



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FLIGHT SCHEDULE

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">DAILY FLIGHT SCHEDULE</li>

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
               DAILY FLIGHT REPORT
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

                  <select onchange="loadtable(this.value)" id="select-status" style="width: 150px" class="form-control">

                      <option value="ENABLE">ENABLE</option>

                      <option value="DISABLE">DISABLE</option>



                  </select>

                </div>

               

              </div>

              

            </div>

            <div class="box-body">

             <!-- FILTER  -->
             <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>master/daily_movement_report/filter" method="post">
                                <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">SELECT ORIGIN BASE</option>
                                                <?php 
                                                  $this->db->order_by('base ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['base']==$_SESSION['origin_base']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['base']."' ".$text." >".$base_airport_document_record['base']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
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

                                                    if($base_airport_document_record['id']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['id']."' ".$text." >".$base_airport_document_record['batch']."</option>";

                                                  }

                                                  ?>

                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>START DATE</label>
                                            <input placeholder="Start Date" type="text" class="form-control tgl" value="<?= $_SESSION['start_date'] ?>" name="start_date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>END DATE</label>
                                            <input placeholder="End Date" type="text" class="form-control tgl" class="form-control" value="<?= $_SESSION['end_date'] ?>" name="end_date" autocomplete="off">
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


  <div class="modal modal-danger fade" id="modal-delete">

  <div class="modal-dialog">
            <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/daily_movement_report/delete') ?>">

              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE DATA</h4>
              </div>

              <div class="modal-body">

                  <input type="hidden" name="id" id="delete-input">

                  <p>Are you sure to delete this data?</p>

              </div>

              <div class="modal-footer">

                 
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline btn-send" href="">Delete Now</button>

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

        <form action="<?= base_url('fitur/impor/daily_movement_report') ?>" method="POST"  enctype="multipart/form-data">



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
                  
                   '       <th style="width:20px" rowspan="2">NUM</th>'+'<th rowspan="2" >ACTION</th>'+'<th style="min-width:100px" rowspan="2">DATE OF<br>FLIGHT</th>'+'<th rowspan="2" >ORIGIN<br>BASE</th>'+'<th rowspan="2" >AIRCRAFT<br>REG</th>'+'<th rowspan="2" >PIC</th>'+'<th rowspan="2" >2ND</th>'+'<th rowspan="2" >COURSE</th>'+'<th rowspan="2" >MISSION</th>'+'<th rowspan="2" >RUTE</th>'+'<th rowspan="2" >BATCH</th>'+'<th rowspan="2" >ETD<br>UTC</th>'+'<th rowspan="2" >ETA<br>UTC</th>'+'<th rowspan="2" >EET</th>'+'<th rowspan="2" >DEP</th>'+'<th rowspan="2" >ARR</th>'+'<th rowspan="2" >REMARK</th>'+
                 
                   '<th colspan="3">BLOCK TIME</th>'+ 
                   '<th colspan="3">FLIGHT TIME</th>'+  
                   '<th rowspan="2">LDG</th>'+   
                   '<th rowspan="2">REMARK REPORT</th>'+  

                   '     </tr>'+
                   '     <tr class="bg-success">'+
                  
                   
                   '<th style="min-width:50px">START</th>'+ 
                   '<th style="min-width:50px">STOP</th>'+ 
                   '<th style="min-width:50px">TOTAL</th>'+  
                   '<th style="min-width:50px">OFF</th>'+  
                   '<th style="min-width:50px">LANDING</th>'+  
                   '<th style="min-width:50px">TOTAL</th>'+   
                   
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

                ajax: {"url": "<?= base_url('master/daily_movement_report/json?status=') ?>"+status, "type": "POST"},

                columns: [

                    {"data": "id","orderable": false},{"data": "date_of_flight"},{"data": "date_of_flight"},{"data": "origin_base"},{"data": "aircraft_reg"},{"data": "pic"},{"data": "2nd"},{"data": "course"},{"data": "mission"},{"data": "rute"},{"data": "batch"},{"data": "etd_utc"},{"data": "eta_utc"},{"data": "eet"},{"data": "dep"},{"data": "arr"},{"data": "remark"},
                    {"data": "block_time_start"},
                    {"data": "block_time_stop"},
                    {"data": "block_time_total"},
                    {"data": "flight_time_take_off"},
                    {"data": "flight_time_landing"},
                    {"data": "flight_time_total"},
                    {"data": "ldg"},
                    {"data": "remark_dmr"},

                

                ],

                order: [[1, 'asc']],

                columnDefs : [

                  { targets : [1],

render : function (data, type, row, meta) {

     htmls = '<a href="<?=base_url()?>master/daily_movement_report/edit/'+row['id']+'" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>'+
     '';

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
      "targets": 8,
      "className": "text-left",
 },

 {
      "targets": 9,
      "className": "text-left",
 },
                      { targets : [17],

render : function (data, type, row, meta) {

     htmls = '<a href="<?=base_url()?>master/daily_movement_report/edit/'+row['id']+'?c=1">'+row['block_time_start']+'</a>'+
     '';

      return htmls;

  }
                      },
                      
                      { targets : [18],

render : function (data, type, row, meta) {

     htmls = '<a href="<?=base_url()?>master/daily_movement_report/edit/'+row['id']+'?c=2">'+row['block_time_stop']+'</a>'+
     '';

      return htmls;

  }
                      },

                       
{ targets : [20],

render : function (data, type, row, meta) {

htmls = '<a href="<?=base_url()?>master/daily_movement_report/edit/'+row['id']+'?c=3">'+row['flight_time_take_off']+'</a>'+
'';

return htmls;

}
},

                       
{ targets : [21],

render : function (data, type, row, meta) {

htmls = '<a href="<?=base_url()?>master/daily_movement_report/edit/'+row['id']+'?c=4">'+row['flight_time_landing']+'</a>'+
'';

return htmls;

}
},

                      
//                       { targets : [20],

// render : function (data, type, row, meta) {

//      htmls = '<a href="<?=base_url()?>master/daily_movement_report/edit/'+row['id']+'">'+row['block_time_total']+'</a>'+
//      '';

//       return htmls;

//   }
//                       },
                      

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

            location.href = "<?= base_url('master/daily_movement_report/edit/') ?>"+id;

         }
         function preview(id) {

          location.href = "<?= base_url('master/daily_movement_report/preview/') ?>"+id;

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