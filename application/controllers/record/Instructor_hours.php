

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Instructor_hours extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}


		public function index()

		{

			$data['page_name'] = "Instructor_hours";

			$this->template->load('template/template','record/instructor_hours/all',$data);

		}

		function instructor($id){
			$data['page_name'] = "Instructor_hours";

			$this->template->load('template/template','record/instructor_hours/instructor',$data);

		}

		function filter(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
			$_SESSION['type'] = $_POST['type'];
			redirect(base_url().'record/instructor_hours');
		}


		
		function filter_detail($id){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
			$_SESSION['type'] = $_POST['type'];
			redirect(base_url().'record/instructor_hours/instructor/'.$id);
		}


		public function create()

		{

			$data['page_name'] = "daily_ftd_schedule";

			$this->template->load('template/template','master/daily_ftd_schedule/add-daily_ftd_schedule',$data);

		}
		

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[date]', '<strong>Date</strong>', 'required');
// $this->form_validation->set_rules('dt[manufacture]', '<strong>Manufacture</strong>', 'required');
$this->form_validation->set_rules('dt[ftd_model]', '<strong>Ftd Model</strong>', 'required');
$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
$this->form_validation->set_rules('dt[pic]', '<strong>Pic</strong>', 'required');
$this->form_validation->set_rules('dt[2nd]', '<strong>2nd</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
$this->form_validation->set_rules('dt[mission]', '<strong>Mission</strong>', 'required');
$this->form_validation->set_rules('dt[eet_utc]', '<strong>Eet Utc</strong>', 'required');
$this->form_validation->set_rules('dt[etd_utc]', '<strong>Etd Utc</strong>', 'required');
$this->form_validation->set_rules('dt[eta]', '<strong>Eta</strong>', 'required');
$this->form_validation->set_rules('dt[remark]', '<strong>Remark</strong>', 'required');
	}



		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
				

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('daily_ftd_schedule', $dt);

				$last_id = $this->db->insert_id();	    if (!empty($_FILES['file']['name'])){

		        	$dir  = "webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('file')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

					   	$file = $this->upload->data();

						$data = array(

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'daily_ftd_schedule',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Send Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'daily_ftd_schedule',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Send Data');



					}

					    

					

			}

		}



		public function json()

		{

			$status = $_GET['status'];

			if($status==''){

				$status = 'ENABLE';

			}

			header('Content-Type: application/json');

	        $this->datatables->select('a.id,a.date,a.ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name,');

	        $this->datatables->where('a.status',$status);

			$this->datatables->from('daily_ftd_schedule a');
			
			// $this->datatables->join('aircraft_document b','a.aircraft_reg = b.id');
			
	        $this->datatables->join('batch c','a.batch = c.id');
			
	        $this->datatables->join('course d','a.course = d.id');
			
	        $this->datatables->join('tpm_syllabus_all_course e','a.mission = e.id');
			
			$this->datatables->join('instructor f','a.pic = f.id');
			
			$this->datatables->join('student_application_form g','a.2nd = g.id');

	        if($status=="ENABLE"){

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			', 'id');



	    	}else{

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');



	    	}

	        echo $this->datatables->generate();

		}

		public function edit($id)

		{

			$data['daily_ftd_schedule'] = $this->mymodel->selectDataone('daily_ftd_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));$data['page_name'] = "daily_ftd_schedule";

			$this->template->load('template/template','master/daily_ftd_schedule/edit-daily_ftd_schedule',$data);

		}
		
		public function preview($id)

		{

			$data['daily_ftd_schedule'] = $this->mymodel->selectDataone('daily_ftd_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));$data['page_name'] = "daily_ftd_schedule";

			$this->template->load('template/template','master/daily_ftd_schedule/preview-daily_ftd_schedule',$data);

		}





		public function update()

		{	

			$this->validate();

			



	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$id = $this->input->post('id', TRUE);

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

	        		$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

						$file = $this->upload->data();

						$data = array(

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				// 'size'=> $file['file_size'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'daily_ftd_schedule',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('daily_ftd_schedule', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('daily_ftd_schedule', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_ftd_schedule'));



				$str = $this->mymodel->deleteData('daily_ftd_schedule',  array('id'=>$id));
				return $str;
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_ftd_schedule',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_ftd_schedule');

		}





	}

?>