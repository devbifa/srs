<?php
                $id = $this->uri->segment(4);
                $student = $this->mymodel->selectDataOne('user',array('id'=>$id));
                $batch = $this->mymodel->selectDataOne('batch',array('code'=>$student['batch']));
                $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$batch['curriculum']));
                $id_curriculum = $curriculum['code'];

                $arr_course = json_decode($curriculum['course'],true);
                $arr_mission = json_decode($curriculum['mission'],true);
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
            
            <div  id="training">

<?php



  $batch = $student['batch'];
  $batch = $this->mymodel->selectDataOne('batch',array('batch'=>$batch));
    $curriculum = $this->mymodel->selectDataOne('syllabus_curriculum', array('code'=>$batch['curriculum']));

    $arr_type_of_training = json_decode($curriculum['type_of_training'],true);
    $arr_course = json_decode($curriculum['course'],true);
    $arr_mission = json_decode($curriculum['mission'],true);

    
    $arr_type_of_training_selected = json_decode($student['type_of_training'],true);
    $arr_course_selected = json_decode($student['course'],true);



    $id_curriculum = $curriculum['code'];

    //  $id_curriculum = $curriculum['id'];
    $data = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_type_of_training ORDER BY position ASC");

    foreach($data as $key=>$val){
      
      if($arr_type_of_training[$val['code']]['status']=="ON"){
      
      
                  
      $table_body = '';
  
  $configuration = '"val":"'.$val['id'].'"';
  $course = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_course  ORDER BY position ASC");

  $grand_total_duration = array();
  foreach($course as $key2=>$val2){    

  if($arr_course[$val['code']][$val2['code']]['status']=="ON"){

  $text = '';
  if($training_requirement[$val['id']]['item'][$val2['id']]['val']==$val2['id']){
      $text = 'checked';
  }    
  
  $course = $val2['code'];
  $curriculum = $val2['curriculum'];
  $type = $val['code'];


  foreach($arr_mission[$val['code']][$val2['code']] as $k5=>$v5){
    if($v5['status']=='ON'){
      $text .= "'".$k5."',";
    }
  }

  $text = substr($text,0,-1);


  if($text){
    $mission = $this->mymodel->selectWithQuery("SELECT * FROM syllabus_mission WHERE type_of_training = '$type' AND code IN ($text) ORDER BY position ASC");
  }

  // print_r($mission);

  
  $duration = array();
  $duration_dual = array();
  $duration_solo = array();
  $duration_pic = array();
  $duration_pic_solo = array();
  $duration_non_rev = array();
  $duration_total = array();
  $total_duration = array();

  foreach($mission as $key3=>$val3){ 
    if ($arr_course_selected[$val['code']][$val2['code']]['status']=="ON") {
    if($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration']){
    $val3['duration'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration'];
    }
    if($arr_mission[$val['code']][$val2['code']][$val3['code']]['price']){
    $val3['price'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['price'];
    }
    if($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_dual']){
    $val3['duration_dual'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_dual'];
    }
    if($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_solo']){
    $val3['duration_solo'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_solo'];
    }
    if($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic']){
    $val3['duration_pic'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic'];
    }
    if($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic_solo']){
    $val3['duration_pic_solo'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_pic_solo'];
    }
    if($arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_non_rev']){
    $val3['duration_non_rev'] = $arr_mission[$val['code']][$val2['code']][$val3['code']]['duration_non_rev'];
    }

    if($val['code']!='FLIGHT'){
      if (strpos($val3['duration'], ':') !== false) {
      array_push($total_duration,$val3['duration']);
      }
    }else{
      if (strpos($val3['duration_dual'], ':') !== false) {
      array_push($duration_dual,$val3['duration_dual']);
      }else if (strpos($val3['duration_solo'], ':') !== false) {
      array_push($duration_solo,$val3['duration_solo']);
      }else if (strpos($val3['duration_pic'], ':') !== false) {
      array_push($duration_pic,$val3['duration_pic']);
      }else if (strpos($val3['duration_pic_solo'], ':') !== false) {
      array_push($duration_pic_solo,$val3['duration_pic_solo']);
      }else if (strpos($val3['duration_non_rev'], ':') !== false) {
      array_push($duration_non_rev,$val3['duration_non_rev']);
      }
      $duration_dual = $this->template->sum_time($duration_dual);
      $duration_solo = $this->template->sum_time($duration_solo);
      $duration_pic = $this->template->sum_time($duration_pic);
      $duration_pic_solo = $this->template->sum_time($duration_pic_solo);
      $duration_non_rev = $this->template->sum_time($duration_non_rev);
      $duration_total[] = $duration_dual;
      $duration_total[] = $duration_solo;
      $duration_total[] = $duration_pic;
      $duration_total[] = $duration_pic_solo;
      $duration_total[] = $duration_non_rev;
      // print_r($duration_total);
      $val3['duration'] = $this->template->sum_time($duration_total);

      if (strpos($val3['duration'], ':') !== false) {
        array_push($total_duration,$val3['duration']);
      }

    }}
  }
  $total_duration = $this->template->sum_time($total_duration);
  array_push($grand_total_duration,$total_duration);

  $text = "";
  if ($arr_course_selected[$val['code']][$val2['code']]['status']=="ON") {
    $text = "checked";
 

  $table_body .= '
      <tr>   
          <td><input disabled '.$text.' type="checkbox" name="course['.$val['code'].']['.$val2['code'].'][status]" value="ON"></td>
          <td class="text-left">'.$val2['code_name'].' - '.$val2['name'].'</td>
          <td>'.$total_duration.'</td>
         
      </tr>
      ';
  }
  }
}
  // print_r($grand_total_duration);
  $grand_total_duration = $this->template->sum_time($grand_total_duration);
  $table_body .= '
  <tr>   
      <th class="text-right" colspan="2">TOTAL</th>
      <th>'.$grand_total_duration.'</th>
     
  </tr>
  ';

 

  $text = "";
  if ($arr_type_of_training_selected[$val['code']]['status']=="ON") {
    $text = "checked";
  


  $table .= ' 
  <table class="table table-bordered">
      <tr class="bg-orange">
          <th style="width:10px;"><input disabled '.$text.' type="checkbox" name="type_of_training['.$val['code'].'][status]" value="ON"></th>
          <th class="text-left"> '.$val['name'].'</th>
          <th class="text-left" style="width:20px;">DURATION</th>
      </tr>
      '.$table_body.'
  </table>';
}


}
}

                  ?>

                  <?= $table; ?>
                   
          

                 
                  </div>    



      </div>
      </div>
      </div>

    </div>

  </div>


