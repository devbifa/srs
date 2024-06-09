<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Gallery</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <img class="img-gallery-view" src="<?= $main_image['url'] ?>" alt="Third slide">
            <div class="box-body">
                <div align="center">
                    <h4 align="center"><?= $subpage ?></h4>
                    <small>
                        Dibuat pada tgl : <?= date('d M Y', strtotime($id['created_at'])) ?>
                    </small>
                </div>
                <hr style="margin:5px">
                <h4 style="margin-bottom:5px"><b>Komentar Gallery</b></h4>
                <div class="row">
                    <?php if ($this->session->userdata('id') != NULL) {
                        if ($this->session->userdata('role') == 'Team') { ?>
                            <div class="col-xs-2">
                                <img src="https://images.pexels.com/photos/594610/pexels-photo-594610.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260" width="50px" height="50px" style="border-radius: 50%">
                            </div>
                            <div class="col-xs-10">
                                <input type="text" class="form-control" placeholder="Tulis Komentar anda...">
                            </div>
                        <?php } else {
                                $photo = $this->mymodel->selectDataone('file', array('table' => 'tbl_raider', 'table_id' => $this->session->userdata('id')));
                                ?>
                            <div class="col-xs-2">
                                <?php if ($photo != null) { ?>
                                    <img src="<?= $photo['url'] ?>" width="50px" height="50px" style="border-radius: 50%">
                                <?php } else { ?>
                                    <img src="https://m.nsoproject.com/webfiles/raider/raider_default.png" width="50px" height="50px" style="border-radius: 50%">
                                <?php } ?>
                            </div>
                            <form method="POST" action="<?= base_url('gallery/comment') ?>" id="upload-create">
                                <div class="col-xs-10">
                                    <input type="text" class="form-control" name="dt[comment]" placeholder="Tulis Komentar anda...">
                                    <input type="hidden" name="dt[imagegroup_id]" value="<?= $id['id'] ?>">
                                </div>
                            </form>
                        <?php }
                        } else { ?>
                        <div class="col-xs-12" align="center">
                            <p style="color:#737373;font-size: 12px;">Silakan Login Terlebih Dahulu untuk berkomentar!</p>
                        </div>
                    <?php } ?>
                </div>
                <br>
                <?php
                $i = 1;
                foreach ($tbl_comment as $row) {
                    $name = '';
                    $src = '';

                    $verif = '';

                    if ($row['id_raider']) {
                        $tbl_raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $row['id_raider']));
                        $file = $this->mymodel->selectDataone('file', array('table_id' => $row['id_raider'], 'table' => 'tbl_raider'));

                        $url = $file['url'];
                        if (!$url) {
                            $url = 'https://m.nsoproject.com/webfiles/raider/raider_default.png';
                        }

                        $name = $tbl_raider['name'];
                        $src = $url;
                        $verif = $tbl_raider['verificacion'];
                    } elseif ($row['id_user']) {
                        $user = $this->mymodel->selectDataone('user', array('id' => $row['id_user']));
                        $file = $this->mymodel->selectDataone('file', array('table_id' => $row['id_user'], 'table' => 'user'));

                        $url = $file['url'];
                        if (!$url) {
                            $url = 'https://admin.nsoproject.com/webfiles/users/6950c16c9bcc6995f376b297f163175942635.jpg';
                        }

                        $name = $user['name'];
                        $src = $url;
                        $verif = '';
                    } ?>

                    <div class="row">
                        <div class="col-xs-2">
                            <img src="<?= $src ?>" width="50px" height="50px" style="border-radius: 50%">
                        </div>
                        <div class="col-xs-10">
                            <div class="comment">
                                <b><?= $name ?></b>
                                <?php if ($verif == 'ENABLE') { ?>
                                    <img src="<?= base_url('assets/flaticon/verified.png') ?>" width="15px" height="15px">
                                <?php }
                                    if ($row['id_user']) {
                                        echo "- <i>Admin</i>";
                                    } ?><br>
                                <p><?= $row['comment'] ?></p>
                                <p style="color:#737373;font-size: 12px;">
                                    <?php
                                        if ($row['updated_at']) { ?>
                                        Diubah pada : <?= date('d M Y H:i:s', strtotime($row['updated_at'])) ?>
                                    <?php } else { ?>
                                        Dibuat pada : <?= date('d M Y H:i:s', strtotime($row['created_at'])) ?>
                                    <?php } ?>
                                </p>
                            </div>
                            <?php if ($row['id_raider'] == $this->session->userdata('id')) { ?>
                                <div class="row" style="color:#737373;font-size: 12px; margin-bottom: 5px;">
                                    <div class="col-xs-1">
                                        <a href="<?= base_url('comment/edit/') . $row['id'] ?>">
                                            Edit
                                        </a>
                                    </div>
                                    <div class="col-xs-1">
                                        <a href="<?= base_url('comment/delete/') . $row['id'] . '/' . $row['imagegroup_id'] . '/view' ?>">
                                            Hapus
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php
                } ?>
                <a href="<?= base_url('gallery/commentview/') . $id['id'] ?>">
                    <p style="margin-bottom:5px" align="center"><b>Komentar Lainnya</b></p>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="load_data">
    </div>
</div>
<div id="load_data_message"></div>

<script type="text/javascript">
    $(document).ready(function() {

        var limit = 3;
        var start = 0;
        var action = 'inactive';
        var search = 0;

        function load_data(limit, start) {
            lazzy_loader(limit);
            search = $('#filter-search').val();

            $.ajax({
                url: "<?= base_url(); ?>gallery/fetchview/<?= $id['id'] ?>?name=" + search,
                method: "POST",
                data: {
                    limit: limit,
                    start: start
                },
                cache: false,
                success: function(data) {
                    if (data == '') {
                        $('#load_data_message').html('<div class="row">' +
                            '<div class="col-xs-12" align="center">' +
                            'Semua Gambar telah Ditampilkan' +
                            '</div>' +
                            '</div>');
                        action = 'active';
                    } else {
                        $('#load_data').append(data);
                        $('#load_data_message').html('<div class="row">' +
                            '<div class="col-xs-12" align="center">' +
                            'Semua Gambar telah Ditampilkan' +
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