
<style>
.complete{
  color : green;
  /* color:#000; */
}
.not-complete{
  color: red;
}
th{
  font-weight:600!important;
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
              BATCH PROGRESS REPORT
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

                                                    if($base_airport_document_record['code']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['code']."' ".$text." >".$base_airport_document_record['batch']."</option>";

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

                      $batch = $this->mymodel->selectDataOne('batch', array('code'=>$_SESSION['batch']));
                      $curriculum = $batch['curriculum'];
                      $this->db->order_by('position','ASC');
                        $syllabus_mission = $this->mymodel->selectWhere('syllabus_course',null);

                        foreach ($syllabus_mission as $val) {

                          $text="";

                          if($val['code']==$_SESSION['course']){

                            $text = "selected";

                          }



                          echo "<option value='".$val['code']."' ".$text." >".$val['code_name']." - ".$val['name']."</option>";

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

            $student = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE instructor_status != '1' AND batch = '$batch' AND status = 'ACTIVE'
            -- LIMIT 3
            ");

            $batch = $this->mymodel->selectDataOne('batch',array('code'=>$_SESSION['batch']));
            $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$batch['curriculum']));
            $id_curriculum = $curriculum['code'];
            
           $id_curriculum = $batch['curriculum'];


           $arr_course = json_decode($curriculum['course'],true);
            $arr_mission = json_decode($curriculum['mission'],true);
            


            $text1 = '{"val":"GROUND"}';

            $text2 = '{"val":"FTD"}';
            
            $text3 = '{"val":"FLIGHT"}';
            // if($_SESSION['course']){
            //   $id_course = $_SESSION['course'];
            //   $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE  code = '$id_course'
            //   AND (configuration LIKE '%$text1%' OR configuration LIKE '%$text2%' OR configuration LIKE '%$text3%') ORDER BY position ASC");
                 
            // }else{
            //   $course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$id_curriculum' 
            //   AND (configuration LIKE '%$text1%' OR configuration LIKE '%$text2%' OR configuration LIKE '%$text3%') ORDER BY position ASC");
            // }
            $id_course = $_SESSION['course'];
            $course = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_course WHERE code = '$id_course'
            ORDER BY position ASC");
        
                 
            ?>

          <?php
          if($_SESSION['batch']){ 
          

            
          foreach($course as $key=>$val){ 
          
            $id_course = $val['code'];
            $count = 0;
            $mission_parent = $this->mymodel->selectWithQuery("SELECT * FROM 	syllabus_mission WHERE  course = '$id_course' AND type_of_training = 'FLIGHT'  GROUP BY type  ORDER BY position ASC");
            
           
            foreach($mission_parent as $key2=>$val2){ 
             
              $type_of_training = $val2['type'];  
              $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	syllabus_mission WHERE  course = '$id_course'  AND type = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_sub ORDER BY position ASC");
             
              foreach($mission_parent_child as $key3=>$val3){ 

              $duration_dual_flight = array();
              $duration_solo_flight = array();
              $duration_solo_svp_flight = array();
              $duration_pic_flight = array();
              $duration_non_rev_flight = array();

                $count++;
                $type_of_training = $val2['type']; 
                $type_of_training_type = $val3['type_sub'];
                $flight_mission_child_item = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type = '$type_of_training' AND type_sub = '$type_of_training_type' ORDER BY position ASC");
                foreach($flight_mission_child_item as $keymci => $valmci){
                 


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
                  if (strpos($valmci['duration_non_rev'], ':') !== false) {
                   
                    array_push($duration_non_rev_flight,$valmci['duration_non_rev']);
                  }
              }

              // print_r($duration_dual_flight);

              $a = array();
              
              $a[0] = $this->template->sum_time_2($duration_dual_flight);
              $a[1] = $this->template->sum_time_2($duration_pic_flight);
              $a[2] = $this->template->sum_time_2($duration_solo_svp_flight);
              $a[3] = $this->template->sum_time_2($duration_solo_flight);
              $a[4] = $this->template->sum_time_2($duration_non_rev_flight);
              
              $a = $this->template->sum_time_2($a);

              $flight_target[$id_course][$type_of_training][$type_of_training_type] = $a;
             

              }

             

            }



            $parent =  (($count+3)*3)+3;

            // echo $count;

            $ground_target = array();

            $ground_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'GROUND' ORDER BY position ASC");
            foreach($ground_mission as $keym=>$valm){
             
              if($arr_mission['GROUND'][$valm['course']][$valm['code']]['duration']){
                $valm['duration'] = $arr_mission['GROUND'][$valm['course']][$valm['code']]['duration'];
              }
              if (strpos($valm['duration'], ':') !== false) {
                array_push($ground_target,$valm['duration']);
              }
            }


             $ground_target[$id_course] = $this->template->sum_time_2($ground_target);

             

             $ftd_target = array();

             $ftd_mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FTD' ORDER BY position ASC");
             foreach($ftd_mission as $keym=>$valm){

              if($arr_mission['FTD'][$valm['course']][$valm['code']]['duration']){
                $valm['duration'] = $arr_mission['FTD'][$valm['course']][$valm['code']]['duration'];
              }

               if (strpos($valm['duration'], ':') !== false) {
                 array_push($ftd_target,$valm['duration']);
               }
             }
 
              $ftd_target[$id_course] = $this->template->sum_time_2($ftd_target);


              
          ?>

          <div class="box-body">
            <div class="table-responsive">
            <table class="table table-bordered" >

            <tr class="bg-orange">
                <th class="text-left" colspan="<?=$parent?>"><?=$val['code_name']?> - <?=$val['name']?>
                </th>
              </tr>

              <tr class="bg-success">
                <th style="width:20px;" rowspan="3">NUM
                </th>
                <th rowspan="3"  style="min-width:150px;">STUDENT NAME
                </th>
                <th rowspan="3" style="min-width:50px;">ID NUMBER
                </th>
                <th rowspan="2" colspan="3">GROUND
                </th>
                <th rowspan="2" colspan="3">FTD
                </th>
                <?php 
                $text_child = '';
                $count = 0;
                foreach($mission_parent as $keyp=>$valp){ 
                $type_of_training = $valp['type'];  
                $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	syllabus_mission WHERE  course = '$id_course'  AND type = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_sub ORDER BY position ASC");
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
                    <th colspan="3"">'.$valc['type_sub'].'</th>';
                  }
                }
                ?>
                <th <?=$style_th?> ><?=$valc['type']?></th>
                <?php }
               
                ?>
                <th rowspan="2" colspan="3">TOTAL FLIGHT HOURS
                </th>
              </tr>

              <tr class="bg-success">
              <?=$text_child?>
              </tr>

             
              <tr class="bg-success">
              <?php for($i = 0; $i < ($count+3); $i++){ ?>
              <th style="min-width:80px;">TARGET
              </th>
              <th style="min-width:80px;">ACTUAL
              </th>
              <th style="min-width:80px;">REMAIN
              </th>
              <?php } ?>
              <!-- <th style="min-width:80px;">TARGET
              </th>
              <th style="min-width:80px;">ACTUAL
              </th>
              <th style="min-width:80px;">REMAIN
              </th> -->
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
              
            $total_flight_hours_target = array();
            $total_flight_hours_total = array();
            $total_flight_hours_remain = array();

            $total_flight_hours_remain_bottom = array();

                $nomor = 0;
              foreach($student as $key2=>$val2){ 

                

                $arr_course_selected = json_decode($val2['course'],true);


                $remain_flight_right = array();

                $training_requirement = json_decode($val2['training_requirement'],true);

                // echo $ground_student = ($training_requirement['GROUND']['item'][$id_course]);
                $ground_student = $training_requirement['GROUND']['item'][$id_course];
                $ftd_student = $training_requirement['FTD']['item'][$id_course];
                $flight_student = $training_requirement['FLIGHT']['item'][$id_course];
                $check = 1;
                // if(empty($ground_student) && empty($ftd_student) && empty($flight_student)){
                //   $check = 0;
                // }
                

              $id_student = $val2['id_number']; 
              $id_mission = $id_mission;
              $total = array();
              $qry = '"'.$id_student.'":';
              $data = $this->mymodel->selectWithQuery("SELECT duration_act FROM daily_ground_schedule WHERE visibility = '1' AND visibility_report = '1' AND course = '$id_course' AND student_attend LIKE '%$qry%'  AND duration_act NOT IN ('','-','0:00') ");

              foreach($data as $key3=>$val3){
                if (strpos($val3['duration_act'], ':') !== false) {
                  array_push($total,$val3['duration_act']);
                }
              }

              $total = $this->template->sum_time_2($total);

              $total_ground[$id_course][$id_student] = $total;
 
              $total1 = (explode(":",$ground_target[$id_course])); 
              $total2 = (explode(":",$total_ground[$id_course][$id_student]));
              
              $style_child_ground = " class='not-complete' ";

              $total_target = $total_time_1 = $total1[0]*60 + $total1[1];

              $total_tercapai = $total_time_2 = $total2[0]*60 + $total2[1];

              $total_akhir = $total_target - $total_tercapai;
              $sign_ground_remain = '';
              if($total_akhir == 0){
                $style_child_ground = " class='complete' ";
                $jam = "00";
                $menit = "00";
              
              }else if($total_akhir > 0){
                if($total_akhir >= 60){
                  $jam = floor($total_akhir/60);
                  $menit = $total_akhir - ($jam * 60);
                }else{
                  $jam = "00";
                  $menit = $total_akhir;
                }
                $style_child_ground = " class='not-complete' ";
                $sign_ground_remain = '- ';
              }else{
                $total_akhir = abs($total_akhir);
                if($total_akhir >= 60){
                  $jam = floor($total_akhir/60);
                  $menit = $total_akhir - ($jam * 60);
                }else{
                  $jam = "00";
                  $menit = $total_akhir;
                }
                $style_child_ground = " class='complete' ";
              }
  
              $jam = str_pad($jam, 2, '0', STR_PAD_LEFT);
              $menit = str_pad($menit, 2, '0', STR_PAD_LEFT);

              $total = intval($jam).':'.$menit;
            
              // echo $total;

              $remain_ground[$id_course][$id_student] = $total;
                


              $id_student = $val2['id_number']; 
              $id_mission = $id_mission;
              $total = array();
              $data = $this->mymodel->selectWithQuery("SELECT a.* 
              FROM daily_ftd_schedule a WHERE a.visibility = '1' AND a.visibility_report = '1'  AND a.course = '$id_course' AND (a.2nd = '$id_student' OR a.pic = '$id_student')");

              foreach($data as $key3=>$val3){
                if (strpos($val3['block_time_total'], ':') !== false) {
                  array_push($total,$val3['block_time_total']);
                }
              }
              $total = $this->template->sum_time_2($total);

              $total_ftd[$id_course][$id_student] = $total;

              $total1 = (explode(":",$ftd_target[$id_course])); 
              $total2 = (explode(":",$total_ftd[$id_course][$id_student]));

              $style_child_ftd = " class='not-complete' ";

              $total_target = $total_time_1 = $total1[0]*60 + $total1[1];

              $total_tercapai = $total_time_2 = $total2[0]*60 + $total2[1];

              $total_akhir = $total_target - $total_tercapai;
              $sign_ftd_remain = '';
              if($total_akhir == 0){
                $style_child_ftd = " class='complete' ";
                $jam = "00";
                $menit = "00";
              
              }else if($total_akhir > 0){
                if($total_akhir >= 60){
                  $jam = floor($total_akhir/60);
                  $menit = $total_akhir - ($jam * 60);
                }else{
                  $jam = "00";
                  $menit = $total_akhir;
                }
                $style_child_ftd = " class='not-complete' ";
                $sign_ftd_remain = '- ';
              }else{
                $total_akhir = abs($total_akhir);
                if($total_akhir >= 60){
                  $jam = floor($total_akhir/60);
                  $menit = $total_akhir - ($jam * 60);
                }else{
                  $jam = "00";
                  $menit = $total_akhir;
                }
                $style_child_ftd = " class='complete' ";
              }

              

              
              $jam = str_pad($jam, 2, '0', STR_PAD_LEFT);
              $menit = str_pad($menit, 2, '0', STR_PAD_LEFT);

              $total = intval($jam).':'.$menit;
            
              // echo $total;

              $remain_ftd[$id_course][$id_student] = $total;

              array_push($target_ground_bottom,$ground_target[$id_course]);
              array_push($total_ground_bottom,$total_ground[$id_course][$id_student]);
              
              
              array_push($target_ftd_bottom,$ftd_target[$id_course]);
              array_push($total_ftd_bottom,$total_ftd[$id_course][$id_student]);
              
              if($style_child_ftd == " class='not-complete' "){
                array_push($remain_ftd_bottom,$remain_ftd[$id_course][$id_student]);
              }

              if($style_child_ground == " class='not-complete' "){
                array_push($remain_ground_bottom,$remain_ground[$id_course][$id_student]);
              }

              
             
              
              if($check > 0){
                $nomor++;
                
                ?>
                
                <tr>
                  <td><?=$nomor?>
                  </td>
                  <td class="text-left"><a href="<?=base_url()?>record/student_hours/student_rev/<?=$val2['id']?>"><?=$val2['full_name']?></a>
                  </td>
                  <td><?=$val2['id_number']?>
                  </td>

                  <td>
                    <?=$ground_target[$id_course]?>
                  </td>
                  <td>
                    <?php $chart_total_ground[$val2['id']] = $total_ground[$id_course][$id_student];
                    echo $this->template->utc($total_ground[$id_course][$id_student]);
                    ?>
                  </td>
                  <td <?=$style_child_ground?> >
                    <?=$sign_ground_remain?><?=$remain_ground[$id_course][$id_student]?>
                  </td>

                  <td>
                    <?=$ftd_target[$id_course]?>
                  </td>
                  <td>
                    <?php $chart_total_ftd[$val2['id']] = $total_ftd[$id_course][$id_student];
                     echo $this->template->utc($total_ftd[$id_course][$id_student]);
                    ?>
                  </td>
                  <td <?=$style_child_ftd?> >
                    <?=$sign_ftd_remain?><?=$remain_ftd[$id_course][$id_student]?>
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
                $type_of_training = $valp['type'];  
                $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	syllabus_mission WHERE  course = '$id_course'  AND type = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_sub ORDER BY position ASC");
                // print_r($mission_parent_child);
                
               foreach($mission_parent_child as $keyc=>$valc){ 
               $type_of_training_type = $valc['type_sub'];  

             
                $flight_mission_child_item = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE course = '$id_course' AND type_of_training = 'FLIGHT' AND type = '$type_of_training' AND type_sub = '$type_of_training_type' ORDER BY position ASC");
                
                $total = array();
                foreach($flight_mission_child_item as $keymci => $valmci){
                  $id_student = $id_student; 
                  $id_mission = $valmci['code'];
                  // $data = $this->mymodel->selectWithQuery("SELECT a.*, b.*, a.id FROM daily_flight_schedule a LEFT JOIN syllabus_mission b ON a.mission = b.id WHERE a.visibility = '1' AND a.visibility_report = '1' AND a.type = '' AND a.mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') ");
                  $data = $this->mymodel->selectWithQuery("SELECT a.* FROM daily_flight_schedule a 
                  WHERE a.visibility = '1' AND a.visibility_report = '1' AND a.type = '' AND a.mission = '$id_mission' 
                  AND (a.2nd = '$id_student' OR a.pic = '$id_student')");
                //   print_r($data);
                // echo "SELECT a.* FROM daily_flight_schedule a WHERE a.visibility = '1' AND a.visibility_report = '1' AND a.type = '' AND a.mission = '$id_mission' AND (2nd = '$id_student' OR pic = '$id_student') LIMIT 1";
                // echo $id_mission.' - ';
                  foreach($data as $key3=>$val3){
                    if (strpos($val3['block_time_total'], ':') !== false) {
                    
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


                      // array_push($total,$val3['block_time_total']);
                    }
                  }
                }
                $total = $this->template->sum_time_2($total);
                $total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student] = $total;

                $t[0] = $total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student];
                $total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student] = $this->template->sum_time($t);

              $total1 = (explode(":",$flight_target[$id_course][$type_of_training][$type_of_training_type])); 
              $total2 = (explode(":",$total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]));
              $style_child_flight = " class='not-complete' ";

              $total_target = $total_time_1 = $total1[0]*60 + $total1[1];

              $total_tercapai = $total_time_2 = $total2[0]*60 + $total2[1];

              $total_akhir = $total_target - $total_tercapai;


              if($total_akhir == 0){
                $style_child_flight = " class='complete' ";
                $sign = '';
                $jam = "00";
                $menit = "00";
              
              }else if($total_akhir > 0){
                if($total_akhir >= 60){
                  $jam = floor($total_akhir/60);
                  $menit = $total_akhir - ($jam * 60);
                }else{
                  $jam = "00";
                  $menit = $total_akhir;
                }
                $style_child_flight = " class='not-complete' ";
                $sign = '- ';
              }else{
                $total_akhir = abs($total_akhir);
                if($total_akhir >= 60){
                  $jam = floor($total_akhir/60);
                  $menit = $total_akhir - ($jam * 60);
                }else{
                  $jam = "00";
                  $menit = $total_akhir;
                }
                $style_child_flight = " class='complete' ";
                $sign = '+ ';
              }

       
              
              $jam = str_pad($jam, 2, '0', STR_PAD_LEFT);
              $menit = str_pad($menit, 2, '0', STR_PAD_LEFT);

              
            

              $total = intval($jam).':'.$menit;
            
              // echo $total;

              $remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student] = $total;

              array_push($flight_target_final,$flight_target[$id_course][$type_of_training][$type_of_training_type]);

              array_push($total_flight_final,$total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]);

              array_push($remain_flight_final,$remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]);
              
              $target_flight_bottom[$id_course][$type_of_training][$type_of_training_type][$val2['id']] = $flight_target[$id_course][$type_of_training][$type_of_training_type];
         
              $total_flight_bottom[$id_course][$type_of_training][$type_of_training_type][$val2['id']] = $total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student];
         
                if($sign=='- '){
                  $remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type][$val2['id']] = $remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student];
                  // $remain_flight_right = $remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student];
                  array_push($remain_flight_right,$remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]);
              }         
             
              
                  ?>
                    <td><?=$flight_target[$id_course][$type_of_training][$type_of_training_type]?></td>
                    <td><?=$total_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]?>
                  
                  </td>
                    <td <?=$style_child_flight?> >
                    <?=$sign?> 
                    <?php 
                    if($remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student]=='0:00'){
                      echo 'DONE';
                    }else{
                      echo $remain_flight[$id_course][$type_of_training][$type_of_training_type][$id_student];
                    }
                    ?>
                    </td>
                  <?php
                }
                ?>
                <?php 

             
         
              }

$flight_target_final = $this->template->sum_time_2($flight_target_final);
$total_flight_final = $this->template->sum_time_2($total_flight_final);
// $remain_flight_final = $this->template->sum_time_2($remain_flight_final);

$total1 = (explode(":",$flight_target_final)); 
$total2 = (explode(":",$total_flight_final));
$style_child_flight_final = " class='not-complete' ";
$sign = '- ';

if(intval($total2[0]) >= intval($total1[0]) && ($total2[1]) >= intval($total1[1])){
  $jam = intval($total2[0]) - intval($total1[0]);
  $menit = intval($total2[1]) - intval($total1[1]);
  $style_child_flight_final = " class='complete' ";
  $sign = '+';
}else if(intval($total1[0]) < intval($total2[0])){
  $jam = intval($total2[0]) - intval($total1[0]);
  $menit_pertama = 60 - intval($total1[1]);
  $menit = $menit_pertama + intval($total2[1]);
  $style_child_flight_final = " class='complete' ";
  $sign = '+ ';
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


$total = intval($jam).':'.$menit;

$remain_flight_final = $total;

if($sign=='- '){
  $remain_flight_final_bottom = $total;
}else{
  $remain_flight_final_bottom = '0:00';
}

if($remain_flight_final=='0:00'){
  $sign = '';
}
// print_r($remain_flight_right);
// echo '<br>';
$remain_flight_right = $this->template->sum_time_2($remain_flight_right);
array_push($total_flight_hours_remain_bottom,$remain_flight_right); 


// echo $remain_flight_right;
// echo '<br>';
if(in_array($remain_flight_right,array('','00:00'))){
  $style_child_flight_final = " class='complete' ";
  $remain_flight_right = 'DONE';
  $sign = '';
}else{
  $style_child_flight_final = " class='not-complete' ";
  $sign = '-';
}
                ?>

                <th>
                <?=$flight_target_final?>
                </th>
                <th>
                <?=$chart_total_flight[$val2['id']] = $total_flight_final?>
                </th>
                <th <?=$style_child_flight_final?> >

                <?=$sign?> 
                <?=$remain_flight_right?>

                </th>

</tr>



              <?php 
              }
              array_push($total_flight_hours_target,$flight_target_final);
              array_push($total_flight_hours_total,$total_flight_final);
              array_push($total_flight_hours_remain,$remain_flight_final); 

              
              }  

              $total_flight_hours_target = $this->template->sum_time_2($total_flight_hours_target);
              $total_flight_hours_total = $this->template->sum_time_2($total_flight_hours_total);
              $total_flight_hours_remain = $this->template->sum_time_2($total_flight_hours_remain);

        
              $total_flight_hours_remain_bottom = $this->template->sum_time_2($total_flight_hours_remain_bottom);


              $target_ground_bottom = $this->template->sum_time_2($target_ground_bottom);
              $total_ground_bottom = $this->template->sum_time_2($total_ground_bottom);
              $remain_ground_bottom = $this->template->sum_time_2($remain_ground_bottom);

              
              $target_ftd_bottom = $this->template->sum_time_2($target_ftd_bottom);
              $total_ftd_bottom = $this->template->sum_time_2($total_ftd_bottom);
              $remain_ftd_bottom = $this->template->sum_time_2($remain_ftd_bottom);


              // $style_ground = " class='not-complete' ";

              // $total1 = (explode(":",$target_ground_bottom)); 
              // $total2 = (explode(":",$total_ground_bottom));

              // if($total2 >= $total1){
              //   $style_ground = " class='complete' ";
              // }

              // $style_ftd = " class='not-complete' ";

              // $total1 = (explode(":",$target_ftd_bottom)); 
              // $total2 = (explode(":",$total_ftd_bottom));

              // if($total2 >= $total1){
              //   $style_ftd = " class='complete' ";
              // }


              if(in_array($remain_ground_bottom,array('','00:00'))){
                $style_ground = " class='complete' ";
                $remain_ground_bottom = 'DONE';
                $sign = '';
              }else{
                $style_ground = " class='not-complete' ";
                $sign = '-';
                $sign_ground_remain_bottom = '- ';
                $remain_ground_bottom = ''.$remain_ground_bottom;
              }


              if(in_array($remain_ftd_bottom,array('','00:00'))){
                $style_ftd = " class='complete' ";
                $remain_ftd_bottom = 'DONE';
                $sign = '';
              }else{
                $style_ftd = " class='not-complete' ";
                $sign = '-';
                $sign_ftd_remain_bottom = '- ';
                $remain_ftd_bottom = ''.$remain_ftd_bottom;
              }



?>

              <tr>
                  <th class="text-right" colspan="3"><b>TOTAL</b>
                  </th>
                  <th>
                    <?=$target_ground_bottom?>
                  </th>
                  <th>
                    <?=$this->template->utc($total_ground_bottom)?>
                  </th>
                  <th <?=$style_ground?> >
                  <?=$sign_ground_remain_bottom?><?=$remain_ground_bottom?>
                  </th>
                  <th>
                    <?=$target_ftd_bottom?>
                  </th>
                  <th>
                    <?=$this->template->utc($total_ftd_bottom)?>
                  </th>
                  <th <?=$style_ftd?> >
                  <?=$sign_ftd_remain_bottom?><?=$remain_ftd_bottom?>
                  </th>

<?php
                foreach($mission_parent as $keyp=>$valp){ 
                $type_of_training = $valp['type'];  
                $mission_parent_child = $this->mymodel->selectWithQuery("SELECT * FROM 	syllabus_mission WHERE  course = '$id_course'  AND type = '$type_of_training' AND type_of_training = 'FLIGHT' GROUP BY type_sub ORDER BY position ASC");
                // print_r($mission_parent_child);
                
               foreach($mission_parent_child as $keyc=>$valc){ 
               $type_of_training_type = $valc['type_sub'];  

               $target_flight_bottom[$id_course][$type_of_training][$type_of_training_type] = $this->template->sum_time_2($target_flight_bottom[$id_course][$type_of_training][$type_of_training_type]);

               
                $total_flight_bottom[$id_course][$type_of_training][$type_of_training_type] = $this->template->sum_time_2($total_flight_bottom[$id_course][$type_of_training][$type_of_training_type]);
            
                $k[0] = $total_flight_bottom[$id_course][$type_of_training][$type_of_training_type];

                $total_flight_bottom[$id_course][$type_of_training][$type_of_training_type] = $this->template->sum_time($k);
                


  
               

                $remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type] = $this->template->sum_time_2($remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type]);


                // echo '<br><br> A : ';
                // print_r($remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type]);

                $style_flight = " class='not-complete' ";
                $sign = '- ';
                $a = $remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type];
                $total1 = (explode(":",$target_flight_bottom[$id_course][$type_of_training][$type_of_training_type])); 
                $total2 = (explode(":",$remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type]));
                if($total_flight_bottom[$id_course][$type_of_training][$type_of_training_type]=='0:00'){
                  $style_flight = " class='not-complete' ";
                  $sign = '- ';
                }else if($total2 >= $total1){
                  $style_flight = " class='complete' ";
                  $sign = '';
                  // $a = 'DONE';
                }else if($remain_flight_bottom[$id_course][$type_of_training][$type_of_training_type]==''){
                  $a = 'DONE';
                  $sign = '';
                  $style_flight = " class='complete' ";
                }

                
                  ?>
                    <th>
                      <?=$target_flight_bottom[$id_course][$type_of_training][$type_of_training_type]?>
                    </th> 
                    <th>
                      <?=$total_flight_bottom[$id_course][$type_of_training][$type_of_training_type]?>
                    </th>
                    <th <?=$style_flight?> >
                      <?=$sign?>
                      <?=$a?>
                    </th>
                  <?php
                }
                ?>
                <?php 

              }

              $style = " class='not-complete' ";

              $total1 = (explode(":",$total_flight_hours_target)); 
              $total2 = (explode(":",$total_flight_hours_remain_bottom));

              if($total2 >= $total1){
                $style = " class='complete' ";
              }


              if(in_array($total_flight_hours_remain_bottom,array('','00:00'))){
                $style = " class='complete' ";
                $total_flight_hours_remain_bottom = 'DONE';
                $sign = '';
              }else{
                $style = " class='not-complete' ";
                $sign = '-';
              }
    
              

                ?>
                <th>
                      <?=$total_flight_hours_target?>
                    </th>
                <th>
                      <?=$total_flight_hours_total?>
                    </th>
                    <th <?=$style?> >  <?=$sign?>
                    <?=$total_flight_hours_remain_bottom?>
                    </th>


</tr>



</tbody>
            </table>
            </div>
            <br>
            
    <!-- <style>
              #chartdiv<?=$key?> {
  width: 100%;
  height: 600px;
}
            </style>

            <script src="//www.amcharts.com/lib/4/core.js"></script>
<script src="//www.amcharts.com/lib/4/charts.js"></script>
<script src="//www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="//www.amcharts.com/lib/4/themes/dataviz.js"></script>

<script>
am4core.useTheme(am4themes_animated);

var chart = am4core.create("chartdiv<?=$key?>", am4charts.XYChart);

chart.data = [
  <?php foreach($student as $key2=>$val2){
    $value = $chart_total_flight[$val2['id']];
    $value = (explode(":",$value));
    $value[1] = intval($value[1]); 
    if($value[1] > 0){
      $value[1] = $value[1] / 60;
     
    }
    $value = $value[0] + $value[1];
    $flight = number_format($value,1);

    $value = $chart_total_ftd[$val2['id']];
    $value = (explode(":",$value));
    $value[1] = intval($value[1]); 
    if($value[1] > 0){
      $value[1] = $value[1] / 60;
     
    }
    $value = $value[0] + $value[1];
    $ftd = number_format($value,1);

    $value = $chart_total_ground[$val2['id']];
    $value = (explode(":",$value));
    $value[1] = intval($value[1]); 
    if($value[1] > 0){
      $value[1] = $value[1] / 60;
     
    }
    $value = $value[0] + $value[1];
    $ground = number_format($value,1);


    ?>
  {
    category: "<?=$val2['nick_name']?>",
    value1: <?=$ground?>,
    value2: <?=$ftd?>,
    value3: <?=$flight?>,
  },
  <?php } ?>
];

chart.colors.step = 2;

var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "category";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.line.strokeOpacity = 1;
categoryAxis.renderer.minGridDistance = 30;

categoryAxis.renderer.cellStartLocation = 0;
categoryAxis.renderer.cellEndLocation = 1;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());  

var series1 = chart.series.push(new am4charts.ColumnSeries());
series1.columns.template.width = am4core.percent(80);
series1.columns.template.tooltipText = "{name}: {valueY.value}";
series1.columns.template.strokeWidth = 0;
series1.name = "Ground";
series1.dataFields.categoryX = "category";
series1.dataFields.valueY = "value1";

var series2 = chart.series.push(new am4charts.ColumnSeries());
series2.columns.template.width = am4core.percent(80);
series2.columns.template.tooltipText = "{name}: {valueY.value}";
series2.columns.template.strokeWidth = 0;
series2.name = "FTD";
series2.dataFields.categoryX = "category";
series2.dataFields.valueY = "value2";

var series3 = chart.series.push(new am4charts.ColumnSeries());
series3.columns.template.width = am4core.percent(80);
series3.columns.template.tooltipText = "{name}: {valueY.value}";
series3.columns.template.strokeWidth = 0;
series3.name = "Flight";
series3.dataFields.categoryX = "category";
series3.dataFields.valueY = "value3";

</script>

<div id="chartdiv<?=$key?>"></div> -->

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
                  url:'<?=base_url()?>ajax/get_course_by_batch_pure/?batch='+batch,
                  success:function(html){
                    $("#course").html(html);
                  }
              }); 
          }else{
            
          }
        
          
       
      });

});

</script>