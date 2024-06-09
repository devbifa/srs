<?php
$data['page_name'] = "daily_flight_schedule";

$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$origin_base = $_SESSION['origin_base'];

if (empty($start_date)) {
  // $_SESSION['start_date'] = DATE('Y-m-d');
  // $_SESSION['end_date'] = DATE('Y-m-d');
  // $start_date = $_SESSION['start_date'];
  // $end_date = $_SESSION['end_date'];
}

if (empty($end_date)) {
  // $_SESSION['start_date'] = DATE('Y-m-d');
  // $_SESSION['end_date'] = DATE('Y-m-d');
  // $start_date = $_SESSION['start_date'];
  // $end_date = $_SESSION['end_date'];
}

if ($origin_base) {
  $origin_base = "  AND a.origin_base = '$origin_base' ";
} else {
  $origin_base = " ";
}

// $id = $this->session->userdata('id');
// $user = $this->mymodel->selectDataone('user',array('id'=>$id));
// $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
// $base = $base['base'];

// if($_SESSION['origin_b']=='23'){
// 	$base = " AND a.origin_base = '$base' ";
// }else{
// 	$base = " ";
// }

$batch = $_SESSION['batch'];
if ($batch) {
  $batch = " AND a.batch = '$batch' ";
} else {
  $batch = "";
}


?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            DAILY FLIGHT SCHEDULE

            <small>CREATE</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


            <li class="#">DAILY FLIGHT SCHEDULE</li>

            <li class="active">CREATE</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/daily_flight_schedule/store') ?>" id="upload-create"
            enctype="multipart/form-data">



            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    CREATE DAILY FLIGHT SCHEDULE
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

                            <div class="show_error"></div>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="row">

                                        <div class="form-group col-md-3">

                                            <label for="form-date_of_flight">DATE OF FLIGHT</label>

                                            <input autocomplete="off" type="text" class="form-control tgl"
                                                id="form-date_of_flight" placeholder="Masukan Date Of Flight"
                                                name="dt[date_of_flight]" value="<?= DATE('Y-m-d') ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-origin_base">ORIGIN BASE</label>

                                            <select style='width:100%' name="dt[origin_base]"
                                                class="form-control select2">
                                                <!-- <option value="">SELECT ORIGIN BASE</option> -->
                                                <?php
                        $id = $this->session->userdata('id');
                        $user = $this->mymodel->selectDataone('user', array('id' => $id));
                        $base = $this->mymodel->selectDataone('base_airport_document', array('id' => $user['base']));
                        $user['base'] = $base['base'];
                        if ($_SESSION['role_id'] == '23') {
                          $base_airport_document = $this->mymodel->selectWhere('base_airport_document', array('base' => $user['base']));
                        } else {
                          $base_airport_document = $this->mymodel->selectWhere('base_airport_document', null);
                        }


                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text = "";

                          if ($base_airport_document_record['base'] == $daily_flight_schedule['origin_base']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $base_airport_document_record['base'] . "' " . $text . " >" . $base_airport_document_record['base'] . "</option>";
                        }

                        ?>

                                            </select>

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-aircraft_reg">AIRCRAFT REG</label>

                                            <select style='width:100%' name="dt[aircraft_reg]"
                                                class="form-control select2">
                                                <option value="">SELECT AIRCRAFT REG</option>
                                                <?php

                        $aircraft_document = $this->mymodel->selectWhere('aircraft_document', array('status' => 'SERVICEABLE'));

                        foreach ($aircraft_document as $val) {

                          $text = "";

                          if ($val['serial_number'] == $daily_flight_schedule['aircraft_reg']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val['serial_number'] . "' " . $text . " >" . $val['serial_number'] . " (" . $val['type'] . ")</option>";
                        }

                        ?>

                                            </select>

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-classroom">BATCH</label>

                                            <select style='width:100%' name="dt[batch]" class="form-control select2"
                                                id="batch">
                                                <option value="">SELECT BATCH</option>
                                                <?php

                        $arr = $this->mymodel->selectWithQuery("SELECT a.*,b.name FROM batch a LEFT JOIN syllabus_curriculum b ON a.curriculum = b.code ORDER BY a.batch ASC");

                        foreach ($arr as $val) {

                          $text = "";

                          if ($val['code'] == $daily_flight_schedule['batch']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['batch'] . ' (' . $val['name'] . ")</option>";
                        }

                        ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-6 d-none">

                                            <label for="form-description">TPM</label>
                                            <?php
                      $tpm = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $daily_flight_schedule['tpm']));
                      ?>
                                            <select class="form-control select2" id="tpm" placeholder="Masukan TPM"
                                                name="dt[tpm]">
                                                <option value="<?= $tpm['code'] ?>"><?= $tpm['name'] ?></option>
                                            </select>

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-2nd">PIC</label>

                                            <select style='width:100%' name="dt[pic]" class="form-control select2"
                                                id="pic">


                                                <option value="">SELECT PIC/INSTRUCTOR</option>
                                                <?php

                        $instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'"));

                        foreach ($instructor as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_flight_schedule['pic']) {

                            $text = "selected";
                          }

                          if (strpos($val['type'], 'FLIGHT') !== false) {
                            echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                          }
                        }


                        ?>

                                                <option value="">SELECT STUDENT</option>
                                                <?php
                        $this->db->order_by("nick_name ASC");
                        $student_document = $this->mymodel->selectWhere('user', array('batch' => $daily_flight_schedule['batch'], 'status' => 'ACTIVE'));

                        foreach ($student_document as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_flight_schedule['pic']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                        }

                        ?>

                                            </select>

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-2nd">2ND</label>

                                            <select style='width:100%' name="dt[2nd]" class="form-control select2"
                                                id="2nd">

                                                <option value="-">SELECT 2ND/INSTRUCTOR</option>
                                                <?php

                        $instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'"));

                        foreach ($instructor as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_flight_schedule['2nd']) {

                            $text = "selected";
                          }

                          if (strpos($val['type'], 'FLIGHT') !== false) {
                            echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                          }
                        }


                        ?>

                                                <option value="">SELECT STUDENT</option>
                                                <?php
                        $this->db->order_by("nick_name ASC");
                        $student_document = $this->mymodel->selectWhere('user', array('batch' => $daily_flight_schedule['batch'], 'status' => 'ACTIVE'));

                        foreach ($student_document as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_flight_schedule['2nd']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                        }

                        ?>

                                            </select>

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-course">COURSE</label>
                                            <select style='width:100%' name="dt[course]" class="form-control select2"
                                                id="course">
                                                <option value="">SELECT COURSE</option>
                                                <?php
                        $batch = $daily_flight_schedule['batch'];
                        $type = 'FLIGHT';
                        $batch = $this->mymodel->selectDataOne('batch', array('code' => $batch));
                        $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));
                        $arr_course = json_decode($curriculum['course'], true);
                        $curriculum = $curriculum['name'];
                        $qry = '"' . $type . '":{"status":"ON"}';
                        $data = $this->mymodel->selectWithQuery("SELECT *
                        FROM syllabus_course
                        WHERE type_of_training LIKE '%$qry%' 
                            ORDER BY position ASC");

                        foreach ($data as $val) {

                          $text = "";

                          if ($val['code'] == $daily_flight_schedule['course']) {

                            $text = "selected";
                          }

                          if ($arr_course[$type][$val['code']]['status'] == 'ON') {

                            echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['code'] . " - " . $val['name'] . "</option>";
                          }
                        }

                        ?>

                                            </select>

                                        </div>



                                        <div class="form-group col-md-3">

                                            <label for="form-mission">MISSION</label>

                                            <select style='width:100%' name="dt[mission]" class="form-control select2"
                                                id="mission">
                                                <option value="">SELECT MISSION</option>
                                                <?php
                        $batch = $daily_flight_schedule['batch'];
                        $batch = $this->mymodel->selectDataOne('batch', array('code' => $batch));
                        $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));
                        $arr_mission = json_decode($curriculum['mission'], true);

                        $v_type = 'FLIGHT';
                        $code_course = $daily_flight_schedule['course'];
                        $data = $this->mymodel->selectWhere('syllabus_mission', "type_of_training = '$v_type' AND course = '$code_course' 
                        ORDER BY position ASC");

                        foreach ($data as $val) {

                          $text = "";

                          if ($val['code'] == $daily_flight_schedule['mission']) {

                            $text = "selected";
                          }

                          if ($arr_mission[$v_type][$code_course][$val['code']]['status'] == 'ON') {
                            echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['code_name'] . ' - ' . $val['name'] . "</option>";
                          }
                        }

                        ?>

                                            </select>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-description">DESCRIPTION</label>
                                            <input type="text" class="form-control" id="description"
                                                placeholder="Masukan Description" name="dt[description]"
                                                value="<?= $daily_flight_schedule['description'] ?>">

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-rute">RUTE</label>

                                            <input type="text" class="form-control" id="form-rute"
                                                placeholder="Masukan Rute" name="dt[rute]"
                                                value="<?= $daily_flight_schedule['rute'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-etd_utc">ETD UTC</label>

                                            <input type="text" class="form-control" id="etd2"
                                                placeholder="Masukan Etd Utc" name="dt[etd_utc]"
                                                value="<?= $daily_flight_schedule['etd_utc'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eet">EET</label>

                                            <input type="text" class="form-control" id="eet2" placeholder="Masukan Eet"
                                                name="dt[eet]" value="<?= $daily_flight_schedule['eet'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eta_utc">ETA UTC</label>

                                            <input type="text" class="form-control" id="eta2"
                                                placeholder="Masukan Eta Utc" name="dt[eta_utc]"
                                                value="<?= $daily_flight_schedule['eta_utc'] ?>">

                                        </div>
                                        <div class="form-group col-md-12">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-dep">DEP</label>

                                            <input type="text" class="form-control" id="form-dep"
                                                placeholder="Masukan Dep" name="dt[dep]"
                                                value="<?= $daily_flight_schedule['dep'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-arr">ARR</label>

                                            <input type="text" class="form-control" id="form-arr"
                                                placeholder="Masukan Arr" name="dt[arr]"
                                                value="<?= $daily_flight_schedule['arr'] ?>">

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-2nd">DUTY INSTRUCTOR</label>

                                            <select style='width:100%' name="dt[duty_instructor]"
                                                class="form-control select2">


                                                <option value="">SELECT DUTY INSTRUCTOR</option>
                                                <?php

                        $instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FLIGHT%'"));

                        foreach ($instructor as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_flight_schedule['duty_instructor']) {

                            $text = "selected";
                          }

                          if (strpos($val['type'], 'FLIGHT') !== false) {
                            echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                          }
                        }


                        ?>


                                            </select>

                                        </div>
                                        <div class="form-group col-md-12">

                                            <label for="form-remark">REMARK</label>

                                            <input type="text" class="form-control" id="form-remark"
                                                placeholder="Masukan Remark" name="dt[remark]"
                                                value="<?= $daily_flight_schedule['remark'] ?>">

                                        </div>
                                        <!-- <div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                      if ($file['dir'] != "") { ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div> -->
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                            <div class="">

                                <button type="submit" class="btn btn-primary btn-send pull-right"><i
                                        class="fa fa-save"></i> SAVE</button>



                                <div class="col-md-12">
                                </div>


        </form>




        <div class="">

            <!-- FILTER  -->
            <div class="row">
                <div class="">
                    <form autocomplete="off" action="<?= base_url() ?>master/daily_flight_schedule/filter_create"
                        method="post">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>SELECT BASE</label>
                                <select style='width:100%' name="origin_base" class="form-control select2">
                                    <option value="">SELECT ORIGIN BASE</option>
                                    <?php
                  $this->db->order_by('base ASC');

                  $id = $this->session->userdata('id');
                  $user = $this->mymodel->selectDataone('user', array('id' => $id));
                  $base = $this->mymodel->selectDataone('base_airport_document', array('id' => $user['base']));
                  $base_id = $user['base'];
                  $user['base'] = $base['base'];

                  $base = $base['base'];
                  if ($_SESSION['role_id'] == '23') {
                    $base = " AND a.origin_base = '$base' ";

                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document', array('id' => $base_id));
                  } else {
                    $base = " ";
                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document', null);
                  }



                  foreach ($base_airport_document as $base_airport_document_record) {

                    $text = "";

                    if ($base_airport_document_record['base'] == $_SESSION['origin_base']) {

                      $text = "selected";
                    }



                    echo "<option value='" . $base_airport_document_record['base'] . "' " . $text . " >" . $base_airport_document_record['base'] . "</option>";
                  }

                  ?>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>START DATE</label>
                                <input placeholder="Date" type="text" class="form-control tgl"
                                    value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>END DATE</label>
                                <input placeholder="Date" type="text" class="form-control tgl"
                                    value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp</label><br>
                                <button class="btn btn-success btn-block"><i class="mdi mdi-database-search"></i>
                                    FILTER</button>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp</label><br>
                                <a href="<?= base_url('fitur/export/daily_flight_schedule') ?>" target="_blank">

                                    <button type="button" class="btn btn-block btn-warning"><i
                                            class="mdi mdi-arrow-up-bold-circle-outline"></i> EXPORT DATA</button>

                                </a>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp</label><br>
                                <button type="button" class="btn  btn-block  btn-info"
                                    onclick="$('#modal-impor').modal()"><i
                                        class="mdi mdi-arrow-down-bold-circle-outline"></i> IMPORT DATA</button>

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

                        <form action="<?= base_url('fitur/import/daily_flight_schedule') ?>" method="POST"
                            enctype="multipart/form-data">



                            <div class="modal-body">

                                <div class="form-group">

                                    <label for="">File Excel</label>

                                    <input required type="file" class="form-control" id="" name="file"
                                        placeholder="Input field">

                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                        class="fa fa-times"></i> Close</button>

                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Import</button>

                            </div>

                        </form>



                    </div>

                </div>

            </div>



            <hr>

            <label for="form-remark">PREVIEW LIST</label>

            <?= $_SESSION['propose'] ?>
            <?php $_SESSION['propose'] = '' ?>

            <div class="table-responsive">


                <table class="table table-bordered table-striped" id="mytable" style="width:100%">

                    <thead>


                        <tr class="bg-success">
                            <th style="width:20px">NUM</th>
                            <th style="min-width:100px">ACTION</th>
                            <th style="min-width:110px">DATE OF<br>FLIGHT</th>
                            <th>ORIGIN<br>BASE</th>
                            <th>AIRCRAFT<br>REG</th>
                            <th>PIC</th>
                            <th>2ND</th>
                            <th>BATCH</th>
                            <th>TPM</th>
                            <th>COURSE</th>
                            <th>MISSION</th>
                            <th>DEP</th>
                            <th>ARR</th>
                            <th>ROUTE</th>
                            <th>ETD<br>UTC</th>
                            <th>ETA<br>UTC</th>
                            <th>EET</th>
                            <th>REMARK</th>
                            <th>DUTY INSTRUCTOR</th>
                            <th>PROPOSE</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php

            $duty_instructor = '';
            $total = array();
            $array_aircraft = array();

            $array_duty_instructor = array();
            if ($_SESSION['origin_base']) {
              $approval = $this->mymodel->selectDataOne('approval', array('date' => $_SESSION['start_date'], 'base' => $_SESSION['origin_base'], 'type' => 'FLIGHT'));
            }
            ?>


                        <?php

            $data_date =  $this->template->date_range($start_date, $end_date);

            $duty_instructor = '';
            $total = array();
            $array_aircraft = array();

            $array_duty_instructor = array();

            $nomor = 0;
            foreach ($data_date as $v => $k) {
              $start_date = $k;
              $end_date = $k;
            ?>


                        <?php
              $data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
WHERE a.visibility = '0' AND DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$start_date'  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
AND a.type = '' "
                . $origin_base .
                "
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");
              foreach ($data as $key => $val) {

                if ($approval and $approval['prepared_time'] >= $val['created_at']) {
                  $sent = '<span class="text-blue">Sent</span>';
                } else {
                  $sent = '<span class="text-red">Not Sent</span>';
                }
                // $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
                // $val['aircraft_reg'] = $dat['nick_name'];

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

                if (in_array($val['duty_instructor'], array('', '-'))) {
                  $val['duty_instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
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

                $nomor++;
                if (!in_array($val['aircraft_reg'], $array_aircraft)) {
                  array_push($array_aircraft, $val['aircraft_reg']);
                }

                if (!in_array($val['duty_instructor'], $array_duty_instructor)) {
                  array_push($array_duty_instructor, $val['duty_instructor']);
                }

                if ($val['duty_instructor']) {
                  $duty_instructor = $val['duty_instructor'];
                }
                if (strpos($val['eet'], ':') !== false) {
                  array_push($total, $val['eet']);
                }

                $val['pic'] = $val['pic'];

                $explode = explode(":", $val['etd_utc']);
                if ($explode[0] > 24 || $explode[1] > 60) {
                  $val['etd_utc'] = '<span class="text-red">' . $val['etd_utc'] . '</span>';
                }

                $explode = explode(":", $val['eet']);
                if ($explode[0] > 24 || $explode[1] > 60) {
                  $val['eet'] = '<span class="text-red">' . $val['eet'] . '</span>';
                }

              ?>
                        <tr>
                            <td><?= $nomor ?></td>
                            <td><a href="<?= base_url() ?>master/daily_flight_schedule/edit/<?= $val['id'] ?>"
                                    class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
                                <a href="#!" data-toggle="modal" data-target="#modal-delete-<?= $val['id'] ?>"
                                    class="btn btn-danger btn-rounded btn-xs"><i class="mdi mdi-delete"></i></a>



                                <div class="modal modal-danger fade" id="modal-delete-<?= $val['id'] ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">DELETE SCHEDULE</h4>
                                            </div>
                                            <div class="modal-body" style="color:#fff!important;">
                                                <form action="">
                                                    <span style="font-weight:100">Are you sure you want to delete this
                                                        schedule?</span>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline pull-left"
                                                    data-dismiss="modal">Close</button>
                                                <a type="button" class="btn btn-outline"
                                                    href="<?= base_url() ?>master/daily_flight_schedule/delete_data/<?= $val['id'] ?>">Delete
                                                    Now</a>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>



                            </td>
                            <td><?= DATE('d M Y', strtotime($val['date_of_flight'])) ?></td>
                            <td><?= $val['origin_base'] ?></td>
                            <td><?= $val['aircraft_reg'] ?></td>
                            <td class="text-left"><?= $val['pic'] ?></td>
                            <td class="text-left"><?= $val['2nd'] ?></td>
                            <td><?= $val['batch'] ?></td>
                            <td><?= $val['tpm'] ?></td>
                            <td><?= $val['course'] ?></td>
                            <?php
                  if ($mission['file']) {
                    $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="' . base_url() . 'webfile/tpm/' . $mission['file'] . '">' . $val['mission'] . '</a>';
                  }
                  ?>
                            <td class="text-left"><?= $val['mission'] ?></td>
                            <td><?= $val['dep'] ?></td>
                            <td><?= $val['arr'] ?></td>
                            <td class="text-left"><?= $val['rute'] ?></td>
                            <td><?= $val['etd_utc'] ?></td>
                            <td><?= $val['eta_utc'] ?></td>
                            <td><?= $val['eet'] ?></td>
                            <td class="text-left"><?= $val['remark'] ?></td>
                            <td class="text-left"><?= $val['duty_instructor'] ?></td>
                            <td class=""><?= $sent ?><br><?= $approval['prepared_time'] ?></td>
                        </tr>
                        <?php } ?>



                        <?php

              $data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
WHERE a.visibility = '0' AND DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$start_date' AND etd_utc >= '00:00' AND etd_utc <= '21:59'
AND a.type = '' "
                . $origin_base .
                "
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC
");

              foreach ($data as $key => $val) {

                if ($approval and $approval['prepared_time'] >= $val['created_at']) {
                  $sent = '<span class="text-blue">Sent</span>';
                } else {
                  $sent = '<span class="text-red">Not Sent</span>';
                }

                // $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
                // $val['aircraft_reg'] = $dat['nick_name'];


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

                if (in_array($val['duty_instructor'], array('', '-'))) {
                  $val['duty_instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
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


                $nomor++;
                if (!in_array($val['aircraft_reg'], $array_aircraft)) {
                  array_push($array_aircraft, $val['aircraft_reg']);
                }

                if (!in_array($val['duty_instructor'], $array_duty_instructor)) {
                  array_push($array_duty_instructor, $val['duty_instructor']);
                }

                if ($val['duty_instructor']) {
                  $duty_instructor = $val['duty_instructor'];
                }
                if (strpos($val['eet'], ':') !== false) {
                  array_push($total, $val['eet']);
                }

                $val['pic'] = $val['pic'];

                $explode = explode(":", $val['etd_utc']);
                if ($explode[0] > 24 || $explode[1] > 60) {
                  $val['etd_utc'] = '<span class="text-red"><b>' . $val['etd_utc'] . '</b></span>';
                }

                $explode = explode(":", $val['eet']);
                if ($explode[0] > 24 || $explode[1] > 60) {
                  $val['eet'] = '<span class="text-red"><b>' . $val['eet'] . '</b></span>';
                }

              ?>
                        <tr>
                            <td><?= $nomor ?></td>
                            <td><a href="<?= base_url() ?>master/daily_flight_schedule/edit/<?= $val['id'] ?>"
                                    class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
                                <a href="#!" data-toggle="modal" data-target="#modal-delete-<?= $val['id'] ?>"
                                    class="btn btn-danger btn-rounded btn-xs"><i class="mdi mdi-delete"></i></a>






                                <div class="modal modal-danger fade" id="modal-delete-<?= $val['id'] ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">DELETE SCHEDULE</h4>
                                            </div>
                                            <div class="modal-body" style="color:#fff!important;">
                                                <form action="">
                                                    <span style="font-weight:100">Are you sure you want to delete this
                                                        schedule?</span>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline pull-left"
                                                    data-dismiss="modal">Close</button>
                                                <a type="button" class="btn btn-outline"
                                                    href="<?= base_url() ?>master/daily_flight_schedule/delete_data/<?= $val['id'] ?>">Delete
                                                    Now</a>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                            </td>
                            <td><?= DATE('d M Y', strtotime($val['date_of_flight'])) ?></td>
                            <td><?= $val['origin_base'] ?></td>
                            <td><?= $val['aircraft_reg'] ?></td>
                            <td class="text-left"><?= $val['pic'] ?></td>
                            <td class="text-left"><?= $val['2nd'] ?></td>
                            <td><?= $val['batch'] ?></td>
                            <td><?= $val['tpm'] ?></td>
                            <td><?= $val['course'] ?></td>
                            <?php
                  if ($mission['file']) {
                    $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="' . base_url() . 'webfile/tpm/' . $mission['file'] . '">' . $val['mission'] . '</a>';
                  }
                  ?>
                            <td class="text-left"><?= $val['mission'] ?></td>
                            <td><?= $val['dep'] ?></td>
                            <td><?= $val['arr'] ?></td>
                            <td class="text-left"><?= $val['rute'] ?></td>
                            <td><?= $val['etd_utc'] ?></td>
                            <td><?= $val['eta_utc'] ?></td>
                            <td><?= $val['eet'] ?></td>
                            <td class="text-left"><?= $val['remark'] ?></td>
                            <td class="text-left"><?= $val['duty_instructor'] ?></td>
                            <td class=""><?= $sent ?><br><?= $approval['prepared_time'] ?></td>
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
            foreach ($array_duty_instructor as $key => $val) {
              if ($val) {
                $text .= '' . $val . ', ';
              }
            }
            $text = substr($text, 0, -2);

            ?>


                        <!-- <tr>
  <th colspan="12" class="text-right">TOTAL PLAN</th>
  <th><?= $total ?></th>
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
                        <th class="text-left no-border" colspan="3">
                            <p><?= $text ?></p>
                        </th>


                    </tr>

                    <tr>
                        <th class="text-left no-border" style="min-width:250px;">

                            <p>TOTAL FLIGHT SCHEDULE</p>

                            <p>TOTAL AIRCRAFT IN USE </p>

                            <p>TOTAL PLAN</p>

                        </th>
                        <th class="no-border" style="min-width:15px;">
                            <p>:</p>
                            <p>:</p>
                            <p>:</p>
                        </th>
                        <th class="text-left no-border" style="min-width:350px;">
                            <p><?= $total_flight ?></p>
                            <p><?= $total_aircraft ?></p>
                            <p><?= $total_plan ?></p>
                        </th>
                        <td class="no-border" style="width:25%;padding-top:21px;">

                        </td>
                        <td class="no-border" style="width:25%">

                        </td>
                    </tr>
                </table>


            </div>


            <br>

            <?php if ($nomor > 0 and $_SESSION['origin_base']) { ?>
            <a href="#!" data-toggle="modal" data-target="#modal-delete" id="" class="btn btn-danger pull-left"><i
                    class="mdi mdi-delete"></i> RESET SCHEDULE</a>
            <div class="modal modal-danger fade" id="modal-delete">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">CONFIRMATION RESET DATA</h4>
                        </div>
                        <div class="modal-body" style="color:#fff!important;">
                            <form action="">
                                <span style="font-weight:100">Are you sure you want to reset this data?</span>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                            <a type="button" class="btn btn-outline"
                                href="<?= base_url() ?>master/daily_flight_schedule/reset" id="submit-now">Reset Now</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <?php } ?>
            <a href="#!" data-toggle="modal" data-target="#modal-submit" id="button-submit"
                class="btn btn-primary pull-right"><i class="mdi mdi-send"></i> PROPOSE FOR APPROVAL</a>

            <?php if ($_SESSION['start_date'] != $_SESSION['end_date']) { ?>
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
                                <span style="font-weight:100">Maximum propose schedule one day only!</span>
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


            <?php } else if (empty($_SESSION['origin_base'])) { ?>
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



            <?php } else if ($nomor > 0) { ?>
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
                            <a type="button" class="btn btn-outline"
                                href="<?= base_url() ?>master/daily_flight_schedule/submit" id="submit-now">Propose
                                Now</a>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>


            <?php } else { ?>
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
                                <span style="font-weight:100">Data is empty. Please insert daily flight schedule!</span>
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

<div class="col-md-6">

    <div class="row">

    </div>
</div>
</div>
<div class="">


</div>

<!-- /.box-body -->

</div>

<!-- /.box -->



<!-- /.box -->

</div>
</div>

<!-- /.col -->

</div>

<!-- /.row -->



</section>
<!-- /.content -->

</div>

<!-- /.content-wrapper -->

<script type="text/javascript">
$('#submit-now').click(function() {
    $('#button-submit').addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i> Processing...").attr(
        'disabled', true);
    $('#submit-now').addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i> Processing...").attr(
        'disabled', true);
});


$("#upload-create").submit(function() {

    var form = $(this);

    var mydata = new FormData(this);

    $.ajax({

        type: "POST",

        url: form.attr("action"),

        data: mydata,

        cache: false,

        contentType: false,

        processData: false,

        beforeSend: function() {

            $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr(
                'disabled', true);

            form.find(".show_error").slideUp().html("");

        },

        success: function(response, textStatus, xhr) {

            // alert(mydata);

            var str = response;

            if (str.indexOf("success") != -1) {

                form.find(".show_error").hide().html(response).slideDown("fast");

                setTimeout(function() {

                    window.location.href =
                        "<?= base_url('master/daily_flight_schedule/create') ?>";

                }, 1000);

                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr(
                    'disabled', false);





            } else {

                form.find(".show_error").hide().html(response).slideDown("fast");

                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr(
                    'disabled', false);



            }

        },

        error: function(xhr, textStatus, errorThrown) {

            console.log(xhr);

            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr(
                'disabled', false);

            form.find(".show_error").hide().html(xhr).slideDown("fast");



        }

    });

    return false;



});
</script>


<script>
$(document).ready(function() {
    $('#batch').change(function() {
        var batch = $('#batch').val();

        $("#pic").html('<option>LOADING...</option>');

        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_tpm/?batch=' + batch,
                success: function(html) {
                    $("#tpm").html(html);
                }
            });
        } else {

        }


        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_pic_by_batch/?batch=' + batch + '&type=FLIGHT',
                success: function(html) {
                    $("#pic").html(html);
                }
            });
        } else {

        }

        $("#2nd").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_2nd_by_batch/?batch=' + batch + '&type=FLIGHT',
                success: function(html) {
                    $("#2nd").html(html);
                }
            });
        } else {

        }

        $("#course").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_course_by_batch/?batch=' + batch +
                    '&type=FLIGHT',
                success: function(html) {
                    $("#course").html(html);
                }
            });
        } else {

        }



    });

});

$(document).ready(function() {
    $('#course').change(function() {
        var course = $('#course').val();
        var batch = $('#batch').val();
        $("#mission").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_mission_by_course/?batch=' + batch +
                    '&course=' +
                    course + '&type=FLIGHT',
                success: function(html) {
                    $("#mission").html(html);
                    // alert(html);
                }
            });
        } else {
            // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
        }

    });

});

// $(document).ready(function(){
//     $('#course').change(function() {
//           var course = $('#course').val();
//           $("#mission").html('<option>LOADING...</option>');
//           if(batch){
//               $.ajax({
//                   url:'<?= base_url() ?>ajax/get_mission_by_course/?course='+course+'&type=FLIGHT',
//                   success:function(html){
//                     $("#mission").html(html);
//                   }
//               }); 
//           }else{
//               // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
//           }

//       });

// });


$(document).ready(function() {
    $('#mission').change(function() {
        var mission = $('#mission').val();
        $("#description").val('LOADING...');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_mission_detail/?mission=' + mission,
                success: function(html) {
                    $("#description").val(html);
                }
            });
        } else {
            // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
        }

    });

});
</script>