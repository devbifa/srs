<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sponsorship extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'sponsor';
        $this->template->load('template/template', 'sponsorship/index', $data);
    }

    // public function view($id)
    // {
    //     $data['page'] = 'sponsor';
    //     $data['id'] = $this->mymodel->selectDataone('sponsor', array('id' => $id));
    //     $data['main_image'] = $this->mymodel->selectDataOne('file', array('table_id' => $data['id']['id'], 'table' => 'sponsor_item'));
    //     $data['subpage'] = '<b>' . $data['id']['value'] . '</b>';

    //     // $data['tbl_comment'] = $this->mymodel->selectWithQuery('SELECT * FROM tbl_comment WHERE imagegroup_id = ' . $id . ' ORDER BY created_at DESC LIMIT 3');

    //     $this->template->load('template/template', 'sponsor/view', $data);
    // }


    public function fetch()
    {
        $output = '';
        $search = $_GET['keyword'];

		if ($search) {
			$sponsor = $this->mymodel->selectWithQuery("SELECT * FROM sponsor WHERE status =  'ENABLE' AND nama_sponsor like '%$search%' ORDER BY RAND() LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$sponsor = $this->mymodel->selectWithQuery("SELECT * FROM sponsor WHERE status =  'ENABLE' ORDER BY RAND() LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        }
        
        if ($sponsor) {
            foreach ($sponsor as $row) {
                // $main_image = $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'sponsor_item'));
                // $imagecount = $this->mymodel->selectWithQuery('SELECT count(id) as imagecount from sponsor WHERE status = "ENABLE" AND imagegroup_id = ' . $row['id']);

                $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'sponsor'));
	
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
				}

				$output .= '
				<div class="col-md-2">
				<div class="box" style="background-color: rgb(255, 255, 255); padding: 0px; display: flex; justify-content: center; align-items: center; height: 215px;">
					<img class="" src="' . $photo['dir']. '" style="width:100%;padding:25px;">
				</div>
				</div>';
            }
        }
		echo '<div class="row">'.$output.'</div>';
    }

    public function fetchview($id)
    {
        $output = '';

        $search = $_GET['title'];

        if ($search) {
            $sponsor = $this->mymodel->selectWithQuery("SELECT * FROM sponsor WHERE imagegroup_id = '" . $id . "' AND title LIKE '%" . $_GET['title'] . "%' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        } else {
            $sponsor = $this->mymodel->selectWithQuery('SELECT * FROM sponsor WHERE imagegroup_id = ' . $id . ' ORDER BY id DESC LIMIT ' . $this->input->post('limit') . ' OFFSET ' . $this->input->post('start'));
        }
        if ($sponsor) {
            foreach ($sponsor as $row) {
                $file =  $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'sponsor'));

                $output .= '
                <div class="col-xs-12">
                    <div class="box">
                    <img src="' . $file['url'] . '" style="width:100%; border-radius:15px">
                    </div>
                </div>';
            }
        }
        echo $output;
    }

    public function comment()
    {
        $dt = $_POST['dt'];
        $dt['id_raider'] = $this->session->userdata('id');
        $dt['status'] = "ENABLE";
        $dt['created_at'] = date('Y-m-d H:i:s');
        $str = $this->db->insert('tbl_comment', $dt);

        $this->alert->alertsuccess('Success Send Data');
    }

    public function commentview($id)
    {
        $data['page'] = 'sponsor';
        $data['id'] = $this->mymodel->selectDataone('sponsor', array('id' => $id));
        $data['main_image'] = $this->mymodel->selectDataOne('file', array('table_id' => $data['id']['id'], 'table' => 'sponsor_item'));
        $data['subpage'] = '<b>' . $data['id']['value'] . '</b>';

        $this->template->load('template/template', 'sponsor/commentview', $data);
    }
}
