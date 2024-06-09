<div class="row">
    <div class="col-md-12">
        <div class="box">
            <img class="img-detail" src="https://thumbs.gfycat.com/NegligiblePaltryCorydorascatfish-small.gif">
            <div class="box-body" align="center">
                <h3>Pendaftaran anda Berhasil Mohon cek <b>Email</b> Anda untuk Proses Lebih Lanjut !</h3>
                <div class="row">
                    <div class="col-xs-12">
                        <?php if ($this->session->userdata('role') == 'Team') { ?>
                            <a href="<?= base_url('monitorevent') ?>">
                                <button class="btn btn-lg btn-block btn-info">
                                    Monitoring Event
                                </button>
                            </a>
                        <?php } else { ?>
                            <a href="<?= base_url('monitoreventrider') ?>">
                                <button class="btn btn-lg btn-block btn-info"> <i class="fa fa-television"></i> Monitoring Event </button>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" align="center">
        <h3>Data Verifired!</h3>
        <div class="row">
            <div class="col-xs-6">
                <a href="<?= base_url('verifteam') ?>" class="a_black">
                    <div class="box" style=" width: 100px; height: 100px;">
                        <div class="box-body" align="center">
                            <img src="<?= base_url('assets/flaticon/team.png') ?>" style=" width: 80px; height: 80px; ">
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xs-6">
                <a href="<?= base_url('verifraider') ?>" class="a_black">
                    <div class="box" style=" width: 100px; height: 100px;">
                        <div class="box-body" align="center">
                            <img src="<?= base_url('assets/flaticon/rider.png') ?>" style=" width: 80px; height: 80px; ">
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>