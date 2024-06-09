

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Champion

        <small>Tambah</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="#">Master</a></li>

        <li class="#">Champion</li>

        <li class="active">Tambah</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Champion/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Tambah Champion

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div><div class="form-group">

                      <label for="form-event">Event</label>

                      <select id="autoselect" style='width:100%' name="dt[event]" class="form-control select2">
                        <option value="">PILIH EVENT</option>
                        <?php 

                        $event = $this->mymodel->selectWhere('event',null);

                        foreach ($event as $event_record) {
                        $selected="";
                        if($event_record['id']==$_GET['id']){
                          $selected="selected";
                        }  
                          echo "<option $selected value=".$event_record['id'].">".$event_record['nama_event']."</option>";

                        }

                        ?>

                      </select>

                  </div>
                  
                  
                  <div class="form-group">

                      <label for="form-nama_champion">Nama Champion</label>

                      <input type="text" class="form-control" id="form-nama_champion" placeholder="Masukan Nama Champion" name="dt[nama_champion]">

                  </div>

                  <?php if(!empty($_GET['id'])){ ?>
                  <table class="table table-condensed table-bordered" id="table-1">
                  <thead>
                    <tr>
                      <th>
                        <i class="fa fa-arrows"></i>
                      </th>
                      <th>Tim/Pembalap</th>
                      <th>Keterangan</th>
                      <th style="width: 1px;"><button type="button" onclick="tambahBaris()" class="btn btn-success"><i class="fa fa-plus"></i></button></th>
                    </tr>
                  </thead>
                  <tbody id="tbody-table">
                    <?php 
                    $customer = $this->mymodel->selectData('customer_dnd');
                    foreach ($customer as $key => $value): ?>
                    <tr id="<?= $key+1 ?>">
                      <td><?= $key+1 ?></td>
                      <td>
                        <select required name="dt[id_pendaftaran][]" class="form-control">
                          <option <?= ($value['status']=='ENABLE')?'selected':''; ?>>ENABLE</option>
                          <option <?= ($value['status']=='DISABLE')?'selected':''; ?>>DISABLE</option>
                        </select>
                      </td>
                      <td><input required type="text" class="form-control" name="dt[keterangan][]" value="<?= $value['nama'] ?>"></td>
                      <td><button type="button" onclick="hapusBaris(<?= $key+1 ?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
              </table>
                  <?php } ?>
              <br>
                  <div class="form-group">

                      <label for="form-file">File</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div></div>

            <div class="box-footer">
              <?php if(!empty($_GET['id'])){
                ?>
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
                <?php
              }
              ?>
                

             

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

      </form>



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

                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/Champion') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>

<script>

var jum = '<?= count($customer) ?>';
function tambahBaris() {
  var pendaftaran="";
  <?php
      $id = $_GET['id'];
      $dataEvent = $this->mymodel->selectWithQuery("SELECT * FROM event WHERE id='$id'");
      $tipe = $dataEvent[0]['tipe_pendaftaran'];
      if($tipe=='Individu'){
      $pendaftaran = $this->mymodel->selectWithQuery("SELECT a.id, a.kode_pendaftaran, c.nama_lengkap FROM pendaftaran a
      LEFT OUTER JOIN pembalap c
      ON a.id = c.id_pendaftaran
      WHERE a.event='$id' AND a.status_pendaftaran='Payment'
      ORDER BY c.nama_lengkap ASC");
      foreach($pendaftaran as $p){
  ?>
    pendaftaran += "<option value='<?=$p['id']?>'><?=strtoupper($p['nama_lengkap'])?> - <?=$p['kode_pendaftaran']?> - INDIVIDU</option>";
  <?php
      }
    }else if($tipe=='Team'){
      $pendaftaran = $this->mymodel->selectWithQuery("SELECT a.id, a.kode_pendaftaran, b.nama_team 
      FROM pendaftaran a
      RIGHT OUTER JOIN team b
      ON a.id = b.id_pendaftaran
      WHERE a.event='$id' AND a.status_pendaftaran='Payment'
      ORDER BY b.nama_team ASC");
      foreach($pendaftaran as $p){
  ?>
 pendaftaran += "<option value='<?=$p['id']?>'><?=strtoupper($p['nama_team'])?> - <?=$p['kode_pendaftaran']?> - TEAM</option>";
  

  <?php
      }
    }
  ?>
  jum++;
  var html = '<tr id="'+jum+'">'+
            '    <td>'+jum+'</td>'+
            '    <td>'+
            '      <select required name="id_pendaftaran[]" class="form-control select2">'+
            '        '+pendaftaran+
            '      </select>'+
            '    </td>'+
            '    <td><input type="text" class="form-control" name="keterangan[]"></td>'+
            '    <td><button type="button" onclick="hapusBaris('+jum+')" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>'+
            '  </tr>';
  $('#tbody-table').append(html);
  loadTableDnD();
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

<script>
    $('#autoselect').bind('change', function () { // bind change event to select
        var url = '<?=base_url()?>master/champion/create/?id='+$(this).val(); // get selected value
        if (url != '') { // require a URL
            window.location = url; // redirect
        }
        return false;
    });
</script>