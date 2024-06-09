
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Log Aktivitas
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Fitur</a></li>
        <li class="active">Log Aktivitas</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
             
              
            </div>
            <div class="box-body">
              <?php if($this->session->flashdata('sukses')){ ?>  
               <div class="alert alert-success">  
                 <a href="#" class="close" data-dismiss="alert">&times;</a>  
                 <strong>Success!</strong> <?php echo $this->session->flashdata('sukses'); ?>  
               </div>  
             <?php } ?>
              <div class="table-responsive">
                <div id="load-table"></div>
              </div>
              <br>
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


    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-backup">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Confirm Backup</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Are you sure to backup database?</p>
              </div>
              <div class="modal-footer">

              <a href="<?=base_url('backupdb/getbackupdb')?>">
                  <button  class="btn btn-primary btn-send">Yes, Backup</button>
                </a>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
  </div> 


 <script type="text/javascript">
    
        function loadtable() {
            var table = '<table class="table table-bordered" id="mytable">'+
                   '     <thead>'+
                   '     <tr>'+
                   '       <th style="width:20px">No</th>'+'<th>Created at</th>'+'<th>Created By</th>'+'<th>Action</th>'+'<th>Table Name</th>'+'<th>Json Data</th>'+
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
                ajax: {"url": "<?= base_url('log_aktivitas/json') ?>", "type": "POST"},
                columns: [
                    {"data": "log_id","orderable": false},{"data": "log_created_at"},{"data": "name"},
                   {"data": "log_action"},{   "data": "log_tablename",
                        "orderable": false
                    },{"data": "log_jsondata"}, 
                ],
                order: [[1, 'DESC']],
                
             
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                }
            });
         }

         loadtable()


          function backup() {
            $("#modal-backup").modal('show');
         }

         function download(id)
         {
          location.href = "<?= base_url('backupdb/downloaddb/') ?>"+id;
         }


         
       </script>