<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Gallery extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page'] = 'Gallery';
        $this->template->load('template/template', 'gallery/index', $data);
    }

    public function view($id)
    {
        $id = $this->template->sonDecode($this->uri->segment(2));
        $data['gallery'] = $this->mymodel->selectDataone('gallery',  array('id' => $id));
        $id_gallery = $data['gallery']['id'];
        $data['komentar'] = $this->mymodel->selectWithQuery("SELECT * FROM komentar WHERE gallery='$id_gallery' LIMIT 5");
        // print_r($data['komentar'] );die;
        if(empty($data['gallery'])){
			redirect(base_url().'gallery');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'gallery'));

		// $data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('gallery' => $data['gallery']['id']));

		$data['page'] = 'GALLERY - '.$data['gallery']['nama_gallery'];

        $this->template->load('template/template', 'gallery/view', $data);
    }

    public function komentar()
    {
        $id = $this->template->sonDecode($this->uri->segment(2));

        $data['gallery'] = $this->mymodel->selectDataone('gallery',  array('id' => $id));
        if(empty($data['gallery'])){
			redirect(base_url().'gallery');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'gallery'));

		// $data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('gallery' => $data['gallery']['id']));

		$data['page'] = 'GALLERY - '.$data['gallery']['nama_gallery'];

        $this->template->load('template/template', 'gallery/data-komentar', $data);
    }


    public function fetch()
    {
        $output = '';

   $search = $_GET['keyword'];

   

        if ($search) {
			$gallery = $this->mymodel->selectWithQuery("SELECT * from gallery WHERE nama_gallery  LIKE '%" . $_GET['keyword'] . "%' AND status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$gallery = $this->mymodel->selectWithQuery("SELECT * FROM gallery WHERE status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		}
        if ($gallery) {
            foreach ($gallery as $row) {
                // $main_image = $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'gallery_item'));
                // $imagecount = $this->mymodel->selectWithQuery('SELECT count(id) as imagecount from gallery WHERE status = "ENABLE" AND imagegroup_id = ' . $row['id']);

                $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'gallery'));
	
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
                }
                $id_gallery = $row['id'];
                $gallery_item = $this->db->query("SELECT count(a.id) as value FROM gallery_item a where a.gallery='$id_gallery'")->row('value');
                $komentar = $this->db->query("SELECT count(a.id) as value FROM komentar a where a.gallery='$id_gallery'")->row('value');


				$output .= '
				<div class="col-md-4">
				<a href="' . base_url("gallery-detail/") . $this->template->sonEncode(($row['id'])) . '" class="a_black">
				<div class="box">
					<img class="img-even" src="' . $photo['dir']. '" style="height:225px;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
								<p class="medium">' . substr($row['nama_gallery'], 0, 20)  . '</p>
                                <p class="small">' . date('d M Y', strtotime($row['created_at']))  . '</p>
                                <p class="small">
								'.intval($gallery_item).' Images
                             
								'.intval($komentar).' Comments
								</p>
							</div>
						</div>
					</div>
				</div>
				</a>
				</div>';
            }
        }
       
		echo '<div class="row">'.$output.'</div>';
    }

    public function fetchview()
    {
        $output = '';

        $search = $_GET['keyword'];

        
        $gallery = $this->mymodel->selectWithQuery('SELECT * FROM gallery_item WHERE  gallery = ' . $search . ' ORDER BY id ASC LIMIT ' . $this->input->post('limit') . ' OFFSET ' . $this->input->post('start'));
        
        if ($gallery) {
            foreach ($gallery as $row) {
                // $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'gallery'));
	
				if(empty($row['file'])){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/webfile/'.$row['file'];
                }
                $output .= '
                <div class="col-md-4">
                    <div class="box">
                    <img class="img-even" src="' . $photo['dir'] . '" style="width:100%; height:275px;border-radius:15px;">
                    </div>
                </div>';
            }
        }
       
		echo '<div class="row">'.$output.'</div>';
    }


    public function fetchkomentar()
    {
        $output = '';

        $search = $_GET['keyword'];

        $id_gallery = $data['gallery']['id'];
        
        $gallery = $this->mymodel->selectWithQuery('SELECT * FROM komentar WHERE gallery = ' . $search . ' ORDER BY id ASC LIMIT ' . $this->input->post('limit') . ' OFFSET ' . $this->input->post('start'));
        
        if ($gallery) {
            foreach ($gallery as $row) {

                $id_user = $row['pendaftar'];
                $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['pendaftar'], 'table' => 'user'));
	
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/webfile/'.$photo['name'];
                }
       
                
                                $user = $this->mymodel->selectDataone('user',  array('id' => $id_user));
                                  
                                                          
                                    if ($row['role_id']=='17') {
                                        $role = 'Admin';
                                    }else{
                                        $role = 'Member';
                                    }
                                      
                                    if ($row['pendaftar'] == $this->session->userdata('id')) { 
                                       $edit =  '<div class="row" style="color:#737373;font-size: 12px; margin-bottom: 5px;">
                                            <div class="col-md-1">
                                                <a href="'.base_url().'gallery/edit/?komentar='.$row['id'].'&gallery='.$search.'">
                                                    Edit
                                                </a>
                                            </div>
                                            <div class="col-md-1">
                                                <a href="#!" onclick="hapus('.$row['id'].')">
                                                    Hapus
                                                </a>
                                            </div>
                                        </div>';
                                    }
                              

                                  
                                        if ($row['updated_at']) {
                                         $ubah = 'Diubah pada : '.date('d M Y H:i:s', strtotime($row['updated_at']));
                                     } else { 
                                        $ubah = 'Dibuat pada : '.date('d M Y H:i:s', strtotime($row['created_at']));
                                    } 


                $output .= '<div class="row">
                        <div class="col-md-1">
                            <img  width="50px" height="50px" style="border-radius: 50%"  src="'.$photo['dir'].'" class="img-circle" alt="User Image" height="150px" width="150px">
                               
                        </div>
                        <div class="col-md-11">
                            <div class="comment" style="width: 100%;">
                                <b>
                                '.$user['name'].'</b> - <i>'.$role.'</i><br>
                                <p>'.$row['komentar'].'</p>
                                <p style="color:#737373;font-size: 12px;">
                                    '.$ubah.'
                                </p>
                            </div>
                            '.$edit.'
                            
                        </div>
                    </div>';
                
            }
        }
       
		echo '<div class="col-md-12">'.$output.'</div>';
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
        $data['page'] = 'Gallery';
        $data['id'] = $this->mymodel->selectDataone('gallery', array('id' => $id));
        $data['main_image'] = $this->mymodel->selectDataOne('file', array('table_id' => $data['id']['id'], 'table' => 'gallery_item'));
        $data['subpage'] = '<b>' . $data['id']['value'] . '</b>';

        $this->template->load('template/template', 'gallery/commentview', $data);
    }

    function store(){

                if(empty($_SESSION['id'])){
                    redirect(base_url());
                }
       
                $dtteam['gallery'] = $_POST['gallery'];

                $dtteam['komentar'] = $_POST['komentar'];

                $dtteam['pendaftar'] = $_SESSION['id'];

				$dtteam['created_by'] = $_SESSION['id'];

				$dtteam['created_at'] = date('Y-m-d H:i:s');

				$dtteam['status'] = "ENABLE";

				$str = $this->mymodel->insertData('komentar', $dtteam);
			
                $this->session->set_userdata('code', 'succes-komentar');

                $id = $_POST['gallery'];
                
                $nama_gallery = $this->db->query("SELECT id as nama_gallery FROM gallery WHERE id='$id'")->row('nama_gallery');
                
                redirect(base_url().'gallery-komentar/'. str_replace(' ', '-', strtolower($nama_gallery)));

    }

    function delete(){
        

        if(empty($_SESSION['id'])){
            redirect(base_url());
        }

        
        $this->session->set_userdata('code', 'succes-delete');
       
        $id_gallery = $_GET['gallery'];
        $id_komentar = $_GET['komentar'];
                
        $nama_gallery = $this->db->query("SELECT nama_gallery FROM gallery a WHERE id='$id_gallery'")->row('nama_gallery');

        $this->db->delete('komentar', array('id' => $id_komentar)); 
    
        $nama_gallery = $this->db->query("SELECT id as nama_gallery FROM gallery WHERE id='$id_gallery'")->row('nama_gallery');
                
        redirect(base_url().'gallery-komentar/'. str_replace(' ', '-', strtolower($nama_gallery)));

}

function store_edit(){
        

    if(empty($_SESSION['id'])){
        redirect(base_url());
    }

    
    $this->session->set_userdata('code', 'succes-edit');
   
 $id_gallery = $_POST['gallery'];
 $id_komentar = $_POST['komentar'];
            
$data['komentar'] = $_POST['isi_komentar'];

    $this->db->where('id', $id_komentar);
    $this->db->update('komentar', $data);

    $nama_gallery = $this->db->query("SELECT id as nama_gallery FROM gallery WHERE id='$id_gallery'")->row('nama_gallery');
                
    redirect(base_url().'gallery-komentar/'. str_replace(' ', '-', strtolower($nama_gallery)));

}

function edit(){

    if(empty($_SESSION['id'])){
        redirect(base_url());
    }
    $this->template->load('template/template', 'gallery/edit-komentar', $data);

}
}
