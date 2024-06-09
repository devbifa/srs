

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Menu_master extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "menu_master";

			$this->template->load('template/template','master/menu_master/all-menu_master',$data);

		}

		public function create()

		{

			$data['page_name'] = "menu_master";

			$this->template->load('template/template','master/menu_master/add-menu_master',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
$this->form_validation->set_rules('dt[icon]', '<strong>Icon</strong>', 'required');
$this->form_validation->set_rules('dt[link]', '<strong>Link</strong>', 'required');
$this->form_validation->set_rules('dt[urutan]', '<strong>Urutan</strong>', 'required');
$this->form_validation->set_rules('dt[parent]', '<strong>Parent</strong>', 'required');
$this->form_validation->set_rules('dt[notif]', '<strong>Notif</strong>', 'required');
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

				$str = $this->mymodel->insertData('menu_master', $dt);

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

					   				'table'=> 'menu_master',

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

				   				'table'=> 'menu_master',

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

	        $this->datatables->select('id,name,icon,link,urutan,parent,notif,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('menu_master');

	        if($status=="ENABLE"){

	        $this->datatables->add_column('view', '<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button>', 'id');



	    	}else{

	        $this->datatables->add_column('view', '<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm mb-5 btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>', 'id');



	    	}

	        echo $this->datatables->generate();

		}

		public function edit($id)

		{

			$data['menu_master'] = $this->mymodel->selectDataone('menu_master',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'menu_master'));$data['page_name'] = "menu_master";

			$this->template->load('template/template','master/menu_master/edit-menu_master',$data);

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

					   				'table'=> 'menu_master',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'menu_master'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('menu_master', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('menu_master', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'menu_master'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'menu_master'));



				$str = $this->mymodel->deleteData('menu_master',  array('id'=>$id));
				return $str;
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('menu_master',array('status'=>$status),array('id'=>$id));


			redirect('master/Menu_master');

		}





	}

?>