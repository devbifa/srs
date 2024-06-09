<style>
.hide {
    visibility: none;
}
</style>

<?php
$type = $_SESSION['type'];
$ground = 1;
$ftd = 1;
$flight = 1;
if ($type == 'GROUND') {
  $ftd = 0;
  $flight = 0;
} else if ($type == 'FTD') {
  $ground = 0;
  $flight = 0;
} else if ($type == 'FLIGHT') {
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
                                INSTRUCTOR HOURS DETAIL
                            </div>
                            <div class="col-xs-2">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="box-body">

                        <?php
            $id = $this->uri->segment(4);
            $student = $this->mymodel->selectDataOne('user', array('id' => $id));
            // $batch = $this->mymodel->selectDataOne('batch',array('id'=>$student['batch']));
            // $curriculum = $this->mymodel->selectDataOne('curriculum',array('id'=>$batch['curriculum']));
            // $id_curriculum = $curriculum['id'];
            // $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND (configuration LIKE '%GROUND%' OR configuration LIKE '%FTD%' OR configuration LIKE '%FLIGHT%') ORDER BY position ASC");
            $pic = $student['id_number'];
            ?>

                        <table style="width:100%;">
                            <tr>
                                <th colspan="3" style="font-size:15px;width:20%;padding:5px 0px;" class="text-left">
                                    INSTRUCTOR NAME</th>
                                <th style="width:2%;"> : </th>
                                <th class="text-left"><?= $student['full_name'] ?></th>
                                <th colspan="4"></th>
                            </tr>
                            <tr>
                                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">NICK NAME</th>
                                <th> : </th>
                                <th class="text-left"><?= $student['nick_name'] ?></th>
                                <th colspan="4"></th>
                            </tr>
                            <tr>
                                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">ID NUMBER</th>
                                <th> : </th>
                                <th class="text-left"><?= $student['id_number'] ?></th>
                                <th colspan="4"></th>
                            </tr>
                            <tr>
                                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">CAPABILITY
                                </th>
                                <th> : </th>
                                <?php
                $type_text = '';
                $type = ($student['type']);
                if (strpos($type, 'GROUND') !== false) {
                  $type_text = $type_text . 'GROUND, ';
                }
                if (strpos($type, 'FTD') !== false) {
                  $type_text = $type_text . 'FTD, ';
                }
                if (strpos($type, 'FLIGHT') !== false) {
                  $type_text = $type_text . 'FLIGHT, ';
                }
                $type_text = substr($type_text, 0, -2);

                ?>
                                <th class="text-left"><?= $type_text ?></th>
                                <th colspan="4"></th>
                            </tr>
                            <tr>
                                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">SUBJECT</th>
                                <th> : </th>
                                <th class="text-left"><?= $student['remark_instructor'] ?></th>
                                <th colspan="4"></th>
                            </tr>

                        </table>
                        <br>
                        <!-- FILTER  -->
                        <div class="row">
                            <div class="">
                                <form autocomplete="off"
                                    action="<?= base_url() ?>record/instructor_hours/filter_detail/<?= $student['id'] ?>"
                                    method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>TYPE OF TRAINING</label>
                                            <select style='width:100%' name="type" class="form-control select2">
                                                <option value="">ALL TYPE OF TRAINING</option>
                                                <?php
                        $base_airport_document = $this->mymodel->selectWhere('type_of_training', null);

                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text = "";

                          if ($base_airport_document_record['value'] == $_SESSION['type']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $base_airport_document_record['value'] . "' " . $text . " >" . $base_airport_document_record['value'] . "</option>";
                        }

                        ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>START DATE</label>
                                            <input placeholder="Start Date" type="text" class="form-control tgl"
                                                value="<?= $_SESSION['start_date'] ?>" name="start_date"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>END DATE</label>
                                            <input placeholder="End Date" type="text" class="form-control tgl"
                                                class="form-control" value="<?= $_SESSION['end_date'] ?>"
                                                name="end_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <button class="btn btn-success btn-block"><i
                                                    class="mdi mdi-database-search"></i> FILTER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->


                        <?php if ($ground > 0) { ?>

                        <div class="table-responsive ">
                            <table style="width:100%;" class="table table-bordered">
                                <thead>
                                    <tr class="bg-orange">
                                        <th colspan="14" style="font-size:15px;" class="text-left"> <label>GROUND
                                                INSTRUCTOR HOURS</label>
                                        </th>
                                    </tr>


                                    <tr class="bg-success">

                                        <th style="width:20px" rowspan="2">NUM</th>
                                        <th style="min-width:110px;" rowspan="2">DATE</th>
                                        <th rowspan="2">CLASS<br>ROOM</th>
                                        <th rowspan="2">INSTRUCTOR</th>
                                        <th rowspan="2">BATCH</th>
                                        <th rowspan="2">COURSE</th>
                                        <th rowspan="2">SUBJECT</th>
                                        <th colspan="3">TIME (UTC)</th>
                                        <th colspan="2">PARTICIPANT</th>
                                        <th rowspan="2">REMARK</th>
                                        <th rowspan="2">IRREG<br>CODE</th>
                                    </tr>

                                    <tr class="bg-success">
                                        <th>START</th>
                                        <th>STOP</th>
                                        <th>DUR</th>
                                        <th>PLAN</th>
                                        <th>ACT</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                    // $_SESSION['instructor_status'] = "0";
                    // if($_SESSION['instructor_status']=="1"){
                    //   $data = $this->mymodel->selectWithQuery("SELECT * FROM
                    //   daily_ground_schedule a
                    //   WHERE a.visibility = '1' AND a.visibility_report = '1' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
                    //   AND a.duration NOT IN ('-','','00:00','0:00') AND a.instructor = '$pic'
                    //   ORDER BY a.date ASC,a.start_act ASC");
                    // }else{
                    //   $qry = '{"val":"'.$pic.'"}';
                    //   $data = $this->mymodel->selectWithQuery("SELECT * FROM
                    //   daily_ground_schedule a
                    //   WHERE a.visibility = '1' AND a.visibility_report = '1' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
                    //   AND a.duration NOT IN ('-','','00:00','0:00') AND student LIKE '%$qry%'
                    //   ORDER BY a.date ASC,a.start_act ASC");
                    // }

                    $data = $this->mymodel->selectWithQuery("SELECT * FROM
daily_ground_schedule a
WHERE a.visibility = '1' AND a.visibility_report = '1' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
AND a.duration NOT IN ('-','','00:00','0:00') AND a.instructor = '$pic'
ORDER BY a.date ASC,a.start_act ASC");


                    $total = array();
                    $total_actual = array();
                    $array_class = array();
                    $array_irregularities = array();
                    $array_subject = array();
                    foreach ($data as $key => $val) {

                      $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['subject'], 'type_of_training' => 'GROUND'));
                      $val['subject'] = $dat['code_name'] . ' - ' . $dat['name'];

                      $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));
                      $val['course'] = $dat['code_name'];


                      $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
                      $val['batch'] = $dat['batch'];


                      if (!in_array($val['classroom'], $array_class)) {
                        array_push($array_class, $val['classroom']);
                      }


                      if (!in_array($val['remark_report'], $array_irregularities)) {
                        if ($val['remark_report']) {
                          array_push($array_irregularities, $val['remark_report']);
                        }
                      }

                      if (!in_array($val['subject'], $array_subject)) {
                        array_push($array_subject, $val['subject']);
                      }
                      if (strpos($val['duration_act'], ':') !== false) {
                        array_push($total, $val['duration_act']);
                        if (in_array($val['remark_report'], array('', '-'))) {
                          array_push($total_actual, $val['duration_act']);
                        }
                      }
                      $participant = 0;
                      $attend = 0;
                      $student_list = json_decode($val['student'], true);
                      // print_r($student_list);
                      $student_other = json_decode($val['student_other'], true);
                      // print_r($student_other);

                      $student_attend = json_decode($val['student_attend'], true);

                      $student_other_attend = json_decode($val['student_other_attend'], true);

                      foreach ($student_list as $key2 => $val2) {

                        if ($val2['val']) {
                          $participant++;
                        }
                      }
                      foreach ($student_other as $key2 => $val2) {

                        if ($val2['check'] == 'on') {
                          $participant++;
                        }
                      }

                      foreach ($student_attend as $key2 => $val2) {

                        if ($val2['val']) {
                          $attend++;
                        }
                      }
                      foreach ($student_other_attend as $key2 => $val2) {

                        if ($val2['check'] == 'on') {
                          $attend++;
                        }
                      }
                      $total2 = $total2 + $participant;
                      $total3 = $total3 + $attend;

                      if (!in_array($val['classroom'], $array_class)) {
                        array_push($array_class, $val['classroom']);
                      }
                      $nomor++;
                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?>
                                        </td>
                                        <td><?= DATE('d M Y', strtotime($val['date'])) ?></td>
                                        <td><?= $val['classroom'] ?></td>
                                        <td class="text-left">
                                            <!-- <?= $val['instructor'] ?> -->
                                            <?= $student['full_name'] ?>
                                        </td>
                                        <td><?= $val['batch'] ?></td>
                                        <td><?= $val['course'] ?></td>
                                        <td class="text-left"><?= $val['subject'] ?></td>
                                        <td><?= $val['start_act'] ?></td>
                                        <td><?= $val['stop_act'] ?></td>
                                        <td><?= $val['duration_act'] ?></td>
                                        <td><?= $participant ?></td>
                                        <td><?= $attend ?></td>
                                        <td><?= $val['remark_2'] ?></td>
                                        <td><?= $val['remark_report'] ?></td>
                                    </tr>
                                    <?php }

                    $total_subject = count($data);
                    $total_classroom = count($array_class);

                    $total_plan = $this->template->sum_time($total);

                    $total_actual = $this->template->sum_time($total_actual);

                    $total = count($data);
                    $total_subject = count($array_subject);
                    $total_irregularities = count($array_irregularities);

                    ?>

                                </tbody>

                            </table>

                        </div>



                        <div class="table-responsive ">
                            <table>
                                <tr>
                                    <th class="text-left no-border" style="min-width:250px;">

                                        <p>TOTAL GROUND RECORD</p>

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
                                        <p><?= $total ?></p>
                                        <p><?= $total_subject ?></p>
                                        <p><?= $total_classroom ?></p>
                                        <p><?= intval($total_irregularities) ?></p>
                                    </th>

                                    <th class="text-left no-border" style="min-width:250px;">
                                        <p>TOTAL ACTUAL</p>

                                    </th>
                                    <th class="no-border" style="min-width:15px;">
                                        <p>:</p>
                                    </th>
                                    <th class="text-left no-border" style="min-width:250px;;">
                                        <p><?= $total_actual ?></p>
                                    </th>


                                </tr>
                            </table>
                            <br>
                        </div>


                        <?php } ?>
                        <?php if ($ftd > 0) { ?>

                        <div class="table-responsive ">
                            <table style="width:100%;" class="table table-bordered">
                                <thead>
                                    <tr class="bg-orange">
                                        <th colspan="16" style="font-size:15px;" class="text-left"> <label>FTD
                                                INSTRUCTOR HOURS</label>
                                        </th>
                                    </tr>




                                    <tr class="bg-success">
                                        <th style="width:20px" rowspan="2">NUM</th>
                                        <th style="min-width:110px" rowspan="2">DATE</th>
                                        <th rowspan="2">FTD MODEL</th>
                                        <th rowspan="2">INSTRUCTOR</th>
                                        <th rowspan="2">STUDENT</th>
                                        <th rowspan="2">BATCH</th>
                                        <th rowspan="2">COURSE</th>
                                        <th rowspan="2">MISSION</th>

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
                    $data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_ftd_schedule a
WHERE  a.visibility = '1'  AND a.visibility_report = '1' AND (a.pic = '$pic' OR a.2nd = '$pic') AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'

ORDER BY a.date ASC, a.etd_utc ASC
");

                    $duty_instructor = '';
                    $total = array();
                    $total2 = array();
                    $array_model = array();
                    foreach ($data as $key => $val) {

                      $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document', array('code' => $val['ftd_model']));

                      $temp = $val['ftd_model'];
                      $val['ftd_model'] = $dat['model'] . ' ' . $dat['serial_number'] . ' ' . $dat['type_enginee'];

                      if (empty($dat)) {
                        $val['ftd_model'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }


                      $dat = '';
                      if (!in_array($val['pic'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['pic']));
                      }

                      if ($val['pic'] == $pic) {
                        if (strpos($val['block_time_total'], ':') !== false) {
                          array_push($total2, $val['block_time_total']);
                        }
                      }


                      $temp = $val['pic'];
                      $val['pic'] = $dat['nick_name'];

                      if (in_array($val['pic'], array('', '-'))) {
                        $val['pic'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }



                      $dat = '';
                      if (!in_array($val['pic'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));
                      }
                      $temp = $val['2nd'];
                      $val['2nd'] = $dat['nick_name'];

                      if (in_array($val['2nd'], array('', '-'))) {
                        $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }


                      $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
                      $temp = $val['batch'];
                      $val['batch'] = $dat['batch'];
                      if (empty($val['batch'])) {
                        $val['batch'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $this->db->select('code_name');
                      $dat = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $val['tpm']));
                      $temp = $val['tpm'];
                      $val['tpm'] = $dat['code_name'];
                      if (empty($val['tpm'])) {
                        $val['tpm'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['mission'], 'type_of_training' => 'FTD'));
                      $mission = $dat;
                      $temp = $val['mission'];
                      $val['mission'] = $dat['code_name'] . ' - ' . $dat['name'];

                      if (($val['mission']) == ' - ') {
                        $val['mission'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

                      $temp = $val['course'];
                      $val['course'] = $dat['code_name'];

                      if (($val['course']) == ' - ') {
                        $val['course'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $nomor++;

                      if ($val['remark_report']) {
                        $total_irregularities = $total_irregularities + 1;
                      }

                      if (strpos($val['block_time_atd'], ':') !== false) {
                        $total_movement = $total_movement + 1;
                      }

                      if (!in_array($val['ftd_model'], $array_model)) {
                        array_push($array_model, $val['ftd_model']);
                      }

                      if ($val['duty_instructor']) {
                        $duty_instructor = $val['duty_instructor'];
                      }
                      if (strpos($val['eet_utc'], ':') !== false) {
                        array_push($total, $val['eet_utc']);
                      }

                    ?>
                                    <tr>
                                        <td><?= $key + 1 ?>
                                        </td>
                                        <td><?= DATE('d M Y', strtotime($val['date'])) ?></td>
                                        <td class="text-left"><?= $val['ftd_model'] ?></td>
                                        <td class="text-left"><?= $val['pic'] ?></td>
                                        <td class="text-left"><?= $val['2nd'] ?></td>
                                        <td><?= $val['batch'] ?></td>
                                        <td class="text-left"><?= $val['course'] ?></td>
                                        <?php

                        if ($val['file_report']) {
                          $val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="' . base_url() . 'webfile/' . $val['file_report'] . '">' . $val['mission'] . '</a>';
                        }
                        ?>
                                        <td class="text-left"><?= $val['mission'] ?></td>

                                        <td><?= $val['block_time_atd'] ?></td>
                                        <td><?= $val['block_time_ata'] ?></td>
                                        <td><?= $val['block_time_total'] ?></td>
                                        <td class="text-left"><?= $val['remark_2'] ?></td>
                                        <td><?= $val['remark_report'] ?></td>
                                    </tr>
                                    <?php }


                    $total =  $this->template->sum_time($total);
                    $total2 =  $this->template->sum_time($total2);

                    // print_r($array_model);
                    $total_plan = $total;
                    $total_block_time = $total2;
                    $total_ftd = count($array_model);
                    $total_flight = count($data);

                    ?>
                                    <!-- <tr>
    <th colspan="10" class="text-right">TOTAL PLAN</th>
    <th><?= $total ?></th>
    <th colspan="3" class="text-right">TOTAL BLOCK TIME</th>
    <th><?= $total2 ?></th>
    <th></th> -->
                                    </tr>
                                </tbody>

                            </table>

                        </div>

                        <div class="table-responsive ">
                            <table>
                                <tr>
                                    <th class="text-left no-border" style="min-width:250px;">

                                        <p>TOTAL FTD ACTIVITY </p>


                                        <!-- <p>TOTAL IRREGULARITIES</p>  -->

                                    </th>
                                    <th class="no-border" style="min-width:15px">
                                        <p>:</p>
                                    </th>
                                    <th class="text-left no-border" style="min-width:250px;">
                                        <p><?= intval($total_movement) ?></p>
                                        <!-- <p><?= intval($total_irregularities) ?></p> -->
                                    </th>

                                    <th class="text-left no-border" style="min-width:250px;;">


                                        <p>TOTAL BLOCK TIME</p>

                                    </th>
                                    <th class="no-border" style="min-width:15px;">

                                        <p>:</p>
                                    </th>
                                    <th class="text-left no-border" style="min-width:250px;;">
                                        <p><?= $total_block_time ?></p>

                                    </th>


                                </tr>
                            </table>

                            <br>
                        </div>


                        <?php } ?>
                        <?php if ($flight > 0) { ?>


                        <div class="table-responsive ">
                            <table style="width:100%;" class="table table-bordered">
                                <thead>
                                    <tr class="bg-orange">
                                        <th colspan="21" style="font-size:15px;" class="text-left"> <label>FLIGHT
                                                INSTRUCTOR HOURS</label>
                                        </th>
                                    </tr>





                                    <tr class="bg-success">

                                        <th style="width:20px" rowspan="2">NO</th>
                                        <th style="min-width:110px" rowspan="2">DATE OF<br>FLIGHT</th>
                                        <th rowspan="2">ORIGIN<br>BASE</th>
                                        <th rowspan="2">AIRCRAFT<br>REG</th>
                                        <th rowspan="2">PIC</th>
                                        <th rowspan="2">2ND</th>
                                        <th rowspan="2">BATCH</th>
                                        <th rowspan="2">COURSE</th>
                                        <th rowspan="2">MISSION</th>
                                        <!-- <th rowspan="2">DESCRIPTION</th> -->
                                        <th rowspan="2">DEP</th>
                                        <th rowspan="2">ARR</th>
                                        <th rowspan="2">ROUTE</th>

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
                                        </th>
                                        <!-- <th rowspan="2">
  DUTY
  <br>INSTRUCTOR
</th> -->
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
                    $data = $this->mymodel->selectWithQuery("SELECT * 
FROM daily_flight_schedule a
WHERE (a.pic = '$pic' OR a.2nd = '$pic') AND  a.visibility = '1' AND a.visibility_report = '1' AND a.type = '' AND a.visibility_report = '1' AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND a.block_time_total NOT IN ('-','','00:00','0:00')
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");
                    // echo count($data);
                    $count = $this->mymodel->selectWithQuery("SELECT COUNT(a.id) as count FROM daily_flight_schedule a
WHERE (a.pic = '$pic' OR a.2nd = '$pic') AND a.visibility = '1' AND a.visibility_report = '1'   AND a.type = ''  AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND a.block_time_start NOT IN ('-','','00:00','0:00')
GROUP BY DATE(date_of_flight)");



                    $duty_instructor = '';
                    $total = array();
                    $total2 = array();
                    $total3 = array();
                    $total_movement = 0;
                    $array_aircraft = array();
                    $array_duty_instructor = array();
                    foreach ($data as $key => $val) {


                      $dat = $this->mymodel->selectDataOne('aircraft_document', array('serial_number' => $val['aircraft_reg']));
                      $temp = $val['aircraft_reg'];
                      $val['aircraft_reg'] = $dat['serial_number'];
                      if (empty($val['aircraft_reg'])) {
                        $val['aircraft_reg'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
                      $temp = $val['batch'];
                      $val['batch'] = $dat['batch'];
                      if (empty($val['batch'])) {
                        $val['batch'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $this->db->select('code_name');
                      $dat = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $val['tpm']));
                      $temp = $val['tpm'];
                      $val['tpm'] = $dat['code_name'];
                      if (empty($val['tpm'])) {
                        $val['tpm'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = '';
                      if (!in_array($val['pic'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['pic']));
                      }

                      if ($val['pic'] == $pic) {
                        if (strpos($val['block_time_total'], ':') !== false) {
                          array_push($total2, $val['block_time_total']);
                        }
                      }

                      $temp = $val['pic'];
                      $val['pic'] = $dat['nick_name'];

                      if (in_array($val['pic'], array('', '-'))) {
                        $val['pic'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = '';
                      if (!in_array($val['pic'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));
                      }
                      $temp = $val['2nd'];
                      $val['2nd'] = $dat['nick_name'];

                      if (in_array($val['2nd'], array('', '-'))) {
                        $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = '';
                      if (!in_array($val['duty_instructor'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['duty_instructor']));
                      }
                      $temp = $val['duty_instructor'];
                      $val['duty_instructor'] = $dat['nick_name'];
                      $vall['duty_instructor'] = $dat['nick_name'];

                      if (in_array($val['duty_instructor'], array('', '-'))) {
                        $val['duty_instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      if (!in_array($vall['duty_instructor'], array('', ' ', '-'))) {
                        if (!in_array($vall['duty_instructor'], $array_duty_instructor)) {
                          array_push($array_duty_instructor, $vall['duty_instructor']);
                        }
                      }

                      $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['mission'], 'type_of_training' => 'FLIGHT'));
                      $mission = $dat;
                      $temp = $val['mission'];
                      $val['mission'] = $dat['code_name'] . ' - ' . $dat['name'];

                      if (($val['mission']) == ' - ') {
                        $val['mission'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

                      $temp = $val['course'];
                      $val['course'] = $dat['code_name'];

                      if (($val['course']) == ' - ') {
                        $val['course'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }



                      $total_ldg += $val['ldg'];
                      $nomor++;
                      if (!in_array($val['aircraft_reg'], $array_aircraft)) {
                        array_push($array_aircraft, $val['aircraft_reg']);
                      }



                      if ($val['duty_instructor']) {
                        $duty_instructor = $val['duty_instructor'];
                      }

                      if (!in_array($val['remark_report'], array('', '-'))) {
                        $total_irregularities = $total_irregularities + 1;
                      }
                      if (strpos($val['block_time_start'], ':') !== false) {
                        $total_movement = $total_movement + 1;
                      }
                      if (strpos($val['eet'], ':') !== false) {
                        array_push($total, $val['eet']);
                      }





                      if (strpos($val['flight_time_total'], ':') !== false) {
                        array_push($total3, $val['flight_time_total']);
                      }


                    ?>
                                    <tr class="<?= $bg ?>">
                                        <td class="text-black"><?= $key + 1 ?></td>
                                        <td class="text-black"><?= DATE('d M Y', strtotime($val['date_of_flight'])) ?>
                                        </td>
                                        <td><?= $val['origin_base'] ?></td>
                                        <td><?= $val['aircraft_reg'] ?></td>
                                        <td class="text-left"><?= $val['pic'] ?></td>
                                        <td class="text-left"><?= $val['2nd'] ?></td>
                                        <td><?= $val['batch'] ?></td>
                                        <td><?= $val['course'] ?></td>
                                        <?php
                        if ($val['file_report']) {
                          $val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="' . base_url() . 'webfile/' . $val['file_report'] . '">' . $val['mission'] . '</a>';
                        }
                        ?>
                                        <td class="text-left"><?= $val['mission'] ?></td>
                                        <!-- <td><?= $val['description'] ?></td> -->
                                        <td><?= $val['dep'] ?></td>
                                        <td><?= $val['arr'] ?></td>
                                        <td class="text-left"><?= $val['rute'] ?></td>

                                        <td><?= $val['block_time_start'] ?></td>
                                        <td><?= $val['block_time_stop'] ?></td>
                                        <td><?= $val['block_time_total'] ?></td>
                                        <td><?= $val['flight_time_take_off'] ?></td>
                                        <td><?= $val['flight_time_landing'] ?></td>
                                        <td><?= $val['flight_time_total'] ?></td>
                                        <td><?= $val['ldg'] ?></td>
                                        <td class="text-left"><?= $val['remark_2'] ?></td>
                                        <td><?= $val['remark_report'] ?></td>
                                        <!-- <td class="text-black"><?= $val['duty_instructor'] ?></td> -->
                                    </tr>
                                    <?php
                      $total_ldg = $total_ldg + $val['ldg'];
                    }

                    $total_plan = $this->template->sum_time($total);
                    $total2 = $this->template->sum_time($total2);
                    $total3 = $this->template->sum_time($total3);

                    $total_aircraft = count($array_aircraft);
                    $total_flight = count($data);
                    $total_block_time = $total2;
                    $total_flight_time = $total3;
                    ?>

                                    <?php
                    $text = "";
                    foreach ($array_duty_instructor as $key => $val) {
                      if ($val) {
                        $text .= '' . $val . ', ';
                      }
                    }
                    $text = substr($text, 0, -2);

                    ?>


                                    <!-- <tr>
    <th colspan="12" class="text-right">TOTAL PLAN</th>
    <th><?= $total_plan ?></th>
    <th colspan="4" class="text-right">TOTAL BLOCK TIME</th>
    <th><?= $total2 ?></th>
    <th colspan="2" class="text-right">TOTAL FLIGHT TIME</th>
    <th><?= $total3 ?></th>
    <th><?= $total_ldg ?></th>
    <th colspan="3"></th>
  </tr> -->
                                </tbody>

                            </table>
                        </div>


                        <div class="table-responsive ">
                            <table>


                                <tr>
                                    <th class="text-left no-border">

                                        <p>DUTY INSTRUCTOR</p>

                                    </th>
                                    <th class="no-border">
                                        <p>:</p>
                                    </th>
                                    <th class="text-left no-border" colspan=4>
                                        <p><?= (count($count)) ?></p>
                                    </th>

                                    </td>

                                    </td>
                                </tr>


                                <tr>
                                    <th class="text-left no-border" style="min-width:250px;">

                                        <p>TOTAL MOVEMENT </p>
                                        <p>TOTAL LANDING </p>

                                        <p>TOTAL IRREGULARITIES</p>

                                    </th>
                                    <th class="no-border" style="min-width:15px;;">
                                        <p>:</p>
                                        <p>:</p>
                                        <p>:</p>
                                    </th>
                                    <th class="text-left no-border" style="min-width:250px;">
                                        <p><?= intval($total_movement) ?></p>
                                        <p><?= intval($total_ldg) ?></p>
                                        <p><?= intval($total_irregularities) ?></p>
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
                                        <p><?= $total_plan ?></p>
                                        <p><?= $total_block_time ?></p>
                                        <p><?= $total_flight_time ?></p>
                                        <?php
                      $total_plan = (explode(":", $total_plan));
                      $total_block_time = (explode(":", $total_block_time));

                      $jam_plan = $total_plan[0] * 60;
                      $jam_plan = $jam_plan + $total_plan[1];

                      $jam_block_time = $total_block_time[0] * 60;
                      $jam_block_time = $jam_block_time + $total_block_time[1];

                      $persentase = number_format(($jam_block_time / $jam_plan) * 100, 1) . ' %';

                      ?>
                                        <p><?= $persentase ?></p>
                                    </th>

                                </tr>
                            </table>
                            <br>
                        </div>


                        <div class="table-responsive ">
                            <table style="width:100%;" class="table table-bordered">
                                <thead>
                                    <tr class="bg-orange">
                                        <th colspan="25" style="font-size:15px;" class="text-left"> <label>DUTY
                                                INSTRUCTOR</label>
                                        </th>
                                    </tr>





                                    <tr class="bg-success">

                                        <th style="width:20px" rowspan="2">NO</th>
                                        <th style="min-width:110px" rowspan="2">DATE OF<br>FLIGHT</th>
                                        <th rowspan="2">ORIGIN<br>BASE</th>
                                        <th rowspan="2">AIRCRAFT<br>REG</th>
                                        <th rowspan="2">PIC</th>
                                        <th rowspan="2">2ND</th>
                                        <th rowspan="2">BATCH</th>
                                        <th rowspan="2">COURSE</th>
                                        <th rowspan="2">MISSION</th>
                                        <!-- <th rowspan="2">DESCRIPTION</th> -->
                                        <th rowspan="2">DEP</th>
                                        <th rowspan="2">ARR</th>
                                        <th rowspan="2">ROUTE</th>

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
                                        </th>
                                        <!-- <th rowspan="2">
  DUTY
  <br>INSTRUCTOR
</th> -->
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
                    $data = $this->mymodel->selectWithQuery("SELECT * 
FROM daily_flight_schedule a

WHERE a.duty_instructor = '$pic' AND  a.visibility = '1' AND a.visibility_report = '1' AND a.type = '' AND a.visibility_report = '1' AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND a.block_time_total NOT IN ('-','','00:00','0:00')
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");
                    // echo count($data);
                    $count = $this->mymodel->selectWithQuery("SELECT COUNT(a.id) as count FROM daily_flight_schedule a
WHERE a.duty_instructor = '$pic' AND a.visibility = '1' AND a.visibility_report = '1'   AND a.type = ''  AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND a.block_time_start NOT IN ('-','','00:00','0:00')
GROUP BY DATE(date_of_flight)");


                    foreach ($data as $key => $val) {


                      $dat = $this->mymodel->selectDataOne('aircraft_document', array('serial_number' => $val['aircraft_reg']));
                      $temp = $val['aircraft_reg'];
                      $val['aircraft_reg'] = $dat['serial_number'];
                      if (empty($val['aircraft_reg'])) {
                        $val['aircraft_reg'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
                      $temp = $val['batch'];
                      $val['batch'] = $dat['batch'];
                      if (empty($val['batch'])) {
                        $val['batch'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $this->db->select('code_name');
                      $dat = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $val['tpm']));
                      $temp = $val['tpm'];
                      $val['tpm'] = $dat['code_name'];
                      if (empty($val['tpm'])) {
                        $val['tpm'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = '';
                      if (!in_array($val['pic'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['pic']));
                      }

                      if ($val['pic'] == $pic) {
                        if (strpos($val['block_time_total'], ':') !== false) {
                          array_push($total2, $val['block_time_total']);
                        }
                      }

                      $temp = $val['pic'];
                      $val['pic'] = $dat['nick_name'];

                      if (in_array($val['pic'], array('', '-'))) {
                        $val['pic'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = '';
                      if (!in_array($val['pic'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));
                      }
                      $temp = $val['2nd'];
                      $val['2nd'] = $dat['nick_name'];

                      if (in_array($val['2nd'], array('', '-'))) {
                        $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = '';
                      if (!in_array($val['duty_instructor'], array('', '-'))) {
                        $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['duty_instructor']));
                      }
                      $temp = $val['duty_instructor'];
                      $val['duty_instructor'] = $dat['nick_name'];
                      $vall['duty_instructor'] = $dat['nick_name'];

                      if (in_array($val['duty_instructor'], array('', '-'))) {
                        $val['duty_instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      if (!in_array($vall['duty_instructor'], array('', ' ', '-'))) {
                        if (!in_array($vall['duty_instructor'], $array_duty_instructor)) {
                          array_push($array_duty_instructor, $vall['duty_instructor']);
                        }
                      }

                      $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['mission'], 'type_of_training' => 'FLIGHT'));
                      $mission = $dat;
                      $temp = $val['mission'];
                      $val['mission'] = $dat['code_name'] . ' - ' . $dat['name'];

                      if (($val['mission']) == ' - ') {
                        $val['mission'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }

                      $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

                      $temp = $val['course'];
                      $val['course'] = $dat['code_name'];

                      if (($val['course']) == ' - ') {
                        $val['course'] = '<a class="text-red"><b>' . $temp . '</b></a>';
                      }



                      $total_ldg += $val['ldg'];
                      $nomor++;
                      if (!in_array($val['aircraft_reg'], $array_aircraft)) {
                        array_push($array_aircraft, $val['aircraft_reg']);
                      }



                      if ($val['duty_instructor']) {
                        $duty_instructor = $val['duty_instructor'];
                      }

                      if (!in_array($val['remark_report'], array('', '-'))) {
                        $total_irregularities = $total_irregularities + 1;
                      }
                      if (strpos($val['block_time_start'], ':') !== false) {
                        $total_movement = $total_movement + 1;
                      }
                      if (strpos($val['eet'], ':') !== false) {
                        array_push($total, $val['eet']);
                      }




                      if (strpos($val['flight_time_total'], ':') !== false) {
                        array_push($total3, $val['flight_time_total']);
                      }

                      $bg = '';
                      if ($val['id_duty'] == $id) {
                        $bg = 'text-grey';
                      }




                      $val['pic'] = $val['pic'];

                    ?>
                                    <tr class="<?= $bg ?>">
                                        <td class="text-black"><?= $key + 1 ?></td>
                                        <td class="text-black"><?= DATE('d M Y', strtotime($val['date_of_flight'])) ?>
                                        </td>
                                        <td><?= $val['origin_base'] ?></td>
                                        <td><?= $val['aircraft_reg'] ?></td>
                                        <td class="text-left"><?= $val['pic'] ?></td>
                                        <td class="text-left"><?= $val['2nd'] ?></td>
                                        <td><?= $val['batch'] ?></td>
                                        <td><?= $val['course'] ?></td>
                                        <?php
                        if ($val['file_report']) {
                          $val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="' . base_url() . 'webfile/' . $val['file_report'] . '">' . $val['mission'] . '</a>';
                        }
                        ?>
                                        <td class="text-left"><?= $val['mission'] ?></td>
                                        <!-- <td><?= $val['description'] ?></td> -->
                                        <td><?= $val['dep'] ?></td>
                                        <td><?= $val['arr'] ?></td>
                                        <td class="text-left"><?= $val['rute'] ?></td>

                                        <td><?= $val['block_time_start'] ?></td>
                                        <td><?= $val['block_time_stop'] ?></td>
                                        <td><?= $val['block_time_total'] ?></td>
                                        <td><?= $val['flight_time_take_off'] ?></td>
                                        <td><?= $val['flight_time_landing'] ?></td>
                                        <td><?= $val['flight_time_total'] ?></td>
                                        <td><?= $val['ldg'] ?></td>
                                        <td class="text-left"><?= $val['remark_2'] ?></td>
                                        <td><?= $val['remark_report'] ?></td>
                                        <!-- <td class="text-black"><?= $val['duty_instructor'] ?></td> -->
                                    </tr>
                                    <?php

                    }


                    ?>




                                </tbody>

                            </table>
                        </div>

                        <br>

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

            <form action="<?= base_url('fitur/impor/daily_flight_schedule') ?>" method="POST"
                enctype="multipart/form-data">



                <div class="modal-body">

                    <div class="form-group">

                        <label for="">File Excel</label>

                        <input type="file" class="form-control" id="" name="file" placeholder="Input field">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>

                </div>

            </form>



        </div>

    </div>

</div>