<?php
	$_SESSION['revise'] = '1';
?>
<style>
  .bg-grey{
    background: #9e9e9e63;
  }
</style>

 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY GROUND SCHEDULE

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">DAILY GROUND SCHEDULE</li>

        <li class="active">DATA</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
               REVISE  DAILY TRAINING REPORT
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-header">

              <div class="row">

                <div class="col-md-6">

                  <select onchange="loadtable(this.value)" id="select-status" style="width: 150px" class="form-control">

                      <option value="ENABLE">ENABLE</option>

                      <option value="DISABLE">DISABLE</option>



                  </select>

                </div>

                <div class="col-md-6">

                  <div class="pull-right">         
                  </div>

                </div>  

              </div>

              

            </div>

            <div class="box-body">

                <div class="show_error"></div>

                
            <!-- FILTER  -->
            <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>master/edit_training_report/filter" method="post">
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">ALL BASE</option>
                                                <?php 
                                                  $this->db->order_by('base ASC');

                                                  $id = $this->session->userdata('id');
                                                  $user = $this->mymodel->selectDataone('user',array('id'=>$id));
                                                  $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
                                                  $base_id = $user['base'];
                                                  $user['base'] = $base['base'];
                                                 
                                                  $base = $base['base'];
                                                  if($_SESSION['role_id']=='23'){
                                                    $base = " AND a.origin_base = '$base' ";
                                                   
                                                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document',array('id'=>$base_id));
                                                  }else{
                                                    $base = " ";
                                                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
                                                  }

                                                 

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['base']==$_SESSION['origin_base']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['base']."' ".$text." >".$base_airport_document_record['base']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>BATCH</label>
                                            <select style='width:100%' name="batch" class="form-control select2">
                                              <option value="">ALL BATCH</option>
                                                <?php 
                                                  $this->db->order_by('batch ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('batch',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['batch']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['batch']."' ".$text." >".$base_airport_document_record['batch']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>START DATE</label>
                                            <input placeholder="Start Date" type="text" class="form-control tgl" value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>END DATE</label>
                                            <input placeholder="End Date" type="text" class="form-control tgl" class="form-control" value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <button class="btn btn-success btn-block"><i class="mdi mdi-database-search"></i> FILTER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

                        <label for="">GROUND REPORT</label>

                        <div class="table-responsive">

<table class="table table-bordered"  id="datatable" style="width:100%">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NUM</th><th rowspan="2" style="min-width:100px;">ACTION</th>
<th style="min-width:110px;" rowspan="2">DATE</th>
<th rowspan="2" >CLASS<br>ROOM</th>
<th rowspan="2" >INSTRUCTOR</th>
<th rowspan="2" >BATCH</th>
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

</tr>

</thead>

<tbody>
<?php


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




$total = array();
$total_actual = array();
$array_class = array();
$array_irregularities = array();
$array_subject = array();
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];

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
ORDER BY a.date ASC,a.start_lt ASC, id_parent ASC");

foreach($data as $key=>$val){
  
  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));
  
  $val['instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
  
  $val['classroom'] = $dat['station'].' '.$dat['classroom'];
  
  
  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));
  
  $val['subject'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];
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

    if($val2['attend']){
      $attend++;
    }
  }
  foreach($student_other_attend as $key2=>$val2){

    if($val2['attend']=='on'){
      $attend++;
    }
  }
  $total2 = $total2 + $participant;
  $total3 = $total3 + $attend;
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  $class = "bg-grey";
  if($val['id_parent']=='0'){
  $class ="";
  }
  ?>
<tr class="<?=$class?>">
  <td><?=$nomor?>
  </td>
    
<td>

<?php
if($val['id_parent']=='0'){ ?>

<a href="#!" data-toggle="modal" data-target="#ground-revise-<?=$val['id']?>" class="btn btn-warning btn-xs btn-rounded"><i class="mdi mdi-pencil-off"></i></a>


<div class="modal modal-warning fade" id="ground-revise-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">REVISE REPORT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to revise this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/revise/ground/<?=$val['id']?>">Revise Now</a>
              </div>
            </div>
          </div>
        </div>


<?php }else{ ?>

  <a href="<?=base_url()?>master/daily_attendance_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
  <a href="#!" data-toggle="modal" data-target="#ground-delete-<?=$val['id']?>" class="btn btn-danger btn-xs btn-rounded"><i class="mdi mdi-delete"></i></a>

  <div class="modal modal-danger fade" id="ground-delete-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE REVISION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/delete/ground/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
          </div>
        </div>

<?php } ?>

</td>


  <td><?=DATE('d M Y',strtotime($val['date']))?></td><td><?=$val['classroom']?></td> <td class="text-left"><?=$val['instructor']?></td>  <td><?=$val['batch']?></td> <td><?=$val['course']?></td>
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id'],'table'=>'daily_ground_schedule'));
    if($file['name']){
      $val['subject'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['subject'].'</a>';
    }
    ?>
  <td class="text-left"><?=$val['subject']?></td>
   <td><?=$val['start_lt']?></td> <td><?=$val['stop_lt']?></td><td><?=$val['duration']?></td> 
   <td><?=$val['start_act']?></td> <td><?=$val['stop_act']?></td><td><?=$val['duration_act']?></td> 
   <td><?=$participant?></td> 
  <td><?=$attend?></td> 
  <td><?=$val['remark']?></td>  <td><?=$val['remark_report']?></td> 
</tr>
<?php } ?>

<?php 
$data = $this->mymodel->selectWithQuery("SELECT a.*
FROM
daily_ground_schedule a
LEFT JOIN classroom b
ON a.classroom = b.code
WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1'  AND a.visibility_report = '1'   AND start_lt >= '00:00' AND start_lt <= '21:59'
 "
 .$base
 .$batch.
 "
ORDER BY a.date ASC,a.start_lt ASC, id_parent ASC");

foreach($data as $key=>$val){
  

  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));
  
  $val['instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
  
  $val['classroom'] = $dat['station'].' '.$dat['classroom'];
  
  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));
  
  $val['subject'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];
  
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

    if($val2['attend']){
      $attend++;
    }
  }
  foreach($student_other_attend as $key2=>$val2){

    if($val2['attend']=='on'){
      $attend++;
    }
  }
  $total2 = $total2 + $participant;
  $total3 = $total3 + $attend;
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }

  $class = "bg-grey";
  if($val['id_parent']=='0'){
  $class ="";
  }

  ?>
<tr class="<?=$class?>">
  <td><?=$nomor?>
  </td>
    
<td>
  
<?php
if($val['id_parent']=='0'){ ?>

<a href="#!" data-toggle="modal" data-target="#ground-revise-<?=$val['id']?>" class="btn btn-warning btn-xs btn-rounded"><i class="mdi mdi-pencil-off"></i></a>


<div class="modal modal-warning fade" id="ground-revise-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">REVISE REPORT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to revise this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/revise/ground/<?=$val['id']?>">Revise Now</a>
              </div>
            </div>
          </div>
        </div>


<?php }else{ ?>

  <a href="<?=base_url()?>master/daily_attendance_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
  <a href="#!" data-toggle="modal" data-target="#ground-delete-<?=$val['id']?>" class="btn btn-danger btn-xs btn-rounded"><i class="mdi mdi-delete"></i></a>

  <div class="modal modal-danger fade" id="ground-delete-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE REVISION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/delete/ground/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
          </div>
        </div>

<?php } ?>

</td>


  <td><?=DATE('d M Y',strtotime($val['date']))?></td><td><?=$val['classroom']?></td> <td class="text-left"><?=$val['instructor']?></td>  <td><?=$val['batch']?></td> <td><?=$val['course']?></td> <td class="text-left">
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id'],'table'=>'daily_ground_schedule'));
    if($file['name']){
      $val['subject'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['subject'].'</a>';
    }
    ?>
  <?=$val['subject']?></td> 
  <td><?=$val['start_lt']?></td> <td><?=$val['stop_lt']?></td><td><?=$val['duration']?></td> 
  
  <td><?=$val['start_act']?></td> <td><?=$val['stop_act']?></td><td><?=$val['duration_act']?></td> 
  <td><?=$participant?></td> 
  <td><?=$attend?></td> 
  <td><?=$val['remark']?></td>  <td><?=$val['remark_report']?></td> 
</tr>
<?php } ?>


<?php }

$total_subject = count($data);
$total_classroom = count($array_class);

$total_plan = $this->template->sum_time($total);

$total_actual = $this->template->sum_time($total_actual);

$total = $nomor;
$total_subject = count($array_subject);
$total_irregularities = count($array_irregularities);

?>

</tbody>

</table>

              </div>

              
              <br><br>
              <div class="table-responsive">
<table>
  <tr >
    <th class="text-left no-border" style="min-width:250px;">
    
    <p>TOTAL GROUND SCHEDULE</p> 
    
    <p>TOTAL SUBJECT</p> 

    <p>TOTAL CLASS ROOM IN USE </p>
  
  
    <p>TOTAL IRREGULARITIES</p> 
    
    </th>
    <th class="no-border" style="min-width:15px">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px;">
    <p><?=$total?></p>
    <p><?=$total_subject?></p>
    <p><?=$total_classroom?></p>
    <p><?=intval($total_irregularities)?></p>
    </th>
    
    <th class="text-left no-border" style="min-width:250px;;">

    <p>TOTAL PLAN</p> 

    <p>TOTAL ACTUAL</p>
    <p>ACTUAL vs PLAN</p>
  
    </th>
    <th class="no-border" style="min-width:15px;">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px;;">
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
 

  </tr>
</table>

</div>



<br><br>
<label for="">FTD REPORT</label>

<div class="table-responsive">

<table class="table table-bordered" id="datatable" style="width:100%">

<thead>

<tr class="bg-success">
<th style="width:20px" rowspan="2" rowspan="2">NUM</th>
<th rowspan="2" style="min-width:100px;">ACTION</th> 
<th style="min-width:110px"  rowspan="2">DATE</th>
  <th rowspan="2">FTD MODEL</th>
  <th rowspan="2">INSTRUCTOR</th><th rowspan="2">STUDENT</th>
  <th rowspan="2">BATCH</th>
  <th rowspan="2">COURSE</th><th rowspan="2">MISSION</th>
  <th rowspan="2">ETD<br>UTC</th><th rowspan="2">ETA<br>UTC</th>
  <th rowspan="2">EET</th>
  <th colspan="3">BLOCK TIME</th>
  <th rowspan="2">REMARK</th>
  <th rowspan="2">IRREG<br>CODE</th>
</tr>
<tr class="bg-success">
  <th>ATD</th>
  <th>ATA</th>
  <th>TOTAL</th>
</tr>

</thead>

<tbody>

<?php
$duty_instructor = '';
$total = array();
$total2 = array();
$array_model = array();

$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$origin_base = '';
$nomor = 0;
$data_date =  $this->template->date_range($start_date, $end_date);

foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;

?>

<?php

$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_ftd_schedule a
WHERE  a.visibility = '1' AND a.visibility_report = '1' 
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
  "
  .$batch
  .$origin_base.
  "
ORDER BY a.date ASC, a.etd_utc ASC, id_parent ASC
"); 
foreach($data_utc as $key=>$val){

  $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
  $val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];


  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));

  $val['pic'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));

  $val['2nd'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));

  $val['duty_instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'SIM'));

  $val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];

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

    $class = "bg-grey";
    if($val['id_parent']=='0'){
    $class ="";
    }

  ?>
<tr class="<?=$class?>">
  <td><?=$nomor?>
  </td>
  <td>
  <?php
if($val['id_parent']=='0'){ ?>

<a href="#!" data-toggle="modal" data-target="#ftd-revise-<?=$val['id']?>" class="btn btn-warning btn-xs btn-rounded"><i class="mdi mdi-pencil-off"></i></a>


<div class="modal modal-warning fade" id="ftd-revise-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">REVISE REPORT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to revise this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/revise/ftd/<?=$val['id']?>">Revise Now</a>
              </div>
            </div>
          </div>
        </div>


<?php }else{ ?>

  <a href="<?=base_url()?>master/daily_ftd_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
  <a href="#!" data-toggle="modal" data-target="#ftd-delete-<?=$val['id']?>" class="btn btn-danger btn-xs btn-rounded"><i class="mdi mdi-delete"></i></a>

  <div class="modal modal-danger fade" id="ftd-delete-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE REVISION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/delete/ftd/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
          </div>
        </div>

<?php } ?>  
  </td>

  <td><?=DATE('d M Y',strtotime($val['date']))?></td><td class="text-left"><?=$val['ftd_model']?></td>
  <td class="text-left"><?=$val['pic']?></td><td class="text-left"><?=$val['2nd']?></td>
  <td><?=$val['batch']?></td>
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id'],'table'=>'daily_ftd_schedule'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
  <td class="text-left"><?=$val['mission']?></td>
  <td><?=$val['etd_utc']?></td><td><?=$val['eta']?></td>  
  <td><?=$val['eet_utc']?></td>
  
  <td><?=$val['block_time_atd']?></td>
  <td><?=$val['block_time_ata']?></td>
  <td><?=$val['block_time_total']?></td>
  <td class="text-left"><?=$val['remark']?></td>
  <td><?=$val['remark_report']?></td>
</tr>
<?php } ?>

<?php

$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_ftd_schedule a
WHERE  a.visibility = '1' AND a.visibility_report = '1' 
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND etd_utc >= '00:00' AND etd_utc <= '21:59'
  "
  .$batch
  .$origin_base.
  "
ORDER BY a.date ASC, a.etd_utc ASC, id_parent ASC
"); 
foreach($data_utc as $key=>$val){
  $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
    $val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];
  

    $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));
  
    $val['pic'] = $dat['nick_name'];
  
    $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));
  
    $val['2nd'] = $dat['nick_name'];
  
    $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));
  
    $val['duty_instructor'] = $dat['nick_name'];
  
    $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'SIM'));
  
    $val['mission'] = $dat['subject_mission'].' - '.$dat['name'];
  
    $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));
  
    $val['course'] = $dat['course_code'];
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

    $class = "bg-grey";
    if($val['id_parent']=='0'){
    $class ="";
    }
  ?>
<tr class="<?=$class?>">
  <td><?=$nomor?>
  </td>
  <td>
  <?php
if($val['id_parent']=='0'){ ?>

<a href="#!" data-toggle="modal" data-target="#ftd-revise-<?=$val['id']?>" class="btn btn-warning btn-xs btn-rounded"><i class="mdi mdi-pencil-off"></i></a>


<div class="modal modal-warning fade" id="ftd-revise-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">REVISE REPORT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to revise this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/revise/ftd/<?=$val['id']?>">Revise Now</a>
              </div>
            </div>
          </div>
        </div>


<?php }else{ ?>

  <a href="<?=base_url()?>master/daily_ftd_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
  <a href="#!" data-toggle="modal" data-target="#ftd-delete-<?=$val['id']?>" class="btn btn-danger btn-xs btn-rounded"><i class="mdi mdi-delete"></i></a>

  <div class="modal modal-danger fade" id="ftd-delete-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE REVISION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/delete/ftd/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
          </div>
        </div>

<?php } ?>   
</td>

  <td><?=DATE('d M Y',strtotime($val['date']))?></td><td class="text-left"><?=$val['ftd_model']?></td>
  <td class="text-left"><?=$val['pic']?></td><td class="text-left"><?=$val['2nd']?></td>
  <td><?=$val['batch']?></td>
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id'],'table'=>'daily_ftd_schedule'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
  <td class="text-left"><?=$val['mission']?></td>
  <td><?=$val['etd_utc']?></td><td><?=$val['eta']?></td>  
  <td><?=$val['eet_utc']?></td>
  
  <td><?=$val['block_time_atd']?></td>
  <td><?=$val['block_time_ata']?></td>
  <td><?=$val['block_time_total']?></td>
  <td class="text-left"><?=$val['remark']?></td>
  <td><?=$val['remark_report']?></td>
</tr>
<?php } ?>

<?php }
$total =  $this->template->sum_time($total);
$total2 =  $this->template->sum_time($total2);

// print_r($array_model);
$total_plan = $total;
$total_block_time = $total2;
$total_ftd = count($array_model);
$total_flight = $nomor;

?>
<!-- <tr class="<?=$class?>">
    <th colspan="10" class="text-right">TOTAL PLAN</th>
    <th><?=$total?></th>
    <th colspan="3" class="text-right">TOTAL BLOCK TIME</th>
    <th><?=$total2?></th>
    <th></th> -->
  </tr>
</tbody>

</table>

              </div>

              <br><br>
              <div class="table-responsive">
<table>
  <tr >
    <th class="text-left no-border" style="min-width:250px;">
    
    <p>TOTAL FTD SCHEDULE</p> 

    <p>TOTAL FTD ACTIVITY  </p>
 
  
    <p>TOTAL IRREGULARITIES</p> 
    
    </th>
    <th class="no-border" style="min-width:15px">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px;">
    <p><?=$total_flight?></p>
    <p><?=intval($total_movement)?></p>
    <p><?=intval($total_irregularities)?></p>
    </th>
    
    <th class="text-left no-border" style="min-width:250px;;">

    <p>TOTAL PLAN</p> 

    <p>TOTAL BLOCK TIME</p>
    <p>ACTUAL vs PLAN</p>
  
    </th>
    <th class="no-border" style="min-width:15px;">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px;;">
    <p><?=$total_plan?></p>
    <p><?=$total_block_time?></p>
    <?php
      $total_plan = (explode(":",$total_plan));
      $total_block_time = (explode(":",$total_block_time));

      $jam_plan = $total_plan[0] * 60;
      $jam_plan = $jam_plan + $total_plan[1];

      $jam_block_time = $total_block_time[0] * 60;
      $jam_block_time = $jam_block_time + $total_block_time[1];

      $persentase = number_format(($jam_block_time/$jam_plan)*100,1).' %';

    ?>
    <p><?=$persentase?></p>
    </th>
 

  </tr>
</table>
</div>

<br><br>
<label for="">FLIGHT REPORT</label>



<div class="table-responsive">

<table class="table table-bordered" id="datatable"  style="width:100%">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NO</th>
<th rowspan="2" style="min-width:100px;">ACTION</th>
<th style="min-width:110px" rowspan="2">DATE OF<br>FLIGHT</th><th rowspan="2">ORIGIN<br>BASE</th><th rowspan="2">AIRCRAFT<br>REG</th><th rowspan="2">PIC</th><th rowspan="2">2ND</th>

<th rowspan="2">BATCH</th>
<th rowspan="2">COURSE</th><th rowspan="2">MISSION</th>
<!-- <th rowspan="2">DESCRIPTION</th> -->
<th rowspan="2">DEP</th><th rowspan="2">ARR</th>
<th rowspan="2">ROUTE</th><th rowspan="2">ETD<br>UTC</th><th rowspan="2">ETA<br>UTC</th><th rowspan="2">EET</th>
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


<tbody>

<?php 
$id = $this->session->userdata('id');
$user = $this->mymodel->selectDataone('user',array('id'=>$id));
$base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
$user['base'] = $base['base'];

$base = $base['base'];
if($_SESSION['role_id']=='23'){
  $base = " AND a.origin_base = '$base' ";
}else{
  $base = " ";
}

$batch = $_SESSION['batch'];
if($batch){
  $batch = " AND a.batch = '$batch' ";
}else{
  $batch = "";
}

$data_date =  $this->template->date_range( $start_date, $end_date);
$duty_instructor = '';
$total = array();
$total2 = array();
$total3 = array();
$array_aircraft = array();
$array_duty_instructor = array();

$nomor = 0;
foreach($data_date as $v=>$k){
$start_date = $k;
$end_date = $k;
?>

<?php
$data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '1'  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
AND a.type = '' "
.$batch
.$origin_base
.$base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC, id_parent ASC");

foreach($data as $key=>$val){

  
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

if($val['remark_dmr']){
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


$class = "bg-grey";
if($val['id_parent']=='0'){
$class ="";
}
?>
<tr class="<?=$class?>">
<td><?=$nomor?></td>
<td>


<?php
if($val['id_parent']=='0'){ ?>

<a href="#!" data-toggle="modal" data-target="#flight-revise-<?=$val['id']?>" class="btn btn-warning btn-xs btn-rounded"><i class="mdi mdi-pencil-off"></i></a>


<div class="modal modal-warning fade" id="flight-revise-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">REVISE REPORT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to revise this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/revise/flight/<?=$val['id']?>">Revise Now</a>
              </div>
            </div>
          </div>
        </div>


<?php }else{ ?>

  <a href="<?=base_url()?>master/daily_movement_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
  <a href="#!" data-toggle="modal" data-target="#ftd-flight-<?=$val['id']?>" class="btn btn-danger btn-xs btn-rounded"><i class="mdi mdi-delete"></i></a>

  <div class="modal modal-danger fade" id="ftd-flight-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE REVISION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/delete/flight/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
          </div>
        </div>

<?php } ?>  

</td>

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
<td><?=$val['block_time_start']?></td>
<td><?=$val['block_time_stop']?></td>
<td><?=$val['block_time_total']?></td>
<td><?=$val['flight_time_take_off']?></td>
<td><?=$val['flight_time_landing']?></td>
<td><?=$val['flight_time_total']?></td>
<td><?=$val['ldg']?></td>
<td><?=$val['remark']?></td>
<td><?=$val['remark_dmr']?></td>
<td><?=$val['duty_instructor']?></td>
</tr>
<?php } ?>

<?php
$data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '1'  AND etd_utc >= '00:00' AND etd_utc <= '21:59'
"
.$batch
.$origin_base
.$base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC, id_parent ASC");

foreach($data as $key=>$val){
  
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

if($val['remark_dmr']){
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

$class = "bg-grey";
if($val['id_parent']=='0'){
$class ="";
}
?>
<tr class="<?=$class?>">
<td><?=$nomor?></td>
<td>


<?php
if($val['id_parent']=='0'){ ?>

<a href="#!" data-toggle="modal" data-target="#flight-revise-<?=$val['id']?>" class="btn btn-warning btn-xs btn-rounded"><i class="mdi mdi-pencil-off"></i></a>


<div class="modal modal-warning fade" id="flight-revise-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">REVISE REPORT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to revise this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/revise/flight/<?=$val['id']?>">Revise Now</a>
              </div>
            </div>
          </div>
        </div>


<?php }else{ ?>

  <a href="<?=base_url()?>master/daily_movement_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
  <a href="#!" data-toggle="modal" data-target="#ftd-flight-<?=$val['id']?>" class="btn btn-danger btn-xs btn-rounded"><i class="mdi mdi-delete"></i></a>

  <div class="modal modal-danger fade" id="ftd-flight-<?=$val['id']?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE REVISION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this report?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>features/delete/flight/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
          </div>
        </div>

<?php } ?>  


</td>

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
<td><?=$val['block_time_start']?></td>
<td><?=$val['block_time_stop']?></td>
<td><?=$val['block_time_total']?></td>
<td><?=$val['flight_time_take_off']?></td>
<td><?=$val['flight_time_landing']?></td>
<td><?=$val['flight_time_total']?></td>
<td><?=$val['ldg']?></td>
<td><?=$val['remark']?></td>
<td><?=$val['remark_dmr']?></td>
<td><?=$val['duty_instructor']?></td>
</tr>
<?php } ?>



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


<!-- <tr class="<?=$class?>">
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

<br><br>
<div class="table-responsive">
<table>


<tr >
<th class="text-left no-border">
<p>DUTY INSTRUCTOR</p>

</th>
<th class="no-border">
<p>:</p>
</th>
<th class="text-left no-border" colspan=4>
<p><?=$text?></p>
</th>

</td>

</td>
</tr>


<tr >
<th class="text-left no-border" style="min-width:250px;">

<p>TOTAL FLIGHT SCHEDULE</p> 

<p>TOTAL MOVEMENT </p>
<p>TOTAL LANDING </p>

<p>TOTAL IRREGULARITIES</p> 

</th>
<th class="no-border" style="min-width:15px;;">
<p>:</p>
<p>:</p>
<p>:</p>
<p>:</p>
</th>
<th class="text-left no-border" style="min-width:250px;">
<p><?=$total_flight?></p>
<p><?=intval($total_movement)?></p>
<p><?=intval($total_ldg)?></p>
<p><?=intval($total_irregularities)?></p>
</th>

<th class="text-left no-border" style="min-width:250px;">

<p>TOTAL PLAN</p> 

<p>TOTAL BLOCK TIME</p>

<p>TOTAL FLIGHT TIME</p> 

<p>ACTUAL vs PLAN</p> 

</th>
<th class="no-border" style="min-width:15px;">
<p>:</p>
<p>:</p>
<p>:</p>
<p>:</p>
</th>
<th class="text-left no-border" style="min-width:250px;">
<p><?=$total_plan?></p>
<p><?=$total_block_time?></p>
<p><?=$total_flight_time?></p>
<?php
$total_plan = (explode(":",$total_plan));
$total_block_time = (explode(":",$total_block_time));

$jam_plan = $total_plan[0] * 60;
$jam_plan = $jam_plan + $total_plan[1];

$jam_block_time = $total_block_time[0] * 60;
$jam_block_time = $jam_block_time + $total_block_time[1];

$persentase = number_format(($jam_block_time/$jam_plan)*100,1).' %';

?>
<p><?=$persentase?></p>
</th>

</tr>
</table>
</div>


            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->


  <div class="modal fade bd-example-modal-sm" tabindex="-1" daily_ground_schedule="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

      <div class="modal-dialog modal-sm">

          <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/daily_attendance_report/delete') ?>">

              <div class="modal-header">

                  <h5 class="modal-title">Confirm delete</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                      <span aria-hidden="true">&times;</span>

                  </button>

              </div>

              <div class="modal-body">

                  <input type="hidden" name="id" id="delete-input">

                  <p>Are you sure to delete this data?</p>

              </div>

              <div class="modal-footer">

                  <button type="submit" class="btn btn-danger btn-send">Yes, Delete</button>

                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

              </div>

              </form>

          </div>

      </div>

  </div> 



  <div class="modal fade" id="modal-impor">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

          <h4 class="modal-title">IMPORT DATA</h4>

        </div>

        <form action="<?= base_url('fitur/impor/daily_ground_schedule') ?>" method="POST"  enctype="multipart/form-data">



        <div class="modal-body">

            <div class="form-group">

              <label for="">File Excel</label>

              <input type="file" class="form-control" id="" name="file" placeholder="Input field">

            </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>

          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>

        </div>

        </form>



      </div>

    </div>

  </div>



  <script type="text/javascript">

$('#submit-now').click(function(){
        $('#button-submit').addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i> Processing...").attr('disabled',true);
        $('#submit-now').addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i> Processing...").attr('disabled',true);
      });


  </script>