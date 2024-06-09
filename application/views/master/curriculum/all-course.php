<?php
$uri = $this->uri->segment(4);
$curriculum = $this->mymodel->selectDataOne('curriculum',array('code'=>$uri));
$course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE curriculum = '$uri' ORDER BY position ASC");
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
                <?=($curriculum['curriculum'])?> > COURSE
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

 <a href="<?=base_url()?>master/curriculum/course/<?=$curriculum['code']?>" class="btn btn-primary" style="margin-right:5px;">BIFA COURSE</a>

      
<?php
$uri = $this->uri->segment(4);
$training_type = $this->mymodel->selectWithQuery("SELECT * FROM training_type WHERE curriculum = '$uri'");
foreach($training_type as $key=>$val){
?>
<a href="<?=base_url()?>master/curriculum/course_mission_custom/<?=$curriculum['code']?>/<?=$val['id']?>" class="btn btn-default" style="margin-right:5px;"><?=$val['training_type']?></a>
<?php } ?>


 <!-- <a href="<?=base_url()?>master/curriculum/course_mission/<?=$curriculum['code']?>/rindam" class="btn btn-info" style="margin-right:5px;">RINDAM</a> -->

<a href="<?=base_url()?>master/curriculum/course_mission/<?=$curriculum['code']?>/ground" class="btn btn-success" style="margin-right:5px;">GROUND COURSE</a>

<a href="<?=base_url()?>master/curriculum/course_mission/<?=$curriculum['code']?>/sim" class="btn btn-warning" style="margin-right:5px;">FTD COURSE</a>

<a href="<?=base_url()?>master/curriculum/course_mission/<?=$curriculum['code']?>/flight" class="btn btn-danger" style="margin-right:5px;">FLIGHT TRAINING</a>
 
<a target="_blank" href="<?=base_url()?>master/curriculum/print/<?=$curriculum['code']?>" class="btn btn-success pull-right">PRINT</a>

<a href="<?=base_url()?>master/training_type/create/<?=$curriculum['code']?>" class="btn btn-primary pull-right">ADD TYPE OF TRAINING</a>

<a href="<?=base_url()?>master/course/create/<?=$curriculum['code']?>" class="btn btn-success pull-right float-1"  data-placement="top" title="ADD COURSE" ><i class="mdi mdi-plus"></i></a>


<a href="<?=base_url()?>master/curriculum/edit/<?=$curriculum['id']?>" class="btn btn-primary pull-right float-3"  data-placement="top" title="EDIT CURRICULUM" ><i class="fa fa-pencil"></i></a>


<a href="" class="btn btn-warning float-4" href="#!" data-toggle="modal" data-target="#modal-clone" data-placement="top" title="CLONE TPM" ><i class="mdi mdi-database-plus"></i></a>
     
<div class="modal modal-warning fade" id="modal-clone">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">CLONE TPM</h4>
               </div>
               <div class="modal-body" style="color:#fff!important;">
                <form action="<?=base_url()?>master/curriculum/clone/<?=$curriculum['id']?>" method="POST">
                 <span style="font-weight:100">Are you sure you want to clone this curriculum data?</span>
                 <br><br>
                 <label for="">New TPM Code</label>
                <input type="text" name="code" class="form-control" required>
                <br>
                 <label for="">New TPM Name</label>
                <input type="text" name="name" class="form-control" required>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-outline">Clone Now</button>
               </div>
               </form>
             </div>
             <!-- /.modal-content -->
           </div>
           <!-- /.modal-dialog -->
         </div>



<a href="" class="btn btn-danger float-2" href="#!" data-toggle="modal" data-target="#modal-delete-1" data-placement="top" title="DELETE CURRICULUM" ><i class="mdi mdi-delete"></i></a>
         
         <div class="modal modal-danger fade" id="modal-delete-1">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">DELETE DATA</h4>
               </div>
               <div class="modal-body" style="color:#fff!important;">
                <form action="<?=base_url()?>master/curriculum/delete/<?=$curriculum['id']?>">
                 <span style="font-weight:100">Are you sure you want to delete this curriculum data?</span>
               
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

         

                </div>  

              </div>

              

            </div>

            <div class="box-body">

                <div class="show_error"></div>



              <div class="table-responsive">

              <table class="table table-bordered table-striped" id="mytable">
                <tr class="bg-orange">
                  <th rowspan="2">NUM</th>
                  <th rowspan="2">CODE</th>
                  <th rowspan="2">COURSE CODE</th>
                  <th rowspan="2">COURSE</th>
                  <th rowspan="2">TYPE OF TRAINING</th>
                  <th colspan="3">MISSION</th>
                  <th rowspan="2">ACTION</th>
                </tr>
                <tr class="bg-orange">
                  
                <th>GROUND</th>
                  <th>FTD</th>
                  <th>FLIGHT</th>
                </tr>

                <?php foreach($course as $key=>$val){
                  $configuration = "";
                  $text = json_decode($val['configuration'],true);
                  foreach($text as $key2=>$val2){
                    if($val2['val']>0){
                      $data = $this->mymodel->selectDataOne('training_type', array('id'=>$val2['val']));
                      if($data){
                        $configuration .= $data['training_type'].', ';
                      }
                    }else{
                      $configuration .= $val2['val'].', ';
                    }
                    $course_code  = $val['code'];
                    $dat = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count, SUM(duration) as hours FROM tpm_syllabus_all_course WHERE type_of_training = 'GROUND' AND course = '$course_code'");
                    $ground = $dat[0]['count'];
                    $ground_hours = $dat[0]['hours'];
                    $dat = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count, SUM(duration) as hours FROM tpm_syllabus_all_course WHERE type_of_training = 'SIM' AND course = '$course_code'");
                    $ftd = $dat[0]['count'];
                    $dat = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count, SUM(duration) as hours FROM tpm_syllabus_all_course WHERE type_of_training = 'FLIGHT' AND course = '$course_code'");
                    $flight = $dat[0]['count'];
                  }
                  $configuration = substr($configuration,0,-2);
                  ?>
                  <tr class="bg-blue">
                  <td><?=$key+1?></td>
                  <td class="text-center"><?=$val['code']?></td>
                  <td class="text-left"><?=$val['course_code']?></td>
                  <td class="text-left"><?=$val['course_name']?></td>
                  <td class="text-left"><?=$configuration?></td>
                  <td class="text-left">
                  <?=intval($ground)?> SUBJECT
                  <br>
                  <?=intval($ground_hours)?> HOURS
                  </td>
                  <td class="text-left">
                  <?=intval($ftd)?> MISSION
                  <br>
                  <?=intval($ftd_hours)?> HOURS
                  </td>
                  <td class="text-left">
                  <?=intval($flight)?> MISSION
                  <br>
                  <?=intval($flight_hours)?> HOURS
                  </td>
                  <td>
                    
                  <a class="btn btn-warning btn-rounded btn-xs" href="<?=base_url()?>master/course/edit/<?=$val['id']?>"><i class="mdi mdi-pencil"></i></a>
                  <a href="<?=base_url()?>master/course/delete/<?=$curriculum['code']?>/<?=$val['id']?>" class="btn btn-danger btn-rounded btn-xs"><i class='mdi mdi-delete'></i></a>
                  </td>
                </tr>
                <?php } ?>
              </table>

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


  <div class="modal fade bd-example-modal-sm" tabindex="-1" curriculum="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

      <div class="modal-dialog modal-sm">

          <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/CURRICULUM/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/curriculum') ?>" method="POST"  enctype="multipart/form-data">



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


