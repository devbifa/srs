

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Exam extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/rindam/all-student_application_form',$data);

		}

		public function create()

		{

			$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/rindam/add-student_application_form',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[registration_date]', '<strong>Registration Date</strong>', 'required');
$this->form_validation->set_rules('dt[application_number]', '<strong>Application Number</strong>', 'required');
$this->form_validation->set_rules('dt[full_name]', '<strong>Full Name</strong>', 'required');
$this->form_validation->set_rules('dt[place_of_birth]', '<strong>Place Of Birth</strong>', 'required');
$this->form_validation->set_rules('dt[gender]', '<strong>Gender</strong>', 'required');
$this->form_validation->set_rules('dt[identity_card_no]', '<strong>Identity Card No</strong>', 'required');
$this->form_validation->set_rules('dt[date_of_birth]', '<strong>Date Of Birth</strong>', 'required');
$this->form_validation->set_rules('dt[weight]', '<strong>Weight</strong>', 'required');
$this->form_validation->set_rules('dt[height]', '<strong>Height</strong>', 'required');
$this->form_validation->set_rules('dt[address]', '<strong>Address</strong>', 'required');
$this->form_validation->set_rules('dt[city]', '<strong>City</strong>', 'required');
$this->form_validation->set_rules('dt[zip_code]', '<strong>Zip Code</strong>', 'required');
$this->form_validation->set_rules('dt[domicile_address]', '<strong>Domicile Address</strong>', 'required');
$this->form_validation->set_rules('dt[domicile_city]', '<strong>Domicile City</strong>', 'required');
$this->form_validation->set_rules('dt[domicile_zip]', '<strong>Domicile Zip</strong>', 'required');
$this->form_validation->set_rules('dt[home_telephone_number]', '<strong>Home Telephone Number</strong>', 'required');
$this->form_validation->set_rules('dt[mobile_phone_number]', '<strong>Mobile Phone Number</strong>', 'required');
$this->form_validation->set_rules('dt[marital_status]', '<strong>Marital Status</strong>', 'required');
$this->form_validation->set_rules('dt[email]', '<strong>Email</strong>', 'required');
$this->form_validation->set_rules('dt[religion]', '<strong>Religion</strong>', 'required');
$this->form_validation->set_rules('dt[nationality]', '<strong>Nationality</strong>', 'required');
$this->form_validation->set_rules('dt[t_shirt_size]', '<strong>T-Shirt Size</strong>', 'required');
$this->form_validation->set_rules('dt[shoes_size]', '<strong>Shoes Size</strong>', 'required');
$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
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

				$str = $this->mymodel->insertData('student_application_form', $dt);

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

					   				'table'=> 'student_application_form',

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

				   				'table'=> 'student_application_form',

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

	        $this->datatables->select('id, CONCAT("CPL, PPL") as course_require, student_application_form.*');

			// $this->datatables->where('status',$status);
			
			$this->datatables->where("student_status != 'APPROVE'");
			
			$this->datatables->where("full_name != ''");

	        $this->datatables->from('student_application_form');

	        if($status=="ENABLE"){

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			', 'id');



	    	}else{

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');



	    	}

	        echo $this->datatables->generate();

		}

		public function edit($id)

		{

			$data['student_application_form'] = $this->mymodel->selectDataone('student_application_form',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/student_application_form/edit-student_application_form',$data);

		}
		
		public function preview($id)

		{

			$data['student_application_form'] = $this->mymodel->selectDataone('student_application_form',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/rindam/preview-student_application_form',$data);

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

					   				'table'=> 'student_application_form',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('student_application_form', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('student_application_form', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'student_application_form'));



				$str = $this->mymodel->deleteData('student_application_form',  array('id'=>$id));
				return $str;
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('student_application_form',array('rindam_status'=>$status),array('id'=>$id));


			redirect('master/rindam');

		}





	}

?>