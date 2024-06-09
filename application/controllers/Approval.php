<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Approval extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
		echo "<h1>Sorry, you can't do the approval because the propose has already been done!</h1>";
    }

	function approve($id_approval,$id_user){
		$approval = $this->mymodel->selectDataOne('approval', array('id'=>$id_approval));
		if($approval['approval_status']=='APPROVED'){
			redirect(base_url().'approval');
			
		}
		$url = "http://localhost:1996/bifa/approval/approve/$id_approval/$id_user";
	
		$send = $this->template->curl_url($url);

		if($send){
			$_SESSION['propose'] = '<div class="alert alert-success">  
			<a href="#" class="close" data-dismiss="alert">×</a>  
			Notificaton
			<br>
			Approved! 
		  </div>';
		}else{
			$_SESSION['propose'] = '<div class="alert alert-danger">  
			<a href="#" class="close" data-dismiss="alert">×</a>  
			Notificaton
			<br>
			Not approved! 
		  </div>';
		}

		
		redirect(base_url().'menu/my_approval');

	}

	function approve_report($id_approval,$id_user){
		$approval = $this->mymodel->selectDataOne('approval', array('id'=>$id_approval));
		if($approval['approval_status']=='APPROVED'){
			redirect(base_url().'approval');
			
		}
		$url = "http://localhost:1996/bifa/approval/approve_report/$id_approval/$id_user";
		$send = $this->template->curl_url($url);

		if($send){
			$_SESSION['propose'] = '<div class="alert alert-success">  
			<a href="#" class="close" data-dismiss="alert">×</a>  
			Notificaton
			<br>
			Approved! 
		  </div>';
		}else{
			$_SESSION['propose'] = '<div class="alert alert-danger">  
			<a href="#" class="close" data-dismiss="alert">×</a>  
			Notificaton
			<br>
			Not approved! 
		  </div>';
		}

		
		redirect(base_url().'menu/my_approval');
	}
    function approve_last($id_approval,$id_user){
     
        $approval = $this->mymodel->selectDataOne('approval', array('id'=>$id_approval));
        if($approval){
            if($approval['approved_by']==$id_user){
				$dt['approval_status'] = 'APPROVED';
				$dt['approved_time'] = DATE('Y-m-d H:i:s');
            }else if($approval['approved_by_2']==$id_user){
                $dt['approval_status_2'] = 'APPROVED';
				$dt['approved_2_time'] = DATE('Y-m-d H:i:s');
            }
            $dt['updated_at'] = DATE('Y-m-d H:i:s');
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
					$pic = $this->mymodel->selectDataOne('user', array('id'=>$pic));
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
					$pic = $this->mymodel->selectDataOne('user', array('id'=>$pic));
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
					$pic = $this->mymodel->selectDataOne('user', array('id'=>$pic));
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
					$pic = $this->mymodel->selectDataOne('user', array('id'=>$pic));
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
					$pic = $this->mymodel->selectDataOne('user', array('id'=>$pic));
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
						$pic = $this->mymodel->selectDataOne('user', array('id'=>$v2['val']));
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
						$pic = $this->mymodel->selectDataOne('user', array('id'=>$v2['id_number']));

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
		
			
    //   die;
        redirect(base_url().'menu/my_approval');
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
