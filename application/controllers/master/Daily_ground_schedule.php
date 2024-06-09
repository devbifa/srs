

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Daily_ground_schedule extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}

		function submit(){
			$start_date = $_SESSION['start_date'];
			$date = $_SESSION['start_date'];
			$type = 'GROUND';
			$end_date = $_SESSION['end_date'];
			
			$origin_base = $_SESSION['origin_base'];
			$location = $_SESSION['origin_base'];


            $header = '
				<tr class="bg-success">
					<th style="width:20px">NUM</th>
				<th>ACFT<br>REG</th><th>PIC</th><th>2ND</th>
					<th>BATCH</th><th>COURSE</th><th>MISSION</th><th>DEP</th><th>ARR</th><th>ROUTE</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>
				</tr>
			';

		$start_date = $_SESSION['start_date'];
		$date = $_SESSION['start_date'];
		$type = 'GROUND';
		$end_date = $_SESSION['end_date'];
		
		$origin_base = $_SESSION['origin_base'];
		$location = $_SESSION['origin_base'];

		$id_base =  $this->mymodel->selectDataOne('base_airport_document',array('base'=>$origin_base));
		$id_base = $id_base['id'];
		// $user = $this->mymodel->selectDataOne('user',array('role'=>'30','base'=>$id_base));
		
		$app = $this->mymodel->selectDataOne('authorize_approval', array('type'=>'GROUND'));
		
		$json_setting = json_decode($app['json_setting'],true);

		$id_user = $json_setting[$origin_base]['user'];

		$user = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		

		if(empty($user)){
			echo '<h1>Approved By Base '.$origin_base.' Not Available!</h1>';
			die;
		}

		$id_user = $_SESSION['id'];

			$url = "http://localhost:1996/bifa/master/daily_ground_schedule/submit/?id_user=$id_user&start_date=$start_date&date=$date&type=$type&end_date=$end_date&origin_base=$origin_base&location=$location";
			
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
			// die;
			redirect(base_url().'master/daily_ground_schedule/create');
		}

	



		function submit_report(){

			$start_date = $_SESSION['start_date'];
			$date = $_SESSION['start_date'];
			$type = 'GROUND';
			$end_date = $_SESSION['end_date'];
			
			$origin_base = $_SESSION['origin_base'];
			$location = $_SESSION['origin_base'];


            $header = '
				<tr class="bg-success">
					<th style="width:20px">NUM</th>
				<th>ACFT<br>REG</th><th>PIC</th><th>2ND</th>
					<th>BATCH</th><th>COURSE</th><th>MISSION</th><th>DEP</th><th>ARR</th><th>ROUTE</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>
				</tr>
			';

		$start_date = $_SESSION['start_date'];
		$date = $_SESSION['start_date'];
		$type = 'GROUND';
		$end_date = $_SESSION['end_date'];
		
		$origin_base = $_SESSION['origin_base'];
		$location = $_SESSION['origin_base'];

		$id_base =  $this->mymodel->selectDataOne('base_airport_document',array('base'=>$origin_base));
		$id_base = $id_base['id'];
		// $user = $this->mymodel->selectDataOne('user',array('role'=>'30','base'=>$id_base));
		
		$app = $this->mymodel->selectDataOne('authorize_approval', array('type'=>'GROUND REPORT'));
		
		$json_setting = json_decode($app['json_setting'],true);

		$id_user = $json_setting[$origin_base]['user'];

		$user = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		

		if(empty($user)){
			echo '<h1>Approved By Base '.$origin_base.' Not Available!</h1>';
			die;
		}

		$id_user = $_SESSION['id'];

			$url = "http://localhost:1996/bifa/master/daily_ground_schedule/submit_report/?id_user=$id_user&start_date=$start_date&date=$date&type=$type&end_date=$end_date&origin_base=$origin_base&location=$location";
	
			
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
			redirect(base_url().'master/daily_attendance_report');
		
		}

		function submit2(){
			$id = $this->session->userdata('id');
			$user = $this->mymodel->selectDataone('user',array('id'=>$id));
			
			
			$data = $this->mymodel->selectWithQuery("SELECT instructor as pic, COUNT(id) as count FROM daily_ground_schedule WHERE visibility = '0' ".$base." GROUP BY instructor"); 
			
			foreach($data as $key=>$val){
				$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$val['pic']));
				$instructor = $this->mymodel->selectDataOne('user', array('nip'=>$pic['id_number']));
				
				
				if (strpos($instructor['email'], '@') !== false) {

					$to_email = $instructor['email'];
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					// $headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Daily Ground Schedule '.DATE('d M Y');
					$body = $this->mymodel->body_email($instructor);
		// die;
					if (mail($to_email, $subject, $body, $headers)) {
						// echo 'Success';
					}else{
						// echo 'Failed';
					}	
				}
			}

			// die;
			$this->db->query("UPDATE daily_ground_schedule SET visibility = '1' WHERE visibility = '0' ".$base);
			redirect(base_url().'master/daily_ground_schedule');
		}

		public function index()

		{

			$_SESSION['create'] = '';
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

			$this->template->load('template/template','master/daily_ground_schedule/all-daily_ground_schedule',$data);

		}

		function filter(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
			$_SESSION['origin_base'] = $_POST['origin_base'];
			$_SESSION['batch'] = $_POST['batch'];
			$_SESSION['classroom'] = $_POST['classroom'];
			redirect(base_url().'master/daily_ground_schedule');
		}

		
		function filter_create(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['start_date'];
			$_SESSION['origin_base'] = $_POST['origin_base'];
			$_SESSION['batch'] = $_POST['batch'];
			redirect(base_url().'master/daily_ground_schedule/create');
		}

		public function create()

		{

			$_SESSION['create'] = 'create';


			$this->template->load('template/template','master/daily_ground_schedule/add-daily_ground_schedule',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[date]', '<strong>Date</strong>', 'required');
	$this->form_validation->set_rules('dt[type]', '<strong>Type</strong>', 'required');
$this->form_validation->set_rules('dt[classroom]', '<strong>Classroom</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
$this->form_validation->set_rules('dt[subject]', '<strong>Subject</strong>', 'required');
$this->form_validation->set_rules('dt[instructor]', '<strong>Instructor</strong>', 'required');
$this->form_validation->set_rules('dt[duration]', '<strong>Duration</strong>', 'required');
$this->form_validation->set_rules('dt[start_lt]', '<strong>Start Lt</strong>', 'required');
$this->form_validation->set_rules('dt[stop_lt]', '<strong>Stop Lt</strong>', 'required');
$this->form_validation->set_rules('dt[remark]', '<strong>Remark</strong>', 'required');
	}



		public function store()

		{


			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
			
				$data = $_POST['dtt'];
					// print_r($data);
					$arr = array();
					foreach($data as $k=>$v){
						if($v['val']){
							$arr[$v['val']] = $v;
						}
					}

					$dt['student'] = json_encode($arr);

					// print_r($dt['student']);

					$data = $_POST['dttt'];
					$arr = array();
					foreach($data as $k=>$v){
						if($v['check']=='on'){
							$arr[$v['val']] = $v;
						}
					}

					$dt['student_other'] = json_encode($arr);


				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				
				$str = $this->mymodel->insertData('daily_ground_schedule', $dt);

			


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

	        $this->datatables->where("DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1'
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

			$data['daily_ground_schedule'] = $this->mymodel->selectDataone('daily_ground_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ground_schedule'));$data['page_name'] = "daily_ground_schedule";

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
				$origin_base = "  AND h.base = '$origin_base' ";
			}else{
				$origin_base = " ";
			}
			
			



			$this->template->load('template/template','master/daily_ground_schedule/edit-daily_ground_schedule',$data);

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

					   				'table'=> 'daily_ground_schedule',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ground_schedule'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

							$data = $_POST['dtt'];
							// print_r($data);
							$arr = array();
							foreach($data as $k=>$v){
								if($v['val']){
									$arr[$v['val']] = $v;
								}
							}

							$dt['student'] = json_encode($arr);

							// print_r($dt['student']);

							$data = $_POST['dttt'];
							$arr = array();
							foreach($data as $k=>$v){
								if($v['check']=='on'){
									$arr[$v['val']] = $v;
								}
							}

							$dt['student_other'] = json_encode($arr);

							$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('daily_ground_schedule', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					$data = $_POST['dtt'];
					// print_r($data);
					$arr = array();
					foreach($data as $k=>$v){
						if($v['val']){
							$arr[$v['val']] = $v;
						}
					}

					$dt['student'] = json_encode($arr);

					// print_r($dt['student']);

					$data = $_POST['dttt'];
					$arr = array();
					foreach($data as $k=>$v){
						if($v['check']=='on'){
							$arr[$v['val']] = $v;
						}
					}

					$dt['student_other'] = json_encode($arr);
					
					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('daily_ground_schedule', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ground_schedule'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_ground_schedule'));



				$str = $this->mymodel->deleteData('daily_ground_schedule',  array('id'=>$id));
				return $str;
				


		}

		public function delete_data($id)

		{

			
				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ground_schedule'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_ground_schedule'));



				$str = $this->mymodel->deleteData('daily_ground_schedule',  array('id'=>$id));
				redirect(base_url().'master/daily_ground_schedule/create');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_ground_schedule',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_ground_schedule');

		}





	}

?>