<div class="row">
    <div class="col-md-12">
        <div class="box">
            <img class="img-detail" src="<?= $filegambar['url'] ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <h4 align="center"><?= $tbl_event['title'] ?></h4>
                        <div class="row" align="center">
                            <?php if ($tbl_event['status'] == 'ENABLE') {
                                echo '<small class="label bg-green">Dibuka</small>';
                            } else {
                                echo '<small class="label bg-red">Ditutup</small>';
                            }
                            ?>
                        </div>
                        <p>
                            <i class="fa fa-globe"></i> <?= $tbl_event['kota'] ?><br>
                            <?= $tbl_event['alamat'] ?>
                        </p>
                    </div>
                </div>
                <hr style="margin-top:5px; margin-bottom: 5px">
                <div class="row">
                    <div class="col-xs-6">
                        Event Dimulai :
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
                            <i class="fa fa-motorcycle"></i> <?= $rowraider[0]['rowraider'] ?>
                            <i class="fa fa-users"></i> <?= $rowteam[0]['rowteam'] ?>
                        </b>
                        <br>
                        <small>Event Dibuat : <?= date('d M y', strtotime($row['created_at'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="https://api.whatsapp.com/send?phone=<?=$tbl_event['phone']?>&text=Perkenalkan Saya <?= $this->session->userdata('name') ?>. Saya ingin menanyakan tentang...">
    <button class="btn btn-lg btn-block btn-success" style="margin-bottom: 15px">
        <i class="fa fa-whatsapp"></i> Hubungi Petanggung Jawab Event
    </button>
</a>
<br>
<?php if ($raideregister) { ?>
    <div class="row">
        <?php foreach ($raideregister as $row) {
                $raider = $this->mymodel->selectDataone('tbl_raider', array('id' => $row['raider_id']));
                $motor = $this->mymodel->selectDataone('master_motor', array('id' => $raider['motor_id']));
                $photo = $this->mymodel->selectDataone('file', array('table_id' => $raider['id'], 'table' => 'tbl_raider')); ?>
            <div class="col-xs-6">
                <div class="box">
                    <div class="box-body">
                        <div class="row" align="center">
                            <div class="col-xs-12">
                                <img class="img-circle" alt="User Image" src="<?= $photo['url'] ?>" alt="Third slide" height="100px" width="100px">
                            </div>
                            <div class="col-xs-12">
                                <h4><?= $raider['name'] ?> <?php if ($raider['verificacion'] == 'ENABLE') {
                                                                        echo '<i class="fa fa-check-circle" style="color: #3b8dbc"> </i>';
                                                                    } ?> <br>
                                    <small><i class="fa fa-globe"></i> <?= $raider['kota'] ?></small>
                                </h4>
                                <b>
                                    <i class="fa fa-motorcycle"></i> <?= $motor['value'] ?>
                                    <br>
                                    <i class="fa fa-phone"></i> <?= $raider['nowa'] ?>
                                </b>
                                <p>Sebanyak : <b><?= $raider['eventikut'] ?></b> Event Telah Di Ikuti</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border" align="center">
                    <h3 class="box-title">Tidak Ada Data</h3>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
