<?php

$my_date = $_SESSION['start_date'];
$type = 'FLIGHT';
$origin_base = $_SESSION['origin_base'];

if ($_SESSION['origin_base']) {
  $location = $_SESSION['origin_base'];
} else {
  $location = 'ALL BASE';
}


$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$my_date' AND type = '$type' AND base = '$origin_base'
LIMIT 1");

$approval = $approval[0];

$created_at = $approval['created_at'];

if ($_SESSION['origin_base']) {
  $left = '
  <p>' . $location . ', ' . DATE('d M Y', strtotime($approval['prepared_time'])) . '</p>
  <p>Prepared By;
    ';
} else {
  $left = '
  <p style="color:#fff">' . $location . '</p>
  <p>Prepared By;
    ';
}

$right = '<p>I hereby declare that the above report is in accordance
    with PT. BIFA requirements and regulations</p><p>Approved By;</p>
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


$batch = $_SESSION['batch'];
if ($batch) {
  $batch = "  AND a.batch = '$batch' ";
} else {
  $batch = " ";
}


// print_r($data);
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
            <th colspan="15" style="font-size:12px;"><?= $date ?>
            </th>
        </tr>
        <tr class="bg-success">

            <th>NO</th>
            <th>AIRCRAFT<br>REG</th>
            <th>PIC</th>
            <th>2ND</th>
            <th>COURSE</th>
            <th>MISSION</th>
            <th>DEP</th>
            <th>ARR</th>
            <th>ROUTE</th>
            <th>BATCH</th>
            <th>TPM</th>
            <th>ETD<br>UTC</th>
            <th>ETA<br>UTC</th>
            <th>EET</th>
            <th>REMARK</th>

        </tr>

        <?php

    $data_date =  $this->template->date_range($start_date, $end_date);

    $duty_instructor = '';
    $total = array();
    $array_aircraft = array();
    $array_duty_instructor = array();
    $array_base = array();

    $nomor = 0;
    foreach ($data_date as $v => $k) {
      $start_date = $k;
      $end_date = $k;
    ?>



        <?php


      $data = $this->mymodel->selectWithQuery("SELECT * 
FROM daily_flight_schedule a
WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''  AND etd_utc >= '22:00' AND etd_utc <= '24:00'
AND a.type = ''
"
        . $batch
        . $origin_base .

        "
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");

      foreach ($data as $key => $val) {


        $dat = $this->mymodel->selectDataOne('aircraft_document', array('serial_number' => $val['aircraft_reg']));
        $temp = $val['aircraft_reg'];
        $val['aircraft_reg'] = $dat['serial_number'];
        if (empty($val['aircraft_reg'])) {
          $val['aircraft_reg'] = '<a class="text-red"><b>' . $temp . '</b></a>';
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


        $dat = '';
        if (!in_array($val['duty_instructor'], array('', '-'))) {
          $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['duty_instructor']));
        }
        $temp = $val['duty_instructor'];
        $val['duty_instructor'] = $dat['nick_name'];

        if (in_array($val['duty_instructor'], array('', '-'))) {
          $val['duty_instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }


        $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['mission'], 'type_of_training' => 'FLIGHT'));
        $mission = $dat;
        $temp = $val['mission'];
        $val['mission'] = $dat['code_name'] . ' - ' . $dat['name'];

        if (($val['mission']) == ' - ') {
          $val['mission'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

        $temp = $val['course'];
        $val['course'] = $dat['code_name'];

        $nomor++;

        if (!in_array($val['aircraft_reg'], $array_aircraft)) {
          array_push($array_aircraft, $val['aircraft_reg']);
        }

        if (!in_array($val['origin_base'], $array_base)) {
          array_push($array_base, $val['origin_base']);
        }

        if (!in_array($val['duty_instructor'], $array_duty_instructor)) {
          array_push($array_duty_instructor, $val['duty_instructor']);
        }

        if ($val['duty_instructor']) {
          $duty_instructor = $val['duty_instructor'];
        }
        if (strpos($val['eet'], ':') !== false) {
          array_push($total, $val['eet']);
        }

        $val['pic'] = $val['pic'];

      ?>

        <tr>
            <td style="width:3%"><?= $nomor ?></td>

            <td style="width:5%"><?= $val['aircraft_reg'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['pic'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['2nd'] ?></td>
            <td style="width:5%"><?= $val['course'] ?></td>

            <td class="text-left" style="width:10%"><?= $val['mission'] ?></td>

            <td style="width:5%"><?= $val['dep'] ?></td>
            <td style="width:5%"><?= $val['arr'] ?></td>

            <td class="text-left" style="width:15%"><?= $val['rute'] ?></td>
            <td style="width:5%"><?= $val['batch'] ?></td>
            <td style="width:5%"><?= $val['tpm'] ?></td>
            <td style="width:5%"><?= $val['etd_utc'] ?></td>
            <td style="width:5%"><?= $val['eta_utc'] ?></td>
            <td style="width:5%"><?= $val['eet'] ?></td>
            <td class="text-left" style="width:12%"><?= $val['remark'] ?></td>
        </tr>
        <?php } ?>


        <?php


      $data = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a
WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''  AND etd_utc >= '00:00' AND etd_utc <= '21:59'
AND a.type = ''
"
        . $batch
        . $origin_base .

        "
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");

      foreach ($data as $key => $val) {
        $nomor++;


        $dat = $this->mymodel->selectDataOne('aircraft_document', array('serial_number' => $val['aircraft_reg']));
        $temp = $val['aircraft_reg'];
        $val['aircraft_reg'] = $dat['serial_number'];
        if (empty($val['aircraft_reg'])) {
          $val['aircraft_reg'] = '<a class="text-red"><b>' . $temp . '</b></a>';
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


        $dat = '';
        if (!in_array($val['duty_instructor'], array('', '-'))) {
          $dat = $this->mymodel->selectDataOne('user', array('id_number' => $val['duty_instructor']));
        }
        $temp = $val['duty_instructor'];
        $val['duty_instructor'] = $dat['nick_name'];

        if (in_array($val['duty_instructor'], array('', '-'))) {
          $val['duty_instructor'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }


        $dat = $this->mymodel->selectDataOne('syllabus_mission', array('code' => $val['mission'], 'type_of_training' => 'FLIGHT'));
        $mission = $dat;
        $temp = $val['mission'];
        $val['mission'] = $dat['code_name'] . ' - ' . $dat['name'];

        if (($val['mission']) == ' - ') {
          $val['mission'] = '<a class="text-red"><b>' . $temp . '</b></a>';
        }

        $dat = $this->mymodel->selectDataOne('syllabus_course', array('code' => $val['course']));

        $temp = $val['course'];
        $val['course'] = $dat['code_name'];

        if (!in_array($val['aircraft_reg'], $array_aircraft)) {
          array_push($array_aircraft, $val['aircraft_reg']);
        }

        if (!in_array($val['origin_base'], $array_base)) {
          array_push($array_base, $val['origin_base']);
        }

        if (!in_array($val['duty_instructor'], $array_duty_instructor)) {
          array_push($array_duty_instructor, $val['duty_instructor']);
        }

        if ($val['duty_instructor']) {
          $duty_instructor = $val['duty_instructor'];
        }
        if (strpos($val['eet'], ':') !== false) {
          array_push($total, $val['eet']);
        }

        $val['pic'] = $val['pic'];

      ?>

        <tr>
            <td style="width:3%"><?= $nomor ?></td>

            <td style="width:5%"><?= $val['aircraft_reg'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['pic'] ?></td>
            <td class="text-left" style="width:10%"><?= $val['2nd'] ?></td>
            <td style="width:5%"><?= $val['course'] ?></td>

            <td class="text-left" style="width:10%"><?= $val['mission'] ?></td>

            <td style="width:5%"><?= $val['dep'] ?></td>
            <td style="width:5%"><?= $val['arr'] ?></td>

            <td class="text-left" style="width:15%"><?= $val['rute'] ?></td>
            <td style="width:5%"><?= $val['batch'] ?></td>
            <td style="width:5%"><?= $val['tpm'] ?></td>
            <td style="width:5%"><?= $val['etd_utc'] ?></td>
            <td style="width:5%"><?= $val['eta_utc'] ?></td>
            <td style="width:5%"><?= $val['eet'] ?></td>
            <td class="text-left" style="width:12%"><?= $val['remark'] ?></td>
        </tr>
        <?php } ?>
        <!-- <tr>
  <td colspan="14" style="padding:0.1px;background:#000;" ></td>
</tr> -->
        <?php

    }

    $total_plan = $this->template->sum_time($total);
    $total_aircraft = count($array_aircraft);
    $total_flight = $nomor;
    ?>



        <?php
    $text = "";
    foreach ($array_duty_instructor as $key => $val) {
      if ($val) {
        $text .= '' . $val . ', ';
      }
    }
    $text = substr($text, 0, -2);


    ?>


    </table>
    <br><br>
    <table>
        <tr>
            <th class="text-left no-border">
                <p>DUTY INSTRUCTOR</p>
            </th>
            <th class="text-left no-border">
                <p>:</p>
            </th>
            <th class="text-left no-border" colspan="3">
                <p><?= $text ?></p>
            </th>
        </tr>
        <tr>
            <th class="text-left no-border" style="width:15%">

                <p>TOTAL FLIGHT SCHEDULE</p>

                <p>TOTAL AIRCRAFT IN USE </p>

                <p>TOTAL PLAN</p>

            </th>
            <th class="no-border" style="width:1%">
                <p>:</p>
                <p>:</p>
                <p>:</p>
            </th>
            <th class="text-left no-border" style="width:15%">
                <p><?= $total_flight ?></p>
                <p><?= $total_aircraft ?></p>
                <p><?= $total_plan ?></p>
            </th>
            <td class="no-border" style="width:15%;">

                <?php


        if ($approval['base']) {
        } else {
          foreach ($array_base as $key => $val) {
            $base = $base . $val . ', ';
          }

          $base = substr($base, 0, -2);
          $left = $left . '<br><br><br>' . $base;
          $right = $right . '<br><br><br>' . $base;
        }
        ?>

                <?= $left ?>
            </td>
            <td class="no-border" style="width:30%;vertical-align:top">
                <?= $right ?>
            </td>
        </tr>
    </table>

</body>