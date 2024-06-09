<?php

$my_date = $_SESSION['start_date'];
$type = 'FTD REPORT';
$origin_base = $_SESSION['origin_base'];

if ($_SESSION['origin_base']) {
  $location = $_SESSION['origin_base'];
} else {
  $location = 'ALL BASE';
}
$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$my_date' AND type = '$type' AND base = '$origin_base'
LIMIT 1");

$approval = $approval[0];
$left = '
  <p>' . $location . ', ' . DATE('d M Y', strtotime($approval['prepared_time'])) . '</p>
  <p>Prepared By;
    ';
$right = '<p style="color:#fff;">KARYA STUDIO</p><p>Acknowledged By;</p>
';

$dat = $this->mymodel->selectDataOne('user', array('id' => $approval['prepared_by']));
$role = $this->mymodel->selectDataOne('role', array('id' => $dat['role']));
$file_prepared_by = $this->mymodel->selectDataOne('file', array('table' => 'file_signature', 'table_id' => $dat['id']));
$base_dat = $this->mymodel->selectDataOne('base_airport_document', array('id' => $dat['base']));
$prepared_by = '<u>' . $dat['full_name'] . '</u><br>' . $role['role'] . ' ' . $base_dat['base'];


$dat = $this->mymodel->selectDataOne('user', array('id' => $approval['approved_by']));
$role = $this->mymodel->selectDataOne('role', array('id' => $dat['role']));
$file_approved_by = $this->mymodel->selectDataOne('file', array('table' => 'file_signature', 'table_id' => $dat['id']));
$base_dat = $this->mymodel->selectDataOne('base_airport_document', array('id' => $dat['base']));
$approved_by = '<u>' . $dat['full_name'] . '</u><br>' . $role['role'] . ' ' . $base_dat['base'];


if ($approval['approval_status'] == 'APPROVED') {
  $right = $right . '<br>
  <img src="' . base_url() . 'webfile/' . $file_approved_by['name'] . '" style="height:40px;">
  <br>' . $approved_by;
} else {
  $right = $right . '<br><br><br><br><br>' . $approved_by;
}



if ($file_prepared_by['name']) {
  $left = $left . '<br>
  <img src="' . base_url() . 'webfile/' . $file_prepared_by['name'] . '" style="height:40px;">
  <br>' . $prepared_by;
} else {
  $left = $left . '<br><br><br><br><br>' . $prepared_by;
}




$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$origin_base = $_SESSION['origin_base'];

if (empty($start_date)) {
  $_SESSION['start_date'] = DATE('Y-m-d');
  $_SESSION['end_date'] = DATE('Y-m-d');
  $start_date = $_SESSION['start_date'];
  $end_date = $_SESSION['end_date'];
}

if (empty($end_date)) {
  $_SESSION['start_date'] = DATE('Y-m-d');
  $_SESSION['end_date'] = DATE('Y-m-d');
  $start_date = $_SESSION['start_date'];
  $end_date = $_SESSION['end_date'];
}

if ($origin_base) {
  $origin_base = "  AND a.origin_base = '$origin_base' ";
} else {
  $origin_base = " ";
}

$origin_base = " ";


$batch = $_SESSION['batch'];
if ($batch) {
  $batch = "  AND a.batch = '$batch' ";
} else {
  $batch = " ";
}

?>
<style>
body {
    /* margin-top:-20px; */
    margin: -30px;
    margin-top: 85px;
}

tr,
th,
td {
    border: 1px #000 solid;
    padding: 5px;
    font-size: 9px;
    text-align: center;
}

th {
    text-align: center;
}

.text-left {
    text-align: left;
}

.text-center {
    text-align: center;
}

table {
    width: 100%;
    border-collapse: collapse;
}

.no-border {
    border-style: none;
    padding-left: 0px;
    text-align: left:
}

p {
    margin: 3px 0px;
}

.bg-success {
    background: #bfbfbf;
}
</style>
<title>DAILY FLIGHT SCHEDULE</title>

<body>
    <table class="table table-bordered table-striped" id="" style="width:100%">

        <tr>
            <th colspan="16" style="font-size:12px;"><?= $date ?>
            </th>
        </tr>

        <tr class="bg-success">
            <th rowspan="2">NUM</th>

            <th rowspan="2">FTD MODEL</th>
            <th rowspan="2">INSTRUCTOR</th>
            <th rowspan="2">STUDENT</th>
            <th rowspan="2">BATCH</th>
            <th rowspan="2">TPM</th>
            <th rowspan="2">COURSE</th>
            <th rowspan="2">MISSION</th>

            <th colspan="3">SCHEDULED TIME (UTC)</th>
            <th colspan="3">BLOCK TIME (UTC)</th>
            <th rowspan="2">REMARK</th>
            <th rowspan="2">IRREG<br>CODE</th>
        </tr>
        <tr class="bg-success">
            <th>ETD</th>
            <th>ETA</th>
            <th>EET</th>
            <th>ATD</th>
            <th>ATA</th>
            <th>TOTAL</th>
        </tr>


        <?php
    $duty_instructor = '';
    $total = array();
    $total2 = array();
    $array_model = array();

    $start_date = $_SESSION['start_date'];
    $end_date = $_SESSION['end_date'];

    $nomor = 0;
    $data_date =  $this->template->date_range($start_date, $end_date);

    foreach ($data_date as $v => $k) {
      $start_date = $k;
      $end_date = $k;

    ?>

        <?php
      $data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_ftd_schedule a

WHERE  a.visibility = '1' AND a.visibility_report = '1'
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND etd_utc >= '22:00' AND etd_utc <= '24:00'
  "
        . $batch
        . $origin_base .
        "
ORDER BY a.date ASC, a.etd_utc ASC
");
      ?>

        <?php

      foreach ($data as $key => $val) {

        $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document', array('code' => $val['ftd_model']));

        $temp = $val['ftd_model'];
        $val['ftd_model'] = $dat['model'] . ' ' . $dat['serial_number'] . ' ' . $dat['type_enginee'];

        if (empty($dat)) {
          $val['ftd_model'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }


        $dat = '';
        if (!in_array($val['pic'], array('', '-'))) {
          $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['pic']));
        }
        $temp = $val['pic'];
        $val['pic'] = $dat['nick_name'];

        if (in_array($val['pic'], array('', '-'))) {
          $val['pic'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = '';
        if (!in_array($val['pic'], array('', '-'))) {
          $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));
        }
        $temp = $val['2nd'];
        $val['2nd'] = $dat['nick_name'];

        if (in_array($val['2nd'], array('', '-'))) {
          $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }


        $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
        $temp = $val['batch'];
        $val['batch'] = $dat['batch'];
        if (empty($val['batch'])) {
          $val['batch'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $this->db->select('code_name');
        $dat = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $val['tpm']));
        $temp = $val['tpm'];
        $val['tpm'] = $dat['code_name'];
        if (empty($val['tpm'])) {
          $val['tpm'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['mission'], 'type_of_training' => 'FTD'));
        $mission = $dat;
        $temp = $val['mission'];
        $val['mission'] = $dat['code_name'] . ' - ' . $dat['name'];

        if (($val['mission']) == ' - ') {
          $val['mission'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

        $temp = $val['course'];
        $val['course'] = $dat['code_name'];

        if (($val['course']) == ' - ') {
          $val['course'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $nomor++;
        if ($val['remark_report']) {
          $total_irregularities = $total_irregularities + 1;
        }

        if (strpos($val['block_time_atd'], ':') !== false) {
          $total_movement = $total_movement + 1;
        }

        if (!in_array($val['ftd_model'], $array_model)) {
          array_push($array_model, $val['ftd_model']);
        }

        if (strpos($val['block_time_total'], ':') !== false) {
          array_push($total2, $val['block_time_total']);
        }
        if ($val['duty_instructor']) {
          $duty_instructor = $val['duty_instructor'];
        }
        if (strpos($val['eet_utc'], ':') !== false) {
          array_push($total, $val['eet_utc']);
        }

        $val['pic'] = $val['pic'];

      ?>

        <tr>
            <td style="width:3%"><?= $nomor ?>
            </td>
            <td class="text-left" style="width:7%"><?= $val['ftd_model'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['pic'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['2nd'] ?></td>
            <td style="width:5%"><?= $val['batch'] ?></td>
            <td style="width:5%"><?= $val['tpm'] ?></td>
            <td class="text-left" style="width:5%"><?= $val['course'] ?></td>

            <td class="text-left" style="width:17%"><?= $val['mission'] ?></td>
            <td style="width:4%"><?= $val['eet_utc'] ?></td>
            <td style="width:4%"><?= $val['etd_utc'] ?></td>
            <td style="width:4%"><?= $val['eta'] ?></td>
            <td style="width:4%"><?= $val['block_time_atd'] ?></td>
            <td style="width:4%"><?= $val['block_time_ata'] ?></td>
            <td style="width:4%"><?= $val['block_time_total'] ?></td>
            <td class="text-left"><?= $val['remark'] ?></td>
            <td style="width:4%"><?= $val['remark_report'] ?></td>
        </tr>
        <?php } ?>

        <?php
      $data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_ftd_schedule a

WHERE  a.visibility = '1' AND a.visibility_report = '1'
AND DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND etd_utc >= '00:00' AND etd_utc <= '21:59'
  "
        . $batch
        . $origin_base .
        "
ORDER BY a.date ASC, a.etd_utc ASC
");
      ?>

        <?php

      foreach ($data as $key => $val) {

        $dat = $this->mymodel->selectDataOne('synthetic_training_devices_document', array('code' => $val['ftd_model']));

        $temp = $val['ftd_model'];
        $val['ftd_model'] = $dat['model'] . ' ' . $dat['serial_number'] . ' ' . $dat['type_enginee'];

        if (empty($dat)) {
          $val['ftd_model'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }


        $dat = '';
        if (!in_array($val['pic'], array('', '-'))) {
          $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['pic']));
        }
        $temp = $val['pic'];
        $val['pic'] = $dat['nick_name'];

        if (in_array($val['pic'], array('', '-'))) {
          $val['pic'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = '';
        if (!in_array($val['pic'], array('', '-'))) {
          $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['2nd']));
        }
        $temp = $val['2nd'];
        $val['2nd'] = $dat['nick_name'];

        if (in_array($val['2nd'], array('', '-'))) {
          $val['2nd'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }


        $dat = $this->mymodel->selectDataOne('batch', array('code' => $val['batch']));
        $temp = $val['batch'];
        $val['batch'] = $dat['batch'];
        if (empty($val['batch'])) {
          $val['batch'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $this->db->select('code_name');
        $dat = $this->mymodel->selectDataOne('syllabus_curriculum', array('code' => $val['tpm']));
        $temp = $val['tpm'];
        $val['tpm'] = $dat['code_name'];
        if (empty($val['tpm'])) {
          $val['tpm'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['mission'], 'type_of_training' => 'FTD'));
        $mission = $dat;
        $temp = $val['mission'];
        $val['mission'] = $dat['code_name'] . ' - ' . $dat['name'];

        if (($val['mission']) == ' - ') {
          $val['mission'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

        $temp = $val['course'];
        $val['course'] = $dat['code_name'];

        if (($val['course']) == ' - ') {
          $val['course'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $nomor++;
        if ($val['remark_report']) {
          $total_irregularities = $total_irregularities + 1;
        }

        if (strpos($val['block_time_atd'], ':') !== false) {
          $total_movement = $total_movement + 1;
        }

        if (!in_array($val['ftd_model'], $array_model)) {
          array_push($array_model, $val['ftd_model']);
        }

        if (strpos($val['block_time_total'], ':') !== false) {
          array_push($total2, $val['block_time_total']);
        }
        if ($val['duty_instructor']) {
          $duty_instructor = $val['duty_instructor'];
        }
        if (strpos($val['eet_utc'], ':') !== false) {
          array_push($total, $val['eet_utc']);
        }

        $val['pic'] = $val['pic'];

      ?>

        <tr>
            <td style="width:3%"><?= $nomor ?>
            </td>
            <td class="text-left" style="width:7%"><?= $val['ftd_model'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['pic'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['2nd'] ?></td>
            <td style="width:5%"><?= $val['batch'] ?></td>
            <td style="width:5%"><?= $val['tpm'] ?></td>
            <td class="text-left" style="width:5%"><?= $val['course'] ?></td>

            <td class="text-left" style="width:17%"><?= $val['mission'] ?></td>
            <td style="width:4%"><?= $val['eet_utc'] ?></td>
            <td style="width:4%"><?= $val['etd_utc'] ?></td>
            <td style="width:4%"><?= $val['eta'] ?></td>
            <td style="width:4%"><?= $val['block_time_atd'] ?></td>
            <td style="width:4%"><?= $val['block_time_ata'] ?></td>
            <td style="width:4%"><?= $val['block_time_total'] ?></td>
            <td class="text-left"><?= $val['remark'] ?></td>
            <td style="width:4%"><?= $val['remark_report'] ?></td>
        </tr>
        <?php } ?>



        <?php }
    // print_r($array_model);
    $total_plan = $this->template->sum_time($total);
    $total_block_time = $this->template->sum_time($total2);
    $total_ftd = count($array_model);
    $total_flight = $nomor;
    ?>


    </table>
    <br><br>
    <table>
        <tr>
            <th class="text-left no-border" style="width:15%">

                <p>TOTAL FTD SCHEDULE</p>

                <p>TOTAL FTD ACTIVITY </p>


                <p>TOTAL IRREGULARITIES</p>

            </th>
            <th class="no-border" style="width:1%">
                <p>:</p>
                <p>:</p>
                <p>:</p>
            </th>
            <th class="text-left no-border" style="width:15%">
                <p><?= $total_flight ?></p>
                <p><?= intval($total_movement) ?></p>
                <p><?= intval($total_irregularities) ?></p>
            </th>

            <th class="text-left no-border" style="width:15%;;">

                <p>TOTAL PLAN</p>

                <p>TOTAL BLOCK TIME</p>
                <p>ACTUAL vs PLAN</p>

            </th>
            <th class="no-border" style="width:1%;">
                <p>:</p>
                <p>:</p>
                <p>:</p>
            </th>
            <th class="text-left no-border" style="width:15%;">
                <p><?= $total_plan ?></p>
                <p><?= $total_block_time ?></p>
                <?php
        $total_plan = (explode(":", $total_plan));
        $total_block_time = (explode(":", $total_block_time));

        $jam_plan = $total_plan[0] * 60;
        $jam_plan = $jam_plan + $total_plan[1];

        $jam_block_time = $total_block_time[0] * 60;
        $jam_block_time = $jam_block_time + $total_block_time[1];

        $persentase = number_format(($jam_block_time / $jam_plan) * 100, 1) . ' %';

        ?>
                <p><?= $persentase ?></p>
            </th>
            <td class="no-border" style="width:25%;;">
                <?php
        $user = $this->mymodel->selectDataOne('user', array('id' => $_SESSION['id']));
        $role = $this->mymodel->selectDataOne('role', array('id' => $user['role_id']));
        $base = $this->mymodel->selectDataOne('base_airport_document', array('id' => $user['base']));
        ?>

                <?= $left ?>
            </td>
            <td class="no-border" style="width:25%;vertical-align:top">
                <?= $right ?>
            </td>
        </tr>
    </table>
</body>