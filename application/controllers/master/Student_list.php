

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Student_list extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}

		function filter(){
			$_SESSION['batch'] = $_POST['batch'];
			$_SESSION['status'] = $_POST['status'];
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



		



		public function json()

		{

			$status = $_SESSION['status'];
			$batch = $_SESSION['batch'];

			


			if($batch){
				$this->datatables->where("a.batch = '$batch'");
			}

			if($status){
				$this->datatables->where("a.status = '$status'");
			}
			
			header('Content-Type: application/json');

		 
			
	        $this->datatables->select('a.id, a.id_number,DATE_FORMAT(a.registration_date,"%d %b %Y") as registration_date,a.email,DATE_FORMAT(a.date_of_birth,"%d %b %Y") as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,a.batch,a.status as student_status, a.remark');

			$this->datatables->where("a.visibility = '1'");

			$this->datatables->where("a.instructor_status != '1'");

			// $this->datatables->where("a.student_status != 'APPROVE'");

			$this->datatables->where("(a.status IN ('WAITING CONTRACT','WAITING FINANCE','PENDING','REJECT','') )");
			
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
				// 'status' => 'WAITING ACTIVE',
				'status' => 'WAITING FINANCE',
				'updated_at' => DATE('Y-m-d H:i:s')
			);

			$user = $this->mymodel->selectDataOne('user',array('id'=>$id));
			$log = json_decode($user['log_perubahan_status'],true);
			if($log){
				$count = count($log);
				$log[$count]['status'] = 'WAITING FINANCE';
				$log[$count]['created_by'] = $_SESSION['id'];
				$log[$count]['created_at'] = DATE('Y-m-d H:i:s');
			}else{
				$log[0]['status'] = 'WAITING FINANCE';
				$log[0]['created_by'] = $_SESSION['id'];
				$log[0]['created_at'] = DATE('Y-m-d H:i:s');
			}

			$data['log_perubahan_status'] = json_encode($log,true);
			
			$this->mymodel->updateData('user', $data , array('id'=>$id));

			redirect(base_url().'master/student_list/preview/'.$id);
		}

		
	public function propose_to_contract($id){
		$data = array(
			'student_status' => 'APPROVE',
			// 'status' => 'WAITING ACTIVE',
			'status' => 'WAITING CONTRACT',
			'updated_at' => DATE('Y-m-d H:i:s')
		);

		$user = $this->mymodel->selectDataOne('user',array('id'=>$id));
			$log = json_decode($user['log_perubahan_status'],true);
			if($log){
				$count = count($log);
				$log[$count]['status'] = 'WAITING CONTRACT';
				$log[$count]['created_by'] = $_SESSION['id'];
				$log[$count]['created_at'] = DATE('Y-m-d H:i:s');
			}else{
				$log[0]['status'] = 'WAITING CONTRACT';
				$log[0]['created_by'] = $_SESSION['id'];
				$log[0]['created_at'] = DATE('Y-m-d H:i:s');
			}

			$data['log_perubahan_status'] = json_encode($log,true);

		$this->mymodel->updateData('user', $data , array('id'=>$id));

		redirect(base_url().'master/student_list/preview/'.$id);
	}
		
		public function reject($id){
		
			$user = $this->mymodel->selectDataOne('user',array('id'=>$id));
			$log = json_decode($user['log_perubahan_status'],true);
			if($log){
				$count = count($log);
				$log[$count]['status'] = 'REJECT';
				$log[$count]['created_by'] = $_SESSION['id'];
				$log[$count]['created_at'] = DATE('Y-m-d H:i:s');
			}else{
				$log[0]['status'] =  'REJECT';
				$log[0]['created_by'] = $_SESSION['id'];
				$log[0]['created_at'] = DATE('Y-m-d H:i:s');
			}

			$data['log_perubahan_status'] = json_encode($log,true);
			$data['status'] = 'REJECT';

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

			



			$dt = $_POST['dt'];
			
			$id = $_POST['id'];
			$nick_name =  $dt['nick_name'];
			$batch =  $dt['batch'];
			$id_number =  $dt['id_number'];
		//    $user = $this->mymodel->selectDataOne('user',"nick_name = '$nick_name' AND id != '$id' AND batch = '$batch'");

		   $user2 = $this->mymodel->selectDataOne('user',"id_number = '$id_number' AND id != '$id' AND batch = '$batch'");

		//    if($user){
		// 	   $this->alert->alertdanger('nick name already used in this batch. please use another nickname!');     
		// 	   die;
		//    }else 
		   
		   if($user2){
				$this->alert->alertdanger('id number already used in this batch. please use another id number!');     
				die;
			}else if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$id = $this->input->post('id', TRUE);

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';
					$config['overwrite'] 			= TRUE;

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

					   				'table'=> 'student_document',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_document'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						$dtt = $_POST['dtt'];

						if($_POST['password']){
							$dt['password'] = md5($_POST['password']);
						}


						$dt['training_requirement'] = json_encode($_POST['dtt']);
						$dt['type_of_training'] = json_encode($_POST['type_of_training'],true);
						$dt['course'] = json_encode($_POST['course'],true);
						$dt['family'] = json_encode($_POST['family']);
						$dt['list_family'] = json_encode($_POST['list_family']);
						$dt['qualification'] = json_encode($_POST['qualification']);
						$dt['others'] = json_encode($_POST['others']);

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('user', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					if($_POST['password']){
						$dt['password'] = md5($_POST['password']);
					}

					$dtt = $_POST['dtt'];

					$dt['training_requirement'] = json_encode($_POST['dtt']);
					$dt['type_of_training'] = json_encode($_POST['type_of_training'],true);
					$dt['course'] = json_encode($_POST['course'],true);
					$dt['family'] = json_encode($_POST['family']);
					$dt['list_family'] = json_encode($_POST['list_family']);
					$dt['qualification'] = json_encode($_POST['qualification']);
					$dt['others'] = json_encode($_POST['others']);

					// $this->db->order_by('number','ASC');
					// $dat = $this->mymodel->selectWhere('payment_status',null);
					
					// foreach($dat as $k=>$v){
					// 	$logs[$v['id']]['date'] = DATE('Y-m-d');
					// 	$logs[$v['id']]['due_date'] = $v['due_date'];
					// 	$logs[$v['id']]['nominal_inv'] = $v['nominal'];
					// 	$logs[$v['id']]['description'] = '-';
					// 	$logs[$v['id']]['updated_at'] = DATE('Y-m-d H:i:s');
					// }
					// $dt['log_status'] = json_encode($logs,true);


					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('user', $dt , array('id'=>$id));

					return $str;  

				}}

		}

		function create_marketing(){

			$dt['created_by'] = $_SESSION['id'];

			$dt['created_at'] = date('Y-m-d H:i:s');

			$dt['updated_at'] = date('Y-m-d H:i:s');

			$dt['status'] = "ENABLE";

			$str = $this->mymodel->insertData('student_document', $dt);
			
			$last_id = $this->db->insert_id();
	// die;		
			redirect(base_url().'master/student_list/create/'.$last_id);
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


			$user = $this->mymodel->selectDataOne('user',array('id'=>$id));
			$log = json_decode($user['log_perubahan_status'],true);
			if($log){
				$count = count($log);
				$log[$count]['status'] = $status;
				$log[$count]['created_by'] = $_SESSION['id'];
				$log[$count]['created_at'] = DATE('Y-m-d H:i:s');
			}else{
				$log[0]['status'] = $status;
				$log[0]['created_by'] = $_SESSION['id'];
				$log[0]['created_at'] = DATE('Y-m-d H:i:s');
			}

			$data['log_perubahan_status'] = json_encode($log,true);
			$data['status'] = $status;

			$this->mymodel->updateData('user',$data,array('id'=>$id));

			



			redirect(base_url().'master/student_document/preview/'.$id);

		}


		

		function upload_file($id){
			header('Content-Type: application/json');

			$data = $this->mymodel->selectDataone('user',array('id'=>$id));
			
			$data = json_decode($data['log_status'],true);
			
			$id_now = (end(array_keys($data))+1);

			$dt = $_POST['dttt'];

		
			if (!empty($_FILES['file']['name'])){
				// echo 123;

				$dir  = "webfile/attachment/";

				$config['upload_path']          = $dir;

				$config['allowed_types']        = '*';
					$config['overwrite'] 			= TRUE;

				$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

				

				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')){

					$error = $this->upload->display_errors();

					$this->alert->alertdanger($error);		

				}else{

					   $file = $this->upload->data();

					   $dt['file'] = $file['file_name'];

				} 

			}

			
			
			$dt['id'] = $id_now;
			$dt['created_at'] = DATE('Y-m-d H:i:s');

			$dt['updated_at'] = DATE('Y-m-d H:i:s');
if($data){
	// array_push($data,$dt);
	$data[$id_now] = $dt;
}else{
	$data = array();
	$data[$id_now] = $dt;
	// array_push($data,$dt);
}

			$dt_input['log_status'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			 
			redirect(base_url().'master/student_list/edit/'.$id);

		}


		function update_file($id,$index){
			header('Content-Type: application/json');

			$data = $this->mymodel->selectDataone('user',array('id'=>$id));
			
			$data = json_decode($data['attachment'],true);
			
			$data_index = $data[$index];
		
			$data_edit = $_POST['dttt'];
			$data_edit['updated_at'] = DATE('Y-m-d H:i:s');
			
			$dt = $data_edit;

			if (!empty($_FILES['file']['name'])){
			
				$dir  = "webfile/attachment/";

				$config['upload_path']          = $dir;

				$config['allowed_types']        = '*';
					$config['overwrite'] 			= TRUE;

				$type =  preg_replace('/[^A-Za-z0-9\-]/', '-', $data_edit['type']);
				$type = str_replace('--','-',$type);
				$type = str_replace('--','-',$type);
				$type = str_replace('--','-',$type);
				$type = strtolower($type);

				$config['file_name']           = 'user-'.$id.'-'.$type;


				$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')){

					$error = $this->upload->display_errors();

					$this->alert->alertdanger($error);		

				}else{

					   $file = $this->upload->data();

					   $dt['file'] = $file['file_name'];

					  

				} 

			}else{
				$dt['file'] = $data_index['file'];
			}

			
			

if($data){
	$data[$index] = $dt;
}else{
	$data[$index] = $dt;
}



			$dt_input['attachment'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			 
			redirect(base_url().'master/student_list/edit/'.$id);

		}


		function update_checklist($id,$index){
			header('Content-Type: application/json');
		
			$data = $this->mymodel->selectDataone('user',array('id'=>$id));
			
			$data = json_decode($data['checklist'],true);
			
			$data_index = $data[$index];
		
			$data_edit = $_POST['dttt'];
			$data_edit['updated_at'] = DATE('Y-m-d H:i:s');
			
			$dt = $data_edit;
		
			if (!empty($_FILES['file']['name'])){
			
				$dir  = "webfile/checklist/";
		
				$config['upload_path']          = $dir;
		
				$config['allowed_types']        = '*';
					$config['overwrite'] 			= TRUE;
		
				$type =  preg_replace('/[^A-Za-z0-9\-]/', '-', $data_edit['type']);
				$type = str_replace('--','-',$type);
				$type = str_replace('--','-',$type);
				$type = str_replace('--','-',$type);
				$type = strtolower($type);
		
				$config['file_name']           = 'user-'.$id.'-'.$type;
		
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('file')){
		
					$error = $this->upload->display_errors();
		
					$this->alert->alertdanger($error);		
		
				}else{
		
					   $file = $this->upload->data();
		
					   $dt['file'] = $file['file_name'];
		
					  
		
				} 
		
			}else{
				$dt['file'] = $data_index['file'];
			}
		
			
			
		
		if($data){
		$data[$index] = $dt;
		}else{
		$data[$index] = $dt;
		}
		
		
		
			$dt_input['checklist'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			 
			redirect(base_url().'master/student_list/edit/'.$id);
		
		}

		function update_result_test($id,$index){
			header('Content-Type: application/json');
		
			$data = $this->mymodel->selectDataone('user',array('id'=>$id));
			
			$data = json_decode($data['result_test'],true);
			
			$data_index = $data[$index];
		
			$data_edit = $_POST['dttt'];
			$data_edit['updated_at'] = DATE('Y-m-d H:i:s');
			
			$dt = $data_edit;
		
			if (!empty($_FILES['file']['name'])){
			
				$dir  = "webfile/result_test/";
		
				$config['upload_path']          = $dir;
		
				$config['allowed_types']        = '*';
					$config['overwrite'] 			= TRUE;
		
				$type =  preg_replace('/[^A-Za-z0-9\-]/', '-', $data_edit['type']);
				$type = str_replace('--','-',$type);
				$type = str_replace('--','-',$type);
				$type = str_replace('--','-',$type);
				$type = strtolower($type);
		
				$config['file_name']           = 'user-'.$id.'-'.$type;
		
		
				$this->load->library('upload', $config);
		
				if ( ! $this->upload->do_upload('file')){
		
					$error = $this->upload->display_errors();
		
					$this->alert->alertdanger($error);		
		
				}else{
		
					   $file = $this->upload->data();
		
					   $dt['file'] = $file['file_name'];
		
					  
		
				} 
		
			}else{
				$dt['file'] = $data_index['file'];
			}
		
			
			
		
		if($data){
		$data[$index] = $dt;
		}else{
		$data[$index] = $dt;
		}
		
		
		
			$dt_input['result_test'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			 
			redirect(base_url().'master/student_list/edit/'.$id);
		
		}


		function store_payment(){
			

			$id_user = $_POST['id_user'];
			$dttt = $_POST['dttt'];
			$dttt['id_user'] = $id_user;
			$dttt['created_at'] = date("Y-m-d H:i:s");
			$dttt['created_by'] = $_SESSION['id'];
			$dttt['status'] = 'ENABLE';
			$str =  $this->mymodel->insertData('log_payment', $dttt);
			$id = $this->db->insert_id();
			

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "webfile/payment/";
					$config['upload_path']          = $dir;
					$config['allowed_types']        = '*';
					$config['overwrite'] 			= TRUE;
					$config['file_name']           	= 'payment-'.$id_user.'-'.$id;
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

					   				'table'=> 'student_document',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);


					$dttt['file'] = $file['file_name'];

	

					}
				}

					


					$dttt['updated_at'] = date("Y-m-d H:i:s");
					$str =  $this->mymodel->updateData('log_payment', $dttt , array('id'=>$id));
					
			 
			redirect(base_url().'master/student_list/edit/'.$id_user);

		}


		function update_payment(){
			
			$id = $this->input->post('id', TRUE);

			$id = $_POST['id'];
			$id_user = $_POST['id_user'];
			$dttt = $_POST['dttt'];
			

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "webfile/payment/";
					$config['upload_path']          = $dir;
					$config['allowed_types']        = '*';
					$config['overwrite'] 			= TRUE;
					$config['file_name']           	= 'payment-'.$id_user.'-'.$id;
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

					   				'table'=> 'student_document',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);


					$dttt['file'] = $file['file_name'];

	

					}
				}

					


					$dttt['updated_at'] = date("Y-m-d H:i:s");
					$str =  $this->mymodel->updateData('log_payment', $dttt , array('id'=>$id));
					
			 
			redirect(base_url().'master/student_list/edit/'.$id_user);

		}

		function delete_payment($id,$index){

			$this->mymodel->deleteData('log_payment', array('id'=>$index));
			redirect(base_url().'master/student_list/edit/'.$id);
		}

		
		
		   function delete_file($id,$index){
			// header('Content-Type: application/json');

			$data = $this->mymodel->selectDataone('user',array('id'=>$id));
			$data = json_decode($data['log_status'],true);
			unset($data[$index]);
			$dt_input['log_status'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			// print_r($data);
			redirect(base_url().'master/student_list/edit/'.$id);
		}

 			function delete_checklist($id,$index){
			// header('Content-Type: application/json');

			$data = $this->mymodel->selectDataone('user',array('id'=>$id));
			$data = json_decode($data['checklist'],true);
			unset($data[$index]);
			$dt_input['checklist'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			// print_r($data);
			redirect(base_url().'master/student_list/edit/'.$id);
		}

		function delete_result_test($id,$index){
			// header('Content-Type: application/json');

			$data = $this->mymodel->selectDataone('user',array('id'=>$id));
			$data = json_decode($data['result_test'],true);
			unset($data[$index]);
			$dt_input['result_test'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			// print_r($data);
			redirect(base_url().'master/student_list/edit/'.$id);
		}




	}

?>