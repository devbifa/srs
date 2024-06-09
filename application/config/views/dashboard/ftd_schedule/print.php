<?php

$my_date = $_SESSION['start_date'];
$type = 'FTD';
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
    <th colspan="11" style="font-size:12px;"><?=$date?>
    </th>
  </tr>
<tr class="bg-success">
<th>NO</th>
<th>FTD MODEL</th><th>INSTRUCTOR</th><th>STUDENT</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>

</tr>



<?php
$nomor = 0;
$duty_instructor = '';
$total = array();
$array_model = array();
$data_date =  $this->template->date_range($start_date, $end_date);
foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>

<?php 
	$data_utc = $this->mymodel->selectWithQuery("SELECT *
  FROM daily_ftd_schedule a

  WHERE  a.visibility = '1' AND a.visibility_report = '0'
  AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
    "
    .$batch
    .$origin_base.
    "
  ORDER BY a.date ASC, a.etd_utc ASC
  ");
// print_r($data_date);

foreach($data_utc as $key=>$val){

$dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
$val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];


$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));

$val['pic'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));

$val['2nd'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));

$val['duty_instructor'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

$val['course'] = $dat['course_code'];
  $nomor++;
  if(!in_array($val['ftd_model'],$array_model)){
    array_push($array_model,$val['ftd_model']);
  }
  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet_utc'], ':') !== false) {
    array_push($total,$val['eet_utc']);
  }
 
    $val['pic'] = $val['pic'];

  ?>
  
  <tr>
  <td style="width:3%"><?=$nomor?>
  </td>
<td class="text-left" style="width:11%"><?=$val['ftd_model']?></td>
<td class="text-left" style="width:10%"><?=$val['pic']?></td>
<td class="text-left" style="width:10%"><?=$val['2nd']?></td>
<td style="width:5%"><?=$val['batch']?></td>
<td class="text-left" style="width:5%"><?=$val['course']?></td>

  <td class="text-left" style="width:30%"><?=$val['mission']?></td>
  <td style="width:3%"><?=$val['etd_utc']?></td>
  <td style="width:3%"><?=$val['eta']?></td>
  <td style="width:3%"><?=$val['eet_utc']?></td>
  <td class="text-left" style="width:18%"><?=$val['remark']?></td>
  </tr>
<?php } ?>


<?php 
	$data_utc = $this->mymodel->selectWithQuery("SELECT *
  FROM daily_ftd_schedule a
  WHERE  a.visibility = '1' AND a.visibility_report = '0'
  AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'  AND etd_utc >= '00:00' AND etd_utc <= '21:59'
    "
    .$batch
    .$origin_base.
    "
  ORDER BY a.date ASC, a.etd_utc ASC
  ");
  
// print_r($data_date);
// $duty_instructor = '';
// $total = array();
// $array_model = array();
foreach($data_utc as $key=>$val){

$dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
$val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];


$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));

$val['pic'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));

$val['2nd'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));

$val['duty_instructor'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

$val['course'] = $dat['course_code'];

  $nomor++;
  if(!in_array($val['ftd_model'],$array_model)){
    array_push($array_model,$val['ftd_model']);
  }
  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet_utc'], ':') !== false) {
    array_push($total,$val['eet_utc']);
  }
 
    $val['pic'] = $val['pic'];

  ?>
  
  <tr>
  <td style="width:3%"><?=$nomor?>
  </td>
<td class="text-left" style="width:11%"><?=$val['ftd_model']?></td>
<td class="text-left" style="width:10%"><?=$val['pic']?></td>
<td class="text-left" style="width:10%"><?=$val['2nd']?></td>
<td style="width:5%"><?=$val['batch']?></td>
<td class="text-left" style="width:5%"><?=$val['course']?></td>

  <td class="text-left" style="width:30%"><?=$val['mission']?></td>
  <td style="width:3%"><?=$val['etd_utc']?></td>
  <td style="width:3%"><?=$val['eta']?></td>
  <td style="width:3%"><?=$val['eet_utc']?></td>
  <td class="text-left" style="width:18%"><?=$val['remark']?></td>
  </tr>
<?php } ?>


<?php }
// print_r($array_model);
  $total_plan = $this->template->sum_time($total);
  $total_ftd = count($array_model);
  $total_flight = $nomor;
?>


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