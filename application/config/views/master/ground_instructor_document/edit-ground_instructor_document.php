

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        GROUND INSTRUCTOR DOCUMENT

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">GROUND INSTRUCTOR DOCUMENT</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Ground_instructor_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $ground_instructor_document['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Ground Instructor Document

              </h5>

            </div>
            -->
            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-6">
                
                <div class="row">
                <div class="form-group col-md-12">

                      <label for="form-instructor_name">INSTRUCTOR NAME</label>

                      <input type="text" class="form-control" id="form-instructor_name" placeholder="Masukan Instructor Name" name="dt[instructor_name]" value="<?= $ground_instructor_document['instructor_name'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-nick_name">NICK NAME</label>

                      <input type="text" class="form-control" id="form-nick_name" placeholder="Masukan Nick Name" name="dt[nick_name]" value="<?= $ground_instructor_document['nick_name'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-employee_number">EMPLOYEE NUMBER</label>

                      <input type="text" class="form-control" id="form-employee_number" placeholder="Masukan Employee Number" name="dt[employee_number]" value="<?= $ground_instructor_document['employee_number'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-gic_number">GIC NUMBER</label>

                      <input type="text" class="form-control" id="form-gic_number" placeholder="Masukan Gic Number" name="dt[gic_number]" value="<?= $ground_instructor_document['gic_number'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-subject_capabilities">SUBJECT CAPABILITIES</label>

                      <input type="text" class="form-control" id="form-subject_capabilities" placeholder="Masukan Subject Capabilities" name="dt[subject_capabilities]" value="<?= $ground_instructor_document['subject_capabilities'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-last_input_date">LAST INPUT DATE</label>

                      <input type="text" class="form-control" id="form-last_input_date" placeholder="Masukan Last Input Date" name="dt[last_input_date]" value="<?= $ground_instructor_document['last_input_date'] ?>">

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
   <div class="form-group col-md-12"> <label for="form-file">ATTACHMENT LIST</label> <div class="table-responsive"> <table class="table table-bordered"> <tr> <th class="text-left">NO. </th> <th class="text-left">TYPE </th> <th class="text-left"> <a href="#!" class="btn btn-primary btn-xs btn-block">ADD</a> </th> </tr> <?php $attachment = $this->mymodel->selectWithQuery("SELECT * FROM attachment_type WHERE status = 'ENABLE'"); foreach($attachment as $key=>$val){ ?> <tr> <td class="text-left" style="width:25px;"> <?=$key+1?> </td> <td class="text-left"> <a href="#!"><?=$val['attachment_type']?></a> </td> <td class="text-left" style="width:25px;"> <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> <a href="#!" class="btn btn-danger btn-xs btn-block">DELETE</a> </td> </tr> <?php } ?> </table> </div> </div>
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

                           window.location.href = "<?= base_url('master/Ground_instructor_document') ?>";

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