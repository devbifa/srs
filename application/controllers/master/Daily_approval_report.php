

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Daily_approval_report extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

	}

	function send_email(){

				$to_email = 'amuammarzein@gmail.com';
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				// More headers. From is required, rest other headers are optional
				$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
				$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
				$subject = 'Hello '.DATE('d M Y');
				$body = 'hello';
	// die;
				if (mail($to_email, $subject, $body, $headers)) {
					echo 'Success';
				}else{
					echo 'Failed';
				}	
		
		// die;
		
	}

	
	function body_email($val){
		$val['role'] = $this->mymodel->selectDataOne('role',array('id'=>$val['role_id']));
		$val['role'] = $val['role']['role'];
		$text = '<!doctype html>
		<html>
		  <head>
			<meta name="viewport" content="width=device-width">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Daily Flight Schedule</title>
			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
			<style>
			body,*{
				font-family: "Poppins", sans-serif;
				text-align: center;
				font-size:15px;
			}
			</style>
		  </head>
		  <body class="" style="background-color: #f6f6f6; font-family: "Poppins", sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
		  <div style="text-align:left">
		  Hi '.ucwords(strtolower($val['name'])).' ('.$val['nip'].')<br>
		  '.$val['role'].'
		  <br><br>
		  The following is your flight schedule for '.DATE('d M Y').'
		  <br><br>
		  <a class="btn" href="'.base_url().'menu/my_schedule" style="padding:10px;
		  color:#fff;
		  text-decoration: none;
		  text-align: left;
		  border-radius: 12px;
		  background: #066265;
		  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">Show My Schedule</a>
		  <br></br><br></br>
		  Good luck!
		  <br><br><br><br><br>
		  <div>
		  BIFA,Bali International Flight Academy. PT.Bali Widya Dirgantara
		  <br>
		  Sovereign Plaza 11th Floor Jl. T.B. Simatupang kav.36 Jakarta 12430, Indonesia
		  <br>
		  info@baliflightacademy.com | 021 29400123 	
		  <br>
		  Build with <a href="https://karyastudio.com">Karya Studio Teknologi Digital</a> on '.DATE('d M Y H:i:s').'
		  </body>
		</html>';
		return $text;
	}


	function body_email_student($val){
		$val['role'] = $this->mymodel->selectDataOne('role',array('id'=>$val['role_id']));
		$val['role'] = $val['role']['role'];
		$text = '<!doctype html>
		<html>
		  <head>
			<meta name="viewport" content="width=device-width">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Daily Flight Schedule</title>
			<link rel="preconnect" href="https://fonts.gstatic.com">
			<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
			<style>
			body,*{
				font-family: "Poppins", sans-serif;
				text-align: center;
				font-size:15px;
			}
			</style>
		  </head>
		  <body class="" style="background-color: #f6f6f6; font-family: "Poppins", sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
		  <div style="text-align:left">
		  Hi '.ucwords(strtolower($val['full_name'])).' ('.$val['id_number'].')<br>
		  '.$val['role'].'
		  <br><br>
						
			Here is your flight schedule for '.DATE('d M Y').'
		  <br><br>
		  <a class="btn" href="'.base_url().'menu/my_schedule" style="padding:10px;
		  color:#fff;
		  text-decoration: none;
		  text-align: left;
		  border-radius: 12px;
		  background: #066265;
		  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">Show My Schedule</a>
		  <br></br><br></br>
		  Good luck!
		  <br><br><br><br><br>
		  <div>
		  BIFA,Bali International Flight Academy. PT.Bali Widya Dirgantara
		  <br>
		  Sovereign Plaza 11th Floor Jl. T.B. Simatupang kav.36 Jakarta 12430, Indonesia
		  <br>
		  info@baliflightacademy.com | 021 29400123 	
		  <br>
		  Build with <a href="https://karyastudio.com">Karya Studio Teknologi Digital</a> on '.DATE('d M Y H:i:s').'
		  </body>
		</html>';
		return $text;
	}


	public function index()

	{

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
	
		$id_instructor = $_SESSION['id_instructor'];
	

		$data['page_name'] = "Flight_schedule";

	
	
		$this->template->load('template/template','master/daily_approval_report/all',$data);

	}

	function filter(){
		$_SESSION['start_date'] = $_POST['start_date'];
		$_SESSION['end_date'] = $_POST['end_date'];
		$_SESSION['origin_base'] = $_POST['origin_base'];
		$_SESSION['batch'] = $_POST['batch'];
		redirect(base_url().'master/daily_approval_report');
	}

	function approve($id){
		$url = "http://localhost:1996/bifa/master/daily_approval/approve/$id";
		$this->template->curl_url($url);
		redirect(base_url().'master/daily_approval_report');
	}
	function approve_report($id){
		$url = "http://localhost:1996/bifa/master/daily_approval/approve_report/$id";
		$this->template->curl_url($url);
		redirect(base_url().'master/daily_approval_report');
	}

	public function approve_last($id){

		$id_approval = $id;
		$id_user = $_SESSION['id'];
		$approval = $this->mymodel->selectDataOne('approval', array('id'=>$id_approval));
        if($approval){
            $dt['approval_status'] = 'APPROVED';
			$id_user = $approval['approved_by'];
			$dt['updated_at'] = DATE('Y-m-d H:i:s');
			$dt['approved_time'] = DATE('Y-m-d H:i:s');
        }

		$this->mymodel->updateData('approval', $dt , array('id'=>$approval['id']));
		
	
        $approval = $this->mymodel->selectDataOne('approval',array('id'=>$id_approval));

			if($approval['type']=='FLIGHT'){
                $type_subject = 'Flight';
				$date = $approval['date'];
				$date = " AND DATE(date_of_flight) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
				// $this->db->query("UPDATE daily_flight_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
                $file = $this->print_flight_schedule($approval);
            }else if($approval['type']=='FTD'){
                $type_subject = 'FTD';
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
				// $this->db->query("UPDATE daily_ftd_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
                $file = $this->print_ftd_schedule($approval);
            }else if($approval['type']=='GROUND'){
              
                $type_subject = 'Ground'; 
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
				LEFT JOIN base_airport_document b
				ON a.station = b.id
				WHERE base = '$base'");
				foreach($dat as $key=>$val){
					$text .= "'".$val['id']."',"; 
				}
				$text = substr($text,0,-1);
				$base = " AND classroom  IN ($text) ";
				// $this->db->query("UPDATE daily_ground_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
                $file = $this->print_ground_schedule($approval);
            }
            
            $instructor = $this->mymodel->selectDataOne('user', array('id'=>$id_user));

            $location = $approval['base'];
            $date = $approval['date'];
            if (strpos($instructor['email'], '@') !== false) {

                // $button_link = base_url().'approval/approve/'.$approval['id'].'/'.$instructor['id'];
                $button_link = "";
                $instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
                $instructor['role'] = $instructor['role']['role'];

            

                $to_email = $instructor['email'];
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers. From is required, rest other headers are optional
                $headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
                $headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
               
                $subject = 'Propose For Approval Daily '.$type_subject.' Schedule '.$location.' '.DATE('d M Y', strtotime($date));
                
                $instructor['body_email'] = '
                <div style="text-align:left">
                Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
                '.$instructor['role'].'
                <br><br>
                You have done schedule approval for <b><u>'.$location.' '.DATE('d M Y', strtotime($date)).'</u></b>
      
                <br></br><br></br>
                Thank you!
                <br><br><br><br><br>
                <div>
                ';
                $body = $this->mymodel->body_email($instructor);
    // die;
                // if (mail($to_email, $subject, $body, $headers)) {
                //     echo 'Success';
                // }else{
                //     echo 'Failed';
                // }	

                $this->load->library('email');
           
                $result = $this->email
                ->from('karyastudioteknologidigital@gmail.com', 'Bali International Flight Academy')
                ->cc('amuammarzein@gmail.com')    // Optional, an account where a human being reads.
                ->to($to_email)
                ->subject($subject)
                ->message($body)
                ->attach($file)
                ->send();

                print_r($result);
			}
			

			$approval = $this->mymodel->selectDataOne('approval',array('id'=>$id_approval));

			$location = $approval['base'];
			$app_date = $approval['date'];
			$app_base = $approval['base'];
	

			$button_link_student = 'http://to.baliflightacademy.com:7329/bifa-student/menu/my_schedule';
			$button_link_instructor = 'http://to.baliflightacademy.com:7329/bifa/menu/my_schedule';

			if($approval['type']=='FLIGHT'){
				$date = $approval['date'];
				$date = " AND DATE(date_of_flight) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
		
		
		$approved = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		$approved_role = $this->mymodel->selectDataOne('role',array('id'=>$approved['role_id']));
 
		$instructor = $this->mymodel->selectDataOne('user',array('id'=>$approval['prepared_by']));
	
		if (strpos($instructor['email'], '@') !== false) {
			$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
			$instructor['role'] = $instructor['role']['role'];
		
			$to_email = $instructor['email'];
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers. From is required, rest other headers are optional
			$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
			$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
			$subject = 'Your Daily Flight Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date));
			
			$button_link = base_url().'menu/my_schedule';
	
			$instructor['body_email'] = '
			<div style="text-align:left">
			Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
			'.$instructor['role'].'
			<br><br>
			Your Daily Flight Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
			<br><br>
			'.$table.'
			<br></br>
			<a class="btn" href="'.$button_link.'" style="padding:10px;
			color:#fff;
			text-decoration: none;
			text-align: left;
			border-radius: 12px;
			background: #066265;
			box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Approval</a>
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
		}else{
			
		}
	
	
		
	
				$schedule = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule WHERE visibility = '0' ".$base.$date);
				$array_instructor = array();
				$array_student = array();
				$button_link_student = 'http://to.baliflightacademy.com:7329/bifa-student/menu/my_schedule';
				$button_link_instructor = base_url().'menu/my_schedule';
				
				foreach($schedule as $k=>$v){
					
					$id_schedule = $v['id'];
						
					$pic = $v['pic'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
				
					
					$pic = $v['2nd'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
				
					
	
				}
				$list_instructor = substr($list_instructor,0,-1);
				$list_student = substr($list_student,0,-1);
				
				if (strpos($list_instructor, '@') !== false) {
				
					$to_email = $list_instructor;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Instructor Daily Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your instructor daily flight schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_instructor.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				if (strpos($list_student, '@') !== false) {
				
					$to_email = $list_student;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Student Daily Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your student daily flight schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_student.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				$date = $approval['date'];
				$date = " AND DATE(date_of_flight) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
				$this->db->query("UPDATE daily_flight_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
			}else if($approval['type']=='FTD'){
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
	
	
				
				$header = '
				<tr class="bg-success">
					<th style="width:20px">NUM</th>
					<th style="width:120px;">FTD MODEL</th><th>INSTRUCTOR</th><th>STUDENT</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>ETD <br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>
					</tr>
			';
				
	
		$approved = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		$approved_role = $this->mymodel->selectDataOne('role',array('id'=>$approved['role_id']));
	
		$instructor = $this->mymodel->selectDataOne('user',array('id'=>$approval['prepared_by']));
	
		if (strpos($instructor['email'], '@') !== false) {
			$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
			$instructor['role'] = $instructor['role']['role'];
		
			$to_email = $instructor['email'];
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers. From is required, rest other headers are optional
			$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
			$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
			$subject = 'Your Daily FTD Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date));
			
			$button_link = base_url().'menu/my_schedule';
	
			$instructor['body_email'] = '
			<div style="text-align:left">
			Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
			'.$instructor['role'].'
			<br><br>
			Your Daily FTD Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
			<br><br>
			'.$table.'
			<br></br>
			<a class="btn" href="'.$button_link.'" style="padding:10px;
			color:#fff;
			text-decoration: none;
			text-align: left;
			border-radius: 12px;
			background: #066265;
			box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Approval</a>
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
		}else{
			
		}
	
		
	
				$schedule = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule WHERE visibility = '0' ".$base.$date);
				
					$array_instructor = array();
				$array_student = array();
				$button_link_student = 'http://to.baliflightacademy.com:7329/bifa-student/menu/my_schedule';
				$button_link_instructor = base_url().'menu/my_schedule';
				
				foreach($schedule as $k=>$v){
					
					$id_schedule = $v['id'];
						
					$pic = $v['pic'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
				
					
					$pic = $v['2nd'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
					
	
				}
				$list_instructor = substr($list_instructor,0,-1);
				$list_student = substr($list_student,0,-1);
				
				if (strpos($list_instructor, '@') !== false) {
				
					$to_email = $list_instructor;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Instructor Daily FTD Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your instructor daily ftd schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_instructor.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				if (strpos($list_student, '@') !== false) {
				
					$to_email = $list_student;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Student Daily FTD Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your student daily ftd schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_student.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				
$date = $approval['date'];
$date = " AND DATE(date) = '$date' ";
$base = $approval['base'];
$base = " AND origin_base = '$base' ";
$this->db->query("UPDATE daily_ftd_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
			}else if($approval['type']=='GROUND'){
				
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
	
	
				
				$button_link_student = 'http://to.baliflightacademy.com:7329/bifa-student/menu/my_schedule';
				$button_link_instructor = base_url().'menu/my_schedule';
	
		$approved = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		$approved_role = $this->mymodel->selectDataOne('role',array('id'=>$approved['role_id']));
	
		$instructor = $this->mymodel->selectDataOne('user',array('id'=>$approval['prepared_by']));
	
		
		
				$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
					LEFT JOIN base_airport_document b
					ON a.station = b.id
					WHERE base = '$app_base'");
					foreach($dat as $key=>$val){
						$text .= "'".$val['id']."',"; 
					}
					$text = substr($text,0,-1);
					$base = " AND a.classroom  IN ($text) ";
	
	
				$schedule = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule a WHERE a.visibility = '0' ".$base.$date);

				$array_instructor = array();
				$array_student = array();
				foreach($schedule as $k=>$v){
					
					$id_schedule = $v['id'];
	
					$pic = $v['instructor'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}

					$student_list = json_decode($v['student'],true);
					foreach($student_list as $k2=>$v2){
						$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$v2['val']));
						if($pic['instructor_status'] != '1'){
							if(!in_array($pic,$array_student)){
								array_push($array_student,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_student = $list_student."".$pic['email'].",";
								}
							}
						}else{
							if(!in_array($pic,$array_instructor)){
								array_push($array_instructor,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_instructor = $list_instructor."".$pic['email'].",";
								}
							}
						}
					}

					$student_other = json_decode($v['student_other'],true);
					foreach($student_other as $k2=>$v2){
						$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$v2['id_number']));

						if($pic['instructor_status'] != '1'){
							if(!in_array($pic,$array_student)){
								array_push($array_student,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_student = $list_student."".$pic['email'].",";
								}
							}
						}else{
							if(!in_array($pic,$array_instructor)){
								array_push($array_instructor,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_instructor = $list_instructor."".$pic['email'].",";
								}
							}
						}
						
					}
				

	
				}
				
				
	
				$list_instructor = substr($list_instructor,0,-1);
				$list_student = substr($list_student,0,-1);
				

				if (strpos($list_instructor, '@') !== false) {
				
					$to_email = $list_instructor;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Instructor Ground Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your instructor daily ground schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_instructor.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				if (strpos($list_student, '@') !== false) {
				
					$to_email = $list_student;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Student Ground Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your student ground flight schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_student.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				// die;
				
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
				LEFT JOIN base_airport_document b
				ON a.station = b.id
				WHERE base = '$base'");
				foreach($dat as $key=>$val){
					$text .= "'".$val['id']."',"; 
				}
				$text = substr($text,0,-1);
				$base = " AND classroom  IN ($text) ";
				$this->db->query("UPDATE daily_ground_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
			}
		
		
        redirect(base_url().'master/daily_approval_report');
    }

	public function rollback($id){
		$dtt = array(
			'approval_status' => 'PENDING',
			'updated_at' => DATE('Y-m-d H:i:s'),
		);

		$str = $this->mymodel->updateData('approval', $dtt , array('id'=>$id));

		$approval = $this->mymodel->selectDataOne('approval',array('id'=>$id));
			
		if($approval['type']=='FLIGHT'){
			$date = $approval['date'];
			$date = " AND DATE(date_of_flight) = '$date' ";
			$base = $approval['base'];
			$base = " AND origin_base = '$base' ";
			$this->db->query("UPDATE daily_flight_schedule SET visibility = '0' WHERE visibility = '1' ".$base.$date);
		}else if($approval['type']=='FTD'){
			$date = $approval['date'];
			$date = " AND DATE(date) = '$date' ";
			$base = $approval['base'];
			$base = " AND origin_base = '$base' ";
			$this->db->query("UPDATE daily_ftd_schedule SET visibility = '0' WHERE visibility = '1' ".$base.$date);
		}else if($approval['type']=='GROUND'){
			$date = $approval['date'];
			$date = " AND DATE(date) = '$date' ";
			$base = $approval['base'];
			$dat = $this->mymodel->selectWithQuery("SELECT a.code FROM classroom a
			LEFT JOIN base_airport_document b
			ON a.station = b.id
			WHERE station = '$base'");
			foreach($dat as $key=>$val){
				$text .= "'".$val['code']."',"; 
			}
			$text = substr($text,0,-1);
			$base = " AND classroom  IN ($text) ";
		
		$base = " AND classroom  IN ($text) ";
			$this->db->query("UPDATE daily_ground_schedule SET visibility = '0' WHERE visibility = '1' ".$base.$date);
		}

		redirect(base_url().'master/daily_approval_report');
	}

	public function rollback_report($id){
		$dtt = array(
			'approval_status' => 'PENDING',
			'updated_at' => DATE('Y-m-d H:i:s'),
		);

		$str = $this->mymodel->updateData('approval', $dtt , array('id'=>$id));

		$approval = $this->mymodel->selectDataOne('approval',array('id'=>$id));
			
		if($approval['type']=='FLIGHT REPORT'){
			$date = $approval['date'];
			$date = " AND DATE(date_of_flight) = '$date' ";
			$base = $approval['base'];
			$base = " AND origin_base = '$base' ";
			$this->db->query("UPDATE daily_flight_schedule SET visibility_report = '0' WHERE visibility_report = '1' ".$base.$date);
		}else if($approval['type']=='FTD REPORT'){
			$date = $approval['date'];
			$date = " AND DATE(date) = '$date' ";
			$base = $approval['base'];
			$base = " AND origin_base = '$base' ";
			$this->db->query("UPDATE daily_ftd_schedule SET visibility_report = '0' WHERE visibility_report = '1' ".$base.$date);
		}else if($approval['type']=='GROUND REPORT'){
			$date = $approval['date'];
			$date = " AND DATE(date) = '$date' ";
			$base = $approval['base'];
				$dat = $this->mymodel->selectWithQuery("SELECT a.code FROM classroom a
				LEFT JOIN base_airport_document b
				ON a.station = b.id
				WHERE station = '$base'");
				foreach($dat as $key=>$val){
					$text .= "'".$val['code']."',"; 
				}
				$text = substr($text,0,-1);
				$base = " AND classroom  IN ($text) ";
			
			$base = " AND classroom  IN ($text) ";
			$this->db->query("UPDATE daily_ground_schedule SET visibility_report = '0' WHERE visibility_report = '1' ".$base.$date);
		}

		redirect(base_url().'master/daily_approval_report');
	}

	function approve_2($id){
		$url = "http://localhost:1996/bifa/master/daily_approval/approve_2/$id";
		$this->template->curl_url($url);
		redirect(base_url().'master/daily_approval_report');
	}


	public function approve_2_last($id){
		
		$id_approval = $id;
		$id_user = $_SESSION['id'];
		$approval = $this->mymodel->selectDataOne('approval', array('id'=>$id_approval));
        if($approval){
            $dt['approval_status_2'] = 'APPROVED';
			$id_user = $approval['approved_by_ 2'];
			$dt['updated_at'] = DATE('Y-m-d H:i:s');
			$dt['approved_2_time'] = DATE('Y-m-d H:i:s');
        }

        $this->mymodel->updateData('approval', $dt , array('id'=>$approval['id']));
        
        $approval = $this->mymodel->selectDataOne('approval',array('id'=>$id_approval));

			if($approval['type']=='FLIGHT'){
                $type_subject = 'Flight';
				$date = $approval['date'];
				$date = " AND DATE(date_of_flight) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
				// $this->db->query("UPDATE daily_flight_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
                $file = $this->print_flight_schedule($approval);
            }else if($approval['type']=='FTD'){
                $type_subject = 'FTD';
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
				// $this->db->query("UPDATE daily_ftd_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
                $file = $this->print_ftd_schedule($approval);
            }else if($approval['type']=='GROUND'){
              
                $type_subject = 'Ground'; 
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
				LEFT JOIN base_airport_document b
				ON a.station = b.id
				WHERE base = '$base'");
				foreach($dat as $key=>$val){
					$text .= "'".$val['id']."',"; 
				}
				$text = substr($text,0,-1);
				$base = " AND classroom  IN ($text) ";
				// $this->db->query("UPDATE daily_ground_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
                $file = $this->print_ground_schedule($approval);
            }
            
            $instructor = $this->mymodel->selectDataOne('user', array('id'=>$id_user));

            $location = $approval['base'];
            $date = $approval['date'];
            if (strpos($instructor['email'], '@') !== false) {

                // $button_link = base_url().'approval/approve/'.$approval['id'].'/'.$instructor['id'];
                $button_link = "";
                $instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
                $instructor['role'] = $instructor['role']['role'];

            

                $to_email = $instructor['email'];
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                // More headers. From is required, rest other headers are optional
                $headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
                $headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
               
                $subject = 'Propose For Approval Daily '.$type_subject.' Schedule '.$location.' '.DATE('d M Y', strtotime($date));
                
                $instructor['body_email'] = '
                <div style="text-align:left">
                Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
                '.$instructor['role'].'
                <br><br>
                You have done schedule approval for <b><u>'.$location.' '.DATE('d M Y', strtotime($date)).'</u></b>
      
                <br></br><br></br>
                Thank you!
                <br><br><br><br><br>
                <div>
                ';
                $body = $this->mymodel->body_email($instructor);
    // die;
                // if (mail($to_email, $subject, $body, $headers)) {
                //     echo 'Success';
                // }else{
                //     echo 'Failed';
                // }	

                $this->load->library('email');
           
                $result = $this->email
                ->from('karyastudioteknologidigital@gmail.com', 'Bali International Flight Academy')
                ->cc('amuammarzein@gmail.com')    // Optional, an account where a human being reads.
                ->to($to_email)
                ->subject($subject)
                ->message($body)
                ->attach($file)
                ->send();

                print_r($result);
			}
			

			$approval = $this->mymodel->selectDataOne('approval',array('id'=>$id_approval));

			$location = $approval['base'];
			$app_date = $approval['date'];
			$app_base = $approval['base'];
	


			if($approval['type']=='FLIGHT'){
				$date = $approval['date'];
				$date = " AND DATE(date_of_flight) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
		
		
		$approved = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		$approved_role = $this->mymodel->selectDataOne('role',array('id'=>$approved['role_id']));
 
		$instructor = $this->mymodel->selectDataOne('user',array('id'=>$approval['prepared_by']));
	
		if (strpos($instructor['email'], '@') !== false) {
			$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
			$instructor['role'] = $instructor['role']['role'];
		
			$to_email = $instructor['email'];
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers. From is required, rest other headers are optional
			$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
			$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
			$subject = 'Your Daily Flight Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date));
			
			$button_link = base_url().'menu/my_schedule';
	
			$instructor['body_email'] = '
			<div style="text-align:left">
			Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
			'.$instructor['role'].'
			<br><br>
			Your Daily Flight Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
			<br><br>
			'.$table.'
			<br></br>
			<a class="btn" href="'.$button_link.'" style="padding:10px;
			color:#fff;
			text-decoration: none;
			text-align: left;
			border-radius: 12px;
			background: #066265;
			box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Approval</a>
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
		}else{
			
		}
	
	
		
	
				$schedule = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule WHERE visibility = '0' ".$base.$date);
				$array_instructor = array();
				$array_student = array();
				$button_link_student = 'http://to.baliflightacademy.com:7329/bifa-student/menu/my_schedule';
				$button_link_instructor = base_url().'menu/my_schedule';
				
				foreach($schedule as $k=>$v){
					
					$id_schedule = $v['id'];
						
					$pic = $v['pic'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
				
					
					$pic = $v['2nd'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
				
					
	
				}
				$list_instructor = substr($list_instructor,0,-1);
				$list_student = substr($list_student,0,-1);
				
				if (strpos($list_instructor, '@') !== false) {
				
					$to_email = $list_instructor;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Instructor Daily Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your instructor daily flight schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_instructor.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				if (strpos($list_student, '@') !== false) {
				
					$to_email = $list_student;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Student Daily Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your student daily flight schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_student.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				$date = $approval['date'];
				$date = " AND DATE(date_of_flight) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
				$this->db->query("UPDATE daily_flight_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
			}else if($approval['type']=='FTD'){
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
	
	
				
				$header = '
				<tr class="bg-success">
					<th style="width:20px">NUM</th>
					<th style="width:120px;">FTD MODEL</th><th>INSTRUCTOR</th><th>STUDENT</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>ETD <br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>
					</tr>
			';
				
	
		$approved = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		$approved_role = $this->mymodel->selectDataOne('role',array('id'=>$approved['role_id']));
	
		$instructor = $this->mymodel->selectDataOne('user',array('id'=>$approval['prepared_by']));
	
		if (strpos($instructor['email'], '@') !== false) {
			$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
			$instructor['role'] = $instructor['role']['role'];
		
			$to_email = $instructor['email'];
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			// More headers. From is required, rest other headers are optional
			$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
			$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
			$subject = 'Your Daily FTD Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date));
			
			$button_link = base_url().'menu/my_schedule';
	
			$instructor['body_email'] = '
			<div style="text-align:left">
			Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
			'.$instructor['role'].'
			<br><br>
			Your Daily FTD Schedule Propose Approved By '.$approved['name'].' ('.$approved_role['role'].') '.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
			<br><br>
			'.$table.'
			<br></br>
			<a class="btn" href="'.$button_link.'" style="padding:10px;
			color:#fff;
			text-decoration: none;
			text-align: left;
			border-radius: 12px;
			background: #066265;
			box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Approval</a>
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
		}else{
			
		}
	
		
	
				$schedule = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule WHERE visibility = '0' ".$base.$date);
				
					$array_instructor = array();
				$array_student = array();
				$button_link_student = 'http://to.baliflightacademy.com:7329/bifa-student/menu/my_schedule';
				$button_link_instructor = base_url().'menu/my_schedule';
				
				foreach($schedule as $k=>$v){
					
					$id_schedule = $v['id'];
						
					$pic = $v['pic'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
				
					
					$pic = $v['2nd'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}
					
	
				}
				$list_instructor = substr($list_instructor,0,-1);
				$list_student = substr($list_student,0,-1);
				
				if (strpos($list_instructor, '@') !== false) {
				
					$to_email = $list_instructor;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Instructor Daily FTD Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your instructor daily ftd schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_instructor.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				if (strpos($list_student, '@') !== false) {
				
					$to_email = $list_student;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Student Daily FTD Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your student daily ftd schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_student.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				
$date = $approval['date'];
$date = " AND DATE(date) = '$date' ";
$base = $approval['base'];
$base = " AND origin_base = '$base' ";
$this->db->query("UPDATE daily_ftd_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
			}else if($approval['type']=='GROUND'){
				
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$base = " AND origin_base = '$base' ";
	
	
				
				$button_link_student = 'http://to.baliflightacademy.com:7329/bifa-student/menu/my_schedule';
				$button_link_instructor = base_url().'menu/my_schedule';
	
		$approved = $this->mymodel->selectDataOne('user',array('id'=>$id_user));
		$approved_role = $this->mymodel->selectDataOne('role',array('id'=>$approved['role_id']));
	
		$instructor = $this->mymodel->selectDataOne('user',array('id'=>$approval['prepared_by']));
	
		
		
				$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
					LEFT JOIN base_airport_document b
					ON a.station = b.id
					WHERE base = '$app_base'");
					foreach($dat as $key=>$val){
						$text .= "'".$val['id']."',"; 
					}
					$text = substr($text,0,-1);
					$base = " AND a.classroom  IN ($text) ";
	
	
				$schedule = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule a WHERE a.visibility = '0' ".$base.$date);

				$array_instructor = array();
				$array_student = array();
				foreach($schedule as $k=>$v){
					
					$id_schedule = $v['id'];
	
					$pic = $v['instructor'];
					$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$pic));
					if($pic['instructor_status'] != '1'){
						if(!in_array($pic,$array_student)){
							array_push($array_student,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_student = $list_student."".$pic['email'].",";
							}
						}
					}else{
						if(!in_array($pic,$array_instructor)){
							array_push($array_instructor,$pic);
							if (strpos($pic['email'], '@') !== false) {
								$list_instructor = $list_instructor."".$pic['email'].",";
							}
						}
					}

					$student_list = json_decode($v['student'],true);
					foreach($student_list as $k2=>$v2){
						$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$v2['val']));
						if($pic['instructor_status'] != '1'){
							if(!in_array($pic,$array_student)){
								array_push($array_student,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_student = $list_student."".$pic['email'].",";
								}
							}
						}else{
							if(!in_array($pic,$array_instructor)){
								array_push($array_instructor,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_instructor = $list_instructor."".$pic['email'].",";
								}
							}
						}
					}

					$student_other = json_decode($v['student_other'],true);
					foreach($student_other as $k2=>$v2){
						$pic = $this->mymodel->selectDataOne('student_application_form', array('id'=>$v2['id_number']));

						if($pic['instructor_status'] != '1'){
							if(!in_array($pic,$array_student)){
								array_push($array_student,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_student = $list_student."".$pic['email'].",";
								}
							}
						}else{
							if(!in_array($pic,$array_instructor)){
								array_push($array_instructor,$pic);
								if (strpos($pic['email'], '@') !== false) {
									$list_instructor = $list_instructor."".$pic['email'].",";
								}
							}
						}
						
					}
				

	
				}
				
				
	
				$list_instructor = substr($list_instructor,0,-1);
				$list_student = substr($list_student,0,-1);
				

				if (strpos($list_instructor, '@') !== false) {
				
					$to_email = $list_instructor;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Instructor Ground Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your instructor daily ground schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_instructor.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				if (strpos($list_student, '@') !== false) {
				
					$to_email = $list_student;
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Here is Your Student Ground Flight Schedule on '.$location.' '.DATE('d M Y', strtotime($app_date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Here is your student ground flight schedule  on <b><u>'.$location.' '.DATE('d M Y', strtotime($app_date)).'</u></b>
					<br><br>
					
					<a class="btn" href="'.$button_link_student.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">My Schedule</a>
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
				}else{
					
				}

				// die;
				
				$date = $approval['date'];
				$date = " AND DATE(date) = '$date' ";
				$base = $approval['base'];
				$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
				LEFT JOIN base_airport_document b
				ON a.station = b.id
				WHERE base = '$base'");
				foreach($dat as $key=>$val){
					$text .= "'".$val['id']."',"; 
				}
				$text = substr($text,0,-1);
				$base = " AND classroom  IN ($text) ";
				$this->db->query("UPDATE daily_ground_schedule SET visibility = '1' WHERE visibility = '0' ".$base.$date);
			}
		
			
        redirect(base_url().'master/daily_approval_report');
	}

	public function rollback_2($id){
		$dtt = array(
			'approval_status_2' => 'PENDING',
			'updated_at' => DATE('Y-m-d H:i:s'),
		);

		$str = $this->mymodel->updateData('approval', $dtt , array('id'=>$id));

		$approval = $this->mymodel->selectDataOne('approval',array('id'=>$id));
			
		if($approval['type']=='FLIGHT'){
			$date = $approval['date'];
			$date = " AND DATE(date_of_flight) = '$date' ";
			$base = $approval['base'];
			$base = " AND origin_base = '$base' ";
			$this->db->query("UPDATE daily_flight_schedule SET visibility = '0' WHERE visibility = '1' ".$base.$date);
		}else if($approval['type']=='FTD'){
			$date = $approval['date'];
			$date = " AND DATE(date) = '$date' ";
			$base = $approval['base'];
			$base = " AND origin_base = '$base' ";
			$this->db->query("UPDATE daily_ftd_schedule SET visibility = '0' WHERE visibility = '1' ".$base.$date);
		}else if($approval['type']=='GROUND'){
			$date = $approval['date'];
			$date = " AND DATE(date) = '$date' ";
			$base = $approval['base'];
			$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
			LEFT JOIN base_airport_document b
			ON a.station = b.id
			WHERE base = '$base'");
			foreach($dat as $key=>$val){
				$text .= "'".$val['id']."',"; 
			}
			$text = substr($text,0,-1);
			$base = " AND classroom  IN ($text) ";
			$this->db->query("UPDATE daily_ground_schedule SET visibility = '0' WHERE visibility = '1' ".$base.$date);
		}
		redirect(base_url().'master/daily_approval_report');
	}



	public function create()

	{

		$data['page_name'] = "Flight_schedule";

		$this->template->load('template/template','master/daily_flight_schedule/add-daily_flight_schedule',$data);

	}

	public function validates()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

$this->form_validation->set_rules('dt[date_of_flight]', '<strong>Date on Flight</strong>', 'required');
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
		
		$this->datatables->join('student_application_form g','a.2nd = g.id');
		
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

		$data['page_name'] = "Daily_approval";

		$data['my_approval'] = $this->mymodel->selectDataOne('approval',array('id'=>$id));

		$this->template->load('template/template','master/daily_approval_report/edit',$data);

	}		
	public function preview($id)

	{

		$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "Flight_schedule";

		$this->template->load('template/template','master/daily_flight_schedule/preview-daily_flight_schedule',$data);

	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

$this->form_validation->set_rules('id', '<strong>ID</strong>', 'required');
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

				$approval = $this->mymodel->selectDataOne('approval', array('id'=>$_POST['id']));
				$dt = $_POST['dt'];
				$date = $dt['date'];
				$type = $dt['type'];
				$base = $dt['base'];
				$dtt = array(
					// 'approved_by' => $dt['approved_by'],
					// 'prepared_by' => $dt['prepared_by'],
					// 'on_be_half_status' => $dt['on_be_half_status'],
					'approved_by_2' => $dt['approved_by_2'],
					'remark' => $dt['remark'],
					'updated_at' => DATE('Y-m-d H:i:s'),
					'status' => 'ENABLE',
				);

				$str = $this->mymodel->updateData('approval', $dtt , array('id'=>$_POST['id']));
				// echo $str;
				$user = $this->mymodel->selectDataOne('user', array('id'=>$_SESSION['id']));
				$user['role'] = $this->mymodel->selectDataOne('role',array('id'=>$user['role_id']));
				$user['role'] = $user['role']['role'];
			
				



				if($dt['type']=='FLIGHT'){

					if($dt['approved_by_2']){


	$base = $approval['base'];
	$date = $approval['date'];


	$header = '
				<tr class="bg-success">
					<th style="width:20px">NUM</th>
				<th>ACFT<br>REG</th><th>PIC</th><th>2ND</th>
					<th>BATCH</th><th>COURSE</th><th>MISSION</th><th>DEP</th><th>ARR</th><th>ROUTE</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>
				</tr>
			';
			
	$dat = $this->mymodel->selectWithQuery("SELECT a.id,e.id as id_mission, h.nick_name as duty_instructor,a.date_of_flight,a.origin_base,b.serial_number as aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status
	FROM daily_flight_schedule a
	JOIN
	aircraft_document b
	ON a.aircraft_reg = b.id
	JOIN
	batch c 
	ON a.batch = c.id
	JOIN
	course d
	ON a.course = d.id
	JOIN
	tpm_syllabus_all_course e
	ON a.mission = e.id
	LEFT JOIN
	student_application_form f
	ON a.pic = f.id
	LEFT JOIN student_application_form g
	 ON a.2nd = g.id
	LEFT JOIN student_application_form h
	 ON a.duty_instructor = h.id
	WHERE a.visibility = '0' AND DATE(a.date_of_flight) = '$date'
	AND origin_base = '$base'
	ORDER BY
	a.date_of_flight ASC, a.etd_utc ASC
	");

	$body = '';

	foreach($dat as $key=>$val){
		$body .= '

			<tr>
			<td>'.($key+1).'</td>

			<td>'.$val['aircraft_reg'].'</td>
			<td class="text-left">'.$val['pic'].'</td>
			<td class="text-left">'.$val['2nd'].'</td>
			<td>'.$val['batch'].'</td>
			<td>'.$val['course'].'</td>
			<td class="text-left">'.$val['mission'].'</td>
			<td>'.$val['dep'].'</td>
			<td>'.$val['arr'].'</td>
			<td class="text-left">'.$val['rute'].'</td>
			<td>'.$val['etd_utc'].'</td>
			<td>'.$val['eta_utc'].'</td>
			<td>'.$val['eet'].'</td>
			<td class="text-left">'.$val['remark'].'</td>
			</tr>
			';
	}
	$table = '';
	$table = '<table style="width: 100%;
	border-collapse: collapse;">'.$header.''.$body.'</table>';
			


						$instructor = $this->mymodel->selectDataOne('user', array('id'=>$dt['approved_by_2']));
						if (strpos($instructor['email'], '@') !== false) {
							$button_link = base_url().'approval/approve/'.$_POST['id'].'/'.$instructor['id'];
							$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
							$instructor['role'] = $instructor['role']['role'];
						
							$to_email = $instructor['email'];
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Propose For Approval Daily Flight Schedule From '.$user['name'].' ('.$user['role'].') '.$location.' '.DATE('d M Y', strtotime($date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
					'.$instructor['role'].'
					<br><br>
					Please approve daily flight schedule for <b><u>'.$location.' '.DATE('d M Y', strtotime($date)).'</u></b>
					<br><br>
					'.$table.'
					<br></br>
					<a class="btn" href="'.$button_link.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">Approve</a>
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


				

				if($dt['type']=='FTD'){

					if($dt['approved_by_2']){


	$base = $approval['base'];
	$date = $approval['date'];


	$header = '
			<tr class="bg-success">
				<th style="width:20px">NUM</th>
				<th style="width:120px;">FTD MODEL</th><th>INSTRUCTOR</th><th>STUDENT</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>ETD <br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>
				</tr>
		';
			
	$dat = $this->mymodel->selectWithQuery("SELECT a.id,a.date, CONCAT(h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.id as id_mission, CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name
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
	WHERE  a.visibility = '0'
	AND DATE(a.date) >= '$date' AND DATE(a.date) <= '$date'
	AND origin_base = '$base'
	ORDER BY a.date ASC, a.etd_utc ASC
	");

	$body = '';

	foreach($dat as $key=>$val){
		$body .= '
		<tr>
		<td>'.($key+1).'</td>

		<td class="text-left">'.$val['ftd_model'].'</td><td class="text-left">'.$val['pic'].'</td><td class="text-left">'.$val['2nd'].'</td><td>'.$val['batch'].'</td>
		<td class="text-left">'.$val['course'].'</td>
	  
		<td class="text-left">'.$val['mission'].'</td></td><td>'.$val['etd_utc'].'</td><td>'.$val['eta'].'</td><td>'.$val['eet_utc'].'<td class="text-left">'.$val['remark'].'</td>
	  
		</tr>
			';
	}
	$table = '';
	$table = '<table style="width: 100%;
	border-collapse: collapse;">'.$header.''.$body.'</table>';
			


						$instructor = $this->mymodel->selectDataOne('user', array('id'=>$dt['approved_by_2']));
						if (strpos($instructor['email'], '@') !== false) {
							$button_link = base_url().'approval/approve/'.$_POST['id'].'/'.$instructor['id'];
							$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
							$instructor['role'] = $instructor['role']['role'];
						
							$to_email = $instructor['email'];
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Propose For Approval Daily FTD Schedule From '.$user['name'].' ('.$user['role'].') '.$location.' '.DATE('d M Y', strtotime($date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
					'.$instructor['role'].'
					<br><br>
					Please approve daily ftd schedule for <b><u>'.$location.' '.DATE('d M Y', strtotime($date)).'</u></b>
					<br><br>
					'.$table.'
					<br></br>
					<a class="btn" href="'.$button_link.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">Approve</a>
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




				if($dt['type']=='GROUND'){

					if($dt['approved_by_2']){


	$base = $approval['base'];
	$date = $approval['date'];

	$header = '
			<tr class="bg-success">
				<th style="width:20px" rowspan="2" >NUM</th>
				<th rowspan="2" >CLASS<br>ROOM</th>
				<th rowspan="2" >INSTRUCTOR</th>
				<th rowspan="2" >BATCH</th>
				<th rowspan="2" >COURSE</th><th rowspan="2" >SUBJECT</th><th colspan="3">TIME (UTC)</th><th rowspan="2" >REMARK</th><th rowspan="2" >PARTICIPANT</th> 
			</tr>
			<tr class="bg-success">
<th>START</th>
<th>STOP</th>
<th>DUR</th>
</tr>

		';

		
	$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
	LEFT JOIN base_airport_document b
	ON a.station = b.id
	WHERE base = '$base'");
	foreach($dat as $key=>$val){
		$text .= "'".$val['id']."',"; 
	}
	$text = substr($text,0,-1);
	$base = " AND a.classroom  IN ($text) ";

	$dat = $this->mymodel->selectWithQuery("SELECT a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,g.batch, CONCAT(c.base,' (',b.classroom,')') as classroom,d.course_code as course,CONCAT(e.subject_mission,'. ',e.name) as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
	FROM
	daily_ground_schedule a
	JOIN classroom b
	ON a.classroom = b.id
	JOIN base_airport_document c
	ON b.station = c.id
	JOIN course d
	ON a.course = d.id
	JOIN tpm_syllabus_all_course e
	ON a.subject = e.id
	LEFT JOIN student_application_form f
	ON a.instructor = f.id
	JOIN batch g
	ON a.batch = g.id
	JOIN base_airport_document h
	ON b.station = h.id
	WHERE DATE(a.date) >= '$date' AND DATE(a.date) <= '$date' AND a.visibility = '0'
	 "
	  .$classroom.
	 "
	ORDER BY a.date ASC,a.start_lt ASC");

	$body = '';

	$total = array();
	$array_class = array();
	$array_subject = array();
	
	foreach($dat as $key=>$val){
		if(!in_array($val['classroom'],$array_class)){
			array_push($array_class,$val['classroom']);
		  }
		  if(!in_array($val['subject'],$array_subject)){
			array_push($array_subject,$val['subject']);
		  }
		  
		  if (strpos($val['duration'], ':') !== false) {
			array_push($total,$val['duration']);
		  }
		
		  $participant = 0;
		  $student_list = json_decode($val['student'],true);
		  // print_r($student_list);
		  $student_other = json_decode($val['student_other'],true);
		  // print_r($student_other);
		
		  foreach($student_list as $key2=>$val2){
			if($val2['val']){
			  $participant++;
			}
		  }
		  foreach($student_other as $key2=>$val2){
			if($val2['check']=='on'){
			  $participant++;
			}
		  }
		$body .= '

			<tr>
			<td>'.($key+1).'</td>

			<td>'.$val['classroom'].'</td> 
  <td class="text-left">'.$val['instructor'].'</td> 
  <td>'.$val['batch'].'</td> 
  <td class="text-left">'.$val['course'].'</td> <td class="text-left">'.$val['subject'].'</td> 
<td>'.$val['start_lt'].'</td> <td>'.$val['stop_lt'].'</td> <td>'.$val['duration'].'</td>  <td class="text-left">'.$val['remark'].'</td> 
 <td>'.$participant.'</td> 

			</tr>
			';
	}
	$table = '';
	$table = '<table style="width: 100%;
	border-collapse: collapse;">'.$header.''.$body.'</table>';
			


						$instructor = $this->mymodel->selectDataOne('user', array('id'=>$dt['approved_by_2']));
						if (strpos($instructor['email'], '@') !== false) {
							$button_link = base_url().'approval/approve/'.$_POST['id'].'/'.$instructor['id'];
							$instructor['role'] = $this->mymodel->selectDataOne('role',array('id'=>$instructor['role_id']));
							$instructor['role'] = $instructor['role']['role'];
						
							$to_email = $instructor['email'];
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					// More headers. From is required, rest other headers are optional
					$headers .= 'From: Bali International Flight Academy <karyastudioteknologidigital@gmail.com>' . "\r\n";
					$headers .= 'Cc: amuammarzein@gmail.com' . "\r\n";
					$subject = 'Propose For Approval Daily Ground Schedule From '.$user['name'].' ('.$user['role'].') '.$location.' '.DATE('d M Y', strtotime($date));
					
					$instructor['body_email'] = '
					<div style="text-align:left">
					Hi '.ucwords(strtolower($instructor['name'])).' ('.$instructor['nip'].')<br>
					'.$instructor['role'].'
					<br><br>
					Please approve daily ground schedule for <b><u>'.$location.' '.DATE('d M Y', strtotime($date)).'</u></b>
					<br><br>
					'.$table.'
					<br></br>
					<a class="btn" href="'.$button_link.'" style="padding:10px;
					color:#fff;
					text-decoration: none;
					text-align: left;
					border-radius: 12px;
					background: #066265;
					box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">Approve</a>
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



    function print_flight_schedule($approval){

		$date = $approval['date'];
		$type = 'FLIGHT';
		$base = $approval['base'];

		$location = $approval['base'];
		
		// if($base){
		// 	$base = " AND base = '$base' ";
		// }else{
		// 	$base = " ";
		// }

		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base'
		LIMIT 1");


		$approval = $approval[0];
		$data['location'] = $location.', '.DATE('d M Y', strtotime($approval['sent_at']));
		// die;

		$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['prepared_by']));
        $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));

        $data['prepared_by'] = '<p><u>'.$dat['name'].'</u><p> <p>'.$role['role'].'</p>';

        $dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by']));
        $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));

		$data['approved_by'] = '<p><u>'.$dat['name'].'</u><p> <p>'.$role['role'].'</p>';
		$img = $this->mymodel->selectDataOne('file',array('table'=>'file_signature','table_id'=>$dat['id']));
		
		// if($approval['approval_status']=='APPROVED'){
		// 	$data['approved_by'] = '<img style="float:left;text-align:left" src="'.base_url().'webfile/'.$img['name'].'" >';
		// }else{
		// 	$data['approved_by'] = '<br><br><br><br><br>'.$data['approved_by'];
		// }
		$data['approved_by'] = '<br><br><br><br><br>'.$data['approved_by'];
		
		if($approval['approved_by_2']){
			if($approval['approval_status'] != 'APPROVED'){
				$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by_2']));
				$data['approved_by'] = '<p><u>'.$dat['name'].'</u><p> <p>On Behalf Of '.$role['role'].'</p>';
			}
        }

		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $approval['base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY FLIGHT SCHEDULE - '.$base['base'];
		}else{
			$text2 = 'DAILY FLIGHT SCHEDULE - ALL BASE';
		}

		if(1==1){
			$data['date'] = DATE('d M Y', strtotime($approval['date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($approval['date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}
		// echo $data['date'];

		$title = $text2.' '.strtoupper($data['date']);
	

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/flight_schedule/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "This document is provided for the exclusive use of $name at Bali International Flight Academy";
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];
		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(0, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 125, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();

		$pdf->setTitle($title);
		// $pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		$namafile = "webfile/schedule/Daily Flight Schedule ".$approval['base']." ".DATE('d M Y', strtotime($approval['date'])).'.pdf';
		$pdf->Output($namafile, 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
        return $namafile;
    }


    
	function print_ftd_schedule($approval){
		
		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $approval['base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY FTD SCHEDULE - '.$base['base'];
		}else{
			$text2 = 'DAILY FTD SCHEDULE - ALL BASE';
		}

		if(1==1){
			$data['date'] = DATE('d M Y', strtotime($approval['date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($approval['date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}
		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/ftd_schedule/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "This document is provided for the exclusive use of $name at Bali International Flight Academy";
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(0, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 125, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		// $pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		$namafile = "webfile/schedule/Daily FTD Schedule ".$approval['base']." ".DATE('d M Y', strtotime($approval['date'])).'.pdf';
		$pdf->Output($namafile, 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
        return $namafile;
	}


	function print_ground_schedule($approval){
		
		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $approval['base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY GROUND SCHEDULE - '.$base['base'];
		}else{
			$text2 = 'DAILY GROUND SCHEDULE - ALL BASE';
		}

		if(1==1){
			$data['date'] = DATE('d M Y', strtotime($approval['date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($approval['date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}
		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/ground_schedule/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "This document is provided for the exclusive use of $name at Bali International Flight Academy";
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(0, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 125, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		// $pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		$namafile = "webfile/schedule/Daily Ground Schedule ".$approval['base']." ".DATE('d M Y', strtotime($approval['date'])).'.pdf';
		$pdf->Output($namafile, 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	   return $namafile;
	 
	}


}

?>