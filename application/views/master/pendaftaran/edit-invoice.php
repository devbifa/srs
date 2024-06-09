

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Pendaftaran

        <small>Edit</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

      <li><a href="#">Master</a></li>

      <li class="#">Pendaftaran</li>

      <li class="active">Edit</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">



    <div>
<?php
$kode = $_GET['kode'];
$id_event = $this->db->query("SELECT event FROM pendaftaran WHERE kode_pendaftaran = '$kode'")->row('event');
if(empty($id_event)){
    redirect(base_url());
}
$id_pendaftaran = $this->db->query("SELECT id FROM pendaftaran WHERE kode_pendaftaran = '$kode'")->row('id');
$event = $this->db->query("SELECT * FROM event WHERE id = '$id_event' limit 1")->result_array();
if(empty($event)){
    redirect(base_url());
}
$row = $event[0];
?>


<div class="row">
    <div class="col-md-12">
        <h3 class="box-title" align="center"><?=$row['nama_event']?></h3>
    </div>
</div>


<?php if(1==1){ ?>
<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <div class="box">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form Pendaftaran Team</h3>
                    </div>
                    <div class="box-body">
                        
                    <form method="POST" action="<?= base_url('master/pendaftaran/edit_invoice_process/') ?>" id="upload-create" enctype="multipart/form-data">


<div class="row">

  <div class="col-xs-12">

    <div class="">

      <div class="box-body">

      <div class="form-group">


<?php
$data_team = $this->db->query("SELECT * FROM team WHERE id_pendaftaran = '$id_pendaftaran' LIMIT 1")->result_array();

foreach($data_team as $dt){
?>

<label style="color:green;">Data Team</label>

</div><div class="form-group">

<label for="form-nama_team">Nama Team</label>
<input type="hidden" name="kode_pendaftaran" value="<?=$_GET['kode']?>">
<input type="text" class="form-control" id="form-nama_team" placeholder="Masukan Nama Team" name="dtteam[nama_team]" value="<?=$dt['nama_team']?>">

</div><div class="form-group">

<label for="form-alamat">Alamat</label>

<input type="text" class="form-control" id="form-alamat" placeholder="Masukan Alamat" name="dtteam[alamat]" value="<?=$dt['alamat']?>">

</div><div class="form-group">

<label for="form-kota">Kota</label>

<input type="text" class="form-control" id="form-kota" placeholder="Masukan Kota" name="dtteam[kota]" value="<?=$dt['kota']?>">

</div><div class="form-group">

<label for="form-nomor_hp">Nomor Hp</label>

<input type="text" class="form-control" id="form-nomor_hp" placeholder="Masukan Nomor Hp" name="dtteam[nomor_hp]" value="<?=$dt['nomor_hp']?>">

</div><div class="form-group">

<label for="form-email">Email</label>

<input type="text" class="form-control" id="form-email" placeholder="Masukan Email" name="dtteam[email]" value="<?=$dt['email']?>">

</div>

<?php } ?>

<!-- <div class="form-group">

<label for="form-file">Gambar</label>

<input type="file" required class="form-control" id="form-file" placeholder="Masukan File" name="fileteam"  accept="image/*">

</div> -->


<?php
$data_pembalap = $this->db->query("SELECT * FROM pembalap WHERE id_pendaftaran = '$id_pendaftaran'")->result_array();

?>
          <?php foreach($data_pembalap as $i=>$dp){ ?>
          
            <div class="form-group">

<label style="color:green;">Data Pembalap <?=$i+1?></label>
</div>

            <div class="form-group">

<label for="form-nama_lengkap">Nama Lengkap</label>
<input type="hidden" name="id_pembalapp[]" value="<?=$dp['id']?>">
<input type="text" class="form-control" id="form-nama_lengkap" value="<?=$dp['nama_lengkap']?>" placeholder="Masukan Nama Lengkap" name="nama_lengkap[]">

</div><div class="form-group">

<label for="form-alamat">Alamat</label>

<input type="text" class="form-control" id="form-alamat" value="<?=$dp['alamat']?>"  placeholder="Masukan Alamat" name="alamat[]">

</div><div class="form-group">

<label for="form-kota">Kota</label>

<input type="text" class="form-control" id="form-kota" value="<?=$dp['kota']?>"  placeholder="Masukan Kota" name="kota[]">

</div><div class="form-group">

<label for="form-tanggal_lahir">Tanggal Lahir</label>

<input type="date" class="form-control" id="form-tanggal_lahir" value="<?=$dp['tanggal_lahir']?>"  placeholder="Masukan Tanggal Lahir" name="tanggal_lahir[]">

</div><div class="form-group">

<label for="form-nomor_start">Nomor Start</label>

<input type="text" class="form-control" id="form-nomor_start"  value="<?=$dp['nomor_start']?>"  placeholder="Masukan Nomor Start" name="nomor_start[]">

</div><div class="form-group">

<label for="form-nama_jersey">Nama Jersey</label>

<input type="text" class="form-control" id="form-nama_jersey"  value="<?=$dp['nama_jersey']?>" placeholder="Masukan Nama Jersey" name="nama_jersey[]">

</div><div class="form-group">

<label for="form-ukuran_jersey">Ukuran Jersey</label>

<select style='width:100%' name="ukuran_jersey[]" class="form-control select2">

  <?php 

  $ukuran_jersey = $this->mymodel->selectWhere('ukuran_jersey',null);

  foreach ($ukuran_jersey as $ukuran_jersey_record) {
    
    $selected = "";
    if($dp['ukuran_jersey'] == $ukuran_jersey_record['nama_ukuran_jersey']){
      $selected = "selected";
    }

    echo "<option $selected value=".$ukuran_jersey_record['nama_ukuran_jersey'].">".$ukuran_jersey_record['nama_ukuran_jersey']."</option>";

  }

  ?>

</select>

</div><div class="form-group">

<label for="form-nomor_hp">Nomor Hp</label>

<input type="text" class="form-control" id="form-nomor_hp"  value="<?=$dp['nomor_hp']?>" placeholder="Masukan Nomor Hp" name="nomor_hp[]">

</div><div class="form-group">

<label for="form-motor">Motor </label>

<select style='width:100%' name="motor[]" class="form-control select2">

  <?php 

  $motor = $this->mymodel->selectWhere('motor',null);

  

  foreach ($motor as $motor_record) {
    $selected = "";
    if($dp['motor'] == $motor_record['nama_motor']){
      $selected = "selected";
    }
    echo "<option $selected value=".$motor_record['nama_motor'].">".$motor_record['nama_motor']."</option>";

  }

  ?>

</select>

</div><div class="form-group">

<label for="form-golongan_darah">Golongan Darah</label>

<input type="text" class="form-control" id="form-golongan_darah"  value="<?=$dp['golongan_darah']?>" placeholder="Masukan Golongan Darah" name="golongan_darah[]">

</div><div class="form-group">

<label for="form-email">Email</label>

<input type="text" class="form-control" id="form-email" placeholder="Masukan Email"  value="<?=$dp['email']?>"  name="email">

</div>
<div class="form-group">
<?php 
$file = '';
$id_pembalap = $dp['id'];
$file = $this->db->query("SELECT * FROM file WHERE file.table='pembalap' AND file.table_id='$id_pembalap'")->result_array();
if($file){
    $foto = base_url().'webfile/'.$file[0]['name'];
    // $foto = 'https://nsoproject.com/admin-side/webfile/'.$file[0]['name'];
}else{
    $foto = base_url().'assets/no_image.png';
}

?>
<label for="form-file">Gambar</label>
<br>
<img src="<?=$foto?>" style="width:250px;">
<br><br>
<input type="file"   class="form-control" id="form-file" placeholder="Masukan File" name="file<?=$i+1?>"  accept="image/*">

</div>
<hr>





          <?php } ?>
          
          <div class="form-group">




          <?php
$data_manager = $this->db->query("SELECT * FROM manager WHERE id_pendaftaran = '$id_pendaftaran' LIMIT 1")->result_array();

foreach($data_manager as $dm){
?>

<label style="color:green;">Data Manager</label>

</div>

          <div class="form-group">

                      <label for="form-nama_lengkap">Nama Lengkap</label>

                      <input type="hidden" class="form-control" id="form-nama_lengkap" placeholder="Masukan Nama Lengkap" name="id_manager" value="<?=$dm['id']?>">
                      <input type="text" class="form-control" id="form-nama_lengkap" placeholder="Masukan Nama Lengkap" name="dtmanager[nama_lengkap]" value="<?=$dm['nama_lengkap']?>">

                  </div><div class="form-group">

                      <label for="form-alamat">Alamat</label>

                      <input type="text" class="form-control" id="form-alamat" placeholder="Masukan Alamat" name="dtmanager[alamat]" value="<?=$dm['alamat']?>">

                  </div><div class="form-group">

                      <label for="form-kota">Kota</label>

                      <input type="text" class="form-control" id="form-kota" placeholder="Masukan Kota" name="dtmanager[kota]" value="<?=$dm['kota']?>">

                  </div><div class="form-group">

                      <label for="form-nomor_hp">Nomor Hp</label>

                      <input type="text" class="form-control" id="form-nomor_hp" placeholder="Masukan Nomor Hp" name="dtmanager[nomor_hp]" value="<?=$dm['nomor_hp']?>">

                  </div><div class="form-group">

                      <label for="form-email">Email</label>

                      <input type="text" class="form-control" id="form-email" placeholder="Masukan Email" name="dtmanager[email]" value="<?=$dm['email']?>">

                  </div>
                  <div class="form-group">
                  
                  <?php 
                    $file = '';
                    $id_manager = $dm['id'];
                    $file = $this->db->query("SELECT * FROM file WHERE file.table='manager' AND file.table_id='$id_manager'")->result_array();
                    if($file){
                        $foto = base_url().'webfile/'.$file[0]['name'];
                        // $foto = 'https://nsoproject.com/admin-side/webfile/'.$file[0]['name'];
                    }else{
                        $foto = base_url().'assets/no_image.png';
                    }

                    ?>
                    <label for="form-file">Gambar</label>
                    <br>
                    <img src="<?=$foto?>" style="width:250px;">
                    <br><br>

                      <label for="form-file">Gambar</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="filemanager" accept="image/*">

                  </div>

<?php } ?>

      <div class="box-footer">

          <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Daftar Sekarang</button>

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

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php } ?>







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

                     window.location.href = "<?= base_url('master/pendaftaran/edit-invoice/?kode=').$_GET['kode'] ?>";

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
</div>

    </section>

    <!-- /.content -->

  </div>

  