<?php


$my_date = $_SESSION['start_date'];
$type = 'GROUND REPORT';
$origin_base = $_SESSION['origin_base'];

if($_SESSION['origin_base']){
  $location = $_SESSION['origin_base'];
}else{
  $location = 'ALL BASE';
}


$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$my_date' AND type = '$type' AND base = '$origin_base'
LIMIT 1");


$approval = $approval[0];


$left = '
  <p>'.$location.', '.DATE('d M Y', strtotime($approval['prepared_time'])).'</p>
  <p>Prepared By;
    ';
    $right = '<p style="color:#fff;">KARYA STUDIO</p><p>Acknowledged By;</p>
';


$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['prepared_by']));
$role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));
$file_prepared_by = $this->mymodel->selectDataOne('file', array('table'=>'file_signature', 'table_id' => $dat['id']));
$base_dat = $this->mymodel->selectDataOne('base_airport_document', array('id'=>$dat['base']));
$prepared_by = '<u>'.$dat['full_name'].'</u><br>'.$role['role'].' '.$base_dat['base'];


$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by']));
$role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));
$file_approved_by = $this->mymodel->selectDataOne('file', array('table'=>'file_signature', 'table_id' => $dat['id']));
$base_dat = $this->mymodel->selectDataOne('base_airport_document', array('id'=>$dat['base']));
$approved_by= '<u>'.$dat['full_name'].'</u><br>'.$role['role'].' '.$base_dat['base'];


if($approval['approval_status']=='APPROVED'){
  $right = $right.'<br>
  <img src="'.base_url().'webfile/'.$file_approved_by['name'].'" style="height:40px;">
  <br>'.$approved_by;
}else{
  $right = $right.'<br><br><br><br><br>'.$approved_by;
}



if($file_prepared_by['name']){
  $left = $left.'<br>
  <img src="'.base_url().'webfile/'.$file_prepared_by['name'].'" style="height:40px;">
  <br>'.$prepared_by;
}else{
  $left = $left.'<br><br><br><br><br>'.$prepared_by;
}




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
		

      if($batch){
        $batch = "  AND a.batch = '$batch' ";
        }else{
        $batch = " ";
        }
        
        $text = "";
        $base = $_SESSION['origin_base'];
    
    
    if($base){
      $base = " AND b.station  = '$base' ";
    }else{
      $base = " ";
    }
    



// print_r($data);
?>
<style>
  body{
    /* margin-top:-20px; */
    margin:-30px;
    margin-top:85px;
  }
  tr,th,td{
    border:1px #000 solid;
    padding:5px;
    font-size:9px;
    text-align:center;
  }
  th{
    text-align:center;
  }
  .text-left{
    text-align:left;
  }
  .text-center{
    text-align:center;
  }
  table{
    width: 100%;
  border-collapse: collapse;
  }
  
  .no-border{
    border-style:none;
    padding-left:0px;
    text-align:left:
  }
  p{
    margin:3px 0px;
  }
   .bg-success{
   background:#bfbfbf;
 }
</style>
<title>DAILY FLIGHT SCHEDULE</title>
<body>
<table class="table table-bordered table-striped" id="" style="width:100%">

<tr>
    <th colspan="18" style="font-size:12px;"><?=$date?>
    </th>
  </tr>
<tr class="bg-success">

<th style="width:20px" rowspan="2" >NUM</th>
<th rowspan="2" >CLASS<br>ROOM</th>
<th rowspan="2" >INSTRUCTOR</th>
<th rowspan="2" >TYPE</th>
<th rowspan="2" >BATCH</th>
<th rowspan="2" >TPM</th>
<th rowspan="2" >COURSE</th><th rowspan="2" >SUBJECT</th><th colspan="3">TIME PLAN (UTC)</th><th colspan="3">TIME ACT (UTC)</th><th colspan="2" >PARTICIPANT</th> <th rowspan="2" >REMARK</th><th rowspan="2" >IRREG<br>CODE</th>
 </tr>
 
 <tr class="bg-success">
	<th>START</th>
	<th>STOP</th>
	<th>DUR</th>
	<th>START</th>
	<th>STOP</th>
	<th>DUR</th>
	<th>PLAN</th>
	<th>ACT</th>
 </tr>


<?php
$total = array();
$total_actual = array();
$array_class = array();
$array_irregularities = array();
$array_subject = array();

$nomor = 0;
$data_date =  $this->template->date_range($start_date, $end_date);

foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>


<?php 
			$data = $this->mymodel->selectWithQuery("SELECT a.*
      FROM
      daily_ground_schedule a
      LEFT JOIN classroom b
      ON a.classroom = b.code
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '1'  AND start_lt >= '22:00' AND start_lt <= '24:00'
			 "
			 .$base
			 .$batch.
			 "
			ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){

   
  
  $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val['batch']));
  $temp = $val['batch'];
  $val['batch'] = $dat['batch'];
  if(empty($val['batch'])){
    $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
  }
  
  $this->db->select('code_name');
  $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val['tpm']));
  $temp = $val['tpm'];
  $val['tpm'] = $dat['code_name'];
  if(empty($val['tpm'])){
    $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
  }

$dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
$temp = $val['classroom'];
$val['classroom'] = $dat['classroom'];
if(empty($val['classroom'])){
  $val['classroom'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));

$temp = $val['instructor'];
$val['instructor'] = $dat['nick_name'];

if(empty($val['instructor'])){
  $val['instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}
$dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));

$temp = $val['subject'];
$val['subject'] = $dat['code_name'].' - '.$dat['name'];

if(($val['subject']) == ' - '){
$val['subject'] = '<a class="text-red"><b>'.$temp.'</b></a>';
} 

$dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));

$temp = $val['course'];
$val['course'] = $dat['code_name'];

if(($val['course']) == ' - '){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

	$nomor++;
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }

  if(!in_array($val['remark_report'],$array_irregularities)){
    if($val['remark_report']){
      array_push($array_irregularities,$val['remark_report']);
    }
  }

  if(!in_array($val['subject'],$array_subject)){
    array_push($array_subject,$val['subject']);
  }
  if (strpos($val['duration'], ':') !== false) {
    array_push($total,$val['duration']);
  }
  if (strpos($val['duration_act'], ':') !== false) {
    array_push($total_actual,$val['duration_act']);
  }
  $participant = 0;
  $attend = 0;
  $student_list = json_decode($val['student'],true);
  // print_r($student_list);
  $student_other = json_decode($val['student_other'],true);
  // print_r($student_other);
  
  $student_attend = json_decode($val['student_attend'],true);
  
  $student_other_attend = json_decode($val['student_other_attend'],true);

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

  foreach($student_attend as $key2=>$val2){

    if($val2['val']){
      $attend++;
    }
  }
  foreach($student_other_attend as $key2=>$val2){

    if($val2['check']=='on'){
      $attend++;
    }
  }

  $total2 = $total2 + $participant;
  $total3 = $total3 + $attend;
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  
  ?>
<tr>
  <td style="width:3%"><?=$nomor?>
  </td>
  <td style="width:15%"><?=$val['classroom']?></td> 
  <td class="text-left"  style="width:8%"><?=$val['instructor']?></td> <td style="width:5%" ><?=$val['type']?></td> 
  <td style="width:5%" ><?=$val['batch']?></td> <td style="width:5%" ><?=$val['tpm']?></td> 
  <td style="width:5%"  ><?=$val['course']?></td>
  <td class="text-left"><?=$val['subject']?></td>
  
  <td style="width:5%"><?=$val['start_lt']?></td> 
  <td style="width:5%"><?=$val['stop_lt']?></td> 
  <td style="width:5%"><?=$val['duration']?></td> 
  <td style="width:5%"><?=$val['start_act']?></td> 
  <td style="width:5%"><?=$val['stop_act']?></td> 
  <td style="width:5%"><?=$val['duration_act']?></td> 
  
  <td style="width:7%" ><?=$participant?></td> 
  
  <td style="width:7%" ><?=$attend?></td> 
  <td><?=$val['remark']?></td> 
  <td style="width:5%;"><?=$val['remark_report']?></td> 
</tr>
<?php }  ?>



<?php 
			$data = $this->mymodel->selectWithQuery("SELECT a.*
FROM
daily_ground_schedule a
LEFT JOIN classroom b
ON a.classroom = b.code
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '1'    AND start_lt >= '00:00' AND start_lt <= '21:59'
			 "
			 .$base
			 .$batch.
			 "
			ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){

  
  
  $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val['batch']));
  $temp = $val['batch'];
  $val['batch'] = $dat['batch'];
  if(empty($val['batch'])){
    $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
  }
  
  $this->db->select('code_name');
  $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val['tpm']));
  $temp = $val['tpm'];
  $val['tpm'] = $dat['code_name'];
  if(empty($val['tpm'])){
    $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
  }

$dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
$temp = $val['classroom'];
$val['classroom'] = $dat['classroom'];
if(empty($val['classroom'])){
  $val['classroom'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));

$temp = $val['instructor'];
$val['instructor'] = $dat['nick_name'];

if(empty($val['instructor'])){
  $val['instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}
$dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));

$temp = $val['subject'];
$val['subject'] = $dat['code_name'].' - '.$dat['name'];

if(($val['subject']) == ' - '){
$val['subject'] = '<a class="text-red"><b>'.$temp.'</b></a>';
} 

$dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));

$temp = $val['course'];
$val['course'] = $dat['code_name'];

if(($val['course']) == ' - '){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}
  
	$nomor++;
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }

  if(!in_array($val['remark_report'],$array_irregularities)){
    if($val['remark_report']){
      array_push($array_irregularities,$val['remark_report']);
    }
  }

  if(!in_array($val['subject'],$array_subject)){
    array_push($array_subject,$val['subject']);
  }
  if (strpos($val['duration'], ':') !== false) {
    array_push($total,$val['duration']);
  }
  if (strpos($val['duration_act'], ':') !== false) {
    array_push($total_actual,$val['duration_act']);
  }
   $participant = 0;
  $attend = 0;
  $student_list = json_decode($val['student'],true);
  // print_r($student_list);
  $student_other = json_decode($val['student_other'],true);
  // print_r($student_other);
  
  $student_attend = json_decode($val['student_attend'],true);
  
  $student_other_attend = json_decode($val['student_other_attend'],true);

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

  foreach($student_attend as $key2=>$val2){

    if($val2['val']){
      $attend++;
    }
  }
  foreach($student_other_attend as $key2=>$val2){

    if($val2['check']=='on'){
      $attend++;
    }
  }
  $total2 = $total2 + $participant;
  $total3 = $total3 + $attend;
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  
  ?>
<tr>
  <td style="width:3%"><?=$nomor?>
  </td>
  <td style="width:15%"><?=$val['classroom']?></td> 
  <td class="text-left"  style="width:8%"><?=$val['instructor']?></td> <td style="width:5%" ><?=$val['type']?></td> 
  <td style="width:5%" ><?=$val['batch']?></td> <td style="width:5%" ><?=$val['tpm']?></td> 
  <td style="width:5%"  ><?=$val['course']?></td>
  <td class="text-left"><?=$val['subject']?></td>
  <td style="width:5%"><?=$val['start_lt']?></td> 
  <td style="width:5%"><?=$val['stop_lt']?></td> 
  <td style="width:5%"><?=$val['duration']?></td> 
  <td style="width:5%"><?=$val['start_act']?></td> 
  <td style="width:5%"><?=$val['stop_act']?></td> 
  <td style="width:5%"><?=$val['duration_act']?></td> 
  
  <td style="width:7%" ><?=$participant?></td> 
  
  <td style="width:7%" ><?=$attend?></td> 
  <td><?=$val['remark']?></td> 
  <td style="width:5%;"><?=$val['remark_report']?></td> 
</tr>
<?php }  ?>


<?php } 
$total_subject = count($data);
$total_classroom = count($array_class);

$total_plan = $this->template->sum_time($total);

$total_actual = $this->template->sum_time($total_actual);

$total = ($nomor);
$total_subject = count($array_subject);
$total_irregularities = count($array_irregularities);
?>

</tbody>

</table>

<br><br>
<table>
  <tr>
    <th class="text-left no-border" style="width:15%">
    
    <p>TOTAL GROUND SCHEDULE</p> 
    
    <p>TOTAL SUBJECT</p> 

    <p>TOTAL CLASS ROOM IN USE </p>
  
  
    <p>TOTAL IRREGULARITIES</p> 
    
    </th>
    <th class="no-border" style="width:1%">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="width:15%">
    <p><?=$total?></p>
    <p><?=$total_subject?></p>
    <p><?=$total_classroom?></p>
    <p><?=intval($total_irregularities)?></p>
    </th>
    
    <th class="text-left no-border" style="width:15%;;">

    <p>TOTAL PLAN</p> 

    <p>TOTAL ACTUAL</p>
    <p>ACTUAL vs PLAN</p>
  
    </th>
    <th class="no-border" style="width:1%;">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="width:15%;">
    <p><?=$total_plan?></p>
    <p><?=$total_actual?></p>
    <?php
      $total_plan = (explode(":",$total_plan));
      $total_actual = (explode(":",$total_actual));

      $jam_plan = $total_plan[0] * 60;
      $jam_plan = $jam_plan + $total_plan[1];

      $jam_block_time = $total_actual[0] * 60;
      $jam_block_time = $jam_block_time + $total_actual[1];

      $persentase = number_format(($jam_block_time/$jam_plan)*100,1).' %';

    ?>
    <p><?=$persentase?></p>
    </th>
    <td class="no-border" style="width:25%;;">
    <?php 
    $user = $this->mymodel->selectDataOne('user',array('id'=>$_SESSION['id']));
    $role = $this->mymodel->selectDataOne('role',array('id'=>$user['role_id']));
    $base = $this->mymodel->selectDataOne('base_airport_document',array('id'=>$user['base']));
    ?>

<?=$left?>
</td>
    <td class="no-border" style="width:25%;vertical-align:top">
   <?=$right?>
</td>
  </tr>
</table>
</body>