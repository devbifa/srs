

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Student_application_form extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		function submit(){

			$this->db->order_by('number','ASC');
			$dat = $this->mymodel->selectWhere('payment_status',null);
			
			foreach($dat as $k=>$v){
				$logs[$v['id']]['date'] = DATE('Y-m-d');
				$logs[$v['id']]['due_date'] = $v['due_date'];
				$logs[$v['id']]['nominal_inv'] = $v['nominal'];
				$logs[$v['id']]['description'] = '-';
				$logs[$v['id']]['updated_at'] = DATE('Y-m-d H:i:s');
			}
			$logs = json_encode($logs,true);

			$this->db->query("UPDATE user SET visibility = '1',status = 'PENDING',log_status = '$logs' WHERE visibility = '0'");
			redirect(base_url().'master/student_application_form');
		}

		function reset(){
			$this->db->query("DELETE FROM user WHERE visibility = '0'");
			redirect(base_url().'master/student_application_form/create');
		}

		function filter(){
			$_SESSION['batch'] = $_POST['batch'];
			redirect(base_url().'master/student_application_form');
		}
		public function index()

		{
			$_SESSION['create'] = '';
			$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/student_application_form/all-student_application_form',$data);

		}

		public function create()

		{

			$_SESSION['create'] = 'create';

			$data['page_name'] = "student_application_form";
			$data['mydata'] = $this->mymodel->selectWithQuery("SELECT *
			FROM user a
			WHERE a.instructor_status != '1' AND a.status = '' AND a.visibility = '0' AND a.full_name != ''");
			
			// print_r($data['mydata']);

			$this->template->load('template/template','master/student_application_form/add-student_application_form',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

			$this->form_validation->set_rules('dt[registration_date]', '<strong>Registration Date</strong>', 'required');
			// $this->form_validation->set_rules('dt[application_number]', '<strong>Application Number</strong>', 'required');
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
			// $this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
	}



		public function store()

		{

			$this->validate();
			$dt = $_POST['dt'];

			$dt['type_of_training'] = json_encode($_POST['type_of_training'],true);
			$dt['course'] = json_encode($_POST['course'],true);

			$id = $_POST['id'];
			$nick_name =  $dt['nick_name'];
			$batch =  $dt['batch'];
			$id_number =  $dt['id_number'];
		//    $user = $this->mymodel->selectDataOne('user',"nick_name = '$nick_name' AND id != '$id' AND batch = '$batch'");

		//    $user2 = $this->mymodel->selectDataOne('user',"id_number = '$id_number' AND id != '$id' AND batch = '$batch'");

		//    if($user){
		// 	   $this->alert->alertdanger('nick name already used in this batch. please use another nickname!');     
		// 	   die;
		//    }else 
		   if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];

				$dt['type_of_training'] = json_encode($_POST['type_of_training'],true);
				$dt['course'] = json_encode($_POST['course'],true);
				
				// $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				// $res = "APP-";
				// for (;;) {
				// 	for ($i = 0; $i < 7; $i++) {
				// 		$res .= $chars[mt_rand(0, strlen($chars) - 1)];
				// 	}
				// 	$query = $this->db->query("SELECT * FROM user WHERE application_number='$res'")->result();
					
				// 	if (count($query) == 0) {
				// 		break;
				// 	} else { }
				// }

				$year = DATE('Y');

				$count = $this->mymodel->selectWithQuery("select count(id) as count from user where instructor_status != '1' AND YEAR(created_at)  = '$year'");
				$count = $count[0]['count'];

				$res  = $count.'/BIFA/B-'.DATE('d').'/'.DATE('m').'/'.DATE('Y').'';
				
				$dt['application_number'] = $res;

				$dt['visibility'] = 0;
				$dt['id_number'] = '---';

				$dt['training_requirement'] = json_encode($_POST['dtt']);
				$dt['family'] = json_encode($_POST['family']);
				$dt['list_family'] = json_encode($_POST['list_family']);
				$dt['qualification'] = json_encode($_POST['qualification']);
				$dt['others'] = json_encode($_POST['others']);
				$dt['created_by'] = $_SESSION['id'];

				$dt['password'] = md5('bifa123#!');

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "";
				$dt['role'] = '4';
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

	        $this->datatables->select('a.id, DATE_FORMAT(a.registration_date,"%d %b %Y") as registration_date,DATE_FORMAT(a.date_of_birth,"%d %b %Y") as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,a.batch,a.status as status, a.remark');

			// $this->datatables->where('status',$status);
			
			$this->datatables->where("a.visibility = '1'");
			
			$this->datatables->where("a.status IN ('','PENDING')");

			$this->datatables->where("a.instructor_status != '1'");
			
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

			$this->template->load('template/template','master/student_application_form/edit-student_application_form',$data);

		}

	
		
		public function preview($id)

		{

			$data['student_application_form'] = $this->mymodel->selectDataone('user',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));$data['page_name'] = "student_application_form";

			$this->template->load('template/template','master/student_application_form/preview-student_application_form',$data);

		}





		public function update()

		{	

			$this->validate();

			
			$dt = $_POST['dt'];

			$dt['type_of_training'] = json_encode($_POST['type_of_training'],true);
			$dt['course'] = json_encode($_POST['course'],true);

			$id = $_POST['id'];
			$nick_name =  $dt['nick_name'];
			$batch =  $dt['batch'];
			$id_number =  $dt['id_number'];
		   $user = $this->mymodel->selectDataOne('user',"nick_name = '$nick_name' AND id != '$id' AND batch = '$batch'");

		//    $user2 = $this->mymodel->selectDataOne('user',"id_number = '$id_number' AND id != '$id' AND batch = '$batch'");

		//    if($user){
		// 	   $this->alert->alertdanger('nick name already used in this batch. please use another nickname!');     
		// 	   die;
		//    }else 
		   
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

						$dt['type_of_training'] = json_encode($_POST['type_of_training'],true);
						$dt['course'] = json_encode($_POST['course'],true);

						$dt['training_requirement'] = json_encode($_POST['dtt']);
						$dt['family'] = json_encode($_POST['family']);
						$dt['list_family'] = json_encode($_POST['list_family']);
						$dt['qualification'] = json_encode($_POST['qualification']);
						$dt['others'] = json_encode($_POST['others']);
	
						$str =  $this->mymodel->updateData('user', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					$dt['type_of_training'] = json_encode($_POST['type_of_training'],true);
					$dt['course'] = json_encode($_POST['course'],true);

					$dt['training_requirement'] = json_encode($_POST['dtt']);
					$dt['family'] = json_encode($_POST['family']);
					$dt['list_family'] = json_encode($_POST['list_family']);
					$dt['qualification'] = json_encode($_POST['qualification']);
					$dt['others'] = json_encode($_POST['others']);

					// $dt['attachment'] = json_encode($_POST['dttt']);

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('user', $dt , array('id'=>$id));

					return $str;  

				}}

		}

		public function delete_data($id)

		{

				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'student_application_form'));



				$str = $this->mymodel->deleteData('user',  array('id'=>$id));
				
				redirect(base_url().'master/student_application_form/create');


		}

        function delete_file($id,$index){
			// header('Content-Type: application/json');

			$data = $this->mymodel->selectDataOne('user',array('id'=>$id));
			$data = json_decode($data['attachment'],true);
			unset($data[$index]);
			// print_r($data);
			// die;
			$dt_input['attachment'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			// print_r($data);
			if($_GET['type']=='student'){

				redirect(base_url().'master/student_document/edit/'.$id);
			}else{
				redirect(base_url().'master/student_application_form/edit/'.$id);
			}
		
		}

		function upload_file($id){
			// header('Content-Type: application/json');

			$data = $this->mymodel->selectDataOne('user',array('id'=>$id));
			
			$data = json_decode($data['attachment'],true);
			// print_r($data);
			
			$id_now = (end(array_keys($data))+1);

			$dt = $_POST['dttt'];

			if (!empty($_FILES['file']['name'])){
				// echo 123;

				$dir  = "webfile/student_file/";

				$config['upload_path']          = $dir;

				$config['allowed_types']        = '*';

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

// print_r($data);
			
// die;


// die;

			$dt_input['attachment'] = json_encode($data);
			$this->mymodel->updateData('user', $dt_input , array('id'=>$id));
			 
			if($_POST['type']=='student'){

				redirect(base_url().'master/student_document/edit/'.$id);
			}else{
				redirect(base_url().'master/student_application_form/edit/'.$id);
			}
			

		}

		function update_file($id,$index){
			header('Content-Type: application/json');

			$data = $this->mymodel->selectDataOne('user',array('id'=>$id));
			
			$data = json_decode($data['attachment'],true);
			
			$data_index = $data[$index];

			$data_edit = $_POST['dttt'];
			$data_edit['updated_at'] = DATE('Y-m-d H:i:s');
			
			$dt = $data_edit;

			if (!empty($_FILES['file']['name'])){
			
				$dir  = "webfile/student_file/";

				$config['upload_path']          = $dir;

				$config['allowed_types']        = '*';

				$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



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
			
			if($_POST['type']=='student'){

				redirect(base_url().'master/student_document/edit/'.$id);
			}else{
				redirect(base_url().'master/student_application_form/edit/'.$id);
			}

		}
		public function delete($id)

		{

			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'student_application_form'));



				$str = $this->mymodel->deleteData('user',  array('id'=>$id));
				redirect(base_url().'master/student_application_form');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('user',array('status'=>$status),array('id'=>$id));


			redirect('master/Student_application_form');

		}





	}

?>