<?php
                $id = $this->uri->segment(4);
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
                <th colspan="3" style="font-size:15px;padding:5px 0px;" class="text-left">CURRENT BATCH</th>
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
            $no_ground = 0;
            $no_flight = 0;
            $no_ftd = 0;
            $id_course = $val['code'];
            $ground_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'GROUND' ORDER BY mission_number ASC");
            $ftd_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'SIM' ORDER BY mission_number ASC");
            $flight_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT' ORDER BY mission_number ASC");
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
            <!-- <table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="6" style="font-size:15px;" class="text-left"> <label><?=$val['course_code']?> - <?=$val['course_name']?></label>
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
              foreach($ground_mission as $key2=>$val2){ 
                 
                 $id_student = $student['id_number']; 
                 $id_mission = $val2['code'];
                 $total = array();
                 $qry = '{"attend":"'.$id_student.'"}';
                 $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule WHERE subject = '$id_mission' AND student_attend LIKE '%$qry%' AND visibility = '1' AND visibility_report = '1' ");
                 $date_report = '';
                 foreach($data as $key3=>$val3){
                   if (strpos($val3['duration'], ':') !== false) {
                     array_push($total,$val3['duration']);
                    $date_report .= '<a href="'.base_url().'master/daily_attendance_report/edit/'.$val3['id'].'">'.DATE('d M Y', strtotime($val3['date'])).'</a><br>';
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
                   $no_ground++;

                ?>
                <tr <?=$style_parent?> >
                <td><?=$no_ground?></td>
                <td><?=$date_report?></td>
                <td><?=$val2['subject_mission']?></td>
                <td class="text-left"><?=$val2['name']?></td>
                  <td><?=$duration?></td>
                  <td <?=$style_status?> ><?=$total?></td>
                
              </tr>
              <?php 
                array_push($target_ground,$duration);
                array_push($total_ground,$total);
            } 
            
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
 $style_parent = "style='display:none;'";
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
              foreach($ftd_mission as $key2=>$val2){
                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule WHERE mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') ");
                $date_report = '';
                foreach($data as $key3=>$val3){
                  if (strpos($val3['block_time_total'], ':') !== false) {
                    array_push($total,$val3['block_time_total']);
                    $date_report .= '<a href="'.base_url().'master/daily_ftd_report/edit/'.$val3['id'].'">'.DATE('d M Y', strtotime($val3['date'])).'</a><br>';
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
                   $no_ftd++;
                ?>
                <tr <?=$style_parent?>>
                <td><?=$no_ftd?></td>
                <td><?=$date_report?></td>
                <td><?=$val2['subject_mission']?></td>
                <td class="text-left"><?=$val2['name']?></td>
                <td><?=$val2['duration']?></td>
                <td <?=$style_status?> ><?=$total?></td>
                
              </tr>
              <?php 
                array_push($target_ftd,$duration);
                array_push($total_ftd,$total);
            } 
            
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
<table style="width:100%;" class="table table-bordered">
              <tr class="bg-orange">
                <th colspan="18" style="font-size:15px;" class="text-left"> <label><?=$val['course_code']?> - <?=$val['course_name']?></label>
                </th>
              </tr>
</table>



<?php 

if($training_requirement['GROUND']['item'][$val['id']]){
 $style_parent = "";
}else{
 $style_parent = "style='display:none;'";
}
 // print_r();
?>

<div <?=$style_parent?> >
<label>GROUND</label>
</div>


<table style="width:100%;" class="table table-bordered">

                <tr class="bg-success" <?=$style_parent?> >

<th style="width:20px" rowspan="2">NUM</th><th style="min-width:110px;" rowspan="2">DATE</th>
<th rowspan="2">CLASS<br>ROOM</th>
<th rowspan="2">INSTRUCTOR</th><th rowspan="2">SUBJECT</th><th colspan="3">TIME ACT (UTC)</th> <th rowspan="2">REMARK</th><th rowspan="2">IRREG<br>CODE</th>
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
                $qry = '{"attend":"'.$id_student.'"}';
                
                $data = $this->mymodel->selectWithQuery("SELECT a.start_act, a.stop_act, a.duration_act, a.subject as id_mission, a.remark_report, a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,g.batch, CONCAT(c.base,' (',b.classroom,')') as classroom,d.course_code as course,CONCAT(e.subject_mission,' - ',e.description) as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
                FROM
                daily_ground_schedule a
                LEFT JOIN classroom b
                ON a.classroom = b.id
                LEFT JOIN base_airport_document c
                ON b.station = c.id
                LEFT JOIN course d
                ON a.course = d.id
                LEFT JOIN tpm_syllabus_all_course e
                ON a.subject = e.id
                LEFT JOIN user f
                ON a.instructor = f.id
                LEFT JOIN batch g
                ON a.batch = g.id
                LEFT JOIN base_airport_document h
                ON b.station = h.id
                WHERE a.course= '$id_course' AND a.visibility = '1' AND a.visibility_report = '1' 
                AND student_attend LIKE '%$qry%' AND duration_act NOT IN ('','-','00:00','0:00')");
                
                $flight_time_total = array();
                $block_time_total = array();
                foreach($data as $key2=>$val2){ 
                if(!in_array($val2['id_mission'],$array_mission)){
                  array_push($array_mission,$val2['id_mission']);
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
                <td class="text-left"><?=$val2['subject']?></td>
                <td><?=$val2['start_act']?></td>
                <td><?=$val2['stop_act']?></td>
                <th><?=$val2['duration_act']?></th>
                <th class="text-left"><?=$val2['remark']?></th>
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
              $not = " AND id NOT IN ($not) ";
            }else{
              $not = "";
            }
            $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'GROUND'
            ".$not." 
            ORDER BY position ASC");
            foreach($mission as $key2=>$val2){
            $no_flight++;
            ?>
              <tr <?=$style_parent?> >
                <td><?=$no_flight?></td>
                <td>-</td>
                <td>-</td>  <td>-</td> 
                <td class="text-left"><?=$val2['subject_mission']?>. <?=$val2['description']?></td>
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
                <th class="text-right" colspan="7">TOTAL BLOCK TIME</th>
                <th><?=$duration_total?></th>
                <th colspan="2"></th>
              </tr>
              

            </table>



<?php 

if($training_requirement['FTD']['item'][$val['id']]){
 $style_parent = "";
}else{
 $style_parent = "style='display:none;'";
}
 // print_r();
?>

<div <?=$style_parent?> >
<label>FTD</label>
</div>


<table style="width:100%;" class="table table-bordered">

                <tr class="bg-success" <?=$style_parent?> >

  <th style="width:20px" rowspan="2">NUM</th>
  <th style="min-width:110px" rowspan="2">DATE</th>
  <th rowspan="2">FTD MODEL</th>
  <th rowspan="2">INSTRUCTOR</th><th rowspan="2">STUDENT</th>
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
                $data = $this->mymodel->selectWithQuery("SELECT e.*, a.mission as id_mission, a.id,a.block_time_ata, a.block_time_atd, a.block_time_total,a.remark_report, a.date, CONCAT(h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,CONCAT(e.subject_mission,' - ',e.description) as mission,e.description as mission_name
                FROM daily_ftd_schedule a
                LEFT JOIN batch c
                ON a.batch = c.id
                LEFT JOIN course d
                ON a.course = d.id
                LEFT JOIN tpm_syllabus_all_course e
                ON a.mission = e.id
                LEFT JOIN user f
                ON a.pic = f.id
                LEFT JOIN user g
                ON a.2nd = g.id
                LEFT JOIN synthetic_training_devices_document h
                ON a.ftd_model = h.id
                WHERE a.visibility = '1' AND a.visibility_report = '1' AND a.course= '$id_course' AND (a.2nd = '$id_student' OR a.pic = '$id_student') AND a.block_time_total NOT IN ('','-','00:00','0:00')");
                
                $flight_time_total = array();
                $block_time_total = array();
                foreach($data as $key2=>$val2){ 
                if(!in_array($val2['id_mission'],$array_mission)){
                  array_push($array_mission,$val2['id_mission']);
                }
             
                if (strpos($val2['block_time_total'], ':') !== false) {
                  array_push($block_time_total,$val2['block_time_total']);
                }

                
                if (strpos($val2['flight_time_total'], ':') !== false) {
                  array_push($flight_time_total,$val2['flight_time_total']);
                }


                  $duration = $this->template->sum_time($duration);

                   $no_flight++;

                ?>
              <tr <?=$style_parent?>>
                <td><?=$no_flight?></td>
                <td><?=DATE('d M Y', strtotime($val2['date']))?></td>
                <td><?=$val2['ftd_model']?></td>
                <td><?=$val2['pic']?></td>
                <td><?=$val2['2nd']?></td>
                <td class="text-left"><?=$val2['mission']?></td>
                <td><?=$val2['block_time_atd']?></td>
                <td><?=$val2['block_time_ata']?></td>
                <th><?=$val2['block_time_total']?></th>
                <th class="text-left" ><?=$val2['remark']?></th>
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
              $not = " AND id NOT IN ($not) ";
            }else{
              $not = "";
            }
            $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'SIM'
            ".$not." 
            ORDER BY position ASC");
            foreach($mission as $key2=>$val2){
            $no_flight++;
            ?>
              <tr <?=$style_parent?> >
                <td><?=$no_flight?></td>
                <td>-</td>
                <td>-</td>  <td>-</td> <td>-</td>
                <td class="text-left"><?=$val2['subject_mission']?>. <?=$val2['description']?></td>
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
                <th class="text-right" colspan="8">TOTAL BLOCK TIME</th>
                <th><?=$block_time_total?></th>
                <th colspan="2"></th>
              </tr>
              

            </table>

            
<?php 

if($training_requirement['FLIGHT']['item'][$val['id']]){
 $style_parent = "";
}else{
 $style_parent = "style='display:none;'";
}
 // print_r();
?>


<div <?=$style_parent?> >
<label>FLIGHT</label>
<a target="_blank" class="pull-right btn btn-success" href="<?=base_url()?>fitur/download_ftr/<?=$student['nick_name']?>/<?=$val['code']?>"><i class="fa fa-print"></i>   DOWNLOAD FTR</a>
</div>
<br>
<table style="width:100%;" class="table table-bordered">

                <tr class="bg-success" <?=$style_parent?> >

<th style="width:20px" rowspan="2">NO</th><th style="min-width:110px" rowspan="2">DATE OF<br>FLIGHT</th><th rowspan="2">ORIGIN<br>BASE</th><th rowspan="2">AIRCRAFT<br>REG</th><th rowspan="2">PIC</th><th rowspan="2">2ND</th>
<th rowspan="2">BATCH</th>
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
                $total_flight = array(); $no_flight = 0;
                $target_flight = array();
                $id_student = $student['id_number']; 
                $id_mission = $val2['code'];
                $total = array();
                $array_mission = array();
                $data = $this->mymodel->selectWithQuery("SELECT *
                
                FROM daily_flight_schedule a
                
                WHERE a.visibility = '1' AND a.visibility_report = '1' AND a.course= '$id_course' AND (a.2nd = '$id_student' OR a.pic = '$id_student') AND a.block_time_total NOT IN ('','-','00:00','0:00')");
           
                $flight_time_total = array();
                $block_time_total = array();
                foreach($data as $key2=>$val2){ 

                  
  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val2['pic']));
  
  $val2['pic'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val2['2nd']));

  $val2['2nd'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val2['duty_instructor']));

  $val2['duty_instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val2['mission'],'type_of_training'=>'FLIGHT'));

  $val2['mission'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val2['course']));

  $val2['course'] = $dat['course_code'];
                if(!in_array($val2['id_mission'],$array_mission)){
                  array_push($array_mission,$val2['id_mission']);
                }
             
                if (strpos($val2['block_time_total'], ':') !== false) {
                  array_push($block_time_total,$val2['block_time_total']);
                }

                
                if (strpos($val2['flight_time_total'], ':') !== false) {
                  array_push($flight_time_total,$val2['flight_time_total']);
                }


                  $duration = $this->template->sum_time($duration);

                   $no_flight++;

                ?>
              <tr <?=$style_parent?>>
                <td><?=$no_flight?></td>
                <td><?=DATE('d M Y', strtotime($val2['date_of_flight']))?></td>
                <td><?=$val2['origin_base']?></td>
                <td><?=$val2['aircraft_reg']?></td>
                <td><?=$val2['pic']?></td>
                <td><?=$val2['2nd']?></td>
                <td><?=$val2['batch']?></td>
                <td><?=$val2['course']?></td>
                <td class="text-left"><?=$val2['mission']?></td>
                <td class="text-left"><?=$val2['rute']?></td>
                <td><?=$val2['dep']?></td>
                <td><?=$val2['arr']?></td>
                <td><?=$val2['block_time_start']?></td>
                <td><?=$val2['block_time_stop']?></td>
                <th><?=$val2['block_time_total']?></th>
                <td><?=$val2['flight_time_take_off']?></td>
                <td><?=$val2['flight_time_landing']?></td>
                <th><?=$val2['flight_time_total']?></th>
                <td><?=$val2['ldg']?></td>
                <td class="text-left"><?=$val2['remark']?></td>
                <td><?=$val2['remark_dmr']?></td>
                <td class="text-left"><?=$val2['duty_instructor']?></td>
                
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
              $not = " AND id NOT IN ($not) ";
            }else{
              $not = "";
            }
            $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT'
            ".$not." 
            ORDER BY position ASC");
            foreach($mission as $key2=>$val2){
            $no_flight++;
            ?>
              <tr <?=$style_parent?> >
                <td><?=$no_flight?></td>
                <td>-</td>
                <td>-</td>  <td>-</td> <td>-</td> <td>-</td> <td>-</td> <td>-</td>
                <td class="text-left"><?=$val2['subject_mission']?>. <?=$val2['description']?></td>
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
                <th class="text-right" colspan="12">TOTAL BLOCK TIME</th>
                <th><?=$block_time_total?></th>
                <th class="text-right" colspan="2">TOTAL FLIGHT</th>
                <th><?=$flight_time_total?></th>
                <th colspan="5"></th>
              </tr>
              

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


