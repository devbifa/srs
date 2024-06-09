<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Merchandise extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page'] = 'MERCHANDISE - NSO PROJECT';
		$this->template->load('template/template', 'merchandise/index', $data);
	}

	public function view($id)
	{
		
		$id = $this->template->sonDecode($this->uri->segment(2));
		
		$data['merchandise'] = $this->mymodel->selectDataone('merchandise',  array('id' => $id));
		// print_r($data['merchandise']);
		if(empty($data['merchandise'])){
			redirect(base_url().'merchandise');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'merchandise'));
		$data['file_detail'] = $this->mymodel->selectWhere('file',array('table_id'=>$id,'table'=>'merchandise_detail'));
		$data['subpage'] = '<b>' . $data['merchandise']['title'] . '</b>';
		
		$data['page'] = 'MERCHANDISE - '.$data['merchandise']['nama_event'];
		$this->template->load('template/template', 'merchandise/view', $data);
	}
	public function fetch()
	{
		$output = '';

		$search = $_GET['keyword'];

		if ($search) {
			$merchandise = $this->mymodel->selectWithQuery("SELECT * from merchandise WHERE nama_merchandise LIKE '%" . $_GET['keyword'] . "%' AND status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$merchandise = $this->mymodel->selectWithQuery("SELECT * FROM merchandise WHERE status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		}
		if ($merchandise) {
			foreach ($merchandise as $row) {
			
			$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'merchandise'));
			
			if(empty($photo)){
				$photo['dir'] = base_url().'webfile/no_image.png';
			}else{
				$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
			}
			
			if ($row['stok_tersedia'] == 'IYA') {
				$status =  '<span class="label bg-green round right" style="border-radius:15px;">Stok Tersedia</span>';
			}  else {
				$status =  '<span class="label bg-red round right" style="border-radius:15px;">Stok Habis</span>';
			}
			
			$nama_event = substr($row["nama_merchandise"], 0, 16);
			
			$tanggal = "";
			if ($row['status_event']=='Cooming Soon') { 
				$tanggal = '-';
			} else {
				$tanggal = date('d M Y', strtotime($row['tanggal_mulai'])) . "<b> s/d </b>" . date('d M Y', strtotime($row['tanggal_selesai']));
			}

			$tanggal_penutupan = date('d M Y', strtotime($row['tanggal_penutupan']));

			$output .= '
			<div class="col-md-4">
			<a href="' . base_url("merchandise-detail/") . $this->template->sonEncode(strtolower($row['id'])). '" class="a_black">
			<div class="box">
				<img class="img-even" src="' . $photo['dir']. '" style="height:225px;">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12" align="center">
							<p class="medium">' . $nama_event . '</p>
							<p class="medium">
							' . $status . '
							</p>
							<p style="padding-top:5px;" class="medium">Rp ' . $this->template->rupiah($row['harga_merchandise']) . '</p>
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
