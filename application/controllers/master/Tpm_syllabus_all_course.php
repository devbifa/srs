

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Tpm_syllabus_all_course extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "tpm_syllabus_all_course";

			$this->template->load('template/template','master/tpm_syllabus_all_course/all-tpm_syllabus_all_course',$data);

		}

		public function create($curriculum, $course, $type)

		{

			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('id'=>$curriculum));
			
			if($type=='ground'){
				$data['header'] = 'GROUND COURSE'; 
			}else if($type=='sim'){
				$data['header'] = 'FTD COURSE'; 
			}else if($type=='flight'){
				$data['header'] = 'FLIGHT TRAINING'; 
			}

			$data['type'] = $type;
			// die;
			$this->db->order_by('position ASC');
			$data['course'] = $this->mymodel->selectDataone('course',array('id'=> $course));

			$data['page_name'] = "tpm_syllabus_all_course";

			$this->template->load('template/template','master/tpm_syllabus_all_course/add-tpm_syllabus_all_course',$data);

		}

		
		public function create_custom($curriculum, $course, $type)

		{

			$data['curriculum'] = $this->mymodel->selectDataone('curriculum',array('id'=>$curriculum));
			
			if($type=='ground'){
				$data['header'] = 'GROUND COURSE'; 
			}else if($type=='sim'){
				$data['header'] = 'FTD COURSE'; 
			}else if($type=='flight'){
				$data['header'] = 'FLIGHT TRAINING'; 
			}

			$data['type'] = $type;
			// die;
			$this->db->order_by('position ASC');
			$data['course'] = $this->mymodel->selectDataone('course',array('id'=> $course));

			$data['page_name'] = "tpm_syllabus_all_course";

			$this->template->load('template/template','master/tpm_syllabus_all_course/add-tpm_syllabus_all_course_custom',$data);

		}

		
		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[curriculum]', '<strong>Curriculum</strong>', 'required');
$this->form_validation->set_rules('dt[type_of_training]', '<strong>Type Of Training</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
$this->form_validation->set_rules('dt[subject_mission]', '<strong>Subject Mission</strong>', 'required');
$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
$this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
// $this->form_validation->set_rules('dt[duration_instruct]', '<strong>Duration Instruct</strong>', 'required');
// $this->form_validation->set_rules('dt[duration_solo]', '<strong>Duration Solo</strong>', 'required');
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

				$str = $this->mymodel->insertData('tpm_syllabus_all_course', $dt);

				$last_id = $this->db->insert_id();	    
			
				
				if (!empty($_FILES['file']['name'])){

		        	$dir  = "webfile/tpm";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = $dt['code'].' '.$dt['description'];

					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('file')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

					   	$file = $this->upload->data();

						// $data = array(

					   	// 			'id' => '',

					   	// 			'name'=> $file['file_name'],

					   	// 			'mime'=> $file['file_type'],

					   	// 			'dir'=> $dir.$file['file_name'],

					   	// 			'table'=> 'tpm_syllabus_all_course',

					   	// 			'table_id'=> $last_id,

					   	// 			'status'=>'ENABLE',

					   	// 			'created_at'=>date('Y-m-d H:i:s')

					   	//  		);

					   	// $str = $this->mymodel->insertData('file', $data);

						// $this->alert->alertsuccess('Success Send Data');
						
						$dt['file'] = $file['file_name'];

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'tpm_syllabus_all_course',

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

	        $this->datatables->select('id,curriculum,type_of_training,course,subject_mission,name,description,duration_instruct,duration_solo,last_input_date,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('tpm_syllabus_all_course');

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

			$data['tpm_syllabus_all_course'] = $this->mymodel->selectDataone('tpm_syllabus_all_course',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tpm_syllabus_all_course'));$data['page_name'] = "tpm_syllabus_all_course";

			$this->template->load('template/template','master/tpm_syllabus_all_course/edit-tpm_syllabus_all_course',$data);

		}

		public function edit_custom($id)

		{

			$data['tpm_syllabus_all_course'] = $this->mymodel->selectDataone('tpm_syllabus_all_course',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tpm_syllabus_all_course'));$data['page_name'] = "tpm_syllabus_all_course";

			$this->template->load('template/template','master/tpm_syllabus_all_course/edit-tpm_syllabus_all_course_custom',$data);

		}
		
		public function preview($id)

		{

			$data['tpm_syllabus_all_course'] = $this->mymodel->selectDataone('tpm_syllabus_all_course',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tpm_syllabus_all_course'));$data['page_name'] = "tpm_syllabus_all_course";

			$this->template->load('template/template','master/tpm_syllabus_all_course/preview-tpm_syllabus_all_course',$data);

		}





		public function update()

		{	

			$this->validate();

			
			$dt = $_POST['dt'];



	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$id = $this->input->post('id', TRUE);

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "webfile/tpm";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = $dt['code'].' '.$dt['description'];

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

					   				'table'=> 'tpm_syllabus_all_course',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						

						



						
						$dt['file'] = $file['file_name'];

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('tpm_syllabus_all_course', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('tpm_syllabus_all_course', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete($id)

		{

			$data = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('id'=>$id));
		
				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tpm_syllabus_all_course'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'tpm_syllabus_all_course'));



				$str = $this->mymodel->deleteData('tpm_syllabus_all_course',  array('id'=>$id));
			
				
				redirect(base_url().'master/curriculum/course_mission/'.$data['curriculum'].'/'.strtolower($data['type_of_training']));
			

		}

		public function delete_custom($id)

		{

			$data = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('id'=>$id));
		// echo ' master/curriculum/course_mission_custom/'.$data['curriculum'].'/10';
			// die;
				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'tpm_syllabus_all_course'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'tpm_syllabus_all_course'));



				$str = $this->mymodel->deleteData('tpm_syllabus_all_course',  array('id'=>$id));
			
				
				redirect(base_url().'master/curriculum/course_mission_custom/'.$data['curriculum'].'/'.strtolower($data['type_of_training']));
				

		}
		


		public function status($id,$status)

		{

			$this->mymodel->updateData('tpm_syllabus_all_course',array('status'=>$status),array('id'=>$id));


			redirect('master/Tpm_syllabus_all_course');

		}





	}

?>