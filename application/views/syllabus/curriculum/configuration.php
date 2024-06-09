

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        CLASSROOM

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">CLASSROOM</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('syllabus/mission/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                SYLLABUS CURRICULUM
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-body">

             <div class="row">
                <div class="col-md-12">
                  <label for="">CODE</label>
                  <p><?=$data['code']?></p>
                </div>
                <div class="col-md-12">
                  <label for="">CURRICULUM</label>
                  <p><?=$data['name']?></p>
                </div>
                <div class="col-md-12">
                  <label for="">DESCRIPTION</label>
                  <p><?=$data['description']?></p>
                </div>
                
                <div class="col-md-12 mb-3">
                  <label for="">TYPE OF TRAINING</label>
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                      <?php 
                      $this->db->order_by('position','ASC');
                      $arr = $this->mymodel->selectWhere('syllabus_type_of_training',null);
                      
                      $arr_type_of_training = json_decode($data['type_of_training'],true);
                      $arr_course = json_decode($data['course'],true);
                      $arr_mission = json_decode($data['mission'],true);
                      
                      foreach($arr as $k=>$v){
                        $checked = '';
                        if($arr_type_of_training[$v['code']]['status'] == 'ON'){
                          $checked = 'checked';
                        }

                        
                        $qry = '"'.$v['code'].'":{"status":"ON"}';
                        $arr_2 = $this->mymodel->selectWithQuery("SELECT *
                        FROM syllabus_course
                        WHERE type_of_training LIKE '%$qry%' 
				                ORDER BY position ASC");

                        ?>
                        <tr style="background:#F1F1F1">
                          <td class="text-left" style="padding-left:10px;" colspan="7">
                          <div class="w-100 row-2 mb-2">
                            <div class="left-2">
                              <label class="switch" for="checkbox-<?=$k?>">
                                <input <?=$checked?> onclick="update_1('checkbox-<?=$k?>','<?=$v['code']?>','<?=$data['id']?>')" name="type_of_training" value="ON" type="checkbox" id="checkbox-<?=$k?>" />
                                <div class="slider round"></div>
                              </label>
                            </div>
                            <div class="right-2">
                              TYPE OF TRAINING CODE : <?=$v['code']?>
                              <br>
                              <?=$v['name']?>
                            </div>
                          </div>
                          </td>
                        </tr>

                        <?php
                            foreach($arr_2 as $k2=>$v2){

                              $v_type = $v['code'];
                              $code_course = $v2['code'];
                              $arr_3 = $this->mymodel->selectWhere('syllabus_mission',"type_of_training = '$v_type' AND course = '$code_course' 
                              ORDER BY position ASC");

                              $checked = '';
                              if($arr_course[$v['code']][$v2['code']]['status'] == 'ON'){
                                $checked = 'checked';
                              }
                              if($arr_course[$v['code']][$v2['code']]['price']){
                                $v2['price'] = $arr_course[$v['code']][$v2['code']]['price'];
                              }
                        ?>
                        <tr>
                        <td class="text-left" style="vertical-align:top;" colspan="1">
                        <div class="w-100 row-2 mb-2 pl-item text-left">
                                <div class="left-2">
                                  <label class="switch" for="checkbox-<?=$k?>-<?=$k2?>">
                                    <input <?=$checked?> onclick="update_2('checkbox-<?=$k?>-<?=$k2?>','<?=$v2['code']?>','<?=$v['code']?>','<?=$data['id']?>','div-mission-<?=$k?>-<?=$k2?>')" name="type_of_training" value="ON" type="checkbox" id="checkbox-<?=$k?>-<?=$k2?>" />
                                    <div class="slider round"></div>
                                  </label>
                                </div>
                                <div class="right-2">
                                  COURSE CODE : <?=$v2['code']?>
                                  <br>
                                  <?=$v2['code_name']?> - <?=$v2['name']?>
                                </div>
                              </div>
                        </td>
                        <?php
                            if($v['code']!='FLIGHT'){
                            ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <td style="width:100px;vertical-align:top;">
                          DURATION
                        </td>
                        <td style="width:100px;vertical-align:top;" class="text-right">
                          PRICE/H
                          <br>
                          <input type="text" name="price_course" value="<?=$this->template->to_number($v2['price'])?>" class="form-control text-right number" onkeyup="update_11('input-11-<?=$k?>-<?=$k2?>','<?=$v2['code']?>','<?=$v['code']?>','<?=$data['id']?>','input-11-<?=$k?>-<?=$k2?>')"  id="input-11-<?=$k?>-<?=$k2?>" />
                        </td>
                        <?php
                            }else{
                            ?>
 <td style="width:100px">
                          DUAL
                        </td>
                        <td style="width:100px">
                          SOLO
                        </td>
                        <td style="width:100px">
                          PIC
                        </td>
                        <td style="width:100px">
                          SOLO (SPV)
                        </td>
                        <td style="width:100px">
                          NON REV
                        </td>
                        <td style="width:100px" class="text-right">
                          PRICE/H
                        </td>
                            <?php } ?>

                        </tr>

                        <?php
                                foreach($arr_3 as $k3=>$v3){
                                  $checked = '';
                                  if($arr_mission[$v['code']][$v2['code']][$v3['code']]['status'] == 'ON'){
                                    $checked = 'checked';
                                  }
                                  ?>
                                 
                            <?php

                            if($arr_mission[$v['code']][$v2['code']][$v3['code']]['duration']){
                              $v3['duration'] = $arr_mission[$v['code']][$v2['code']][$v3['code']]['duration'];
                            }
                            if($arr_mission[$v['code']][$v2['code']][$v3['code']]['price']){
                              $v3['price'] = $arr_mission[$v['code']][$v2['code']][$v3['code']]['price'];
                            }
                            if($arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_dual']){
                              $v3['duration_dual'] = $arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_dual'];
                            }
                            if($arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_solo']){
                              $v3['duration_solo'] = $arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_solo'];
                            }
                            if($arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_pic']){
                              $v3['duration_pic'] = $arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_pic'];
                            }
                            if($arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_pic_solo']){
                              $v3['duration_pic_solo'] = $arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_pic_solo'];
                            }
                            if($arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_non_rev']){
                              $v3['duration_non_rev'] = $arr_mission[$v['code']][$v2['code']][$v3['code']]['duration_non_rev'];
                            }

                            if($v['code']!='FLIGHT'){
                            ?>
                             <form action="<?=base_url()?>syllabus/curriculum/update-target" method="POST" class="update-target">
                            <tr class="div-mission-<?=$k?>-<?=$k2?>">
                        <td class="text-left">
                        <div class="w-100 row-2 mb-2 pl-item-2 text-left">
                                    <div class="left-2">
                                      <label class="switch" for="checkbox-<?=$k?>-<?=$k2?>-<?=$k3?>">
                                        <input <?=$checked?> onclick="update_3('checkbox-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')" name="type_of_training" value="ON" type="checkbox" id="checkbox-<?=$k?>-<?=$k2?>-<?=$k3?>" />
                                        <div class="slider round"></div>
                                      </label>
                                    </div>
                                    <div class="right-2">
                                      MISSION CODE : <?=$v3['code']?>
                                      <br>
                                      <?=$v3['code_name']?> - <?=$v3['name']?>
                                    </div>
                                  </div>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                          <input type="text" name="duration" value="<?=$v3['duration']?>" class="form-control text-center" onkeyup="update_4('input-4-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')" id="input-4-<?=$k?>-<?=$k2?>-<?=$k3?>">
                        </td>
                        <td>
                          <input type="text" name="price" value="<?=$this->template->to_number($v3['price'])?>" class="form-control text-right number" onkeyup="update_5('input-5-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')" id="input-5-<?=$k?>-<?=$k2?>-<?=$k3?>">
                        </td>
                        </tr>

                            <?php }else{ ?>
                              <tr class="div-mission-<?=$k?>-<?=$k2?>">
                        <td class="text-left">
                        <div class="w-100 row-2 mb-2 pl-item-2 text-left">
                                    <div class="left-2">
                                      <label class="switch" for="checkbox-<?=$k?>-<?=$k2?>-<?=$k3?>">
                                      <input <?=$checked?> onclick="update_3('checkbox-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')" name="type_of_training" value="ON" type="checkbox" id="checkbox-<?=$k?>-<?=$k2?>-<?=$k3?>" />
                                        <div class="slider round"></div>
                                      </label>
                                    </div>
                                    <div class="right-2">
                                      MISSION CODE : <?=$v3['code']?>
                                      <br>
                                      <?=$v3['code_name']?> - <?=$v3['name']?>
                                    </div>
                                  </div>
                        </td>
                        <td>
                          <input type="text" name="duration_dual" value="<?=$v3['duration_dual']?>" class="form-control text-center" id="input-6-<?=$k?>-<?=$k2?>-<?=$k3?>" onkeyup="update_6('input-6-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')">
                        </td>
                        <td>
                          <input type="text" name="duration_solo" value="<?=$v3['duration_solo']?>" class="form-control text-center" id="input-7-<?=$k?>-<?=$k2?>-<?=$k3?>" onkeyup="update_7('input-7-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')">
                        </td>
                        <td>
                          <input type="text" name="duration_pic" value="<?=$v3['duration_pic']?>" class="form-control text-center" id="input-8-<?=$k?>-<?=$k2?>-<?=$k3?>" onkeyup="update_8('input-8-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')">
                        </td>
                        <td>
                          <input type="text" name="duration_pic_solo" value="<?=$v3['duration_pic_solo']?>" class="form-control text-center" id="input-9-<?=$k?>-<?=$k2?>-<?=$k3?>" onkeyup="update_9('input-9-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')">
                        </td>
                        <td>
                          <input type="text" name="duration_non_rev" value="<?=$v3['duration_non_rev']?>" class="form-control text-center" id="input-10-<?=$k?>-<?=$k2?>-<?=$k3?>" onkeyup="update_10('input-10-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')">
                        </td>
                        <td>
                          <input type="text" name="price" value="<?=$this->template->to_number($v3['price'])?>" class="form-control text-right number" onkeyup="update_5('input-5-<?=$k?>-<?=$k2?>-<?=$k3?>','<?=$v3['code']?>','<?=$v['code']?>','<?=$v2['code']?>','<?=$data['id']?>')" id="input-5-<?=$k?>-<?=$k2?>-<?=$k3?>">
                        </td>
                        </tr>
                            <?php } ?>
                        </form>
                        <?php 
                        $checked = '';
                        if($arr_course[$v['code']][$v2['code']]['status'] != 'ON'){
                         
                        ?>
                        <script>
                          $('.div-mission-<?=$k?>-<?=$k2?>').hide();
                        </script>
                                <?php } ?>

                                <?php } ?>

                        <?php } ?>

                      <?php } ?>
                      </tbody>
                    </table>
                  </div>
                <script>
                  function update_1(name,id,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]:checked').val();
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_1/",
                              type: "POST",
                              data: { val: val, id : id, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }

                  function update_2(name,id,id_parent,id_curriculum,id_div){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]:checked').val();
                          if(val=='ON'){
                            $('.'+id_div).show();
                          }else{
                            $('.'+id_div).hide();
                          }
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_2/",
                              type: "POST",
                              data: { val: val, id : id, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }
                  function update_3(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]:checked').val();
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_3/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }

                  function update_4(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          console.log(val);
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_4/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }

                  function update_5(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          console.log(val);
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_5/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }
                  
                  function update_6(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          console.log(val);
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_6/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }
                  
                  function update_7(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          console.log(val);
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_7/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }
                  function update_8(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          console.log(val);
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_8/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }
                  function update_9(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          console.log(val);
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_9/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }
                  function update_10(name,id,id_type,id_parent,id_curriculum){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          console.log(val);
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_10/",
                              type: "POST",
                              data: { val: val, id : id, id_type : id_type, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }

                  function update_11(name,id,id_parent,id_curriculum,id_div){
                    $(document).ready(function() {
                          val = $('input[id="'+name+'"]').val();
                          if(id && name) {
                          $.ajax({
                              url: "<?=base_url()?>syllabus/curriculum/update_11/",
                              type: "POST",
                              data: { val: val, id : id, id_parent : id_parent, id_curriculum : id_curriculum} ,
                              dataType: "json",
                              success: function(data) {

                              }
                          });
                          }
                    });
                  }

                  // $(".update-target").submit(function() {
                  //                 var form = $(this);
                  //                 var mydata = new FormData(this);
                  //                 $.ajax({
                  //                   type: "POST",
                  //                   url: form.attr("action"),
                  //                   data: mydata,
                  //                   cache: false,
                  //                   contentType: false,
                  //                   processData: false,
                  //                   beforeSend: function() {
                  //                     $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i> Proses...").attr('disabled', true);
                  //                   },
                  //                   success: function(response, textStatus, xhr) {
                  //                     var str = JSON.parse(response);
                  //                     if(str['status'] == true) {
                  //                       $(".show_error").html(str['alert']);
                  //                       setTimeout(function() {
                  //                         window.location.href = "";
                  //                 $(".btn-send").removeClass("disabled").html('Kirim Komentar').attr('disabled', false);
                  //                       }, 3000);
                  //                     } else {
                  //                       $(".show_error").html(str['alert']);
                  //                       $(".btn-send").removeClass("disabled").html('Kirim Komentar').attr('disabled', false);
                  //                     }
                  //                   },
                  //                   error: function(xhr, textStatus, errorThrown) {
                  //                     console.log(xhr);
                  //                     $(".btn-send").removeClass("disabled").html('Kirim Komentar').attr('disabled', false);
                  //                     form.find(".show_error").hide().html(xhr).slideDown("fast");
                  //                   }
                  //                 });
                  //                 return false;
                  //               });

                </script>

                <script>
                  // $( document ).ready(function() {
                  to_number();
                  to_persen();
                  function to_number(){
                      $('input.number').keyup(function(event) {
                      // When user select text in the document, also abort.
                      var selection = window.getSelection().toString(); 
                      if (selection !== '') {
                          return; 
                      }       
                      // When the arrow keys are pressed, abort.
                      // if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                      //     return; 
                      // }       
                      var $this = $(this);            
                      // Get the value.
                      var input = $this.val();            
                      input = to_rupiah(input);
                      $this.val(function () {
                          return (input === 0)?"":input.toLocaleString("id-US"); 
                      }); 
                      });
                  }

                  function to_rupiah(input){
                      var number_string = input.toString().replace(/[^,\d]/g, "").toString(),
                      split = number_string.split(","),
                      sisa = split[0].length % 3,
                      rupiah = split[0].substr(0, sisa),
                      ribuan = split[0].substr(sisa).match(/\d{3}/gi);
                      if (ribuan) {
                          separator = sisa ? "." : "";
                          rupiah += separator + ribuan.join(".");
                      }
                      rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
                      
                      return rupiah;
                  }

                  function to_rupiah_format(input){
                      // rupiah = input.toFixed(2).toLocaleString('de-DE');
                      // rupiah = input.toLocaleString('de-DE');
                      let number   = input
                      let decimals = 2
                      let decpoint = ',' // Or Number(0.1).toLocaleString().substring(1, 2)
                      let thousand = '.' // Or Number(10000).toLocaleString().substring(2, 3)
                  
                      let n = Math.abs(number).toFixed(decimals).split('.')
                      n[0] = n[0].split('').reverse().map((c, i, a) =>
                      i > 0 && i < a.length && i % 3 == 0 ? c + thousand : c
                      ).reverse().join('')
                      let rupiah = (Math.sign(number) < 0 ? '-' : '') + n.join(decpoint)
                  
                      return rupiah;
                  }
                  
                  function to_persen(){
                      $('input.persen').keyup(function(event) {
                      // When user select text in the document, also abort.
                      var selection = window.getSelection().toString(); 
                      if (selection !== '') {
                          return; 
                      }       
                      // When the arrow keys are pressed, abort.
                      // if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                      //     return; 
                      // }       
                      var $this = $(this);            
                      // Get the value.
                      var input = $this.val();            
                      if(input > 100){
                          input = 100;
                      }else if(input < 0){
                          input = 0;
                      }
                      $this.val(function () {
                          return input;
                          // return (input === 0)?"":input.toLocaleString("id-US"); 
                      }); 
                      });
                  }
                  
                  function to_number_format(angka){
                      angka = angka.replaceAll(".", "KS");
                      angka = angka.replaceAll(",", ".");
                      angka = angka.replaceAll("KS", "");
                      if(angka==''){
                          angka = 0;
                      }
                      return angka;
                  }
     
                </script>
                
                
             </div>

            </div>


    </section>

    <!-- /.content -->

  </div>
