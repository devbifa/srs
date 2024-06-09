

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        INSTRUCTOR FILE

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">INSTRUCTOR FILE</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/inspection_type/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $inspection_type['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

            <!-- /.box-header -->
            <!--
            <div class="box-header">

              <h5 class="box-title">

                  Edit Instructor File

              </h5>

            </div>
            -->

            
            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT AIRCRAFT INSPECTION TYPE
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

                      <label for="form-instructor_file">INSPECTION NUMBER</label>

                      <input type="text" class="form-control" id="form-instructor_file" placeholder="Fill Inspection Number" name="dt[inspection_number]" value="<?= $inspection_type['inspection_number'] ?>">

                  </div>  <div class="form-group col-md-3">

<label for="form-instructor_file">INSPECTION TYPE</label>

<input type="text" class="form-control" id="form-instructor_file" placeholder="Fill Inspection Type" name="dt[inspection_type]" value="<?= $inspection_type['inspection_type'] ?>">

</div> <div class="form-group col-md-6">

<label for="form-instructor_file">REMARK</label>

<input type="text" class="form-control" id="form-instructor_file" placeholder="Fill Remark" name="dt[remark]" value="<?= $inspection_type['remark'] ?>">

</div>
<div class="form-group col-md-12">
  <label for="">Konfigurasi Jawaban</label>
  <div class="table-responsive">
  <table class="table table-condensed table-bordered" id="table-1">
  <thead>
    <tr>
      <th style="vertical-align:top;text-align:center;width:50px;" class="text-center">
        <i class="fa fa-arrows"></i>
      </th>
      <th class="text-left" >Option</th>
      <th class="text-left">Next Due Hours</th>
      <th style="width: 1px;"><button type="button" onclick="tambahBaris()" class="btn btn-success"><i class="fa fa-plus"></i></button></th>
    </tr>
  </thead>
  <tbody id="tbody-table">
  <?php
  $konfigurasi = (json_decode($inspection_type['konfigurasi'],true));
  $no = 0; 
  foreach($konfigurasi as $key=>$val){
  ?>
      <tr id="<?=$key?>">
      <td style="vertical-align:top;text-align:center;width:50px;"><?=$no+1?></td>
     <td>
      <input required type="text" class="form-control" id="project<?=$no?>" name="konfigurasi[<?=$key?>][option]" value="<?=$val['option']?>">
    </td>
     <td>
      <input required type="text" class="form-control" id="project<?=$no?>" name="konfigurasi[<?=$key?>][jam]" value="<?=$val['jam']?>">
    </td>
      <td style="width:15px;"><button <?=$disabled?> type="button" onclick="hapusBaris(<?=$key?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
    </tr>

    <?php $no++; } ?>
     
                      </tbody>
</table>
</div>
  </div>
<div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

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
                <button type="submit" class="btn btn-primary btn-send float-1" ><i class="fa fa-save"></i></button>

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

      <a href="" class="btn btn-danger float-2" href="#!" data-toggle="modal" data-target="#modal-delete-1" data-placement="top" title="DELETE BATCH" ><i class="mdi mdi-delete"></i></a>
         
         <div class="modal modal-danger fade" id="modal-delete-1">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">DELETE DATA</h4>
               </div>
               <div class="modal-body" style="color:#fff!important;">
                <form action="<?=base_url()?>master/inspection_type/delete/<?=$inspection_type['id']?>">
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

                           window.location.href = "<?= base_url('master/inspection_type') ?>";

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

  
<script>

var jum = <?=intval(count($json_jawaban))?>;

function tambahBaris() {
  var html = '<tr id="'+jum+'">'+
            '    <td></td>'+
           '        <td>'+
                    '<input required type="text" class="form-control  project" id="project'+jum+'" name="konfigurasi[][option]">'+
                    ' </td>'+
            '    <td style="width:15px" ><button type="button" onclick="hapusBaris('+jum+')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
            '  </tr>';
  jum++;
  $('#tbody-table').append(html);
  loadTableDnD();
  $('.select2').select2();
}

function hapusBaris(id) {
  if (confirm('Apakah anda yakin ingin menghapus baris ini ?')) {
    $('#tbody-table>#'+id).remove();
  } else {
    return false;
  }
}

// Initialise the first table (as before)
function loadTableDnD() {
  $("#table-1").tableDnD();
}
loadTableDnD();
</script>  

