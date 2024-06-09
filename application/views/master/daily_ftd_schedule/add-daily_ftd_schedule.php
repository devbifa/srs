<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            DAILY FTD SCHEDULE

            <small>CREATE</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


            <li class="#">DAILY FTD SCHEDULE</li>

            <li class="active">CREATE</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/daily_ftd_schedule/store') ?>" id="upload-create"
            enctype="multipart/form-data">


            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    DAILY FTD SCHEDULE > CREATE
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

                                            <label for="form-date">DATE</label>

                                            <input autocomplete="off" type="text" class="form-control tgl"
                                                id="form-date" placeholder="Masukan Date" name="dt[date]"
                                                value="<?= DATE('Y-m-d') ?>">

                                        </div>

                                        <div class="form-group col-md-3">

<label for="form-classroom">BASE</label>

<select style='width:100%' name="dt[origin_base]"
    class="form-control select2" id="base">
    <option value="">SELECT BASE</option>
    <?php
$base_airport_document = $this->mymodel->selectWithQuery("SELECT * FROM base_airport_document");


foreach ($base_airport_document as $base_airport_document_record) {

$text = "";

if ($base_airport_document_record['base'] == $daily_ftd_schedule['origin_base']) {

$text = "selected";
}



echo "<option value='" . $base_airport_document_record['base'] . "' " . $text . " >" . $base_airport_document_record['base'] . "</option>";
}

?>

</select>

</div>


                                        <div class="form-group col-md-3">

                                            <label for="form-ftd_model">FTD MODEL</label>

                                            <select style='width:100%' name="dt[ftd_model]"
                                                class="form-control select2 ">
                                                <option value="">SELECT FTD MODEL</option>
                                                <?php

                        $base_airport_document = $this->mymodel->selectWithQuery("SELECT * FROM synthetic_training_devices_document");

                        foreach ($base_airport_document as $val) {

                          $text = "";

                          if ($val['code'] == $daily_ftd_schedule['ftd_model']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['model'] . " - " . $val['serial_number'] . " (" . $val['type_enginee'] . ")</option>";
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

                          if ($val['code'] == $daily_ftd_schedule['batch']) {

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
                      $tpm = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $daily_ftd_schedule['tpm']));
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

                        $instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FTD%'"));

                        foreach ($instructor as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_ftd_schedule['pic']) {

                            $text = "selected";
                          }

                          if (strpos($val['type'], 'FTD') !== false) {
                            echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                          }
                        }


                        ?>

                                                <option value="">SELECT STUDENT</option>
                                                <?php
                        $this->db->order_by("nick_name ASC");
                        $student_document = $this->mymodel->selectWhere('user', array('batch' => $daily_ftd_schedule['batch'], 'status' => 'ACTIVE'));

                        foreach ($student_document as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_ftd_schedule['pic']) {

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

                        $instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%FTD%' OR type LIKE '%FTD%'"));

                        foreach ($instructor as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_ftd_schedule['2nd']) {

                            $text = "selected";
                          }

                          if (strpos($val['type'], 'FTD') !== false) {
                            echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                          }
                        }


                        ?>

                                                <option value="">SELECT STUDENT</option>
                                                <?php
                        $this->db->order_by("nick_name ASC");
                        $student_document = $this->mymodel->selectWhere('user', array('batch' => $daily_ftd_schedule['batch'], 'status' => 'ACTIVE'));

                        foreach ($student_document as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_ftd_schedule['2nd']) {

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
                        $batch = $daily_ftd_schedule['batch'];
                        $type = 'FTD';
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

                          if ($val['code'] == $daily_ftd_schedule['course']) {

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
                        $batch = $daily_ftd_schedule['batch'];
                        $batch = $this->mymodel->selectDataOne('batch', array('code' => $batch));
                        $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));
                        $arr_mission = json_decode($curriculum['mission'], true);

                        $v_type = 'FTD';
                        $code_course = $daily_ftd_schedule['course'];
                        $data = $this->mymodel->selectWhere('syllabus_mission', "type_of_training = '$v_type' AND course = '$code_course' 
                        ORDER BY position ASC");

                        foreach ($data as $val) {

                          $text = "";

                          if ($val['code'] == $daily_ftd_schedule['mission']) {

                            $text = "selected";
                          }

                          if ($arr_mission[$v_type][$code_course][$val['code']]['status'] == 'ON') {
                            echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['code'] . ' - ' . $val['name'] . "</option>";
                          }
                        }

                        ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-etd_utc">ETD UTC</label>

                                            <input type="text" class="form-control" id="etd2"
                                                placeholder="Masukan Etd Utc" name="dt[etd_utc]"
                                                value="<?= $daily_ftd_schedule['etd_utc'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eet_utc">EET</label>

                                            <input type="text" class="form-control" id="eet2"
                                                placeholder="Masukan Eet Utc" name="dt[eet_utc]"
                                                value="<?= $daily_ftd_schedule['eet_utc'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eta">ETA UTC</label>

                                            <input type="text" class="form-control" id="eta2" placeholder="Masukan Eta"
                                                name="dt[eta]" value="<?= $daily_ftd_schedule['eta'] ?>">

                                        </div>

                                        <div class="form-group col-md-12">

                                            <label for="form-remark">REMARK</label>

                                            <input type="text" class="form-control" id="form-remark"
                                                placeholder="Masukan Remark" name="dt[remark]"
                                                value="<?= $daily_ftd_schedule['remark'] ?>">

                                        </div>
                                        <!-- <div class="form-group col-md-12">

      <label for="form-file">FILE </label>  
      
      <?php

      if ($file['dir'] != "") { ?>
    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


<?php } ?>
     

      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

  </div> -->
                                        <div class="col-md-12">

                                            <button type="submit" class="btn btn-primary btn-send pull-right"><i
                                                    class="fa fa-save"></i> SAVE</button>
        </form>


</div>
<div class="form-group col-md-12">
    <hr>
    <!-- FILTER  -->
    <div class="row">
        <div class="">
            <form autocomplete="off" action="<?= base_url() ?>master/daily_ftd_schedule/filter_create" method="post">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>ORIGIN BASE</label>
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
                        <label>DATE</label>
                        <input placeholder="Date" type="text" class="form-control tgl"
                            value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
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
                        <a href="<?= base_url('fitur/export/daily_ftd_schedule') ?>" target="_blank">

                            <button type="button" class="btn btn-block btn-warning"><i
                                    class="mdi mdi-arrow-up-bold-circle-outline"></i> EXPORT DATA</button>

                        </a>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>&nbsp</label><br>
                        <button type="button" class="btn  btn-block  btn-info" onclick="$('#modal-impor').modal()"><i
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

                <form action="<?= base_url('fitur/import/daily_ftd_schedule') ?>" method="POST"
                    enctype="multipart/form-data">



                    <div class="modal-body">

                        <div class="form-group">

                            <label for="">File Excel</label>

                            <input required type="file" class="form-control" id="" name="file"
                                placeholder="Input field">

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                            Close</button>

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

        <table class="table table-bordered" id="mytable" style="width:100%">

            <thead>

                <tr class="bg-success">

                    <th style="width:20px" rowspan="2">NUM</th>
                    <th style="min-width:100px" rowspan="2">ACTION</th>
                    <th style="min-width:110px">DATE</th>
                    <th>SITE</th>
                    <th style="width:120px;">FTD MODEL</th>
                    <th>INSTRUCTOR</th>
                    <th>STUDENT</th>
                    <th>BATCH</th>
                    <th>TPM</th>
                    <th>COURSE</th>
                    <th>MISSION</th>
                    <th>ETD <br>UTC</th>
                    <th>ETA<br>UTC</th>
                    <th>EET</th>
                    <th>REMARK</th>
                    <th>PROPOSE</th>

                </tr>

            </thead>

            <tbody>
                <?php

        if ($_SESSION['origin_base']) {
          $approval = $this->mymodel->selectDataOne('approval', array('date' => $_SESSION['start_date'], 'base' => $_SESSION['origin_base'], 'type' => 'FTD'));
          if ($approval) {
            $sent = '<span class="text-blue">Sent</span>';
          } else {
            $sent = '<span class="text-red">Not Sent</span>';
          }
        }

        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $nomor = 0;
        $data_date =  $this->template->date_range($start_date, $end_date);


        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];
        $origin_base = $_SESSION['origin_base'];

        if (empty($start_date)) {
          $_SESSION['start_date'] = DATE('Y-m-d');
          $_SESSION['end_date'] = DATE('Y-m-d');
          $start_date = $_SESSION['start_date'];
          $end_date = $_SESSION['end_date'];
        }

        if (empty($end_date)) {
          $_SESSION['start_date'] = DATE('Y-m-d');
          $_SESSION['end_date'] = DATE('Y-m-d');
          $start_date = $_SESSION['start_date'];
          $end_date = $_SESSION['end_date'];
        }

        if ($origin_base) {
          $origin_base = "  AND a.origin_base = '$origin_base' ";
        } else {
          $origin_base = " ";
        }


        $origin_base = " ";


        $batch = $_SESSION['batch'];
        if ($batch) {
          $batch = " AND a.batch = '$batch' ";
        } else {
          $batch = "";
        }

        
    
        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];
        $origin_base = $_SESSION['origin_base'];

        if (empty($start_date)) {
          $_SESSION['start_date'] = DATE('Y-m-d');
          $_SESSION['end_date'] = DATE('Y-m-d');
          $start_date = $_SESSION['start_date'];
          $end_date = $_SESSION['end_date'];
        }

        if (empty($end_date)) {
          $_SESSION['start_date'] = DATE('Y-m-d');
          $_SESSION['end_date'] = DATE('Y-m-d');
          $start_date = $_SESSION['start_date'];
          $end_date = $_SESSION['end_date'];
        }

        if ($origin_base) {
          $origin_base = "  AND a.origin_base = '$origin_base' ";
        } else {
          $origin_base = " ";
        }


        $origin_base = " ";


        $batch = $_SESSION['batch'];
        if ($batch) {
          $batch = " AND a.batch = '$batch' ";
        } else {
          $batch = "";
        }

        $base = $_SESSION['origin_base'];


        if ($base) {
          $base = " AND a.origin_base  = '$base' ";
        } else {
          $base = " ";
        }

        
        ?>

                <?php
        $duty_instructor = '';
        $total = array();
        $array_model = array();
        foreach ($data_date as $v => $k) {
          $start_date = $k;
          $end_date = $k;
        ?>
                <?php
          $data_utc = $this->mymodel->selectWithQuery("SELECT *
			FROM daily_ftd_schedule a
		
			WHERE  a.visibility = '0'
			AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$start_date'  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
				"
            . $batch
. $base
            . $origin_base .
            "
			ORDER BY a.date ASC, a.etd_utc ASC
      ");

          // print_r($data_date);

          foreach ($data_utc as $key => $val) {

            if ($approval and $approval['prepared_time'] >= $val['created_at']) {
              $sent = '<span class="text-blue">Sent</span>';
            } else {
              $sent = '<span class="text-red">Not Sent</span>';
            }

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
                    <td><?= $nomor ?>
                    </td>
                    <td><a href="<?= base_url() ?>master/daily_ftd_schedule/edit/<?= $val['id'] ?>"
                            class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
                        <a href="#!" data-toggle="modal" data-target="#modal-delete-<?= $val['id'] ?>"
                            class="btn btn-danger btn-rounded btn-xs"><i class="mdi mdi-delete"></i></a>



                        <div class="modal modal-danger fade" id="modal-delete-<?= $val['id'] ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                            href="<?= base_url() ?>master/daily_ftd_schedule/delete_data/<?= $val['id'] ?>">Delete
                                            Now</a>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>



                    </td>
                    <td><?= DATE('d M Y', strtotime($val['date'])) ?></td>
                    <td class="text-left"><?= $val['origin_base'] ?></td>
 <td class="text-left"><?= $val['ftd_model'] ?></td>
                    <td class="text-left"><?= $val['pic'] ?></td>
                    <td class="text-left"><?= $val['2nd'] ?></td>
                    <td><?= $val['batch'] ?></td>
                    <td><?= $val['tpm'] ?></td>
                    <td class="text-left"><?= $val['course'] ?></td>
                    <?php
              $file = $this->mymodel->selectDataone('file', array('table_id' => $val['id_mission'], 'table' => 'tpm_syllabus_all_course'));
              if ($file['name']) {
                $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="' . base_url() . 'webfile/' . $file['name'] . '">' . $val['mission'] . '</a>';
              }
              ?>
                    <td class="text-left"><?= $val['mission'] ?></td>
                    </td>
                    <td><?= $val['etd_utc'] ?></td>
                    <td><?= $val['eta'] ?></td>
                    <td><?= $val['eet_utc'] ?>
                    <td class="text-left"><?= $val['remark'] ?></td>
                    <td class=""><?= $sent ?><br><?= $approval['prepared_time'] ?></td>
                </tr>
                <?php } ?>


                <?php
          $data_utc = $this->mymodel->selectWithQuery("SELECT *
			FROM daily_ftd_schedule a
			WHERE  a.visibility = '0'
			AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$start_date'  AND etd_utc >= '00:00' AND etd_utc <= '21:59'
				"
            . $batch
. $base
            . $origin_base .
            "
			ORDER BY a.date ASC, a.etd_utc ASC
      ");

          // print_r($data_date);
          // $duty_instructor = '';
          // $total = array();
          // $array_model = array();
          foreach ($data_utc as $key => $val) {

            if ($approval and $approval['prepared_time'] >= $val['created_at']) {
              $sent = '<span class="text-blue">Sent</span>';
            } else {
              $sent = '<span class="text-red">Not Sent</span>';
            }
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

            if (!in_array($val['ftd_model'], $array_model)) {
              array_push($array_model, $val['ftd_model']);
            }
            if ($val['duty_instructor']) {
              $duty_instructor = $val['duty_instructor'];
            }
            if (strpos($val['eet_utc'], ':') !== false) {
              array_push($total, $val['eet_utc']);
            }

            $val['pic'] = $val['pic'];



          ?>
                <tr>
                    <td><?= $nomor ?>
                    </td>
                    <td><a href="<?= base_url() ?>master/daily_ftd_schedule/edit/<?= $val['id'] ?>"
                            class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
                        <ahref="#!" data-toggle="modal" data-target="#modal-delete-<?= $val['id'] ?>"
                            class="btn btn-danger btn-rounded btn-xs"><i class="mdi mdi-delete"></i></a>



                            <div class="modal modal-danger fade" id="modal-delete-<?= $val['id'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                                                href="<?= base_url() ?>master/daily_ftd_schedule/delete_data/<?= $val['id'] ?>">Delete
                                                Now</a>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>



                    </td>

                    <td><?= DATE('d M Y', strtotime($val['date'])) ?></td>
                    <td class="text-left"><?= $val['origin_base'] ?></td>
 <td class="text-left"><?= $val['ftd_model'] ?></td>
                    <td class="text-left"><?= $val['pic'] ?></td>
                    <td class="text-left"><?= $val['2nd'] ?></td>
                    <td><?= $val['batch'] ?></td>
                    <td><?= $val['tpm'] ?></td>
                    <td class="text-left"><?= $val['course'] ?></td>
                    <?php
              $file = $this->mymodel->selectDataone('file', array('table_id' => $val['id_mission'], 'table' => 'tpm_syllabus_all_course'));
              if ($file['name']) {
                $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="' . base_url() . 'webfile/' . $file['name'] . '">' . $val['mission'] . '</a>';
              }
              ?>
                    <td class="text-left"><?= $val['mission'] ?></td>
                    </td>
                    <td><?= $val['etd_utc'] ?></td>
                    <td><?= $val['eta'] ?></td>
                    <td><?= $val['eet_utc'] ?>
                    <td class="text-left"><?= $val['remark'] ?></td>
                    <td class=""><?= $sent ?><br><?= $approval['prepared_time'] ?></td>
                </tr>
                <?php } ?>

                <?php } ?>
                <?php


        $total =  $this->template->sum_time($total);
        $total_plan = $nomor;
        $total_ftd = count($array_model);
        $total_flight = $total;

        ?>
                <!-- <tr>
    <th colspan="10" class="text-right">TOTAL PLAN</th>
    <th><?= $total ?></th>
    <th colspan="1"></th>
  </tr> -->
            </tbody>

        </table>



    </div>

    <br><br>
    <div class="table-responsive">
        <table>
            <tr>
                <th class="text-left no-border" style="min-width:250px">

                    <p>TOTAL FTD SCHEDULE</p>

                    <p>TOTAL FTD IN USE </p>

                    <p>TOTAL PLAN</p>

                </th>
                <th class="no-border" style="min-width:15px;">

                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </th>
                <th class="text-left no-border" style="min-width:250px">

                    <p><?= $total_flight ?></p>
                    <p><?= $total_ftd ?></p>
                    <p><?= $total_plan ?></p>
                </th>
            </tr>
        </table>


    </div>

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
                    <a type="button" class="btn btn-outline" href="<?= base_url() ?>master/daily_ftd_schedule/reset"
                        id="submit-now">Reset Now</a>
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
                    <a type="button" class="btn btn-outline" href="<?= base_url() ?>master/daily_ftd_schedule/submit"
                        id="submit-now">Propose Now</a>
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
                        <span style="font-weight:100">Data is empty. Please insert daily ftd schedule!</span>
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
<div class="box-footer">
    <div class="col-md-12">
        <div class="row">


        </div>


    </div>

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
                        "<?= base_url('master/daily_ftd_schedule/create') ?>";

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
                url: '<?= base_url() ?>ajax/get_pic_by_batch/?batch=' + batch + '&type=FTD',
                success: function(html) {
                    $("#pic").html(html);
                }
            });
        } else {

        }

        $("#2nd").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_2nd_by_batch/?batch=' + batch + '&type=FTD',
                success: function(html) {
                    $("#2nd").html(html);
                }
            });
        } else {

        }

        $("#course").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_course_by_batch/?batch=' + batch + '&type=FTD',
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
                    '&course=' + course + '&type=FTD',
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