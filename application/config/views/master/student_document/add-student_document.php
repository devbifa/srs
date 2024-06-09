

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        STUDENT DOCUMENT

        <small>MARKETING</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">STUDENT DOCUMENT</li>

      <li class="active">MARKETING</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Student_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $student_document['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Student Document

              </h5>

            </div>
            -->
            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-6">
                
                <div class="row">
                <div class="form-group col-md-12">

                      <label for="form-medex_valid_date">REGISTRATION DATE</label>

                      <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input autocomplete="off" type="text" class="form-control pull-right tgl" id="datepicker"  placeholder="Masukan Registration Date" name="dt[registration_date]" value="<?= $student_document['registration_date'] ?>">
                </div>


                  </div>
                <div class="form-group col-md-12">

                      <label for="form-student_name">STUDENT NAME</label>

                      <input type="text" class="form-control" id="form-student_name" placeholder="Masukan Student Name" name="dt[student_name]" value="<?= $student_document['student_name'] ?>">

                  </div>
                  <div class="form-group col-md-12">

                      <label for="form-nick_name">NICK NAME</label>

                      <input type="text" class="form-control" id="form-nick_name" placeholder="Masukan Nick Name" name="dt[nick_name]" value="<?= $student_document['nick_name'] ?>">

                  </div>

                  <div class="form-group col-md-12">

                      <label for="form-nick_name">ADDRESS</label>

                      <input type="text" class="form-control" id="form-nick_name" placeholder="Masukan Address" name="dt[address]" value="<?= $student_document['nick_name'] ?>">

                  </div>

                  <div class="form-group col-md-12">

                      <label for="form-nick_name">PHONE NUMBER</label>

                      <input type="text" class="form-control" id="form-nick_name" placeholder="Masukan Phone Number" name="dt[phone_number]" value="<?= $student_document['nick_name'] ?>">

                  </div>

                  <div class="form-group col-md-12">

                      <label for="form-nick_name">EMAIL</label>

                      <input type="text" class="form-control" id="form-nick_name" placeholder="Masukan Email" name="dt[email]" value="<?= $student_document['nick_name'] ?>">

                  </div>
                  <!-- <div class="form-group col-md-12">

                      <label for="form-id_number">ID NUMBER</label>

                      <input type="text" class="form-control" id="form-id_number" placeholder="Masukan Id Number" name="dt[id_number]" value="<?= $student_document['id_number'] ?>">

                  </div> -->
                  <!-- <div class="form-group col-md-12">

                      <label for="form-spl_number">SPL NUMBER</label>

                      <input type="text" class="form-control" id="form-spl_number" placeholder="Masukan Spl Number" name="dt[spl_number]" value="<?= $student_document['spl_number'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-ppl_number">PPL NUMBER</label>

                      <input type="text" class="form-control" id="form-ppl_number" placeholder="Masukan Ppl Number" name="dt[ppl_number]" value="<?= $student_document['ppl_number'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-cpl_number">CPL NUMBER</label>

                      <input type="text" class="form-control" id="form-cpl_number" placeholder="Masukan Cpl Number" name="dt[cpl_number]" value="<?= $student_document['cpl_number'] ?>">

                  </div> -->
                  <!-- <div class="form-group col-md-12">

                      <label for="form-medex_valid_date">MEDEX VALID DATE</label>

                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input autocomplete="off" type="text" class="form-control pull-right tgl" id="datepicker"  placeholder="Masukan Medex Valid Date" name="dt[medex_valid_date]" value="<?= $student_document['medex_valid_date'] ?>">
                      </div>


                  </div>
                  
                  <div class="form-group col-md-12">

                      <label for="form-curriculum">CURRICULUM</label>

                      <input style='width:100%' name="dt[curriculum]" class="form-control" value="<?=$student_document['curriculum']?>">

                    

                  </div>
                   -->
                  <div class="form-group col-md-12">

                      <label for="form-training_requirement">TRAINING REQUIREMENT</label>
                      
                      <div class="table-responsive">
<table class="table table-bordered">
<tr>
<th class="text-left">COURSE
</th>
<th class="text-left">GROUND
</th>
<th class="text-left">FTD
</th>
<th class="text-left">FLIGHT
</th>
</tr>
<?php
$training_requirement = json_decode($student_document['training_requirement'],true);
// print_r($training_requirement);
$attachment = $this->mymodel->selectWithQuery("SELECT * FROM training_requirement");
foreach($attachment as $key=>$val){
?>
<tr>
<td class="text-left">
<?=$val['course']?>
<input name="dtt[<?=$no?>][course]" value="<?=$val['course']?>" type="hidden" style="width:200px;" placeholder="OTHER REQUIREMENT">
</td>
<td class="text-left" style="width:25px;">
<input name="dtt[<?=$no?>][ground]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ground']?>">
</td>
<td class="text-left" style="width:25px;">
<input name="dtt[<?=$no?>][flight]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['flight']?>">
</td>
<td class="text-left" style="width:25px;">
<input name="dtt[<?=$no?>][ftd]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ftd']?>">
</td>
</tr>
<?php 
$no++;
} ?>
<tr>
<td class="text-left">
<input name="dtt[<?=$no?>][course]" type="text" style="width:200px;" placeholder="OTHER REQUIREMENT" value="<?=$training_requirement[$no]['course']?>">
</td>
<td class="text-left" style="width:25px;">
<input name="dtt[<?=$no?>][ground]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ground']?>">
</td>
<td class="text-left" style="width:25px;">
<input name="dtt[<?=$no?>][flight]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['flight']?>">
</td>
<td class="text-left" style="width:25px;">
<input name="dtt[<?=$no?>][ftd]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ftd']?>">
</td>

</tr>
</table>
</div>

                      <!-- <input type="text" class="form-control" id="form-training_requirement" placeholder="Masukan Training Requirement" name="dt[training_requirement]" value="<?= $student_document['training_requirement'] ?>"> -->

                  </div><div class="form-group col-md-12">

                      <label for="form-last_input_date">LAST INPUT DATE</label>

                      <input type="text" class="form-control" id="form-last_input_date" placeholder="Masukan Last Input Date" name="dt[last_input_date]" value="<?= DATE('Y-m-d H:i:s') ?>">

                  </div><div class="form-group col-md-12">
                  
                      <label for="form-file">ATTACHMENT </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                    <div class="row">
                    <div class="col-md-12">
                    <div class="row">
                     <div class="col-md-6">
                      <input type="text" class="form-control" id="form-file" placeholder="Attachment Name" name="text">
                      </div>
                      <div class="col-md-3">
                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">
                      </div>
                      <div class="col-md-3">
                      <input type="submit" class="form-control btn btn-primary" id="form-file" placeholder="Masukan File" name="text" value="INSERT">
                      </div>
                      </div>
                      </div>
                      </div>
                  </div></div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  <div class="form-group col-md-12">
<label for="form-file">ATTACHMENT LIST</label>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th class="text-left">NO.
</th>
<th class="text-left">ATTACHMENT
</th>
<th class="text-left">
ACTION
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
<a href="#!"><?=$val['attachment_type']?></a>
</td>
<td class="text-left" style="width:25px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->
<a href="#!" class="btn btn-danger btn-xs btn-block">DELETE</a>
</td>
</tr>
<?php } ?>
</table>
</div>
</div>
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> SAVE</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> RESET</button>

                <!-- <a href="#!" class="btn btn-success pull-right" ><i class="fa fa-approve"></i> ACTIVATE</a>
                <a href="#!" class="btn btn-warning pull-right" style="margin-right:5px;"><i class="fa fa-approve"></i> DEACTIVED</a>
                <a href="#!" class="btn btn-danger pull-right" style="margin-right:5px;"><i class="fa fa-approve"></i> SHUT DOWN</a> -->

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

                           window.location.href = "<?= base_url('master/student_document/preview/').$student_document['id'] ?>";

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