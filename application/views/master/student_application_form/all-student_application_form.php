



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
              <?php 
              $count = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count FROM user WHERE instructor_status != '1'AND student_status != 'APPROVE' AND visibility = '1'");
              $count = $count[0]['count'];
              ?>
              <!-- <h3 class="box-header-material-text">APPLICATION LIST <span class="count">(<?=$count?> APPLICANT)</span> -->
              <h3 class="box-header-material-text">APPLICATION LIST <span class="">(<?=$count?> APPLICANT)</span>

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
                    
                  <!-- <a href="<?= base_url('master/user/create') ?>">
               
                    <button data-toggle="tooltip" data-placement="top" title="ADD APPLICANT" type="button" class="btn btn-primary float-add"><i class="mdi mdi-plus"></i></button> 

                  </a> -->


                  <!-- <a href="<?= base_url('fitur/ekspor/user') ?>" target="_blank">

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
                                <form autocomplete="off" action="<?= base_url() ?>master/student_application_form/filter" method="post">
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
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>START DATE</label>
                                            <input placeholder="Start Date" type="text" class="form-control tgl" value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>END DATE</label>
                                            <input placeholder="End Date" type="text" class="form-control tgl" class="form-control" value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
                                        </div>
                                    </div> -->
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


  <div class="modal fade bd-example-modal-sm" tabindex="-1" user="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

      <div class="modal-dialog modal-sm">

          <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/user/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/user') ?>" method="POST"  enctype="multipart/form-data">



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

                   '       <th style="width:20px">No</th>'+'<th>BATCH<br>ALLOCATION</th>'+'<th>REGISTRATION<br>DATE</th>'+'<th>APPLICATION<br>NUMBER</th>'+'<th class="text-center">FULL NAME</th>'+'<th class="text-center">NICK NAME</th>'+
                  //  '<th>COURSE REQUIRE</th>'+
                   '<th>PLACE OF<br>BIRTH</th>'+
                   
                   '<th style="min-width:100px">DATE OF<br>BIRTH</th>'+
                   '<th>GENDER</th>'+
                   '<th>REMARK</th>'+
                   '<th>STATUS</th>'+
                  //  '<th>IDENTITY CARD NO</th>'+
                  //  '<th>WEIGHT</th>'+'<th>HEIGHT</th>'+'<th>ADDRESS</th>'+'<th>CITY</th>'+'<th>ZIP CODE</th>'+'<th>DOMICILE ADDRESS</th>'+'<th>DOMICILE CITY</th>'+'<th>DOMICILE ZIP</th>'+'<th>HOME TELEPHONE NUMBER</th>'+'<th>MOBILE PHONE NUMBER</th>'+'<th>MARITAL STATUS</th>'+'<th>EMAIL</th>'+'<th>RELIGION</th>'+
                  //  '<th>NATIONALITY</th>'+
                  //  '<th>T-SHIRT SIZE</th>'+
                  //  '<th>SHOES SIZE</th>'+
                  //  '<th>STATUS</th>'+
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

                serverSide: false,
                
                lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]], 
                
                iDisplayLength : 25,

                ajax: {"url": "<?= base_url('master/student_application_form/json?status=') ?>"+status, "type": "POST"},

                columns: [

                    {"data": "id","orderable": false},
                    {"data": "batch"},
                    {"data": "registration_date"},
                    {"data": "application_number"},
                    {"data": "full_name"},
                    {"data": "nick_name"},
                    {"data": "place_of_birth"},
                    {"data": "date_of_birth"},
                    {"data": "gender"},
                    {"data": "remark"},
                    {"data": "status"},

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

            location.href = "<?= base_url('master/user/edit/') ?>"+id;

         }
         
         function preview(id) {

          location.href = "<?= base_url('master/student_application_form/edit/') ?>"+id;

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