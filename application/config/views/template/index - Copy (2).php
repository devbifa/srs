<?php
	$user = $_SESSION['id'];
    $user = $this->mymodel->selectDataOne('user', array('id'=>$user));
    // $instructor = $this->mymodel->selectDataOne('student_application_form',array('id_number'=>$user['nip']));
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

          <div class="box" style="min-height: 1000px;margin-bottom:0px!important;">

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
           
            <marquee direction="left"  style="background-color: #eeeeee;padding:7px 0px;">
            <?php 
      $news = $this->mymodel->selectWithQuery("SELECT * FROM news ORDER BY date DESC LIMIT 15");
      foreach($news as $key=>$val){
           $text .= '<a href="' . base_url("news/detail/") . ($val['date']).'/'.($val['id']). '" class="">'.$val['title'].'</a> | ';
          }
          echo $text = $text.$text.$text.$text.$text;
      ?>
            </marquee>

            <div class="row">

            <div class="col-md-12">
                    
                    <h4 style="padding-bottom:15px"><b><span  style="border-bottom:4px #066265 solid">Daily Flight Schedule</span></b></h4>
                    <div class="table-responsive">

<table class="table table-bordered table-striped"  id="datatable2" style="width:100%;">

<thead>

<tr class="bg-success">

<th style="width:20px">NO</th><th style="min-width:110px">DATE OF<br>FLIGHT</th><th>ORIGIN<br>BASE</th><th>AIRCRAFT<br>REG</th><th>PIC</th><th>2ND</th><th>BATCH</th><th>COURSE</th><th>MISSION</th><th>DEP</th><th>ARR</th><th>ROUTE</th><th>ETD<br>UTC</th><th>ETA<br>UTC</th><th>EET</th><th>REMARK</th>

</tr>

</thead>


<tbody>
<?php 

$start_date = DATE('Y-m-d');
$end_date = DATE('Y-m-d');

$data_date =  $this->template->date_range( $start_date, $end_date);

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
$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a

WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''  AND a.visibility_report = '0' AND etd_utc >= '22:00' AND etd_utc <= '24:00'
AND a.type = ''
"
.$batch
.$origin_base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");


foreach($data_utc as $key=>$val){

$nomor++;


$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));

$val['pic'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));

$val['2nd'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));

$val['duty_instructor'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

$val['course'] = $dat['course_code'];

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
$data_utc = $this->mymodel->selectWithQuery("SELECT *
FROM daily_flight_schedule a

WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND a.type = ''  AND a.visibility_report = '0' AND etd_utc >= '00:00' AND etd_utc <= '21:59'
AND a.type = ''
"
.$batch
.$origin_base.
"
GROUP BY a.id
ORDER BY
a.date_of_flight ASC, a.etd_utc ASC");



foreach($data_utc as $key=>$val){

$nomor++;


$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['pic']));

$val['pic'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['2nd']));

$val['2nd'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('user',array('nick_name'=>$val['duty_instructor']));

$val['duty_instructor'] = $dat['nick_name'];

$dat = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));

$val['mission'] = $dat['subject_mission'].' - '.$dat['name'];

$dat = $this->mymodel->selectDataOne('course',array('code'=>$val['course']));

$val['course'] = $dat['course_code'];

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

<?php
if($nomor < 1){
    echo '<tr><td colspan="16">No Schedule Available</td></tr>';
}
?>
</tbody>

</table>
</div>
                    </div>

          <div class="col-md-12">
                    
          <h4 style="padding:15px 0px"><b><span  style="border-bottom:4px #066265 solid">Daily News</span></b></h4>
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


        $user = $this->mymodel->selectDataOne('user',array('id'=>$row['created_by']));

        $output .= '
        <a href="' . base_url("news/detail/") . ($row['date']).'/'.($row['id']). '" class="">
        <div class="col-md-4" style="margin-bottom:15px;">
        <div class="box">
            <img class="img-even" src="' . $photo['dir']. '" style="height: 250px; width: 100%; object-fit: cover; display: inline;">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12" align="center">
                    <p style="font-size:17px;color:#066265">'.$row['title'].'</p>
                    <p style="color:#066265"><i class="mdi mdi-calendar-clock"></i> '.DATE('d M Y', strtotime($row['date'])).'</p>
                    <p style="color:#066265"> <i class="mdi mdi-pencil"></i>'.$user['full_name'].'</p>
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
