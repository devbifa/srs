



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
                FLIGHT INSTRUCTOR PRODUCTIVITY HOURS
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
                                <form autocomplete="off" action="<?= base_url() ?>report/flight_intructor_productivity_hours/filter" method="post">
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

            <th style="width:20px" rowspan="2">NUM</th>
            <th rowspan="2">FULL NAME</th><th rowspan="2">NICK NAME</th><th rowspan="2">EMPLOYEE<br>NUMBER</th>
            <th rowspan="2">DUTY<br>INS</th>
            <th colspan="4">SE</th>
            <th colspan="4">ME</th>
            <th colspan="3">SE + ME</th>
            <th rowspan="2">TOTAL<br>FLIGHT<br>HOURS</th>
          </tr>
          <tr class="bg-success">
            <th>DUAL<br>INS</th>
            <th>SOLO<br>(SVP)</th>
            <!-- <th>FI<br>EXC</th> -->
            <th>NON<br>REV</th>
            <th>TOTAL</th>
            <th>DUAL<br>INS</th>
            <th>SOLO<br>(SVP)</th>
            <!-- <th>FI<br>EXC</th> -->
            <th>NON<br>REV</th>
            <th>TOTAL</th>
            <th>DUAL<br>INS</th>
            <th>SOLO<br>(SVP)</th>
            <!-- <th>FI<br>EXC</th> -->
            <th>NON<br>REV</th>
          </tr>

</thead>

<tbody>
<?php
$start_date = $_SESSION['start_date'];
$end_date = $_SESSION['end_date'];
$type = 'FLIGHT';
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.type, DATE_FORMAT(a.registration_date,'%d %b %Y') as registration_date,DATE_FORMAT(a.date_of_birth,'%d %b %Y') as date_of_birth,a.application_number,a.full_name, a.nick_name, a.place_of_birth, a.gender,b.batch,a.status,a.id_number, a.ppl_number,  a.spl_number, a.cpl_number,a.medex_valid_date, a.remark,a.last_input_date 
FROM user a
LEFT JOIN batch b
ON a.batch = b.id
WHERE   a.instructor_status = '1' AND a.full_name != '' AND a.type LIKE '%$type%' AND id_number NOT IN ('','-')
ORDER BY b.batch ASC
");

?>
<?php
$se_total_bottom = array();
$me_total_bottom = array();
$total_bottom = array();
$se_dual_bottom = array();
$se_solo_bottom = array();
$se_fi_bottom = array();
$se_rev_bottom = array();
$me_dual_bottom = array();
$me_solo_bottom = array();
$me_fi_bottom = array();
$me_rev_bottom = array();
$se_me_dual_bottom = array();
$se_me_solo_bottom = array();
$se_me_fi_bottom = array();
$se_me_rev_bottom = array();

foreach($instructor as $key=>$val){
$pic = $val['id'];
$data = $this->mymodel->selectWithQuery("SELECT e.*,a.id,a.block_time_start, a.block_time_stop,
a.block_time_total,
a.flight_time_take_off,
a.flight_time_landing,
a.flight_time_total,
a.remark_dmr, h.nick_name as duty_instructor,a.ldg,
a.date_of_flight,a.origin_base,b.serial_number as aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status
FROM daily_flight_schedule a
JOIN
aircraft_document b
ON a.aircraft_reg = b.id
JOIN
batch c 
ON a.batch = c.id
JOIN
course d
ON a.course = d.id
JOIN
tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN
user f
ON a.pic = f.id
LEFT JOIN user g
ON a.2nd = g.id
LEFT JOIN user h
ON a.duty_instructor = h.id
WHERE a.visibility = '1'  AND (a.pic = '$pic' OR a.2nd = '$pic') 
AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND b.type = 'SE'
AND a.block_time_start NOT IN ('-','')
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");
$se_dual = array();
$se_pic = array();
$se_fi = array();
$se_rev = array();
$me_total = array();
foreach($data as $key2=>$val2){
  if (strpos($val2['duration_dual'], ':') !== false) {
    array_push($se_dual,$val2['block_time_total']);
  }
  if (strpos($val2['duration_solo'], ':') !== false) {
    array_push($se_solo,$val2['block_time_total']);
  }
  if (strpos($val2['duration_pic'], ':') !== false) {
    array_push($se_fi,$val2['block_time_total']);
  }
  if (strpos($val2['duration_pic_solo'], ':') !== false) {
    array_push($se_rev,$val2['block_time_total']);
  }
}

$se_dual = $this->template->sum_time_3($se_dual);
$se_solo = $this->template->sum_time_3($se_solo);
$se_fi = $this->template->sum_time_3($se_fi);
$se_rev = $this->template->sum_time_3($se_rev);

$se_total[0] = $se_dual;
$se_total[1] = $se_solo;
$se_total[2] = $se_fi;
$se_total[3] = $se_rev;
$se_total = $this->template->sum_time_3($se_total);


$data = $this->mymodel->selectWithQuery("SELECT e.*,a.id,a.block_time_start, a.block_time_stop,
a.block_time_total,
a.flight_time_take_off,
a.flight_time_landing,
a.flight_time_total,
a.remark_dmr, h.nick_name as duty_instructor,a.ldg,
a.date_of_flight,a.origin_base,b.serial_number as aircraft_reg,f.nick_name as pic,g.nick_name as 2nd,d.course_code as course,c.batch,e.name as mission,e.name as mission_name,a.description,a.rute,a.etd_utc,a.eta_utc,a.eet,a.dep,a.arr,a.remark,a.status
FROM daily_flight_schedule a
JOIN
aircraft_document b
ON a.aircraft_reg = b.id
JOIN
batch c 
ON a.batch = c.id
JOIN
course d
ON a.course = d.id
JOIN
tpm_syllabus_all_course e
ON a.mission = e.id
LEFT JOIN
user f
ON a.pic = f.id
LEFT JOIN user g
ON a.2nd = g.id
LEFT JOIN user h
ON a.duty_instructor = h.id
WHERE a.visibility = '1'  AND (a.pic = '$pic' OR a.2nd = '$pic' OR a.duty_instructor = '$pic') 
AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND b.type = 'ME'
AND a.block_time_start NOT IN ('-','')
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");
$me_dual = array();
$me_pic = array();
$me_fi = array();
$me_rev = array();
foreach($data as $key2=>$val2){
  if (strpos($val2['duration_dual'], ':') !== false) {
    array_push($me_dual,$val2['block_time_total']);
  }
  if (strpos($val2['duration_solo'], ':') !== false) {
    array_push($me_solo,$val2['block_time_total']);
  }
  if (strpos($val2['duration_pic'], ':') !== false) {
    array_push($me_fi,$val2['block_time_total']);
  }
  if (strpos($val2['duration_pic_solo'], ':') !== false) {
    array_push($me_rev,$val2['block_time_total']);
  }
}

$me_dual = $this->template->sum_time_3($me_dual);
$me_solo = $this->template->sum_time_3($me_solo);
$me_fi = $this->template->sum_time_3($me_fi);
$me_rev = $this->template->sum_time_3($me_rev);

$me_total[0] = $me_dual;
$me_total[1] = $me_solo;
$me_total[2] = $me_fi;
$me_total[3] = $me_rev;
$me_total = $this->template->sum_time_3($me_total);

$se_me_dual = array();
$se_me_dual[0] = $se_dual;
$se_me_dual[1] = $me_dual;
$se_me_dual = $this->template->sum_time_3($se_me_dual);

$se_me_solo = array();
$se_me_solo[0] = $se_solo;
$se_me_solo[1] = $me_solo;
$se_me_solo = $this->template->sum_time_3($se_me_solo);

$se_me_fi = array();
$se_me_fi[0] = $se_fi;
$se_me_fi[1] = $me_fi;
$se_me_fi = $this->template->sum_time_3($se_me_fi);

$se_me_rev = array();
$se_me_rev[0] = $se_rev;
$se_me_rev[1] = $me_rev;
$se_me_rev = $this->template->sum_time_3($se_me_rev);

$total = array();
$total[0] = $se_me_dual;
$total[1] = $se_me_solo;
$total[2] = $se_me_fi;
$total[3] = $se_me_rev;
$total = $this->template->sum_time_3($total);

if (strpos($se_dual, ':') !== false) {
  array_push($se_dual_bottom,$se_dual);
}
if (strpos($se_solo, ':') !== false) {
  array_push($se_solo_bottom,$se_solo);
}
if (strpos($se_fi, ':') !== false) {
  array_push($se_fi_bottom,$se_fi);
}
if (strpos($se_rev, ':') !== false) {
  array_push($se_rev_bottom,$se_rev);
}

if (strpos($me_dual, ':') !== false) {
  array_push($me_dual_bottom,$me_dual);
}
if (strpos($me_solo, ':') !== false) {
  array_push($me_solo_bottom,$me_solo);
}
if (strpos($me_fi, ':') !== false) {
  array_push($me_fi_bottom,$me_fi);
}
if (strpos($me_rev, ':') !== false) {
  array_push($me_rev_bottom,$me_rev);
}

if (strpos($se_me_dual, ':') !== false) {
  array_push($se_me_dual_bottom,$se_me_dual);
}
if (strpos($se_me_solo, ':') !== false) {
  array_push($se_me_solo_bottom,$se_me_solo);
}
if (strpos($se_me_fi, ':') !== false) {
  array_push($se_me_fi_bottom,$se_me_fi);
}
if (strpos($se_me_rev, ':') !== false) {
  array_push($se_me_rev_bottom,$se_me_rev);
}

if (strpos($total, ':') !== false) {
  array_push($total_bottom,$total);
}

if (strpos($se_total, ':') !== false) {
  array_push($se_total_bottom,$se_total);
}
if (strpos($me_total, ':') !== false) {
  array_push($me_total_bottom,$me_total);
}


$count = $this->mymodel->selectWithQuery("SELECT COUNT(a.id) as count FROM daily_flight_schedule a
WHERE a.visibility = '1'  AND (a.duty_instructor = '$pic') AND DATE(date_of_flight) >= '$start_date' AND DATE(date_of_flight) <= '$end_date'
AND a.block_time_start NOT IN ('-','')
GROUP BY DATE(date_of_flight)");
$duty = count($count);
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
<td class="text-center"><?=$duty?>
</td>
<td class="text-center"><?=$se_dual?>
</td>
<td class="text-center"><?=$se_solo?>
</td>
<!-- <td class="text-center"><?=$se_fi?>
</td> -->
<td class="text-center"><?=$se_rev?>
</td>
<td class="text-center"><?=$se_total?>
</td>
<td class="text-center"><?=$me_dual?>
</td>
<td class="text-center"><?=$me_solo?>
</td>
<!-- <td class="text-center"><?=$me_fi?>
</td> -->
<td class="text-center"><?=$me_rev?>
</td>
<td class="text-center"><?=$me_total?>
</td>
<td class="text-center"><?=$se_me_dual?>
</td>
<td class="text-center"><?=$se_me_solo?>
</td>
<!-- <td class="text-center"><?=$se_me_fi?>
</td> -->
<td class="text-center"><?=$se_me_rev?>
</td>
<td class="text-center"><?=$total?>
</td>
</tr>
<?php 
$duty_sum += $duty;
}


$se_dual_bottom = $this->template->sum_time($se_dual_bottom);
$se_solo_bottom = $this->template->sum_time($se_solo_bottom);
$se_fi_bottom = $this->template->sum_time($se_fi_bottom);
$se_rev_bottom = $this->template->sum_time($se_rev_bottom);

$me_dual_bottom = $this->template->sum_time($me_dual_bottom);
$me_solo_bottom = $this->template->sum_time($me_solo_bottom);
$me_fi_bottom = $this->template->sum_time($me_fi_bottom);
$me_rev_bottom = $this->template->sum_time($me_rev_bottom);

$se_me_dual_bottom = $this->template->sum_time($se_me_dual_bottom);
$se_me_solo_bottom = $this->template->sum_time($se_me_solo_bottom);
$se_me_fi_bottom = $this->template->sum_time($se_me_fi_bottom);
$se_me_rev_bottom = $this->template->sum_time($se_me_rev_bottom);

$se_total_bottom = $this->template->sum_time($se_total_bottom);

$me_total_bottom = $this->template->sum_time($me_total_bottom);

$total_bottom = $this->template->sum_time($total_bottom);

?>
<tr>
  <th colspan="4" class="text-left">TOTAL</th>
  <th><?=$duty_sum?></th>
  <th><?=$se_dual_bottom?></th>
  <th><?=$se_solo_bottom?></th>
  <!-- <th><?=$se_fi_bottom?></th> -->
  <th><?=$se_rev_bottom?></th>
  <th><?=$se_total_bottom?></th>
  <th><?=$me_dual_bottom?></th>
  <th><?=$me_solo_bottom?></th>
  <!-- <th><?=$me_fi_bottom?></th> -->
  <th><?=$me_rev_bottom?></th>
  <th><?=$me_total_bottom?></th>
  <th><?=$se_me_dual_bottom?></th>
  <th><?=$se_me_solo_bottom?></th>
  <!-- <th><?=$se_me_fi_bottom?></th> -->
  <th><?=$se_me_rev_bottom?></th>
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


