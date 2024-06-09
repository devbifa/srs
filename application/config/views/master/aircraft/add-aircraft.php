

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Aircraft

        <small>Tambah</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">Aircraft</li>

        <li class="active">Tambah</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Aircraft/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Tambah Aircraft

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div>
                <div class="row"><div class="form-group col-md-6">

                      <label for="form-aircraft_code">Aircraft Code</label>

                      <input type="text" class="form-control" id="form-aircraft_code" placeholder="Masukan Aircraft Code" name="dt[aircraft_code]">

                  </div><div class="form-group col-md-6">

                      <label for="form-aircraft_name">Aircraft Name</label>

                      <input type="text" class="form-control" id="form-aircraft_name" placeholder="Masukan Aircraft Name" name="dt[aircraft_name]">

                  </div><div class="form-group col-md-6">

                      <label for="form-aircraft_type">Aircraft Type</label>

                      <select style='width:100%' name="dt[aircraft_type]" class="form-control select2">

                        <?php 

                        $aircraft_type = $this->mymodel->selectWhere('aircraft_type',null);

                        foreach ($aircraft_type as $aircraft_type_record) {

                          echo "<option value='".$aircraft_type_record['aircraft_type']."' >".$aircraft_type_record['aircraft_type']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-6">

                      <label for="form-description">Description</label>

                      <input type="text" class="form-control" id="form-description" placeholder="Masukan Description" name="dt[description]">

                  </div><div class="form-group col-md-6">

                      <label for="form-file">File</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div></div>
            <div class="box-footer">

            <div class="">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

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

                           window.location.href = "<?= base_url('master/Aircraft') ?>";

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