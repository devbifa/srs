<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

        <h1>

            BATCH

            <small>DATA</small>

        </h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

            <li class="#">BATCH</li>

            <li class="active">DATA</li>

        </ol>

    </section>

    <!-- Main content -->

    <section class="content">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">

                    <!-- /.box-header -->
                    <div class="box-header-material box-header-material-text">
                        <div class="row">
                            <div class="col-xs-10">
                                BATCH LIST
                            </div>
                            <div class="col-xs-2">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-header">

                        <div class="row">



                            <div class="col-md-6">

                                <div class="pull-right">


                                    <!-- <a href="<?= base_url('fitur/ekspor/batch') ?>" target="_blank">

                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> EXPORT DATA</button> 

                  </a>

                  <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> IMPORT DATA</button> -->

                                </div>

                            </div>

                        </div>



                    </div>

                    <a href="<?= base_url('master/batch/create') ?>">

                        <button type="button" class="btn btn-sm btn-success float-1" data-placement="top"
                            title="ADD BATCH"><i class="mdi mdi-plus"></i></button>

                    </a>

                    <div class="box-body">

                        <div class="show_error"></div>



                        <div class="table-responsive">

                            <table class="table table-bordered " id="example2">

                                <thead>

                                    <tr class="bg-success">

                                        <th style="width:20px">NUM</th>
                                        <th>BATCH</th>
                                        <th>NUMBER OF STUDENT</th>
                                        <th>CURRICULUM</th>
                                        <th>STATUS</th>
                                        <th>OPEN DATE</th>

                                    </tr>

                                </thead>

                                <tbody>
                                    <?php

                  $data = $this->mymodel->selectWithQuery("SELECT *,a.id as id_batch
FROM batch a
LEFT JOIN syllabus_curriculum b
ON a.curriculum = b.code
ORDER BY a.batch ASC");
                  foreach ($data as $key => $val) {
                    $batch = $val['batch'];
                    $student = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count FROM user WHERE batch = '$batch' AND student_status = 'APPROVE'");
                    $val['number_of_student'] = $student[0]['count'];
                  ?>
                                    <tr>
                                        <td><?= $key + 1 ?>
                                        </td>
                                        <td><a title="EDIT BATCH"
                                                href="<?= base_url() ?>master/batch/edit/<?= $val['id_batch'] ?>"><?= $val['batch'] ?></a>
                                        </td>
                                        <td><a title="STUDENT LIST"
                                                href="<?= base_url() ?>master/batch/student/<?= $val['batch'] ?>"><?= $val['number_of_student'] ?></a>
                                        </td>
                                        <td><?= $val['name'] ?>
                                        </td>
                                        <td><?= $val['status'] ?>
                                        </td>
                                        <td><?= $val['description'] ?>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>

                            </table>

                        </div>

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


<div class="modal fade bd-example-modal-sm" tabindex="-1" batch="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true" id="modal-delete">

    <div class="modal-dialog modal-sm">

        <div class="modal-content">

            <form id="upload-delete" action="<?= base_url('master/batch/delete') ?>">

                <div class="modal-header">

                    <h5 class="modal-title">Confirm delete</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="delete-input">

                    <p>Are you sure to delete this data?</p>

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-danger btn-send">Yes, Delete</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

                </div>

            </form>

        </div>

    </div>

</div>



<div class="modal fade" id="modal-impor">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h4 class="modal-title">IMPORT DATA</h4>

            </div>

            <form action="<?= base_url('fitur/impor/batch') ?>" method="POST" enctype="multipart/form-data">



                <div class="modal-body">

                    <div class="form-group">

                        <label for="">File Excel</label>

                        <input type="file" class="form-control" id="" name="file" placeholder="Input field">

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>
                        Close</button>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>

                </div>

            </form>



        </div>

    </div>

</div>



<script type="text/javascript">
function edit(id) {

    location.href = "<?= base_url('master/batch/edit/') ?>" + id;

}

function preview(id) {

    location.href = "<?= base_url('master/batch/preview/') ?>" + id;

}

function hapus(id) {

    $("#modal-delete").modal('show');

    $("#delete-input").val(id);



}

$("#upload-delete").submit(function() {

    event.preventDefault();

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

            $(".btn-send").addClass("disabled").html(
                "<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled', true);

            $(".show_error").slideUp().html("");

        },

        success: function(response, textStatus, xhr) {

            var str = response;

            if (str.indexOf("success") != -1) {

                $(".show_error").hide().html(response).slideDown("fast");



                $(".btn-send").removeClass("disabled").html('Yes, Delete it').attr('disabled',
                    false);

            } else {

                setTimeout(function() {

                    $("#modal-delete").modal('hide');

                }, 1000);

                $(".show_error").hide().html(response).slideDown("fast");

                $(".btn-send").removeClass("disabled").html('Yes , Delete it').attr('disabled',
                    false);

                loadtable($("#select-status").val());

            }

        },

        error: function(xhr, textStatus, errorThrown) {



        }

    });

    return false;



});
</script>