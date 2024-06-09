

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Base_airport_document extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "base_airport_document";

			$this->template->load('template/template','master/base_airport_document/all-base_airport_document',$data);

		}

		public function create()

		{

			$data['page_name'] = "base_airport_document";

			$this->template->load('template/template','master/base_airport_document/add-base_airport_document',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[base]', '<strong>Base</strong>', 'required');
$this->form_validation->set_rules('dt[icao_code]', '<strong>Icao Code</strong>', 'required');
$this->form_validation->set_rules('dt[serial_number]', '<strong>Serial Number</strong>', 'required');
$this->form_validation->set_rules('dt[city]', '<strong>City</strong>', 'required');
// $this->form_validation->set_rules('dt[last_input_date]', '<strong>Last Input Date</strong>', 'required');
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

				$str = $this->mymodel->insertData('base_airport_document', $dt);

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

					   				'table'=> 'base_airport_document',

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

				   				'table'=> 'base_airport_document',

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

	        $this->datatables->select('id,base,icao_code,serial_number,city,last_input_date,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('base_airport_document');

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

			$data['base_airport_document'] = $this->mymodel->selectDataone('base_airport_document',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'base_airport_document'));$data['page_name'] = "base_airport_document";

			$this->template->load('template/template','master/base_airport_document/edit-base_airport_document',$data);

		}
		
		public function preview($id)

		{

			$data['base_airport_document'] = $this->mymodel->selectDataone('base_airport_document',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'base_airport_document'));$data['page_name'] = "base_airport_document";

			$this->template->load('template/template','master/base_airport_document/preview-base_airport_document',$data);

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

					   				'table'=> 'base_airport_document',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'base_airport_document'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('base_airport_document', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('base_airport_document', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete($id)

		{

			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'base_airport_document'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'base_airport_document'));



				$str = $this->mymodel->deleteData('base_airport_document',  array('id'=>$id));
				redirect(base_url().'master/base_airport_document');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('base_airport_document',array('status'=>$status),array('id'=>$id));


			redirect('master/Base_airport_document');

		}





	}

?>