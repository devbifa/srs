

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Training_type extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "training_type";

			$this->template->load('template/template','master/training_type/all-training_type',$data);

		}

		public function create()

		{

			$data['page_name'] = "training_type";

			$this->template->load('template/template','master/training_type/add-training_type',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[curriculum]', '<strong>Curriculum</strong>', 'required');
$this->form_validation->set_rules('dt[training_type]', '<strong>Training Type</strong>', 'required');
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

				$str = $this->mymodel->insertData('training_type', $dt);

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

					   				'table'=> 'training_type',

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

				   				'table'=> 'training_type',

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

	        $this->datatables->select('id,curriculum,training_type,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('training_type');

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

			$data['training_type'] = $this->mymodel->selectDataone('training_type',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'training_type'));$data['page_name'] = "training_type";

			$this->template->load('template/template','master/training_type/edit-training_type',$data);

		}
		
		public function preview($id)

		{

			$data['training_type'] = $this->mymodel->selectDataone('training_type',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'training_type'));$data['page_name'] = "training_type";

			$this->template->load('template/template','master/training_type/preview-training_type',$data);

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

					   				'table'=> 'training_type',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'training_type'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('training_type', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('training_type', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete($id)

		{

				$data = $this->mymodel->selectDataOne('training_type',array('id'=>$id));
				
				
				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'training_type'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'training_type'));



				$str = $this->mymodel->deleteData('training_type',  array('id'=>$id));

				$str = $this->mymodel->deleteData('tpm_syllabus_all_course',  array('type_of_training'=>$id));

				
				redirect(base_url().'master/curriculum/course/'.$data['curriculum']);


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('training_type',array('status'=>$status),array('id'=>$id));


			redirect('master/Training_type');

		}





	}

?>