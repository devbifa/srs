<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Monitoreventrider extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['page'] = 'Monitoring Event';
		$this->template->load('template/template','monitoreventrider/index', $data); 
	}

	public function fetch(){
		$output = '';

		$search = $_GET['title'];
		
		if($search){
			$tbl_event_register = $this->mymodel->selectWithQuery("SELECT a.*, b.raider_id, c.title FROM tbl_event_register a INNER JOIN tbl_event_register_raider b ON a.id = b.event_register_id INNER JOIN tbl_event c ON a.event_id = c.id WHERE a.team_id = 0 AND b.raider_id = ".$this->session->userdata('id')." AND LOWER(c.title) like '%".$search."%' ORDER BY id DESC LIMIT ".$this->input->post('limit')." OFFSET ".$this->input->post('start'));   
		}else{
			$tbl_event_register = $this->mymodel->selectWithQuery("SELECT a.*, b.raider_id, c.title FROM tbl_event_register a INNER JOIN tbl_event_register_raider b ON a.id = b.event_register_id INNER JOIN tbl_event c ON a.event_id = c.id WHERE a.team_id = 0 AND b.raider_id = ".$this->session->userdata('id')." ORDER BY id DESC LIMIT ".$this->input->post('limit')." OFFSET ".$this->input->post('start'));   
        }
        
		if($tbl_event_register){
			foreach($tbl_event_register as $row)
			{
				$event = $this->mymodel->selectDataone('tbl_event', array('id' => $row['event_id']));

				$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['event_id'], 'table' => 'tbl_event'));

				$rowraider = $this->mymodel->selectWithQuery("SELECT count(a.id) as rowraider from tbl_event_register_raider a INNER JOIN tbl_event_register b ON a.event_register_id = b.id WHERE b.event_id = " . $row['id']." AND b.approve = 'APPROVE' ");

				if ($row['approve'] == 'WAITING') {
					$approve = '<small class="label bg-yellow"><i class="fa fa-warning"> </i> Menunggu Dikonfirmasi </small>';
				} else if ($row['approve'] == "APPROVE") {
					$approve = '<small class="label bg-green"><i class="fa fa-check"> </i> Pendaftaran Di Terima </small>';
				} else if ($row['approve'] == "REJECT") {
					$approve = '<small class="label bg-red"><i class="fa fa-ban"> </i> Pendaftaran Di Tolak </small>';
				} 
				
				$title = strlen($row["title"]) > 20 ? substr($row["title"], 0, 20) . "..." : $row["title"];

				$tanggal = "";
				if ((!$row['tgleventStart']) || (!$row['tgleventEnd'])) { 
					$tanggal = '<b>Coming Soon</b>';
				} else {
					$tanggal = date('d M Y', strtotime($row['tgleventStart'])) . "<b> s/d </b>" . date('d M Y', strtotime($row['tgleventEnd']));
				}

				$output .= '
				<div class="col-xs-6">
				<div class="box">
					<img class="img-even" src="' . $photo['url'] . '">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12" align="center">
								<b style="font-size:11px">' . $title . '</b><br>
								<div class="row" align="center">
								' . $approve . '
								</div>
								<div class="col-md-12" style="padding:0px 10px;">
								</div>
							</div>
						</div>
						<hr style="margin-top:5px; margin-bottom: 5px;">
						<div class="row">
							<div class="col-xs-12" align="center">
								Tanggal Event :
								<br>
								<small>'.$tanggal.'</small>
							</div>
							<div class="col-xs-12" align="center">
								Pendaftar :
								<b>
								<img src="' . base_url('assets/flaticon/icon_rider.png') . '" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" />' . $rowraider[0]['rowraider'] . '
								</b>
							</div>
						</div>
					</div>
				</div>
				</div>';
			}
		}
		echo $output;
	}
}