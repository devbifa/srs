

                             

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
               APPROVED DAILY FTD REPORT
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
                                <form autocomplete="off" action="<?= base_url() ?>master/daily_ftd_report_approved/filter" method="post">
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">ALL BASE</option>
                                                <?php 
                                                  $this->db->order_by('base ASC');

                                                  $id = $this->session->userdata('id');
                                                  $user = $this->mymodel->selectDataone('user',array('id'=>$id));
                                                  $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
                                                  $base_id = $user['base'];
                                                  $user['base'] = $base['base'];
                                                 
                                                  $base = $base['base'];
                                                  if($_SESSION['role_id']=='23'){
                                                    $base = " AND a.origin_base = '$base' ";
                                                   
                                                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document',array('id'=>$base_id));
                                                  }else{
                                                    $base = " ";
                                                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document',array('base'=>'WSN'));
                                                  }

                                                 

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
                                            <label>BATCH</label>
                                            <select style='width:100%' name="batch" class="form-control select2">
                                              <option value="">ALL BATCH</option>
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


                        <div class="table-responsive">

<table class="table table-bordered" id="datatable" style="width:100%">

<thead>

<tr class="bg-success">
<th style="width:20px" rowspan="2" rowspan="2">NUM</th>
<th style="min-width:110px"  rowspan="2">DATE</th>
  <th rowspan="2">FTD MODEL</th>
  <th rowspan="2">INSTRUCTOR</th><th rowspan="2">STUDENT</th>
  <th rowspan="2">BATCH</th>
  <th rowspan="2">TPM</th>
  <th rowspan="2">COURSE</th><th rowspan="2">MISSION</th>
  <th rowspan="2">ETD<br>UTC</th><th rowspan="2">ETA<br>UTC</th>
  <th rowspan="2">EET</th>
  <th rowspan="2">REMARK</th>
  <th colspan="3">BLOCK TIME</th>
  <th rowspan="2">REMARK REPORT</th>
  <th rowspan="2">IRREG<br>CODE</th>
</tr>
<tr class="bg-success">
  <th>ATD</th>
  <th>ATA</th>
  <th>TOTAL</th>
</tr>

</thead>

<tbody>

<?php
$duty_instructor = '';
$total = array();
$total2 = array();
$array_model = array();

$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
if($origin_base){
  $origin_base = "  AND a.origin_base = '$origin_base' ";
}else{
  $origin_base = " ";
}


$origin_base = " ";


$batch = $_SESSION['batch'];
if($batch){
$batch = " AND a.batch = '$batch' ";
}else{
$batch = "";
}
$nomor = 0;
$data_date =  $this->template->date_range($start_date, $end_date);

foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;

?>

<?php

$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_ftd_schedule a
WHERE  a.visibility = '1' AND a.visibility_report = '1' 
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
  "
  .$batch
  .$origin_base.
  "
ORDER BY a.date ASC, a.etd_utc ASC
"); 
foreach($data_utc as $key=>$val){
  
  $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
 
  $temp = $val['ftd_model'];
  $val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];

  if(empty($dat)){
    $val['ftd_model'] = '<a class="text-red"><b>'.$temp.'</b></a>';
  }

  
    $dat = '';
    if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
    }
    $temp = $val['pic'];
    $val['pic'] = $dat['nick_name'];
  
    if(in_array($val['pic'],array('','-'))){
      $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
  
    $dat = '';
    if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));
    }
    $temp = $val['2nd'];
    $val['2nd'] = $dat['nick_name'];
  
    if(in_array($val['2nd'],array('','-'))){
      $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }

 
    
    $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val['batch']));
    $temp = $val['batch'];
    $val['batch'] = $dat['batch'];
    if(empty($val['batch'])){
      $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
    
    $this->db->select('code_name');
    $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val['tpm']));
    $temp = $val['tpm'];
    $val['tpm'] = $dat['code_name'];
    if(empty($val['tpm'])){
      $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
  
      $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['mission'],'type_of_training'=>'FTD'));
    $mission = $dat;
    $temp = $val['mission'];
    $val['mission'] = $dat['code_name'].' - '.$dat['name'];
  
    if(($val['mission']) == ' - '){
      $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
  
    $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));
  
    $temp = $val['course'];
    $val['course'] = $dat['code_name'];
  
    if(($val['course']) == ' - '){
      $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }


  $nomor++;

  if($val['remark_report']){
    $total_irregularities = $total_irregularities + 1;
  }

  if (strpos($val['block_time_atd'], ':') !== false) {
    $total_movement = $total_movement + 1;
  }

  if(!in_array($val['ftd_model'],$array_model)){
    array_push($array_model,$val['ftd_model']);
  }
  
  if (strpos($val['block_time_total'], ':') !== false) {
    array_push($total2,$val['block_time_total']);
  }
  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet_utc'], ':') !== false) {
    array_push($total,$val['eet_utc']);
  }
 
    $val['pic'] = $val['pic']; 
  ?>
<tr>
  <td><?=$nomor?>
  </td>
  
  <td><?=DATE('d M Y',strtotime($val['date']))?></td><td class="text-left"><?=$val['ftd_model']?></td>
  <td class="text-left"><?=$val['pic']?></td><td class="text-left"><?=$val['2nd']?></td>
  <td><?=$val['batch']?></td><td><?=$val['tpm']?></td>
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $val['file_report'];
    if($file){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/document/'.$file.'">'.$val['mission'].'</a>';
    }
    ?>
  <td class="text-left"><?=$val['mission']?></td>
  <td><?=$val['etd_utc']?></td><td><?=$val['eta']?></td>  
  <td><?=$val['eet_utc']?></td><td><?=$val['remark']?></td>
  
  <td><?=$val['block_time_atd']?></td>
  <td><?=$val['block_time_ata']?></td>
  <td><?=$val['block_time_total']?></td>
  <td class="text-left"><?=$val['remark_2']?></td>
  <td><?=$val['remark_report']?></td>
</tr>
<?php } ?>

<?php

$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_ftd_schedule a
WHERE  a.visibility = '1' AND a.visibility_report = '1' 
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND etd_utc >= '00:00' AND etd_utc <= '21:59'
  "
  .$batch
  .$origin_base.
  "
ORDER BY a.date ASC, a.etd_utc ASC
"); 
foreach($data_utc as $key=>$val){
  // print_r($val['pic']);
  $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
 
    $temp = $val['ftd_model'];
    $val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];
  
    if(empty($dat)){
      $val['ftd_model'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }

    
    $dat = '';
    if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
    }
    $temp = $val['pic'];
    $val['pic'] = $dat['nick_name'];
  
    if(in_array($val['pic'],array('','-'))){
      $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
  
    $dat = '';
    if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));
    }
    $temp = $val['2nd'];
    $val['2nd'] = $dat['nick_name'];
  
    if(in_array($val['2nd'],array('','-'))){
      $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }

   
    
    $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val['batch']));
    $temp = $val['batch'];
    $val['batch'] = $dat['batch'];
    if(empty($val['batch'])){
      $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
    
    $this->db->select('code_name');
    $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val['tpm']));
    $temp = $val['tpm'];
    $val['tpm'] = $dat['code_name'];
    if(empty($val['tpm'])){
      $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
  
      $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['mission'],'type_of_training'=>'FTD'));
    $mission = $dat;
    $temp = $val['mission'];
    $val['mission'] = $dat['code_name'].' - '.$dat['name'];
  
    if(($val['mission']) == ' - '){
      $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }
  
    $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));
  
    $temp = $val['course'];
    $val['course'] = $dat['code_name'];
  
    if(($val['course']) == ' - '){
      $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
    }


  $nomor++;

  if($val['remark_report']){
    $total_irregularities = $total_irregularities + 1;
  }

  if (strpos($val['block_time_atd'], ':') !== false) {
    $total_movement = $total_movement + 1;
  }

  if(!in_array($val['ftd_model'],$array_model)){
    array_push($array_model,$val['ftd_model']);
  }
  
  if (strpos($val['block_time_total'], ':') !== false) {
    array_push($total2,$val['block_time_total']);
  }
  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet_utc'], ':') !== false) {
    array_push($total,$val['eet_utc']);
  }
 
    $val['pic'] = $val['pic']; 
  ?>
<tr>
  <td><?=$nomor?>
  </td>
 
  <td><?=DATE('d M Y',strtotime($val['date']))?></td><td class="text-left"><?=$val['ftd_model']?></td>
  <td class="text-left"><?=$val['pic']?></td><td class="text-left"><?=$val['2nd']?></td>
  <td><?=$val['batch']?></td><td><?=$val['tpm']?></td>
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $val['file_report'];
    if($file){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL REPORT" target="_blank" href="'.base_url().'webfile/document/'.$file.'">'.$val['mission'].'</a>';
    }
    ?>
  <td class="text-left"><?=$val['mission']?></td>
  <td><?=$val['etd_utc']?></td><td><?=$val['eta']?></td>  
  <td><?=$val['eet_utc']?></td><td><?=$val['remark']?></td>
  
  <td><?=$val['block_time_atd']?></td>
  <td><?=$val['block_time_ata']?></td>
  <td><?=$val['block_time_total']?></td>
  <td class="text-left"><?=$val['remark_2']?></td>
  <td><?=$val['remark_report']?></td>
</tr>
<?php } ?>

<?php }
$total =  $this->template->sum_time($total);
$total2 =  $this->template->sum_time($total2);

// print_r($array_model);
$total_plan = $total;
$total_block_time = $total2;
$total_ftd = count($array_model);
$total_flight = $nomor;

?>
<!-- <tr>
    <th colspan="10" class="text-right">TOTAL PLAN</th>
    <th><?=$total?></th>
    <th colspan="3" class="text-right">TOTAL BLOCK TIME</th>
    <th><?=$total2?></th>
    <th></th> -->
  </tr>
</tbody>

</table>

              </div>

              <br><br>
              <div class="table-responsive">
<table>
  <tr>
    <th class="text-left no-border" style="min-width:250px;">
    
    <p>TOTAL FTD SCHEDULE</p> 

    <p>TOTAL FTD ACTIVITY  </p>
 
  
    <p>TOTAL IRREGULARITIES</p> 
    
    </th>
    <th class="no-border" style="min-width:15px">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px;">
    <p><?=$total_flight?></p>
    <p><?=intval($total_movement)?></p>
    <p><?=intval($total_irregularities)?></p>
    </th>
    
    <th class="text-left no-border" style="min-width:250px;;">

    <p>TOTAL PLAN</p> 

    <p>TOTAL BLOCK TIME</p>
    <p>ACTUAL vs PLAN</p>
  
    </th>
    <th class="no-border" style="min-width:15px;">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px;;">
    <p><?=$total_plan?></p>
    <p><?=$total_block_time?></p>
    <?php
      $total_plan = (explode(":",$total_plan));
      $total_block_time = (explode(":",$total_block_time));

      $jam_plan = $total_plan[0] * 60;
      $jam_plan = $jam_plan + $total_plan[1];

      $jam_block_time = $total_block_time[0] * 60;
      $jam_block_time = $jam_block_time + $total_block_time[1];

      $persentase = number_format(($jam_block_time/$jam_plan)*100,1).' %';

    ?>
    <p><?=$persentase?></p>
    </th>
 

  </tr>
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

$('#submit-now').click(function(){
        $('#button-submit').addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i> Processing...").attr('disabled',true);
        $('#submit-now').addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i> Processing...").attr('disabled',true);
      });


  </script>