

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Daily_attendance_report extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "daily_ground_schedule";

			$start_date = $_SESSION['start_date'];
			$end_date = $_SESSION['end_date'];
			$origin_base = $_SESSION['origin_base'];

			if(empty($start_date)){
				$_SESSION['start_date'] = DATE('Y-m-d');
				$_SESSION['end_date'] = DATE('Y-m-d');
				$start_date = $_SESSION['start_date'];
				$end_date = $_SESSION['end_date'];
			}

			if(empty($end_date)){
				$_SESSION['start_date'] = DATE('Y-m-d');
				$_SESSION['end_date'] = DATE('Y-m-d');
				$start_date = $_SESSION['start_date'];
				$end_date = $_SESSION['end_date'];
			}

			$this->template->load('template/template','master/daily_attendance_report/all',$data);

		}

		function filter(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
			$_SESSION['origin_base'] = $_POST['origin_base'];
			$_SESSION['batch'] = $_POST['batch'];
			$_SESSION['classroom'] = $_POST['classroom'];
			redirect(base_url().'master/daily_attendance_report');
		}

		public function create()

		{

			$data['page_name'] = "daily_ground_schedule";

			$this->template->load('template/template','master/daily_ground_schedule/add-daily_ground_schedule',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('id', '<strong>ID</strong>', 'required');
// $this->form_validation->set_rules('dt[classroom]', '<strong>Classroom</strong>', 'required');
// $this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
// $this->form_validation->set_rules('dt[subject]', '<strong>Subject</strong>', 'required');
// $this->form_validation->set_rules('dt[instructor]', '<strong>Instructor</strong>', 'required');
// $this->form_validation->set_rules('dt[duration]', '<strong>Duration</strong>', 'required');
// $this->form_validation->set_rules('dt[start_lt]', '<strong>Start Lt</strong>', 'required');
// $this->form_validation->set_rules('dt[stop_lt]', '<strong>Stop Lt</strong>', 'required');
// $this->form_validation->set_rules('dt[remark]', '<strong>Remark</strong>', 'required');
	}



		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
				
				$dt['student_attend'] = json_encode($_POST['dtt']);
						
				$dt['student_other_attend'] = json_encode($_POST['dttt']);

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('daily_ground_schedule', $dt);

				$last_id = $this->db->insert_id();	    if (!empty($_FILES['file']['name'])){

		        	$dir  = "webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = $last_id.'-'.$_FILES['file']['name'];



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

					   				'table'=> 'daily_ground_schedule',

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

				   				'table'=> 'daily_ground_schedule',

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

			$start_date = $_SESSION['start_date'];
			$end_date = $_SESSION['end_date'];
			$origin_base = $_SESSION['origin_base'];
			$batch = $_SESSION['batch'];

			if(empty($start_date)){
				$_SESSION['start_date'] = DATE('Y-m-d');
				$_SESSION['end_date'] = DATE('Y-m-d');
				$start_date = $_SESSION['start_date'];
				$end_date = $_SESSION['end_date'];
			}

			if(empty($end_date)){
				$_SESSION['start_date'] = DATE('Y-m-d');
				$_SESSION['end_date'] = DATE('Y-m-d');
				$start_date = $_SESSION['start_date'];
				$end_date = $_SESSION['end_date'];
			}

			if($origin_base){
				$origin_base = "  AND h.base = '$origin_base' ";
			}else{
				$origin_base = " ";
			}
			
			if($batch){
				$batch = "  AND a.batch = '$batch' ";
			}else{
				$batch = " ";
			}

			
	        $this->datatables->select('a.id,a.date,g.batch, CONCAT(c.base," (",b.classroom,")") as classroom,d.course_code as course,e.name as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status');

	        $this->datatables->where("DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
			"
			.$origin_base
			
			.$batch.
			"");

			$this->datatables->from('daily_ground_schedule a');
			
	        $this->datatables->join('classroom b','a.classroom = b.id','LEFT');
			
	        $this->datatables->join('base_airport_document c','b.station = c.id','LEFT');
			
	        $this->datatables->join('course d','a.course = d.id','LEFT');
			
	        $this->datatables->join('tpm_syllabus_all_course e','a.subject = e.id','LEFT');
			
	        $this->datatables->join('student_application_form f','a.instructor = f.id','LEFT');
			
	        $this->datatables->join('batch g','a.batch = g.id','LEFT');
			
			$this->datatables->join('base_airport_document h','b.station = h.id','LEFT');
			
			$this->db->order_by("a.date ASC,a.start_lt ASC");

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

			$data['daily_ground_schedule'] = $this->mymodel->selectDataone('daily_ground_schedule',array('id'=>$id));
			$data['file'] = $data['daily_ground_schedule']['file_report'];

			$this->template->load('template/template','master/daily_attendance_report/edit',$data);

		}
		
		public function preview($id)

		{

			$data['daily_ground_schedule'] = $this->mymodel->selectDataone('daily_ground_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ground_schedule'));$data['page_name'] = "daily_ground_schedule";

			$this->template->load('template/template','master/daily_ground_schedule/preview-daily_ground_schedule',$data);

		}





		public function update()

		{	

			$this->validate();



	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				$id = $this->input->post('id', TRUE);
	
				if (!empty($_FILES['file']['name'])){
	
					$array = explode('.', $_FILES['file']['name']);
					$ext = end($array);
	
					$dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$dt['mission'],'type_of_training'=>'GROUND'));
					$mission = $dat;
	
					$dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$dt['course']));
					$course = $dat;
	
						$dir  = "webfile/document/";
	
						$config['upload_path']          = $dir;
	
						$config['allowed_types']        = '*';
	
						$config['overwrite'] = TRUE;
						
						// $filename = $student['nick_name']."_BATCH_".$v['batch']."_".$course['code_name']."_".$type."_".$mission['code_name']."_".$v['id'].".".$ext;
						
						$course = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$dt['course']));
						$mission = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$dt['subject']));
						$type = 'GROUND';
						$config['file_name']           = "BATCH_".$dt['batch']."_".$course['code_name']."_".$type."_".$mission['code_name']."_".$id.".".$ext;
	
						$pic = $dt['pic'];
						$nd = $dt['2nd'];
	
	
						$this->load->helper('directory');
	
						if (!is_dir("webfile/$pic")) mkdir("webfile/$pic", 0777, true);
						// if (!is_dir("webfile/$nd")) mkdir("webfile/$nd", 0777, true);
	
	
	
					$this->load->library('upload', $config);
	
				if ( ! $this->upload->do_upload('file')){
	
						$error = $this->upload->display_errors();
	
						$this->alert->alertdanger($error);		
	
					}else{
	
						$file = $this->upload->data();
	
	
						$old_file = "webfile/document/".$file['file_name'];
						$newfile = "webfile/".$pic."/".$file['file_name'];
						$newfile_2 = "webfile/".$nd."/".$file['file_name'];
						copy($old_file,$newfile);
						// copy($old_file,$newfile_2);
	
						$data = array(
	
									   'name'=> $config['file_name'],
	
									   'mime'=> $file['file_type'],
	
									   // 'size'=> $file['file_size'],
	
									   'dir'=> $dir.$config['file_name'],
	
									   'table'=> 'daily_ground_schedule',
	
									   'table_id'=> $id,
	
									   'updated_at'=>date('Y-m-d H:i:s')
	
									);
	
						
	
	
	
						$dt = $_POST['dt'];
	
						
						if($file){
							$dt['file_report'] = $file['file_name'];
						}
	
						
	
	
					$data = $_POST['dtt'];
	
					$arr = array();
					foreach($data as $k=>$v){
						if($v['val']){
							$arr[$v['val']] = $v;
						}
					}

					

					$dt['student_attend'] = json_encode($arr);

					

					$data = $_POST['dttt'];
					$arr = array();
					foreach($data as $k=>$v){
						if($v['check']=='on'){
							$arr[$v['val']] = $v;
						}
					}

					$dt['student_other_attend'] = json_encode($arr);
					
					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('daily_ground_schedule', $dt , array('id'=>$id));

					return $str;  

				}
				
			}else{
				$dt = $_POST['dt'];
	
						
	
	
				$data = $_POST['dtt'];
			
				
			

			$arr = array();
			foreach($data as $k=>$v){
				if($v['val']){
					$arr[$v['val']] = $v;
				}
			}

			$dt['student_attend'] = json_encode($arr);

			// print_r($dt['student']);

			$data = $_POST['dttt'];
			$arr = array();
			foreach($data as $k=>$v){
				if($v['check']=='on'){
					$arr[$v['val']] = $v;
				}
			}

			$dt['student_other_attend'] = json_encode($arr);
			
			$dt['updated_at'] = date("Y-m-d H:i:s");

			$str = $this->mymodel->updateData('daily_ground_schedule', $dt , array('id'=>$id));

			return $str;  
			}

		}
	}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ground_schedule'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_ground_schedule'));



				$str = $this->mymodel->deleteData('daily_ground_schedule',  array('id'=>$id));
				return $str;
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_ground_schedule',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_ground_schedule');

		}





	}

?>