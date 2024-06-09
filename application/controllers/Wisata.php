<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Wisata extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page'] = 'WISATA - NSO PROJECT';
		$this->template->load('template/template', 'wisata/index', $data);
	}

	public function view($id)
	{
		$id = $this->template->sonDecode($this->uri->segment(2));

		$data['wisata'] = $this->mymodel->selectDataone('wisata',  array('id' => $id));
		if(empty($data['wisata'])){
			redirect(base_url().'wisata');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'wisata'));

		// $data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('wisata' => $data['wisata']['id']));

		$data['page'] = 'WISATA - '.$data['wisata']['nama_wisata'];
		
		$this->template->load('template/template', 'wisata/view', $data);
	}

	public function fetch()
	{
		$output = '';
		$search = $_GET['keyword'];
		if ($search) {
			$wisata = $this->mymodel->selectWithQuery("SELECT * from wisata WHERE nama_wisata LIKE '%" . $_GET['keyword'] . "%' AND status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$wisata = $this->mymodel->selectWithQuery("SELECT * FROM wisata WHERE status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		}
		if ($wisata) {
			foreach ($wisata as $row) {
				$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'wisata'));
	
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
				}

				$output .= '
				<div class="col-md-4">
				<a href="' . base_url("wisata-detail/") . $this->template->sonEncode(strtolower($row['id'])) . '" class="a_black">
				<div class="box">
					<img class="img-even" src="' . $photo['dir']. '" style="height:225px;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
								<p class="medium">' . substr($row['nama_wisata'], 0, 20)  . '</p>
								<p class="small">
								' . substr($row['deskripsi_news'], 0, 45) . '
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
}
