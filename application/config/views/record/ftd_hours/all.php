



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
              FTD HOURS
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
                                <form autocomplete="off" action="<?= base_url() ?>record/ftd_hours/filter" method="post">
                                    <!-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">SELECT ORIGIN BASE</option>
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
                                    </div> -->
                                    <div class="col-md-3">
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

              <table class="table table-bordered table-striped" id="mytable" style="width:100%">

<thead>
<?php
 $aircraft = $this->mymodel->selectWithQuery("SELECT *
 FROM synthetic_training_devices_document
 GROUP BY serial_number
 ORDER BY model
 ");
?>
<tr class="bg-success">

<tr class="bg-success">

<th style="width:5%" rowspan="2">NUM</th>
<th style="min-width:100px" rowspan="2">DATE</th>
<?php foreach($aircraft as $key=>$val){ ?>
<th style="min-width:100px" colspan="3"><?=$val['model']?> <?=$val['serial_number']?></th>
<?php } ?>

<th style="min-width:100px" colspan="3">TOTAL</th>
 </tr>
</tr>
<tr class="bg-success">
<?php foreach($aircraft as $key=>$val){ ?>
<th>SE</th>
<th>ME</th>
<th>TOTAL</th>
<?php } ?>
<th>SE</th>
<th>ME</th>
<th>TOTAL</th>
</tr>

</thead>


<tbody>
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

     $type = $valp['type'];
      
     $data =  $this->template->date_range( $start_date, $end_date);
     
    $se_bottom = array();
    $me_bottom = array();
    $se_me_bottom = array();
foreach($data as $key=>$val){
  $code = $val['code'];
  $total = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count FROM daily_flight_schedule
  WHERE remark_dmr = '$code'
  ");

  $total = $total[0]['count'];

  $grand_total = $grand_total + $total;

  ?>
  <tr>
    <td><?=$key+1?></td>
    <td><?=$val?></td>
    <?php 
    
    $se_right = array();
    $me_right = array();
    $time_right = array();
    
    $bt = array();
    $ft = array();
    $se_r = array();
    $me_r = array();
    $se_me_r = array();
    foreach($aircraft as $key2=>$val2){
      $dmr_date = $val;
      $ftd_id = $val2['serial_number'];
      $ftd = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('type_enginee'=>'SE','serial_number'=>$ftd_id));
      $se_ftd_id = $ftd['id'];
      $ftd = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('type_enginee'=>'ME','serial_number'=>$ftd_id));
      $me_ftd_id = $ftd['id'];
      
      $se_schedule = $this->mymodel->selectWithQuery("SELECT block_time_total
      FROM daily_ftd_schedule
      WHERE date = '$dmr_date' AND ftd_model = '$se_ftd_id'
      ");

      $me_schedule = $this->mymodel->selectWithQuery("SELECT block_time_total
      FROM daily_ftd_schedule
      WHERE date = '$dmr_date' AND ftd_model = '$me_ftd_id'
      ");
      

      $se = array();
      $me = array();
      $se_me = array();
      
      foreach($se_schedule as $key3=>$val3){
        if (strpos($val3['block_time_total'], ':') !== false) {
          array_push($se,$val3['block_time_total']);
        }
      }
      foreach($me_schedule as $key3=>$val3){
        if (strpos($val3['block_time_total'], ':') !== false) {
          array_push($me,$val3['block_time_total']);
        }
      }

      $se = $this->template->sum_time_3($se);
      $me = $this->template->sum_time_3($me);

      $se_me[0] = $se;
      $se_me[1] = $me;
      $se_me = $this->template->sum_time_3($se_me);


      array_push($se_r,$se);
      array_push($me_r,$me);
      array_push($se_me_r,$se_me);
     

      // header('Content-Type: application/json');
      $se_bottom[$val2['id']][$dmr_date] = $se;
      $me_bottom[$val2['id']][$dmr_date] = $me;
      $se_me_bottom[$val2['id']][$dmr_date] = $se_me;

      ?>
      <td><?=$se?>
      </td>
      <td><?=$me?>
      </td>
      <td><?=$se_me?>
      </td>
    <?php }
    
       $se_r = $this->template->sum_time_3($se_r);
       $me_r = $this->template->sum_time_3($me_r); 
       $se_me_r = $this->template->sum_time_3($se_me_r); 

       $dt['bt'][$dmr_date] = $se_r;
       $dt['ft'][$dmr_date] = $me_r;
       $dt['tt'][$dmr_date] = $se_me_r;

    ?>
    <th class=""><?=$se_r?></th>
    <th class=""><?=$me_r?></th>
    <th class=""><?=$se_me_r?></th>
  </tr>
<?php } 


?>

<tr>
    <th colspan="2" class="text-left">TOTAL</th>
    <?php foreach($aircraft as $key2=>$val2){

      $se_bottom_fix = ($se_bottom[$val2['id']]);
      $se_bottom_fix = $this->template->sum_time_3($se_bottom_fix); 
      $me_bottom_fix = ($me_bottom[$val2['id']]);
      $me_bottom_fix = $this->template->sum_time_3($me_bottom_fix); 
      $se_me_bottom_fix = ($se_me_bottom[$val2['id']]);
      $se_me_bottom_fix = $this->template->sum_time_3($se_me_bottom_fix); 
      ?>
      <th><?=$se_bottom_fix?>
      </th>
      <th>
        <?=$me_bottom_fix?>
      </th>
      <th>
        <?=$se_me_bottom_fix?>
      </th>
    <?php }
    ?>
    
    <th class="">
      <?=$this->template->sum_time_3($dt['bt'])?>
      </th>
    <th class="">
      <?=$this->template->sum_time_3($dt['ft'])?>
      </th>
    <th class="">
      <?=$this->template->sum_time_3($dt['tt'])?>
      </th>
  </tr>
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


