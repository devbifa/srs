



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">


    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
              INSTRUCTOR HOURS
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
                                <form autocomplete="off" action="<?= base_url() ?>record/instructor_hours/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>TYPE OF TRAINING</label>
                                            <select style='width:100%' name="type" class="form-control select2">
                                              <option value="">SELECT TYPE OF TRAINING</option>
                                                <?php 

                                                  $base_airport_document = $this->mymodel->selectWhere('type_of_training',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['value']==$_SESSION['type']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['value']."' ".$text." >".$base_airport_document_record['value']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>START DATE</label>
                                            <input placeholder="Date" type="text" class="form-control tgl" value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>END DATE</label>
                                            <input placeholder="Date" type="text" class="form-control tgl" value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
                                        </div>
                                    </div>
                               
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>&nbsp</label><br>
                                        <button class="btn btn-success btn-block"><i class="mdi mdi-database-search"></i> FILTER</button>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <a class="btn btn-success btn-block" href="<?=base_url()?>features/excel/instructor_hours" target="_blank"><i class="mdi mdi-excel"></i> EXCEL</a>
                                        </div>
                                    </div>
                                  
                                    <!-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <button class="btn btn-success btn-block"><i class="mdi mdi-database-search"></i> FILTER</button>
                                        </div>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

            
                        <div class="table-responsive">

<table class="table table-bordered " id="datatable">

<thead>

<tr class="bg-success">

            <th style="width:20px" rowspan="2">NUM</th>
            <th rowspan="2">FULL NAME</th>
            <th rowspan="2">NICK NAME</th>
            <th rowspan="2">ID NUMBER</th>
            <th rowspan="2">CAPABILITY</th>
            <th rowspan="2">DUTY INSTRUCTOR</th>
            <th colspan="2">GROUND</th>
            <th colspan="2">FTD</th>
            <th colspan="2">FLIGHT</th>
            <th colspan="4">TOTAL</th>

          </tr>
<tr class="bg-success">
            <th>SE</th>
            <th>ME</th>
            <th>SE</th>
            <th>ME</th>
            <th>SE</th>
            <th>ME</th>
            <th>GROUND</th>
            <th>FTD</th>
            <th>FLIGHT</th>
            <th>TOTAL</th>
          </tr>

</thead>

<tbody>
<?php

$batch = $this->uri->segment(4);
$type = $_SESSION['type'];
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];

$ground_se_summary = array();
$ground_me_summary = array();
$ftd_se_summary = array();
$ftd_me_summary = array();
$flight_se_summary = array();
$flight_me_summary = array();

$data = $this->mymodel->selectWithQuery("SELECT a.id, a.type, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM user a
LEFT JOIN batch b
ON a.batch = b.id
WHERE   a.instructor_status = '1' AND a.full_name != '' AND a.type LIKE '%$type%' AND a.id_number NOT IN ('-','') AND type NOT IN ('','null')
-- AND a.id = '103'
ORDER BY a.full_name ASC
");
foreach($data as $key=>$val){

$type = '';
if (strpos($val['type'], 'GROUND') !== false) {
    $type .= 'GROUND, ';
}

if (strpos($val['type'], 'FTD') !== false) {
  $type .= 'FTD, ';
}

if (strpos($val['type'], 'FLIGHT') !== false) {
  $type .= 'FLIGHT, ';
}

$type = substr($type,0,-2);
$val['type'] = $type;


$ground_se_act = array();
$ground_me_act = array();
$ground_se_me_act = array();
$ftd_se_act = array();
$ftd_me_act = array();
$ftd_se_me_act = array();
$flight_se_act = array();
$flight_me_act = array();
$flight_se_me_act = array();
$ground_r = array();
$ftd_r = array();
$flight_r = array();
$r = array();
$id_instructor= $val['id_number'];

$ground_se = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule a
WHERE a.visibility = '1' AND a.visibility_report = '1' AND  instructor = '$id_instructor' AND duration_act NOT IN ('','-','00:00','0:00') AND DATE(date) >='$start_date' AND DATE(date) <='$end_date'
AND type != 'ME'
");
foreach($ground_se as $k=>$v){
  if (strpos($v['duration_act'], ':') !== false) {
    array_push($ground_se_act,$v['duration_act']);
    }  
}


$ground_me = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule a
WHERE a.visibility = '1' AND a.visibility_report = '1' AND  instructor = '$id_instructor' AND duration_act NOT IN ('','-','00:00','0:00') AND DATE(date) >='$start_date' AND DATE(date) <='$end_date'
AND type = 'ME'
");
foreach($ground_me as $k=>$v){
  if (strpos($v['duration_act'], ':') !== false) {
    array_push($ground_me_act,$v['duration_act']);
    }  
}


$ftd_se = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule a 
LEFT JOIN synthetic_training_devices_document b
ON a.ftd_model = b.code
WHERE a.visibility = '1' AND a.visibility_report = '1' AND  (a.pic = '$id_instructor') 
-- AND a.block_time_total NOT IN ('','-','00:00','0:00') 
AND b.type_enginee='SE' 
-- AND a.etd_utc >= '00:00' AND a.etd_utc <= '21:59'
AND DATE(date) >='$start_date' AND DATE(date) <='$end_date'");
foreach($ftd_se as $k=>$v){
  if (strpos($v['block_time_total'], ':') !== false) {
    array_push($ftd_se_act,$v['block_time_total']);
    }  
}

$ftd_me = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule a 
LEFT JOIN synthetic_training_devices_document b
ON a.ftd_model = b.code
WHERE a.visibility = '1' AND a.visibility_report = '1' AND  (a.pic = '$id_instructor') 
-- AND a.block_time_total NOT IN ('','-','00:00','0:00') 
AND b.type_enginee='ME' 
-- AND a.etd_utc >= '00:00' AND a.etd_utc <= '21:59'
AND DATE(date) >='$start_date' AND DATE(date) <='$end_date'");
foreach($ftd_me as $k=>$v){
  if (strpos($v['block_time_total'], ':') !== false) {
    array_push($ftd_me_act,$v['block_time_total']);
    }  
}

$flight_se = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule a 
LEFT JOIN aircraft_document b
ON a.aircraft_reg = b.serial_number
WHERE  a.visibility = '1' AND a.visibility_report = '1'  AND DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date'
AND a.block_time_start NOT IN ('-','')
AND (a.pic = '$id_instructor')
AND b.type = 'SE'");
foreach($flight_se as $k=>$v){
  if (strpos($v['block_time_total'], ':') !== false) {
    array_push($flight_se_act,$v['block_time_total']);
    }  
}
$flight_me = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule a 
LEFT JOIN aircraft_document b
ON a.aircraft_reg = b.serial_number
WHERE  a.visibility = '1' AND a.visibility_report = '1' AND (a.pic = '$id_instructor') AND a.block_time_total NOT IN ('','-','00:00','0:00') AND b.type='ME' AND a.type=''
AND DATE(date_of_flight) >='$start_date' AND DATE(date_of_flight) <='$end_date'");
foreach($flight_me as $k=>$v){
  if (strpos($v['block_time_total'], ':') !== false) {
    array_push($flight_me_act,$v['block_time_total']);
    }  
}


$ground_se_act = $this->template->sum_time_3($ground_se_act);
$ground_me_act = $this->template->sum_time_3($ground_me_act);
$ground_se_me_act[0] = $ground_se_act;
$ground_se_me_act[1] = $ground_me_act;
$ground_se_me_act = $this->template->sum_time_3($ground_se_me_act);
$ftd_se_act = $this->template->sum_time_3($ftd_se_act);
$ftd_me_act = $this->template->sum_time_3($ftd_me_act);
$ftd_se_me_act[0] = $ftd_se_act;
$ftd_se_me_act[1] = $ftd_me_act;
$ftd_se_me_act = $this->template->sum_time_3($ftd_se_me_act);
$flight_se_act = $this->template->sum_time_3($flight_se_act);
$flight_me_act = $this->template->sum_time_3($flight_me_act);
$flight_se_me_act[0] = $flight_se_act;
$flight_se_me_act[1] = $flight_me_act;
$flight_se_me_act = $this->template->sum_time_3($flight_se_me_act);

$r[0] = $ground_se_me_act;
$r[1] = $ftd_se_me_act;
$r[2] = $flight_se_me_act;
$r = $this->template->sum_time_3($r);
$val['duty_instructor'] = $this->mymodel->selectWithQuery("SELECT count(a.id) as count FROM daily_flight_schedule a
WHERE a.duty_instructor = '$id_instructor' AND a.visibility = '1' AND a.visibility_report = '1' AND DATE(a.date_of_flight) >='$start_date' AND DATE(a.date_of_flight) <='$end_date'
GROUP BY a.date_of_flight");
$val['duty_instructor'] = count($val['duty_instructor']);
?>
<tr>
<td><?=$key+1?>
</td>
<td class="text-left"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-left"><?=$val['nick_name']?>
</td>
<td><?=$val['id_number']?>
</td>
<td class="text-left"><?=$val['type']?>
</td>
<td class="text-center"><?=$val['duty_instructor']?>
</td>
<?php
array_push($ground_se_summary,$ground_se_act);
array_push($ground_me_summary,$ground_me_act);
array_push($ftd_se_summary,$ftd_se_act);
array_push($ftd_me_summary,$ftd_me_act);
array_push($flight_se_summary,$flight_se_act);
array_push($flight_me_summary,$flight_me_act);
$count_duty += $val['duty_instructor'];
?>
<td><?=$ground_se_act?></td>
<td><?=$ground_me_act?></td>
<td><?=$ftd_se_act?></td>
<td><?=$ftd_me_act?></td>
<td><?=$flight_se_act?></td>
<td><?=$flight_me_act?></td>
<td><?=$ground_se_me_act?></td>
<td><?=$ftd_se_me_act?></td>
<td><?=$flight_se_me_act?></td>
<td><?=$r?></td>
</tr>
<?php } 
$ground_se_summary = $this->template->sum_time_3($ground_se_summary);
$ground_me_summary = $this->template->sum_time_3($ground_me_summary);
$ftd_se_summary = $this->template->sum_time_3($ftd_se_summary);
$ftd_me_summary = $this->template->sum_time_3($ftd_me_summary);
$flight_se_summary = $this->template->sum_time_3($flight_se_summary);
$flight_me_summary = $this->template->sum_time_3($flight_me_summary);
$total_ground_summary = array();
$total_ground_summary[0] = $ground_se_summary;
$total_ground_summary[1] = $ground_me_summary;
$total_ground_summary = $this->template->sum_time_3($total_ground_summary);
$total_ftd_summary = array();
$total_ftd_summary[0] = $ftd_se_summary;
$total_ftd_summary[1] = $ftd_me_summary;
$total_ftd_summary = $this->template->sum_time_3($total_ftd_summary);
$total_flight_summary = array();
$total_flight_summary[0] = $flight_se_summary;
$total_flight_summary[1] = $flight_me_summary;
$total_flight_summary = $this->template->sum_time_3($total_flight_summary);
$total_summary = array();
$total_summary[0] = $total_ground_summary;
$total_summary[1] = $total_ftd_summary;
$total_summary[2] = $total_flight_summary;
$total_summary = $this->template->sum_time_3($total_summary);
?>
<tr>
  <th></th>
  <th colspan="4" class="text-left">TOTAL</th>
  <th><?=$count_duty?></th>
  <th><?=$ground_se_summary?></th>
  <th><?=$ground_me_summary?></th>
  <th><?=$ftd_se_summary?></th>
  <th><?=$ftd_me_summary?></th>
  <th><?=$flight_se_summary?></th>
  <th><?=$flight_me_summary?></th>
  <th><?=$total_ground_summary?></th>
  <th><?=$total_ftd_summary?></th>
  <th><?=$total_flight_summary?></th>
  <th><?=$total_summary?></th>
</tr>
</tbody>

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

              <form id="upload-delete" action="<?= base_url('dashboard/flight_schedule/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/daily_flight_schedule') ?>" method="POST"  enctype="multipart/form-data">



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


