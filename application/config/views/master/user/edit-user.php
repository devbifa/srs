

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        USER

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">USER</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/user/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $user['id'] ?>">





      <div class="row">

        <div class="col-md-4">

          <div class="box">
          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
              EDIT USER DATA
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
                <div class="form-group col-md-6">

                      <label for="form-nip">ID NUMBER</label>

                      <input type="text" class="form-control" id="form-nip" placeholder="Fill Id Number" name="dt[id_number]" value="<?= $user['id_number'] ?>">

                  </div><div class="form-group col-md-6">

                      <label for="form-name">FULL NAME</label>

                      <input type="text" class="form-control" id="form-name" placeholder="Fill Full Name" name="dt[full_name]" value="<?= $user['full_name'] ?>">

                  </div><div class="form-group col-md-6">

<label for="form-name">NICK NAME</label>

<input type="text" class="form-control" id="form-name" placeholder="Fill Nick Name" name="dt[nick_name]" value="<?= $user['nick_name'] ?>">

</div><div class="form-group col-md-6">

                      <label for="form-email">EMAIL</label>

                      <input type="text" class="form-control" id="form-email" placeholder="Fill Email" name="dt[email]" value="<?= $user['email'] ?>">

                  </div><div class="form-group col-md-6">

    <label for="form-password">PASSWORD</label>

    <input type="text" class="form-control" id="form-password" placeholder="Fill Password" name="password">

</div><div class="form-group col-md-6">

                      <label for="form-role_id">ROLE</label>

                      <?php 
                      $dat = $this->mymodel->selectDataOne("role",array('id'=>$_SESSION['role']));
                      ?>
                      <select style='width:100%' name="dt[role]" class="form-control select2">

                        <?php 

                        
                        // $this->db->order_by('role ASC');

                        $role = $this->mymodel->selectWhere('role',null);

                        foreach ($role as $role_record) {

                          $text="";

                          if($role_record['id']==$user['role']){

                            $text = "selected";

                          }
                          
                          if(@in_array($role_record['id'], json_decode($dat['akses']))){

                          echo "<option value='".$role_record['id']."' ".$text." >".$role_record['role']."</option>";

                          }

                        }

                        ?>

                      </select>

                  </div><div class="form-group col-md-6">

                      <label for="form-base">BASE</label>
                      <select style='width:100%' name="dt[base]" class="form-control select2">

                        <?php 

                        $this->db->order_by('base ASC');

                        $base = $_SESSION['json']['base'];
                        
                        if($base== ''){
                         
                          $base_airport_document = $this->mymodel->selectWhere('base_airport_document',null);
                          echo "<option value='' selected >-</option>";
                        }else{
                          $base_airport_document = $this->mymodel->selectWhere('base_airport_document',array('base'=>$base));
                        }
                       

                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text="";

                          if($base_airport_document_record['base']==$user['base']){

                            $text = "selected";

                          }



                          echo "<option value='".$base_airport_document_record['base']."' ".$text." >".$base_airport_document_record['base']."</option>";

                        }

                        ?>

                      </select>

                  </div>
                  
                  <div class="form-group col-md-6">

                      <label for="form-base">STATUS</label>
                      <select style='width:100%' name="dt[status]" class="form-control select2">

                        <?php 

                        $this->db->order_by('status ASC');

                        $base_airport_document = $this->mymodel->selectWhere('instructor_status',null);

                        foreach ($base_airport_document as $base_airport_document_record) {

                          $text="";

                          if($base_airport_document_record['instructor_status']==$user['status']){

                            $text = "selected";

                          }



                          echo "<option value='".$base_airport_document_record['instructor_status']."' ".$text." >".$base_airport_document_record['instructor_status']."</option>";

                        }

                        ?>

                      </select>

                  </div>

                  <div class="form-group col-md-6">

                      <label for="form-desc">POSITION</label>

                      <input type="text" class="form-control" id="form-desc" placeholder="Fill Position" name="dt[position]" value="<?= $user['position'] ?>">

                  </div>
                  <div class="form-group col-md-6">

                      <label for="form-desc">SUBJECT</label>

                      <input type="text" class="form-control" id="form-desc" placeholder="Fill Remark" name="dt[remark_instructor]" value="<?= $user['remark_instructor'] ?>">

                  </div>

                  <div class="form-group col-md-12">

<label for="form-remark">COURSE POSITION</label>
<br>
<?php 
$type = json_decode($user['type'],true);
$data = $this->mymodel->selectWithQuery("SELECT * FROM instructor_type");
foreach($data as $key=>$val){
  $text = ""; 
  foreach($type as $key2=>$val2){
    if($val2[$val['instructor_type']]==$val['instructor_type']){
     $text = "checked";
    }
  }  
?>
<input name="dtt[][<?=$val['instructor_type']?>]" type="checkbox" <?=$text?> value="<?=$val['instructor_type']?>" > <?=$val['instructor_type']?> 
<?php } ?>

</div>
                  
                  <div class="form-group col-md-12">

<label for="form-role">MENU</label>

<!-- <input type="text" class="form-control" id="form-role" placeholder="Masukan Role" name="dt[role]" value="<?= $role['role'] ?>"> -->

<div>

  <!-- <ul> -->

  <?php 

 

  $my_data = $this->mymodel->selectDataOne('user',array('id'=>$_SESSION['id']));

  $my_menu = (json_decode($my_data['menu']));
  $my_menu = join("','",$my_menu);  
  
  $this->db->order_by('urutan asc');
  $menu = $this->mymodel->selectWhere('menu_master',"parent = 0 AND status = 'ENABLE' AND id IN ('$my_menu')");

  $menu_user = json_decode($user['menu_item'],true);


  foreach ($menu as $m) {
    $this->db->order_by('urutan asc');
    $this->db->order_by('name asc');
 
  ?>

<a href="javascript::void(0)">

<input type="checkbox" name="menu[]" value="<?= $m['id'] ?>" <?= (in_array($m['id'], json_decode($user['menu']))) ? "checked":"" ?>>

<i class="<?= $m['icon'] ?>"></i> <?= $m['name'] ?><br>

</a>

<?php

$this->db->order_by('urutan asc');
$this->db->order_by('name asc');
$id_parent = $m['id'];
$parent = $this->mymodel->selectWhere('menu_master',"parent = '$id_parent' AND status = 'ENABLE' AND id IN ('$my_menu')");
foreach($parent as $p){
?>
<a href="javascript::void(0)" style="padding-left:20px;">

<input type="checkbox" name="menu[]" value="<?= $p['id'] ?>" <?= (in_array($p['id'], json_decode($user['menu']))) ? "checked":"" ?>>

<i class="<?= $p['icon'] ?>"></i> <?= $p['name'] ?><br>

</a>
<?php 
$this->db->order_by('urutan asc');
$this->db->order_by('name asc');
$id_parent = $p['id'];
$parent_child = $this->mymodel->selectWhere('menu_master',"parent = '$id_parent' AND status = 'ENABLE' AND id IN ('$my_menu')");
foreach($parent_child as $pc){

 

?>
<a href="javascript::void(0)" style="padding-left:40px;">

<input type="checkbox" name="menu[]" value="<?= $pc['id'] ?>" <?= (in_array($pc['id'], json_decode($user['menu']))) ? "checked":"" ?>>

<i class="<?= $pc['icon'] ?>"></i> <?= $pc['name'] ?> <br>
<i class="" style="margin-left:95px;" ></i> 
<input <?php if($menu_user[$pc['id']]['read']){ echo 'checked'; } ?> name="menu_item[<?=$pc['id']?>][read]" type="checkbox" value="Read"> Read  
<input <?php if($menu_user[$pc['id']]['add']){ echo 'checked'; } ?> name="menu_item[<?=$pc['id']?>][add]" type="checkbox" value="Add"> Add  
<input <?php if($menu_user[$pc['id']]['edit']){ echo 'checked'; } ?> name="menu_item[<?=$pc['id']?>][edit]" type="checkbox" value="Edit"> Edit  
<input <?php if($menu_user[$pc['id']]['delete']){ echo 'checked'; } ?> name="menu_item[<?=$pc['id']?>][delete]" type="checkbox" value="Delete"> Delete <br>

</a>

<?php } ?>
<?php } ?>
  <?php } ?>


  <!-- </ul> -->

</div>

</div>
                  <div class="form-group col-md-12">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

                  </div>
                
                
                  <div class="form-group col-md-12">

                      <label for="form-file">SIGNATURE </label>  
                      
                      <?php

                  if($file_signature['dir']!=""){ ?>
                    <a href="<?= base_url($file_signature['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file_signature['name'] ?></a>


                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file_signature">

                  </div>

                </div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1"  data-placement="top" title="SAVE USER DATA" ><i class="mdi mdi-content-save"></i></button>

                </form>

                </div>
             

                </div>

                </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

          </div>
          </div>

        <!-- /.col -->

       
        
        <div class="col-md-8">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                ATTACHMENT LIST
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
  
  <div class="row">
  <div class="form-group col-md-12">
<!-- <label for="form-file">ATTACHMENT LIST</label> -->
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th class="text-left" rowspan="2" >NO.
</th>
<th class="text-left" rowspan="2" >ATTACHMENT NAME
</th>
<th colspan="2">VALID DATE
</th>
<th rowspan="2">REMARK
</th>
<th class="text-left"   rowspan="2" style="width:105px;">
</th>
</tr>
<tr>
  <th style="width:100px;" >START
  </th>
  <th style="width:100px;" >UNTIL
  </th>
</tr>
<?php
$attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM instructor_file WHERE status = 'ENABLE' ORDER BY number ASC");
$att = json_decode($user['attachment'],true);

$i = 0;

$price = array();
// foreach ($attachment_list as $key => $row)
// {
//     $price[$key] = $row['number'];
// }
array_multisort($price, SORT_ASC, $attachment_list);
// print_r($attachment_list);

foreach($attachment_list as $key=>$val){
 
    // echo $val['number'];
    // $data = $this->mymodel->selectDataOne('instructor_file',array('id'=>$val['type']));
    
?>
<tr>
<td class="text-left" style="width:25px;" >
<?=$i+1?>
</td>
<td class="text-left">
<?=$val['instructor_file']?>
</td>
<td>
<?=$this->template->date_indo(($att[$val['id']]['valid_date_start']))?>
</td>

<td>
<?=$this->template->date_indo(($att[$val['id']]['valid_date_until']))?>
</td>
<td class="text-left">
<?=(($att[$val['id']]['description']))?>
</td>
<td class="text-left" style="width:70px;">
<!-- <a href="#!" class="btn btn-primary btn-xs mb-5 btn-block">EDIT</a> -->

<a href="#!" class="btn btn-warning btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-upload-<?=$i?>"><i class="mdi mdi-pencil"></i></a>
<a href="#!" class="btn btn-danger btn-xs btn-delete"  href="#!" data-toggle="modal" data-target="#modal-delete-<?=$i?>"><i class="mdi mdi-delete"></i></a>

<?php

if($att[$val['id']]['file']){ ?>
<a href="<?=base_url()?>webfile/student_file/<?=$att[$val['id']]['file']?>" target="_blank" class="btn btn-delete btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
<?php } ?>

  
<div class="modal modal-success fade" id="modal-upload-<?=$i?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPDATE ATTACHMENT FILE</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/user/update_file/<?=$user['id']?>/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Attachment Type</label>
                <input readonly autocomplete="off" required required type="text" class="form-control" name="dtt[type]" value="<?=$val['instructor_file']?>">
            </div>
<div class="form-group">
                <label>Valid Date Start</label>
                <input autocomplete="off" required required type="hidden" class="form-control" name="dtt[id]" value="<?=$val['id']?>">
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_start]" value="<?=$att[$val['id']]['valid_date_start']?>">
                </div>
                <div class="form-group">
                <label>Valid Date Until</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_until]" value="<?=$att[$val['id']]['valid_date_until']?>">
                </div>
<!-- <div class="form-group">
                <label>Attachment Number</label>
                <input autocomplete="off" requiredrequired type="text" class="form-control" name="dtt[number]" value="<?=$val['number']?>">
                </div> -->
                <div class="form-group">
                <label>Description</label>
                <input autocomplete="off" required required type="text" class="form-control" name="dtt[description]" value="<?=$att[$val['id']]['description']?>">
                </div>
<div class="form-group">
                <label>Attachment File</label> *empty if not updated.
                <input type="file" class="form-control" name="file">
</div>
             
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Upload File</button>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

       
<div class="modal modal-danger fade" id="modal-delete-<?=$i?>">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE ATTACHMENT</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="">
                <span style="font-weight:100">Are you sure you want to delete this file?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/user/delete_file/<?=$user['id']?>/<?=$val['id']?>">Delete Now</a>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>


        
</td>
</tr>

<?php 
$i++;
} ?>
</table>
</div>
</div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>

      </div>

      <!-- /.row -->

      <!-- </form> -->



      
        <a href="" class="btn btn-danger float-2" href="#!" data-toggle="modal" data-target="#modal-delete-1" data-placement="top" title="DELETE USER DATA"><i class="mdi mdi-delete"></i></a>

        
        <div class="modal modal-danger fade" id="modal-delete-1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DELETE USER DATA</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/user/delete/<?=$user['id']?>">
                <span style="font-weight:100">Are you sure you want to delete this user?</span>
              
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline">Delete Now</button>
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

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

                          //  window.location.href = "<?= base_url('master/user') ?>";
                          window.location.href = "";


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