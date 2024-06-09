

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY AIRCRAFT STATUS

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">DAILY AIRCRAFT STATUS</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Daily_aircraft_status/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $daily_aircraft_status['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT DAILY AIRCRAFT STATUS
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
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

                      <input autocomplete="off" type="text" class="form-control tgl" id="form-date" placeholder="Masukan Date" name="dt[date]" value="<?= $daily_aircraft_status['date'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-acft_reg">ACFT REG</label>

                      <select style='width:100%' name="dt[acft_reg]" class="form-control select2">

                        <?php 

                        $aircraft_document = $this->mymodel->selectWhere('aircraft_document',null);

                        foreach ($aircraft_document as $aircraft_document_record) {

                          $text="";

                          if($aircraft_document_record['serial_number']==$daily_aircraft_status['acft_reg']){

                            $text = "selected";

                          }



                          echo "<option value='".$aircraft_document_record['serial_number']."' ".$text." >".$aircraft_document_record['serial_number']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-3">

                      <label for="form-type">TYPE</label>

                      <select style='width:100%' name="dt[type]" class="form-control select2">

                        <?php 

                        $aircraft_document = $this->mymodel->selectWhere('aircraft_document',null);

                        foreach ($aircraft_document as $aircraft_document_record) {

                          $text="";

                          if($aircraft_document_record['type']==$daily_aircraft_status['type']){

                            $text = "selected";

                          }



                          echo "<option value='".$aircraft_document_record['type']."' ".$text." >".$aircraft_document_record['type']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-3">

                      <label for="form-origin_base">ORIGIN BASE</label>

                      <select style='width:100%' name="dt[origin_base]" class="form-control select2">

                        <?php 

                        $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);

                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text="";

                          if($base_airport_document_record['base']==$daily_aircraft_status['origin_base']){

                            $text = "selected";

                          }



                          echo "<option value='".$base_airport_document_record['base']."' ".$text." >".$base_airport_document_record['base']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-3">

                      <label for="form-engine_hoobs_start">ENGINE HOOBS START</label>

                      <input type="text" class="form-control" id="form-engine_hoobs_start" placeholder="Masukan Engine Hoobs Start" name="dt[engine_hoobs_start]" value="<?= $daily_aircraft_status['engine_hoobs_start'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-engine_hoobs_stop">ENGINE HOOBS STOP</label>

                      <input type="text" class="form-control" id="form-engine_hoobs_stop" placeholder="Masukan Engine Hoobs Stop" name="dt[engine_hoobs_stop]" value="<?= $daily_aircraft_status['engine_hoobs_stop'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-total_hobbs">TOTAL HOBBS</label>

                      <input type="text" class="form-control" id="form-total_hobbs" placeholder="Masukan Total Hobbs" name="dt[total_hobbs]" value="<?= $daily_aircraft_status['total_hobbs'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-c_of_a_valid">C OF A VALID</label>

                      <input type="text" class="form-control" id="form-c_of_a_valid" placeholder="Masukan C Of A Valid" name="dt[c_of_a_valid]" value="<?= $daily_aircraft_status['c_of_a_valid'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-c_of_r_valid">C OF R VALID</label>

                      <input type="text" class="form-control" id="form-c_of_r_valid" placeholder="Masukan C Of R Valid" name="dt[c_of_r_valid]" value="<?= $daily_aircraft_status['c_of_r_valid'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-radio_station_dgca">RADIO STATION DGCA</label>

                      <input type="text" class="form-control" id="form-radio_station_dgca" placeholder="Masukan Radio Station Dgca" name="dt[radio_station_dgca]" value="<?= $daily_aircraft_status['radio_station_dgca'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-radio_station_kominfo">RADIO STATION KOMINFO</label>

                      <input type="text" class="form-control" id="form-radio_station_kominfo" placeholder="Masukan Radio Station Kominfo" name="dt[radio_station_kominfo]" value="<?= $daily_aircraft_status['radio_station_kominfo'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-swing_compass">SWING COMPASS</label>

                      <input type="text" class="form-control" id="form-swing_compass" placeholder="Masukan Swing Compass" name="dt[swing_compass]" value="<?= $daily_aircraft_status['swing_compass'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-weight_and_balance">WEIGHT AND BALANCE</label>

                      <input type="text" class="form-control" id="form-weight_and_balance" placeholder="Masukan Weight And Balance" name="dt[weight_and_balance]" value="<?= $daily_aircraft_status['weight_and_balance'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-basarnas">BASARNAS</label>

                      <input type="text" class="form-control" id="form-basarnas" placeholder="Masukan Basarnas" name="dt[basarnas]" value="<?= $daily_aircraft_status['basarnas'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

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