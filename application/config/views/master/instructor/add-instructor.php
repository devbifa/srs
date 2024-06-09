

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        INSTRUCTOR

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">INSTRUCTOR</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/instructor/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

        <div class="box">

<div class="box-header-material box-header-material-text">
      <div class="row">
      <div class="col-xs-10">
      CREATE BIFA INSTRUCTOR
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
                <div class="form-group col-md-12">

                      <label for="form-instructor_name">INSTRUCTOR NAME</label>

                      <input type="text" class="form-control" id="form-instructor_name" placeholder="Masukan Instructor Name" name="dt[instructor_name]" value="<?= $instructor['instructor_name'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-nick_name">NICK NAME</label>

                      <input type="text" class="form-control" id="form-nick_name" placeholder="Masukan Nick Name" name="dt[nick_name]" value="<?= $instructor['nick_name'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-employee_number">EMPLOYEE NUMBER</label>

                      <input type="text" class="form-control" id="form-employee_number" placeholder="Masukan Employee Number" name="dt[employee_number]" value="<?= $instructor['employee_number'] ?>">

                  </div>
                  <div class="form-group col-md-12">

                      <label for="form-remark">REMARK</label>

                      <input type="text" class="form-control" id="form-remark" placeholder="Masukan Remark" name="dt[remark]" value="<?= $instructor['remark'] ?>">

                  </div>
                  <div class="form-group col-md-12">

                      <label for="form-remark">COURSE POSITION</label>
                      <br>
                      <?php 
                      $type = json_decode($instructor['type'],true);
                      $data = $this->mymodel->selectWithQuery("SELECT * FROM instructor_type");
                      foreach($data as $key=>$val){
                        $text = ""; 
                        foreach($type as $key2=>$val2){
                          if($val2[$val['instructor_type']]==$val['instructor_type']){
                           $text = "checked";
                          }
                        }  
                      ?>
                      <input name="dtt[][<?=$val['instructor_type']?>]" type="checkbox" <?=$text?> value="<?=$val['instructor_type']?>" > <?=$val['instructor_type']?> 
                      <?php } ?>

                  </div>


                  
                  <div class="form-group col-md-12">
                  
                  <label for="form-file">ATTACHMENT </label>  
                  
                  <?php

              if($file['dir']!=""){ ?>
                <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


            <?php } ?>
            <input type="file" class="form-control" id="form-file" placeholder="Insert File" name="file">
              </div>


                  </div></div>
  
 
                  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
  <div class="col-md-6">
  <div class="row">
      <button type="submit" class="btn btn-primary btn-send float-add" ><i class="mdi mdi-content-save"></i></button>

      <a class="btn btn-success float-upload" href="#!" data-toggle="modal" data-target="#modal-upload"><i class="mdi mdi-attachment"></i></a>

      </div>
   

      </div>

      </div>

  <!-- /.box-body -->

</div>

<!-- /.box -->



<!-- /.box -->

</div>
</form>
</div>


<!-- /.col -->

</div>

<!-- /.row -->





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

                           window.location.href = "<?= base_url('master/instructor') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>