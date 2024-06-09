



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        STUDENT APPLICATION FORM

        <small>DATA FROM MARKETING</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">STUDENT APPLICATION FORM</li>

        <li class="active">DATA FROM MARKETING</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          <div class="box">

          <div class="box-header-material">
              <h3 class="box-header-material-text">APPLICANT STATUS
              <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
            </div>

            <div class="box-header">

              <div class="row">

                <div class="col-md-6">

                  <select onchange="loadtable(this.value)" id="select-status" style="width: 150px" class="form-control">

                      <option value="ENABLE">ENABLE</option>

                      <option value="DISABLE">DISABLE</option>



                  </select>

                </div>

                <div class="col-md-6">

                  <div class="pull-right">          
                    
                  <!-- <a href="<?= base_url('master/student_list/create') ?>">

                    <button type="button" class="btn btn-primary float-add"><i class="mdi mdi-plus"></i></button> 

                  </a> -->


                  <!-- <a href="<?= base_url('fitur/ekspor/Student_application_form') ?>" target="_blank">

                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> EXPORT DATA</button> 

                  </a>

                  <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> IMPORT DATA</button> -->

                  </div>

                </div>  

              </div>

              

            </div>

            <div class="box-body">

                  <!-- FILTER  -->
                  <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>master/student_list/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>BATCH</label>
                                            <select style='width:100%' name="batch" class="form-control select2">
                                              <option value="">SELECT BATCH</option>
                                                <?php 
                                                  $this->db->order_by('batch ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('batch',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['batch']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['batch']."' ".$text." >".$base_airport_document_record['batch']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>STATUS</label>
                                            <select style='width:100%' name="status" class="form-control select2">
                                              <option value="">SELECT STATUS</option>
                                                <?php 
                                                  $this->db->order_by('id ASC');
                                                  $this->db->where("(status IN ('WAITING CONTRACT','WAITING FINANCE','PENDING','REJECT','') )");
                                                  $base_airport_document = $this->mymodel->selectWhere('status',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['status']==$_SESSION['status']){

                                                      $text = "selected";

                                                    }

                                                    echo "<option value='".$base_airport_document_record['status']."' ".$text." >".$base_airport_document_record['status']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <button class="btn btn-success btn-block"><i class="mdi mdi-database-search"></i> FILTER</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->
                <div class="show_error"></div>



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


  <div class="modal fade bd-example-modal-sm" tabindex="-1" Student_application_form="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

      <div class="modal-dialog modal-sm">

          <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/student_list/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/Student_application_form') ?>" method="POST"  enctype="multipart/form-data">



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

    

        function loadtable(status) {

            var table = '<table class="table table-bordered table-striped" id="mytable" style="width:100%">'+

                   '     <thead>'+

                   '     <tr class="bg-success">'+

                   '       <th style="width:20px">No</th>'+'<th>BATCH<br>ALLOCATION</th>'+'<th>REGISTRATION<br>DATE</th>'+'<th>APPLICATION<br>NUMBER</th>'+'<th class="text-center">FULL NAME</th>'+'<th class="text-center">NICK NAME</th>'+'<th class="text-center">ID NUMBER</th>'+'<th class="text-center">EMAIL</th>'+
                  //  '<th>COURSE REQUIRE</th>'+
                   '<th>PLACE OF<br>BIRTH</th>'+
                   
                   '<th style="min-width:100px">DATE OF<br>BIRTH</th>'+
                   '<th>GENDER</th>'+
                   '<th>REMARK</th>'+
                   '<th>STATUS</th>'+
                  //  '       <th style="min-width:50px">STATUS</th>'+

                  //  '       <th style="min-width:50px"></th>'+

                   '     </tr>'+

                   '     </thead>'+

                   '     <tbody>'+

                   '     </tbody>'+

                   ' </table>';

             // body...

             $("#load-table").html(table)



              var t = $("#mytable").dataTable({

                initComplete: function() {

                    var api = this.api();

                    $('#mytable_filter input')

                            .off('.DT')

                            .on('keyup.DT', function(e) {

                                if (e.keyCode == 13) {

                                    api.search(this.value).draw();

                        }

                    });

                },

                oLanguage: {

                    sProcessing: "loading..."

                },

                processing: true,

                serverSide: true,

                lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]], 
                
                iDisplayLength : 25,

                ajax: {"url": "<?= base_url('master/student_list/json?status=') ?>"+status, "type": "POST"},

                columns: [

                  {"data": "id","orderable": false},
                    {"data": "batch"},
                    {"data": "registration_date"},
                    {"data": "application_number"},
                    {"data": "full_name"},
                    {"data": "nick_name"},
                    {"data": "id_number"},
                    {"data": "email"},
                    {"data": "place_of_birth"},
                    {"data": "date_of_birth"},
                    {"data": "gender"},
                    {"data": "remark"},
                    {"data": "student_status"},


                ],

                order: [[1, 'ASC'],[4, 'ASC']],

                columnDefs : [

                    { targets : [4],

                        render : function (data, type, row, meta) {

                             htmls = '<a href="#!" onclick="preview('+row['id']+')" >'+row['full_name']+'</a>'

                              return htmls;

                          }

                      },
                      {
      "targets": 4,
      "className": "text-left",
 },   {
      "targets": 5,
      "className": "text-left",
 },

                ],

             

                rowCallback: function(row, data, iDisplayIndex) {

                    var info = this.fnPagingInfo();

                    var page = info.iPage;

                    var length = info.iLength;

                    var index = page * length + (iDisplayIndex + 1);

                    $('td:eq(0)', row).html(index);

                }

            });

         }





         loadtable($("#select-status").val());

           

      function edit(id) {

            location.href = "<?= base_url('master/student_list/edit/') ?>"+id;

         }
         
         function preview(id) {

          location.href = "<?= base_url('master/student_list/preview/') ?>"+id;

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