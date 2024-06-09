



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        USER

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">USER</li>

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
              USER DATA
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>


            <div class="box-header" style="display:none;">

              <div class="row">

                <div class="col-md-6">

                  <select onchange="loadtable(this.value)" id="select-status" style="width: 150px" class="form-control">

                      <option value="ENABLE">ENABLE</option>

                      <option value="DISABLE">DISABLE</option>



                  </select>

                </div>

                <div class="col-md-6">

                  <div class="pull-right">          


                  <a href="<?= base_url('fitur/ekspor/user') ?>" target="_blank">

                    <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> EXPORT DATA</button> 

                  </a>

                  <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> IMPORT DATA</button>

                  </div>

                </div>  

              </div>

              

            </div>

            <a href="<?= base_url('master/user/create') ?>">

                    <button type="button" class="btn btn-sm btn-success float-1" data-placement="top" title="ADD USER DATA"><i class="mdi mdi-plus"></i></button> 

                  </a>

            <div class="box-body">

                <!-- FILTER  -->
                <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>master/user/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ROLE</label>
                                            <select style='width:100%' name="role_filter" class="form-control select2">
                                              <option value="">ALL ROLE</option>
                                                <?php 
                                                //  $dat = $this->mymodel->selectDataOne("role",array('id'=>$_SESSION['role']));
                    
                                                  $this->db->order_by('role ASC');
                                                  // $base_airport_document = $this->mymodel->selectWhere('role',null);

                                                  // $role = $this->mymodel->selectWhere("role",array('created_role'=>$_SESSION['role'],'status'=>'ENABLE'));
                                                  if($_SESSION['role']=='1'){
                                                    $role = $this->mymodel->selectWhere("role","id NOT IN ('4','25')");
                                                  }else{
                                                    $role = $this->mymodel->selectWhere("role",array('created_role'=>$_SESSION['role'],'status'=>'ENABLE'));
                                                  }
                                                  
                                                  foreach ($role as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['id']==$_SESSION['role_filter']){

                                                      $text = "selected";

                                                    }


                                                   
                                                    echo "<option value='".$base_airport_document_record['id']."' ".$text." >".$base_airport_document_record['role']."</option>";
                               
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
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp</label><br>
                                            <a target="_blank" href="<?=base_url()?>master/user/print" class="btn btn-success btn-block"><i class="mdi mdi-printer"></i> PRINT</a>
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

            var table = '<table class="table table-bordered" id="mytable" style="width:100%">'+

                   '     <thead>'+

                   '     <tr class="bg-success">'+

                   '       <th style="width:20px">NUM</th>'+'<th>ROLE</th>'+'<th>ID NUMBER</th>'+'<th>FULL NAME</th>'+'<th>NICK NAME</th>'+'<th>EMAIL</th>'+'<th>CAPABILITY</th>'+'<th>SUBJECT</th>'+'<th>POSITION</th>'+'<th>BASE</th>'+'<th>STATUS</th>'+
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

                ajax: {"url": "<?= base_url('master/user/json?status=') ?>"+status, "type": "POST"},

                columns: [

                    {"data": "id","orderable": false},{"data": "role"},{"data": "id_number"},{"data": "full_name"},{"data": "nick_name"},{"data": "email"},
                    {"data": "type"},
                    {"data": "remark_instructor"},
                    {"data": "position"},
                    {"data": "base"},
                    {"data": "status"},

               

                ],

                order: [[1, 'asc']],

                columnDefs : [

                    { targets : [2],

                        render : function (data, type, row, meta) {

                              htmls = '<a href="<?=base_url()?>master/user/edit/'+row['id']+'">'+row['id_number']+'</a>';

                              return htmls;

                          }

                      },   { targets : [6],

render : function (data, type, row, meta) {
var json = (row['type']);
text = '';
if(json.includes("GROUND")){
  text += 'GROUND, ';
}
if(json.includes("FTD")){
  text += 'FTD, ';
}
if(json.includes("FLIGHT")){
  text += 'FLIGHT, ';
}
text = text.slice(0, -2);
     htmls = text;

      return htmls;

  }

},
{
      "targets": 5,
      "className": "text-left",
 },
{
      "targets": 6,
      "className": "text-left",
 },
{
      "targets": 7,
      "className": "text-left",
 },
                      {
                            "targets": 1,
                            "className": "text-left",
                      },
                      {
                            "targets": 2,
                            "className": "text-left",
                      },
                      {
                            "targets": 3,
                            "className": "text-left",
                      },
                      {
                            "targets": 4,
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

          location.href = "<?= base_url('master/user/preview/') ?>"+id;

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