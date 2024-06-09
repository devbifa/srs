



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
               FTD SCHEDULE
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
                                <form autocomplete="off" action="<?= base_url() ?>dashboard/ftd_schedule/filter" method="post">
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">ALL BASE</option>
                                                <?php 

                                                  $base_airport_document = $this->mymodel->selectWhere('base_airport_document',array('base'=>'WSN'));

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
                                            <a class="btn btn-success btn-block" href="<?=base_url()?>features/print_ftd_schedule" target="_blank"><i class="mdi mdi-printer"></i> PRINT</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

              <div class="table-responsive">

              <table class="table table-bordered"  id="datatable" style="width:100%">

<thead>

<tr class="bg-success">

  <th style="width:20px">NUM</th><th style="min-width:110px">DATE</th><th style="width:120px;">FTD MODEL</th><th>INSTRUCTOR</th><th>STUDENT</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>ETD <br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>
</tr>

</thead>

<tbody>
<?php 

$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];

$nomor = 0;
$data_date =  $this->template->date_range($start_date, $end_date);

	
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


$origin_base = " ";


$batch = $_SESSION['batch'];
if($batch){
$batch = " AND a.batch = '$batch' ";
}else{
$batch = "";
}


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


			$origin_base = " ";
			

$batch = $_SESSION['batch'];
if($batch){
  $batch = " AND a.batch = '$batch' ";
}else{
  $batch = "";
}
?>

<?php
$duty_instructor = '';
$total = array();
$array_model = array();
foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>
<?php
					$data_utc = $this->mymodel->selectWithQuery("SELECT *
          FROM daily_ftd_schedule a
        
          	WHERE  a.visibility = '1' AND a.visibility_report = '0'
          AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
            "
            .$batch
            .$origin_base.
            "
          ORDER BY a.date ASC, a.etd_utc ASC
          ");
// print_r($data_date);

foreach($data_utc as $key=>$val){

  $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
  $val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];

  
  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));

  $val['pic'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));

  $val['2nd'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));

  $val['duty_instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

  $val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];

  $nomor++;

  if(!in_array($val['ftd_model'],$array_model)){
    array_push($array_model,$val['ftd_model']);
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
  <td class="text-left"><?=$val['pic']?></td><td class="text-left"><?=$val['2nd']?></td><td><?=$val['batch']?></td>
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
  <td class="text-left"><?=$val['mission']?></td></td><td><?=$val['etd_utc']?></td><td><?=$val['eta']?></td><td><?=$val['eet_utc']?><td class="text-left"><?=$val['remark']?></td>
</tr>
<?php } ?>


<?php
			$data_utc = $this->mymodel->selectWithQuery("SELECT *
			FROM daily_ftd_schedule a
				WHERE  a.visibility = '1' AND a.visibility_report = '0'
			AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date'  AND etd_utc >= '00:00' AND etd_utc <= '21:59'
				"
				.$batch
				.$origin_base.
				"
			ORDER BY a.date ASC, a.etd_utc ASC
      ");
      
// print_r($data_date);
// $duty_instructor = '';
// $total = array();
// $array_model = array();
foreach($data_utc as $key=>$val){

  $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('code'=>$val['ftd_model']));
  $val['ftd_model'] = $dat['model'].' '.$dat['serial_number'].' '.$dat['type_enginee'];

  
  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));

  $val['pic'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));

  $val['2nd'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));

  $val['duty_instructor'] = $dat['nick_name'];

  $dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

  $val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

  $dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

  $val['course'] = $dat['course_code'];

  $nomor++;

  if(!in_array($val['ftd_model'],$array_model)){
    array_push($array_model,$val['ftd_model']);
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
  <td class="text-left"><?=$val['pic']?></td><td class="text-left"><?=$val['2nd']?></td><td><?=$val['batch']?></td>
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
  <td class="text-left"><?=$val['mission']?></td></td><td><?=$val['etd_utc']?></td><td><?=$val['eta']?></td><td><?=$val['eet_utc']?><td class="text-left"><?=$val['remark']?></td>
</tr>
<?php } ?>

<?php } ?>
<?php


  $total =  $this->template->sum_time($total);
  $total_plan = $nomor;
  $total_ftd = count($array_model);
  $total_flight = $total;

?>
<!-- <tr>
    <th colspan="10" class="text-right">TOTAL PLAN</th>
    <th><?=$total?></th>
    <th colspan="1"></th>
  </tr> -->
</tbody>

</table>

              </div>

              <br><br>
              <div class="table-responsive">
<table>
  <tr>
    <th class="text-left no-border" style="min-width:250px">
    
    <p>TOTAL FTD SCHEDULE</p> 

    <p>TOTAL FTD IN USE </p>
  
    <p>TOTAL PLAN</p> 
    
    </th>
    <th class="no-border" style="min-width:15px;">
  
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px">
 
    <p><?=$total_plan?></p>
    <p><?=$total_ftd?></p>
    <p><?=$total_flight?></p>
    </th>
  </tr>
</table>


</div>  </div>

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

              <form id="upload-delete" action="<?= base_url('master/daily_ftd_schedule/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/Daily_ftd_schedule') ?>" method="POST"  enctype="multipart/form-data">



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


