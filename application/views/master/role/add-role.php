
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Role
        <small>Master</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">master</a></li>
        <li class="active">Role</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    <form method="POST" action="<?= base_url('master/role/store') ?>" id="upload-create" enctype="multipart/form-data">

      <div class="row">
        <div class="col-xs-8">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-header">
              <h5 class="box-title">
                  Tambah Role
              </h5>
            </div>
            <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                ADD NEW ROLE
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

                <div class="form-group">

                      <label for="form-role">Role</label>

                      <input type="text" class="form-control" id="form-role" placeholder="Masukan Role" name="dt[role]" value="<?= $role['role'] ?>">

                </div>
                <div class="form-group">

<label for="form-role">MENU</label>

<!-- <input type="text" class="form-control" id="form-role" placeholder="Masukan Role" name="dt[role]" value="<?= $role['role'] ?>"> -->

<div>

  <!-- <ul> -->

  <?php 

 

  $my_data = $this->mymodel->selectDataOne('user',array('id'=>$_SESSION['id']));
  $roles = $this->mymodel->selectDataOne('role',array('id'=>$my_data['role']));
  // print_r($role);
  $my_menu = (json_decode($roles['menu']));
  $my_menu = join("','",$my_menu);  

  
  $my_menu_sub = (json_decode($roles['menu_sub'],true));

  $menu_sub = (json_decode($role['menu_sub'],true));
  // $my_menu_sub = join("','",$my_menu_sub);  

  $arr = array();
  $arr[0]['id'] = 'add';
  $arr[0]['opt'] = 'ADD';
  $arr[1]['id'] = 'edit';
  $arr[1]['opt'] = 'EDIT';
  $arr[2]['id'] = 'delete';
  $arr[2]['opt'] = 'DELETE';
  
  $this->db->order_by('urutan asc');
  $menu = $this->mymodel->selectWhere('menu_master',"parent = 0 AND status = 'ENABLE' AND id IN ('$my_menu')");

  $menu_user = json_decode($user['menu_item'],true);


  foreach ($menu as $m) {
    $this->db->order_by('urutan asc');
    $this->db->order_by('name asc');
 
  ?>

<a href="javascript::void(0)">

<input type="checkbox" name="menu[]" value="<?= $m['id'] ?>" <?= (in_array($m['id'], json_decode($role['menu']))) ? "checked":"" ?>>

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

<input type="checkbox" name="menu[]" value="<?= $p['id'] ?>" <?= (in_array($p['id'], json_decode($role['menu']))) ? "checked":"" ?>>

<i class="<?= $p['icon'] ?>"></i> <span class="t-title"><?= $p['name'] ?></span>

<?php 
if(in_array($p['id'],array('2055','952','954'))){
foreach($arr as $kopt=>$vopt){
if($my_menu_sub[$p['id']][$vopt['id']]){
?>
<input type="checkbox" name="menu_sub[<?=$p['id']?>][<?=$vopt['id']?>]" value="<?= $p['id'] ?>" <?= $menu_sub[$p['id']][$vopt['id']] ? "checked":"" ?>>
<span class="t-title"><?=$vopt['opt']?></span>
<?php }}} ?>

<br>

</a>
<?php 
$this->db->order_by('urutan asc');
$this->db->order_by('name asc');
$id_parent = $p['id'];
$parent_child = $this->mymodel->selectWhere('menu_master',"parent = '$id_parent' AND status = 'ENABLE' AND id IN ('$my_menu')");
foreach($parent_child as $pc){

 

?>
<a href="javascript::void(0)" style="padding-left:40px;">

<input type="checkbox" name="menu[]" value="<?= $pc['id'] ?>" <?= (in_array($pc['id'], json_decode($role['menu']))) ? "checked":"" ?>>

<i class="<?= $pc['icon'] ?>"></i> <?= $pc['name'] ?> <br>
</a>

<?php } ?>
<?php } ?>
  <?php } ?>


  <!-- </ul> -->

</div>

                </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
                <!-- <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button> -->
             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- /.box -->
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
                    $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
                    form.find(".show_error").slideUp().html("");
                },
                success: function(response, textStatus, xhr) {
                    // alert(mydata);
                   var str = response;
                    if (str.indexOf("success") != -1){
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        setTimeout(function(){ 
                           window.location.href = "<?= base_url('master/role') ?>";
                        }, 1000);
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);


                    }else{
                        form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                        
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                  console.log(xhr);
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    form.find(".show_error").hide().html(xhr).slideDown("fast");

                }
            });
            return false;
    
        });
  </script>