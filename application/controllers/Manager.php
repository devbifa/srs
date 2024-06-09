<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Manager extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'Manajer';
        $data['manajer'] = $this->mymodel->selectDataone('tbl_manager', array('team_id' => $this->session->userdata('id')));
        $data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $data['manajer']['id'], 'table' => 'tbl_manager'));
        $this->template->load('template/template', 'manager/index', $data);
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('dt[name]', '<strong>Nama Tim</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_rules('dt[alamat]', '<strong>Alamat Tim</strong> Tidak Boleh Kosong', 'required');
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

    public function store()
    {
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $id = $this->session->userdata('id');
            $dt = $_POST['dt'];
            $dt['team_id'] = $id;
            $dt['status'] = 'ENABLE';
            $dt['created_at'] = date("Y-m-d H:i:s");
            
            $this->mymodel->insertData('tbl_manager', $dt);

            $last_id = $this->db->insert_id();
            if (!empty($_FILES['file']['name'])) {
                $dir  = "webfiles/manager/";
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
                        'table' => 'tbl_manager',
                        'table_id' => $last_id,
                        'url' => base_url() . $dir . $file['file_name'],
                        'status' => 'ENABLE',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->mymodel->insertData('file', $data);
                }
            }else{
                $data = array(
                    'name' => 'manager_default.png',
                    'mime' => 'image/png',
                    'dir' => 'webfiles/manager/manager_default.png',
                    'table' => 'tbl_manager',
                    'table_id' => $last_id,
                    'url' => base_url().'webfiles/manager/manager_default.png',
                    'status' => 'ENABLE',
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->mymodel->insertData('file', $data);
            }
            $this->alert->alertsuccess('Success Send Data');
        }
    }

    public function delete($id)
    {
        $file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'tbl_manager'));
        @unlink($file_dir['dir']);

        $this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
        $this->mymodel->deleteData('tbl_manager',  array('id' => $id));
        header('Location:'.base_url('manager'));
    }
}
