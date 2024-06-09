

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FLIGHT SCHEDULE

        <small>PREVIEW</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">DAILY FLIGHT SCHEDULE</li>

      <li class="active">PREVIEW</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Daily_flight_schedule/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $daily_flight_schedule['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Daily Flight Schedule

              </h5>

            </div>
            -->
            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-6">
                
                <div class="row">
                <div class="form-group col-md-12">

                     <label for="form-date_of_flight">DATE OF FLIGHT</label>

                      <br>
                      <?= $daily_flight_schedule['date_of_flight'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-origin_base">ORIGIN BASE</label>

                      <br>
                      <?= $daily_flight_schedule['origin_base'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-aircraft_reg">AIRCRAFT REG</label>

                      <br>
                      <?= $daily_flight_schedule['aircraft_reg'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-pic">PIC</label>

                      <br>
                      <?= $daily_flight_schedule['pic'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-2nd">2ND</label>

                      <br>
                      <?= $daily_flight_schedule['2nd'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-course">COURSE</label>

                      <br>
                      <?= $daily_flight_schedule['course'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-batch">BATCH</label>

                      <br>
                      <?= $daily_flight_schedule['batch'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-mission">MISSION</label>

                      <br>
                      <?= $daily_flight_schedule['mission'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-mission_name">MISSION NAME</label>

                      <br>
                      <?= $daily_flight_schedule['mission_name'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-description">DESCRIPTION</label>
                      <br>
                      <?= $daily_flight_schedule['description'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-rute">RUTE</label>
                      <br>
                      <?= $daily_flight_schedule['rute'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-etd_utc">ETD UTC</label>
                      <br>
                      <?= $daily_flight_schedule['etd_utc'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-eta_utc">ETA UTC</label>
                      <br>
                      <?= $daily_flight_schedule['eta_utc'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-eet">EET</label>
                      <br>
                      <?= $daily_flight_schedule['eet'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-dep">DEP</label>
                      <br>
                      <?= $daily_flight_schedule['dep'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-arr">ARR</label>
                      <br>
                      <?= $daily_flight_schedule['arr'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-remark">REMARK</label>
                      <br>
                      <?= $daily_flight_schedule['remark'] ?>
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

                           window.location.href = "<?= base_url('master/Daily_flight_schedule') ?>";

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