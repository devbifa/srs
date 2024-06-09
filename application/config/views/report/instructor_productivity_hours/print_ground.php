<?php

$my_date = $_SESSION['start_date'];
$type = 'GROUND INSTRUCTOR PRODUCTIVITY';
$origin_base = $_SESSION['origin_base'];

if($_SESSION['origin_base']){
  $location = $_SESSION['origin_base'];
}else{
  $location = 'ALL BASE';
}


$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$my_date' AND type = '$type' AND base = '$origin_base'
LIMIT 1");


$approval = $approval[0];


// print_r($approval);

$left = '
  <p>'.$location.', '.DATE('d M Y', strtotime($approval['prepared_time'])).'</p>
  <p>Prepared By;
    ';
    $right = '<p>I hereby declare that the above report is in accordance
    with PT. BIFA requirements and regulations</p><p>Approved By;</p>
';



$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['prepared_by']));
$role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));
$file_prepared_by = $this->mymodel->selectDataOne('file', array('table'=>'file_signature', 'table_id' => $dat['id']));
$base_dat = $this->mymodel->selectDataOne('base_airport_document', array('id'=>$dat['base']));
$prepared_by = '<u>'.$dat['name'].'</u><br>'.$role['role'].' '.$base_dat['base'];


$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by']));
$role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));
$file_approved_by = $this->mymodel->selectDataOne('file', array('table'=>'file_signature', 'table_id' => $dat['id']));
$base_dat = $this->mymodel->selectDataOne('base_airport_document', array('id'=>$dat['base']));
$approved_by= '<u>'.$dat['name'].'</u><br>'.$role['role'].' '.$base_dat['base'];

$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by_2']));
$role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));
$file_approved_by_2 = $this->mymodel->selectDataOne('file', array('table'=>'file_signature', 'table_id' => $dat['id']));
$base_dat = $this->mymodel->selectDataOne('base_airport_document', array('id'=>$dat['base']));
$approved_by_2=  '<u>'.$dat['name'].'</u><br>'.$role['role'].' '.$base_dat['base'];

if($approval['approval_status']!='APPROVE'){
  if($approval['approved_by_2']){
    if($file_approved_by_2['name']){
      
      $right = $right.'<br>
      <img src="'.base_url().'webfile/'.$file_approved_by_2['name'].'" style="height:40px;">
      <br>'.$approved_by_2;
    }else{
      $right = $right.'<br><br><br><br><br>'.$approved_by_2;
    }
  }else{
    
    if($file_approved_by['name']){
      $right = $right.'<br>
      <img src="'.base_url().'webfile/'.$file_approved_by['name'].'" style="height:40px;">
      <br>'.$approved_by;
    }else{
      $right = $right.'<br><br><br><br><br>'.$approved_by;
    }
  }
}else{
  if($file_approved_by['name']){
    $right = $right.'<br>
    <img src="'.base_url().'webfile/'.$file_approved_by['name'].'" style="height:40px;">
    <br>'.$approved_by;
  }else{
    $right = $right.'<br><br><br><br><br>'.$approved_by;
  }
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


$batch = $_SESSION['batch'];
if($batch){
	$batch = "  AND a.batch = '$batch' ";
}else{
	$batch = " ";
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
    <th colspan="10" style="font-size:12px;"><?=$date?>
    </th>
  </tr>
  
<tr class="bg-success">

<th style="width:20px">NUM</th>
<th style="width:200px;" >FULL NAME</th>
<th style="width:200px;" >NICK NAME</th>
<th style="width:200px;" >EMPLOYEE<br>NUMBER</th>
<th>BASE</th>
<th>BATCH</th>
<th>DURATION</th>
<th>SUBJECT</th>
<th>TOTAL<br>DAY</th>
<th>TOTAL<br>TIME</th>
</tr>

<?php
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$type = 'GROUND';
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.type, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM user a
LEFT JOIN batch b
ON a.batch = b.id
WHERE   a.instructor_status = '1' AND a.full_name != '' AND a.type LIKE '%$type%' AND id_number NOT IN ('','-')
ORDER BY a.full_name ASC
");

?>


<?php

$total_duration = array();
foreach($instructor as $key=>$val){
$pic = $val['id'];
$data = $this->mymodel->selectWithQuery("SELECT a.*, a.subject as id_mission, e.name as subject
FROM daily_ground_schedule a
JOIN tpm_syllabus_all_course e
ON a.subject = e.id
WHERE a.visibility = '1'  AND a.instructor = '$pic' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
AND a.duration_act NOT IN ('-','','00:00')
GROUP BY a.subject
ORDER BY a.date ASC,a.start_lt ASC");

// print_r($data);


foreach($data as $key2=>$val2){
$id_mission = $val2['id_mission'];
$classroom = '';
$base = '';
$time = '';

$data_detail = $this->mymodel->selectWithQuery("SELECT a.start_act, a.stop_act, a.duration_act, a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,g.batch, CONCAT(c.base) as base,d.course_code as course,e.name as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
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
LEFT JOIN user f
ON a.instructor = f.id
JOIN batch g
ON a.batch = g.id
JOIN base_airport_document h
ON b.station = h.id
WHERE a.visibility = '1' AND a.instructor = '$pic' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND a.subject = '$id_mission'
AND a.duration_act NOT IN ('-','','00:00')
ORDER BY a.date ASC,a.start_lt ASC");

$day = $this->mymodel->selectWithQuery("SELECT a.id FROM
daily_ground_schedule a
WHERE a.visibility = '1' AND a.instructor = '$pic' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND a.subject = '$id_mission'
AND a.duration_act NOT IN ('-','','00:00')
GROUP BY DATE(a.date)
");

$day = count($day);


$total_day += $day;
$duration = array();
foreach($data_detail as $key3=>$val3){
$classroom .= $val3['batch'].'<br>';
$base .= $val3['base'].'<br>';
$time .= $val3['duration_act'].'<br>';

if (strpos($val3['duration_act'], ':') !== false) {
array_push($duration,$val3['duration_act']);
}

}




// }
$count = count($data); 

$duration = $this->template->sum_time($duration);
?>

<?php if($count >= 1 && $key2 == 0){
$no++;  
?>
<tr>
<td rowspan="<?=$count?>"><?=$no?>
<td class="text-left" rowspan="<?=$count?>"><?=$val['full_name']?>
</td>
<td class="text-left"><?=$val['nick_name']?></td>
<td class="text-left"><?=$val['id_number']?></td>
<td class="text-center"><?=$base?></td>
<td class="text-center"><?=$classroom?></td>
<td class="text-center"><?=$time?></td>
<td class="text-left"><?=$val2['subject']?></td>
<td class="text-center"><?=$day?></td>
<td class="text-center"><?=$duration?></td>
</tr>
<?php }else if($count >= 1 && $key2 != 0){ ?>
<tr>
<td class="text-left"><?=$val['nick_name']?></td>
<td class="text-left"><?=$val['id_number']?></td>
<td class="text-center"><?=$base?></td>
<td class="text-center"><?=$classroom?></td>
<td class="text-center"><?=$time?></td>
<td class="text-left"><?=$val2['subject']?></td>
<td class="text-center"><?=$day?></td>
<td class="text-center"><?=$duration?></td>
</tr>
<?php } ?>
<!-- <td class="text-left" rowspan="<?=$count?>"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-left" rowspan="<?=$count?>"><?=$val['id_number']?>
</td>

</td>
</tr> -->
<?php 

if (strpos($duration, ':') !== false) {
array_push($total_duration,$duration);
}

}


}



$total_duration = $this->template->sum_time($total_duration);

?>
<tr>
<th colspan="8" class="text-left">TOTAL</th>
<th><?=$total_day?></th>
<th><?=$total_duration?></th>
</tr>

</table>
<br><br>
<table>
  <tr>
    <th class="text-left no-border" style="width:15%">
   
    
    <p>TOTAL FTD SCHEDULE</p> 

    <p>TOTAL FTD IN USE </p>
  
    <p>TOTAL PLAN</p> 
    
    </th>
    <th class="no-border" style="width:1%">
  
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="width:15%">
 
    <p><?=$total_flight?></p>
    <p><?=$total_ftd?></p>
    <p><?=$total_plan?></p>
    </th>
    <td class="no-border" style="width:15%;">
    <?=$left?>
</td>
    <td class="no-border" style="width:30%;vertical-align:top">
   <?=$right?>
</td>
  </tr>
</table>
</body>