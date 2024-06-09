<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Teampassword extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'Ubah Password';
        $this->template->load('template/template', 'teampassword/index', $data);
    }


    public function validate()
    {
        $this->form_validation->set_error_delimiters('<li>', '</li>');
        $this->form_validation->set_rules('newpassword', '<strong>Password Baru</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_rules('conf_newpassword', '<strong>Konfrimasi Password Baru</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_rules('lastpassword', '<strong>Konfirmasi Password Lama</strong> Tidak Boleh Kosong', 'required');
        $this->form_validation->set_message('required', '%s');
    }

    public function update()
    {
        $this->validate();
        if ($this->form_validation->run() == FALSE) {
            $this->alert->alertdanger(validation_errors());
        } else {
            $id = $this->session->userdata('id');
            $newPassword = md5($_POST['newpassword']);
            if ($_POST['newpassword'] != $_POST['conf_newpassword']) {
                $this->alert->alertdanger('<strong>Password Baru</strong> & <strong>Konfirmasi Password</strong> harus Sama !');
                return FALSE;
            } else {
                $password = $this->mymodel->selectDataOne('tbl_team', array('id' => $id));
                $lastPassword = md5($_POST['lastpassword']);
                if ($lastPassword != $password['password']) {
                    $this->alert->alertdanger('Masukan <strong>Password Lama</strong> anda dengan benar');
                    return FALSE;
                } else {
                    $dt['password'] = $newPassword;
                    $this->mymodel->updateData('tbl_team', $dt, array('id' => $id));
                }
            }
            $this->alert->alertsuccess('Success Send Data');
        }
    }
}
