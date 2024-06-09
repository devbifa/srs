

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Safety_performance extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "safety_performance";

			$this->template->load('template/template','master/safety_performance/all',$data);

		}

		public function create()

		{

			$data['page_name'] = "safety_performance";

			$this->template->load('template/template','master/safety_performance/add',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[type]', '<strong>Type</strong>', 'required');
$this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
$this->form_validation->set_rules('dt[remarks]', '<strong>Remarks</strong>', 'required');
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

				$str = $this->mymodel->insertData('safety_performance', $dt);

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

					   				'table'=> 'safety_performance',

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

				   				'table'=> 'safety_performance',

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

	        $this->datatables->select('id,type,code,remarks,last_input_date,status');

	        // $this->datatables->where('status','DISABLE');

	        $this->datatables->from('safety_performance');

	        if($status=="ENABLE"){

				$this->datatables->add_column('view', '
				<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger btn-block"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');



	    	}else{

			$this->datatables->add_column('view', '
			<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger btn-block"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');



	    	}

	        echo $this->datatables->generate();

		}

		public function edit($id)

		{

			$data['safety_performance'] = $this->mymodel->selectDataone('safety_performance',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'safety_performance'));$data['page_name'] = "safety_performance";

			$this->template->load('template/template','master/safety_performance/edit',$data);

		}
		
		public function preview($id)

		{

			$data['safety_performance'] = $this->mymodel->selectDataone('safety_performance',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'safety_performance'));$data['page_name'] = "safety_performance";

			$this->template->load('template/template','master/safety_performance/preview',$data);

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

					   				'table'=> 'safety_performance',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'safety_performance'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('safety_performance', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('safety_performance', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete($id)

		{

				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'safety_performance'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'safety_performance'));



				$str = $this->mymodel->deleteData('safety_performance',  array('id'=>$id));
				
				redirect(base_url().'master/safety_performance');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('safety_performance',array('status'=>$status),array('id'=>$id));


			redirect('master/Safety_performance');

		}





	}

?>