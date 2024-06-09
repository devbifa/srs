

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Student

        <small>Tambah</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">Student</li>

        <li class="active">Tambah</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Student/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Tambah Student

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div>
                <div class="row"><div class="form-group col-md-6">

                      <label for="form-batch_code">Batch Code</label>

                      <select style='width:100%' name="dt[batch_code]" class="form-control select2">

                        <?php 

                        $batch = $this->mymodel->selectWhere('batch',null);

                        foreach ($batch as $batch_record) {

                          echo "<option value='".$batch_record['batch_code']."' >".$batch_record['batch_name']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-6">

                      <label for="form-student_code">Student Code</label>

                      <input type="text" class="form-control" id="form-student_code" placeholder="Masukan Student Code" name="dt[student_code]">

                  </div><div class="form-group col-md-6">

                      <label for="form-student_name">Student Name</label>

                      <input type="text" class="form-control" id="form-student_name" placeholder="Masukan Student Name" name="dt[student_name]">

                  </div><div class="form-group col-md-6">

                      <label for="form-student_nick_name">Student Nick Name</label>

                      <input type="text" class="form-control" id="form-student_nick_name" placeholder="Masukan Student Nick Name" name="dt[student_nick_name]">

                  </div><div class="form-group col-md-6">

                      <label for="form-spl_number">Spl Number</label>

                      <input type="text" class="form-control" id="form-spl_number" placeholder="Masukan Spl Number" name="dt[spl_number]">

                  </div><div class="form-group col-md-6">

                      <label for="form-ppl_number">Ppl Number</label>

                      <input type="text" class="form-control" id="form-ppl_number" placeholder="Masukan Ppl Number" name="dt[ppl_number]">

                  </div><div class="form-group col-md-6">

                      <label for="form-cpl_number">Cpl Number</label>

                      <input type="text" class="form-control" id="form-cpl_number" placeholder="Masukan Cpl Number" name="dt[cpl_number]">

                  </div><div class="form-group col-md-6">

                      <label for="form-description">Description</label>

                      <input type="text" class="form-control" id="form-description" placeholder="Masukan Description" name="dt[description]">

                  </div><div class="form-group col-md-6">

                      <label for="form-file">File</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div></div>
            <div class="box-footer">

            <div class="">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

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

                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/Student') ?>";

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