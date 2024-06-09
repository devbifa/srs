



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY GROUND SCHEDULE

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">DAILY GROUND SCHEDULE</li>

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
               APPROVED DAILY GROUND SCHEDULE
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            <div class="">

              <div class="row">

                <div class="col-md-6">

                  <select onchange="loadtable(this.value)" id="select-status" style="width: 150px" class="form-control">

                      <option value="ENABLE">ENABLE</option>

                      <option value="DISABLE">DISABLE</option>



                  </select>

                </div>

                <div class="col-md-6">

                  <div class="pull-right">         
                     <!-- <a href="<?= base_url('master/daily_ground_schedule/create') ?>">

                    <button type="button" class="btn btn-sm btn-primary float-1"><i class="fa fa-plus"></i> </button> 

                  </a> -->


                  <!-- <a href="<?= base_url('fitur/ekspor/daily_ground_schedule') ?>" target="_blank">

                    <button type="button" class="btn btn-sm btn-warning float-2"><i class="mdi mdi-arrow-up-bold-circle-outline"></i></button> 

                  </a>

                  <button type="button" class="btn btn-sm btn-info float-4" onclick="$('#modal-impor').modal()"><i class="mdi mdi-arrow-down-bold-circle-outline"></i></button>

                  </                  </div> -->

                </div>  

              </div>

              

            </div>

            <div class="box-body">

                <div class="show_error"></div>

                
            <!-- FILTER  -->
            <div class="row">
                            <div class="">
                                <form autocomplete="off" action="<?= base_url() ?>master/daily_ground_schedule/filter" method="post">
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

                                                    if($base_airport_document_record['id']==$_SESSION['batch']){

                                                      $text = "selected";

                                                    }



                                                    echo "<option value='".$base_airport_document_record['id']."' ".$text." >".$base_airport_document_record['batch']."</option>";

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


                        <div class="table-responsive">

<table class="table table-bordered" style="width:100%;" id="datatable">

<thead>

<tr class="bg-success">

<th style="width:20px" rowspan="2">NUM</th>

<th rowspan="2" style="min-width:110px;">DATE</th>
<th rowspan="2" >CLASS<br>ROOM</th>
<th rowspan="2" >INSTRUCTOR</th>
<th rowspan="2" >BATCH</th>
<th rowspan="2" >COURSE</th><th rowspan="2" >SUBJECT</th><th colspan="3">TIME (UTC)</th><th rowspan="2" >PARTICIPANT</th> <th rowspan="2" >REMARK</th>
</tr>

<tr class="bg-success">
	<th>START</th>
	<th>STOP</th>
	<th>DUR</th>
 </tr>
</thead>

<tbody>

<?php 


$start_date = $_SESSION['start_date'];
			$end_date = $_SESSION['end_date'];
			$origin_base = $_SESSION['origin_base'];
			$classroom = $_SESSION['classroom'];
			$batch = $_SESSION['batch'];

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
			if($classroom){
			$classroom = "  AND a.classroom = '$classroom' ";
			}else{
			$classroom = " ";
			}

			if($batch){
			$batch = "  AND a.batch = '$batch' ";
			}else{
			$batch = " ";
			}
			
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
      $base = " AND a.classroom  IN ($text) ";
    }else{
      $base = " AND a.classroom  IN ('none') ";
    }
  }else{
    $base = " ";
  }
 
			


$total = array();
$array_class = array();
$array_subject = array();

$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];

$nomor = 0;
$data_date =  $this->template->date_range($start_date, $end_date);

foreach($data_date as $v=>$k){
  $start_date = $k;
  $end_date = $k;
?>

<?php

			$data = $this->mymodel->selectWithQuery("SELECT a.subject as id_mission,a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,g.batch, CONCAT(c.base,' (',b.classroom,')') as classroom,d.course_code as course,CONCAT(e.subject_mission,'. ',e.name) as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
			FROM
			daily_ground_schedule a
			LEFT JOIN classroom b
			ON a.classroom = b.id
			LEFT JOIN base_airport_document c
			ON b.station = c.id
			LEFT JOIN course d
			ON a.course = d.id
			LEFT JOIN tpm_syllabus_all_course e
			ON a.subject = e.id
			LEFT JOIN user f
			ON a.instructor = f.id
			LEFT JOIN batch g
			ON a.batch = g.id
			LEFT JOIN base_airport_document h
			ON b.station = h.id
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1'  AND start_lt >= '22:00' AND start_lt <= '24:00'
			 "
			  .$base
			  .$batch.
			 "
			ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){
  $nomor++;
	
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  if(!in_array($val['subject'],$array_subject)){
    array_push($array_subject,$val['subject']);
  }
  
  if (strpos($val['duration'], ':') !== false) {
    array_push($total,$val['duration']);
  }

  $participant = 0;
  $student_list = json_decode($val['student'],true);
  // print_r($student_list);
  $student_other = json_decode($val['student_other'],true);
  // print_r($student_other);

  foreach($student_list as $key2=>$val2){
    if($val2['val']){
      $participant++;
    }
  }
  foreach($student_other as $key2=>$val2){
    if($val2['check']=='on'){
      $participant++;
    }
  }
  
  ?>
<tr>
  <td><?=$nomor?>
  </td>
  <td><?=DATE('d M Y',strtotime($val['date']))?></td></td>
  <td><?=$val['classroom']?></td> 
  <td class="text-left"><?=$val['instructor']?></td> 
  <td><?=$val['batch']?></td> 
  <td class="text-left"><?=$val['course']?></td>
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['subject'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['subject'].'</a>';
    }
    ?>  
  <td class="text-left"><?=$val['subject']?></td> 
<td><?=$val['start_lt']?></td> <td><?=$val['stop_lt']?></td> <td><?=$val['duration']?></td> 

<td><?=$participant?></td> 
<td class="text-left"><?=$val['remark']?></td> 
</tr>
<?php } ?>


<?php

			$data = $this->mymodel->selectWithQuery("SELECT a.subject as id_mission,a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,g.batch, CONCAT(c.base,' (',b.classroom,')') as classroom,d.course_code as course,CONCAT(e.subject_mission,'. ',e.name) as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
			FROM
			daily_ground_schedule a
			LEFT JOIN classroom b
			ON a.classroom = b.id
			LEFT JOIN base_airport_document c
			ON b.station = c.id
			LEFT JOIN course d
			ON a.course = d.id
			LEFT JOIN tpm_syllabus_all_course e
			ON a.subject = e.id
			LEFT JOIN user f
			ON a.instructor = f.id
			LEFT JOIN batch g
			ON a.batch = g.id
			LEFT JOIN base_airport_document h
			ON b.station = h.id
			WHERE DATE(a.date) >= '$start_date' AND DATE(a.date) <= '$end_date' AND a.visibility = '1'  AND start_lt >= '00:00' AND start_lt <= '21:59'
			 "
			  .$base
			  .$batch.
			 "
			ORDER BY a.date ASC,a.start_lt ASC");
foreach($data as $key=>$val){
	$nomor++;
  if(!in_array($val['classroom'],$array_class)){
    array_push($array_class,$val['classroom']);
  }
  if(!in_array($val['subject'],$array_subject)){
    array_push($array_subject,$val['subject']);
  }
  
  if (strpos($val['duration'], ':') !== false) {
    array_push($total,$val['duration']);
  }

  $participant = 0;
  $student_list = json_decode($val['student'],true);
  // print_r($student_list);
  $student_other = json_decode($val['student_other'],true);
  // print_r($student_other);

  foreach($student_list as $key2=>$val2){
    if($val2['val']){
      $participant++;
    }
  }
  foreach($student_other as $key2=>$val2){
    if($val2['check']=='on'){
      $participant++;
    }
  }
  
  ?>
<tr>
  <td><?=$nomor?>
  </td>
  <td><?=DATE('d M Y',strtotime($val['date']))?></td></td>
  <td><?=$val['classroom']?></td> 
  <td class="text-left"><?=$val['instructor']?></td> 
  <td><?=$val['batch']?></td> 
  <td class="text-left"><?=$val['course']?></td> <td class="text-left">
  <?php 
    $file = $this->mymodel->selectDataone('file',array('table_id'=>$val['id_mission'],'table'=>'tpm_syllabus_all_course'));
    if($file['name']){
      $val['subject'] = '<a data-placement="top" title="SEE DETAIL SCHEDULE" target="_blank" href="'.base_url().'webfile/'.$file['name'].'">'.$val['subject'].'</a>';
    }
    ?>  
  <?=$val['subject']?></td> 
<td><?=$val['start_lt']?></td> <td><?=$val['stop_lt']?></td> <td><?=$val['duration']?></td> 

<td><?=$participant?></td> 
<td class="text-left"><?=$val['remark']?></td> 
</tr>
<?php } ?>

<?php 
}
$total_subject = count($data);
$total_classroom = count($array_class);

$total_plan = $this->template->sum_time($total);

$total = $nomor;
$total_subject = count($array_subject);

?>

</tbody>

</table>

              </div>

              
              <br><br>
              <div class="table-responsive">
<table>
  <tr>
    <th class="text-left no-border" style="min-width:250px">
    
    <p>TOTAL GROUND SCHEDULE</p> 
    
    <p>TOTAL SUBJECT</p> 

    <p>TOTAL CLASS ROOM IN USE </p>
  
    <p>TOTAL PLAN</p> 
    
    </th>
    <th class="no-border" style="min-width:15px;">
  
    <p>:</p>
    <p>:</p>
    <p>:</p>
    <p>:</p>
    </th>
    <th class="text-left no-border" style="min-width:250px">
 
    <p><?=$total?></p>
    <p><?=$total_subject?></p>
    <p><?=$total_classroom?></p>
    <p><?=$total_plan?></p>
    </th>
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


  <div class="modal fade bd-example-modal-sm" tabindex="-1" daily_ground_schedule="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modal-delete">

      <div class="modal-dialog modal-sm">

          <div class="modal-content">

              <form id="upload-delete" action="<?= base_url('master/daily_ground_schedule/delete') ?>">

              <div class="modal-header">

                  <h5 class="modal-title">Confirm delete</h5>

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                      <span aria-hidden="true">&times;</span>

                  </button>

              </div>

              <div class="modal-body">

                  <input type="hidden" name="id" id="delete-input">

                  <p>Are you sure to delete this data?</p>

              </div>

              <div class="modal-footer">

                  <button type="submit" class="btn btn-danger btn-send">Yes, Delete</button>

                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

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

        <form action="<?= base_url('fitur/impor/daily_ground_schedule') ?>" method="POST"  enctype="multipart/form-data">



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

            var table = '<table class="table table-bordered" id="mytable" style="width:100%">'+

                   '     <thead>'+

                   '     <tr class="bg-success">'+

                   '       <th style="width:20px">No</th>'+'<th style="min-width:70px;">ACTION</th>'+'<th style="min-width:70px;">DATE</th>'+'<th>BATCH</th>'+'<th>CLASSROOM</th>'+'<th>COURSE</th>'+'<th>SUBJECT</th>'+'<th>INSTRUCTOR</th>'+'<th>DURATION</th>'+'<th>START<br>UTC</th>'+'<th>STOP<br>UTC</th>'+'<th>REMARK</th>'+
                  //  '       <th style="min-width:50px">STATUS</th>'+

                  //  '       <th style="min-width:50px"></th>'+

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

                ajax: {"url": "<?= base_url('master/daily_ground_schedule/json?status=') ?>"+status, "type": "POST"},

                columns: [

                    {"data": "id","orderable": false},{"data": "date"},{"data": "date"},{"data": "batch"},{"data": "classroom"},{"data": "course"},{"data": "subject"},{"data": "instructor"},{"data": "duration"},{"data": "start_lt"},{"data": "stop_lt"},{"data": "remark"},

                   

                ],

                order: [[1, 'asc']],

                columnDefs : [

                  { targets : [1],

render : function (data, type, row, meta) {

     htmls = '<a href="<?=base_url()?>master/daily_ground_schedule/edit/'+row['id']+'" class="btn btn-primary btn-xs btn-rounded"><i class="mdi mdi-pencil"></i></a>'+
     '<a onclick="hapus('+row['id']+')" class="btn btn-danger btn-rounded btn-xs"><i class="mdi mdi-delete"></i></a>';

      return htmls;

  }
                      },
                      {
      "targets": 5,
      "className": "text-left",
 },

 {
      "targets": 6,
      "className": "text-left",
 },

 {
      "targets": 7,
      "className": "text-left",
 },

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





         loadtable($("#select-status").val());

           

      function edit(id) {

            location.href = "<?= base_url('master/daily_ground_schedule/edit/') ?>"+id;

         }
         function preview(id) {

          location.href = "<?= base_url('master/daily_ground_schedule/preview/') ?>"+id;

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