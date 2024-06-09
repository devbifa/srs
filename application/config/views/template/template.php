<?php 

    $user = $this->mymodel->selectDataone('user', array('id'=>$_SESSION['id']));
    // $jsonmenu = json_decode($user['menu']);
    // print_r($jsonmenu);
    
    if($this->session->userdata('session_sop')=="") {
            redirect('login/');
    }

    // if($this->session->userdata('role') != "20") {
            
    // }else{
    //   redirect('login/');
    // }
 ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= TITLE_APPLICATION  ?></title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Select 2 -->
  
  <link href="<?=base_url()?>assets/logo.jpg" rel=icon type=image/png>

  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/select2/dist/css/select2.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Material Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>fonts/material-icons/css/materialdesignicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
  <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">

  <script src="<?= base_url('assets/') ?>bower_components/jquery/dist/jquery.min.js"></script>

  <!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  
  <!-- CK Editor -->
  <script src="<?=base_url()?>assets/bower_components/ckeditor/ckeditor.js"></script>
  <!-- Bootstrap WYSIHTML5 -->
  <script src="<?=base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  
<script>
  $(function () {
    $('#editor1').wysihtml5({
  toolbar: {
    "font-styles": false, // Font styling, e.g. h1, h2, etc.
    "emphasis": true, // Italics, bold, etc.
    "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
    "html": false, // Button which allows you to edit the generated HTML.
    "link": false, // Button to insert a link.
    "image": false, // Button to insert an image.
    "color": false, // Button to change color of font
    "blockquote": false, // Blockquote 
  }
})
  })
</script>

  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/timepicker/bootstrap-timepicker.min.css">
  

  <?php
            $logo = $this->mymodel->selectDataone('file', array('table_id' => '7', 'table' => 'Konfig'));
          ?>


<link href="<?= base_url().'webfile/'.$logo['name'] ?>"rel=icon type=image/png>

<link rel="stylesheet" href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome-font-awesome.min.css">

  <!-- <style type="text/css">
    @import url('https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700|Poppins:300,400,500,600,700|Raleway:300,400,500,600,700');
    body{
      font-family: Montserrat;
    }

  </style> -->

<!-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet"> -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>dist/css/main.css">

<!-- jQuery 3 -->
<script src="<?= base_url('assets/') ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="<?= base_url('assets/') ?>bower_components/jquery-ui/jquery-ui.min.js"></script> -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- DataTables -->
<script src="<?= base_url('assets/') ?>bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
       
            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
            {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };
         function idleLogout(){
        var t;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer; // catches touchscreen presses
        window.onclick = resetTimer;     // catches touchpad clicks
        window.onscroll = resetTimer;    // catches scrolling with arrow keys
        window.onkeypress = resetTimer;

        function logout() {
            // window.location.href = '<?= base_url()?>';
        }

        function resetTimer() {
            clearTimeout(t);
            t = setTimeout(logout,900000);  // time is in milliseconds //60000 = 1 minutes
        }
        }

    idleLogout();
  </script>
    <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Potta+One&display=swap" rel="stylesheet"> -->

<!-- <link rel="preconnect" href="https://fonts.gstatic.com"> -->
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


    <style>
    th,td{
      font-weight:500!important;
    }
      .alert{
        margin-top:15px;
      }
        .ui-autocomplete { z-index:2147483647; }
        h1,h2,h3,h4,h5,h6,p,span,body,h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6, .main-header .logo .logo-lg,.sidebar-mini.sidebar-collapse .main-header .logo>.logo-mini{
            font-family: Poppins-Regular, sans-serif !important;
            /* font-family: Bahnschrift, sans-serif !important; */
            /* font-family: 'Potta One', cursive; */
            /* font-family: 'Source Sans Pro', sans-serif; */
        }
        .mb-5{
          margin-bottom:5px;
        }
        input[type="checkbox"]{
  width: 15px; /*Desired width*/
  height: 15px; /*Desired height*/
}
        table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting {
    padding-right: 5px;
}

.main-footer{
  /* display:none; */
}

.box-header{
  display:none;
}
    </style>

<style>
    .dataTable > thead > tr > th[class*="sort"]:before,
.dataTable > thead > tr > th[class*="sort"]:after {
    content: "" !important;
}
           </style> 

<style>
  .modal-title {
    margin: 0;
    line-height: 1.42857143;
    display: inline!important;
}
  /* .text-red{
    background: red;
    color:#000!important;  
  }
  .text-yellow{
    background: yellow;
    color:#000!important;  
  } */
</style>


<style>
  .user-header p{
    padding-top:5px;
    font-size:13px!important;
  }
  .text-grey{
    color:#9e9e9ec7!important;
  }
  .text-black{
    color:#000!important;
  }
  th{
    vertical-align:middle!important;
  }
</style>

<style>
              .border-right{
                border-right:1px #fff solid;
              }
              .bg-success{
                background : #066265;
                color: #fff;
              }
              .bg-warning {
    background-color: #ffcc00;
}

.bg-danger {
    background-color: #ff3b30;
}
.bg-default{
  background-color: #f4f4f4;;
}
              .table>tbody>tr>td {vertical-align: middle}
              /* td{
                font-size:10px;
              } */
              </style>
    

  <style type="text/css">
    ::-webkit-scrollbar-track {
      background-color: #1a1b1d;
    }

    ::-webkit-scrollbar {
      width: 15px;
      background-color: #1a1b1d;
    }

    ::-webkit-scrollbar-thumb {
      background-color: #066265;
    }
    tr, th, td{
      /* font-size:12px; */
      text-align:center;
      /* padding:2px 5px!important; */
    }
    .box-footer{
      padding-left:0px;
    }
    .text-blue{
      color:blue;
    }
    .text-red{
      color:red;
    }
    .text-red{
      color:red;
    }
    .text-yellow{
      color:yellow;
    }
    .text-orange{
      color:orange;
    }
    .bg-blue{
      background-color: #fff!IMPORTANT;
      color:#000!important;
    }
    .bg-red{
      background-color: red;
    }
    .bg-yellow{
      background-color: yellow;
    }
    .bg-orange{
      background-color: orange;
    }
  </style>

  <style>
  .btn{
    border-radius:0%;
  }
  .box-header-material {
    color: #fff;
    display: block;
    padding: 10px;
    position: relative;
    background:#066265;
  }
  .alert-success{
    color: #fff;
    display: block;
    padding: 10px;
    position: relative;
    background:#066265;
  }
  .alert-danger{
    color: #fff;
    display: block;
    padding: 10px;
    position: relative;
    background:#066265;
  }
  .alert{
    border-radius: 0%!important;
  }
  .box-header-material-text{
    margin:5px 0px;
    font-size:20px;
  }
  .box, .modal {
    border-radius: 0%;
    border-top: 0px solid #d2d6de!important;
    box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
  }

.skin-blue .main-header .logo {
    background-color: #1e272e;
    color: #fff;
    margin-bottom: -1px!important;
    border-bottom: 0 solid transparent;
}
.skin-blue .main-header .logo:hover {
    background-color: #1e272e;
    color: #fff;
    border-bottom: 0 solid transparent;
}
.skin-blue .main-header .navbar {
    background: #9CECFB;
    background: -webkit-linear-gradient(to right,#0052D4,#65C7F7);
    background: linear-gradient(to right,#1e272e,#1e272e);
}
.btn{
  /* margin-top:5px; */
}
.skin-blue .main-header .navbar .sidebar-toggle:hover {
    background: rgba(0,0,0,.1);
    color: #f6f6f6;
}
.skin-blue .main-header li.user-header {
    background-color: #1e272e;
}
a{
  /* pointer-events: none; */
}
.float-add,.float-1{
  display: block;
  position: fixed;
  right: 30px;
  bottom: 30px;
  height:50px;
  width:50px;
  font-size:25px;
  /* box-shadow: 2px 2px 3px #999; */
  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
  z-index: 100;
  border-radius:50%;
}
.float-5{
  display: block;
  position: fixed;
  right: 270px;
  bottom: 30px;
  height:50px;
  width:50px;
  font-size:25px;
  /* box-shadow: 2px 2px 3px #999; */
  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
  z-index: 100;
  border-radius:50%;
}
.float-upload{
  display: block;
  position: fixed;
  right: 90px;
  bottom: 30px;
  height:50px;
  width:50px;
  font-size:25px;
  /* box-shadow: 2px 2px 3px #999; */
  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
  z-index: 100;
  border-radius:50%;
}
.modal-dialog > .modal-content > .modal-header{
  background-color:  #066265;
  color:#fff;
}

.float-active{
  display: block;
  position: fixed;
  right: 210px;
  bottom: 30px;
  height:50px;
  width:50px;
  font-size:25px;
  /* box-shadow: 2px 2px 3px #999; */
  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
  z-index: 100;
  border-radius:50%;
}

.float-hold .float-3, .float-4{
  display: block;
  position: fixed;
  right: 150px;
  bottom: 30px;
  height:50px;
  width:50px;
  font-size:25px;
  /* box-shadow: 2px 2px 3px #999; */
  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
  z-index: 100;
  border-radius:50%;
}
.float-terminated, .float-2{
  display: block;
  position: fixed;
  right: 90px;
  bottom: 30px;
  height:50px;
  width:50px;
  font-size:25px;
  /* box-shadow: 2px 2px 3px #999; */
  box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
  z-index: 100;
  border-radius:50%;
}

.form-control{
    color:#000;
    font-weight:100;
    background-color: transparent;
    border: 0;
    border-bottom: 1px solid #ced4da;
    border-radius: 0;
    outline: 0;
    -webkit-box-shadow: none;
    box-shadow: none;
    -webkit-transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
}

#select-status, .content-header{
  display:none;
}
.box-header{
  margin:0px;
  padding:0px;
}
.content{
  min-height: 1000px;;
}
.box-tools{
  margin-top: -6px;
  color:#fff;
}
.box-tools > button{
  color:#fff;
  /* pointer-events: none; */
}

.btn-delete{
  border-radius:50%;
  margin-top:0px;
}
th{
  /* font-weight:500; */
}

.btn-rounded{
  border-radius:50%;
  margin-top:0px;
  margin-right:5px;
  font-size:15px;
}
ul{
  padding-left:20px;
}
.alert-success {
    color: #fff;
    display: block;
    padding: 10px;
    position: relative;
    background: #066265;
    border-radius: 0px;
    box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);
}

.count{
  font-size:16px;
}
ul {
    padding-left: 0px;
}

.hidden{
  display:none;
}
.bg-orange{
  background:#e26c0a;
}
.bg-blue{
  background:#1f487c;
}
  </style>

<script>
  // Prevent closing from click inside dropdown
$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});

// make it as accordion for smaller screens
if ($(window).width() < 992) {
  $('.dropdown-menu a').click(function(e){
    e.preventDefault();
      if($(this).next('.submenu').length){
        $(this).next('.submenu').toggle();
      }
      $('.dropdown').on('hide.bs.dropdown', function () {
     $(this).find('.submenu').hide();
  })
  });
}
</script>
<style>
  /* @media (min-width: 992px){ */
	.dropdown-menu .dropdown-toggle:after{
		border-top: .3em solid transparent;
	    border-right: 0;
	    border-bottom: .3em solid transparent;
	    border-left: .3em solid;
	}
	.dropdown-menu .dropdown-menu{
		margin-left:0; margin-right: 0;
	}
	.dropdown-menu li{
		position: relative;
	}
	.nav-item .submenu{ 
		display: none;
		position: absolute;
    border-radius:0px;
		left:100%; top:-7px;
    background:#1e272e!important;
    color:#fff!important;
	}
	.nav-item .submenu-left{ 
		right:100%; left:auto;
	}

	.dropdown-menu > li:hover > .submenu{
		display: block;
	}
/* } */
.d-m li a{
  color:#fff!important;
}
.d-m li a:hover{ 
    background-color: #777!important;
  }
  .d-m li a:focus{ 
    background-color: #777!important;
  }
  .d-m li a:active{ 
    background-color: #777!important;
  }
/* li>a:hover{
  background:#1e272eeb!important;
} */

  .navbar-nav .dropdown-menu{
    background:#1e272e!important;
    min-width:200px;
  }
  .dropdown-menu>li>a {
    display: block;
    padding: 3px 15px;
  }

</style>
</head>
<body class="hold-transition <?=SKIN?> layout-top-nav scroll-bar" onload="startTime()">

  <script src="<?=base_url()?>assets/chart/core.js"></script>
  <script src="<?=base_url()?>assets/chart/charts.js"></script>
  <script src="<?=base_url()?>assets/chart/animated.js"></script>

  <link rel="stylesheet" href="<?=base_url()?>assets/plugins/tablednd/tablednd.css" type="text/css"/>
  <script type="text/javascript" src="<?=base_url()?>assets/plugins/tablednd/js/jquery.tablednd.0.7.min.js"></script>

  <div class="wrapper">
    <header class="main-header">
      <nav class="navbar navbar-static-top" style="">
        <div class="navbar-header">
          <a href="<?= base_url() ?>" class="navbar-brand" style="padding:10px 10px;">
      <span class="logo-lg"><img src="<?=base_url()?>assets/logo.png" style="height:31px" alt=""> SRS BIFA</span>
            
          </a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <div class="collapse navbar-collapse pull-left menu-custom_css" style="margin-left: 5px;" id="navbar-collapse">
          <ul class="nav navbar-nav">
        
            <?php
            // $user = $_SESSION['json'];
            $jsonmenu = json_decode($user['menu']);

            $jsonmenu = join("','",$jsonmenu); 

            if($_SESSION['role']=='4'){
              $role = $this->mymodel->selectDataOne('role',array('id'=>$_SESSION['role']));
              $jsonmenu = json_decode($role['menu']);

              $jsonmenu = join("','",$jsonmenu);
            }
            
          
            $this->db->order_by('urutan asc');
            // $this->db->where_in('id', $jsonmenu);
            $menu = $this->mymodel->selectWhere('menu_master', "parent = 0 AND status = 'ENABLE'  AND id IN ('$jsonmenu')");
            foreach ($menu as $m) {
              $this->db->order_by('urutan','ASC');
              // $this->db->where_in('id', $jsonmenu);
              $id_parent = $m['id'];
              $parent = $this->mymodel->selectWhere('menu_master', "parent = '$id_parent' AND status = 'ENABLE' AND id IN ('$jsonmenu') ");
              if (count($parent) == 0) {
                ?>
                   <a class="dropdown-item"  href="<?= base_url($m['link']) ?>"><i class="<?= $m['icon'] ?>"></i> <?= $m['name'] ?></a>
              <?php } else { ?>

                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown"> <span><i class="<?= $m['icon'] ?>"></i> <?= $m['name'] ?></span> <span class="mdi mdi-arrow-down-drop-circle"></span> </a>
                <ul class="dropdown-menu d-m">
                    <?php foreach ($parent as $p) { ?>
                      <?php  
                        $this->db->order_by('urutan','ASC');
                        // $this->db->where_in('id', $jsonmenu);
                        $id_parent = $p['id'];
                        $parent_child = $this->mymodel->selectWhere('menu_master', "parent = '$id_parent' AND status = 'ENABLE' AND id IN ('$jsonmenu') ");
                         if (count($parent_child) == 0) {
                      ?>
                      <li>
                        <a style="font-size:13px;" class="dropdown-item" href="<?= base_url($p['link']) ?>"><i class="<?= $p['icon'] ?>"></i> <?= $p['name'] ?></a>
                      </li>
                    <?php }else{ ?>
                      <li class="nav-item dropdown d-m">
                        <a class="nav-link dropdown-toggle" style="font-size:13px;" href="#" data-toggle="dropdown"> <span><i class="<?= $p['icon'] ?>"></i> <?= $p['name'] ?></span> 
                        <span class="mdi mdi-arrow-right-bold-circle pull-right"></span>
                       </a>
                        <ul class="submenu dropdown-menu d-m">
                        <?php foreach ($parent_child as $pc) { ?>
                          <li>
                          <a class="dropdown-item"  href="<?= base_url($pc['link']) ?>"><i class="<?= $pc['icon'] ?>"></i> <?= $pc['name'] ?></a>
                        </li>
                        <?php } ?>
                        </ul>
                      </li>
                    <?php } ?>
                    <?php } ?>
                  </ul>
                </li>
              <?php } ?>
            <?php } ?>
            
          </ul>
        </div>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
         
          <li class="dropdown user user-menu">
            <?php
              $id = $this->session->userdata('id');
              $user = $this->mymodel->selectDataone('user',array('id'=>$id));
              $file = $this->mymodel->selectDataone('file',array('table'=>'user','table_id'=>$id));
            ?>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php if($file['name']){ ?>  
                  <img style='height: 20px; width: 20px; object-fit: cover; display: inline;' class='img-circle' src="<?=base_url().'webfile/'.$file['name']?>" class="user-image" >
                <?php }else{ ?>
                  <img style='height: 20px; width: 20px; object-fit: cover; display: inline;' class='img-circle' src="<?=base_url()?>webfile/no_image.png" class="user-image" >
                <?php } ?>
              <span class="hidden-xs">
              <?= strtoupper($user['full_name'])?> 
              <?php 
                    $role = $user['role'];
                    $role = $this->mymodel->selectDataOne('role',array('id'=>$role));
                    echo ' | '.strtoupper($role['role']).'';

                    if(empty($user['base'])){
                      $user['base'] = 'ALL';
                    }

                    echo ' | BASE : '.$user['base'].'';

              ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header" style="height: 201px">
                <?php if($file['name']){ ?>  
                  <img style='height: 100px; width: 100px; object-fit: cover; display: inline;' class='img-circle' src="<?=base_url().'webfile/'.$file['name']?>" class="user-image" >
                <?php }else{ ?>
                  
                  <img style='height: 100px; width: 100px; object-fit: cover; display: inline;' class='img-circle' src="<?=base_url()?>webfile/no_image.png" class="user-image" >
                <?php } ?>

                <p>
                <?= substr(strtoupper($user['full_name']),0,27)?>  <br>
                <?= strtoupper($role['role'])?>  <br>
                BASE : <?= strtoupper($user['base'])?> 
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <!-- <div class="pull-left"> -->
                  <a href="<?= base_url('user/edit/') ?>" class="btn btn-default btn-flat"><i class="fa fa-gear"></i> Settings</a>
                <!-- </div> -->
                <!-- <div class="pull-right"> -->
                  <a href="<?= base_url('login/logout') ?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
        </div>
      </nav>
    </header>
    <!-- <div class="row" style="height: 45px;background-color: #ff0000;"></div> -->

  <?=$contents?>
  
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>VERSION</b> 1.0.0
    </div>
    <strong>COPYRIGHT © 2021 <a href="https://karyastudio.com" target="_blank">KARYA STUDIO TEKNOLOGI DIGITAL</a>
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Canvas JS -->
<!--<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>-->
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/') ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?= base_url('assets/') ?>bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="<?= base_url('assets/') ?>bower_components/raphael/raphael.min.js"></script>
<script src="<?= base_url('assets/') ?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?= base_url('assets/') ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url('assets/') ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url('assets/') ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url('assets/') ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url('assets/') ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?= base_url('assets/') ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url('assets/') ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url('assets/') ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url('assets/') ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url('assets/') ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/') ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url('assets/') ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url('assets/') ?>dist/js/demo.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            
            $('#user-data-autocomplete').autocomplete({
                source: "<?php echo site_url('home/get_autocomplete');?>",
      
                select: function (event, ui) {
                    // $('[name="title"]').val(ui.item.label); 
                    // $('[name="description"]').val(ui.item.description); 
                    window.location.href = "<?= base_url('master/user/editUser_redirect/') ?>"+ui.item.id;
                }
            });
        });

        var url = window.location;
        // for sidebar menu but not for treeview submenu
        $('ul.sidebar-menu a').filter(function() {
            return this.href == url;
        }).parent().siblings().removeClass('active').end().addClass('active');
        // for treeview which is like a submenu
        $('ul.treeview-menu a').filter(function() {
            return this.href == url;
        }).parentsUntil(".sidebar-menu > .treeview-menu").siblings().removeClass('active menu-open').end().addClass('active menu-open');
    </script>

    
  <script src="<?= base_url('assets/') ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>

<script type="text/javascript">
   $('.select2').select2();

    $('.tgl').datepicker({
      autoclose: true,
      format:'yyyy-mm-dd',
      orientation: 'bottom'
    });
    
     //Timepicker
     $(function () {
        $('.timepicker').timepicker({
            showMeridian: false,
            showInputs: true,
            use24hours: true,
            format: 'HH:mm'
        });
    });

  $(function () {
    $('.datatable2').DataTable();
    $('#datatable, .datatable').DataTable({
      'paging'      : true, 
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], "iDisplayLength" : -1
    });
    $('.datatable_without_page').DataTable({
      'paging'      : false, 
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], "iDisplayLength" : -1
    });
  });

  function startTime() {
    var today = new Date();
    var hr = today.getHours();
    var min = today.getMinutes();
    var sec = today.getSeconds();
    ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
    hr = (hr == 0) ? 12 : hr;
    hr = (hr > 12) ? hr - 12 : hr;
    //Add a zero in front of numbers<10
    hr = checkTime(hr);
    min = checkTime(min);
    sec = checkTime(sec);
    document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
    
    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    var curWeekDay = days[today.getDay()];
    var curDay = today.getDate();
    var curMonth = months[today.getMonth()];
    var curYear = today.getFullYear();
    var date = curWeekDay+", "+curDay+" "+curMonth+" "+curYear+" /";
    document.getElementById("date").innerHTML = date;
    
    var time = setTimeout(function(){ startTime() }, 500);
  }
  function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }

  function lazzy_loader(limit) {
    var output = '<div class="row">' +
      '<div class="col-xs-12" align="center">' +
      '<i class="fa fa-spinner fa-spin"></i> Show More'+
      '</div>' +
      '</div>';
    $('#load_data_message').html(output);
  }

  /* Fungsi formatRupiah */
  function fungsiRupiah() {
    $(".rupiah").keyup(function(){
      $(this).val(formatRupiah(this.value, ''));
    });
 
    function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      rupiah        = split[0].substr(0, sisa),
      ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
 
      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
 
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
    }
  }

  fungsiRupiah();

  function maskRupiah(angka) {
    var   bilangan = angka;

    var reverse = bilangan.toString().split('').reverse().join(''),
      ribuan  = reverse.match(/\d{1,3}/g);
      ribuan  = ribuan.join('.').split('').reverse().join('');

    // Cetak hasil  
    return ribuan;
  }

  // $('img').bind('contextmenu', function(e){
  //   return false;
  // }); 

</script>


<script>
$(document).ready(function(){
    $('#etd').keyup(function() {
      var etd = $('#etd').val();
      var etd_array =  etd.split(":");
      jam = etd_array[0];
      jam = leftPad(jam, 2);
      menit = etd_array[1];
      menit = leftPad(menit, 2);
      if(etd=='-'){
        $('#etd').val('-');
      }else{
        if(jam > 24){
        jam = '00';
        time = jam+':'+menit;
        $('#etd').val(time);
      }
      if(menit > 60){
        menit = '00';
        time = jam+':'+menit;
        $('#etd').val(time);
      }
      }
      
      
      get_val();
    });

    $('#eta').keyup(function() {

      var etd = $('#eta').val();
      var etd_array =  etd.split(":");
      jam = etd_array[0];
      jam = leftPad(jam, 2);
      menit = etd_array[1];
      menit = leftPad(menit, 2);
      if(jam > 24){
        jam = '00';
        time = jam+':'+menit;
        $('#eta').val(time);
      }
      if(menit > 60){
        menit = '00';
        time = jam+':'+menit;
        $('#eta').val(time);
      }

      get_val();
    });

    $('#etd').change(function() {
      var etd_b = $('#etd').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd_b=='-'){
        $('#etd').val('-');
      }else{
        var str = time;
        var n = str.includes("ed");
        if(n==true){
          $('#etd').val('-');
        }else{
          $('#etd').val(time);
        }
        
      }
      
    });

    $('#eta').change(function() {
      var etd_b = $('#eta').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd_b=='-'){
        $('#eta').val('-');
      }else{
        var str = time;
        var n = str.includes("ed");
        if(n==true){
          $('#eta').val('-');
        }else{
          $('#eta').val(time);
        }
        
      }
      
    });


    $('#eet').change(function() {
      var etd_b = $('#eet').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd_b=='-'){
        $('#eet').val('-');
      }else{
        var str = time;
        var n = str.includes("ed");
        if(n==true){
          $('#eet').val('-');
        }else{
          $('#eet').val(time);
        }
        
      }
      
    });

  });

  function get_val(){
    var etd = $('#etd').val();
    var eta = $('#eta').val();
    
    var etd_array =  etd.split(":");
    jam1 = etd_array[0];
    menit1 = etd_array[1];
    
    var eta_array =  eta.split(":");
    jam2 = eta_array[0];
    menit2 = eta_array[1];

    var time = '00:00';
    var jam = '';
    var time = '';
    if(jam2 >= jam1){
      jam = jam2-jam1;
      menit = menit2-menit1;
      if(menit < 0){
        menit = 60 + menit;
        jam = jam - 1;
      }
      // jam = leftPad(jam, 2);
      menit = leftPad(menit, 2);
      time = (jam)+':'+(menit);
    }else{
      jam = jam2-jam1;
      menit = menit2-menit1;
      if(jam<0){
        jam = 24+jam;
      }
      if(menit < 0){
        menit = 60 + menit;
        jam = jam - 1;
      }
      // jam = leftPad(jam, 2);
      menit = leftPad(menit, 2);
      time = (jam)+':'+(menit);
    }

    var n = time.includes("aN");
    if(n==true){
      time = '';
    }

    if(etd=='-' || eta=='-'){
      $('#eet').val('-');
    }else{
      $('#eet').val(time);
    }
    
  }

  function leftPad(value, length) { 
    return ('0'.repeat(length) + value).slice(-length); 
}

</script>




<script>
$(document).ready(function(){
    $('#etd_b').keyup(function() {
      var etd_b = $('#etd_b').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      if(etd_b=='-'){
        $('#etd_b').val('-');
      }else{
        if(jam > 24){
        jam = '00';
        time = jam+':'+menit;
        $('#etd_b').val(time);
      }
      if(menit > 60){
        menit = '00';
        time = jam+':'+menit;
        $('#etd_b').val(time);
      }
      }
      
      
      get_val_b();
    });

    $('#eta_b').keyup(function() {

      var etd_b = $('#eta_b').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      if(jam > 24){
        jam = '00';
        time = jam+':'+menit;
        $('#eta_b').val(time);
      }
      if(menit > 60){
        menit = '00';
        time = jam+':'+menit;
        $('#eta_b').val(time);
      }

      get_val_b();
    });

    $('#etd_b').change(function() {
      var etd_b = $('#etd_b').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd_b=='-'){
        $('#etd_b').val('-');
      }else{
        var str = time;
        var n = str.includes("ed");
        if(n==true){
          $('#etd_b').val('-');
        }else{
          $('#etd_b').val(time);
        }
        
      }
      
    });

    $('#eta_b').change(function() {
      var etd_b = $('#eta_b').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd_b=='-'){
        $('#eta_b').val('-');
      }else{
        var str = time;
        var n = str.includes("ed");
        if(n==true){
          $('#eta_b').val('-');
        }else{
          $('#eta_b').val(time);
        }
        
      }
      
    });

    
    $('#eet_b').change(function() {
      var etd_b = $('#eet_b').val();
      var etd_b_array =  etd_b.split(":");
      jam = etd_b_array[0];
      jam = leftPad(jam, 2);
      menit = etd_b_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd_b=='-'){
        $('#eet_b').val('-');
      }else{
        var str = time;
        var n = str.includes("ed");
        if(n==true){
          $('#eet_b').val('-');
        }else{
          $('#eet_b').val(time);
        }
        
      }
      
    });

  });

  function get_val_b(){
    var etd_b = $('#etd_b').val();
    var eta_b = $('#eta_b').val();
    
    var etd_b_array =  etd_b.split(":");
    jam1 = etd_b_array[0];
    menit1 = etd_b_array[1];
    
    var eta_b_array =  eta_b.split(":");
    jam2 = eta_b_array[0];
    menit2 = eta_b_array[1];

    var time = '00:00';
    var jam = '';
    var time = '';
    if(jam2 >= jam1){
      jam = jam2-jam1;
      menit = menit2-menit1;
      if(menit < 0){
        menit = 60 + menit;
        jam = jam - 1;
      }
      // jam = leftPad(jam, 2);
      menit = leftPad(menit, 2);
      time = (jam)+':'+(menit);
    }else{
      jam = jam2-jam1;
      menit = menit2-menit1;
      if(jam<0){
        jam = 24+jam;
      }
      if(menit < 0){
        menit = 60 + menit;
        jam = jam - 1;
      }
      // jam = leftPad(jam, 2);
      menit = leftPad(menit, 2);
      time = (jam)+':'+(menit);
    }

    var n = time.includes("aN");
    if(n==true){
      time = '';
    }

    if(etd_b=='-' || eta_b=='-'){
      $('#eet_b').val('-');
    }else{
      $('#eet_b').val(time);
    }
    
  }

  function leftPad(value, length) { 
    return ('0'.repeat(length) + value).slice(-length); 
}

</script>




<script>
$(document).ready(function(){
    $('#etd2').keyup(function() {
      
      var etd2 = $('#etd2').val();
      var etd2_array =  etd2.split(":");
      jam = etd2_array[0];
      jam = leftPad(jam, 2);
      menit = etd2_array[1];
      menit = leftPad(menit, 2);
      if(jam > 24){
        jam = '00';
        time = jam+':'+menit;
        $('#etd2').val(time);
      }
      if(menit > 60){
        menit = '00';
        time = jam+':'+menit;
        $('#etd2').val(time);
      }
      
      get_val2();
    });

    $('#eet2').keyup(function() {

      var etd2 = $('#eet2').val();
      var etd2_array =  etd2.split(":");
      jam = etd2_array[0];
      jam = leftPad(jam, 2);
      menit = etd2_array[1];
      menit = leftPad(menit, 2);
      if(jam > 24){
        jam = '00';
        time = jam+':'+menit;
        $('#eet').val(time);
      }
      if(menit > 60){
        menit = '00';
        time = jam+':'+menit;
        $('#eet').val(time);
      }

      get_val2();
    });

    $('#etd2').change(function() {
      var etd2 = $('#etd2').val();
      var etd2_array =  etd2.split(":");
      jam = etd2_array[0];
      jam = leftPad(jam, 2);
      menit = etd2_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd2=='-' || etd2==''){
        $('#etd2').val('-');
      }else{
        $('#etd2').val(time);
      }
    });

    $('#eet2').change(function() {
      var etd2 = $('#eet2').val();
      var etd2_array =  etd2.split(":");
      jam = etd2_array[0];
      if(jam < 10){
        jam = leftPad(jam, 1);
      }
      
      menit = etd2_array[1];
      menit = leftPad(menit, 2);
      time = jam+':'+menit;
      if(etd2=='-' || etd2==''){
        $('#eet2').val('-');
      }else{
        $('#eet2').val(time);
      }
    });


  });

  function get_val2(){
    var etd2 = $('#etd2').val();
    var eta2 = $('#eet2').val();
    
    var etd2_array =  etd2.split(":");
    jam1 = etd2_array[0];
    menit1 = etd2_array[1];
    
    var eta2_array =  eta2.split(":");
    jam2 = eta2_array[0];
    menit2 = eta2_array[1];

    var time = '00:00';
    var jam = '';
    var time = '';
    jam = parseInt(jam1) + parseInt(jam2);
    menit = parseInt(menit1) + parseInt(menit2); 

    if(menit >= 60){
      menit = menit - 60;
      jam = jam + 1;
    }

    if(jam=='24'){
      jam = '00';
    }else if(jam > 24){
      jam = jam - 24;
    }
    
    // if(menit > 60){
    //   menit = menit - 60;
    //   jam = jam + 1;
    // }else if(menit==60){
    //   menit = menit - 60;
    // }

    // if(jam > 24){
    //   jam = jam - 24;
    //   jam = jam + 2;
    //   if(menit > 0){
    //     jam = jam - 2;
    //   }else{

    //   }
    // }else if(jam==24){
    //   jam = '00';
    // }


    if(jam2 == '00' && menit2 == '00'){
      menit = menit1;
      jam = jam1;
    }

    menit = leftPad(menit, 2);

    jam = leftPad(jam, 2);

    time = (jam)+':'+(menit);
    
    var n = time.includes("aN");
    if(n==true){
      time = '';
    }
    if(etd2=='-' || eta2=='-' || etd2=='' || eta2==''){
      $('#eta2').val('-');
    }else{
      $('#eta2').val(time);
    }
    
    
  }

  function leftPad(value, length) { 
    return ('0'.repeat(length) + value).slice(-length); 
}

</script>


</body>
</html>




<div class="modal modal-danger fade" id="modal-reject">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">REJECT APPLICATION STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to reject this application student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/student_list/reject/<?=$student_application_form['id']?>">Reject Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

              
<div class="modal modal-success fade" id="modal-approve">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">APPROVE APPLICATION STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to approve this application student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/student_list/approve/<?=$student_application_form['id']?>">Approve Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

   
           
        <div class="modal modal-info fade" id="modal-graduate">
          <div class="modal-dialog" >
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">GRADUATE STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to graduate this student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>/master/student_document/status/<?=$student_document['id']?>/GRADUATED">Graduate Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


           
<div class="modal modal-success fade" id="modal-active">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ACTIVATE STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to activate this student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>/master/student_document/status/<?=$student_document['id']?>/ACTIVE">Activate Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

                   
<div class="modal modal-warning fade" id="modal-hold">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">HOLD STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to hold this student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>/master/student_document/status/<?=$student_document['id']?>/HOLD">Hold Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

                           
<div class="modal modal-danger fade" id="modal-terminated">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">TERMINATE STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to terminate this student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>/master/student_document/status/<?=$student_document['id']?>/TERMINATED">Terminate Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


          
<div class="modal modal-danger fade" id="modal-reject-rindam">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">FAIL RINDAM STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to complete this application student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>/master/rindam/status/<?=$student_application_form['id']?>/FAIL">Fail Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

              
<div class="modal modal-success fade" id="modal-approve-rindam">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">COMPLETE RINDAM STUDENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to fail rindam this application student?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>/master/rindam/status/<?=$student_application_form['id']?>/COMPLETE">Complete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
