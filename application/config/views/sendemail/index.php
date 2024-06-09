 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Send Email
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Fitur</a></li>
        <li class="active">Send Email</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <div class="pull-right">
                 <button type="button" class="btn btn-sm btn-info"  onclick="konfig()"><i class="fa fa-gear"></i> Konfigurasi Email</button>
              </div>
            </div>
            <div class="box-body">
              <?php if($this->session->flashdata('sukses')){ ?>  
               <div class="alert alert-success">  
                 <a href="#" class="close" data-dismiss="alert">&times;</a>  
                 <strong>Success!</strong> <?php echo $this->session->flashdata('sukses'); ?>  
               </div>  
             <?php } ?>

             <div class="row">
              <div class="col-md-6">

                <form method="POST" action="<?= base_url('sendemail/send') ?>" id="upload-create" enctype="multipart/form-data">
                  <div class="show_error"></div>
                  <div class="form-group">

                      <label for="form-cm_nama">Email Penerima</label>

                      <input type="email" class="form-control"  placeholder="Masukan Email Penerima" name="email">

                  </div>

                  <div class="form-group pull-right">

                    <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-paper-plane"></i> Send Email</button>
                  </div>
                </form>
                

              </div>




            </div>

             
              <br>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-konfig">
      <div class="modal-dialog">

                <form method="POST" action="<?= base_url('sendemail/update') ?>" id="update-create"  enctype="multipart/form-data">
          <div class="modal-content">

              <div class="modal-header">
                  <h5 class="modal-title">Konfigurasi</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                <div class="show_errors"></div>
                <table class="table table-striped">
                  <tr>
                    <td>Logo</td>
                    <td><input type="text" class="form-control" name="logo" value="<?=@$konfig['logo']?>"></td>
                  </tr>
                  <tr>
                    <td>Nama Perusahaan</td>
                    <td><input type="text" class="form-control" name="perusahaan" value="<?=@$konfig['perusahaan']?>"></td>
                  </tr>
                   <tr>
                    <td>Body</td>
                    <td><textarea class="form-control" name="body" ><?=@$konfig['body']?></textarea></td>
                  </tr>
                  <tr>
                    <td>footer</td>
                    <td><input type="text" class="form-control" name="footer" value="<?=@$konfig['footer']?>"></td>
                  </tr>
                  <tr>
                    <td>Warna</td>
                    <td><input type="color" class="form-control" name="warna" value="<?=@$konfig['warna']?>"></td>
                  </tr>
                </table>
                  
              </div>
              <div class="modal-footer">
                  <button type="submit"  class="btn btn-primary btn-update">Update</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
          </div>

            </form>
      </div>
  </div> 


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
                      
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-paper-plane"></i> Send Email').attr('disabled',false);
                    }else{
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-paper-plane"></i> Send Email').attr('disabled',false);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  console.log(xhr);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-paper-plane"></i> Send Email').attr('disabled',false);
                    form.find(".show_error").hide().html(xhr).slideDown("fast");
                }
            });
            return false;
        });




      function konfig() {
            $("#modal-konfig").modal();
            
         }


         $("#update-create").submit(function(){
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
                    $(".btn-update").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
                    form.find(".show_errors").slideUp().html("");
                },
                success: function(response, textStatus, xhr) {
                    // alert(mydata);
                   var str = response;
                    if (str.indexOf("success") != -1){
                        form.find(".show_errors").hide().html(response).slideDown("fast");
                        setTimeout(function(){ 
                          $("#modal-konfig").modal('hide');
                        }, 1000);
                        $(".btn-update").removeClass("disabled").html('Update').attr('disabled',false);
                    }else{
                        form.find(".show_errors").hide().html(response).slideDown("fast");
                        $(".btn-update").removeClass("disabled").html('Update').attr('disabled',false);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  console.log(xhr);
                    $(".btn-update").removeClass("disabled").html('Update').attr('disabled',false);
                    form.find(".show_errors").hide().html(xhr).slideDown("fast");
                }
            });
            return false;
        });
  </script>