

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Base

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="#">Master</a></li>

      <li class="#">Base</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Base/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $base['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Base

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div><div class="form-group">

                      <label for="form-kode_base">Kode Base</label>

                      <input type="text" class="form-control" id="form-kode_base" placeholder="Masukan Kode Base" name="dt[kode_base]" value="<?= $base['kode_base'] ?>">

                  </div><div class="form-group">

                      <label for="form-nama_base">Nama Base</label>

                      <input type="text" class="form-control" id="form-nama_base" placeholder="Masukan Nama Base" name="dt[nama_base]" value="<?= $base['nama_base'] ?>">

                  </div><?php

                  if($file['dir']!=""){

                  $types = explode("/", $file['mime']);

                  if($types[0]=="image"){

                  ?>

                    <img src="<?= base_url($file['dir']) ?>" style="width: 200px" class="img img-thumbnail">

                    <br>

                  <?php }else{ ?>

                    

                    <i class="fa fa-file fa-5x text-danger"></i>

                    <br>

                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>

                    <br>

                  <br>

                <?php } ?>

                <?php } ?><div class="form-group">

                      <label for="form-file">File</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div></div>

            <div class="box-footer">

                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

             

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

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

                           window.location.href = "<?= base_url('master/Base') ?>";

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