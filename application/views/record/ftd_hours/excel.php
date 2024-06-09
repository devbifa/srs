<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$file_name.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
echo $excel_file;
?>

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
      $ftd = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('serial_number'=>$ftd_id));
      $se_ftd_id = $ftd['id'];
      $ftd = $this->mymodel->selectDataOne('synthetic_training_devices_document',array('serial_number'=>$ftd_id));
      $me_ftd_id = $ftd['id'];
      
      $se_ftd_id = $val2['code_sub'].' SE';
      $me_ftd_id = $val2['code_sub'].' ME';

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