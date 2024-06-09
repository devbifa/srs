

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Pendaftaran

        <small>Tambah</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="#">Master</a></li>

        <li class="#">Pendaftaran</li>

        <li class="active">Tambah</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Pendaftaran/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Tambah Pendaftaran

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div><div class="form-group">

                      <label for="form-event">Event</label>

                      <select style='width:100%' name="dt[event]" class="form-control select2">

                        <?php 

                        $event = $this->mymodel->selectWhere('event',null);

                        foreach ($event as $event_record) {

                          echo "<option value=".$event_record['id'].">".$event_record['nama_event']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-kode_pendaftaran">Kode Pendaftaran</label>

                      <input type="text" class="form-control" id="form-kode_pendaftaran" placeholder="Masukan Kode Pendaftaran" name="dt[kode_pendaftaran]">

                  </div><div class="form-group">

                      <label for="form-tipe_pendaftaran">Tipe Pendaftaran</label>

                      <select style='width:100%' name="dt[tipe_pendaftaran]" class="form-control select2">

                        <?php 

                        $tipe_pendaftaran = $this->mymodel->selectWhere('tipe_pendaftaran',null);

                        foreach ($tipe_pendaftaran as $tipe_pendaftaran_record) {

                          echo "<option value=".$tipe_pendaftaran_record['nama_tipe_pendaftaran'].">".$tipe_pendaftaran_record['nama_tipe_pendaftaran']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-status_pendaftaran">Status Pendaftaran</label>

                      <select style='width:100%' name="dt[status_pendaftaran]" class="form-control select2">

                        <?php 

                        $status_pendaftaran = $this->mymodel->selectWhere('status_pendaftaran',null);

                        foreach ($status_pendaftaran as $status_pendaftaran_record) {

                          echo "<option value=".$status_pendaftaran_record['nama_status_status_pendaftaran'].">".$status_pendaftaran_record['nama_status_status_pendaftaran']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

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

                           window.location.href = "<?= base_url('master/Pendaftaran') ?>";

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