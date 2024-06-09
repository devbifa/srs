

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

        <div class="col-md-12">
    <form method="POST" action="<?= base_url('master/aircraft_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input disabled type="hidden" name="id" value="<?= $aircraft_document['id'] ?>">


          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                PREVIEW AIRCRAFT 
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
             
                <div class="form-group col-md-3">

<label for="form-model">MODEL</label>

<input type="text" class="form-control" id="form-model" placeholder="Masukan Model" name="dt[model]" value="<?= $aircraft_document['model'] ?>">

</div><div class="form-group col-md-3">

<label for="form-type">TYPE</label>

<input type="text" class="form-control" id="form-type" placeholder="Masukan Type" name="dt[type]" value="<?= $aircraft_document['type'] ?>">

</div><div class="form-group col-md-3">

<label for="form-serial_number">SERIAL NUMBER</label>

<input type="text" class="form-control" id="form-serial_number" placeholder="Masukan Serial Number" name="dt[serial_number]" value="<?= $aircraft_document['serial_number'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-registration">REGISTRATION</label>

<input type="text" class="form-control" id="form-registration" placeholder="Masukan Registration" name="dt[registration]" value="<?= $aircraft_document['registration'] ?>">

</div>

<div class="form-group col-md-12">

<label for="form-serial_number">REMARK</label>

<input type="text" class="form-control" id="form-serial_number" placeholder="Masukan Remark" name="dt[remark]" value="<?= $aircraft_document['remark'] ?>">

</div>
<div class="form-group col-md-12">

<label for="form-file">ATTACHMENT </label>  

<?php

if($file['dir']!=""){ ?>
<a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


<?php } ?>


<input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

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
            <!-- <a href="#!" data-toggle="modal" data-target="#modal-active" class="btn btn-success  pull-right float-active"><i class="mdi mdi-checkbox-marked-circle-outline" ></i></a>
            
            <a href="#!" data-toggle="modal" data-target="#modal-hold" class="btn btn-warning  pull-right float-4"><i class="mdi mdi-minus-circle-outline" ></i></a>
            
            <a href="#!" data-toggle="modal" data-target="#modal-terminated" class="btn btn-danger  pull-right float-terminated"><i class="mdi mdi-close-circle-outline" ></i></a> -->
         

            
            <a href="<?=base_url()?>master/aircraft_document/edit/<?=$aircraft_document['id']?>" class="btn btn-primary  pull-right float-add"><i class="mdi mdi-pencil" ></i></a>
                
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
		  
		  
		  
		  
		  <div class="col-md-4">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                ADD HOURS HISTORY
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
<th class="text-left">DMR CODE
</th>
<th class="text-left">DATE
</th>
<th class="text-left">HOURS
</th>
</tr>
<?php
$attachment = array();
$attachment[0]['dmr_code'] = "DMR-001";
$attachment[1]['dmr_code'] = "DMR-002";
$attachment[2]['dmr_code'] = "DMR-003";
foreach($attachment as $key=>$val){
  // $key = 50;
  $total = $total + 50;
?>
<tr>
<td class="text-left" style="width:25px;">
<?=$key+1?>
</td>
<td class="text-left">
<a href="<?=base_url()?>webfile/example.pdf" target="_blank"><?=$val['dmr_code']?></a>
</td>
<td class="text-left">
2020-12-12
</td>
<td class="text-right">
<?=50?>
</td>

</tr>
<?php } ?>
<tr>
<td class="text-left" colspan="3">
TOTAL HOURS
<td class="text-right">
<?=$total?>
</td>

</tr>
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


          <div class="col-md-4">

<div class="box">

<div class="box-header-material box-header-material-text">
      <div class="row">
      <div class="col-xs-10">
      AIRCRAFT HOURS
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
<th class="text-left">DATE
</th>
<th class="text-left">HOURS
</th>
</tr>
<?php
$total = 0;
$attachment = array();
for($i=0;$i < 7; $i++){
  $attachment[$i]['dmr_code'] = "DMR-00".$i+1;
  $attachment[$i]['hours'] = 20;
}
foreach($attachment as $key=>$val){
$total = $total + $val['hours'];
?>
<tr>
<td class="text-left" style="width:25px;">
<?=$key+1?>
</td>

<td class="text-left">
2020-12-12
</td>
<td class="text-right">
<?=$val['hours']?>
</td>

</tr>
<?php } ?>
<tr>
<td class="text-left" colspan="2">
TOTAL HOURS
<td class="text-right">
<?=$total?>
</td>

</tr>
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
		  
		  <div class="col-md-4">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                MAINTENANCE
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
<th class="text-left">SPAREPART NAME
</th>
<th class="text-left">DATE
</th>
<th class="text-left">QTY
</th>
</tr>
<?php
$attachment = array();
$attachment[0]['sparepart_name'] = "Mur A";
$attachment[1]['sparepart_name'] = "Mur B";
$attachment[2]['sparepart_name'] = "Mur C";
foreach($attachment as $key=>$val){
?>
<tr>
<td class="text-left" style="width:25px;">
<?=$key+1?>
</td>
<td class="text-left">
<a href="<?=base_url()?>webfile/example.pdf" target="_blank"><?=$val['sparepart_name']?></a>
</td>
<td class="text-left">
2020-12-12
</td>
<td class="text-left">
<?=($key+1)*2?>
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

                           window.location.href = "<?= base_url('master/aircraft_document/preview/'.$aircraft_document['id']) ?>";

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