<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Akun extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        if(empty($_SESSION['id'])){
			redirect(base_url());
		}
        
        
        $data['page'] = 'NSO PROJECT - AKUN SAYA';
        $data['subpage'] = '';
        $this->template->load('template/template', 'akun/index', $data);
    }

    public function create()
    {
        $data['page'] = 'Rider';
        $data['subpage'] = 'Tambah Rider';
        $this->template->load('template/template', 'raider/create', $data);
    }

    public function edit($id)
    {
        $data['page'] = 'NSO PROJECT - EDIT AKUN';
        $data['raider'] = $this->mymodel->selectDataone('user', array('id' => $id));
        $data['file'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));
        $data['subpage'] = 'Ubah - <b>' . $data['raider']['name'] . '</b>';
        $this->template->load('template/template', 'user/edit', $data);
    }


    public function fetch()
    {
        $output = '';

        $search = $_GET['name'];

        if ($search) {
            $raider = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE team_id = " . $this->session->userdata('id') . " AND LOWER(name) like '%" . $search . "%' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        } else {
            $raider = $this->mymodel->selectWithQuery("SELECT * FROM user WHERE team_id = " . $this->session->userdata('id') . " ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
        }

        if ($raider) {
            foreach ($raider as $row) {
                $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'user'));
                $motor = $this->mymodel->selectDataone('master_motor', array('id' => $row['motor_id']));

                $gambar_raider = base_url('webfiles/raider/raider_default.png');
                if ($photo != NULL) {
                    $gambar_raider = $photo['url'];
                }

                $verificacion = '';
                if ($row['verificacion'] == 'ENABLE') {
                    $verificacion = '<img src="'.base_url('assets/flaticon/verified.png').'" style=" width: 15px; height: 15px; margin-bottom: 5px;">';
                }

                $output .= '
                <div class="col-xs-12">
                <div class="box"> 
                <div class="box-body">
                <div class="row" align="center">
                <div class="col-xs-6">
                <img class="img-circle" alt="User Image" src="' . $gambar_raider . '" alt="Third slide" height="150px" width="150px">
                </div>
                <div class="col-xs-6">
                <h4>' . $row['name'] . ' ' . $verificacion . '<br>
                <small><img src="'.base_url('assets/flaticon/worldwide.png').'" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> ' . $row['kota'] . '</small> 
                </h4>
                <b>
                <img src="'.base_url('assets/flaticon/sport.png').'" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> ' . $motor['value'] . '
                <br>
                <img src="'.base_url('assets/flaticon/phone-call.png').'" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> ' . $row['nowa'] . '
                </b>
                <p>Sebanyak : <br><b>' . $row['eventikut'] . '</b> Event Telah Di Ikuti</p>
                </div>
                </div>
                <br>
                <a href="' . base_url('raider/edit/') . $row['id'] . '">
                <button class="btn btn-lg btn-block btn-info"> Lihat </button>
                </a>
                <div class="row" id="deleteForm_' . $row['id'] . '">
                <div class="col-xs-12 btnDelete_' . $row['id'] . '">
                <button class="btn btn-lg btn-block btn-danger" onclick="hapus(' . $row['id'] . ')"> Hapus </button>
                </div>
                </div>
                </div>
                </div>
                </div>
                ';
            }
        }
        echo $output;
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
            $dt['verificacion'] = 'DISABLE';
            $dt['eventikut'] = 0;
            $dt['status'] = 'ENABLE';
            $dt['created_at'] = date("Y-m-d H:i:s");
            $this->mymodel->insertData('user', $dt);

            $last_id = $this->db->insert_id();
            if (!empty($_FILES['file']['name'])) {
                $dir  = "webfiles/raider/";
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
                        'table' => 'user',
                        'table_id' => $last_id,
                        'url' => base_url() . $dir . $file['file_name'],
                        'status' => 'ENABLE',
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    $this->mymodel->insertData('file', $data);
                }
            } else {
                $data = array(
                    'name' => 'raider_default.png',
                    'mime' => 'image/png',
                    'dir' => 'webfiles/raider/raider_default.png',
                    'table' => 'user',
                    'table_id' => $last_id,
                    'url' => base_url() . 'webfiles/raider/raider_default.png',
                    'status' => 'ENABLE',
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->mymodel->insertData('file', $data);
            }
            $this->alert->alertsuccess('Success Send Data');
        }
    }

    public function update()

		{	

            
			

				$id = $_SESSION['id'];

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "admin-side/webfile/";

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

					   				'table'=> 'user',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

                                    );

                                    

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));

                        // print_r($data);die;
						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						$dt['password'] = md5($dt['password']);

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('user', $dt , array('id'=>$id));
                       
						return $str;  
	
					}

				}else{

					$dt = $_POST['dt'];

					$dt['password'] = md5($dt['password']);

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('user', $dt , array('id'=>$id));

					return $str;  
                   

				}
              
		}
    

    public function delete($id)
    {
        $file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));
        @unlink($file_dir['dir']);

        $this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
        $this->mymodel->deleteData('user',  array('id' => $id));
        header('Location:' . base_url('raider'));
    }

    public function deleteapi($id)
    {
        $file_dir = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'user'));
        @unlink($file_dir['dir']);

        $this->mymodel->deleteData('file',  array('id' => $file_dir['id']));
        $this->mymodel->deleteData('user',  array('id' => $id));
        header('Location: http://192.168.100.9:8080/raider?delete=true');
    }
}
