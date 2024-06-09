<?php

$row['phone'] = $this->db->query("SELECT value FROM konfig WHERE id='27'")->row("value");

$row = $event[0];
$id_pendaftaran = $row['id_pendaftaran'];
$team = $this->mymodel->selectWithQuery("SELECT * FROM team WHERE id_pendaftaran='$id_pendaftaran'");
$manager = $this->mymodel->selectWithQuery("SELECT * FROM manager WHERE id_pendaftaran='$id_pendaftaran'");
$pembalap = $this->mymodel->selectWithQuery("SELECT * FROM pembalap WHERE id_pendaftaran='$id_pendaftaran'");

?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Invoice <?=$row['kode_pendaftaran']?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
				<div class="box">
                <div class="box-body">
                  <table class="table table-bordered">
                    <tbody>
                    <tr>
                      <th colspan=2  style="text-align:center;color:green;">DATA EVENT</th>
                    </tr>
                    <tr>
                      <th>Kode Pendafataran</th>
                      <th><?=$row['kode_pendaftaran']?> 
                      <br>
                      <?php 
                            if($row['status_pendaftaran']=='Register'){
                                echo '<span class="label bg-yellow round right" style="border-radius:15px;margin:0px;">Register</span>';
                            }else if($row['status_pendaftaran']=='Payment'){
                                echo '<span class="label bg-green round right" style="border-radius:15px;margin:0px;">Payment</span>';
                            }else{
                                echo '<span class="label bg-red round right" style="border-radius:15px;margin:0px;">Cancel</span>';
                            }
                            ?>
                      </th>
                    </tr>
                    <tr>
                      <th>Event</th>
                      <th><?=$row['nama_event']?></th>
                    </tr>
                    <tr>
                      <th>Tipe Event</th>
                      <th><?=$row['tipe_pendaftaran']?></th>
                    </tr>
                    <tr>
                      <th>Tanggal Event</th>
                      <th><?=DATE('d M Y', strtotime($row['tanggal_mulai']))?>
                      <br>
                      s/d
                      <br>
                      <?=DATE('d M Y', strtotime($row['tanggal_selesai']))?>
                      </th>
                    </tr>
                    <tr>
                      <th>Biaya Pendaftaran</th>
                      <th>Rp <?= $this->template->rupiah($row['biaya_pendaftaran'])?>
                      </th>
                    </tr>
                    <tr>
                      <th>Lokasi Event</th>
                      <th><?=$row['lokasi_event']?></th>
                    </tr>
                    <?php if($row['tipe_pendaftaran']=='Individu'){ ?>
                        <?php foreach($pembalap as $key=>$p){ ?>

<tr>
                  <th colspan=2  style="text-align:center;color:green;">DATA PEMBALAP <?=$key+1?></th>
                </tr>
                <tr>
                  <th>Nama Lengkap</th>
                  <th><?=$p['nama_lengkap']?></th>
                </tr>
                <tr>
                  <th>Alamat</th>
                  <th><?=$p['alamat']?></th>
                </tr>
                <tr>
                  <th>Kota</th>
                  <th><?=$p['kota']?></th>
                </tr>
                <tr>
                  <th>Tanggal Lahir</th>
                  <th><?=DATE('d M Y', strtotime($p['tanggal_lahir']))?></th>
                </tr>
                <tr>
                  <th>Nomor Start</th>
                  <th><?=$p['nomor_start']?></th>
                </tr>
                <tr>
                  <th>Nama Jersey</th>
                  <th><?=$p['nama_jersey']?></th>
                </tr>
                <tr>
                  <th>Ukuran Jersey</th>
                  <th><?=$p['ukuran_jersey']?></th>
                </tr>
                <tr>
                  <th>Nomor HP</th>
                  <th><?=$p['nomor_hp']?></th>
                </tr>
                <tr>
                  <th>Motor</th>
                  <th><?=$p['motor']?></th>
                </tr>
                <tr>
                  <th>Golongan Darah</th>
                  <th><?=$p['golongan_darah']?></th>
                </tr>
                <tr>
                  <th>Email</th>
                  <th><?=$p['email']?></th>
                </tr>

<?php } ?>
                    <?php } ?>
                    <?php if($row['tipe_pendaftaran']=='Team'){ ?>
                    
                        <tr>
                      <th colspan=2  style="text-align:center;color:green;">DATA TEAM</th>
                    </tr>
                    <tr>
                      <th>Nama Team</th>
                      <th><?=$team[0]['nama_team']?></th>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <th><?=$team[0]['alamat']?></th>
                    </tr>
                    <tr>
                      <th>Kota</th>
                      <th><?=$team[0]['kota']?></th>
                    </tr>
                    <tr>
                      <th>Nomor HP</th>
                      <th><?=$team[0]['nomor_hp']?></th>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <th><?=$team[0]['email']?></th>
                    </tr>

<?php foreach($pembalap as $key=>$p){ ?>

    <tr>
                      <th colspan=2  style="text-align:center;color:green;">DATA PEMBALAP <?=$key+1?></th>
                    </tr>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th><?=$p['nama_lengkap']?></th>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <th><?=$p['alamat']?></th>
                    </tr>
                    <tr>
                      <th>Kota</th>
                      <th><?=$p['kota']?></th>
                    </tr>
                    <tr>
                      <th>Tanggal Lahir</th>
                      <th><?=DATE('d M Y', strtotime($p['tanggal_lahir']))?></th>
                    </tr>
                    <tr>
                      <th>Nomor Start</th>
                      <th><?=$p['nomor_start']?></th>
                    </tr>
                    <tr>
                      <th>Nama Jersey</th>
                      <th><?=$p['nama_jersey']?></th>
                    </tr>
                    <tr>
                      <th>Ukuran Jersey</th>
                      <th><?=$p['ukuran_jersey']?></th>
                    </tr>
                    <tr>
                      <th>Nomor HP</th>
                      <th><?=$p['nomor_hp']?></th>
                    </tr>
                    <tr>
                      <th>Motor</th>
                      <th><?=$p['motor']?></th>
                    </tr>
                    <tr>
                      <th>Golongan Darah</th>
                      <th><?=$p['golongan_darah']?></th>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <th><?=$p['email']?></th>
                    </tr>

<?php } ?>

                    <tr>
                      <th colspan=2  style="text-align:center;color:green;">DATA MANAGER</th>
                    </tr>
                    <tr>
                      <th>Nama Manager</th>
                      <th><?=$manage[0]['nama_manager']?></th>
                    </tr>
                    <tr>
                      <th>Alamat</th>
                      <th><?=$team[0]['alamat']?></th>
                    </tr>
                    <tr>
                      <th>Kota</th>
                      <th><?=$team[0]['kota']?></th>
                    </tr>
                    <tr>
                      <th>Nomor HP</th>
                      <th><?=$team[0]['nomor_hp']?></th>
                    </tr>
                    <tr>
                      <th>Email</th>
                      <th><?=$team[0]['email']?></th>
                    </tr>

                    

                    <?php }else{ ?>

                    <?php } ?>

                  </tbody></table>
                  <hr>
                  <tr>
                      <th>Biaya Pendaftaran</th>
                      <th><p  style="font-size:25px;">Rp <?= $this->template->rupiah($row['biaya_pendaftaran'])?></p>
                      </th>
                    </tr>
                  <hr>
                  <span> * Lakukan <b>Pembayaran</b> sesuai dengan nominal <b>biaya pendaftaran</b> yang ada pada invoice ini dan segera konfirmasi ke Admin.</span>
                <br>
                <br>
                NSO PROJECT
                <br>

Perum. Permata Jingga Blok X G7 No. 35
                </div>
                </div>
            </div>
        </div>
    </div>
</div>



<a href="https://api.whatsapp.com/send?phone=<?= $row['phone'] ?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin melakukan konfirmasi pembayaran invoice dengan kode pendaftaran <?=$row['kode_pendaftaran']?>." target="_black">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <img src="<?= base_url('assets/flaticon/whatsapp.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> Hubungi Admin
    </button>
</a>
