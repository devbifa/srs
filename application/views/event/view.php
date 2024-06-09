<?php
$row = $event;

$row['phone'] = $this->db->query("SELECT value FROM konfig WHERE id='27'")->row("value");
?>


<div class="row">
    <div class="col-md-8">
        <h3 class="box-title" align="left"><?=$row['nama_event']?></h3>

<div class="row">
    <div class="col-md-12">
        <div class="">
            <?php
        $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'event'));
		$register_id = $this->mymodel->selectDataone('pendaftaran', array('event' => $row['id']));
		$pendaftar = $this->mymodel->selectWithQuery("SELECT count(id) as pendaftar from pendaftaran WHERE event = '" . $row['id'] . "' AND status_pendaftaran='Payment'");

		$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'event'));
				
				if(empty($photo)){
					$photo['dir'] = base_url().'webfile/no_image.png';
				}else{
					$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
				}
				$tanggal_penutupan = date('d M Y', strtotime($row['tanggal_penutupan']));


				if ($row['status_event'] == 'Cooming Soon') {
					$tanggal_penutupan = '-';
					$status =  '<span class="label bg-yellow round right" style="border-radius:15px;">Cooming Soon</span>';
				}  else if ($row['status_event'] == 'Masih Dibuka') {
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

				
				$output = '
				<a href="' . base_url("event/view/") . $row['id'] . '" class="a_black">
				<div class="col-md-12">
				<div class="box">
					<img class="" src="' . $photo['dir']. '" style="width:100%;border-radius:15px;border-radius:15px;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
                            <p class="medium">
                            ' . $row['tipe_pendaftaran']. '
                            </p><p class="medium">
                            ' . $status . '
                            </p>
								<p class="medium" style="margin-top:5px;">'.$tanggal.'</p>
								<p class="medium" style="margin-top:5px;">'.intval($pendaftar[0]['pendaftar']).' Verified Register</p>
								<p class="medium" style="margin-top:5px;">Penutupan : '.$tanggal_penutupan.'</p>
							</div>
						</div>
					</div>
				</div>
				</div>
				</a>';
                echo $output;
                
            ?>
        </div>
    </div>
</div>
		
    </div>
</div>

<a href="https://api.whatsapp.com/send?phone=<?= $row['phone'] ?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin menanyakan tentang..." target="_black">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <img src="<?= base_url('assets/flaticon/whatsapp.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> Hubungi Admin
    </button>
</a>

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
			<div class="col-md-12">
                <h3 class="box-title"  align="center">Syarat Pendaftaran </h3>
				</div>
            </div>
            <div class="box-body" align="center">
               <p class="medium">Biaya Pendaftaran</p>
        
               <p class="medium" style="font-size:25px;">Rp. <?= number_format($row['biaya_pendaftaran'], 0, ',', '.') ?>,- </p>
               <?php if($row['tipe_pendaftaran']=='Team'){ ?>
               <p class="medium">  Riders per Team</p>
               <p class="medium"><?= $row['jumlah_rider'] ?> Riders</p>
               <?php } ?> 
            </div>
        </div>
    </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <div class="box">
            <div class="">
                <div class="col-xs-12">
                    <div class="box-header with-border">
					<div class="col-md-12">
                        <h3 class="box-title"  align="center">Deskripsi</h3>
						</div>
                    </div>
                    <div class="box-body">
                        <?= $row['deskripsi_event'] ?>
                        <br><br><br>
						<?php
							$filedownload = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'event'));
				
							if(empty($filedownload['name'])){
								// $filedownload = base_url().'webfile/no_image.png';
							}else{
								$filedownload = '
								<a href="'.base_url().'admin-side/webfile/'.$filedownload['name'].'" target="_blank">
									<button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
										  Download Peraturan Event
									</button>
								</a>';
								echo $filedownload;
								
							}
							
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($row['status_event']=='Masih Dibuka' AND !empty($_SESSION['id'])) { ?>
<a href="<?=base_url()?>event-register/<?=$row['id']?>">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
         Daftar Sekarang!
    </button>
</a>
<?php } ?>
    <div class="row">
    	<div class="col-md-2" >
		<a href="<?= base_url('event/verified/').$this->template->sonEncode($row['id']) ?>" class="a_black">
	
			<div class="box" style="height:100px;padding: 0px; display: flex; justify-content: center; align-items: center;">
				<div class="" align="center" style="">
					<img src="<?= base_url('assets/icon/rider.png') ?>" style="width:50px;height:50px;margin-top:5px;">
					</p class="small">Verified</p>
				</div>
			</div>
			</a>
		</div>
	

  		<div class="col-md-2" >
		  <a href="<?= base_url('event/dokumentasi/').$this->template->sonEncode($row['id']) ?>" class="a_black">
			<div class="box" style="height:100px;padding: 0px; display: flex; justify-content: center; align-items: center;">
				<div class="box-body" align="center" style="">
					<img src="<?= base_url('assets/icon/gallery.png') ?>" style="width:50px;height:50px;margin-top:5px;">
					</p class="small">Dokumentasi</p>
				</div>
			</div>
	</a>
		</div>

    	<div class="col-md-2" >
		<a href="<?=$row['live_event']?>" class="a_black">
		<div class="box" style="height:100px;padding: 0px; display: flex; justify-content: center; align-items: center;">
				<div class="box-body" align="center" style="">
					<img src="<?= base_url('assets/icon/live.png') ?>" style="width:50px;height:50px;margin-top:5px;">
					</p class="small">Live Event</p>
				</div>
			</div>
			
	</a>
		</div>

    	<div class="col-md-2" >
		<a href="<?= base_url('event/champions/').$this->template->sonEncode($row['id']) ?>" class="a_black">
		<div class="box" style="height:100px;padding: 0px; display: flex; justify-content: center; align-items: center;">
				<div class="box-body" align="center" style="">
					<img src="<?= base_url('assets/icon/champion.png') ?>" style="width:50px;height:50px;margin-top:5px;">
					</p class="small">Champions</p>
				</div>
			</div>
	</a>
		</div>
   	<div class="col-md-2" >
	   <a href="<?= base_url('event') ?>" class="a_black">
			<div class="box" style="height:100px;padding: 0px; display: flex; justify-content: center; align-items: center;">
				<div class="box-body" align="center" style="">
					<img src="<?= base_url('assets/icon/event.png') ?>" style="width:50px;height:50px;margin-top:5px;">
					</p class="small">All Event</p>
				</div>
			</div>
	</a>
		</div>
   	<div class="col-md-2" >
	   <a href="<?= base_url('sponsorship') ?>" class="a_black">
			<div class="box" style="height:100px;padding: 0px; display: flex; justify-content: center; align-items: center;">
				<div class="box-body" align="center" style="">
					<img src="<?= base_url('assets/icon/sponsorship.png') ?>" style="width:50px;height:50px;margin-top:5px;">
					</p class="small">Sponsorship</p>
				</div>
			</div>
	</a>
		</div>
		</div>