<?php
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$type = 'GROUND';
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.type, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM user a
LEFT JOIN batch b
ON a.batch = b.id
WHERE   a.instructor_status = '1' AND a.full_name != '' AND a.type LIKE '%$type%' AND id_number NOT IN ('','-')
ORDER BY b.batch ASC
");

?>



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
                GROUND INSTRUCTOR PRODUCTIVITY HOURS
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
                                <form autocomplete="off" action="<?= base_url() ?>report/ground_intructor_productivity_hours/filter" method="post">
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
            <th>FULL NAME</th>
            <th>BASE</th>
            <th>BATCH</th>
            <th>DURATION</th>
            <th>SUBJECT</th>
            <th>TOTAL<br>DAY</th>
            <th>TOTAL<br>TIME</th>
          </tr>

</thead>

<tbody>
<?php

$total_duration = array();
foreach($instructor as $key=>$val){
$pic = $val['id'];
$data = $this->mymodel->selectWithQuery("SELECT a.*, a.subject as id_mission, e.name as subject
FROM daily_ground_schedule a
JOIN tpm_syllabus_all_course e
ON a.subject = e.id
WHERE a.visibility = '1'  AND a.instructor = '$pic' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date'
AND a.duration NOT IN ('-','')
GROUP BY a.subject
ORDER BY a.date ASC,a.start_lt ASC");

// print_r($data);


foreach($data as $key2=>$val2){
  $id_mission = $val2['id_mission'];
  $classroom = '';
  $base = '';
  $time = '';
  
  $data_detail = $this->mymodel->selectWithQuery("SELECT a.student, a.student_attend, a.student_other, a.student_other_attend, a.id,a.date,g.batch, CONCAT(c.base) as base,d.course_code as course,e.name as subject,f.nick_name as instructor,a.duration,a.start_lt,a.stop_lt,a.remark,a.status
  FROM
  daily_ground_schedule a
  JOIN classroom b
  ON a.classroom = b.id
  JOIN base_airport_document c
  ON b.station = c.id
  JOIN course d
  ON a.course = d.id
  JOIN tpm_syllabus_all_course e
  ON a.subject = e.id
  LEFT JOIN user f
  ON a.instructor = f.id
  JOIN batch g
  ON a.batch = g.id
  JOIN base_airport_document h
  ON b.station = h.id
  WHERE a.visibility = '1' AND a.instructor = '$pic' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND a.subject = '$id_mission'
  AND a.duration NOT IN ('-','')
  ORDER BY a.date ASC,a.start_lt ASC");

  $day = $this->mymodel->selectWithQuery("SELECT a.id FROM
  daily_ground_schedule a
  WHERE a.visibility = '1' AND a.instructor = '$pic' AND DATE(date) >= '$start_date' AND DATE(date) <= '$end_date' AND a.subject = '$id_mission'
  AND a.duration NOT IN ('-','')
  GROUP BY DATE(a.date)
  ");

  $day = count($day);
  

  $total_day += $day;
  $duration = array();
  foreach($data_detail as $key3=>$val3){
    $classroom .= $val3['batch'].'<br>';
    $base .= $val3['base'].'<br>';
    $time .= $val3['duration'].'<br>';

    if (strpos($val3['duration'], ':') !== false) {
      array_push($duration,$val3['duration']);
    }

  }




// }
$count = count($data); 

$duration = $this->template->sum_time($duration);
?>

<?php if($count >= 1 && $key2 == 0){
$no++;  
?>
<tr>
<td rowspan="<?=$count?>"><?=$no?>
<td class="text-left" rowspan="<?=$count?>"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-center"><?=$base?></td>
<td class="text-center"><?=$classroom?></td>
<td class="text-center"><?=$time?></td>
<td class="text-left"><?=$val2['subject']?></td>
<td class="text-center"><?=$day?></td>
<td class="text-center"><?=$duration?></td>
</tr>
<?php }else if($count >= 1 && $key2 != 0){ ?>
<tr>
<td class="text-center"><?=$base?></td>
<td class="text-center"><?=$classroom?></td>
<td class="text-center"><?=$time?></td>
<td class="text-left"><?=$val2['subject']?></td>
<td class="text-center"><?=$day?></td>
<td class="text-center"><?=$duration?></td>
</tr>
<?php } ?>
<!-- <td class="text-left" rowspan="<?=$count?>"><a href="<?=base_url()?>record/instructor_hours/instructor/<?=$val['id']?>"><?=$val['full_name']?>
</td>
<td class="text-left" rowspan="<?=$count?>"><?=$val['id_number']?>
</td>

</td>
</tr> -->
<?php 

if (strpos($duration, ':') !== false) {
  array_push($total_duration,$duration);
}

}


}



$total_duration = $this->template->sum_time($total_duration);

?>
<tr>
  <th colspan="6" class="text-left">TOTAL</th>
  <th><?=$total_day?></th>
  <th><?=$total_duration?></th>
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


