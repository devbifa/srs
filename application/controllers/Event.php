<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Event extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page'] = 'EVENT - NSO PROJECT';
		
		$this->template->load('template/template', 'event/index', $data);
	}

	public function champions()
	{
		$id = $this->template->sonDecode($this->uri->segment(3));
		
		$data['event'] = $this->mymodel->selectDataone('event',  array('id' => $id));
		if(empty($data['event'])){
			redirect(base_url().'event');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));

		// $data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('event' => $data['event']['id']));

		$data['page'] = 'CHAMPION - '.$data['event']['nama_event'];

		
		$this->template->load('template/template', 'event/champion', $data);
	}

	public function dokumentasi()
	{
		$id = $this->template->sonDecode($this->uri->segment(3));

		$data['event'] = $this->mymodel->selectDataone('event',  array('id' => $id));
		if(empty($data['event'])){
			redirect(base_url().'event');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));

		// $data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('event' => $data['event']['id']));

		$data['page'] = 'DOKUMETASI - '.$data['event']['nama_event'];

		
		$this->template->load('template/template', 'event/dokumentasi', $data);
	}

	public function verified()
	{
		$id = $this->template->sonDecode($this->uri->segment(3));

		$data['event'] = $this->mymodel->selectDataone('event',  array('id' => $id));
		if(empty($data['event'])){
			redirect(base_url().'event');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));

		// $data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('event' => $data['event']['id']));

		$data['page'] = 'VERIFIED - '.$data['event']['nama_event'];
		
		$this->template->load('template/template', 'event/verified', $data);
	}


	public function view($id)
	{
		$id = $this->template->sonDecode($this->uri->segment(2));

		$data['event'] = $this->mymodel->selectDataone('event',  array('id' => $id));
		if(empty($data['event'])){
			redirect(base_url().'event');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));

		// $data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('event' => $data['event']['id']));

		$data['page'] = 'EVENT - '.$data['event']['nama_event'];
		$this->template->load('template/template', 'event/view', $data);
	}

	public function gallery($id)
	{
		$data['page'] = 'Event';
		$data['event'] = $this->mymodel->selectDataone('event',  array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));

		$data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('event' => $data['event']['id']));
		$data['pendaftar'] = $this->mymodel->selectWithQuery("SELECT count(id) as pendaftar from pendaftaran WHERE event = '" . $id . "' AND approve = 'APPROVE' AND id NOT LIKE '0'");
		$data['rowraider'] = $this->mymodel->selectWithQuery("SELECT count(a.id) as rowraider from pendaftaran_raider a INNER JOIN pendaftaran b ON a.pendaftaran_id = b.id WHERE b.event = " . $id." AND b.approve = 'APPROVE' ");

		$data['subpage'] = '<b>' . $data['event']['nama_event'] . '</b>';
		$this->template->load('template/template', 'event/gallery', $data);
	}

	public function get_raider($id)
	{
		$value = $this->db->query("SELECT a.*, b.url FROM tbl_raider a INNER JOIN file b on b.table_id = a.id WHERE b.table = 'tbl_raider' AND a.id = '" . $id . "'")->result_array();
		echo json_encode($value);
	}


	public function fetch()
	{
		$output = '';

		$search = $_GET['keyword'];

		if ($search) {
			$event = $this->mymodel->selectWithQuery("SELECT * FROM event WHERE status =  'ENABLE' AND nama_event like '%$search%' ORDER BY tanggal_mulai DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$event = $this->mymodel->selectWithQuery("SELECT * FROM event WHERE status =  'ENABLE' ORDER BY tanggal_mulai DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		}
		if ($event) {
			foreach ($event as $row) {
				$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'event'));
				
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
				}
				$pendaftar = $this->mymodel->selectWithQuery("SELECT count(id) as pendaftar from pendaftaran WHERE event = '" . $row['id'] . "' AND status_pendaftaran = 'Payment' AND id NOT LIKE '0'");

				$tanggal_penutupan = date('d M Y', strtotime($row['tanggal_penutupan']));


				if ($row['status_event'] == 'Cooming Soon') {
					$tanggal_penutupan = '-';
					$status =  '<span class="label bg-yellow round right" style="border-radius:15px;">Cooming Soon</span>';
				} else if ($row['status_event'] == 'Masih Dibuka') {
					$status =  '<span class="label bg-green round right" style="border-radius:15px;">Masih Dibuka</span>';
				} else if ($row['status_event'] == 'Sudah Ditutup') {
					$status =  '<span class="label bg-red round right" style="border-radius:15px;">Sudah Ditutup</span>';
				} else {
					$status =  '<span class="label bg-blue round right" style="border-radius:15px;">Sedang Berjalan</span>';
				}
				
				$nama_event = substr($row["nama_event"], 0, 16);
				
				$tanggal = "";
				if ($row['status_event']=='Cooming Soon') { 
					$tanggal = '-';
				} else {
					$tanggal = date('d M Y', strtotime($row['tanggal_mulai'])) . "<b> s/d </b>" . date('d M Y', strtotime($row['tanggal_selesai']));
				}

				
				$output .= '
				<div class="col-md-4">
				<a href="' . base_url("event-detail/") . $this->template->sonEncode(($row['id'])). '" class="a_black">
				<div class="box">
					<img class="img-even" src="' . $photo['dir']. '" style="height:225px;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
							<p class="small">
                            ' . $row['tipe_pendaftaran']. '
                            </p>
							<p class="medium">' . $nama_event . '</p>
								<p class="medium">
								' . $status . '
								</p>
								<p class="small" style="margin-top:5px;">'.$tanggal.'</p>
								<p class="medium" style="margin-top:5px;">'.intval($pendaftar[0]['pendaftar']).' Verified Register</p>
								<p class="small" style="margin-top:5px;">Penutupan : '.$tanggal_penutupan.'</p>
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
	public function fetchdokumentasi(){
		$output = '';

		$search = $_GET['keyword'];
	 
		
	 
				 $gallery = $this->mymodel->selectWithQuery("SELECT * from gallery WHERE event  = '" . $_GET['keyword'] . "' AND status = 'ENABLE' ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
			
			 
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
	public function fetchverified()
	{
		$output = '';

		$search = $_GET['keyword'];
		
		$event = $this->mymodel->selectWithQuery("SELECT  a.id, a.tipe_pendaftaran, a.kode_pendaftaran, b.nama_team, b.kota, c.id as id_pembalap, c.nama_lengkap,c.kota,c.nomor_start,c.ukuran_jersey FROM pendaftaran a
		LEFT OUTER JOIN team b
		ON a.id = b.id_pendaftaran
		LEFT OUTER JOIN pembalap c
		ON a.id = c.id_pendaftaran
		WHERE a.event='$search' AND a.status_pendaftaran='Payment'
		ORDER BY b.nama_team ASC, c.nama_lengkap ASC
		LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));

		if ($event) {
			foreach ($event as $row) {
				$id_pembalap = $row['id_pembalap'];
				$photo = $this->mymodel->selectDataone('file', array('table_id' => $id_pembalap, 'table' => 'Pembalap'));
				
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().''.$photo['dir'];
				}
				
				if($row['tipe_pendaftaran']=='Individu'){
					$row['nama_team'] = '';
				}
				
				$output .= '
				<div class="col-md-3">
				<div class="box">
					<img class="img-even" src="' . $photo['dir']. '" style="height:255px;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
							<p class="medium">' . substr($row['nama_lengkap'],0,25) . '</p>
							<p class="medium">' . substr($row['kota'],0,25) . '</p>
							<p class="medium">' . substr($row['nomor_start'],0,25) . ' / '. substr($row['ukuran_jersey'],0,25) .'</p>
							<p class="medium">' . substr($row['nama_team'],0,25) . '</p>
								
							</div>
						</div>
					</div>
				</div>
				</div>';
			}
		}
		
		echo '<div class="row">'.$output.'</div>';
	}



	public function fetchchampion()
	{
		$output = '';

		
		$search = $_GET['keyword'];
	 
		
	 
		$event = $this->mymodel->selectWithQuery("SELECT * from champion WHERE event  = '" . $_GET['keyword'] . "' AND status = 'ENABLE' ORDER BY nama_champion ASC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
			

		if ($event) {
			foreach ($event as $row) {
				$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'event'));
				
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
				}
				$pendaftar = $this->mymodel->selectWithQuery("SELECT count(id) as pendaftar from pendaftaran WHERE event = '" . $row['id'] . "' AND status_pendaftaran = 'Payment' AND id NOT LIKE '0'");

				$tanggal_penutupan = date('d M Y', strtotime($row['tanggal_penutupan']));

				$champion_child = "";
				$content_tr = "";
				$id_champion = $row['id'];
				$champion_child = $this->mymodel->selectWithQuery("SELECT * FROM champion_item WHERE id_champion='$id_champion' ORDER BY keterangan ASC");

				
				foreach($champion_child as $key=>$c){
					$id_pendaftaran = $c['id_pendaftaran'];
					$id_event = $row['event'];
					$data_pembalap = $this->mymodel->selectWithQuery("SELECT DISTINCT(a.id), a.id, a.kode_pendaftaran, b.nama_team, c.nama_lengkap 
					FROM pendaftaran a
					LEFT OUTER JOIN team b
					ON a.id = b.id_pendaftaran
					LEFT OUTER JOIN pembalap c
					ON a.id = c.id_pendaftaran
					WHERE a.event='$id_event' AND a.status_pendaftaran='Payment' AND a.id='$id_pendaftaran'
					ORDER BY b.nama_team ASC, c.nama_lengkap ASC");
					foreach($data_pembalap as $k){ 
						$selected="";
						if (empty($k['nama_team'])){
							$k['nama_team'] = 'INDIVIDU';
							$nama = $k['nama_lengkap'];
						}else{
							$k['nama_lengkap'] = 'TEAM';
							$nama = $k['nama_team'];
						}	
						if($p['id_pendaftaran']==$k['id']){
							$selected='selected';
						}
					}

					
					$content_tr .= '<tr>
						<td>'.($key+1).'
						</td>
						<td>'.$nama.'
						</td>
						<td>'.($c['keterangan']).'
						</td>
					</tr>';
				}

				$filedownload = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'champion'));
				
				if(empty($filedownload['name'])){
					// $filedownload = base_url().'webfile/no_image.png';
				}else{
					$filedownload = '
					<a href="'.base_url().'admin-side/webfile/'.$filedownload['name'].'" target="_blank">
						<button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
							  Download Data
						</button>
					</a>';
					
				}

				
				$output .= '
				<div class="">
					<div class="col-md-12">
						<div class="box" style="padding:15px;">
						<p align="center" class="large">'.$row['nama_champion'].'</p>
						<table class="table table-bordered table-hover " style="width:100%;" id="event">
								<thead>
								<tr>
									<th>No</th>
									<th>Rider/Team</th>
									<th>Keterangan</th>
								</tr>
								</thead>
								<tbody>	
								'.$content_tr.'
								</tbody>
						</table>
						'.$filedownload.'
						</div>
						</div>
						</div>
						</div>
				';
                
            }
        }
        
		echo '<div class="">'.$output.'</div>';
	}

	public function data(){

		if(empty($_SESSION['id'])){
			redirect(base_url());
		}
		
		
		$id = $_SESSION['id'];

		$data['event'] = $this->mymodel->selectWithQuery("SELECT a.*,b.nama_event, b.tanggal_mulai, b.tanggal_selesai FROM pendaftaran a
		LEFT OUTER JOIN event b ON a.event = b.id
		WHERE a.created_by = '$id'");

		$data['page'] = 'EVENT SAYA - NSO PROJECT';
		$this->template->load('template/template', 'event/data', $data);
	}

	public function invoice(){
		$id = $this->uri->segment(3);

		$data['event'] = $this->mymodel->selectWithQuery("SELECT *,a.id as id_pendaftaran FROM pendaftaran a
		LEFT OUTER JOIN event b ON a.event = b.id
		WHERE a.kode_pendaftaran = '$id'");

		$data['page'] = 'INVOICE - '.$id;
		$this->template->load('template/template', 'event/invoice', $data);
	}

	public function event_register(){
		$id = $this->uri->segment(2);

		$data['event'] = $this->mymodel->selectDataone('event',  array('id' => $id));
		if(empty($data['event'])){
			redirect(base_url().'event');
		}
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));
		$data['rule'] = $this->mymodel->selectDataone('file', array('table_id' => $id, 'table' => 'event_rule'));

		$data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('event' => $data['event']['id']));

		// $data['pendaftar'] = $this->mymodel->selectWithQuery("SELECT count(id) as pendaftar from pendaftaran WHERE event = '" . $id . "' AND approve = 'APPROVE' AND id NOT LIKE '0'");
		// $data['rowraider'] = $this->mymodel->selectWithQuery("SELECT count(a.id) as rowraider from pendaftaran_raider a INNER JOIN pendaftaran b ON a.pendaftaran_id = b.id WHERE b.event = " . $id." AND b.approve = 'APPROVE' ");

		// $data['subpage'] = '<b>' . $data['event']['nama_event'] . '</b>';
		$data['page'] = 'EVENT - '.$data['event']['nama_event'];
		$this->template->load('template/template', 'event/register', $data);

	}

	public function galleryfetch($event)
	{
		$output = '';

		$search = $_GET['nama_event'];

		if ($search) {
			$tbl_gallery = $this->mymodel->selectWithQuery("SELECT a.*, b.imagegroup_id FROM master_imagegroup a INNER JOIN tbl_gallery b ON a.id = b.imagegroup_id WHERE a.status =  'ENABLE' AND a.id_event = '.$event.' AND a.value LIKE '%" . $_GET['nama_event'] . "%' GROUP BY b.imagegroup_id ORDER BY id DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
		} else {
			$tbl_gallery = $this->mymodel->selectWithQuery('SELECT a.*, b.imagegroup_id FROM master_imagegroup a INNER JOIN tbl_gallery b ON a.id = b.imagegroup_id WHERE a.status =  "ENABLE" AND a.id_event = ' . $event . ' GROUP BY b.imagegroup_id ORDER BY id DESC LIMIT ' . $this->input->post('limit') . ' OFFSET ' . $this->input->post('start'));
		}
		if ($tbl_gallery) {
			foreach ($tbl_gallery as $row) {
				$main_image = $this->mymodel->selectDataOne('file', array('table_id' => $row['id'], 'table' => 'master_gallery'));
				$imagecount = $this->mymodel->selectWithQuery('SELECT count(id) as imagecount from tbl_gallery WHERE status = "ENABLE" AND imagegroup_id = ' . $row['id']);

				$value = strlen($row["value"]) > 20 ? substr($row["value"], 0, 20) . "..." : $row["value"];

				$output .= '
                <div class="col-xs-6">
                    <a href="' . base_url('gallery/view/') . $row['id'] . '" class="a_black">
                        <div class="box">
                        <img class="img-even" src="' . $main_image['dir'] . '">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-12" align="center">
										<b style="font-size:15px">' . $value . '</b><br>
                                    </div>
                                    <div class="col-xs-12" align="center">
									Total : <b>' . $imagecount[0]['imagecount'] . '</b> <img src="'.base_url('assets/flaticon/sidebar_picture.png').'" style="display: unset; width: 15px; height: 15px; margin-bottom: 3px;" /> Gambar
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

	public function rank($id)
	{
		$data['page'] = 'Event';
		$data['event'] = $this->mymodel->selectDataone('event',  array('id' => $id));
		$data['file'] = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));

		$data['register_id'] = $this->mymodel->selectDataone('pendaftaran', array('event' => $data['event']['id']));
		$data['pendaftar'] = $this->mymodel->selectWithQuery("SELECT count(id) as pendaftar from pendaftaran WHERE event = '" . $id . "' AND approve = 'APPROVE' AND id NOT LIKE '0'");
		$data['rowraider'] = $this->mymodel->selectWithQuery("SELECT count(a.id) as rowraider from pendaftaran_raider a INNER JOIN pendaftaran b ON a.pendaftaran_id = b.id WHERE b.event = " . $id." AND b.approve = 'APPROVE' ");

		$data['subpage'] = '<b>' . $data['event']['nama_event'] . '</b>';
		$this->template->load('template/template', 'event/rank', $data);
	}

	public function rankfetch($id)
	{
		$output = '';

		$tbl_paket = $this->mymodel->selectWithQuery('SELECT * FROM tbl_paket WHERE id_event = ' . $id . ' ORDER BY id LIMIT ' . $this->input->post('limit') . ' OFFSET ' . $this->input->post('start'));
		if ($tbl_paket) {
			foreach ($tbl_paket as $row) {
				$rankDetail = '';
				$fileRank = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'paket_file'));
				$tbl_paket_detail = $this->db->order_by('number', 'ASC')->get_where('tbl_paket_detail', array('id_paket' => $row['id']))->result_array();

				if ($tbl_paket_detail) {
					foreach ($tbl_paket_detail as $row_detail) {
						$team = $this->mymodel->selectDataone('tbl_team', array('id' => $row_detail['id_team']));
						$fileteam = $this->mymodel->selectDataone('file', array('table_id' => $team['id'], 'table' => 'tbl_team'));

						$rider = $this->mymodel->selectDataone('tbl_raider', array('id' => $row_detail['id_raider']));

						$filerider = $this->mymodel->selectDataone('file', array('table_id' => $rider['id'], 'table' => 'tbl_raider'));

						if ($team != null) {
							$phototeam = '<img src="' . base_url('webfile/team/team_default.png') . '" width="50px" height="50px" style="border-radius:5px"><br>' . $team['name'];
							if ($fileteam != null) {
								$phototeam = '<img src="' . $fileteam['dir'] . '" width="50px" height="50px" style="border-radius:5px"><br>' . $team['name'];
							}
						} else {
							$phototeam = '<i>Tidak Terdaftar Team</i>';
						}

						if ($rider != null) {
							$photorider = '<img src="' . base_url('webfile/raider/raider_default.png') . '" width="50px" height="50px" style="border-radius:5px"><br>' . $rider['name'];
							if ($filerider != null) {
								$photorider = '<img src="' . $filerider['dir'] . '" width="50px" height="50px" style="border-radius:5px"><br>' . $rider['name'];
							}
						} else {
							$photorider = '<i>-</i>';
						}


						$rankDetail .= '<tr>
					<td>' . $row_detail['number'] . '</td>
					<td align="center">' . $phototeam . '</td>
					<td align="center">' . $photorider . '</td>
					<td>' . $row_detail['keterangan'] . '</td>
					</tr>';
					}
				} else {
					$rankDetail .= '<tr>
					<td colspan="4" align="center">Tidak ada Data</td>
					</tr>';
				}

				$filedownload = '';

				if ($fileRank) {
					$filedownload = '<a href="' . base_url('download/downloadPDFPaket/') . $fileRank['id'] . '">
						<button class="btn btn-lg btn-block btn-info btn-daftar" style="margin-bottom: 15px">
							<img src="'.base_url('assets/flaticon/download.png').'" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" />  Download
						</button>
					</a>';
				}

				$output .= '
                <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
									<div class="col-xs-12" align="center">
									<h4><b>' . $row['nama_event'] . '</b></h4>
									<table class="table table-hover">
										<thead>
											<th>Juara</th>
											<th>Team</th>
											<th>Rider</th>
											<th>Keterangan</th>
										</thead>
										<tbody>
											' . $rankDetail . '
										</tbody>
									</table>
									' . $filedownload . '
                                    </div>
								</div>
                            </div>
						</div>
                </div>';
			}
		}
		echo $output;
	}

	public function resultregister()
	{
		$data['page'] = 'Event';
		$this->template->load('template/template', 'event/resultregister', $data);
	}

	public function store()

		{

			


			if(empty($_SESSION['id'])){
				redirect(base_url());
			}

			
			
			$dt = $_POST['dt'];
			$dts = $_POST['dts'];


				$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$res = "";

				for(;;){

				for ($i = 0; $i < 7; $i++) {
					$res .= $chars[mt_rand(0, strlen($chars)-1)];
				}
					
					$query = $this->db->query("SELECT * FROM pendaftaran WHERE kode_pendaftaran='$res'")->result();
					// echo "SELECT * FROM donasi WHERE kodeDonasi='$res'";
					if(count($query)==0){
						// echo 'TIDAK ADA';
						break;
					}else{
						// echo 'ADA';
					}
				}
				
				$kode = 'NSO-'.$res;

				$id_events = $dts['event'];

				$biaya_pendaftaran = $this->db->query("SELECT biaya_pendaftaran as value FROM event WHERE id = '$id_events'")->row('value');
				
				$datas = array(
					'kode_pendaftaran' => $kode,
					'tipe_pendaftaran' => $dts['tipe_pendaftaran'],
					'biaya_pendaftaran' => $biaya_pendaftaran,
					'event' => $dts['event'],
					'created_by' => $_SESSION['id'],
					'created_at' => date('Y-m-d H:i:s'),
					'status' => "ENABLE",
					'status_pendaftaran' => "Register",
				);

				$this->db->insert('pendaftaran',$datas);

				$id_pendaftaran = $this->db->insert_id();
				

				if($dts['tipe_pendaftaran']=='Individu'){
				
				$dt['id_pendaftaran'] = $id_pendaftaran;

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('pembalap', $dt);

				$last_id = $this->db->insert_id();	    
				
				if (!empty($_FILES['file']['name'])){

					// $dir  = "webfile/";$dir  = "webfile/";
					
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

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'pembalap',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Send Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'pembalap',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Send Data');



					}
			}else{

				$dtteam = $_POST['dtteam'];
								
				$dtteam['id_pendaftaran'] = $id_pendaftaran;

				$dtteam['created_by'] = $_SESSION['id'];

				$dtteam['created_at'] = date('Y-m-d H:i:s');

				$dtteam['status'] = "ENABLE";

				$str = $this->mymodel->insertData('team', $dtteam);

				$last_id = $this->db->insert_id();	    if (!empty($_FILES['fileteam']['name'])){

		        	$dir  = "admin-side/webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('fileteam')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

					   	$file = $this->upload->data();

						$data = array(

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'team',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Send Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'team',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Send Data');



				}


				
				$dtmanager = $_POST['dtmanager'];
				
				$dtmanager['id_pendaftaran'] = $id_pendaftaran;
								
				$dtmanager['created_by'] = $_SESSION['id'];

				$dtmanager['created_at'] = date('Y-m-d H:i:s');

				$dtmanager['status'] = "ENABLE";

				$str = $this->mymodel->insertData('manager', $dtmanager);

				$last_id = $this->db->insert_id();	   
				 if (!empty($_FILES['filemanager']['name'])){

		        	$dir  = "admin-side/webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload('filemanager')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

					   	$file = $this->upload->data();

						$data = array(

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'manager',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Send Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'team',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Send Data');



				}

				
				
				
				
				

				$nama_lengkap = $_POST['nama_lengkap'];
				$alamat = $_POST['alamat'];
				$kota = $_POST['kota'];
				$tanggal_lahir = $_POST['tanggal_lahir'];
				$nomor_start = $_POST['nomor_start'];
				$nama_jersey = $_POST['nama_jersey'];
				$ukuran_jersey = $_POST['ukuran_jersey'];
				$nomor_hp = $_POST['nomor_hp'];
				$motor = $_POST['motor'];
				$golongan_darah = $_POST['golongan_darah'];
				$email = $_POST['email'];
				// print_r($dt);
				for($i=0; $i < COUNT($nama_lengkap); $i++){
				
				
				$dtk['id_pendaftaran'] = $id_pendaftaran;

				
				$dtk['nama_lengkap'] = strval($nama_lengkap[$i]);
				$dtk['alamat'] = strval($alamat[$i]);
				$dtk['kota'] = strval($kota[$i]);
				$dtk['tanggal_lahir'] = strval($tanggal_lahir[$i]);
				$dtk['nomor_start'] = strval($nomor_start[$i]);
				$dtk['nama_jersey'] = strval($nama_jersey[$i]);
				$dtk['ukuran_jersey'] = strval($ukuran_jersey[$i]);
				$dtk['nomor_hp'] = strval($nomor_hp[$i]);
				$dtk['motor'] = strval($motor[$i]);
				$dtk['golongan_darah'] = strval($golongan_darah[$i]);
				$dtk['email'] = strval($email[$i]);

				$dtk['created_by'] = $_SESSION['id'];

				$dtk['created_at'] = date('Y-m-d H:i:s');

				$dtk['status'] = "ENABLE";

				$str = $this->mymodel->insertData('pembalap', $dtk);

				$last_id = $this->db->insert_id();	

				if (!empty($_FILES["file".($i+1)]['name'])){

					// $dir  = "webfile/";$dir  = "webfile/";
					
					$dir  = "admin-side/webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



					$this->load->library('upload', $config);

					if ( ! $this->upload->do_upload("file".($i+1))){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

					   	$file = $this->upload->data();

						$data = array(

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'pembalap',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData("file", $data);

						$this->alert->alertsuccess('Success Send Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'pembalap',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData("file", $data);

					$this->alert->alertsuccess('Success Send Data');


					}
					
				}
				
			}
			
			$this->session->set_userdata('code', 'succes-invoice');
		}

		

}
