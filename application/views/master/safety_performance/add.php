

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        SAFETY PERFORMANCE

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">SAFETY PERFORMANCE</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/safety_performance/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Tambah Delay And Cancel Code

              </h5>
            </div>
            -->
            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                NEW SAFETY PERFORMANCE
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
                <div class="form-group col-md-3">

                      <label for="form-type">TYPE</label>

                      <select style='width:100%' name="dt[type]" class="form-control select2">

                        <?php 

                        $this->db->order_by('safety_performance_type','ASC');
                        $safety_performance_type = $this->mymodel->selectWhere('safety_performance_type',null);

                        foreach ($safety_performance_type as $safety_performance_type_record) {

                          $text="";

                          if($safety_performance_type_record['safety_performance_type']==$safety_performance['type']){

                            $text = "selected";

                          }



                          echo "<option value='".$safety_performance_type_record['safety_performance_type']."' ".$text." >".$safety_performance_type_record['safety_performance_type']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-3">

                      <label for="form-code">CODE</label>

                      <input type="text" class="form-control" id="form-code" placeholder="Fill Code" name="dt[code]" value="<?= $safety_performance['code'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-remarks">REMARKS</label>

                      <input type="text" class="form-control" id="form-remarks" placeholder="Fill Remarks" name="dt[remarks]" value="<?= $safety_performance['remarks'] ?>">

                  </div><div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

                  </div></div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1" data-placement="top" title="SAVE SAFETY PERFORMANCE"  ><i class="mdi mdi-content-save"></i></button>


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

                           window.location.href = "<?= base_url('master/safety_performance') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>