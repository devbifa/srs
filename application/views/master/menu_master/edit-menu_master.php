

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Menu Master

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


      <li class="#">Menu Master</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Menu_master/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $menu_master['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Menu Master

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="form-group col-md-6">

                      <label for="form-name">Name</label>

                      <input type="text" class="form-control" id="form-name" placeholder="Masukan Name" name="dt[name]" value="<?= $menu_master['name'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-icon">Icon</label>

                      <input type="text" class="form-control" id="form-icon" placeholder="Masukan Icon" name="dt[icon]" value="<?= $menu_master['icon'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-link">Link</label>

                      <input type="text" class="form-control" id="form-link" placeholder="Masukan Link" name="dt[link]" value="<?= $menu_master['link'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-urutan">Urutan</label>

                      <input type="text" class="form-control" id="form-urutan" placeholder="Masukan Urutan" name="dt[urutan]" value="<?= $menu_master['urutan'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-parent">Parent</label>

                      <input type="text" class="form-control" id="form-parent" placeholder="Masukan Parent" name="dt[parent]" value="<?= $menu_master['parent'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-notif">Notif</label>

                      <input type="text" class="form-control" id="form-notif" placeholder="Masukan Notif" name="dt[notif]" value="<?= $menu_master['notif'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-file">File </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

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

                           window.location.href = "<?= base_url('master/Menu_master') ?>";

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