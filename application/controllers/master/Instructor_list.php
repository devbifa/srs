

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Instructor_list extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

	}



	public function index()

	{

		$data['page_name'] = "instructor_list";

		$this->template->load('template/template','master/instructor_list/all',$data);

	}

	public function create()

	{

		$data['page_name'] = "student_application_form";

		$this->template->load('template/template','master/instructor_list/add',$data);

	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules('dt[full_name]', '<strong>Full Name</strong>', 'required');
		$this->form_validation->set_rules('dt[nick_name]', '<strong>Nick Name</strong>', 'required');
		$this->form_validation->set_rules('dt[id_number]', '<strong>Employee Number</strong>', 'required');

	}

	public function store()

	{

		$this->validate();

		if ($this->form_validation->run() == FALSE){

			$this->alert->alertdanger(validation_errors());     

		}else{

			$dt = $_POST['dt'];
			$dt['instructor_status'] = '1';
			$dt['type'] = json_encode($_POST['dtt']);
			// $dt['attachment'] = json_encode($_POST['dtt']);
			$dt['created_by'] = $_SESSION['id'];

			$dt['created_at'] = date('Y-m-d H:i:s');

			$dt['status'] = "";

			$this->mymodel->insertData('student_application_form', $dt);

			$last_id = $this->db->insert_id();	 
			
			$nip = $dt['id_number'];
			$dat = $this->mymodel->selectDataOne('user', array('nip'=>$nip));
			
			if(count($dat) == 0){
				$dtt['role_id'] = '2';
				$dtt['status'] = 'ENABLE';
				$dtt['base'] = '4';
				$dtt['name'] = $dt['nick_name'];
				$dtt['desc'] = $dt['remark_instructor'];
				$dtt['nip'] = $dt['id_number'];
				$dtt['email'] = $dt['email'];
				$dtt['password'] = md5('bifa123#!');
				$dtt['created_by'] = $_SESSION['id'];
				$dtt['created_at'] = date('Y-m-d H:i:s');
				$str = $this->mymodel->insertData('user', $dtt);
			}else{
				// $dtt['role_id'] = '2';
				// $dtt['status'] = 'ENABLE';
				// $dtt['base'] = '4';
				$dtt['name'] = $dt['nick_name'];
				$dtt['desc'] = $dt['remark_instructor'];
				// $dtt['nip'] = $dt['id_number'];
				$dtt['email'] = $dt['email'];
				$dtt['password'] = md5('bifa123#!');
				// $dtt['created_by'] = $_SESSION['id'];
				$dtt['updated_at'] = date('Y-m-d H:i:s');
				$str = $this->mymodel->updateData('user', $dtt , array('nip'=>$dt['id_number']));
			}
			
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

		$this->datatables->select('a.id, a.full_name, a.nick_name, a.id_number, a.type,a.remark_instructor,a.position');

		// $this->datatables->where('status',$status);
		
		$this->datatables->where("instructor_status = '1'");
		
		

		$this->datatables->from('student_application_form a');

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

		$this->template->load('template/template','master/instructor_list/edit',$data);

	}
	
	public function preview($id)

	{

		$data['student_application_form'] = $this->mymodel->selectDataone('student_application_form',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));$data['page_name'] = "student_application_form";

		$this->template->load('template/template','master/instructor_list/preview',$data);

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

					$dt['type'] = json_encode($_POST['dtt']);

					// $dt['attachment'] = json_encode($_POST['dtt']);

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$this->mymodel->updateData('student_application_form', $dt , array('id'=>$id));

					$nip = $dt['id_number'];
					$dat = $this->mymodel->selectDataOne('user', array('nip'=>$nip));
					
					if(count($dat) == 0){
						$dtt['role_id'] = '2';
						$dtt['status'] = 'ENABLE';
						$dtt['base'] = '4';
						$dtt['name'] = $dt['nick_name'];
						$dtt['desc'] = $dt['remark_instructor'];
						$dtt['nip'] = $dt['id_number'];
						$dtt['email'] = $dt['email'];
						$dtt['password'] = md5('bifa123#!');
						$dtt['created_by'] = $_SESSION['id'];
						$dtt['created_at'] = date('Y-m-d H:i:s');
						$str = $this->mymodel->insertData('user', $dtt);
					}else{
						// $dtt['role_id'] = '2';
						// $dtt['status'] = 'ENABLE';
						// $dtt['base'] = '4';
						$dtt['name'] = $dt['nick_name'];
						$dtt['desc'] = $dt['remark_instructor'];
						// $dtt['nip'] = $dt['id_number'];
						$dtt['email'] = $dt['email'];
						$dtt['password'] = md5('bifa123#!');
						// $dtt['created_by'] = $_SESSION['id'];
						$dtt['updated_at'] = date('Y-m-d H:i:s');
						$str = $this->mymodel->updateData('user', $dtt , array('nip'=>$dt['id_number']));
					}

					return $str;  


				}

			}else{

				$dt = $_POST['dt'];
				$dt['type'] = json_encode($_POST['dtt']);
				// $dt['attachment'] = json_encode($_POST['dtt']);

				$dt['updated_at'] = date("Y-m-d H:i:s");

				$this->mymodel->updateData('student_application_form', $dt , array('id'=>$id));
				
				$nip = $dt['id_number'];
				$dat = $this->mymodel->selectDataOne('user', array('nip'=>$nip));
				
				if(count($dat) == 0){
					$dtt['role_id'] = '2';
					$dtt['status'] = 'ENABLE';
					$dtt['base'] = '4';
					$dtt['name'] = $dt['nick_name'];
					$dtt['desc'] = $dt['remark_instructor'];
					$dtt['nip'] = $dt['id_number'];
					$dtt['email'] = $dt['email'];
					$dtt['password'] = md5('bifa123#!');
					$dtt['created_by'] = $_SESSION['id'];
					$dtt['created_at'] = date('Y-m-d H:i:s');
					$str = $this->mymodel->insertData('user', $dtt);
				}else{
					// $dtt['role_id'] = '2';
					// $dtt['status'] = 'ENABLE';
					// $dtt['base'] = '4';
					$dtt['name'] = $dt['nick_name'];
					$dtt['desc'] = $dt['remark_instructor'];
					// $dtt['nip'] = $dt['id_number'];
					$dtt['email'] = $dt['email'];
					$dtt['password'] = md5('bifa123#!');
					// $dtt['created_by'] = $_SESSION['id'];
					$dtt['updated_at'] = date('Y-m-d H:i:s');
					$str = $this->mymodel->updateData('user', $dtt , array('nip'=>$dt['id_number']));
				}
				

				return $str;  

			}}

	}

	
	
	function delete_file($id,$index){
		// header('Content-Type: application/json');

		$data = $this->mymodel->selectDataOne('student_application_form',array('id'=>$id));
		$data = json_decode($data['attachment'],true);
		unset($data[$index]);
		// print_r($data);
		// die;
		$dt_input['attachment'] = json_encode($data);
		$this->mymodel->updateData('student_application_form', $dt_input , array('id'=>$id));
		// print_r($data);
		if($_GET['type']=='student'){

			redirect(base_url().'master/student_document/edit/'.$id);
		}else{
			redirect(base_url().'master/instructor_list/edit/'.$id);
		}
	
	}

	function upload_file($id){
		// header('Content-Type: application/json');

		$data = $this->mymodel->selectDataOne('student_application_form',array('id'=>$id));
		
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
		$this->mymodel->updateData('student_application_form', $dt_input , array('id'=>$id));
		 
		if($_POST['type']=='student'){

			redirect(base_url().'master/student_document/edit/'.$id);
		}else{
			redirect(base_url().'master/instructor_list/edit/'.$id);
		}
		

	}

	function update_file($id,$index){
		header('Content-Type: application/json');

		$data = $this->mymodel->selectDataOne('student_application_form',array('id'=>$id));
		
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
		$this->mymodel->updateData('student_application_form', $dt_input , array('id'=>$id));
		
		if($_POST['type']=='student'){

			redirect(base_url().'master/student_document/edit/'.$id);
		}else{
			redirect(base_url().'master/instructor_list/edit/'.$id);
		}

	}

	public function delete($id)

	{

		$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'student_application_form'));

			@unlink($file['dir']);

			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'student_application_form'));



			$str = $this->mymodel->deleteData('student_application_form',  array('id'=>$id));
			redirect(base_url().'master/instructor_list');
			


	}



	public function status($id,$status)

	{

		$this->mymodel->updateData('student_application_form',array('status'=>$status),array('id'=>$id));


		redirect('master/instructor_list');

	}





}

?>