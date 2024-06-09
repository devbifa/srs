



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
               GROUND SCHEDULE
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
                                <form autocomplete="off" action="<?= base_url() ?>dashboard/ground_schedule/filter" method="post">
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
                                    <div class="col-md-2">
     <div class="form-group">
         <label>&nbsp</label><br>
         <a class="btn btn-success btn-block" href="<?=base_url()?>features/print_ground_schedule" target="_blank"><i class="mdi mdi-printer"></i> PRINT</a>
     </div> 
    
    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

              <div class="table-responsive">

              <table class="table table-bordered " style="width:100%;" id="datatable">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NUM</th><th rowspan="2" style="min-width:5px;">DATE</th>
<th rowspan="2" >CLASS<br>ROOM</th>
<th rowspan="2" >INSTRUCTOR</th>
<th rowspan="2" >TYPE</th>
<th rowspan="2" >BATCH</th>
<th rowspan="2" >TPM</th>
<th rowspan="2" >COURSE</th><th rowspan="2" >SUBJECT</th><th colspan="3">TIME (UTC)</th><th rowspan="2" >PARTICIPANT</th> <th rowspan="2" >REMARK</th>
</tr>

<tr class="bg-success">
	<th>START</th>
	<th>STOP</th>
	<th>DUR</th>
 </tr>

</thead>

<tbody>

<?php 


$start_date = $_SESSION['start_date'];
			$end_date = $_SESSION['end_date'];
			$origin_base = $_SESSION['origin_base'];
			$classroom = $_SESSION['classroom'];
			$batch = $_SESSION['batch'];

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
    
      if($batch){
        $batch = "  AND a.batch = '$batch' ";
        }else{
        $batch = " ";
        }
        
        $text = "";
        $base = $_SESSION['origin_base'];
  
  
    if($base){
      $base = " AND b.station  = '$base' ";
    }else{
      $base = " ";
    }
   
			


$total = array();
$array_class = array();
$array_subject = array();

$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];

$nomor = 0;
$data_date =  $this->template->date_range($start_date, $end_date);

foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>

<?php

			$data = $this->mymodel->selectWithQuery("SELECT a.*
			FROM
			daily_ground_schedule a
      LEFT JOIN classroom b
      ON a.classroom = b.code
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1'  AND start_lt >= '22:00' AND start_lt <= '24:00'
			 "
			  .$base
			  .$batch.
			 "
			ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){

 
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
  if(empty($val['batch'])){
    $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
  }

$dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
$temp = $val['classroom'];
$val['classroom'] = $dat['classroom'];
if(empty($val['classroom'])){
  $val['classroom'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));

$temp = $val['instructor'];
$val['instructor'] = $dat['nick_name'];

if(empty($val['instructor'])){
  $val['instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}
$dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));

$temp = $val['subject'];
$val['subject'] = $dat['code_name'].' - '.$dat['name'];

if(($val['subject']) == ' - '){
$val['subject'] = '<a class="text-red"><b>'.$temp.'</b></a>';
} 

$dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));

$temp = $val['course'];
$val['course'] = $dat['code_name'];

if(($val['course']) == ' - '){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}


  $nomor++;
	
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  if(!in_array($val['subject'],$array_subject)){
    array_push($array_subject,$val['subject']);
  }
  
  if (strpos($val['duration'], ':') !== false) {
    array_push($total,$val['duration']);
  }

  $participant = 0;
  $attend = 0;
  $student_list = json_decode($val['student'],true);
  // print_r($student_list);
  $student_other = json_decode($val['student_other'],true);
  // print_r($student_other);
  
  $student_attend = json_decode($val['student_attend'],true);
  
  $student_other_attend = json_decode($val['student_other_attend'],true);

  foreach($student_list as $key2=>$val2){
  
    if($val2['val']){
      $participant++;
    }
  }
  foreach($student_other as $key2=>$val2){

    if($val2['check']=='on'){
      $participant++;
    }
  }

  foreach($student_attend as $key2=>$val2){

    if($val2['val']){
      $attend++;
    }
  }
  foreach($student_other_attend as $key2=>$val2){

    if($val2['check']=='on'){
      $attend++;
    }
  }
  
  ?>
<tr>
  <td><?=$nomor?>
  </td>
  <td><?=DATE('d M Y',strtotime($val['date']))?></td></td>
  <td><?=$val['classroom']?></td> 
  <td class="text-left"><?=$val['instructor']?></td><td><?=$val['type']?></td> 
  <td><?=$val['batch']?></td><td><?=$val['tpm']?></td>
  <td class="text-left"><?=$val['course']?></td> 
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['subject'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['subject'].'</a>';
    }
    ?>  
  <td class="text-left"><?=$val['subject']?></td> 
<td><?=$val['start_lt']?></td> <td><?=$val['stop_lt']?></td> <td><b><?=$val['duration']?></b></td> 

<td><?=$participant?></td> 
<td class="text-left"><?=$val['remark']?></td> 
</tr>
<?php } ?>


<?php

			$data = $this->mymodel->selectWithQuery("SELECT a.*
			FROM
			daily_ground_schedule a
      LEFT JOIN classroom b
      ON a.classroom = b.code
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1'  AND start_lt >= '00:00' AND start_lt <= '21:59'
			 "
			  .$base
			  .$batch.
			 "
			ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){
 
  
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
  if(empty($val['batch'])){
    $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
  }

$dat = $this->mymodel->selectDataOne('classroom',array('code'=>$val['classroom']));
$temp = $val['classroom'];
$val['classroom'] = $dat['classroom'];
if(empty($val['classroom'])){
  $val['classroom'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['instructor']));

$temp = $val['instructor'];
$val['instructor'] = $dat['nick_name'];

if(empty($val['instructor'])){
  $val['instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}

$dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));

$temp = $val['2nd'];
$val['2nd'] = $dat['nick_name'];

if(empty($val['2nd'])){
  $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}
$dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['subject'],'type_of_training'=>'GROUND'));

$temp = $val['subject'];
$val['subject'] = $dat['code_name'].' - '.$dat['name'];

if(($val['subject']) == ' - '){
$val['subject'] = '<a class="text-red"><b>'.$temp.'</b></a>';
} 

$dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));

$temp = $val['course'];
$val['course'] = $dat['code_name'];

if(($val['course']) == ' - '){
  $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
}


  $nomor++;
	
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  if(!in_array($val['subject'],$array_subject)){
    array_push($array_subject,$val['subject']);
  }
  
  if (strpos($val['duration'], ':') !== false) {
    array_push($total,$val['duration']);
  }

  $participant = 0;
  $attend = 0;
  $student_list = json_decode($val['student'],true);
  // print_r($student_list);
  $student_other = json_decode($val['student_other'],true);
  // print_r($student_other);
  
  $student_attend = json_decode($val['student_attend'],true);
  
  $student_other_attend = json_decode($val['student_other_attend'],true);

  foreach($student_list as $key2=>$val2){
  
    if($val2['val']){
      $participant++;
    }
  }
  foreach($student_other as $key2=>$val2){

    if($val2['check']=='on'){
      $participant++;
    }
  }

  foreach($student_attend as $key2=>$val2){

    if($val2['val']){
      $attend++;
    }
  }
  foreach($student_other_attend as $key2=>$val2){

    if($val2['check']=='on'){
      $attend++;
    }
  }
  
  ?>
<tr>
  <td><?=$nomor?>
  </td>
  <td><?=DATE('d M Y',strtotime($val['date']))?></td></td>
  <td><?=$val['classroom']?></td> 
  <td class="text-left"><?=$val['instructor']?></td><td><?=$val['type']?></td> 
  <td><?=$val['batch']?></td><td><?=$val['tpm']?></td>
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['subject'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['subject'].'</a>';
    }
    ?>  
  <td class="text-left"><?=$val['subject']?></td> 
<td><?=$val['start_lt']?></td> <td><?=$val['stop_lt']?></td> <td><b><?=$val['duration']?></b></td> 

<td><?=$participant?></td> 
<td class="text-left"><?=$val['remark']?></td> 
</tr>
<?php } ?>

<?php 
}
$total_subject = count($data);
$total_classroom = count($array_class);

$total_plan = $this->template->sum_time($total);

$total = $nomor;
$total_subject = count($array_subject);

?>

</tbody>

</table>

              </div>

              
              <br><br>
              <div class="table-responsive">
<table>
  <tr>
    <th class="text-left no-border" style="min-width:250px">
    
    <p>TOTAL GROUND SCHEDULE</p> 
    
    <p>TOTAL SUBJECT</p> 

    <p>TOTAL CLASS ROOM IN USE </p>
  
    <p>TOTAL PLAN</p> 
    
    </th>
    <th class="no-border" style="min-width:15px;">
  
    <p>:</p>
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px">
 
    <p><?=$total?></p>
    <p><?=$total_subject?></p>
    <p><?=$total_classroom?></p>
    <p><?=$total_plan?></p>
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


