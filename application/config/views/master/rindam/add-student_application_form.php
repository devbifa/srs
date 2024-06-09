

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

    <form method="POST" action="<?= base_url('master/student_application_form/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Tambah Student Application Form

              </h5>
            </div>
            -->

            <div class="box-body">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-12">
                
  <div class="row">
                <div class="form-group col-md-3">

  <label for="form-registration_date">REGISTRATION DATE</label>
                 
                        <input autocomplete="off" autocomplete="off" type="text" class="form-control pull-right tgl" id="datepicker"  name="dt[registration_date]" value="<?= DATE('Y-m-d') ?>">
                    
                      
                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-application_number">APPLICATION NUMBER</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-application_number" placeholder="Masukan Application Number" name="dt[application_number]">

                  </div><div class="form-group col-md-3">

                      <label for="form-full_name">FULL NAME</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-full_name" placeholder="Masukan Full Name" name="dt[full_name]">

                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-full_name">NICK NAME</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-full_name" placeholder="Masukan Nick Name" name="dt[nick_name]">

                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-place_of_birth">PLACE OF BIRTH</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-place_of_birth" placeholder="Masukan Place Of Birth" name="dt[place_of_birth]">

                  </div><div class="form-group col-md-3">

                      <label for="form-gender">GENDER</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-gender" placeholder="Masukan Gender" name="dt[gender]">

                  </div><div class="form-group col-md-3">

                      <label for="form-identity_card_no">IDENTITY CARD NO</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-identity_card_no" placeholder="Masukan Identity Card No" name="dt[identity_card_no]">

                  </div><div class="form-group col-md-3">

  <label for="form-date_of_birth">DATE OF BIRTH</label>
                  
                        <input autocomplete="off" autocomplete="off" type="text" class="form-control pull-right tgl" id="datepicker"  name="dt[date_of_birth]" value="<?= DATE('Y-m-d') ?>">
                    
                      
                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-weight">WEIGHT</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-weight" placeholder="Masukan Weight" name="dt[weight]">

                  </div><div class="form-group col-md-3">

                      <label for="form-height">HEIGHT</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-height" placeholder="Masukan Height" name="dt[height]">

                  </div><div class="form-group col-md-3">

                      <label for="form-address">ADDRESS</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-address" placeholder="Masukan Address" name="dt[address]">

                  </div><div class="form-group col-md-3">

                      <label for="form-city">CITY</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-city" placeholder="Masukan City" name="dt[city]">

                  </div><div class="form-group col-md-3">

                      <label for="form-zip_code">ZIP CODE</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-zip_code" placeholder="Masukan Zip Code" name="dt[zip_code]">

                  </div><div class="form-group col-md-3">

                      <label for="form-domicile_address">DOMICILE ADDRESS</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-domicile_address" placeholder="Masukan Domicile Address" name="dt[domicile_address]">

                  </div><div class="form-group col-md-3">

                      <label for="form-domicile_city">DOMICILE CITY</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-domicile_city" placeholder="Masukan Domicile City" name="dt[domicile_city]">

                  </div><div class="form-group col-md-3">

                      <label for="form-domicile_zip">DOMICILE ZIP</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-domicile_zip" placeholder="Masukan Domicile Zip" name="dt[domicile_zip]">

                  </div><div class="form-group col-md-3">

                      <label for="form-home_telephone_number">HOME TELEPHONE NUMBER</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-home_telephone_number" placeholder="Masukan Home Telephone Number" name="dt[home_telephone_number]">

                  </div><div class="form-group col-md-3">

                      <label for="form-mobile_phone_number">MOBILE PHONE NUMBER</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-mobile_phone_number" placeholder="Masukan Mobile Phone Number" name="dt[mobile_phone_number]">

                  </div><div class="form-group col-md-3">

                      <label for="form-marital_status">MARITAL STATUS</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-marital_status" placeholder="Masukan Marital Status" name="dt[marital_status]">

                  </div><div class="form-group col-md-3">

                      <label for="form-email">EMAIL</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-email" placeholder="Masukan Email" name="dt[email]">

                  </div><div class="form-group col-md-3">

                      <label for="form-religion">RELIGION</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-religion" placeholder="Masukan Religion" name="dt[religion]">

                  </div><div class="form-group col-md-3">

                      <label for="form-nationality">NATIONALITY</label>

                      <input autocomplete="off" type="text" class="form-control" id="form-nationality" placeholder="Masukan Nationality" name="dt[nationality]">

                  </div>
                  <div class="form-group col-md-3">

<label for="form-nationality">T-SHIRT SIZE</label>

<input type="text" class="form-control" id="form-nationality" placeholder="Insert T-Shirt Size" name="dt[t_shirt_size]" value="<?= $student_application_form['t_shirt_size'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-nationality">SHOES SIZE</label>

<input type="text" class="form-control" id="form-nationality" placeholder="Insert Shoes Size" name="dt[shoes_size]" value="<?= $student_application_form['shoes_size'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-nationality">BATCH</label>

<select style='width:100%' name="dt[batch]" class="form-control select2">
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
<div class="form-group col-md-9">

                      <label for="form-file">ATTACHMENT</label>

                      <input autocomplete="off" type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

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
<td style="width:10px;"><input autocomplete="off" type="checkbox" checked ></td>
<td class="text-left">
<?=$val['course']?>
<input autocomplete="off" name="dtt[<?=$no?>][course]" value="<?=$val['course']?>" type="hidden" style="width:200px;" placeholder="OTHER REQUIREMENT">
</td>
<td style="width:10px;"><input autocomplete="off" type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input autocomplete="off"  name="dtt[<?=$no?>][ground]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ground']?>">
</td>
<td style="width:10px;"><input autocomplete="off" type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input autocomplete="off"  name="dtt[<?=$no?>][flight]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['flight']?>">
</td>
<td style="width:10px;"><input autocomplete="off" type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input autocomplete="off"   name="dtt[<?=$no?>][ftd]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ftd']?>">
</td>
</tr>
<?php 
$no++;
} ?>
<tr>
<td></td>
<td class="text-left">
<input autocomplete="off" name="dtt[<?=$no?>][course]" type="text" style="width:200px;" placeholder="OTHER REQUIREMENT" value="<?=$training_requirement[$no]['course']?>">
</td>
<td style="width:10px;"><input autocomplete="off" type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input autocomplete="off"   name="dtt[<?=$no?>][ground]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ground']?>">
</td>
<td style="width:10px;"><input autocomplete="off" type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input autocomplete="off"  name="dtt[<?=$no?>][flight]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['flight']?>">
</td>
<td style="width:10px;"><input autocomplete="off" type="checkbox" checked ></td>
<td class="text-left" style="width:25px;">
<input autocomplete="off"  name="dtt[<?=$no?>][ftd]" type="text" style="width:75px;" placeholder="HH:mm" value="<?=$training_requirement[$no]['ftd']?>">
</td>

</tr>
</table>
</div>

    <!-- <input autocomplete="off" type="text" class="form-control" id="form-training_requirement" placeholder="Masukan Training Requirement" name="dt[training_requirement]" value="<?= $student_document['training_requirement'] ?>"> -->

</div>
                  </div></div>
  

  </div>
            <div class="">
            <div class="">
            <div class="">
                <button type="submit" class="btn btn-primary btn-send float-add" ><i class="mdi mdi-content-save"></i></button>

                <!-- <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> RESET</button> -->

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

                    $(".btn-send").addClass("").html("<i class='fa fa-spinner fa-spin'></i>").attr('',true);

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

                        $(".btn-send").removeClass("").html('<i class="mdi mdi-content-save"></i>').attr('',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("").html('<i class="mdi mdi-content-save"></i>').attr('',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("").html('<i class="mdi mdi-content-save"></i>').attr('',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>