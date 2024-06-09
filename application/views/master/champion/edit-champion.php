

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Champion

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="#">Master</a></li>

      <li class="#">Champion</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Champion/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $champion['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Champion

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div><div class="form-group">

                      <label for="form-event">Event</label>

                    <select disabled id="autoselect" style='width:100%' class="form-control select2">
                        <option value="">PILIH EVENT</option>

                        <?php 

                        $event = $this->mymodel->selectWhere('event',null);

                        foreach ($event as $event_record) {

                          $text="";

                          if($event_record['id']==$champion['event']){

                            $text = "selected";

                          }



                          echo "<option value=".$event_record['id']." ".$text." >".$event_record['nama_event']."</option>";

                        }

                        ?>

                      </select>

                  </div><div class="form-group">

                      <label for="form-nama_champion">Nama Champion</label>

                      <input type="text" class="form-control" id="form-nama_champion" placeholder="Masukan Nama Champion" name="dt[nama_champion]" value="<?= $champion['nama_champion'] ?>">
                      <input type="hidden" name="dt[event]"  value="<?=$champion['event']?>">
                  </div>
                  
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
                    
                    $id_event = $champion['event'];
                    $id = $champion['event'];
                    $id_champion = $champion['id'];

                   

                    $data = $this->mymodel->selectWithQuery("SELECT * FROM champion_item
                    WHERE id_champion='$id_champion' ORDER BY keterangan ASC");

                    foreach ($data as $key => $p): 
                  
                    ?>
                    <tr id="<?= $key+1 ?>">
                      <td><?= $key+1 ?></td>
                      <td>
                        <select required name="id_pendaftaran[]" class="form-control">
                        <!-- <?php
                        $data_pembalap = $this->mymodel->selectWithQuery("SELECT DISTINCT(a.id), a.id, a.kode_pendaftaran, b.nama_team, c.nama_lengkap FROM pendaftaran a
                        LEFT OUTER JOIN team b
                        ON a.id = b.id_pendaftaran
                        LEFT OUTER JOIN pembalap c
                        ON a.id = c.id_pendaftaran
                        WHERE a.event='$id_event' AND a.status_pendaftaran='Payment'
                        ORDER BY b.nama_team ASC, c.nama_lengkap ASC");
                        foreach($data_pembalap as $k){ 
                        $selected="";
                        if (empty($k['nama_team'])){
                          $k['nama_team'] = 'INDIVIDU';
                        }else{
                          $k['nama_lengkap'] = 'TEAM';
                        }
                        if($p['id_pendaftaran']==$k['id']){
                          $selected='selected';
                        }
                        ?>
                        <option <?=$selected?> value='<?=$k['id']?>'><?=$k['kode_pendaftaran']?> - <?=strtoupper($k['nama_team'])?> - <?=strtoupper($k['nama_lengkap'])?></option>
                        <?php } ?> -->

                        <?php
      $id = $champion['event'];
      $dataEvent = $this->mymodel->selectWithQuery("SELECT * FROM event WHERE id='$id'");
      $tipe = $dataEvent[0]['tipe_pendaftaran'];
      if($tipe=='Individu'){
      $pendaftaran = $this->mymodel->selectWithQuery("SELECT a.id, a.kode_pendaftaran, c.nama_lengkap FROM pendaftaran a
      LEFT OUTER JOIN pembalap c
      ON a.id = c.id_pendaftaran
      WHERE a.event='$id' AND a.status_pendaftaran='Payment'
      ORDER BY c.nama_lengkap ASC");
      foreach($pendaftaran as $k){
        $selected = "";
        if($p['id_pendaftaran']==$k['id']){
          $selected='selected';
        }
  ?>
  <option  <?=$selected?> value='<?=$k['id']?>'><?=strtoupper($k['nama_lengkap'])?> - <?=$k['kode_pendaftaran']?> - INDIVIDU</option>
  <?php
      }
    }else if($tipe=='Team'){
      $pendaftaran = $this->mymodel->selectWithQuery("SELECT a.id, a.kode_pendaftaran, b.nama_team 
      FROM pendaftaran a
      RIGHT OUTER JOIN team b
      ON a.id = b.id_pendaftaran
      WHERE a.event='$id' AND a.status_pendaftaran='Payment'
      ORDER BY b.nama_team ASC");
      foreach($pendaftaran as $k){
        $selected = "";
        if($p['id_pendaftaran']==$k['id']){
          $selected='selected';
        }
  ?>
  
  <option  <?=$selected?>  value='<?=$k['id']?>'><?=strtoupper($k['nama_team'])?> - <?=$k['kode_pendaftaran']?> - TEAM</option>

  <?php
      }
    }
  ?>

                        
                        </select>
                      </td>
                      <td><input required type="text" class="form-control" name="keterangan[]" value="<?= $p['keterangan'] ?>"></td>
                      <td><button type="button" onclick="hapusBaris(<?= $key+1 ?>)" class="btn btn-danger"><i class="fa fa-trash"></i></button></td>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
              </table>

              <br>
                  <?php

                  if($file['dir']!=""){

                  $types = explode("/", $file['mime']);

                  if($types[0]=="image"){

                  ?>

                    <img src="<?= base_url($file['dir']) ?>" style="width: 200px" class="img img-thumbnail">

                    <br>

                  <?php }else{ ?>

                    

                    <i class="fa fa-file fa-5x text-danger"></i>

                    <br>

                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>

                    <br>

                  <br>

                <?php } ?>

                <?php } ?><div class="form-group">

                      <label for="form-file">File</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div></div>

            <div class="box-footer">

                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>

                <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>

             

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

var jum = '<?= count($data) ?>';
function tambahBaris() {
  var pendaftaran="";
  <?php
      $id = $champion['event'];
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
            '    <td><input required type="text" class="form-control" name="keterangan[]"></td>'+
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