<?php
$uri = $this->uri->segment(4);
$curriculum = $this->mymodel->selectDataOne('curriculum',array('code'=>$uri));

?>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

      CURRICULUM : <?=$curriculum['curriculum']?>

      <?php $curriculum_id = $curriculum['code']?>

        <small>CREATE MISSION</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


      <li class="#">CURRICULUM</li>
        <li class="#">COURSE</li>
        <li class="#">TPM SYLLABUS ALL COURSE</li>

        <li class="active">CREATE MISSION</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/tpm_syllabus_all_course/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Tambah Tpm Syllabus All Course

              </h5>
            </div>
            -->

            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                <?php
                  $a = $this->uri->segment(6);
                  $a = $this->mymodel->selectDataOne('type_of_training',array('type_of_training'=>$a));
                ?>
                <?=($curriculum['curriculum'])?> > COURSE >  <?=$a['type_of_training']?> > CREATE
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



                <div class="form-group col-md-3 ">

                      <label for="form-curriculum">CURRICULUM</label>

                      <select style='width:100%' name="dt[curriculum]" class="form-control select2">

                        <?php 

                        $curriculum = $this->mymodel->selectWhere('curriculum',array('id'=>$curriculum['id']));

                        foreach ($curriculum as $curriculum_record) {

                          echo "<option value='".$curriculum_record['code']."' >".$curriculum_record['curriculum']."</option>";

                        }

                        ?>

                      </select>

                  </div>
                  <div class="form-group col-md-3 ">

                      <label for="form-course">COURSE</label>

                      <select style='width:100%' name="dt[course]" class="form-control select2">

                        <?php 

                        $course = $this->mymodel->selectWhere('course',array('id'=> $course['id']));

                        foreach ($course as $course_record) {

                          echo "<option value='".$course_record['code']."' >".$course_record['course_code']."</option>";

                        }

                        ?>

                      </select>

                  </div>
                  <div class="form-group col-md-3 hidden">

                      <label for="form-type_of_training">TYPE OF TRAINING</label>

                      <select style='width:100%' name="dt[type_of_training]" class="form-control select2">

                        <?php 

                        $type_of_training = $this->mymodel->selectWhere('type_of_training',array('type_of_training'=>$type));

                        foreach ($type_of_training as $type_of_training_record) {

                          echo "<option value='".$type_of_training_record['type_of_training']."' >".$type_of_training_record['type_of_training']."</option>";

                        }

                        ?>

                      </select>

                  </div>

                  <div class="form-group col-md-3">

<label for="form-duration_instruct">CODE</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Code" name="dt[code]">

</div>

                  
                  <div class="form-group col-md-3">

<label for="form-duration_instruct">MISSION NUMBER</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Mission Number" name="dt[position]">

</div>

                  <div class="form-group col-md-3">

<label for="form-subject_mission">MISSION CODE</label>

<input type="text" class="form-control" id="form-subject_mission" placeholder="Masukan Mission Code" name="dt[subject_mission]">

</div><div class="form-group col-md-3">

<label for="form-name">MISSION</label>

<input type="text" class="form-control" id="form-name" placeholder="Masukan Mission" name="dt[name]">

</div><div class="form-group col-md-3">

<label for="form-description">DESCRIPTION</label>

<input type="text" class="form-control" id="form-description" placeholder="Masukan Description" name="dt[description]">

</div>


<?php

if($type!='flight'){ ?>

<div class="form-group col-md-3">

<label for="form-duration_instruct">DURATION</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Duration" name="dt[duration]" value="-">

</div>

<?php }else{ ?>

<div class="form-group col-md-3">

<label for="form-duration_instruct">DURATION DUAL</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Duration Dual" name="dt[duration_dual]" value="-">

</div>

<div class="form-group col-md-3">

<label for="form-duration_instruct">DURATION SOLO</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Duration Soal" name="dt[duration_solo]" value="-">

</div>


<div class="form-group col-md-3">

<label for="form-duration_instruct">DURATION PIC</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Duration Pic" name="dt[duration_pic]" value="-">

</div>


<div class="form-group col-md-3">

<label for="form-duration_instruct">DURATION SOLO (SVP)</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Duration Solo (SVP)" name="dt[duration_pic_solo]" value="-">

</div>


<?php } ?>
<div class="form-group col-md-3">

<label for="form-duration_instruct">Type Of Training</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Type Of Training" name="dt[type_of_training2]" value="<?=$tpm_syllabus_all_course['type_of_training2']?>">

</div>

<div class="form-group col-md-3">

<label for="form-duration_instruct">Type Of Training Type</label>

<input type="text" class="form-control" id="form-duration_instruct" placeholder="Masukan Type Of Training Type" name="dt[type_of_training_type2]" value="<?=$tpm_syllabus_all_course['type_of_training_type2']?>">

</div>

                
                  <div class="form-group col-md-3">

                      <label for="form-file">FILE</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div></div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> SUBMIT</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> RESET</button>

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

                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/curriculum/course_mission/').$curriculum_id.'/'.$type ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>