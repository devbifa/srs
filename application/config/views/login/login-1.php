
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
    <meta name="viewport" content="width=device-width, initial-scale=1">


   
  <title><?= TITLE_APPLICATION  ?></title>
  <link href="<?=base_url()?>assets/logo.jpg" rel=icon type=image/png>

  <!-- <link rel="stylesheet" type="text/css" href="assets/fonts/Lato/lato.css"> -->
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/font-awesome-4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/plugins/animate.css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/assets/css/themes/flat-blue.css">
    
<style>
body, html {
  height: 100%;
  width:100%;
}

</style>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/assets/css/landing-page.css">
</head>

<body class="flat-blue" id="landing-page">

    <div class="container-fluid app-content-b feature-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7">
                                    </div>
                <div class="col-lg-4 col-md-4 col-sm-5 text-right color-white">
                        <img src="<?=base_url()?>assets/assets/images/logo.png" class="img-responsive" id="logo">

                        <form action="<?= base_url('login/act_login')?>" class="form-signin" method="POST" id="upload">
                    <div class="show_error"></div>
                        <input type="text" class="form-control" id="username" name="username" value="" placeholder="Username" required="" autofocus="">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                    </form>

                
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center app-content-header" style="font-size:60px;">
            SCHEDULER AND REPORTING SYSTEM
            </h1>
            <p class="app-content-company text-center"><span>PT BALI WIDYA DIRGANTARA</span></p>
        </div>
    </div>

    <script type="text/javascript" src="<?=base_url()?>assets/plugins/jQuery-2.1.4/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>assets/plugins/jquery-match-height/jquery.matchHeight-min.js"></script>
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

</body>

</html>
