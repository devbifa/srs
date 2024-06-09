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
            <div class="table-responsive">
  					<table class="table table-bordered table-striped" style="width:100%;">
                      <thead>
                        <tr class="bg-success th1">
                        <th rowspan="2">REMARK
                        </th>
                        <th  rowspan="2" style="min-width:75px;">DATE
                        </th>
                        <th colspan="3">FLIGHT TIME
                        </th>
                        <th colspan="3">CURRENT TIME
                        </th>
                        <th colspan="3">NEXT INSPECT PERIODIC	
                        </th>
                        <th  rowspan="2" style="min-width:75px;">CALCULATE REMAINING
                        </th>
                        </tr>
                        <tr class="bg-success th2">
                        <th style="min-width:75px;">TAKE<br>OFF</th>
                        <th style="min-width:75px;">LDG</th>
                        <th style="min-width:75px;">TOTAL</th>
                        <th style="min-width:75px;">A/F<br>TTIS</th>
                        <th style="min-width:75px;">ENG<br>TSO</th>
                        <th style="min-width:75px;">PROP<br>TSO</th>
                        <th style="min-width:75px;">A/F<br>TTIS</th>
                        <th style="min-width:75px;">REM</th>
                        <th style="min-width:75px;">INS.<br>TYPE</th>
                        </tr>
                      </thead>
                      <tbody id="data-one">
                        <tr>
                          <td colspan="12" class="text-left">
                          <i class="fa fa-spin fa-spinner"></i> Loading...
                          </td>
                        </tr>
                      </tbody>
                      </table>
                      </div>
              

              <script>
      $.ajax(
        {
            type: 'post',
            url: '<?=base_url()?>report/aircraft_status/ajax_one',
            data: { 
              "aircraft": '<?=$aircraft_document['registration']?>'
            },
            success: function (response) {
              $('#data-one').html('');
              $('#data-one').html(response);
            },
            error: function () {
              
            }
        }
      );
      </script>

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

$id_aircraft = $aircraft_document['serial_number'];


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

    // $file = $this->mymodel->selectDataone('file',array('table_id'=>$vr['id'],'table'=>'daily_flight_schedule'));
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
   
    // $file = $this->mymodel->selectDataone('file',array('table_id'=>$vr['id'],'table'=>'daily_flight_schedule'));
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
                    <th  rowspan="2" style="min-width:75px;">DATE
                    </th>
                    <th colspan="3">MAINTENACE TIME
                    </th>
                    <th rowspan="2" style="min-width:75px;">
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
$id_aircraft = $aircraft_document['serial_number'];
$report_2 = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule 
WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft'  AND type NOT IN ('ENGINE','PROP','')
-- AND flight_time_total NOT IN ('','-','00:00','0:00')
-- AND flight_time_take_off >= '00:00' AND flight_time_take_off <= '21:59' AND type != ''
ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
// print_r($aircraft_document);
$last_report = $report_2[(count($report_2)-1)];

$body_history = '';
// print_r($report_2);
foreach($report_2 as $kr=>$vr){
$next_inspection2 = $vr['type'];
$nomor++;

$text = "";
// if($vr['type']=='ENGINE'){


  $text = 'INSPECTION<br>'.$vr['type'];
  $text2 = 'INSPECTION'.$vr['type'];

// $file = $this->mymodel->selectDataone('file',array('table_id'=>$vr['id'],'table'=>'daily_flight_schedule'));
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
          <th  rowspan="2" style="min-width:75px;">DATE
          </th>
          <th colspan="3">INSPECTION TIME
          </th>
          <th rowspan="2" style="min-width:75px;">
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
    // print_r($aircraft_inspection_type);
    foreach($inspection_type_next as $k=>$v){
      $inspection = '<option value="'.$v['option'].'">'.$v['option'].'</option>'; 
    }
    // print_r($last_report['type']);
    // echo $last_report['type'];
    // if(empty($last_report['type'])){
    //      $inspection = '<option value="'.$aircraft_document['next_inspection_type'].'">'.$aircraft_document['next_inspection_type'].'</option>'; 
    // }else{
    //   $check = 0;
    //   foreach($aircraft_inspection_type as $k=>$v){
    //     if($v['option'] > $last_report['type']){
    //       $check = $k;
    //       // echo $v['inspection_type'].'<br>';
    //       // echo $type['type'].'<br><br>';
    //       break;
    //     }else{
    //       // $check = 0;
    //     }
    //   }
    //   if($check==0){
    //     $inspection = '<option value="'.$aircraft_inspection_type[0]['option'].'">'.$aircraft_inspection_type[0]['option'].'</option>'; 
    //   }else{
    //     $inspection = '<option value="'.$aircraft_inspection_type[$check]['option'].'">'.$aircraft_inspection_type[$check]['option'].'</option>'; 
    //   }
    
    // }

$insp = $this->mymodel->selectDataOne('inspection_type',array('id'=>$aircraft_document['inspection_type']));
$insp = json_decode($insp['konfigurasi'],true);
$arr_insp = '';
foreach($insp as $k=>$v){
  $arr_insp .= '<option value="'.$v['option'].'">'.$v['option'].' ~ '.$v['hours'].' Hours</option>';
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
'.$arr_insp.'
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