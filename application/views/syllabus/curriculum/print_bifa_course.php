
<style>

body,html, *{
  padding:0px;
  margin:0px;
  font-family: Tahoma, Geneva, sans-serif;
}
table{
  border-collapse: collapse !important;
  margin-bottom:15px;
  width:100%;
}
.no-border{
  border:#fff solid 1px;
}
p,th,td,tr{
    font-family: Tahoma, Geneva, sans-serif;
   }
   h1{
     font-weight:700;
     font-size:25px;
   }
   
		table tr td {
			vertical-align: top;
      
		}
	
    .text-center{
      text-align:center;
    }
    .border-full{
      border:1px #000 solid;
      padding:5px;
    }
    .border-full2{
      /* border:1px #000 solid; */
      padding:5px;
      /* padding-top:5px; */
      /* padding-bottom:5px; */
    }
    
    td,th{
      padding:15px;
    }
    .text-right{
      text-align:right;
    }.text-left{
      text-align:left;
    }
    p,tr,td,th,div{
      font-size:14px;
    }
    th{
      text-align:center;
      padding:5px;
    }
    td{
      padding:5px;
    }

    #left {
    width: 1%;
    /* background: lightblue; */
    display: inline-block;
    float:left;
}
#right {
    width: 60%;
    /* background: orange; */
    display: inline-block;
    float:left;
}
#right2 {
    width: 33%;
    /* background: orange; */
    display: inline-block;
    float:left;
}
td,th{
  border:1px #000 solid;
}

@media print and (color) {
   * {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
   }
}
    
    body{
      margin:15px;
    }
    td{
      text-align:center;
    }
</style>

<h1>
CURRICULUM : <?=$data['name']?>
</h1>
<b>TYPE OF TRAINING : <?=$type_of_training['name']?></b>
<div class="col-md-12">
               
                 
                  <div class="w-100" style="margin-bottom:10px;">
                  <?php 
                  $type_of_training = json_decode($data['type_of_training'],true);
                  if(empty($type_of_training)){
                    echo '<p>SYLLABUS CONFIGURATION HAS NOT BEEN SET!</p>';
                  } ?>
                  <?php
                  $key = $_GET['key'];
                  $arr = json_decode($data['type_of_training'],true);
                  $in = "";
                  foreach($arr as $k=>$v){
                    if($v['status']=='ON'){
                      $in .= "'".$k."',";
                    }
                  }
                  $in = substr($in,0,-1);
                  if($in){
                    $list_1 = $this->mymodel->selectWithQuery("SELECT *
                    FROM syllabus_type_of_training
                    WHERE code IN ($in)
                    ORDER BY position ASC");
                  }
                  $arr_type = array();
                  foreach($list_1 as $k=>$v){
                  $arr_type[] = $v['code'];
                    $class = "btn btn-default";
                    if($v['code']=="FLIGHT"){
                      $class = "btn btn-danger";
                    }else if($v['code']=="FTD"){
                      $class = "btn btn-warning";
                    }else if($v['code']=="GROUND"){
                      $class = "btn btn-success";
                    }
                    ?>
                  <?php } ?>


                  </div>
                  <?php 
                    if(in_array($key,$arr_type)){
                      
                      $class_tr = "bg-default";
                      if($key=="FLIGHT"){
                        $class_tr = "bg-danger";
                      }else if($key=="FTD"){
                        $class_tr = "bg-warning";
                      }else if($key=="GROUND"){
                        $class_tr = "bg-success";
                      }
                      $arr_course = json_decode($data['course'],true);
                      $arr_mission = json_decode($data['mission'],true);
                      $text = '';
                      foreach($arr_course[$key] as $k5=>$v5){
                         
                          if($v5['status']=='ON'){
                            $text .= "'".$k5."',";
                          }
                        }
                      $text = substr($text,0,-1);
                    // echo $text;

                    $qry = '"'.$key.'":{"status":"ON"}';
                    if($text){
                      $course = $this->mymodel->selectWithQuery("SELECT *
                      FROM syllabus_course
                      WHERE type_of_training LIKE '%$qry%' AND code IN ($text)
                      ORDER BY position ASC");
                    }
                    // print_r($course[0]);
                    ?>
                    <?php if(empty($course)){
                    echo '<p>SYLLABUS CONFIGURATION HAS NOT BEEN SET!</p>';
                  } ?>
                    <?php foreach($course as $k=>$v){ ?>
                    <div class="w-100">
                      <div class="table-responsive">
                      <table class="table table-bordered" style="border-color:#000 1px solid;" id="mytable">
                    <tr class="<?=$class_tr?>">
                    <?php if($key!='FLIGHT'){ ?>
                      <th colspan="7">
                    COURSE CODE : <?=$v['code']?>  
                    <br>
                    CODE NAME : <?=$v['code_name']?>  
                    <br>
                    <?=$v['name']?></th>
                    <?php }else{ ?>
                      <th colspan="12">
                    COURSE CODE : <?=$v['code']?>  
                    <br>
                    CODE NAME : <?=$v['code_name']?>  
                    <br>
                    <?=$v['name']?></th>
                  <?php } ?>
                    </tr>
                    <?php if($key!='FLIGHT'){ ?>
                      <tr class="<?=$class_tr?>">
                      <th style="width:50px;">NUM</th>
                      <th style="width:100px;">CODE</th>
                      <th style="width:100px;">CODE NAME</th>
                      <th style="width:250px;">MISSION</th>
                      <th>DESCRIPTION</th>
                      <th style="width:100px;">DURATION</th>
                      <th style="width:100px;" class="text-right">PRICE/H</th>
                    </tr>
                    <?php }else{ ?>
                      <tr class="<?=$class_tr?>">
                      <th style="width:50px;">NUM</th>
                      <th style="width:100px;">CODE</th>
                      <th style="width:100px;">CODE NAME</th>
                      <th style="width:250px;">MISSION</th>
                      <th style="width:100px;">TYPE</th>
                      <th>DESCRIPTION</th>
                      <th style="width:100px;">DUAL</th>
                      <th style="width:100px;">SOLO</th>
                      <th style="width:100px;">PIC</th>
                      <th style="width:100px;">SOLO (SPV)</th>
                      <th style="width:100px;">NON REV</th>
                      <th style="width:100px;" class="text-right">PRICE/H</th>
                    </tr>
                    <?php } ?>
                    
                    <?php 

                    $text = '';
                    foreach($arr_mission[$key][$v['code']] as $k5=>$v5){
                        if($v5['status']=='ON'){
                          $text .= "'".$k5."',";
                        }
                      }
                    $text = substr($text,0,-1);

                    $v_type = $key;
                    $code_course = $v['code'];
                    
                    if($text){

                      $mission = $this->mymodel->selectWithQuery("SELECT *
                      FROM syllabus_mission
                      WHERE type_of_training = '$v_type' AND course = '$code_course' AND code IN ($text)
                      ORDER BY position ASC");


                    }
                    $no = 0;
                    $duration = array();
                    $duration_dual = array();
                    $duration_solo = array();
                    $duration_pic = array();
                    $duration_pic_solo = array();
                    $duration_non_rev = array();
                    $duration_total = array();
                    $price = 0;
                    foreach($mission as $k2=>$v2){
                    $no++;  
                    if($arr_mission[$key][$v['code']][$v2['code']]['duration']){
                      $v2['duration'] = $arr_mission[$key][$v['code']][$v2['code']]['duration'];
                    }
                    if($arr_mission[$key][$v['code']][$v2['code']]['price']){
                      $v2['price'] = $arr_mission[$key][$v['code']][$v2['code']]['price'];
                    }
                    if($arr_mission[$key][$v['code']][$v2['code']]['duration_dual']){
                      $v2['duration_dual'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_dual'];
                    }
                    if($arr_mission[$key][$v['code']][$v2['code']]['duration_solo']){
                      $v2['duration_solo'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_solo'];
                    }
                    if($arr_mission[$key][$v['code']][$v2['code']]['duration_pic']){
                      $v2['duration_pic'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_pic'];
                    }
                    if($arr_mission[$key][$v['code']][$v2['code']]['duration_pic_solo']){
                      $v2['duration_pic_solo'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_pic_solo'];
                    }
                    if($arr_mission[$key][$v['code']][$v2['code']]['duration_non_rev']){
                      $v2['duration_non_rev'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_non_rev'];
                    }
                    $price += $v2['price'];
                    ?>
                    <tr>
                      <?php 
                      
                      if($key!='FLIGHT'){
                        if (strpos($v2['duration'], ':') !== false) {
                          array_push($duration,$v2['duration']);
                        }  
                      ?>
                      <td><?=$no?></td>
                      <td><?=$v2['code']?></td>
                      <td><?=$v2['code_name']?></td>
                      <td class="text-left"><?=$v2['name']?></td>
                      <td class="text-left"><?=$v2['description']?></td>
                      <td><?=$v2['duration']?></td>
                      <td class="text-right"><?=$this->template->to_number($v2['price'])?></td>
                      <?php }else{
                        
                      if (strpos($v2['duration_dual'], ':') !== false) {
                        array_push($duration_dual,$v2['duration_dual']);
                      }else if (strpos($v2['duration_solo'], ':') !== false) {
                        array_push($duration_solo,$v2['duration_solo']);
                      }else if (strpos($v2['duration_pic'], ':') !== false) {
                        array_push($duration_pic,$v2['duration_pic']);
                      }else if (strpos($v2['duration_pic_solo'], ':') !== false) {
                        array_push($duration_pic_solo,$v2['duration_pic_solo']);
                      }else if (strpos($v2['duration_non_rev'], ':') !== false) {
                        array_push($duration_non_rev,$v2['duration_non_rev']);
                      } 

                      ?>
                      <td><?=$no?></td>
                      <td><?=$v2['code']?></td>
                      <td><?=$v2['code_name']?></td>
                      <td class="text-left"><?=$v2['name']?></td>
                      <td class="text-left">
                        <?=$v2['type']?>
                        <?=$v2['type_sub']?>
                      </td>
                      <td class="text-left"><?=$v2['description']?></td>
                      <td><?=$v2['duration_dual']?></td>
                      <td><?=$v2['duration_solo']?></td>
                      <td><?=$v2['duration_pic']?></td>
                      <td><?=$v2['duration_pic_solo']?></td>
                      <td><?=$v2['duration_non_rev']?></td>
                      <td class="text-right"><?=$this->template->to_number($v2['price'])?></td>
                      <?php } ?>
                    </tr>
                    <?php }
                    $duration = $this->template->sum_time($duration);
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
                    $duration_total = $this->template->sum_time($duration_total);
                    ?>
                    <?php if($key!='FLIGHT'){ ?>
                    <tr>
                      <td colspan="5" class="text-right">TOTAL</td>
                      <td><?=$duration?></td>
                      <td class="text-right"><?=$this->template->to_number($price/count($mission))?></td>
                    </tr>
                    <?php }else{ ?>
                      <tr>
                      <td colspan="6" rowspan="2" class="text-right">TOTAL</td>
                      <td><?=$duration_dual?></td>
                      <td><?=$duration_solo?></td>
                      <td><?=$duration_pic?></td>
                      <td><?=$duration_pic_solo?></td>
                      <td><?=$duration_non_rev?></td>
                      <td class="text-right"><?=$this->template->to_number($price/count($mission))?></td>
                    </tr>
                    <tr>
                      <td colspan="5">
                        <?=$duration_total?>
                      </td>
                      <td>
                      </td>
                    </tr>
                    <?php } ?>
                        
                  </table>
                      </div>
                    </div>
                  <?php } ?>

                  <?php } ?>

                  <?php 

                  if($key==""){

                    
                    $mission_exist = array();
                    $mission = $mission = $this->mymodel->selectWithQuery("SELECT *
                    FROM syllabus_mission
                    ORDER BY position ASC");
                    foreach($mission as $k2=>$v2){

                      if($arr_mission[$key][$v['code']][$v2['code']]['duration']){
                        $v2['duration'] = $arr_mission[$key][$v['code']][$v2['code']]['duration'];
                      }
                      if($arr_mission[$key][$v['code']][$v2['code']]['price']){
                        $v2['price'] = $arr_mission[$key][$v['code']][$v2['code']]['price'];
                      }
                      if($arr_mission[$key][$v['code']][$v2['code']]['duration_dual']){
                        $v2['duration_dual'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_dual'];
                      }
                      if($arr_mission[$key][$v['code']][$v2['code']]['duration_solo']){
                        $v2['duration_solo'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_solo'];
                      }
                      if($arr_mission[$key][$v['code']][$v2['code']]['duration_pic']){
                        $v2['duration_pic'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_pic'];
                      }
                      if($arr_mission[$key][$v['code']][$v2['code']]['duration_pic_solo']){
                        $v2['duration_pic_solo'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_pic_solo'];
                      }
                      if($arr_mission[$key][$v['code']][$v2['code']]['duration_non_rev']){
                        $v2['duration_non_rev'] = $arr_mission[$key][$v['code']][$v2['code']]['duration_non_rev'];
                      }
                      
                      if($v2['type_of_training'] != 'FLIGHT'){

                      }else{
                        
                      }
                      
                      $mission_exist[$v2['type_of_training']][$v2['course']][$v2['code']]['status'] = 'ON';
                      $mission_exist[$v2['type_of_training']][$v2['course']][$v2['code']]['duration'] = $v2['duration'];
                      $mission_exist[$v2['type_of_training']][$v2['course']][$v2['code']]['duration_dual'] = $v2['duration_dual'];
                      $mission_exist[$v2['type_of_training']][$v2['course']][$v2['code']]['duration_solo'] = $v2['duration_solo'];
                      $mission_exist[$v2['type_of_training']][$v2['course']][$v2['code']]['duration_pic'] = $v2['duration_pic'];
                      $mission_exist[$v2['type_of_training']][$v2['course']][$v2['code']]['duration_pic_solo'] = $v2['duration_pic_solo'];
                      $mission_exist[$v2['type_of_training']][$v2['course']][$v2['code']]['duration_non_rev'] = $v2['duration_non_rev'];
                    
                    }


                    $arr_type_of_training = json_decode($data['type_of_training'],true);
                    $arr_course = json_decode($data['course'],true);
                    $arr_mission = json_decode($data['mission'],true);
                    $text = '';
                    $text_2 = '';
                    foreach($arr_type_of_training as $k4=>$v4){
                      if($v4['status']=="ON"){
                        $text_2 .= "'".$k4."',";
                        foreach($arr_course[$k4] as $k5=>$v5){
                          if($v5['status']=='ON'){
                            $text .= "'".$k5."',";
                          }
                        }
                      }
                    }
                    $text = substr($text,0,-1);
                    $text_2 = substr($text_2,0,-1);
                   
                    if($text){
                      $course = $this->mymodel->selectWithQuery("SELECT *
                      FROM syllabus_course
                      WHERE code IN ($text)
                      ORDER BY position ASC");
                    }

                    if($text_2){
                      $type_of_training = $this->mymodel->selectWithQuery("SELECT *
                      FROM syllabus_type_of_training
                      WHERE code IN ($text_2)
                      ORDER BY position ASC");
                    }
                    $th_count = 0;
                    foreach($type_of_training as $k2=>$v2){
                        $th_custom .= "<th>".$v2['name']."</th>";
                        $th_count++;
                    }


                    ?>
                  <div class="table-responsive">

<table class="table table-bordered table-striped" id="mytable">
  <tbody><tr class="bg-primary">
    <th rowspan="2">NUM</th>
    <th rowspan="2">CODE</th>
    <th rowspan="2">COURSE</th>
    <th rowspan="2">TYPE OF TRAINING</th>
    <th colspan="<?=$th_count?>">MISSION</th>
  </tr>
  <tr class="bg-primary">
    
  <?=$th_custom?>
  </tr>
  <?php foreach($course as $k=>$v){ 
    $text = '';
    foreach($arr_type_of_training as $k2=>$v2){
      if($arr_course[$k2][$v['code']]['status']=="ON" AND $arr_type_of_training[$k2]['status']){
        $text .= "".$k2.",";
      }
    }
    $text = substr($text,0,-1);
   
  ?>
  <tr class="">
    <td><?=++$k?></td>
    <td class="text-center"><?=$v['code']?> </td>
    <td class="text-left"><?=$v['name']?></td>
    <td class="text-left"><?=$text?></td>
    <?php foreach($type_of_training as $k2=>$v2){
    $subject = 0;
    $duration = array();
    foreach($arr_mission[$v2['code']][$v['code']] as $k3=>$v3){
      if($mission_exist[$v2['code']][$v['code']][$k3]['status']=='ON'){
        $subject++;
        if($v2['code']!='FLIGHT'){
          if (strpos($mission_exist[$v2['code']][$v['code']][$k3]['duration'], ':') !== false) {
            array_push($duration,$mission_exist[$v2['code']][$v['code']][$k3]['duration']);
          }
        }else{
          if (strpos($mission_exist[$v2['code']][$v['code']][$k3]['duration_dual'], ':') !== false) {
            array_push($duration,$mission_exist[$v2['code']][$v['code']][$k3]['duration_dual']);
          }else if (strpos($mission_exist[$v2['code']][$v['code']][$k3]['duration_solo'], ':') !== false) {
            array_push($duration,$mission_exist[$v2['code']][$v['code']][$k3]['duration_solo']);
          }else if (strpos($mission_exist[$v2['code']][$v['code']][$k3]['duration_pic'], ':') !== false) {
            array_push($duration,$mission_exist[$v2['code']][$v['code']][$k3]['duration_pic']);
          }else if (strpos($mission_exist[$v2['code']][$v['code']][$k3]['duration_pic_solo'], ':') !== false) {
            array_push($duration,$mission_exist[$v2['code']][$v['code']][$k3]['duration_pic_solo']);
          }else if (strpos($mission_exist[$v2['code']][$v['code']][$k3]['duration_non_rev'], ':') !== false) {
            array_push($duration,$mission_exist[$v2['code']][$v['code']][$k3]['duration_non_rev']);
          }
        }
      }  
    }
    $duration = $this->template->sum_time($duration);
    ?>
    <td class="text-left">
    <?php if($subject > 0 AND $arr_type_of_training[$v2['code']]['status']=="ON"){ ?>
    <?=$subject?> SUBJECT
    <br>
    <?=$duration?> HOURS
    <?php } ?>
    </td>
    <?php } ?>
  </tr>
  <?php } ?>
                </tbody></table>

</div>

                  <?php } ?>

                </div>
            