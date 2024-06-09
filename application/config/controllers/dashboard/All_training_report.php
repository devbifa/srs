

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class All_training_report extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "Flight_schedule";


			$start_date = $_SESSION['start_date'];
			$end_date = $_SESSION['end_date'];
			$origin_base = $_SESSION['origin_base'];
			$classroom = $_SESSION['classroom'];
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
			if($classroom){
				$classroom = "  AND a.classroom = '$classroom' ";
				}else{
				$classroom = " ";
				}
	
				if($batch){
				$batch = "  AND a.batch = '$batch' ";
				}else{
				$batch = " ";
				}
			

			$data['data_ground'] = $this->mymodel->selectWithQuery("SELECT a.start_act, a.stop_act, a.duration_act,a.remark_report, a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,g.batch, CONCAT(c.base,' (',b.classroom,')') as classroom,d.course_code as course,CONCAT(e.subject_mission,'. ',e.name) as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
			FROM
			daily_ground_schedule a
			LEFT JOIN classroom b
			ON a.classroom = b.id
			LEFT JOIN base_airport_document c
			ON b.station = c.id
			LEFT JOIN course d
			ON a.course = d.id
			LEFT JOIN tpm_syllabus_all_course e
			ON a.subject = e.id
			LEFT JOIN user f
			ON a.instructor = f.id
			LEFT JOIN batch g
			ON a.batch = g.id
			LEFT JOIN base_airport_document h
			ON b.station = h.id
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '1' 
			 "
			 .$classroom
			 .$batch.
			 "
			ORDER BY a.date ASC,a.start_lt ASC");
			
			
			
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

			if($origin_base){
				$origin_base = "  AND a.origin_base = '$origin_base' ";
			}else{
				$origin_base = " ";
			}


			$origin_base = " ";
			
			$data['data_ftd'] = $this->mymodel->selectWithQuery("SELECT a.id,a.block_time_ata, a.block_time_atd, a.block_time_total,a.remark_report, a.date, CONCAT(h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name
			FROM daily_ftd_schedule a
			LEFT JOIN batch c
			ON a.batch = c.id
			LEFT JOIN course d
			ON a.course = d.id
			LEFT JOIN tpm_syllabus_all_course e
			ON a.mission = e.id
			LEFT JOIN user f
			ON a.pic = f.id
			LEFT JOIN user g
			ON a.2nd = g.id
			LEFT JOIN synthetic_training_devices_document h
			ON a.ftd_model = h.id
			WHERE  a.visibility = '1' AND a.visibility_report = '1' 
			AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
				"
				.$origin_base.
				"
			ORDER BY a.date ASC, a.etd_utc ASC
			");
			
			
				
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

			if($origin_base){
				$origin_base = "  AND a.origin_base = '$origin_base' ";
			}else{
				$origin_base = " ";
			}


			$data['data_flight'] = $this->mymodel->selectWithQuery("SELECT a.id,a.ldg,a.date_of_flight,a.block_time_start, a.block_time_stop, a.block_time_total, a.flight_time_take_off, a.flight_time_landing, a.flight_time_total, a.remark_dmr, h.nick_name as duty_instructor, a.origin_base,b.serial_number as aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.id as id_mission, CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status
			FROM daily_flight_schedule a
			LEFT JOIN
			aircraft_document b
			ON a.aircraft_reg = b.id
			LEFT JOIN
			batch c 
			ON a.batch = c.id
			LEFT JOIN
			course d
			ON a.course = d.id
			LEFT JOIN
			tpm_syllabus_all_course e
			ON a.mission = e.id
			LEFT JOIN
			user f
			ON a.pic = f.id
			LEFT JOIN user g
		 	ON a.2nd = g.id
			LEFT JOIN user h
			ON a.duty_instructor = h.id
			WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '1' 
			"
			.$origin_base.
			"
			ORDER BY
			a.date_of_flight ASC, a.etd_utc ASC");
			$this->template->load('template/template','dashboard/all_training_report/all',$data);

		}

		function filter(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
			$_SESSION['origin_base'] = $_POST['origin_base'];
			$_SESSION['batch'] = $_POST['batch'];
			redirect(base_url().'dashboard/all_training_report');
		}
		public function create()

		{

			$data['page_name'] = "Flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/add-daily_flight_schedule',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[date_of_flight]', '<strong>Date Of Flight</strong>', 'required');
$this->form_validation->set_rules('dt[origin_base]', '<strong>Origin Base</strong>', 'required');
$this->form_validation->set_rules('dt[aircraft_reg]', '<strong>Aircraft Reg</strong>', 'required');
$this->form_validation->set_rules('dt[pic]', '<strong>Pic</strong>', 'required');
$this->form_validation->set_rules('dt[2nd]', '<strong>2nd</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
$this->form_validation->set_rules('dt[mission]', '<strong>Mission</strong>', 'required');
// $this->form_validation->set_rules('dt[mission_name]', '<strong>Mission Name</strong>', 'required');
$this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
$this->form_validation->set_rules('dt[rute]', '<strong>Rute</strong>', 'required');
$this->form_validation->set_rules('dt[etd_utc]', '<strong>Etd Utc</strong>', 'required');
$this->form_validation->set_rules('dt[eta_utc]', '<strong>Eta Utc</strong>', 'required');
$this->form_validation->set_rules('dt[eet]', '<strong>Eet</strong>', 'required');
$this->form_validation->set_rules('dt[dep]', '<strong>Dep</strong>', 'required');
$this->form_validation->set_rules('dt[arr]', '<strong>Arr</strong>', 'required');
$this->form_validation->set_rules('dt[remark]', '<strong>Remark</strong>', 'required');
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

				$str = $this->mymodel->insertData('daily_flight_schedule', $dt);

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

					   				'table'=> 'daily_flight_schedule',

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

				   				'table'=> 'daily_flight_schedule',

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

			$this->datatables->select('a.id,a.date_of_flight,a.origin_base,b.serial_number as aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status');

	        $this->datatables->where('a.status',$status);

	        $this->datatables->from('daily_flight_schedule a');

			$this->datatables->join('aircraft_document b','a.aircraft_reg = b.id');
			
	        $this->datatables->join('batch c','a.batch = c.id');
			
	        $this->datatables->join('course d','a.course = d.id');
			
	        $this->datatables->join('tpm_syllabus_all_course e','a.mission = e.id');
			
			$this->datatables->join('instructor f','a.pic = f.id');
			
			$this->datatables->join('user g','a.2nd = g.id');
			
			$this->db->order_by("a.date_of_flight ASC, a.etd_utc ASC");

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

			$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "Flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/edit-daily_flight_schedule',$data);

		}
		
		public function preview($id)

		{

			$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "Flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/preview-daily_flight_schedule',$data);

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

					   				'table'=> 'daily_flight_schedule',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('daily_flight_schedule', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('daily_flight_schedule', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_flight_schedule'));

				$this->alert->alertdanger('Success Delete Data');

				$str = $this->mymodel->deleteData('daily_flight_schedule',  array('id'=>$id));
				return $str;
				
			

		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_flight_schedule',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_flight_schedule');

		}





	}

?>