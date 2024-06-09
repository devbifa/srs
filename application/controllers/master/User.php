

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class User extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "user";
// print_r($_SESSION);
			$this->template->load('template/template','master/user/all-user',$data);

		}

		function filter(){
			$_SESSION['role_filter'] = $_POST['role_filter'];
			redirect(base_url().'master/user');
		}

		public function create()

		{

			$data['page_name'] = "user";

			$this->template->load('template/template','master/user/add-user',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[id_number]', '<strong>id_number</strong>', 'required');
	$this->form_validation->set_rules('dt[full_name]', '<strong>Full Name</strong>', 'required');
	$this->form_validation->set_rules('dt[nick_name]', '<strong>Nick Name</strong>', 'required');
$this->form_validation->set_rules('dt[email]', '<strong>Email</strong>', 'required');
$this->form_validation->set_rules('dt[role]', '<strong>Role</strong>', 'required');
// $this->form_validation->set_rules('dt[base]', '<strong>Base</strong>', 'required');
	}

	public function validate_2()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[id_number]', '<strong>id_number</strong>', 'required');
	$this->form_validation->set_rules('dt[full_name]', '<strong>Full Name</strong>', 'required');
	$this->form_validation->set_rules('dt[nick_name]', '<strong>Nick Name</strong>', 'required');
$this->form_validation->set_rules('dt[email]', '<strong>Email</strong>', 'required');
$this->form_validation->set_rules('dt[role]', '<strong>Role</strong>', 'required');
// $this->form_validation->set_rules('dt[base]', '<strong>Base</strong>', 'required');
	}

	function get(){
		$data = $this->mymodel->selectWithQuery("SELECT id, full_name, id_number, email FROM user WHERE status = 'ACTIVE' AND email_notification LIKE '%DMR%' LIMIT 5");
		print_r($data);
	}


		public function store()

		{

			$this->validate();
			$dt = $_POST['dt'];
	    	$nick_name =  $dt['nick_name'];
			$id_number =  $dt['id_number'];
		   $user = $this->mymodel->selectDataOne('user',"nick_name = '$nick_name' AND id != '$id'");
   
		   $user2 = $this->mymodel->selectDataOne('user',"id_number = '$id_number' AND id != '$id'");

		   if($user){
			   $this->alert->alertdanger('nick name already in use. please use another nickname!');     
			   die;
		   }else if($user2){
				$this->alert->alertdanger('id number already in use. please use another id number!');     
				die;
			}else if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{


				


				$dt = $_POST['dt'];
				
				$dt['menu'] = json_encode($_POST['menu']);
				$dt['menu_item'] = json_encode($_POST['menu_item']);

				$dt['password'] = md5($dt['password']);

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['instructor_status'] = '1';

				$dt['status'] = "ACTIVE";

				$dt['type'] = json_encode($_POST['dtt']);
				$dt['email_notification'] = json_encode($_POST['dttt']);

				$str = $this->mymodel->insertData('user', $dt);

				$last_id = $this->db->insert_id();	   
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

					if (!empty($_FILES['file_signature']['name'])){

						$dir  = "webfile/";
						
						$config['upload_path']          = $dir;
						
						$config['allowed_types']        = '*';
						
						$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);
						
						$this->load->library('upload', $config);
						
						if ( ! $this->upload->do_upload('file_signature')){
						
							$error = $this->upload->display_errors();
						
							$this->alert->alertdanger($error);		
						
						}else{
						
							$file = $this->upload->data();
						
							$data = array(
						
										   'name'=> $file['file_name'],
						
										   'mime'=> $file['file_type'],
						
										   // 'size'=> $file['file_size'],
						
										   'dir'=> $dir.$file['file_name'],
						
										   'table'=> 'file_signature',
						
										   'table_id'=> $last_id,
						
										   'updated_at'=>date('Y-m-d H:i:s')
						
										);
						
							$file = $this->mymodel->selectDataone('file',array('table_id'=>$last_id,'table'=>'file_signature'));
						
							@unlink($file['dir']);
						
							if($file==""){
						
								$this->mymodel->insertData('file', $data);
						
							}else{
						
								$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
						
							}
						
						
						
						}
						
						}

					    

					

			}

		}


		function print(){
			$status = $_GET['status'];

			if($status==''){

				$status = 'ENABLE';

			}

			$role = $_SESSION['role_filter'];

			$this->db->where(array('status'=>'ENABLE'));
			$dat = $this->mymodel->selectDataOne("role",array('id'=>$_SESSION['role']));
			
			 $sub_role = (str_replace(']','',str_replace('[','',$dat['akses'])));
			

			$base = ($_SESSION['json']['base']);
			

			if($base==''){

			}else{
				$this->db->where("a.base = '$base'");
			}
			

			
			if($sub_role){
				$this->db->where("a.role in ($sub_role)");
			}else{
				$this->db->where("1=0");
			}
			
			// die;

			if($role){
				$this->db->where('a.role',$role);
			}
			$this->db->select('a.id,a.id_number, a.full_name,a.nick_name,a.email,a.password,b.role as role,a.base, a.status, a.position,a.remark_instructor,a.type');

			// $this->datatables->where('a.status',$status);
			
	        $this->db->where("a.role IN ('2','3')");

	        $this->db->from('user a');
		
	        $this->db->join('role b','a.role = b.id','LEFT');

	        


			$data['data'] = $this->db->get()->result_array();
			// print_r($data['data']);
			$this->load->view('master/user/print',$data);
		}
		public function json()

		{

			$status = $_GET['status'];

			if($status==''){

				$status = 'ENABLE';

			}

			header('Content-Type: application/json');

			$role = $_SESSION['role_filter'];

			$this->db->where(array('status'=>'ENABLE'));
			$dat = $this->mymodel->selectWhere("role",array('created_role '=>$_SESSION['role']));

			$base = '';

			foreach($dat as $k=>$v){
				$sub_role .= "'".$v['id']."',";
			}
			
			$sub_role = substr($sub_role,0,-1);
			

			
			if(in_array($_SESSION['role'],array('1','25'))){
				$my_id = $_SESSION['id'];
				$this->datatables->where("a.role not in ('4','25','') AND a.id != '$my_id'");
				$role = $_SESSION['role_filter'];
				if($role){
					$this->datatables->where("a.role  = '$role'");
				}else{
					// $this->datatables->where("1=0");
				}
			  }else{
				if($sub_role){
					$this->datatables->where("a.role in ($sub_role)");
				}else{
					$this->datatables->where("1=0");
				}
				
	
				if($role){
					$this->datatables->where('a.role',$role);
				}
			  }
			
			
			$this->datatables->select('a.id,a.id_number, a.full_name,a.nick_name,a.email,a.password,b.role as role,a.base, a.status, a.position,a.remark_instructor,a.type');

			// $this->datatables->where('a.status',$status);
			
	        // $this->datatables->where("a.role IN ('2','3')");

	        $this->datatables->from('user a');
		
	        $this->datatables->join('role b','a.role = b.id','LEFT');

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

			$data['user'] = $this->mymodel->selectDataone('user',array('id'=>$id));
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));
			$data['file_signature'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'file_signature'));
			$data['page_name'] = "user";

			$this->template->load('template/template','master/user/edit-user',$data);

		}
		
		public function preview($id)

		{

			$data['user'] = $this->mymodel->selectDataone('user',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));$data['page_name'] = "user";

			$this->template->load('template/template','master/user/preview-user',$data);

		}





		public function update()

		{	

			$this->validate();

			


			$dt = $_POST['dt'];
			$id = $_POST['id'];
			$nick_name =  $dt['nick_name'];
			$id_number =  $dt['id_number'];
		   $user = $this->mymodel->selectDataOne('user',"nick_name = '$nick_name' AND id != '$id'");
   
		   $user2 = $this->mymodel->selectDataOne('user',"id_number = '$id_number' AND id != '$id'");

		   if($user){
			   $this->alert->alertdanger('nick name already in use. please use another nickname!');     
			   die;
		   }else if($user2){
				$this->alert->alertdanger('id number already in use. please use another id number!');     
				die;
			}else if ($this->form_validation->run() == FALSE){

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

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}



					}

				}

				if (!empty($_FILES['file_signature']['name'])){

					$dir  = "webfile/";
					
					$config['upload_path']          = $dir;
					
					$config['allowed_types']        = '*';
					
					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);
					
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('file_signature')){
					
						$error = $this->upload->display_errors();
					
						$this->alert->alertdanger($error);		
					
					}else{
					
						$file = $this->upload->data();
					
						$data = array(
					
									   'name'=> $file['file_name'],
					
									   'mime'=> $file['file_type'],
					
									   // 'size'=> $file['file_size'],
					
									   'dir'=> $dir.$file['file_name'],
					
									   'table'=> 'file_signature',
					
									   'table_id'=> $id,
					
									   'updated_at'=>date('Y-m-d H:i:s')
					
									);
					
						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'file_signature'));
					
						@unlink($file['dir']);
					
						if($file==""){
					
							$this->mymodel->insertData('file', $data);
					
						}else{
					
							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
					
						}
					
					
					
					}
					
					}
				


				$dt = $_POST['dt'];

				$dt['type'] = json_encode($_POST['dtt']);
				$dt['email_notification'] = json_encode($_POST['dttt']);
				$dt['menu_item'] = json_encode($_POST['menu_item'],true);
				
				if($_POST['password']){
					$dt['password'] = md5($_POST['password']);
				}

				$dt['instructor_status'] = '1';

				$dt['menu'] = json_encode($_POST['menu']);
				$dt['updated_at'] = date("Y-m-d H:i:s");

				$str =  $this->mymodel->updateData('user', $dt , array('id'=>$id));

				return $str;  

			}

		}



		public function delete($id)

		{

				
				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'user'));



				$str = $this->mymodel->deleteData('user',  array('id'=>$id));
				redirect(base_url().'master/user');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('user',array('status'=>$status),array('id'=>$id));


			redirect('master/User');

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
			redirect(base_url().'master/user/edit/'.$id);
		}
	
	}

	function upload_file($id){
		// header('Content-Type: application/json');

		$data = $this->mymodel->selectDataOne('user',array('id'=>$id));
		
		$data = json_decode($data['attachment'],true);
		// print_r($data);
		
		$id_now = (end(array_keys($data))+1);

		$dt = $_POST['dtt'];

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
			redirect(base_url().'master/user/edit/'.$id);
		}
		

	}

	function update_file($id,$index){
		header('Content-Type: application/json');

		$data = $this->mymodel->selectDataOne('user',array('id'=>$id));
		
		$data = json_decode($data['attachment'],true);
		
		$data_index = $data[$index];

		$data_edit = $_POST['dtt'];
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
			redirect(base_url().'master/user/edit/'.$id);
		}

	}






	}

?>