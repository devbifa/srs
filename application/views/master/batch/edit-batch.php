<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            BATCH

            <small>EDIT</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


            <li class="#">BATCH</li>

            <li class="active">EDIT</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <form method="POST" action="<?= base_url('master/batch/update') ?>" id="upload-create"
            enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $batch['id'] ?>">





            <div class="row">

                <div class="col-md-12">

                    <div class="box">

                        <!-- /.box-header -->
                        <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Batch

              </h5>

            </div>
            -->

                        <div class="box-header-material box-header-material-text">
                            <div class="row">
                                <div class="col-xs-10">
                                    EDIT BATCH
                                </div>
                                <div class="col-xs-2">
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i></button>
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

                                            <label for="form-code">CODE</label>

                                            <input type="text" class="form-control" id="form-code"
                                                placeholder="Fill Code" name="dt[code]" value="<?= $batch['code'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-batch">BATCH</label>

                                            <input type="text" class="form-control" id="form-batch"
                                                placeholder="Fill Batch" name="dt[batch]"
                                                value="<?= $batch['batch'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-curriculum">CURRICULUM</label>

                                            <select style='width:100%' name="dt[curriculum]"
                                                class="form-control select2">

                                                <?php

                                                $curriculum = $this->mymodel->selectWhere('syllabus_curriculum', null);

                                                foreach ($curriculum as $curriculum_record) {

                                                    $text = "";

                                                    if ($curriculum_record['code'] == $batch['curriculum']) {

                                                        $text = "selected";
                                                    }



                                                    echo "<option value='" . $curriculum_record['code'] . "' " . $text . " >" . $curriculum_record['name'] . "</option>";
                                                }

                                                ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-curriculum">STATUS</label>

                                            <select style='width:100%' name="dt[status]" class="form-control select2">

                                                <?php

                                                $curriculum = $this->mymodel->selectWhere('batch_status', null);

                                                foreach ($curriculum as $curriculum_record) {

                                                    $text = "";

                                                    if ($curriculum_record['batch_status'] == $batch['status']) {

                                                        $text = "selected";
                                                    }



                                                    echo "<option value='" . $curriculum_record['batch_status'] . "' " . $text . " >" . $curriculum_record['batch_status'] . "</option>";
                                                }

                                                ?>

                                            </select>

                                        </div>

                                        <div class="form-group col-md-3">

                                            <label for="form-description">OPEN DATE</label>

                                            <input type="text" class="form-control tgl" id="form-description"
                                                placeholder="Fill Open Date" name="dt[description]"
                                                value="<?= $batch['description'] ?>">

                                        </div>
                                        <div class="form-group col-md-3">

                                            <label for="form-file">FILE </label>

                                            <?php

                                            if ($file['dir'] != "") { ?>
                                            <a href="<?= base_url($file['dir']) ?>" target="_blank"><i
                                                    class="fa fa-download"></i> <?= $file['name'] ?></a>


                                            <?php } ?>


                                            <input type="file" class="form-control" id="form-file"
                                                placeholder="Fill File" name="file">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="row">

                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-12">
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary btn-send float-1"
                                            data-placement="top" title="SAVE BATCH"><i
                                                class="mdi mdi-content-save"></i></button>

                                        <!-- <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> RESET</button> -->

                                    </div>


                                </div>

                            </div>

                            <!-- /.box-body -->

                        </div>

                        <!-- /.box -->



                        <!-- /.box -->

                    </div>
                </div>

                <!-- /.col -->

            </div>

            <!-- /.row -->

        </form>

        <a href="" class="btn btn-danger float-2" href="#!" data-toggle="modal" data-target="#modal-delete-1"
            data-placement="top" title="DELETE BATCH"><i class="mdi mdi-delete"></i></a>

        <div class="modal modal-danger fade" id="modal-delete-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">DELETE DATA</h4>
                    </div>
                    <div class="modal-body" style="color:#fff!important;">
                        <form action="<?= base_url() ?>master/batch/delete/<?= $batch['id'] ?>">
                            <span style="font-weight:100">Are you sure you want to delete this data?</span>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline">Delete Now</button>
                    </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>


    </section>

    <!-- /.content -->

</div>

<!-- /.content-wrapper -->

<script type="text/javascript">
$("#upload-create").submit(function() {

    var form = $(this);

    var mydata = new FormData(this);

    $.ajax({

        type: "POST",

        url: form.attr("action"),

        data: mydata,

        cache: false,

        contentType: false,

        processData: false,

        beforeSend: function() {

            $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr(
                'disabled', true);

            form.find(".show_error").slideUp().html("");

        },

        success: function(response, textStatus, xhr) {

            // alert(mydata);

            var str = response;

            if (str.indexOf("success") != -1) {

                form.find(".show_error").hide().html(response).slideDown("fast");

                setTimeout(function() {

                    window.location.href = "<?= base_url('master/batch') ?>";

                }, 1000);

                $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                    .attr('disabled', false);





            } else {

                form.find(".show_error").hide().html(response).slideDown("fast");

                $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                    .attr('disabled', false);



            }

        },

        error: function(xhr, textStatus, errorThrown) {

            console.log(xhr);

            $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>')
                .attr('disabled', false);

            form.find(".show_error").hide().html(xhr).slideDown("fast");



        }

    });

    return false;



});
</script>