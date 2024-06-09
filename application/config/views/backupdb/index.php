
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Backup Database
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Fitur</a></li>
        <li class="active">Backup Database</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">

        <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                BACKUP & RESTORE
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
          <div class="box">
            <!-- /.box-header -->
 

            <div class="">
               <!-- <div class="row"> -->
             <button style="margin-left:5px;" class="btn btn-primary" onclick="backup()"><i class="fa fa-hdd-o"></i> Backup Database</button>
             <button class="btn btn-primary" onclick="backup_file()"><i class="fa fa-hdd-o"></i> Backup File</button>
             
             <button class="btn btn-success" onclick="restore_database()" ><i class="fa fa-hdd-o"></i> Restore Database</button>
             <button class="btn btn-success" onclick="restore_file()" ><i class="fa fa-hdd-o"></i> Restore File</button>
             
            </div>

             
             <hr>

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


  <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-backup-file">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Confirm Backup File</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Are you sure to backup file?</p>
              </div>
              <div class="modal-footer">

              <a href="<?=base_url('backupdb/getbackupfile')?>">
                  <button  class="btn btn-primary btn-send">Yes, Backup</button>
                </a>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
  </div> 


  
  <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="restore-database">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Confirm Restore Database</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Are you sure to restore database?</p>
                  <p>File</p>
                  <input type="file" class="form-control">
              </div>
              <div class="modal-footer">

              <a href="<?=base_url('backupdb/restore_database')?>">
                  <button  class="btn btn-primary btn-send">Yes, Restore</button>
                </a>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
  </div> 

  <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="restore-file">
      <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Confirm Restore File</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Are you sure to restore file?</p>
                  <p>File</p>
                  <input type="file" class="form-control">
              </div>
              <div class="modal-footer">

              <a href="<?=base_url('backupdb/restore_file')?>">
                  <button  class="btn btn-primary btn-send">Yes, File</button>
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
                   '       <th style="width:20px">No</th>'+'<th>DB</th>'+'<th>Size</th>'+'<th>Backup At</th>'+'<th>Backup By</th>'+'<th>Aksi</th>'+
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
                ajax: {"url": "<?= base_url('Backupdb/json') ?>", "type": "POST"},
                columns: [
                    {"data": "bdb_id","orderable": false},{"data": "bdb_file"},{"data": "bdb_sizedisplay"},
                   {"data": "bdb_created_at"},{"data": "name"}, {   "data": "view",
                        "orderable": false
                    }
                ],
                order: [[1, 'asc']],
                
             
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

         function backup_file() {
            $("#modal-backup-file").modal('show');
         }

         
         function restore_database() {
            $("#restore-database").modal('show');
         }

         function restore_file() {
            $("#restore-file").modal('show');
         }

         function download(id)
         {
          location.href = "<?= base_url('backupdb/downloaddb/') ?>"+id;
         }


         
       </script>