

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Daily_flight_schedule extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}

		function submit(){

			$start_date = $_SESSION['start_date'];
			$date = $_SESSION['start_date'];
			$type = 'FLIGHT';
			$end_date = $_SESSION['end_date'];
			
			$origin_base = $_SESSION['origin_base'];
			$location = $_SESSION['origin_base'];

		$start_date = $_SESSION['start_date'];
		$date = $_SESSION['start_date'];
		$type = 'FLIGHT';
		$end_date = $_SESSION['end_date'];
		
		$origin_base = $_SESSION['origin_base'];
		$location = $_SESSION['origin_base'];

		$id_base =  $this->mymodel->selectDataOne('base_airport_document',array('base'=>$origin_base));
		$id_base = $id_base['id'];
		// $user = $this->mymodel->selectDataOne('user',array('role'=>'30','base'=>$id_base));
		
		$app = $this->mymodel->selectDataOne('authorize_approval', array('type'=>'FLIGHT'));
		
		$json_setting = json_decode($app['json_setting'],true);

		$id_user = $json_setting[$origin_base]['user'];

		$user = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		

		if(empty($user)){
			echo '<h1>Approved By Base '.$origin_base.' Not Available!</h1>';
			die;
		}
		$id_user = $_SESSION['id'];
			$url = "http://localhost:1996/bifa/master/daily_flight_schedule/submit/?id_user=$id_user&start_date=$start_date&date=$date&type=$type&end_date=$end_date&origin_base=$origin_base&location=$location";
			// die;
			$send = $this->template->curl_url($url);

			if($send){
				$_SESSION['propose'] = '<div class="alert alert-success">  
				<a href="#" class="close" data-dismiss="alert">×</a>  
				Notificaton
				<br>
				Propose for approval success! 
			  </div>';
			}else{
				$_SESSION['propose'] = '<div class="alert alert-danger">  
				<a href="#" class="close" data-dismiss="alert">×</a>  
				Notificaton
				<br>
				Propose for approval failed! 
			  </div>';
			}
			// die;
			redirect(base_url().'master/daily_flight_schedule/create');
		
			// die;

			// redirect(base_url().'master/daily_flight_schedule');
		}

		function reset(){
			$start_date = $_SESSION['start_date'];
			$end_date = $_SESSION['end_date'];
			$origin_base = $_SESSION['origin_base'];

			$this->mymodel->deleteData('daily_flight_schedule', "origin_base = '$origin_base' AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'");
			
			redirect(base_url().'master/daily_flight_schedule/create');
		}
		function submit_report(){
			$start_date = $_SESSION['start_date'];
			$date = $_SESSION['start_date'];
			$type = 'FLIGHT';
			$end_date = $_SESSION['end_date'];
			
			$origin_base = $_SESSION['origin_base'];
			$location = $_SESSION['origin_base'];


            $header = '
				<tr class="bg-success">
					<td style="width:20px">NUM</td>
				<td>ACFT<br>REG</td><td>PIC</td><td>2ND</td>
					<td>BATCH</td><td>COURSE</td><td>MISSION</td><td>DEP</td><td>ARR</td><td>ROUTE</td><td>ETD<br>UTC</td><td>ETA<br>UTC</td><td>EET</td><td>REMARK</td>
				</tr>
			';

		$start_date = $_SESSION['start_date'];
		$date = $_SESSION['start_date'];
		$type = 'FLIGHT';
		$end_date = $_SESSION['end_date'];
		
		$origin_base = $_SESSION['origin_base'];
		$location = $_SESSION['origin_base'];

		$id_base =  $this->mymodel->selectDataOne('base_airport_document',array('base'=>$origin_base));
		$id_base = $id_base['id'];
		// $user = $this->mymodel->selectDataOne('user',array('role'=>'30','base'=>$id_base));
		
		$app = $this->mymodel->selectDataOne('authorize_approval', array('type'=>'FLIGHT REPORT'));
		
		$json_setting = json_decode($app['json_setting'],true);

		$id_user = $json_setting[$origin_base]['user'];

		$user = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		

		if(empty($user)){
			echo '<h1>Approved By Base '.$origin_base.' Not Available!</h1>';
			die;
		}
		$id_user = $_SESSION['id'];
		$url = "http://localhost:1996/bifa/master/daily_flight_schedule/submit_report/?id_user=$id_user&start_date=$start_date&date=$date&type=$type&end_date=$end_date&origin_base=$origin_base&location=$location";
			
			// $this->template->curl_url($url);
			
			$send = $this->template->curl_url($url);

			if($send){
				$_SESSION['propose'] = '<div class="alert alert-success">  
				<a href="#" class="close" data-dismiss="alert">×</a>  
				Notificaton
				<br>
				Propose for approval success! 
			  </div>';
			}else{
				$_SESSION['propose'] = '<div class="alert alert-danger">  
				<a href="#" class="close" data-dismiss="alert">×</a>  
				Notificaton
				<br>
				Propose for approval failed! 
			  </div>';
			}

			// die;
			redirect(base_url().'master/daily_movement_report');
		
		}
		
		function submit_reportt(){


			redirect(base_url().'master/daily_movement_report');
		}


		public function index()

		{

			$_SESSION['create'] = '';
			$data['page_name'] = "daily_flight_schedule";

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

			$this->template->load('template/template','master/daily_flight_schedule/all-daily_flight_schedule',$data);

		}

		function filter(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
			$_SESSION['origin_base'] = $_POST['origin_base'];
			$_SESSION['batch'] = $_POST['batch'];
			redirect(base_url().'master/daily_flight_schedule');
		}

		function filter_create(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
			$_SESSION['origin_base'] = $_POST['origin_base'];
			$_SESSION['batch'] = $_POST['batch'];
			redirect(base_url().'master/daily_flight_schedule/create');
		}


		public function create()

		{

			$_SESSION['create'] = 'create';
			

			$this->template->load('template/template','master/daily_flight_schedule/add-daily_flight_schedule',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[date_of_flight]', '<strong>Date Of Flight</strong>', 'required');
$this->form_validation->set_rules('dt[origin_base]', '<strong>Origin Base</strong>', 'required');
$this->form_validation->set_rules('dt[aircraft_reg]', '<strong>Aircraft Reg</strong>', 'required');
$this->form_validation->set_rules('dt[pic]', '<strong>Pic</strong>', 'required');
// $this->form_validation->set_rules('dt[2nd]', '<strong>2nd</strong>', 'required');
$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
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
				$origin_base = "  AND a.origin_base = '$origin_base' ";
			}else{
				$origin_base = " ";
			}

			if($batch){
				$batch = "  AND a.batch = '$batch' ";
			}else{
				$batch = " ";
			}

			$this->datatables->select('a.id,h.nick_name as duty_instructor, a.date_of_flight,a.origin_base,b.serial_number as aircraft_reg,f.nick_name as pic, g.nick_name as 2nd,d.course_code as course,c.batch,CONCAT(e.subject_mission,"<br>",e.name,"<br>",e.description) as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status');

	        $this->datatables->where("DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'
			"
			.$origin_base
			
			.$batch.
			"");

	        $this->datatables->from('daily_flight_schedule a');

			$this->datatables->join('aircraft_document b','a.aircraft_reg = b.id');
			
	        $this->datatables->join('batch c','a.batch = c.id');
			
	        $this->datatables->join('course d','a.course = d.id');
			
	        $this->datatables->join('tpm_syllabus_all_course e','a.mission = e.id');
			
			$this->datatables->join('user f','a.pic = f.id','LEFT');
			
			$this->datatables->join('user g','a.2nd = g.id','LEFT');
			
			$this->datatables->join('user h','a.duty_instructor = h.id','LEFT');
			
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

			$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "daily_flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/edit-daily_flight_schedule',$data);

		}
		
		public function preview($id)

		{

			$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "daily_flight_schedule";

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

		public function delete_data($id)

		{

				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_flight_schedule'));

				$this->alert->alertdanger('Success Delete Data');

				$str = $this->mymodel->deleteData('daily_flight_schedule',  array('id'=>$id));
				redirect(base_url().'master/daily_flight_schedule/create');
				
			

		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_flight_schedule',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_flight_schedule');

		}





	}

?>