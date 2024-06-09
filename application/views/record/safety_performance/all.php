



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
              SAFETY PERFORMANCE
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
                                <form autocomplete="off" action="<?= base_url() ?>record/safety_performance/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">SELECT ORIGIN BASE</option>
                                                <?php 

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
                                    
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <a class="btn btn-success btn-block" href="<?=base_url()?>record/safety_performance/excel" target="_blank"><i class="mdi mdi-excel"></i> EXCEL</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

              <?php


$base = $_SESSION['origin_base'];
$dat = $this->mymodel->selectWithQuery("SELECT a.id FROM classroom a
LEFT JOIN base_airport_document b
ON a.station = b.id
WHERE base = '$base'");
foreach($dat as $key=>$val){
    $text .= "'".$val['id']."',"; 
}
$text = substr($text,0,-1);


if($base){
if($text){
  $base = " AND classroom  IN ($text) ";
}else{
  $base = " AND classroom  IN ('none') ";
}
}else{
$base = " ";
}


 $parent = $this->mymodel->selectWithQuery("SELECT *
 FROM safety_performance GROUP BY type");
 foreach($parent as $keyp=>$valp){
              ?>
              <label><?=$valp['type']?></label>
              <div class="">

              <table class="table table-bordered table-striped" id="mytable" style="width:100%">

<thead>

<tr class="bg-success">

<tr class="bg-success">

<th style="width:5%">NUM</th>
<th style="width:5%">CODE</th>
<th style="width:20%">REMARK</th>
<th style="width:5%">GROUND</th>
<th style="width:5%">FTD</th>
<th style="width:5%">FLIGHT</th>
<th style="width:5%">TOTAL</th>
 </tr>
</tr>


</thead>


<tbody>
<?php 

            $start_date = $_SESSION['start_date'];
			$end_date = $_SESSION['end_date'];
			$origin_base = $_SESSION['origin_base'];

			if(empty($start_date)){
				$_SESSION['start_date'] = DATE('Y-m-d');
				$_SESSION['end_date'] = DATE('Y-m-d');
				$start_date = $_SESSION['start_date'];
				$end_date = $_SESSION['end_date'];
			}

			if(empty($end_date)){
				$_SESSION['start_date'] = DATE('Y-m-d');
				$_SESSION['end_date'] = DATE('Y-m-d');
				$start_date = $_SESSION['start_date'];
				$end_date = $_SESSION['end_date'];
			}

			if($origin_base){
				$origin_base = "  AND origin_base = '$origin_base' ";
			}else{
				$origin_base = " ";
			}

      $type = $valp['type'];
      $data = $this->mymodel->selectWithQuery("SELECT *
      FROM safety_performance WHERE type = '$type'");
// $total = array();
$grand_total = 0;
$grand_total_flight = 0;
$grand_total_ftd = 0;
$grand_total_ground = 0;


foreach($data as $key=>$val){
  $code = $val['code'];
  $total = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count FROM daily_flight_schedule
  WHERE remark_safety = '$code' AND visibility = '1' AND visibility_report = '1' AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date' ".$origin_base." 
  ");

  $total_flight = $total[0]['count'];

  $total = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count FROM daily_ftd_schedule
  WHERE remark_safety = '$code' AND visibility = '1' AND visibility_report = '1'  AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
  ");

  $total_ftd = $total[0]['count'];

  $total = $this->mymodel->selectWithQuery("SELECT COUNT(id) as count FROM daily_ground_schedule
  WHERE remark_safety = '$code' AND visibility = '1' AND visibility_report = '1'  AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' ".$base." 
  ");

  $total_ground = $total[0]['count'];

  $total_all = $total_ground + $total_ftd + $total_flight;


  $grand_total_ground = $grand_total_ground + $total_ground;

  $grand_total_ftd = $grand_total_ftd + $total_ftd;

  $grand_total_flight = $grand_total_flight + $total_flight;

  $grand_total = $grand_total + $total_all;

  ?>
  <tr>
    <td><?=$key+1?></td>
    <td><?=$val['code']?></td>
    <td class="text-left"><?=$val['remarks']?></td>
    <td><?=$total_ground?></td>
    <td><?=$total_ftd?></td>
    <td><a  href="<?=base_url()?>master/daily_movement_report_approved/?safety_code=<?=$val['code']?>"><?=$total_flight?></a></td>
    <td><?=$total_all?></td>
  </tr>
<?php } 


?>

<tr>
    <th colspan="3" class="text-left">TOTAL</th>
    <th><?=$grand_total_ground?></th>
    <th><?=$grand_total_ftd?></th>
    <th><?=$grand_total_flight?></th>
    <th><?=$grand_total?></th>
  </tr>
</tbody>

</table>
              </div>

<?php 
$statistik[$keyp]['type'] = $valp['type'];
$statistik[$keyp]['count'] = $grand_total;
$statistik[$keyp]['count_ftd'] = $grand_total_ftd;
$statistik[$keyp]['count_flight'] = $grand_total_flight;
$statistik[$keyp]['count_ground'] = $grand_total_ground;
} ?>

<div class="col-md-6">
                        <div class="row">
                            <h3>TOTAL SAFETY PERFORMANCE</h3>
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
                                            foreach ($statistik as $key => $k) {
                                                $total_radir = $total_radir + $k['count']; ?>
                                                <tr>
                                                    <td style="width:15px;">
                                                        <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;">
                                                        </div>
                                                    </td>
                                                    <td class="text-left"><?= $k['type'] ?></td>
                                                    <td style="text-align:right;"><?= $k['count'] ?></a></td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td style="width:15px;">
                                                    <!-- <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;"> -->
                               
                                </td>
                                <th class="text-left">TOTAL</th>
                                <th style="text-align:right;"><?= $total_radir ?></a></th>
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

                                    <?php foreach ($statistik as $key => $k) {   ?> {
                                            "title": "<?= $k['type'] ?>",
                                            "value": <?= $k['count'] ?>
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

                 
                    
                    
<div class="col-md-6">
                        <div class="row">
                            <h3>GROUND SAFETY PERFORMANCE</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="chartdiv_ground"></div>
                                </div>
                                <div class="col-md-6" style="padding-top: 10px;">
                                    <table class="table">
                                        <tbody>
                                            <?php
                                            $color_array = array('#106d80', '#189cb8', '#5db9cd', '#ff9900', '#ffb74c', '#ad5b54', '#f88379', '#faa8a1', '#888888', '#ababab', '#cfcfcf', '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#D32F2F', '#C62828');
                                            $total_radir = 0;
                                            foreach ($statistik as $key => $k) {
                                                $total_radir = $total_radir + $k['count_ground']; ?>
                                                <tr>
                                                    <td style="width:15px;">
                                                        <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;">
                                                        </div>
                                                    </td>
                                                    <td class="text-left"><?= $k['type'] ?></td>
                                                    <td style="text-align:right;"><?= $k['count_ground'] ?></a></td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td style="width:15px;">
                                                    <!-- <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;"> -->
                               
                                </td>
                                <th class="text-left">TOTAL</th>
                                <th style="text-align:right;"><?= $total_radir ?></a></th>
                                </tr>
                                </tbody>
                                </table>
								 </div>
                            </div>

                        <!-- *Agenda Diskusi Umum yang tidak dapat di klasifikasikan secara jelas ke satu Direktorat tertentu. -->

                        <style>
                            #chartdiv_ground {
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

                                    <?php foreach ($statistik as $key => $k) {   ?> {
                                            "title": "<?= $k['type'] ?>",
                                            "value": <?= $k['count_ground'] ?>
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
                            }, "chartdiv_ground", "PieChart");
                        </script>

                        </div>
                    </div>


                    
                    
<div class="col-md-6">
                        <div class="row">
                            <h3>FTD SAFETY PERFORMANCE</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="chartdiv_ftd"></div>
                                </div>
                                <div class="col-md-6" style="padding-top: 10px;">
                                    <table class="table">
                                        <tbody>
                                            <?php
                                            $color_array = array('#106d80', '#189cb8', '#5db9cd', '#ff9900', '#ffb74c', '#ad5b54', '#f88379', '#faa8a1', '#888888', '#ababab', '#cfcfcf', '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#D32F2F', '#C62828');
                                            $total_radir = 0;
                                            foreach ($statistik as $key => $k) {
                                                $total_radir = $total_radir + $k['count_ftd']; ?>
                                                <tr>
                                                    <td style="width:15px;">
                                                        <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;">
                                                        </div>
                                                    </td>
                                                    <td class="text-left"><?= $k['type'] ?></td>
                                                    <td style="text-align:right;"><?= $k['count_ftd'] ?></a></td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td style="width:15px;">
                                                    <!-- <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;"> -->
                               
                                </td>
                                <th class="text-left">TOTAL</th>
                                <th style="text-align:right;"><?= $total_radir ?></a></th>
                                </tr>
                                </tbody>
                                </table>
								 </div>
                            </div>

                        <!-- *Agenda Diskusi Umum yang tidak dapat di klasifikasikan secara jelas ke satu Direktorat tertentu. -->

                        <style>
                            #chartdiv_ftd {
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

                                    <?php foreach ($statistik as $key => $k) {   ?> {
                                            "title": "<?= $k['type'] ?>",
                                            "value": <?= $k['count_ftd'] ?>
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
                            }, "chartdiv_ftd", "PieChart");
                        </script>

                        </div>
                    </div>

                    
<div class="col-md-6">
                        <div class="row">
                            <h3>FLIGHT SAFETY PERFORMANCE</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div id="chartdiv_flight"></div>
                                </div>
                                <div class="col-md-6" style="padding-top: 10px;">
                                    <table class="table">
                                        <tbody>
                                            <?php
                                            $color_array = array('#106d80', '#189cb8', '#5db9cd', '#ff9900', '#ffb74c', '#ad5b54', '#f88379', '#faa8a1', '#888888', '#ababab', '#cfcfcf', '#FFEBEE', '#FFCDD2', '#EF9A9A', '#E57373', '#EF5350', '#F44336', '#E53935', '#D32F2F', '#C62828');
                                            $tot = 0;
                                            foreach ($statistik as $key => $k) {
                                                $tot = $tot + $k['count_flight'];
                                            }
                                            $total_radir = 0;
                                            foreach ($statistik as $key => $k) {
                                                $total_radir = $total_radir + $k['count_flight']; ?>
                                                <tr>
                                                    <td style="width:15px;">
                                                        <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;">
                                                        </div>
                                                    </td>
                                                    <td class="text-left"><?= $k['type'] ?></td>
                                                    <td style="text-align:right;"><a  href="<?=base_url()?>master/daily_movement_report_approved/?safety_type=<?=$k['type']?>"><?= $k['count_flight'] ?></a></td>
                                                
                                                    <td class="text-right"><?=round(($k['count_flight']*100/$tot),2) ?>%</td>
                                                </tr>
                                            <?php } ?>

                                            <tr>
                                                <td style="width:15px;">
                                                    <!-- <div class="legend_box" style="background-color:<?= $color_array[$key]; ?>;width:15px;height:15px;padding:0px;margin:0px;"> -->
                               
                                </td>
                                <th class="text-left">TOTAL</th> 
                                <th style="text-align:right;"><?= $total_radir ?></th>
                                <th style="text-align:right;">100%</th>
                                </tr>
                                </tbody>
                                </table>
								 </div>
                            </div>

                        <!-- *Agenda Diskusi Umum yang tidak dapat di klasifikasikan secara jelas ke satu Direktorat tertentu. -->

                        <style>
                            #chartdiv_flight {
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

                                    <?php foreach ($statistik as $key => $k) {   ?> {
                                            "title": "<?= $k['type'] ?>",
                                            "value": <?= $k['count_flight'] ?>
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
                            }, "chartdiv_flight", "PieChart");
                        </script>

                        </div>
                    </div>
                    
               
        </div>

            </div>

            

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

              <form id="upload-delete" action="<?= base_url('dashboard/flight_schedule/delete') ?>">

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

        <form action="<?= base_url('fitur/impor/daily_flight_schedule') ?>" method="POST"  enctype="multipart/form-data">



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


