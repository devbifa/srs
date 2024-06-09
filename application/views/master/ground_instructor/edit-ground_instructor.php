

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Ground Instructor

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


      <li class="#">Ground Instructor</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Ground_instructor/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $ground_instructor['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Ground Instructor

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="form-group col-md-6">

                      <label for="form-instructor_code">Instructor Code</label>

                      <input type="text" class="form-control" id="form-instructor_code" placeholder="Masukan Instructor Code" name="dt[instructor_code]" value="<?= $ground_instructor['instructor_code'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-instructor_name">Instructor Name</label>

                      <input type="text" class="form-control" id="form-instructor_name" placeholder="Masukan Instructor Name" name="dt[instructor_name]" value="<?= $ground_instructor['instructor_name'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-gic_number">Gic Number</label>

                      <input type="text" class="form-control" id="form-gic_number" placeholder="Masukan Gic Number" name="dt[gic_number]" value="<?= $ground_instructor['gic_number'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-subject">Subject</label>

                      <input type="text" class="form-control" id="form-subject" placeholder="Masukan Subject" name="dt[subject]" value="<?= $ground_instructor['subject'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-description">Description</label>

                      <input type="text" class="form-control" id="form-description" placeholder="Masukan Description" name="dt[description]" value="<?= $ground_instructor['description'] ?>">

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

                           window.location.href = "<?= base_url('master/Ground_instructor') ?>";

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