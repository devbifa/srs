

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Aircraft_status extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}




		public function index()

		{

			$data['page_name'] = "Aircraft_status";

			
			
			$this->template->load('template/template','report/aircraft_status/all',$data);

		}

		function filter(){
			$_SESSION['start_date'] = $_POST['start_date'];
			$_SESSION['end_date'] = $_POST['end_date'];
	
			$_SESSION['origin_base'] = $_POST['origin_base'];
			$_SESSION['batch'] = $_POST['batch'];
			
			redirect(base_url().'report/aircraft_status');
		}

		
		function ajax(){
		
		
			// $id_aircraft = $_POST['aircraft'];     
			$id_aircraft = $_GET['aircraft'];     
	
			$aircraft[0] = $this->mymodel->selectDataOne('aircraft_document',array('registration'=>$id_aircraft));

			$last_date = $this->mymodel->selectWithQuery("SELECT *
			FROM maintenance_logbook a
			WHERE a.aircraft_reg = '$id_aircraft'
			ORDER BY a.date DESC
			LIMIT 5");
			print_r($last_date);
			die;
		 
	//  echo "SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) ASC LIMIT 1";
	//   $date_1 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) ASC LIMIT 1");
	//   $date_1 = $date_1[0]['date_of_flight'];
	//   $date_2 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) DESC LIMIT 1");
	// $date_2 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' AND DATE(date_of_flight) <= '2021-01-01' ORDER BY DATE(date_of_flight) DESC LIMIT 1");
	 
	$date_2 = $date_2[0]['date_of_flight'];
	  $data =  $this->template->date_range( $date_1, $date_2);
	
	  foreach($aircraft as $key=>$val){
		$aircraft_document = $val;
	
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
		
		
		$report_1 = $this->mymodel->selectWithQuery("SELECT origin_base, type_hours,date_of_flight,calculate_remaining,type,flight_time_take_off,flight_time_landing,block_time_total,flight_time_total FROM daily_flight_schedule 
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
	  
			  //$current_time_eng_now = "00:00"; 
	  
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
			  
			  // $current_time_prop_now = "00:00";
	  
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
			  
	  
			  if($vr['calculate_remaining']=='YES'){
				  $current_time_next_ttis[0] = $vr['type_hours'];
				  $current_time_next_ttis[1] = $current_time_next_ttis_now;
				  $current_time_next_ttis[2] = $current_time_next_rem_now;
				  $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
				  $current_time_next_ttis_now = $current_time_next_ttis;
				  
				  $arr = array();
				  $a[0] = $current_time_next_ttis_now;
				  $a[1] = $current_time_next_rem_now;
				  $current_time_next_ttis = $this->template->sub_time($a);
				  $current_time_next_ttis_now = $current_time_next_ttis;
	  
				  $current_time_next_rem[0] = $current_time_next_rem_now;
				  $current_time_next_rem[1] = $vr['type_hours'];
				  $current_time_next_rem = $this->template->sum_time($current_time_next_rem);
				  $current_time_next_rem_now = $current_time_next_rem;
			  }else{
				  $current_time_next_ttis[0] =$vr['type_hours'];
				  $current_time_next_ttis[1] = $current_time_next_ttis_now;
				  $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
				  $current_time_next_ttis_now = $current_time_next_ttis;
				  $vr['calculate_remaining'] = 'NO';
				  $arr = array();
				  $a[0] = $current_time_next_ttis_now;
				  $a[1] = $current_time_next_rem_now;
				  $current_time_next_ttis = $this->template->sub_time($a);
				  $current_time_next_ttis_now = $current_time_next_ttis;
	  
				  $current_time_next_rem[0] = '00:00';
				  $current_time_next_rem[1] =$vr['type_hours'];
				  $current_time_next_rem = $this->template->sum_time($current_time_next_rem);
				  $current_time_next_rem_now = $current_time_next_rem;
			  }
			 
			  $in = $vr['type'];
	  
			  $body_eng_tso .= '<tr>
			  <td>INSPECTION<br>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td>
			  <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
			  <td class="text-left" >START<br>STOP<br>DURATION</td>
			  <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
			  
			  <td colspan="4"></td>
	  
			  <td>'.$current_time_next_ttis.'</td><td>'.$current_time_next_rem_now.'</td><td>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td><td>'.$vr['calculate_remaining'].'</td>
			  </tr>'; 
			}
			$dt = array();
			$dt['base'] = $vr['origin_base'];
			$this->db->update('aircraft_document',$dt,array('serial_number'=>$id_aircraft));

$body_eng_tso_modal .= '<tr>
<td>DMR '.$vr['origin_base'].'</td>
<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
<td>'.$vr['flight_time_take_off'].'</td>
<td>'.$vr['flight_time_landing'].'</td>
<td>'.$vr['flight_time_total'].'</td>
<td>'.$current_time_eng_now.'</td>
</tr>'; 


$body_prop_tso .= '<tr>
<td>DMR '.$vr['origin_base'].'</td>
<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
<td>'.$vr['flight_time_take_off'].'</td>
<td>'.$vr['flight_time_landing'].'</td>
<td>'.$vr['flight_time_total'].'</td>
<td>'.$current_time_prop_now.'</td>
</tr>'; 

$body_a_f_ttis .= '<tr>
<td>DMR '.$vr['origin_base'].'</td>
<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
<td>'.$vr['flight_time_take_off'].'</td>
<td>'.$vr['flight_time_landing'].'</td>
<td>'.$vr['flight_time_total'].'</td>
<td>'.$current_time_ttis_now.'</td>
</tr>'; 
		}
	
			
		$report_2 = $this->mymodel->selectWithQuery("SELECT origin_base, type_hours,date_of_flight,calculate_remaining,type,flight_time_take_off,flight_time_landing,block_time_total,flight_time_total FROM daily_flight_schedule 
		WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft' 
		AND DATE(date_of_flight) >= '$kd' AND DATE(date_of_flight) <= '$kd' 
		-- AND status = 'ENABLE'
		AND flight_time_total NOT IN ('','-','00:00','0:00')
		AND flight_time_take_off >= '00:00' AND flight_time_take_off <= '21:59'
		ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
		// print_r($report_2);
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
	
			//$current_time_eng_now = "00:00"; 
	
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
			
			// $current_time_prop_now = "00:00";
	
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
			
	
			if($vr['calculate_remaining']=='YES'){
				$current_time_next_ttis[0] = $vr['type_hours'];
				$current_time_next_ttis[1] = $current_time_next_ttis_now;
				$current_time_next_ttis[2] = $current_time_next_rem_now;
				$current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
				$current_time_next_ttis_now = $current_time_next_ttis;
				
				$arr = array();
				$a[0] = $current_time_next_ttis_now;
				$a[1] = $current_time_next_rem_now;
				$current_time_next_ttis = $this->template->sub_time($a);
				$current_time_next_ttis_now = $current_time_next_ttis;
	
				$current_time_next_rem[0] = $current_time_next_rem_now;
				$current_time_next_rem[1] = $vr['type_hours'];
				$current_time_next_rem = $this->template->sum_time($current_time_next_rem);
				$current_time_next_rem_now = $current_time_next_rem;
			}else{
				$current_time_next_ttis[0] =$vr['type_hours'];
				$current_time_next_ttis[1] = $current_time_next_ttis_now;
				$current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
				$current_time_next_ttis_now = $current_time_next_ttis;
				$vr['calculate_remaining'] = 'NO';
				$arr = array();
				$a[0] = $current_time_next_ttis_now;
				$a[1] = $current_time_next_rem_now;
				$current_time_next_ttis = $this->template->sub_time($a);
				$current_time_next_ttis_now = $current_time_next_ttis;
	
				$current_time_next_rem[0] = '00:00';
				$current_time_next_rem[1] =$vr['type_hours'];
				$current_time_next_rem = $this->template->sum_time($current_time_next_rem);
				$current_time_next_rem_now = $current_time_next_rem;
			}
		   
			$in = $vr['type'];
	
			$body_eng_tso .= '<tr>
			<td>INSPECTION<br>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td>
			<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
			<td class="text-left" >START<br>STOP<br>DURATION</td>
			<td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
			
			<td colspan="4"></td>
	
			<td>'.$current_time_next_ttis.'</td><td>'.$current_time_next_rem_now.'</td><td>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td><td>'.$vr['calculate_remaining'].'</td>
			</tr>'; 
		  }
		  $dt = array();
		  $dt['base'] = $vr['origin_base'];
		  $this->db->update('aircraft_document',$dt,array('serial_number'=>$id_aircraft));

$body_eng_tso_modal .= '<tr>
<td>DMR '.$vr['origin_base'].'</td>
<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
<td>'.$vr['flight_time_take_off'].'</td>
<td>'.$vr['flight_time_landing'].'</td>
<td>'.$vr['flight_time_total'].'</td>
<td>'.$current_time_eng_now.'</td>
</tr>'; 


$body_prop_tso .= '<tr>
<td>DMR '.$vr['origin_base'].'</td>
<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
<td>'.$vr['flight_time_take_off'].'</td>
<td>'.$vr['flight_time_landing'].'</td>
<td>'.$vr['flight_time_total'].'</td>
<td>'.$current_time_prop_now.'</td>
</tr>'; 

$body_a_f_ttis .= '<tr>
<td>DMR '.$vr['origin_base'].'</td>
<td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
<td>'.$vr['flight_time_take_off'].'</td>
<td>'.$vr['flight_time_landing'].'</td>
<td>'.$vr['flight_time_total'].'</td>
<td>'.$current_time_ttis_now.'</td>
</tr>'; 

		}
	
	  }
	
	  
	
	  $history_use = $body_eng_tso;
	
	
	  $a_f_ttis = $this->template->sum_time_3($a_f_ttis);
	  $eng_tso = $current_time_eng_now;
	  $prop_tso = $current_time_prop_now;
	  if($eng_tso >= 2200){
		$eng_tso_text = "text-red";
	  }
	  if($prop_tso >= 2000){
		$prop_tso_text = "text-red";
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
						  '.$body_eng_tso_modal.'
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
						  

						  
	
	  $history_rem = '<div class="table-responsive">
	  <table class="table table-bordered"  style="background-color: #fff0;">

		<tr class="bg-success ">
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
		<tr class="bg-success ">
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
	 
	  '.$body_eng_tso.'
	  </table>
	  </div>';
	  

				$ttis = '<a href="#!" title="A/F TTIS HISTORY"  data-toggle="modal" data-target="#history-'.$val['id'].'-ttis"  style="color:#3c8dbc!important;">'.$current_time_ttis_now.'</a>
  
				<div class="modal fade modal-success" id="history-'.$val['id'].'-ttis">
				<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">'.$id_aircraft.' A/F TTIS</h4>
					</div>
					<div class="modal-body" style="color:#fff!important;">
						<span style="font-weight:100">'.$history_a_f_ttis.'</span>    
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
					</div>
					</div>
				</div>
				</div>';

				$eng = '<a href="#!" title="ENG TSO HISTORY"  data-toggle="modal" data-target="#history-'.$val['id'].'-eng"  style="color:#3c8dbc!important;">'.$current_time_eng_now.'</a>
		
				<div class="modal fade modal-success" id="history-'.$val['id'].'-eng">
				<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">'.$id_aircraft.' ENG TSO</h4>
					</div>
					<div class="modal-body" style="color:#fff!important;">
						<span style="font-weight:100">'.$history_eng_tso.'</span>    
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
					</div>
					</div>
				</div>
				</div>';

				
				$prop = '<a href="#!" title="PROP TSO HISTORY"  data-toggle="modal" data-target="#history-'.$val['id'].'-prop"  style="color:#3c8dbc!important;">'.$current_time_prop_now.'</a>
		
				<div class="modal fade modal-success" id="history-'.$val['id'].'-prop">
				<div class="modal-dialog">
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">'.$id_aircraft.' PROP TSO</h4>
					</div>
					<div class="modal-body" style="color:#fff!important;">
						<span style="font-weight:100">'.$history_prop_tso.'</span>    
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
					</div>
					</div>
				</div>
				</div>';

				$next_rem = '<a href="#!" title="USAGE HISTORY"  data-toggle="modal" data-target="#history-'.$val['id'].'-rem"  style="color:#3c8dbc!important;">'.$current_time_next_rem_now.'</a>
		
				<div class="modal fade modal-success" id="history-'.$val['id'].'-rem">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">'.$id_aircraft.' USAGE HISTORY</h4>
					</div>
					<div class="modal-body" style="color:#fff!important;">
						<span style="font-weight:100">'.$history_rem.'</span>    
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
					</div>
					</div>
				</div>
				</div>';
	
				$dt['type'] = $in;
				$insp = $this->mymodel->selectDataOne('inspection_type',array('id'=>$aircraft_document['inspection_type']));
				$insp = json_decode($insp['konfigurasi'],true);

				foreach($insp as $k=>$v){
				if($v['option']==$dt['type']){
					$key = 1;
				}else if($key==1){
					$next_insp = $v['option'];
					break;
				}
				}
				if(empty($next_insp)){
				$next_insp = $insp[0]['option'];
				}


				$arr = array();
				$arr[0] = $ttis;
				$arr[1] = $eng;
				$arr[2] = $prop;
				$arr[3] = $next_rem;
				$arr[4] = $next_insp;
				$arr[5] = $dt['base'];

		 		echo $arr = json_encode($arr,true);
		

			}

		public function create()

		{
			
			$data['page_name'] = "Flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/add-daily_flight_schedule',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[date_of_flight]', '<strong>Date Of Flight</strong>', 'required');
$this->form_validation->set_rules('dt[origin_base]', '<strong>Origin Base</strong>', 'required');
$this->form_validation->set_rules('dt[aircraft_reg]', '<strong>Aircraft Reg</strong>', 'required');
$this->form_validation->set_rules('dt[pic]', '<strong>Pic</strong>', 'required');
$this->form_validation->set_rules('dt[2nd]', '<strong>2nd</strong>', 'required');
$this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
$this->form_validation->set_rules('dt[batch]', '<strong>Batch</strong>', 'required');
$this->form_validation->set_rules('dt[mission]', '<strong>Mission</strong>', 'required');
// $this->form_validation->set_rules('dt[mission_name]', '<strong>Mission Name</strong>', 'required');
$this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
$this->form_validation->set_rules('dt[rute]', '<strong>Rute</strong>', 'required');
$this->form_validation->set_rules('dt[etd_utc]', '<strong>Etd Utc</strong>', 'required');
$this->form_validation->set_rules('dt[eta_utc]', '<strong>Eta Utc</strong>', 'required');
$this->form_validation->set_rules('dt[eet]', '<strong>Eet</strong>', 'required');
$this->form_validation->set_rules('dt[dep]', '<strong>Dep</strong>', 'required');
$this->form_validation->set_rules('dt[arr]', '<strong>Arr</strong>', 'required');
$this->form_validation->set_rules('dt[remark]', '<strong>Remark</strong>', 'required');
	}


	


	


		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
				

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('daily_flight_schedule', $dt);

				$last_id = $this->db->insert_id();	    if (!empty($_FILES['file']['name'])){

		        	$dir  = "webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('file')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

					   	$file = $this->upload->data();

						$data = array(

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'daily_flight_schedule',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Send Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'daily_flight_schedule',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Send Data');



					}

					    

					

			}

		}

		function ajax_one(){
		
		
		$id_aircraft = $_POST['aircraft'];     

		$aircraft[0] = $this->mymodel->selectDataOne('aircraft_document',array('registration'=>$id_aircraft));
     
//  echo "SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) ASC LIMIT 1";
  $date_1 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) ASC LIMIT 1");
  $date_1 = $date_1[0]['date_of_flight'];
  $date_2 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' ORDER BY DATE(date_of_flight) DESC LIMIT 1");
// $date_2 = $this->mymodel->selectWithQuery("SELECT date_of_flight FROM daily_flight_schedule WHERE visibility_report = '1' AND aircraft_reg='$id_aircraft' AND DATE(date_of_flight) <= '2021-01-01' ORDER BY DATE(date_of_flight) DESC LIMIT 1");
 
$date_2 = $date_2[0]['date_of_flight'];
  $data =  $this->template->date_range( $date_1, $date_2);

  foreach($aircraft as $key=>$val){
	$aircraft_document = $val;

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
    
    
    $report_1 = $this->mymodel->selectWithQuery("SELECT origin_base, type_hours,date_of_flight,calculate_remaining,type,flight_time_take_off,flight_time_landing,block_time_total,flight_time_total FROM daily_flight_schedule 
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
  
		  //$current_time_eng_now = "00:00"; 
  
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
		  
		  // $current_time_prop_now = "00:00";
  
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
		  
  
		  if($vr['calculate_remaining']=='YES'){
			  $current_time_next_ttis[0] = $vr['type_hours'];
			  $current_time_next_ttis[1] = $current_time_next_ttis_now;
			  $current_time_next_ttis[2] = $current_time_next_rem_now;
			  $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
			  $current_time_next_ttis_now = $current_time_next_ttis;
			  
			  $arr = array();
			  $a[0] = $current_time_next_ttis_now;
			  $a[1] = $current_time_next_rem_now;
			  $current_time_next_ttis = $this->template->sub_time($a);
			  $current_time_next_ttis_now = $current_time_next_ttis;
  
			  $current_time_next_rem[0] = $current_time_next_rem_now;
			  $current_time_next_rem[1] = $vr['type_hours'];
			  $current_time_next_rem = $this->template->sum_time($current_time_next_rem);
			  $current_time_next_rem_now = $current_time_next_rem;
		  }else{
			  $current_time_next_ttis[0] =$vr['type_hours'];
			  $current_time_next_ttis[1] = $current_time_next_ttis_now;
			  $current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
			  $current_time_next_ttis_now = $current_time_next_ttis;
			  $vr['calculate_remaining'] = 'NO';
			  $arr = array();
			  $a[0] = $current_time_next_ttis_now;
			  $a[1] = $current_time_next_rem_now;
			  $current_time_next_ttis = $this->template->sub_time($a);
			  $current_time_next_ttis_now = $current_time_next_ttis;
  
			  $current_time_next_rem[0] = '00:00';
			  $current_time_next_rem[1] =$vr['type_hours'];
			  $current_time_next_rem = $this->template->sum_time($current_time_next_rem);
			  $current_time_next_rem_now = $current_time_next_rem;
		  }
		 
		
  
		  $body_eng_tso .= '<tr>
		  <td>INSPECTION<br>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td>
		  <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
		  <td class="text-left" >START<br>STOP<br>DURATION</td>
		  <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
		  
		  <td colspan="4"></td>
  
		  <td>'.$current_time_next_ttis.'</td><td>'.$current_time_next_rem_now.'</td><td>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td><td>'.$vr['calculate_remaining'].'</td>
		  </tr>'; 
		}
		$dt = array();
		$dt['base'] = $vr['origin_base'];
		$this->db->update('aircraft_document',$dt,array('serial_number'=>$id_aircraft));
    }

        
    $report_2 = $this->mymodel->selectWithQuery("SELECT origin_base, type_hours,date_of_flight,calculate_remaining,type,flight_time_take_off,flight_time_landing,block_time_total,flight_time_total FROM daily_flight_schedule 
    WHERE visibility_report = '1' AND aircraft_reg = '$id_aircraft' 
    AND DATE(date_of_flight) >= '$kd' AND DATE(date_of_flight) <= '$kd' 
	-- AND status = 'ENABLE'
    AND flight_time_total NOT IN ('','-','00:00','0:00')
    AND flight_time_take_off >= '00:00' AND flight_time_take_off <= '21:59'
    ORDER BY DATE(date_of_flight) ASC, flight_time_take_off ASC");
	// print_r($report_2);
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

        //$current_time_eng_now = "00:00"; 

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
		
        // $current_time_prop_now = "00:00";

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
        

        if($vr['calculate_remaining']=='YES'){
			$current_time_next_ttis[0] = $vr['type_hours'];
			$current_time_next_ttis[1] = $current_time_next_ttis_now;
			$current_time_next_ttis[2] = $current_time_next_rem_now;
			$current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
			$current_time_next_ttis_now = $current_time_next_ttis;
			
			$arr = array();
			$a[0] = $current_time_next_ttis_now;
			$a[1] = $current_time_next_rem_now;
			$current_time_next_ttis = $this->template->sub_time($a);
			$current_time_next_ttis_now = $current_time_next_ttis;

			$current_time_next_rem[0] = $current_time_next_rem_now;
			$current_time_next_rem[1] = $vr['type_hours'];
			$current_time_next_rem = $this->template->sum_time($current_time_next_rem);
			$current_time_next_rem_now = $current_time_next_rem;
        }else{
			$current_time_next_ttis[0] =$vr['type_hours'];
			$current_time_next_ttis[1] = $current_time_next_ttis_now;
			$current_time_next_ttis = $this->template->sum_time($current_time_next_ttis);
			$current_time_next_ttis_now = $current_time_next_ttis;
			$vr['calculate_remaining'] = 'NO';
			$arr = array();
			$a[0] = $current_time_next_ttis_now;
			$a[1] = $current_time_next_rem_now;
			$current_time_next_ttis = $this->template->sub_time($a);
			$current_time_next_ttis_now = $current_time_next_ttis;

			$current_time_next_rem[0] = '00:00';
			$current_time_next_rem[1] =$vr['type_hours'];
			$current_time_next_rem = $this->template->sum_time($current_time_next_rem);
			$current_time_next_rem_now = $current_time_next_rem;
        }
       
      

        $body_eng_tso .= '<tr>
        <td>INSPECTION<br>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td>
        <td>'.$this->template->date_indo($vr['date_of_flight']).'</td>
        <td class="text-left" >START<br>STOP<br>DURATION</td>
        <td>'.$vr['flight_time_take_off'].'<br>'.$vr['flight_time_landing'].'<br>'.$vr['flight_time_total'].'</td>
        
        <td colspan="4"></td>

        <td>'.$current_time_next_ttis.'</td><td>'.$current_time_next_rem_now.'</td><td>'.$vr['type'].'  ~ '.$vr['type_hours'].' Hours </td><td>'.$vr['calculate_remaining'].'</td>
        </tr>'; 
      }
	  $dt = array();
	  $dt['base'] = $vr['origin_base'];
	  $this->db->update('aircraft_document',$dt,array('serial_number'=>$id_aircraft));
    }

  }

  

  $history_use = $body_eng_tso;


  $a_f_ttis = $this->template->sum_time_3($a_f_ttis);
  $eng_tso = $current_time_eng_now;
  $prop_tso = $current_time_prop_now;
  if($eng_tso >= 2200){
    $eng_tso_text = "text-red";
  }
  if($prop_tso >= 2000){
    $prop_tso_text = "text-red";
  }



}


              echo $history_use;
		}



		public function json()

		{

			$status = $_GET['status'];

			if($status==''){

				$status = 'ENABLE';

			}

			header('Content-Type: application/json');

			$this->datatables->select('a.id,a.date_of_flight,a.origin_base, type_hours,date_of_flight,calculate_remaining,type,flight_time_take_off,flight_time_landing,b.serial_number as aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status');

	        $this->datatables->where('a.status',$status);

	        $this->datatables->from('daily_flight_schedule a');

			$this->datatables->join('aircraft_document b','a.aircraft_reg = b.id');
			
	        $this->datatables->join('batch c','a.batch = c.id');
			
	        $this->datatables->join('course d','a.course = d.id');
			
	        $this->datatables->join('tpm_syllabus_all_course e','a.mission = e.id');
			
			$this->datatables->join('instructor f','a.pic = f.id');
			
			$this->datatables->join('student_application_form g','a.2nd = g.id');
			
			$this->db->order_by("a.date_of_flight ASC, a.etd_utc ASC");

	        if($status=="ENABLE"){

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			', 'id');



	    	}else{

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');



	    	}

	        echo $this->datatables->generate();

		}

		public function edit($id)

		{

			$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "Flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/edit-daily_flight_schedule',$data);

		}
		
		public function preview($id)

		{

			$data['daily_flight_schedule'] = $this->mymodel->selectDataone('daily_flight_schedule',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));$data['page_name'] = "Flight_schedule";

			$this->template->load('template/template','master/daily_flight_schedule/preview-daily_flight_schedule',$data);

		}





		public function update()

		{	

			$this->validate();

			



	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$id = $this->input->post('id', TRUE);

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

	        		$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

						$file = $this->upload->data();

						$data = array(

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				// 'size'=> $file['file_size'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'daily_flight_schedule',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('daily_flight_schedule', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('daily_flight_schedule', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_flight_schedule'));

				$this->alert->alertdanger('Success Delete Data');

				$str = $this->mymodel->deleteData('daily_flight_schedule',  array('id'=>$id));
				return $str;
				
			

		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_flight_schedule',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_flight_schedule');

		}





	}

?>