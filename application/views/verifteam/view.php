<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Verified Team</h3>
    </div>
</div><div class="row">
    <div class="col-md-12">
        <div class="box">
            <img class="img-detail" src="<?= $file_event['url'] ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 align="center"><?= $tbl_event['title'] ?></h4>
                        <div class="row" align="center">
                            <?php
                            if ($tbl_event['statusEvent'] == 'BERJALAN') {
                                $status =  '<span class="label bg-yellow round right" style="margin-left:5px">BERJALAN</span>';
                            } else if ($tbl_event['statusEvent'] == 'SELESAI') {
                                $status =  '<span class="label bg-green round right" style="margin-left:5px">SELESAI</span>';
                            } else if ($tbl_event['statusEvent'] == 'BATAL') {
                                $status =  '<span class="label bg-red round right" style="margin-left:5px">DIBATALKAN</span>';
                            } else {
                                $status =  '<span class="label bg-blue round right" style="margin-left:5px">DIBUKA</span>';
                            }
                            ?>
                        </div>
                        <div class="col-md-12" style="padding:0px 10px;">
                            <p style="text-align:center;">
                                <!--<i class="fa fa-globe"></i> <?= $tbl_event['kota'] ?><br>-->
                                <?= $tbl_event['alamat'] ?>
                            </p>
                            <!-- <a href="https://maps.google.com/?q=<?= $tbl_event['alamat'] ?>">
                            <button class="btn btn-md btn-block btn-info"> <i></i> Lihat Peta Di Google Maps</button>
                        </a> -->
                        </div>
                    </div>
                </div>
                <hr style="margin-top:5px; margin-bottom: 5px;">
                <div class="row">
                    <div class="col-xs-6">
                        Tanggal Event :
                        <br>
                        <small>
                            <?php if ((!$tbl_event['tgleventStart']) || (!$tbl_event['tgleventEnd'])) { ?>
                                <b>Coming Soon</b>
                            <?php  } else { ?>
                                <?= date('d M Y', strtotime($tbl_event['tgleventStart'])) . "<b> s/d </b>" . date('d M Y', strtotime($tbl_event['tgleventEnd'])) ?>
                            <?php } ?>
                        </small>
                    </div>
                    <div class="col-xs-6" align="right">
                        Pendaftar :
                        <b>
                            <img src="<?= base_url('assets/flaticon/icon_team.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px; margin-right: 3px" /><?= $rowteam[0]['rowteam'] ?>
                        </b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="https://api.whatsapp.com/send?phone=<?= $tbl_event['phone'] ?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin menanyakan tentang..." target="_black">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <img src="<?= base_url('assets/flaticon/whatsapp.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /> Hubungi Admin
    </button>
</a>
<div class="row">
    <div class="col-md-12">
        <form role="form" action="<?= base_url('verifteam/view/' . $tbl_event['id']) ?>" method="GET">
            <div class="form-group">
                <label>Cari Team</label>
                <input type="text" name="name" class="form-control" <?php if ($_GET['name']) {
                                                                        echo 'value="' . $_GET['name'] . '"';
                                                                    } ?> id="filter-search">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-block btn-primary">
                    Cari
                </button>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div id="load_data">
    </div>
</div>
<div id="load_data_message"></div>
<script type="text/javascript">
    $(document).ready(function() {

        var limit = 10;
        var start = 0;
        var action = 'inactive';
        var search = 0;

        function load_data(limit, start) {
            lazzy_loader(limit);
            search = $('#filter-search').val();

            $.ajax({
                url: "<?= base_url('verifteam/fetchteam/' . $tbl_event['id']); ?>?name=" + search,
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
                            'Semua Team Pendaftar telah Ditampilkan' +
                            '</div>' +
                            '</div>');
                        action = 'active';
                    } else {
                        $('#load_data').append(data);
                        $('#load_data_message').html('<div class="row">' +
                            '<div class="col-xs-12" align="center">' +
                            'Tampilkan Lebih Banyak <br> <i class="fa fa-angle-down"></i>' +
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
</script>