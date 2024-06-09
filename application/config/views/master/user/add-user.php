

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        USER

        <small>CREATE</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="#">USER</li>

        <li class="active">CREATE</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/user/store') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
              NEW USER DATA
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

    <input type="text" class="form-control" id="form-password" placeholder="Fill Password" name="dt[password]">

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

<i class="<?= $pc['icon'] ?>"></i> <?= $pc['name'] ?><br>

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
                <button type="submit" class="btn btn-primary btn-send float-1"  data-placement="top" title="SAVE USER DATA"><i class="mdi mdi-content-save"></i></button>

              

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

                    $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

                    form.find(".show_error").slideUp().html("");

                },

                success: function(response, textStatus, xhr) {

                    // alert(mydata);

                   var str = response;

                    if (str.indexOf("success") != -1){

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        setTimeout(function(){ 

                           window.location.href = "<?= base_url('master/user') ?>";

                        }, 1000);

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> SUBMIT').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>