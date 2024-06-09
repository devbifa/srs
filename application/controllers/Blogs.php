<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Blogs extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page'] = 'NEWS - NSO PROJECT';
		$this->template->load('template/template', 'blog/index', $data);
	}

	public function view($id)
	{
		$id = $this->template->sonDecode($this->uri->segment(2));
		
		$data['news'] = $this->mymodel->selectDataone('news',  array('nama_news' => $id));
		if(empty($data['news'])){
			redirect(base_url().'news');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'news'));

		$data['page'] = 'NEWS - '.$data['event']['nama_news'];
		$this->template->load('template/template', 'blog/view', $data);
	}

	public function fetch()
	{
		$output = '';
		$search = $_GET['keyword'];
		if ($search) {
			$news = $this->mymodel->selectWithQuery("SELECT * from news WHERE nama_news LIKE '%" . $_GET['keyword'] . "%' AND status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$news = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		}
		if ($news) {
			foreach ($news as $row) {
				$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'news'));
	
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
				}

				$output .= '
				
				<div class="col-md-4">
				<a href="' . base_url("news-detail/") . $this->template->sonEncode(strtolower($row['id'])) . '" class="a_black">
				<div class="box">
					<img class="img-even" src="' . $photo['dir']. '" style="height:225px;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
								<p class="medium">' . substr($row['nama_news'], 0, 20)  . '</p>
								<p class="small">
								' . substr($row['deskripsi_news'], 0, 45) . '
								</p>
								<p class="small" style="margin-top:5px;">'.DATE('d M Y', strtotime($row['created_at'])).'</p>
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
