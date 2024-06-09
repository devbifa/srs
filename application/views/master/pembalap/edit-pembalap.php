

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Pembalap

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="#">Master</a></li>

      <li class="#">Pembalap</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Pembalap/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $pembalap['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Pembalap

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div><div class="form-group">

                      <label for="form-id_pendaftaran">Id Pendaftaran</label>

                      <select style='width:100%' name="dt[id_pendaftaran]" class="form-control select2">

                        <?php 

                        $pendaftaran = $this->mymodel->selectWhere('pendaftaran',null);

                        foreach ($pendaftaran as $pendaftaran_record) {

                          $text="";

                          if($pendaftaran_record['id']==$pembalap['id_pendaftaran']){

                            $text = "selected";

                          }



                          echo "<option value=".$pendaftaran_record['id']." ".$text." >".$pendaftaran_record['kode_pendaftaran']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-nama_lengkap">Nama Lengkap</label>

                      <input type="text" class="form-control" id="form-nama_lengkap" placeholder="Masukan Nama Lengkap" name="dt[nama_lengkap]" value="<?= $pembalap['nama_lengkap'] ?>">

                  </div><div class="form-group">

                      <label for="form-alamat">Alamat</label>

                      <input type="text" class="form-control" id="form-alamat" placeholder="Masukan Alamat" name="dt[alamat]" value="<?= $pembalap['alamat'] ?>">

                  </div><div class="form-group">

                      <label for="form-kota">Kota</label>

                      <input type="text" class="form-control" id="form-kota" placeholder="Masukan Kota" name="dt[kota]" value="<?= $pembalap['kota'] ?>">

                  </div><div class="form-group">

                      <label for="form-tanggal_lahir">Tanggal Lahir</label>

                      <input type="date" class="form-control" id="form-tanggal_lahir" placeholder="Masukan Tanggal Lahir" name="dt[tanggal_lahir]" value="<?= $pembalap['tanggal_lahir'] ?>">

                  </div><div class="form-group">

                      <label for="form-nomor_start">Nomor Start</label>

                      <input type="text" class="form-control" id="form-nomor_start" placeholder="Masukan Nomor Start" name="dt[nomor_start]" value="<?= $pembalap['nomor_start'] ?>">

                  </div><div class="form-group">

                      <label for="form-nama_jersey">Nama Jersey</label>

                      <input type="text" class="form-control" id="form-nama_jersey" placeholder="Masukan Nama Jersey" name="dt[nama_jersey]" value="<?= $pembalap['nama_jersey'] ?>">

                  </div><div class="form-group">

                      <label for="form-ukuran_jersey">Ukuran Jersey</label>

                      <select style='width:100%' name="dt[ukuran_jersey]" class="form-control select2">

                        <?php 

                        $ukuran_jersey = $this->mymodel->selectWhere('ukuran_jersey',null);

                        foreach ($ukuran_jersey as $ukuran_jersey_record) {

                          $text="";

                          if($ukuran_jersey_record['id']==$pembalap['ukuran_jersey']){

                            $text = "selected";

                          }



                          echo "<option value=".$ukuran_jersey_record['id']." ".$text." >".$ukuran_jersey_record['nama_ukuran_jersey']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-nomor_hp">Nomor Hp</label>

                      <input type="text" class="form-control" id="form-nomor_hp" placeholder="Masukan Nomor Hp" name="dt[nomor_hp]" value="<?= $pembalap['nomor_hp'] ?>">

                  </div><div class="form-group">

                      <label for="form-motor">Motor</label>

                      <select style='width:100%' name="dt[motor]" class="form-control select2">

                        <?php 

                        $motor = $this->mymodel->selectWhere('motor',null);

                        foreach ($motor as $motor_record) {

                          $text="";

                          if($motor_record['id']==$pembalap['motor']){

                            $text = "selected";

                          }



                          echo "<option value=".$motor_record['id']." ".$text." >".$motor_record['nama_motor']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-golongan_darah">Golongan Darah</label>

                      <input type="text" class="form-control" id="form-golongan_darah" placeholder="Masukan Golongan Darah" name="dt[golongan_darah]" value="<?= $pembalap['golongan_darah'] ?>">

                  </div><div class="form-group">

                      <label for="form-email">Email</label>

                      <input type="text" class="form-control" id="form-email" placeholder="Masukan Email" name="dt[email]" value="<?= $pembalap['email'] ?>">

                  </div><?php

                  if($file['dir']!=""){

                  $types = explode("/", $file['mime']);

                  if($types[0]=="image"){

                  ?>

                    <img src="<?= base_url().'webfile/'.$file['name'] ?>" style="width: 200px" class="img img-thumbnail">

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

                  </div></div>

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

                           window.location.href = "<?= base_url('master/Pembalap') ?>";

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