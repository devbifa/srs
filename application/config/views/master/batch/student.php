



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
                <?php 
                $batch = $this->uri->segment(4);
                $batch = $this->mymodel->selectDataOne('batch',array('batch'=>$batch));
                $batch = $batch['batch'];
                ?>
                BATCH <?=$batch?> STUDENT
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-header">

              <div class="row">

              

                <div class="col-md-6">

                  <div class="pull-right">          <a href="<?= base_url('master/batch/create') ?>">

                    <button type="button" class="btn btn-sm btn-success float-1"><i class="mdi mdi-plus"></i></button> 

                  </a>


                  <!-- <a href="<?= base_url('fitur/ekspor/batch') ?>" target="_blank">

                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> EXPORT DATA</button> 

                  </a>

                  <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> IMPORT DATA</button> -->

                  </div>

                </div>  

              </div>

              

            </div>

            <div class="box-body">

                <div class="show_error"></div>



              <div class="table-responsive">

              <table class="table table-bordered " id="example2">

<thead>

<tr class="bg-success">

                          <th style="width:20px">NUM</th><th>BATCH</th><th>FULL NAME</th><th>NICK NAME</th><th>ID NUMBER</th><th>SPL NUMBER</th><th>PPL NUMBER</th><th>CPL NUMBER</th><th>MEDEX VALID DATE</th><th>CURRICULUM</th><th>REMARK</th>       <th style="min-width:50px">STATUS</th>

      
                        </tr>

</thead>

<tbody>
<?php
$batch = $this->uri->segment(4);
?>
<form action="<?=base_url()?>master/batch/update_status" method="POST">  
<input type="hidden" name="id_batch" value="<?=$batch?>" >
<?php


$status = $this->mymodel->selectWithQuery("SELECT * FROM status");

$data = $this->mymodel->selectWithQuery("SELECT a.id, a.graduated_status, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status, c.curriculum,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM user a
LEFT JOIN batch b
ON a.batch = b.id
LEFT JOIN curriculum c
ON b.curriculum = c.id
WHERE a.batch = '$batch' AND a.student_status = 'APPROVE' AND a.visibility = '1' AND a.instructor_status != '1' AND a.full_name != ''");
foreach($data as $key=>$val){

  ?>
<tr>
<td><?=$key+1?>
</td>
<td><?=$val['batch']?>
</td>
<td><?=$val['full_name']?>
</td>
<td><?=$val['nick_name']?>
</td>
<td><?=$val['id_number']?>
</td>
<td><?=$val['spl_number']?>
</td>
<td><?=$val['ppl_number']?>
</td>
<td><?=$val['cpl_number']?>
</td>
<td><?=$val['medex_valid_date']?>
</td>
<td><?=$val['curriculum']?>
</td>
<td><?=$val['remark']?>
</td>
<td>
  <input type="hidden" name="student[<?=$key?>]" value="<?=$val['id']?>">
  <select class="form-control select2" name="status[<?=$key?>][status]" id="" style="width:150px;">
    <?php foreach($status as $k=>$v){
      $text = "";
      if($val['status']==$v['status']){
        $text = "selected";
      }
      ?>
      <option <?=$text?> value="<?=$v['status']?>"><?=$v['status']?></option>
    <?php } ?>
  </select>
</td>
</tr>
<?php } ?>
<tr>
  <td colspan="11"></td>
  <td><button type="submit" class="btn btn-primary btn-block">SAVE STATUS</button></td>
</tr>
</form>
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


  <div class="modal fade bd-example-modal-sm" tabindex="-1" batch="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

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

        <form action="<?= base_url('fitur/impor/batch') ?>" method="POST"  enctype="multipart/form-data">



        <div class="modal-body">

            <div class="form-group">

              <label for="">File Excel</label>

              <input type="file" class="form-control" id="" name="file" placeholder="Input field">

            </div>

        </div>

        <div class="modal-footer">

          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>

          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>

        </div>

        </form>



      </div>

    </div>

  </div>



  <script type="text/javascript">

    

           

      function edit(id) {

            location.href = "<?= base_url('master/batch/edit/') ?>"+id;

         }
         function preview(id) {

          location.href = "<?= base_url('master/batch/preview/') ?>"+id;

       }
                  function hapus(id) {

            $("#modal-delete").modal('show');

            $("#delete-input").val(id);

            

         }

         $("#upload-delete").submit(function(){

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

                beforeSend : function(){

                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                    $(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                   var str = response;

                    if (str.indexOf("success") != -1){

                        $(".show_error").hide().html(response).slideDown("fast");

                       

                        $(".btn-send").removeClass("disabled").html('Yes, Delete it').attr('disabled',false);

                    }else{

                         setTimeout(function(){ 

                           $("#modal-delete").modal('hide');

                        }, 1000);

                        $(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('Yes , Delete it').attr('disabled',false);

                        loadtable($("#select-status").val());

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

            

                }

            });

            return false;

    

        });

  </script>