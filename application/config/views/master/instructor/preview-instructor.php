

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        STUDENT ACTIVE

        <small>EDIT  BY MARKETING</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">STUDENT ACTIVE</li>

      <li class="active">EDIT BY MARKETING</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">


      <div class="row">

        <div class="col-md-6">
    <!-- <form method="POST" action="<?= base_url('master/Instructor/update') ?>" id="upload-create" enctype="multipart/form-data"> -->

    <input disabled  type="hidden" name="id" value="<?= $instructor['id'] ?>">


          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                PREVIEW BIFA INSTRUCTOR
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
                <div class="form-group col-md-12">

                      <label for="form-instructor_name">INSTRUCTOR NAME</label>

                      <input disabled  type="text" class="form-control" id="form-instructor_name" placeholder="Masukan Instructor Name" name="dt[instructor_name]" value="<?= $instructor['instructor_name'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-nick_name">NICK NAME</label>

                      <input disabled  type="text" class="form-control" id="form-nick_name" placeholder="Masukan Nick Name" name="dt[nick_name]" value="<?= $instructor['nick_name'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-employee_number">EMPLOYEE NUMBER</label>

                      <input disabled  type="text" class="form-control" id="form-employee_number" placeholder="Masukan Employee Number" name="dt[employee_number]" value="<?= $instructor['employee_number'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-remark">REMARK</label>

                      <input disabled  type="text" class="form-control" id="form-remark" placeholder="Masukan Remark" name="dt[remark]" value="<?= $instructor['remark'] ?>">

                  </div>

                  <div class="form-group col-md-12">

<label for="form-remark">COURSE POSITION</label>
<br>
<?php 
$type = json_decode($instructor['type'],true);
$data = $this->mymodel->selectWithQuery("SELECT * FROM instructor_type");
foreach($data as $key=>$val){
  $text = ""; 
  foreach($type as $key2=>$val2){
    if($val2[$val['instructor_type']]==$val['instructor_type']){
     $text = "checked";
    }
  }  
?>
<input disabled name="dtt[][<?=$val['instructor_type']?>]" type="checkbox" <?=$text?> value="<?=$val['instructor_type']?>" > <?=$val['instructor_type']?> 
<?php } ?>

</div>

                  
                  <div class="form-group col-md-12">
                  
                  <label for="form-file">ATTACHMENT </label>  
                  
                  <?php

              if($file['dir']!=""){ ?>
                <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


            <?php } ?>
            <input disabled  type="file" class="form-control" id="form-file" placeholder="Insert File" name="file">
              </div>


                  </div></div>
  
 
                  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-6">
            <div class="row">
                <a href="<?=base_url()?>master/instructor/edit/<?=$instructor['id']?>" class="btn btn-primary btn-send float-add" ><i class="mdi mdi-pencil"></i></a>

 </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

          </div>
		   <!-- </form> -->
          </div>
		  
		  <div class="col-md-6">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                ATTACHMENT LIST
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-body">

   
                <div class="row">
               
 
                  <div class="col-md-12">
  
  <div class="row">
  <div class="form-group col-md-12">
<!-- <label for="form-file">ATTACHMENT LIST</label> -->
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th class="text-left">NO.
</th>
<th class="text-left">ATTACHMENT NAME
</th>
<th class="text-left">EXPIRED DATE
</th>
<th class="text-left">

<!-- <a href="#!" class="btn btn-primary btn-xs btn-block">ADD</a> -->
</th>
</tr>
<?php
$attachment = $this->mymodel->selectWithQuery("SELECT * FROM attachment_type WHERE status = 'ENABLE'");
foreach($attachment as $key=>$val){
?>
<tr>
<td class="text-left" style="width:25px;">
<?=$key+1?>
</td>
<td class="text-left">
<a href="<?=base_url()?>webfile/example.pdf" target="_blank"><?=$val['attachment_type']?></a>
</td>
<td class="text-left">
2020-12-12
</td>
<td class="text-left" style="width:25px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete"><i class="mdi mdi-delete"></i></a>
</td>
</tr>
<?php } ?>
</table>
</div>
</div>
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

                           window.location.href = "<?= base_url('master/instructor/preview/'.$instructor['id']) ?>";

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