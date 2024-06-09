
        <?php
                $id = $this->uri->segment(4);
                $student = $this->mymodel->selectDataOne('user',array('id'=>$id));
                $batch = $this->mymodel->selectDataOne('batch',array('batch'=>$student['batch']));
                $curriculum = $this->mymodel->selectDataOne('curriculum',array('code'=>$batch['curriculum']));
                $id_curriculum = $curriculum['code'];
                $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND (configuration LIKE '%GROUND%' OR configuration LIKE '%FTD%' OR configuration LIKE '%FLIGHT%') ORDER BY position ASC");
          // print_r($course);
             ?>


<style>
.bg-success{
  color : green;
  background:#fff;
  /* color:#000; */
}
.bg-danger{
  color: red;
  background:#fff;
}
  </style>



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
              <?php $this->load->view('record/student_hours/menu.php')?>
           
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
            $ground_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'GROUND' ORDER BY mission_number ASC");
            $ftd_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'SIM' ORDER BY mission_number ASC");
            $flight_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT' GROUP BY type_of_training2 ORDER BY mission_number ASC");
            ?>

<?php 

if(empty($training_requirement['GROUND']['item'][$val['id']]) AND empty($training_requirement['FTD']['item'][$val['id']]) AND empty($training_requirement['FLIGHT']['item'][$val['id']])){
  $style_parent = "style='display:none;'";
}else{
  $style_parent = "";
}
 // print_r();
?>

 <div class="row" <?=$style_parent?> >
              <div class="col-md-6">

             <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="5" style="font-size:15px;" class="text-left"> <label><?=$val['course_code']?> - <?=$val['course_name']?></label>
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
             
              <?php 

$id_student = $student['id_number']; 
$id_mission = $val2['code'];
$total = array();
$qry = '{"attend":"'.$id_student.'"}';
$data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule WHERE course = '$id_course' AND student_attend LIKE '%$qry%' AND visibility = '1' AND visibility_report = '1' ");

foreach($data as $key3=>$val3){
  if (strpos($val3['duration_act'], ':') !== false) {
    array_push($total,$val3['duration_act']);
  }
}

$total = $this->template->sum_time($total);




              $duration = array();
              foreach($ground_mission as $key2=>$val2){ 
               
                   if (strpos($val2['duration'], ':') !== false) {
                     array_push($duration,$val2['duration']);
                   }
                 
                   
                  
                   



                ?>
               
              
            
              
              <?php }
             
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
              $ground_hours = $duration;
              $ground_hours_student = $total;
              ?>

              <tr <?=$style_parent?> >
                
              <th style="width:200px;" class="text-left" colspan="2">GROUND</th>
              <td><?=$duration?></td>
              <td  <?=$style_status?> ><?=$total?></td>
               
                
              </tr>

              <?php 

if($training_requirement['FTD']['item'][$val['id']]){
 $style_parent = "";
}else{
 $style_parent = "style='display:none;'";
}
 // print_r();
?>

              <?php 

                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule WHERE visibility = '1' AND visibility_report = '1' AND course = '$id_course' AND (2nd = '$id_student' OR pic = '$id_student')");

                foreach($data as $key3=>$val3){
                  if (strpos($val3['block_time_total'], ':') !== false) {
                    array_push($total,$val3['block_time_total']);
                  }
                }
                $total = $this->template->sum_time($total);


                $duration = array();
                foreach($ftd_mission as $key2=>$val2){
                  if (strpos($val2['duration'], ':') !== false) {
                    array_push($duration,$val2['duration']);
                  }
              
                ?>
                
                
            
              <?php }
              
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
              //  echo $style_status;
              $ftd_hours = $duration;
              
              $ftd_hours_student = $total;
              ?>

              <tr <?=$style_parent?> >

                <th style="width:200px;" class="text-left" colspan="2">FTD</th>
                <td><?=$duration?></td>
                <td  <?=$style_status?> ><?=$total?></td>
              </tr>

              <?php 

if($training_requirement['FLIGHT']['item'][$val['id']]){

 $style_parent = "";
}else{
 $style_parent = "style='display:none;'";
}
 // print_r();
?>
<tr <?=$style_parent?> >
               
              </tr>
              
            
              
              <?php 
              
              $duration_flight = array();
              $duration_flight_student = array();
              $duration_dual_flight = array();
              $duration_solo_flight = array();
              $duration_solo_svp_flight = array();
              $duration_pic_flight = array();
              
              $duration_dual_flight_student = array();
              $duration_solo_flight_student = array();
              $duration_solo_svp_flight_student = array();
              $duration_pic_flight_student = array();

              foreach($flight_mission as $key2=>$val2){ 
                $type_of_training2 = $val2['type_of_training2'];

                $flight_mission_child = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type_of_training2 = '$type_of_training2' GROUP BY type_of_training2, type_of_training_type2 ORDER BY mission_number ASC");
                
                $type_of_training_type2 = $val2['type_of_training_type2'];
               
               

              
                  
                  
                   $rowspan = count($flight_mission_child);
                  
                ?>
               
                <?php
                  foreach($flight_mission_child as $keymc=>$valmc){
                    $type_of_training_type2 = $valmc['type_of_training_type2'];
                    $flight_mission_child_item = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type_of_training2 = '$type_of_training2' AND type_of_training_type2 = '$type_of_training_type2' ORDER BY mission_number ASC");
                    $duration = array();
                    $total = array();
                    foreach($flight_mission_child_item as $keymci => $valmci){
                      
                      $id_student = $student['id_number']; 
                      $id_mission = $valmci['code'];
                      
                      $data = $this->mymodel->selectWithQuery("SELECT a.*, b.*, a.id FROM daily_flight_schedule a LEFT JOIN tpm_syllabus_all_course b ON a.mission = b.id WHERE a.mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') AND a.visibility = '1' AND a.visibility_report = '1' AND a.type = ''");
                      foreach($data as $key3=>$val3){
                        if (strpos($val3['block_time_total'], ':') !== false) {
                          array_push($total,$val3['block_time_total']);
                        }

                        if (strpos($val3['duration_dual'], ':') !== false) {
                          array_push($duration_dual_flight_student,$val3['duration_dual']);
                        }else  if (strpos($val3['duration_solo'], ':') !== false) {
                          array_push($duration_solo_flight_student,$val3['duration_solo']);
                        }else  if (strpos($val3['duration_pic'], ':') !== false) {
                          array_push($duration_pic_flight_student,$val3['duration_pic']);
                        }else  if (strpos($val3['duration_pic_solo'], ':') !== false) {
                          array_push($duration_solo_svp_flight_student,$val3['duration_pic_solo']);
                        }
                        
                      }
                     

                      if (strpos($valmci['duration_dual'], ':') !== false) {
                        array_push($duration,$valmci['duration_dual']);
                        array_push($duration_dual_flight,$valmci['duration_dual']);
                      }
                      if (strpos($valmci['duration_solo'], ':') !== false) {
                        array_push($duration,$valmci['duration_solo']);
                        array_push($duration_solo_flight,$valmci['duration_solo']);
                      }
                      if (strpos($valmci['duration_pic'], ':') !== false) {
                        array_push($duration,$valmci['duration_pic']);
                        array_push($duration_pic_flight,$valmci['duration_pic']);
                      }
                      if (strpos($valmci['duration_pic_solo'], ':') !== false) {
                        array_push($duration,$valmci['duration_pic_solo']);
                        array_push($duration_solo_svp_flight,$valmci['duration_pic_solo']);
                      }
                      
                    }

                    $total = $this->template->sum_time($total);
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
                    // print_r($total);
                    if($keymc == 0){
                
                ?>

                <tr <?=$style_parent?>>
                <th rowspan="<?=$rowspan?>"  class="text-left"><?=$val2['type_of_training2']?></th>
                <th class="text-left"><?=$valmc['type_of_training_type2']?></th>
                <td><?=$duration?></td>
                <td  <?=$style_status?> ><?=$total?></td>
                </tr>

                

                <?php 
                    }else{
                ?>
<tr <?=$style_parent?>>
                
                <th  class="text-left"><?=$valmc['type_of_training_type2']?></th>
              <td><?=$duration?></td>
                <td  <?=$style_status?> ><?=$total?></td>
                </tr>
                    <?php } ?>

                    <?php

if (strpos($duration, ':') !== false) {
  array_push($duration_flight,$duration);
}
if (strpos($total, ':') !== false) {
  array_push($duration_flight_student,$total);
}

                  }
                ?>
              <?php }
              
               $duration_flight = $this->template->sum_time($duration_flight);
               $flight_hours = $duration_flight;

               
              
               $duration_flight_student = $this->template->sum_time($duration_flight_student);
               $flight_hours_student = $duration_flight_student;
              
               $duration_dual_flight = $this->template->sum_time($duration_dual_flight);
               $duration_pic_flight = $this->template->sum_time($duration_pic_flight);
               $duration_solo_svp_flight = $this->template->sum_time($duration_solo_svp_flight);
               $duration_solo_flight = $this->template->sum_time($duration_solo_flight);

               $duration_dual_flight_student = $this->template->sum_time($duration_dual_flight_student);
               $duration_pic_flight_student = $this->template->sum_time($duration_pic_flight_student);
               $duration_solo_svp_flight_student = $this->template->sum_time($duration_solo_svp_flight_student);
               $duration_solo_flight_student = $this->template->sum_time($duration_solo_flight_student);


               
              ?>
              

            </table>
            
<br>


                
</div>
            <div class="col-md-4">
              
            <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
              <th colspan="5" style="font-size:15px;" class="text-left"> <label>SUMMARY
                </th>
              </tr>
              <tr class="">
                <td class="text-right">DUAL FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_dual_flight?></label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_dual_flight_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-right">SOLO FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_solo_flight?></label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_solo_flight_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-right">SOLO(SVP) FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_solo_svp_flight?></label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_solo_svp_flight_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-right">PIC FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_pic_flight?></label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_pic_flight_student?></label>
                </td>
              </tr>

              <tr class="">
                <td class="text-right" colspan="3"><br>
                </td>
              </tr>
              <tr class="">
                <td class="text-right">GROUND HOURS</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$ground_hours?></label>
                </td>
                <td class="text-center" style="width:80px;"><?=$ground_hours_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-right">FTD HOURS</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$ftd_hours?></label>
                </td>
                <td class="text-center" style="width:80px;"><?=$ftd_hours_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-right">FLIGHT HOURS</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$flight_hours?></label>
                </td>
                <td class="text-center" style="width:80px;"><?=$flight_hours_student?></label>
                </td>
              </tr>
                </table>
            </div>
                </div>
            
            <?php } ?>
            
           
            </div>
                    



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


