<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Team extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'Team';
        $data['team'] = $this->mymodel->selectDataone('tbl_team', array('id' => $this->session->userdata('id')));
        $data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $data['team']['id'], 'table' => 'tbl_team'));
        $data['subpage'] = '<b>'.$data['team']['name'].'</b>';
        $this->template->load('template/template', 'team/index', $data);
    }


    public function validate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dt[name]', '<strong>Nama Tim</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_rules('dt[email]', '<strong>Email Tim</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_rules('dt[alamat]', '<strong>Alamat Tim</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_rules('dt[kota]', '<strong>Kota Tim</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_rules('dt[nowa]', '<strong>Nomor Wa</strong> Tidak Boleh Kosong', 'required');

        $supported_file = array(
            'jpg', 'jpeg', 'png'
        );

        $src_file_name = $_FILES['file']['name'];

        if ($src_file_name) {
            $ext = strtolower(pathinfo($src_file_name, PATHINFO_EXTENSION));

            if (!in_array($ext, $supported_file)) {
                $this->form_validation->set_message('dt[gambar]', '<strong>Gambar Proyek</strong> Harus berformat PNG, JPG, JPEG', 'required');
            }
        }
        $this->form_validation->set_message('required', '%s');
    }

    public function update()
    {
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $id = $this->session->userdata('id');
            $dt = $_POST['dt'];
            $dt['updated_at'] = date("Y-m-d H:i:s");
            $this->mymodel->updateData('tbl_team', $dt, array('id' => $id));

            $last_id = $this->db->insert_id();
            if (!empty($_FILES['file']['name'])) {
                $dir  = "webfiles/team/";
                $config['upload_path']          = $dir;
                $config['allowed_types']        = '*';
                $config['file_name']           = md5('smartsoftstudio') . rand(1000, 100000);

                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('file')) {
                    $error = $this->upload->display_errors();
                    $this->alert->alertdanger($error);
                } else {
                    $file = $this->upload->data();
                    $data = array(
                        'name' => $file['file_name'],
                        'mime' => $file['file_type'],
                        'dir' => $dir . $file['file_name'],
                        'table' => 'tbl_team',
                        'table_id' => $this->session->userdata('id'),
                        'url' => base_url() . $dir . $file['file_name'],
                        'status' => 'ENABLE',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $file = $this->mymodel->selectDataone('file', array('table_id' => $this->session->userdata('id'), 'table' => 'tbl_team'));
                    if ($file['name'] != "team_default.png") {
                        @unlink($file['dir']);
                    }
                    
                    if($file != NULL){
                        $this->mymodel->updateData('file', $data, array('table_id' => $this->session->userdata('id'), 'table' => 'tbl_team'));
                    }else {
                        $this->mymodel->insertData('file', $data);
                    }
                }
            }
            $this->alert->alertsuccess('Success Send Data');
        }
    }
    
    public function delete($id)
    {
        $file = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_team'));
        if ($file['name'] != "team_default.png") {
            @unlink($file['dir']);
        }
        
        $this->mymodel->deleteData('file',  array('id' => $file['id']));
        $this->mymodel->deleteData('tbl_team',  array('id' => $id));
        header('Location: http://192.168.100.9:8080/team?delete=true');
    }
}
