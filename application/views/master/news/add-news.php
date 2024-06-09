

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        NEWS

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">NEWS</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/news/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Tambah News

              </h5>
            </div>
            -->

            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                NEW DAILY NEWS
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-body">

<div class="show_error"></div>
<div class="row">
<div class="col-md-12">

<div class="row">
<div class="form-group col-md-9">

      <label for="form-title">TITLE</label>

      <input type="text" class="form-control" id="form-title" placeholder="Masukan Title" name="dt[title]" value="<?= $news['title'] ?>">

  </div><div class="form-group col-md-3">

      <label for="form-date">DATE</label>

      <input type="text" class="form-control tgl" id="form-date" placeholder="Masukan Date" name="dt[date]" value="<?= $news['date'] ?>">

  </div><div class="form-group col-md-12">

      <label for="form-content">CONTENT</label>

      <textarea name="dt[content]" class="form-control" id="editor1"><?= $news['content'] ?></textarea>

  </div>
  <!-- <div class="form-group col-md-12">

      <label for="form-visibility">VISIBILITY</label>

      <input type="text" class="form-control" id="form-visibility" placeholder="Masukan Visibility" name="dt[visibility]" value="<?= $news['visibility'] ?>">

  </div> -->
  <div class="form-group col-md-12">

      <label for="form-file">FILE </label>  
      
      <?php

  if($file['dir']!=""){ ?>
    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


<?php } ?>
     

      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

  </div></div></div>

<div class="col-md-6">

<div class="row">

</div>
</div>
</div>
<div class="box-footer">
<div class="col-md-12">
<div class="row">
<button type="submit" class="btn btn-primary btn-send float-1" ><i class="fa fa-save"></i></button>

                </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

        </div>

        <!-- /.col -->

        </div></div>

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

                    $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/news') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i>').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i>').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i>').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>