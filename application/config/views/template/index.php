<?php
	$user = $_SESSION['id'];
    $user = $this->mymodel->selectDataOne('user', array('id'=>$user));
    // $instructor = $this->mymodel->selectDataOne('student_application_form',array('id_number'=>$user['nip']));
    $_SESSION['id_instructor'] = $instructor['id'];

    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
            
?>

<div class="content-wrapper">


    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Student_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $student_document['id'] ?>">


<style>
.blink_me {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>


      <div class="row">

        <div class="col-md-12">

          <div class="box" style="min-height: 1000px;margin-bottom:0px!important;">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                <?=strtoupper($this->template->date_indo3(DATE('Y-m-d')))?>
                <i class="fa fa-dot-circle-o blink_me " style="font-weight:700"></i>
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-body" style="min-height:500px;">
           
            <script src="<?=base_url()?>assets/eocjs-newsticker.js"></script>
            <link rel="stylesheet" href="<?=base_url()?>assets/eocjs-newsticker.css">
           
            <marquee direction="left"  style="background-color: #eeeeee;padding:7px 0px;">
            <?php 
      $news = $this->mymodel->selectWithQuery("SELECT * FROM news ORDER BY date DESC LIMIT 15");
      foreach($news as $key=>$val){
           $text .= '<a href="' . base_url("news/detail/") . ($val['date']).'/'.($val['id']). '" class="">'.$val['title'].'</a> | ';
          }
          echo $text = $text.$text.$text.$text.$text;
      ?>
            </marquee>

            <div class="row">

            <div class="col-md-12">
                    
                    <h4 style="padding-bottom:15px"><b><span  style="border-bottom:4px #066265 solid">DAILY FLIGHT SCHEDULE</span></b></h4>
                    <div class="table-responsive">

<table class="table table-bordered table-striped datatable_without_page2"  style="width:100%;">

<thead>

<tr class="bg-success">

<th style="width:20px">NO</th><th style="min-width:110px">DATE OF<br>FLIGHT</th><th>ORIGIN<br>BASE</th><th>AIRCRAFT<br>REG</th><th>PIC</th><th>2ND</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>DEP</th><th>ARR</th><th>ROUTE</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>

</tr>

</thead>


<tbody>
<?php 

$start_date = DATE('Y-m-d');
$end_date = DATE('Y-m-d');

$data_date =  $this->template->date_range( $start_date, $end_date);

$duty_instructor = '';
$total = array();
$array_aircraft = array();

$array_duty_instructor = array();

$nomor = 0;
foreach($data_date as $v=>$k){
$start_date = $k;
$end_date = $k;
?>


<?php
$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a

WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = '' AND etd_utc >= '22:00' AND etd_utc <= '24:00'
AND a.type = ''
"
.$batch
.$origin_base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");


foreach($data_utc as $key=>$val){

$nomor++;

$dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
$temp = $val['aircraft_reg'];
$val['aircraft_reg'] = $dat['serial_number'];
if(empty($val['aircraft_reg'])){
  $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('batch',array('batch'=>$val['batch']));
$temp = $val['batch'];
$val['batch'] = $dat['batch'];
if(empty($val['batch'])){
  $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
$temp = $val['pic'];
$val['pic'] = $dat['nick_name'];

if(empty($val['pic'])){
  $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));

$temp = $val['duty_instructor'];
$val['duty_instructor'] = $dat['nick_name'];

if(empty($val['duty_instructor'])){
  $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$temp = $val['mission'];
$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

if(($val['mission']) == ' - '){
  $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));


$temp = $val['course'];
$val['course'] = $dat['course_code'];

if(empty($val['course'])){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$total_ldg += $val['ldg'];
$nomor++;
if(!in_array($val['aircraft_reg'],$array_aircraft)){
  array_push($array_aircraft,$val['aircraft_reg']);
}

if(!in_array($val['duty_instructor'],$array_duty_instructor)){
  array_push($array_duty_instructor,$val['duty_instructor']);
}

if($val['duty_instructor']){
  $duty_instructor = $val['duty_instructor'];
}

if(!in_array($val['remark_report'],array('','-'))){
  $total_irregularities = $total_irregularities + 1;
}
if (strpos($val['block_time_start'], ':') !== false) {
  $total_movement = $total_movement + 1;
}
if (strpos($val['eet'], ':') !== false) {
  array_push($total,$val['eet']);
}



if (strpos($val['block_time_total'], ':') !== false) {
  array_push($total2,$val['block_time_total']);
}

if (strpos($val['flight_time_total'], ':') !== false) {
  array_push($total3,$val['flight_time_total']);
}


  $val['pic'] = $val['pic'];

?>
<tr>
<td><?=$nomor?></td>
<td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
<td><?=$val['origin_base']?></td>
<td><?=$val['aircraft_reg']?></td>
<td class="text-left"><?=$val['pic']?></td>
<td class="text-left"><?=$val['2nd']?></td>

<td><?=$val['batch']?></td>
<td><?=$val['course']?></td>
<?php 
$file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
if($file['name']){
$val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
}
?>
<td class="text-left"><?=$val['mission']?></td>
<td><?=$val['dep']?></td>
<td><?=$val['arr']?></td>
<td class="text-left"><?=$val['rute']?></td>
<td><?=$val['etd_utc']?></td>
<td><?=$val['eta_utc']?></td>
<td><?=$val['eet']?></td>
<td class="text-left"><?=$val['remark']?></td>
</tr>
<?php } ?>


<?php
$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a

WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = '' AND etd_utc >= '00:00' AND etd_utc <= '21:59'
AND a.type = ''
"
.$batch
.$origin_base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");



foreach($data_utc as $key=>$val){

$nomor++;

$dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
$temp = $val['aircraft_reg'];
$val['aircraft_reg'] = $dat['serial_number'];
if(empty($val['aircraft_reg'])){
  $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('batch',array('batch'=>$val['batch']));
$temp = $val['batch'];
$val['batch'] = $dat['batch'];
if(empty($val['batch'])){
  $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
$temp = $val['pic'];
$val['pic'] = $dat['nick_name'];

if(empty($val['pic'])){
  $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));

$temp = $val['duty_instructor'];
$val['duty_instructor'] = $dat['nick_name'];

if(empty($val['duty_instructor'])){
  $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$temp = $val['mission'];
$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

if(($val['mission']) == ' - '){
  $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));


$temp = $val['course'];
$val['course'] = $dat['course_code'];

if(empty($val['course'])){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$total_ldg += $val['ldg'];
$nomor++;
if(!in_array($val['aircraft_reg'],$array_aircraft)){
  array_push($array_aircraft,$val['aircraft_reg']);
}

if(!in_array($val['duty_instructor'],$array_duty_instructor)){
  array_push($array_duty_instructor,$val['duty_instructor']);
}

if($val['duty_instructor']){
  $duty_instructor = $val['duty_instructor'];
}

if(!in_array($val['remark_report'],array('','-'))){
  $total_irregularities = $total_irregularities + 1;
}
if (strpos($val['block_time_start'], ':') !== false) {
  $total_movement = $total_movement + 1;
}
if (strpos($val['eet'], ':') !== false) {
  array_push($total,$val['eet']);
}



if (strpos($val['block_time_total'], ':') !== false) {
  array_push($total2,$val['block_time_total']);
}

if (strpos($val['flight_time_total'], ':') !== false) {
  array_push($total3,$val['flight_time_total']);
}


  $val['pic'] = $val['pic'];

?>
<tr>
<td><?=$nomor?></td>
<td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
<td><?=$val['origin_base']?></td>
<td><?=$val['aircraft_reg']?></td>
<td class="text-left"><?=$val['pic']?></td>
<td class="text-left"><?=$val['2nd']?></td>

<td><?=$val['batch']?></td>
<td><?=$val['course']?></td>
<?php 
$file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
if($file['name']){
$val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
}
?>
<td class="text-left"><?=$val['mission']?></td>
<td><?=$val['dep']?></td>
<td><?=$val['arr']?></td>
<td class="text-left"><?=$val['rute']?></td>
<td><?=$val['etd_utc']?></td>
<td><?=$val['eta_utc']?></td>
<td><?=$val['eet']?></td>
<td class="text-left"><?=$val['remark']?></td>
</tr>
<?php } ?>

<?php

}



$total = $this->template->sum_time($total);
$total_plan = $total;
$total_aircraft = count($array_aircraft);
$total_flight = $nomor;

?>

<?php
$text = "";
foreach($array_duty_instructor as $key=>$val){
if($val){
$text .= ''.$val.', ';
}
}
$text = substr($text,0,-2);

?>


<!-- <tr>
<th colspan="12" class="text-right">TOTAL PLAN</th>
<th><?=$total?></th>
<th colspan="3"></th>
</tr> -->

<?php
if($nomor < 1){
    echo '<tr><td colspan="16">No Schedule Available</td></tr>';
}
?>
</tbody>

</table>
</div>



                    </div>


                    <div class="col-md-12">
                    
                    <h4 style="padding-bottom:15px;margin-top:15px;"><b><span  style="border-bottom:4px #066265 solid">DAILY FLIGHT REPORT</span></b></h4>
                    <div class="table-responsive">

<table class="table table-bordered table-striped datatable_without_page2"  style="width:100%">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NO</th>
<th style="min-width:110px" rowspan="2">DATE OF<br>FLIGHT</th><th rowspan="2">ORIGIN<br>BASE</th><th rowspan="2">AIRCRAFT<br>REG</th><th rowspan="2">PIC</th><th rowspan="2">2ND</th>
<th rowspan="2">BATCH</th>
<th rowspan="2">COURSE</th><th rowspan="2">MISSION</th>
<!-- <th rowspan="2">DESCRIPTION</th> -->
<th rowspan="2">DEP</th><th rowspan="2">ARR</th>
<th rowspan="2">ROUTE</th>
<th colspan="3">SCHEDULE</th>
<th rowspan="2">REMARK</th>

<th colspan="3">
BLOCK TIME
</th>
<th colspan="3">
FLIGHT TIME
</th>
<th rowspan="2">TOTAL<br>LDG</th>
<th rowspan="2">REMARK</th>
<th rowspan="2">
IRREG
<br>CODE
</th><th rowspan="2">
DUTY
<br>INSTRUCTOR
</th>
</tr>

<tr class="bg-success">
<th>
    ETD
</th>
<th>
    ETA
</th>
<th>
    EET
</th>
<th style="min-width:50px;">
START
</th>
<th style="min-width:50px;">
STOP
</th>
<th style="min-width:50px;">
TOTAL
</th>
<th style="min-width:50px;">
T/OFF
</th>
<th style="min-width:50px;">
LDG
</th>
<th style="min-width:50px;">
TOTAL
</th>
</tr>

</thead>

<?php 


$data_date =  $this->template->date_range( $start_date, $end_date);

$duty_instructor = '';
$total = array();
$total2 = array();
$total3 = array();
$array_aircraft = array();
$array_duty_instructor = array();


$array_duty_instructor = array();

$nomor = 0;
foreach($data_date as $v=>$k){
$start_date = $k;
$end_date = $k;
?>

<tbody>
<?php 

$data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a

WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''  AND a.visibility_report = '1' AND etd_utc >= '22:00' AND etd_utc <= '24:00'
AND a.type = ''
"
.$batch
.$origin_base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");

foreach($data as $key=>$val){
$nomor++;

$dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
$temp = $val['aircraft_reg'];
$val['aircraft_reg'] = $dat['serial_number'];
if(empty($val['aircraft_reg'])){
  $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('batch',array('batch'=>$val['batch']));
$temp = $val['batch'];
$val['batch'] = $dat['batch'];
if(empty($val['batch'])){
  $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
$temp = $val['pic'];
$val['pic'] = $dat['nick_name'];

if(empty($val['pic'])){
  $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));

$temp = $val['duty_instructor'];
$val['duty_instructor'] = $dat['nick_name'];

if(empty($val['duty_instructor'])){
  $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$temp = $val['mission'];
$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

if(($val['mission']) == ' - '){
  $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));


$temp = $val['course'];
$val['course'] = $dat['course_code'];

if(empty($val['course'])){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$total_ldg += $val['ldg'];
$nomor++;
if(!in_array($val['aircraft_reg'],$array_aircraft)){
  array_push($array_aircraft,$val['aircraft_reg']);
}

if(!in_array($val['duty_instructor'],$array_duty_instructor)){
  array_push($array_duty_instructor,$val['duty_instructor']);
}

if($val['duty_instructor']){
  $duty_instructor = $val['duty_instructor'];
}

if(!in_array($val['remark_report'],array('','-'))){
  $total_irregularities = $total_irregularities + 1;
}
if (strpos($val['block_time_start'], ':') !== false) {
  $total_movement = $total_movement + 1;
}
if (strpos($val['eet'], ':') !== false) {
  array_push($total,$val['eet']);
}



if (strpos($val['block_time_total'], ':') !== false) {
  array_push($total2,$val['block_time_total']);
}

if (strpos($val['flight_time_total'], ':') !== false) {
  array_push($total3,$val['flight_time_total']);
}


  $val['pic'] = $val['pic'];

?>
<tr>
<td><?=$nomor?></td>
<td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
<td><?=$val['origin_base']?></td>
<td><?=$val['aircraft_reg']?></td>
<td class="text-left"><?=$val['pic']?></td>
<td class="text-left"><?=$val['2nd']?></td>
<td><?=$val['batch']?></td>
<td><?=$val['course']?></td>
<?php 
$file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id'],'table'=>'daily_flight_schedule'));
// print_r($file);
if($file['name']){
$val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
}
?>
<td class="text-left"><?=$val['mission']?></td>
<!-- <td><?=$val['description']?></td> -->
<td><?=$val['dep']?></td>
<td><?=$val['arr']?></td>
<td class="text-left"><?=$val['rute']?></td>
<td><?=$val['etd_utc']?></td>
<td><?=$val['eta_utc']?></td>
<td><?=$val['eet']?></td>
<td class="text-left"><?=$val['remark']?></td>
<td><?=$val['block_time_start']?></td>
<td><?=$val['block_time_stop']?></td>
<td><?=$val['block_time_total']?></td>
<td><?=$val['flight_time_take_off']?></td>
<td><?=$val['flight_time_landing']?></td>
<td><?=$val['flight_time_total']?></td>
<td><?=$val['ldg']?></td>
<td class="text-left"><?=$val['remark_2']?></td>
<td><?=$val['remark_report']?></td>
<td><?=$val['duty_instructor']?></td>
</tr>
<?php 
$total_ldg = $total_ldg + $val['ldg'];
} ?>


<?php 

$data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''  AND a.visibility_report = '1'  AND etd_utc >= '00:00' AND etd_utc <= '21:59'
AND a.type = ''
"
.$batch
.$origin_base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");

foreach($data as $key=>$val){
$nomor++;


$dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
$temp = $val['aircraft_reg'];
$val['aircraft_reg'] = $dat['serial_number'];
if(empty($val['aircraft_reg'])){
  $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('batch',array('batch'=>$val['batch']));
$temp = $val['batch'];
$val['batch'] = $dat['batch'];
if(empty($val['batch'])){
  $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
$temp = $val['pic'];
$val['pic'] = $dat['nick_name'];

if(empty($val['pic'])){
  $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));

$temp = $val['duty_instructor'];
$val['duty_instructor'] = $dat['nick_name'];

if(empty($val['duty_instructor'])){
  $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$temp = $val['mission'];
$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

if(($val['mission']) == ' - '){
  $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));


$temp = $val['course'];
$val['course'] = $dat['course_code'];

if(empty($val['course'])){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$total_ldg += $val['ldg'];
$nomor++;
if(!in_array($val['aircraft_reg'],$array_aircraft)){
  array_push($array_aircraft,$val['aircraft_reg']);
}

if(!in_array($val['duty_instructor'],$array_duty_instructor)){
  array_push($array_duty_instructor,$val['duty_instructor']);
}

if($val['duty_instructor']){
  $duty_instructor = $val['duty_instructor'];
}

if(!in_array($val['remark_report'],array('','-'))){
  $total_irregularities = $total_irregularities + 1;
}
if (strpos($val['block_time_start'], ':') !== false) {
  $total_movement = $total_movement + 1;
}
if (strpos($val['eet'], ':') !== false) {
  array_push($total,$val['eet']);
}



if (strpos($val['block_time_total'], ':') !== false) {
  array_push($total2,$val['block_time_total']);
}

if (strpos($val['flight_time_total'], ':') !== false) {
  array_push($total3,$val['flight_time_total']);
}


  $val['pic'] = $val['pic'];

?>
<tr>
<td><?=$nomor?></td>
<td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
<td><?=$val['origin_base']?></td>
<td><?=$val['aircraft_reg']?></td>
<td class="text-left"><?=$val['pic']?></td>
<td class="text-left"><?=$val['2nd']?></td>
<td><?=$val['batch']?></td>
<td><?=$val['course']?></td>
<?php 
$file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id'],'table'=>'daily_flight_schedule'));
// print_r($file);
if($file['name']){
$val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
}
?>
<td class="text-left"><?=$val['mission']?></td>
<!-- <td><?=$val['description']?></td> -->
<td><?=$val['dep']?></td>
<td><?=$val['arr']?></td>
<td class="text-left"><?=$val['rute']?></td>
<td><?=$val['etd_utc']?></td>
<td><?=$val['eta_utc']?></td>
<td><?=$val['eet']?></td>
<td class="text-left"><?=$val['remark']?></td>
<td><?=$val['block_time_start']?></td>
<td><?=$val['block_time_stop']?></td>
<td><?=$val['block_time_total']?></td>
<td><?=$val['flight_time_take_off']?></td>
<td><?=$val['flight_time_landing']?></td>
<td><?=$val['flight_time_total']?></td>
<td><?=$val['ldg']?></td>
<td class="text-left"><?=$val['remark_2']?></td>
<td><?=$val['remark_report']?></td>
<td><?=$val['duty_instructor']?></td>
</tr>
<?php 
$total_ldg = $total_ldg + $val['ldg'];
} ?>

<?php

}

$total_plan = $this->template->sum_time($total);
$total2 = $this->template->sum_time($total2);
$total3 = $this->template->sum_time($total3);

$total_aircraft = count($array_aircraft);
$total_flight = $nomor;
$total_block_time = $total2;
$total_flight_time = $total3;

?>

<?php
$text = "";
foreach($array_duty_instructor as $key=>$val){
if($val){
$text .= ''.$val.', ';
}
}
$text = substr($text,0,-2);

?>


<!-- <tr>
<th colspan="12" class="text-right">TOTAL PLAN</th>
<th><?=$total_plan?></th>
<th colspan="4" class="text-right">TOTAL BLOCK TIME</th>
<th><?=$total2?></th>
<th colspan="2" class="text-right">TOTAL FLIGHT TIME</th>
<th><?=$total3?></th>
<th><?=$total_ldg?></th>
<th colspan="3"></th>
</tr> -->
</tbody>

</table>
</div>



                    </div>

          <div class="col-md-12">
                    
          <h4 style="padding:15px 0px"><b><span  style="border-bottom:4px #066265 solid">DAILY NEWS</span></b></h4>
                            <div class="row">
                           
                            <?php
$search = $_GET['keyword'];

if ($search) {
    $event = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE status =  'ENABLE' AND title like '%$search%' ORDER BY date DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
} else {
    $event = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE status =  'ENABLE' ORDER BY date DESC LIMIT 6");
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


        $user = $this->mymodel->selectDataOne('user',array('id'=>$row['created_by']));

        $output .= '
        <a href="' . base_url("news/detail/") . ($row['date']).'/'.($row['id']). '" class="">
        <div class="col-md-4" style="margin-bottom:15px;">
        <div class="box">
            <img class="img-even" src="' . $photo['dir']. '" style="height: 250px; width: 100%; object-fit: cover; display: inline;">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" align="center">
                    <p style="font-size:17px;color:#066265">'.$row['title'].'</p>
                    <p style="color:#066265"><i class="mdi mdi-calendar-clock"></i> '.DATE('d M Y', strtotime($row['date'])).'</p>
                    <p style="color:#066265"> <i class="mdi mdi-pencil"></i>'.$user['full_name'].'</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </a>';
    }
}
echo $output;
                            ?>
                            
                        </div>


</div>


                
               
        </div>


        
            <div>
        
      </div>

      <!-- /.row -->

      </form>



    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  <script type="text/javascript">

      $("#upload-create").submit(function(){

            var form = $(this);

            var mydata = new FormData(this);

            $.ajax({

                type: "POST",

                url: form.attr("action"),

                data: mydata,

                cache: false,

                contentType: false,

                processData: false,

                beforeSend : function(){

                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/Student_document') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>
