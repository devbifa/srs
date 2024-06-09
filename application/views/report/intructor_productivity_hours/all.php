<?php
$type = $_SESSION['type'];
$ground = 1;
$ftd = 1;
$flight = 1;
if($type=='GROUND'){
  $ftd = 0;
  $flight = 0;
}else if($type=='FTD'){
  $ground = 0;
  $flight = 0;
}else if($type=='FLIGHT'){
  $ground = 0;
  $ftd = 0;
} 
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
?>


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
                INSTRUCTOR PRODUCTIVITY HOURS
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
                                <form autocomplete="off" action="<?= base_url() ?>report/instructor_productivity_hours/filter" method="post">
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>TYPE OF TRAINING</label>
                                            <select style='width:100%' name="type" class="form-control select2">
                                              <option value="">ALL TYPE OF TRAINING</option>
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

            <?php if($ground > 0) { ?>
                    
                        <label for="">GROUND</label>

                        <!-- <div class="row" style="margin-top:0px;margin-bottom:10px;">
                        <div class="col-md-2">
                        <a class="btn btn-success btn-block" href="<?=base_url()?>features/print_ground_instructor_productivity" target="_blank"><i class="mdi mdi-printer"></i> PRINT</a>
                        </div>
                        </div> -->

                        <div class="table-responsive">

                        <table class="table table-bordered " id="">

<thead>

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

</thead>

<tbody>
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
$pic = $val['id_number'];
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
<td class="text-left" rowspan="<?=$count?>"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?></a>
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
</tbody>

</table>

</div>

<?php } ?>
<?php if($ftd > 0) { ?>
<label for="">FTD</label>

<div class="table-responsive">

<table class="table table-bordered " id="">

<thead>

<tr class="bg-success">

            <th style="width:20px">NUM</th>
            <th style="width:200px;" >FULL NAME</th><th style="width:200px;" >NICK NAME</th><th style="width:200px;" >EMPLOYEE<br>NUMBER</th>
            <th>TOTAL<br>SINGLE ENGINE</th>
            <th >TOTAL<br>MULTI ENGINE</th>
            <th>TOTAL<br>FTD HOURS</th>
          </tr>
       

</thead>

<tbody>
<?php
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$type = 'FTD';
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.type, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM user a
LEFT JOIN batch b
ON a.batch = b.id
WHERE   a.instructor_status = '1' AND a.full_name != '' AND a.type LIKE '%$type%' AND id_number NOT IN ('','-')
ORDER BY a.full_name ASC
");

?>

<?php
$se_bottom = array();
$me_bottom = array();
$total_bottom = array();

foreach($instructor as $key=>$val){
$se = array();
$me = array();
$total = array();

$pic = $val['id_number'];
$data = $this->mymodel->selectWithQuery("SELECT a.id,a.block_time_atd, a.block_time_ata, a.block_time_total, a.remark_report, a.date, CONCAT(h.model,'<br>',h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name
FROM daily_ftd_schedule a
JOIN batch c
ON a.batch = c.id
JOIN course d
ON a.course = d.id
JOIN tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN user f
ON a.pic = f.id
JOIN user g
ON a.2nd = g.id
JOIN synthetic_training_devices_document h
ON a.ftd_model = h.id
WHERE  a.visibility = '1' AND (a.pic = '$pic' OR a.2nd = '$pic') AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
AND a.block_time_atd NOT IN ('-','') AND h.type_enginee = 'SE'
ORDER BY a.date ASC, a.etd_utc ASC
");
foreach($data as $key2=>$val2){
  // print_r($val2);

  if (strpos($val2['block_time_total'], ':') !== false) {
    array_push($se,$val2['block_time_total']);
  }
 
}

$se = $this->template->sum_time_3($se);

$data = $this->mymodel->selectWithQuery("SELECT a.id,a.block_time_atd, a.block_time_ata, a.block_time_total, a.remark_report, a.date, CONCAT(h.model,'<br>',h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name
FROM daily_ftd_schedule a
JOIN batch c
ON a.batch = c.id
JOIN course d
ON a.course = d.id
JOIN tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN user f
ON a.pic = f.id
JOIN user g
ON a.2nd = g.id
JOIN synthetic_training_devices_document h
ON a.ftd_model = h.id
WHERE  a.visibility = '1' AND (a.pic = '$pic' OR a.2nd = '$pic') AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
AND a.block_time_atd NOT IN ('-','') AND h.type_enginee = 'ME'
ORDER BY a.date ASC, a.etd_utc ASC
");
foreach($data as $key2=>$val2){
  // print_r($val2);

  if (strpos($val2['block_time_total'], ':') !== false) {
    array_push($me,$val2['block_time_total']);
  }
 
}

$me = $this->template->sum_time_3($me);

$total[0] = $se;
$total[1] = $me; 
$total = $this->template->sum_time_3($total);

if (strpos($se, ':') !== false) {
  array_push($se_bottom,$se);
}
if (strpos($me, ':') !== false) {
  array_push($me_bottom,$me);
}
if (strpos($total, ':') !== false) {
  array_push($total_bottom,$total);
}

?>
<tr>
<td><?=$key+1?>
</td>
<td class="text-left"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-left"><?=$val['nick_name']?>
</td>
<td class="text-left"><?=$val['id_number']?>
</td>
<td class="text-center"><?=$se?>
</td>
<td class="text-center"><?=$me?>
</td>
<td class="text-center"><?=$total?>
</td>
</tr>
<?php 
$duty_sum += $duty;
}

$se_bottom = $this->template->sum_time($se_bottom);
$me_bottom = $this->template->sum_time($me_bottom);
$total_bottom = $this->template->sum_time($total_bottom);


?>
<tr>
  <th colspan="4" class="text-left">TOTAL</th>
  <th><?=$se_bottom?></th>
  <th><?=$me_bottom?></th>
  <th><?=$total_bottom?></th>
</tr>
</tbody>

</table>

</div>
<?php } ?>
<?php if($flight > 0) { ?>
<label for="">FLIGHT</label>

<div class="table-responsive">

<table class="table table-bordered " id="">

<thead>

<tr class="bg-success">

            <th style="width:20px" rowspan="2">NUM</th>
            <th rowspan="2" style="width:200px;" >FULL NAME</th><th rowspan="2" style="width:200px;" >NICK NAME</th><th rowspan="2" style="width:200px;" >EMPLOYEE<br>NUMBER</th>
            <th rowspan="2">DUTY<br>INS</th>
            <th colspan="6">SE</th>
            <th colspan="6">ME</th>
            <th rowspan="2">TOTAL<br>FLIGHT<br>HOURS</th>
          </tr>
          <tr class="bg-success">
            <th>DUAL</th>
            <th>SOLO</th>
            <th>PIC</th>
            <th>SOLO (SVP)</th>
            <th>NON REV</th>
            <th>TOTAL</th>
            <th>DUAL</th>
            <th>SOLO</th>
            <th>PIC</th>
            <th>SOLO (SVP)</th>
            <th>NON REV</th>
            <th>TOTAL</th>
          </tr>

</thead>

<tbody>
<?php
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$type = 'FLIGHT';
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.type, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM user a
LEFT JOIN batch b
ON a.batch = b.id
WHERE   a.instructor_status = '1' AND a.full_name != '' AND a.type LIKE '%$type%' AND id_number NOT IN ('','-')
ORDER BY a.full_name ASC
");

?>
<?php
$se_total_bottom = array();
$me_total_bottom = array();
$total_bottom = array();

$se_dual_bottom = array();
$se_solo_bottom = array();
$se_pic_bottom = array();
$se_solo_spv_bottom = array();
$se_non_rev_bottom = array();
$se_total_bottom = array();

$me_dual_bottom = array();
$me_solo_bottom = array();
$me_pic_bottom = array();
$me_solo_spv_bottom = array();
$me_non_rev_bottom = array();
$me_total_bottom = array();

foreach($instructor as $key=>$val){
$pic = $val['id_number'];
$data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
LEFT JOIN aircraft_document b
ON a.aircraft_reg = b.serial_number
JOIN tpm_syllabus_all_course c
ON a.mission = c.code
WHERE a.visibility = '1' AND a.visibility_report = '1'  AND DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date'
AND a.block_time_start NOT IN ('-','')
AND (a.pic = '$pic' OR a.2nd = '$pic')
AND b.type = 'SE' ");

$se_dual = array();
$se_solo = array();
$se_pic = array();
$se_solo_spv = array();
$se_non_rev = array();
$se_total = array();

foreach($data as $key2=>$val2){
  if (strpos($val2['duration_dual'], ':') !== false) {
    array_push($se_dual,$val2['block_time_total']);
  }else if (strpos($val2['duration_solo'], ':') !== false) {
    array_push($se_solo,$val2['block_time_total']);
  }else if (strpos($val2['duration_pic'], ':') !== false) {
    array_push($se_pic,$val2['block_time_total']);
  }else if (strpos($val2['duration_pic_solo'], ':') !== false) {
    array_push($se_solo_spv,$val2['block_time_total']);
  }else if (strpos($val2['duration_non_rev'], ':') !== false) {
    array_push($se_non_rev,$val2['block_time_total']);
  }

}


$se_dual = $this->template->sum_time_3($se_dual);
$se_solo = $this->template->sum_time_3($se_solo);
$se_pic = $this->template->sum_time_3($se_pic);
$se_solo_spv = $this->template->sum_time_3($se_solo_spv);
$se_non_rev = $this->template->sum_time_3($se_non_rev);

$se_total[0] = $se_dual;
$se_total[1] = $se_solo;
$se_total[2] = $se_pic;
$se_total[3] = $se_solo_spv;
$se_total[4] = $se_non_rev;
$se_total = $this->template->sum_time_3($se_total);

$pic = $val['id_number'];
$data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
LEFT JOIN aircraft_document b
ON a.aircraft_reg = b.serial_number
JOIN tpm_syllabus_all_course c
ON a.mission = c.code
WHERE a.visibility = '1' AND a.visibility_report = '1'  AND DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date'
AND a.block_time_start NOT IN ('-','')
AND (a.pic = '$pic' OR a.2nd = '$pic')
AND b.type = 'ME' ");


$me_dual = array();
$me_solo = array();
$me_pic = array();
$me_solo_spv = array();
$me_non_rev = array();
$me_total = array();

foreach($data as $key2=>$val2){
 
  if (strpos($val2['duration_dual'], ':') !== false) {
    array_push($me_dual,$val2['block_time_total']);
  }else if (strpos($val2['duration_solo'], ':') !== false) {
    array_push($me_solo,$val2['block_time_total']);
  }else if (strpos($val2['duration_pic'], ':') !== false) {
    array_push($me_pic,$val2['block_time_total']);
  }else if (strpos($val2['duration_pic_solo'], ':') !== false) {
    array_push($me_solo_spv,$val2['block_time_total']);
  }else if (strpos($val2['duration_non_rev'], ':') !== false) {
    array_push($me_non_rev,$val2['block_time_total']);
  }

}


$me_dual = $this->template->sum_time_3($me_dual);
$me_solo = $this->template->sum_time_3($me_solo);
$me_pic = $this->template->sum_time_3($me_pic);
$me_solo_spv = $this->template->sum_time_3($me_solo_spv);
$me_non_rev = $this->template->sum_time_3($me_non_rev);

$me_total[0] = $me_dual;
$me_total[1] = $me_solo;
$me_total[2] = $me_pic;
$me_total[3] = $me_solo_spv;
$me_total[4] = $me_non_rev;
$me_total = $this->template->sum_time_3($me_total);



$total = array();
$total[0] = $se_total;
$total[1] = $me_total;
$total = $this->template->sum_time_3($total);

if (strpos($se_dual, ':') !== false) {
  array_push($se_dual_bottom,$se_dual);
}
if (strpos($se_solo, ':') !== false) {
  array_push($se_solo_bottom,$se_solo);
}
if (strpos($se_pic, ':') !== false) {
  array_push($se_pic_bottom,$se_pic);
}
if (strpos($se_solo_spv, ':') !== false) {
  array_push($se_solo_spv_bottom,$se_solo_spv);
}
if (strpos($se_non_rev, ':') !== false) {
  array_push($se_non_rev_bottom,$se_non_rev);
}
if (strpos($me_dual, ':') !== false) {
  array_push($me_dual_bottom,$me_dual);
}
if (strpos($me_solo, ':') !== false) {
  array_push($me_solo_bottom,$me_solo);
}
if (strpos($me_pic, ':') !== false) {
  array_push($me_pic_bottom,$me_pic);
}
if (strpos($me_solo_spv, ':') !== false) {
  array_push($me_solo_spv_bottom,$me_solo_spv);
}
if (strpos($me_non_rev, ':') !== false) {
  array_push($me_non_rev_bottom,$me_non_rev);
}



if (strpos($se_total, ':') !== false) {
  array_push($se_total_bottom,$se_total);
}
if (strpos($me_total, ':') !== false) {
  array_push($me_total_bottom,$me_total);
}
if (strpos($total, ':') !== false) {
  array_push($total_bottom,$total);
}


$count = $this->mymodel->selectWithQuery("SELECT COUNT(a.id) as count FROM daily_flight_schedule a
WHERE a.visibility = '1'  AND (a.duty_instructor = '$pic') AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND a.block_time_start NOT IN ('-','')
GROUP BY DATE(date_of_flight)");
$duty = count($count);
?>
<tr>
<td><?=$key+1?>
</td>
<td class="text-left"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-left"><?=$val['nick_name']?>
</td>
<td class="text-left"><?=$val['id_number']?>
</td>
<td class="text-center"><?=$duty?>
</td>
<td class="text-center"><?=$se_dual?>
</td>
<td class="text-center"><?=$se_solo?>
</td>
<td class="text-center"><?=$se_pic?>
</td>
<td class="text-center"><?=$se_solo_spv?>
</td>
<td class="text-center"><?=$se_non_rev?>
</td>
<td class="text-center"><?=$se_total?>
</td>
<td class="text-center"><?=$me_dual?>
</td>
<td class="text-center"><?=$me_solo?>
</td>
<td class="text-center"><?=$me_pic?>
</td>
<td class="text-center"><?=$me_solo_spv?>
</td>
<td class="text-center"><?=$me_non_rev?>
</td>
<td class="text-center"><?=$me_total?>
</td>
<td class="text-center"><?=$total?>
</td>
</tr>
<?php 
$duty_sum += $duty;
}

$se_dual_bottom = $this->template->sum_time($se_dual_bottom);
$se_solo_bottom = $this->template->sum_time($se_solo_bottom);
$se_pic_bottom = $this->template->sum_time($se_pic_bottom);
$se_solo_spv_bottom = $this->template->sum_time($se_solo_spv_bottom);
$se_non_rev_bottom = $this->template->sum_time($se_non_rev_bottom);
$se_total_bottom = $this->template->sum_time($se_total_bottom);

$me_dual_bottom = $this->template->sum_time($me_dual_bottom);
$me_solo_bottom = $this->template->sum_time($me_solo_bottom);
$me_solo_spv_bottom = $this->template->sum_time($me_solo_spv_bottom);
$me_pic_bottom = $this->template->sum_time($me_pic_bottom);
$me_non_rev_bottom = $this->template->sum_time($me_non_rev_bottom);
$me_total_bottom = $this->template->sum_time($me_total_bottom);



// $se_total_bottom = $this->template->sum_time($se_total_bottom);

// $me_total_bottom = $this->template->sum_time($me_total_bottom);

$total_bottom = $this->template->sum_time($total_bottom);

?>
<tr>
  <th colspan="4" class="text-left">TOTAL</th>
  <th><?=$duty_sum?></th>

  <th><?=$se_dual_bottom?></th>
  <th><?=$se_solo_bottom?></th>
  <th><?=$se_pic_bottom?></th>
  <th><?=$se_solo_spv_bottom?></th>
  <th><?=$se_non_rev_bottom?></th>
  <th><?=$se_total_bottom?></th>

  <th><?=$me_dual_bottom?></th>
  <th><?=$me_solo_bottom?></th>
  <th><?=$me_pic_bottom?></th>
  <th><?=$me_solo_spv_bottom?></th>
  <th><?=$me_non_rev_bottom?></th>
  <th><?=$me_total_bottom?></th>

  <th><?=$total_bottom?></th>
</tr>
</tbody>

</table>

</div>
<?php } ?>




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


