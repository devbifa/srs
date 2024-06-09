<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Batch extends MY_Controller
{



	public function __construct()

	{

		parent::__construct();
	}

	function update_status()
	{
		$id = $_POST['id_batch'];
		$student = $_POST['student'];
		$status = $_POST['status'];
		foreach ($student as $k => $v) {
			$dt['updated_at'] = DATE('Y-m-d H:i:s');
			$dt['status'] = $status[$k]['status'];
			$this->mymodel->updateData('student_application_form', $dt, array('id' => $v));
		}
		redirect(base_url() . 'master/batch/student/' . $id);
	}


	public function index()

	{

		$data['page_name'] = "batch";

		$this->template->load('template/template', 'master/batch/all-batch', $data);
	}

	public function create()

	{

		$data['page_name'] = "batch";

		$this->template->load('template/template', 'master/batch/add-batch', $data);
	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules('dt[curriculum]', '<strong>Curriculum</strong>', 'required');
		$this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
		$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
		$this->form_validation->set_rules('dt[description]', '<strong>Open Date</strong>', 'required');
	}



	public function store()

	{

		$this->validate();

		if ($this->form_validation->run() == FALSE) {

			$this->alert->alertdanger(validation_errors());
		} else {

			$dt = $_POST['dt'];



			$dt['created_by'] = $_SESSION['id'];

			$dt['created_at'] = date('Y-m-d H:i:s');

			// $dt['status'] = "ENABLE";

			$str = $this->mymodel->insertData('batch', $dt);

			$last_id = $this->db->insert_id();
			if (!empty($_FILES['file']['name'])) {

				$dir  = "webfile/";

				$config['upload_path']          = $dir;

				$config['allowed_types']        = '*';

				$config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);



				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('file')) {

					$error = $this->upload->display_errors();

					$this->alert->alertdanger($error);
				} else {

					$file = $this->upload->data();

					$data = array(

						'id' => '',

						'name' => $file['file_name'],

						'mime' => $file['file_type'],

						'dir' => $dir . $file['file_name'],

						'table' => 'batch',

						'table_id' => $last_id,

						'status' => 'ENABLE',

						'created_at' => date('Y-m-d H:i:s')

					);

					$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Send Data');
				}
			} else {

				$data = array(

					'id' => '',

					'name' => '',

					'mime' => '',

					'dir' => '',

					'table' => 'batch',

					'table_id' => $last_id,

					'status' => 'ENABLE',

					'created_at' => date('Y-m-d H:i:s')

				);



				$str = $this->mymodel->insertData('file', $data);

				$this->alert->alertsuccess('Success Send Data');
			}
		}
	}

	public function student($id)
	{
		$data['page_name'] = "batch";
		$this->template->load('template/template', 'master/batch/student', $data);
	}

	public function json()

	{

		$status = $_GET['status'];

		if ($status == '') {

			$status = 'ENABLE';
		}

		header('Content-Type: application/json');

		$this->datatables->select('a.id,COUNT(c.id) as number_of_student, b.name as curriculum,a.code,a.batch,a.description,a.status');

		$this->datatables->where('c.student_status', 'APPROVE');

		$this->datatables->where('a.status', $status);

		$this->datatables->from('batch a');

		$this->datatables->join('curriculum b', 'a.curriculum = b.code', 'LEFT');

		$this->datatables->join('student_application_form c', 'a.id = c.batch', 'LEFT');

		$this->db->group_by('a.id');

		if ($status == "ENABLE") {

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			', 'id');
		} else {

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');
		}

		echo $this->datatables->generate();
	}

	public function edit($id)

	{

		$data['batch'] = $this->mymodel->selectDataone('batch', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'batch'));
		$data['page_name'] = "batch";

		$this->template->load('template/template', 'master/batch/edit-batch', $data);
	}

	public function preview($id)

	{

		$data['batch'] = $this->mymodel->selectDataone('batch', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'batch'));
		$data['page_name'] = "batch";

		$this->template->load('template/template', 'master/batch/preview-batch', $data);
	}





	public function update()

	{

		$this->validate();





		if ($this->form_validation->run() == FALSE) {

			$this->alert->alertdanger(validation_errors());
		} else {

			$id = $this->input->post('id', TRUE);

			if (!empty($_FILES['file']['name'])) {

				$dir  = "webfile/";

				$config['upload_path']          = $dir;

				$config['allowed_types']        = '*';

				$config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('file')) {

					$error = $this->upload->display_errors();

					$this->alert->alertdanger($error);
				} else {

					$file = $this->upload->data();

					$data = array(

						'name' => $file['file_name'],

						'mime' => $file['file_type'],

						// 'size'=> $file['file_size'],

						'dir' => $dir . $file['file_name'],

						'table' => 'batch',

						'table_id' => $id,

						'updated_at' => date('Y-m-d H:i:s')

					);

					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'batch'));

					@unlink($file['dir']);

					if ($file == "") {

						$this->mymodel->insertData('file', $data);
					} else {

						$this->mymodel->updateData('file', $data, array('id' => $file['id']));
					}





					$dt = $_POST['dt'];



					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str =  $this->mymodel->updateData('batch', $dt, array('id' => $id));

					return $str;
				}
			} else {

				$dt = $_POST['dt'];



				$dt['updated_at'] = date("Y-m-d H:i:s");

				$str = $this->mymodel->updateData('batch', $dt, array('id' => $id));

				return $str;
			}
		}
	}



	public function delete($id)

	{

		$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'batch'));

		@unlink($file['dir']);

		$this->mymodel->deleteData('file',  array('table_id' => $id, 'table' => 'batch'));



		$str = $this->mymodel->deleteData('batch',  array('id' => $id));
		redirect(base_url() . 'master/batch');
	}



	public function status($id, $status)

	{

		$this->mymodel->updateData('batch', array('status' => $status), array('id' => $id));


		redirect('master/Batch');
	}
}