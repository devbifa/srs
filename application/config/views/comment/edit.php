<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Ubah Komentar</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <?php $photo = $this->mymodel->selectDataone('file', array('table' => 'tbl_raider', 'table_id' => $tbl_comment['id_raider'])); ?>
                <div class="col-xs-2">
                    <?php if ($photo != null) { ?>
                        <img src="<?= $photo['url'] ?>" width="50px" height="50px" style="border-radius: 50%">
                    <?php } else { ?>
                        <img src="https://m.nsoproject.com/webfiles/raider/raider_default.png" width="50px" height="50px" style="border-radius: 50%">
                    <?php } ?>
                </div>
                <form method="POST" action="<?= base_url('comment/update') ?>">
                    <div class="col-xs-10">
                        <input type="text" class="form-control" name="dt[comment]" placeholder="Tulis Komentar anda..." value="<?= $tbl_comment['comment'] ?>">
                        <input type="hidden" name="id" value="<?= $tbl_comment['id'] ?>">
                        <input type="hidden" name="gallery_id" value="<?= $tbl_comment['imagegroup_id'] ?>">
                        <p style="color:#737373;font-size: 12px;">
                            <?php
                            if ($tbl_comment['updated_at']) { ?>
                                Diubah pada : <?= date('d M Y H:i:s', strtotime($tbl_comment['updated_at'])) ?>
                            <?php } else { ?>
                                Dibuat pada : <?= date('d M Y H:i:s', strtotime($tbl_comment['created_at'])) ?>
                            <?php } ?>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>