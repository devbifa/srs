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
              AIRCRAFT STATUS
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

             
            
              <div class="table-responsive">

              <table class="table table-bordered table-striped" id="mytable" style="width:100%">

<thead>
<tr class="bg-success">
<th style="width:5%" rowspan="2">NUM</th>
<th rowspan="2" style="min-width:100px;" >AIRCRAFT</th>
<th rowspan="2" style="min-width:100px;">COA</th>
<th rowspan="2" style="min-width:100px;">BASE</th>
<th colspan="3">SERIAL NUMBER</th>
<th colspan="2" style="min-width:100px;">FUEL CAPACITY</th>
<th colspan="2" style="min-width:100px;">INSTRUMENT</th>
<th rowspan="2" style="min-width:100px;"> A/F TTIS</th>
<th rowspan="2" style="min-width:100px;"> ENG TSO</th>
<th rowspan="2" style="min-width:100px;"> PROP TSO</th>
<th rowspan="2" style="min-width:100px;"> LOG NO</th>
<th rowspan="2" style="min-width:100px;"> STATUS LAST ENTRY</th>
<th rowspan="2" style="min-width:100px;"> STATUS LAST EDIT</th>
<th colspan="3">NEXT INSPECT PERIODIC 50 FHI</th>
<th rowspan="2" style="min-width:100px;"> A/F TTIS</th>
<th rowspan="2" style="min-width:100px;"> NEXT INSP. 500 FHI REM</th>
<th rowspan="2" style="min-width:100px;"> A/F TTIS</th>
<th colspan="2">AGEING SEI-SI OPS 21	</th>
<th rowspan="2" style="min-width:100px;"> AIRCRAFT STATUS</th>
</tr>
<tr class="bg-success">
<th style="min-width:100px;">AIRCRAFT</th>
<th style="min-width:100px;">ENGINEE</th>
<th style="min-width:100px;">PROP</th>
<th style="min-width:100px;">USG</th>
<th style="min-width:100px;">MIX</th>
<th style="min-width:100px;">NF</th>
<th style="min-width:100px;">AVIONIC</th>
<th style="min-width:100px;">A/F TTIS</th>
<th style="min-width:100px;">REM</th>
<th style="min-width:100px;">TYPE INSP.</th>
<th style="min-width:100px;">NEXT INSP. 1000 FHI REM</th>
<th style="min-width:100px;">CALENDER 5 YEARS</th>
</tr>

</thead>


<tbody>
<?php 
//  $aircraft = $this->mymodel->selectWithQuery("SELECT * FROM aircraft_document WHERE id = '1' ORDER BY serial_number ASC");
$aircraft = $this->mymodel->selectWithQuery("SELECT * FROM aircraft_document  ORDER BY serial_number ASC");

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
   
     
    $block_time_total_bottom = array();
    $flight_time_total_bottom = array();


  
 
  $date_1 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' ORDER BY DATE(date_of_flight) ASC LIMIT 1");
  $date_1 = $date_1[0]['date_of_flight'];
  $date_2 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' ORDER BY DATE(date_of_flight) DESC LIMIT 1");
  $date_2 = $date_2[0]['date_of_flight'];
  $data =  $this->template->date_range( $date_1, $date_2);
  foreach($aircraft as $key=>$val){
    $history_eng_tso = "";
    $body_eng_tso = "";

    $history_prop_tso = "";
    $body_prop_tso = "";

    $history_a_f_ttis = "";
    $body_a_f_ttis = "";
  
  $id_aircraft = $val['id'];
  
  $a_f_ttis = array();
  $eng_tso_text = "";
  $prop_tso_text = "";
  $a_f_ttis_text = "";
  
  $current_time_eng_now = "";
  $current_time_prop_now = "";
  $current_time_ttis_now = "";

  $start_a_f_ttis = $val['start_a_f_ttis'];

  $nomor = 0;  

  $body_a_f_ttis .= '<tr>
  <td colspan="5" class="text-left" >START A/F TTIS</td>
  <td>'.$val['start_a_f_ttis'].'</td>
  </tr>'; 


  $body_eng_tso .= '<tr>
  <td colspan="5" class="text-left" >START ENG TSO</td>
  <td>'.$val['start_eng_tso'].'</td>
  </tr>'; 

  $body_prop_tso .= '<tr>
  <td colspan="5" class="text-left" >START PROP TSO</td>
  <td>'.$val['start_prop_tso'].'</td>
  </tr>'; 

  $last_base = "";

  foreach($data as $vd=>$kd){
    
    
    $report_1 = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule 
    WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft' 
    AND DATE(date_of_flight) >= '$kd' AND DATE(date_of_flight) <= '$kd' 
    AND flight_time_total NOT IN ('','-','00:00','0:00')
    AND flight_time_take_off >= '22:00' AND flight_time_take_off <= '24:00'
    ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
    foreach($report_1 as $kr=>$vr){
      $current_time_eng = array();
      $current_time_prop = array();
      $current_time_ttis = array();
      $current_time_next_ttis = array();
      $current_time_next_rem = array();
      $nomor++;
      if($vr['type']==''){

        if($vr['origin_base']){
          $last_base = $vr['origin_base'];
        }

        array_push($a_f_ttis,$vr['flight_time_total']);

        if($nomor == 1){
          $current_time_eng[0] = $val['start_eng_tso'];
          $current_time_eng[1] = $vr['flight_time_total'];
          $current_time_eng = $this->template->sum_time($current_time_eng);
          $current_time_eng_now = $current_time_eng;
          $current_time_prop[0] = $val['start_prop_tso'];
          $current_time_prop[1] = $vr['flight_time_total'];
          $current_time_prop = $this->template->sum_time($current_time_prop);
          $current_time_prop_now = $current_time_prop;
          $current_time_ttis[0] = $val['start_a_f_ttis'];
          $current_time_ttis[1] = $vr['flight_time_total'];
          $current_time_ttis = $this->template->sum_time($current_time_ttis);
          $current_time_ttis_now = $current_time_ttis;

          $current_time_next_ttis[0] =$val['next_a_f_ttis'];
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
        

          // $current_time_next_ttis[0] =$val['next_a_f_ttis'];
          $current_time_next_ttis[1] =$current_time_next_ttis_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;

          $current_time_next_rem[0] = $current_time_next_ttis_now;
          $current_time_next_rem[1] = $current_time_ttis;
          $current_time_next_rem = $this->template->sub_time($current_time_next_rem);
          $current_time_next_rem_now = $current_time_next_rem;
        }

        $body_eng_tso .= '<tr>
                            <td>DMR</td>
                            <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
                            <td>'.$vr['flight_time_take_off'].'</td>
                            <td>'.$vr['flight_time_landing'].'</td>
                            <td>'.$vr['flight_time_total'].'</td>
                            <td>'.$current_time_eng_now.'</td>
                          </tr>'; 


                          $body_prop_tso .= '<tr>
                          <td>DMR</td>
                          <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
                          <td>'.$vr['flight_time_take_off'].'</td>
                          <td>'.$vr['flight_time_landing'].'</td>
                          <td>'.$vr['flight_time_total'].'</td>
                          <td>'.$current_time_prop_now.'</td>
                        </tr>'; 
                        
      $body_a_f_ttis .= '<tr>
      <td>DMR</td>
      <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
      <td>'.$vr['flight_time_take_off'].'</td>
      <td>'.$vr['flight_time_landing'].'</td>
      <td>'.$vr['flight_time_total'].'</td>
      <td>'.$current_time_ttis_now.'</td>
    </tr>'; 


      }else if($vr['type']=='ENGINE'){

        $current_time_eng_now = "00:00"; 

        $body_eng_tso .= '<tr>
        <td>MAINTENANCE<br>ENGINE</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_eng_now.'</td>
        </tr>'; 
      }else if($vr['type']=='PROP'){

        $current_time_prop_now = "00:00";

        $body_prop_tso .= '<tr>
        <td>MAINTENANCE<br>PROPELLER</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_prop_now.'</td>
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
      $nomor++;
      if($vr['type']==''){

        if($vr['origin_base']){
          $last_base = $vr['origin_base'];
        }

        array_push($a_f_ttis,$vr['flight_time_total']);

        if($nomor == 1){
          $current_time_eng[0] = $val['start_eng_tso'];
          $current_time_eng[1] = $vr['flight_time_total'];
          $current_time_eng = $this->template->sum_time($current_time_eng);
          $current_time_eng_now = $current_time_eng;
          $current_time_prop[0] = $val['start_prop_tso'];
          $current_time_prop[1] = $vr['flight_time_total'];
          $current_time_prop = $this->template->sum_time($current_time_prop);
          $current_time_prop_now = $current_time_prop;
          $current_time_ttis[0] = $val['start_a_f_ttis'];
          $current_time_ttis[1] = $vr['flight_time_total'];
          $current_time_ttis = $this->template->sum_time($current_time_ttis);
          $current_time_ttis_now = $current_time_ttis;

          $current_time_next_ttis[0] =$val['next_a_f_ttis'];
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
        

          // $current_time_next_ttis[0] =$val['next_a_f_ttis'];
          $current_time_next_ttis[1] =$current_time_next_ttis_now;
          $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
          $current_time_next_ttis_now = $current_time_next_ttis;

          $current_time_next_rem[0] = $current_time_next_ttis_now;
          $current_time_next_rem[1] = $current_time_ttis;
          $current_time_next_rem = $this->template->sub_time($current_time_next_rem);
          $current_time_next_rem_now = $current_time_next_rem;
        }

        $body_eng_tso .= '<tr>
                            <td>DMR</td>
                            <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
                            <td>'.$vr['flight_time_take_off'].'</td>
                            <td>'.$vr['flight_time_landing'].'</td>
                            <td>'.$vr['flight_time_total'].'</td>
                            <td>'.$current_time_eng_now.'</td>
                          </tr>'; 


                          $body_prop_tso .= '<tr>
                          <td>DMR</td>
                          <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
                          <td>'.$vr['flight_time_take_off'].'</td>
                          <td>'.$vr['flight_time_landing'].'</td>
                          <td>'.$vr['flight_time_total'].'</td>
                          <td>'.$current_time_prop_now.'</td>
                        </tr>'; 
                        
      $body_a_f_ttis .= '<tr>
      <td>DMR</td>
      <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
      <td>'.$vr['flight_time_take_off'].'</td>
      <td>'.$vr['flight_time_landing'].'</td>
      <td>'.$vr['flight_time_total'].'</td>
      <td>'.$current_time_ttis_now.'</td>
    </tr>'; 


      }else if($vr['type']=='ENGINE'){

        $current_time_eng_now = "00:00"; 

        $body_eng_tso .= '<tr>
        <td>MAINTENANCE<br>ENGINE</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_eng_now.'</td>
        </tr>'; 
      }else if($vr['type']=='PROP'){

        $current_time_prop_now = "00:00";

        $body_prop_tso .= '<tr>
        <td>MAINTENANCE<br>PROPELLER</td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        <td></td>
        <td>'.$current_time_prop_now.'</td>
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

       
      }
    }


  }

  $history_a_f_ttis = '<table class="table table-bordered" style="background-color: #fff0;">
                      <th>REMARK
                      </th>
                      <th style="width:100px;">DATE
                      </th>
                      <th>FLIGHT TIME TAKE OFF
                      </th>
                      <th>FLIGHT TIME LANDING
                      </th>
                      <th>FLIGHT TIME TOTAL
                      </th>
                      <th>CURRENT TIME
                      </th>
                      </tr>
                      '.$body_a_f_ttis.'
                      </table>';

  $history_eng_tso = '<table class="table table-bordered" style="background-color: #fff0;">
                      <th>REMARK
                      </th>
                      <th style="width:100px;">DATE
                      </th>
                      <th>FLIGHT TIME TAKE OFF
                      </th>
                      <th>FLIGHT TIME LANDING
                      </th>
                      <th>FLIGHT TIME TOTAL
                      </th>
                      <th>CURRENT TIME
                      </th>
                      </tr>
                      '.$body_eng_tso.'
                      </table>';


  $history_prop_tso = '<table class="table table-bordered" style="background-color: #fff0;">
                      <th>REMARK
                      </th>
                      <th style="width:100px;">DATE
                      </th>
                      <th>FLIGHT TIME TAKE OFF
                      </th>
                      <th>FLIGHT TIME LANDING
                      </th>
                      <th>FLIGHT TIME TOTAL
                      </th>
                      <th>CURRENT TIME
                      </th>
                      </tr>
                      '.$body_prop_tso.'
                      </table>';



  // foreach($report as $k=>$v){
  //   if (strpos($v['flight_time_total'], ':') !== false) {
  //     array_push($a_f_ttis,$v['flight_time_total']);
  //   }
  // }

  // $maintenance_engine = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_aircraft_engine WHERE aircraft_reg = '$id_aircraft'");
  // $maintenance_prop = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_aircraft_propeller WHERE aircraft_reg = '$id_aircraft'");
// echo count($a_f_ttis);
  $a_f_ttis = $current_time_ttis_now;
  $eng_tso = $current_time_eng_now;
  $prop_tso = $current_time_prop_now;
  if($eng_tso >= 2100){
    $eng_tso_text = "text-red";
  }else if($eng_tso >= 2000){
    $eng_tso_text = "text-yellow";
  }
  if($prop_tso >= 1900){
    $prop_tso_text = "text-red";
  }else if($prop_tso >= 1800){
    $prop_tso_text = "text-yellow";
  }
  $coa = json_decode($val['attachment'],true);
  $coa = $coa[1]['description'];

  $this->db->update('aircraft_document',array('base'=>$last_base),array('id'=>$val['id']));
  $id_aircraft = $val['id'];
  $inspection = $this->mymodel->selectWithQuery("SELECT * FROM daily_flight_schedule 
  WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft'  AND type NOT IN ('ENGINE','PROP','')
  -- AND flight_time_total NOT IN ('','-','00:00','0:00')
  -- AND flight_time_take_off >= '00:00' AND flight_time_take_off <= '21:59' AND type != ''
  ORDER BY DATE(date_of_flight) DESC, flight_time_take_off DESC LIMIT 1");
  if($inspection){
    $last_inspection_type = $inspection[0]['type'];
    $next_inspection_type = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type WHERE inspection_type > $last_inspection_type ORDER BY inspection_type ASC LIMIT 1");
    $next_inspection_type = $next_inspection_type[0]['inspection_type'];
  }else{
    $next_inspection_type = $val['next_inspection_type'];
  }

  if(empty($next_inspection_type)){
    $next_inspection_type = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type ORDER BY inspection_type ASC LIMIT 1");
    $next_inspection_type = $next_inspection_type[0]['inspection_type'];
  }

  // $inspection_type_next = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type WHERE inspection_type > $next_inspection2 ORDER BY inspection_type ASC LIMIT 1");

  ?>
  <tr>
    <td><?=$key+1?></td>
    <td><a href="<?=base_url()?>master/aircraft_document/edit/<?=$val['id']?>"><?=$val['registration']?></a></td>
    <td><?=$coa?></td>
    <td><?=$last_base?></td>
    <td><?=$val['serial']?></td>
    <td>
      <?=$val['engine']?>
    </td>
    <td>
      <?=$val['prop']?>
    </td>
    <td><?=$val['usg']?></td>
    <td><?=$val['mix']?></td>
    <td><?=$val['nf']?></td>
    <td><?=$val['avionic']?></td>
    <td>
    <a href="#!" title="A/F TTIS HISTORY"  data-toggle="modal" data-target="#history-<?=$val['id']?>-ttis"  style="color:#000!important;"><?=$current_time_ttis_now?></a>
  
  <div class="modal fade modal-success" id="history-<?=$val['id']?>-ttis">
  <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?=$val['serial_number']?> A/F TTIS</h4>
        </div>
        <div class="modal-body" style="color:#fff!important;">
          <span style="font-weight:100"><?=$history_a_f_ttis?></span>    
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
  </div>
  </td>
    <td class="<?=$eng_tso_text?>">
    <a href="#!" title="ENG TSO HISTORY"  data-toggle="modal" data-target="#history-<?=$val['id']?>-eng" style="color:#000!important;" ><?=$eng_tso?></a>
  
      <div class="modal fade modal-success" id="history-<?=$val['id']?>-eng">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><?=$val['serial_number']?> ENG TSO</h4>
            </div>
            <div class="modal-body" style="color:#fff!important;">
              <span style="font-weight:100"><?=$history_eng_tso?></span>    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
      </div>
    </td>
    <td class="<?=$prop_tso_text?>">
    <a href="#!" title="PROPELLER TSO HISTORY" data-toggle="modal" data-target="#history-<?=$val['id']?>-prop"  style="color:#000!important;"><?=$prop_tso?></a>
       <div class="modal fade modal-success" id="history-<?=$val['id']?>-prop">
      <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"><?=$val['serial_number']?> PROP TSO</h4>
            </div>
            <div class="modal-body" style="color:#fff!important;">
              <span style="font-weight:100"><?=$history_prop_tso?></span>    
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
      </div>
    </td>
      
    <td><?=$val['log_number']?></td>
    <td><?=$val['updated_at']?></td>
    <td><?=$val['updated_at']?></td>
    <td><?=$current_time_next_ttis_now?></td><td><?=$current_time_next_rem_now?></td><td><?=$next_inspection_type?></td><td></td><td></td><td></td><td></td><td></td>
    <td><?=$val['status']?></td>
  </tr>
<?php 
}

?>

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


