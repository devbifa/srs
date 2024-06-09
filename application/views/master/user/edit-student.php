

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        STUDENT

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">STUDENT</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('user/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input readonly type="hidden" name="id" value="<?= $user['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">
          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
              EDIT MY PROFILE
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
                <div class="form-group col-md-6">

<label for="form-nip">ID NUMBER</label>

<input readonly type="text" class="form-control" id="form-nip" placeholder="Fill Id Number" name="dt[id_number]" value="<?= $user['id_number'] ?>">

</div><div class="form-group col-md-6">

<label for="form-name">FULL NAME</label>

<input readonly type="text" class="form-control" id="form-name" placeholder="Fill Full Name" name="dt[full_name]" value="<?= $user['full_name'] ?>">

</div><div class="form-group col-md-6">

<label for="form-name">NICK NAME</label>

<input readonly type="text" class="form-control" id="form-name" placeholder="Fill Nick Name" name="dt[nick_name]" value="<?= $user['nick_name'] ?>">

</div><div class="form-group col-md-6">

<label for="form-email">EMAIL</label>

<input readonly type="text" class="form-control" id="form-email" placeholder="Fill Email" name="dt[email]" value="<?= $user['email'] ?>">

</div><div class="form-group col-md-6">

<label for="form-password">PASSWORD</label>

<input type="text" class="form-control" id="form-password" placeholder="Fill Password" name="password">

</div>

<div class="form-group col-md-6">

<label for="form-base">STATUS</label>
<select disabled style='width:100%' name="dt[status]" class="form-control select2">

  <?php 

  $this->db->order_by('status ASC');

  $base_airport_document = $this->mymodel->selectWhere('instructor_status',null);

  foreach ($base_airport_document as $base_airport_document_record) {

    $text="";

    if($base_airport_document_record['instructor_status']==$user['status']){

      $text = "selected";

    }



    echo "<option value='".$base_airport_document_record['instructor_status']."' ".$text." >".$base_airport_document_record['instructor_status']."</option>";

  }

  ?>

</select>

</div>

                  <div class="form-group col-md-12">

<label for="form-file">FILE </label>  

<?php

if($file['dir']!=""){ ?>
<a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


<?php } ?>


<input  type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

</div>



                </div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1" ><i class="mdi mdi-content-save"></i></button>

              

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

                    $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>