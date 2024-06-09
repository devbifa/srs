

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY GROUND SCHEDULE

        <small>PREVIEW</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">DAILY GROUND SCHEDULE</li>

      <li class="active">PREVIEW</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Daily_ground_schedule/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $daily_ground_schedule['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Daily Ground Schedule

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

                      <br>
                      <?= $daily_ground_schedule['date'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-classroom">CLASSROOM</label>

                      <br>
                      <?= $daily_ground_schedule['classroom'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-course">COURSE</label>

                      <br>
                      <?= $daily_ground_schedule['course'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-subject">SUBJECT</label>

                      <br>
                      <?= $daily_ground_schedule['subject'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-instructor">INSTRUCTOR</label>

                      <br>
                      <?= $daily_ground_schedule['instructor'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-duration">DURATION</label>
                      <br>
                      <?= $daily_ground_schedule['duration'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-start_lt">START LT</label>
                      <br>
                      <?= $daily_ground_schedule['start_lt'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-stop_lt">STOP LT</label>
                      <br>
                      <?= $daily_ground_schedule['stop_lt'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-remark">REMARK</label>
                      <br>
                      <?= $daily_ground_schedule['remark'] ?>
                  </div><div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                    
                  </div></div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
  <!--          
  <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

                </div>
             

                </div>

                </div>
-->
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

                           window.location.href = "<?= base_url('master/Daily_ground_schedule') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>