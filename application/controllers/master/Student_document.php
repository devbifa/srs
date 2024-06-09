<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Student_document extends MY_Controller
{



	public function __construct()

	{

		parent::__construct();
	}

	function filter()
	{
		$_SESSION['batch'] = $_POST['batch'];
		$_SESSION['status'] = $_POST['status'];
		redirect(base_url() . 'master/student_document');
	}

	public function index()

	{

		$data['page_name'] = "student_document";

		$this->template->load('template/template', 'master/student_document/all-student_document', $data);
	}

	public function create($id)

	{


		$data['page_name'] = "student_document";
		$data['student_document'] = $this->mymodel->selectDataone('user', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'student_document'));
		$data['page_name'] = "student_document";

		$this->template->load('template/template', 'master/student_document/add-student_document', $data);
	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		// $this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
		$this->form_validation->set_rules('dt[full_name]', '<strong>Student Name</strong>', 'required');
		// $this->form_validation->set_rules('dt[nick_name]', '<strong>Nick Name</strong>', 'required');
		// $this->form_validation->set_rules('dt[id_number]', '<strong>Id Number</strong>', 'required');
		// $this->form_validation->set_rules('dt[spl_number]', '<strong>Spl Number</strong>', 'required');
		// $this->form_validation->set_rules('dt[ppl_number]', '<strong>Ppl Number</strong>', 'required');
		// $this->form_validation->set_rules('dt[cpl_number]', '<strong>Cpl Number</strong>', 'required');
		// $this->form_validation->set_rules('dt[medex_valid_date]', '<strong>Medex Valid Date</strong>', 'required');
		// $this->form_validation->set_rules('dt[curriculum]', '<strong>Curriculum</strong>', 'required');
		// $this->form_validation->set_rules('dt[last_input_date]', '<strong>Last Input Date</strong>', 'required');
	}





	public function json()

	{

		$status = $_SESSION['status'];
		$batch = $_SESSION['batch'];

		if ($batch) {
			$this->datatables->where("a.batch = '$batch'");
		}

		if ($status) {
			$this->datatables->where("a.status = '$status'");
		}

		header('Content-Type: application/json');



		$this->datatables->select('a.id, a.email, DATE_FORMAT(a.registration_date,"%d %b %Y") as registration_date,DATE_FORMAT(a.date_of_birth,"%d %b %Y") as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,a.batch,a.status, c.name as curriculum,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date');


		$this->datatables->where("a.visibility = '1'");

		$this->datatables->where("a.instructor_status != '1'");

		// $this->datatables->where("student_status = 'APPROVE'");

		$this->db->where("(a.status NOT IN ('WAITING CONTRACT','WAITING FINANCE','PENDING','REJECT','') )");

		$this->datatables->where("a.full_name != ''");
		$this->datatables->where("a.status != ''");

		$this->datatables->from('user a');

		$this->datatables->join('batch b', 'a.batch = b.batch', 'LEFT');

		$this->datatables->join('syllabus_curriculum c', 'b.curriculum = c.code', 'LEFT');

		if ($status == "ENABLE") {

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			', 'id');
		} else {

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');
		}

		echo $this->datatables->generate();
	}



	public function print()

	{

		$status = $_SESSION['status'];
		$batch = $_SESSION['batch'];

		if ($batch) {
			$this->datatables->where("a.batch = '$batch'");
		}

		if ($status) {
			$this->db->where("a.status = '$status'");
		}

		// header('Content-Type: application/json');



		$this->db->select('a.id, a.email, DATE_FORMAT(a.registration_date,"%d %b %Y") as registration_date,DATE_FORMAT(a.date_of_birth,"%d %b %Y") as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,a.batch,a.status, c.name as curriculum,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date');


		$this->db->where("a.visibility = '1'");

		$this->db->where("a.instructor_status != '1'");

		$this->db->where("student_status = 'APPROVE'");

		$this->db->where("a.full_name != ''");

		$this->db->from('user a');

		$this->db->join('batch b', 'a.batch = b.batch', 'LEFT');

		$this->db->join('syllabus_curriculum c', 'b.curriculum = c.code', 'LEFT');



		$data['data'] = $this->db->get()->result_array();
		$this->load->view('master/student_document/print', $data);
	}

	public function edit($id)

	{

		$data['student_document'] = $this->mymodel->selectDataone('user', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'student_document'));
		$data['page_name'] = "student_document";

		$this->template->load('template/template', 'master/student_document/edit-student_document', $data);
	}

	public function preview($id)

	{

		$data['student_document'] = $this->mymodel->selectDataone('user', array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'student_document'));
		$data['page_name'] = "student_document";

		$this->template->load('template/template', 'master/student_document/preview-student_document', $data);
	}





	public function update()

	{

		$this->validate();





		$dt = $_POST['dt'];

		$dt['type_of_training'] = json_encode($_POST['type_of_training'], true);
		$dt['course'] = json_encode($_POST['course'], true);

		$id = $_POST['id'];
		$nick_name =  $dt['nick_name'];
		$batch =  $dt['batch'];
		$id_number =  $dt['id_number'];
		//    $user = $this->mymodel->selectDataOne('user',"nick_name = '$nick_name' AND id != '$id' AND batch = '$batch'");

		$user2 = $this->mymodel->selectDataOne('user', "id_number = '$id_number' AND id != '$id' AND batch = '$batch'");

		//    if($user){
		// 	   $this->alert->alertdanger('nick name already used in this batch. please use another nickname!');     
		// 	   die;
		//    }else 
		if ($user2) {
			$this->alert->alertdanger('id number already used in this batch. please use another id number!');
			die;
		} else if ($this->form_validation->run() == FALSE) {

			$this->alert->alertdanger(validation_errors());
		} else {

			$id = $this->input->post('id', TRUE);

			if (!empty($_FILES['file']['name'])) {

				$dir  = "webfile/";

				$config['upload_path']          = $dir;

				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;

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

						'table' => 'student_document',

						'table_id' => $id,

						'updated_at' => date('Y-m-d H:i:s')

					);

					$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'student_document'));

					@unlink($file['dir']);

					if ($file == "") {

						$this->mymodel->insertData('file', $data);
					} else {

						$this->mymodel->updateData('file', $data, array('id' => $file['id']));
					}





					$dt = $_POST['dt'];

					$dt['type_of_training'] = json_encode($_POST['type_of_training'], true);
					$dt['course'] = json_encode($_POST['course'], true);

					$dtt = $_POST['dtt'];

					if ($_POST['password']) {
						$dt['password'] = md5($_POST['password']);
					}


					$dt['training_requirement'] = json_encode($_POST['dtt']);
					$dt['family'] = json_encode($_POST['family']);
					$dt['list_family'] = json_encode($_POST['list_family']);
					$dt['qualification'] = json_encode($_POST['qualification']);
					$dt['others'] = json_encode($_POST['others']);

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str =  $this->mymodel->updateDAta('user', $dt, array('id' => $id));

					return $str;
				}
			} else {

				$dt = $_POST['dt'];

				$dt['type_of_training'] = json_encode($_POST['type_of_training'], true);
				$dt['course'] = json_encode($_POST['course'], true);

				if ($_POST['password']) {
					$dt['password'] = md5($_POST['password']);
				}

				$dtt = $_POST['dtt'];

				$dt['training_requirement'] = json_encode($_POST['dtt']);
				$dt['family'] = json_encode($_POST['family']);
				$dt['list_family'] = json_encode($_POST['list_family']);
				$dt['qualification'] = json_encode($_POST['qualification']);
				$dt['others'] = json_encode($_POST['others']);


				$dt['updated_at'] = date("Y-m-d H:i:s");

				$str = $this->mymodel->updateDAta('user', $dt, array('id' => $id));

				return $str;
			}
		}
	}

	function create_marketing()
	{

		$dt['created_by'] = $_SESSION['id'];

		$dt['created_at'] = date('Y-m-d H:i:s');

		$dt['updated_at'] = date('Y-m-d H:i:s');

		$dt['status'] = "ENABLE";

		$str = $this->mymodel->insertData('student_document', $dt);

		$last_id = $this->db->insert_id();
		// die;		
		redirect(base_url() . 'master/student_document/create/' . $last_id);
	}

	public function delete()

	{

		$id = $this->input->post('id', TRUE);
		$file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'student_document'));

		@unlink($file['dir']);

		$this->mymodel->deleteData('file',  array('table_id' => $id, 'table' => 'student_document'));



		$str = $this->mymodel->deleteData('student_document',  array('id' => $id));
		return $str;
	}



	public function status($id, $status)

	{


		$user = $this->mymodel->selectDataOne('user', array('id' => $id));
		$log = json_decode($user['log_perubahan_status'], true);
		if ($log) {
			$count = count($log);
			$log[$count]['status'] = $status;
			$log[$count]['created_by'] = $_SESSION['id'];
			$log[$count]['created_at'] = DATE('Y-m-d H:i:s');
		} else {
			$log[0]['status'] = $status;
			$log[0]['created_by'] = $_SESSION['id'];
			$log[0]['created_at'] = DATE('Y-m-d H:i:s');
		}

		$data['log_perubahan_status'] = json_encode($log, true);
		$data['status'] = $status;

		$this->mymodel->updateDAta('user', $data, array('id' => $id));


		// die;
		redirect(base_url() . 'master/student_document/preview/' . $id);
	}



	function upload_file($id)
	{
		header('Content-Type: application/json');

		$data = $this->mymodel->selectDataone('user', array('id' => $id));

		$data = json_decode($data['log_status'], true);

		$id_now = (end(array_keys($data)) + 1);

		$dt = $_POST['dttt'];


		if (!empty($_FILES['file']['name'])) {
			// echo 123;

			$dir  = "webfile/student_status/";

			$config['upload_path']          = $dir;

			$config['allowed_types']        = '*';
			$config['overwrite'] 			= TRUE;

			$config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);



			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {

				$error = $this->upload->display_errors();

				$this->alert->alertdanger($error);
			} else {

				$file = $this->upload->data();

				$dt['file'] = $file['file_name'];
			}
		}

		$dt['id'] = $id_now;
		$dt['created_at'] = DATE('Y-m-d H:i:s');

		$dt['updated_at'] = DATE('Y-m-d H:i:s');
		if ($data) {
			// array_push($data,$dt);
			$data[$id_now] = $dt;
		} else {
			$data = array();
			$data[$id_now] = $dt;
			// array_push($data,$dt);
		}

		$dt_input['log_status'] = json_encode($data);
		$this->mymodel->updateData('user', $dt_input, array('id' => $id));

		redirect(base_url() . 'master/student_document/edit/' . $id);
	}


	function update_file($id, $index)
	{
		header('Content-Type: application/json');

		$data = $this->mymodel->selectDataone('user', array('id' => $id));

		$data = json_decode($data['attachment'], true);

		$data_index = $data[$index];

		$data_edit = $_POST['dttt'];
		$data_edit['updated_at'] = DATE('Y-m-d H:i:s');

		$dt = $data_edit;

		if (!empty($_FILES['file']['name'])) {

			$dir  = "webfile/attachment/";

			$config['upload_path']          = $dir;

			$config['allowed_types']        = '*';
			$config['overwrite'] 			= TRUE;

			$type =  preg_replace('/[^A-Za-z0-9\-]/', '-', $data_edit['type']);
			$type = str_replace('--', '-', $type);
			$type = str_replace('--', '-', $type);
			$type = str_replace('--', '-', $type);
			$type = strtolower($type);

			$config['file_name']           = 'user-' . $id . '-' . $type;


			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {

				$error = $this->upload->display_errors();

				$this->alert->alertdanger($error);
			} else {

				$file = $this->upload->data();

				$dt['file'] = $file['file_name'];
			}
		} else {
			$dt['file'] = $data_index['file'];
		}




		if ($data) {
			$data[$index] = $dt;
		} else {
			$data[$index] = $dt;
		}



		$dt_input['attachment'] = json_encode($data);
		$this->mymodel->updateData('user', $dt_input, array('id' => $id));

		redirect(base_url() . 'master/student_document/edit/' . $id);
	}


	function update_checklist($id, $index)
	{
		header('Content-Type: application/json');

		$data = $this->mymodel->selectDataone('user', array('id' => $id));

		$data = json_decode($data['checklist'], true);

		$data_index = $data[$index];

		$data_edit = $_POST['dttt'];
		$data_edit['updated_at'] = DATE('Y-m-d H:i:s');

		$dt = $data_edit;

		if (!empty($_FILES['file']['name'])) {

			$dir  = "webfile/checklist/";

			$config['upload_path']          = $dir;

			$config['allowed_types']        = '*';
			$config['overwrite'] 			= TRUE;

			$type =  preg_replace('/[^A-Za-z0-9\-]/', '-', $data_edit['type']);
			$type = str_replace('--', '-', $type);
			$type = str_replace('--', '-', $type);
			$type = str_replace('--', '-', $type);
			$type = strtolower($type);

			$config['file_name']           = 'user-' . $id . '-' . $type;


			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {

				$error = $this->upload->display_errors();

				$this->alert->alertdanger($error);
			} else {

				$file = $this->upload->data();

				$dt['file'] = $file['file_name'];
			}
		} else {
			$dt['file'] = $data_index['file'];
		}




		if ($data) {
			$data[$index] = $dt;
		} else {
			$data[$index] = $dt;
		}



		$dt_input['checklist'] = json_encode($data);
		$this->mymodel->updateData('user', $dt_input, array('id' => $id));

		redirect(base_url() . 'master/student_document/edit/' . $id);
	}

	function update_result_test($id, $index)
	{
		header('Content-Type: application/json');

		$data = $this->mymodel->selectDataone('user', array('id' => $id));

		$data = json_decode($data['result_test'], true);

		$data_index = $data[$index];

		$data_edit = $_POST['dttt'];
		$data_edit['updated_at'] = DATE('Y-m-d H:i:s');

		$dt = $data_edit;

		if (!empty($_FILES['file']['name'])) {

			$dir  = "webfile/result_test/";

			$config['upload_path']          = $dir;

			$config['allowed_types']        = '*';
			$config['overwrite'] 			= TRUE;

			$type =  preg_replace('/[^A-Za-z0-9\-]/', '-', $data_edit['type']);
			$type = str_replace('--', '-', $type);
			$type = str_replace('--', '-', $type);
			$type = str_replace('--', '-', $type);
			$type = strtolower($type);

			$config['file_name']           = 'user-' . $id . '-' . $type;


			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('file')) {

				$error = $this->upload->display_errors();

				$this->alert->alertdanger($error);
			} else {

				$file = $this->upload->data();

				$dt['file'] = $file['file_name'];
			}
		} else {
			$dt['file'] = $data_index['file'];
		}




		if ($data) {
			$data[$index] = $dt;
		} else {
			$data[$index] = $dt;
		}



		$dt_input['result_test'] = json_encode($data);
		$this->mymodel->updateData('user', $dt_input, array('id' => $id));

		redirect(base_url() . 'master/student_document/edit/' . $id);
	}


	function store_payment()
	{


		$id_user = $_POST['id_user'];
		$dttt = $_POST['dttt'];
		$dttt['id_user'] = $id_user;
		$dttt['created_at'] = date("Y-m-d H:i:s");
		$dttt['created_by'] = $_SESSION['id'];
		$dttt['status'] = 'ENABLE';
		$str =  $this->mymodel->insertData('log_payment', $dttt);
		$id = $this->db->insert_id();


		if (!empty($_FILES['file']['name'])) {

			$dir  = "webfile/payment/";
			$config['upload_path']          = $dir;
			$config['allowed_types']        = '*';
			$config['overwrite'] 			= TRUE;
			$config['file_name']           	= 'payment-' . $id_user . '-' . $id;
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

					'table' => 'student_document',

					'table_id' => $id,

					'updated_at' => date('Y-m-d H:i:s')

				);


				$dttt['file'] = $file['file_name'];
			}
		}




		$dttt['updated_at'] = date("Y-m-d H:i:s");
		$str =  $this->mymodel->updateData('log_payment', $dttt, array('id' => $id));


		redirect(base_url() . 'master/student_document/edit/' . $id_user);
	}


	function update_payment()
	{

		$id = $this->input->post('id', TRUE);

		$id = $_POST['id'];
		$id_user = $_POST['id_user'];
		$dttt = $_POST['dttt'];


		if (!empty($_FILES['file']['name'])) {

			$dir  = "webfile/payment/";
			$config['upload_path']          = $dir;
			$config['allowed_types']        = '*';
			$config['overwrite'] 			= TRUE;
			$config['file_name']           	= 'payment-' . $id_user . '-' . $id;
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

					'table' => 'student_document',

					'table_id' => $id,

					'updated_at' => date('Y-m-d H:i:s')

				);


				$dttt['file'] = $file['file_name'];
			}
		}




		$dttt['updated_at'] = date("Y-m-d H:i:s");
		$str =  $this->mymodel->updateData('log_payment', $dttt, array('id' => $id));


		redirect(base_url() . 'master/student_document/edit/' . $id_user);
	}

	function delete_payment($id, $index)
	{

		$this->mymodel->deleteData('log_payment', array('id' => $index));
		redirect(base_url() . 'master/student_document/edit/' . $id);
	}



	function delete_file($id, $index)
	{
		// header('Content-Type: application/json');

		$data = $this->mymodel->selectDataone('user', array('id' => $id));
		$data = json_decode($data['log_status'], true);
		unset($data[$index]);
		$dt_input['log_status'] = json_encode($data);
		$this->mymodel->updateData('user', $dt_input, array('id' => $id));
		// print_r($data);
		redirect(base_url() . 'master/student_document/edit/' . $id);
	}

	function delete_checklist($id, $index)
	{
		// header('Content-Type: application/json');

		$data = $this->mymodel->selectDataone('user', array('id' => $id));
		$data = json_decode($data['checklist'], true);
		unset($data[$index]);
		$dt_input['checklist'] = json_encode($data);
		$this->mymodel->updateData('user', $dt_input, array('id' => $id));
		// print_r($data);
		redirect(base_url() . 'master/student_document/edit/' . $id);
	}

	function delete_result_test($id, $index)
	{
		// header('Content-Type: application/json');

		$data = $this->mymodel->selectDataone('user', array('id' => $id));
		$data = json_decode($data['result_test'], true);
		unset($data[$index]);
		$dt_input['result_test'] = json_encode($data);
		$this->mymodel->updateData('user', $dt_input, array('id' => $id));
		// print_r($data);
		redirect(base_url() . 'master/student_document/edit/' . $id);
	}
}