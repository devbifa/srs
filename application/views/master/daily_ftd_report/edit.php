<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            DAILY FTD SCHEDULE

            <small>EDIT</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


            <li class="#">DAILY FTD SCHEDULE</li>

            <li class="active">EDIT</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/daily_ftd_report/update') ?>" id="upload-create"
            enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $daily_ftd_schedule['id'] ?>">





            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    DAILY FTD REPORT > EDIT
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
                                                value="<?= $daily_ftd_schedule['date'] ?>">

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

                            echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['code_name'] . "</option>";
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
                            echo "<option value='" . $val['code'] . "' " . $text . " >" . $val['code_name'] . ' - ' . $val['name'] . "</option>";
                          }
                        }

                        ?>

                                            </select>

                                        </div>

                                        <!-- <div class="form-group col-md-3">

                      <label for="form-description">DESCRIPTION</label>

                      <input type="text" class="form-control" id="description" placeholder="Masukan Description" name="dt[description]" value="<?= $daily_ftd_schedule['description'] ?>">

                  </div> -->
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

                                        <div class="form-group col-md-3">

                                            <label for="form-remark">REMARK</label>

                                            <input type="text" class="form-control" id="form-remark"
                                                placeholder="Masukan Remark" name="dt[remark]"
                                                value="<?= $daily_ftd_schedule['remark'] ?>">

                                        </div>

                                        <!-- <div class="form-group col-md-3">

                                            <label for="form-etd_utc">ETD UTC</label>

                                            <input type="text" class="form-control" id="form-etd_utc"
                                                placeholder="Masukan Etd Utc" name="dt[etd_utc]"
                                                value="<?= $daily_ftd_schedule['etd_utc'] ?>">

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-eta">ETA UTC</label>

                                            <input type="text" class="form-control" id="form-eta"
                                                placeholder="Masukan Eta" name="dt[eta]"
                                                value="<?= $daily_ftd_schedule['eta'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eet_utc">EET</label>

                                            <input type="text" class="form-control" id="form-eet_utc"
                                                placeholder="Masukan Eet Utc" name="dt[eet_utc]"
                                                value="<?= $daily_ftd_schedule['eet_utc'] ?>">

                                        </div> -->
                                        <div class="form-group col-md-3">

                                            <label for="form-remark">REMARK REPORT</label>

                                            <input type="text" class="form-control" id="form-remark"
                                                placeholder="Masukan Remark Report" name="dt[remark_2]"
                                                value="<?= $daily_ftd_schedule['remark_2'] ?>">

                                        </div>

                                        <div class="col-md-12 form-group">
                                            <hr>
                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eet_utc">BLOCK TIME ATD</label>

                                            <input type="text" class="form-control" id="etd_b"
                                                placeholder="Masukan Block Time ATD" name="dt[block_time_atd]"
                                                value="<?= $daily_ftd_schedule['block_time_atd'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eet_utc">BLOCK TIME ATA</label>

                                            <input type="text" class="form-control" id="eta_b"
                                                placeholder="Masukan Block Time ATA" name="dt[block_time_ata]"
                                                value="<?= $daily_ftd_schedule['block_time_ata'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-eet_utc">BLOCK TIME TOTAL</label>
                                            <?php
                      $total1 = ($daily_ftd_schedule['block_time_atd']);
                      $total2 = ($daily_ftd_schedule['block_time_ata']);
                      if ($total1 > $total2) {
                        $awal = strtotime('2020-01-01 ' . $total1 . ':00');
                        $akhir = strtotime('2020-01-02 ' . $total2 . ':00');
                        $diff  = $akhir - $awal;
                        $jam   = str_pad(floor($diff / (60 * 60)), 2, '0', STR_PAD_LEFT);
                        $menit = $diff - $jam * (60 * 60);
                        $menit = str_pad(floor($menit / 60), 2, '0', STR_PAD_LEFT);
                        $total = $jam . ':' . $menit;
                      } else {
                        $awal = strtotime('2020-01-01 ' . $total1 . ':00');
                        $akhir = strtotime('2020-01-01 ' . $total2 . ':00');
                        $diff  = $akhir - $awal;
                        $jam   = str_pad(floor($diff / (60 * 60)), 2, '0', STR_PAD_LEFT);
                        $menit = $diff - $jam * (60 * 60);
                        $menit = str_pad(floor($menit / 60), 2, '0', STR_PAD_LEFT);
                        $total = $jam . ':' . $menit;
                      }
                      ?>
                                            <input type="text" class="form-control" id="eet_b"
                                                placeholder="Masukan Block Total" name="dt[block_time_total]"
                                                value="<?= $total ?>">

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-remark">IRREG CODE</label>


                                            <select style='width:100%' name="dt[remark_report]"
                                                class="form-control select2">
                                                <option value="">SELECT IRREG CODE</option>
                                                <?php

                        $this->db->order_by('code ASC');
                        $base_airport_document = $this->mymodel->selectWhere('delay_and_cancel_code', null);

                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text = "";

                          if ($base_airport_document_record['code'] == $daily_ftd_schedule['remark_report']) {

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

                          if ($base_airport_document_record['code'] == $daily_ftd_schedule['remark_safety']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $base_airport_document_record['code'] . "' " . $text . " >" . $base_airport_document_record['code'] . ' (' . $base_airport_document_record['remarks'] . ")</option>";
                        }

                        ?>

                                            </select>
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
                    window.location.href = "<?= base_url('master/daily_ftd_report') ?>";
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
    $('#course').change(function() {
        var course = $('#course').val();
        $("#mission").html('<option>LOADING...</option>');
        if (batch) {
            $.ajax({
                url: '<?= base_url() ?>ajax/get_mission_by_course/?course=' + course +
                    '&type=FTD',
                success: function(html) {
                    $("#mission").html(html);
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