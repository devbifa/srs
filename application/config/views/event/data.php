<link rel="stylesheet" href="<?=base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<script src="<?=base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<?php
$row = $event;
?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Event Saya</h3>
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
                            <th>Tipe Event</th>
                            <th>Biaya Pendaftaran</th>
                            <th>Tanggal Daftar</th>
                            <th>Tanggal Event</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th>Invoice</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($row as $key=>$r){ ?>
                        <tr>
                            <td><?=$key+1?></td>
                            <td><?=$r['kode_pendaftaran']?></td>
                            <td><?=$r['tipe_pendaftaran']?></td>
                            <td><?=$this->template->rupiah($r['biaya_pendaftaran'])?></td>
                            <td><?=DATE('d M Y', strtotime($r['created_at']))?></td>
                            <td><?=DATE('d M Y', strtotime($r['tanggal_mulai']))?>
                            <br>
                            <?=DATE('d M Y', strtotime($r['tanggal_selesai']))?>
                            </td>
                            <td><a style="color:green" href="<?=base_url()?>event-detail/<?=str_replace(' ', '-', strtolower($r['nama_event']))?>"><?=$r['nama_event']?></a></td>
                            <td>
                            <?php 
                            if($r['status_pendaftaran']=='Register'){
                                echo '<span class="label bg-yellow round right" style="border-radius:15px;">Register</span>';
                            }else if($r['status_pendaftaran']=='Payment'){
                                echo '<span class="label bg-green round right" style="border-radius:15px;">Payment</span>';
                            }else{
                                echo '<span class="label bg-red round right" style="border-radius:15px;">Cancel</span>';
                            }
                            ?>
                            </td>
                            <td>
                            <a style="color:green" href="<?=base_url()?>event/invoice/<?=$r['kode_pendaftaran']?>" class="label bg-green round right" style="border-radius:15px;">Invoice</a>
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
<div class="row">
    <div class="col-md-12">
<a href="https://api.whatsapp.com/send?phone=<?= $row['phone'] ?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin menanyakan tentang..." target="_black">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <img src="<?= base_url('assets/flaticon/whatsapp.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> Hubungi Admin
    </button>
</a>

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
