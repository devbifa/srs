

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

        <div class="col-md-6">
    <form method="POST" action="<?= base_url('master/Student_application_form/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input disabled type="hidden" name="id" value="<?= $student_application_form['id'] ?>">


          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                PREVIEW RINDAM
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

                      <label for="form-registration_date">REGISTRATION DATE</label>
              
                        <input disabled autocomplete="off" type="text" class="form-control pull-right tgl" id="datepicker"  name="dt[registration_date]" value="<?= $student_application_form['registration_date'] ?>">
                 
                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-application_number">APPLICATION NUMBER</label>

                      <input disabled type="text" class="form-control" id="form-application_number" placeholder="Insert Application Number" name="dt[application_number]" value="<?= $student_application_form['application_number'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-full_name">FULL NAME</label>

                      <input disabled type="text" class="form-control" id="form-full_name" placeholder="Insert Full Name" name="dt[full_name]" value="<?= $student_application_form['full_name'] ?>">

                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-full_name">NICK NAME</label>

                      <input disabled type="text" class="form-control" id="form-full_name" placeholder="Insert Nick Name" name="dt[nick_name]" value="<?= $student_application_form['full_name'] ?>">

                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-place_of_birth">PLACE OF BIRTH</label>

                      <input disabled type="text" class="form-control" id="form-place_of_birth" placeholder="Insert Place Of Birth" name="dt[place_of_birth]" value="<?= $student_application_form['place_of_birth'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-gender">GENDER</label>

                      <input disabled type="text" class="form-control" id="form-gender" placeholder="Insert Gender" name="dt[gender]" value="<?= $student_application_form['gender'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-identity_card_no">IDENTITY CARD NO</label>

                      <input disabled type="text" class="form-control" id="form-identity_card_no" placeholder="Insert Identity Card No" name="dt[identity_card_no]" value="<?= $student_application_form['identity_card_no'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-date_of_birth">DATE OF BIRTH</label>
                        <input disabled autocomplete="off" type="text" class="form-control pull-right tgl" id="datepicker"  name="dt[date_of_birth]" value="<?= $student_application_form['date_of_birth'] ?>">
                      
                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-weight">WEIGHT</label>

                      <input disabled type="text" class="form-control" id="form-weight" placeholder="Insert Weight" name="dt[weight]" value="<?= $student_application_form['weight'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-height">HEIGHT</label>

                      <input disabled type="text" class="form-control" id="form-height" placeholder="Insert Height" name="dt[height]" value="<?= $student_application_form['height'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-address">ADDRESS</label>

                      <input disabled type="text" class="form-control" id="form-address" placeholder="Insert Address" name="dt[address]" value="<?= $student_application_form['address'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-city">CITY</label>

                      <input disabled type="text" class="form-control" id="form-city" placeholder="Insert City" name="dt[city]" value="<?= $student_application_form['city'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-zip_code">ZIP CODE</label>

                      <input disabled type="text" class="form-control" id="form-zip_code" placeholder="Insert Zip Code" name="dt[zip_code]" value="<?= $student_application_form['zip_code'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-domicile_address">DOMICILE ADDRESS</label>

                      <input disabled type="text" class="form-control" id="form-domicile_address" placeholder="Insert Domicile Address" name="dt[domicile_address]" value="<?= $student_application_form['domicile_address'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-domicile_city">DOMICILE CITY</label>

                      <input disabled type="text" class="form-control" id="form-domicile_city" placeholder="Insert Domicile City" name="dt[domicile_city]" value="<?= $student_application_form['domicile_city'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-domicile_zip">DOMICILE ZIP</label>

                      <input disabled type="text" class="form-control" id="form-domicile_zip" placeholder="Insert Domicile Zip" name="dt[domicile_zip]" value="<?= $student_application_form['domicile_zip'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-home_telephone_number">HOME TELEPHONE NUMBER</label>

                      <input disabled type="text" class="form-control" id="form-home_telephone_number" placeholder="Insert Home Telephone Number" name="dt[home_telephone_number]" value="<?= $student_application_form['home_telephone_number'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-mobile_phone_number">MOBILE PHONE NUMBER</label>

                      <input disabled type="text" class="form-control" id="form-mobile_phone_number" placeholder="Insert Mobile Phone Number" name="dt[mobile_phone_number]" value="<?= $student_application_form['mobile_phone_number'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-marital_status">MARITAL STATUS</label>

                      <input disabled type="text" class="form-control" id="form-marital_status" placeholder="Insert Marital Status" name="dt[marital_status]" value="<?= $student_application_form['marital_status'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-email">EMAIL</label>

                      <input disabled type="text" class="form-control" id="form-email" placeholder="Insert Email" name="dt[email]" value="<?= $student_application_form['email'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-religion">RELIGION</label>

                      <input disabled type="text" class="form-control" id="form-religion" placeholder="Insert Religion" name="dt[religion]" value="<?= $student_application_form['religion'] ?>">

                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-nationality">NATIONALITY</label>

                      <input disabled type="text" class="form-control" id="form-nationality" placeholder="Insert Nationality" name="dt[nationality]" value="<?= $student_application_form['nationality'] ?>">

                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-nationality">T-SHIRT SIZE</label>

                      <input disabled type="text" class="form-control" id="form-nationality" placeholder="Insert T-Shirt Size" name="dt[t_shirt_size]" value="<?= $student_application_form['t_shirt_size'] ?>">

                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-nationality">SHOES SIZE</label>

                      <input disabled type="text" class="form-control" id="form-nationality" placeholder="Insert Shoes Size" name="dt[shoes_size]" value="<?= $student_application_form['shoes_size'] ?>">

                  </div>

                  
<div class="form-group col-md-6">

<label for="form-id_number">ID NUMBER</label>

<input disabled type="text" class="form-control" id="form-id_number" placeholder="Masukan Id Number" name="dt[id_number]" value="<?= $student_document['id_number'] ?>">

</div><div class="form-group col-md-6">

<label for="form-spl_number">SPL NUMBER</label>

  <input disabled type="text" class="form-control" id="form-spl_number" placeholder="Masukan Spl Number" name="dt[spl_number]" value="<?= $student_document['spl_number'] ?>">

</div><div class="form-group col-md-6">

<label for="form-ppl_number">PPL NUMBER</label>

<input disabled type="text" class="form-control" id="form-ppl_number" placeholder="Masukan Ppl Number" name="dt[ppl_number]" value="<?= $student_document['ppl_number'] ?>">

</div><div class="form-group col-md-6">

<label for="form-cpl_number">CPL NUMBER</label>

<input disabled type="text" class="form-control" id="form-cpl_number" placeholder="Masukan Cpl Number" name="dt[cpl_number]" value="<?= $student_document['cpl_number'] ?>">

</div>
<div class="form-group col-md-6">

<label for="form-medex_valid_date">MEDEX VALID DATE</label>

<input disabled type="text" class="form-control tgl" id="form-medex_valid_date" placeholder="Masukan Medex Valid Date" name="dt[medex_valid_date]" value="<?= $student_document['medex_valid_date'] ?>">

</div>

<div class="form-group col-md-6">

<label for="form-curriculum">REMARK</label>

<input disabled style='width:100%' name="dt[remark]" class="form-control" value="<?=$student_document['remark']?>">



</div>


                  <div class="form-group col-md-12">

<label for="form-nationality">BATCH</label>

<select disabled style='width:100%' name="dt[batch]" class="form-control select2">
<option value=''>SELECT BATCH</option>
<?php 

$curriculum = $this->mymodel->selectWithQuery("SELECT a.*, b.curriculum FROM batch a LEFT JOIN curriculum b ON a.curriculum = b.id");

foreach ($curriculum as $curriculum_record) {

  $text="";

  if($curriculum_record['id']==$student_application_form['batch']){

    $text = "selected";

  }



  echo "<option value='".$curriculum_record['id']."' ".$text." >".$curriculum_record['batch'].' - '.$curriculum_record['curriculum']."</option>";

}

?>

</select>
</div>
                  <div class="form-group col-md-12">

<label for="form-training_requirement">TRAINING REQUIREMENT COURSE</label>
    
    <div class="table-responsive">
<table class="table table-bordered">
<tr>
<th class="text-left">
</th>
<th class="text-left">COURSE
</th>
<th class="text-left">
</th>
<th class="text-left">GROUND
</th>
<th class="text-left">
</th>
<th class="text-left">FTD
</th>
<th class="text-left">
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
<td style="width:10px;"><input disabled type="checkbox" checked ></td>
<td class="text-left">
<?=$val['course']?>
<input disabled name="dtt[<?=$no?>][course]" value="<?=$val['course']?>" type="hidden" style="width:200px;" placeholder="OTHER REQUIREMENT">
</td>
<td style="width:10px;"><input disabled type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input disabled  name="dtt[<?=$no?>][ground]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ground']?>">
</td>
<td style="width:10px;"><input disabled type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input disabled  name="dtt[<?=$no?>][flight]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['flight']?>">
</td>
<td style="width:10px;"><input disabled type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input disabled   name="dtt[<?=$no?>][ftd]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ftd']?>">
</td>
</tr>
<?php 
$no++;
} ?>
<tr>
<td></td>
<td class="text-left">
<input disabled name="dtt[<?=$no?>][course]" type="text" style="width:200px;" placeholder="OTHER REQUIREMENT" value="<?=$training_requirement[$no]['course']?>">
</td>
<td style="width:10px;"><input disabled type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input disabled   name="dtt[<?=$no?>][ground]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ground']?>">
</td>
<td style="width:10px;"><input disabled type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input disabled  name="dtt[<?=$no?>][flight]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['flight']?>">
</td>
<td style="width:10px;"><input disabled type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input disabled  name="dtt[<?=$no?>][ftd]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ftd']?>">
</td>

</tr>
</table>
</div>

    <!-- <input disabled type="text" class="form-control" id="form-training_requirement" placeholder="Insert Training Requirement" name="dt[training_requirement]" value="<?= $student_document['training_requirement'] ?>"> -->

</div>

                 


                  
                  <div class="form-group col-md-12">
                  
                  <label for="form-file">ATTACHMENT </label>  
                  
                  <?php

              if($file['dir']!=""){ ?>
                <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


            <?php } ?>
            <input disabled type="file" class="form-control" id="form-file" placeholder="Insert File" name="file">
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
<a class="btn btn-danger float-upload" href="#!" data-toggle="modal" data-target="#modal-reject-rindam"><i class="mdi mdi-close"></i></a>

<a class="btn btn-success float-add" href="#!" data-toggle="modal" data-target="#modal-approve-rindam"><i class="mdi mdi-check"></i></a>


        </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

          </div>
		   </form>
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

                           window.location.href = "<?= base_url('master/student_application_form') ?>";

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