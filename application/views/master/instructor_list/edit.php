

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        STUDENT APPLICATION FORM

        <small>EDIT  BY MARKETING</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">STUDENT APPLICATION FORM</li>

      <li class="active">EDIT BY MARKETING</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">


      <div class="row">

        <div class="col-md-4">
    <form method="POST" action="<?= base_url('master/instructor_list/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $student_application_form['id'] ?>">


          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT INSTRUCTOR
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

                      <label for="form-application_number">EMPLOYEE NUMBER</label>

                      <input type="text" class="form-control" id="form-application_number" placeholder="Insert Employee Number" name="dt[id_number]" value="<?= $student_application_form['id_number'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-full_name">FULL NAME</label>

                      <input type="text" class="form-control" id="form-full_name" placeholder="Insert Full Name" name="dt[full_name]" value="<?= $student_application_form['full_name'] ?>">

                  </div>
                  <div class="form-group col-md-12">

                      <label for="form-full_name">NICK NAME</label>

                      <input type="text" class="form-control" id="form-full_name" placeholder="Insert Nick Name" name="dt[nick_name]" value="<?= $student_application_form['nick_name'] ?>">

                  </div>
                  <div class="form-group col-md-12">

                      <label for="form-full_name">EMAIL</label>

                      <input type="text" class="form-control" id="form-full_name" placeholder="Insert Email" name="dt[email]" value="<?= $student_application_form['email'] ?>">

                  </div>
                  <div class="form-group col-md-12">

<label for="form-full_name">POSITION</label>

<input type="text" class="form-control" id="form-full_name" placeholder="Insert Position" name="dt[position]" value="<?= $student_application_form['position'] ?>">

</div>
                  <div class="form-group col-md-12">

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



                  </div></div>
  
 
                  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-6">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-add" data-placement="top" title="SAVE INSTRUCTOR DATA" ><i class="mdi mdi-content-save"></i></button>

                <!-- <a class="btn btn-success float-upload" href="#!" data-toggle="modal" data-target="#modal-upload" data-placement="top" title="UPLOAD ATTACHMENT INSTRUCTOR DATA" ><i class="mdi mdi-attachment"></i></a> -->

                </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>
  
          </form>
          <!-- /.box -->



          <!-- /.box -->

          </div>
		
          </div>
		  
		  <div class="col-md-8">

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
<th class="text-left" rowspan="2" >NO.
</th>
<th class="text-left" rowspan="2" >ATTACHMENT NAME
</th>
<th colspan="2">VALID DATE
</th>
<th rowspan="2">REMARK
</th>
<th class="text-left"   rowspan="2" style="width:105px;">
</th>
</tr>
<tr>
  <th style="width:100px;" >START
  </th>
  <th style="width:100px;" >UNTIL
  </th>
</tr>
<?php
$attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM instructor_file WHERE status = 'ENABLE' ORDER BY number ASC");
$att = json_decode($student_application_form['attachment'],true);

$i = 0;

$price = array();
// foreach ($attachment_list as $key => $row)
// {
//     $price[$key] = $row['number'];
// }
array_multisort($price, SORT_ASC, $attachment_list);
// print_r($attachment_list);

foreach($attachment_list as $key=>$val){
 
    // echo $val['number'];
    // $data = $this->mymodel->selectDataOne('instructor_file',array('id'=>$val['type']));
    
?>
<tr>
<td class="text-left" style="width:25px;" >
<?=$i+1?>
</td>
<td class="text-left">
<?=$val['instructor_file']?>
</td>
<td>
<?=$this->template->date_indo(($att[$val['id']]['valid_date_start']))?>
</td>

<td>
<?=$this->template->date_indo(($att[$val['id']]['valid_date_until']))?>
</td>
<td class="text-left">
<?=(($att[$val['id']]['description']))?>
</td>
<td class="text-left" style="width:70px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-<?=$i?>"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-<?=$i?>"><i class="mdi mdi-delete"></i></a>

<?php

if($att[$val['id']]['file']){ ?>
<a href="<?=base_url()?>webfile/student_file/<?=$att[$val['id']]['file']?>" target="_blank" class="btn btn-delete btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
<?php } ?>

  
<div class="modal modal-success fade" id="modal-upload-<?=$i?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE ATTACHMENT FILE</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/instructor_list/update_file/<?=$student_application_form['id']?>/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Attachment Type</label>
                <input readonly autocomplete="off" required required type="text" class="form-control" name="dtt[type]" value="<?=$val['instructor_file']?>">
            </div>
<div class="form-group">
                <label>Valid Date Start</label>
                <input autocomplete="off" required required type="hidden" class="form-control" name="dtt[id]" value="<?=$val['id']?>">
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_start]" value="<?=$att[$val['id']]['valid_date_start']?>">
                </div>
                <div class="form-group">
                <label>Valid Date Until</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_until]" value="<?=$att[$val['id']]['valid_date_until']?>">
                </div>
<!-- <div class="form-group">
                <label>Attachment Number</label>
                <input autocomplete="off" requiredrequired type="text" class="form-control" name="dtt[number]" value="<?=$val['number']?>">
                </div> -->
                <div class="form-group">
                <label>Description</label>
                <input autocomplete="off" required required type="text" class="form-control" name="dtt[description]" value="<?=$att[$val['id']]['description']?>">
                </div>
<div class="form-group">
                <label>Attachment File</label> *empty if not updated.
                <input type="file" class="form-control" name="file">
</div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Upload File</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

       
<div class="modal modal-danger fade" id="modal-delete-<?=$i?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE ATTACHMENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this file?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/instructor_list/delete_file/<?=$student_application_form['id']?>/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
</td>
</tr>

<?php 
$i++;
} ?>
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

     
      <div class="modal modal-success fade" id="modal-upload">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPLOAD ATTACHMENT FILE</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/instructor_list/upload_file/<?=$student_application_form['id']?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Attachment Type</label>
                <select required style="width:100%;" class="select2" name="dtt[type]">
<option value="">SELECT ATTACHMENT
</option>
<?php foreach($attachment as $key2=>$val2){ ?>
<option value="<?=$val2['id']?>"><?=$val2['instructor_file']?>
</option>
<?php } ?>
</select>    
            </div>
<div class="form-group">
                <label>Valid Date Start</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_start]">
                </div>
<div class="form-group">
                <label>Valid Date Until</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_until]">
                </div>
<div class="form-group">
                <label>Attachment Number</label>
                <input autocomplete="off" requiredrequired type="text" class="form-control" name="dtt[number]">
                </div>
                <div class="form-group">
                <label>Description</label>
                <input autocomplete="off" required required type="text" class="form-control" name="dtt[description]">
                </div>
<div class="form-group">
                <label>Attachment File</label>
                <input required type="file" class="form-control" name="file">
</div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Upload File</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>



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


