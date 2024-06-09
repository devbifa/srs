<?php 
$id = $_SESSION['id'];
$data = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE id='$id'");
$user = $data[0];
$photo = $this->mymodel->selectDataone('file', array('table' => 'user', 'table_id' => $id));
 
?>

<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Akun Saya</h3>
    </div>
</div>
<div class="box">
    <div class="col-md-12">
    <form method="POST" action="<?= base_url('akun/update') ?>" id="upload-create" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $user['id'] ?>">





  <div class="row">

    <div class="col-md-12">

      <div class="">

        <div class="box-body">

            <div class="show_error"></div>
            <div class="form-group">

                  <label for="form-name">Name</label>

                  <input type="text" class="form-control" id="form-name" placeholder="Masukan Name" name="dt[name]" value="<?= $user['name'] ?>">

              </div><div class="form-group">

                  <label for="form-email">Email</label>

                  <input readonly type="text" class="form-control" id="form-email" placeholder="Masukan Email" value="<?= $user['email'] ?>">

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

       <div class="col-md-12 text-center">
       <?php if ($photo != null) { ?>
                    <img src="<?= base_url().'admin-side/webfile/'.$photo['name'] ?>" class="img-circle" alt="User Image" height="150px" width="150px">
                <?php } else { ?>
                    <img src="<?= base_url('webfile/raider/raider_default.png') ?>" class="img-circle" alt="User Image" height="150px" width="150px">
                <?php } ?>  
       </div>

<br>

<div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-send btn-block" ><i class="fa fa-save"></i> Simpan Akun Saya</button>
            </div>

         

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
    </div>
</div>
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

                     window.location.href = "<?= base_url('akun') ?>";

                  }, 1000);

                  $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan Akun Saya').attr('disabled',false);


                  window.location.href = "<?= base_url('akun') ?>";

                 

              }else{

                  form.find(".show_error").hide().html(response).slideDown("fast");

                  $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan Akun Saya').attr('disabled',false);

                  window.location.href = "<?= base_url('akun') ?>";
                  

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