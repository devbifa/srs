



 <!-- Content Wrapper. Contains page content -->

 <div class="content-wrapper">

<!-- Content Header (Page header) -->

<section class="content-header">

  <h1>

    DAILY FTD SCHEDULE

    <small>DATA</small>

  </h1>

  <ol class="breadcrumb">

    <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

    <li class="#">DAILY FTD SCHEDULE</li>

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
         MY SCHEDULE
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
                            <form autocomplete="off" action="<?= base_url() ?>menu/my_schedule/filter" method="post">
                           
                            <div class="col-md-2">
                                        <div class="form-group">
                                            <label>START DATE</label>
                                            <input placeholder="Start Date" type="text" class="form-control tgl" value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>END DATE</label>
                                            <input placeholder="End Date" type="text" class="form-control tgl" value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
                                        </div>
                                    </div>
                               
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp</label><br>
                                        <button class="btn btn-success btn-block"><i class="mdi mdi-database-search"></i> FILTER</button>
                                    </div>
                                </div>
                                <!-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp</label><br>
                                        <a class="btn btn-success btn-block" href="<?=base_url()?>features/print_all_training_schedule" target="_blank"><i class="mdi mdi-printer"></i> PRINT</a>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                    <!-- FILTER  -->

                    <!-- <label>GROUND SCHEDULE</label> -->

<!-- <table class="" style="margin-bottom:10px;">
<tr class="bg-success">
<th style="padding:5px;" class="text-left"><?=DATE('d M Y',strtotime($_SESSION['start_date']))?></th>
</tr>
</table> -->
                    <div class="table-responsive">
                    <table class="table table-bordered " id="datatable2" style="width:100%;">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NUM</th>
<th rowspan="2" style="min-width:100px;">DATE</th><th rowspan="2" >TYPE</th>
<th rowspan="2" >BASE</th>
<th rowspan="2" >CLASS/<br>FTD/ACFT</th>
<th rowspan="2" >INSTRUCTOR</th>
<th rowspan="2" >STUDENT</th>
<th rowspan="2" >BATCH</th>
<th rowspan="2" >COURSE</th>
<th rowspan="2" >SUBJECT/MISSION</th>
<th rowspan="2" >ROUTE</th>
<th colspan="3">SCHEDULE (UTC)</th><th rowspan="2" >REMARK</th>
</tr>

<tr class="bg-success">
	<th>START</th>
	<th>STOP</th>
	<th>DUR</th>
 </tr>

</thead>

<tbody>
<?php 
$se = array();
$me = array();

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
      
      $id_instructor = $_SESSION['json']['nick_name'];
    if($_SESSION['role']!='1'){
      $data = $this->mymodel->selectWithQuery("SELECT * FROM
      (SELECT 'GROUND' as type, a.date as date, '-' as origin_base, a.classroom, a.instructor as pic, a.student as student, a.student_other as student_2, a.batch, a.course, a.subject as mission, '-' as rute, a.start_lt as start, a.stop_lt as stop, a.duration, a.start_lt as start2, a.stop_lt as stop2, a.duration as duration2, '-' as start3, '-' as stop3, '-' as duration3, a.remark FROM daily_ground_schedule a
      WHERE a.instructor = '$id_instructor' AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
      AND a.visibility = '1' AND a.visibility_report = '0' 
      UNION ALL
      SELECT 'FTD' as type, a.date as date, 'WSN' as origin_base, a.ftd_model as classroom, a.pic as pic, a.2nd as student,'-' as student_2, a.batch, a.course, a.mission as mission, '-' as rute, a.etd_utc as start, a.eta as stop, a.eet_utc as duration, a.block_time_atd as start2, a.block_time_ata as stop2, a.block_time_total as duration2, '-' as start3, '-' as stop3, '-' as duration3, a.remark FROM daily_ftd_schedule a 
      WHERE (a.pic = '$id_instructor' OR a.2nd = '$id_instructor') AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
      AND a.visibility = '1' AND a.visibility_report = '0' 
      UNION ALL
      SELECT 'FLIGHT' as type, a.date_of_flight as date, a.origin_base, a.aircraft_reg as classroom, a.pic as pic, a.2nd as student,'-' as student_2, a.batch, a.course, a.mission as mission, a.rute, a.etd_utc as start, a.eta_utc as stop, a.eet as duration, a.block_time_start as start2, a.block_time_stop as stop, a.block_time_total as duration2, a.flight_time_take_off as start3, a.flight_time_landing as stop3, a.flight_time_total as duration3, a.remark FROM daily_flight_schedule a 
      WHERE (a.pic = '$id_instructor' OR a.2nd = '$id_instructor') 
      AND a.visibility = '1' AND a.visibility_report = '0'   AND a.type = ''  AND DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date'
      AND a.type = ''
      ) a
      ORDER BY a.date ASC, a.start ASC");
    }else{
      $data = $this->mymodel->selectWithQuery("SELECT * FROM
      (SELECT 'GROUND' as type, a.date as date, '-' as origin_base, a.classroom, a.instructor as pic, a.student as student, a.student_other as student_2, a.batch, a.course, a.subject as mission, '-' as rute, a.start_lt as start, a.stop_lt as stop, a.duration, a.start_lt as start2, a.stop_lt as stop2, a.duration as duration2, '-' as start3, '-' as stop3, '-' as duration3, a.remark FROM daily_ground_schedule a
      WHERE  DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
      AND a.visibility = '1' AND a.visibility_report = '0' 
      UNION ALL
      SELECT 'FTD' as type, a.date as date, 'WSN' as origin_base, a.ftd_model as classroom, a.pic as pic, a.2nd as student,'-' as student_2, a.batch, a.course, a.mission as mission, '-' as rute, a.etd_utc as start, a.eta as stop, a.eet_utc as duration, a.block_time_atd as start2, a.block_time_ata as stop2, a.block_time_total as duration2, '-' as start3, '-' as stop3, '-' as duration3, a.remark FROM daily_ftd_schedule a 
      WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'
      AND a.visibility = '1' AND a.visibility_report = '0' 
      UNION ALL
      SELECT 'FLIGHT' as type, a.date_of_flight as date, a.origin_base, a.aircraft_reg as classroom, a.pic as pic, a.2nd as student,'-' as student_2, a.batch, a.course, a.mission as mission, a.rute, a.etd_utc as start, a.eta_utc as stop, a.eet as duration, a.block_time_start as start2, a.block_time_stop as stop, a.block_time_total as duration2, a.flight_time_take_off as start3, a.flight_time_landing as stop3, a.flight_time_total as duration3, a.remark FROM daily_flight_schedule a 
      WHERE a.visibility = '1'  AND a.type = ''  AND DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date'
      AND a.type = ''
      ) a
      ORDER BY a.date ASC, a.start ASC");
    }
// print_r($data);
$total = array();
$array_class = array();
$array_subject = array();
foreach($data as $key=>$val){
	
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  if(!in_array($val['subject'],$array_subject)){
    array_push($array_subject,$val['subject']);
  }
  
  if (strpos($val['duration'], ':') !== false) {
    array_push($total,$val['duration']);
  }



  

  if($val['type']=='GROUND'){
    $participant = 0;
    $student_list = json_decode($val['student'],true);
    // print_r($student_list);
    $student_other = json_decode($val['student_2'],true);
    // print_r($student_other);
  
    foreach($student_list as $key2=>$val2){
      //
      if($val2['val']){
        $participant++;
      }
    }
    foreach($student_other as $key2=>$val2){
      // print_r($val2);
      if($val2['check']=='on'){
        $participant++;
      }
    }
    $val['student'] = $participant.' STUDENTS';
  }else{
    // $dat = $this->mymodel->selectDataOne('user',array('id'=>$val['student']));
    // $val['student'] = $dat['nick_name'];
  }

  


  if($val['type']=='GROUND'){
    $dat = $this->mymodel->selectDataOne('classroom',array('id'=>$val['classroom']));
    $val['classroom'] = $dat['classroom'];
    $dat = $this->mymodel->selectDataOne('base_airport_document',array('id'=>$dat['station']));
    $val['origin_base'] = $dat['base'];
    $ground_schedule++;
  }else if($val['type']=='FTD'){
    $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('id'=>$val['classroom']));
    $val['classroom'] = $dat['serial_number'];
    $ftd_schedule++; 
  }else{
    $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
    
    $val['pic'] = $dat['nick_name'];

    $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

    $val['2nd'] = $dat['nick_name'];

    $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));

    $val['duty_instructor'] = $dat['nick_name'];

    $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

    $val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

    $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

    $val['course'] = $dat['course_code'];
    
    if($dat['type']=='SE'){
      array_push($se,$val['duration']);
    }else if($dat['ME']){
      array_push($me,$val['duration']);
    }
    $flight_schedule++;
  }
  $all_schedule++;
  ?>
<tr>
  <td><?=$key+1?>
  </td>
  
  <td><?=$this->template->date_indo($val['date'])?></td> 
  <td><?=$val['type']?></td> 
  <td><?=$val['origin_base']?></td> 
  <td><?=$val['classroom']?></td> 
  <td class="text-left"><?=$val['pic']?></td> 
  <td class="text-left"><?=$val['2nd']?></td> 
  <td><?=$val['batch']?></td> 
  <td class="text-left"><?=$val['course']?></td> <td class="text-left"><?=$val['mission']?></td> 
  <td class="text-left"><?=$val['rute']?></td> 
<td><?=$val['start']?></td> <td><?=$val['stop']?></td> <td><?=$val['duration']?></td>

  <td class="text-left"><?=$val['remark']?></td> 
</tr>
<?php } 
$total_subject = count($data_ground);
$total_classroom = count($array_class);

$total_plan = $this->template->sum_time($total);

$total = count($data_ground);
$total_subject = count($array_subject);
$se = $this->template->sum_time($se);
$me = $this->template->sum_time($me);
?>

<?php
if(count($data) == 0 ){ 
?>
<tr>
  <td colspan="14">
    No Schedule
  </td>
</tr>
<?php
}
?>
</tbody>

</table>

              </div>

              
              <br>
              <div class="table-responsive">
<table>
  <tr>
    <th class="text-left no-border" style="min-width:250px">
    
    <p>GROUND SCHEDULE</p> 
    
    <p>FTD SCHEDULE</p> 

    <p>FLIGHT SCHEDULE </p>
  
    <p>TOTAL SCHEDULE</p> 
    
    </th>
    <th class="no-border" style="min-width:15px;">
  
    <p>:</p>
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:50px">
 
    <p><?=intval($ground_schedule)?></p>
    <p><?=intval($ftd_schedule)?></p>
    <p><?=intval($flight_schedule)?></p>
    <p><?=intval($all_schedule)?></p>
    </th>
    <!-- <th class="text-left no-border" style="min-width:80px;padding-top:30px;">
    <p>SE : <?=($se)?></p>
    </th>
    <th class="text-left no-border" style="min-width:80px;padding-top:30px;">
    <p>ME : <?=($me)?></p>
    </th> -->
  </tr>
</table>
</div>


<br>
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

          <form id="upload-delete" action="<?= base_url('master/daily_ftd_schedule/delete') ?>">

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

    <form action="<?= base_url('fitur/impor/Daily_ftd_schedule') ?>" method="POST"  enctype="multipart/form-data">



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


