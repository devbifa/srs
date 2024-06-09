<?php
	$user = $_SESSION['id'];
    $user = $this->mymodel->selectDataOne('user', array('id'=>$user));
    $instructor = $this->mymodel->selectDataOne('student_application_form',array('id_number'=>$user['nip']));
    $_SESSION['id_instructor'] = $instructor['id'];

    $_SESSION['start_date'] = DATE('Y-m-d');
    $_SESSION['end_date'] = DATE('Y-m-d');
            
?>

<div class="content-wrapper">


    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Student_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $student_document['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
               HOME
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-body" style="min-height:500px;">
           
            <script src="<?=base_url()?>assets/eocjs-newsticker.js"></script>
            <link rel="stylesheet" href="<?=base_url()?>assets/eocjs-newsticker.css">
            <script>

            $(function() {

            $("#example-1").eocjsNewsticker({
                speed: 25,
                timeout: 0.5
            });

            $("#example-2").eocjsNewsticker({
                divider: "***",
                type: 'ajax',
                source: 'example-json.php',
                interval: 30
            });

            $("#example-3").eocjsNewsticker({
                speed: 15,
                divider: "|",
                type: 'ajax',
                source: 'example-json.php',
                dataType: 'jsonp',
                interval: 30
            });

            });

            </script>
            <marquee direction="left"  style="background-color: #eeeeee;padding:7px 0px;">
            <?php 
      $news = $this->mymodel->selectWithQuery("SELECT * FROM news ORDER BY date DESC LIMIT 15");
      foreach($news as $key=>$val){
          echo '<a href="' . base_url("news/detail/") . ($val['date']).'/'.($val['id']). '" class="">'.$val['title'].'</a> | ';
      }
      ?>
            </marquee>
  <!-- <div id="example-1">
      <?php 
      $news = $this->mymodel->selectWithQuery("SELECT * FROM news ORDER BY date DESC LIMIT 15");
      foreach($news as $key=>$val){
          echo '<a href="' . base_url("news/detail/") . ($val['date']).'/'.($val['id']). '" class="">'.$val['title'].'</a> | ';
      }
      ?>
  </div> -->

            <div class="row">

          <!-- <div class="col-md-12">
                    
                    <h3>Menu Master</h3>
</div>
            <?php 
        $role = $this->mymodel->selectDataone('role',['id'=>$this->session->userdata('role_id')]);
        $jsonmenu = json_decode($role['menu']);
        $this->db->order_by('urutan asc');
        $this->db->where_in('id',$jsonmenu);
        $menu = $this->mymodel->selectWhere('menu_master',['parent'=>0,'status'=>'ENABLE']);
        foreach ($menu as $key=>$m) {
        $this->db->order_by('urutan asc');
        $this->db->order_by('name asc');
        $this->db->where_in('id',$jsonmenu);
        $parent = $this->mymodel->selectWhere('menu_master',['parent'=>$m['id'],'status'=>'ENABLE']);
        if(count($parent)==0){
        ?>
        <!-- <li class="<?php if($page_name==$m['name']) echo "active"; ?>" >
          <a href="<?= base_url($m['link']) ?>">
            <i class="<?= $m['icon'] ?>"></i> <span><?= $m['name'] ?></span>
             <?php if($m['notif']!=""){ ?>
              <span class="pull-right-container">
                <small class="label pull-right label-danger" id="<?= $m['notif'] ?>">0</small>
              </span>
              <?php } ?>
          </a>
        </li> -->
        <?php }else{  ?>

       
          <div class="col-md-2">
                    <div class="wow zoomIn animated" data-wow-duration="400ms" data-wow-delay="0ms" style="visibility: visible; animation-duration: 400ms; animation-delay: 0ms; animation-name: zoomIn;">
                        <ul class="pricing">
							<a data-toggle="collapse" data-target="#regulasi<?=$key?>" style="display:block; cursor: pointer;" class="" aria-expanded="true">
                            <span class="plan-header">
                                <div class="price-duration" style="padding:0px; background-color:rgba(255,255,255,.1); border: none; background-image:none;">
                                    <img src="https://images.vexels.com/media/users/3/127746/isolated/preview/db152ec9678645b1f02e5d4d393ff27e-flying-global-icon-by-vexels.png" width="125" class="img-responsive" style="margin: 5px;">
                                </div>
                                <div class="plan-name">
                                <i class="<?= $m['icon'] ?>"></i> <span><?= $m['name'] ?> <i class="fa fa-caret-down"></i>
                                </div>
                            </span>
							</a>
							<div id="regulasi<?=$key?>" class="collapse in" aria-expanded="true" style="">
               
						
         
        
            <?php foreach ($parent as $p) {  ?>

              <a href="<?= base_url($p['link']) ?>"> <?=$p['name']?></a>
                <br>

         
           
            <?php } ?>

          
							</div>
                        </ul>
                    </div>
                </div>
                
        <?php } ?>
        <?php } ?>

        <div class="col-md-2">
                    <div class="wow zoomIn animated" data-wow-duration="400ms" data-wow-delay="0ms" style="visibility: visible; animation-duration: 400ms; animation-delay: 0ms; animation-name: zoomIn;">
                        <ul class="pricing">
							<a data-toggle="collapse" data-target="#regulasiz" style="display:block; cursor: pointer;" class="" aria-expanded="true">
                            <span class="plan-header">
                                <div class="price-duration" style="padding:0px; background-color:rgba(255,255,255,.1); border: none; background-image:none;">
                                    <img src="https://images.vexels.com/media/users/3/127746/isolated/preview/db152ec9678645b1f02e5d4d393ff27e-flying-global-icon-by-vexels.png" width="125" class="img-responsive" style="margin: 5px;">
                                </div>
                                <div class="plan-name">
                                <i class="mdi mdi-information-outline"></i> <span>APP GUIDE <i class="fa fa-caret-down"></i>
                                </div>
                            </span>
							</a>
							<div id="regulasiz" class="collapse in" aria-expanded="true" style="">
               
						
         

          
							</div>
                        </ul>
                    </div>
                </div> -->

          <div class="col-md-12">
                    
                            <h3>Daily News</h3>
                            <div class="row">
                           
                            <?php
$search = $_GET['keyword'];

if ($search) {
    $event = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE status =  'ENABLE' AND title like '%$search%' ORDER BY date DESC LIMIT " . $this->input->post('limit') . " OFFSET " . $this->input->post('start'));
} else {
    $event = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE status =  'ENABLE' ORDER BY date DESC LIMIT 6");
}
if ($event) {
    foreach ($event as $row) {
        $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'news'));
        
        if(empty($photo)){
            $photo['dir'] = base_url().'webfile/no_image.png';
        }else{
            $photo['dir'] =  base_url().'webfile/'.$photo['name'];
        }
        


        if(strlen($row['title']) > 37 ){ 
            $row['title'] = substr($row['title'],0,37).'...'; 
        }else{ 
            $row['title'] = $row['title']; 
        }

        
        $output .= '
        <a href="' . base_url("news/detail/") . ($row['date']).'/'.($row['id']). '" class="">
        <div class="col-md-4" style="margin-bottom:15px;">
        <div class="box">
            <img class="img-even" src="' . $photo['dir']. '" style="height: 250px; width: 100%; object-fit: cover; display: inline;">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" align="center">
                    <p>'.$row['title'].'</p>
                    <p>'.DATE('d M Y', strtotime($row['date'])).'</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </a>';
    }
}
echo $output;
                            ?>
                            
                        </div>


</div>


                <div class="col-md-12">
                        <div class="">
                            <h3>Batch Student Allocation Data</h3>
                            <div class="">
                      <!-- <div class="form-group">
                      Data menampilkan Direktorat yang menjadi PIC Utama
                      </div> -->
                    </div>
                            <?php
                              $pic = $this->mymodel->selectWithQuery("SELECT * FROM
                              (SELECT a.id, a.batch as nama_batch FROM batch a ORDER BY a.batch ASC) a
                              LEFT JOIN
                              (SELECT a.batch, COUNT(a.id) as count  FROM student_application_form a WHERE a.student_status = 'APPROVE'
                              GROUP BY batch) b
                              ON a.id = b.batch
                              ORDER BY a.nama_batch");
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="chartdiv"></div>
                                </div>
                                <div class="col-md-6" style="padding-top: 10px;">
                                    <table class="table">
                                        <tbody>
                                            <?php
                                            $color_array = array('#106d80', '#189cb8', '#5db9cd', '#ff9900', '#ffb74c', '#ad5b54', '#f88379', '#faa8a1', '#888888', '#ababab', '#cfcfcf', '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#D32F2F', '#C62828');
                                            $total_radir = 0;
                                            foreach ($pic as $key => $k) {
                                                $total_radir = $total_radir + intval($k['count']); ?>
                                                <tr>
                                                    <td style="width:15px;">
                                                        <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;">
                                                        </div>
                                                    </td>
                                                    <td class="text-left">BATCH <?= $k['nama_batch'] ?></td>
                                                    <td style="text-align:right;"><?= intval($k['count']) ?></a></td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td style="width:15px;">
                                                    <!-- <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;"> -->
                                </div>
                                </td>
                                <td class="text-left">TOTAL STUDENT</td>
                                <td style="text-align:right;"><?= $total_radir ?></a></td>
                                </tr>
                                </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- *Agenda Diskusi Umum yang tidak dapat di klasifikasikan secara jelas ke satu Direktorat tertentu. -->

                        <style>
                            #chartdiv {
                                width: 100%;
                                height: 300px;
                            }
                        </style>

                        <script>
                            // Set theme
                            am4core.useTheme(am4themes_animated);

                            // Create chart
                            var chart = am4core.createFromConfig({
                                // Set data
                                data: [

                                    <?php foreach ($pic as $key => $k) {   ?> {
                                            "title": "BATCH <?= $k['nama_batch'] ?>",
                                            "value": <?= intval($k['count']) ?>
                                        },
                                    <?php } ?>


                                ],

                                // Create series

                                "series": [{
                                    "type": "PieSeries",
                                    "colors": {
                                        "list": [
                                            '#00809b', '#189cb8', '#5db9cd', '#ff9900', '#ffb74c', '#ad5b54', '#f88379', '#faa8a1', '#888888', '#ababab', '#cfcfcf', '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#D32F2F', '#C62828'
                                        ]
                                    },
                                    "ticks": {
                                        "disabled": true
                                    },
                                    "labels": {
                                        "disabled": true
                                    },
                                    "dataFields": {
                                        "value": "value",
                                        "category": "title"
                                    },
                                    "hiddenState": {
                                        "properties": {
                                            // this creates initial animation
                                            "opacity": 1,
                                            "endAngle": -90,
                                            "startAngle": -90
                                        }
                                    }
                                }],

                                // Add legend
                            }, "chartdiv", "PieChart");
                        </script>

                    </div>
               
        </div>


        
            <div>
        
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

                           window.location.href = "<?= base_url('master/Student_document') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SAVE').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>
