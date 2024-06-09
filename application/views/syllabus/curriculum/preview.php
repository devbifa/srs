

<a href="#!" class="btn btn-danger float-4" href="#!" data-toggle="modal" data-target="#modal-deletes" data-placement="top" title="DELETE USER DATA"><i class="mdi mdi-delete-forever"></i></a>
<div class="modal modal-danger fade" id="modal-deletes">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">DELETE DATA</h4>
      </div>
      <div class="modal-body" style="color:#fff!important;">
        <form action="<?=base_url()?>syllabus/curriculum/delete/<?=$data['id']?>">
        <span style="font-weight:100">Are you sure you want to delete this data?</span>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline">Delete Now</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<a href="<?= base_url('syllabus/curriculum/clone/'.$data['id']) ?>">
<button type="button" class="btn btn-sm btn-success float-3"  data-placement="top" title="CLONE DATA" ><i class="mdi mdi-content-copy"></i></button> 
</a>
<a href="<?= base_url('syllabus/curriculum/edit/'.$data['id']) ?>">
<button type="button" class="btn btn-sm btn-success float-2"  data-placement="top" title="EDIT DATA" ><i class="mdi mdi-pencil"></i></button> 
</a>

<a href="<?=base_url()?>syllabus/curriculum/configuration/<?=$data['id']?>">

  <button type="button" class="btn btn-sm btn-success float-1" data-placement="top" title="CONFIGURATION DATA"><i class="mdi mdi-settings"></i></button> 

</a>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        CLASSROOM

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">CLASSROOM</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('syllabus/mission/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                SYLLABUS CURRICULUM
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
              
             <div class="col-md-12">
                  <label for="">CODE</label>
                  <p><?=$data['code']?></p>
                </div>
                <div class="col-md-12">
                  <label for="">CURRICULUM</label>
                  <p><?=$data['name']?></p>
                </div>
                <div class="col-md-12">
                  <label for="">DESCRIPTION</label>
                  <p><?=$data['description']?></p>
                </div>
                <div class="col-md-12">
                  <label for="">SYLLABUS CONFIGURATION</label>
                 
                  <div class="w-100" style="margin-bottom:10px;">
                  <a href="<?=base_url()?>syllabus/curriculum/preview/<?=$data['id']?>"  style="margin-right:5px;" class="btn btn-primary">BIFA COURSE</a>
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
                    <a href="<?=base_url()?>syllabus/curriculum/preview/<?=$data['id']?>?key=<?=$v['code']?>"  style="margin-right:5px;" class="<?=$class?>"><?=$v['name']?></a>
                  <?php } ?>

                  <a target="_blank" href="<?=base_url()?>syllabus/curriculum/print_mission/<?=$data['id']?>?key=<?=$key?>"  style="margin-right:5px;" class="btn btn-default pull-right">PRINT</a>

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
                   
                   
                    $mission = array();
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
             </div>

            </div>


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

                           window.location.href = "<?= base_url('syllabus/mission') ?>";

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