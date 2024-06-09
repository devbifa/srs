<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$file_name.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
echo $excel_file;
?>

<table class="table table-bordered " id="datatable">

<thead>

<tr class="bg-success">

            <th style="width:20px"  rowspan="2">NUM</th>
            <th rowspan="2">BATCH</th>
            <th rowspan="2">FULL NAME</th>
            <th rowspan="2">NICK NAME</th>
            <th rowspan="2">ID NUMBER</th>
            <th colspan="2">GROUND</th>
            <th colspan="2">FTD</th>
            <th colspan="2">FLIGHT</th>
            <th colspan="4">TOTAL</th>

          </tr>
<tr class="bg-success">
            <th>SE</th>
            <th>ME</th>
            <th>SE</th>
            <th>ME</th>
            <th>SE</th>
            <th>ME</th>
            <th>GROUND</th>
            <th>FTD</th>
            <th>FLIGHT</th>
            <th>TOTAL</th>
          </tr>
          </tr>

</thead>

<tbody>
<?php
$batch = $_SESSION['batch'];
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
if($batch){
  $batch = " AND a.batch = '$batch' ";
}else{
  $batch = " ";
}
$ground_se_summary = array();
$ground_me_summary = array();
$ftd_se_summary = array();
$ftd_me_summary = array();
$flight_se_summary = array();
$flight_me_summary = array();

$data = $this->mymodel->selectWithQuery("SELECT *
FROM user a
WHERE  a.student_status = 'APPROVE' AND a.visibility = '1'  AND a.instructor_status != '1' AND a.full_name != ''
"
.$batch.
"
ORDER BY a.batch ASC
");
foreach($data as $key=>$val){


  $ground_se_act = array();
  $ground_me_act = array();
  $ground_se_me_act = array();
  $ftd_se_act = array();
  $ftd_me_act = array();
  $ftd_se_me_act = array();
  $flight_se_act = array();
  $flight_me_act = array();
  $flight_se_me_act = array();
  $ground_r = array();
  $ftd_r = array();
  $flight_r = array();
  $r = array();
  $id_instructor= $val['id_number'];

  $qry = '{"val":"'.$id_instructor.'"}';

  $ground_se = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule a
  WHERE a.visibility = '1' AND a.visibility_report = '1'  AND student_attend LIKE '%$qry%' AND duration_act NOT IN ('','-','00:00','0:00') AND DATE(date) >='$start_date' AND DATE(date) <='$end_date' 
  AND type = 'SE'
  ");
  foreach($ground_se as $k=>$v){
    if (strpos($v['duration_act'], ':') !== false) {
      array_push($ground_se_act,$v['duration_act']);
      }  
  }

  $ground_me = $this->mymodel->selectWithQuery("SELECT * FROM daily_ground_schedule a
  WHERE a.visibility = '1' AND a.visibility_report = '1'  AND student_attend LIKE '%$qry%' AND duration_act NOT IN ('','-','00:00','0:00') AND DATE(date) >='$start_date' AND DATE(date) <='$end_date' 
  AND type = 'ME'
  ");
  foreach($ground_me as $k=>$v){
    if (strpos($v['duration_act'], ':') !== false) {
      array_push($ground_me_act,$v['duration_act']);
      }  
  }

  // print_r($ground_se_act);
  // print_r($ground_me_act);
  
  $ftd_se = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule a 
  LEFT JOIN synthetic_training_devices_document b
  ON a.ftd_model = b.code
  WHERE a.visibility = '1' AND a.visibility_report = '1'  AND  (a.pic = '$id_instructor' OR a.2nd = '$id_instructor') 
  -- AND a.block_time_total NOT IN ('','-','00:00','0:00') 
  AND b.type_enginee='SE'
  AND DATE(date) >='$start_date' AND DATE(date) <='$end_date'");
  foreach($ftd_se as $k=>$v){
    if (strpos($v['block_time_total'], ':') !== false) {
      array_push($ftd_se_act,$v['block_time_total']);
      }  
  }
  $ftd_me = $this->mymodel->selectWithQuery("SELECT * FROM daily_ftd_schedule a 
  LEFT JOIN synthetic_training_devices_document b
  ON a.ftd_model = b.code
  WHERE a.visibility = '1' AND a.visibility_report = '1'  AND  (a.pic = '$id_instructor' OR a.2nd = '$id_instructor') 
  -- AND a.block_time_total NOT IN ('','-','00:00','0:00') 
  AND b.type_enginee='ME'
  AND DATE(date) >='$start_date' AND DATE(date) <='$end_date'");
  foreach($ftd_me as $k=>$v){
    if (strpos($v['block_time_total'], ':') !== false) {
      array_push($ftd_me_act,$v['block_time_total']);
    }  
  }
  $flight_se = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule a 
  LEFT JOIN aircraft_document b
  ON a.aircraft_reg = b.serial_number
  WHERE  a.visibility = '1' AND a.type = '' AND a.visibility_report = '1'  AND (a.pic = '$id_instructor' OR a.2nd = '$id_instructor') AND a.block_time_total NOT IN ('','-','00:00','0:00') AND b.type='SE'
  AND DATE(date_of_flight) >='$start_date' AND DATE(date_of_flight) <='$end_date'");
  foreach($flight_se as $k=>$v){
    if (strpos($v['block_time_total'], ':') !== false) {

      $pic = $v['pic'];
      $pic = $this->mymodel->selectWithQuery("SELECT id, id_number,instructor_status FROM user WHERE id_number  = '$pic'");
      
      $student = $v['2nd'];
      $student = $this->mymodel->selectWithQuery("SELECT id, id_number,instructor_status FROM user WHERE id_number  = '$student'");

      if($pic[0]['instructor_status'] == '1' && $student['instructor_status'] != '1'){
        // echo 'MASUK KE 2ND';
        if($id_instructor==$student[0]['id_number']){
          array_push($flight_se_act,$v['block_time_total']);
        }
      }else if($pic[0]['instructor_status'] != '1'){
        // echo 'MASUK PIC';
        if($id_instructor==$pic[0]['id_number']){
          array_push($flight_se_act,$v['block_time_total']);
        }
      }
     
    }  
  }
  $flight_me = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule a 
  LEFT JOIN aircraft_document b
  ON a.aircraft_reg = b.serial_number
  WHERE  a.visibility = '1' AND  a.type = '' AND a.visibility_report = '1'  AND (a.pic = '$id_instructor'  OR a.2nd = '$id_instructor') AND a.block_time_total NOT IN ('','-','00:00','0:00') AND b.type='ME'
  AND DATE(date_of_flight) >='$start_date' AND DATE(date_of_flight) <='$end_date'");
  foreach($flight_me as $k=>$v){
    if (strpos($v['block_time_total'], ':') !== false) {
      array_push($flight_me_act,$v['block_time_total']);
      }  
  }
  
  
  $ground_se_act = $this->template->sum_time_3($ground_se_act);
  $ground_me_act = $this->template->sum_time_3($ground_me_act);
  $ground_se_me_act[0] = $ground_se_act;
  $ground_se_me_act[1] = $ground_me_act;
  $ground_se_me_act = $this->template->sum_time_3($ground_se_me_act);
  $ftd_se_act = $this->template->sum_time_3($ftd_se_act);
  $ftd_me_act = $this->template->sum_time_3($ftd_me_act);
  $ftd_se_me_act[0] = $ftd_se_act;
  $ftd_se_me_act[1] = $ftd_me_act;
  $ftd_se_me_act = $this->template->sum_time_3($ftd_se_me_act);
  $flight_se_act = $this->template->sum_time_3($flight_se_act);
  $flight_me_act = $this->template->sum_time_3($flight_me_act);
  $flight_se_me_act[0] = $flight_se_act;
  $flight_se_me_act[1] = $flight_me_act;
  $flight_se_me_act = $this->template->sum_time_3($flight_se_me_act);
  
  $r[0] = $ground_se_me_act;
  $r[1] = $ftd_se_me_act;
  $r[2] = $flight_se_me_act;
  $r = $this->template->sum_time_3($r);
?>
<tr>
<td><?=$key+1?>
</td>
<td><?=$val['batch']?>
</td>
<td class="text-left" ><a href="<?=base_url()?>record/student_hours/student_rev/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-left" ><?=$val['nick_name']?>
</td>
<td><?=$val['id_number']?>
</td>
<?php
array_push($ground_se_summary,$ground_se_act);
array_push($ground_me_summary,$ground_me_act);
array_push($ftd_se_summary,$ftd_se_act);
array_push($ftd_me_summary,$ftd_me_act);
array_push($flight_se_summary,$flight_se_act);
array_push($flight_me_summary,$flight_me_act);
?>
<td><?=$ground_se_act?></td>
<td><?=$ground_me_act?></td>
<td><?=$ftd_se_act?></td>
<td><?=$ftd_me_act?></td>
<td><?=$flight_se_act?></td>
<td><?=$flight_me_act?></td>
<td><?=$ground_se_me_act?></td>
<td><?=$ftd_se_me_act?></td>
<td><?=$flight_se_me_act?></td>
<td><?=$r?></td>
</tr>
<?php } 
$ground_se_summary = $this->template->sum_time_3($ground_se_summary);
$ground_me_summary = $this->template->sum_time_3($ground_me_summary);
$ftd_se_summary = $this->template->sum_time_3($ftd_se_summary);
$ftd_me_summary = $this->template->sum_time_3($ftd_me_summary);
$flight_se_summary = $this->template->sum_time_3($flight_se_summary);
$flight_me_summary = $this->template->sum_time_3($flight_me_summary);
$total_ground_summary = array();
$total_ground_summary[0] = $ground_se_summary;
$total_ground_summary[1] = $ground_me_summary;
$total_ground_summary = $this->template->sum_time_3($total_ground_summary);
$total_ftd_summary = array();
$total_ftd_summary[0] = $ftd_se_summary;
$total_ftd_summary[1] = $ftd_me_summary;
$total_ftd_summary = $this->template->sum_time_3($total_ftd_summary);
$total_flight_summary = array();
$total_flight_summary[0] = $flight_se_summary;
$total_flight_summary[1] = $flight_me_summary;
$total_flight_summary = $this->template->sum_time_3($total_flight_summary);
$total_summary = array();
$total_summary[0] = $total_ground_summary;
$total_summary[1] = $total_ftd_summary;
$total_summary[2] = $total_flight_summary;
$total_summary = $this->template->sum_time_3($total_summary);
?>
<tr>
  <th colspan="5">Total</th>
  <th><?=$ground_se_summary?></th>
  <th><?=$ground_me_summary?></th>
  <th><?=$ftd_se_summary?></th>
  <th><?=$ftd_me_summary?></th>
  <th><?=$flight_se_summary?></th>
  <th><?=$flight_me_summary?></th>
  <th><?=$total_ground_summary?></th>
  <th><?=$total_ftd_summary?></th>
  <th><?=$total_flight_summary?></th>
  <th><?=$total_summary?></th>
</tr>
</tbody>

</table>