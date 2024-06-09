<?php
$row = $event;

$row['phone'] = $this->db->query("SELECT value FROM konfig WHERE id='27'")->row("value");
?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center"><?=$row['nama_event']?></h3>
    </div>
</div>
<!-- <div class="row">
    <div class="col-md-12">
        <div class="row">
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
				<div class="col-xs-12">
				<div class="box">
					<img class="" src="' . $photo['dir']. '" style="width:100%;border-radius:15px">
					<div class="box-body">
						<div class="row">
							<div class="col-xs-12" align="center">
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
<a href="https://api.whatsapp.com/send?phone=<?= $row['phone'] ?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin menanyakan tentang..." target="_blank">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <img src="<?= base_url('assets/flaticon/whatsapp.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> Hubungi Admin
    </button>
</a> -->

<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Event Ranking</h3>
    </div>
</div>



<div class="">
    <div id="load_data">
    </div>
</div>
<div id="load_data_message"></div>
<script type="text/javascript">
    $(document).ready(function(){

        var limit = 4;
        var start = 0;
        var action = 'inactive'; 
        var search = 0;

        function load_data(limit, start){
            lazzy_loader(limit);
            search = <?=$this->template->sonDecode($this->uri->segment(3))?>;

            $.ajax({
                url:"<?= base_url(); ?>event/fetchchampion?keyword="+search,
                method:"POST",
                data:{limit:limit, start:start},
                cache: false,
                success:function(data)
                {
                    if(data == '') {
                        $('#load_data_message').html('<div class="row">'+
                            '<div class="col-xs-12" align="center">'+
                            'Semua Data Telah Ditampilkan'+
                            '</div>'+
                            '</div>');
                        action = 'active';
                    } else {
                        $('#load_data').append(data);
                        $('#load_data_message').html('<div class="row">'+
                            '<div class="col-xs-12" align="center">'+
                            'Tampilkan Lebih Banyak <br> <i class="fa fa-angle-down"></i>'+
                            '</div>'+
                            '</div>');
                        action = 'inactive';
                    }
                }
            })
        }

        if(action == 'inactive')
        {
            action = 'active';
            load_data(limit, start);
        }

        $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
            {
                lazzy_loader(limit);
                action = 'active';
                start = start + limit;
                setTimeout(function(){
                    load_data(limit, start);
                }, 1000);
            }
        });
    });
</script>