

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Daily_flight_schedule extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "daily_flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/all-daily_flight_schedule',$data);

		}

		public function create()

		{

			$data['page_name'] = "daily_flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/add-daily_flight_schedule',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[date_of_flight]', '<strong>Date Of Flight</strong>', 'required');
$this->form_validation->set_rules('dt[origin_base]', '<strong>Origin Base</strong>', 'required');
$this->form_validation->set_rules('dt[aircraft_reg]', '<strong>Aircraft Reg</strong>', 'required');
$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
$this->form_validation->set_rules('dt[pic]', '<strong>Pic</strong>', 'required');
$this->form_validation->set_rules('dt[second]', '<strong>Second</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
$this->form_validation->set_rules('dt[mission]', '<strong>Mission</strong>', 'required');
$this->form_validation->set_rules('dt[route]', '<strong>Route</strong>', 'required');
$this->form_validation->set_rules('dt[etd]', '<strong>Etd</strong>', 'required');
$this->form_validation->set_rules('dt[eta]', '<strong>Eta</strong>', 'required');
// $this->form_validation->set_rules('dt[eet]', '<strong>Eet</strong>', 'required');
// $this->form_validation->set_rules('dt[off]', '<strong>Off</strong>', 'required');
// $this->form_validation->set_rules('dt[on]', '<strong>On</strong>', 'required');
// $this->form_validation->set_rules('dt[time]', '<strong>Time</strong>', 'required');
$this->form_validation->set_rules('dt[dep]', '<strong>Dep</strong>', 'required');
$this->form_validation->set_rules('dt[arr]', '<strong>Arr</strong>', 'required');
$this->form_validation->set_rules('dt[remark]', '<strong>Remark</strong>', 'required');
// $this->form_validation->set_rules('dt[acft_remaining_hours]', '<strong>Acft Remaining Hours</strong>', 'required');
// $this->form_validation->set_rules('dt[type_of_inspection]', '<strong>Type Of Inspection</strong>', 'required');
// $this->form_validation->set_rules('dt[del_cnl_code]', '<strong>Del Cnl Code</strong>', 'required');
// $this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
	}



		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
				$pic = $dt['pic'];

				$pic = explode('-ksxyz-', $pic);

				$dt['pic'] = $pic[0];

				$dt['pic_status'] = $pic[1];

				$second = $dt['second'];

				$second = explode('-ksxyz-', $second);

				$dt['second'] = $second[0];

				$dt['second_status'] = $second[1];

				

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

	        $this->datatables->select('id,date_of_flight,origin_base,aircraft_reg,batch,pic,second,course,mission,route,etd,eta,DATE_FORMAT(TIMEDIFF(etd,eta), "%h:%i") as eet,off,on,time,dep,arr,remark,acft_remaining_hours,type_of_inspection,del_cnl_code,description,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('daily_flight_schedule');

	        if($status=="ENABLE"){

	        $this->datatables->add_column('view', '<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button>', 'id');



	    	}else{

	        $this->datatables->add_column('view', '<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> Edit</button><button type="button" onclick="hapus($1)" class="btn btn-sm mb-5 btn-danger"><i class="fa fa-trash-o"></i> Hapus</button>', 'id');



	    	}

	        echo $this->datatables->generate();

		}

		public function edit($id)

		{

			$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "daily_flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/edit-daily_flight_schedule',$data);

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

						$pic = $dt['pic'];

						$pic = explode('-ksxyz-', $pic);

						$dt['pic'] = $pic[0];

						$dt['pic_status'] = $pic[1];

						$second = $dt['second'];

						$second = explode('-ksxyz-', $second);

						$dt['second'] = $second[0];

						$dt['second_status'] = $second[1];


						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('daily_flight_schedule', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					$pic = $dt['pic'];

					$pic = explode('-ksxyz-', $pic);

					$dt['pic'] = $pic[0];

					$dt['pic_status'] = $pic[1];

					$second = $dt['second'];

					$second = explode('-ksxyz-', $second);

					$dt['second'] = $second[0];

					$dt['second_status'] = $second[1];


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



				$str = $this->mymodel->deleteData('daily_flight_schedule',  array('id'=>$id));
				return $str;
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_flight_schedule',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_flight_schedule');

		}



		function get_pic(){
			header('Access-Control-Allow-Origin: *');
			$batch = $_GET['batch'];
			

	
			// $data_session = array(
			// 	'customer' => $id,
			// );
			// $this->session->set_userdata($data_session);
	
			$data_text = array();
			$data_crew = $this->db->query("SELECT * FROM crew")->result_array();
			$data_student = $this->db->query("SELECT * FROM student WHERE batch_code = '$batch'")->result_array();
			$i = 0;
			
			$data_text[$i]['id'] = 'disabled';
			$data_text[$i]['crew_code'] = 'CREW';
			$data_text[$i]['crew_name'] = 'CREW';

			foreach($data_crew as $key=>$val){
				$i++;
				$data_text[$i]['id'] = $val['id'];
				$data_text[$i]['crew_code'] = $val['crew_code'];
				$data_text[$i]['crew_name'] = $val['crew_name'];
				$data_text[$i]['crew_status'] = 'crew';
			}

			$i++;
			$data_text[$i]['id'] = 'disabled';
			$data_text[$i]['crew_code'] = 'STUDENT BATCH '.$batch;
			$data_text[$i]['crew_name'] = 'STUDENT BATCH '.$batch;

			foreach($data_student as $key=>$val){
				$i++;
				$data_text[$i]['id'] = $val['id'];
				$data_text[$i]['crew_code'] = $val['student_code'];
				$data_text[$i]['crew_name'] = $val['student_name'];
				$data_text[$i]['crew_status'] = 'student';
			}
			// $data_text = '<option>Pilih</option>';
			// foreach($data as $key=>$val){
			// 	// $data_text = $data_text . '<option value="'.$val['id'].'">'.$val['no_serial'].'</option>';
			// }
			echo json_encode($data_text);
	
		}

		function get_mission(){
			header('Access-Control-Allow-Origin: *');
			$course = $_GET['course'];
		
			$data_text = array();
			$data_text = $this->db->query("SELECT * FROM mission WHERE course_code = '$course'")->result_array();

			echo json_encode($data_text);
	
		}

	}

?>