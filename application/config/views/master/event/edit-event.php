

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Event

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="#">Master</a></li>

      <li class="#">Event</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Event/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $event['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Event

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div><div class="form-group">

                      <label for="form-nama_event">Nama Event</label>

                      <input type="text" class="form-control" id="form-nama_event" placeholder="Masukan Nama Event" name="dt[nama_event]" value="<?= $event['nama_event'] ?>">

                  </div><div class="form-group">

                      <label for="form-lokasi_event">Lokasi Event</label>

                      <input type="text" class="form-control" id="form-lokasi_event" placeholder="Masukan Lokasi Event" name="dt[lokasi_event]" value="<?= $event['lokasi_event'] ?>">

                  </div><div class="form-group">

                      <label for="form-tanggal_penutupan">Tanggal Penutupan</label>

                      <input type="date" class="form-control" id="form-tanggal_penutupan" placeholder="Masukan Tanggal Penutupan" name="dt[tanggal_penutupan]" value="<?= $event['tanggal_penutupan'] ?>">

                  </div><div class="form-group">

                      <label for="form-tanggal_mulai">Tanggal Mulai</label>

                      <input type="date" class="form-control" id="form-tanggal_mulai" placeholder="Masukan Tanggal Mulai" name="dt[tanggal_mulai]" value="<?= $event['tanggal_mulai'] ?>">

                  </div><div class="form-group">

                      <label for="form-tanggal_selesai">Tanggal Selesai</label>

                      <input type="date" class="form-control" id="form-tanggal_selesai" placeholder="Masukan Tanggal Selesai" name="dt[tanggal_selesai]" value="<?= $event['tanggal_selesai'] ?>">

                  </div><div class="form-group">

                      <label for="form-biaya_pendaftaran">Biaya Pendaftaran</label>

                      <input type="text" class="form-control" id="form-biaya_pendaftaran" placeholder="Masukan Biaya Pendaftaran" name="dt[biaya_pendaftaran]" value="<?= $event['biaya_pendaftaran'] ?>">

                  </div><div class="form-group">

                      <label for="form-tipe_pendaftaran">Tipe Pendaftaran</label>

                      <select style='width:100%' name="dt[tipe_pendaftaran]" class="form-control select2">

                        <?php 

                        $tipe_pendaftaran = $this->mymodel->selectWhere('tipe_pendaftaran',null);

                        foreach ($tipe_pendaftaran as $tipe_pendaftaran_record) {

                          $text="";

                          if($tipe_pendaftaran_record['nama_tipe_pendaftaran']==$event['tipe_pendaftaran']){

                            $text = "selected";

                          }



                          echo "<option value=".$tipe_pendaftaran_record['nama_tipe_pendaftaran']." ".$text." >".$tipe_pendaftaran_record['nama_tipe_pendaftaran']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-jumlah_rider">Jumlah Rider</label>

                      <input type="text" class="form-control" id="form-jumlah_rider" placeholder="Masukan Jumlah Rider" name="dt[jumlah_rider]" value="<?= $event['jumlah_rider'] ?>">

                  </div><div class="form-group">

                      <label for="form-status_event">Status Event</label>

                      <select style='width:100%' name="dt[status_event]" class="form-control select2">

                        <?php 

                        $status_event = $this->mymodel->selectWhere('status_event',null);

                        foreach ($status_event as $status_event_record) {

                          $text="";

                          if($status_event_record['nama_status_event']==$event['status_event']){

                            $text = "selected";

                          }
                          ?>
<option value="<?=$status_event_record['nama_status_event']?>" <?=$text?> ><?=$status_event_record['nama_status_event']?></option>
                         

                          <?php



                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-event_utama">Event Utama</label>

                      <select style='width:100%' name="dt[event_utama]" class="form-control select2">

                        <?php 

                        $master_ya_tidak = $this->mymodel->selectWhere('master_ya_tidak',null);

                        foreach ($master_ya_tidak as $master_ya_tidak_record) {

                          $text="";

                          if($master_ya_tidak_record['nama_master_ya_tidak']==$event['event_utama']){

                            $text = "selected";

                          }



                          echo "<option value=".$master_ya_tidak_record['nama_master_ya_tidak']." ".$text." >".$master_ya_tidak_record['nama_master_ya_tidak']."</option>";

                        }

                        ?>

                      </select>

                  </div>
                  
                  <div class="form-group">

                      <label for="form-deskripsi_event">Deskripsi Event</label>

                      <textarea type="text" class="form-control" id="form-deskripsi_event" placeholder="Masukan Deskripsi Event" name="dt[deskripsi_event]" ><?= $event['deskripsi_event'] ?></textarea>

                  </div>

                  
                  <?php

if($file_peraturan['dir']!=""){

$types = explode("/", $file['mime']);

if($types[0]=="image"){

?>

  <a class="btn btn-primary" target="_blank" href="<?= base_url($file_peraturan['dir']) ?>">Buka File Peraturan</a>

  <br>

<?php }else{ ?>

  

  <i class="fa fa-file fa-5x text-danger"></i>

  <br>

  <a href="<?= base_url($file_peraturan['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>

  <br>

<br>

<?php } ?>

<?php } ?><div class="form-group">

    <label for="form-file">File Peraturan</label>

    <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file_peraturan">

</div>




                  
                  <?php

                  if($file_card['dir']!=""){

                  $types = explode("/", $file_card['mime']);

                  if($types[0]=="image"){

                  ?>

                    <img src="<?= base_url($file_card['dir']) ?>" style="width: 200px" class="img img-thumbnail">

                    <br>

                  <?php }else{ ?>

                    

                    <i class="fa fa-file fa-5x text-danger"></i>

                    <br>

                    <a href="<?= base_url($file_card['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file_card['name'] ?></a>

                    <br>

                  <br>

                <?php } ?>

                <?php } ?>
                <div class="form-group">

                      <label for="form-file">File ID Card</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file_card">

                  </div>


                  <?php

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

                <?php } ?>
                <div class="form-group">

                      <label for="form-file">File Gambar</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div>

                  
                  </div>

            <div class="box-footer">

                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

             

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

      </form>



    </section>

    <!-- /.content -->

  </div>

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

                           window.location.href = "<?= base_url('master/Event') ?>";

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