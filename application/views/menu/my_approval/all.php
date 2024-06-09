



 <!-- Content Wrapper. Contains page content -->

 <div class="content-wrapper">

<!-- Content Header (Page header) -->

<section class="content-header">

  <h1>

    DAILY FTD SCHEDULE

    <small>DATA</small>

  </h1>

  <ol class="breadcrumb">

    <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

    <li class="#">DAILY FTD SCHEDULE</li>

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
           MY SCHEDULE APPROVAL
            </div>
            <div class="col-xs-2">
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            </div>
        </div>


        <div class="box-header">

          <div class="row">

            <div class="col-md-6">

              <select onchange="loadtable(this.value)" id="select-status" style="width: 150px" class="form-control">

                  <option value="ENABLE">ENABLE</option>

                  <option value="DISABLE">DISABLE</option>



              </select>

            </div>

            <div class="col-md-6">

              <div class="pull-right">   
              </div>

            </div>  

          </div>

          

        </div>

        <div class="box-body">

            <div class="show_error"></div>

               <!-- FILTER  -->
        <div class="row">
                        <div class="">
                            <form autocomplete="off" action="<?= base_url() ?>menu/my_approval/filter" method="post">
                            <div class="col-md-2">
                                    <div class="form-group">
                                        <label>ORIGIN BASE</label>
                                        <select style='width:100%' name="origin_base" class="form-control select2">
                                          <option value="">SELECT ORIGIN BASE</option>
                                            <?php 
                                              $this->db->order_by('base ASC');
                                              $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);

                                              foreach ($base_airport_document as $base_airport_document_record) {

                                                $text="";

                                                if($base_airport_document_record['base']==$_SESSION['origin_base']){

                                                  $text = "selected";

                                                }



                                                echo "<option value='".$base_airport_document_record['base']."' ".$text." >".$base_airport_document_record['base']."</option>";

                                              }

                                              ?>

                                            </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>START DATE</label>
                                        <input placeholder="Start Date" type="text" class="form-control tgl" value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>END DATE</label>
                                        <input placeholder="End Date" type="text" class="form-control tgl" class="form-control" value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
                                    </div>
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

                    <?=$_SESSION['propose']?>
               <?php $_SESSION['propose'] = '' ?>

                    <label>FLIGHT SCHEDULE</label>
                    <div class="table-responsive">

<table class="table table-bordered" id="datatable" style="width:100%">

<thead>

<tr class="bg-success">
<th style="width:20px" rowspan="2">NUM</th>
<th rowspan="2">ACTION</th>
<th style="min-width:95px" >DATE</th>
<th >BASE</th>
<th style="width:150px">PREPARE BY</th>
<th style="width:150px" >APPROVE BY</th>
<th >APPROVAL STATUS</th>
<!-- <th style="width:150px" >APPROVED 2</th>
<th >APPROVAL STATUS 2</th> -->
<th>TOTAL SCHEDULE</th>

</tr>
</thead>

<tbody>
<?php $total = array();
$start_date = $_SESSION['start_date'];
  $end_date = $_SESSION['end_date'];
  $origin_base = $_SESSION['origin_base'];

  if(empty($start_date)){
    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
  }

  if(empty($end_date)){
    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
  }

  if($origin_base){
    $origin_base = "  AND a.origin_base = '$origin_base' ";
  }else{
    $origin_base = " ";
  }

  $my_id = $_SESSION['id'];

  $data =  $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND type = 'FLIGHT'  AND (prepared_by='$my_id' OR approved_by='$my_id') ORDER BY date DESC");
  foreach($data as $key=>$val){
    $id_approved_by = $val['approved_by'];
    $id_approved_by_2 = $val['approved_by_2'];


    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['prepared_by']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['prepared_by'] = $dat['full_name'].'<br>'.$role['role'];

    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['approved_by']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['approved_by'] = $dat['full_name'].'<br>'.$role['role'];

    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['approved_by_2']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['approved_by_2'] = $dat['full_name'].'<br>'.$role['role'];

    $val['approval_status'] = $val['approval_status'];
    $val['approval_status_2'] = $val['approval_status_2'];
    $date = $val['date'];
    $base = $val['base'];
    $total_schedule = $this->mymodel->selectWithQuery("SELECT COUNT(id)  as count FROM daily_flight_schedule
    WHERE DATE(date_of_flight) = '$date' AND origin_base = '$base'");

    $total_schedule = $total_schedule[0]['count'];

$nomor++; ?>
<tr>
<td><?=$nomor?>
</td>
<td style="min-width:50px;">

<!-- <a href="<?=base_url()?>menu/my_approval/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a> -->
<?php if($id_approved_by==$my_id){  ?>
<?php if($val['approval_status']!='APPROVED'){ ?>
<a class="btn btn-success btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-approve-<?=$val['id']?>-FLIGHT"  data-placement="top" title="APPROVE SCHEDULE" ><i class="mdi mdi-check"></i></a>
<?php }else if($val['approval_status']=='APPROVED'){ ?>
<a class="btn btn-warning btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-rollback-<?=$val['id']?>-FLIGHT"  data-placement="top" title="ROLLBACK SCHEDULE" ><i class="mdi mdi-reload"></i></a>
<?php } ?>
<?php } ?>
<?php if($id_approved_by_2==$my_id){ ?>
<?php if($val['approval_status_2']!='APPROVED'){ ?>
<a class="btn btn-success btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-approve2-<?=$val['id']?>-FLIGHT"  data-placement="top" title="APPROVE SCHEDULE 2" ><i class="mdi mdi-check"></i></a>
<?php }else if($val['approval_status_2']=='APPROVED'){ ?>
<a class="btn btn-warning btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-rollback2-<?=$val['id']?>-FLIGHT"  data-placement="top" title="ROLLBACK SCHEDULE 2" ><i class="mdi mdi-reload"></i></a>
<?php } ?>
<?php } ?>

<div class="modal modal-success fade" id="modal-approve-<?=$val['id']?>-FLIGHT">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">APPROVE DAILY FLIGHT SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/approve/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to approve this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Approve Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    
<div class="modal modal-success fade" id="modal-approve2-<?=$val['id']?>-FLIGHT">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">APPROVE DAILY FLIGHT SCHEDULE</h4>
  </div>
  <div class="modal-body" style="color:#fff!important;">
    <form action="<?=base_url()?>menu/my_approval/approve_2/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
    <p>Are you sure to approve this schedule?</p>
    
    </div>
  
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-outline">Approve Schedule</button>
    </form>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
      
<div class="modal modal-warning fade" id="modal-rollback-<?=$val['id']?>-FLIGHT">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ROLLBACK DAILY FLIGHT SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/rollback/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to rollback this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Rollback Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


    <div class="modal modal-warning fade" id="modal-rollback2-<?=$val['id']?>-FLIGHT">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ROLLBACK DAILY FLIGHT SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/rollback_2/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to rollback this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Rollback Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


</td>
<td>

<?=$val['date']?></td>
<td><?=$val['base']?></td>
<td class="text-left"><?=$val['prepared_by']?><br><?=$this->template->date_with_time($val['prepared_time'])?></td>
<td class="text-left"><?=$val['approved_by']?><br><?=$this->template->date_with_time($val['approved_time'])?></td>
<td><?=$val['approval_status']?></td>
<!-- <td class="text-left"><?=$val['approved_by_2']?><br><?=$this->template->date_with_time($val['approved_2_time'])?></td>
<td><?=$val['approval_status_2']?></td> -->
<td><?=$total_schedule?></td>
</tr>

<?php } 

$total =  $this->template->sum_time($total);
$total2 =  $this->template->sum_time($total2);

?>
</tbody>

</table>

</div>




<br>
<br>



<label>FTD SCHEDULE</label>
<div class="table-responsive">

<table class="table table-bordered" id="datatable" style="width:100%">

<thead>

<tr class="bg-success">
<th style="width:20px" rowspan="2">NUM</th>
<th rowspan="2">ACTION</th>
<th style="min-width:95px" >DATE</th>
<th >BASE</th>
<th style="width:100px">PREPARE BY</th>
<th style="width:150px" >APPROVE BY</th>
<th >APPROVAL STATUS</th>
<!-- <th style="width:150px" >APPROVED 2</th>
<th >APPROVAL STATUS 2</th> -->
<th>TOTAL SCHEDULE</th>

</tr>
</thead>

<tbody>
<?php $total = array();
$start_date = $_SESSION['start_date'];
  $end_date = $_SESSION['end_date'];
  $origin_base = $_SESSION['origin_base'];

  if(empty($start_date)){
    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
  }

  if(empty($end_date)){
    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
  }

  if($origin_base){
    $origin_base = "  AND a.origin_base = '$origin_base' ";
  }else{
    $origin_base = " ";
  }

  $my_id = $_SESSION['id'];

  $data =  $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND type = 'FTD'  AND (prepared_by='$my_id' OR approved_by='$my_id') ORDER BY date DESC");
//  echo "SELECT * FROM approval WHERE DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND type = 'FTD'  AND (prepared_by='$my_id' OR approved_by='$my_id') ORDER BY date DESC";
  $nomor = 0;
  foreach($data as $key=>$val){
    $id_approved_by = $val['approved_by'];
    $id_approved_by_2 = $val['approved_by_2'];


    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['prepared_by']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['prepared_by'] = $dat['full_name'].'<br>'.$role['role'];

    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['approved_by']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['approved_by'] = $dat['full_name'].'<br>'.$role['role'];

    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['approved_by_2']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['approved_by_2'] = $dat['full_name'].'<br>'.$role['role'];

    $val['approval_status'] = $val['approval_status'];
    $val['approval_status_2'] = $val['approval_status_2'];
    $date = $val['date'];
    $base = $val['base'];
    $total_schedule = $this->mymodel->selectWithQuery("SELECT COUNT(id)  as count FROM daily_ftd_schedule
    WHERE DATE(date) = '$date'");

    $total_schedule = $total_schedule[0]['count'];

$nomor++; ?>
<tr>
<td><?=$nomor?>
</td>
<td style="min-width:50px;">


<!-- <a href="<?=base_url()?>menu/my_approval/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a> -->

<?php if($id_approved_by==$my_id){  ?>    
<?php if($val['approval_status']!='APPROVED'){ ?>
<a class="btn btn-success btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-approve-<?=$val['id']?>-FTD"  data-placement="top" title="APPROVE SCHEDULE" ><i class="mdi mdi-check"></i></a>
<?php }else if($val['approval_status']=='APPROVED'){ ?>
<a class="btn btn-warning btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-rollback-<?=$val['id']?>-FTD"  data-placement="top" title="ROLLBACK SCHEDULE" ><i class="mdi mdi-reload"></i></a>
<?php } ?>
<?php } ?>
<?php if($id_approved_by_2==$my_id){ ?>
<?php if($val['approval_status_2']!='APPROVED'){ ?>
<a class="btn btn-success btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-approve2-<?=$val['id']?>-FTD"  data-placement="top" title="APPROVE SCHEDULE 2" ><i class="mdi mdi-check"></i></a>
<?php }else if($val['approval_status_2']=='APPROVED'){ ?>
<a class="btn btn-warning btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-rollback2-<?=$val['id']?>-FTD"  data-placement="top" title="ROLLBACK SCHEDULE 2" ><i class="mdi mdi-reload"></i></a>
<?php } ?>
<?php } ?>

<div class="modal modal-success fade" id="modal-approve-<?=$val['id']?>-FTD">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">APPROVE DAILY FTD SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/approve/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to approve this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Approve Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    
<div class="modal modal-success fade" id="modal-approve2-<?=$val['id']?>-FTD">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">APPROVE DAILY FTD SCHEDULE</h4>
  </div>
  <div class="modal-body" style="color:#fff!important;">
    <form action="<?=base_url()?>menu/my_approval/approve_2/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
    <p>Are you sure to approve this schedule?</p>
    
    </div>
  
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-outline">Approve Schedule</button>
    </form>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
      
<div class="modal modal-warning fade" id="modal-rollback-<?=$val['id']?>-FTD">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ROLLBACK DAILY FTD SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/rollback/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to rollback this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Rollback Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


    <div class="modal modal-warning fade" id="modal-rollback2-<?=$val['id']?>-FTD">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ROLLBACK DAILY FTD SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/rollback_2/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to rollback this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Rollback Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


</td>
<td>

<?=$val['date']?></td>
<td><?=$val['base']?></td>
<td class="text-left"><?=$val['prepared_by']?><br><?=$this->template->date_with_time($val['prepared_time'])?></td>
<td class="text-left"><?=$val['approved_by']?><br><?=$this->template->date_with_time($val['approved_time'])?></td>
<td><?=$val['approval_status']?></td>
<!-- <td class="text-left"><?=$val['approved_by_2']?><br><?=$this->template->date_with_time($val['approved_2_time'])?></td>
<td><?=$val['approval_status_2']?></td> -->
<td><?=$total_schedule?></td>
</tr>

<?php } 

$total =  $this->template->sum_time($total);
$total2 =  $this->template->sum_time($total2);

?>
</tbody>

</table>

</div>


<br><br>

<label>GROUND SCHEDULE</label>
<div class="table-responsive">

<table class="table table-bordered" id="datatable" style="width:100%">

<thead>

<tr class="bg-success">
<th style="width:20px" rowspan="2">NUM</th>
<th rowspan="2">ACTION</th>
<th style="min-width:95px" >DATE</th>
<th >BASE</th>
<th style="width:100px">PREPARE BY</th>
<th style="width:150px" >APPROVE BY</th>
<th >APPROVAL STATUS</th>
<!-- <th style="width:150px" >APPROVED 2</th>
<th >APPROVAL STATUS 2</th> -->
<th>TOTAL SCHEDULE</th>

</tr>
</thead>

<tbody>
<?php $total = array();
$start_date = $_SESSION['start_date'];
  $end_date = $_SESSION['end_date'];
  $origin_base = $_SESSION['origin_base'];

  if(empty($start_date)){
    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
  }

  if(empty($end_date)){
    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];
  }

  if($origin_base){
    $origin_base = "  AND a.origin_base = '$origin_base' ";
  }else{
    $origin_base = " ";
  }

  $my_id = $_SESSION['id'];

  $data =  $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND type = 'GROUND'  AND (prepared_by='$my_id' OR approved_by='$my_id') ORDER BY date DESC");
  $nomor = 0;
  foreach($data as $key=>$val){
    $id_approved_by = $val['approved_by'];
    $id_approved_by_2 = $val['approved_by_2'];


    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['prepared_by']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['prepared_by'] = $dat['full_name'].'<br>'.$role['role'];

    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['approved_by']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['approved_by'] = $dat['full_name'].'<br>'.$role['role'];

    $dat = $this->mymodel->selectDataOne('user', array('id'=>$val['approved_by_2']));
    $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role']));

    $val['approved_by_2'] = $dat['full_name'].'<br>'.$role['role'];

    $val['approval_status'] = $val['approval_status'];
    $val['approval_status_2'] = $val['approval_status_2'];
    $date = $val['date'];
    $base = $val['base'];
    $total_schedule = $this->mymodel->selectWithQuery("SELECT COUNT(id)  as count FROM daily_ground_schedule
    WHERE DATE(date) = '$date'");

    $total_schedule = $total_schedule[0]['count'];

$nomor++; ?>
<tr>
<td><?=$nomor?>
</td>
<td style="min-width:50px;">



<?php if($id_approved_by==$my_id){  ?>
<!-- <a href="<?=base_url()?>menu/my_approval/edit/<?=$val['id']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a> -->

<?php if($val['approval_status']!='APPROVED'){ ?>
<a class="btn btn-success btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-approve-<?=$val['id']?>-GROUND"  data-placement="top" title="APPROVE SCHEDULE" ><i class="mdi mdi-check"></i></a>
<?php }else if($val['approval_status']=='APPROVED'){ ?>
<a class="btn btn-warning btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-rollback-<?=$val['id']?>-GROUND"  data-placement="top" title="ROLLBACK SCHEDULE" ><i class="mdi mdi-reload"></i></a>
<?php } ?>
<?php } ?>
<?php if($id_approved_by_2==$my_id){ ?>
<?php if($val['approval_status_2']!='APPROVED'){ ?>
<a class="btn btn-success btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-approve2-<?=$val['id']?>-GROUND"  data-placement="top" title="APPROVE SCHEDULE 2" ><i class="mdi mdi-check"></i></a>
<?php }else if($val['approval_status_2']=='APPROVED'){ ?>
<a class="btn btn-warning btn-rounded btn-xs" href="#!" data-toggle="modal" data-target="#modal-rollback2-<?=$val['id']?>-GROUND"  data-placement="top" title="ROLLBACK SCHEDULE 2" ><i class="mdi mdi-reload"></i></a>
<?php } ?>
<?php } ?>

<div class="modal modal-success fade" id="modal-approve-<?=$val['id']?>-GROUND">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">APPROVE DAILY GROUND SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/approve/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to approve this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Approve Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

    
<div class="modal modal-success fade" id="modal-approve2-<?=$val['id']?>-GROUND">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">APPROVE DAILY GROUND SCHEDULE</h4>
  </div>
  <div class="modal-body" style="color:#fff!important;">
    <form action="<?=base_url()?>menu/my_approval/approve_2/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
    <p>Are you sure to approve this schedule?</p>
    
    </div>
  
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-outline">Approve Schedule</button>
    </form>
  </div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
      
<div class="modal modal-warning fade" id="modal-rollback-<?=$val['id']?>-GROUND">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ROLLBACK DAILY GROUND SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/rollback/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to rollback this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Rollback Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


    <div class="modal modal-warning fade" id="modal-rollback2-<?=$val['id']?>-GROUND">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">ROLLBACK DAILY GROUND SCHEDULE</h4>
          </div>
          <div class="modal-body" style="color:#fff!important;">
           <form action="<?=base_url()?>menu/my_approval/rollback_2/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <p>Are you sure to rollback this schedule?</p>
           
            </div>
         
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-outline">Rollback Schedule</button>
            </form>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>


</td>
<td>

<?=$val['date']?></td>
<td><?=$val['base']?></td>
<td class="text-left"><?=$val['prepared_by']?><br><?=$this->template->date_with_time($val['prepared_time'])?></td>
<td class="text-left"><?=$val['approved_by']?><br><?=$this->template->date_with_time($val['approved_time'])?></td>
<td><?=$val['approval_status']?></td>
<!-- <td class="text-left"><?=$val['approved_by_2']?><br><?=$this->template->date_with_time($val['approved_2_time'])?></td>
<td><?=$val['approval_status_2']?></td> -->
<td><?=$total_schedule?></td>
</tr>

<?php } 

$total =  $this->template->sum_time($total);
$total2 =  $this->template->sum_time($total2);

?>
</tbody>

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


<div class="modal modal-danger fade" id="modal-delete">

<div class="modal-dialog">
        <div class="modal-content">

          <form id="upload-delete" action="<?= base_url('master/daily_ftd_report/delete') ?>">

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

    <form action="<?= base_url('fitur/impor/daily_ftd_report') ?>" method="POST"  enctype="multipart/form-data">



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



<script type="text/javascript">



    function loadtable(status) {

        var table = '<table class="table table-bordered" id="mytable" style="width:100%">'+

               '     <thead>'+

               '     <tr class="bg-success">'+

               '       <th rowspan="2" style="width:20px">NUM</th>'+'<th rowspan="2" style="min-width:20px">ACTION</th>'+'<th rowspan="2" style="min-width:60px">DATE</th>'+'<th rowspan="2">FTD MODEL</th>'+'<th rowspan="2">BATCH</th>'+'<th rowspan="2">COURSE</th>'+'<th rowspan="2">MISSION</th>'+'<th rowspan="2">INSTRUCTOR</th>'+'<th rowspan="2">STUDENT</th>'+'<th rowspan="2">ETD UTC</th>'+'<th rowspan="2">ETA UTC</th>'+'<th rowspan="2">EET</th>'+'<th rowspan="2">REMARK</th>'+'<th colspan="3">BLOCK TIME</th>'+'<th rowspan="2">REMARK REPORT</th>'+
              
               '     </tr>'+
               '     <tr class="bg-success">'+
               '<th>ATD</th>'+'<th>ATA</th>'+'<th>TOTAL</th>'+
               '     </tr>'+
               '     </thead>'+

               '     <tbody>'+

               '     </tbody>'+

               ' </table>';

         // body...

         $("#load-table").html(table)



          var t = $("#mytable").dataTable({

            initComplete: function() {

                var api = this.api();

                $('#mytable_filter input')

                        .off('.DT')

                        .on('keyup.DT', function(e) {

                            if (e.keyCode == 13) {

                                api.search(this.value).draw();

                    }

                });

            },

            oLanguage: {

                sProcessing: "loading..."

            },

            processing: true,

            serverSide: true,

            ajax: {"url": "<?= base_url('master/daily_ftd_report/json?status=') ?>"+status, "type": "POST"},

            columns: [

                {"data": "id","orderable": false},{"data": "date"},{"data": "date"},{"data": "ftd_model"},{"data": "batch"},{"data": "course"},{"data": "mission"},{"data": "pic"},{"data": "2nd"},{"data": "etd_utc"},{"data": "eta"},{"data": "eet_utc"},{"data": "remark"},
                {"data": "block_time_atd"},{"data": "block_time_ata"},{"data": "block_time_total"},{"data": "remark_report"},

   

            ],

            order: [[1, 'asc']],

            columnDefs : [

              { targets : [1],

render : function (data, type, row, meta) {

 htmls = '<a href="<?=base_url()?>master/daily_ftd_report/edit/'+row['id']+'" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>';
  return htmls;

}
                  },
                  
                  {
  "targets": 3,
  "className": "text-left",
},

{
  "targets": 5,
  "className": "text-left",
},


{
  "targets": 6,
  "className": "text-left",
},


{
  "targets": 7,
  "className": "text-left",
},


{
  "targets": 8,
  "className": "text-left",
},



            ],

         

            rowCallback: function(row, data, iDisplayIndex) {

                var info = this.fnPagingInfo();

                var page = info.iPage;

                var length = info.iLength;

                var index = page * length + (iDisplayIndex + 1);

                $('td:eq(0)', row).html(index);

            }

        });

     }





     loadtable($("#select-status").val());

       

  function edit(id) {

        location.href = "<?= base_url('master/daily_ftd_report/edit/') ?>"+id;

     }
     function preview(id) {

      location.href = "<?= base_url('master/daily_ftd_report/preview/') ?>"+id;

   }
              function hapus(id) {

        $("#modal-delete").modal('show');

        $("#delete-input").val(id);

        

     }

     $("#upload-delete").submit(function(){

        event.preventDefault();

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

                $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                $(".show_error").slideUp().html("");

            },

            success: function(response, textStatus, xhr) {

               var str = response;

                if (str.indexOf("success") != -1){

                    $(".show_error").hide().html(response).slideDown("fast");

                   

                    $(".btn-send").removeClass("disabled").html('Yes, Delete it').attr('disabled',false);

                }else{

                     setTimeout(function(){ 

                       $("#modal-delete").modal('hide');

                    }, 1000);

                    $(".show_error").hide().html(response).slideDown("fast");

                    $(".btn-send").removeClass("disabled").html('Yes , Delete it').attr('disabled',false);

                    loadtable($("#select-status").val());

                }

            },

            error: function(xhr, textStatus, errorThrown) {

        

            }

        });

        return false;



    });

</script>