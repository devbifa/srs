<?php
$id_gallery = $_GET['gallery'];
$id_komentar = $_GET['komentar'];
        

$komentar= $this->mymodel->selectDataone('komentar',  array('id' => $id_komentar));
?>
<div class="row">
    <div class="col-md-12">
        <div class="box">

            <?php
            $photo = $this->mymodel->selectDataone('file', array('table' => 'user', 'table_id' => $rider['id']));
            // print_r($photo);
            if(!empty($id_session)){
            ?>
           <?php if ($photo != null) { ?>
                <img src="<?= base_url().'admin-side/webfile/'.$photo['name'] ?>" class="img-circle" alt="User Image" height="150px" width="150px">
            <?php } else { ?>
                <img src="<?= base_url('webfile/raider/raider_default.png') ?>" class="img-circle" alt="User Image" height="150px" width="150px">
            <?php } ?>   
            <h3 class="box-title" style="margin-top:10px;padding:5px;"><?=$rider['name'] ?></h3>
            <p><?=$_SESSION['email']?></p>
            <?php } ?>
            <div class="box-body">
              
                <h4 style="margin-bottom:5px"><b>Komentar Gallery</b></h4>
                <br>
                <div class="row">
                    <?php if ($this->session->userdata('id')) {?>
                            <div class="col-xs-2">
                            <?php
                            $id_user = $_SESSION['id'];
                            $photo = $this->mymodel->selectDataone('file', array('table' => 'user', 'table_id' => $id_user));
                            
                            ?>
                        <?php if ($photo != null) { ?>
                                <img  width="50px" height="50px" style="border-radius: 50%"  src="<?= base_url().'admin-side/webfile/'.$photo['name'] ?>" class="img-circle" alt="User Image" height="150px" width="150px">
                            <?php } else { ?>
                                <img  width="50px" height="50px" style="border-radius: 50%" src="<?= base_url('webfile/raider/raider_default.png') ?>" class="img-circle" alt="User Image" height="150px" width="150px">
                        <?php } ?> 
                            </div>
                            <div class="col-xs-10">
                                <form action="<?=base_url()?>gallery/store-edit" method="POST">
                                <input type="hidden" name="gallery" value="<?=$id_gallery?>">
                                <input type="hidden" name="komentar" value="<?=$id_komentar?>">
                                <textarea required name="isi_komentar" type="text" class="form-control" placeholder="Tulis Komentar Anda..."><?=$komentar['komentar']?></textarea>
                                <button type="submit" class="btn btn-blog btn-xs pull-right" style="margin-top:5px;">Edit Komentar</button>
                                </form>
                            </div>
                        <?php }else{ ?>
                        <div class="col-xs-12" align="center">
                            <p style="color:#737373;font-size: 12px;">Silahkan <a href="<?=base_url()?>login">Login</a> Terlebih Dahulu Untuk Berkomentar!</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
