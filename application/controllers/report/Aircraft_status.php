

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Aircraft_status extends MY_Controller {



		public function __construct()

		{

			parent::__construct();
			// die;

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

			$last_data = $this->mymodel->selectWithQuery("SELECT *
			FROM maintenance_logbook a
			WHERE a.aircraft_reg = '$id_aircraft'
			ORDER BY a.date DESC
			LIMIT 5");
			$origin_base = '-';
			foreach($last_data as $k=>$v){
				if($v['last_base']){
					$origin_base = $v['last_base'];
					break;
				}
			}

			$next_rem = '-';
			foreach($last_data as $k=>$v){
				if($v['ni_ac_ttis']){
					$next_rem = $v['ni_ac_ttis'];
					$remaining = number_format($v['ni_ac_ttis'] - ($v['hobbs_end_start']+$v['bf_ac_hours_ttis']),1);
					break;
				}
			}

			$next_insp = '-';
			foreach($last_data as $k=>$v){
				if($v['ni_type']){
					$next_insp = $v['ni_type'];
					break;
				}
			}
			
			$ttis = '-';
			foreach($last_data as $k=>$v){
				if($v['hobbs_end_start']+$v['bf_ac_hours_ttis']){
					$ttis = ($v['hobbs_end_start'] - $v['aircraft_duration']) +$v['bf_ac_hours_ttis'];
					// $ttis = number_format($ttis,1);
					break;
				}
			}

			$eng_1 = '-';
			foreach($last_data as $k=>$v){
				if($v['hobbs_end_start']+$v['bf_no_1_engine_tso']){
					// $eng_1 = $v['hobbs_end_start']+$v['bf_no_1_engine_tso'];
					$eng_1 = ($v['hobbs_end_start'] - $v['aircraft_duration']) + $v['bf_no_1_engine_tso'];
					// $eng_1 = number_format($eng_1,1);
					break;
				}
			}

			$eng_2 = '-';
			foreach($last_data as $k=>$v){
				if($v['hobbs_end_start']+$v['bf_no_2_engine_tso']){
					$eng_2 = ($v['hobbs_end_start'] - $v['aircraft_duration']) + $v['bf_no_2_engine_tso'];
					break;
				}
			}

			$prop_1 = '-';
			foreach($last_data as $k=>$v){
				if($v['hobbs_end_start']+$v['bf_no_1_prop_tso']){
					$prop_1 = ($v['hobbs_end_start'] - $v['aircraft_duration']) + $v['bf_no_1_prop_tso'];
					// $prop_1 = number_format($prop_1,1);
					break;
				}
			}

			$prop_2 = '-';
			foreach($last_data as $k=>$v){
				if($v['hobbs_end_start']+$v['bf_no_2_prop_tso']){
					$prop_2 = ($v['hobbs_end_start'] - $v['aircraft_duration']) + $v['bf_no_2_prop_tso'];
					
					break;
				}
			}
			// print_r($last_data);
			// die;

			if($aircraft[0]['type']=="SE"){
				$eng_2 = '-';
				$prop_2 = '-';
			}

		
				$ttis = number_format((float)$ttis, 1, '.', ',');
				$eng_1 = number_format((float)$eng_1, 1, '.', ',');
				$eng_2 = number_format((float)$eng_2, 1, '.', ',');
				$prop_1 = number_format((float)$prop_1, 1, '.', ',');
				$prop_2 = number_format((float)$prop_2, 1, '.', ',');
				$next_rem = number_format((float)$next_rem, 1, '.', ',');

				$arr = array();
				$arr[0] = $ttis;
				$arr[1] = $eng_1;
				$arr[11] = $eng_2;
				$arr[2] = $prop_1;
				$arr[21] = $prop_2;
				$arr[3] = $next_rem;
				$arr[4] = $next_insp;
				$arr[5] = $origin_base;
				$arr[6] = $remaining;

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