

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Maintenance_logbook extends MY_Controller {



	public function __construct()

	{

		parent::__construct();
		// die;

	}



	public function index()

	{

		$data['page_name'] = "maintenance_logbook";

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


		$this->template->load('template/template','master/maintenance_logbook/all',$data);

	}

	function filter(){
		$_SESSION['start_date'] = $_POST['start_date'];
		$_SESSION['end_date'] = $_POST['end_date'];
		$_SESSION['origin_base'] = $_POST['origin_base'];
		$_SESSION['batch'] = $_POST['batch'];
		$_SESSION['aircraft'] = $_POST['aircraft'];
		$_SESSION['keyword'] = $_POST['keyword'];
		$_SESSION['keyword_arr'] = $_POST['keyword_arr'];
		redirect(base_url().'master/maintenance_logbook');
	}

	function generate(){
		$date = $_GET['date'];
		$aircraft_reg = $_GET['aircraft_reg'];
		$data = $this->mymodel->selectDataOne('maintenance_logbook',array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
		if($data){
			redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);
		}else{
			$dat = $this->mymodel->selectWithQuery("SELECT count(id) as count
			FROM maintenance_logbook");
			$log_sheet = $dat[0]['count']+1;
			$log_sheet = str_pad($log_sheet,6,"0",STR_PAD_LEFT);
			$dt = array();
			$dt['aircraft_status'] = 'SERVICEABLE';
			$dt['aircraft_reg'] = $aircraft_reg;
			$dt['date'] = $date;
			$dt['log_sheet'] = $log_sheet;
			$dt['di_date'] = $date;
			$dt['di_created_by'] = $_SESSION['id'];
			// $dt['di_created_at'] = DATE('Y-m-d H:i:s');
			// $dt['di_amel_no'] = $date;
			$dt['status'] = $date;
			$dt['created_by'] = $_SESSION['id'];
			$dt['created_at'] = $date;
			$this->db->insert('maintenance_logbook',$dt);
			$data['id'] = $this->db->insert_id();
			$data = $this->mymodel->selectDataOne('maintenance_logbook',array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
			redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

		}
	}

	function store(){
		$date = $_POST['date'];
		$aircraft_reg = $_POST['aircraft_reg'];
		$data = $this->mymodel->selectDataOne('maintenance_logbook',array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
		if($data){

			redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

			

			
		}else{
			$dat = $this->mymodel->selectWithQuery("SELECT count(id) as count
			FROM maintenance_logbook");
			$log_sheet = $dat[0]['count']+1;
			$log_sheet = str_pad($log_sheet,6,"0",STR_PAD_LEFT);
			$dt = array();
			$dt['aircraft_reg'] = $aircraft_reg;
			$dt['date'] = $date;
			$dt['aircraft_status'] = 'SERVICEABLE';
			$dt['log_sheet'] = $log_sheet;
			$dt['di_date'] = $date;
			$dt['di_created_by'] = $_SESSION['id'];
			// $dt['di_created_at'] = DATE('Y-m-d H:i:s');
			// $dt['di_amel_no'] = $date;
			$dt['status'] = $date;
			$dt['created_by'] = $_SESSION['id'];
			$dt['created_at'] = $date;
			$this->db->insert('maintenance_logbook',$dt);
			$data['id'] = $this->db->insert_id();
			$data = $this->mymodel->selectDataOne('maintenance_logbook',array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
			
			redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

		}
	}


	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

$this->form_validation->set_rules('id', '<strong>ID</strong>', 'required');
// $this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
}


	public function edit()

	{

		$my_role = $this->mymodel->selectDataOne('role',array('id'=>$_SESSION['role']));
		$my_menu_sub = json_decode($my_role['menu_sub'],true);
		$menu_id = '2055';

		if($my_menu_sub[$menu_id]['edit']){

		}else{
			redirect(base_url().'master/maintenance_logbook');
		}


		$date = $_GET['date'];
		$aircraft_reg = $_GET['aircraft_reg'];
		$data['data'] = $this->mymodel->selectDataOne('maintenance_logbook',array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
		if(empty($data['data'])){
			redirect(base_url().'master/maintenance_logbook');
		}
		$data['data']['hobbs_end_start'] = $data['data']['hobbs_end'] - $data['data']['hobbs_start'];
		$data['di_created_by'] = $this->mymodel->selectDataOne('user',array('id'=>$data['data']['di_created_by']));

		$data_last_5 = $this->mymodel->selectWithQuery("SELECT *
		FROM maintenance_logbook
		WHERE aircraft_reg = '$aircraft_reg' AND date < '$date'
		ORDER BY date DESC
		LIMIT 10;
		");

$data_last = array();
if($data['data']['bf_ac_hours_ttis']==''){
	foreach($data_last_5 as $k=>$v){
		if($v['total_ac_hours_ttis'] > 0){
			$data_last = $v;
			break;
		}
	}
	$data['data']['bf_ac_hours_ttis'] = $data_last['total_ac_hours_ttis'];
}

$data_last = array();
if($data['data']['bf_no_1_engine_tso']==''){
	foreach($data_last_5 as $k=>$v){
		if($v['total_no_1_engine_tso'] > 0){
			$data_last = $v;
			break;
		}
	}
	$data['data']['bf_no_1_engine_tso'] = $data_last['total_no_1_engine_tso'];
}

$data_last = array();
if($data['data']['bf_no_2_engine_tso']==''){
	foreach($data_last_5 as $k=>$v){
		if($v['total_no_2_engine_tso'] > 0){
			$data_last = $v;
			break;
		}
	}
	$data['data']['bf_no_2_engine_tso'] = $data_last['total_no_2_engine_tso'];
}

$data_last = array();
if($data['data']['bf_no_1_prop_tso']==''){
	foreach($data_last_5 as $k=>$v){
		if($v['total_no_1_prop_tso'] > 0){
			$data_last = $v;
			break;
		}
	}
	$data['data']['bf_no_1_prop_tso'] = $data_last['total_no_1_prop_tso'];
}

$data_last = array();
if($data['data']['bf_no_2_prop_tso']==''){
	foreach($data_last_5 as $k=>$v){
		if($v['total_no_2_prop_tso'] > 0){
			$data_last = $v;
			break;
		}
	}
	$data['data']['bf_no_2_prop_tso'] = $data_last['total_no_2_prop_tso'];
}

$data_last = array();
if($data['data']['ni_type']==''){
	foreach($data_last_5 as $k=>$v){
		if($v['ni_type'] > 0){
			$data_last = $v;
			break;
		}
	}
	$data['data']['ni_type'] = $data_last['ni_type'];
}

$data_last = array();
if($data['data']['ni_ac_ttis']==''){
	foreach($data_last_5 as $k=>$v){
		if($v['ni_ac_ttis'] > 0){
			$data_last = $v;
			break;
		}
	}
	$data['data']['ni_ac_ttis'] = $data_last['ni_ac_ttis'];
}

		


		$this->template->load('template/template','master/maintenance_logbook/edit',$data);

	}

	function get(){
		$aircraft_reg = $_GET['aircraft_reg'];
		$date = $_GET['date'];

		$data_last_5 = $this->mymodel->selectWithQuery("SELECT *
		FROM maintenance_logbook
		WHERE aircraft_reg = '$aircraft_reg' AND date < '$date'
		ORDER BY date DESC
		LIMIT 10;
		");

		$data = array();

		$data_last = array();
		if($data['data']['bf_ac_hours_ttis']==''){
			foreach($data_last_5 as $k=>$v){
				if($v['total_ac_hours_ttis'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_ac_hours_ttis'] = $data_last['total_ac_hours_ttis'];
		}

		$data_last = array();
		if($data['data']['bf_no_1_engine_tso']==''){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_1_engine_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_1_engine_tso'] = $data_last['total_no_1_engine_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_2_engine_tso']==''){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_2_engine_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_2_engine_tso'] = $data_last['total_no_2_engine_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_1_prop_tso']==''){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_1_prop_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_1_prop_tso'] = $data_last['total_no_1_prop_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_2_prop_tso']==''){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_2_prop_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_2_prop_tso'] = $data_last['total_no_2_prop_tso'];
		}

		$data_last = array();
		if($data['data']['ni_type']==''){
			foreach($data_last_5 as $k=>$v){
				if($v['ni_type'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['ni_type'] = $data_last['ni_type'];
		}

		$data_last = array();
		if($data['data']['ni_ac_ttis']==''){
			foreach($data_last_5 as $k=>$v){
				if($v['ni_ac_ttis'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['ni_ac_ttis'] = $data_last['ni_ac_ttis'];
		}


		$dt = array();
		$dt = $data['data'];
		$this->db->update('maintenance_logbook',$dt,array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
		redirect(base_url().'master/maintenance_logbook/edit?date='.$date.'&aircraft_reg='.$aircraft_reg);
	}

	public function print_v1()

	{
		$date = $_GET['date'];
		$aircraft_reg = $_GET['aircraft_reg'];
		$data['data'] = $this->mymodel->selectDataOne('maintenance_logbook',array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
		if(empty($data['data'])){
			redirect(base_url().'master/maintenance_logbook');
		}
		$data['data']['hobbs_end_start'] = $data['data']['hobbs_end'] - $data['data']['hobbs_start'];

		// $data_last_5 = $this->mymodel->selectWithQuery("SELECT *
		// FROM maintenance_logbook
		// WHERE aircraft_reg = '$aircraft_reg' 
		// ORDER BY date DESC
		// LIMIT 5;
		// ");
		$data_last_5 = array();

		$data_last = array();
		if($data['data']['bf_ac_hours_ttis']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_ac_hours_ttis'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_ac_hours_ttis'] = $data_last['total_ac_hours_ttis'];
		}

		$data_last = array();
		if($data['data']['bf_no_1_engine_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_1_engine_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_1_engine_tso'] = $data_last['total_no_1_engine_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_2_engine_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_2_engine_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_2_engine_tso'] = $data_last['total_no_2_engine_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_1_prop_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_1_prop_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_1_prop_tso'] = $data_last['total_no_1_prop_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_2_prop_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_2_prop_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_2_prop_tso'] = $data_last['total_no_2_prop_tso'];
		}

		$data_last = array();
		if($data['data']['ni_type']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['ni_type'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['ni_type'] = $data_last['ni_type'];
		}

		$data_last = array();
		if($data['data']['ni_ac_ttis']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['ni_ac_ttis'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['ni_ac_ttis'] = $data_last['ni_ac_ttis'];
		}

		$this->load->view('master/maintenance_logbook/print_v1',$data);

	}


	public function print_v2()

	{
		$date = $_GET['date'];
		$aircraft_reg = $_GET['aircraft_reg'];
		$data['data'] = $this->mymodel->selectDataOne('maintenance_logbook',array('date'=>$date,'aircraft_reg'=>$aircraft_reg));
		if(empty($data['data'])){
			redirect(base_url().'master/maintenance_logbook');
		}
		$data['data']['hobbs_end_start'] = $data['data']['hobbs_end'] - $data['data']['hobbs_start'];

		$data_last_5 = $this->mymodel->selectWithQuery("SELECT *
		FROM maintenance_logbook
		WHERE aircraft_reg = '$aircraft_reg' 
		ORDER BY date DESC
		LIMIT 10;
		");

		$data_last = array();
		if($data['data']['bf_ac_hours_ttis']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_ac_hours_ttis'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_ac_hours_ttis'] = $data_last['total_ac_hours_ttis'];
		}

		$data_last = array();
		if($data['data']['bf_no_1_engine_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_1_engine_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_1_engine_tso'] = $data_last['total_no_1_engine_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_2_engine_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_2_engine_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_2_engine_tso'] = $data_last['total_no_2_engine_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_1_prop_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_1_prop_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_1_prop_tso'] = $data_last['total_no_1_prop_tso'];
		}

		$data_last = array();
		if($data['data']['bf_no_2_prop_tso']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['total_no_2_prop_tso'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['bf_no_2_prop_tso'] = $data_last['total_no_2_prop_tso'];
		}

		$data_last = array();
		if($data['data']['ni_type']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['ni_type'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['ni_type'] = $data_last['ni_type'];
		}

		$data_last = array();
		if($data['data']['ni_ac_ttis']==0){
			foreach($data_last_5 as $k=>$v){
				if($v['ni_ac_ttis'] > 0){
					$data_last = $v;
					break;
				}
			}
			$data['data']['ni_ac_ttis'] = $data_last['ni_ac_ttis'];
		}

		$this->load->view('master/maintenance_logbook/print_v2',$data);

	}
	
	public function preview($id)

	{

		$data['maintenance_logbook'] = $this->mymodel->selectDataone('maintenance_logbook',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'maintenance_logbook'));$data['page_name'] = "maintenance_logbook";

		$this->template->load('template/template','master/maintenance_logbook/preview',$data);

	}





	public function update()

	{	

		$this->validate();

		



		if ($this->form_validation->run() == FALSE){

			$this->alert->alertdanger(validation_errors());     

		}else{

			$id = $this->input->post('id', TRUE);

			$dt = $_POST['dt'];

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/maintenance_logbook/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'maintenance_logbook-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dt['file'] = $file['file_name'];



				}
			}

			



	

				$data['data'] = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id));

				$start_date = $data['data']['date'];
				$aircraft_reg = $data['data']['aircraft_reg'];

				
				$data_report = $this->mymodel->selectWithQuery("SELECT *
				FROM daily_flight_schedule a
				WHERE DATE(a.date_of_flight) = '$start_date' AND a.visibility = '1' 
				AND a.visibility_report = '1' AND etd_utc >= '22:00' AND etd_utc <= '24:00' AND remark_report IN ('','-')
				AND a.aircraft_reg = '$aircraft_reg'
				GROUP BY a.id
				ORDER BY
				a.date_of_flight ASC, a.etd_utc ASC");

				$dt['first_dep'] = $data_report[0]['dep'];
				$dt['last_arr'] = $data_report[count($data_report)-1]['arr'];

				$data_report = $this->mymodel->selectWithQuery("SELECT *
				FROM daily_flight_schedule a
				WHERE DATE(a.date_of_flight) = '$start_date' AND a.visibility = '1' 
				AND a.visibility_report = '1' AND etd_utc >= '00:00' AND etd_utc <= '21:59' AND remark_report IN ('','-')
				AND a.aircraft_reg = '$aircraft_reg'
				GROUP BY a.id
				ORDER BY
				a.date_of_flight ASC, a.etd_utc ASC");

				if($dt['first_dep']==""){
					$dt['first_dep'] = $data_report[0]['dep'];
				}

				if($data_report[count($data_report)-1]['arr']){
					$dt['last_arr'] = $data_report[count($data_report)-1]['arr'];
				}

				$dt['first_dep'] = strval($dt['first_dep']);
				$dt['last_arr'] = strval($dt['last_arr']);
			

				$dt['updated_at'] = date("Y-m-d H:i:s");

				$arr = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_issue 
				WHERE id_maintenance = '$id' AND status = 'ENABLE' ORDER BY id ASC");
				
				if($arr[count($arr)-1]['issue_status']){
					$status = $arr[count($arr)-1]['issue_status'];
				}else{
					$status = 'SERVICEABLE';
				}
				$dt['aircraft_status'] = $status;
				
				$str = $this->mymodel->updateData('maintenance_logbook', $dt , array('id'=>$id));

				$aircraft_status = 'SERVICEABLE';
				$log_sheet = '-';

				$last_data = $this->mymodel->selectWithQuery("SELECT *
				FROM maintenance_logbook a
				WHERE a.aircraft_reg = '$aircraft_reg'
				ORDER BY a.date DESC
				LIMIT 5");
				foreach($last_data as $k=>$v){
					if($v['aircraft_status']){
						$aircraft_status = $v['aircraft_status'];
						break;
					}
				}
				foreach($last_data as $k=>$v){
					if($v['log_sheet']){
						$log_sheet = $v['log_sheet'];
						break;
					}
				}

				$dt_a = array();
				$dt_a['updated_at'] = DATE('Y-m-d H:i:s');
				$dt_a['status'] = $aircraft_status;
				$dt_a['remark'] = $dt['remark'];
				$dt_a['log_number'] = $log_sheet;
				$this->db->update('aircraft_document',$dt_a,array('serial_number'=>$aircraft_reg));
				
				
				return $str;  

			
		}

	}



	public function delete($id)

	{

			$data = $this->mymodel->selectDataOne('maintenance_logbook',  array('id'=>$id));
		
			$aircraft_reg = $data['aircraft_reg'];
			$aircraft_status = 'SERVICEABLE';
			$log_sheet = '-';

			$last_data = $this->mymodel->selectWithQuery("SELECT *
			FROM maintenance_logbook a
			WHERE a.aircraft_reg = '$aircraft_reg'
			ORDER BY a.date DESC
			LIMIT 5");
			foreach($last_data as $k=>$v){
				if($v['aircraft_status']){
					$aircraft_status = $v['aircraft_status'];
					break;
				}
			}
			foreach($last_data as $k=>$v){
				if($v['log_sheet']){
					$log_sheet = $v['log_sheet'];
					break;
				}
			}

			$dt_a = array();
			$dt_a['updated_at'] = DATE('Y-m-d H:i:s');
			$dt_a['status'] = $aircraft_status;
			$dt_a['remark'] = $data['remark'];
			$dt_a['log_number'] = $log_sheet;
			$this->db->update('aircraft_document',$dt_a,array('serial_number'=>$aircraft_reg));

			$this->alert->alertdanger('Success Delete Data');

			$str = $this->mymodel->deleteData('maintenance_logbook',  array('id'=>$id));
			redirect(base_url().'master/maintenance_logbook');

	}



	public function status($id,$status)

	{

		$this->mymodel->updateData('maintenance_logbook',array('status'=>$status),array('id'=>$id));


		redirect('master/Daily_flight_schedule');

	}



	function store_issue(){
			

		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		$dttt['id_maintenance'] = $id_maintenance;
		$dttt['created_at'] = date("Y-m-d H:i:s");
		$dttt['created_by'] = $_SESSION['id'];
		$dttt['status'] = 'ENABLE';
		$str =  $this->mymodel->insertData('maintenance_issue', $dttt);
		$id = $this->db->insert_id();
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/maintenance_issue/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'issue-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}

				
				$str =  $this->mymodel->updateData('maintenance_issue', $dttt , array('id'=>$id));

				$arr = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_issue 
				WHERE id_maintenance = '$id_maintenance' AND status = 'ENABLE' ORDER BY id ASC");
				
				if($arr[count($arr)-1]['issue_status']){
					$status = $arr[count($arr)-1]['issue_status'];
				}else{
					$status = 'SERVICEABLE';
				}

				$dt = array();
				$dt['aircraft_status'] = $status;
				$this->db->update('maintenance_logbook', $dt , array('id'=>$id_maintenance));
				
		 
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}


	function update_issue(){
		

		$id = $this->input->post('id', TRUE);

		$id = $_POST['id'];
		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/maintenance_issue/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'issue-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}



				$dttt['updated_at'] = date("Y-m-d H:i:s");

				

				

				
				
				$str =  $this->mymodel->updateData('maintenance_issue', $dttt , array('id'=>$id));

				$arr = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_issue 
				WHERE id_maintenance = '$id_maintenance' AND status = 'ENABLE' ORDER BY id ASC");
				
				if($arr[count($arr)-1]['issue_status']){
					$status = $arr[count($arr)-1]['issue_status'];
				}else{
					$status = 'SERVICEABLE';
				}

				$dt = array();
				$dt['aircraft_status'] = $status;
				$this->db->update('maintenance_logbook', $dt , array('id'=>$id_maintenance));
				
				
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}

	function delete_issue($id,$index){

		$this->mymodel->deleteData('maintenance_issue', array('id'=>$index));

		
		$arr = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_issue 
		WHERE id_maintenance = '$id' AND status = 'ENABLE' ORDER BY id ASC");
		
		if($arr[count($arr)-1]['issue_status']){
			$status = $arr[count($arr)-1]['issue_status'];
		}else{
			$status = 'SERVICEABLE';
		}

		$dt = array();
		$dt['aircraft_status'] = $status;
		$this->db->update('maintenance_logbook', $dt , array('id'=>$id));


		$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id));
		redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);
	}



	function store_component_replacement(){
			

		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		$dttt['id_maintenance'] = $id_maintenance;
		$dttt['created_at'] = date("Y-m-d H:i:s");
		$dttt['created_by'] = $_SESSION['id'];
		$dttt['status'] = 'ENABLE';
		$str =  $this->mymodel->insertData('component_replacement', $dttt);
		$id = $this->db->insert_id();
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/component_replacement/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'component-replacement-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}

				


				$dttt['updated_at'] = date("Y-m-d H:i:s");
				$str =  $this->mymodel->updateData('component_replacement', $dttt , array('id'=>$id));
				
		 
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}


	function update_component_replacement(){
		

		$id = $this->input->post('id', TRUE);

		$id = $_POST['id'];
		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/component_replacement/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'component-replacement-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}



				$dttt['updated_at'] = date("Y-m-d H:i:s");
				$str =  $this->mymodel->updateData('component_replacement', $dttt , array('id'=>$id));
				
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}

	function delete_component_replacement($id,$index){

		$this->mymodel->deleteData('component_replacement', array('id'=>$index));
		$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id));
		redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);
	}

	function store_fuel(){
			

		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		$dttt['id_maintenance'] = $id_maintenance;
		$dttt['created_at'] = date("Y-m-d H:i:s");
		$dttt['created_by'] = $_SESSION['id'];
		$dttt['status'] = 'ENABLE';
		$str =  $this->mymodel->insertData('fuel', $dttt);
		$id = $this->db->insert_id();
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/fuel/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'fuel-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}

				


				$dttt['updated_at'] = date("Y-m-d H:i:s");
				$str =  $this->mymodel->updateData('fuel', $dttt , array('id'=>$id));
				
		 
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}


	function update_fuel(){
		

		$id = $this->input->post('id', TRUE);

		$id = $_POST['id'];
		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/fuel/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'fuel-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}



				$dttt['updated_at'] = date("Y-m-d H:i:s");
				$str =  $this->mymodel->updateData('fuel', $dttt , array('id'=>$id));
				
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}

	function delete_fuel($id,$index){

		$this->mymodel->deleteData('fuel', array('id'=>$index));
		$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id));
		redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);
	}

	function store_oil(){
			

		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		$dttt['id_maintenance'] = $id_maintenance;
		$dttt['created_at'] = date("Y-m-d H:i:s");
		$dttt['created_by'] = $_SESSION['id'];
		$dttt['status'] = 'ENABLE';
		$str =  $this->mymodel->insertData('oil', $dttt);
		$id = $this->db->insert_id();
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/oil/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'oil-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}

				


				$dttt['updated_at'] = date("Y-m-d H:i:s");
				$str =  $this->mymodel->updateData('oil', $dttt , array('id'=>$id));
				
		 
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}


	function update_oil(){
		

		$id = $this->input->post('id', TRUE);

		$id = $_POST['id'];
		$id_maintenance = $_POST['id_maintenance'];
		$dttt = $_POST['dttt'];
		

			if (!empty($_FILES['file']['name'])){

				$dir  = "webfile/oil/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['overwrite'] 			= TRUE;
				$config['file_name']           	= 'oil-'.$id_maintenance.'-'.$id;
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

								   'table'=> 'maintenance_logbook',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);


				$dttt['file'] = $file['file_name'];



				}
			}



				$dttt['updated_at'] = date("Y-m-d H:i:s");
				$str =  $this->mymodel->updateData('oil', $dttt , array('id'=>$id));
				
				$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id_maintenance));
				redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);

	}

	function delete_oil($id,$index){

		$this->mymodel->deleteData('oil', array('id'=>$index));
		$data = $this->mymodel->selectDataOne('maintenance_logbook',array('id'=>$id));
		redirect(base_url().'master/maintenance_logbook/edit?date='.$data['date'].'&aircraft_reg='.$data['aircraft_reg']);
	}


}

?>