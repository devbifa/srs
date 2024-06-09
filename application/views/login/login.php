
  <style type="text/css">
    ::-webkit-scrollbar-track {
      background-color: #fff;
    }

    ::-webkit-scrollbar {
      width: 13px;
      background-color: #fff;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #074c90;
    }
  </style>
<?php 



    if($this->session->userdata('session_sop')!="") {

            redirect('/');

    }

?>

<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title><?= TITLE_LOGIN_APPLICATION ?></title>

  <!-- Tell the browser to be responsive to screen width -->

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->

  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/vendor/bootstrap/css/bootstrap.min.css">


<link href="<?=base_url()?>assets/logo.jpg" rel=icon type=image/png>

  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">



  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/fonts/iconic/css/material-design-iconic-font.min.css">



  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/vendor/animate/animate.css">

  

  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/vendor/css-hamburgers/hamburgers.min.css">



  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/vendor/animsition/css/animsition.min.css">



  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/vendor/select2/select2.min.css">

  

  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/vendor/daterangepicker/daterangepicker.css">



  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/css/util.css">

  <link rel="stylesheet" type="text/css" href="<?= base_url('assets/login/')?>/css/main.css">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

  <!--[if lt IE 9]>

  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->



  <!-- Google Font -->
  <style>
  /* body{
    font-family: 'Times New Roma'
  } */
  </style>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition login-page">

<div class="limiter">

  <div class="container-login100" style="<?= LOGIN_BACKGROUND ?>">

    <div class="wrap-login100" style="<?= LOGIN_BOX  ?>"> 

       <!-- /.box-header -->

       <div class="box-header">

<div class="row">


  <div class="col-md-12">

    <div class="">          <a href="">

<!-- <button type="button" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Generate DSF</button>  -->

<h5 style="font-weight:700;">DMR FOR <?=DATE('d/m/Y')?></h5>
<br>
<!-- <button type="button" class="btn btn-sm btn-primary pull-right"><i class="fa fa-save"></i> Simpan DMR</button>  -->

</a>

<!-- 
    <a href="<?= base_url('fitur/ekspor/data_tanggal') ?>" target="_blank">

      <button type="button" class="btn btn-sm btn-warning"><i class="fa fa-file-excel-o"></i> Ekspor Data</button> 

    </a>

    <button type="button" class="btn btn-sm btn-info" onclick="$('#modal-impor').modal()"><i class="fa fa-file-excel-o"></i> Import Data</button> -->

    </div>

  </div>  

</div>



<style>
.wrap-login100 {
    width: 100%;
    overflow: auto;
    border-radius: 10px;
    padding: 55px 55px 37px 55px;
    background: #9152f8;
    background: -webkit-linear-gradient(top, #0197db, #ffffff);
    background: -o-linear-gradient(top, #0197db, #ffffff);
    background: -moz-linear-gradient(top, #0197db, #ffffff);
    background: linear-gradient(top, #0197db, #ffffff);
}
</style>

</div>

<div class="box-body">



<div class="table-responsive">
<table class="table table-bordered table-hover " style="width:100%;" id="event">
    <tr>
      <th style="min-width:50;">NO
      </th>
      <th style="min-width:200px;">AIRCRAFT REG
      </th>
      <th style="min-width:200px;">A/C REMS HRS
      </th>
      <th style="min-width:200px;">A/C TYPE INSPECTION
      </th>
      <th style="min-width:200px;">PIC
      </th>
      <th style="min-width:200px;">2ND
      </th>
      <th style="min-width:200px;">ETD (UCT)
      </th>
      <th style="min-width:200px;">ETA (UCT)
      </th>
      <th style="min-width:200px;">EET
      </th>
      <th style="min-width:200px;">ROUTE
      </th>
      <th style="min-width:200px;">BATCH
      </th>
      <th style="min-width:200px;">TYPE OF TRAINING
      </th>
      <th style="min-width:200px;">BLOCK TIME START
      </th>
      <th style="min-width:200px;">BLOCK TIME STOP
      </th>
      <th style="min-width:200px;">BLOCK TIME END
      </th>
      <th style="min-width:200px;">REMARK
      </th>
      <th style="min-width:200px;">LDG
      </th>
    </tr>
    <?php for($i=0; $i < 17; $i++){ ?>
    
    <tr>
      <td>
        <?=$i+1?>
      </td>
      <td>
       <?php
          $pesawat = $this->mymodel->selectWithQuery("SELECT * FROM pesawat ORDER BY RAND() LIMIT 1");
          foreach ($pesawat as $key => $value) {
        ?>
       <?= $value['nama_pesawat'] ?>
        <?php } ?>
      </td>
      <td>
        <?=(rand(3,10));?>
      </td>
      <td>
        <?=(rand(3,10));?>
      </td>
      <td>
     
        <!-- <option value="">--Pilih Pesawat-- -->
        <?php
$pilot = $this->mymodel->selectWithQuery("SELECT * FROM pilot ORDER BY RAND() LIMIT 1");
foreach ($pilot as $key => $value) {
?>
<?= $value['nama_lengkap'] ?>
<?php } ?>
      
      </td>
      <td>
     
        <!-- <option value="">--Pilih Pesawat-- -->
        <?php
$siswa = $this->mymodel->selectWithQuery("SELECT * FROM siswa ORDER BY RAND() LIMIT 1");
foreach ($siswa as $key => $value) {
?>
<?= $value['nama_lengkap'] ?>
<?php } ?>
      
      </td>
      <td>
        23.20
      </td>
      <td>
        02.20
      </td>
      <td>
        3.00
      </td>
      <td>
     
        <option value="">WSN-TB3-GILIMANUK-WSN
        <option value="">WSN-GILIMANUK-WADY
        <option value="">WADY-GILIMANUK-WSN
      </td>
      <td>
     
      <?php
$batch = $this->mymodel->selectData("batch");
foreach ($batch as $key => $value) {
?>
<?= $value['nama_batch'] ?>
<?php } ?>
      </td>
      <td>
     
      <?php
$type_of_traning = $this->mymodel->selectData("type_of_traning");
foreach ($type_of_traning as $key => $value) {
?>
<?= $value['type_of_training'] ?>
<?php } ?>
      </td>
      <td>
        -
      </td>
      <td>
        -
      </td>
      <td>
        -
      </td>
      <td>
        VIA NORTH 7000'
      </td>
      <td>
        -
      </td>
      
    </tr>
            
    <?php } ?>

    </table>
</div>

</div>




    </div>
    


    <div class="wrap-login100" style="<?= LOGIN_BOX  ?>" > 

<!-- /.box-header -->

<div class="box-header">

<div class="row">


<div class="col-md-12">

<div class="">    

<!-- /.box-body -->

<form action="<?= base_url('login/act_login')?>" method="post" id="upload">

 <span class="login100-form-logo">

   <img src=" <?= LOGO ?>" style="width:200px;">


 </span>



 <span class="login100-form-title p-b-34 p-t-27">


  <b><?= LOGIN_TITLE  ?></a>

 </span>

 <div class="show_error"></div>

 <div class="wrap-input100 validate-input" data-validate = "Enter username">

   <input  class="input100" type="text" name="username" placeholder="Username">

   <span class="focus-input100" data-placeholder="&#xf207;"></span>

 </div>



 <div class="wrap-input100 validate-input" data-validate="Enter password">

   <input  class="input100" type="password" name="password" placeholder="Password">

   <span class="focus-input100" data-placeholder="&#xf191;"></span>

 </div>

 <div class="container-login100-form-btn">

   <button class="btn btn-block btn-primary">

     Login

   </button>

 </div>

</form>


</div>

</div>  

</div>



<style>
.wrap-login100 {
width: 100%;
overflow: auto;
border-radius: 10px;
padding: 55px 55px 37px 55px;
margin-top:15px;
background: #9152f8;
background: -webkit-linear-gradient(top, #0197db, #ffffff);
background: -o-linear-gradient(top, #0197db, #ffffff);
background: -moz-linear-gradient(top, #0197db, #ffffff);
background: linear-gradient(top, #0197db, #ffffff);
}
</style>

</div>

<div class="box-body">

<div class="show_error"></div>

</div>
</div>




  </div>


</div>


<!-- jQuery 3 -->

<script src="<?= base_url('assets/login/')?>/vendor/jquery/jquery-3.2.1.min.js"></script>



  <script src="<?= base_url('assets/login/')?>/vendor/animsition/js/animsition.min.js"></script>



  <script src="<?= base_url('assets/login/')?>/vendor/bootstrap/js/popper.js"></script>

  <script src="<?= base_url('assets/login/')?>/vendor/bootstrap/js/bootstrap.min.js"></script>



  <script src="<?= base_url('assets/login/')?>/vendor/select2/select2.min.js"></script>



  <script src="<?= base_url('assets/login/')?>/vendor/daterangepicker/moment.min.js"></script>

  <script src="<?= base_url('assets/login/')?>/vendor/daterangepicker/daterangepicker.js"></script>



  <script src="<?= base_url('assets/login/')?>/vendor/countdowntime/countdowntime.js"></script>



  <script src="<?= base_url('assets/login/')?>/js/main.js"></script>

<script type="text/javascript">

        $("#upload").submit(function(){



            var mydata = new FormData(this);

            var form = $(this);

            $.ajax({

                type: "POST",

                url: form.attr("action"),

                data: mydata,

                cache: false,

                contentType: false,

                processData: false,

                beforeSend : function(){

                    $("#send-btn").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Send...");

                    form.find(".show_error").slideUp().html("");



                },

                    success: function(response, textStatus, xhr) {

                    var str = response;

                    if (str.indexOf("oke") != -1){

                        document.getElementById('upload').reset();

                        $("#send-btn").removeClass("disabled").html("Sign in");

                         location.href = '<?= base_url("/") ?>';

                    }else{

                         $("#send-btn").removeClass("disabled").html("Sign in");

                        form.find(".show_error").hide().html(response).slideDown("fast");

                       

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

            

                }

            });

            return false;

            });

    </script>

<script>

  $(function () {

    $('input').iCheck({

      checkboxClass: 'icheckbox_square-blue',

      radioClass: 'iradio_square-blue',

      increaseArea: '20%' /* optional */

    });

  });

</script>

</body>

</html>


<script>
$(document).ready(function() {
    $('#event').DataTable({
  //"scrollX": true,            
  "initComplete": function (settings, json) {  
    $("#event").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
  },
});
    } );
</script>
