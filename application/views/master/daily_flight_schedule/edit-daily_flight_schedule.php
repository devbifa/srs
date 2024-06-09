<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            DAILY FLIGHT SCHEDULE

            <small>EDIT</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


            <li class="#">DAILY FLIGHT SCHEDULE</li>

            <li class="active">EDIT</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/daily_flight_schedule/update') ?>" id="upload-create"
            enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $daily_flight_schedule['id'] ?>">





            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    EDIT DAILY FLIGHT SCHEDULE
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
                                                name="dt[date_of_flight]"
                                                value="<?= $daily_flight_schedule['date_of_flight'] ?>">

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


                        foreach ($base_airport_document as $val) {

                          $text = "";

                          if ($val['base'] == $daily_flight_schedule['origin_base']) {

                            $text = "selected";
                          }



                          echo "<option value='" . $val['base'] . "' " . $text . " >" . $val['base'] . "</option>";
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


                    <?php if ($_SESSION['create'] == 'create') { ?>
                    window.location.href =
                        "<?= base_url('master/daily_flight_schedule/create') ?>";
                    <?php } else { ?>
                    window.location.href =
                        "<?= base_url('master/daily_flight_schedule/create') ?>";
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
                    '&course=' + course + '&type=FLIGHT',
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