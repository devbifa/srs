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
 FROM aircraft_document
--  WHERE serial_number = 'PK-ROC'
 ORDER BY serial_number ASC");
?>
<tr class="bg-success">

<tr class="bg-success">

<th style="width:5%" rowspan="2">NUM</th>
<th style="min-width:100px" rowspan="2">DATE</th>
<?php foreach($aircraft as $key=>$val){ ?>
<th style="min-width:100px" colspan="2"><?=$val['serial_number']?> (<?=$val['type']?>)</th>
<?php } ?>

<th style="min-width:100px" colspan="2">TOTAL</th>
 </tr>
</tr>
<tr class="bg-success">
<?php foreach($aircraft as $key=>$val){ ?>
<th>BLOCK TIME</th>
<th>FLIGHT TIME</th>
<?php } ?>
<th>BLOCK TIME</th>
<th>FLIGHT TIME</th>
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
     
    $block_time_total_bottom = array();
    $flight_time_total_bottom = array();
foreach($data as $key=>$val){
  $code = $val['code'];
  // $total = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count FROM daily_flight_schedule
  // WHERE remark_dmr = '$code' AND visibility = '1' AND visibility_report = '1' 
  // ");

  $total = $total[0]['count'];

  $grand_total = $grand_total + $total;

  ?>
  <tr>
    <td><?=$key+1?></td>
    <td><?=$val?></td>
    <?php 
    
    $block_time_total_right = array();
    $flight_time_total_right = array();
    $time_right = array();
    
    $bt = array();
    $ft = array();

    foreach($aircraft as $key2=>$val2){
      $dmr_date = $val;
      $aircraft_reg = $val2['serial_number'];
      $dmr = $this->mymodel->selectWithQuery("
      SELECT * FROM daily_flight_schedule a
      WHERE  a.visibility = '1' AND a.visibility_report = '1'  AND DATE(a.date_of_flight) = '$dmr_date'
      AND a.block_time_start NOT IN ('-','') AND a.aircraft_reg = '$aircraft_reg'
      ");
      $block_time_total = array();
      $flight_time_total = array();
      foreach($dmr as $key3=>$val3){
        if (strpos($val3['block_time_total'], ':') !== false) {
          array_push($block_time_total,$val3['block_time_total']);
        }
        if (strpos($val3['flight_time_total'], ':') !== false) {
          array_push($flight_time_total,$val3['flight_time_total']);
        }
      }
      $block_time_total = $this->template->sum_time_3($block_time_total);
      $flight_time_total = $this->template->sum_time_3($flight_time_total);

      $t[0] = $block_time_total;
      $t[1] = $flight_time_total;
      $time = $this->template->sum_time_3($t);

      array_push($block_time_total_right,$block_time_total);
      array_push($flight_time_total_right,$flight_time_total);
      array_push($time_right,$time);

     

      // header('Content-Type: application/json');
      $block_time_total_bottom[$val2['id']][$dmr_date] = $block_time_total;
      $flight_time_total_bottom[$val2['id']][$dmr_date] = $flight_time_total;

      ?>
      <td><?=$block_time_total?>
      </td>
      <td><?=$flight_time_total?>
      </td>
    <?php }
       $block_time_total_right = $this->template->sum_time_3($block_time_total_right);
       $flight_time_total_right = $this->template->sum_time_3($flight_time_total_right); 
       $time_right = $this->template->sum_time_3($time_right); 

       $dt['bt'][$dmr_date] = $block_time_total_right;
       $dt['ft'][$dmr_date] = $flight_time_total_right;
       $dt['tt'][$dmr_date] = $time_right;

    ?>
    <th class="bg-success"><?=$block_time_total_right?></th>
    <th class="bg-success"><?=$flight_time_total_right?></th>
  </tr>
<?php } 


?>

<tr>
    <th colspan="2" class="text-left">TOTAL</th>
    <?php foreach($aircraft as $key2=>$val2){

      $block_time_total_bottom_fix = ($block_time_total_bottom[$val2['id']]);
      $block_time_total_bottom_fix = $this->template->sum_time_3($block_time_total_bottom_fix); 
      $flight_time_total_bottom_fix = ($flight_time_total_bottom[$val2['id']]);
      $flight_time_total_bottom_fix = $this->template->sum_time_3($flight_time_total_bottom_fix); 
      ?>
      <th><?=$block_time_total_bottom_fix?>
      </th>
      <th>
        <?=$flight_time_total_bottom_fix?>
      </th>
    <?php }
    ?>
    
    <th class="bg-success">
      <?=$this->template->sum_time_3($dt['bt'])?>
      </th>
    <th class="bg-success">
      <?=$this->template->sum_time_3($dt['ft'])?>
      </th>
   
  </tr>
</tbody>

</table>