<a href="<?= base_url('master/instructor_list/create') ?>">

<button type="button" class="btn btn-sm btn-success float-1"  data-placement="top" title="ADD INSTRUCTOR LIST" ><i class="mdi mdi-plus"></i></button> 

</a>



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
       
              <h3 class="box-header-material-text">INSTRUCTOR LIST
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
                    
                  <a href="<?= base_url('master/instructor_list/create') ?>">
               
                    <button data-toggle="tooltip" data-placement="top" title="ADD INSTRUCTOR" type="button" class="btn btn-primary float-add"  data-placement="top" title="ADD INSTRUCTOR" ><i class="mdi mdi-plus"></i></button> 

                  </a>


                  <!-- <a href="<?= base_url('fitur/ekspor/instructor_list') ?>" target="_blank">

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

              <form id="upload-delete" action="<?= base_url('master/instructor_list/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/instructor_list') ?>" method="POST"  enctype="multipart/form-data">



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

                   '       <th style="width:20px">NUM</th>'+'<th class="text-center" >FULL NAME</th>'+
                   '<th class="text-center" >NICK NAME</th>'+'<th class="text-center" >EMPLOYEE NUMBER</th>'+'<th class="text-center" >CAPABILITY</th>'+
                   '<th class="text-center" >SUBJECT</th>'+
                   '<th class="text-center" >POSITION</th>'+
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

serverSide: true,
lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]], 

iDisplayLength : 25,


                ajax: {"url": "<?= base_url('master/instructor_list/json?status=') ?>"+status, "type": "POST"},

                columns: [

                    {"data": "id","orderable": false},
                    {"data": "full_name"},
                    {"data": "nick_name"},
                    {"data": "id_number"},
                    {"data": "type"},
                    {"data": "remark_instructor"},
                    {"data": "position"},

                ],

                order: [[1, 'ASC'],[4, 'ASC']],

                columnDefs : [

                    { targets : [1],

                        render : function (data, type, row, meta) {

                             htmls = '<a href="#!" onclick="preview('+row['id']+')" >'+row['full_name']+'</a>'

                              return htmls;

                          }

                      },
                      { targets : [4],

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
      "targets": 1,
      "className": "text-left",
 },
{
      "targets": 2,
      "className": "text-left",
 },
{
      "targets": 4,
      "className": "text-left",
 },
{
      "targets": 5,
      "className": "text-left",
 },
{
      "targets": 6,
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

            location.href = "<?= base_url('master/instructor_list/edit/') ?>"+id;

         }
         
         function preview(id) {

          location.href = "<?= base_url('master/instructor_list/preview/') ?>"+id;

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