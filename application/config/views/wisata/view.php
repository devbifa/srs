<?php
$row = $wisata;
$row['phone'] = $this->db->query("SELECT value FROM konfig WHERE id='27'")->row("value");
?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center"><?=$row['nama_wisata']?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="">
            <?php
            $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'wisata'));
	
            if(empty($photo)){
                $photo['dir'] = base_url().'webfile/no_image.png';
            }else{
                $photo['dir'] = base_url().'admin-side/'.$photo['dir'];
            }
        $output = '
        <a href="' . base_url("wisata-detail/") . str_replace(' ', '-', strtolower($row['nama_wisata'])) . '" class="a_black">
        <div class="col-xs-12">
        <div class="box">
            <img class="" src="' . $photo['dir']. '" style="width:100%;border-radius:15px">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" align="center">
                        <p class="large">' . substr($row['nama_wisata'], 0, 25)  . '</p>
                        
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
               <p class="medium"><?=$row['deskripsi_wisata']?></p>
            </div>
        </div>
    </div>
</div>

<a href="https://api.whatsapp.com/send?phone=<?= $row['phone'] ?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin menanyakan tentang..." target="_black">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <img src="<?= base_url('assets/flaticon/whatsapp.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> Hubungi Admin
    </button>
</a>
