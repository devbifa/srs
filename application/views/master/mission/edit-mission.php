

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Mission

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


      <li class="#">Mission</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Mission/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $mission['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Mission

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="form-group col-md-6">

                      <label for="form-course_code">Course Code</label>

                      <select style='width:100%' name="dt[course_code]" class="form-control select2">

                        <?php 

                        $course = $this->mymodel->selectWhere('course',null);

                        foreach ($course as $course_record) {

                          $text="";

                          if($course_record['course_code']==$mission['course_code']){

                            $text = "selected";

                          }



                          echo "<option value='".$course_record['course_code']."' ".$text." >".$course_record['course_name']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-6">

                      <label for="form-mission_code">Mission Code</label>

                      <input type="text" class="form-control" id="form-mission_code" placeholder="Masukan Mission Code" name="dt[mission_code]" value="<?= $mission['mission_code'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-mission_name">Mission Name</label>

                      <input type="text" class="form-control" id="form-mission_name" placeholder="Masukan Mission Name" name="dt[mission_name]" value="<?= $mission['mission_name'] ?>">

                  </div><div class="form-group col-md-6">

<label for="form-position">Dual Duration</label>

<input type="text" class="form-control" id="form-position" placeholder="Masukan Dual Duration" name="dt[dual_duration]" value="<?= $mission['dual_duration'] ?>">

</div>
<div class="form-group col-md-6">

<label for="form-position">Solo Duration</label>

<input type="text" class="form-control" id="form-position" placeholder="Masukan Solo Duration" name="dt[solo_duration]" value="<?= $mission['solo_duration'] ?>">

</div>
<div class="form-group col-md-6">

<label for="form-position">Position</label>

<input type="text" class="form-control" id="form-position" placeholder="Masukan Position" name="dt[position]" value="<?= $mission['position'] ?>">

</div><div class="form-group col-md-6">

                      <label for="form-description">Description</label>

                      <input type="text" class="form-control" id="form-description" placeholder="Masukan Description" name="dt[description]" value="<?= $mission['description'] ?>">

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

                           window.location.href = "<?= base_url('master/Mission') ?>";

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