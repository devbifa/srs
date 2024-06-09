<style>
.hidden {
    display: none;
}
</style>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            DAILY GROUND SCHEDULE

            <small>CREATE</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


            <li class="#">DAILY GROUND SCHEDULE</li>

            <li class="active">CREATE</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/daily_ground_schedule/store') ?>" id="upload-create"
            enctype="multipart/form-data">



            <div class="row">

                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    CREATE DAILY GROUND SCHEDULE
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

                                            <label for="form-classroom">TYPE</label>

                                            <select style='width:100%' name="dt[type]" class="form-control select2">
                                                <option value="">SELECT TYPE</option>
                                                <?php

                        $arr = array();
                        $arr[] = "SE";
                        $arr[] = "ME";
                        foreach ($arr as $val) {

                          $text = "";

                          if ($val == $daily_ground_schedule['type']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val . "' " . $text . " >" . $val . "</option>";
                        }

                        ?>

                                            </select>

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

                          if ($base_airport_document_record['base'] == $daily_ground_schedule['origin_base']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $base_airport_document_record['base'] . "' " . $text . " >" . $base_airport_document_record['base'] . "</option>";
                        }

                        ?>

                                            </select>

                                        </div>


                                        <div class="form-group col-md-3">

                                            <label for="form-classroom">CLASSROOM</label>

                                            <select style='width:100%' name="dt[classroom]" class="form-control select2"
                                                id="classroom">

                                                <?php

                        $base_airport_document = $this->mymodel->selectWhere('classroom', array('station' => $daily_ground_schedule['origin_base'], 'status' => 'ENABLE'));


                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text = "";

                          if ($base_airport_document_record['code'] == $daily_ground_schedule['classroom']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $base_airport_document_record['code'] . "' " . $text . " >" . $base_airport_document_record['classroom'] . "</option>";
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

                                            <label for="form-course">COURSE</label>
                                            <select style='width:100%' name="dt[course]" class="form-control select2"
                                                id="course">
                                                <option value="">SELECT COURSE</option>
                                                <?php
                        $batch = $daily_ground_schedule['batch'];
                        $type = 'GROUND';
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

                          if ($val['code'] == $daily_ground_schedule['course']) {

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

                                            <label for="form-mission">SUBJECT</label>

                                            <select style='width:100%' name="dt[subject]" class="form-control select2"
                                                id="mission">
                                                <option value="">SELECT SUBJECT</option>
                                                <?php
                        $batch = $daily_ground_schedule['batch'];
                        $batch = $this->mymodel->selectDataOne('batch', array('code' => $batch));
                        $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $batch['curriculum']));
                        $arr_mission = json_decode($curriculum['mission'], true);

                        $v_type = 'GROUND';
                        $code_course = $daily_ground_schedule['course'];
                        $data = $this->mymodel->selectWhere('syllabus_mission', "type_of_training = '$v_type' AND course = '$code_course' 
  ORDER BY position ASC");

                        foreach ($data as $val) {

                          $text = "";

                          if ($val['code'] == $daily_ground_schedule['subject']) {

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

                                            <label for="form-pic">INSTRUCTOR</label>
                                            <select style='width:100%' name="dt[instructor]"
                                                class="form-control select2" id="instructor">


                                                <option value="">SELECT PIC/INSTRUCTOR</option>
                                                <?php

                        $instructor = $this->mymodel->selectWhere('user', array("type LIKE '%GROUND%' OR type LIKE '%GROUND%' OR type LIKE '%GROUND%'"));

                        foreach ($instructor as $val) {

                          $text = "";

                          if ($val['id_number'] == $daily_ground_schedule['instructor']) {

                            $text = "selected";
                          }

                          if (strpos($val['type'], 'GROUND') !== false) {
                            echo "<option value='" . $val['id_number'] . "' " . $text . " >" . $val['nick_name'] . "</option>";
                          }
                        }


                        ?>



                                            </select>

                                        </div>
                                        <div class="form-group col-md-6">

                                            <label for="form-remark">REMARK</label>

                                            <input type="text" class="form-control" id="form-remark"
                                                placeholder="Masukan Remark" name="dt[remark]"
                                                value="<?= $daily_ground_schedule['remark'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-start_lt">START UTC</label>

                                            <input type="text" class="form-control" id="etd2"
                                                placeholder="Masukan Start UTC" name="dt[start_lt]"
                                                value="<?= $daily_ground_schedule['start_lt'] ?>">

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-duration">DURATION</label>

                                            <input type="text" class="form-control" id="eet2"
                                                placeholder="Masukan Duration" name="dt[duration]"
                                                value="<?= $daily_ground_schedule['duration'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-stop_lt">STOP UTC</label>

                                            <input type="text" class="form-control" id="eta2"
                                                placeholder="Masukan Stop UTC" name="dt[stop_lt]"
                                                value="<?= $daily_ground_schedule['stop_lt'] ?>">

                                        </div>


                                        <div class="form-group col-md-12">

                                            <label for="form-remark">PARTICIPANT LIST</label>
                                            <div id="student_list">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="student"
                                                        style="width:100%;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:50px;">Num
                                                                </th>
                                                                <th>Batch
                                                                </th>
                                                                <th>ID Number
                                                                </th>
                                                                <th>Full Name
                                                                </th>
                                                                <th>Nick Name
                                                                </th>
                                                                <th style="width:50px;">Participant
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                              $i = 0;
                              $batch = $daily_ground_schedule['batch'];
                              // $student = $this->mymodel->selectWithQuery("SELECT a.* FROM user a
                              // WHERE a.batch='$batch' AND a.status='ACTIVE'");

                              // print_r($student);
                              $student_list = json_decode($daily_ground_schedule['student'], true);
                              $student_list_other = json_decode($daily_ground_schedule['student_other'], true);

                              $table_body = '';
                              foreach ($student as $key => $val) {
                                $text = '';
                                if ($student_list[$val['id_number']]['val'] == $val['id_number']) {
                                  $text = 'checked';
                                }
                                $table_body .= '<tr id="' . $i . '">
                      <td>' . ($i + 1) . '
                     </td>
                      <td>
                     
                      ' . $val['batch'] . '
                     </td>
                      <td>' . $val['id_number'] . '
                     </td>
                      <td class="text-left">' . $val['full_name'] . '
                     </td>
                      <td class="text-left">' . $val['nick_name'] . '
                     </td>
                     <td>
                       <input type="checkbox" ' . $text . ' name="dtt[' . $val['id_number'] . '][val]" value="' . $val['id_number'] . '">
                     </td>

                   </tr>';

                                $i++;
                              }

                              echo $table_body;


                              // $batch_data = $this->mymodel->selectWithQuery("SELECT a.*, b.curriculum FROM batch a LEFT JOIN curriculum b ON a.curriculum = b.id ORDER BY a.batch ASC");


                              $batch_datas = $this->mymodel->selectWithQuery("SELECT a.*, b.name as curriculum FROM batch a LEFT JOIN syllabus_curriculum b ON a.curriculum = b.code ORDER BY a.batch ASC");



                              $table_body = '';
                              foreach ($student_list_other as $key => $val) {
                                if ($val['check'] == 'on') {
                                  $text = '';
                                  if ($student_list[$val['id']]['val'] == $val['id']) {
                                    $text = 'checked';
                                  }


                                  $text2 = '<option value="">SELECT BATCH</option>';
                                  foreach ($batch_datas as $key2 => $val2) {
                                    $text = "";
                                    if ($val['batch'] == $val2['batch']) {
                                      $text = "selected";
                                    }
                                    $text2 .= "<option " . $text . " value='" . $val2['id'] . "' " . $text . " >" . $val2['batch'] . ' (' . $val2['curriculum'] . ")</option>";
                                  }

                                  $student_text = '<option value="">SELECT STUDENT</option>';
                                  $batch = $val['batch'];
                                  $student_list = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE batch='$batch' AND status='ACTIVE'");
                                  foreach ($student_list as $key2 => $val2) {
                                    $text = "";
                                    if ($val['id_number'] == $val2['id_number']) {
                                      $text = "selected";
                                    }
                                    $student_text .= "<option " . $text . " value='" . $val2['id'] . "' " . $text . " >" . $val2['full_name'] . "</option>";
                                  }

                                  $student_detail = $this->mymodel->selectDataOne('user', array('id' => $val['id_number']));

                                  $table_body .= '<tr id="' . $i . '">
                                    <td>' . ($i + 1) . '
                                  </td>
                                    <td>
                                      <select required style="width:100%" name="dttt[' . $i . '][batch]" class="select2 batch" id="batch' . $i . '">
                                        ' . $text2 . '
                                      </select>
                                  </td>
                                    <td colspan="3">
                                    <select required style="width:100%" name="dttt[' . $i . '][id_number]" class="select2 id_number" id="id_number' . $i . '">
                                        ' . $student_text . '
                                      </select>
                                  </td>
                                  <td>
                                    <input type="checkbox" ' . $text . '  name="dttt[' . $i . '][check]" value="on" checked>
                                  </td>
              
                                </tr>';

                                  $i++;
                                }
                              }
                              echo $table_body;

                              ?>

                                                            <?php
                              // $batch = $this->mymodel->selectDataOne('batch', array('id'=>$daily_ground_schedule['batch']));
                              // $curriculum = $this->mymodel->selectDataOne('curriculum', array('id'=>$batch['curriculum']));
                              // $curriculum = $curriculum['id'];
                              // $batch_data = $this->mymodel->selectWithQuery("SELECT a.*, b.curriculum FROM batch a LEFT JOIN curriculum b ON a.curriculum = b.id ORDER BY a.batch ASC");

                              ?>
                                                        <tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <table>
                                                <tr>
                                                    <td style="width:50px;">
                                                        <button type="button" name="addstudent" id="addstudent"
                                                            class="btn btn-primary btn-xs btn-rounded"
                                                            style="margin-left:3px;"><i
                                                                class="mdi mdi-plus"></i></button>
                                                    </td>
                                                </tr>
                                            </table>
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
            <form autocomplete="off" action="<?= base_url() ?>master/daily_ground_schedule/filter_create" method="post">
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
                        <a href="<?= base_url('fitur/export/daily_ground_schedule') ?>" target="_blank">

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

                <form action="<?= base_url('fitur/import/daily_ground_schedule') ?>" method="POST"
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
                    <th style="min-width:100px;" rowspan="2">ACTION</th>
                    <th rowspan="2" style="min-width:110px;">DATE</th>
                    <th rowspan="2">CLASS<br>ROOM</th>
                    <th rowspan="2">INSTRUCTOR</th>
                    <th rowspan="2">TYPE</th>
                    <th rowspan="2">BATCH</th>
                    <th rowspan="2">TPM</th>
                    <th rowspan="2">COURSE</th>
                    <th rowspan="2">SUBJECT</th>
                    <th colspan="3">TIME (UTC)</th>
                    <th rowspan="2">PARTICIPANT</th>
                    <th rowspan="2">REMARK</th>
                    <th rowspan="2">PROPOSE</th>
                </tr>

                <tr class="bg-success">
                    <th>START</th>
                    <th>STOP</th>
                    <th>DUR</th>
                </tr>
            </thead>

            <tbody>


                <?php

        if ($_SESSION['origin_base']) {
          $approval = $this->mymodel->selectDataOne('approval', array('date' => $_SESSION['start_date'], 'base' => $_SESSION['origin_base'], 'type' => 'GROUND'));
          if ($approval) {
            $sent = '<span class="text-blue">Sent</span>';
          } else {
            $sent = '<span class="text-red">Not Sent</span>';
          }
        }

        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];
        $origin_base = $_SESSION['origin_base'];
        $classroom = $_SESSION['classroom'];
        $batch = $_SESSION['batch'];

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
        if ($classroom) {
          $classroom = "  AND a.classroom = '$classroom' ";
        } else {
          $classroom = " ";
        }

        if ($batch) {
          $batch = "  AND a.batch = '$batch' ";
        } else {
          $batch = " ";
        }

        $text = "";
        $base = $_SESSION['origin_base'];


        if ($base) {
          $base = " AND a.origin_base  = '$base' ";
        } else {
          $base = " ";
        }





        $total = array();
        $array_class = array();
        $array_subject = array();

        $start_date = $_SESSION['start_date'];
        $end_date = $_SESSION['end_date'];

        $nomor = 0;
        $data_date =  $this->template->date_range($start_date, $end_date);

        foreach ($data_date as $v => $k) {
          $start_date = $k;
          $end_date = $k;
        ?>

                <?php

          $data = $this->mymodel->selectWithQuery("SELECT a.*
			FROM
			daily_ground_schedule a
      LEFT JOIN classroom b
      ON a.classroom = b.code
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$start_date' AND a.visibility = '0'  AND start_lt >= '22:00' AND start_lt <= '24:00'
			 "
            . $base
            . $batch .
            "
			ORDER BY a.date ASC,a.start_lt ASC");
          foreach ($data as $key => $val) {


            if ($approval and $approval['prepared_time'] >= $val['created_at']) {
              $sent = '<span class="text-blue">Sent</span>';
            } else {
              $sent = '<span class="text-red">Not Sent</span>';
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

            $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));

            $temp = $val['2nd'];
            $val['2nd'] = $dat['nick_name'];

            if (empty($val['2nd'])) {
              $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            $dat = $this->mymodel->selectDataOne('classroom', array('code' => $val['classroom']));
            $temp = $val['classroom'];
            $val['classroom'] = $dat['classroom'];
            if (empty($val['classroom'])) {
              $val['classroom'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['instructor']));

            $temp = $val['instructor'];
            $val['instructor'] = $dat['nick_name'];

            if (empty($val['instructor'])) {
              $val['instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));

            $temp = $val['2nd'];
            $val['2nd'] = $dat['nick_name'];

            if (empty($val['2nd'])) {
              $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }
            $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['subject'], 'type_of_training' => 'GROUND'));

            $temp = $val['subject'];
            $val['subject'] = $dat['code_name'] . ' - ' . $dat['name'];

            if (($val['subject']) == ' - ') {
              $val['subject'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

            $temp = $val['course'];
            $val['course'] = $dat['code_name'];

            if (($val['course']) == ' - ') {
              $val['course'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            // print_r($val);


            $nomor++;

            if (!in_array($val['classroom'], $array_class)) {
              array_push($array_class, $val['classroom']);
            }
            if (!in_array($val['subject'], $array_subject)) {
              array_push($array_subject, $val['subject']);
            }

            if (strpos($val['duration'], ':') !== false) {
              array_push($total, $val['duration']);
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

          ?>
                <tr>
                    <td><?= $nomor ?>
                    </td>

                    <td><a href="<?= base_url() ?>master/daily_ground_schedule/edit/<?= $val['id'] ?>"
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
                                                href="<?= base_url() ?>master/daily_ground_schedule/delete_data/<?= $val['id'] ?>">Delete
                                                Now</a>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>



                    </td>

                    <td><?= DATE('d M Y', strtotime($val['date'])) ?></td>
                    </td>
                    <td><?= $val['classroom'] ?></td>
                    <td class="text-left"><?= $val['instructor'] ?></td>
                    <td><?= $val['type'] ?></td>
                    <td><?= $val['batch'] ?></td>
                    <td><?= $val['tpm'] ?></td>
                    <td class="text-left"><?= $val['course'] ?></td>
                    <td class="text-left"><?= $val['subject'] ?></td>
                    <td><?= $val['start_lt'] ?></td>
                    <td><?= $val['stop_lt'] ?></td>
                    <td><?= $val['duration'] ?></td>

                    <td><?= $participant ?></td>
                    <td class="text-left"><?= $val['remark'] ?></td>
                    <td class=""><?= $sent ?><br><?= $approval['prepared_time'] ?></td>
                    </td>
                </tr>
                <?php } ?>


                <?php

          $data = $this->mymodel->selectWithQuery("SELECT a.*
FROM
daily_ground_schedule a
LEFT JOIN classroom b
ON a.classroom = b.code
WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$start_date' AND a.visibility = '0' AND start_lt >= '00:00' AND start_lt <= '21:59'
 "
            . $base
            . $batch .
            "
ORDER BY a.date ASC,a.start_lt ASC");
          foreach ($data as $key => $val) {



            if ($approval and $approval['prepared_time'] >= $val['created_at']) {
              $sent = '<span class="text-blue">Sent</span>';
            } else {
              $sent = '<span class="text-red">Not Sent</span>';
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

            $dat = $this->mymodel->selectDataOne('classroom', array('code' => $val['classroom']));
            $temp = $val['classroom'];
            $val['classroom'] = $dat['classroom'];
            if (empty($val['classroom'])) {
              $val['classroom'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['instructor']));

            $temp = $val['instructor'];
            $val['instructor'] = $dat['nick_name'];

            if (empty($val['instructor'])) {
              $val['instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));

            $temp = $val['2nd'];
            $val['2nd'] = $dat['nick_name'];

            if (empty($val['2nd'])) {
              $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }
            $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['subject'], 'type_of_training' => 'GROUND'));

            $temp = $val['subject'];
            $val['subject'] = $dat['code_name'] . ' - ' . $dat['name'];

            if (($val['subject']) == ' - ') {
              $val['subject'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }

            $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

            $temp = $val['course'];
            $val['course'] = $dat['code_name'];

            if (($val['course']) == ' - ') {
              $val['course'] = '<a class="text-red"><b>' . $temp . '</b></a>';
            }


            $nomor++;
            if (!in_array($val['classroom'], $array_class)) {
              array_push($array_class, $val['classroom']);
            }
            if (!in_array($val['subject'], $array_subject)) {
              array_push($array_subject, $val['subject']);
            }

            if (strpos($val['duration'], ':') !== false) {
              array_push($total, $val['duration']);
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


          ?>
                <tr>
                    <td><?= $nomor ?>
                    </td>

                    <td><a href="<?= base_url() ?>master/daily_ground_schedule/edit/<?= $val['id'] ?>"
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
                                                href="<?= base_url() ?>master/daily_ground_schedule/delete_data/<?= $val['id'] ?>">Delete
                                                Now</a>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>



                    </td>

                    <td><?= DATE('d M Y', strtotime($val['date'])) ?></td>
                    </td>
                    <td><?= $val['classroom'] ?></td>
                    <td class="text-left"><?= $val['instructor'] ?></td>
                    <td><?= $val['type'] ?></td>
                    <td><?= $val['batch'] ?></td>
                    <td><?= $val['tpm'] ?></td>
                    <td class="text-left"><?= $val['course'] ?></td>
                    <td class="text-left"><?= $val['subject'] ?></td>
                    <td><?= $val['start_lt'] ?></td>
                    <td><?= $val['stop_lt'] ?></td>
                    <td><?= $val['duration'] ?></td>

                    <td><?= $participant ?></td>
                    <td class="text-left"><?= $val['remark'] ?></td>
                    <td class=""><?= $sent ?><br><?= $approval['prepared_time'] ?></td>
                    </td>
                </tr>
                <?php } ?>

                <?php
        }
        $total_subject = count($data);
        $total_classroom = count($array_class);

        $total_plan = $this->template->sum_time($total);

        $total = $nomor;
        $total_subject = count($array_subject);

        ?>

            </tbody>

        </table>

    </div>


    <br><br>
    <div class="table-responsive">
        <table>
            <tr>
                <th class="text-left no-border" style="min-width:250px">

                    <p>TOTAL GROUND SCHEDULE</p>

                    <p>TOTAL SUBJECT</p>

                    <p>TOTAL CLASS ROOM IN USE </p>

                    <p>TOTAL PLAN</p>

                </th>
                <th class="no-border" style="min-width:15px;">

                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                    <p>:</p>
                </th>
                <th class="text-left no-border" style="min-width:250px">

                    <p><?= $total ?></p>
                    <p><?= $total_subject ?></p>
                    <p><?= $total_classroom ?></p>
                    <p><?= $total_plan ?></p>
                </th>
            </tr>
        </table>

    </div>


    <a href="#!" data-toggle="modal" data-target="#modal-submit" id="button-submit"
        class="btn btn-primary pull-right">PROPOSE FOR APPROVAL</a>
    <?php if (empty($_SESSION['origin_base'])) { ?>
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
    <?php } else if ($nomor) { ?>
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
                    <a type="button" class="btn btn-outline" href="<?= base_url() ?>master/daily_ground_schedule/submit"
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
                        <span style="font-weight:100">Data is empty. Please insert daily ground schedule!</span>
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
    <div class="col-md-12">
        <div class="row">
            <!-- <button type="submit" class="btn btn-primary btn-send float-1" ><i class="fa fa-save"></i> SAVE</button> -->

        </div>


    </div>

</div>

<!-- /.box-body -->

</div>

<!-- /.box -->



<!-- /.box -->

</div>

<!-- /.col -->

</div>
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

                    //  window.location.href = "<?= base_url('master/daily_ground_schedule/create') ?>";
                    window.location.href = "";
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




<script type="text/javascript">
$(document).ready(function() {
    // loadTableDnD();


    var text = '';
    <?php

    $text2 = "<option value='' selected>SELECT BATCH</option>";
    foreach ($batch_datas as $val) {


      $text2 .= "<option value='" . $val['batch'] . "' " . $text . " >" . $val['batch'] . ' (' . $val['curriculum'] . ")</option>";
    }

    ?>

    var text = "<?= $text2 ?>";

    var i = <?= intval(1000) ?>;
    $('#addstudent').click(function() {
        i++;
        $('#student').append('<tr id="row' + i + '">' +

            '<td align="center"><button type="button" name="remove" id="' + i +
            '" class="btn btn-xs btn-rounded btn-danger btn_remove"><i class="mdi mdi-delete"></i></button></td>' +
            '<td style="min-width:100px;"><select required class="select2 batch" style="width:100%;" name="dttt[' +
            i + '][batch]" id="batch' + i + '" >' + text + '</select></td>' +
            '<td colspan="3"><select required class="select2 id_number" style="width:100%;" name="dttt[' +
            i + '][val]" id="id_number' + i +
            '" ><option value="">SELECT STUDENT</option</select></td>' +
            '<td><input type="checkbox" name="dttt[' + i + '][check]" checked value="on" ></td>' +
            '</tr>');
        $('.select2').select2();
        $('.money').mask("#,##0.00", {
            reverse: true
        });
        loadTableDnD();
        // $('.select2').select2();
        $('.tgl').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

    });
});

$(document).on('click', '.btn_remove', function() {
    var button_id = $(this).attr("id");
    $('#row' + button_id + '').remove();
});

function loadTableDnD() {
    $("#student").tableDnD();
}

$("#student").tableDnD();
</script>




<script>
$(document).ready(function() {
    $('#batch').change(function() {
        var batch = $('#batch').val();


        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_tpm/?batch=' + batch,
                success: function(html) {
                    $("#tpm").html(html);
                }
            });
        } else {

        }

        $("#2nd").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_2nd_by_batch/?batch=' + batch,
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
                    '&type=GROUND',
                success: function(html) {
                    $("#course").html(html);
                }
            });
        } else {

        }

        $("#student_list").html('LOADING...');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_student_list_by_batch/?batch=' + batch +
                    '&type=GROUND',
                success: function(html) {
                    $("#student_list").html(html);
                    loadTableDnD();
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
                    '&course=' + course + '&type=GROUND',
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
</script>

<script>
$(document).on('change', '.batch', function() {
    var str = $(this).attr("id");
    var id = str.substring(5);
    // console.log(id);
    get_detail(id);
});

function get_detail(id) {
    var id_batch = $("#batch" + id).val();
    $("#id_number" + id).html('<option>LOADING...</option>');
    if (id_batch) {
        $.ajax({
            url: '<?= base_url() ?>ajax/get_student_by_batch/?batch=' + id_batch,
            success: function(html) {
                $("#id_number" + id).html(html);
            }
        });
    } else {

    }
}
</script>


<script>
$(document).ready(function() {
    $('#base').change(function() {
        var base = $('#base').val();
        $("#classroom").html('<option>LOADING...</option>');
        if (base) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_classroom/?base=' + base,
                success: function(html) {
                    $("#classroom").html(html);

                }
            });
        } else {

        }

    });

});
</script>