

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FUEL CONSUMPTION

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">DAILY FUEL CONSUMPTION</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/daily_fuel_consumption/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Tambah Daily Fuel Consumption

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

                      <label for="form-acft_reg">ACFT REG</label>

                      <select style='width:100%' name="dt[acft_reg]" class="form-control select2">

                        <?php 

                        $aircraft_document = $this->mymodel->selectWhere('aircraft_document',null);

                        foreach ($aircraft_document as $aircraft_document_record) {

                          echo "<option value='".$aircraft_document_record['serial_number']."' >".$aircraft_document_record['serial_number']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-type">TYPE</label>

                      <select style='width:100%' name="dt[type]" class="form-control select2">

                        <?php 

                        $aircraft_document = $this->mymodel->selectWhere('aircraft_document',null);

                        foreach ($aircraft_document as $aircraft_document_record) {

                          echo "<option value='".$aircraft_document_record['type']."' >".$aircraft_document_record['type']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-origin_base">ORIGIN BASE</label>

                      <select style='width:100%' name="dt[origin_base]" class="form-control select2">

                        <?php 

                        $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);

                        foreach ($base_airport_document as $base_airport_document_record) {

                          echo "<option value='".$base_airport_document_record['base']."' >".$base_airport_document_record['base']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-12">

                      <label for="form-fueling_type">FUELING TYPE</label>

                      <input type="text" class="form-control" id="form-fueling_type" placeholder="Masukan Fueling Type" name="dt[fueling_type]">

                  </div><div class="form-group col-md-12">

                      <label for="form-refueling_station">REFUELING STATION</label>

                      <input type="text" class="form-control" id="form-refueling_station" placeholder="Masukan Refueling Station" name="dt[refueling_station]">

                  </div><div class="form-group col-md-12">

                      <label for="form-uplift_qty_ltr">UPLIFT QTY LTR</label>

                      <input type="text" class="form-control" id="form-uplift_qty_ltr" placeholder="Masukan Uplift Qty Ltr" name="dt[uplift_qty_ltr]">

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

                           window.location.href = "<?= base_url('master/daily_fuel_consumption') ?>";

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