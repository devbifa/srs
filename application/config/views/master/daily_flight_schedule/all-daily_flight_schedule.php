<?php
$total = array();
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
				$origin_base = "  AND a.origin_base = '$origin_base' ";
			}else{
				$origin_base = " ";
      }
      
      $batch = $_SESSION['batch'];
      if($batch){
        $batch = " AND a.batch = '$batch' ";
      }else{
        $batch = "";
      }
      ?>


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
               APPROVED DAILY FLIGHT SCHEDULE
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

                <div class="col-md-6">

                  <div class="pull-right">          <a href="<?= base_url('master/daily_flight_schedule/create') ?>">

                    <button type="button" class="btn btn-sm btn-primary float-1"><i class="fa fa-plus"></i></button> 

                  </a>


                  <a href="<?= base_url('fitur/ekspor/daily_flight_schedule') ?>" target="_blank">

<button type="button" class="btn btn-sm btn-warning float-2"><i class="mdi mdi-arrow-up-bold-circle-outline"></i></button> 

</a>

<button type="button" class="btn btn-sm btn-info float-4" onclick="$('#modal-impor').modal()"><i class="mdi mdi-arrow-down-bold-circle-outline"></i></button>

                  </div>

                </div>  

              </div>

              

            </div>

            <div class="box-body">

            <!-- FILTER  -->
            <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>master/daily_flight_schedule/filter" method="post">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>ORIGIN BASE</label>
                                            <select style='width:100%' name="origin_base" class="form-control select2">
                                              <option value="">ALL BASE</option>
                                                <?php 
                                                  $this->db->order_by('base ASC');

                                                  $id = $this->session->userdata('id');
                                                  $user = $this->mymodel->selectDataone('user',array('id'=>$id));
                                                  $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
                                                  $base_id = $user['base'];
                                                  $user['base'] = $base['base'];
                                                 
                                                  $base = $base['base'];
                                                  if($_SESSION['role_id']=='23'){
                                                    $base = " AND a.origin_base = '$base' ";
                                                   
                                                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document',array('id'=>$base_id));
                                                  }else{
                                                    $base = " ";
                                                    $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
                                                  }

                                                 

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
                                            <label>BATCH</label>
                                            <select style='width:100%' name="batch" class="form-control select2">
                                              <option value="">ALL BATCH</option>
                                                <?php 
                                                  $this->db->order_by('batch ASC');
                                                  $base_airport_document = $this->mymodel->selectWhere('batch',null);

                                                  foreach ($base_airport_document as $base_airport_document_record) {

                                                    $text="";

                                                    if($base_airport_document_record['batch']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['batch']."' ".$text." >".$base_airport_document_record['batch']."</option>";

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
                                </form>
                            </div>
                        </div>
                        <!-- FILTER  -->

                <div class="show_error"></div>

                <div class="table-responsive">


<table class="table table-bordered table-striped" id="datatable" style="width:100%">

<thead>

<tr class="bg-success">

<th style="width:20px">NO</th>
<th style="min-width:110px">DATE OF<br>FLIGHT</th><th>ORIGIN<br>BASE</th><th>AIRCRAFT<br>REG</th><th>PIC</th><th>2ND</th>
<th>BATCH</th>
<th>COURSE</th><th>MISSION</th><th>DEP</th><th>ARR</th><th>ROUTE</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>

</tr>

</thead>


<tbody>


<?php 

$data_date =  $this->template->date_range($start_date, $end_date);

$duty_instructor = '';
$total = array();
$array_aircraft = array();

$array_duty_instructor = array();

$nomor = 0;
foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>

<?php 

			$data =  $this->mymodel->selectWithQuery("SELECT a.id,e.id as id_mission, h.nick_name as duty_instructor,a.date_of_flight,a.origin_base,a.aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,a.batch,CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status
      FROM daily_flight_schedule a
      
      LEFT JOIN 
      course d
      ON a.course = d.id
      LEFT JOIN 
      tpm_syllabus_all_course e
      ON a.mission = e.subject_mission
      LEFT JOIN  
      user f
      ON a.pic = f.id_number
      LEFT JOIN   user g
       ON a.2nd = g.id_number
      LEFT JOIN   user h
       ON a.duty_instructor = h.id_number
			WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1' AND etd_utc >= '22:00' AND etd_utc <= '24:00'
      "
      .$batch
      .$origin_base
      .$base.
      "
      GROUP BY a.id
			ORDER BY
      a.date_of_flight ASC, a.etd_utc ASC");
      
      



foreach($data as $key=>$val){
  $nomor++;
  if(!in_array($val['aircraft_reg'],$array_aircraft)){
    array_push($array_aircraft,$val['aircraft_reg']);
  }

  if(!in_array($val['duty_instructor'],$array_duty_instructor)){
    array_push($array_duty_instructor,$val['duty_instructor']);
  }

  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet'], ':') !== false) {
    array_push($total,$val['eet']);
  }
 
    $val['pic'] = $val['pic'];

?>
<tr>
<td><?=$nomor?></td>
<td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
    <td><?=$val['origin_base']?></td>
    <td><?=$val['aircraft_reg']?></td>
    <td class="text-left"><?=$val['pic']?></td>
    <td class="text-left"><?=$val['2nd']?></td>
    <td><?=$val['batch']?></td>
    <td><?=$val['course']?></td>
    <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
    <td class="text-left"><?=$val['mission']?></td>
    <td><?=$val['dep']?></td>
    <td><?=$val['arr']?></td>
    <td class="text-left"><?=$val['rute']?></td>
    <td><?=$val['etd_utc']?></td>
    <td><?=$val['eta_utc']?></td>
    <td><?=$val['eet']?></td>
    <td class="text-left"><?=$val['remark']?></td>
  </tr>
<?php } ?>


<?php 

			$data =  $this->mymodel->selectWithQuery("SELECT a.id,e.id as id_mission, h.nick_name as duty_instructor,a.date_of_flight,a.origin_base,a.aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,a.batch,CONCAT(e.subject_mission,'. ',e.name) as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status
      FROM daily_flight_schedule a
      LEFT JOIN 
      course d
      ON a.course = d.id
      LEFT JOIN 
      tpm_syllabus_all_course e
      ON a.mission = e.subject_mission
      LEFT JOIN  
      user f
      ON a.pic = f.id_number
      LEFT JOIN   user g
       ON a.2nd = g.id_number
      LEFT JOIN   user h
       ON a.duty_instructor = h.id_number
			WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1' AND etd_utc >= '00:00' AND etd_utc <= '21:59'
      "
      .$batch
      .$origin_base
      .$base.
      "
      GROUP BY a.id
			ORDER BY
      a.date_of_flight ASC, a.etd_utc ASC");
      
      

foreach($data as $key=>$val){
  $nomor++;
  if(!in_array($val['aircraft_reg'],$array_aircraft)){
    array_push($array_aircraft,$val['aircraft_reg']);
  }

  if(!in_array($val['duty_instructor'],$array_duty_instructor)){
    array_push($array_duty_instructor,$val['duty_instructor']);
  }

  if($val['duty_instructor']){
    $duty_instructor = $val['duty_instructor'];
  }
  if (strpos($val['eet'], ':') !== false) {
    array_push($total,$val['eet']);
  }
 
    $val['pic'] = $val['pic'];

?>
<tr>
<td><?=$nomor?></td>
<td><?=DATE('d M Y',strtotime($val['date_of_flight']))?></td>
    <td><?=$val['origin_base']?></td>
    <td><?=$val['aircraft_reg']?></td>
    <td class="text-left"><?=$val['pic']?></td>
    <td class="text-left"><?=$val['2nd']?></td>
    <td><?=$val['batch']?></td>
    <td><?=$val['course']?></td>
    <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['mission'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['mission'].'</a>';
    }
    ?>
    <td class="text-left"><?=$val['mission']?></td>
    <td><?=$val['dep']?></td>
    <td><?=$val['arr']?></td>
    <td class="text-left"><?=$val['rute']?></td>
    <td><?=$val['etd_utc']?></td>
    <td><?=$val['eta_utc']?></td>
    <td><?=$val['eet']?></td>
    <td class="text-left"><?=$val['remark']?></td>
  </tr>
<?php } ?>


<?php 
}

$total = $this->template->sum_time($total);
$total_plan = $total;
$total_aircraft = count($array_aircraft);
$total_flight = $nomor;

?>

<?php
  $text = "";
  foreach($array_duty_instructor as $key=>$val){
    if($val){
      $text .= ''.$val.', ';
    }
  }
  $text = substr($text,0,-2);
  
  ?>


<!-- <tr>
  <th colspan="12" class="text-right">TOTAL PLAN</th>
  <th><?=$total?></th>
  <th colspan="3"></th>
</tr> -->
</tbody>

</table>
            </div>

            
<br><br>
<div class="table-responsive">
<table>


<tr>
  <th class="text-left no-border">
  <p>DUTY INSTRUCTOR</p>

  </th>
  <th class="no-border">
  <p>:</p>
  </th>
  <th class="text-left no-border" colspan="3">
  <p><?=$text?></p>
  </th>
 

</tr>

<tr>
  <th class="text-left no-border" style="min-width:250px;">
  
  <p>TOTAL FLIGHT SCHEDULE</p> 

  <p>TOTAL AIRCRAFT IN USE </p>

  <p>TOTAL PLAN</p> 
  
  </th>
  <th class="no-border" style="min-width:15px;">
  <p>:</p>
  <p>:</p>
  <p>:</p>
  </th>
  <th class="text-left no-border" style="min-width:350px;">
  <p><?=$total_flight?></p>
  <p><?=$total_aircraft?></p>
  <p><?=$total_plan?></p>
  </th>
  <td class="no-border" style="width:25%;padding-top:21px;">

</td>
  <td class="no-border" style="width:25%">

</td>
</tr>
</table>

</div>


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


  <div class="modal modal-danger fade" id="modal-delete">

  <div class="modal-dialog">
            <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/daily_flight_schedule/delete') ?>">

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




  

  <script type="text/javascript">

    

        function loadtable(status) {

            var table = '<table class="table table-bordered" id="mytable">'+

                   '     <thead>'+

                   '     <tr class="bg-success">'+

                   '       <th style="width:20px">NUM</th>'+'<th style="min-width:80px;">ACTION</th>'+'<th style="min-width:100px">DATE OF<br>FLIGHT</th>'+'<th>ORIGIN<br>BASE</th>'+'<th>AIRCRAFT<br>REG</th>'+'<th>PIC</th>'+'</th>'+'<th>2ND</th>'+'<th>COURSE</th>'+'<th>MISSION</th>'+'<th>RUTE</th>'+'<th>BATCH</th>'+'<th>ETD<br>UTC</th>'+'<th>ETA<br>UTC</th>'+'<th>EET</th>'+'<th>DEP</th>'+'<th>ARR</th>'+'<th>DUTY INSTRUCTOR</th>'+'<th>REMARK</th>'+

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

                ajax: {"url": "<?= base_url('master/daily_flight_schedule/json?status=') ?>"+status, "type": "POST"},

                columns: [

                    {"data": "id","orderable": false},{"data": "date_of_flight"},{"data": "date_of_flight"},{"data": "origin_base"},{"data": "aircraft_reg"},{"data": "pic"},{"data": "2nd"},{"data": "course"},{"data": "mission"},{"data": "rute"},{"data": "batch"},{"data": "etd_utc"},{"data": "eta_utc"},{"data": "eet"},{"data": "dep"},{"data": "arr"},{"data": "duty_instructor"},{"data": "remark"},

                

                ],

                order: [[1, 'asc']],

                columnDefs : [

                

                ],

             

                rowCallback: function(row, data, iDisplayIndex) {

                    var info = this.fnPagingInfo();

                    var page = info.iPage;

                    var length = info.iLength;

                    var index = page * length + (iDisplayIndex + 1);

                    $('td:eq(0)', row).html(index);

                }

            });

         }





        //  loadtable($("#select-status").val());

           

      function edit(id) {

            location.href = "<?= base_url('master/daily_flight_schedule/edit/') ?>"+id;

         }
         function preview(id) {

          location.href = "<?= base_url('master/daily_flight_schedule/preview/') ?>"+id;

       }
            function hapus(id) {

            $("#modal-delete").modal('show');

            $("#delete-input").val(id);

            

         }

         $("#upload-delete").submit(function(){

            event.preventDefault();

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

                    $(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                   var str = response;

                    if (str.indexOf("success") != -1){

                        $(".show_error").hide().html(response).slideDown("fast");

                       

                        $(".btn-send").removeClass("disabled").html('Yes, Delete it').attr('disabled',false);

                    }else{

                         setTimeout(function(){ 

                           $("#modal-delete").modal('hide');

                        }, 1000);

                        $(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('Yes , Delete it').attr('disabled',false);

                        loadtable($("#select-status").val());

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

            

                }

            });

            return false;

    

        });

  </script>