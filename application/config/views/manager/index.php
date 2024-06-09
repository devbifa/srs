<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center">Manajer</h3>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form role="form" action="<?= base_url('manager/store') ?>" method="POST" id="sumbit">
            <div class="show_error"></div>
            <input type="hidden" name="id" class="form-control" value="<?= $manajer['id'] ?>">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="dt[name]" class="form-control" value="<?= $manajer['name'] ?>">
            </div>
            <div class="form-group">
                <label>Foto</label><br>
                <div align="center">
                    <?php if ($file != NULL) { ?>
                        <img class="img-circle" alt="User Image" src="<?= $file['url'] ?>" alt="Third slide" height="250px" width="250px" style="margin-bottom: 10px" id="preview">
                    <?php } else { ?>
                        <img class="img-circle" alt="User Image" src="<?= base_url('webfiles/manager/manager_default.png') ?>" alt="Third slide" height="250px" width="250px" style="margin-bottom: 10px" id="preview">
                    <?php } ?>
                </div>
                <div class="input-group" id="preview_image">
                    <button type="button" class="btn btn-lg btn-primary" id="btnFile">Pilih Gambar</button>
                    <input name="file" type="file" class="file" id="imageFile" style="display: none;" name="file" accept="image/x-png,image/jpeg,image/jpg" />
                </div>
                <p class="help-block">Foto yang diupload disarankan memiliki format PNG, JPG, atau JPEG</p>
            </div>
            <div class="form-group">
                <label>Alamat Team</label>
                <textarea name="dt[alamat]" class="form-control" rows="5"><?= $manajer['alamat'] ?></textarea>
            </div>
            <div class="form-group">
                <label>Nomor Wa</label>
                <input type="text" name="dt[nowa]" class="form-control" value="<?= $manajer['nowa'] ?>">
            </div>
            <div class="show_error"></div>
            <div class="form-group">
                <button type="submit" class="btn btn-send btn-lg btn-block btn-primary">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("#sumbit").submit(function() {
            var form = $(this);
            var mydata = new FormData(this);
            $.ajax({
                type: "POST",
                url: form.attr("action"),
                data: mydata,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Memperoses...").attr('disabled', true);
                    form.find(".show_error").slideUp().html("");
                },

                success: function(response, textStatus, xhr) {
                    var str = response;
                    if (str.indexOf("success") != -1) {
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        location.href = '<?= base_url("manager") ?>';
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled', false);
                    } else {
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled', false);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Simpan').attr('disabled', false);
                    form.find(".show_error").hide().html(xhr).slideDown("fast");
                }
            });
            return false;
        });
    });
</script>