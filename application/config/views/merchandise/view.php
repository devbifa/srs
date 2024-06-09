<?php
$row = $merchandise;

$row['phone'] = $this->db->query("SELECT value FROM konfig WHERE id='27'")->row("value");
?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center"><?=$row['nama_merchandise']?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="">
            <?php
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
           <a href="' . base_url("merchandise-detail/") . str_replace(' ', '-', strtolower($row['nama_merchandise'])). '" class="a_black">
           <div class="col-md-12">
           <div class="box">
               <img class="" src="' . $photo['dir']. '" style="width:100%;border-radius:15px">
               <div class="box-body">
                   <div class="row">
                       <div class="col-md-12" align="center">
                           <p class="medium">
                           ' . $status . '
                           </p>
                           <p style="padding-top:5px;font-size:25px;" class="medium">Rp ' . $this->template->rupiah($row['harga_merchandise']) . '</p>
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

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body" align="justify">
               <p class="medium"><?=$row['deskripsi_merchandise']?></p>
            </div>
        </div>
    </div>
</div>

<a href="https://api.whatsapp.com/send?phone=<?= $row['phone'] ?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin menanyakan tentang..." target="_black">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <img src="<?= base_url('assets/flaticon/whatsapp.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> Hubungi Admin
    </button>
</a>
