

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Authorize_approval extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "user";

			$this->template->load('template/template','master/authorize_approval/all',$data);

		}

		public function create()

		{

			$data['page_name'] = "user";

			$this->template->load('template/template','master/user/add-user',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('id', '<strong>ID</strong>', 'required');
	}



		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
				$dt['password'] = md5($dt['password']);

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

			if($status==''){

				$status = 'ENABLE';

			}

			header('Content-Type: application/json');

			$this->datatables->select('a.id,a.nip,a.name,a.email,a.password,b.role as role,c.base, a.status');

	        $this->datatables->where('a.status',$status);

	        $this->datatables->from('user a');

	        $this->datatables->join('role b','a.role = b.id','LEFT');

	        $this->datatables->join('base_airport_document c','a.base = c.id','LEFT');

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

			$data['authorize_approval'] = $this->mymodel->selectDataone('authorize_approval',array('id'=>$id));
			// $data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'authorize_approval'));
			// $data['file_signature'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'file_signature'));
			$data['page_name'] = "user";

			$this->template->load('template/template','master/authorize_approval/edit',$data);

		}
		
		public function preview($id)

		{

			$data['user'] = $this->mymodel->selectDataone('user',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));$data['page_name'] = "user";

			$this->template->load('template/template','master/user/preview-user',$data);

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

		

				$dt['updated_at'] = date("Y-m-d H:i:s");
				$dt['json_setting'] = json_encode($_POST['json_setting']);

				$str =  $this->mymodel->updateData('authorize_approval', $dt , array('id'=>$id));

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





	}

?>