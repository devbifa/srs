<style>
  th{
    border:0.5px #FFF solid!important;
  }
</style>

<?php
 $arr_user = array();
 $arr_user = $this->mymodel->selectWithQuery("SELECT
 id, nick_name as opt
 FROM user 
 WHERE instructor_status = '1' AND role IN ('18','32')
 ORDER BY full_name ASC
 ");


  $aircraft = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$_GET['aircraft_reg']));
 

  $my_role = $this->mymodel->selectDataOne('role',array('id'=>$_SESSION['role']));
  $my_menu_sub = json_decode($my_role['menu_sub'],true);
  $menu_id = '2055';

 ?>


<div class="modal modal-success fade" id="modal-add-log-store">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ADD DISCREPANCIES & RECTIFATION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/store_issue" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>DISCREPANCIES</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <textarea autocomplete="off" required type="text" class="form-control" name="dttt[discrepancies]"><?=$val['discrepancies']?></textarea>
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[d_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['d_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                <label>RECTIFATION</label>
                <textarea autocomplete="off" required type="text" class="form-control" name="dttt[rectifation]"><?=$val['rectifation']?></textarea>
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[r_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['r_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                <label>ISSUE STATUS</label>
                <select autocomplete="off" type="text" class="form-control" name="dttt[issue_status]">
                <?php
                  $arr = array();
                  $arr[] = "SERVICEABLE";
                  $arr[] = "UNSERVICEABLE";
                  $arr[] = "MAINTENANCE";
                  $arr[] = "AOG";
                  foreach($arr as $k=>$v){
                    $text = "";
                    if($v==$val['issue_status']){
                      $text = "selected";
                    }
                    ?>
                    <option <?=$text?> value="<?=$v?>"><?=$v?></option>
                  <?php } ?>
              </select>
    </div>
<div class="form-group">
                <label>Attachment File</label> *empty if not updated.
                <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Store Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>



        <div class="modal modal-success fade" id="modal-add-component-replacement-store">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ADD COMPONENT REPLACEMENTS</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/store_component_replacement" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>POS</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <input autocomplete="off" required type="text" class="form-control" name="dttt[pos]" value="<?=$val['pos']?>">
                </div>
                <div class="form-group">
                <label>DESCRIPTION</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[description]" value="<?=$val['description']?>">
                </div>
                <div class="form-group">
                <label>PART NUMBER</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[part_number]" value="<?=$val['part_number']?>">
                </div>
                <div class="form-group">
                <label>S/N ON</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[s_n_on]" value="<?=$val['s_n_on']?>">
                </div>
                <div class="form-group">
                <label>S/N OFF</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[s_n_off]" value="<?=$val['s_n_off']?>">
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select required autocomplete="off" type="text" class="form-control" name="dttt[sign_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['sign_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
                
<div class="form-group">
                <label>Attachment File</label> *empty if not updated.
                <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Store Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        <div class="modal modal-success fade" id="modal-add-fuel-store">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ADD FUEL</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/store_fuel" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>STN (BASE)</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <input autocomplete="off" required type="hidden" class="form-control" name="id" value="<?=$val['id']?>">
                <!-- <input autocomplete="off" required type="text" class="form-control" name="dttt[stn]" value="<?=$val['stn']?>"> -->
                <select style='width:100%' name="dttt[stn]" class="form-control select2">
                         <!-- <option value="">SELECT ORIGIN BASE</option> -->
                        <?php 
                        $id = $this->session->userdata('id');
                        $user = $this->mymodel->selectDataone('user',array('id'=>$id));
                        $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
                        $user['base'] = $base['base'];
                        $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
                        

                        foreach ($base_airport_document as $vall) {

                          $text="";

                          if($vall['base']==$val['stn']){

                            $text = "selected";

                          }



                          echo "<option value='".$vall['base']."' ".$text." >".$vall['base']."</option>";

                        }

                        ?>

                      </select>
                </div>
                <div class="form-group">
                <label>SERVICE (LTR)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[service]" value="<?=$val['service']?>">
                </div>
                <div class="form-group">
                <label>ONBOARD (LTR)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[onboard]" value="<?=$val['onboard']?>">
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[sign_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['sign_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
                
<div class="form-group">
                <label>Attachment File</label> *empty if not updated.
                <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Store Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        <div class="modal modal-success fade" id="modal-add-oil-store">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">ADD OIL</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/store_oil" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>STN (BASE)</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <input autocomplete="off" required type="hidden" class="form-control" name="id" value="<?=$val['id']?>">
                <!-- <input autocomplete="off" required type="text" class="form-control" name="dttt[stn]" value="<?=$val['stn']?>"> -->
                
                <select style='width:100%' name="dttt[stn]" class="form-control select2">
                         <!-- <option value="">SELECT ORIGIN BASE</option> -->
                        <?php 
                        $id = $this->session->userdata('id');
                        $user = $this->mymodel->selectDataone('user',array('id'=>$id));
                        $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
                        $user['base'] = $base['base'];
                        $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
                        

                        foreach ($base_airport_document as $vall) {

                          $text="";

                          if($vall['base']==$val['stn']){

                            $text = "selected";

                          }



                          echo "<option value='".$vall['base']."' ".$text." >".$vall['base']."</option>";

                        }

                        ?>

                      </select>

                </div>
                <div class="form-group">
                <label>SERVICE (QRS)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[service]" value="<?=$val['service']?>">
                </div>
                <div class="form-group">
                <label>ONBOARD (QRS)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[onboard]" value="<?=$val['onboard']?>">
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[sign_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['sign_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
                
<div class="form-group">
                <label>Attachment File</label> *empty if not updated.
                <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Store Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FLIGHT SCHEDULE

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">DAILY FLIGHT SCHEDULE</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/maintenance_logbook/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $data['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT AIRCRAFT STATUS
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <div class="box-body">

                
                <div class="show_error"></div>
                
                <div class="row">
                <div class="col-md-12">
                
                <div class="row">
                  <div class="form-group col-md-3">
                      <label for="form-date_of_flight">DATE</label>
                      <input disabled autocomplete="off" type="text" class="form-control tgl" id="form-date_of_flight" placeholder="Masukan Date" name="dt[date]" value="<?= $data['date'] ?>">
                  </div>
                  <div class="form-group col-md-3">
                      <label for="form-date_of_flight">AIRCRAFT</label>
                      <input disabled autocomplete="off" type="text" class="form-control tgl" id="form-date_of_flight" placeholder="Masukan Aircraft" name="dt[aircraft_reg]" value="<?= $data['aircraft_reg'] ?>">
                  </div>
                  <div class="form-group col-md-3">
                      <label for="form-date_of_flight">LOG SHEET</label>
                      <input autocomplete="off" type="text" class="form-control" id="form-date_of_flight" placeholder="Masukan Log Sheet" name="dt[log_sheet]" value="<?= $data['log_sheet'] ?>">
                  </div>
                  <div class="form-group col-md-3">
                      <label for="form-last_base">BASE</label>
                      <input autocomplete="off" type="text" class="form-control" id="form-last_base" placeholder="Masukan Base" name="dt[last_base]" value="<?= $data['last_base'] ?>">
                  </div>

                  <div class="form-group col-md-12">
                    <hr>
                    <h3>FLIGHT REPORT</h3> 
                      
                      <div class="table-responsive">

<table class="table table-bordered table-striped" id="datatable"  style="width:100%">
    <tr style="background:#066265;color:#FFF;">
    <th rowspan="2" colspan="1" style="width:3%!important">
        NO
      </th>
      <th rowspan="2" colspan="3" style="width:10%">
        CREW NAME
      </th>
      <th rowspan="2" style="width:5%">
        TYPE OF FLIGHT
      </th>
      <th rowspan="1" colspan="4">
        FLIGHT
      </th>
      <th rowspan="1" colspan="2">
        BLOCK TIME
      </th>
      <th rowspan="1" colspan="2">
        TOTAL TIME
      </th>
      <th rowspan="2" style="width:5%">
        LDG
      </th>
    </tr>

    <tr style="background:#066265;color:#FFF;">
      <th style="width:5%">
        FROM
      </th>
      <th style="width:5%">
        TO
      </th>
      <th style="width:5%">
        ATD
      </th>
      <th style="width:5%">
        ATA
      </th>
      <th style="width:5%">
        OFF
      </th>
      <th style="width:5%">
        ON
      </th>
      <th style="width:5%">
        BLOCK
      </th>
      <th style="width:5%">
        I.F
      </th>
    </tr>
    <?php 


    $start_date = $data['date'];
    $end_date = $data['date'];
    $aircraft_reg = $data['aircraft_reg'];
    $air = " AND a.aircraft_reg = '$aircraft_reg' ";

    $arr_flight = array();

    $data_report = $this->mymodel->selectWithQuery("SELECT *
    FROM daily_flight_schedule a
    WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND etd_utc >= '22:00' AND etd_utc <= '24:00' AND remark_report IN ('','-')
    "
    .$keyword.$keyword_arr
    .$batch.$air
    .$origin_base
    .$base.$qry_irreg.
    "
    GROUP BY a.id
    ORDER BY
    a.date_of_flight ASC, a.etd_utc ASC");

    foreach($data_report as $key=>$val){

        

        $dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
        $temp = $val['aircraft_reg'];
        $val['aircraft_reg'] = $dat['serial_number'];
        if(empty($val['aircraft_reg'])){
        $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val['batch']));
        $temp = $val['batch'];
        $val['batch'] = $dat['batch'];
        if(empty($val['batch'])){
        $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $this->db->select('code_name');
        $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val['tpm']));
        $temp = $val['tpm'];
        $val['tpm'] = $dat['code_name'];
        if(empty($val['tpm'])){
        $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = '';
        if(!in_array($val['pic'],array('','-'))){
        $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
        }
        $temp = $val['pic'];
        $val['pic'] = $dat['nick_name'];
        
        if(in_array($val['pic'],array('','-'))){
        $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = '';
        if(!in_array($val['pic'],array('','-'))){
        $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));
        }
        $temp = $val['2nd'];
        $val['2nd'] = $dat['nick_name'];
        
        if(in_array($val['2nd'],array('','-'))){
        $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = '';
        if(!in_array($val['duty_instructor'],array('','-'))){
        $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));
        }
        $temp = $val['duty_instructor'];
        $val['duty_instructor'] = $dat['nick_name'];
        
        if(in_array($val['duty_instructor'],array('','-'))){
        $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        
        $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));
        $mission = $dat;
        $temp = $val['mission'];
        $val['mission'] = $dat['code_name'];
        
        if(($val['mission']) == ' - '){
        $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));
        
        $temp = $val['course'];
        $val['course'] = $dat['code_name'];
        
        if(($val['course']) == ' - '){
        $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
        }
        
        
        
        $total_ldg += $val['ldg'];
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
        
        if(!in_array($val['remark_report'],array('','-'))){
        $total_irregularities = $total_irregularities + 1;
        }
        if (strpos($val['block_time_start'], ':') !== false) {
        $total_movement = $total_movement + 1;
        }
        if (strpos($val['eet'], ':') !== false) {
        array_push($total,$val['eet']);
        }
        
        
        
        if (strpos($val['block_time_total'], ':') !== false) {
        array_push($total2,$val['block_time_total']);
        }
        
        if (strpos($val['flight_time_total'], ':') !== false) {
        array_push($total3,$val['flight_time_total']);
        }

        $arr_flight[] = $val;
    }

    $data_report = $this->mymodel->selectWithQuery("SELECT *
    FROM daily_flight_schedule a
    WHERE DATE(a.date_of_flight) >= '$start_date' AND DATE(a.date_of_flight) <= '$end_date' AND a.visibility = '1'  AND etd_utc >= '00:00' AND etd_utc <= '21:59' AND remark_report IN ('','-')
    "
    .$keyword.$keyword_arr
    .$batch.$air
    .$origin_base
    .$base.$qry_irreg.
    "
    GROUP BY a.id
    ORDER BY
    a.date_of_flight ASC, a.etd_utc ASC");

    foreach($data_report as $key=>$val){


      $dat = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$val['aircraft_reg']));
      $temp = $val['aircraft_reg'];
      $val['aircraft_reg'] = $dat['serial_number'];
      if(empty($val['aircraft_reg'])){
      $val['aircraft_reg'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = $this->mymodel->selectDataOne('batch',array('code'=>$val['batch']));
      $temp = $val['batch'];
      $val['batch'] = $dat['batch'];
      if(empty($val['batch'])){
      $val['batch'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $this->db->select('code_name');
      $dat = $this->mymodel->selectDataOne('syllabus_curriculum',array('code'=>$val['tpm']));
      $temp = $val['tpm'];
      $val['tpm'] = $dat['code_name'];
      if(empty($val['tpm'])){
      $val['tpm'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = '';
      if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['pic']));
      }
      $temp = $val['pic'];
      $val['pic'] = $dat['nick_name'];
      
      if(in_array($val['pic'],array('','-'))){
      $val['pic'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = '';
      if(!in_array($val['pic'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['2nd']));
      }
      $temp = $val['2nd'];
      $val['2nd'] = $dat['nick_name'];
      
      if(in_array($val['2nd'],array('','-'))){
      $val['2nd'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = '';
      if(!in_array($val['duty_instructor'],array('','-'))){
      $dat = $this->mymodel->selectDataOne('user',array('id_number'=>$val['duty_instructor']));
      }
      $temp = $val['duty_instructor'];
      $val['duty_instructor'] = $dat['nick_name'];
      
      if(in_array($val['duty_instructor'],array('','-'))){
      $val['duty_instructor'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      
      $dat = $this->mymodel->selectDataOne('syllabus_mission',array('code'=>$val['mission'],'type_of_training'=>'FLIGHT'));
      $mission = $dat;
      $temp = $val['mission'];
      $val['mission'] = $dat['code_name'];
      
      if(($val['mission']) == ' - '){
      $val['mission'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      $dat = $this->mymodel->selectDataOne('syllabus_course',array('code'=>$val['course']));
      
      $temp = $val['course'];
      $val['course'] = $dat['code_name'];
      
      if(($val['course']) == ' - '){
      $val['course'] = '<a class="text-red"><b>'.$temp.'</b></a>';
      }
      
      
      
      $total_ldg += $val['ldg'];
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
      
      if(!in_array($val['remark_report'],array('','-'))){
      $total_irregularities = $total_irregularities + 1;
      }
      if (strpos($val['block_time_start'], ':') !== false) {
      $total_movement = $total_movement + 1;
      }
      if (strpos($val['eet'], ':') !== false) {
      array_push($total,$val['eet']);
      }
      
      
      
      if (strpos($val['block_time_total'], ':') !== false) {
      array_push($total2,$val['block_time_total']);
      }
      
      if (strpos($val['flight_time_total'], ':') !== false) {
      array_push($total3,$val['flight_time_total']);
      }

      $arr_flight[] = $val;
  }

    

    $total_flight = count($arr_flight);
    $limit = $total_flight;
    $nomor = 0;
    for($i=0;$i<$limit;$i++){
    $nomor++;
    if($arr_flight[$i]['2nd']){
      $arr_flight[$i]['pic'] .= ' - '.$arr_flight[$i]['2nd']; 
    }
    ?>
    <tr>
      <td>
        <?=$nomor;?>
      </td>
      <td colspan="3" class="text-left">
      <?=$arr_flight[$i]['pic']?> 
      </td>
      <td>
        <?=$arr_flight[$i]['course']?> <?=$arr_flight[$i]['mission']?>
      </td>
      <td>
        <?=$arr_flight[$i]['dep']?>
      </td>
      <td>
        <?=$arr_flight[$i]['arr']?>
      </td>
      <td>
        <?=$arr_flight[$i]['flight_time_take_off']?>
      </td>
      <td>
        <?=$arr_flight[$i]['flight_time_landing']?>
      </td>
      <td>
        <?=$arr_flight[$i]['block_time_start']?>
      </td>
      <td>
        <?=$arr_flight[$i]['block_time_stop']?>
      </td>
      <td>
        <?=$arr_flight[$i]['block_time_total']?>
      </td>
      <td>
        <?=$arr_flight[$i]['if']?>
      </td>
      <td>
        <?=$arr_flight[$i]['ldg']?>
      </td>
    </tr>

    <?php } ?>

</table>
</div>

                  </div>


                  <div class="col-md-12">
                    <hr>
                    <h3>DAILY INSPECTION</h3> 
                    <div class="row">
                      <div class="form-group col-md-2">
                        <label for="form-rute">DATE & TIME</label>
                        <input autocomplete="off" type="text" class="form-control ymdhis" name="dt[di_created_at]" value="<?= $data['di_created_at'] ?>">
                      </div>
                      <div class="form-group col-md-2">
                          <label for="form-rute">SIGN BY</label>
                          <select autocomplete="off" type="text" class="form-control" name="dt[di_created_by]" id="di_created_by">
                            <option value="">SELECT SIGN BY</option>
                            <?php
                             
                              foreach($arr_user as $k=>$v){
                                $text = "";
                                if($v['id']==$data['di_created_by']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v['id']?>"><?=$v['opt']?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="form-group col-md-2">
                          <label>AMEL NO</label>
                          <input id="amel_no" autocomplete="off" type="text" class="form-control" name="dt[di_amel_no]" value="<?= $data['di_amel_no'] ?>">
                      </div>
                      <script>
                        $(document).ready(function(){
                        $('#di_created_by').change(function() {
                              var id = $('#di_created_by').val();
                              $("#amel_no").val('Loading');
                              if(id){
                                  $.ajax({
                                      url:'<?=base_url()?>ajax/get_amel_no/?id='+id,
                                      success:function(html){
                                        $("#amel_no").val(html);
                                      }
                                  }); 
                              }else{
                              }
                          
                          });

                      });
                    </script>
                    </div>
                  </div>

                 

                  <?php
                  $id = $data['id'];
                  $arr = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_issue 
                  WHERE id_maintenance = '$id' AND status = 'ENABLE' ORDER BY id ASC");
                  if($arr){
                  ?>
                  <div class="col-md-12">
                    <hr>
                    <h3>MAINTENANCE RELEASE</h3> 
                    <div class="row">
                      <div class="form-group col-md-2">
                          <label>DATE & TIME</label>
                          <input autocomplete="off" type="text" class="form-control ymdhis" name="dt[mr_created_at]" value="<?= $data['mr_created_at'] ?>">
                      </div>
                      
                      <div class="form-group col-md-2">
                          <label>RELEASE STATUS</label>
                          <select autocomplete="off" type="text" class="form-control" name="dt[release_status]">
                            <?php
                              $arr = array();
                              $arr[] = "NOT RELEASE";
                              $arr[] = "RELEASE";
                              foreach($arr as $k=>$v){
                                $text = "";
                                if($v==$data['release_status']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v?>"><?=$v?></option>
                              <?php } ?>
                          </select>
                      </div>
                      
                      <div class="form-group col-md-2">
                          <label for="form-rute">SIGN BY</label>
                          <select autocomplete="off" type="text" class="form-control" name="dt[mr_created_by]" id="mr_created_by">
                            <option value="">SELECT SIGN BY</option>
                            <?php
                              foreach($arr_user as $k=>$v){
                                $text = "";
                                if($v['id']==$data['mr_created_by']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v['id']?>"><?=$v['opt']?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="form-group col-md-2">
                          <label>AMEL NO</label>
                          <input id="amel_no_2" autocomplete="off" type="text" class="form-control" name="dt[mr_amel_no]" value="<?= $data['mr_amel_no'] ?>">
                      </div>
                      <script>
                        $(document).ready(function(){
                        $('#mr_created_by').change(function() {
                              var id = $('#mr_created_by').val();
                              $("#amel_no_2").val('Loading');
                              if(id){
                                  $.ajax({
                                      url:'<?=base_url()?>ajax/get_amel_no/?id='+id,
                                      success:function(html){
                                        $("#amel_no_2").val(html);
                                      }
                                  }); 
                              }else{
                              }
                          
                          });

                      });
                    </script>
                    <div class="form-group col-md-12"></div>
                      <div class="form-group col-md-2">
                          <label>A/C TTIS</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[mr_ac_ttis]" value="<?= $data['mr_ac_ttis'] ?>">
                      </div>

                      <div class="form-group col-md-2">
                          <label>A/C TTIS UNTIL</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[mr_ac_ttis_until]" value="<?= $data['mr_ac_ttis_until'] ?>">
                      </div>

                      <div class="form-group col-md-2">
                          <label>DAYS UNTIL</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[mr_day_until]" value="<?= $data['mr_day_until'] ?>">
                      </div>
                    
                    </div>
                  </div>

                  <?php } ?>

                  <div class="col-md-12">
                    <hr>
                    <h3>NEXT INSPECTION</h3> 
                    <div class="row">
                      <div class="form-group col-md-2">
                          <label>TYPE</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[ni_type]" value="<?= $data['ni_type'] ?>">
                      </div>
                      
                      <div class="form-group col-md-2">
                          <label>AT A/C TTIS</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[ni_ac_ttis]" value="<?= $data['ni_ac_ttis'] ?>">
                      </div>
                      <div class="form-group col-md-2">
                          <label>REMAINING (+/-)</label>
                          <input readonly autocomplete="off" type="text" class="form-control" name="dt[ni_remaining]" value="<?=number_format($data['ni_ac_ttis'] -  (($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_ac_hours_ttis']),1)?>">
                      </div>
                      <div class="form-group col-md-2">
                          <label>AIRCRAFT STATUS</label>
                          <select disabled autocomplete="off" type="text" class="form-control" name="dt[aircraft_status]">
                            <?php
                              $arr = array();
                              $arr[] = "SERVICEABLE";
                              $arr[] = "UNSERVICEABLE";
                              $arr[] = "MAINTENANCE";
                              $arr[] = "AOG";
                              foreach($arr as $k=>$v){
                                $text = "";
                                if($v==$data['aircraft_status']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v?>"><?=$v?></option>
                              <?php } ?>
                          </select>
                      </div>
                      <div class="form-group col-md-4">
                          <label>REMARK</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[remark]" value="<?= $data['remark'] ?>">
                      </div>
                    </div>
                  </div>


                  


                  <div class="col-md-12">
                    <hr>
                    <h3>MAINTENANCE LOG</h3>
                    <?php if($my_menu_sub[$menu_id]['edit_fwd']){ ?> 
                    <a class="btn btn-success" style="margin-bottom:15px" href="<?=base_url()?>master/maintenance_logbook/get?date=<?=$_GET['date']?>&aircraft_reg=<?=$_GET['aircraft_reg']?>">GET LAST DATA OF BROUGHT FWD</a>
                    <?php } ?>
                    <table class="table  table-bordered table-striped">
                      <tr>
                        <th>
                          TIME
                        </th>
                        <th>
                          A/C HOURS TTIS
                        </th>
                        <th>
                          NO 1 ENGINE TSO
                        </th>
                        <th>
                          NO 2 ENGINE TSO
                        </th>
                        <th>
                          NO 1 PROP TSO
                        </th>
                        <th>
                          NO 2 PROP TSO
                        </th>
                      </tr>
                      
                      <?php if($my_menu_sub[$menu_id]['edit_fwd']){ ?> 

                      <tr>
                        <th class="text-left">
                          BROUGHT FWD
                        </th>
                        <th>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_ac_hours_ttis]" value="<?= $data['bf_ac_hours_ttis'] ?>">
                        </th>
                        <th>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_1_engine_tso]" value="<?= $data['bf_no_1_engine_tso'] ?>">
                        </th>

                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_engine_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_engine_tso]" value="<?= $data['bf_no_2_engine_tso'] ?>">
                        <?php } ?>
                        </th>
                        
                        <th>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_1_prop_tso]" value="<?= $data['bf_no_1_prop_tso'] ?>">
                        </th>

                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_prop_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_prop_tso]" value="<?= $data['bf_no_2_prop_tso'] ?>">
                        <?php } ?>
                        </th>

                      </tr>

                      <?php }else{ ?>

                        <tr>
                        <th class="text-left">
                          BROUGHT FWD
                        </th>
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_ac_hours_ttis]" value="<?= $data['bf_ac_hours_ttis'] ?>">
                        </th>
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_1_engine_tso]" value="<?= $data['bf_no_1_engine_tso'] ?>">
                        </th>

                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_engine_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_engine_tso]" value="<?= $data['bf_no_2_engine_tso'] ?>">
                        <?php } ?>
                        </th>
                        
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_1_prop_tso]" value="<?= $data['bf_no_1_prop_tso'] ?>">
                        </th>

                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_prop_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input readonly ="off" type="text" class="form-control text-center" name="dt[bf_no_2_prop_tso]" value="<?= $data['bf_no_2_prop_tso'] ?>">
                        <?php } ?>
                        </th>

                      </tr>

                      <?php } ?>

                      <tr>
                        <th class="text-left">
                          TODA
                        </th>
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[toda_ac_hours_ttis]" value="<?= number_format($data['hobbs_end_start'] - $data['aircraft_duration'],1) ?>">
                        </th>
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[toda_no_1_engine_tso]" value="<?= number_format($data['hobbs_end_start'] - $data['aircraft_duration'],1) ?>">
                        </th>

                        
                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[toda_no_2_engine_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[toda_no_2_engine_tso]" value="<?= number_format($data['hobbs_end_start'] - $data['aircraft_duration'],1) ?>">
                        <?php } ?>
                        </th>

                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[toda_no_1_prop_tso]" value="<?= number_format($data['hobbs_end_start'] - $data['aircraft_duration'],1) ?>">
                        </th>

                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[toda_no_2_prop_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[toda_no_2_prop_tso]" value="<?= number_format($data['hobbs_end_start'] - $data['aircraft_duration'],1) ?>">
                        <?php } ?>
                        </th>

                      </tr>
                      <tr>
                        <th class="text-left">
                          TOTAL
                        </th>
                       
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[total_ac_hours_ttis]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration']) +$data['bf_ac_hours_ttis'] ?>">
                        </th>
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[total_no_1_engine_tso]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_1_engine_tso'] ?>">
                        </th>

                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[total_no_2_engine_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[total_no_2_engine_tso]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_2_engine_tso'] ?>">
                        <?php } ?>
                         
                        </th>
                        <th>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[total_no_1_prop_tso]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_1_prop_tso'] ?>">
                        </th>

                        
                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[total_no_2_prop_tso]" value="-" readonly >
                        <?php }else{ ?>
                          <input readonly autocomplete="off" type="text" class="form-control text-center" name="dt[total_no_2_prop_tso]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_2_prop_tso'] ?>">
                        <?php } ?>
                        
                      </tr>


                      <tr>
                        <th class="text-left">
                          SIGN BY
                        </th>

                        <th>
                          <select readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_ac_hours_ttis_by]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration']) +$data['bf_ac_hours_ttis'] ?>">
                          <option value="">SELECT SIGN BY</option>
                            <?php
                              
                              foreach($arr_user as $k3=>$v3){
                                $text = "";
                                if($v3['id']==$data['bf_ac_hours_ttis_by']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                              <?php } ?>
                          </select>
                        </th>
                        <th>
                          <select readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_1_engine_tso_by]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_1_engine_tso'] ?>">
                          <option value="">SELECT SIGN BY</option>
                            <?php
                              
                              foreach($arr_user as $k3=>$v3){
                                $text = "";
                                if($v3['id']==$data['bf_no_1_engine_tso_by']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                              <?php } ?>
                          </select>
                        </th>

                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_engine_tso_by]" value="-" readonly >
                        <?php }else{ ?>
                          <select readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_engine_tso_by]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_2_engine_tso'] ?>">
                          <option value="">SELECT SIGN BY</option>
                            <?php
                              
                              foreach($arr_user as $k3=>$v3){
                                $text = "";
                                if($v3['id']==$data['bf_no_2_engine_tso_by']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                              <?php } ?>
                          </select>
                        <?php } ?>
                         
                        </th>
                        <th>
                          <select readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_1_prop_tso_by]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_1_prop_tso'] ?>">
                          <option value="">SELECT SIGN BY</option>
                            <?php
                              
                              foreach($arr_user as $k3=>$v3){
                                $text = "";
                                if($v3['id']==$data['bf_no_1_prop_tso_by']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                              <?php } ?>
                          </select>
                        </th>

                        
                        <th>
                        <?php if($aircraft['type']=="SE"){ ?>
                          <input autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_prop_tso_by]" value="-" readonly >
                        <?php }else{ ?>
                          <select readonly autocomplete="off" type="text" class="form-control text-center" name="dt[bf_no_2_prop_tso_by]" value="<?= ($data['hobbs_end_start'] - $data['aircraft_duration'])+$data['bf_no_2_prop_tso'] ?>">
                          <option value="">SELECT SIGN BY</option>
                            <?php
                              
                              foreach($arr_user as $k3=>$v3){
                                $text = "";
                                if($v3['id']==$data['bf_no_2_prop_tso_by']){
                                  $text = "selected";
                                }
                                ?>
                                <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                              <?php } ?>
                          </select>
                        <?php } ?>

                        

                        
                      </tr>

                    </table>
                    
                    </div>
                  </div>
                  </div>

                  <div class="col-md-12">
                    <hr>
                    <h3>HOBBS</h3> 
                    <div class="row">
                      <div class="form-group col-md-3">
                          <label>START</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[hobbs_start]" value="<?= $data['hobbs_start'] ?>">
                      </div>
                      
                      <div class="form-group col-md-3">
                          <label>END</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[hobbs_end]" value="<?= $data['hobbs_end'] ?>">
                      </div>
                      <div class="form-group col-md-3">
                          <label>END - START</label>
                          <input readonly autocomplete="off" type="text" class="form-control" name="dt[hobbs_end_start]" value="<?= $data['hobbs_end_start'] ?>">
                          <input readonly autocomplete="off" type="hidden" class="form-control" name="dt[aircraft_duration]" value="<?= $total_flight*0.1 ?>">
                      </div>
                      <div class="form-group col-md-3">
                          <label>HOBBS</label>
                          <input readonly autocomplete="off" type="text" class="form-control" name="dt[hobbs]" value="<?= number_format($data['hobbs_end_start'] - $data['aircraft_duration'],1) ?>">
                      </div>
                      <div class="form-group col-md-12">
                          <label>OBSERVATION DURING FLIGHT</label>
                          <input autocomplete="off" type="text" class="form-control" name="dt[observation]" value="<?= $data['observation'] ?>">
                      </div>
                      <div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($data['file']!=""){ ?>
                    <a href="<?= base_url('webfile/maintenance_logbook/'.$data['file']) ?>" target="_blank"><i class="fa fa-download"></i>OPEN FILE</a>

                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Masukan File" name="file">

                  </div>
                    </div>
                  </div>

                  </form>


                  <div class="col-md-12">
                    <hr>
                    <h3>FUEL</h3> 

                    <div class="table-responsive">


                    <table class="table table-bordered">
<tr class="bg-success">
<th class="text-center"  style="width:55px;">NO
</th>
<th class="text-center">STN (BASE)
</th>
<th class="text-center">SERVICE (LTR)
</th>
<th class="text-center">ONBOARD (LTR)
</th>
<th class="text-center">SIGN
</th>
<th class="text-center">FILE
</th>
<th class="text-center" style="width:100px;">
<a href="#!" data-toggle="modal" data-target="#modal-add-fuel-store" class="btn btn-primary btn-xs btn-block">ADD</a>   
</th>


</tr>
<?php
$id = $data['id'];
$arr = $this->mymodel->selectWithQuery("SELECT * FROM fuel 
WHERE id_maintenance = '$id' AND status = 'ENABLE' ORDER BY id ASC");
$i = 0;

$price = array();
// foreach ($attachment_list as $key => $row)
// {
//     $price[$key] = $row['date'];
// }
// array_multisort($price, SORT_ASC, $attachment_list);
// // print_r($attachment_list);
$nomor = 0;
foreach($arr as $key=>$val){
$nomor++;
$this->db->select('nick_name');
$s = $this->mymodel->selectDataOne('user',array('id'=>$val['sign_created_by']));
?>
<tr>
<td class="text-center">
<?=$nomor?>
</td>
<td class="text-center">
<?=$val['stn']?>
</td>
<td class="text-center">
<?=$val['service']?>
</td>
<td class="text-center">
<?=$val['onboard']?>
</td>
<td class="text-center">
<?=$s['nick_name']?>
</td>
<td class="text-center">
<?php
if($val['file']){
?>
<a href="<?=base_url()?>webfile/fuel/<?=$val['file']?>?token=<?=DATE('Ymdhis',strtotime($val['updated_at']))?>" target="_blank">OPEN</a>
<?php } ?>
</td>
<td class="text-left" style="width:100px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

<div class="text-center">
<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-fuel-<?=$key?>"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-fuel-<?=$key?>"><i class="mdi mdi-delete"></i></a>

</div>

  


<div class="modal modal-success fade" id="modal-upload-fuel-<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE FUEL</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/update_fuel" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>STN (BASE)</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <input autocomplete="off" required type="hidden" class="form-control" name="id" value="<?=$val['id']?>">
                <!-- <input autocomplete="off" required type="text" class="form-control" name="dttt[stn]" value="<?=$val['stn']?>"> -->
                <select style='width:100%' name="dttt[stn]" class="form-control select2">
                         <!-- <option value="">SELECT ORIGIN BASE</option> -->
                        <?php 
                        $id = $this->session->userdata('id');
                        $user = $this->mymodel->selectDataone('user',array('id'=>$id));
                        $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
                        $user['base'] = $base['base'];
                        $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
                        

                        foreach ($base_airport_document as $vall) {

                          $text="";

                          if($vall['base']==$val['stn']){

                            $text = "selected";

                          }



                          echo "<option value='".$vall['base']."' ".$text." >".$vall['base']."</option>";

                        }

                        ?>

                      </select>
                </div>
                <div class="form-group">
                <label>SERVICE (LTR)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[service]" value="<?=$val['service']?>">
                </div>
                <div class="form-group">
                <label>ONBOARD (LTR)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[onboard]" value="<?=$val['onboard']?>">
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[sign_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['sign_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
               
    <div class="form-group">
                    <label>Attachment File</label> *empty if not updated.
                    <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Update Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
       
<div class="modal modal-danger fade" id="modal-delete-fuel-<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE FUEL</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this data?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/maintenance_logbook/delete_fuel/<?=$data['id']?>/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
</td>
</tr>
<?php 
} ?>

</table>



                    
                              </div>

                  </div>


                  <div class="col-md-12">
                    <hr>
                    <h3>OIL</h3> 

                    <div class="table-responsive">


                    <table class="table table-bordered">
<tr class="bg-success">
<th class="text-center"  style="width:55px;">NO
</th>
<th class="text-center">STN (BASE)
</th>
<th class="text-center">SERVICE (QRS)
</th>
<th class="text-center">ONBOARD (QRS)
</th>
<th class="text-center">SIGN
</th>
<th class="text-center">FILE
</th>
<th class="text-center" style="width:100px;">
<a href="#!" data-toggle="modal" data-target="#modal-add-oil-store" class="btn btn-primary btn-xs btn-block">ADD</a>   
</th>


</tr>
<?php
$id = $data['id'];
$arr = $this->mymodel->selectWithQuery("SELECT * FROM oil 
WHERE id_maintenance = '$id' AND status = 'ENABLE' ORDER BY id ASC");
$i = 0;

$price = array();
// foreach ($attachment_list as $key => $row)
// {
//     $price[$key] = $row['date'];
// }
// array_multisort($price, SORT_ASC, $attachment_list);
// // print_r($attachment_list);
$nomor = 0;
foreach($arr as $key=>$val){
$nomor++;
$this->db->select('nick_name');
$s = $this->mymodel->selectDataOne('user',array('id'=>$val['sign_created_by']));
?>
<tr>
<td class="text-center">
<?=$nomor?>
</td>
<td class="text-center">
<?=$val['stn']?>
</td>
<td class="text-center">
<?=$val['service']?>
</td>
<td class="text-center">
<?=$val['onboard']?>
</td>
<td class="text-center">
<?=$s['nick_name']?>
</td>
<td class="text-center">
<?php
if($val['file']){
?>
<a href="<?=base_url()?>webfile/oil/<?=$val['file']?>?token=<?=DATE('Ymdhis',strtotime($val['updated_at']))?>" target="_blank">OPEN</a>
<?php } ?>
</td>
<td class="text-left" style="width:100px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

<div class="text-center">
<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-oil-<?=$key?>"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-oil-<?=$key?>"><i class="mdi mdi-delete"></i></a>

</div>

  


<div class="modal modal-success fade" id="modal-upload-oil-<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE OIL</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/update_oil" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>STN (BASE)</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <input autocomplete="off" required type="hidden" class="form-control" name="id" value="<?=$val['id']?>">
                <!-- <input autocomplete="off" required type="text" class="form-control" name="dttt[stn]" value="<?=$val['stn']?>"> -->
                <select style='width:100%' name="dttt[stn]" class="form-control select2">
                         <!-- <option value="">SELECT ORIGIN BASE</option> -->
                        <?php 
                        $id = $this->session->userdata('id');
                        $user = $this->mymodel->selectDataone('user',array('id'=>$id));
                        $base = $this->mymodel->selectDataone('base_airport_document',array('id'=>$user['base']));
                        $user['base'] = $base['base'];
                        $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
                        

                        foreach ($base_airport_document as $vall) {

                          $text="";

                          if($vall['base']==$val['stn']){

                            $text = "selected";

                          }



                          echo "<option value='".$vall['base']."' ".$text." >".$vall['base']."</option>";

                        }

                        ?>

                      </select>
                </div>
                <div class="form-group">
                <label>SERVICE (QRS)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[service]" value="<?=$val['service']?>">
                </div>
                <div class="form-group">
                <label>ONBOARD (QRS)</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[onboard]" value="<?=$val['onboard']?>">
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[sign_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['sign_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
               
    <div class="form-group">
                    <label>Attachment File</label> *empty if not updated.
                    <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Update Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
       
<div class="modal modal-danger fade" id="modal-delete-oil-<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE OIL</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this data?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/maintenance_logbook/delete_oil/<?=$data['id']?>/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
</td>
</tr>
<?php 
} ?>

</table>



                    
                              </div>

                  </div>



                  <div class="col-md-12">
                    <hr>
                    <h3>DISCREPANCIES & RECTIFATION</h3> 

                    <div class="table-responsive">


                    <table class="table table-bordered">
<tr class="bg-success">
<th class="text-center" style="width:55px;">NO
</th>
<th class="text-center">DISCREPANCIES
</th>
<th class="text-center">SIGN
</th>
<th class="text-center">RECTIFATION
</th>
<th class="text-center">SIGN
</th>
<th class="text-center">STATUS
</th>
<th class="text-center">FILE
</th>
<th class="text-center" style="width:100px;">
<a href="#!" data-toggle="modal" data-target="#modal-add-log-store" class="btn btn-primary btn-xs btn-block">ADD</a>   
</th>


</tr>
<?php
$id = $data['id'];
$arr = $this->mymodel->selectWithQuery("SELECT * FROM maintenance_issue 
WHERE id_maintenance = '$id' AND status = 'ENABLE' ORDER BY id ASC");
$i = 0;

$price = array();
// foreach ($attachment_list as $key => $row)
// {
//     $price[$key] = $row['date'];
// }
// array_multisort($price, SORT_ASC, $attachment_list);
// // print_r($attachment_list);
$nomor = 0;
foreach($arr as $key=>$val){
$nomor++;
$this->db->select('nick_name');
$r = $this->mymodel->selectDataOne('user',array('id'=>$val['r_created_by']));
$this->db->select('nick_name');
$d = $this->mymodel->selectDataOne('user',array('id'=>$val['d_created_by']));
?>
<tr>
<td class="text-center">
<?=$nomor?>
</td>
<td class="text-left">
<?=$val['discrepancies']?>
</td>
<td class="text-center">
<?=$d['nick_name']?>
</td>
<td class="text-left">
<?=$val['rectifation']?>
</td>
<td class="text-center">
<?=$r['nick_name']?>
</td>
<td class="text-center">
<?=$val['issue_status']?>
</td>
<td class="text-center">
<?php
if($val['file']){
?>
<a href="<?=base_url()?>webfile/maintenance_issue/<?=$val['file']?>?token=<?=DATE('Ymdhis',strtotime($val['updated_at']))?>" target="_blank">OPEN</a>
<?php } ?>
</td>
<td class="text-left" style="width:100px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

<div class="text-center">
<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-log-<?=$key?>"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-log-<?=$key?>"><i class="mdi mdi-delete"></i></a>

</div>

  


<div class="modal modal-success fade" id="modal-upload-log-<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE DISCREPANCIES & RECTIFATION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/update_issue" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>DISCREPANCIES</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <input autocomplete="off" required type="hidden" class="form-control" name="id" value="<?=$val['id']?>">
                <textarea autocomplete="off" required type="text" class="form-control" name="dttt[discrepancies]"><?=$val['discrepancies']?></textarea>
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[d_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['d_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                <label>RECTIFATION</label>
                <textarea autocomplete="off" required type="text" class="form-control" name="dttt[rectifation]"><?=$val['rectifation']?></textarea>
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select autocomplete="off" type="text" class="form-control" name="dttt[r_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['r_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                <label>ISSUE STATUS</label>
                <select autocomplete="off" type="text" class="form-control" name="dttt[issue_status]">
                <?php
                  $arr = array();
                  $arr[] = "SERVICEABLE";
                  $arr[] = "UNSERVICEABLE";
                  $arr[] = "MAINTENANCE";
                  $arr[] = "AOG";
                  foreach($arr as $k=>$v){
                    $text = "";
                    if($v==$val['issue_status']){
                      $text = "selected";
                    }
                    ?>
                    <option <?=$text?> value="<?=$v?>"><?=$v?></option>
                  <?php } ?>
              </select>
    </div>
    <div class="form-group">
                    <label>Attachment File</label> *empty if not updated.
                    <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Update Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
       
<div class="modal modal-danger fade" id="modal-delete-log-<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE ISCREPANCIES & RECTIFATION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this data?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/maintenance_logbook/delete_issue/<?=$data['id']?>/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
</td>
</tr>
<?php 
} ?>

</table>



                    
                              </div>

                  </div>




                  <div class="col-md-12">
                    <hr>
                    <h3>COMPONENT REPLACEMENTS</h3> 

                    <div class="table-responsive">


                    <table class="table table-bordered">
<tr class="bg-success">
<th class="text-center" style="width:55px;">NO
</th>
<th class="text-center">POS
</th>
<th class="text-center">DESCRIPTION
</th>
<th class="text-center">PART NUMBER
</th>
<th class="text-center">S/N ON
</th>
<th class="text-center">S/N OFF
</th>
<th class="text-center">SIGN
</th>
<th class="text-center">FILE
</th>
<th class="text-center" style="width:100px;">
<a href="#!" data-toggle="modal" data-target="#modal-add-component-replacement-store" class="btn btn-primary btn-xs btn-block">ADD</a>   
</th>


</tr>
<?php
$id = $data['id'];
$arr = $this->mymodel->selectWithQuery("SELECT * FROM component_replacement 
WHERE id_maintenance = '$id' AND status = 'ENABLE' ORDER BY id ASC");
$i = 0;

$price = array();
// foreach ($attachment_list as $key => $row)
// {
//     $price[$key] = $row['date'];
// }
// array_multisort($price, SORT_ASC, $attachment_list);
// // print_r($attachment_list);
$nomor = 0;
foreach($arr as $key=>$val){
$nomor++;
$this->db->select('nick_name');
$s = $this->mymodel->selectDataOne('user',array('id'=>$val['sign_created_by']));
?>
<tr>
<td class="text-center">
<?=$nomor?>
</td>
<td class="text-center">
<?=$val['pos']?>
</td>
<td class="text-center">
<?=$val['description']?>
</td>
<td class="text-center">
<?=$val['part_number']?>
</td>
<td class="text-center">
<?=$val['s_n_on']?>
</td>
<td class="text-center">
<?=$val['s_n_off']?>
</td>
<td class="text-center">
<?=$s['nick_name']?>
</td>
<td class="text-center">
<?php
if($val['file']){
?>
<a href="<?=base_url()?>webfile/component_replacement/<?=$val['file']?>?token=<?=DATE('Ymdhis',strtotime($val['updated_at']))?>" target="_blank">OPEN</a>
<?php } ?>
</td>
<td class="text-left" style="width:100px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

<div class="text-center">
<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-component-replacement<?=$key?>"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-component-replacement<?=$key?>"><i class="mdi mdi-delete"></i></a>

</div>

  


<div class="modal modal-success fade" id="modal-upload-component-replacement<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE COMPONENT REPLACEMENTS</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/maintenance_logbook/update_component_replacement" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                <label>POS</label>
                <input autocomplete="off" required type="hidden" class="form-control" name="id_maintenance" value="<?=$data['id']?>">
                <input autocomplete="off" required type="hidden" class="form-control" name="id" value="<?=$val['id']?>">
                <input autocomplete="off" required type="text" class="form-control" name="dttt[pos]" value="<?=$val['pos']?>">
                </div>
                <div class="form-group">
                <label>DESCRIPTION</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[description]" value="<?=$val['description']?>">
                </div>
                <div class="form-group">
                <label>PART NUMBER</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[part_number]" value="<?=$val['part_number']?>">
                </div>
                <div class="form-group">
                <label>S/N ON</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[s_n_on]" value="<?=$val['s_n_on']?>">
                </div>
                <div class="form-group">
                <label>S/N OFF</label>
                <input autocomplete="off" required type="text" class="form-control" name="dttt[s_n_off]" value="<?=$val['s_n_off']?>">
                </div>
                <div class="form-group">
                <label>SIGN</label>
                  <select required autocomplete="off" type="text" class="form-control" name="dttt[sign_created_by]">
                    <option value="">SELECT SIGN BY</option>
                    <?php
                      
                      foreach($arr_user as $k3=>$v3){
                        $text = "";
                        if($v3['id']==$val['sign_created_by']){
                          $text = "selected";
                        }
                        ?>
                        <option <?=$text?> value="<?=$v3['id']?>"><?=$v3['opt']?></option>
                      <?php } ?>
                  </select>
                </div>
    <div class="form-group">
                    <label>Attachment File</label> *empty if not updated.
                    <input autocomplete="off" type="file" class="form-control" name="file">
    </div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Update Data</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
       
<div class="modal modal-danger fade" id="modal-delete-component-replacement<?=$key?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE ISCREPANCIES & RECTIFATION</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this data?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/maintenance_logbook/delete_component_replacement/<?=$data['id']?>/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
</td>
</tr>
<?php 
} ?>

</table>



                    
                              </div>

                  </div>

                  
                  

                </div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1" ><i class="mdi mdi-content-save"></i></button>
                </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

          <a href="<?=base_url()?>master/maintenance_logbook/print_v2?date=<?=$data['date']?>&aircraft_reg=<?=$data['aircraft_reg']?>" target="_blank" class="btn btn-success  float-2" ><i class="mdi mdi-printer"></i></a>

          <!-- /.box -->

          </div>
          </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

      

      



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

                  $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 


                          window.location.href = "";
                          // window.location.href = "<?= base_url('master/maintenance_logbook/') ?>";
                      

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="mdi mdi-content-save"></i>').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>

<script>
$(document).ready(function(){
    $('#batch').change(function() {
          var batch = $('#batch').val();

          $("#pic").html('<option>LOADING...</option>');

          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_tpm/?batch='+batch,
                  success:function(html){
                    $("#tpm").html(html);
                  }
              }); 
          }else{
             
          }


          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_pic_by_batch/?batch='+batch+'&type=FLIGHT',
                  success:function(html){
                    $("#pic").html(html);
                  }
              }); 
          }else{
             
          }

          $("#2nd").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_2nd_by_batch/?batch='+batch+'&type=FLIGHT',
                  success:function(html){
                    $("#2nd").html(html);
                  }
              }); 
          }else{
             
          }

          $("#course").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_course_by_batch/?batch='+batch+'&type=FLIGHT',
                  success:function(html){
                    $("#course").html(html);
                  }
              }); 
          }else{
            
          }
        
          
       
      });

});

$(document).ready(function(){
    $('#course').change(function() {
          var course = $('#course').val();
          var batch = $('#batch').val();
          $("#mission").html('<option>LOADING...</option>');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_mission_by_course/?batch='+batch+'&course='+course+'&type=FLIGHT',
                  success:function(html){
                    $("#mission").html(html);
                    // alert(html);
                  }
              }); 
          }else{
              // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
          }
       
      });

});

// $(document).ready(function(){
//     $('#course').change(function() {
//           var course = $('#course').val();
//           $("#mission").html('<option>LOADING...</option>');
//           if(batch){
//               $.ajax({
//                   url:'<?=base_url()?>ajax/get_mission_by_course/?course='+course+'&type=FLIGHT',
//                   success:function(html){
//                     $("#mission").html(html);
//                   }
//               }); 
//           }else{
//               // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
//           }
       
//       });

// });


$(document).ready(function(){
    $('#mission').change(function() {
          var mission = $('#mission').val();
          $("#description").val('LOADING...');
          if(batch){
              $.ajax({
                  url:'<?=base_url()?>ajax/get_mission_detail/?mission='+mission,
                  success:function(html){
                    $("#description").val(html);
                  }
              }); 
          }else{
              // $('#kabupaten').html('<option value="">PILIH KABUPATEN/KOTA</option>'); 
          }
       
      });

});
</script>
 <script>
