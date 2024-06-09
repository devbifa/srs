<?php
$row = $gallery;
$rows = $gallery;
// print_r($row);
// die;
$row['phone'] = $this->db->query("SELECT value FROM konfig WHERE id='27'")->row("value");
?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center"><?=$row['nama_gallery']?></h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="">
            <?php
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
            <a href="' . base_url("gallery-detail/") . str_replace(' ', '-', strtolower($row['nama_gallery'])) . '" class="a_black">
            <div class="col-md-12">
            <div class="box">
                <img class="" src="' . $photo['dir']. '" style="width:100%;border-radius:15x">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12" align="center">
                            <p class="large">' . substr($row['nama_gallery'], 0, 25)  . '</p>
                            <p class="medium">' . date('d M Y', strtotime($row['created_at']))  . '</p>
                            <p class="medium">
                            '.intval($gallery_item).' Images
                         
                            '.intval($komentar).' Comments
                            </p>
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
               <p class="medium"><?=$row['deskripsi_gallery']?></p>
            </div>
        </div>
    </div>
</div>


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
                            <div class="col-md-1">
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
                            <div class="col-md-11">
                                <form action="<?=base_url()?>gallery/store" method="POST">
                                <input type="hidden" name="gallery" value="<?=$rows['id']?>">
                                <textarea required name="komentar" type="text" class="form-control" placeholder="Tulis Komentar Anda..."></textarea>
                                <button type="submit" class="btn btn-blog btn-xs pull-right" style="margin-top:5px;">Kirim Komentar</button>
                                </form>
                            </div>
                        <?php }else{ ?>
                        <div class="col-md-12" align="center">
                            <p style="color:#737373;font-size: 12px;">Silahkan <a href="<?=base_url()?>login">Login</a> Terlebih Dahulu Untuk Berkomentar!</p>
                        </div>
                    <?php } ?>
                </div>
                <br>
                <?php
                $id_gallery = $row['id'];
                $komentar= $this->mymodel->selectWithQuery("SELECT * FROM komentar WHERE gallery='$id_gallery' LIMIT 5");
                
                $i = 1;
                foreach ($komentar as $row) {
                    ?>

                    <div class="row">
                        <div class="col-md-1">

                        <?php
                            $id_user = $row['pendaftar'];
                            $photo = $this->mymodel->selectDataone('file', array('table' => 'user', 'table_id' => $id_user));
                            
                            ?>
                        <?php if ($photo != null) { ?>
                                <img  width="50px" height="50px" style="border-radius: 50%"  src="<?= base_url().'admin-side/webfile/'.$photo['name'] ?>" class="img-circle" alt="User Image" height="150px" width="150px">
                            <?php } else { ?>
                                <img  width="50px" height="50px" style="border-radius: 50%" src="<?= base_url('webfile/raider/raider_default.png') ?>" class="img-circle" alt="User Image" height="150px" width="150px">
                        <?php } ?>  
                        </div>
                        <div class="col-md-11">
                            <div class="comment" style="width: 100%;">
                                <b><?php 
                                $user = $this->mymodel->selectDataone('user',  array('id' => $id_user));
                                echo $user['name']; 
                                ?></b>
                                <?php if ($verif == 'ENABLE') { ?>
                                    <img src="<?= base_url('assets/flaticon/verified.png') ?>" width="15px" height="15px">
                                <?php }
                                    if ($row['role_id']=='17') {
                                        echo "- <i>Admin</i>";
                                    }else{
                                        echo "- <i>Member</i>";
                                    }
                                         ?><br>
                                <p><?= $row['komentar'] ?></p>
                                <p style="color:#737373;font-size: 12px;">
                                    <?php
                                        if ($row['updated_at']) { ?>
                                        Diubah pada : <?= date('d M Y H:i:s', strtotime($row['updated_at'])) ?>
                                    <?php } else { ?>
                                        Dibuat pada : <?= date('d M Y H:i:s', strtotime($row['created_at'])) ?>
                                    <?php } ?>
                                </p>
                            </div>
                            <?php if ($row['pendaftar'] == $this->session->userdata('id')) { ?>
                                <div class="row" style="color:#737373;font-size: 12px; margin-bottom: 5px;">
                                    <div class="col-md-1">
                                        <a href="<?=base_url()?>gallery/edit/?komentar=<?=$row['id']?>&gallery=<?=$rows['id']?>">
                                            Edit
                                        </a>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="#!" onclick="hapus(<?=$row['id']?>)">
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } ?>
                <a href="<?= base_url('gallery-komentar/') . $this->template->sonEncode($rows['id'])?>">
                    <p style="margin-bottom:5px" align="center"><b>Komentar Lainnya</b></p>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="">
    <div id="load_data">
    </div>
</div>
<div id="load_data_message"></div>

<script type="text/javascript">
    $(document).ready(function() {

        var limit = 6;
        var start = 0;
        var action = 'inactive';
        var search = 0;

        function load_data(limit, start) {
            lazzy_loader(limit);
            search = <?=($rows['id'])?>;

            $.ajax({
                url: "<?= base_url(); ?>gallery/fetchview/?keyword=" + search,
                method: "POST",
                data: {
                    limit: limit,
                    start: start
                },
                cache: false,
                success: function(data) {
                    if (data == '') {
                        $('#load_data_message').html('<div class="row">' +
                            '<div class="col-md-12" align="center">' +
                            'Semua Data Telah Ditampilkan' +
                            '</div>' +
                            '</div>');
                        action = 'active';
                    } else {
                        $('#load_data').append(data);
                        $('#load_data_message').html('<div class="row">' +
                            '<div class="col-md-12" align="center">' +
                            'Semua Data Telah Ditampilkan' +
                            '</div>' +
                            '</div>');
                        action = 'inactive';
                    }
                }
            })
        }

        if (action == 'inactive') {
            action = 'active';
            load_data(limit, start);
        }

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive') {
                lazzy_loader(limit);
                action = 'active';
                start = start + limit;
                setTimeout(function() {
                    load_data(limit, start);
                }, 1000);
            }
        });
    });

    $("#upload-create").submit(function() {
        var form = $(this);
        var mydata = new FormData(this);
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: mydata,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response, textStatus, xhr) {
                var str = response;
                if (str.indexOf("success") != -1) {
                    location.reload();
                }
            },
            error: function(xhr, textStatus, errorThrown) {}
        });
        return false;
    });
</script>


<!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->
<script src="<?=base_url()?>assets/sweetalert.js"></script>


<!-- <script>
$(document).ready(function() {
    $('#event').DataTable({
  //"scrollX": true,            
  "initComplete": function (settings, json) {  
    $("#event").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  },
});
    } );
</script> -->

<?php
if($this->session->userdata('code')=='succes-komentar'){
?>
<script>
Swal.fire(
  'Success!',
  'Komentar Berhasil Ditambahkan!',
  'success'
)
</script>
<?php
$this->session->set_userdata('code', '');
}

?>

<?php
if($this->session->userdata('code')=='succes-edit'){
?>
<script>
Swal.fire(
  'Success!',
  'Komentar Berhasil Diedit!',
  'success'
)
</script>
<?php
$this->session->set_userdata('code', '');
}

?>

<?php
if($this->session->userdata('code')=='succes-delete'){
?>
<script>
Swal.fire(
  'Success!',
  'Komentar Berhasil Dihapus!',
  'success'
)
</script>
<?php
$this->session->set_userdata('code', '');
}
?>

<script>

function hapus(id){
    Swal.fire({
    title: 'Hapus Komentar',
    text: "Anda yakin menghapus komentar ini?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    cancelButtonText: 'Batal',
    confirmButtonText: 'Hapus!'
    }).then((result) => {
    if (result.value) {
        window.location = "<?=base_url()?>gallery/delete/?komentar="+id+"&gallery=<?=$rows['id']?>";
    }
    })
}
</script>

<script>
function edit(id){
    
}
</script>