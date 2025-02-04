<?php
$_SESSION['revise'] = '';
?>

<style>
.select2-container--default .select2-selection--single,
.select2-selection .select2-selection--single {
    border: 1px solid #d2d6de;
    border-radius: 0;
    padding: 6px 12px;
    padding-left: 13px;
    text-align: left;
    height: 34px;
}

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

            <small>EDIT</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


            <li class="#">DAILY GROUND SCHEDULE</li>

            <li class="active">EDIT</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/daily_attendance_report/update') ?>" id="upload-create"
            enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $daily_ground_schedule['id'] ?>">





            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    EDIT DAILY ATTENDANCE REPORT
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
                                                value="<?= $daily_ground_schedule['date'] ?>">

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

                          if ($val['code'] == $daily_ground_schedule['batch']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['batch'] . ' (' . $val['name'] . ")</option>
    ";
                        }

                        ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-3 d-none">

                                            <label for="form-description">TPM</label>
                                            <?php
                      $tpm = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $daily_ground_schedule['tpm']));
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

                            echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['code_name'] . "</option>";
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
                            echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['code_name'] . ' - ' . $val['name'] . "</option>";
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
                                        <div class="form-group col-md-3">

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
                                            <hr>
                                        </div>


                                        <div class="form-group col-md-3">

                                            <label for="form-start_lt">START ACT</label>

                                            <input type="text" class="form-control" id="etd2"
                                                placeholder="Masukan Start UTC" name="dt[start_act]"
                                                value="<?= $daily_ground_schedule['start_act'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-duration">DURATION ACT</label>

                                            <input type="text" class="form-control" id="eet2"
                                                placeholder="Masukan Duration" name="dt[duration_act]"
                                                value="<?= $daily_ground_schedule['duration_act'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-stop_lt">STOP ACT</label>

                                            <input type="text" class="form-control" id="eta2"
                                                placeholder="Masukan Stop UTC" name="dt[stop_act]"
                                                value="<?= $daily_ground_schedule['stop_act'] ?>">

                                        </div>


                                        <div class="form-group col-md-3">

                                            <label for="form-remark">REMARK REPORT</label>

                                            <input type="text" class="form-control" id="form-remark"
                                                placeholder="Masukan Remark Report" name="dt[remark_2]"
                                                value="<?= $daily_ground_schedule['remark_2'] ?>">

                                        </div>



                                        <div class="form-group col-md-3">

                                            <label for="form-remark">IRREG CODE</label>


                                            <select style='width:100%' name="dt[remark_report]"
                                                class="form-control select2">
                                                <option value="-">-</option>
                                                <?php

                        $this->db->order_by('code ASC');
                        $base_airport_document = $this->mymodel->selectWhere('delay_and_cancel_code', null);

                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text = "";

                          if ($base_airport_document_record['code'] == $daily_ground_schedule['remark_report']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $base_airport_document_record['code'] . "' " . $text . " >" . $base_airport_document_record['code'] . ' (' . $base_airport_document_record['remarks'] . ")</option>";
                        }

                        ?>

                                            </select>
                                        </div>


                                        <div class="form-group col-md-3">

                                            <label for="form-remark">SAFETY REPORT</label>


                                            <select style='width:100%' name="dt[remark_safety]"
                                                class="form-control select2">
                                                <option value="-">-</option>
                                                <?php
                        $this->db->order_by('code ASC');
                        $base_airport_document = $this->mymodel->selectWhere('safety_performance_code', null);

                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text = "";

                          if ($base_airport_document_record['code'] == $daily_ground_schedule['remark_safety']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $base_airport_document_record['code'] . "' " . $text . " >" . $base_airport_document_record['code'] . ' (' . $base_airport_document_record['remarks'] . ")</option>";
                        }

                        ?>

                                            </select>
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
                                                                <th style="width:50px;">Attend
                                                                </th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                              $i = 0;
                              $batch = $daily_ground_schedule['batch'];


                              // print_r($student);
                              $student_list = json_decode($daily_ground_schedule['student_attend'], true);
                              $student_list_other = json_decode($daily_ground_schedule['student_other_attend'], true);


                              $student = json_decode($daily_ground_schedule['student'], true);
                              $student_other = json_decode($daily_ground_schedule['student_other'], true);

                              if (count($student) == 0) {
                                $student = $this->mymodel->selectWithQuery("SELECT a.* FROM user a
  WHERE a.batch='$batch' AND a.status='ACTIVE'");
                              }

                              $table_body = '';

                              foreach ($student as $key => $val) {
                                $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['val']));
                                $val = $dat;
                                $text = '';
                                if ($student_list[$val['id_number']]['val'] == $val['id_number']) {
                                  $text = 'checked';
                                }

                                $batch_user = $val['batch'];
                                $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
                                $val['batch'] = $dat['batch'];


                                $this->db->select('name');
                                $dat = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $dat['curriculum']));
                                $val['tpm'] = $dat['name'];

                                $val['batch'] = $val['batch'] . ' (' . $val['tpm'] . ')';

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
 <input type="checkbox" ' . $text . ' name="dtt[' . $val['id'] . '][val]" value="' . $val['id_number'] . '">
</td>

</tr>';

                                $i++;
                              }

                              echo $table_body;


                              // $batch_data = $this->mymodel->selectWithQuery("SELECT a.*, b.curriculum FROM batch a LEFT JOIN curriculum b ON a.curriculum = b.id ORDER BY a.batch ASC");



                              $table_body = '';
                              foreach ($student_other as $key => $val) {

                                if ($val['check'] == 'on') {



                                  $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['val']));
                                  $val = $dat;

                                  $text = '';
                                  if ($student_list_other[$val['id_number']]['val'] == $val['id_number']) {
                                    $text = 'checked';
                                  }



                                  $student_detail = $this->mymodel->selectDataOne('user', array('id_number' => $val['id_number']));

                                  $batch_user = $val['batch'];
                                  $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
                                  $val['batch'] = $dat['batch'];

                                  $batch_pure = $dat;

                                  $this->db->select('name');
                                  $dat = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $dat['curriculum']));
                                  $val['tpm'] = $dat['name'];

                                  $val['batch'] = $val['batch'] . ' (' . $val['tpm'] . ')';


                                  $table_body .= '<tr id="' . $i . '">
              <td>' . ($i + 1) . '
            </td>
            <td>
            ' . $val['batch'] . '
          </td>
          <td>
          ' . $val['id_number'] . '
        </td>
        <td class="text-left">
        ' . $val['full_name'] . '
      </td>
      <td class="text-left">
      ' . $val['nick_name'] . '
    </td>
            
            
            <td>
            <input type="hidden"   name="dttt[' . $val['id'] . '][val]" value="' . $val['id_number'] . '">
            <input type="hidden"   name="dttt[' . $val['id'] . '][batch]" value="' . $batch_pure['code'] . '">

              <input type="checkbox" ' . $text . '  name="dttt[' . $val['id'] . '][check]" value="on">
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

                                        </div>


                                        <div class="form-group col-md-12">

                                            <label for="form-file">FILE </label>


                                            <?php

                      if ($file) { ?>
                                            <a href="<?= base_url() ?>webfile/document/<?= $file ?>" target="_blank"><i
                                                    class="fa fa-download"></i> <?= $file ?></a>


                                            <?php } ?>


                                            <input type="file" class="form-control" id="form-file"
                                                placeholder="Fill File" name="file">

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
                                        <button type="submit" class="btn btn-primary btn-send float-1"><i
                                                class="mdi mdi-content-save"></i></button>

                                        <!-- <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> RESET</button> -->

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

        </form>



    </section>

    <!-- /.content -->

</div>

<!-- /.content-wrapper -->

<script type="text/javascript">
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

                    <?php if ($_SESSION['revise']) { ?>
                    window.location.href = "<?= base_url('master/edit_training_report') ?>";
                    <?php } else { ?>
                    window.location.href =
                        "<?= base_url('master/daily_attendance_report') ?>";
                    <?php } ?>

                }, 1000);

                $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                    .attr('disabled', false);





            } else {

                form.find(".show_error").hide().html(response).slideDown("fast");

                $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                    .attr('disabled', false);



            }

        },

        error: function(xhr, textStatus, errorThrown) {

            console.log(xhr);

            $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                .attr('disabled', false);

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
            i + '][id_number]" id="id_number' + i +
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
                    $("#tpm").val(html);
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
            // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
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
                url: '<?= base_url() ?>ajax/get_student_list_by_batch/?batch=' + batch,
                success: function(html) {
                    $("#student_list").html(html);
                    loadTableDnD();
                }
            });
        } else {
            // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
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
        // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
    }
}
</script>