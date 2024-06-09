<?php
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


$batch = $_SESSION['batch'];
if($batch){
$batch = " AND a.batch = '$batch' ";
}else{
$batch = "";
}

?>



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
               FLIGHT SCHEDULE
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
                                <form autocomplete="off" action="<?= base_url() ?>dashboard/flight_schedule/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">ALL BASE</option>
                                                <?php 

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
            <label>BATCH</label>
            <select style='width:100%' name="batch" class="form-control select2">
              <option value="">ALL BATCH</option>
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <a class="btn btn-success btn-block" href="<?=base_url()?>features/print_flight_schedule" target="_blank"><i class="mdi mdi-printer"></i> PRINT</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

              <div class="table-responsive">

              <table class="table table-bordered table-striped"  id="datatable" style="width:100%">

<thead>

<tr class="bg-success">

  <th style="width:20px">NO</th><th style="min-width:110px">DATE OF<br>FLIGHT</th><th>ORIGIN<br>BASE</th><th>AIRCRAFT<br>REG</th><th>PIC</th><th>2ND</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>DEP</th><th>ARR</th><th>ROUTE</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>

</tr>

</thead>


<tbody>
<?php 

$data_date =  $this->template->date_range( $start_date, $end_date);

$duty_instructor = '';
$total = array();
$array_aircraft = array();

$array_duty_instructor = array();

$nomor = 0;
foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>


<?php
  $data_utc = $this->mymodel->selectWithQuery("SELECT *
  FROM daily_flight_schedule a
  
  WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''   AND etd_utc >= '22:00' AND etd_utc <= '24:00'
  AND a.type = ''
  "
  .$batch
  .$origin_base.
  "
  GROUP BY a.id
  ORDER BY
  a.date_of_flight ASC, a.etd_utc ASC");


foreach($data_utc as $key=>$val){

  $nomor++;

  
  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
  
  $val['pic'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

  $val['2nd'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));

  $val['duty_instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

  $val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];

  if(!in_array($val['aircraft_reg'],$array_aircraft)){
    array_push($array_aircraft,$val['aircraft_reg']);
  }

  if(!in_array($val['duty_instructor'],$array_duty_instructor)){
    array_push($array_duty_instructor,$val['duty_instructor']);
  }

  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet'], ':') !== false) {
    array_push($total,$val['eet']);
  }
 
    $val['pic'] = $val['pic'];

  ?>
  <tr>
    <td><?=$nomor?></td>
    <td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
    <td><?=$val['origin_base']?></td>
    <td><?=$val['aircraft_reg']?></td>
    <td class="text-left"><?=$val['pic']?></td>
    <td class="text-left"><?=$val['2nd']?></td>
    
    <td><?=$val['batch']?></td>
    <td><?=$val['course']?></td>
    <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
    <td class="text-left"><?=$val['mission']?></td>
    <td><?=$val['dep']?></td>
    <td><?=$val['arr']?></td>
    <td class="text-left"><?=$val['rute']?></td>
    <td><?=$val['etd_utc']?></td>
    <td><?=$val['eta_utc']?></td>
    <td><?=$val['eet']?></td>
    <td class="text-left"><?=$val['remark']?></td>
  </tr>
<?php } ?>


<?php
  $data_utc = $this->mymodel->selectWithQuery("SELECT *
   FROM daily_flight_schedule a
  
  WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''   AND etd_utc >= '00:00' AND etd_utc <= '21:59'
  AND a.type = ''
  "
  .$batch
  .$origin_base.
  "
  GROUP BY a.id
  ORDER BY
  a.date_of_flight ASC, a.etd_utc ASC");

  

foreach($data_utc as $key=>$val){
  
  $nomor++;

  
  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
  
  $val['pic'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

  $val['2nd'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));

  $val['duty_instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

  $val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];
  
  if(!in_array($val['aircraft_reg'],$array_aircraft)){
    array_push($array_aircraft,$val['aircraft_reg']);
  }

  if(!in_array($val['duty_instructor'],$array_duty_instructor)){
    array_push($array_duty_instructor,$val['duty_instructor']);
  }

  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet'], ':') !== false) {
    array_push($total,$val['eet']);
  }
 
    $val['pic'] = $val['pic'];

  ?>
  <tr>
    <td><?=$nomor?></td>
    <td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
    <td><?=$val['origin_base']?></td>
    <td><?=$val['aircraft_reg']?></td>
    <td class="text-left"><?=$val['pic']?></td>
    <td class="text-left"><?=$val['2nd']?></td>
    
    <td><?=$val['batch']?></td>
    <td><?=$val['course']?></td>
    <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
    <td class="text-left"><?=$val['mission']?></td>
    <td><?=$val['dep']?></td>
    <td><?=$val['arr']?></td>
    <td class="text-left"><?=$val['rute']?></td>
    <td><?=$val['etd_utc']?></td>
    <td><?=$val['eta_utc']?></td>
    <td><?=$val['eet']?></td>
    <td class="text-left"><?=$val['remark']?></td>
  </tr>
<?php } ?>

<?php

}



  $total = $this->template->sum_time($total);
  $total_plan = $total;
  $total_aircraft = count($array_aircraft);
  $total_flight = $nomor;

?>

<?php
    $text = "";
    foreach($array_duty_instructor as $key=>$val){
      if($val){
        $text .= ''.$val.', ';
      }
    }
    $text = substr($text,0,-2);
    
    ?>


<!-- <tr>
    <th colspan="12" class="text-right">TOTAL PLAN</th>
    <th><?=$total?></th>
    <th colspan="3"></th>
  </tr> -->
</tbody>

</table>
              </div>

              
<br><br>
<div class="table-responsive">
<table>


<tr>
    <th class="text-left no-border">
    <p>DUTY INSTRUCTOR</p>

    </th>
    <th class="no-border">
    <p>:</p>
    </th>
    <th class="text-left no-border" colspan="3">
    <p><?=$text?></p>
    </th>
   

  </tr>

  <tr>
    <th class="text-left no-border" style="min-width:250px;">
    
    <p>TOTAL FLIGHT SCHEDULE</p> 

    <p>TOTAL AIRCRAFT IN USE </p>
  
    <p>TOTAL PLAN</p> 
    
    </th>
    <th class="no-border" style="min-width:15px;">
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:350px;">
    <p><?=$total_flight?></p>
    <p><?=$total_aircraft?></p>
    <p><?=$total_plan?></p>
    </th>
    <td class="no-border" style="width:25%;padding-top:21px;">

</td>
    <td class="no-border" style="width:25%">
 
</td>
  </tr>
</table>

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


