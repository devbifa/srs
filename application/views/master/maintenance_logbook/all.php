<?php 

$my_role = $this->mymodel->selectDataOne('role',array('id'=>$_SESSION['role']));
$my_menu_sub = json_decode($my_role['menu_sub'],true);
$menu_id = '2055';

$total = array();
$total2 = array();
$total3 = array();
$total_ldg = 0;
	
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$origin_base = $_SESSION['origin_base'];
$keyword = $_SESSION['keyword'];
$keyword_arr = $_SESSION['keyword_arr'];



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
$air = $_SESSION['aircraft'];
if($origin_base){
  $origin_base = "  AND a.origin_base = '$origin_base' ";
}else{
  $origin_base = " ";
}

if($air){
  $air = "  AND a.aircraft_reg = '$air' ";
}else{
  $air = " ";
}

$id = $this->session->userdata('id');
$user = $this->mymodel->selectDataone('user',array('id'=>$id));
$base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
$user['base'] = $base['base'];

$base = $base['base'];
if($_SESSION['role_id']=='23'){
  $base = " AND a.origin_base = '$base' ";
}else{
  $base = " ";
}

$batch = $_SESSION['batch'];
if($batch){
  $batch = " AND a.batch = '$batch' ";
}else{
  $batch = "";
}
?>


<div class="modal modal-success fade" id="modal-add-fuel-store">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">CREATE MAINTENANCE LOGBOOK</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/store" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>AIRCRAFT REG</label>
                  <select autocomplete="off" type="text" class="form-control" name="aircraft_reg">
                    <?php
                      $arr = array();
                      $this->db->order_by('serial_number ASC');
                      $arr = $this->mymodel->selectWhere('aircraft_document',null);
                      foreach($arr as $k3=>$v3){
                        ?>
                        <option <?=$text?> value="<?=$v3['serial_number']?>"><?=$v3['serial_number']?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                <label>DATE</label>
                <input autocomplete="off" required type="text" class="form-control tgl" name="date" value="<?=DATE('Y-m-d')?>">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Create Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


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
               AIRCRAFT STATUS
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
                                <form autocomplete="off" action="<?= base_url() ?>master/maintenance_logbook/filter" method="post">
                                <!-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">ALL BASE</option>
                                                <?php 
                                                  // $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);

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
                                                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
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
                                    </div> -->
                                   
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ACFT</label>
                                            <select style='width:100%' name="aircraft" class="form-control select2">
                                              <option value="">ALL AIRCRAFT</option>
                                                <?php 
                                                  $this->db->order_by('serial_number ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('aircraft_document',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['serial_number']==$_SESSION['aircraft']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['serial_number']."' ".$text." >".$base_airport_document_record['serial_number']."</option>";

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
                                    <?php if($my_menu_sub[$menu_id]['add']){ ?>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <a href="#!" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal-add-fuel-store" ><i class="mdi mdi-plus"></i> CREATE</a>
                                        </div>
                                    </div>  
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

                <div class="show_error"></div>



                <div class="table-responsive">

              <table class="table table-bordered table-striped" id="datatable"  style="width:100%">

              <thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NO</th>
<th style="width:150px" rowspan="2">ACTION</th>
<th style="width:110px" rowspan="2">DATE</th>
<th rowspan="2" style="width:110px" rowspan="2">AIRCRAFT<br>REG</th>
<th rowspan="2" style="width:150px" rowspan="2">LOG<br>SHEET</th>
<th style="width:110px" rowspan="2">HOBBS<br>START</th>
<th style="width:110px" rowspan="2">HOBBS<br>END</th>
<th style="width:110px" rowspan="2">TTL DMR</th>
<th style="width:110px" rowspan="2">HOBBS</th>
<th style="width:110px" rowspan="2">TTL A/C HOURS TTIS</th>
<th rowspan="2">AIRCRAFT STATUS</th>
<th rowspan="2">BASE</th>
<th rowspan="2">REMARK</th>
</tr>
</thead>


<tbody>

<?php 

$irreg = $_GET['irreg'];
$irreg_type = $_GET['irreg_type'];
if($irreg){
  $qry_irreg = " AND remark_report = '$irreg' ";
}
if($irreg_type){
  $dat = $this->mymodel->selectWithQuery("SELECT * FROM delay_and_cancel_code WHERE type = '$irreg_type'");
  $t = "'AANG',";
  foreach($dat as $k=>$v){
    $t .= "'".$v['code']."',";
  }
   $t = substr($t,0,-1);
  $qry_irreg = " AND remark_report IN ($t) ";
}

$data_date =  $this->template->date_range( $start_date, $end_date);
$duty_instructor = '';
$total = array();
$total2 = array();
$total3 = array();
$array_aircraft = array();
$array_duty_instructor = array();

$nomor = 0;
foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>

<?php

$data = $this->mymodel->selectWithQuery("SELECT *
FROM maintenance_logbook a
WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' $air
"
.$qry_irreg.
"
GROUP BY a.id
ORDER BY
a.date ASC");

foreach($data as $key=>$val){
    $nomor++;
    // $val['remark'] = "GENERATED";
    ?>
  <tr>
    <td><?=$nomor?></td>
    <td>
    <?php if($my_menu_sub[$menu_id]['edit']){ ?>
    <a href="<?=base_url()?>master/maintenance_logbook/edit?date=<?=$val['date']?>&aircraft_reg=<?=$val['aircraft_reg']?>" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>
    <?php } ?>
    <a target="_blank" href="<?=base_url()?>master/maintenance_logbook/print_v1?date=<?=$val['date']?>&aircraft_reg=<?=$val['aircraft_reg']?>" class="btn btn-info btn-xs btn-rounded"><i class="mdi mdi-cloud-print-outline"></i></a>
    <a target="_blank" href="<?=base_url()?>master/maintenance_logbook/print_v2?date=<?=$val['date']?>&aircraft_reg=<?=$val['aircraft_reg']?>" class="btn btn-success btn-xs btn-rounded"><i class="mdi mdi-cloud-print"></i></a>
    <?php if($my_menu_sub[$menu_id]['delete']){ ?>
    <a href="" class="btn btn-danger btn-xs btn-rounded" href="#!" data-toggle="modal" data-target="#modal-delete-<?=$k?>"  data-placement="top" title="Delete Aircraft Status"><i class="mdi mdi-delete"></i></a>
         
         <div class="modal modal-danger fade" id="modal-delete-<?=$k?>">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">DELETE DATA <?=$val['aircraft_reg']?> <?=DATE('d M Y',strtotime($val['date']))?></h4>
               </div>
               <div class="modal-body" style="color:#fff!important;">
                <form action="<?=base_url()?>master/maintenance_logbook/delete/<?=$val['id']?>">
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
         <?php } ?>
  </td>
    <td><?=DATE('d M Y',strtotime($val['date']))?></td>
    <td><?=$val['aircraft_reg']?></td>
    <td><?=$val['log_sheet']?></td>
    <td><?=$val['hobbs_start']?></td>
    <td><?=$val['hobbs_end']?></td>
    <td><?=$val['aircraft_duration']*10?></td>
    <td><?=number_format($val['hobbs'],1)?></td>
    <td><?=number_format($val['total_ac_hours_ttis'],1)?></td>
    <td><?=$val['aircraft_status']?></td>
    <td><?=$val['last_base']?></td>
    <td><?=$val['remark']?></td>
   
  </tr>
<?php } ?>




<?php 
}

$total_plan = $this->template->sum_time($total);
$total2 = $this->template->sum_time($total2);
$total3 = $this->template->sum_time($total3);

$total_aircraft = count($array_aircraft);
$total_flight = $nomor;
$total_block_time = $total2;
$total_flight_time = $total3;
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
  <th><?=$total_plan?></th>
  <th colspan="4" class="text-right">TOTAL BLOCK TIME</th>
  <th><?=$total2?></th>
  <th colspan="2" class="text-right">TOTAL FLIGHT TIME</th>
  <th><?=$total3?></th>
  <th><?=$total_ldg?></th>
  <th colspan="3"></th>
</tr> -->
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

              <form id="upload-delete" action="<?= base_url('master/daily_movement_report/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/daily_movement_report') ?>" method="POST"  enctype="multipart/form-data">



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