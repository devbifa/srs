<?php
$code = $_GET['c'];
$a = '';
$b = '';
$c = '';
$d = '';
if($code==1){
  $a = 'autofocus'; 
}else if($code==2){
  $b = 'autofocus'; 
}else if($code==3){
  $c = 'autofocus'; 
}else if($code==4){
  $d = 'autofocus'; 
}
?>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FLIGHT SCHEDULE

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">DAILY FLIGHT SCHEDULE</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/daily_movement_report/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $daily_flight_schedule['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT DAILY MOVEMENT REPORT
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

<label for="form-date_of_flight">DATE OF FLIGHT</label>

<input disabled  autocomplete="off" type="text" class="form-control tgl" id="form-date_of_flight" placeholder="Fill Date Of Flight" name="dt[date_of_flight]" value="<?= $daily_flight_schedule['date_of_flight'] ?>">

</div><div class="form-group col-md-3">

<label for="form-origin_base">ORIGIN BASE</label>

<select disabled  style='width:100%' name="dt[origin_base]" class="form-control select2">

  <?php 

  $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);

  foreach ($base_airport_document as $base_airport_document_record) {

    $text="";

    if($base_airport_document_record['base']==$daily_flight_schedule['origin_base']){

      $text = "selected";

    }



    echo "<option value='".$base_airport_document_record['base']."' ".$text." >".$base_airport_document_record['base']."</option>";

  }

  ?>

</select>

</div><div class="form-group col-md-3">

<label for="form-aircraft_reg">AIRCRAFT REG</label>

<select disabled  style='width:100%' name="dt[aircraft_reg]" class="form-control select2">
  <option value="">SELECT AIRCRAFT REG</option>
  <?php 

  $aircraft_document = $this->mymodel->selectWhere('aircraft_document',array('status'=>'ENABLE'));

  foreach ($aircraft_document as $val) {

    $text="";

    if($val['id']==$daily_flight_schedule['aircraft_reg']){

      $text = "selected";

    }



    echo "<option value='".$val['id']."' ".$text." >".$val['serial_number']." (".$val['type'].")</option>";

  }

  ?>

</select>

</div>
<div class="form-group col-md-3">

<label for="form-classroom">BATCH</label>

<select disabled  style='width:100%' name="dt[batch]" class="form-control select2" id="batch">
<option value="">SELECT BATCH</option>
<?php 

$base_airport_document = $this->mymodel->selectWithQuery("SELECT a.*, b.curriculum FROM batch a LEFT JOIN curriculum b ON a.curriculum = b.id");

foreach ($base_airport_document as $base_airport_document_record) {

$text="";

if($base_airport_document_record['id']==$daily_flight_schedule['batch']){

$text = "selected";

}



echo "<option value='".$base_airport_document_record['id']."' ".$text." >".$base_airport_document_record['batch'].' ('.$base_airport_document_record['curriculum'].")</option>";

}

?>

</select>

</div>

<div class="form-group col-md-3">

<label for="form-2nd">PIC</label>

<select style='width:100%' name="dt[pic]" class="form-control select2" id="pic" disabled >


<option value="">SELECT PIC/INSTRUCTOR</option>
<?php 

$instructor = $this->mymodel->selectWhere('student_application_form',array('instructor_status'=>'1')); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$daily_flight_schedule['pic']){

$text = "selected";

}

if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id']."' ".$text." >".$val['nick_name']."</option>";
}

}


?>

<option value="">SELECT STUDENT</option>
  <?php 
  $this->db->order_by("nick_name ASC");
  $student_document = $this->mymodel->selectWhere('student_application_form',array('batch'=>$daily_flight_schedule['batch'],'status'=>'ACTIVE'));

  foreach ($student_document as $val) {

    $text="";

    if($val['id']==$daily_flight_schedule['pic']){

      $text = "selected";

    }



    echo "<option value='".$val['id']."' ".$text." >".$val['nick_name']."</option>";

  }

  ?>

</select>

</div>
<div class="form-group col-md-3">

<label for="form-2nd">2ND</label>

<select style='width:100%' name="dt[2nd]" class="form-control select2" id="2nd" disabled >

<option value="">SELECT 2ND/INSTRUCTOR</option>
<?php 

$instructor = $this->mymodel->selectWhere('student_application_form',array('instructor_status'=>'1')); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$daily_flight_schedule['2nd']){

$text = "selected";

}

if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id']."' ".$text." >".$val['nick_name']."</option>";
}

}


?>

<option value="">SELECT STUDENT</option>
  <?php 
  $this->db->order_by("nick_name ASC");
  $student_document = $this->mymodel->selectWhere('student_application_form',array('batch'=>$daily_flight_schedule['batch'],'status'=>'ACTIVE'));

  foreach ($student_document as $val) {

    $text="";

    if($val['id']==$daily_flight_schedule['2nd']){

      $text = "selected";

    }



    echo "<option value='".$val['id']."' ".$text." >".$val['nick_name']."</option>";

  }

  ?>

</select>

</div>

<div class="form-group col-md-3">

                      <label for="form-course">COURSE</label>

                      <select style='width:100%' name="dt[course]" class="form-control select2" id="course">
                      <option value="">SELECT COURSE</option>
                        <?php 

                      $batch = $this->mymodel->selectDataOne('batch', array('id'=>$daily_flight_schedule['batch']));
                      $curriculum = $this->mymodel->selectDataOne('curriculum', array('id'=>$batch['curriculum']));
                      $curriculum = $curriculum['id'];
                      $this->db->order_by('position','ASC');
                        $tpm_syllabus_all_course = $this->mymodel->selectWhere('course',array('curriculum'=>$curriculum));

                        foreach ($tpm_syllabus_all_course as $val) {

                          $text="";

                          if($val['id']==$daily_flight_schedule['course']){

                            $text = "selected";

                          }



                          echo "<option value='".$val['id']."' ".$text." >".$val['course_code']."</option>";

                        }

                        ?>

                      </select>

                  </div>
                  
                

                  <div class="form-group col-md-3">

                      <label for="form-mission">MISSION</label>

                      <select style='width:100%' name="dt[mission]" class="form-control select2" id="mission">
                        <option value="">SELECT MISSION</option> 
                        <?php 
                        $this->db->order_by('position','ASC');
                        $tpm_syllabus_all_course = $this->mymodel->selectWhere('tpm_syllabus_all_course',array('type_of_training'=>'FLIGHT', 'course'=>$daily_flight_schedule['course']));

                        foreach ($tpm_syllabus_all_course as $val) {

                          $text="";

                          if($val['id']==$daily_flight_schedule['mission']){

                            $text = "selected";

                          }



                          echo "<option value='".$val['id']."' ".$text." >".$val['subject_mission'].' - '.$val['name']."</option>";

                        }

                        ?>

                      </select>

                  </div>

<div class="form-group col-md-3">

<label for="form-description">DESCRIPTION</label>

 <input readonly type="text" class="form-control" id="description" placeholder="Masukan Description" name="dt[description]" value="<?= $daily_flight_schedule['description'] ?>">

</div><div class="form-group col-md-3">

<label for="form-rute">RUTE</label>

<input  type="text" class="form-control" id="form-rute" placeholder="Fill Rute" name="dt[rute]" value="<?= $daily_flight_schedule['rute'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-dep">DEP</label>

<input disabled  type="text" class="form-control" id="form-dep" placeholder="Fill Dep" name="dt[dep]" value="<?= $daily_flight_schedule['dep'] ?>">

</div><div class="form-group col-md-3">

<label for="form-arr">ARR</label>

<input disabled  type="text" class="form-control" id="form-arr" placeholder="Fill Arr" name="dt[arr]" value="<?= $daily_flight_schedule['arr'] ?>">

</div>

<div class="form-group col-md-3">

<label for="form-etd_utc">ETD UTC</label>

<input disabled  type="text" class="form-control" id="form-etd_utc" placeholder="Fill Etd Utc" name="dt[etd_utc]" value="<?= $daily_flight_schedule['etd_utc'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-eet">EET</label>

<input disabled  type="text" class="form-control" id="form-eet" placeholder="Fill Eet" name="dt[eet]" value="<?= $daily_flight_schedule['eet'] ?>">

</div>
<div class="form-group col-md-3">

<label for="form-eta_utc">ETA UTC</label>

<input disabled  type="text" class="form-control" id="form-eta_utc" placeholder="Fill Eta Utc" name="dt[eta_utc]" value="<?= $daily_flight_schedule['eta_utc'] ?>">

</div>

<div class="form-group col-md-3">

<label for="form-2nd">Duty Instructor</label>

<select disabled style='width:100%' name="dt[duty_instructor]" class="form-control select2" >


<option value="">SELECT INSTRUCTOR</option>
<?php 

$instructor = $this->mymodel->selectWhere('student_application_form',array('instructor_status'=>'1')); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$daily_flight_schedule['duty_instructor']){

$text = "selected";

}

// if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id']."' ".$text." >".$val['nick_name']."</option>";
// }

}


?>


</select>

</div>
<div class="form-group col-md-12">

<label for="form-remark">REMARK</label>

<input   type="text" class="form-control" id="form-remark" placeholder="Fill Remark" name="dt[remark]" value="<?= $daily_flight_schedule['remark'] ?>">

</div>
                
                <div class="form-group col-md-3">

                <label for="form-remark">BLOCK TIME START</label>
              
                <input type="text" <?=$a?> class="form-control" id="etd" placeholder="Fill Block Time Start" name="dt[block_time_start]" value="<?= $daily_flight_schedule['block_time_start'] ?>">

                </div>
                
                <div class="form-group col-md-3">

                <label for="form-remark">BLOCK TIME STOP</label>

                <input type="text" <?=$b?> class="form-control" id="eta" placeholder="Fill Block Time Stop" name="dt[block_time_stop]" value="<?= $daily_flight_schedule['block_time_stop'] ?>">

                </div>

                <div class="form-group col-md-3">

                <label for="form-remark">BLOCK TIME TOTAL</label> 

                <?php 
                $total1 = ($daily_flight_schedule['block_time_start']); 
                $total2 = ($daily_flight_schedule['block_time_stop']);
                if($total1 > $total2){
                  $awal = strtotime('2020-01-01 '.$total1.':00');
                  $akhir = strtotime('2020-01-02 '.$total2.':00');
                  $diff  = $akhir - $awal;
                  $jam   = str_pad(floor($diff / (60 * 60)), 2, '0', STR_PAD_LEFT);
                  $menit = $diff - $jam * (60 * 60);
                  $menit = str_pad(floor( $menit / 60 ), 2, '0', STR_PAD_LEFT);
                  $total = $jam.':'.$menit;
                }else{
                  $awal = strtotime('2020-01-01 '.$total1.':00');
                  $akhir = strtotime('2020-01-01 '.$total2.':00');
                  $diff  = $akhir - $awal;
                  $jam   = str_pad(floor($diff / (60 * 60)), 2, '0', STR_PAD_LEFT);
                  $menit = $diff - $jam * (60 * 60);
                  $menit = str_pad(floor( $menit / 60 ), 2, '0', STR_PAD_LEFT);
                  $total = $jam.':'.$menit;
                }
                // echo DATE('H:i:s',$total2 - $total1);
                ?>

                <input type="text"  class="form-control" id="eet" placeholder="Fill Block Time Total" name="dt[block_time_total]" value="<?= $total ?>">

                </div>
                   
                
                <div class="col-md-12">

                <div class="row">
              
                <div class="form-group col-md-3">

                <label for="form-remark">FLIGHT TIME TAKE OFF</label>

                <input type="text" <?=$c?> class="form-control" id="etd_b" placeholder="Fill Flight Time Take Off" name="dt[flight_time_take_off]" value="<?= $daily_flight_schedule['flight_time_take_off'] ?>">

                </div>

                <div class="form-group col-md-3">

                <label for="form-remark">FLIGHT TIME LANDING</label>

                <input type="text" <?=$d?> class="form-control" id="eta_b" placeholder="Fill Flight Time Landing" name="dt[flight_time_landing]" value="<?= $daily_flight_schedule['flight_time_landing'] ?>">

                </div>

                <div class="form-group col-md-3">

                <label for="form-remark">FLIGHT TIME TOTAL</label>

                <?php 
                $total1 = ($daily_flight_schedule['flight_time_take_off']); 
                $total2 = ($daily_flight_schedule['flight_time_landing']);
                if($total1 > $total2){
                  $awal = strtotime('2020-01-01 '.$total1.':00');
                  $akhir = strtotime('2020-01-02 '.$total2.':00');
                  $diff  = $akhir - $awal;
                  $jam   = str_pad(floor($diff / (60 * 60)), 2, '0', STR_PAD_LEFT);
                  $menit = $diff - $jam * (60 * 60);
                  $menit = str_pad(floor( $menit / 60 ), 2, '0', STR_PAD_LEFT);
                  $total = $jam.':'.$menit;
                }else{
                  $awal = strtotime('2020-01-01 '.$total1.':00');
                  $akhir = strtotime('2020-01-01 '.$total2.':00');
                  $diff  = $akhir - $awal;
                  $jam   = str_pad(floor($diff / (60 * 60)), 2, '0', STR_PAD_LEFT);
                  $menit = $diff - $jam * (60 * 60);
                  $menit = str_pad(floor( $menit / 60 ), 2, '0', STR_PAD_LEFT);
                  $total = $jam.':'.$menit;
                }
                // echo DATE('H:i:s',$total2 - $total1);
                ?>

                <input type="text"  class="form-control" id="eet_b" placeholder="Fill Flight Time Total" name="dt[flight_time_total]" value="<?= $total ?>">

                </div>

                <div class="form-group col-md-3">

<label for="form-remark">TOTAL LANDING</label>

<input type="text" class="form-control" id="form-remark" placeholder="Fill Total Landing" name="dt[ldg]" value="<?= $daily_flight_schedule['ldg'] ?>">

</div>
                </div>
                </div>

            

                <div class="form-group col-md-3">

<label for="form-remark">IRREG CODE</label>


<select  style='width:100%' name="dt[remark_dmr]" class="form-control select2">
<option value="">SELECT IRREG CODE</option>
  <?php 
  $this->db->order_by('code ASC');
  $base_airport_document = $this->mymodel->selectWhere('delay_and_cancel_code',null);

  foreach ($base_airport_document as $base_airport_document_record) {

    $text="";

    if($base_airport_document_record['code']==$daily_flight_schedule['remark_dmr']){

      $text = "selected";

    }



    echo "<option value='".$base_airport_document_record['code']."' ".$text." >".$base_airport_document_record['code'].' ('.$base_airport_document_record['remarks'].")</option>";

  }

  ?>

</select>
</div>

<div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

                  </div>
               

                </div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1" ><i class="mdi mdi-content-save"></i></button>
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

                  $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/daily_movement_report') ?>";

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

          $("#2nd").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_2nd_by_batch/?batch='+batch,
                  success:function(html){
                    $("#2nd").html(html);
                  }
              }); 
          }else{
              // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
          }

          $("#course").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_course_by_batch/?batch='+batch,
                  success:function(html){
                    $("#course").html(html);
                  }
              }); 
          }else{
              // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
          }
        
          
       
      });

});

$(document).ready(function(){
    $('#course').change(function() {
          var course = $('#course').val();
          $("#mission").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_mission_by_course/?course='+course+'&type=FLIGHT',
                  success:function(html){
                    $("#mission").html(html);
                  }
              }); 
          }else{
              // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
          }
       
      });

});
</script>

<script>
$(document).ready(function(){
    $('#mission').change(function() {
          var mission = $('#mission').val();
          $("#description").val('LOADING...');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_mission_detail/?mission='+mission,
                  success:function(html){
                    $("#description").val(html);
                  }
              }); 
          }else{
              // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
          }
       
      });

});
</script>
