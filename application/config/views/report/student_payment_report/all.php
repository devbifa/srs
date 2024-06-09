<style>
  .text-red{
    background-color: red;
    color:#000!important;  
  }
  .text-yellow{
    background-color: yellow;
    color:#000!important;  
  }
</style>



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FLIGHT SCHEDULE

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">DAILY FLIGHT SCHEDULE</li>

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
             STUDENT PAYMENT REPORT
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

                

              </div>

              

            </div>

            <div class="box-body">

                <!-- FILTER  -->
                <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>report/student_payment_report/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>BATCH</label>
                                            <select style='width:100%' name="batch" class="form-control select2">
                                              <option value="">SELECT BATCH</option>
                                                <?php 
                                                  $this->db->order_by('batch ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('batch',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['batch']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['batch']."' ".$text." >".$base_airport_document_record['batch']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>STATUS</label>
                                            <select style='width:100%' name="status" class="form-control select2">
                                              <option value="">SELECT STATUS</option>
                                                <?php 
                                                  $this->db->order_by('id ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('status',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['status']==$_SESSION['status']){

                                                      $text = "selected";

                                                    }

                                                    echo "<option value='".$base_airport_document_record['status']."' ".$text." >".$base_airport_document_record['status']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>START DATE</label>
                                            <input placeholder="Start Date" type="text" class="form-control tgl" value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>END DATE</label>
                                            <input placeholder="End Date" type="text" class="form-control tgl" class="form-control" value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
                                        </div>
                                    </div> -->
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
              <div class="table-responsive">

              <table class="table table-bordered table-striped" id="mytable" style="width:100%">

<thead>
<?php 
 $att_master = $this->mymodel->selectWithQuery("SELECT *
 FROM payment_status ORDER BY number ASC");
 ?>
<tr class="bg-success">
<th style="width:5%" rowspan="2">NUM</th>
<th style="min-width:100px;"  rowspan="2">FULL NAME</th>
<th rowspan="2">NICK NAME</th>
<th rowspan="2">ID NUMBER</th>
<th rowspan="2">BATCH</th>
<th rowspan="2">STATUS</th>
<?php
foreach($att_master as $k=>$v){ ?>
<th colspan="5"><?=$v['payment_status']?></th>
<?php } ?>

<th colspan="3">TOTAL</th>
</tr>
<tr class="bg-success">
<?php
foreach($att_master as $k=>$v){ ?>
<th style="min-width:50px;">INV</th>
<th style="min-width:50px;">PAID</th>
<th style="min-width:50px;">EXPIRED</th>
<th style="min-width:50px;">SISA</th>
<th style="min-width:50px;">DESC</th>
<?php } ?>

<th style="min-width:50px;">INV</th>
<th style="min-width:50px;">PAID</th>
<th style="min-width:50px;">SISA</th>
</tr>
</thead>


<tbody>
<?php 
 $batch = $_SESSION['batch'];
 $status = $_SESSION['status'];
 if($batch){
   $batch = " AND batch = '$batch' ";
 }else{
   $batch = " ";
 }

if($status){
  $status = " AND status = '$status' ";
}else{
  $status = " ";
}

 $aircraft = $this->mymodel->selectWithQuery("SELECT *
 FROM user WHERE instructor_status != '1' 
 ".$batch.
 $status."
 ORDER BY batch ASC");
  foreach($aircraft as $key=>$val){
    $att = json_decode($val['log_status'],true);
    // $batch = $this->mymodel->selectDataOne('batch',array('id'=>$val['batch']));
    // $val['batch'] = $batch['batch'];
    // print_r($att);
    ?>
    <td><?=$key+1?></td>
    <td class="text-left" style="min-width:250px;"><a href="<?=base_url()?>master/student_document/preview/<?=$val['id']?>"><?=$val['full_name']?></a></td>
    <td class="text-left"><?=$val['nick_name']?></td>
    <td><?=$val['id_number']?></td>
    <td><?=$val['batch']?></td>
    <td><?=$val['status']?></td>
    <?php
$a = 0;
$b = 0;
foreach($att_master as $k=>$v){
$debit = abs($att[$v['id']]['nominal_inv'] - $att[$v['id']]['nominal_paid']);
$text_color_debit = '';
if($att[$v['id']]['nominal_paid'] < $att[$v['id']]['nominal_inv']){
  $text_color_debit = 'text-red';
}

if($att[$v['id']]['due_date']){
$date1 = strtotime(DATE('Y-m-d'));
$date2 = strtotime($att[$v['id']]['due_date']);

// Declare two dates
$start_date = $date1;
$end_date = $date2;
  
// Get the difference and divide into 
// total no. seconds 60/60/24 to get 
// number of days
$day = ($end_date - $start_date)/60/60/24;
}else{
  $day = 2021;
}
$day = intval($day);
// echo $days;
$ket = '';
if($att[$v['id']]['due_date']=='' || $att[$v['id']]['nominal_paid'] == $att[$v['id']]['nominal_inv']){
  $text_color = '';
  // $ket = '-';
}else if($day=='1'){
  $text_color = 'text-red';
  $ket = 'past '.$day.' day';
}else if($day <= 14){
   $text_color = 'text-red';
  $ket = 'less than '.$day.' day';
}else if($day <= 30){
  $text_color = 'text-yellow';
  $ket = 'less than '.$day.' day';
}else{
  // echo '123';
}
$a += $att[$v['id']]['nominal_inv'];
$b += $att[$v['id']]['nominal_paid'];
?>
<td><?=$this->template->rupiah($att[$v['id']]['nominal_inv'])?></td>
<td><?=$this->template->rupiah($att[$v['id']]['nominal_paid'])?></td>
<td style="min-width:100px;" class="<?=$text_color?>"><?=($att[$v['id']]['due_date'])?></td>
<td class="<?=$text_color_debit?>"><?=$this->template->rupiah($debit)?></td>
<td style="min-width:100px;" class="text-left"><?=$ket?></td>

<?php } ?>
<td><?=$this->template->rupiah($a)?></td>
<td><?=$this->template->rupiah($b)?></td>
<td><?=$this->template->rupiah($a-$b)?></td>
  </tr>
<?php 
}


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


