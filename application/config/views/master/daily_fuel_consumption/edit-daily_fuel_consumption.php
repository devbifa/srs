

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FUEL CONSUMPTION

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">DAILY FUEL CONSUMPTION</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Daily_fuel_consumption/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $daily_fuel_consumption['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">
          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT DAILY FUEL STATUS
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

                      <input autocomplete="off" type="text" class="form-control tgl" id="form-date" placeholder="Masukan Date" name="dt[date]" value="<?= $daily_fuel_consumption['date'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-acft_reg">ACFT REG</label>

                      <select style='width:100%' name="dt[acft_reg]" class="form-control select2">

                        <?php 

                        $aircraft_document = $this->mymodel->selectWhere('aircraft_document',null);

                        foreach ($aircraft_document as $aircraft_document_record) {

                          $text="";

                          if($aircraft_document_record['serial_number']==$daily_fuel_consumption['acft_reg']){

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

                          if($aircraft_document_record['type']==$daily_fuel_consumption['type']){

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

                          if($base_airport_document_record['base']==$daily_fuel_consumption['origin_base']){

                            $text = "selected";

                          }



                          echo "<option value='".$base_airport_document_record['base']."' ".$text." >".$base_airport_document_record['base']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-3">

                      <label for="form-fueling_type">FUELING TYPE</label>

                      <input type="text" class="form-control" id="form-fueling_type" placeholder="Masukan Fueling Type" name="dt[fueling_type]" value="<?= $daily_fuel_consumption['fueling_type'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-refueling_station">REFUELING STATION</label>

                      <input type="text" class="form-control" id="form-refueling_station" placeholder="Masukan Refueling Station" name="dt[refueling_station]" value="<?= $daily_fuel_consumption['refueling_station'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-uplift_qty_ltr">UPLIFT QTY LTR</label>

                      <input type="text" class="form-control" id="form-uplift_qty_ltr" placeholder="Masukan Uplift Qty Ltr" name="dt[uplift_qty_ltr]" value="<?= $daily_fuel_consumption['uplift_qty_ltr'] ?>">

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

                           window.location.href = "<?= base_url('master/Daily_fuel_consumption') ?>";

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