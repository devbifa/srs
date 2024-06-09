<style>
#myBar {
  width: 100%;
  background-color: #ddd;
}

#myProgress {
  width: 1%;
  height: 30px;
  background-color: #4CAF50;
}
</style>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Uploader
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-cloud-upload"></i> Home</a></li>
        <li class="active">Uploader</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <section class="col-lg-12 col-md-12 col-xs-12">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">

                  <form action="<?=base_url('Uploader/prosesuploadAjax')?>" method="post" enctype="multipart/form-data" id="proses-upload">
                <div class="box-header">
                  
                <div class="show_error"></div>
                    
                </div>

                <div class="box-body">

                    <div class="col-md-6">
                     
                      <div class="form-group">
                        <label>Select files from your computer</label>
                        <input type="file" class="form-control" name="file" id="file-input">
                      </div>

                      <div class="form-group">
                        <div id="resultfile"></div>
                      </div>
                    </div>

                </div>
                <div class="box-footer">
                  <div class="col-md-6">
                  <button type="submit" class="btn btn-primary pull-right btn-send"><i class="fa fa-upload"></i> Upload</button>
                 </div>
                </div>

                  </form>
              </div>
            </div>
          </div>
        </section>
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <script type="text/javascript">
      $("#proses-upload").submit(function(){
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
                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Uploading...").attr('disabled',true);
                    form.find(".show_error").slideUp().html("");
                },
                success: function(response, textStatus, xhr) {
                    // alert(mydata);
                    // 
                   var str = response;
                    if (str.indexOf("success") != -1){
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $('#file-input').val('');
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-upload"></i> Upload').attr('disabled',false);


                    }else{
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-upload"></i> Upload').attr('disabled',false);
                        
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  console.log(xhr);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-upload"></i> Upload').attr('disabled',false);
                    form.find(".show_error").hide().html(xhr).slideDown("fast");

                }
            });
            return false;
    
        });
  </script>