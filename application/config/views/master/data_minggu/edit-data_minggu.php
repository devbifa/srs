

  <!-- Content Wrapper. Contains page content -->



    <form method="POST" action="<?= base_url('master/Data_minggu/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $data_minggu['id'] ?>">



                <div class="show_error"></div><div class="form-group">

                      <label for="form-tanggal_awal">Tanggal Awal</label>

                      <input type="text" class="form-control" id="form-tanggal_awal" placeholder="Masukan Tanggal Awal" name="dt[tanggal_awal]" value="<?= $data_minggu['tanggal_awal'] ?>">

                  </div><div class="form-group">

                      <label for="form-tanggal_akhir">Tanggal Akhir</label>

                      <input type="text" class="form-control" id="form-tanggal_akhir" placeholder="Masukan Tanggal Akhir" name="dt[tanggal_akhir]" value="<?= $data_minggu['tanggal_akhir'] ?>">

                  </div><div class="form-group">

                      <label for="form-minggu_ke">Minggu Ke</label>

                      <input type="text" class="form-control" id="form-minggu_ke" placeholder="Masukan Minggu Ke" name="dt[minggu_ke]" value="<?= $data_minggu['minggu_ke'] ?>">

                  </div><?php

                  if($file['dir']!=""){

                  $types = explode("/", $file['mime']);

                  if($types[0]=="image"){

                  ?>

                    <img src="<?= base_url($file['dir']) ?>" style="width: 200px" class="img img-thumbnail">

                    <br>

                  <?php }else{ ?>

                    

                    <i class="fa fa-file fa-5x text-danger"></i>

                    <br>

                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>

                    <br>

                  <br>

                <?php } ?>

                <?php } ?><div class="form-group">

                      <label for="form-file">File</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div>
                <hr>

                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

             

           
      </form>


  <!-- /.content-wrapper -->

  <script type="text/javascript">

      $("#upload-create").submit(function(){

            var form = $(this);

            var mydata = new FormData(this);

            $.ajax({

                type: "POST",

                url: form.attr("action"),

                data: mydata,

                cache: false,

                contentType: false,

                processData: false,

                beforeSend : function(){

                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                          // window.location.href = "<?= base_url('master/Data_minggu') ?>";
                          $("#load-table").html('');
                          loadtable($("#select-status").val());
                          $("#modal-form").modal('hide');

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>