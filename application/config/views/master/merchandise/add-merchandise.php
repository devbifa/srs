

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Merchandise

        <small>Tambah</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="#">Master</a></li>

        <li class="#">Merchandise</li>

        <li class="active">Tambah</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Merchandise/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Tambah Merchandise

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div><div class="form-group">

                      <label for="form-kode_produk">Kode Produk</label>

                      <input type="text" class="form-control" id="form-kode_produk" placeholder="Masukan Kode Produk" name="dt[kode_produk]">

                  </div><div class="form-group">

                      <label for="form-nama_merchandise">Nama Merchandise</label>

                      <input type="text" class="form-control" id="form-nama_merchandise" placeholder="Masukan Nama Merchandise" name="dt[nama_merchandise]">

                  </div><div class="form-group">

                      <label for="form-harga_merchandise">Harga Merchandise</label>

                      <input type="text" class="form-control" id="form-harga_merchandise" placeholder="Masukan Harga Merchandise" name="dt[harga_merchandise]">

                  </div><div class="form-group">

                      <label for="form-stok_tersedia">Stok Tersedia</label>

                      <select style='width:100%' name="dt[stok_tersedia]" class="form-control select2">

                        <?php 

                        $master_ya_tidak = $this->mymodel->selectWhere('master_ya_tidak',null);

                        foreach ($master_ya_tidak as $master_ya_tidak_record) {

                          echo "<option value=".$master_ya_tidak_record['nama_master_ya_tidak'].">".$master_ya_tidak_record['nama_master_ya_tidak']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-deskripsi_merchandise">Deskripsi Merchandise</label>

                      <textarea name="dt[deskripsi_merchandise]" class="form-control"></textarea>

                  </div><div class="form-group">

                      <label for="form-berat">Berat</label>

                      <input type="text" class="form-control" id="form-berat" placeholder="Masukan Berat" name="dt[berat]">

                  </div><div class="form-group">

                      <label for="form-no_telepon">No Telepon</label>

                      <input type="text" class="form-control" id="form-no_telepon" placeholder="Masukan No Telepon" name="dt[no_telepon]">

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

                           window.location.href = "<?= base_url('master/Merchandise') ?>";

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