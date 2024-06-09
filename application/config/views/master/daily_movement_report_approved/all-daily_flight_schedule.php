<?php 
$total = array();
$total2 = array();
$total3 = array();
$total_ldg = 0;
	
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$origin_base = $_SESSION['origin_base'];
$keyword = $_SESSION['keyword'];



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

if($keyword){
  $keyword = "  AND b.serial_number = '$keyword' ";
}else{
  $keyword = " ";
}

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
?>



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FLIGHT SCHEDULE

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">DAILY FLIGHT SCHEDULE</li>

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
               APPROVED DAILY FLIGHT REPORT
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

               

              </div>

              

            </div>

            <div class="box-body">

             <!-- FILTER  -->
             <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>master/daily_movement_report_approved/filter" method="post">
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">ALL BASE</option>
                                                <?php 
                                                  // $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);

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
                                            <label>KEYWORD</label>
                                            <input placeholder="End Date" type="text" class="form-control" class="form-control" value="<?= $_SESSION['keyword'] ?>" name="keyword" autocomplete="off">
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

                <div class="show_error"></div>



                <div class="table-responsive">

              <table class="table table-bordered table-striped" id="datatable"  style="width:100%">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NO</th>
<!-- <th rowspan="2">ACTION</th> -->
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

$irreg = $_GET['irreg'];
$irreg_type = $_GET['irreg_type'];
if($irreg){
  $qry_irreg = " AND remark_dmr = '$irreg' ";
}
if($irreg_type){
  $dat = $this->mymodel->selectWithQuery("SELECT * FROM delay_and_cancel_code WHERE type = '$irreg_type'");
  $t = "'AANG',";
  foreach($dat as $k=>$v){
    $t .= "'".$v['code']."',";
  }
   $t = substr($t,0,-1);
  $qry_irreg = " AND remark_dmr IN ($t) ";
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
"
.$keyword
.$batch
.$origin_base
.$base.$qry_irreg.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");

foreach($data as $key=>$val){

  
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
.$keyword
.$batch
.$origin_base
.$base.$qry_irreg.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");

foreach($data as $key=>$val){
 
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

            <br><br>
            <div class="table-responsive">
<table>


<tr>
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


<tr>
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


  <div class="modal modal-danger fade" id="modal-delete">

  <div class="modal-dialog">
            <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/daily_movement_report/delete') ?>">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE DATA</h4>
              </div>

              <div class="modal-body">

                  <input type="hidden" name="id" id="delete-input">

                  <p>Are you sure to delete this data?</p>

              </div>

              <div class="modal-footer">

                 
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline btn-send" href="">Delete Now</button>

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

        <form action="<?= base_url('fitur/impor/daily_movement_report') ?>" method="POST"  enctype="multipart/form-data">



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