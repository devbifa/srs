



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">


    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                FTD INSTRUCTOR PRODUCTIVITY HOURS
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
                                <form autocomplete="off" action="<?= base_url() ?>report/ftd_intructor_productivity_hours/filter" method="post">
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

<table class="table table-bordered " id="">

<thead>

<tr class="bg-success">

            <th style="width:20px">NUM</th>
            <th>FULL NAME</th><th>NICK NAME</th><th>EMPLOYEE<br>NUMBER</th>
            <th>TOTAL<br>SE<br>INSTRUCT</th>
            <th >TOTAL<br>ME<br>INSTRUCT</th>
            <th>TOTAL<br>INSTRUCT</th>
          </tr>
       

</thead>

<tbody>
<?php
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$type = 'FTD';
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.type, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM student_application_form a
LEFT JOIN batch b
ON a.batch = b.id
WHERE   a.instructor_status = '1' AND a.full_name != '' AND a.type LIKE '%$type%' AND id_number NOT IN ('','-')
ORDER BY b.batch ASC
");

?>

<?php
$se_bottom = array();
$me_bottom = array();
$total_bottom = array();

foreach($instructor as $key=>$val){
$se = array();
$me = array();
$total = array();

$pic = $val['id'];
$data = $this->mymodel->selectWithQuery("SELECT a.id,a.block_time_atd, a.block_time_ata, a.block_time_total, a.remark_report, a.date, CONCAT(h.model,'<br>',h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name
FROM daily_ftd_schedule a
JOIN batch c
ON a.batch = c.id
JOIN course d
ON a.course = d.id
JOIN tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN student_application_form f
ON a.pic = f.id
JOIN student_application_form g
ON a.2nd = g.id
JOIN synthetic_training_devices_document h
ON a.ftd_model = h.id
WHERE  a.visibility = '1' AND (a.pic = '$pic' OR a.2nd = '$pic') AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
AND a.block_time_atd NOT IN ('-','') AND h.type_enginee = 'SE'
ORDER BY a.date ASC, a.etd_utc ASC
");
foreach($data as $key2=>$val2){
  // print_r($val2);

  if (strpos($val2['block_time_total'], ':') !== false) {
    array_push($se,$val2['block_time_total']);
  }
 
}

$se = $this->template->sum_time_3($se);

$data = $this->mymodel->selectWithQuery("SELECT a.id,a.block_time_atd, a.block_time_ata, a.block_time_total, a.remark_report, a.date, CONCAT(h.model,'<br>',h.serial_number) as ftd_model,a.eet_utc,a.etd_utc,a.eta,a.remark,a.status,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name
FROM daily_ftd_schedule a
JOIN batch c
ON a.batch = c.id
JOIN course d
ON a.course = d.id
JOIN tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN student_application_form f
ON a.pic = f.id
JOIN student_application_form g
ON a.2nd = g.id
JOIN synthetic_training_devices_document h
ON a.ftd_model = h.id
WHERE  a.visibility = '1' AND (a.pic = '$pic' OR a.2nd = '$pic') AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
AND a.block_time_atd NOT IN ('-','') AND h.type_enginee = 'ME'
ORDER BY a.date ASC, a.etd_utc ASC
");
foreach($data as $key2=>$val2){
  // print_r($val2);

  if (strpos($val2['block_time_total'], ':') !== false) {
    array_push($me,$val2['block_time_total']);
  }
 
}

$me = $this->template->sum_time_3($me);

$total[0] = $se;
$total[1] = $me; 
$total = $this->template->sum_time_3($total);

if (strpos($se, ':') !== false) {
  array_push($se_bottom,$se);
}
if (strpos($me, ':') !== false) {
  array_push($me_bottom,$me);
}
if (strpos($total, ':') !== false) {
  array_push($total_bottom,$total);
}

?>
<tr>
<td><?=$key+1?>
</td>
<td class="text-left"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-left"><?=$val['nick_name']?>
</td>
<td class="text-left"><?=$val['id_number']?>
</td>
<td class="text-center"><?=$se?>
</td>
<td class="text-center"><?=$me?>
</td>
<td class="text-center"><?=$total?>
</td>
</tr>
<?php 
$duty_sum += $duty;
}

$se_bottom = $this->template->sum_time($se_bottom);
$me_bottom = $this->template->sum_time($me_bottom);
$total_bottom = $this->template->sum_time($total_bottom);


?>
<tr>
  <th colspan="4" class="text-left">TOTAL</th>
  <th><?=$se_bottom?></th>
  <th><?=$me_bottom?></th>
  <th><?=$total_bottom?></th>
</tr>
</tbody>

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


