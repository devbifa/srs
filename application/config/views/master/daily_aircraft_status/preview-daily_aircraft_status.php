

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY AIRCRAFT STATUS

        <small>PREVIEW</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">DAILY AIRCRAFT STATUS</li>

      <li class="active">PREVIEW</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Daily_aircraft_status/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $daily_aircraft_status['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Daily Aircraft Status

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
                      <?= $daily_aircraft_status['date'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-acft_reg">ACFT REG</label>

                      <br>
                      <?= $daily_aircraft_status['acft_reg'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-type">TYPE</label>

                      <br>
                      <?= $daily_aircraft_status['type'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-origin_base">ORIGIN BASE</label>

                      <br>
                      <?= $daily_aircraft_status['origin_base'] ?>

                  </div><div class="form-group col-md-12">

                     <label for="form-engine_hoobs_start">ENGINE HOOBS START</label>
                      <br>
                      <?= $daily_aircraft_status['engine_hoobs_start'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-engine_hoobs_stop">ENGINE HOOBS STOP</label>
                      <br>
                      <?= $daily_aircraft_status['engine_hoobs_stop'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-total_hobbs">TOTAL HOBBS</label>
                      <br>
                      <?= $daily_aircraft_status['total_hobbs'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-c_of_a_valid">C OF A VALID</label>
                      <br>
                      <?= $daily_aircraft_status['c_of_a_valid'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-c_of_r_valid">C OF R VALID</label>
                      <br>
                      <?= $daily_aircraft_status['c_of_r_valid'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-radio_station_dgca">RADIO STATION DGCA</label>
                      <br>
                      <?= $daily_aircraft_status['radio_station_dgca'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-radio_station_kominfo">RADIO STATION KOMINFO</label>
                      <br>
                      <?= $daily_aircraft_status['radio_station_kominfo'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-swing_compass">SWING COMPASS</label>
                      <br>
                      <?= $daily_aircraft_status['swing_compass'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-weight_and_balance">WEIGHT AND BALANCE</label>
                      <br>
                      <?= $daily_aircraft_status['weight_and_balance'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-basarnas">BASARNAS</label>
                      <br>
                      <?= $daily_aircraft_status['basarnas'] ?>
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

                           window.location.href = "<?= base_url('master/Daily_aircraft_status') ?>";

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