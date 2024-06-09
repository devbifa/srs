 <?php
                $id = $this->uri->segment(4);
                $student = $this->mymodel->selectDataOne('user',array('id'=>$id));
                $batch = $this->mymodel->selectDataOne('batch',array('code'=>$student['batch']));
                $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$batch['curriculum']));
                $id_curriculum = $curriculum['code'];

                $arr_course = json_decode($curriculum['course'],true);
                $arr_mission = json_decode($curriculum['mission'],true);

                $arr_course_selected = json_decode($student['course'],true);

                // $arr_course = json_decode($curriculum['course'],true);
                // foreach($arr_course['FLIGHT'] as $k=>$v){
                //   if($v['status']=="ON"){
                //     $text .= "'".$k."',";
                //   }
                // }
                // $text = substr($text,0,-1);
                // if($text){
                //   $course = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_course WHERE code IN ($text) ORDER BY position ASC");
                // }
                // print_r($course);
                // die;

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
table{
  margin-bottom:0px!important;
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
            <br>
            <?php 
            $training_requirement = json_decode($student['training_requirement'],true);
            
            foreach($course as $key=>$val){

            $visible_course = "0";
            if($arr_course['FLIGHT'][$val['code']]['status']=="ON"){
              $visible_course = "1";
            }else if($arr_course['FTD'][$val['code']]['status']=="ON"){
              $visible_course = "1";
            }else if($arr_course['GROUND'][$val['code']]['status']=="ON"){
              $visible_course = "1";
            }
            
            if($visible_course=="1"){

            $no_ground = 0;
            $no_flight = 0;
            $no_ftd = 0;
            $id_course = $val['code'];
            // $ground_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'GROUND' ORDER BY position ASC");
            // $ftd_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FTD' ORDER BY position ASC");
            // $flight_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT' ORDER BY position ASC");
            ?>

<?php 

if(empty($training_requirement['GROUND']['item'][$val['id']]) AND empty($training_requirement['FTD']['item'][$val['id']]) AND empty($training_requirement['FLIGHT']['item'][$val['id']])){
 // $style_parent = "style='display:none;'";
}else{
  $style_parent = "";
}
 // print_r();
?>

          <!-- <div <?=$style_parent?> > -->
          <div>
            <!-- <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="6" style="font-size:15px;" class="text-left"> <label><?=$val['course_code']?> - <?=$val['course_name']?></label>
                </th>
              </tr>
              <?php 

                   if($training_requirement['GROUND']['item'][$val['id']]){
                    $style_parent = "";
                   }else{
                   // $style_parent = "style='display:none;'";
                   }
                    // print_r();
              ?>
              <tr <?=$style_parent?> >
                <th class="text-left" colspan="6">GROUND</th>
              </tr>
              <tr class="bg-success" <?=$style_parent?>>
                <th style="min-width:30px;">
                NO
                </th>
                <th style="min-width:100px;">
                  DATE
                </th>
                <th style="min-width:30px;">
                CODE
                </th>
                <th>
                MISSION
                </th>
                <th style="min-width:50px;">
                TPM
                </th>
                <th style="min-width:50px;">
                  FT
                </th>
              </tr>
              <?php 
              $target_ground = array();
              $total_ground = array();
              
            
            // print_r($total_ground);
            $target_ground = $this->template->sum_time($target_ground);
            $total_ground = $this->template->sum_time($total_ground);
            ?>

              <tr <?=$style_parent?> >
                <th class="text-right" colspan="4">TOTAL</th>
                <th><?=$target_ground?></th>
                <th><?=$total_ground?></th>
              </tr>

              <?php 

if($training_requirement['FTD']['item'][$val['id']]){
 $style_parent = "";
}else{
// $style_parent = "style='display:none;'";
}
 // print_r();
?>
<tr <?=$style_parent?> >

                <th class="text-left" colspan="6">FTD</th>
</tr>
                <tr class="bg-success" <?=$style_parent?>>
                <th>
                NO
                </th>
                <th>
                  DATE
                </th>
                <th>
                CODE
                </th>
                <th>
                MISSION
                </th>
                <th>
                TPM
                </th>
                <th>
                  FT
                </th>
              </tr>
              <?php 
              $total_ftd = array();
              $target_ftd = array();
             
            
            // print_r($total_ground);
            $target_ftd = $this->template->sum_time($target_ftd);
            $total_ftd = $this->template->sum_time($total_ftd);
            ?>

              

              <tr <?=$style_parent?> >
                <th class="text-right" colspan="4">TOTAL</th>
                <th><?=$target_ftd?></th>
                <th><?=$total_ftd?></th>
              </tr>

             
</table> -->
<table style="width:100%;margin-top:15px;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="18" style="font-size:15px;" class="text-left"> <label><?=$val['code_name']?> - <?=$val['name']?></label>
                </th>
              </tr>
</table>



<?php 

if($training_requirement['GROUND']['item'][$val['id']]){
 $style_parent = "";
}else{
// $style_parent = "style='display:none;'";
}
 // print_r();
?>

<table style="width:100%;" class="table table-bordered">
<tr style="background: #ffc28e;">
<th style="font-size:15px;" class="text-left"> <label style="padding-top:5px">GROUND - <?=$val['code_name']?></label>
  <a target="_blank" class="pull-right btn btn-success" href="<?=base_url()?>fitur/download_ftr/ground/<?=$student['id_number']?>/<?=$val['code']?>"><i class="fa fa-print"></i>   DOWNLOAD FTR</a>
  </th>
</tr>
</table>

<?php if($arr_course_selected['GROUND'][$val['code']]['status']=="ON"){ ?>

<table style="width:100%;" class="table table-bordered">

<tr class="bg-success" <?=$style_parent?> >

<th style="width:20px" rowspan="2">NUM</th><th style="min-width:110px;" rowspan="2">DATE</th>
<th rowspan="2">CLASS<br>ROOM</th>
<th rowspan="2">INSTRUCTOR</th>
<th rowspan="2">BATCH</th>
<th rowspan="2">TPM</th>
<th rowspan="2">COURSE</th>
<th rowspan="2">SUBJECT</th><th colspan="3">TIME ACT (UTC)</th> <th rowspan="2">REMARK</th><th rowspan="2">IRREG<br>CODE</th>
 </tr>
 
 <tr class="bg-success" <?=$style_parent?> >
	<th>START</th>
	<th>STOP</th>
	<th>DUR</th>
 </tr>
              <?php 

                $total_flight = array(); $no_flight = 0;
                $target_flight = array();
                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $array_mission = array();
                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $duration_total = array();
                $qry = '"val":"'.$id_student.'"';
                
                $data =  array();
                if($arr_course_selected['GROUND'][$val['code']]['status']=="ON"){
                  $data = $this->mymodel->selectWithQuery("SELECT a.batch, a.tpm, a.course,a.start_act, a.subject,a.tpm,a.instructor,a.classroom, a.stop_act, a.duration_act, a.subject as id_mission, a.remark_report, a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
                  FROM
                  daily_ground_schedule a
                  WHERE a.course= '$id_course' AND a.visibility = '1' AND a.visibility_report = '1' 
                  AND (student_attend LIKE '%$qry%' OR student_other_attend LIKE '%$qry%')  AND duration_act NOT IN ('','-','00:00','0:00')");
                }
              
                $flight_time_total = array();
                $block_time_total = array();
                foreach($data as $key2=>$val2){

                  $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val2['batch']));
                  $val2['batch'] = $dat['batch'];
                 
                  
                  $this->db->select('code_name');
                  $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val2['tpm']));
                  $val2['tpm'] = $dat['code_name'];

                $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['instructor']));

                $val2['instructor'] = $dat['nick_name'];
              
                $dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val2['classroom']));
                
                $val2['classroom'] = $dat['station'].' '.$dat['classroom'];
                
                $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val2['subject'],'type_of_training'=>'GROUND'));
                
                $dat_mission = $dat;

                $temp = $val2['subject'];
                $val2['subject'] = $dat['code_name'].' - '.$dat['name'];
              
                if(($val2['subject']) == ' - '){
                  $val2['subject'] = '<a class="text-red"><b>'.$temp.'</b></a>';
                }

                $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val2['course']));

                  $val2['course'] = $dat['code_name'];
                  
                
                if(!in_array($dat_mission['code'],$array_mission)){
                  array_push($array_mission,$dat_mission['code']);
                }
                
                if (strpos($val2['duration_act'], ':') !== false) {
                  array_push($duration_total,$val2['duration_act']);
                }

                

                  $duration = $this->template->sum_time($duration);

                   $no_flight++;

                ?>
              <tr <?=$style_parent?>>
                <td><?=$no_flight?></td>
                <td><?=DATE('d M Y', strtotime($val2['date']))?></td>
                <td><?=$val2['classroom']?></td>
                <td class="text-left"><?=$val2['instructor']?></td>
                <td class="text-center"><?=$val2['batch']?></td>
                <td class="text-center"><?=$val2['tpm']?></td>
                <td class="text-center"><?=$val2['course']?></td>
                <td class="text-left"><a href="<?=base_url()?>master/daily_attendance_report/edit/<?=$val2['id']?>"><?=$val2['subject']?></a></td>
                <td><?=$val2['start_act']?></td>
                <td><?=$val2['stop_act']?></td>
                <th><?=$val2['duration_act']?></th>
                <th class="text-left"><?=$val2['remark_2']?></th>
                <th><?=$val2['remark_report']?></th>
                
              </tr>

              <?php 
       
               
            } 
           
            // print_r($total_ground);
            $duration_total = $this->template->sum_time($duration_total);
            
            $not = "";
            foreach($array_mission as $keym=>$valm){
              $not .= "'".$valm."',";
            }
            $not = substr($not,0,-1);
            if($not){
              $not = " AND code NOT IN ($not) ";
            }else{
              $not = "";
            }
            $mission = array();
            if($arr_course_selected['GROUND'][$val['code']]['status']=="ON"){
            $mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'GROUND'
            ".$not." 
            ORDER BY position ASC");
            }
            foreach($mission as $key2=>$val2){
            $no_flight++;
            ?>
              <tr <?=$style_parent?> >
                <td><?=$no_flight?></td>
                <td>-</td>
                <td>-</td>  
                <td>-</td>  
                <td>-</td>  
                <td>-</td> 
                <td>-</td> 
                <td class="text-left"><?=$val2['code_name']?> - <?=$val2['name']?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                
              </tr>
            <?php
            }
            ?>

              <tr <?=$style_parent?> >
                <th class="text-right" colspan="10">TTL BLOCK TIME</th>
                <th><?=$duration_total?></th>
                <th colspan="2"></th>
              </tr>
              

            </table>

            <?php }else{ ?>
              <p>NOT SELECTED BY STUDENT</p>
            <?php } ?>


<?php 

if($training_requirement['FTD']['item'][$val['id']]){
 $style_parent = "";
}else{
// $style_parent = "style='display:none;'";
}
 // print_r();
?>

<table style="width:100%;" class="table table-bordered">
<tr style="background: #ffc28e;">
<th style="font-size:15px;" class="text-left"> <label style="padding-top:5px">FTD - <?=$val['code_name']?></label>
  <a target="_blank" class="pull-right btn btn-success" href="<?=base_url()?>fitur/download_ftr/ftd/<?=$student['id_number']?>/<?=$val['code']?>"><i class="fa fa-print"></i>   DOWNLOAD FTR</a>
  </th>
</tr>
</table>

<?php if($arr_course_selected['FTD'][$val['code']]['status']=="ON"){ ?>

<table style="width:100%;" class="table table-bordered">

                <tr class="bg-success" <?=$style_parent?> >

  <th style="width:20px" rowspan="2">NUM</th>
  <th style="min-width:110px" rowspan="2">DATE</th>
  <th rowspan="2">FTD MODEL</th>
  <th rowspan="2">INSTRUCTOR</th><th rowspan="2">2ND</th>
  <th rowspan="2">BATCH</th>
  <th rowspan="2">TPM</th>
  <th rowspan="2">COURSE</th>
  <th rowspan="2">MISSION</th>
  <th colspan="3">BLOCK TIME</th>
  <th rowspan="2">REMARK</th>
  <th rowspan="2">IRREG<br>CODE</th>
</tr>
<tr class="bg-success" <?=$style_parent?> >
  <th>ATD</th>
  <th>ATA</th>
  <th>TOTAL</th>
</tr>
              <?php 
                $total_flight = array(); $no_flight = 0;
                $target_flight = array();
                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $array_mission = array();
                
                $data =  array();
                if($arr_course_selected['FTD'][$val['code']]['status']=="ON"){
                $data = $this->mymodel->selectWithQuery("SELECT *
                FROM daily_ftd_schedule a
                
                WHERE a.visibility = '1' AND a.visibility_report = '1' AND a.course= '$id_course' AND (a.2nd = '$id_student' OR a.pic = '$id_student') AND a.block_time_total NOT IN ('','-','00:00','0:00')");
                }
                $flight_time_total = array();
                $block_time_total = array();
                foreach($data as $key2=>$val2){ 

                  $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val2['batch']));
$val2['batch'] = $dat['batch'];

$this->db->select('code_name');
$dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val2['tpm']));
$val2['tpm'] = $dat['code_name'];


                  

  
                
                  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['pic']));
                  
                  $val2['pic'] = $dat['nick_name'];

                  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['2nd']));

                  $val2['2nd'] = $dat['nick_name'];

                  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['duty_instructor'],'instructor_status'=>'1'));

                  $temp = $val2['duty_instructor'];
                  $val2['duty_instructor'] = $dat['nick_name'];

                  if(empty($val2['duty_instructor'])){
                    $val2['duty_instructor'] = ''.$temp.'';
                  }

                  if(!in_array($val2['mission'],$array_mission)){
                    array_push($array_mission,$val2['mission']);
                  }
                  
                  $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val2['mission'],'type_of_training'=>'FTD'));

                  $dat_mission = $dat;

                  $temp = $val2['mission'];
                  $val2['mission'] = $dat['code_name'].' - '.$dat['name'];
                
                  if(($val2['mission']) == ' - '){
                    $val2['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
                  }


                  $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val2['course']));

                  $val2['course'] = $dat['code_name'];

                 
             
                if (strpos($val2['block_time_total'], ':') !== false) {
                  array_push($block_time_total,$val2['block_time_total']);
                }

                
                if (strpos($val2['flight_time_total'], ':') !== false) {
                  array_push($flight_time_total,$val2['flight_time_total']);
                }


                  $duration = $this->template->sum_time($duration);

                   $no_flight++;

                   if(!in_array($dat_mission['code'],$array_mission)){
                    array_push($array_mission,$dat_mission['code']);
                  }

                ?>
              <tr <?=$style_parent?>>
                <td><?=$no_flight?></td>
                <td><?=DATE('d M Y', strtotime($val2['date']))?></td>
                <td><?=$val2['ftd_model']?></td>
                <td><?=$val2['pic']?></td>
                <td><?=$val2['2nd']?></td>
                <td class="text-center"><?=$val2['batch']?></td>
                <td class="text-center"><?=$val2['tpm']?></td>
                <td><?=$val2['course']?></td>
                <td class="text-left"><a href="<?=base_url()?>master/daily_ftd_report/edit/<?=$val2['id']?>"><?=$val2['mission']?></a></td>
                <td><?=$val2['block_time_atd']?></td>
                <td><?=$val2['block_time_ata']?></td>
                <th><?=$val2['block_time_total']?></th>
                <th class="text-left" ><?=$val2['remark_2']?></th>
                <th><?=$val2['remark_report']?></th>
                
              </tr>

              <?php 
       
               
            } 
           
            // print_r($total_ground);
            $block_time_total = $this->template->sum_time($block_time_total);
            $flight_time_total = $this->template->sum_time($flight_time_total);
            
            $not = "";
            foreach($array_mission as $keym=>$valm){
              $not .= "'".$valm."',";
            }
            $not = substr($not,0,-1);
            if($not){
              $not = " AND code NOT IN ($not) ";
            }else{
              $not = "";
            }
            $mission = array();
            if($arr_course_selected['FTD'][$val['code']]['status']=="ON"){
            $mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FTD'
            ".$not." 
            ORDER BY position ASC");
            }

            // echo "SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FTD'
            // ".$not." 
            // ORDER BY position ASC";

            foreach($mission as $key2=>$val2){
            $no_flight++;
            ?>
              <tr <?=$style_parent?> >
                <td><?=$no_flight?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>  <td>-</td> <td>-</td><td>-</td>
                <td class="text-left"><?=$val2['code_name']?> - <?=$val2['name']?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                
              </tr>
            <?php
            }
            ?>

              <tr <?=$style_parent?> >
                <th class="text-right" colspan="11">TTL BLOCK TIME</th>
                <th><?=$block_time_total?></th>
                <th colspan="2"></th>
              </tr>
              

            </table>

            <?php }else{ ?>
    <p>NOT SELECTED BY STUDENT</p>
  <?php } ?>

            
<?php 

if($training_requirement['FLIGHT']['item'][$val['id']]){
 $style_parent = "";
}else{
// $style_parent = "style='display:none;'";
}
 // print_r();
?>


<table style="width:100%;" class="table table-bordered">
<tr style="background: #ffc28e;">
  <th style="font-size:15px;" class="text-left"> <label style="padding-top:5px">FLIGHT - <?=$val['code_name']?></label>
  <a target="_blank" class="pull-right btn btn-success" href="<?=base_url()?>fitur/download_ftr/flight/<?=$student['id_number']?>/<?=$val['code']?>"><i class="fa fa-print"></i>   DOWNLOAD FTR</a>
  </th>
</tr>
</table>


<!-- <br> -->
<div class="table-responsive">

<?php if($arr_course_selected['FLIGHT'][$val['code']]['status']=="ON"){ ?>

<table style="width:100%;" class="table table-bordered">

                <tr class="bg-success" <?=$style_parent?> >

<th style="width:20px" rowspan="2">NUM</th><th style="min-width:110px" rowspan="2">DATE OF<br>FLIGHT</th><th rowspan="2">ORIGIN<br>BASE</th><th rowspan="2">AIRCRAFT<br>REG</th><th rowspan="2">PIC</th><th rowspan="2">2ND</th>
<th rowspan="2">BATCH</th>
<th rowspan="2">TPM</th>
<th rowspan="2">COURSE</th>
<th rowspan="2">MISSION</th>
<!-- <th rowspan="2">DESCRIPTION</th> -->
<th rowspan="2">RUTE</th><th rowspan="2">DEP</th><th rowspan="2">ARR</th>
<th colspan="3">
  BLOCK TIME
</th>
<th colspan="3">
  FLIGHT TIME
</th>
<th rowspan="2">TOTAL<br>LDG</th>

<th rowspan="2">REMARK</th>
<th rowspan="2">IRREG<br>CODE</th>
<th rowspan="2">DUTY<br>INSTRUCTOR</th>


</tr>
<tr class="bg-success" <?=$style_parent?> >

<th style="min-width:50px;">
  START
</th>
<th style="min-width:50px;">
  STOP
</th>
<th style="min-width:50px;">
  TOTAL
</th>
<th style="min-width:50px;">
  T/OFF
</th>
<th style="min-width:50px;">
  LDG
</th>
<th style="min-width:50px;">
  TOTAL
</th>
</tr>
              <?php 

                $array_mission_done_text = "'ks', ";

                $total_flight = array(); $no_flight = 0;
                $target_flight = array();
                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $array_mission = array();
                
                $data =  array();
                if($arr_course_selected['FLIGHT'][$val['code']]['status']=="ON"){
                  $data = $this->mymodel->selectWithQuery("SELECT *
                  FROM daily_flight_schedule a
                  WHERE a.visibility = '1' AND a.visibility_report = '1' AND a.course= '$id_course' AND (a.2nd = '$id_student' OR a.pic = '$id_student') AND a.block_time_total NOT IN ('','-','00:00','0:00')
                  ORDER BY date_of_flight ASC, block_time_start ASC
                  ");
                }
           
                $flight_time_total = array();
                $block_time_total = array();
                foreach($data as $key2=>$val2){

                  $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val2['batch']));
                  $val2['batch'] = $dat['batch'];
                  $this->db->select('code_name');
                  $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val2['tpm']));
                  $val2['tpm'] = $dat['code_name'];

                  
                  $pic = $val2['pic'];
                  $pic = $this->mymodel->selectWithQuery("SELECT instructor_status FROM user WHERE id_number = '$pic'");
                  $pic = $pic[0]['instructor_status'];
                  $nd = $val2['2nd'];
                  $nd = $this->mymodel->selectWithQuery("SELECT instructor_status FROM user WHERE id_number = '$nd'");
                  $nd = $nd[0]['instructor_status'];
                  if($pic=='1'){
                    $pass = '1';
                    if (strpos($val2['block_time_total'], ':') !== false) {
                      array_push($block_time_total,$val2['block_time_total']);
                    }
    
                    
                    if (strpos($val2['flight_time_total'], ':') !== false) {
                      array_push($flight_time_total,$val2['flight_time_total']);
                    }
                  }else if($pic!='1'){
                    if($val2['pic']==$id_student){
                      $pass = '1';
                      if (strpos($val2['block_time_total'], ':') !== false) {
                        array_push($block_time_total,$val2['block_time_total']);
                      }
      
                      
                      if (strpos($val2['flight_time_total'], ':') !== false) {
                        array_push($flight_time_total,$val2['flight_time_total']);
                      }
                      // echo ($key2+1).' - '.$id_student.' - '.$val2['pic'].' - '.$val2['2nd'].'<br>';
                    }else{
                      $pass = '0';
                      $data_out[] = $val2;
                      // echo ($key2+1).' - '.$id_student.' - '.$val2['pic'].' - '.$val2['2nd'].'<br>';
                    }
                  }

                  // echo '123 - '.$id_student.' - ';
                
                  if(!in_array($val2['mission'],$array_mission)){
                    array_push($array_mission,$val2['mission']);
                    $array_mission_done_text .= "'".$val2['mission']."', ";
                  }
                  
                  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['pic']));
                  
                  $val2['pic'] = $dat['nick_name'];

                  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['2nd']));

                  $val2['2nd'] = $dat['nick_name'];

                  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['duty_instructor'],'instructor_status'=>'1'));

                  $temp = $val2['duty_instructor'];
                  $val2['duty_instructor'] = $dat['nick_name'];

                  if(empty($val2['duty_instructor'])){
                    $val2['duty_instructor'] = ''.$temp.'';
                  }

                  $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val2['mission'],'type_of_training'=>'FLIGHT'));

                  $dat_mission = $dat;

                  $temp = $val2['mission'];
                  $val2['mission'] = $dat['code_name'].' - '.$dat['name'];
                
                  if(($val2['mission']) == ' - '){
                    $val2['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
                  }

                  $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val2['course']));

                  $val2['course'] = $dat['code_name'];
                
             
               


                  $duration = $this->template->sum_time($duration);

                   $no_flight++;

                 
                   if(!in_array($dat_mission['code'],$array_mission)){
                    array_push($array_mission,$dat_mission['code']);
                  }
                  
                
                  if($pass=='1'){
                ?>
              <tr <?=$style_parent?>>
                <td><?=$no_flight?></td>
                <td><?=DATE('d M Y', strtotime($val2['date_of_flight']))?></td>
                <td><?=$val2['origin_base']?></td>
                <td><?=$val2['aircraft_reg']?></td>
                <td><?=$val2['pic']?></td>
                <td><?=$val2['2nd']?></td>
                <td class="text-center"><?=$val2['batch']?></td>
                <td class="text-center"><?=$val2['tpm']?></td>
                <td><?=$val2['course']?></td>
                <td class="text-left"><a href="<?=base_url()?>master/daily_movement_report/edit/<?=$val2['id']?>"><?=$val2['mission']?></a></td>
                <td class="text-left"><?=$val2['rute']?></td>
                <td><?=$val2['dep']?></td>
                <td><?=$val2['arr']?></td>
                <td><?=$val2['block_time_start']?></td>
                <td><?=$val2['block_time_stop']?></td>
                <th><b><?=$val2['block_time_total']?></b></th>
                <td><?=$val2['flight_time_take_off']?></td>
                <td><?=$val2['flight_time_landing']?></td>
                <th><?=$val2['flight_time_total']?></th>
                <td><?=$val2['ldg']?></td>
                <td class="text-left"><?=$val2['remark_2']?></td>
                <td><?=$val2['remark_report']?></td>
                <td class="text-left"><?=$val2['duty_instructor']?></td>
                
              </tr>

              <?php 
       
              }
            } 

            $array_mission_done_text = substr($array_mission_done_text,0,-2);

            $block_time_total = $this->template->sum_time($block_time_total);
            $flight_time_total = $this->template->sum_time($flight_time_total);
            
            
            $not = "";
            foreach($array_mission as $keym=>$valm){
              $not .= "'".$valm."',";
            }
            $not = substr($not,0,-1);
            if($not){
              $not = " AND code NOT IN ($not) ";
            }else{
              $not = "";
            }
            $mission = array();
            if($arr_course_selected['FLIGHT'][$val['code']]['status']=="ON"){
            $mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT'
            ".$not." 
            ORDER BY position ASC");
            }

            // echo "SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT'
            // ".$not." 
            // ORDER BY position ASC";

            
            foreach($mission as $key2=>$val2){
            $no_flight++;
            ?>
              <tr <?=$style_parent?> >
                <td><?=$no_flight?></td>
                <td>-</td>
                <td>-</td>  <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td><td>-</td>
                <td class="text-left"><?=$val2['code_name']?> - <?=$val2['name']?></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                
              </tr>
            <?php
            }
            ?>

              <tr <?=$style_parent?> >
                <th class="text-right" colspan="15">TTL BLOCK TIME</th>
                <th><b><?=$block_time_total?></b></th>
                <th class="text-right" colspan="2">TTL FLT TIME</th>
                <th><b><?=$flight_time_total?></b></th>
                <th colspan="5"></th>
              </tr>
              

            </table>

            <?php }else{ ?>
    <p>NOT SELECTED BY STUDENT</p>
  <?php } ?>

            </div>
            
            <?php if($data_out){ ?>
            <br>
            <label for="">SECOND IN COMMAND / SIC</label>
            <div class="table-responsive">
            <?php if($arr_course_selected['GROUND'][$val['code']]['status']=="ON"){ ?>
              <table class="table">
              <tr class="bg-success" <?=$style_parent?> >

<th style="width:20px" rowspan="2">NUM</th><th style="min-width:110px" rowspan="2">DATE OF<br>FLIGHT</th><th rowspan="2">ORIGIN<br>BASE</th><th rowspan="2">AIRCRAFT<br>REG</th><th rowspan="2">PIC</th><th rowspan="2">2ND</th>
<th rowspan="2">BATCH</th>
<th rowspan="2">TPM</th>
<th rowspan="2">COURSE</th>
<th rowspan="2">MISSION</th>
<!-- <th rowspan="2">DESCRIPTION</th> -->
<th rowspan="2">RUTE</th><th rowspan="2">DEP</th><th rowspan="2">ARR</th>
<th colspan="3">
  BLOCK TIME
</th>
<th colspan="3">
  FLIGHT TIME
</th>
<th rowspan="2">TOTAL<br>LDG</th>

<th rowspan="2">REMARK</th>
<th rowspan="2">IRREG<br>CODE</th>
<th rowspan="2">DUTY<br>INSTRUCTOR</th>


</tr>
<tr class="bg-success" <?=$style_parent?> >

<th style="min-width:50px;">
  START
</th>
<th style="min-width:50px;">
  STOP
</th>
<th style="min-width:50px;">
  TOTAL
</th>
<th style="min-width:50px;">
  T/OFF
</th>
<th style="min-width:50px;">
  LDG
</th>
<th style="min-width:50px;">
  TOTAL
</th>
</tr>
              <?php 
              $no_flight = 0;
              $block_time_total = array();
              $flight_time_total = array();

              foreach($data_out as $key2=>$val2){
                if(!in_array($val2['mission'],$array_mission)){
                  array_push($array_mission,$val2['mission']);
                  $array_mission_done_text .= "'".$val2['mission']."', ";
                }
                

$dat = $this->mymodel->selectDataOne('batch',array('code'=>$val2['batch']));
$val2['batch'] = $dat['batch'];

$this->db->select('code_name');
$dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val2['tpm']));
$val2['tpm'] = $dat['code_name'];

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['pic']));

$val2['pic'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['2nd']));

$val2['2nd'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val2['duty_instructor'],'instructor_status'=>'1'));

$temp = $val2['duty_instructor'];
$val2['duty_instructor'] = $dat['nick_name'];

if(empty($val2['duty_instructor'])){
  $val2['duty_instructor'] = ''.$temp.'';
}

$dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val2['mission'],'type_of_training'=>'FLIGHT'));

$dat_mission = $dat;

$temp = $val2['mission'];
$val2['mission'] = $dat['code_name'].' - '.$dat['name'];

if(($val2['mission']) == ' - '){
  $val2['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val2['course']));

$val2['course'] = $dat['code_name'];
              
           
              if (strpos($val2['block_time_total'], ':') !== false) {
                array_push($block_time_total,$val2['block_time_total']);
              }

              
              if (strpos($val2['flight_time_total'], ':') !== false) {
                array_push($flight_time_total,$val2['flight_time_total']);
              }


                $duration = $this->template->sum_time($duration);

                 $no_flight++;


                 if(!in_array($dat_mission['code'],$array_mission)){
                  array_push($array_mission,$dat_mission['code']);
                }

                ?>
                <tr <?=$style_parent?>>
                <td><?=$no_flight?></td>
                <td><?=DATE('d M Y', strtotime($val2['date_of_flight']))?></td>
                <td><?=$val2['origin_base']?></td>
                <td><?=$val2['aircraft_reg']?></td>
                <td><?=$val2['pic']?></td>
                <td><?=$val2['2nd']?></td>
                <td><?=$val2['batch']?></td>
                <td><?=$val2['tpm']?></td>
                <td><?=$val2['course']?></td>
                <td class="text-left"><a href="<?=base_url()?>master/daily_movement_report/edit/<?=$val2['id']?>"><?=$val2['mission']?></a></td>
                <td class="text-left"><?=$val2['rute']?></td>
                <td><?=$val2['dep']?></td>
                <td><?=$val2['arr']?></td>
                <td><?=$val2['block_time_start']?></td>
                <td><?=$val2['block_time_stop']?></td>
                <th><b><?=$val2['block_time_total']?></b></th>
                <td><?=$val2['flight_time_take_off']?></td>
                <td><?=$val2['flight_time_landing']?></td>
                <th><?=$val2['flight_time_total']?></th>
                <td><?=$val2['ldg']?></td>
                <td class="text-left"><?=$val2['remark_2']?></td>
                <td><?=$val2['remark_report']?></td>
                <td class="text-left"><?=$val2['duty_instructor']?></td>
                
              </tr>
              <?php }
              
              $block_time_total = $this->template->sum_time($block_time_total);
              $flight_time_total = $this->template->sum_time($flight_time_total);
              ?>

              <tr <?=$style_parent?> >
                <th class="text-right" colspan="15">TTL BLOCK TIME</th>
                <th><b><?=$block_time_total?></b></th>
                <th class="text-right" colspan="2">TTL FLT TIME</th>
                <th><b><?=$flight_time_total?></b></th>
                <th colspan="5"></th>
              </tr>

              </table>

              <?php }else{ ?>
    <p>NOT SELECTED BY STUDENT</p>
  <?php } ?>

            </div>
            
                  </div>
<br>
            <?php }}} ?>
            
            
                    



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


