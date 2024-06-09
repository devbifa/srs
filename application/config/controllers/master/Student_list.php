

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Student_list extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}

		function filter(){
			$_SESSION['batch'] = $_POST['batch'];
			redirect(base_url().'master/student_list');
		}


		public function index()

		{

			$data['page_name'] = "student_list";

			$this->template->load('template/template','master/student_list/all-student_application_form',$data);

		}

		public function create()

		{

			$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/student_list/add-student_application_form',$data);

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

				$str = $this->mymodel->insertData('user', $dt);

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

					   				'table'=> 'user',

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

				   				'table'=> 'user',

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
			$batch = $_SESSION['batch'];
			if($status==''){

				$status = 'ENABLE';

			}


			if($batch){
				$this->datatables->where("a.batch = '$batch'");
			}
			
			header('Content-Type: application/json');

		 
			
	        $this->datatables->select('a.id, DATE_FORMAT(a.registration_date,"%d %b %Y") as registration_date,DATE_FORMAT(a.date_of_birth,"%d %b %Y") as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,a.batch,a.student_status, a.remark');

			$this->datatables->where("a.visibility = '1'");

			$this->datatables->where("a.instructor_status != '1'");

			$this->datatables->where("a.student_status != 'APPROVE'");
			
			$this->datatables->where("a.full_name != ''");

			$this->datatables->from('user a');
			
	        // $this->datatables->join('batch b','a.batch = b.id','LEFT');


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

			$data['student_application_form'] = $this->mymodel->selectDataone('user',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/student_list/edit-student_application_form',$data);

		}
		
		public function approve($id){
			$data = array(
				'student_status' => 'APPROVE',
				'status' => 'PROPOSE TO ACTIVE',
				'updated_at' => DATE('Y-m-d H:i:s')
			);
			$this->mymodel->updateData('user', $data , array('id'=>$id));

			redirect(base_url().'master/student_list');
		}
		
		public function reject($id){
			$data = array(
				'student_status' => 'REJECT',
				'updated_at' => DATE('Y-m-d H:i:s')
			);
			$this->mymodel->updateData('user', $data , array('id'=>$id));

			redirect(base_url().'master/student_list');
		}
		
		public function preview($id)

		{

			$data['student_application_form'] = $this->mymodel->selectDataone('user',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));
			$data['page_name'] = "STUDENT LIST";

			$this->template->load('template/template','master/student_list/preview-student_application_form',$data);

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

					   				'table'=> 'user',

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

						$str =  $this->mymodel->updateData('user', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('user', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'student_application_form'));



				$str = $this->mymodel->deleteData('user',  array('id'=>$id));
				return $str;
				


		}

		



		public function status($id,$status)

		{

			$this->mymodel->updateData('user',array('status'=>$status),array('id'=>$id));


			redirect('master/Student_application_form');

		}





	}

?>