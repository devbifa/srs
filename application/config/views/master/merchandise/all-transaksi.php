<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<?php
$row = $pesanan;
?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Pesanan Saya</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="box" style="padding:15px;">
                <table class="table table-bordered table-hover " style="width:100%;" id="event">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Total Transaksi</th>
                            <th>Penerima</th>
                            <th>Alamat Penerima</th>
                            <th>Telepon Penerima</th>
                            <th>Ongkir</th>
                            <th>Tanggal Pesan</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Status</th>
                            <th>Invoice</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($row as $key=>$r){ ?>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?=$r['kodeTransaksi']?></td>
                            <td><?=$this->template->rupiah($r['totalTransaksi'])?></td>
                            <td><?=$r['nama_penerima']?></td>
                            <td><?=$r['alamatKirim']?>, <?=$r['kota']?>, <?=$r['provinsi']?></td>
                            <td><?=$r['noHubungi']?></td>
                            <td><?=$r['kurir']?>/<?=$r['biayaKurir']?></td>
                            <td><?=DATE('d M Y', strtotime($r['transaksiDibuat']))?></td>
                            <td><?=DATE('d M Y', strtotime($r['transaksiEXP']))?></td>
                            <td>
                            <?php 
                            if($r['statusTransaksi']=='WAITING_PAYMENT'){
                                echo '<span class="label bg-yellow round right" style="border-radius:15px;">Menunggu Pembayaran</span>';
                            }else if($r['statusTransaksi']=='APPROVE'){
                                echo '<span class="label bg-green round right" style="border-radius:15px;">Pembayaran Berhasil</span>';
                            }else{
                                echo '<span class="label bg-red round right" style="border-radius:15px;">Pesanan Kadaluarsa</span>';
                            }
                            ?>
                            </td>
                            <td>
                            <a style="color:green" href="<?=base_url()?>invoice/payment/<?=$r['kodeTransaksi']?>" class="label bg-green round right" style="border-radius:15px;">Invoice</a>
                            </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="<?=base_url()?>assets/alert/sweetalert2.min.css">
<script src="<?=base_url()?>assets/alert/sweetalert2.all.min.js"></script>
<script src="<?=base_url()?>assets/alert/sweetalert2.min.js"></script>


<script>
$(document).ready(function() {
    $('#event').DataTable({
  //"scrollX": true,            
  "initComplete": function (settings, json) {  
    $("#event").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  },
});
    } );
</script>

<?php
if($this->session->userdata('code')=='succes-invoice'){
?>
<script>
Swal.fire(
  'Success!',
  'Selamat Anda Berhasil Terdaftar Di Event Tersebut!',
  'success'
)
</script>
<?php
}
$this->session->set_userdata('code', '');
?>
