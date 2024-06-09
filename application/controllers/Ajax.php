<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
	}

	function get_amel_no()
	{
		$id = $_GET['id'];
		$data = $this->mymodel->selectDataOne('user', array('id' => $id));
		echo $data['id_number'];
	}

	// function generate_file_flight(){
	// 	header('Content-Type: application/json');
	// 	$data = $this->mymodel->selectWithQuery("SELECT id,file_report
	// 	FROM daily_flight_schedule 
	// 	ORDER BY id DESC		
	// 	-- LIMIT 10
	// 	");
	// 	$this->db->trans_start();
	// 	foreach($data as $k=>$v){
	// 		$dt = array();
	// 		$dt = $v;
	// 		$file = $this->mymodel->selectDataone('file',array('table_id'=>$v['id'],'table'=>'daily_flight_schedule'));
	// 		if($dt['file_report']==''){
	// 			$dt['file_report'] = strval($file['name']);
	// 		}else{
	// 			$dt['file_report'] = '';	
	// 		}
	// 		print_r($dt);
	// 		// $this->db->update('daily_flight_schedule',$dt,array('id'=>$dt['id']));
	// 	}
	// 	$this->db->trans_complete();
	// }

	function generate_student_attendance()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT *
		FROM daily_ground_schedule
		-- WHERE id = '703'
		");
		$this->db->trans_start();
		foreach ($data as $k => $v) {
			$dt = array();

			$arr = array();
			$json = json_decode($v['student'], true);
			foreach ($json as $k2 => $v2) {
				$arr[$k2]['val'] = $v2['val'];
			}
			$dt['student'] = json_encode($arr, true);

			$arr = array();
			$json = json_decode($v['student_other'], true);
			foreach ($json as $k2 => $v2) {
				// if($v2['check']=="on"){
				$arr[$k2]['val'] = $v2['val'];
				$arr[$k2]['batch'] = $v2['batch'];
				$arr[$k2]['check'] = $v2['check'];
				// }
			}
			$dt['student_other'] = json_encode($arr, true);

			$arr = array();
			$json = json_decode($v['student_attend'], true);
			foreach ($json as $k2 => $v2) {
				$arr[$k2]['val'] = $v2['val'];
			}
			$dt['student_attend'] = json_encode($arr, true);

			$arr = array();
			$json = json_decode($v['student_other_attend'], true);
			foreach ($json as $k2 => $v2) {
				// if($v2['check']=="on"){
				$arr[$k2]['val'] = $v2['val'];
				$arr[$k2]['batch'] = $v2['batch'];
				$arr[$k2]['check'] = $v2['check'];
				// }
			}
			$dt['student_other_attend'] = json_encode($arr, true);
			print_r($dt);
			$this->db->update('daily_ground_schedule', $dt, array('id' => $v['id']));
		}
		$this->db->trans_complete();
	}

	function generate_student_course()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE instructor_status != '1'
		-- LIMIT 1
		");
		$this->db->order_by('position', 'ASC');
		$list = $this->mymodel->selectWhere('syllabus_type_of_training', null);
		foreach ($list as $k => $v) {
			$arr_1[$v['code']]['status'] = "ON";
			$this->db->order_by('position', 'ASC');
			$course = $this->mymodel->selectWhere('syllabus_course', null);
			foreach ($course as $k2 => $v2) {
				$arr_2[$v['code']][$v2['code']]['status'] = "ON";
			}
		}

		$this->db->trans_start();
		foreach ($data as $k => $v) {
			$dt = array();

			$dt['type_of_training'] = json_encode($arr_1, true);
			$dt['course'] = json_encode($arr_2, true);
			print_r($dt);
			$this->db->update('user', $dt, array('id' => $v['id']));
		}
		$this->db->trans_complete();
	}

	function generate_schedule_flight()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT id, batch, tpm, course, mission
		FROM daily_flight_schedule 
		ORDER BY id DESC		
		-- LIMIT 10
		");
		$this->db->trans_start();
		foreach ($data as $k => $v) {
			$dt = array();
			$dt = $v;

			if (substr($v['course'], 0, strlen($v['tpm'])) == $v['tpm']) {
				$dt['course'] = substr($v['course'], strlen($v['tpm']));
			}

			if (substr($v['mission'], 0, strlen($v['tpm'])) == $v['tpm']) {
				$dt['mission'] = substr($v['mission'], strlen($v['tpm']));
			}

			$dt['course'] = substr(strstr($v['course'], 'C'), strlen(''));
			$dt['mission'] = substr(strstr($v['mission'], 'C'), strlen(''));

			print_r($dt);
			$this->db->update('daily_flight_schedule', $dt, array('id' => $dt['id']));
		}
		$this->db->trans_complete();
	}

	function generate_schedule_ftd()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT id, batch, tpm, course, mission
		FROM daily_ftd_schedule 
		ORDER BY id DESC		
		-- LIMIT 10
		");
		$this->db->trans_start();
		foreach ($data as $k => $v) {
			$dt = array();
			$dt = $v;

			if (substr($v['course'], 0, strlen($v['tpm'])) == $v['tpm']) {
				$dt['course'] = substr($v['course'], strlen($v['tpm']));
			}

			if (substr($v['mission'], 0, strlen($v['tpm'])) == $v['tpm']) {
				$dt['mission'] = substr($v['mission'], strlen($v['tpm']));
			}

			$dt['course'] = substr(strstr($v['course'], 'C'), strlen(''));
			$dt['mission'] = substr(strstr($v['mission'], 'C'), strlen(''));

			print_r($dt);
			$this->db->update('daily_ftd_schedule', $dt, array('id' => $dt['id']));
		}
		$this->db->trans_complete();
	}

	function generate_schedule_ground()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT id, batch, tpm, course, subject
		FROM daily_ground_schedule 
		-- WHERE id = '23'
		ORDER BY id DESC		
		-- LIMIT 10
		");
		$this->db->trans_start();
		foreach ($data as $k => $v) {
			$dt = array();
			$dt = $v;

			if (substr($v['course'], 0, strlen($v['tpm'])) == $v['tpm']) {
				$dt['course'] = substr($v['course'], strlen($v['tpm']));
			}
			// echo substr($v['subject'],0,strlen($v['tpm']));

			if (substr($v['subject'], 0, strlen($v['tpm'])) == $v['tpm']) {
				$dt['subject'] = substr($v['subject'], strlen($v['tpm']));
			}
			$dt['course'] = substr(strstr($v['course'], 'C'), strlen(''));
			$dt['subject'] = substr(strstr($v['subject'], 'C'), strlen(''));
			print_r($dt);
			$this->db->update('daily_ground_schedule', $dt, array('id' => $dt['id']));
		}
		$this->db->trans_complete();
	}

	function generate_mission()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT a.subject_mission,b.code,b.course_code,a.*,REPLACE(a.code, a.curriculum, '') as new_code
		FROM tpm_syllabus_all_course a
		JOIN course b
		ON a.course = b.code
		WHERE a.curriculum = '10'
		GROUP BY a.type_of_training,new_code,a.name
		ORDER BY a.type_of_training,new_code,a.name
		");
		$this->db->delete('syllabus_mission', '1=1');
		$this->db->trans_start();
		echo count($data);
		foreach ($data as $k => $v) {
			$dt = array();
			$dt = $v;
			// print_r($dt);
			// die;
			$dt['status'] = 'ENABLE';
			$dt['created_at'] = DATE('Y-m-d H:i:s');
			// $code = $dt['course_code'].str_replace($v['course'],'',$v['code']);
			// $code = str_replace($v['curriculum'],'',$v['code']);
			$dt['code'] = substr(strstr($v['code'], 'C'), strlen(''));
			$dt['code_name'] = $v['subject_mission'];
			if ($dt['type_of_training'] == "SIM") {
				$dt['type_of_training'] = 'FTD';
			}
			if (!in_array($dt['type_of_training'], array('FLIGHT', 'FTD', 'GROUND'))) {
				$dt['type_of_training'] = 'RINDAM';
			}
			$dt['position'] = intval($dt['position']);
			$dt['type'] = $dt['type_of_training2'];
			$dt['type_sub'] = $dt['type_of_training_type2'];
			$code = str_replace($v['curriculum'], '', $v['course']);
			$dt['course'] = $code;
			// $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$v['course_code']));
			// print_r($dat);die;
			// $dt['id_course'] = $dat['code'];
			unset($dt['id']);
			unset($dt['subject_mission']);
			unset($dt['type_of_training2']);
			unset($dt['type_of_training_type2']);
			unset($dt['curriculum']);
			// unset($dt['course']);
			unset($dt['mission_number']);
			unset($dt['subject_mission']);
			unset($dt['course_code']);
			unset($dt['new_code']);
			print_r($dt);
			$this->db->insert('syllabus_mission', $dt);
		}
		$this->db->trans_complete();
	}

	function generate_course()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT a.*
		FROM course a
		WHERE a.curriculum = '10'
		GROUP BY a.course_code
		");
		$this->db->delete('syllabus_course', '1=1');
		$this->db->trans_start();
		foreach ($data as $k => $v) {
			$dt = array();
			$dt = $v;
			$dt['status'] = 'ENABLE';
			$dt['created_at'] = DATE('Y-m-d H:i:s');
			// $code = $dt['course_code'].str_replace($v['course'],'',$v['code']);
			// $code = $dt['course_code'].$v['subject_mission'];
			$code = str_replace($v['curriculum'], '', $v['code']);
			$dt['code'] = $code;
			$dt['code_name'] = $v['course_code'];
			$dt['name'] = $dt['course_name'];
			$arr = array();
			foreach (json_decode($v['configuration'], true) as $k => $v) {
				if ($v['val'] == "SIM") {
					$arr['FTD']['status'] = 'ON';
				} else if (!in_array($v['val'], array('FLIGHT', 'SIM', 'GROUND'))) {
					$arr['RINDAM']['status'] = 'ON';
				} else {
					$arr[$v['val']]['status'] = 'ON';
				}
			}
			$dt['type_of_training'] = json_encode($arr, true);
			// print_r($dt);
			// die;
			unset($dt['id']);
			unset($dt['configuration']);
			unset($dt['curriculum']);
			unset($dt['mission_number']);
			unset($dt['course_name']);
			unset($dt['course_code']);
			print_r($dt);
			$this->db->insert('syllabus_course', $dt);
		}
		$this->db->trans_complete();
	}

	function generate_curriculum()
	{
		header('Content-Type: application/json');
		$data = $this->mymodel->selectWithQuery("SELECT a.*
		FROM curriculum a
		");
		$this->db->delete('syllabus_curriculum', '1=1');
		$this->db->trans_start();
		foreach ($data as $k => $v) {
			$dt = array();
			$dt = $v;
			$dt['status'] = 'ENABLE';
			$dt['created_at'] = DATE('Y-m-d H:i:s');
			// $code = $dt['course_code'].str_replace($v['course'],'',$v['code']);
			$code = $v['code'];
			$dt['code'] = $code;
			$dt['code_name'] = $dt['code'];
			$dt['name'] = $dt['curriculum'];
			unset($dt['id']);
			unset($dt['configuration']);
			unset($dt['curriculum']);
			unset($dt['mission_number']);
			unset($dt['course_name']);
			unset($dt['course_code']);
			unset($dt['approval_date']);

			print_r($dt);
			$this->db->insert('syllabus_curriculum', $dt);
		}
		$this->db->trans_complete();
	}

	function generate_configuration()
	{
		header('Content-Type: application/json');
		// $this->db->order_by('position','ASC');
		$data = $this->mymodel->selectWhere('syllabus_curriculum', null);
		foreach ($data as $k => $v) {
			$dt = array();
			$this->db->order_by('position', 'ASC');
			$list = $this->mymodel->selectWhere('syllabus_type_of_training', null);
			$arr_2 = array();
			$arr_3 = array();
			$arr_4 = array();
			foreach ($list as $k2 => $v2) {
				$arr_2[$v2['code']]['status'] = 'ON';
				$qry = '"' . $v2['code'] . '":{"status":"ON"}';
				$list_3 = $this->mymodel->selectWithQuery("SELECT *
				FROM syllabus_course
				WHERE type_of_training LIKE '%$qry%' 
				ORDER BY position ASC
				");

				foreach ($list_3 as $k3 => $v3) {
					$arr_3[$v2['code']][$v3['code']]['status'] = 'ON';

					$v_type = $v2['code'];
					$code_course = $v3['code'];
					$list_4 = $this->mymodel->selectWhere('syllabus_mission', "type_of_training = '$v_type' AND course = '$code_course' 
					ORDER BY position ASC");
					foreach ($list_4 as $k4 => $v4) {
						$arr_4[$v2['code']][$v3['code']][$v4['code']]['status'] = 'ON';
					}
				}
			}
			$dt['type_of_training'] = json_encode($arr_2, true);
			$dt['course'] = json_encode($arr_3, true);
			$dt['mission'] = json_encode($arr_4, true);

			print_r($dt);
			$this->db->update('syllabus_curriculum', $dt, array('id' => $v['id']));
		}
	}

	function a()
	{

		$base = 'BWX';

		$special = $this->mymodel->selectWithQuery("SELECT id, full_name, id_number, email FROM user WHERE instructor_status = '1' AND base IN ('','$base') AND status = 'ACTIVE' AND email_notification LIKE '%DFS%'");

		foreach ($special as $k5 => $v5) {
			$pic = $v5;
			if (!in_array($pic, $array_special)) {
				array_push($array_special, $pic);
				if (strpos($pic['email'], '@') !== false) {
					$list_special = $list_special . "" . $pic['email'] . ",";
				}
			}
		}
		echo $list_special;
	}

	function get_classroom()
	{
		$base = $_GET['base'];
		$data = $this->mymodel->selectWhere('classroom', array('station' => $base, 'status' => 'ENABLE'));
		$text = '<option value="">SELECT CLASSROOM</option>';
		foreach ($data as $key => $val) {
			$text .= '<option value="' . $val['code'] . '">' . $val['classroom'] . '</option>';
		}
		echo $text;
	}

	function get_course_by_batch()
	{
		$batch = $_GET['batch'];
		$type = $_GET['type'];
		$batch = $this->mymodel->selectDataOne('batch', array('code' => $batch));
		$curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));
		$arr_course = json_decode($curriculum['course'], true);
		$curriculum = $curriculum['name'];
		$qry = '"' . $type . '":{"status":"ON"}';
		$data = $this->mymodel->selectWithQuery("SELECT *
		FROM syllabus_course
		WHERE type_of_training LIKE '%$qry%' 
				ORDER BY position ASC");
		$text = '<option value="">SELECT COURSE</option>';
		foreach ($data as $key => $val) {
			if ($arr_course[$type][$val['code']]['status'] == 'ON') {
				$text .= '<option value="' . $val['code'] . '">' . $val['code_name'] . '</option>';
			}
		}
		echo $text;
	}

	function get_course_by_batch_pure()
	{
		$batch = $_GET['batch'];
		// $type = $_GET['type'];
		$batch = $this->mymodel->selectDataOne('batch', array('code' => $batch));
		$curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));

		$arr_course = json_decode($curriculum['course'], true);
		$curriculum = $curriculum['name'];
		// $qry = '"'.$type.'":{"status":"ON"}';
		$data = $this->mymodel->selectWithQuery("SELECT *
		FROM syllabus_course
		-- WHERE type_of_training LIKE '%$qry%' 
				ORDER BY position ASC");
		$text = '<option value="">SELECT COURSE</option>';
		foreach ($data as $key => $val) {
			// if($arr_course[$type][$val['code']]['status'] == 'ON'){
			$text .= '<option value="' . $val['code'] . '">' . $val['code_name'] . ' - ' . $val['name'] . '</option>';
			// }
		}
		echo $text;
	}


	function get_mission_by_course()
	{
		$batch = $_GET['batch'];
		$v_type = $_GET['type'];
		$code_course = $_GET['course'];

		$batch = $this->mymodel->selectDataOne('batch', array('code' => $batch));
		$curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));
		$arr_mission = json_decode($curriculum['mission'], true);

		$data = $this->mymodel->selectWhere('syllabus_mission', "type_of_training = '$v_type' AND course = '$code_course' 
		ORDER BY position ASC");
		$text = '<option value="">SELECT MISSION</option>';
		foreach ($data as $key => $val) {
			if ($arr_mission[$v_type][$code_course][$val['code']]['status'] == 'ON') {
				$text .= '<option value="' . $val['code'] . '">' . $val['code_name'] . ' - ' . $val['name'] . '</option>';
			}
		}
		echo $text;
	}


	function get_mission_detail()
	{
		$mission = $_GET['mission'];
		$mission = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $mission));

		echo $mission['description'];
	}

	// function get_pic_by_batch(){
	// 	$instructor = $this->mymodel->selectWhere('instructor',null);

	// 	echo '<option value="" >SELECT PIC/INSTRUCTOR</option>';
	// 	foreach ($instructor as $val) {

	// 	  $text="";

	// 	  if (strpos($val['type'], 'FLIGHT') !== false) {
	// 		echo "<option value='PIC--".$val['id_number']."' ".$text." >".$val['full_name']."</option>";
	// 	  }

	// 	}
	// 	$batch = $_GET['batch'];
	// 	$data = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE batch = '$batch' AND status = 'ACTIVE'");
	// 	$text = '<option value="">SELECT STUDENT</option>';
	// 	foreach($data as $key=>$val){
	// 		$text .= '<option value="STUDENT'.$val['id'].'">'.$val['id_number'].'</option>';
	// 	}
	// 	echo $text;

	// }


	function get_2nd_by_batch()
	{
		$batch = $_GET['batch'];
		$type = $_GET['type'];
		if ($type == 'FLIGHT') {
			echo  '<option value="-">SELECT 2ND/INSTRUCTOR</option>';
			$instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'"));

			foreach ($instructor as $val) {

				$text = "";

				if ($val['id'] == $daily_flight_schedule['pic']) {

					$text = "selected";
				}

				if (strpos($val['type'], 'FLIGHT') !== false) {
					echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
				}
			}
		} else if ($type == 'FTD') {
			echo  '<option value="">SELECT PIC/INSTRUCTOR</option>';
			$instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'"));

			foreach ($instructor as $val) {

				$text = "";

				if ($val['id'] == $daily_flight_schedule['pic']) {

					$text = "selected";
				}

				if (strpos($val['type'], 'FTD') !== false) {
					echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
				}
			}
		}
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE batch = '$batch' AND status = 'ACTIVE'");
		$text = '<option value="">SELECT STUDENT</option>';
		foreach ($data as $key => $val) {
			$text .= '<option value="' . $val['id_number'] . '">' . $val['nick_name'] . '</option>';
		}
		echo $text;
	}


	function get_pic_by_batch()
	{
		$batch = $_GET['batch'];
		$type = $_GET['type'];
		if ($type == 'FLIGHT') {

			echo  '<option value="">SELECT PIC/INSTRUCTOR</option>';
			$instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'"));

			foreach ($instructor as $val) {

				$text = "";

				if ($val['id'] == $daily_flight_schedule['pic']) {

					$text = "selected";
				}

				if (strpos($val['type'], 'FLIGHT') !== false) {
					echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
				}
			}
		} else if ($type == 'FTD') {
			echo  '<option value="">SELECT PIC/INSTRUCTOR</option>';
			$instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'"));

			foreach ($instructor as $val) {

				$text = "";

				if ($val['id'] == $daily_flight_schedule['pic']) {

					$text = "selected";
				}

				if (strpos($val['type'], 'FTD') !== false) {
					echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
				}
			}
		}
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE batch = '$batch' AND status = 'ACTIVE'");
		$text = '<option value="">SELECT STUDENT</option>';
		foreach ($data as $key => $val) {
			$text .= '<option value="' . $val['id_number'] . '">' . $val['nick_name'] . '</option>';
		}
		echo $text;
	}


	function get_student_by_batch()
	{
		$batch = $_GET['batch'];
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user a
		WHERE a.batch='$batch' AND a.status='ACTIVE'");
		$text = '<option value="">SELECT STUDENT</option>';
		foreach ($data as $key => $val) {
			$text .= '<option value="' . $val['id_number'] . '">' . $val['id_number'] . ' - ' . $val['full_name'] . '</option>';
		}
		echo $text;
	}


	function get_student_list_by_batch()
	{
		$batch = $_GET['batch'];


		$text = "";
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user a
		WHERE a.batch='$batch' AND a.status='ACTIVE'");

		$batch = $this->mymodel->selectWithQuery("SELECT a.*,b.name FROM batch a LEFT JOIN syllabus_curriculum b ON a.curriculum = b.code 
		WHERE a.code = '$batch'
		ORDER BY a.batch ASC");

		$batch = $batch[0];

		$nomor = 0;
		foreach ($data as $key => $val) {
			$nomor++;
			$text .= '
		<tr id="' . $key . '">
		<td>' . $nomor . '
	   </td>
		<td>
		' . $batch['batch'] . ' (' . $batch['name'] . ')
	   </td>
		<td>' . $val['id_number'] . '
	   </td>
		<td class="text-left">' . $val['full_name'] . '
	   </td>
		<td class="text-left">' . $val['nick_name'] . '
	   </td>
	   <td>
		 <input type="checkbox" checked name="dtt[' . $val['id'] . '][val]" value="' . $val['id_number'] . '">
	   </td>

	 </tr>';
		}

		$text = '<div class="table-responsive">
		<table class="table table-bordered" id="student"  style="width:100%;">
		<thead>  
		<tr>
			<th style="width:50px;">Num
			</th>
			<th>Batch
			</th>
			<th>ID Number
			</th>
			<th>Full Name
			</th>
			<th>Nick Name
			</th>
			<th style="width:50px;">Participant
			</th>
			
		</tr>
		</thead>  
		<tbody>
		' . $text . '
		   <tbody>
</table>
	   
		 </div>';

		echo $text;
	}


	function get_tpm()
	{
		$batch = $_GET['batch'];
		$batch = $this->mymodel->selectDataOne('batch', array('batch' => $batch));
		$curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));
		echo '<option value="' . $curriculum['code'] . '">' . ($curriculum['name']) . '</option>';
	}
	function get_training()
	{

		$id_user = $_GET['id_user'];
		$student_application_form = $this->mymodel->selectDataOne('user', array('id' => $id_user));


		$batch = $_GET['batch'];
		$batch = $this->mymodel->selectDataOne('batch', array('batch' => $batch));
		$curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));

		$arr_type_of_training = json_decode($curriculum['type_of_training'], true);
		$arr_course = json_decode($curriculum['course'], true);
		$arr_mission = json_decode($curriculum['mission'], true);


		$arr_type_of_training_selected = json_decode($student_application_form['type_of_training'], true);
		$arr_course_selected = json_decode($student_application_form['course'], true);



		$id_curriculum = $curriculum['code'];

		//  $id_curriculum = $curriculum['id'];
		$data = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_type_of_training ORDER BY position ASC");

		foreach ($data as $key => $val) {

			if ($arr_type_of_training[$val['code']]['status'] == "ON") {



				$table_body = '';

				$configuration = '"val":"' . $val['id'] . '"';
				$course = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_course  ORDER BY position ASC");

				$grand_total_duration = array();
				foreach ($course as $key2 => $val2) {

					if ($arr_course[$val['code']][$val2['code']]['status'] == "ON") {

						$text = '';
						if ($training_requirement[$val['id']]['item'][$val2['id']]['val'] == $val2['id']) {
							$text = 'checked';
						}

						$course = $val2['code'];
						$curriculum = $val2['curriculum'];
						$type = $val['code'];


						foreach ($arr_mission[$val['code']][$val2['code']] as $k5 => $v5) {
							if ($v5['status'] == 'ON') {
								$text .= "'" . $k5 . "',";
							}
						}

						$text = substr($text, 0, -1);


						if ($text) {
							$mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE type_of_training = '$type' AND code IN ($text) ORDER BY position ASC");
						}

						// print_r($mission);


						$duration = array();
						$duration_dual = array();
						$duration_solo = array();
						$duration_pic = array();
						$duration_pic_solo = array();
						$duration_non_rev = array();
						$duration_total = array();
						$total_duration = array();

						foreach ($mission as $key3 => $val3) {

							if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration']) {
								$val3['duration'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration'];
							}
							if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['price']) {
								$val3['price'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['price'];
							}
							if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_dual']) {
								$val3['duration_dual'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_dual'];
							}
							if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_solo']) {
								$val3['duration_solo'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_solo'];
							}
							if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic']) {
								$val3['duration_pic'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic'];
							}
							if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic_solo']) {
								$val3['duration_pic_solo'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic_solo'];
							}
							if ($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_non_rev']) {
								$val3['duration_non_rev'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_non_rev'];
							}

							if ($val['code'] != 'FLIGHT') {
								if (strpos($val3['duration'], ':') !== false) {
									array_push($total_duration, $val3['duration']);
								}
							} else {
								if (strpos($val3['duration_dual'], ':') !== false) {
									array_push($duration_dual, $val3['duration_dual']);
								} else if (strpos($val3['duration_solo'], ':') !== false) {
									array_push($duration_solo, $val3['duration_solo']);
								} else if (strpos($val3['duration_pic'], ':') !== false) {
									array_push($duration_pic, $val3['duration_pic']);
								} else if (strpos($val3['duration_pic_solo'], ':') !== false) {
									array_push($duration_pic_solo, $val3['duration_pic_solo']);
								} else if (strpos($val3['duration_non_rev'], ':') !== false) {
									array_push($duration_non_rev, $val3['duration_non_rev']);
								}
								$duration_dual = $this->template->sum_time($duration_dual);
								$duration_solo = $this->template->sum_time($duration_solo);
								$duration_pic = $this->template->sum_time($duration_pic);
								$duration_pic_solo = $this->template->sum_time($duration_pic_solo);
								$duration_non_rev = $this->template->sum_time($duration_non_rev);
								$duration_total[] = $duration_dual;
								$duration_total[] = $duration_solo;
								$duration_total[] = $duration_pic;
								$duration_total[] = $duration_pic_solo;
								$duration_total[] = $duration_non_rev;
								// print_r($duration_total);
								$val3['duration'] = $this->template->sum_time($duration_total);

								if (strpos($val3['duration'], ':') !== false) {
									array_push($total_duration, $val3['duration']);
								}
							}
						}
						$total_duration = $this->template->sum_time($total_duration);
						array_push($grand_total_duration, $total_duration);

						$text = "";
						if ($arr_course_selected[$val['code']][$val2['code']]['status'] == "ON") {
							$text = "checked";
						}

						$table_body .= '
                    <tr>   
                        <td><input ' . $text . ' type="checkbox" name="course[' . $val['code'] . '][' . $val2['code'] . '][status]" value="ON"></td>
                        <td class="text-left">' . $val2['code_name'] . ' - ' . $val2['name'] . '</td>
                        <td>' . $total_duration . '</td>
                       
                    </tr>
                    ';
					}
				}
				// print_r($grand_total_duration);
				$grand_total_duration = $this->template->sum_time($grand_total_duration);
				$table_body .= '
                <tr>   
                    <th class="text-right" colspan="2">TOTAL</th>
                    <th>' . $grand_total_duration . '</th>
                   
                </tr>
                ';



				$text = "";
				if ($arr_type_of_training_selected[$val['code']]['status'] == "ON") {
					$text = "checked";
				}


				$table .= ' 
                <table class="table table-bordered">
                    <tr class="bg-orange">
                        <th style="width:10px;"><input ' . $text . ' type="checkbox" name="type_of_training[' . $val['code'] . '][status]" value="ON"></th>
                        <th class="text-left"> ' . $val['name'] . '</th>
                        <th class="text-left" style="width:20px;">DURATION</th>
                    </tr>
                    ' . $table_body . '
                </table>';
			}
		}
		echo $table;
	}

	public function get_news()
	{

		$output = '';
		// print_r($_POST);
		$search = $_GET['keyword'];

		if ($search) {
			$event = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE status =  'ENABLE' AND title like '%$search%' ORDER BY date DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$event = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE status =  'ENABLE' ORDER BY date DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		}
		if ($event) {
			foreach ($event as $row) {
				$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'news'));

				if (empty($photo)) {
					$photo['dir'] = base_url() . 'webfile/no_image.png';
				} else {
					$photo['dir'] =  base_url() . 'webfile/' . $photo['name'];
				}



				if (strlen($row['title']) > 37) {
					$row['title'] = substr($row['title'], 0, 37) . '...';
				} else {
					$row['title'] = $row['title'];
				}


				$output .= '
				<a href="' . base_url("news/detail/") . ($row['id']) . '" class="a_black">
				<div class="col-md-4" style="margin-bottom:15px;">
				<div class="box">
					<img class="img-even" src="' . $photo['dir'] . '" style="height: 250px; width: 100%; object-fit: cover; display: inline;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
							<p>' . $row['title'] . '</p>
							<p>' . DATE('d M Y', strtotime($row['date'])) . '</p>
							</div>
						</div>
					</div>
				</div>
				</div>
				</a>';
			}
		}
		echo $output;
	}
}