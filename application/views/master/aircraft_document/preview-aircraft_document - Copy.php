

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        AIRCRAFT DOCUMENT

        <small>PREVIEW</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">AIRCRAFT DOCUMENT</li>

      <li class="active">PREVIEW</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Aircraft_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $aircraft_document['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Aircraft Document

              </h5>

            </div>
            -->
            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-6">
                
                <div class="row">
                <div class="form-group col-md-12">

                     <label for="form-model">MODEL</label>
                      <br>
                      <?= $aircraft_document['model'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-type">TYPE</label>
                      <br>
                      <?= $aircraft_document['type'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-serial_number">SERIAL NUMBER</label>
                      <br>
                      <?= $aircraft_document['serial_number'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-registration">REGISTRATION</label>
                      <br>
                      <?= $aircraft_document['registration'] ?>
                  </div><div class="form-group col-md-12">

                     <label for="form-last_input_date">LAST INPUT DATE</label>
                      <br>
                      <?= $aircraft_document['last_input_date'] ?>
                  </div><div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                    
                  </div></div></div>
  
  <div class="col-md-6">
  
  <div class="row">
   <div class="form-group col-md-12"> <label for="form-file">ATTACHMENT LIST</label> <div class="table-responsive"> <table class="table table-bordered"> <tr> <th class="text-left">NO. </th> <th class="text-left">TYPE </th> <th class="text-left"> <a href="#!" class="btn btn-primary btn-xs btn-block">ADD</a> </th> </tr> <?php $attachment = $this->mymodel->selectWithQuery("SELECT * FROM attachment_type WHERE status = 'ENABLE'"); foreach($attachment as $key=>$val){ ?> <tr> <td class="text-left" style="width:25px;"> <?=$key+1?> </td> <td class="text-left"> <a href="#!"><?=$val['attachment_type']?></a> </td> <td class="text-left" style="width:25px;"> <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> <a href="#!" class="btn btn-danger btn-xs btn-block">DELETE</a> </td> </tr> <?php } ?> </table> </div> </div>
  </div>
  </div>
  </div>
  <!--          
  <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

                </div>
             

                </div>

                </div>
-->
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

                           window.location.href = "<?= base_url('master/Aircraft_document') ?>";

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