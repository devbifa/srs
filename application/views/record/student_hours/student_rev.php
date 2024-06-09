        <?php
                $id = $this->uri->segment(4);
                $student = $this->mymodel->selectDataOne('user',array('id'=>$id));
                $batch = $this->mymodel->selectDataOne('batch',array('code'=>$student['batch']));
                $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$batch['curriculum']));
                $id_curriculum = $curriculum['code'];

                $arr_course = json_decode($curriculum['course'],true);
                $arr_mission = json_decode($curriculum['mission'],true);

                $arr_course_selected = json_decode($student['course'],true);

                

                // foreach($arr_course['FLIGHT'] as $k=>$v){
                //   if($v['status']=="ON"){
                //     $text .= "'".$k."',";
                //   }
                // }
                // $text = substr($text,0,-1);
                // if($text){
                //   $course = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_course WHERE code IN ($text) ORDER BY position ASC");
                // }

                $course = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_course ORDER BY position ASC");
              

                
                
               
            
            
$flight_hours_student_ttl = array();
$flight_hours_ttl = array();

$ftd_hours_student_ttl = array();
$ftd_hours_ttl = array();

$ground_hours_student_ttl = array();
$ground_hours_ttl = array();

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

     
            <div class="row">
              <div class="col-md-6">
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
                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">ID NUMBER</th>
                <th>:</th>
                <th class="text-left"><?=$student['id_number']?></th>
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
                <th class="text-left"><?=$curriculum['name']?></th>
                <th colspan="4"></th>
              </tr>

            </table>
              </div>
              <div class="col-md-4">
                  <div class="" id="summary-top"></div>
              </div>
            </div>
                
            
            <br>
            
            <?php 
            $training_requirement = json_decode($student['training_requirement'],true);

           

            foreach($course as $key=>$val){

              
            $id_course = $val['code'];
              
              $visible_course = "0";
              if($arr_course['FLIGHT'][$val['code']]['status']=="ON"){
                $visible_course = "1";
              }else if($arr_course['FTD'][$val['code']]['status']=="ON"){
                $visible_course = "1";
              }else if($arr_course['GROUND'][$val['code']]['status']=="ON"){
                $visible_course = "1";
              }
              
              if($visible_course=="1"){

              $ground_mission = array();
              $ftd_mission = array();
              $flight_mission = array();
            

            if($arr_course_selected['GROUND'][$val['code']]['status']=="ON"){
              $ground_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'GROUND' ORDER BY position ASC");
            }else{
              $ground_hours = "00:00";
              $ground_hours_student = "00:00";
            }
            if($arr_course_selected['FTD'][$val['code']]['status']=="ON"){
              $ftd_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FTD' ORDER BY position ASC");
            }else{
              $ftd_hours = "00:00";
              $ftd_hours_student = "00:00";
            }
            if($arr_course_selected['FLIGHT'][$val['code']]['status']=="ON"){
              $flight_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT' GROUP BY type ORDER BY position ASC");
            }else{
              $duration_flight = "00:00";
              $duration_flight_student = "00:00";
              $duration_dual_flight = "00:00";
              $duration_solo_flight = "00:00";
              $duration_solo_svp_flight = "00:00";
              $duration_pic_flight = "00:00";
              $duration_non_rev_flight = "00:00";
              
              $duration_dual_flight_student = "00:00";
              $duration_solo_flight_student = "00:00";
              $duration_solo_svp_flight_student = "00:00";
              $duration_pic_flight_student = "00:00";
              $duration_non_rev_flight_student = "00:00";

              $flight_hours = "00:00";
              $flight_hours_student = "00:00";
            }
            ?>

<?php 

// if(empty($training_requirement['GROUND']['item'][$val['id']]) AND empty($training_requirement['FTD']['item'][$val['id']]) AND empty($training_requirement['FLIGHT']['item'][$val['id']])){
//   $style_parent = "style='display:none;'";
// }else{
//   $style_parent = "";
// }
$style_parent = "";
?>

 <div class="row">
  <?php
if($arr_course_selected['FLIGHT'][$val['code']]['status']=="ON"){
  ?>
              <div class="col-md-6">
             <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="2" style="font-size:15px;" class="text-left"> <label><?=$val['code_name']?> - <?=$val['name']?></label>
                </th>
                <th style="font-size:15px;"><b>TARGET</b></th>
                <th style="font-size:15px;"><b>ACTUAL</b></th>
              </tr>
              <?php 

                   if($training_requirement['GROUND']['item'][$val['id']]){
                    $ground_pass = '1';
                    $style_parent = "";
                   }else{
                    $ground_pass = '0';
                    $style_parent = "style='display:none;'";
                   }
                    // print_r();
              ?>
             
              <?php 

$id_student = $student['id_number']; 
$id_mission = $val2['code'];
$total = array();


$qry = '"val":"'.$id_student.'"';
$data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule a
WHERE a.visibility = '1' AND a.visibility_report = '1'  AND (student_attend LIKE '%$qry%' OR student_other_attend LIKE '%$qry%')  AND duration_act NOT IN ('','-','00:00','0:00')  
AND course = '$id_course' "
);
// echo count($data);
foreach($data as $key3=>$val3){
  if (strpos($val3['duration_act'], ':') !== false) {
    array_push($total,$val3['duration_act']);
  }
}

$total = $this->template->sum_time($total);




              $duration = array();
              foreach($ground_mission as $key2=>$val2){ 
               
                    if($arr_mission['GROUND'][$val2['course']][$val2['code']]['duration']){
                      $val2['duration'] = $arr_mission['GROUND'][$val2['course']][$val2['code']]['duration'];
                    }

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

              <tr >
                
              <th style="width:200px;" class="text-left" colspan="2">GROUND</th>
              <td><?=$duration?></td>
              <td  <?=$style_status?> ><?=$total?></td>
               
                
              </tr>

              <?php 

if($training_requirement['FTD']['item'][$val['id']]){
  $ftd_pass = '1';
 $style_parent = "";
}else{
  $ftd_pass = '0';
 $style_parent = "style='display:none;'";
}
?>

              <?php 

                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule WHERE visibility = '1' AND visibility_report = '1' AND course = '$id_course' AND (2nd = '$id_student' OR 2nd = '$id_student' OR pic = '$id_student')");

                foreach($data as $key3=>$val3){
                  if (strpos($val3['block_time_total'], ':') !== false) {
                    array_push($total,$val3['block_time_total']);
                  }
                }
                $total = $this->template->sum_time($total);


                $duration = array();
                foreach($ftd_mission as $key2=>$val2){

                  if($arr_mission['FTD'][$val2['course']][$val2['code']]['duration']){
                    $val2['duration'] = $arr_mission['FTD'][$val2['course']][$val2['code']]['duration'];
                  }


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

              <tr >

                <th style="width:200px;" class="text-left" colspan="2">FTD</th>
                <td><?=$duration?></td>
                <td  <?=$style_status?> ><?=$total?></td>
              </tr>

              <?php 

// if($training_requirement['FLIGHT']['item'][$val['id']]){
//   $flight_pass = '1';
//  $style_parent = "";
// }else{
//   $flight_pass = '0';
//  $style_parent = "style='display:none;'";
// }
?>
<tr>
               
              </tr>
              
            
              
              <?php 
              
              $duration_flight = array();
              $duration_flight_student = array();
              $duration_dual_flight = array();
              $duration_solo_flight = array();
              $duration_solo_svp_flight = array();
              $duration_pic_flight = array();
              $duration_non_rev_flight = array();
              
              $duration_dual_flight_student = array();
              $duration_solo_flight_student = array();
              $duration_solo_svp_flight_student = array();
              $duration_pic_flight_student = array();
              $duration_non_rev_flight_student = array();

              $nomor = 0;
              foreach($flight_mission as $key2=>$val2){ 


                if (strpos($val2['duration'], ':') !== false) {
                  array_push($duration,$val2['duration']);
                }
                
                $type = $val2['type'];

                $flight_mission_child = $this->mymodel->selectWithQuery("SELECT type,type_sub FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type = '$type' GROUP BY type, type_sub ORDER BY position ASC");
                
               

                $type_sub = $val2['type_sub'];
               
                $rowspan = count($flight_mission_child);
                  
                ?>
               
                <?php
                
                  foreach($flight_mission_child as $keymc=>$valmc){
                    $type_sub = $valmc['type_sub'];
                    $flight_mission_child_item = $this->mymodel->selectWithQuery("SELECT code,type,type_sub,course,duration_dual,duration_solo,duration_pic,duration_non_rev,duration_pic_solo
                    FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type = '$type' AND type_sub = '$type_sub' ORDER BY position ASC");

                    $duration = array();
                    $total = array();
                    foreach($flight_mission_child_item as $keymci => $valmci){
                      
                      $id_student = $student['id_number']; 
                      $id_mission = $valmci['code'];
                     
                      $data = $this->mymodel->selectWithQuery("SELECT a.*, b.*, a.id 
                      FROM daily_flight_schedule a 
                      LEFT JOIN syllabus_mission b ON a.mission = b.code 
                      WHERE a.mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') AND a.visibility = '1' AND a.visibility_report = '1' 
                      AND a.type = ''
                      AND a.block_time_total NOT IN ('','-','00:00','0:00') ");
                      

                      foreach($data as $key3=>$val3){
                        
                      $nomor++;
                        
                      $pic = $val3['pic'];
                      $pic = $this->mymodel->selectWithQuery("SELECT instructor_status FROM user WHERE id_number = '$pic'");
                      $pic = $pic[0]['instructor_status'];
                      $nd = $val3['2nd'];
                      $nd = $this->mymodel->selectWithQuery("SELECT instructor_status FROM user WHERE id_number = '$nd'");
                      $nd = $nd[0]['instructor_status'];
                      if($pic=='1'){
                        if (strpos($val3['block_time_total'], ':') !== false) {
                          array_push($total,$val3['block_time_total']);
                        }
                      }else if($pic!='1'){
                        if($val3['pic']==$id_student){
                          if (strpos($val3['block_time_total'], ':') !== false) {
                            array_push($total,$val3['block_time_total']);
                          }
                        }
                      }
                   

                        

                      
                        if (strpos($val3['duration_dual'], ':') !== false) {
                          array_push($duration_dual_flight_student,$val3['duration_dual']);
                        }else  if (strpos($val3['duration_solo'], ':') !== false) {
                          array_push($duration_solo_flight_student,$val3['duration_solo']);
                        }else  if (strpos($val3['duration_pic'], ':') !== false) {
                          array_push($duration_pic_flight_student,$val3['duration_pic']);
                        }else  if (strpos($val3['duration_non_rev'], ':') !== false) {
                          array_push($duration_non_rev_flight_student,$val3['duration_non_rev']);
                        }else  if (strpos($val3['duration_pic_solo'], ':') !== false) {
                          array_push($duration_solo_svp_flight_student,$val3['duration_pic_solo']);
                        }
                        
                      }
                     

                      if($arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration']){
                        $valmci['duration'] = $arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration'];
                      }
                      if($arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_dual']){
                        $valmci['duration_dual'] = $arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_dual'];
                      }
                      if($arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_solo']){
                        $valmci['duration_solo'] = $arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_solo'];
                      }
                      if($arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_pic']){
                        $valmci['duration_pic'] = $arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_pic'];
                      }
                      if($arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_pic_solo']){
                        $valmci['duration_pic_solo'] = $arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_pic_solo'];
                      }
                      if($arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_non_rev']){
                        $valmci['duration_non_rev'] = $arr_mission['FLIGHT'][$valmci['course']][$valmci['code']]['duration_non_rev'];
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

                      if (strpos($valmci['duration_non_rev'], ':') !== false) {
                        array_push($duration,$valmci['duration_non_rev']);
                        array_push($duration_non_rev_flight,$valmci['duration_non_rev']);
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

                <!-- <tr <?=$style_parent?>> -->
                <tr>
                <th rowspan="<?=$rowspan?>"  class="text-left"><?=$val2['type']?></th>
                <th class="text-left"><?=$valmc['type_sub']?></th>
                <td><?=$duration?></td>
                <td  <?=$style_status?> ><?=$total?></td>
                </tr>

                

                <?php 
                    }else{
                ?>
<!-- <tr <?=$style_parent?>> -->
                <tr>
                
                <th  class="text-left"><?=$valmc['type_sub']?></th>
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

               $flight_pass = "1";
               $ftd_pass = "1";
               $ground_pass = "1";

               if($flight_pass=="1"){
                array_push($flight_hours_ttl,$flight_hours);
                array_push($flight_hours_student_ttl,$flight_hours_student);
              }
              if($ftd_pass=="1"){
                array_push($ftd_hours_ttl,$ftd_hours);
                array_push($ftd_hours_student_ttl,$ftd_hours_student);
              }
              if($ground_pass=="1"){
                array_push($ground_hours_ttl,$ground_hours);
                array_push($ground_hours_student_ttl,$ground_hours_student);
              }

              
               $duration_dual_flight = $this->template->sum_time($duration_dual_flight);
               $duration_pic_flight = $this->template->sum_time($duration_pic_flight);
               $duration_non_rev_flight = $this->template->sum_time($duration_non_rev_flight);
               $duration_solo_svp_flight = $this->template->sum_time($duration_solo_svp_flight);
               $duration_solo_flight = $this->template->sum_time($duration_solo_flight);
             
               $duration_dual_flight_student = $this->template->sum_time($duration_dual_flight_student);
               $duration_pic_flight_student = $this->template->sum_time($duration_pic_flight_student);
               $duration_non_rev_flight_student = $this->template->sum_time($duration_non_rev_flight_student);
               $duration_solo_svp_flight_student = $this->template->sum_time($duration_solo_svp_flight_student);
               $duration_solo_flight_student = $this->template->sum_time($duration_solo_flight_student);

               


               
              ?>
              

            </table>
<br>
</div>
<?php }else{ ?>
  <div class="col-md-6">
             <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="2" style="font-size:15px;" class="text-left"> <label><?=$val['code_name']?> - <?=$val['name']?></label>
                </th>
                <th style="font-size:15px;"><b>TARGET</b></th>
                <th style="font-size:15px;"><b>ACTUAL</b></th>
              </tr>
              <tr>
<td colspan="4" class="text-left">THIS COURSE IN FLIGHT NOT SELECTED BY STUDENT!</td>
</tr>
</table>
<br>
</div>
<?php } ?> 


            <div class="col-md-4">
              
            <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
              <th colspan="1" style="font-size:15px;" class="text-left"> <label>SUMMARY
                </th>
                
                <th style="font-size:15px;"><b>TARGET</b></th>
                <th style="font-size:15px;"><b>ACTUAL</b></th>
              </tr>
              <?php
              if($arr_course_selected['FLIGHT'][$val['code']]['status']=="ON"){
              ?>
              <tr class="">
                <td class="text-left">DUAL FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_dual_flight?></label>
                <?php
                $check = $this->template->check_time_pass($duration_dual_flight,$duration_dual_flight_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$duration_dual_flight_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-left">SOLO FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_solo_flight?></label>
                <?php
                $check = $this->template->check_time_pass($duration_solo_flight,$duration_solo_flight_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$duration_solo_flight_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-left">SOLO(SVP) FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_solo_svp_flight?></label>
                <?php
                $check = $this->template->check_time_pass($duration_solo_svp_flight,$duration_solo_svp_flight_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$duration_solo_svp_flight_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-left">PIC FLIGHT</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_pic_flight?></label>
                <?php
                $check = $this->template->check_time_pass($duration_pic_flight,$duration_pic_flight_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$duration_pic_flight_student?></label>
                </td>
              </tr>
              <tr class="">
                <td class="text-left">NON REV</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$duration_non_rev_flight?></label>
                <?php
                $check = $this->template->check_time_pass($duration_non_rev_flight,$duration_non_rev_flight_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$duration_non_rev_flight_student?></label>
                </td>
              </tr>

              <tr class="">
                <td class="text-right" colspan="3"><br>
                </td>
              </tr>
              <?php
              }
              ?>
              <?php
              if($arr_course_selected['GROUND'][$val['code']]['status']=="ON"){
              ?>
              <tr class="">
                <td class="text-left">GROUND HOURS</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$ground_hours?></label>
                <?php
                $check = $this->template->check_time_pass($ground_hours,$ground_hours_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$ground_hours_student?></label>
                </td>
              </tr>
              <?php }else{ ?>
                <tr>
                  <td colspan="3" class="text-left">
                    GROUND NOT SELECTED BY STUDENT!
                  </td>
                </tr>
              <?php } ?>
              <?php
              if($arr_course_selected['FTD'][$val['code']]['status']=="ON"){
              ?>
              <tr class="">
                <td class="text-left">FTD HOURS</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$ftd_hours?></label>
                <?php
                $check = $this->template->check_time_pass($ftd_hours,$ftd_hours_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$ftd_hours_student?></label>
                </td>
              </tr>
              <?php }else{ ?>
                <tr>
                  <td colspan="3" class="text-left">
                    FTD NOT SELECTED BY STUDENT!
                  </td>
                </tr>
              <?php } ?>
              <?php
              if($arr_course_selected['FLIGHT'][$val['code']]['status']=="ON"){
              ?>
              <tr class="">
                <td class="text-left">FLIGHT HOURS</label>
                </td>
                <td class="text-center" style="width:80px;"><?=$flight_hours?></label>
                <?php
                $check = $this->template->check_time_pass($flight_hours,$flight_hours_student);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$flight_hours_student?></label>
                </td>
              </tr>
              <?php }else{ ?>
                <tr>
                  <td colspan="3" class="text-left">
                    FLIGHT NOT SELECTED BY STUDENT!
                  </td>
                </tr>
              <?php } ?>
                </table>
            </div>
                </div>
            
            <?php 
         
          } }
          // print_r($ftd_hours_ttl);
          ?>
            
            
            <div class="">
              <div class="row">
              <div class="col-md-6"></div>
              <div class="col-md-4" id="summary-bottom" style="display:none">
              
              <table style="width:100%;" class="table table-bordered">
                <tr class="bg-green">
                <th colspan="1" style="font-size:15px;" class="text-left"> <label>SUMMARY ALL TRAINING
                  </th>
                  
                  <th style="font-size:15px;"><b>TARGET</b></th>
                  <th style="font-size:15px;"><b>ACTUAL</b></th>
                </tr>
               
                  
              <?php
              
              $ground_hours_ttl = $this->template->sum_time($ground_hours_ttl);
              $ground_hours_student_ttl = $this->template->sum_time($ground_hours_student_ttl);
              $ftd_hours_ttl = $this->template->sum_time($ftd_hours_ttl);
              $ftd_hours_student_ttl = $this->template->sum_time($ftd_hours_student_ttl);
              $flight_hours_ttl = $this->template->sum_time($flight_hours_ttl);
              $flight_hours_student_ttl = $this->template->sum_time($flight_hours_student_ttl);


              ?>
               
                <tr class="">
                  <td class="text-left">GROUND HOURS</label>
                  </td>
                  <td class="text-center" style="width:80px;"><?=$ground_hours_ttl?></label>
                <?php
                $check = $this->template->check_time_pass($ground_hours_ttl,$ground_hours_student_ttl);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$ground_hours_student_ttl?></label>
                  </td>
                </tr>
                <tr class="">
                  <td class="text-left">FTD HOURS</label>
                  </td>
                  <td class="text-center" style="width:80px;"><?=$ftd_hours_ttl?></label>
                <?php
                $check = $this->template->check_time_pass($ftd_hours_ttl,$ftd_hours_student_ttl);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$ftd_hours_student_ttl?></label>
                  </td>
                </tr>
                <tr class="">
                  <td class="text-left">FLIGHT HOURS</label>
                  </td>
                  <td class="text-center" style="width:80px;"><?=$flight_hours_ttl?></label>
                <?php
                $check = $this->template->check_time_pass($flight_hours_ttl,$flight_hours_student_ttl);
                $style_status = "color:red;";
                if($check=="1"){
                  $style_status = "color:green";
                }
                ?>
                </td>
                <td class="text-center" style="width:80px;<?=$style_status?>"><?=$flight_hours_student_ttl?></label>
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



  <script>
    $('#summary-top').html($('#summary-bottom').html());
  </script>
