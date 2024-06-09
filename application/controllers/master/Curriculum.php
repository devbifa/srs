

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Curriculum extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}


		public function course_mission_export($curriculum,$type)
		{
			
		
			if($type=='flight'){
				$this->db->order_by('course ASC');
				$this->db->order_by('position ASC');
				$list = $this->mymodel->selectWhere('tpm_syllabus_all_course',array('curriculum'=>$curriculum,'type_of_training'=>'FLIGHT'));
				$data = array();
				$i=1;
				foreach ($list as $u) {

				$structure = array("id","code","mission","type","type_sub","description","dual","solo","pic","solo (svp)","non rev");
			
				$data[] = array($u['id'],
				$u['type_of_training'],
				$u['curriculum'],
				$u['course'],
				$u['code'],
				$u['subject_mission'],
				$u['description'],
				$u['position'],
				$u['duration_dual'],
				$u['duration_solo'],
				$u['duration_pic'],
				$u['duration_pic_solo'],
				$u['duration_non_rev'],
				$u['type_of_training2'],
				$u['type_of_training_type2']
				);
				$i++;
			}

				$judul = "FLIGHT ".$curriculum;

				$head = array('ID','TYPE','CURRICULUM CODE','COURSE CODE','MISSION CODE','MISSION','DESCRIPTION','MISSION NUMBER','DURATION DUAL','DURATION SOLO','DURATION PIC','DURATION SOLO (SVP)','NON REV','TYPE OF TRAINING','TYPE OF TRAINING SUB');

				$json = [
				'judul'=>$judul,
				'head'=>$head,
				'data'=>$data
				];

				$this->session->set_flashdata('report',$json);
				redirect('fitur/exportreport');

				}else if($type=='sim'){
					$this->db->order_by('course ASC');
				$this->db->order_by('position ASC');
				
					$list = $this->mymodel->selectWhere('tpm_syllabus_all_course',array('curriculum'=>$curriculum,'type_of_training'=>'SIM'));
				$data = array();
				$i=1;
				foreach ($list as $u) {

				$data[] = array($u['id'],
				$u['type_of_training'],
				$u['curriculum'],
				$u['course'],
				$u['code'],
				$u['subject_mission'],
				$u['description'],
				$u['position'],
				$u['duration'],
				);
				$i++;
			}
			$judul = "FTD ".$curriculum;

			$head = array('ID','TYPE','CURRICULUM CODE','COURSE CODE','MISSION CODE','MISSION','DESCRIPTION','MISSION NUMBER','DURATION');

			
			$json = [
			'judul'=>$judul,
			'head'=>$head,
			'data'=>$data
			];

			$this->session->set_flashdata('report',$json);
			redirect('fitur/exportreport');
			}else if($type=='ground'){
				$this->db->order_by('course ASC');
				$this->db->order_by('position ASC');
				
					$list = $this->mymodel->selectWhere('tpm_syllabus_all_course',array('curriculum'=>$curriculum,'type_of_training'=>'GROUND'));
				$data = array();
				$i=1;
				foreach ($list as $u) {

				$structure = array("id","code","mission","type","type_sub","description","dual","solo","pic","solo (svp)","non rev");
			
				$data[] = array($u['id'],
				$u['type_of_training'],
				$u['curriculum'],
				$u['course'],
				$u['code'],
				$u['subject_mission'],
				$u['description'],
				$u['position'],
				$u['duration']);
				$i++;
				}

				$judul = "GROUND ".$curriculum;

				$head = array('ID','TYPE','CURRICULUM CODE','COURSE CODE','MISSION CODE','MISSION','DESCRIPTION','MISSION NUMBER','DURATION');

				
				$json = [
				'judul'=>$judul,
				'head'=>$head,
				'data'=>$data
				];

				$this->session->set_flashdata('report',$json);
				redirect('fitur/exportreport');
				
				
			}else{

			}

			
		}


		function course_mission_import($curriculum,$type){
			# code...
			ini_set('max_execution_time', 30000);
			$config['upload_path']          = 'webfile/';
			$config['allowed_types'] 		= 'xlsx|csv|xls';
			$config['file_name']            = md5($table).'.xlsx';
			$config['overwrite']            = TRUE;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('file'))
			{
				$error = array('error' => $this->upload->display_errors());
				print_r($error);
			}
			else
			{
				$data = array('file' => $this->upload->data());
				$this->importdata($curriculum,$type);
			}
		}

		public function importdata($curriculum,$type)
		{
	
			$base = $_SESSION['origin_base'];
			$date = $_SESSION['start_date'];
	
	
			# code...
		   $this->load->library('excel');
			try 
			{
				$objPHPExcel = PHPExcel_IOFactory::load('webfile/'.md5($table).'.xlsx');
			}
			catch(Exception $e)
			{
				$this->resp->success = FALSE;
				$this->resp->msg = 'Error Uploading file';
				echo json_encode($this->resp);
				exit;
			}

			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			$query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table_name."' AND COLUMN_KEY = 'PRI'";
			// $pri = $this->mymodel->selectWithQuery($query);
			$primary = $pri[0]['COLUMN_NAME'];
			$header = $allDataInSheet[1];
		
			$i=1;
			$record=0;
			$total = array();
				
				
	
				
				if(in_array($type,array('flight'))){

					$this->db->trans_start();

					foreach($allDataInSheet as $k=>$v){
						if($k > 1){	
							
							$dt['id'] = $v['A'];
							$dt['type_of_training'] = $v['B'];
							$dt['curriculum'] = $v['C'];
							$dt['course'] = $v['D'];
							$dt['code'] = $v['E'];
							$dt['subject_mission'] = $v['F'];
							$dt['description'] = $v['G'];
							$dt['name'] = $v['G'];
							$dt['position'] = $v['H'];
							$dt['duration_dual'] = $v['I'];
							$dt['duration_solo'] = $v['J'];
							$dt['duration_pic'] = $v['K'];
							$dt['duration_pic_solo'] = $v['L'];
							$dt['duration_non_rev'] = $v['M'];
							$dt['type_of_training_type2'] = $v['N'];
							$dt['type_of_training2'] = $v['O'];

							$dtt = array();
							foreach($dt as $k5=>$v5){
								$dtt[$k5] = strval($v5);
							}
							
							if($dt['id']){
								$this->mymodel2->updateData('tpm_syllabus_all_course',$dtt,array('id'=>$dtt['id']));
							}else{
								$this->mymodel2->insertData('tpm_syllabus_all_course',$dtt);
							}
							
							
						}
						
					}
					$this->db->trans_complete();

					redirect(base_url()."master/curriculum/course_mission/$curriculum/$type");
				}else if(in_array($type,array('sim'))){

					$this->db->trans_start();

					foreach($allDataInSheet as $k=>$v){
						if($k > 1){	
							$dt['id'] = $v['A'];
							$dt['type_of_training'] = $v['B'];
							$dt['curriculum'] = $v['C'];
							$dt['course'] = $v['D'];
							$dt['code'] = $v['E'];
							$dt['subject_mission'] = $v['F'];
							$dt['description'] = $v['G'];
							$dt['name'] = $v['G'];
							$dt['position'] = $v['H'];
							$dt['duration'] = $v['I'];

							$dtt = array();
							foreach($dt as $k5=>$v5){
								$dtt[$k5] = strval($v5);
							}

							if($dt['id']){
								$this->mymodel2->updateData('tpm_syllabus_all_course',$dtt,array('id'=>$dtt['id']));
							}else{
								$this->mymodel2->insertData('tpm_syllabus_all_course',$dtt);
							}
							
							
						}
					}
					$this->db->trans_complete();
					redirect(base_url()."master/curriculum/course_mission/$curriculum/$type");
				}else if(in_array($type,array('ground'))){

					$this->db->trans_start();

					foreach($allDataInSheet as $k=>$v){
						if($k > 1){	
							$dt['id'] = $v['A'];
							$dt['type_of_training'] = $v['B'];
							$dt['curriculum'] = $v['C'];
							$dt['course'] = $v['D'];
							$dt['code'] = $v['E'];
							$dt['subject_mission'] = $v['F'];
							$dt['description'] = $v['G'];
							$dt['name'] = $v['G'];
							$dt['position'] = $v['H'];
							$dt['duration'] = $v['I'];

							$dtt = array();
							foreach($dt as $k5=>$v5){
								$dtt[$k5] = strval($v5);
							}
							
							if($dt['id']){
								$this->mymodel2->updateData('tpm_syllabus_all_course',$dtt,array('id'=>$dtt['id']));
							}else{
								$this->mymodel2->insertData('tpm_syllabus_all_course',$dtt);
							}
							
							
						}
					}
					$this->db->trans_complete();
					redirect(base_url()."master/curriculum/course_mission/$curriculum/$type");
				}
				
				
				
				
	
	
				
		
				
				
				// if($table=='daily_flight_schedule'){
				// 	// echo 123456;
				// 	redirect ('master/daily_flight_schedule/create');
				// }else if($table=='daily_movement_report'){
				// 	redirect ('master/daily_movement_report');
				// }else if($table=='daily_ftd_schedule'){
				// 	redirect ('master/daily_ftd_schedule/create');
				// }else if($table=='daily_ftd_report'){
				// 	redirect ('master/daily_ftd_report');
				// }else if($table=='daily_ground_schedule'){
				// 	redirect ('master/daily_ground_schedule/create');
				// }else if($table=='daily_attendance_report'){
				// 	redirect ('master/daily_attendance_report');
				// }
				
			}


		function clone($id){
			$curriculum = $this->mymodel->selectDataOne('curriculum',array('id'=>$id));

			$dt = $curriculum;

			if(empty($curriculum)){
				echo '<h1>Curriculum Not Found!</h1>';
			}else{
				if($_POST['code']){
					
					$curriculum_2 = $this->mymodel->selectDataOne('curriculum',array('code'=>$_POST['code']));
					if($curriculum_2){
						echo '<h1>Code is Used!</h1>';
					}else{
						
						$this->db->trans_start();

						$dt['id'] = null;
						$dt['code'] = $_POST['code'];
						$dt['curriculum'] = $_POST['name'];
						$dt['created_at'] = DATE('Y-m-d H:i:s');
						$dt['updated_at'] = '';
						$dt['created_by'] = $_SESSION['id'];

					$this->db->insert('curriculum',$dt);
					
						$course = $this->mymodel->selectWhere('course',array('curriculum'=>$curriculum['code']));
						// print_r($course);
						foreach($course as $k=>$v){
							$dt = array();
							$dt = $v;
							$dt['id'] = null;
							$dt['curriculum'] = $_POST['code'];
							$before = strtok($v['code'], 'C');
							$after = substr(strrchr($v['code'], 'C'),1);
							$dt['code'] = $_POST['code'].'C'.$after;
							$dt['created_at'] = DATE('Y-m-d H:i:s');
							$dt['updated_at'] = '';
							$dt['created_by'] = $_SESSION['id'];
							$this->db->insert('course',$dt);
						}

						$item = $this->mymodel->selectWhere('tpm_syllabus_all_course',array('curriculum'=>$curriculum['code']));
						// print_r($item);
						foreach($item as $k=>$v){
							$dt = array();
							$dt = $v;
							$dt['id'] = null;
							$dt['curriculum'] = $_POST['code'];
							$before = strtok($v['course'], 'C');
							$after = substr(strrchr($v['course'], 'C'),1);
							$dt['course'] = $_POST['code'].'C'.$after;

							
							$before = strtok($v['code'], 'C');
							$after = substr(strrchr($v['code'], 'C'),1);
							$dt['code'] = $_POST['code'].'C'.$after;

							$dt['created_at'] = DATE('Y-m-d H:i:s');
							$dt['updated_at'] = '';
							$dt['created_by'] = $_SESSION['id'];
							$this->db->insert('tpm_syllabus_all_course',$dt);
						}

						$this->db->trans_complete();
						echo '<h1>Cloning is Successful!</h1>';
					}
				}else{
					echo '<h1>TPM Code & Name is Required!</h1>';
				}
			}
			
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

	        $this->datatables->select('id,code,UPPER(curriculum) as curriculum,approval_date, description,status');

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

				$curriculum = $this->mymodel->selectDataone('curriculum',array('id'=>$id));
				
				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'curriculum'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'curriculum'));

				$this->mymodel->deleteData('course',  array('curriculum'=>$curriculum['code']));

				$this->mymodel->deleteData('tpm_syllabus_all_course',  array('curriculum'=>$curriculum['code']));

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