

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        STUDENT APPLICATION FORM

        <small>CREATE BY MARKETING</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


        <li class="#">STUDENT APPLICATION FORM</li>

        <li class="active">CREATE BY MARKETING</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/instructor_list/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material">
            
              <h3 class="box-header-material-text">CREATE INSTRUCTOR
              <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            </div>
            <div class="box-body">

<div class="show_error"></div>
<div class="row">
<div class="col-md-12">

<div class="row"><div class="form-group col-md-3">

<label for="form-application_number">EMPLOYEE NUMBER</label>

<input type="text" class="form-control" id="form-application_number" placeholder="Insert Employee Number" name="dt[id_number]" value="<?= $student_application_form['id_number'] ?>">

</div><div class="form-group col-md-3">

<label for="form-full_name">FULL NAME</label>

<input type="text" class="form-control" id="form-full_name" placeholder="Insert Full Name" name="dt[full_name]" value="<?= $student_application_form['full_name'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-full_name">NICK NAME</label>

<input type="text" class="form-control" id="form-full_name" placeholder="Insert Nick Name" name="dt[nick_name]" value="<?= $student_application_form['nick_name'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-full_name">EMAIL</label>

<input type="text" class="form-control" id="form-full_name" placeholder="Insert Email" name="dt[email]" value="<?= $student_application_form['email'] ?>">

</div><div class="form-group col-md-6">

<label for="form-full_name">POSITION</label>

<input type="text" class="form-control" id="form-full_name" placeholder="Insert Position" name="dt[position]" value="<?= $student_application_form['position'] ?>">

</div>
<div class="form-group col-md-6">

<label for="form-full_name">REMARK</label>

<input type="text" class="form-control" id="form-full_name" placeholder="Insert Remark" name="dt[remark_instructor]" value="<?= $student_application_form['remark_instructor'] ?>">

</div>


<div class="form-group col-md-12">

<label for="form-remark">COURSE POSITION</label>
<br>
<?php 
$type = json_decode($student_application_form['type'],true);
$data = $this->mymodel->selectWithQuery("SELECT * FROM instructor_type");
foreach($data as $key=>$val){
  $text = ""; 
  foreach($type as $key2=>$val2){
    if($val2[$val['instructor_type']]==$val['instructor_type']){
     $text = "checked";
    }
  }  
?>
<input name="dtt[][<?=$val['instructor_type']?>]" type="checkbox" <?=$text?> value="<?=$val['instructor_type']?>" > <?=$val['instructor_type']?> 
<?php } ?>

</div>
  
  <div class="form-group col-md-12">
  
  <label for="form-file">ATTACHMENT </label>  
  
  <?php

if($file['dir']!=""){ ?>
<a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


<?php } ?>
<input type="file" class="form-control" id="form-file" placeholder="Insert File" name="file">
</div>


  </div></div>


  <div class="col-md-3">

<div class="row">

</div>
</div>
</div>
<div class="box-footer">
<div class="col-md-3">
<div class="row">
<button type="submit" class="btn btn-primary btn-send float-add" data-placement="top" title="SAVE INSTRUCTOR DATA" ><i class="mdi mdi-content-save"></i></button>

<!-- <a class="btn btn-success float-upload" href="#!" data-toggle="modal" data-target="#modal-upload"><i class="mdi mdi-attachment"></i></a> -->

</div>


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

                           window.location.href = "<?= base_url('master/instructor_list') ?>";

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
  
<script>
$(document).ready(function(){
    $('#batch').change(function() {
          var batch = $('#batch').val();

          $("#training").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_training/?batch='+batch,
                  success:function(html){
                    $("#training").html(html);
                  }
              }); 
          }else{
              // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
          }
       
      });

});

</script>


