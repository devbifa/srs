

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Curriculum extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "curriculum";

			$this->template->load('template/template','master/curriculum/all-curriculum',$data);

		}
		
		function course_mission($id, $type){

			$data['page_name'] = "curriculum";
			
			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('code'=>$id));
			
			$configuration = '"val":"'.$type.'"';

			if($type=='ground'){
				$data['header'] = 'GROUND COURSE'; 
			}else if($type=='sim'){
				$data['header'] = 'FTD COURSE'; 
			}else if($type=='flight'){
				$data['header'] = 'FLIGHT TRAINING'; 
			}

			$data['type'] = $type;
			// die;
			$id_curriculum = $data['curriculum']['code'];
			$data['course'] = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");

			$this->template->load('template/template','master/curriculum/all-course-mission',$data);
		}

		function course_mission_custom($id, $type){

			$data['page_name'] = "curriculum";
			
			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('code'=>$id));
			
			$configuration = '"val":"'.$type.'"';

			$type = $this->mymodel->selectDataOne("training_type",array('id'=>$type));

			
			$data['type'] = $type['id'];
			

			$type = $type['training_type'];

			$data['header'] = $type;

			$id_curriculum = $data['curriculum']['code'];
			$data['course'] = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");
			$this->template->load('template/template','master/curriculum/all-course-mission-custom',$data);
		}

		function course_mission_print($id, $type){
			$data['page_name'] = "curriculum";
			
			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('code'=>$id));
			
			$configuration = '"val":"'.$type.'"';

			if($type=='ground'){
				$data['header'] = 'GROUND COURSE'; 
			}else if($type=='sim'){
				$data['header'] = 'FTD COURSE'; 
			}else if($type=='flight'){
				$data['header'] = 'FLIGHT TRAINING'; 
			}

			$data['type'] = $type;
			// die;
			$id_curriculum = $data['curriculum']['code'];
			$data['course'] = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");
			$this->load->view('master/curriculum/print-course-mission',$data);
		}

		function course_mission_custom_print($id, $type){
			
			$data['page_name'] = "curriculum";
			
			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('code'=>$id));
			
			$configuration = '"val":"'.$type.'"';

			$type = $this->mymodel->selectDataOne("training_type",array('id'=>$type));

			
			$data['type'] = $type['id'];
			

			$type = $type['training_type'];

			$data['header'] = $type;

			$id_curriculum = $data['curriculum']['code'];
			$data['course'] = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");

			$this->load->view('master/curriculum/print-course-mission-custom',$data);
		}
		function course($id){

			$data['page_name'] = "curriculum";

			// $data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('code'=>$id));
			
			// $this->db->order_by('position ASC');
			// $data['course'] = $this->mymodel->selectWhere('course',array('curriculum'=>$data['curriculum']['id']));

			
			$this->template->load('template/template','master/curriculum/all-course',$data);
		}

		function print($id){

			$data['page_name'] = "curriculum";

			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('code'=>$id));
			
			$this->db->order_by('position ASC');
			$data['course'] = $this->mymodel->selectWhere('course',array('curriculum'=>$data['curriculum']['code']));

			
			$this->load->view('master/curriculum/print-course',$data);
		}
		

		public function create()

		{

			$data['page_name'] = "curriculum";

			$this->template->load('template/template','master/curriculum/add-curriculum',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	// $this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
$this->form_validation->set_rules('dt[curriculum]', '<strong>Curriculum</strong>', 'required');
$this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
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

				$str = $this->mymodel->insertData('curriculum', $dt);

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

					   				'table'=> 'curriculum',

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

				   				'table'=> 'curriculum',

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

	        $this->datatables->select('id,code,curriculum,approval_date, description,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('curriculum');

	        if($status=="ENABLE"){

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($2)"><i class="fa fa-pencil"></i> EDIT</button>
			', 'id,code');



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

			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'curriculum'));$data['page_name'] = "curriculum";

			$this->template->load('template/template','master/curriculum/edit-curriculum',$data);

		}
		
		public function preview($id)

		{

			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'curriculum'));$data['page_name'] = "curriculum";

			$this->template->load('template/template','master/curriculum/preview-curriculum',$data);

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

					   				'table'=> 'curriculum',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'curriculum'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('curriculum', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('curriculum', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete($id)

		{

				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'curriculum'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'curriculum'));



				$str = $this->mymodel->deleteData('curriculum',  array('id'=>$id));
				redirect(base_url().'master/curriculum');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('curriculum',array('status'=>$status),array('id'=>$id));


			redirect('master/Curriculum');

		}





	}

?>