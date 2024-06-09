 <?php
$my_role = $this->mymodel->selectDataOne('role',array('id'=>$_SESSION['role']));
$my_menu_sub = json_decode($my_role['menu_sub'],true);
$menu_id = '952';
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
              AIRCRAFT STATUS
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
<tr class="bg-success">
<th style="width:5%" rowspan="2">NUM</th>
<th rowspan="2" style="min-width:100px;" >AIRCRAFT</th>
<th rowspan="2" style="min-width:100px;">BASE</th>
<th colspan="2" style="min-width:100px;">FUEL CAPACITY</th>
<th rowspan="1" style="min-width:100px;">A/C WEIGHT</th>
<th rowspan="2" style="min-width:100px;">INSTRUMENT<br>AVIONIC</th>
<th rowspan="2" style="min-width:100px;"> A/F TTIS</th>
<th rowspan="2" style="min-width:100px;"> NO 1 ENG TSO</th>
<th rowspan="2" style="min-width:100px;"> NO 2 ENG TSO</th>
<th rowspan="2" style="min-width:100px;"> NO 1 PROP TSO</th>
<th rowspan="2" style="min-width:100px;"> NO 2 PROP TSO</th>
<th rowspan="2" style="min-width:100px;"> LOG NO.</th>
<th rowspan="2" style="min-width:100px;"> UPDATE<br>STATUS</th>
<th colspan="3" style="min-width:100px;"> INSPECTION PERIOD</th>
<th rowspan="2" style="min-width:100px;"> AIRCRAFT STATUS</th>
<th rowspan="2" style="min-width:100px;">REMARK</th>
</tr>
<tr class="bg-success">
<th style="min-width:100px;">USG</th>
<th style="min-width:100px;">FUEL</th>
<th style="min-width:100px;">KG</th>
<th style="min-width:100px;">NEXT INSP.</th>
<th style="min-width:100px;">TYPE INSP.</th>
<th style="min-width:100px;">REMAINING</th>
</tr>

</thead>


<tbody>
<?php 
//  $aircraft = $this->mymodel->selectWithQuery("SELECT * FROM aircraft_document WHERE id = '1' ORDER BY serial_number ASC");
$aircraft = $this->mymodel->selectWithQuery("SELECT * FROM aircraft_document  ORDER BY serial_number ASC");

foreach($aircraft as $key=>$val){
  // $last_base = $val['base'];
?>
  <tr>
    <td><?=$key+1?></td>
    <?php if($my_menu_sub[$menu_id]['edit']){ ?>
    <td><a href="<?=base_url()?>master/aircraft_document/edit/<?=$val['id']?>"><?=$val['serial_number']?></a></td>
    <?php }else{ ?>
    <td><?=$val['serial_number']?></td>
    <?php } ?>
    <td><span id="<?=$val['id']?>-base"><i class="fa fa-spin fa-spinner"></i></span></td>
    <td><?=$val['usg']?></td>
    <td><?=$val['fuel']?></td>
    <td><?=$val['weight']?></td>
    <td><?=$val['avionic']?></td>
    <td>
    <span id="<?=$val['id']?>-ttis"><i class="fa fa-spin fa-spinner"></i></span>
    </td>
    <td>
    <span id="<?=$val['id']?>-eng-1"><i class="fa fa-spin fa-spinner"></i></span>
    </td>
    <td>
    <span id="<?=$val['id']?>-eng-2"><i class="fa fa-spin fa-spinner"></i></span>
    </td>
    <td>
    <span id="<?=$val['id']?>-prop-1"><i class="fa fa-spin fa-spinner"></i></span>
    </td>
    <td>
    <span id="<?=$val['id']?>-prop-2"><i class="fa fa-spin fa-spinner"></i></span>
    </td>

  <script>
      $.ajax(
        {
            type: 'GET',
            url: '<?=base_url()?>report/aircraft_status/ajax',
            data: { 
              "aircraft": '<?=$val['registration']?>'
            },
            success: function (response) {

              response = JSON.parse(response);
              $('#<?=$val['id']?>-ttis').html('');
              $('#<?=$val['id']?>-ttis').html(response[0]);
              $('#<?=$val['id']?>-eng-1').html(response[1]);
              $('#<?=$val['id']?>-eng-2').html(response[11]);
              $('#<?=$val['id']?>-prop-1').html(response[2]);
              $('#<?=$val['id']?>-prop-2').html(response[21]);
              $('#<?=$val['id']?>-next').html(response[3]);
              $('#<?=$val['id']?>-insp').html(response[4]);
              $('#<?=$val['id']?>-base').html(response[5]);
              $('#<?=$val['id']?>-remaining').html(response[6]);
            },
            error: function () {
              
            }
        }
      );
      </script>

      
    <td><?=$val['log_number']?></td>
    <td><?=DATE('d M Y H:i',strtotime($val['updated_at']))?></td>
   
    <td>
    <span id="<?=$val['id']?>-next"><i class="fa fa-spin fa-spinner"></i></span>
    </td>
    <td>
    <span id="<?=$val['id']?>-insp"><i class="fa fa-spin fa-spinner"></i></span>
    
    </td>
    <td>
    <span id="<?=$val['id']?>-remaining"><i class="fa fa-spin fa-spinner"></i></span>
    </td>
    
    </td><td><?=$val['status']?></td>
    <td><?=$val['remark']?></td>
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


