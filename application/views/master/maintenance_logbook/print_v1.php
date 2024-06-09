<style>
  body,html, *{
  padding:0px;
  margin:0px;
  font-family: Tahoma, Geneva, sans-serif;
}
table{
  border-collapse: collapse !important;
  margin-bottom:15px;
  width:100%;
}
.no-border{
  border:#fff solid 1px;
}
p,th,td,tr{
    font-family: Tahoma, Geneva, sans-serif;
   }
   h1{
     font-weight:700;
     font-size:25px;
   }
   
		table tr td {
			vertical-align: top;
      
		}
	
    .text-center{
      text-align:center;
    }
    .border-full{
      border:1px #000 solid;
      padding:5px;
    }
    .border-full2{
      /* border:1px #000 solid; */
      padding:5px;
      /* padding-top:5px; */
      /* padding-bottom:5px; */
    }
    
    td,th{
      padding:15px;
    }
    .text-right{
      text-align:right;
    }.text-left{
      text-align:left;
    }
    p,tr,td,th,div{
      font-size:14px;
    }
    th{
      text-align:center;
      padding:5px;
    }
    td{
      padding:5px;
    }

    #left {
    width: 1%;
    /* background: lightblue; */
    display: inline-block;
    float:left;
}
#right {
    width: 60%;
    /* background: orange; */
    display: inline-block;
    float:left;
}
#right2 {
    width: 33%;
    /* background: orange; */
    display: inline-block;
    float:left;
}
td,th{
  border:1px #000 solid;
}

@media print and (color) {
   * {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
   }
}
    
    body{
      margin:15px;
    }
    td{
      text-align:center;
    }
</style>
<head>
  <title>Scheduler And Reporting Bali International Flight Academy System</title>
<link href="<?=base_url()?>assets/logo.jpg" rel=icon type=image/png>
</head>
<body>
  <table>
    <tr>
      <td colspan="5" class="text-center no-border" style="width:200px;vertical-align:middle;">
        <img src="<?=base_url()?>assets/logo.png" alt="" style="width:150px;">
        <h3 style="margin-top:10px;">Bali Widya Dirgantara</h3>
      </td>
      <td colspan="10" class="text-center no-border" style="vertical-align:middle;">
        <h1>AIRCRAFT AND JOURNEY LOGBOOK</h1>
        <h3 style="margin-top:10px;">AIRCRAFT REGISTRATION ......................</h3>
      </td>
      <td colspan="3" class="text-left no-border" style="width:200px;vertical-align:middle;">
        <p><b>LOG SHEET NO ........................</b></p>
        <p style="margin-top:10px;"><b>DATE .......................................</b></p>
      </td>
    </tr>
    <tr>
      <td colspan="18" style="border-left:0px #FFF solid;border-right:0px #FFF solid"></td>
    </tr>
    <tr>
      <td rowspan="2" colspan="1" style="width:3%!important;vertical-align:middle">
        NO
      </td>
      <td rowspan="2" colspan="3" style="width:10%;vertical-align:middle">
        CREW NAME
      </td>
      <td rowspan="2" style="width:5%;vertical-align:middle">
        TYPE OF FLIGHT
      </td>
      <td rowspan="1" colspan="4">
        FLIGHT
      </td>
      <td rowspan="1" colspan="2">
        BLOCK TIME
      </td>
      <td rowspan="1" colspan="2">
        TOTAL TIME
      </td>
      <td rowspan="2" style="width:5%;vertical-align:middle">
        LDG
      </td>
      <td rowspan="7" colspan="4" class="text-left">
        <center>
        <b>MAINTENANCE RELEASE</b>
        </center>
        <br>
        <?php

$data['mr_created_at_date'] = '......................';
$data['mr_created_at_time'] = '......................';
$data['mr_ac_ttis'] = '......................';
$data['mr_ac_ttis_until'] = '......................';
$data['mr_day_until'] = '......................';
$data['mr_amel_no'] = '......................';
$data['mr_created_by'] = '......................';
$data['di_created_at_date'] = '......................';
$data['di_created_at_time'] = '......................';
$data['di_created_by'] = '......................';
$data['di_amel_no'] = '......................';
$data['aircraft_reg'] = '......................';

        
        
        

        ?>

        I hereby certify that aircraft <?=$data['aircraft_reg']?> has been maintained and inspected in accordance with the current Approved Aircraft Inspection Program and is safe for flight.
        <br>
        Sign/Name/Stemp <?=$data['mr_created_by']?>
        <br>
        AMEL No. <?=$data['mr_amel_no']?> Date <?=$data['mr_created_at_date']?>
        <br>
        Time <?=$data['mr_created_at_time']?> A/C TTIS <?=$data['mr_ac_ttis']?>
        <br>
        Subject to CASR, this Maintenance Release is valid until <?=$data['mr_ac_ttis_until']?> A/C TTIS or for <?=$data['mr_day_until']?> days whichever come first.

      </td>
    </tr>

    <tr>
      <td style="width:5%">
        FROM
      </td>
      <td style="width:5%">
        TO
      </td>
      <td style="width:5%">
        ATD
      </td>
      <td style="width:5%">
        ATA
      </td>
      <td style="width:5%">
        OFF
      </td>
      <td style="width:5%">
        ON
      </td>
      <td style="width:5%">
        BLOCK
      </td>
      <td style="width:5%">
        I.F
      </td>
    </tr>
    <?php 


    $start_date = $data['date'];
    $end_date = $data['date'];
    $aircraft_reg = $data['aircraft_reg'];
    $air = " AND a.aircraft_reg = '$aircraft_reg' ";

    $arr_flight = array();

    $data_report = $this->mymodel->selectWithQuery("SELECT *
    FROM daily_flight_schedule a
    WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND etd_utc >= '22:00' AND etd_utc <= '24:00' AND remark_report IN ('','-')
    "
    .$keyword.$keyword_arr
    .$batch.$air
    .$origin_base
    .$base.$qry_irreg.
    "
    GROUP BY a.id
    ORDER BY
    a.date_of_flight ASC, a.etd_utc ASC");


    $total = array();
    $total2 = array();
    $total3 = array();
    $total_if = array();

    foreach($data_report as $key=>$val){

        

        $dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
        $temp = $val['aircraft_reg'];
        $val['aircraft_reg'] = $dat['serial_number'];
        if(empty($val['aircraft_reg'])){
        $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
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
        if(empty($val['tpm'])){
        $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = '';
        if(!in_array($val['pic'],array('','-'))){
        $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
        }
        $temp = $val['pic'];
        $val['pic'] = $dat['nick_name'];
        
        if(in_array($val['pic'],array('','-'))){
        $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = '';
        if(!in_array($val['pic'],array('','-'))){
        $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));
        }
        $temp = $val['2nd'];
        $val['2nd'] = $dat['nick_name'];
        
        if(in_array($val['2nd'],array('','-'))){
        $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = '';
        if(!in_array($val['duty_instructor'],array('','-'))){
        $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));
        }
        $temp = $val['duty_instructor'];
        $val['duty_instructor'] = $dat['nick_name'];
        
        if(in_array($val['duty_instructor'],array('','-'))){
        $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        
        $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));
        $mission = $dat;
        $temp = $val['mission'];
        $val['mission'] = $dat['code_name'];
        
        if(($val['mission']) == ' - '){
        $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));
        
        $temp = $val['course'];
        $val['course'] = $dat['code_name'];
        
        if(($val['course']) == ' - '){
        $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        
        
        $total_ldg += $val['ldg'];
        $nomor++;
        if(!in_array($val['aircraft_reg'],$array_aircraft)){
        array_push($array_aircraft,$val['aircraft_reg']);
        }
        
        if(!in_array($val['duty_instructor'],$array_duty_instructor)){
        array_push($array_duty_instructor,$val['duty_instructor']);
        }
        
        if($val['duty_instructor']){
        $duty_instructor = $val['duty_instructor'];
        }
        
        if(!in_array($val['remark_report'],array('','-'))){
        $total_irregularities = $total_irregularities + 1;
        }
        if (strpos($val['block_time_start'], ':') !== false) {
        $total_movement = $total_movement + 1;
        }
        if (strpos($val['eet'], ':') !== false) {
        array_push($total,$val['eet']);
        }
        
        
        
        if (strpos($val['block_time_total'], ':') !== false) {
        array_push($total2,$val['block_time_total']);
        }
        
        if (strpos($val['flight_time_total'], ':') !== false) {
        array_push($total3,$val['flight_time_total']);
        }
        
        if (strpos($val['if'], ':') !== false) {
        array_push($total_if,$val['if']);
        }

        $arr_flight[] = $val;
    }

    $data_report = $this->mymodel->selectWithQuery("SELECT *
    FROM daily_flight_schedule a
    WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND etd_utc >= '00:00' AND etd_utc <= '21:59' AND remark_report IN ('','-')
    "
    .$keyword.$keyword_arr
    .$batch.$air
    .$origin_base
    .$base.$qry_irreg.
    "
    GROUP BY a.id
    ORDER BY
    a.date_of_flight ASC, a.etd_utc ASC");

    foreach($data_report as $key=>$val){


      $dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
      $temp = $val['aircraft_reg'];
      $val['aircraft_reg'] = $dat['serial_number'];
      if(empty($val['aircraft_reg'])){
      $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
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
      if(empty($val['tpm'])){
      $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = '';
      if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
      }
      $temp = $val['pic'];
      $val['pic'] = $dat['nick_name'];
      
      if(in_array($val['pic'],array('','-'))){
      $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = '';
      if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));
      }
      $temp = $val['2nd'];
      $val['2nd'] = $dat['nick_name'];
      
      if(in_array($val['2nd'],array('','-'))){
      $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = '';
      if(!in_array($val['duty_instructor'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));
      }
      $temp = $val['duty_instructor'];
      $val['duty_instructor'] = $dat['nick_name'];
      
      if(in_array($val['duty_instructor'],array('','-'))){
      $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      
      $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));
      $mission = $dat;
      $temp = $val['mission'];
      $val['mission'] = $dat['code_name'];
      
      if(($val['mission']) == ' - '){
      $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));
      
      $temp = $val['course'];
      $val['course'] = $dat['code_name'];
      
      if(($val['course']) == ' - '){
      $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      
      
      $total_ldg += $val['ldg'];
      $nomor++;
      if(!in_array($val['aircraft_reg'],$array_aircraft)){
      array_push($array_aircraft,$val['aircraft_reg']);
      }
      
      if(!in_array($val['duty_instructor'],$array_duty_instructor)){
      array_push($array_duty_instructor,$val['duty_instructor']);
      }
      
      if($val['duty_instructor']){
      $duty_instructor = $val['duty_instructor'];
      }
      
      if(!in_array($val['remark_report'],array('','-'))){
      $total_irregularities = $total_irregularities + 1;
      }
      if (strpos($val['block_time_start'], ':') !== false) {
      $total_movement = $total_movement + 1;
      }
      if (strpos($val['eet'], ':') !== false) {
      array_push($total,$val['eet']);
      }
      
      
      
      if (strpos($val['block_time_total'], ':') !== false) {
      array_push($total2,$val['block_time_total']);
      }
      
      if (strpos($val['flight_time_total'], ':') !== false) {
      array_push($total3,$val['flight_time_total']);
      }

      if (strpos($val['if'], ':') !== false) {
      array_push($total_if,$val['if']);
      }

      $arr_flight[] = $val;
  }

    

    $total_flight = count($arr_flight);
    if($total_flight <= 10){
      $limit = 10;
      $di_rowspan = 6;
    }else{
      $di_rowspan = $total_flight - 4;
      $limit = $total_flight;
    }
    $nomor = 0;
    for($i=0;$i<$limit;$i++){
    $nomor++;
    if($arr_flight[$i]['2nd']){
      $arr_flight[$i]['pic'] .= ' - '.$arr_flight[$i]['2nd']; 
    }
    ?>
    <tr>
      <td>
        <?=$nomor;?>
      </td>
      <td colspan="3" class="text-left">
      <?=$arr_flight[$i]['pic']?> 
      </td>
      <td>
        <?=$arr_flight[$i]['course']?> <?=$arr_flight[$i]['mission']?>
      </td>
      <td>
        <?=$arr_flight[$i]['dep']?>
      </td>
      <td>
        <?=$arr_flight[$i]['arr']?>
      </td>
      <td>
        <?=$arr_flight[$i]['flight_time_take_off']?>
      </td>
      <td>
        <?=$arr_flight[$i]['flight_time_landing']?>
      </td>
      <td>
        <?=$arr_flight[$i]['block_time_start']?>
      </td>
      <td>
        <?=$arr_flight[$i]['block_time_stop']?>
      </td>
      <td>
        <?=$arr_flight[$i]['block_time_total']?>
      </td>
      <td>
        <?=$arr_flight[$i]['if']?>
      </td>
      <td>
        <?=$arr_flight[$i]['ldg']?>
      </td>
      
      <?php if($i==5){ ?>
        <td rowspan="<?=$di_rowspan?>" colspan="4" class="text-left">
        <center>
        <b>DAILY INSPECTION</b>
        </center>
        <br>
        Date <?=$data['di_created_at_date']?> Time <?=$data['di_created_at_time']?>
        <br>
        Sign/Name/Stemp <?=$data['di_created_by']?>
        <br>
        AMEL No. <?=$data['di_amel_no']?>
        </td>
      <?php }?>
    </tr>

    <?php } 
    $total =  $this->template->sum_time($total);
    $total2 =  $this->template->sum_time($total2);
    $total_if =  $this->template->sum_time($total_if);

    // print_r($array_model);
    $total_plan = $total;
    $total_block_time = $total2;
    $total_ftd = count($array_model);
    $total_flight = $nomor;

    ?>


    <tr>
      <td class="text-left" colspan="10">
        OBSERVATION DURING FLIGHT
      </td>
      <td>
        TOTAL
      </td>
      <td>
        <?=$total_block_time?>
      </td>
      <td>
        <?=$total_if?>
      </td>
      <td>
      <?=$total_ldg?>
      </td>
    </tr>



    <tr>
      <td colspan="14" rowspan="1" class="text-left" style="border-right:0px #FFF solid!important">
        <?=$data['observation']?>
      </td>
      <td colspan="4" style="border-left:0px #FFF solid!important"><br><br><br></td>
    </tr>

    <tr>
      <td colspan="4" rowspan="2" style="vertical-align:middle">
        TIME
      </td>
      <td colspan="2" rowspan="2" style="vertical-align:middle">
        A/C HOURS TTIS
      </td>
      <td colspan="2" rowspan="2" style="vertical-align:middle">
        NO 1 ENGINE TSO
      </td>
      <td colspan="2" rowspan="2" style="vertical-align:middle">
        NO 2 ENGINE TSO
      </td>
      <td colspan="2" rowspan="2" style="vertical-align:middle">
        NO 1 PROP TSO
      </td>
      <td colspan="2" rowspan="2" style="vertical-align:middle">
        NO 2 PROP TSO
      </td>
      <td colspan="4" rowspan="1" style="vertical-align:middle" >
        <b>
          NEXT INSPECTION
        </b>
      </td>
    </tr>

    <tr>
      <td style="width:5%">
        TYPE
      </td>
      <td colspan="2" style="width:15%">
        AT A/C TTIS
      </td>
      <td style="width:5%">
        REMAINING
      </td>
    </tr>

    <tr>
      <td colspan="4" class="text-left" style="width:10%">
        BROUGHT FWD
      </td>
      <td colspan="2">
        
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td rowspan="3" style="vertical-align:middle">
      </td>
      <td rowspan="3" colspan="2" style="vertical-align:middle">
      </td>
      <td rowspan="3" style="vertical-align:middle">
      </td>
    </tr>

    

    <tr>
      <td colspan="4" class="text-left">
        TODA
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
    </tr>


    <tr>
      <td colspan="4" class="text-left">
        TOTAL
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
      <td colspan="2">
      </td>
    </tr>

    <tr>
      <td colspan="6">
        FUEL
      </td>
      <td rowspan="2" colspan="5" style="vertical-align:middle">
        DISCREPANCIES
      </td>
      <td rowspan="2" colspan="1" style="width:5%;vertical-align:middle">
        SIGN
      </td>
      <td rowspan="2" colspan="5" style="vertical-align:middle">
        RECTIFATION
      </td>
      <td rowspan="2" colspan="1" style="width:5%;vertical-align:middle">
        SIGN
      </td>
    </tr>

    <tr>
      <td colspan="2">
        STN
      </td>
      <td colspan="2">
        SERVICE
      </td>
      <td>
        ONBOARD
      </td>
      <td style="width:5%">
        SIGN
      </td>
    </tr>


    <?php 

    $text_discrepancies = '';
    $text_rectifation = '';
    $id = $data['id'];
    
    foreach($arr_issue as $k=>$v){
      $text_discrepancies .= 'ISSUE '.($k+1).'<br>';
      $text_discrepancies .= $v['discrepancies'].'<br><br>';

      
      $text_rectifation .= 'SOLVE '.($k+1).'<br>';
      $text_rectifation .= $v['rectifation'].'<br><br>';

    }

    $arr = array();
    $id = $data['id'];
   
    $total_fuel = count($arr);
    if($total_fuel <= 3){
      $limit = 3;
      $fuel_rowspan = 3;
    }else{
      $fuel_rowspan = $total_fuel;
      $limit = $total_fuel;
    }

    $arr_oil = array();
    $id = $data['id'];
    
    $total_oil = count($arr_oil);
    if($total_oil <= 2){
      $limit_oil = 2;
      $fuel_rowspan_oil = 2;
    }else{
      $fuel_rowspan_oil = $total_oil;
      $limit_oil = $total_oil;
    }
    $fuel_rowspan += $fuel_rowspan_oil + 3;
    
    $nomor = 0;
    $br = '';
    for($i=0;$i<$limit;$i++){
    $br .= '<br>';
    $nomor++;
    $this->db->select('nick_name');
    $arr[$i]['sign_created_by']  = $this->mymodel->selectDataOne('user',array('id'=>$arr[$i]['sign_created_by']));
    ?>
    <tr>
    <td colspan="2">
        <br>
      </td>
      <td colspan="2">
        <?=$arr[$i]['service']?>
      </td>
      <td>
        <?=$arr[$i]['onboard']?>
      </td>
      <td style="width:5%">
      <?=$arr[$i]['sign_created_by']['nick_name']?>
      </td>
      
      <?php if($i==0){ ?>
        <td rowspan="<?=$fuel_rowspan?>" colspan="5" class="text-left">
        <?=$text_discrepancies?>
      </td>
      <td rowspan="<?=$fuel_rowspan?>" colspan="1" style="width:5%">
        
      </td>
      <td rowspan="<?=$fuel_rowspan?>" colspan="5" class="text-left">
        <?=$text_rectifation?>
      </td>
      <td rowspan="<?=$fuel_rowspan?>" colspan="1" style="width:5%">
        
      </td>
      <?php }?>
    </tr>

    <?php } ?>



    <tr>
      <td colspan="6">
        OIL
      </td>
    </tr>

    <tr>
      <td colspan="2">
        STN
      </td>
      <td colspan="2">
        SERVICE
      </td>
      <td>
        ONBOARD
      </td>
      <td style="width:5%">
        SIGN
      </td>
    </tr>


    <?php 
    $nomor = 0;
    for($i=0;$i<$limit_oil;$i++){
    $nomor++;
    $this->db->select('nick_name');
    $arr_oil[$i]['sign_created_by']  = $this->mymodel->selectDataOne('user',array('id'=>$arr_oil[$i]['sign_created_by']));
    ?>
    <tr>
    <td colspan="2">
        <br>
      </td>
      <td colspan="2">
        <?=$arr_oil[$i]['service']?>
      </td>
      <td>
        <?=$arr_oil[$i]['onboard']?>
      </td>
      <td style="width:5%">
      <?=$arr_oil[$i]['sign_created_by']['nick_name']?>
      </td>
    </tr>

    <?php } ?>

    <tr>
      <td colspan="3" class="text-left" style="border-right:0px #FFF solid;vertical-align:middle">
        Distribution
       
      </td>
      <td class="text-left" style="border-left:0px #FFF solid;border-right:0px #FFF solid">
      White
      <br>
      Yellow
      <br>
      Blue
      </td>
      <td colspan="2" class="text-left"style="border-left:0px #FFF solid">
      - PPC
      <br>
      - Operation
      <br>
      - Remain on the logbook
      </td>
    </tr>


    <?php
    $id = $data['id'];

    $total_component = count($arr);
    if($total_component <= 4){
      $limit = 4;
      $hobbs_rowspan = 4+2;
    }else{
      $limit = $total_component;
      $hobbs_rowspan = $total_component+2;
    }
    ?>
    
    <tr>
      <td colspan="6" rowspan="<?=$hobbs_rowspan?>">
        <p>HOBBS</p>
        <br>
        <br>
        <p class="text-left">START<span style="margin-left:29.5px"> : </span></p>
        <p class="text-left">END<span style="margin-left:43px"> : </span></p>
        <p class="text-left"><span style="margin-left:74px"> : </span></p>
        <br>
        <br>
        <br>
        <br>
        <?=$br?>
        <div style="width:100%;display: table">
          <div style="width:50%;display:inline-block;text-align:left">
            <p>FORM BIFA/MTC/ML/001</p>
          </div>
          <div style="width:49%;display:inline-block;text-align:right">
            <p>NWS</p>
          </div>
        </div>
      </td>
      <td colspan="12" style="vertical-align:middle">
        COMPONEN REPLACEMENTS
      </td>
    </tr>

    <tr>
      <td style="vertical-align:middle">
        NO
      </td>
      <td colspan="2" style="vertical-align:middle">
        POS
      </td>
      <td colspan="4" style="vertical-align:middle">
        DESCRIPTION
      </td>
      <td colspan="2" style="vertical-align:middle">
        PART NUMBER
      </td>
      <td style="vertical-align:middle">
        S/N ON
      </td>
      <td style="vertical-align:middle">
        S/N OFF
      </td>
      <td style="vertical-align:middle">
        SIGN
      </td>
    </tr>

    <?php 
    $nomor = 0;
    for($i=0;$i<$limit;$i++){
    $nomor++;
    $this->db->select('nick_name');
    $arr[$i]['sign_created_by']  = $this->mymodel->selectDataOne('user',array('id'=>$arr[$i]['sign_created_by']));
    ?>
    <tr>
      <td>
        <?=$nomor?>
      </td>
      <td colspan="2">
      <?=$arr[$i]['pos']?>
      </td>
      <td colspan="4">
      <?=$arr[$i]['description']?>
      </td>
      <td colspan="2">
      <?=$arr[$i]['part_number']?>
      </td>
      <td>
      <?=$arr[$i]['s_n_on']?>
      </td>
      <td>
      <?=$arr[$i]['s_n_off']?>
      </td>
      <td>
      <?=$arr[$i]['sign_created_by']['nick_name']?>
      </td>
    </tr>

    <?php } ?>



  </table>
</body>



