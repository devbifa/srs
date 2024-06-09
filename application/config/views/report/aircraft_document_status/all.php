<style>
  .text-red{
    background-color: red;
    color:#000!important;  
  }
  .text-yellow{
    background-color: yellow;
    color:#000!important;  
  }
</style>



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
              AIRCRAFT DOCUMENT STATUS
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

             
            
              <div class="table-responsive">

              <table class="table table-bordered table-striped" id="mytable" style="width:100%">

<thead>
<?php 
 $att_master = $this->mymodel->selectWithQuery("SELECT *
 FROM aircraft_file ORDER BY number ASC");
 ?>
<tr class="bg-success">
<th style="width:5%">NUM</th>
<th style="min-width:100px;" >AIRCRAFT</th>
<th>TYPE</th>
<th>BASE</th>
<?php
foreach($att_master as $k=>$v){ ?>
<th style="min-width:150px;"><?=$v['aircraft_file']?></th>
<?php } ?>
</tr>

</thead>


<tbody>
<?php 
 $aircraft = $this->mymodel->selectWithQuery("SELECT *
 FROM aircraft_document ORDER BY serial_number ASC");
  foreach($aircraft as $key=>$val){
    $att = json_decode($val['attachment'],true);
    // print_r($att);
    ?>
    <td><?=$key+1?></td>
    <td><a href="<?=base_url()?>master/aircraft_document/edit/<?=$val['id']?>"><?=$val['serial_number']?></a></td>
    <td><?=$val['type']?></td>
    <td><?=$val['base']?></td>
    <?php

foreach($att_master as $k=>$v){
$date1 = new DateTime(DATE('Y-m-d'));
$date2 = new DateTime($att[$v['id']]['valid_date_until']);
$diff = $date1->diff($date2);
$text_color = '';
$ket = '';
if($att[$v['id']]['valid_date_until']==''){
  $text_color = '';
  $ket = '-';
}else if($diff->invert=='1'){
  $text_color = 'text-red';
  $ket = 'past '.$diff->days.' day';
}else if($diff->days <= 14){
  $text_color = 'text-red';
  $ket = 'less than '.$diff->days.' day';
}else if($diff->days <= 30){
  $text_color = 'text-yellow';
  $ket = 'less than '.$diff->days.' day';
}
?>
<td class="<?=$text_color?>"><?=$this->template->date_indo($att[$v['id']]['valid_date_until'])?>
<br>
<?=$ket?>
</td>
<?php } ?>
  </tr>
<?php 
}


?>

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


