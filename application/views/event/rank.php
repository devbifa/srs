<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Event</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <img class="img-detail" src="<?= $file['url'] ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 align="center"><?= $tbl_event['title'] ?></h4>
                        <div class="row" align="center">
                            <?php
                            if ($tbl_event['statusEvent'] == 'BERJALAN') {
                                echo '<span class="label bg-yellow round right" style="margin-left:5px">BERJALAN</span>';
                            } else if ($tbl_event['statusEvent'] == 'SELESAI') {
                                echo '<span class="label bg-green round right" style="margin-left:5px">SELESAI</span>';
                            } else if ($tbl_event['statusEvent'] == 'BATAL') {
                                echo '<span class="label bg-red round right" style="margin-left:5px">DIBATALKAN</span>';
                            } else {
                                echo '<span class="label bg-blue round right" style="margin-left:5px">DIBUKA</span>';
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
                        <br>
                        <b>
                            <img src="<?= base_url('assets/flaticon/icon_rider.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /><?= $rowraider[0]['rowraider'] ?>
                            <img src="<?= base_url('assets/flaticon/icon_team.png') ?>" style="display: unset; width: 15px; height: 15px; margin-bottom: 5px;" /><?= $rowteam[0]['rowteam'] ?>
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
        <div class="row">
            <div class="col-xs-12" align="center">
                <h3 class="box-title">Data Juara</h3>
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
            $.ajax({
                url: "<?= base_url(); ?>event/rankfetch/<?= $tbl_event['id'] ?>",
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
                            'Semua Rank telah Ditampilkan' +
                            '</div>' +
                            '</div>');
                        action = 'active';
                    } else {
                        $('#load_data').append(data);
                        $('#load_data_message').html('<div class="row">' +
                            '<div class="col-xs-12" align="center">' +
                            'Semua Rank telah Ditampilkan' +
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