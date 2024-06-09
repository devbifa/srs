<?php
$uri = $this->uri->segment(4);
$curriculum = $this->mymodel->selectDataOne('curriculum',array('code'=>$uri));
?>





 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

      CURRICULUM : <?=$curriculum['curriculum']?>

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">CURRICULUM</li>
        <li class="#">COURSE</li>

        <li class="active">DATA</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

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

                

                <div style="margin-left:10px;margin-top:10px;">

 <a href="<?=base_url()?>master/curriculum/course/<?=$curriculum['code']?>" class="btn btn-primary" style="margin-right:5px;">BIFA COURSE</a>

 <?php
$uri = $this->uri->segment(4);
$training_type = $this->mymodel->selectWithQuery("SELECT * FROM training_type WHERE curriculum = '$uri'");
foreach($training_type as $key=>$val){
?>
<a href="<?=base_url()?>master/curriculum/course_mission_custom/<?=$curriculum['code']?>/<?=$val['id']?>" class="btn btn-default" style="margin-right:5px;"><?=$val['training_type']?></a>
<?php } ?>

<a href="<?=base_url()?>master/curriculum/course_mission/<?=$curriculum['code']?>/ground" class="btn btn-success" style="margin-right:5px;">GROUND COURSE</a>

<a href="<?=base_url()?>master/curriculum/course_mission/<?=$curriculum['code']?>/sim" class="btn btn-warning" style="margin-right:5px;">FTD COURSE</a>

<a href="<?=base_url()?>master/curriculum/course_mission/<?=$curriculum['code']?>/flight" class="btn btn-danger" style="margin-right:5px;">FLIGHT TRAINING</a>


<?php
$uris = $this->uri->segment(3);
$types = $this->uri->segment(5);
if($uris=='course_mission'){
  $link = base_url().'master/curriculum/course_mission_print/'.$curriculum['code'].'/'.$types;
}else{
  $link = base_url().'master/curriculum/course_mission_custom_print/'.$curriculum['code'].'/'.$types;
}
?>

<a target="_blank" href="<?=$link?>" class="btn btn-default pull-right" style="margin-right:10px;">CETAK</a>
  

                  <!-- <div class="pull-right">
                  <a href="<?= base_url('master/curriculum/create') ?>">

                    <button type="button" class="btn  btn-success"><i class="fa fa-plus"></i> GROUND COURSE</button> 

                  </a>


                  <a href="<?= base_url('fitur/ekspor/curriculum') ?>" target="_blank">

                    <button type="button" class="btn btn-warning"><i class="fa fa-file-excel-o"></i> EXPORT DATA</button> 

                  </a>

                  <button type="button" class="btn btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> IMPORT DATA</button>

                  </div> -->

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
                 <th style="width:50px;"><a style="margin-top:0px;" href="<?=base_url()?>master/tpm_syllabus_all_course/create_custom/<?=$curriculum_id?>/<?=$val['id']?>/<?=$type?>" class="btn-block btn btn-primary pull-right"><i class="mdi mdi-plus"></i></a>
    </th>
                  <th colspan="6"><?=$val['course_code']?> - <?=$val['course_name']?>
                  </th>
                 
                </tr>
                <tr class="<?=$bg?>">
                  <th>NUM</th>
                  <th style="width:100px;">CODE</th>
                  <th>DESCRIPTION</th>
                  <th style="width:100px;">DUAL</th>
                  <th style="width:100px;">SOLO</th>
                  <th style="width:100px;">PIC</th>
                  <th style="width:100px;">SOLO (SPV)</th>
                </tr>

                <?php 
                // echo $type;\
               
                $course = $val['code'];
                $curriculum = $val['curriculum'];
                
                // $this->db->order_by("mission_number ASC");
                $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY mission_number ASC");
                foreach($mission as $key2=>$val2){ ?>
                  <tr class="">
                  <td><?=$val2['key2']?></td>
                  <?php 
                  $file = $this->mymodel->selectDataone('file',array('table_id'=>$val2['id'],'table'=>'tpm_syllabus_all_course'));
                  if($file['name']){
                    $val2['subject_mission'] = '<a data-placement="top" title="SEE DETAIL MISSION" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val2['subject_mission'].'</a>';
                  }
                  ?>
                  <td><?=$val2['subject_mission']?></td>
                  <td class="text-left"><?=$val2['description']?></td>
                  <td class="text-left"><?=$val2['duration_instruct']?></td>
                  <td><?=$val2['duration_solo']?></td>
                  <td><?=$val2['duration_pic']?></td>
                  <td><?=$val2['duration_solo_pic']?></td>
                  <!-- <td>
                  <a class="btn btn-warning"><i class="mdi mdi-pen"></i></a>
                  <a class="btn btn-danger"><i class="mdi mdi-delete"></i></a>
                  </td> -->
                </tr>
                <?php } ?>
                <?php }else{ ?>
 <tr class="bg-orange">
                 <th style="width:50px;"><a style="margin-top:0px;" href="<?=base_url()?>master/tpm_syllabus_all_course/create_custom/<?=$curriculum_id?>/<?=$val['id']?>/<?=$type?>" class="btn-block btn btn-primary pull-right"><i class="mdi mdi-plus"></i></a>
    </th>
                  <th colspan="6"><?=$val['course_code']?> - <?=$val['course_name']?>
                  </th>
                 
                </tr>
                <tr class="bg-orange">
                  <th>NUM</th>
                  <th style="width:100px;">ACTION</th>
                  <th style="width:100px;">CODE</th>
                  <th style="width:100px;">MISSION CODE</th>
                  <th style="width:100px;">MISSION</th>
                  <th>DESCRIPTION</th>
                  <th style="width:100px;">DURATION</th>
                </tr>

                <?php 
                // echo $type;\
                $course = $val['code'];
                $curriculum = $val['curriculum'];
                
                // $this->db->order_by("mission_number ASC");
                $mission = $this->mymodel->selectWithQuery("SELECT * FROM tpm_syllabus_all_course WHERE course = '$course' AND type_of_training = '$type' AND curriculum = '$curriculum' ORDER BY mission_number ASC");
                $total_duration = array();
                $total = array();
                foreach($mission as $key2=>$val2){ 
                  if (strpos($val2['duration'], ':') !== false) {
                    array_push($total_duration,$val2['duration']);
                  }
                  ?>
                  <tr class="">
                  <td><?=$key2+1?></td>
                  <td>
                    <a class="btn btn-xs btn-rounded btn-warning" href="<?=base_url()?>master/tpm_syllabus_all_course/edit_custom/<?=$val2['id']?>"><i class="mdi mdi-pencil"></i></a>
                    <a class="btn btn-xs btn-rounded btn-danger" href="#!" data-toggle="modal" data-target="#modal-delete-2-<?=$val2['id']?>"><i class="mdi mdi-delete"></i></a>
                 

                      <div class="modal modal-danger fade" id="modal-delete-2-<?=$val2['id']?>">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">DELETE MISSION</h4>
                            </div>
                            <div class="modal-body" style="color:#fff!important;">
                            <form action="">
                              <span style="font-weight:100">Are you sure you want to delete this mission?</span>
                            </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                              <a type="button" class="btn btn-outline" href="<?=base_url()?>master/tpm_syllabus_all_course/delete_custom/<?=$val2['id']?>">Delete Now</a>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                  </td>

                  <?php 
                  $file = $this->mymodel->selectDataone('file',array('table_id'=>$val2['id'],'table'=>'tpm_syllabus_all_course'));
                  if($file['name']){
                    $val2['subject_mission'] = '<a data-placement="top" title="SEE DETAIL MISSION" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val2['subject_mission'].'</a>';
                  }
                  ?>
                  
                  <td><?=$val2['code']?></td>
                  <td><?=$val2['subject_mission']?></td>
                  <td class="text-left"><?=$val2['name']?></td>
                  <td class="text-left"><?=$val2['description']?></td>
                  <td><?=$val2['duration']?></td>
                  <!-- <td>
                  <a class="btn btn-warning"><i class="mdi mdi-pen"></i></a>
                  <a class="btn btn-danger"><i class="mdi mdi-delete"></i></a>
                  </td> -->
                </tr>
                <?php }
                  $sum = strtotime('00:00:00');
                  $sum2=0;  
                  
                  $total_duration =  $this->template->sum_time($total_duration);
                ?>
                 <tr class="">
                  <th class="text-right" colspan="5" style="background:#fff;color:#000;">TOTAL
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


  <div class="modal fade bd-example-modal-sm" tabindex="-1" curriculum="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

      <div class="modal-dialog modal-sm">

          <div class="modal-content">

              <!-- <form id="upload-delete" action="<?= base_url('master/CURRICULUM/delete') ?>"> -->

              <div class="modal-header">

                  <h5 class="modal-title">Confirm delete</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                      <span aria-hidden="true">&times;</span>

                  </button>

              </div>

              <div class="modal-body">

                  <input type="hidden" name="id" id="delete-input">

                  <p>Are you sure to delete this data?</p>

              </div>

              <div class="modal-footer">

                  <button type="submit" class="btn btn-danger btn-send">Yes, Delete</button>

                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

              </div>

              <!-- </form> -->

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

        <!-- <form action="<?= base_url('fitur/impor/curriculum') ?>" method="POST"  enctype="multipart/form-data"> -->



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

        <!-- </form> -->



      </div>

    </div>

  </div>


<a href="" class="btn btn-danger float-1" href="#!" data-toggle="modal" data-target="#modal-delete-1"><i class="mdi mdi-delete"></i></a>



        
<div class="modal modal-danger fade" id="modal-delete-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE TRAINING TYPE</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/training_type/delete/<?=$type?>">
                <span style="font-weight:100">Are you sure you want to delete this training type?</span>
              
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

