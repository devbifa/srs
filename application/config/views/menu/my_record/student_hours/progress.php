<?php
                $id = $_SESSION['id'];
                $student = $this->mymodel->selectDataOne('user',array('id'=>$id));
                $batch = $this->mymodel->selectDataOne('batch',array('batch'=>$student['batch']));
                $curriculum = $this->mymodel->selectDataOne('curriculum',array('code'=>$batch['curriculum']));
                $id_curriculum = $curriculum['code'];
                $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND (configuration LIKE '%GROUND%' OR configuration LIKE '%FTD%' OR configuration LIKE '%FLIGHT%') ORDER BY position ASC");
     
             ?>



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">


    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
              STUDENT HOURS DETAIL 
              <?php $this->load->view('menu/my_record/student_hours/menu.php')?>
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            

            <div class="box-body">

            

            <table style="width:100%;">
              <tr>
              <th colspan="3" style="font-size:15px;width:20%;padding:5px 0px;" class="text-left">STUDENT NAME</th>
                <th>:</th>
                <th class="text-left"><?=$student['full_name']?></th>
                <th colspan="4"></th>
              </tr>
              <tr>
                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">NICK NAME</th>
                <th>:</th>
                <th class="text-left"><?=$student['nick_name']?></th>
                <th colspan="4"></th>
              </tr>
              <tr>
                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">BATCH</th>
                <th>:</th>
                <th class="text-left"><?=$batch['batch']?></th>
                <th colspan="4"></th>
              </tr>
              <tr>
                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">CURRICULUM</th>
                <th>:</th>
                <th class="text-left"><?=$curriculum['curriculum']?></th>
                <th colspan="4"></th>
              </tr>

            </table>
            <br>
            <?php 
            $training_requirement = json_decode($student['training_requirement'],true);
            
            foreach($course as $key=>$val){
            $id_course = $val['code'];
            $ground_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'GROUND' ORDER BY position ASC");
            $ftd_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'SIM' ORDER BY position ASC");
            $flight_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT' ORDER BY position ASC");
            ?>

<?php 

if(empty($training_requirement['GROUND']['item'][$val['id']]) AND empty($training_requirement['FTD']['item'][$val['id']]) AND empty($training_requirement['FLIGHT']['item'][$val['id']])){
  $style_parent = "style='display:none;'";
}else{
  $style_parent = "";
}
 // print_r();
?>

          <div <?=$style_parent?> >
            <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="4" style="font-size:15px;" class="text-left"> <label><?=$val['course_code']?> - <?=$val['course_name']?></label>
                </th>
              </tr>
              <?php 

                   if($training_requirement['GROUND']['item'][$val['id']]){
                    $style_parent = "";
                   }else{
                    $style_parent = "style='display:none;'";
                   }
                    // print_r();
              ?>
              <tr <?=$style_parent?> >
                <th style="width:200px;" class="text-left" colspan="2">GROUND</th>
                <th style="width:200px;" >TARGET</th>
                <th style="width:200px;" >ACCOMPLISHMENT</th>
               
              </tr>
              <?php foreach($ground_mission as $key2=>$val2){ 
                 $id_student = $student['nick_name']; 
                 $id_mission = $val2['code'];
                 $total = array();
                 $qry = '{"attend":"'.$id_student.'"}';
                 $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule WHERE visibility = '1' AND visibility_report = '1' AND subject = '$id_mission' AND student_attend LIKE '%$qry%' ");
                
                 foreach($data as $key3=>$val3){
                   if (strpos($val3['duration_act'], ':') !== false) {
                     array_push($total,$val3['duration_act']);
                   }
                 }

                $total = $this->template->sum_time($total);
 
                 $duration = array();
                   if (strpos($val2['duration'], ':') !== false) {
                     array_push($duration,$val2['duration']);
                   }
                 
                   $duration = $this->template->sum_time($duration);
                  
                   
                  $total1 = (explode(":",$total));

                  $duration1 = (explode(":",$duration));

                  if($total1[0] == $duration1[0] && $total1[1] >= $duration1[1] ){
                    $status = "COMPLETE";
                    $style_status = "style='color:green;'";
                  }else if($total1[0] > $duration1[0]){
                    $status = "COMPLETE";
                     $style_status = "style='color:green;'";
                  }else{
                     $status = "NOT COMPLETE";
                     $style_status = "style='color:red;'";
                  }

                ?>
                <tr <?=$style_parent?> >
                <td style="width:200px;" class="text-left" colspan="2"><?=$val2['subject_mission']?> - <?=$val2['description']?></td>
                  <td><?=$val2['duration']?></td>
                  <td <?=$style_status?> ><?=$total?></td>
              </tr>
              <?php } ?>

              <?php 

if($training_requirement['FTD']['item'][$val['id']]){
 $style_parent = "";
}else{
 $style_parent = "style='display:none;'";
}
 // print_r();
?>
<tr <?=$style_parent?> >

                <th style="width:200px;" class="text-left" colspan="2">FTD</th>
                <th style="width:200px;" >TARGET</th>
                <th style="width:200px;">ACCOMPLISHMENT</th>
               
              </tr>
              <?php foreach($ftd_mission as $key2=>$val2){
                $id_student = $student['nick_name']; 
                $id_mission = $val2['code'];
                $total = array();
                $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule WHERE visibility = '1' AND visibility_report = '1'  AND mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') ");
                foreach($data as $key3=>$val3){
                  if (strpos($val3['block_time_total'], ':') !== false) {
                    array_push($total,$val3['block_time_total']);
                  }
                }
                $total = $this->template->sum_time($total);

                
                $duration = array();
                  if (strpos($val2['duration'], ':') !== false) {
                    array_push($duration,$val2['duration']);
                  }
                
                  $duration = $this->template->sum_time($duration);
                
                  $total1 = (explode(":",$total));

                  $duration1 = (explode(":",$duration));

                  if($total1[0] == $duration1[0] && $total1[1] >= $duration1[1] ){
                    $status = "COMPLETE";
                    $style_status = "style='color:green;'";
                  }else if($total1[0] > $duration1[0]){
                    $status = "COMPLETE";
                     $style_status = "style='color:green;'";
                  }else{
                     $status = "NOT COMPLETE";
                     $style_status = "style='color:red;'";
                  }
                ?>
                <tr <?=$style_parent?>>
                <td style="width:200px;" class="text-left" colspan="2"><?=$val2['subject_mission']?> - <?=$val2['description']?></td>
                <td><?=$val2['duration']?></td>
                <td <?=$style_status?> ><?=$total?></td>
              </tr>
              <?php } ?>

              <?php 

if($training_requirement['FLIGHT']['item'][$val['id']]){
 $style_parent = "";
}else{
 $style_parent = "style='display:none;'";
}
 // print_r();
?>

<tr <?=$style_parent?> >
                <th style="width:200px;" class="text-left" colspan="2">FLIGHT</th>
                <th style="width:200px;" >TARGET</th>
                <th style="width:200px;" >ACCOMPLISHMENT</th>
               
              </tr>
              <?php foreach($flight_mission as $key2=>$val2){ 
                $id_student = $student['nick_name']; 
                $id_mission = $val2['code'];
                $total = array();
                $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule WHERE mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') AND visibility = '1' AND visibility_report = '1' AND type = '' ");
                foreach($data as $key3=>$val3){
                  if (strpos($val3['block_time_total'], ':') !== false) {
                    array_push($total,$val3['block_time_total']);
                  }
                }
                $total = $this->template->sum_time($total);

                $duration = array();
                  if (strpos($val2['duration_dual'], ':') !== false) {
                    array_push($duration,$val2['duration_dual']);
                  }
                  if (strpos($val2['duration_solo'], ':') !== false) {
                    array_push($duration,$val2['duration_solo']);
                  }
                  if (strpos($val2['duration_pic'], ':') !== false) {
                    array_push($duration,$val2['duration_pic']);
                  }
                  if (strpos($val2['duration_pic_solo'], ':') !== false) {
                    array_push($duration,$val2['duration_pic_solo']);
                  }
                  $duration = $this->template->sum_time($duration);
                  
                  $total1 = (explode(":",$total));

                  $duration1 = (explode(":",$duration));

                  if($total1[0] == $duration1[0] && $total1[1] >= $duration1[1] ){
                    $status = "COMPLETE";
                    $style_status = "style='color:green;'";
                  }else if($total1[0] > $duration1[0]){
                    $status = "COMPLETE";
                     $style_status = "style='color:green;'";
                  }else{
                     $status = "NOT COMPLETE";
                     $style_status = "style='color:red;'";
                  }
                ?>
                <tr <?=$style_parent?>>
                <td style="width:200px;" class="text-left" colspan="2"><?=$val2['subject_mission']?> - <?=$val2['description']?></td>
                <td><?=$duration?></td>
                <td <?=$style_status?> ><?=$total?></td>
              </tr>

              <?php } ?>
              

            </table>
                  </div>
<br>
            <?php } ?>
            
            
                    



            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->


  <div class="modal modal-danger fade" id="modal-delete">

  <div class="modal-dialog">
            <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('dashboard/flight_schedule/delete') ?>">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE DATA</h4>
              </div>

              <div class="modal-body">

                  <input type="hidden" name="id" id="delete-input">

                  <p>Are you sure to delete this data?</p>

              </div>

              <div class="modal-footer">

                 
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline btn-send" href="">Delete Now</button>

              </div>

              </form>

          </div>

      </div>

  </div> 



  <div class="modal fade" id="modal-impor">

    <div class="modal-dialog">

      <div class="modal-content">

        <div class="modal-header">

          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

          <h4 class="modal-title">IMPORT DATA</h4>

        </div>

        <form action="<?= base_url('fitur/impor/daily_flight_schedule') ?>" method="POST"  enctype="multipart/form-data">



        <div class="modal-body">

            <div class="form-group">

              <label for="">File Excel</label>

              <input type="file" class="form-control" id="" name="file" placeholder="Input field">

            </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>

          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>

        </div>

        </form>



      </div>

    </div>

  </div>


