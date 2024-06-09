<style>
.complete{
  color : green;
  /* color:#000; */
}
.not-complete{
  color: red;
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
              STUDENT PROGRESS REPORT
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            
            <div class="box-body">

            
               <!-- FILTER  -->
               <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>report/student_progress_report/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>SELECT BATCH</label>
                                            <select style='width:100%' name="batch" class="form-control select2" id="batch">
                                              <option value="">SELECT BATCH</option>
                                                <?php 
                                                  $this->db->order_by('batch ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('batch',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['id']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['id']."' ".$text." >".$base_airport_document_record['batch']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">

                      <label for="form-course">COURSE</label>

                      <select style='width:100%' name="course" class="form-control select2" id="course">
                      <option value="">SELECT COURSE</option>
                      <?php 

                      $batch = $this->mymodel->selectDataOne('batch', array('id'=>$_SESSION['batch']));
                      $curriculum = $this->mymodel->selectDataOne('curriculum', array('id'=>$batch['curriculum']));
                      $curriculum = $curriculum['id'];
                      $this->db->order_by('position','ASC');
                        $tpm_syllabus_all_course = $this->mymodel->selectWhere('course',array('curriculum'=>$curriculum));

                        foreach ($tpm_syllabus_all_course as $val) {

                          $text="";

                          if($val['id']==$_SESSION['course']){

                            $text = "selected";

                          }



                          echo "<option value='".$val['id']."' ".$text." >".$val['course_code']."</option>";

                        }

                        ?>

                      </select>

                  </div>
                  
                
                                
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <button class="btn btn-success btn-block"><i class="mdi mdi-database-search"></i> FILTER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->
            </div>

            <?php
            
            $batch = $_SESSION['batch'];

            $student = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE instructor_status != '1' AND batch = '$batch'");

            

            $batch = $this->mymodel->selectDataOne('batch',array('id'=>$batch));

            $curriculum = $this->mymodel->selectDataOne('curriculum',array('id'=>$batch['curriculum']));
            
            $id_curriculum = $curriculum['id'];

            $text1 = '{"val":"GROUND"}';

            $text2 = '{"val":"SIM"}';
            
            $text3 = '{"val":"FLIGHT"}';
            if($_SESSION['course']){
              $id_course = $_SESSION['course'];
              $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' AND id = '$id_course'
              AND (configuration LIKE '%$text1%' OR configuration LIKE '%$text2%' OR configuration LIKE '%$text3%') ORDER BY position ASC");
            }else{
              $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' 
              AND (configuration LIKE '%$text1%' OR configuration LIKE '%$text2%' OR configuration LIKE '%$text3%') ORDER BY position ASC");
            }
            
            
        // print_r($mission_parent);


            ?>

          <?php
          if($_SESSION['batch']){ 
          

            
          foreach($course as $key=>$val){ 
          
            $id_course = $val['id'];
            $count = 0;
            $mission_parent = $this->mymodel->selectWithQuery("SELECT * FROM 	tpm_syllabus_all_course WHERE curriculum = '$id_curriculum' AND course = '$id_course' AND type_of_training = 'FLIGHT'  GROUP BY type_of_training2  ORDER BY position ASC");
            // echo count($mission_parent);

            
            foreach($mission_parent as $key2=>$val2){ 
             
              $type_of_training = $val2['type_of_training2'];  
              $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	tpm_syllabus_all_course WHERE curriculum = '$id_curriculum' AND course = '$id_course'  AND type_of_training2 = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_of_training_type2 ORDER BY position ASC");
              
              ;
              
              foreach($mission_parent_child as $key3=>$val3){ 

              $duration_dual_flight = array();
              $duration_solo_flight = array();
              $duration_solo_svp_flight = array();
              $duration_pic_flight = array();

                $count++;
                $type_of_training = $val2['type_of_training2']; 
                $type_of_training_type = $val3['type_of_training_type2'];
                $flight_mission_child_item = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type_of_training2 = '$type_of_training' AND type_of_training_type2 = '$type_of_training_type' ORDER BY mission_number ASC");
                foreach($flight_mission_child_item as $keymci => $valmci){
                 
                  if (strpos($valmci['duration_dual'], ':') !== false) {
                   
                    array_push($duration_dual_flight,$valmci['duration_dual']);
                  }
                  if (strpos($valmci['duration_solo'], ':') !== false) {
                    array_push($duration_solo_flight,$valmci['duration_solo']);
                    
                  }
                  if (strpos($valmci['duration_pic'], ':') !== false) {
                   
                    array_push($duration_pic_flight,$valmci['duration_pic']);
                  }
                  if (strpos($valmci['duration_pic_solo'], ':') !== false) {
                   
                    array_push($duration_solo_svp_flight,$valmci['duration_pic_solo']);
                  }
              }

              // print_r($duration_dual_flight);

              $a = array();
              
              $a[0] = $this->template->sum_time($duration_dual_flight);
              $a[1] = $this->template->sum_time($duration_pic_flight);
              $a[2] = $this->template->sum_time($duration_solo_svp_flight);
              $a[3] = $this->template->sum_time($duration_solo_flight);
              
              $a = $this->template->sum_time($a);

              $flight_target[$id_course][$type_of_training][$type_of_training_type] = $a;
             

              }

             

            }



            $parent =  (($count+3)*3)+3;

            // echo $count;

            $ground_target = array();

            $ground_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'GROUND' ORDER BY mission_number ASC");
            foreach($ground_mission as $keym=>$valm){
              if (strpos($valm['duration'], ':') !== false) {
                array_push($ground_target,$valm['duration']);
              }
            }

             $ground_target[$id_course] = $this->template->sum_time($ground_target);


             $ftd_target = array();

             $ftd_mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'SIM' ORDER BY mission_number ASC");
             foreach($ftd_mission as $keym=>$valm){
               if (strpos($valm['duration'], ':') !== false) {
                 array_push($ftd_target,$valm['duration']);
               }
             }
 
              $ftd_target[$id_course] = $this->template->sum_time($ftd_target);


              
          ?>

          <div class="box-body">
            <div class="table-responsive">
            <table class="table table-bordered">

            <tr class="bg-orange">
                <th class="text-left" colspan="<?=$parent?>"><?=$val['course_code']?> - <?=$val['course_name']?>
                </th>
              </tr>

              <tr class="bg-success">
                <th style="width:20px;" rowspan="3">NUM
                </th>
                <!-- <th rowspan="3" style="min-width:50px;">ID NUMBER
                </th> -->
                <th rowspan="3"  style="min-width:150px;">STUDENT NAME
                </th>
                <th rowspan="2" colspan="3">GROUND
                </th>
                <th rowspan="2" colspan="3">FTD
                </th>
                <?php 
                $text_child = '';
                $count = 0;
                foreach($mission_parent as $keyp=>$valp){ 
                $type_of_training = $valp['type_of_training2'];  
                $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	tpm_syllabus_all_course WHERE curriculum = '$id_curriculum' AND course = '$id_course'  AND type_of_training2 = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_of_training_type2 ORDER BY position ASC");
                // print_r($mission_parent_child);
                $count_child = count($mission_parent_child);
                if($count_child > 1){
                //  echo 1;
                  $perkalian = 3*$count_child;
                  $style_th = 'colspan="'.$perkalian.'" ';
                 
                }else{
                  
                  $perkalian = 3*$count_child;
                  $style_th = 'rowspan="2" colspan="'.$perkalian.'" ';
                }

               foreach($mission_parent_child as $keyc=>$valc){ 
                  $count++;  
                  if($count_child > 1){
                    $text_child .= '
                    <th colspan="3">'.$valc['type_of_training_type2'].'</th>';
                  }
                }
                ?>
                <th <?=$style_th?> ><?=$valc['type_of_training2']?></th>
                <?php }
               
                ?>
                <th rowspan="2" colspan="3">TOTAL FLIGHT HOURS
                </th>
              </tr>

              <tr class="bg-success">
              <?=$text_child?>
              </tr>

             
              <tr class="bg-success">
              <?php for($i = 0; $i < ($count+2); $i++){ ?>
              <th>TARGET
              </th>
              <th>TOTAL
              </th>
              <th>REMAIN
              </th>
              <?php } ?>
              <th>TARGET
              </th>
              <th>TOTAL
              </th>
              <th>REMAIN
              </th>
              </tr>


              
              <tbody>
              <?php 
             

             $target_ground_bottom = array();
             $target_ftd_bottom = array();
             $target_flight_bottom = array();

            $total_ground_bottom = array();
            $total_ftd_bottom = array();
            $total_flight_bottom = array();

            $remain_ground_bottom = array();
            $remain_ftd_bottom = array();
            $remain_flight_bottom = array();
              


              foreach($student as $key2=>$val2){ 

              $id_student = $val2['id']; 
              $id_mission = $id_mission;
              $total = array();
              $qry = '{"attend":"'.$id_student.'"}';
              $data = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule WHERE course = '$id_course' AND student_attend LIKE '%$qry%' ");

              foreach($data as $key3=>$val3){
                if (strpos($val3['duration'], ':') !== false) {
                  array_push($total,$val3['duration']);
                }
              }

              $total = $this->template->sum_time($total);

              $total_ground[$id_course][$id_student] = $total;
 
              $total1 = (explode(":",$ground_target[$id_course])); 
              $total2 = (explode(":",$total_ground[$id_course][$id_student]));
              
              $style_child_ground = " class='not-complete' ";

              if(intval($total2[0]) >= intval($total1[0]) && ($total2[1]) >= intval($total1[1])){
                $jam = intval($total2[0]) - intval($total1[0]);
                $menit = intval($total2[1]) - intval($total1[1]);
                $style_child_ground = " class='complete' ";
              }else if(intval($total1[0]) < intval($total2[0])){
                $jam = intval($total2[0]) - intval($total1[0]);
                $menit_pertama = 60 - intval($total1[1]);
                $menit = $menit_pertama + intval($total2[1]);
                $style_child_ground = " class='complete' ";

              }else{
                $jam = intval($total1[0]) - intval($total2[0]);
                $menit = intval($total1[1]) - intval($total2[1]);

                if($menit < 0 ){
                  // $jam = $jam - 1;
                  $menit = abs($menit);
                }

              }
              
              $jam = str_pad($jam, 2, '0', STR_PAD_LEFT);
              $menit = str_pad($menit, 2, '0', STR_PAD_LEFT);

              $total = $jam.':'.$menit;
            
              // echo $total;

              $remain_ground[$id_course][$id_student] = $total;
                


              $id_student = $val2['id']; 
              $id_mission = $id_mission;
              $total = array();
              $data = $this->mymodel->selectWithQuery("SELECT a.* 
              FROM daily_ftd_schedule a WHERE a.course = '$id_course' AND (a.2nd = '$id_student' OR a.pic = '$id_student')");

              foreach($data as $key3=>$val3){
                if (strpos($val3['block_time_total'], ':') !== false) {
                  array_push($total,$val3['block_time_total']);
                }
              }
              $total = $this->template->sum_time($total);

              $total_ftd[$id_course][$id_student] = $total;

              $total1 = (explode(":",$ftd_target[$id_course])); 
              $total2 = (explode(":",$total_ftd[$id_course][$id_student]));

              $style_child_ftd = " class='not-complete' ";

              if(intval($total2[0]) >= intval($total1[0]) && ($total2[1]) >= intval($total1[1])){
                $jam = intval($total2[0]) - intval($total1[0]);
                $menit = intval($total2[1]) - intval($total1[1]);
                $style_child_ftd = " class='complete' ";
              }else if(intval($total1[0]) < intval($total2[0])){
                $jam = intval($total2[0]) - intval($total1[0]);
                $menit_pertama = 60 - intval($total1[1]);
                $menit = $menit_pertama + intval($total2[1]);
                $style_child_ftd = " class='complete' ";

              }else{
                $jam = intval($total1[0]) - intval($total2[0]);
                $menit = intval($total1[1]) - intval($total2[1]);

                if($menit < 0 ){
                  // $jam = $jam - 1;
                  $menit = abs($menit);
                }

              }
              

              
              $jam = str_pad($jam, 2, '0', STR_PAD_LEFT);
              $menit = str_pad($menit, 2, '0', STR_PAD_LEFT);

              $total = $jam.':'.$menit;
            
              // echo $total;

              $remain_ftd[$id_course][$id_student] = $total;

              array_push($target_ground_bottom,$ground_target[$id_course]);
              array_push($total_ground_bottom,$total_ground[$id_course][$id_student]);
              array_push($remain_ground_bottom,$remain_ground[$id_course][$id_student]);
              
              array_push($target_ftd_bottom,$ftd_target[$id_course]);
              array_push($total_ftd_bottom,$total_ftd[$id_course][$id_student]);
              array_push($remain_ftd_bottom,$remain_ftd[$id_course][$id_student]);
              

                
                ?>
                
                <tr>
                  <td><?=$key2+1?>
                  </td>
                  <!-- <td><?=$val2['id_number']?>
                  </td> -->
                  <td class="text-left"><a href="<?=base_url()?>record/student_hours/student_rev/<?=$val2['id']?>"><?=$val2['full_name']?></a>
                  </td>

                  <td>
                    <?=$ground_target[$id_course]?>
                  </td>
                  <td>
                    <?=$total_ground[$id_course][$id_student]?>
                  </td>
                  <td <?=$style_child_ground?> >
                    <?=$remain_ground[$id_course][$id_student]?>
                  </td>

                  <td>
                    <?=$ftd_target[$id_course]?>
                  </td>
                  <td>
                    <?=$total_ftd[$id_course][$id_student]?>
                  </td>
                  <td <?=$style_child_ftd?> >
                    <?=$remain_ftd[$id_course][$id_student]?>
                  </td>

<?php 

$flight_target_final = array();
$total_flight_final = array();
$remain_flight_final = array();

                $a = array();
                $b = array();
                $c = array();

                $index_a = -1;
                
                foreach($mission_parent as $keyp=>$valp){ 
                  $index_a++;
                $type_of_training = $valp['type_of_training2'];  
                $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	tpm_syllabus_all_course WHERE curriculum = '$id_curriculum' AND course = '$id_course'  AND type_of_training2 = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_of_training_type2 ORDER BY position ASC");
                // print_r($mission_parent_child);
                
               foreach($mission_parent_child as $keyc=>$valc){ 
               $type_of_training_type = $valc['type_of_training_type2'];  

             
                $flight_mission_child_item = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type_of_training2 = '$type_of_training' AND type_of_training_type2 = '$type_of_training_type' ORDER BY mission_number ASC");
                $total = array();
                foreach($flight_mission_child_item as $keymci => $valmci){
                  $id_student = $id_student; 
                  $id_mission = $valmci['id'];
                  $data = $this->mymodel->selectWithQuery("SELECT a.*, b.*, a.id FROM daily_flight_schedule a LEFT JOIN tpm_syllabus_all_course b ON a.mission = b.id WHERE a.mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') ");
                  foreach($data as $key3=>$val3){
                    if (strpos($val3['block_time_total'], ':') !== false) {
                      array_push($total,$val3['block_time_total']);
                    }
                  }
                }
                $total = $this->template->sum_time($total);
                $total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student] = $total;

              $total1 = (explode(":",$flight_target[$id_course][$type_of_training][$type_of_training_type])); 
              $total2 = (explode(":",$total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]));
              $style_child_flight = " class='not-complete' ";

              if(intval($total2[0]) >= intval($total1[0]) && ($total2[1]) >= intval($total1[1])){
                $jam = intval($total2[0]) - intval($total1[0]);
                $menit = intval($total2[1]) - intval($total1[1]);
                $style_child_flight = " class='complete' ";
              }else if(intval($total1[0]) < intval($total2[0])){
                $jam = intval($total2[0]) - intval($total1[0]);
                $menit_pertama = 60 - intval($total1[1]);
                $menit = $menit_pertama + intval($total2[1]);
                $style_child_flight = " class='complete' ";

              }else{
                $jam = intval($total1[0]) - intval($total2[0]);
                $menit = intval($total1[1]) - intval($total2[1]);

                if($menit < 0 ){
                  // $jam = $jam - 1;
                  $menit = abs($menit);
                }

              }
              
              $jam = str_pad($jam, 2, '0', STR_PAD_LEFT);
              $menit = str_pad($menit, 2, '0', STR_PAD_LEFT);

              $total = $jam.':'.$menit;
            
              // echo $total;

              $remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student] = $total;

              array_push($flight_target_final,$flight_target[$id_course][$type_of_training][$type_of_training_type]);

              array_push($total_flight_final,$total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]);

              array_push($remain_flight_final,$remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]);
              
              $target_flight_bottom[$id_course][$type_of_training][$type_of_training_type][$val2['id']] = $flight_target[$id_course][$type_of_training][$type_of_training_type];
         
              $total_flight_bottom[$id_course][$type_of_training][$type_of_training_type][$val2['id']] = $total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student];
         
              $remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type][$val2['id']] = $remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student];
         
             
                  ?>
                    <td><?=$flight_target[$id_course][$type_of_training][$type_of_training_type]?></td>
                    <td><?=$total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]?></td>
                    <td <?=$style_child_flight?> >
                    <?=$remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]?></td>
                  <?php
                }
                ?>
                <?php 

             
         
              }

$flight_target_final = $this->template->sum_time($flight_target_final);
$total_flight_final = $this->template->sum_time($total_flight_final);
$remain_flight_final = $this->template->sum_time($remain_flight_final);

$total1 = (explode(":",$flight_target_final)); 
$total2 = (explode(":",$total_flight_final));
$style_child_flight_final = " class='not-complete' ";

if(intval($total2[0]) >= intval($total1[0]) && ($total2[1]) >= intval($total1[1])){
  $jam = intval($total2[0]) - intval($total1[0]);
  $menit = intval($total2[1]) - intval($total1[1]);
  $style_child_flight_final = " class='complete' ";
}else if(intval($total1[0]) < intval($total2[0])){
  $jam = intval($total2[0]) - intval($total1[0]);
  $menit_pertama = 60 - intval($total1[1]);
  $menit = $menit_pertama + intval($total2[1]);
  $style_child_flight_final = " class='complete' ";

}else{
  $jam = intval($total1[0]) - intval($total2[0]);
  $menit = intval($total1[1]) - intval($total2[1]);

  if($menit < 0 ){
    // $jam = $jam - 1;
    $menit = abs($menit);
  }

}

$jam = str_pad($jam, 2, '0', STR_PAD_LEFT);
$menit = str_pad($menit, 2, '0', STR_PAD_LEFT);

$total = $jam.':'.$menit;
               
                ?>

                <th>
                <?=$flight_target_final?>
                </th>
                <th>
                <?=$total_flight_final?>
                </th>
                <td <?=$style_child_flight_final?> >
                <?=$remain_flight_final?>
                </th>

</tr>



              <?php }  
              $target_ground_bottom = $this->template->sum_time($target_ground_bottom);
              $total_ground_bottom = $this->template->sum_time($total_ground_bottom);
              $remain_ground_bottom = $this->template->sum_time($remain_ground_bottom);

              
              $target_ftd_bottom = $this->template->sum_time($target_ftd_bottom);
              $total_ftd_bottom = $this->template->sum_time($total_ftd_bottom);
              $remain_ftd_bottom = $this->template->sum_time($remain_ftd_bottom);
              ?>

              <tr>
                  <th class="text-right" colspan="3">TOTAL
                  </th>
                  <th>
                    <?=$target_ground_bottom?>
                  </th>
                  <th>
                    <?=$total_ground_bottom?>
                  </th>
                  <th>
                    <?=$remain_ground_bottom?>
                  </th>
                  <th>
                    <?=$target_ftd_bottom?>
                  </th>
                  <th>
                    <?=$total_ftd_bottom?>
                  </th>
                  <th>
                    <?=$remain_ftd_bottom?>
                  </th>

<?php
                foreach($mission_parent as $keyp=>$valp){ 
                $type_of_training = $valp['type_of_training2'];  
                $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	tpm_syllabus_all_course WHERE curriculum = '$id_curriculum' AND course = '$id_course'  AND type_of_training2 = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_of_training_type2 ORDER BY position ASC");
                // print_r($mission_parent_child);
                
               foreach($mission_parent_child as $keyc=>$valc){ 
               $type_of_training_type = $valc['type_of_training_type2'];  

               $target_flight_bottom[$id_course][$type_of_training][$type_of_training_type] = $this->template->sum_time($target_flight_bottom[$id_course][$type_of_training][$type_of_training_type]);

               
                $total_flight_bottom[$id_course][$type_of_training][$type_of_training_type] = $this->template->sum_time($total_flight_bottom[$id_course][$type_of_training][$type_of_training_type]);
            
                $remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type] = $this->template->sum_time($remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type]);

                  ?>
                    <th>
                      <?=$target_flight_bottom[$id_course][$type_of_training][$type_of_training_type]?>
                    </th> 
                    <th>
                      <?=$total_flight_bottom[$id_course][$type_of_training][$type_of_training_type]?>
                    </th>
                    <th>
                      <?=$remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type]?>
                    </th>
                  <?php
                }
                ?>
                <?php 

              }

                ?>
                <td></td>
                <td></td>
                <td></td>


</tr>



</tbody>
            </table>
            </div>
            </div>

              <?php } }else{ ?>
              <div class="row" style="margin-left:0px;">
                <div class="col-md-12">
              <p>Please Select Batch!</p>
              </div></div>
              <?php } ?>
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
$(document).ready(function(){
    $('#batch').change(function() {
          var batch = $('#batch').val();

          $("#course").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_course_by_batch/?batch='+batch,
                  success:function(html){
                    $("#course").html(html);
                  }
              }); 
          }else{
            
          }
        
          
       
      });

});

</script>