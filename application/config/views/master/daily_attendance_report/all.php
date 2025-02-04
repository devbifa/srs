<?php
	$_SESSION['revise'] = '';
?>



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
               CREATE DAILY GROUND REPORT
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
                                <form autocomplete="off" action="<?= base_url() ?>master/daily_attendance_report/filter" method="post">
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

                                                    if($base_airport_document_record['id']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['id']."' ".$text." >".$base_airport_document_record['batch']."</option>";

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
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <a href="<?= base_url('fitur/export/daily_attendance_report') ?>" target="_blank">

<button type="button" class="btn btn-block btn-warning"><i class="mdi mdi-arrow-up-bold-circle-outline"></i> EXPORT</button> 

</a>
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <button type="button" class="btn  btn-block  btn-info" onclick="$('#modal-impor').modal()"><i class="mdi mdi-arrow-down-bold-circle-outline"></i> IMPORT</button>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->


                        
                        <div class="modal fade" id="modal-impor">

<div class="modal-dialog">

  <div class="modal-content">

    <div class="modal-header">

      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

      <h4 class="modal-title">IMPORT DATA</h4>

    </div>

    <form action="<?= base_url('fitur/import/daily_attendance_report') ?>" method="POST"  enctype="multipart/form-data">



    <div class="modal-body">

        <div class="form-group">

          <label for="">File Excel</label>

          <input required type="file" class="form-control" id="" name="file" placeholder="Input field">

        </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>

      <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Import</button>

    </div>

    </form>



  </div>

</div>

</div>

<?=$_SESSION['propose']?>
               <?php $_SESSION['propose'] = '' ?>

                        <div class="table-responsive">

<table class="table table-bordered"  id="datatable" style="width:100%">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NUM</th><th rowspan="2">ACTION</th>
<th style="min-width:110px;" rowspan="2">DATE</th>
<th rowspan="2" >CLASS<br>ROOM</th>
<th rowspan="2" >INSTRUCTOR</th>
<th rowspan="2" >BATCH</th>
<th rowspan="2" >COURSE</th><th rowspan="2" >SUBJECT</th><th colspan="3">TIME PLAN (UTC)</th><th colspan="3">TIME ACT (UTC)</th><th colspan="2" >PARTICIPANT</th> <th rowspan="2" >REMARK</th><th rowspan="2" >IRREG<br>CODE</th>

</th><th rowspan="2">
 PROPOSE
</th>
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
if($classroom){
  $classroom = "  AND a.classroom = '$classroom' ";
  }else{
  $classroom = " ";
  }

  if($batch){
  $batch = "  AND a.batch = '$batch' ";
  }else{
  $batch = " ";
  }

  $base = $_SESSION['origin_base'];

  if($base){
    $base = " AND b.station  = '$base' ";
  }else{
    $base = " ";
  }
 

  if($_SESSION['origin_base']){
    $approval = $this->mymodel->selectDataOne('approval',array('date'=>$_SESSION['start_date'],'base'=>$_SESSION['origin_base'],'type'=>'GROUND REPORT'));
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
  WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '0'  AND start_lt >= '22:00' AND start_lt <= '24:00'
   "
    .$base
    .$batch.
   "
  ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){
  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));
  
  $val['instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
  
  $val['classroom'] = $dat['station'].' '.$dat['classroom'];
  
  
  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));
  
  $val['subject'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];



if($approval AND $approval['prepared_time'] >= $val['created_at']){
$sent = '<span class="text-blue">Sent</span>';
}else{
$sent = '<span class="text-red">Not Sent</span>';
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
  ?>
<tr>
  <td><?=$nomor?>
  </td>
    
<td>
<?php
if($_SESSION['role_id']=='24'){ ?>
<?php if($val['station']==$user['base']){ ?>
  <a href="<?=base_url()?>master/daily_attendance_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>

<?php }else{ ?>
-
<?php } ?>

<?php }else{ ?>
<a href="<?=base_url()?>master/daily_attendance_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>

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
  <td><?=$val['remark']?></td>  <td><?=$val['remark_report']?></td> <td><?=$sent?></td> 
</tr>
<?php } ?>

<?php 

$data = $this->mymodel->selectWithQuery("SELECT a.*
FROM
daily_ground_schedule a
LEFT JOIN classroom b
ON a.classroom = b.code
WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1' AND a.visibility_report = '0' AND start_lt >= '00:00' AND start_lt <= '21:59'
 "
  .$base
  .$batch.
 "
ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){

  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));
  
  $val['instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
  
  $val['classroom'] = $dat['station'].' '.$dat['classroom'];
  
  
  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));
  
  $val['subject'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];

  
if($approval AND $approval['prepared_time'] >= $val['created_at']){
$sent = '<span class="text-blue">Sent</span>';
}else{
$sent = '<span class="text-red">Not Sent</span>';
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
  ?>
<tr>
  <td><?=$nomor?>
  </td>
    
<td>
<?php
if($_SESSION['role_id']=='24'){ ?>
<?php if($val['station']==$user['base']){ ?>
  <a href="<?=base_url()?>master/daily_attendance_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>

<?php }else{ ?>
-
<?php } ?>

<?php }else{ ?>
<a href="<?=base_url()?>master/daily_attendance_report/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>

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
  <td><?=$val['remark']?></td>  <td><?=$val['remark_report']?></td> <td><?=$sent?></td> 
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
  <tr>
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

<div class="row">
<div class="col-md-2 pull-right">
                                        <div class="">
                                            <label>&nbsp</label><br>
                                            <button class="btn btn-success btn-block"  data-toggle="modal" data-target="#modal-submit" id="button-submit"><i class="mdi mdi-send"></i> PROPOSE REPORT</button>
                                            
                                            <?php if(empty($_SESSION['origin_base'])){ ?>
                                              <div class="modal modal-danger fade" id="modal-submit">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">CONFIRMATION SUBMIT DATA</h4>
                                                          </div>
                                                          <div class="modal-body" style="color:#fff!important;">
                                                          <form action="">
                                                            <span style="font-weight:100">Please select origin base!</span>
                                                          </form>
                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                      
                                                          </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                      </div>
                                                      <!-- /.modal-dialog -->
                                                    </div>
                                            <?php }else if($nomor){ ?>
                                            <div class="modal modal-success fade" id="modal-submit">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">CONFIRMATION SUBMIT DATA</h4>
                                                          </div>
                                                          <div class="modal-body" style="color:#fff!important;">
                                                          <form action="">
                                                            <span style="font-weight:100">Are you sure you want to submit this data?</span>
                                                          </form>
                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                            <a type="button" class="btn btn-outline" href="<?=base_url()?>master/daily_ground_schedule/submit_report" id="submit-now" >Submit Now</a>
                                                          </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                      </div>
                                                      <!-- /.modal-dialog -->
                                                    </div>
                                            <?php }else{ ?>
                                              <div class="modal modal-danger fade" id="modal-submit">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">
                                                          <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">CONFIRMATION SUBMIT DATA</h4>
                                                          </div>
                                                          <div class="modal-body" style="color:#fff!important;">
                                                          <form action="">
                                                            <span style="font-weight:100">Data is empty. Please insert daily ground report!</span>
                                                          </form>
                                                          </div>
                                                          <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                                                      
                                                          </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                      </div>
                                                      <!-- /.modal-dialog -->
                                                    </div>
                                            <?php } ?>
                                        </div>
                                    </div>
									
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