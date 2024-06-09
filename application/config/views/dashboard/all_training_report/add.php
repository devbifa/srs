

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

    <form method="POST" action="<?= base_url('master/daily_ftd_schedule/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Tambah Daily Ftd Schedule

              </h5>
            </div>
            -->

            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-6">
                
  <div class="row">
                <div class="form-group col-md-12">

                      <label for="form-date">DATE</label>

                      <input value="<?=DATE('Y-m-d')?>" autocomplete="off" type="text" class="form-control tgl" id="form-date" placeholder="Masukan Date" name="dt[date]">

                  </div><div class="form-group col-md-12">

                      <label for="form-manufacture">MANUFACTURE</label>

                      <input type="text" class="form-control" id="form-manufacture" placeholder="Masukan Manufacture" name="dt[manufacture]">

                  </div><div class="form-group col-md-12">

                      <label for="form-ftd_model">FTD MODEL</label>

                      <input type="text" class="form-control" id="form-ftd_model" placeholder="Masukan Ftd Model" name="dt[ftd_model]">

                  </div><div class="form-group col-md-12">

                      <label for="form-course">COURSE</label>

                      <select style='width:100%' name="dt[course]" class="form-control select2">

                        <?php 

                        $tpm_syllabus_all_course = $this->mymodel->selectWhere('tpm_syllabus_all_course',null);

                        foreach ($tpm_syllabus_all_course as $tpm_syllabus_all_course_record) {

                          echo "<option value='".$tpm_syllabus_all_course_record['course']."' >".$tpm_syllabus_all_course_record['course']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-batch">BATCH</label>

                      <select style='width:100%' name="dt[batch]" class="form-control select2">

                        <?php 

                        $batch = $this->mymodel->selectWhere('batch',null);

                        foreach ($batch as $batch_record) {

                          echo "<option value='".$batch_record['batch']."' >".$batch_record['batch']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-mission">MISSION</label>

                      <select style='width:100%' name="dt[mission]" class="form-control select2">

                        <?php 

                        $tpm_syllabus_all_course = $this->mymodel->selectWhere('tpm_syllabus_all_course',null);

                        foreach ($tpm_syllabus_all_course as $tpm_syllabus_all_course_record) {

                          echo "<option value='".$tpm_syllabus_all_course_record['subject_mission']."' >".$tpm_syllabus_all_course_record['subject_mission']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-instructor">INSTRUCTOR</label>

                      <select style='width:100%' name="dt[instructor]" class="form-control select2">

                        <?php 

                        $ftd_flight_instructor_document = $this->mymodel->selectWhere('ftd_flight_instructor_document',null);

                        foreach ($ftd_flight_instructor_document as $ftd_flight_instructor_document_record) {

                          echo "<option value='".$ftd_flight_instructor_document_record['instructor_name']."' >".$ftd_flight_instructor_document_record['instructor_name']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-student">STUDENT</label>

                      <select style='width:100%' name="dt[student]" class="form-control select2">

                        <?php 

                        $student_document = $this->mymodel->selectWhere('student_document',null);

                        foreach ($student_document as $student_document_record) {

                          echo "<option value='".$student_document_record['student_name']."' >".$student_document_record['student_name']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-eet_utc">EET UTC</label>

                      <input type="text" class="form-control" id="form-eet_utc" placeholder="Masukan Eet Utc" name="dt[eet_utc]">

                  </div><div class="form-group col-md-12">

                      <label for="form-etd_utc">ETD UTC</label>

                      <input type="text" class="form-control" id="form-etd_utc" placeholder="Masukan Etd Utc" name="dt[etd_utc]">

                  </div><div class="form-group col-md-12">

                      <label for="form-eta">ETA</label>

                      <input type="text" class="form-control" id="form-eta" placeholder="Masukan Eta" name="dt[eta]">

                  </div><div class="form-group col-md-12">

                      <label for="form-remark">REMARK</label>

                      <input type="text" class="form-control" id="form-remark" placeholder="Masukan Remark" name="dt[remark]">

                  </div><div class="form-group col-md-12">

                      <label for="form-file">FILE</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div></div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> SAVE</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> RESET</button>

                </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

        </div>

        <!-- /.col -->

        </div></div>

      <!-- /.row -->

      </form>



    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->

  <script type="text/javascript">

      $("#upload-create").submit(function(){

            var form = $(this);

            var mydata = new FormData(this);

            $.ajax({

                type: "POST",

                url: form.attr("action"),

                data: mydata,

                cache: false,

                contentType: false,

                processData: false,

                beforeSend : function(){

                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/daily_ftd_schedule') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>