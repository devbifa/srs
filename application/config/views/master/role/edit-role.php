<style>
li{
  margin-left:15px;
}
  </style>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Role

        <small>Master</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="javascript::void(0)"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="javascript::void(0)">master</a></li>

        <li class="active">Role</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/role/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $role['id'] ?>">





      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

            <div class="box-header">

              <h5 class="box-title">

                  Edit Role

              </h5>

            </div>

            <div class="box-body">

                <div class="show_error"></div>

                <div class="form-group">

                      <label for="form-role">Role</label>

                      <input type="text" class="form-control" id="form-role" placeholder="Masukan Role" name="dt[role]" value="<?= $role['role'] ?>">

                </div>

                <div class="form-group">

                      <label for="form-role">Menu</label>

                      <!-- <input type="text" class="form-control" id="form-role" placeholder="Masukan Role" name="dt[role]" value="<?= $role['role'] ?>"> -->

                      <div>

                        <!-- <ul> -->

                        <?php 

                        $this->db->order_by('urutan asc');

                        $menu = $this->mymodel->selectWhere('menu_master',['parent'=>0,'status'=>'ENABLE']);

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
 $parent = $this->mymodel->selectWhere('menu_master',['parent'=>$m['id'],'status'=>'ENABLE']);
  foreach($parent as $p){
?>
<a href="javascript::void(0)" style="padding-left:20px;">

<input type="checkbox" name="menu[]" value="<?= $p['id'] ?>" <?= (in_array($p['id'], json_decode($role['menu']))) ? "checked":"" ?>>

<i class="<?= $p['icon'] ?>"></i> <?= $p['name'] ?><br>

</a>
<?php 
$this->db->order_by('urutan asc');
$this->db->order_by('name asc');
$parent_child = $this->mymodel->selectWhere('menu_master',['parent'=>$p['id'],'status'=>'ENABLE']);
foreach($parent_child as $pc){
?>
<a href="javascript::void(0)" style="padding-left:40px;">

<input type="checkbox" name="menu[]" value="<?= $pc['id'] ?>" <?= (in_array($pc['id'], json_decode($role['menu']))) ? "checked":"" ?>>

<i class="<?= $pc['icon'] ?>"></i> <?= $pc['name'] ?><br>

</a>
<?php } ?>
<?php } ?>
                        <?php } ?>


                        <!-- </ul> -->

                      </div>

                </div>

                <div class="form-group">

                      <label for="form-role">Sub Role</label>

                      <?php 
                      $sub_role = $this->mymodel->selectWithQuery("SELECT * FROM role ORDER BY role ASC");
                      foreach($sub_role as $key=>$val){
                      ?>
                      <br>
                      <input type="checkbox" name="sub_role[]" value="<?=$val['id']?>" <?= (@in_array($val['id'], json_decode($role['sub_role']))) ? "checked":"" ?> > <?= $val['role'] ?>
                      <?php } ?>
                </div>

                <div class="form-group">

                <label for="form-role">Email Notification Status</label>

                <?php 
                $sub_role = $this->mymodel->selectWithQuery("SELECT * FROM authorize_approval ORDER BY val ASC");
                foreach($sub_role as $key=>$val){
                ?>
                <br>
                <input type="checkbox" name="email_notification[]" value="<?=$val['id']?>" <?= (@in_array($val['id'], json_decode($role['email_notification']))) ? "checked":"" ?> > <?= $val['val'] ?>
                <?php } ?>
                </div>

                </div>

            <!-- <div class="box-footer"> -->
              <!-- <div class="col-md-12"> -->
                <button type="submit" class="btn btn-primary btn-send float-1" ><i class="fa fa-save"></i></button>

                <!-- <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button> -->

                <!-- </div> -->

            <!-- </div> -->

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

                    $(".btn-send").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>").attr('disabled',true);

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

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i>').attr('disabled',false);





                    }else{

                        form.find(".show_error").hide().html(response).slideDown("fast");

                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i>').attr('disabled',false);

                        

                    }

                },

                error: function(xhr, textStatus, errorThrown) {

                  console.log(xhr);

                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i>').attr('disabled',false);

                    form.find(".show_error").hide().html(xhr).slideDown("fast");



                }

            });

            return false;

    

        });

  </script>