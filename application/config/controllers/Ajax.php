<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ajax extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		
	}

	function get_course_by_batch(){
		$batch = $_GET['batch'];
		$batch = $this->mymodel->selectDataOne('batch', array('batch'=>$batch));
		// $curriculum = $this->mymodel->selectDataOne('curriculum', array('id'=>$batch['curriculum']));
		$curriculum = $batch['curriculum'];
		$data = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$curriculum' ORDER BY position ASC");
		$text = '<option value="">SELECT COURSE</option>';
		foreach($data as $key=>$val){
			$text .= '<option value="'.$val['code'].'">'.$val['course_code'].'</option>';
		}
		echo $text;
	}

	function get_mission_detail(){
		$mission = $_GET['mission'];
		$mission = $this->mymodel->selectDataOne('tpm_syllabus_all_course', array('code'=>$mission));

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
	
	
function get_2nd_by_batch(){
	$batch = $_GET['batch'];
	$type = $_GET['type'];
	if($type=='FLIGHT'){
echo  '<option value="-">SELECT 2ND/INSTRUCTOR</option>';
		$instructor = $this->mymodel->selectWhere('user',array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'")); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$daily_flight_schedule['pic']){

$text = "selected";

}

if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id_number']."' ".$text." >".$val['full_name']."</option>";
}

}

		}else if($type=='FTD'){
			echo  '<option value="">SELECT PIC/INSTRUCTOR</option>';
		$instructor = $this->mymodel->selectWhere('user',array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'")); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$daily_flight_schedule['pic']){

$text = "selected";

}

if (strpos($val['type'], 'FTD') !== false) {
echo "<option value='".$val['id_number']."' ".$text." >".$val['full_name']."</option>";
}

}	
		}
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE batch = '$batch' AND status = 'ACTIVE'");
		$text = '<option value="">SELECT STUDENT</option>';
		foreach($data as $key=>$val){
			$text .= '<option value="'.$val['id_number'].'">'.$val['id_number'].'</option>';
		}
		echo $text;
	}
	

function get_pic_by_batch(){
	$batch = $_GET['batch'];
	$type = $_GET['type'];
	if($type=='FLIGHT'){
		
echo  '<option value="">SELECT PIC/INSTRUCTOR</option>';
		$instructor = $this->mymodel->selectWhere('user',array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'")); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$daily_flight_schedule['pic']){

$text = "selected";

}

if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id_number']."' ".$text." >".$val['full_name']."</option>";
}

}

		}else if($type=='FTD'){
			echo  '<option value="">SELECT PIC/INSTRUCTOR</option>';
		$instructor = $this->mymodel->selectWhere('user',array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'")); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$daily_flight_schedule['pic']){

$text = "selected";

}

if (strpos($val['type'], 'FTD') !== false) {
echo "<option value='".$val['id_number']."' ".$text." >".$val['full_name']."</option>";
}

}	
		}
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE batch = '$batch' AND status = 'ACTIVE'");
		$text = '<option value="">SELECT STUDENT</option>';
		foreach($data as $key=>$val){
			$text .= '<option value="'.$val['id_number'].'">'.$val['id_number'].'</option>';
		}
		echo $text;
	}
	

	function get_student_by_batch(){
		$batch = $_GET['batch'];
		$data = $this->mymodel->selectWithQuery("SELECT * FROM user a
		WHERE a.batch='$batch' AND a.status='ACTIVE'");
		$text = '<option value="">SELECT STUDENT</option>';
		foreach($data as $key=>$val){
			$text .= '<option value="'.$val['id_number'].'">'.$val['id_number'].' - '.$val['full_name'].'</option>';
		}
		echo $text;
	}

	function get_mission_by_course(){
		$course = $_GET['course'];
		$type = $_GET['type'];
		if($type=='FLIGHT'){
			$data = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = 'FLIGHT' ORDER BY position ASC");
		// echo "SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = 'FLIGHT' ORDER BY position ASC";
		}else if($type=='FTD'){
			$data = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = 'SIM' ORDER BY position ASC");
		}else if($type=='GROUND'){
			$data = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = 'GROUND' ORDER BY position ASC");
		}
		$text = '<option value="">SELECT MISSION</option>';
		foreach($data as $key=>$val){
			$text .= '<option value="'.$val['code'].'">'.$val['subject_mission'].' - '.$val['name'].'</option>';
		}
		echo $text;
	}
	
	function get_tpm(){
		$batch = $_GET['batch'];
		$batch = $this->mymodel->selectDataOne('batch',array('batch'=>$batch));

		$curriculum = $this->mymodel->selectDataOne('curriculum', array('code'=>$batch['curriculum']));
		echo '<option value="'.$curriculum['code'].'">'.($curriculum['curriculum']).'</option>';
	}
	function get_training(){
		


		$batch = $_GET['batch'];
		$batch = $this->mymodel->selectDataOne('batch',array('batch'=>$batch));
		// echo 123;
		$curriculum = $this->mymodel->selectDataOne('curriculum', array('code'=>$batch['curriculum']));
		// print_r($curriculum);
		$id_curriculum = $curriculum['code'];
		
						//  $id_curriculum = $curriculum['id'];
						 $data = $this->mymodel->selectWithQuery("SELECT * FROM training_type WHERE curriculum='$id_curriculum' ORDER BY pos ASC");
						//  print_r($data);
						 foreach($data as $key=>$val){
	   
						   $text = "";
						   if (strpos($course['configuration'], $val['id']) !== false) {
							//  $text = "checked";
						   }
									   
						   $table_body = '';
					   
					   $configuration = '"val":"'.$val['id'].'"';
					   $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");
					 
					   $grand_total_duration = array();
					   foreach($course as $key2=>$val2){    
					   $text = '';
					   if($training_requirement[$val['id']]['item'][$val2['id']]['val']==$val2['id']){
						//    $text = 'checked';
					   }    
					   
					   $course = $val2['code'];
					   $curriculum = $val2['curriculum'];
					   $type = $val['id'];
					   // $this->db->order_by("position ASC");
					   $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY position ASC");
					   $total_duration = array();
					   foreach($mission as $key3=>$val3){ 
						 if (strpos($val3['duration'], ':') !== false) {
						   array_push($total_duration,$val3['duration']);
						 }
					   }
					   $total_duration = $this->template->sum_time($total_duration);
					   array_push($grand_total_duration,$total_duration);
					   $table_body .= '
						   <tr>   
							   <td><input '.$text.' type="checkbox" name="dtt['.$val['id'].'][item]['.$val2['id'].'][val]" value="'.$val2['id'].'"></td>
							   <td class="text-left">'.$val2['course_code'].' - '.$val2['course_name'].'</td>
							   <td>'.$total_duration.'</td>
							  
						   </tr>
						   ';
					   }
					   // print_r($grand_total_duration);
					   $grand_total_duration = $this->template->sum_time($grand_total_duration);
					   $table_body .= '
					   <tr>   
						   <th class="text-right" colspan="2">TOTAL</th>
						   <th>'.$grand_total_duration.'</th>
						  
					   </tr>
					   ';
	   
					   $text = '';
					   if($training_requirement[$val['id']]['val']['name']==$val['id']){
						//    $text = 'checked';
					   }  
	   
					   $table = ' 
					   <table class="table table-bordered">
						   <tr class="bg-orange">
							   <th style="width:10px;"><input '.$text.' type="checkbox"  name="dtt['.$val['id'].'][val][name]" value="'.$val['id'].'"></th>
							   <th class="text-left"> '.$val['training_type'].'</th>
							   <th class="text-left" style="width:20px;">DURATION</th>
						   </tr>
						   '.$table_body.'
					   </table>';
	   
						 
	   
						 echo $table; 
					
						  } 
						 
						 
						  
						 $data = $this->mymodel->selectWithQuery("SELECT * FROM type_of_training");
						 $no = 0;
						 foreach($data as $key=>$val){
						   $text = "";
						   if (strpos($course['configuration'], $val['type_of_training']) !== false) {
							//  $text = "checked";
						   }
						  
						   $table_body = '';
					   $configuration = '"val":"'.$val['type_of_training'].'"';
					   $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC");
					
					   //    echo "SELECT * FROM course WHERE curriculum = '$id_curriculum' AND configuration LIKE '%$configuration%' ORDER BY position ASC";
						//    print_r($course);
					   $grand_total_duration_flight = array();
					   $grand_total_duration = array();
					   foreach($course as $key2=>$val2){
					   $text = '';
					   if($training_requirement[$val['value']]['item'][$val2['id']]['val']==$val2['id']){
						//    $text = 'checked';
					   }    
					   
					   $course = $val2['code'];
					   $curriculum = $val2['curriculum'];
					   $type = $val['type_of_training'];
					   // $this->db->order_by("position ASC");
					   $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY position ASC");
					   $total_duration = array();
					   $total_dual = array();
					   $total_solo = array();
					   $total_pic = array();
					   $total_pic_solo = array();
					   $total = array();
					   foreach($mission as $key3=>$val3){ 
						 if (strpos($val3['duration'], ':') !== false) {
						   array_push($total_duration,$val3['duration']);
						 }
	   
						 if (strpos($val3['duration_dual'], ':') !== false) {
						   array_push($total_dual,$val3['duration_dual']);
						 }
						 if (strpos($val3['duration_solo'], ':') !== false) {
						   array_push($total_solo,$val3['duration_solo']);
						 }
						 if (strpos($val3['duration_pic'], ':') !== false) {
						   array_push($total_pic,$val3['duration_pic']);
						 }
						 if (strpos($val3['duration_pic_solo'], ':') !== false) {
						   array_push($total_pic_solo,$val3['duration_pic_solo']);
						 }
					   }
					   $total_duration = $this->template->sum_time($total_duration);
					   array_push($grand_total_duration,$total_duration);
					   
					   $total_dual = $this->template->sum_time($total_dual);
					   $total_solo = $this->template->sum_time($total_solo);
					   $total_pic = $this->template->sum_time($total_pic);
					   $total_pic_solo = $this->template->sum_time($total_pic_solo);
						
					   $total[0] = $total_dual;
					   $total[1] = $total_solo;
					   $total[2] = $total_pic;
					   $total[3] = $total_pic_solo;
	   
					   $total =  $this->template->sum_time($total);
					   
					   array_push($grand_total_duration_flight,$total);
	   
					   if($val['type_of_training']=='FLIGHT'){
						   $table_body .= '
						   <tr>   
							   <td><input '.$text.' type="checkbox" name="dtt['.$val['value'].'][item]['.$val2['id'].'][val]" value="'.$val2['id'].'"></td>
							   <td class="text-left">'.$val2['course_code'].' - '.$val2['course_name'].'</td>
							   <td>'.$total.'</td>
							  
						   </tr>
						   ';
					   }else{
					   $table_body .= '
						   <tr>   
							   <td><input '.$text.' type="checkbox" name="dtt['.$val['value'].'][item]['.$val2['id'].'][val]" value="'.$val2['id'].'"></td>
							   <td class="text-left">'.$val2['course_code'].' - '.$val2['course_name'].'</td>
							   <td>'.$total_duration.'</td>
							  
						   </tr>
						   ';
					   }
					   }
					   
					  
					   if($val['type_of_training']=='FLIGHT'){
						   $grand_total_duration_flight = $this->template->sum_time($grand_total_duration_flight);
						   $table_body .= '
							   <tr>   
								   <th class="text-right" colspan="2">TOTAL</th>
								 
								   <th>'.$grand_total_duration_flight.'</th>
							   </tr>
							   ';
					   }else{
					   $grand_total_duration = $this->template->sum_time($grand_total_duration);
					   $table_body .= '
						   <tr>   
							   <th class="text-right" colspan="2">TOTAL</th>
							 
							   <th>'.$grand_total_duration.'</th>
						   </tr>
						   ';
					   }
						   $text = '';
						   if($training_requirement[$val['value']]['val']['name']==$val['value']){
							//    $text = 'checked';
						   }  
	   
					   $table = ' 
					   <table class="table table-bordered">
						   <tr class="bg-orange">
							   <th style="width:10px;"><input '.$text.' type="checkbox"  name="dtt['.$val['value'].'][val][name]" value="'.$val['value'].'"></th>
							   <th class="text-left"> '.$val['value'].'</th>
							   <th class="text-left" style="width:20px;">DURATION</th>
						   </tr>
						   '.$table_body.'
					   </table>';
	   
						 
	   
						 echo $table; 
						  
						  $no++; } 
						
						}

						function get_student_list_by_batch(){
							echo '<div class="table-responsive">
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
                      <tbody>';
                      
                      $i = 0;
                      $batch = $_GET['batch'];
					  $student = $this->mymodel->selectWithQuery("SELECT a.*, b.batch as batch_text FROM user a
					  LEFT JOIN batch b ON a.batch = b.id WHERE a.batch='$batch' AND a.status='ACTIVE'");
                      $student_list = json_decode($_GET['student'],true);
                      $student_list_other = json_decode($_GET['student_other'],true);
                      
                      $table_body = '';
                      foreach($student as $key=>$val){ 
                      $text = '';
                      if($student_list[$val['id']]['val']==$val['id']){
                        $text = 'checked';
                      }
                      $table_body .= '<tr id="'.$i.'">
                      <td>'.($i+1).'
                     </td>
                      <td>
                     
                      '.$val['batch'].'
                     </td>
                      <td>'.$val['id_number'].'
                     </td>
                      <td class="text-left">'.$val['full_name'].'
                     </td>
                      <td class="text-left">'.$val['id_number'].'
                     </td>
                     <td>
                       <input type="checkbox" checked name="dtt['.$val['id_number'].'][val]" value="'.$val['id'].'">
                     </td>

                   </tr>';

                   $i++;

                
                        }

                        echo $table_body;

                        
                        $batch_data = $this->mymodel->selectWithQuery("SELECT a.*, b.curriculum FROM batch a LEFT JOIN curriculum b ON a.curriculum = b.id");

                        
                        
                        

                        $table_body = '';
                        foreach($student_list_other as $key=>$val){
                             if($val['check']=='on'){
                                    $text = '';
                                    if($student_list[$val['id']]['val']==$val['id']){
                                      $text = 'checked';
                                    }

                                 
                                    $text2 = '<option value="">SELECT BATCH</option>';
                                    foreach($batch_data as $key2=>$val2){
                                      $text = "";
                                      if($val['batch']==$val2['id']){
                                        $text = "selected";
                                      }
                                      $text2 .= "<option ".$text." value='".$val2['id']."' ".$text." >".$val2['batch'].' ('.$val2['curriculum'].")</option>";
                                    }

                                    $student_text = '<option value="">SELECT STUDENT</option>';
                                    $batch = $val['batch'];
                                    $student_list = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE batch='$batch' AND status='ACTIVE'");
                                    foreach($student_list as $key2=>$val2){
                                      $text = "";
                                      if($val['id_number']==$val2['id']){
                                        $text = "selected";
                                      }
                                      $student_text .= "<option ".$text." value='".$val2['id']."' ".$text." >".$val2['full_name']."</option>";
                                    }

                                    $student_detail = $this->mymodel->selectDataOne('user',array('id'=>$val['id_number']));

                                    $table_body .= '<tr id="'.$i.'">
                                    <td>'.($i+1).'
                                  </td>
                                    <td>
                                      <select required style="width:100%" name="dttt['.$i.'][batch]" class="select2 batch" id="batch'.$i.'">
                                        '.$text2.'
                                      </select>
                                  </td>
                                    <td colspan="3">
                                    <select required style="width:100%" name="dttt['.$i.'][id_number]" class="select2 id_number" id="id_number'.$i.'">
                                        '.$student_text.'
                                      </select>
                                  </td>
                                  <td>
                                    <input type="checkbox" '.$text.'  name="dttt['.$i.'][check]" value="on" checked>
                                  </td>
              
                                </tr>';
              
                                $i++;
                             }
                        }
                        echo $table_body;
                        
                      

                      
                      $batch = $this->mymodel->selectDataOne('batch', array('id'=>$_GET['batch']));
                      $curriculum = $this->mymodel->selectDataOne('curriculum', array('id'=>$batch['curriculum']));
                      $curriculum = $curriculum['id'];
                      $batch_data = $this->mymodel->selectWithQuery("SELECT a.*, b.curriculum FROM batch a LEFT JOIN curriculum b ON a.curriculum = b.id");

                      
 echo '<tbody>
</table>
                      </div>
                      </div>';
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
				
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] =  base_url().'webfile/'.$photo['name'];
				}
				


				if(strlen($row['title']) > 37 ){ 
					$row['title'] = substr($row['title'],0,37).'...'; 
				}else{ 
					$row['title'] = $row['title']; 
				}

				
				$output .= '
				<a href="' . base_url("news/detail/") . ($row['id']). '" class="a_black">
				<div class="col-md-4" style="margin-bottom:15px;">
				<div class="box">
					<img class="img-even" src="' . $photo['dir']. '" style="height: 250px; width: 100%; object-fit: cover; display: inline;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
							<p>'.$row['title'].'</p>
							<p>'.DATE('d M Y', strtotime($row['date'])).'</p>
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