

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Daily_ftd_schedule extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

	}

	
	function reset(){
		$start_date = $_SESSION['start_date'];
		$end_date = $_SESSION['end_date'];
		$origin_base = $_SESSION['origin_base'];

		if($origin_base){
			$origin_base = "  AND origin_base = '$origin_base' ";
		  }else{
			$origin_base = " ";
		  }

		  
		if($start_date && $end_date){
			$this->mymodel->deleteData('daily_ftd_schedule', "DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' ".$origin_base." ");
		}else{
			$start_date = '1970-01-01';
			$this->db->delete('daily_ftd_schedule', "origin_base = '$origin_base' AND DATE(date) = '$start_date'");
		}
		
		redirect(base_url().'master/daily_ftd_schedule/create');
	}


	function submit(){
		$start_date = $_SESSION['start_date'];
		$date = $_SESSION['start_date'];
		$type = 'FTD';
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
		$type = 'FTD';
		$end_date = $_SESSION['end_date'];
		
		$origin_base = $_SESSION['origin_base'];
		$location = $_SESSION['origin_base'];

		$id_base =  $this->mymodel->selectDataOne('base_airport_document',array('base'=>$origin_base));
		$id_base = $id_base['id'];
		// $user = $this->mymodel->selectDataOne('user',array('role'=>'30','base'=>$id_base));
		
		$app = $this->mymodel->selectDataOne('authorize_approval', array('type'=>'FTD'));
		
		$json_setting = json_decode($app['json_setting'],true);

		$id_user = $json_setting[$origin_base]['user'];

		$user = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		

		if(empty($user)){
			echo '<h1>Approved By Base '.$origin_base.' Not Available!</h1>';
			die;
		}
		$id_user = $_SESSION['id'];

		$url = "http://localhost:1996/bifa/master/daily_ftd_schedule/submit/?id_user=$id_user&start_date=$start_date&date=$date&type=$type&end_date=$end_date&origin_base=$origin_base&location=$location";
		// die;
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
	
		redirect(base_url().'master/daily_ftd_schedule/create');
	}

	
	function submit_report(){
		$start_date = $_SESSION['start_date'];
		$date = $_SESSION['start_date'];
		$type = 'FTD_REPORT';
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
	$type = 'FTD_REPORT';
	$end_date = $_SESSION['end_date'];
	
	$origin_base = $_SESSION['origin_base'];
	$location = $_SESSION['origin_base'];

	$id_base =  $this->mymodel->selectDataOne('base_airport_document',array('base'=>$origin_base));
	$id_base = $id_base['id'];
	// $user = $this->mymodel->selectDataOne('user',array('role'=>'30','base'=>$id_base));
	
	$app = $this->mymodel->selectDataOne('authorize_approval', array('type'=>'FTD REPORT'));
	
	$json_setting = json_decode($app['json_setting'],true);

	$id_user = $json_setting[$origin_base]['user'];

	$user = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
	

	if(empty($user)){
		echo '<h1>Approved By Base '.$origin_base.' Not Available!</h1>';
		die;
	}

	$type = 'FTD_REPORT';
	$id_user = $_SESSION['id'];
	$url = "http://localhost:1996/bifa/master/daily_ftd_schedule/submit_report/?id_user=$id_user&start_date=$start_date&date=$date&type=$type&end_date=$end_date&origin_base=$origin_base&location=$location";

		// echo $url = "http://localhost:1996/bifa/master/daily_ftd_schedule/submit_report/?id_user=$id_user&start_date=$start_date&date=$date&type=$type&end_date=$end_date&origin_base=$origin_base&location=$location";
		// die;
		// $this->template->curl_url($url);
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
		redirect(base_url().'master/daily_ftd_report');
	}





	function submit_reportt(){

		$header = '
			<tr class="bg-success">
			<td style="width:20px" rowspan="2" rowspan="2">NUM</td>
			  <td rowspan="2">FTD MODEL</td>
			  <td rowspan="2">INSTRUCTOR</td><td rowspan="2">STUDENT</td>
			  <td rowspan="2">BATCH</td>
			  <td rowspan="2">COURSE</td><td rowspan="2">MISSION</td>
			  <td rowspan="2">ETD<br>UTC</td><td rowspan="2">ETA<br>UTC</td>
			  <td rowspan="2">EET</td>
			  <td colspan="3">BLOCK TIME</td>
			  <td rowspan="2">REMARK</td>
			  <td rowspan="2">IRREG<br>CODE</td>
			  </tr>
			  <tr class="bg-success">
<td>ATD</td>
<td>ATA</td>
<td>TOTAL</td>
</tr>
		';

	$start_date = $_SESSION['start_date'];
	$date = $_SESSION['start_date'];
	$type = 'FTD_REPORT';
	$end_date = $_SESSION['end_date'];
	
	$origin_base = $_SESSION['origin_base'];
	$location = $_SESSION['origin_base'];

	$id_base =  $this->mymodel->selectDataOne('base_airport_document',array('base'=>$origin_base));
	$id_base = $id_base['id'];
	// $user = $this->mymodel->selectDataOne('user',array('role_id'=>'30','base'=>$id_base));
	
	$app = $this->mymodel->selectDataOne('authorize_approval', array('type'=>'FTD REPORT'));
	if($app['by_base']!='YES'){
		$user = $this->mymodel->selectDataOne('user',array('role_id'=>$app['role_id'],'base'=>$id_base));
	}else{
		$user = $this->mymodel->selectDataOne('user',array('role_id'=>$app['role_id']));
	}
	
	if(empty($user)){
		echo '<h1>Approved By Base '.$origin_base.' Not Available!</h1>';
		die;
	}

				$date = $start_date;
				$type = 'FTD_REPORT';
				$base = $origin_base;
				$data = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base' ");
				
				if($data){
				
					$dtt = array(
						'approved_by' => $user['id'],
						'prepared_by' => $_SESSION['id'],
						// 'on_be_half_status' => $dt['on_be_half_status'],
						// 'approved_by_2' => $dt['approved_by_2'],
						// 'remark' => $dt['remark'],
						'updated_at' => DATE('Y-m-d H:i:s'),
						'prepared_time' => DATE('Y-m-d H:i:s'),
						'status' => 'ENABLE',
						'approval_status' => 'PENDING',
						'prepared_time' => DATE('Y-m-d H:i:s'),
					);

					$str = $this->mymodel->updateData('approval', $dtt , array('date'=>$date, 'type'=>$type, 'base'=>$base));
					// echo $str;
				}else{
				// echo 11;
					$dtt = array(
						'date' => $date,
						'type' => $type,
						'approved_by' => $user['id'],
						'prepared_by' => $_SESSION['id'],
						'approval_status' => 'PENDING',
						'approval_status_2' => '',
						// 'on_be_half_status' => $dt['on_be_half_status'],
						// 'approved_by_2' => $dt['approved_by_2'],
						'base' => $base,
						'created_by' => $_SESSION['id'],
						// 'remark' => $dt['remark'],
						'created_at' => DATE('Y-m-d H:i:s'),
						'status' => 'ENABLE',
						'approval_status' => 'PENDING',
						'prepared_time' => DATE('Y-m-d H:i:s'),
					);
					
					$str = $this->mymodel->insertData('approval', $dtt);
				}

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


$id = $this->session->userdata('id');
$user = $this->mymodel->selectDataone('user',array('id'=>$id));
$base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
$base = $base['base'];

if($_SESSION['role_id']=='23'){
	$base = " AND a.origin_base = '$base' ";
}else{
	$base = " ";
}
$origin_base = "";

$duty_instructor = '';
$total = array();
$total2 = array();
$array_model = array();

$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$origin_base = '';
$nomor = 0;

$dat = $this->mymodel->selectWithQuery("SELECT a.id,a.block_time_ata, a.block_time_atd, a.block_time_total,a.remark_report, a.date, CONCAT(h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name
FROM daily_ftd_schedule a
JOIN batch c
ON a.batch = c.id
JOIN course d
ON a.course = d.id
JOIN tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN student_application_form f
ON a.pic = f.id
JOIN student_application_form g
ON a.2nd = g.id
JOIN synthetic_training_devices_document h
ON a.ftd_model = h.id
WHERE  a.visibility_report = '0'
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
AND etd_utc >= '22:00' AND etd_utc <= '24:00'
	"
	.$origin_base.
	"
ORDER BY a.date ASC, a.etd_utc ASC
");

// $body = '';

foreach($dat as $key=>$val){

	
	$nomor++;

	if($val['remark_report']){
	  $total_irregularities = $total_irregularities + 1;
	}
  
	if (strpos($val['block_time_atd'], ':') !== false) {
	  $total_movement = $total_movement + 1;
	}
  
	if(!in_array($val['ftd_model'],$array_model)){
	  array_push($array_model,$val['ftd_model']);
	}
	
	if (strpos($val['block_time_total'], ':') !== false) {
	  array_push($total2,$val['block_time_total']);
	}
	if($val['duty_instructor']){
	  $duty_instructor = $val['duty_instructor'];
	}
	if (strpos($val['eet_utc'], ':') !== false) {
	  array_push($total,$val['eet_utc']);
	}
   
	  $val['pic'] = $val['pic']; 

	$body .= '

		<tr>
		<td>'.($nomor).'</td>

		<td class="text-left">'.$val['ftd_model'].'</td><td class="text-left">'.$val['pic'].'</td><td class="text-left">'.$val['2nd'].'</td><td>'.$val['batch'].'</td>
		<td class="text-left">'.$val['course'].'</td>
	  
		<td class="text-left">'.$val['mission'].'</td>
		<td>'.$val['etd_utc'].'</td><td>'.$val['eta'].'</td>
		<td>'.$val['eet_utc'].'
		<td>'.$val['block_time_atd'].'</td><td>'.$val['block_time_ata'].'</td>
		<td>'.$val['block_time_total'].'
		<td class="text-left">'.$val['remark'].'</td>
		<td >'.$val['remark_report'].'</td>
	  
		</tr>
		';
}

$dat = $this->mymodel->selectWithQuery("SELECT a.id,a.block_time_ata, a.block_time_atd, a.block_time_total,a.remark_report, a.date, CONCAT(h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name
FROM daily_ftd_schedule a
JOIN batch c
ON a.batch = c.id
JOIN course d
ON a.course = d.id
JOIN tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN student_application_form f
ON a.pic = f.id
JOIN student_application_form g
ON a.2nd = g.id
JOIN synthetic_training_devices_document h
ON a.ftd_model = h.id
WHERE  a.visibility_report = '0'
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
AND etd_utc >= '00:00' AND etd_utc <= '21:59'
	"
	.$origin_base.
	"
ORDER BY a.date ASC, a.etd_utc ASC
");

// $body = '';

foreach($dat as $key=>$val){

	
	$nomor++;

	if($val['remark_report']){
	  $total_irregularities = $total_irregularities + 1;
	}
  
	if (strpos($val['block_time_atd'], ':') !== false) {
	  $total_movement = $total_movement + 1;
	}
  
	if(!in_array($val['ftd_model'],$array_model)){
	  array_push($array_model,$val['ftd_model']);
	}
	
	if (strpos($val['block_time_total'], ':') !== false) {
	  array_push($total2,$val['block_time_total']);
	}
	if($val['duty_instructor']){
	  $duty_instructor = $val['duty_instructor'];
	}
	if (strpos($val['eet_utc'], ':') !== false) {
	  array_push($total,$val['eet_utc']);
	}
   
	  $val['pic'] = $val['pic']; 

	$body .= '

		<tr>
		<td>'.($nomor).'</td>

		<td class="text-left">'.$val['ftd_model'].'</td><td class="text-left">'.$val['pic'].'</td><td class="text-left">'.$val['2nd'].'</td><td>'.$val['batch'].'</td>
		<td class="text-left">'.$val['course'].'</td>
	  
		<td class="text-left">'.$val['mission'].'</td>
		<td>'.$val['etd_utc'].'</td><td>'.$val['eta'].'</td>
		<td>'.$val['eet_utc'].'
		<td>'.$val['block_time_atd'].'</td><td>'.$val['block_time_ata'].'</td>
		<td>'.$val['block_time_total'].'
		<td class="text-left">'.$val['remark'].'</td>
		<td >'.$val['remark_report'].'</td>
	  
		</tr>
		';
}


$total =  $this->template->sum_time($total);
$total2 =  $this->template->sum_time($total2);

// print_r($array_model);
$total_plan = $total;
$total_block_time = $total2;
$total_ftd = count($array_model);
$total_flight = $nomor;

$table = '';
$table = '<table style="width: 100%;
border-collapse: collapse;">'.$header.''.$body.'</table>';



  $total_plan2 = (explode(":",$total_plan));
  $total_block_time2 = (explode(":",$total_block_time));

  $jam_plan = $total_plan2[0] * 60;
  $jam_plan = $jam_plan + $total_plan2[1];

  $jam_block_time = $total_block_time2[0] * 60;
  $jam_block_time = $jam_block_time + $total_block_time2[1];

  $persentase = number_format(($jam_block_time/$jam_plan)*100,1).' %';



$table .= '<br><p>TOTAL FTD SCHEDULE : '.$total_flight.'</p>
<p>TOTAL FTD ACTIVITY : '.intval($total_movement).'</p>
<p>TOTAL IRREGULARITIES : '.intval($total_irregularities).'</p>

<p>TOTAL PLAN : '.$total_plan.'</p>
<p>TOTAL BLOCK TIME : '.$total_block_time.'</p>
<p>ACTUAL vs PLAN : '.$persentase.'</p>
';
		


		$type = 'FTD_REPORT';
		$date = $_SESSION['start_date'];
		$base = $_SESSION['origin_base'];
		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base' AND approved_by > 0
		LIMIT 1");

		$approval = $approval[0];
		
		if($approval){
			$this->mymodel->updateData('approval', array('prepared_time'=>DATE('Y-m-d H:i:s')) , array('id'=>$approval['id']));
			// $app[0] = $approval['prepared_by'];
			$app = array();
			$app[0] = $approval['approved_by'];
			// $app[1] = $approval['approved_by_2'];
			foreach($app as $key=>$val){
			$instructor = $this->mymodel->selectDataOne('user', array('id'=>$val));
			
			if (strpos($instructor['email'], '@') !== false) {

				$button_link = base_url().'approval/approve_report/'.$approval['id'].'/'.$instructor['id'];
				$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
				$instructor['role'] = $instructor['role']['role'];

			


				$to_email = $instructor['email'];
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers. From is required, rest other headers are optional
				$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
				$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
				$subject = 'Propose For Approval Daily FTD Report '.$location.' '.DATE('d M Y', strtotime($_SESSION['start_date']));
				
				$instructor['body_email'] = '
				<div style="text-align:left">
				Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
				'.$instructor['role'].'
				<br><br>
				Please approve daily ftd report for <b><u>'.$location.' '.DATE('d M Y', strtotime($_SESSION['start_date'])).'</u></b>
				<br><br>
				'.$table.'
				<br></br>
				<a class="btn" href="'.$button_link.'" style="padding:10px;
				color:#fff;
				text-decoration: none;
				text-align: left;
				border-radius: 12px;
				backFTD: #066265;
				box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">Approve And Submit</a>
				<br></br><br></br>
				Thank you!
				<br><br><br><br><br>
				<div>
				';
				$body = $this->mymodel->body_email($instructor);
	// die;
				if (mail($to_email, $subject, $body, $headers)) {
					echo 'Success';
				}else{
					echo 'Failed';
				}	
			}
		}
	}
		// die;

		redirect(base_url().'master/daily_ftd_report');
	}


	function submit2(){

		$data = $this->mymodel->selectWithQuery("SELECT pic, COUNT(id) as count FROM daily_ftd_schedule WHERE visibility = '0' GROUP BY pic"); 
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
				$subject = 'Daily FTD Schedule '.DATE('d M Y');
				$body = $this->mymodel->body_email($instructor);
	// die;
				if (mail($to_email, $subject, $body, $headers)) {
					// echo 'Success';
				}else{
					// echo 'Failed';
				}	
			}
		}

		$this->db->query("UPDATE daily_ftd_schedule SET visibility = '1' WHERE visibility = '0'");
		redirect(base_url().'master/daily_ftd_schedule');
	}

	public function index()

	{

		
		$_SESSION['create'] = '';
		
		$data['page_name'] = "daily_ftd_schedule";

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


		$this->template->load('template/template','master/daily_ftd_schedule/all-daily_ftd_schedule',$data);

	}

	function filter(){
		$_SESSION['start_date'] = $_POST['start_date'];
		$_SESSION['end_date'] = $_POST['end_date'];
		$_SESSION['origin_base'] = $_POST['origin_base'];
		$_SESSION['batch'] = $_POST['batch'];
		redirect(base_url().'master/daily_ftd_schedule');
	}

	function filter_create(){
		$_SESSION['start_date'] = $_POST['start_date'];
		$_SESSION['end_date'] = $_POST['start_date'];
		$_SESSION['origin_base'] = $_POST['origin_base'];
		$_SESSION['batch'] = $_POST['batch'];
		redirect(base_url().'master/daily_ftd_schedule/create');
	}


	public function create()

	{

		$_SESSION['create'] = 'create';

		$data['page_name'] = "daily_ftd_schedule";

		
		$this->template->load('template/template','master/daily_ftd_schedule/add-daily_ftd_schedule',$data);

	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

$this->form_validation->set_rules('dt[date]', '<strong>Date</strong>', 'required');
$this->form_validation->set_rules('dt[origin_base]', '<strong>Base</strong>', 'required');
// $this->form_validation->set_rules('dt[manufacture]', '<strong>Manufacture</strong>', 'required');
$this->form_validation->set_rules('dt[ftd_model]', '<strong>Ftd Model</strong>', 'required');
$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
$this->form_validation->set_rules('dt[pic]', '<strong>Pic</strong>', 'required');
$this->form_validation->set_rules('dt[2nd]', '<strong>2nd</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
$this->form_validation->set_rules('dt[mission]', '<strong>Mission</strong>', 'required');
$this->form_validation->set_rules('dt[eet_utc]', '<strong>Eet Utc</strong>', 'required');
$this->form_validation->set_rules('dt[etd_utc]', '<strong>Etd Utc</strong>', 'required');
$this->form_validation->set_rules('dt[eta]', '<strong>Eta</strong>', 'required');
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

			$str = $this->mymodel->insertData('daily_ftd_schedule', $dt);

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

								   'table'=> 'daily_ftd_schedule',

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

							   'table'=> 'daily_ftd_schedule',

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


		$origin_base = " ";

		$this->datatables->select('a.id,a.date,CONCAT(h.model,"<br>",h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name,');

		$this->datatables->where("DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1'
		"
		.$origin_base
		
		.$batch.
		"");


		$this->datatables->from('daily_ftd_schedule a');
		
		// $this->datatables->join('aircraft_document b','a.aircraft_reg = b.id');
		
		$this->datatables->join('batch c','a.batch = c.id');
		
		$this->datatables->join('course d','a.course = d.id','LEFT');
		
		$this->datatables->join('tpm_syllabus_all_course e','a.mission = e.id','LEFT');
		
		$this->datatables->join('student_application_form f','a.pic = f.id','LEFT');
		
		$this->datatables->join('student_application_form g','a.2nd = g.id','LEFT');
		
		$this->datatables->join('synthetic_training_devices_document h','a.ftd_model = h.id','LEFT');

		$this->db->order_by("a.date ASC, a.eet_utc ASC");

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

		$data['daily_ftd_schedule'] = $this->mymodel->selectDataone('daily_ftd_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));$data['page_name'] = "daily_ftd_schedule";

		$this->template->load('template/template','master/daily_ftd_schedule/edit-daily_ftd_schedule',$data);

	}
	
	public function preview($id)

	{

		$data['daily_ftd_schedule'] = $this->mymodel->selectDataone('daily_ftd_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));$data['page_name'] = "daily_ftd_schedule";

		$this->template->load('template/template','master/daily_ftd_schedule/preview-daily_ftd_schedule',$data);

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

								   'table'=> 'daily_ftd_schedule',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);

					$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));

					@unlink($file['dir']);

					if($file==""){

						$this->mymodel->insertData('file', $data);

					}else{

						$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

					}

					



					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str =  $this->mymodel->updateData('daily_ftd_schedule', $dt , array('id'=>$id));

					return $str;  


				}

			}else{

				$dt = $_POST['dt'];

				

				$dt['updated_at'] = date("Y-m-d H:i:s");

				$str = $this->mymodel->updateData('daily_ftd_schedule', $dt , array('id'=>$id));

				return $str;  

			}}

	}



	public function delete()

	{

			$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));

			@unlink($file['dir']);

			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_ftd_schedule'));



			$str = $this->mymodel->deleteData('daily_ftd_schedule',  array('id'=>$id));
			return $str;
			


	}


	
	public function delete_data($id)

	{

			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_ftd_schedule'));

			@unlink($file['dir']);

			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_ftd_schedule'));



			$str = $this->mymodel->deleteData('daily_ftd_schedule',  array('id'=>$id));
			redirect(base_url().'master/daily_ftd_schedule/create');
			


	}



	public function status($id,$status)

	{

		$this->mymodel->updateData('daily_ftd_schedule',array('status'=>$status),array('id'=>$id));


		redirect('master/Daily_ftd_schedule');

	}





}

?>