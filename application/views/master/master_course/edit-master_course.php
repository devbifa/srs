

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        MASTER COURSE

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">MASTER COURSE</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Master_course/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $master_course['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Master Course

              </h5>

            </div>
            -->
            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-6">
                
                <div class="row">
                <div class="form-group col-md-12">

                      <label for="form-position">POSITION</label>

                      <input type="text" class="form-control" id="form-position" placeholder="Masukan Position" name="dt[position]" value="<?= $master_course['position'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-course_code">COURSE CODE</label>

                      <input type="text" class="form-control" id="form-course_code" placeholder="Masukan Course Code" name="dt[course_code]" value="<?= $master_course['course_code'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-course_name">COURSE NAME</label>

                      <input type="text" class="form-control" id="form-course_name" placeholder="Masukan Course Name" name="dt[course_name]" value="<?= $master_course['course_name'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-description">DESCRIPTION</label>

                      <input type="text" class="form-control" id="form-description" placeholder="Masukan Description" name="dt[description]" value="<?= $master_course['description'] ?>">

                  </div><div class="form-group col-md-12">

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
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> SUBMIT</button>

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

                           window.location.href = "<?= base_url('master/Master_course') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>