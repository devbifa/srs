



 <!-- Content Wrapper. Contains page content -->

 <div class="content-wrapper">

<!-- Content Header (Page header) -->

<section class="content-header">

  <h1>

    Mission

    <small>Data</small>

  </h1>

  <ol class="breadcrumb">

    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

    <li class="#">Mission</li>

    <li class="active">Data</li>

  </ol>

</section>

<!-- Main content -->

<section class="content">

  <div class="row">

    <div class="col-xs-12">

      <div class="box">

        <!-- /.box-header -->

        <div class="box-header">

          <div class="row">

            <div class="col-md-6">

              <select onchange="loadtable(this.value)" id="select-status" style="width: 150px" class="form-control">

                  <option value="ENABLE">ENABLE</option>

                  <option value="DISABLE">DISABLE</option>



              </select>

            </div>

            <div class="col-md-6">

              <div class="pull-right">          <a href="<?= base_url('master/mission/create') ?>">

                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Data</button> 

              </a>


              <a href="<?= base_url('fitur/ekspor/mission') ?>" target="_blank">

                <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> Ekspor Data</button> 

              </a>

              <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> Import Data</button>

              </div>

            </div>  

          </div>

          

        </div>

        <div class="box-body">

            <div class="show_error"></div>

          <?php
            $data = $this->mymodel->selectWithQuery("SELECT * FROM curriculum WHERE status='ENABLE'");
            foreach($data as $key=>$val){
            $curriculum = $val['curriculum'];
            $data_course = $this->mymodel->selectWithQuery("SELECT * FROM course WHERE status='ENABLE' AND curriculum='$curriculum' ORDER BY position ASC");
            foreach($data_course as $key2=>$val2){
          ?>


<div class="table-responsive">
          <table class="table table-responsive">
          <tr class="bg-orange">
            <td style="min-width:50;" colspan="17"><h5 style="padding:0px;margin:0px;text-align:left;">CURRICULUM : <?=$val['curriculum_name']?> - COURSE : <?=$val2['course_name']?></h5>
            </td>
          </tr>
          <tr class="bg-blue">
            <td class="border-right" style="min-width:20px;">NUM
            </td>
            <td class="border-right" style="min-width:20px;">CODE
            </td>
            <td class="border-right" style="min-width:20px;">MISSION
            </td>
            <td class="border-right" style="min-width:20px;">DUAL DURATION
            </td>
            <td class="border-right" style="min-width:20px;">SOLO DURATION
            </td>
            
            <td style="min-width:50px;">ACTION
            </td>
            
          </tr>
          <?php 
          $course_code = $val2['course_code'];
         $data_course = $this->mymodel->selectWithQuery("SELECT * FROM mission WHERE status='ENABLE' AND course_code='$course_code' ORDER BY position ASC");
         foreach($data_course as $key3=>$val3){
          ?>
          
          <tr class="bg-primary">
            <td class="border-right">
              <?=$key3+1?>
            </td>
            <td class="border-right">
              <?=$val3['mission_code']?>
            </td>
            <td class="border-right">
              <?=$val3['mission_name']?>
            </td>
            <td class="border-right">
              <?=$val3['dual_duration']?>
            </td>
            <td class="border-right">
              <?=$val3['solo_duration']?>
            </td>
            <td>
            <a class="btn btn-warning btn-sm mb-5 btn-block" href="<?=base_url()?>master/mission/edit/<?=$val3['id']?>">Edit</a>
                <button type="button" onclick="hapus('<?=$val3['id']?>')" class="btn btn-sm mb-5 btn-danger  btn-block">Delete</button>
               
            </td>
          </tr>

          <?php } ?>


          </table>
      </div>


      <br>
      <?php } ?>

            <?php } ?>

          <div class="table-responsive">

            <div id="load-table"></div>

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


<div class="modal fade bd-example-modal-sm" tabindex="-1" mission="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

  <div class="modal-dialog modal-sm">

      <div class="modal-content">

          <form id="upload-delete" action="<?= base_url('master/Mission/delete') ?>">

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

      <h4 class="modal-title">Impor Data</h4>

    </div>

    <form action="<?= base_url('fitur/impor/mission') ?>" method="POST"  enctype="multipart/form-data">



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



  //   function loadtable(status) {

  //       var table = '<table class="table table-bordered" id="mytable">'+

  //              '     <thead>'+

  //              '     <tr class="bg-success">'+

  //              '       <th style="width:20px">No</th>'+'<th>Course Code</th>'+'<th>Mission Code</th>'+'<th>Mission Name</th>'+'<th>Position</th>'+'<th>Description</th>'+'       <th style="width:150px">Status</th>'+

  //              '       <th style="width:150px"></th>'+

  //              '     </tr>'+

  //              '     </thead>'+

  //              '     <tbody>'+

  //              '     </tbody>'+

  //              ' </table>';

  //        // body...

  //        $("#load-table").html(table)



  //         var t = $("#mytable").dataTable({

  //           initComplete: function() {

  //               var api = this.api();

  //               $('#mytable_filter input')

  //                       .off('.DT')

  //                       .on('keyup.DT', function(e) {

  //                           if (e.keyCode == 13) {

  //                               api.search(this.value).draw();

  //                   }

  //               });

  //           },

  //           oLanguage: {

  //               sProcessing: "loading..."

  //           },

  //           processing: true,

  //           serverSide: true,

  //           ajax: {"url": "<?= base_url('master/Mission/json?status=') ?>"+status, "type": "POST"},

  //           columns: [

  //               {"data": "id","orderable": false},{"data": "course_code"},{"data": "mission_code"},{"data": "mission_name"},{"data": "position"},{"data": "description"},

  //              {"data": "status"},

  //               {   "data": "view",

  //                   "orderable": false

  //               }

  //           ],

  //           order: [[1, 'asc']],

  //           columnDefs : [

  //               { targets : [6],

  //                   render : function (data, type, row, meta) {

  //                         if(row['status']=='ENABLE'){

  //                           var htmls = '<a href="<?= base_url('master/Mission/status/') ?>'+row['id']+'/DISABLE">'+

  //                                       '    <button type="button" class="btn btn-sm btn-sm btn-success"><i class="fa fa-home"></i> ENABLE</button>'+

  //                                       '</a>';

  //                         }else{

  //                           var htmls = '<a href="<?= base_url('master/Mission/status/') ?>'+row['id']+'/ENABLE">'+

  //                                       '    <button type="button" class="btn btn-sm btn-sm btn-danger"><i class="fa fa-home"></i> DISABLE</button>'+

  //                                       '</a>';



  //                         }

  //                         return htmls;

  //                     }

  //                 }

  //           ],

         

  //           rowCallback: function(row, data, iDisplayIndex) {

  //               var info = this.fnPagingInfo();

  //               var page = info.iPage;

  //               var length = info.iLength;

  //               var index = page * length + (iDisplayIndex + 1);

  //               $('td:eq(0)', row).html(index);

  //           }

  //       });

  //    }





  //    loadtable($("#select-status").val());

       

  // function edit(id) {

  //       location.href = "<?= base_url('master/mission/edit/') ?>"+id;

    //  }
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

                   
                    setTimeout(function(){ 

window.location.href = "<?= base_url('master/Mission') ?>";

}, 1000);

                }else{

                     setTimeout(function(){ 

                       $("#modal-delete").modal('hide');

                    }, 1000);

                    $(".show_error").hide().html(response).slideDown("fast");

                    $(".btn-send").removeClass("disabled").html('Yes , Delete it').attr('disabled',false);

                    // loadtable($("#select-status").val());

                    setTimeout(function(){ 

window.location.href = "<?= base_url('master/Mission') ?>";

}, 1000);

                }

            },

            error: function(xhr, textStatus, errorThrown) {

        

            }

        });

        return false;



    });

</script>
