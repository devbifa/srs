<?php

$inspection_type = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type ORDER BY inspection_number ASC");

?>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        AIRCRAFT DOCUMENT

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">AIRCRAFT DOCUMENT</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/aircraft_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $aircraft_document['id'] ?>">

      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT AIRCRAFT DOCUMENT <?=$aircraft_document['serial_number']?>
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-body collapse">

                <div class="show_error"></div>
                <div class="row">
                <div class="col-md-12">
                
                <div class="row">
                <div class="form-group col-md-3">

                      <label for="form-model">MODEL</label>

                      <input type="text" class="form-control" id="form-model" placeholder="Fill Model" name="dt[model]" value="<?= $aircraft_document['model'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-type">TYPE</label>

                     
<select style='width:100%' name="dt[type]" class="form-control select2">

<?php 

$curriculum = $this->mymodel->selectWhere('aircraft_type',null);

foreach ($curriculum as $curriculum_record) {

  $text="";

  if($curriculum_record['aircraft_type']==$aircraft_document['type']){

    $text = "selected";

  }



  echo "<option value='".$curriculum_record['aircraft_type']."' ".$text." >".$curriculum_record['aircraft_type']."</option>";

}

?>

</select>


                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-serial_number">SERIAL</label>

                      <input type="text" class="form-control" id="form-serial_number" placeholder="Fill Serial Number" name="dt[serial_number]" value="<?= $aircraft_document['serial_number'] ?>">

                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-registration">REGISTRATION</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[registration]" value="<?= $aircraft_document['registration'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">SERIAL NUMBER</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[serial]" value="<?= $aircraft_document['serial'] ?>">

                  </div>

                  <div class="form-group col-md-3">

                      <label for="form-registration">ENGINE NUMBER</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[engine]" value="<?= $aircraft_document['engine'] ?>">

                  </div>

                  <div class="form-group col-md-3">

                      <label for="form-registration">PROP NUMBER</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[prop]" value="<?= $aircraft_document['prop'] ?>">

                  </div>

                  <div class="form-group col-md-3">

                      <label for="form-registration">USG</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[usg]" value="<?= $aircraft_document['usg'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">MIX</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[mix]" value="<?= $aircraft_document['mix'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">NF</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[nf]" value="<?= $aircraft_document['nf'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">AVIONIC</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[avionic]" value="<?= $aircraft_document['avionic'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">LOG NUMBER</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[log_number]" value="<?= $aircraft_document['log_number'] ?>">

                  </div>

                  <div class="form-group col-md-3">

<label for="form-registration">A/F TTIS</label>

<input type="text" class="form-control" id="form-registration" placeholder="" name="dt[start_a_f_ttis]" value="<?= $aircraft_document['start_a_f_ttis'] ?>">

</div>

<div class="form-group col-md-3">

<label for="form-registration">ENG TSO</label>

<input type="text" class="form-control" id="form-registration" placeholder="" name="dt[start_eng_tso]" value="<?= $aircraft_document['start_eng_tso'] ?>">

</div>

<div class="form-group col-md-3">

<label for="form-registration">PROP TSO</label>

<input type="text" class="form-control" id="form-registration" placeholder="" name="dt[start_prop_tso]" value="<?= $aircraft_document['start_prop_tso'] ?>">

</div>

                  <div class="form-group col-md-3">

                      <label for="form-type">STATUS</label>

                     
<select style='width:100%' name="dt[status]" class="form-control select2">

<?php 

$curriculum = $this->mymodel->selectWhere('aircraft_status',null);

foreach ($curriculum as $curriculum_record) {

  $text="";

  if($curriculum_record['aircraft_status']==$aircraft_document['status']){

    $text = "selected";

  }



  echo "<option value='".$curriculum_record['aircraft_status']."' ".$text." >".$curriculum_record['aircraft_status']."</option>";

}

?>

</select>


                  </div>

                  
<div class="form-group col-md-3">

<label for="form-registration">NEXT A/F TTIS</label>

<input type="text" class="form-control" id="form-registration" placeholder="" name="dt[next_a_f_ttis]" value="<?= $aircraft_document['next_a_f_ttis'] ?>">

</div>
<!-- <div class="form-group col-md-3">

<label for="form-registration">NEXT REM</label>

<input type="text" class="form-control" id="form-registration" placeholder="" name="dt[next_rem]" value="<?= $aircraft_document['next_rem'] ?>">

</div> -->


<div class="form-group col-md-3">

<label for="form-type">INSPECTION TYPE</label>


<select style='width:100%' name="dt[inspection_type]" class="form-control select2">

<?php 

$curriculum = $this->mymodel->selectWhere('inspection_type',null);

foreach ($curriculum as $curriculum_record) {

$text="";

if($curriculum_record['id']==$aircraft_document['inspection_type']){

$text = "selected";

}



echo "<option value='".$curriculum_record['id']."' ".$text." >".$curriculum_record['inspection_type']."</option>";

}

?>

</select>


</div>



<div class="form-group col-md-3">

<label for="form-type">PREV INSPECTION</label>


<select style='width:100%' name="dt[prev_inspection_type]" class="form-control select2">

<?php 
$inspection_type  = $this->mymodel->selectDataOne('inspection_type', array('id'=>$aircraft_document['inspection_type']));
// print_r($inspection_type);
$json_konfigurasi = json_decode($inspection_type['konfigurasi'],true);

foreach ($json_konfigurasi as $v) {
  
// echo '<br>'.$v['inspection_type'].' - '.$aircraft_document['next_inspection_type'];
$text="";

if($v['option']==$aircraft_document['prev_inspection_type']){

$text = "selected";

}



echo "<option value='".$v['option']."' ".$text." >".$v['option']."</option>";

}

?>

</select>


</div>

<div class="form-group col-md-3">

<label for="form-type">NEXT INSPECTION</label>


<select style='width:100%' name="dt[next_inspection_type]" class="form-control select2">

<?php 
$inspection_type  = $this->mymodel->selectDataOne('inspection_type', array('id'=>$aircraft_document['inspection_type']));
// print_r($inspection_type);
$json_konfigurasi = json_decode($inspection_type['konfigurasi'],true);

foreach ($json_konfigurasi as $v) {
  
// echo '<br>'.$v['inspection_type'].' - '.$aircraft_document['next_inspection_type'];
$text="";

if($v['option']==$aircraft_document['next_inspection_type']){

$text = "selected";

}



echo "<option value='".$v['option']."' ".$text." >".$v['option']."</option>";

}

?>

</select>


</div>

    

<div class="form-group col-md-3">

<label for="form-type">BASE</label>


<select style='width:100%' name="dt[base]" class="form-control select2">

<?php 

$this->db->order_by('base','ASC');
$curriculum = $this->mymodel->selectWhere('base_airport_document',null);

foreach ($curriculum as $curriculum_record) {

$text="";

if($curriculum_record['base']==$aircraft_document['base']){

$text = "selected";

}



echo "<option value='".$curriculum_record['base']."' ".$text." >".$curriculum_record['base']."</option>";

}

?>

</select>


</div>



                  <div class="form-group col-md-3">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

                  </div>
                
       

                </div></div>
  
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1"  data-placement="top" title="SAVE AIRCRAFT DATA"><i class="mdi mdi-content-save"></i></button>

            

                </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

          </div>
          </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

      </form>


      

      <div class="row">
		  
		  <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                ATTACHMENT LIST
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-body collapse">

   
                <div class="row">
               
 
                  <div class="col-md-12">
  
  <div class="row">
  <div class="form-group col-md-12">
<!-- <label for="form-file">ATTACHMENT LIST</label> -->
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th class="text-left" rowspan="2" >NO.
</th>
<th class="text-left" rowspan="2" >ATTACHMENT NAME
</th>
<th colspan="2">VALID DATE
</th>
<th rowspan="2">REMARK
</th>
<th class="text-left"   rowspan="2" style="width:105px;">
</th>
</tr>
<tr>
  <th style="width:100px;" >START
  </th>
  <th style="width:100px;" >UNTIL
  </th>
</tr>
<?php
$attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM aircraft_file WHERE status = 'ENABLE' ORDER BY number ASC");
$att = json_decode($aircraft_document['attachment'],true);
// print_r($att);

$i = 0;

$price = array();
// // foreach ($attachment_list as $key => $row)
// // {
// //     $price[$key] = $row['number'];
// // }
// array_multisort($price, SORT_ASC, $attachment_list);
// print_r($attachment_list);

foreach($attachment_list as $key=>$val){
 
    // echo $val['number'];
    // $data = $this->mymodel->selectDataOne('aircraft_file',array('id'=>$val['type']));
    
?>
<tr>
<td class="text-left" style="width:25px;" >
<?=$i+1?>
</td>
<td class="text-left">
<?=$val['aircraft_file']?>
</td>
<td>
<?=$this->template->date_indo(($att[$val['id']]['valid_date_start']))?>
</td>

<td>
<?=$this->template->date_indo(($att[$val['id']]['valid_date_until']))?>
</td>
<td class="text-left">
<?=(($att[$val['id']]['description']))?>
</td>
<td class="text-left" style="width:70px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-<?=$i?>"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-<?=$i?>"><i class="mdi mdi-delete"></i></a>

<?php

if($att[$val['id']]['file']){ ?>
<a href="<?=base_url()?>webfile/student_file/<?=$att[$val['id']]['file']?>" target="_blank" class="btn btn-delete btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
<?php } ?>

  
<div class="modal modal-success fade" id="modal-upload-<?=$i?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE ATTACHMENT FILE</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/aircraft_document/update_file/<?=$aircraft_document['id']?>/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Attachment Type</label>
                <input readonly autocomplete="off" required required type="text" class="form-control" name="dtt[type]" value="<?=$val['aircraft_file']?>">
            </div>
<div class="form-group">
                <label>Valid Date Start</label>
                <input autocomplete="off" required required type="hidden" class="form-control" name="dtt[id]" value="<?=$val['id']?>">
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_start]" value="<?=$att[$val['id']]['valid_date_start']?>">
                </div>
                <div class="form-group">
                <label>Valid Date Until</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_until]" value="<?=$att[$val['id']]['valid_date_until']?>">
                </div>
<!-- <div class="form-group">
                <label>Attachment Number</label>
                <input autocomplete="off" requiredrequired type="text" class="form-control" name="dtt[number]" value="<?=$val['number']?>">
                </div> -->
                <div class="form-group">
                <label>Description</label>
                <input autocomplete="off" required required type="text" class="form-control" name="dtt[description]" value="<?=$att[$val['id']]['description']?>">
                </div>
<div class="form-group">
                <label>Attachment File</label> *empty if not updated.
                <input type="file" class="form-control" name="file">
</div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Upload File</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

       
<div class="modal modal-danger fade" id="modal-delete-<?=$i?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE ATTACHMENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this data?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/aircraft_document/delete/<?=$aircraft_document['id']?>">Delete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
</td>
</tr>

<?php 
$i++;
} ?>
</table>
</div>
</div>
  </div>
  </div>
  </div>
  
            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

          </div>
          </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

     
      <div class="modal modal-success fade" id="modal-upload">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPLOAD ATTACHMENT FILE</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/aircraft_document/upload_file/<?=$aircraft_document['id']?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Attachment Type</label>
                <select required style="width:100%;" class="select2" name="dtt[type]">
<option value="">SELECT ATTACHMENT
</option>
<?php foreach($attachment as $key2=>$val2){ ?>
<option value="<?=$val2['id']?>"><?=$val2['aircraft_file']?>
</option>
<?php } ?>
</select>    
            </div>
<div class="form-group">
                <label>Valid Date Start</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_start]">
                </div>
<div class="form-group">
                <label>Valid Date Until</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_until]">
                </div>
<div class="form-group">
                <label>Attachment Number</label>
                <input autocomplete="off" requiredrequired type="text" class="form-control" name="dtt[number]">
                </div>
                <div class="form-group">
                <label>Description</label>
                <input autocomplete="off" required required type="text" class="form-control" name="dtt[description]">
                </div>
<div class="form-group">
                <label>Attachment File</label>
                <input required type="file" class="form-control" name="file">
</div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Upload File</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>




      <div class="row">

        <div class="col-md-7">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                AIRCRAFT USAGE HISTORY
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-body">
              <?php
      $id_aircraft = $aircraft_document['serial_number'];     
      $aircraft[0] = $id_aircraft;    
//  echo "SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) ASC LIMIT 1";
  $date_1 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) ASC LIMIT 1");
  $date_1 = $date_1[0]['date_of_flight'];
  $date_2 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) DESC LIMIT 1");
  $date_2 = $date_2[0]['date_of_flight'];
  $data =  $this->template->date_range( $date_1, $date_2);
  // print_r($data);
  foreach($aircraft as $key=>$val){
    $history_use = "";
    $body_eng_tso = "";

    $history_prop_tso = "";
    $body_prop_tso = "";
  
 
  
  $a_f_ttis = array();
  $eng_tso_text = "";
  $prop_tso_text = "";
  
  $current_time_eng_now = "";
  $current_time_prop_now = "";

  $start_a_f_ttis = $val['start_a_f_ttis'];
  $nomor = 0;  
  
  $next_rem = array();

  $next_rem[0] = $aircraft_document['next_a_f_ttis'];
  $next_rem[1] = $aircraft_document['start_a_f_ttis'];

  $next_rem = $this->template->sub_time($next_rem);

  $body_eng_tso .= '<tr>
  <td colspan="5" class="text-left" >START TIME</td>
  <td>'.$aircraft_document['start_a_f_ttis'].'</td>
  <td>'.$aircraft_document['start_eng_tso'].'</td>
  <td>'.$aircraft_document['start_prop_tso'].'</td>
  <td>'.$aircraft_document['next_a_f_ttis'].'</td>
  <td>'.$next_rem.'</td>
  <td>-</td>
  </tr>'; 

  foreach($data as $vd=>$kd){
    
    
    $report_1 = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule 
    WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft' 
    AND DATE(date_of_flight) >= '$kd' AND DATE(date_of_flight) <= '$kd' 
    AND flight_time_total NOT IN ('','-','00:00','0:00')
    AND flight_time_take_off >= '22:00' AND flight_time_take_off <= '24:00'
    ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
    // print_r($report_1);
    foreach($report_1 as $kr=>$vr){
      $current_time_eng = array();
      $current_time_prop = array();
      $current_time_ttis = array();
      $current_time_next_ttis = array();
      $current_time_next_rem = array();
      // $current_time_ttis = array();
      $nomor++;
      if($vr['type']==''){
        array_push($a_f_ttis,$vr['flight_time_total']);

        if($nomor == 1){
          $current_time_eng[0] = $aircraft_document['start_eng_tso'];
          $current_time_eng[1] = $vr['flight_time_total'];
          $current_time_eng = $this->template->sum_time($current_time_eng);
          $current_time_eng_now = $current_time_eng;
          $current_time_prop[0] = $aircraft_document['start_prop_tso'];
          $current_time_prop[1] = $vr['flight_time_total'];
          $current_time_prop = $this->template->sum_time($current_time_prop);
          $current_time_prop_now = $current_time_prop;
          $current_time_ttis[0] = $aircraft_document['start_a_f_ttis'];
          $current_time_ttis[1] = $vr['flight_time_total'];
          $current_time_ttis = $this->template->sum_time($current_time_ttis);
          $current_time_ttis_now = $current_time_ttis;

          $current_time_next_ttis[0] =$aircraft_document['next_a_f_ttis'];
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;

          $current_time_next_rem[0] = $current_time_next_ttis_now;
          $current_time_next_rem[1] = $current_time_ttis_now;
          $current_time_next_rem = $this->template->sub_time($current_time_next_rem);
          $current_time_next_rem_now = $current_time_next_rem;

          
        }else{
          $current_time_eng[0] = $current_time_eng_now;
          $current_time_eng[1] = $vr['flight_time_total'];
          $current_time_eng = $this->template->sum_time($current_time_eng);
          $current_time_eng_now = $current_time_eng;
          $current_time_prop[0] = $current_time_prop_now;
          $current_time_prop[1] = $vr['flight_time_total'];
          $current_time_prop = $this->template->sum_time($current_time_prop);
          $current_time_prop_now = $current_time_prop;
          $current_time_ttis[0] = $current_time_ttis_now;
          $current_time_ttis[1] = $vr['flight_time_total'];
          $current_time_ttis = $this->template->sum_time($current_time_ttis);
          $current_time_ttis_now = $current_time_ttis;
        

          // $current_time_next_ttis[0] =$aircraft_document['next_a_f_ttis'];
          $current_time_next_ttis[1] =$current_time_next_ttis_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;

          $current_time_next_rem[0] = $current_time_next_ttis_now;
          $current_time_next_rem[1] = $current_time_ttis;
          $current_time_next_rem = $this->template->sub_time($current_time_next_rem);
          $current_time_next_rem_now = $current_time_next_rem;

        }

        $body_eng_tso .= '<tr>
                            <td>DMR '.$vr['origin_base'].'</td>
                            <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
                            <td>'.$vr['flight_time_take_off'].'</td>
                            <td>'.$vr['flight_time_landing'].'</td>
                            <td>'.$vr['flight_time_total'].'</td>
                            <td>'.$current_time_ttis_now.'</td><td>'.$current_time_eng_now.'</td><td>'.$current_time_prop_now.'</td>
                            <td>'.$current_time_next_ttis_now.'</td><td>'.$current_time_next_rem_now.'</td><td>-</td>
                          </tr>'; 
 


      }else if($vr['type']=='ENGINE'){

        $current_time_eng_now = "00:00"; 

        $body_eng_tso .= '<tr>
        <td>MAINTENANCE<br>ENGINE</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_ttis_now.'</td><td>'.$current_time_eng_now.'</td><td>'.$current_time_prop_now.'</td>
        <td colspan="3"></td>
        </tr>'; 
      }else if($vr['type']=='PROP'){

        $current_time_prop_now = "00:00";

        $body_eng_tso .= '<tr>
        <td>MAINTENANCE<br>PROPELLER</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_ttis_now.'</td><td>'.$current_time_eng_now.'</td><td>'.$current_time_prop_now.'</td>
        <td colspan="3"></td>
        </tr>'; 
      }else if(!in_array($vr['type'],array('PROP','ENGINE',''))){

        // echo '2';

        if($vr['calculate_remaining']=='YES'){
          $current_time_next_ttis[0] =$vr['type'];
          $current_time_next_ttis[1] = $current_time_next_ttis_now;
          $current_time_next_ttis[2] = $current_time_next_rem_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;
        }else{
          $current_time_next_ttis[0] =$vr['type'];
          $current_time_next_ttis[1] = $current_time_next_ttis_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;
          $vr['calculate_remaining'] = 'NO';
        }
       

        $current_time_next_rem[0] = $current_time_next_rem_now;
        $current_time_next_rem[1] = $vr['type'];
        $current_time_next_rem = $this->template->sum_time($current_time_next_rem);
        $current_time_next_rem_now = $current_time_next_rem;

        $body_eng_tso .= '<tr>
        <td>INSPECTION<br>'.$vr['type'].'</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        
        <td colspan="4"></td>

        <td>'.$current_time_next_ttis.'</td><td>'.$current_time_next_rem_now.'</td><td>'.$vr['type'].'</td>
        </tr>'; 
      }
    }

        
    $report_2 = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule 
    WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft' 
    AND DATE(date_of_flight) >= '$kd' AND DATE(date_of_flight) <= '$kd' 
    AND flight_time_total NOT IN ('','-','00:00','0:00')
    AND flight_time_take_off >= '00:00' AND flight_time_take_off <= '21:59'
    ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
    foreach($report_2 as $kr=>$vr){
      $current_time_eng = array();
      $current_time_prop = array();
      $current_time_ttis = array();
      $current_time_next_ttis = array();
      $current_time_next_rem = array();
      // $current_time_ttis = array();
      $nomor++;
      if($vr['type']==''){
        array_push($a_f_ttis,$vr['flight_time_total']);

        if($nomor == 1){
          $current_time_eng[0] = $aircraft_document['start_eng_tso'];
          $current_time_eng[1] = $vr['flight_time_total'];
          $current_time_eng = $this->template->sum_time($current_time_eng);
          $current_time_eng_now = $current_time_eng;
          $current_time_prop[0] = $aircraft_document['start_prop_tso'];
          $current_time_prop[1] = $vr['flight_time_total'];
          $current_time_prop = $this->template->sum_time($current_time_prop);
          $current_time_prop_now = $current_time_prop;
          $current_time_ttis[0] = $aircraft_document['start_a_f_ttis'];
          $current_time_ttis[1] = $vr['flight_time_total'];
          $current_time_ttis = $this->template->sum_time($current_time_ttis);
          $current_time_ttis_now = $current_time_ttis;

          $current_time_next_ttis[0] =$aircraft_document['next_a_f_ttis'];
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;

          $current_time_next_rem[0] = $current_time_next_ttis_now;
          $current_time_next_rem[1] = $current_time_ttis_now;
          $current_time_next_rem = $this->template->sub_time($current_time_next_rem);
          $current_time_next_rem_now = $current_time_next_rem;

          
        }else{
          $current_time_eng[0] = $current_time_eng_now;
          $current_time_eng[1] = $vr['flight_time_total'];
          $current_time_eng = $this->template->sum_time($current_time_eng);
          $current_time_eng_now = $current_time_eng;
          $current_time_prop[0] = $current_time_prop_now;
          $current_time_prop[1] = $vr['flight_time_total'];
          $current_time_prop = $this->template->sum_time($current_time_prop);
          $current_time_prop_now = $current_time_prop;
          $current_time_ttis[0] = $current_time_ttis_now;
          $current_time_ttis[1] = $vr['flight_time_total'];
          $current_time_ttis = $this->template->sum_time($current_time_ttis);
          $current_time_ttis_now = $current_time_ttis;
        

          // $current_time_next_ttis[0] =$aircraft_document['next_a_f_ttis'];
          $current_time_next_ttis[1] =$current_time_next_ttis_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;

          $current_time_next_rem[0] = $current_time_next_ttis_now;
          $current_time_next_rem[1] = $current_time_ttis;
          $current_time_next_rem = $this->template->sub_time($current_time_next_rem);
          $current_time_next_rem_now = $current_time_next_rem;

        }

        $body_eng_tso .= '<tr>
                            <td>DMR '.$vr['origin_base'].'</td>
                            <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
                            <td>'.$vr['flight_time_take_off'].'</td>
                            <td>'.$vr['flight_time_landing'].'</td>
                            <td>'.$vr['flight_time_total'].'</td>
                            <td>'.$current_time_ttis_now.'</td><td>'.$current_time_eng_now.'</td><td>'.$current_time_prop_now.'</td>
                            <td>'.$current_time_next_ttis_now.'</td><td>'.$current_time_next_rem_now.'</td><td>-</td>
                          </tr>'; 
 


      }else if($vr['type']=='ENGINE'){

        $current_time_eng_now = "00:00"; 

        $body_eng_tso .= '<tr>
        <td>MAINTENANCE<br>ENGINE</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_ttis_now.'</td><td>'.$current_time_eng_now.'</td><td>'.$current_time_prop_now.'</td>
        <td colspan="3"></td>
        </tr>'; 
      }else if($vr['type']=='PROP'){

        $current_time_prop_now = "00:00";

        $body_eng_tso .= '<tr>
        <td>MAINTENANCE<br>PROPELLER</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_ttis_now.'</td><td>'.$current_time_eng_now.'</td><td>'.$current_time_prop_now.'</td>
        <td colspan="3"></td>
        </tr>'; 
      }else if(!in_array($vr['type'],array('PROP','ENGINE',''))){
        // echo '1';


        if($vr['calculate_remaining']=='YES'){
          $current_time_next_ttis[0] =$vr['type'];
          $current_time_next_ttis[1] = $current_time_next_ttis_now;
          $current_time_next_ttis[2] = $current_time_next_rem_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;

          $current_time_next_rem[0] = $current_time_next_rem_now;
        $current_time_next_rem[1] = $vr['type'];
        $current_time_next_rem = $this->template->sum_time($current_time_next_rem);
        $current_time_next_rem_now = $current_time_next_rem;
        }else{
          $current_time_next_ttis[0] =$vr['type'];
          $current_time_next_ttis[1] = $current_time_next_ttis_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;
          $vr['calculate_remaining'] = 'NO';

          $current_time_next_rem[0] = '00:00';
        $current_time_next_rem[1] = $vr['type'];
        $current_time_next_rem = $this->template->sum_time($current_time_next_rem);
        $current_time_next_rem_now = $current_time_next_rem;

        }
       
        

        $body_eng_tso .= '<tr>
        <td>INSPECTION<br>'.$vr['type'].'</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        
        <td colspan="4"></td>

        <td>'.$current_time_next_ttis.'</td><td>'.$current_time_next_rem_now.'</td><td>'.$vr['type'].'</td>
        </tr>'; 
      }
    }


  }

  $history_use = '<div class="table-responsive">
  <table class="table table-bordered" style="background-color: #fff0;" style="width:100%;">
                      <tr class="bg-success">
                      <th rowspan="2">REMARK
                      </th>
                      <th  rowspan="2" style="min-width:100px;">DATE
                      </th>
                      <th colspan="3">FLIGHT TIME
                      </th>
                      <th colspan="3">CURRENT TIME
                      </th>
                      <th colspan="3">INSPECT PERIODIC	
                      </th>
                      </tr>
                      <tr class="bg-success">
                      <th>TAKE OFF</th>
                      <th>LANDING</th>
                      <th>TOTAL</th>
                      <th>A/F TTIS</th>
                      <th>ENG TSO</th>
                      <th>PROP TSO</th>
                      <th>A/F TTIS</th>
                      <th>REM</th>
                      <th>INS. TYPE</th>
                      </tr>
                      '.$body_eng_tso.'
                      </table>
                      </div>
                      ';


  // foreach($report as $k=>$v){
  //   if (strpos($v['flight_time_total'], ':') !== false) {
  //     array_push($a_f_ttis,$v['flight_time_total']);
  //   }
  // }

  // $maintenance_engine = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_aircraft_engine WHERE aircraft_reg = '$id_aircraft'");
  // $maintenance_prop = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_aircraft_propeller WHERE aircraft_reg = '$id_aircraft'");
// echo count($a_f_ttis);
  $a_f_ttis = $this->template->sum_time_3($a_f_ttis);
  $eng_tso = $current_time_eng_now;
  $prop_tso = $current_time_prop_now;
  if($eng_tso >= 2200){
    $eng_tso_text = "text-red";
  }
  if($prop_tso >= 2000){
    $prop_tso_text = "text-red";
  }
  ?>

<?php 
}

?>
              <?=$history_use?>
			</div>
			</div>
      </div>
      <div class="col-md-5">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                AIRCRAFT MAINTENANCE HISTORY
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-body">
              <?php



$report_2 = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule 
WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft' 
AND flight_time_total NOT IN ('','-','00:00','0:00')
-- AND flight_time_take_off >= '00:00' AND flight_time_take_off <= '21:59' AND type != ''
ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
foreach($report_2 as $kr=>$vr){
  $current_time_eng = array();
  $current_time_prop = array();
  $current_time_ttis = array();
  $nomor++;
  
  $text = "";
  if($vr['type']=='ENGINE'){

   
    $text = "MAINTENANCE ENGINE";

    $file = $this->mymodel->selectDataone('file',array('table_id'=>$vr['id'],'table'=>'daily_flight_schedule'));
    $eye = "";
    if($file['name']){
      $eye = ' <a href="'.base_url().'webfile/'.$file['name'].'" target="_blank" class="btn btn-primary btn-xs btn-delete" ><i class="mdi mdi-eye"></i></a>';
    }

    $body_history .= '<tr>
    <td>MAINTENANCE<br>ENGINE</td>
    <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
    <td>'.$vr['flight_time_take_off'].'</td><td>'.$vr['flight_time_landing'].'</td><td>'.$vr['flight_time_total'].'</td>
    <td class="text-left">
    <a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-'.$vr['id'].'"><i class="mdi mdi-pencil"></i></a>
    <a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-'.$vr['id'].'"><i class="mdi mdi-delete"></i></a>
    '.$eye.'
    </td>
    </tr>'; 
  }else if($vr['type']=='PROP'){

    $text = "MAINTENANCE PROPELLER";
   
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$vr['id'],'table'=>'daily_flight_schedule'));
    $eye = "";
    if($file['name']){
      $eye = ' <a href="'.base_url().'webfile/'.$file['name'].'" target="_blank" class="btn btn-primary btn-xs btn-delete" ><i class="mdi mdi-eye"></i></a>';
    }

    $body_history .= '<tr>
    <td>MAINTENANCE<br>PROPELLER</td>
    <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
    <td>'.$vr['flight_time_take_off'].'</td><td>'.$vr['flight_time_landing'].'</td><td>'.$vr['flight_time_total'].'</td>
    <td class="text-left">
    <a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-'.$vr['id'].'"><i class="mdi mdi-pencil"></i></a>
    <a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-'.$vr['id'].'"><i class="mdi mdi-delete"></i></a>
    '.$eye.'
    </td>
    </tr>'; 
  }
  $body_history .= '<div class="modal modal-success fade" id="modal-upload-'.$vr['id'].'">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">EDIT MAINTENANCE HISTORY</h4>
      </div>
      <div class="modal-body" style="color:#fff!important;">
       <form action="'.base_url().'master/aircraft_document/update_history/'.$vr['id'].'" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <label>MAINTENANCE TYPE</label>
        <input readonly autocomplete="off" required required type="text" class="form-control" name="" value="'.$text.'">
        </div>
        <div class="form-group">
        <label>DATE</label>
        <input autocomplete="off" required required type="text" class="form-control tgl" name="dt[date_of_flight]" value="'.$vr['date_of_flight'].'">
        <input autocomplete="off" required required type="hidden" class="form-control" name="id" value="'.$vr['id'].'">
        <input autocomplete="off" required required type="hidden" class="form-control" name="id_aircraft" value="'.$aircraft_document['id'].'">
        </div>
        <div class="form-group">
        <label>MAINTENANCE START</label>
        <input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_take_off]" value="'.$vr['flight_time_take_off'].'">
        </div>
        <div class="form-group">
        <label>MAINTENANCE STOP</label>
        <input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_landing]" value="'.$vr['flight_time_landing'].'">
        </div>
        <div class="form-group">
        <label>MAINTENANCE DURATION</label>
        <input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_total]" value="'.$vr['flight_time_total'].'">
        </div>
<div class="form-group">
        <label>ATTACHMENT FILE</label> *empty if not updated.
        <input type="file" class="form-control" name="file">
</div>
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline">Save</button>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal modal-danger fade" id="modal-delete-'.$vr['id'].'">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">DELETE MAINTENANCE HISTORY</h4>
      </div>
      <div class="modal-body" style="color:#fff!important;">
       <form action="">
        <span style="font-weight:100">Are you sure you want to delete this history?</span>
       </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
         <a type="button" class="btn btn-outline" href="'.base_url().'master/aircraft_document/delete_history/'.$vr['id'].'">Delete Now</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

';

}

$history_maintenance = '<div class="table-responsive">
<table class="table table-bordered" style="background-color: #fff0;" style="width:100%;">
                    <tr class="bg-success">
                    <th rowspan="2">REMARK
                    </th>
                    <th  rowspan="2" style="min-width:100px;">DATE
                    </th>
                    <th colspan="3">MAINTENACE TIME
                    </th>
                    <th rowspan="2" style="min-width:100px;">
                    </th>
                    </tr>
                    <tr class="bg-success">
                    <th>START</th>
                    <th>STOP</th>
                    <th>DURATION</th>
                    </tr>
                    '.$body_history.'
                    </table>
                    </div>
                    ';
              ?>
              <?=$history_maintenance?>
<br>
              <a href="#!" class="btn btn-success"  href="#!" data-toggle="modal" data-target="#modal-add-maintenance"><i class="mdi mdi-plus"></i> ADD MAINTENANCE</a>

              <?php
echo  '<div class="modal modal-success fade" id="modal-add-maintenance">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title">ADD MAINTENANCE HISTORY</h4>
    </div>
    <div class="modal-body" style="color:#fff!important;">
     <form action="'.base_url().'master/aircraft_document/store_history/'.$vr['id'].'" method="POST" enctype="multipart/form-data">
      <div class="form-group">
      <label>MAINTENANCE TYPE</label>
      <select readonly autocomplete="off" required required type="text" class="form-control select2" style="width:100%" name="dt[type]">
        <option value="ENGINE">ENGINE MAINTENANCE</option>
        <option value="PROP">PROPELLER MAINTENANCE</option>
      </select>
      </div>
      <div class="form-group">
      <label>DATE</label>
      <input autocomplete="off" required required type="text" class="form-control tgl" name="dt[date_of_flight]">
      <input autocomplete="off" required required type="hidden" class="form-control" name="id" value="'.$vr['id'].'">
      <input autocomplete="off" required required type="hidden" class="form-control" name="id_aircraft" value="'.$aircraft_document['id'].'">
      </div>
      <div class="form-group">
      <label>MAINTENANCE START</label>
      <input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_take_off]">
      </div>
      <div class="form-group">
      <label>MAINTENANCE STOP</label>
      <input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_landing]">
      </div>
      <div class="form-group">
      <label>MAINTENANCE DURATION</label>
      <input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_total]">
      </div>
<div class="form-group">
      <label>ATTACHMENT FILE</label> *empty if not updated.
      <input type="file" class="form-control" name="file">
</div>
   
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
      <button type="submit" class="btn btn-outline">Save</button>
      </form>
    </div>
  </div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>';


              ?>
			</div>
			</div>
      <div class="box">

<div class="box-header-material box-header-material-text">
      <div class="row">
      <div class="col-xs-10">
      AIRCRAFT INSPECTION HISTORY
      </div>
      <div class="col-xs-2">
          <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
          </div>
      </div>
      </div>
  </div>
  <div class="box-body">
    <?php

$report_2 = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule 
WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft'  AND type NOT IN ('ENGINE','PROP','')
-- AND flight_time_total NOT IN ('','-','00:00','0:00')
-- AND flight_time_take_off >= '00:00' AND flight_time_take_off <= '21:59' AND type != ''
ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
$last_report = $report_2[(count($report_2)-1)];

$body_history = '';
// print_r($report_2);
foreach($report_2 as $kr=>$vr){
$next_inspection2 = $vr['type'];
$nomor++;

$text = "";
// if($vr['type']=='ENGINE'){


  $text = 'INSPECTION<br>'.$vr['type'];
  $text2 = 'INSPECTION '.$vr['type'];

$file = $this->mymodel->selectDataone('file',array('table_id'=>$vr['id'],'table'=>'daily_flight_schedule'));
$eye = "";
if($file['name']){
$eye = ' <a href="'.base_url().'webfile/'.$file['name'].'" target="_blank" class="btn btn-primary btn-xs btn-delete" ><i class="mdi mdi-eye"></i></a>';
}

$body_history .= '<tr>
<td>INSPECTION<br>'.$vr['type'].'<br>CALCULATE:'.$vr['calculate_remaining'].'</td>
<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
<td>'.$vr['flight_time_take_off'].'</td><td>'.$vr['flight_time_landing'].'</td><td>'.$vr['flight_time_total'].'</td>
<td class="text-left">
<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-inspection-'.$vr['id'].'"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-inspection-'.$vr['id'].'"><i class="mdi mdi-delete"></i></a>
'.$eye.'
</td>
</tr>'; 
// }else if($vr['type']=='PROP'){

$selected_no = "";
$selected_yes = "";
if($vr['calculate_remaining']=='YES'){
  $selected_yes = 'selected';
}else{
  $selected_no = 'selected';
}
$body_history .= '<div class="modal modal-success fade" id="modal-upload-inspection-'.$vr['id'].'">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">EDIT INSPECTION HISTORY</h4>
</div>
<div class="modal-body" style="color:#fff!important;">
<form action="'.base_url().'master/aircraft_document/update_history/'.$vr['id'].'" method="POST" enctype="multipart/form-data">
<div class="form-group">
<label>INSPECTION TYPE</label>
<input readonly autocomplete="off" required required type="text" class="form-control" name="" value="'.$text2.'">
</div>
<div class="form-group">
<label>DATE</label>
<input autocomplete="off" required required type="text" class="form-control tgl" name="dt[date_of_flight]" value="'.$vr['date_of_flight'].'">
<input autocomplete="off" required required type="hidden" class="form-control" name="id" value="'.$vr['id'].'">
<input autocomplete="off" required required type="hidden" class="form-control" name="id_aircraft" value="'.$aircraft_document['id'].'">
</div>
<div class="form-group">
<label>INSPECTION START</label>
<input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_take_off]" value="'.$vr['flight_time_take_off'].'">
</div>
<div class="form-group">
<label>INSPECTION STOP</label>
<input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_landing]" value="'.$vr['flight_time_landing'].'">
</div>
<div class="form-group">
<label>INSPECTION DURATION</label>
<input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_total]" value="'.$vr['flight_time_total'].'">
</div>
<div class="form-group">
<label>CALCULATE REMAINING</label>
<select readonly autocomplete="off" required required type="text" class="form-control select2" style="width:100%" name="dt[calculate_remaining]">
<option '.$selected_yes.' >YES</option>
<option '.$selected_no.'>NO</option>
</select>
</div>

<div class="form-group">
<label>ATTACHMENT FILE</label> *empty if not updated.
<input type="file" class="form-control" name="file">
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-outline">Save</button>
</form>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>


<div class="modal modal-danger fade" id="modal-delete-inspection-'.$vr['id'].'">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">DELETE INSPECTION HISTORY</h4>
</div>
<div class="modal-body" style="color:#fff!important;">
<form action="">
<span style="font-weight:100">Are you sure you want to delete this history?</span>
</form>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
<a type="button" class="btn btn-outline" href="'.base_url().'master/aircraft_document/delete_history/'.$vr['id'].'">Delete Now</a>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

';

}

$history_maintenance = '<div class="table-responsive">
<table class="table table-bordered" style="background-color: #fff0;" style="width:100%;">
          <tr class="bg-success">
          <th rowspan="2">REMARK
          </th>
          <th  rowspan="2" style="min-width:100px;">DATE
          </th>
          <th colspan="3">INSPECTION TIME
          </th>
          <th rowspan="2" style="min-width:100px;">
          </th>
          </tr>
          <tr class="bg-success">
          <th>START</th>
          <th>STOP</th>
          <th>DURATION</th>
          </tr>
          '.$body_history.'
          </table>
          </div>
          ';
    ?>
    <?=$history_maintenance?>

    <br>
    <a href="#!" class="btn btn-success"  href="#!" data-toggle="modal" data-target="#modal-add-inspection"><i class="mdi mdi-plus"></i> ADD INSPECTION</a>

    <?php

    $inspection = '';
    $next_inspection = $aircraft_document['next_inspection_type'];

    $next_inspection2 = intval($next_inspection2);
    $next_inspection = intval($next_inspection);

    // if($report_2){
    //   $inspection_type_next = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type WHERE inspection_type > $next_inspection2 ORDER BY inspection_type ASC LIMIT 1");
    // }else{
    //   $inspection_type_next = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type WHERE inspection_type = $next_inspection ORDER BY inspection_type ASC LIMIT 1");
    // }
    
    
    // if(empty($inspection_type_next)){
    //   $inspection_type_next = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type ORDER BY inspection_type ASC LIMIT 1");
    // }
// echo 'AANG';
    $aircraft_inspection_type = $json_konfigurasi;
    
    foreach($inspection_type_next as $k=>$v){
      $inspection = '<option value="'.$v['option'].'">'.$v['option'].'</option>'; 
    }
    // print_r($last_report['type']);
    // echo $last_report['type'];
    if(empty($last_report['type'])){
         $inspection = '<option value="'.$aircraft_document['next_inspection_type'].'">'.$aircraft_document['next_inspection_type'].'</option>'; 
    }else{
      $check = 0;
      foreach($aircraft_inspection_type as $k=>$v){
        if($v['option'] > $last_report['type']){
          $check = $k;
          // echo $v['inspection_type'].'<br>';
          // echo $type['type'].'<br><br>';
          break;
        }else{
          // $check = 0;
        }
      }
      if($check==0){
        $inspection = '<option value="'.$aircraft_inspection_type[0]['option'].'">'.$aircraft_inspection_type[0]['option'].'</option>'; 
      }else{
        $inspection = '<option value="'.$aircraft_inspection_type[$check]['option'].'">'.$aircraft_inspection_type[$check]['option'].'</option>'; 
      }
    
    }

echo  '<div class="modal modal-success fade" id="modal-add-inspection">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span></button>
<h4 class="modal-title">ADD INSPECTON HISTORY</h4>
</div>
<div class="modal-body" style="color:#fff!important;">
<form action="'.base_url().'master/aircraft_document/store_history/'.$vr['id'].'" method="POST" enctype="multipart/form-data">
<div class="form-group">
<label>INSPECTION TYPE</label>
<select readonly autocomplete="off" required required type="text" class="form-control select2" style="width:100%" name="dt[type]">
'.$inspection.'
</select>
</div>
<div class="form-group">
<label>DATE</label>
<input autocomplete="off" required required type="text" class="form-control tgl" name="dt[date_of_flight]">
<input autocomplete="off" required required type="hidden" class="form-control" name="id" value="'.$vr['id'].'">
<input autocomplete="off" required required type="hidden" class="form-control" name="id_aircraft" value="'.$aircraft_document['id'].'">
</div>
<div class="form-group">
<label>INSPECTION START</label>
<input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_take_off]">
</div>
<div class="form-group">
<label>INSPECTION STOP</label>
<input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_landing]">
</div>
<div class="form-group">
<label>INSPECTION DURATION</label>
<input autocomplete="off" required required type="text" class="form-control" name="dt[flight_time_total]">
</div>
<div class="form-group">
<label>CALCULATE REMAINING</label>
<select readonly autocomplete="off" required required type="text" class="form-control select2" style="width:100%" name="dt[calculate_remaining]">
<option>YES</option>
<option>NO</option>
</select>
</div>
<div class="form-group">
<label>ATTACHMENT FILE</label> *empty if not updated.
<input type="file" class="form-control" name="file">
</div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
<button type="submit" class="btn btn-outline">Save</button>
</form>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>';


    ?>
</div>
</div>  
    </div>
      
      </div>
      
      
      
      <a href="" class="btn btn-danger float-2" href="#!" data-toggle="modal" data-target="#modal-delete-1"  data-placement="top" title="DELETE AIRCRAFT DATA"><i class="mdi mdi-delete"></i></a>
         
         <div class="modal modal-danger fade" id="modal-delete-1">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">DELETE DATA</h4>
               </div>
               <div class="modal-body" style="color:#fff!important;">
                <form action="<?=base_url()?>master/aircraft_document/delete/<?=$aircraft_document['id']?>">
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

         

    </section>

    <!-- /.content -->
    

  </div>
  

  <!-- /.content-wrapper -->

  <script type="text/javascript">

      $("#upload-create").submit(function(){

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

                    $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                          //  window.location.href = "<?= base_url('master/aircraft_document') ?>";
                           window.location.href = "";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>