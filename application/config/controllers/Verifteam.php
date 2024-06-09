<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Verifteam extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'Verified Team';
        $this->template->load('template/template', 'verifteam/index', $data);
    }

    public function fetchevent()
    {
        $output = '';

        $search = $_GET['title'];

        if ($search) {
            $event = $this->mymodel->selectWithQuery("SELECT * FROM tbl_event WHERE public = 'ENABLE' AND status = 'ENABLE' AND LOWER(title) like '%" . $search . "%' ORDER BY tgleventStart DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        } else {
            $event = $this->mymodel->selectWithQuery("SELECT * FROM tbl_event WHERE public = 'ENABLE' AND status = 'ENABLE' ORDER BY tgleventStart DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        }
        if ($event) {
            foreach ($event as $row) {
                $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'tbl_event'));
                
                $rowteam = $this->mymodel->selectWithQuery("SELECT count(team_id) as rowteam from tbl_event_register WHERE event_id = '" . $row['id'] . "' AND approve = 'APPROVE' AND team_id NOT LIKE '0'");
                
                if ($row['statusEvent'] == 'BERJALAN') {
                    $status =  '<span class="label bg-yellow round right" style="margin-left:5px">BERJALAN</span>';
                } else if ($row['statusEvent'] == 'SELESAI') {
                    $status =  '<span class="label bg-green round right" style="margin-left:5px">SELESAI</span>';
                } else if ($row['statusEvent'] == 'BATAL') {
                    $status =  '<span class="label bg-red round right" style="margin-left:5px">DIBATALKAN</span>';
                } else {
                    $status =  '<span class="label bg-blue round right" style="margin-left:5px">DIBUKA</span>';
                }

                $title = strlen($row["title"]) > 20 ? substr($row["title"], 0, 20) . "..." : $row["title"];

				$tanggal = "";
				if ((!$row['tgleventStart']) || (!$row['tgleventEnd'])) { 
					$tanggal = '<b>Coming Soon</b>';
				} else {
					$tanggal = date('d M Y', strtotime($row['tgleventStart'])) . "<b> s/d </b>" . date('d M Y', strtotime($row['tgleventEnd']));
                }
                
                $output .= '
				<a href="' . base_url("verifteam/view/") . $row['id'] . '" class="a_black">
				<div class="col-xs-6">
				<div class="box">
					<img class="img-even" src="' . $photo['url'] . '">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12" align="center">
                            <b style="font-size:11px">' . $title . '</b><br>
								<div class="row" align="center">
								' . $status . '
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
                                <img src="' . base_url('assets/flaticon/icon_team.png') . '" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> ' . $rowteam[0]['rowteam'] . '</b>
							</div>
						</div>
					</div>
				</div>
				</div>
				</a>';
            }
        }
        echo $output;
    }

    public function view($id)
    {
        $data['page'] = 'Verified Team';
        $data['tbl_event'] = $this->mymodel->selectDataone('tbl_event', array('id' => $id));
        $data['file_event'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_event'));
        $data['rowteam'] = $this->mymodel->selectWithQuery("SELECT count(id) as rowteam from tbl_event_register WHERE event_id = '" . $id . "' AND team_id NOT LIKE 0 AND approve = 'APPROVE'");

        $data['subpage'] = $data['tbl_event']['title'];
        $this->template->load('template/template', 'verifteam/view', $data);
    }

    public function fetchteam($id)
    {
        $output = '';

        $search = $_GET['name'];

        if ($search) {
            $team = $this->mymodel->selectWithQuery("SELECT a.team_id as team_id, b.name from tbl_event_register a INNER JOIN tbl_team b on a.team_id = b.id WHERE event_id = '" . $id . "' AND team_id NOT LIKE 0 AND b.name LIKE '%" . $_GET['name'] . "%' AND approve = 'APPROVE' ORDER BY b.name ASC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        } else {
            $team = $this->mymodel->selectWithQuery("SELECT a.team_id as team_id from tbl_event_register a INNER JOIN tbl_team b ON a.team_id = b.id WHERE a.event_id = '" . $id . "' AND a.team_id NOT LIKE 0 AND a.approve = 'APPROVE' ORDER BY b.name ASC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        }

        if ($team) {
            foreach ($team as $row) {
                $team = $this->mymodel->selectDataone('tbl_team', array('id' => $row['team_id']));
                $photo = $this->mymodel->selectDataone('file', array('table_id' => $team['id'], 'table' => 'tbl_team'));

                if ($team['verificacion'] == 'ENABLE') {
                    $verificacion  = '<img src="' . base_url('assets/flaticon/verified.png') . '" style=" width: 10px; height: 10px; margin-bottom: 5px;">';
                }

                $photoUrl = base_url('webfiles/team/team_default.png');
                if ($photo['url'] != NULL) {
                    $photoUrl = $photo['url'];
                }

                $nameteam = strlen($team["name"]) > 15 ? substr($team["name"], 0, 15) . "..." : $team["name"];
                // $nameteam = $team["name"];

                $kota = '-';
                if ($team['kota']) {
                    $kota = $team['kota'];
                }


                $output .= '<div class="col-xs-6">
                <div class="box">
                <div class="box-body">
                <div class="row" align="center">
                <div class="col-xs-12">
                <img class="img-circle" alt="User Image" src="' . $photoUrl . '" alt="Third slide" height="100px" width="100px">
                </div>
                <div class="col-xs-12" style="margin-top:15px;">
                <small style="font-size:11px;"><b>' . $nameteam . ' ' . $verificacion . '
                </b></small>
                <br>
                <small>' . $kota . '</small>
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
