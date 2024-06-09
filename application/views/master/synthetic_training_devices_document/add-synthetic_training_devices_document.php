

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        SYNTHETIC TRAINING DEVICES DOCUMENT

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">SYNTHETIC TRAINING DEVICES DOCUMENT</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/synthetic_training_devices_document/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">
          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                NEW FTD/AATD LIST
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

                      <label for="form-type">TYPE</label>

                      <input type="text" class="form-control" id="form-type" placeholder="Fill Type" name="dt[type]" value="<?= $synthetic_training_devices_document['type'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-model">MODEL</label>

                      <input type="text" class="form-control" id="form-model" placeholder="Fill Model" name="dt[model]" value="<?= $synthetic_training_devices_document['model'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-serial_number">SERIAL NUMBER</label>

                      <input type="text" class="form-control" id="form-serial_number" placeholder="Fill Serial Number" name="dt[serial_number]" value="<?= $synthetic_training_devices_document['serial_number'] ?>">

                  </div>
                  <div class="form-group col-md-3">

<label for="form-serial_number">CODE</label>

<input type="text" class="form-control" id="form-serial_number" placeholder="Fill Serial Number" name="dt[code]" value="<?= $synthetic_training_devices_document['code'] ?>">

</div>
                  <div class="form-group col-md-3">

                      <label for="form-certificate_number">CERTIFICATE NUMBER</label>

                      <input type="text" class="form-control" id="form-certificate_number" placeholder="Fill Certificate Number" name="dt[certificate_number]" value="<?= $synthetic_training_devices_document['certificate_number'] ?>">

                  </div>
                  <div class="form-group col-md-3">

<label for="form-certificate_valid">VALID FROM</label>

<input autocomplete="off" type="text" class="form-control tgl" id="form-certificate_valid" placeholder="Fill From" name="dt[certificate_valid]" value="<?= $synthetic_training_devices_document['certificate_valid'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-certificate_valid">VALID UNTIL</label>

<input autocomplete="off" type="text" class="form-control tgl" id="form-certificate_valid" placeholder="Fill Until" name="dt[certificate_valid_until]" value="<?= $synthetic_training_devices_document['certificate_valid_until'] ?>">

</div>
                  <div class="form-group col-md-3">

<label for="form-type">CAPABILITY</label>


<select style='width:100%' name="dt[type_enginee]" class="form-control select2">

<?php 

$curriculum = $this->mymodel->selectWhere('aircraft_type',null);

foreach ($curriculum as $curriculum_record) {

$text="";

if($curriculum_record['aircraft_type']==$synthetic_training_devices_document['type_enginee']){

$text = "selected";

}



echo "<option value='".$curriculum_record['aircraft_type']."' ".$text." >".$curriculum_record['aircraft_type']."</option>";

}

?>

</select>


</div>
                  <div class="form-group col-md-3">

                      <label for="form-training_capabilities">TRAINING CAPABILITIES</label>

                      <input type="text" class="form-control" id="form-training_capabilities" placeholder="Fill Training Capabilities" name="dt[training_capabilities]" value="<?= $synthetic_training_devices_document['training_capabilities'] ?>">

                  </div><div class="form-group col-md-3">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

                  </div></div></div>
  
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1" data-placement="top" title="SAVE FTD/AATD DATA"  ><i class="mdi mdi-content-save"></i></button>



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

                    $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/synthetic_training_devices_document') ?>";

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