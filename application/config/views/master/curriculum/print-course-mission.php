
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=($curriculum['curriculum'])?> > COURSE >  <?=$header?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

</head>
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
     font-family: "Times New Roman", Times, serif;
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
    .bg-primary{
      background:#333a54;
      color:#fff;
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

<?php
$uri = $this->uri->segment(4);
$curriculum = $this->mymodel->selectDataOne('curriculum',array('code'=>$uri));
?>

<body>
  
      <h1>

      CURRICULUM : <?=$curriculum['curriculum']?>

  
      </h1>


            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                <?=($curriculum['curriculum'])?> > COURSE >  <?=$header?>
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-header" style="display:block!important;">

              <div class="<?=$header?>">

                


                </div>  

              </div>

              

            </div>

            <?php $curriculum_id = $curriculum['code']; ?>

            <?php
            // echo $type;
              if($type=='ground'){
                $bg = 'bg-success';
              }else if($type=='sim'){
                $bg = 'bg-warning';
              }else if($type=='flight'){
                $bg = 'bg-danger';
              }else if($type=='others'){
                $bg = 'bg-default';
              }
            ?>
            <div class="box-body">

                <div class="show_error"></div>


              <?php foreach($course as $key=>$val){ 
                // echo $course = $val['id']; ?>
              <div class="table-responsive">

              
              
              <table class="table table-bordered" style="border-color:#000 1px solid;" id="mytable">
              <?php if($type=='flight'){ ?>
              <tr class="<?=$bg?>">
                 <th style="width:50px;"><a style="margin-top:0px;" href="<?=base_url()?>master/tpm_syllabus_all_course/create/<?=$curriculum_id?>/<?=$val['id']?>/<?=$type?>" class="btn-block btn btn-primary"><i class="mdi mdi-plus"></i></a>
    </th>
                  <th colspan="10"><?=$val['course_code']?> - <?=$val['course_name']?>
                  </th>
                 
                </tr>
                <tr class="<?=$bg?>">
                  <th>NUM</th>
                  <!-- <th style="width:100px;">ACTION</th> -->
                  <th style="width:100px;">CODE</th><th style="width:100px;">MISSION CODE</th>
                  <th style="width:100px;">MISSION</th>
                  <th style="width:100px;">TYPE OF TRAINING</th>
                  <th>DESCRIPTION</th>
                  <th style="width:100px;">DUAL</th>
                  <th style="width:100px;">SOLO</th>
                  <th style="width:100px;">PIC</th>
                  <th style="width:100px;">SOLO (SPV)</th>
                </tr>

                <?php 
             
                $course = $val['code'];
                $curriculum = $uri;
                
                // $this->db->order_by("position ASC");
                $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY position ASC");
                $total_dual = array();
                $total_solo = array();
                $total_pic = array();
                $total_pic_solo = array();
                $total = array();
                foreach($mission as $key2=>$val2){
                  if (strpos($val2['duration_dual'], ':') !== false) {
                    array_push($total_dual,$val2['duration_dual']);
                  }
                  if (strpos($val2['duration_solo'], ':') !== false) {
                    array_push($total_solo,$val2['duration_solo']);
                  }
                  if (strpos($val2['duration_pic'], ':') !== false) {
                    array_push($total_pic,$val2['duration_pic']);
                  }
                  if (strpos($val2['duration_pic_solo'], ':') !== false) {
                    array_push($total_pic_solo,$val2['duration_pic_solo']);
                  }
                  
                  ?>
                  <tr class="">
                  <td class="text-center"><?=$key2+1?></td>
               
                  <?php 
                  //$file = $this->mymodel->selectDataone('file',array('table_id'=>$val2['id'],'table'=>'tpm_syllabus_all_course'));
                  if($file['name']){
                    $val2['subject_mission'] = ''.$val2['subject_mission'].'';
                  }
                  ?>
                  <td><?=$val2['code']?></td><td><?=$val2['subject_mission']?></td>
                  <td class="text-left"><?=$val2['name']?></td>
                  <td class="text-left"><?=$val2['type_of_training2']?> <?=$val2['type_of_training_type2']?></td>
                  <td class="text-left"><?=$val2['description']?></td>
                  <td><?=$val2['duration_dual']?></td>
                  <td><?=$val2['duration_solo']?></td>
                  <td><?=$val2['duration_pic']?></td>
                  <td><?=$val2['duration_pic_solo']?></td>
                  <!-- <td>
                  <a class="btn btn-warning"><i class="mdi mdi-pen"></i></a>
                  <a class="btn btn-danger"><i class="mdi mdi-delete"></i></a>
                  </td> -->
                </tr>
                <?php }
               $total_dual = $this->template->sum_time($total_dual);
               $total_solo = $this->template->sum_time($total_solo);
               $total_pic = $this->template->sum_time($total_pic);
               $total_pic_solo = $this->template->sum_time($total_pic_solo);
                
               
                $total[0] = $total_dual;
                $total[1] = $total_solo;
                $total[2] = $total_pic;
                $total[3] = $total_pic_solo;     

                $total =  $this->template->sum_time($total);
                
                ?>
                <tr class="">
                  <th class="text-right" colspan="6" rowspan="2" style='background:#fff;color:#000;vertical-align:middle;'>TOTAL
                  </th>
                  <th><?=$total_dual?>
                  </th>
                  <th><?=$total_solo?>
                  </th>
                  <th><?=$total_pic?>
                  </th>
                  <th><?=$total_pic_solo?>
                  </th>
                </tr>
                <tr class="">
                  <th colspan="4"><?=$total?>
                  </th>
                </tr>
                <?php }else{ ?>
                <tr class="<?=$bg?>">
                 <th style="width:50px;"><a style="margin-top:0px;" href="<?=base_url()?>master/tpm_syllabus_all_course/create/<?=$curriculum_id?>/<?=$val['id']?>/<?=$type?>" class="btn-block btn btn-primary "><i class="mdi mdi-plus"></i></a>
                </th>
                  <th colspan="7"><?=$val['course_code']?> - <?=$val['course_name']?>
                  </th>
                 
                </tr>
                <tr class="<?=$bg?>">
                  <th>NUM</th>
                  <!-- <th style="width:100px;">ACTION</th> -->
                  <th style="width:100px;">CODE</th><th style="width:100px;">MISSION CODE</th>
                  <th style="width:100px;">MISSION</th>
                  <th style="width:100px;">TYPE OF TRAINING</th>
                  <th>DESCRIPTION</th>
                  <th style="width:100px;">DURATION</th>
                </tr>

                <?php 
                // echo $type;\
                $course = $val['code'];
                $curriculum = $curriculum['code'];
       
                // $this->db->order_by("position ASC");
                $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY position ASC");
               
                $total_duration = array();
                $total = array();
                foreach($mission as $key2=>$val2){
                  if (strpos($val2['duration'], ':') !== false) {
                    array_push($total_duration,$val2['duration']);
                  }
               ?>
                  <tr class="">
                  <td class="text-center"><?=$key2+1?></td>
                 
                  <?php 
                  //$file = $this->mymodel->selectDataone('file',array('table_id'=>$val2['id'],'table'=>'tpm_syllabus_all_course'));
                  if($file['name']){
                    $val2['subject_mission'] = ''.$val2['subject_mission'].'';
                  }
                  ?>
                  <td><?=$val2['code']?></td><td><?=$val2['subject_mission']?></td>
                  <td class="text-left"><?=$val2['name']?></td>
                  <td class="text-left"><?=$val2['type_of_training2']?> <?=$val2['type_of_training_type2']?></td>
                  <td class="text-left"><?=$val2['description']?></td>
                  <td><?=$val2['duration']?></td>
                  <!-- <td>
                  <a class="btn btn-warning"><i class="mdi mdi-pen"></i></a>
                  <a class="btn btn-danger"><i class="mdi mdi-delete"></i></a>
                  </td> -->
                </tr>
                <?php }

                  $total_duration =  $this->template->sum_time($total_duration);
                
                ?>
                <tr class="">
                  <th class="text-right" colspan="6" style="background:#fff;color:#000;">TOTAL
                  </th>
                  <th class="text-center" colspan="1"><?=$total_duration?>
                  </th>
                </tr>
                <?php } ?>
                
              </table>

              </div>


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



  </body>
