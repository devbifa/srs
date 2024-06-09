



 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        DAILY FTD SCHEDULE

        <small>DATA</small>

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>

        <li class="#">DAILY FTD SCHEDULE</li>

        <li class="active">DATA</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

<form method="POST" action="<?= base_url('master/daily_approval/update') ?>" id="upload-create" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $my_approval['id'] ?>">





  <div class="row">

    <div class="col-md-12">

      <div class="box">

      <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
               EDIT MY APPROVAL
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

        <!-- /.box-header -->
        <!--
        <div class="box-header">

          <h5 class="box-title">

              Edit Approval

          </h5>

        </div>
        -->
        <div class="box-body">

            <div class="show_error"></div>
            <div class="row">
            <div class="col-md-12">
            
            <div class="row">
            <div class="form-group col-md-3">

                  <label for="form-date">DATE</label>

                  <input readonly type="text" class="form-control" id="form-date" placeholder="Masukan Date" name="dt[date]" value="<?= $my_approval['date'] ?>">

              </div><div class="form-group col-md-3">

                  <label for="form-type">TYPE</label>

                  <input readonly type="text" class="form-control" id="form-type" placeholder="Masukan Type" name="dt[type]" value="<?= $my_approval['type'] ?>">

              </div>
              <div class="form-group col-md-6">

                  <label for="form-type">BASE</label>

                  <input readonly type="text" class="form-control" id="form-type" placeholder="Masukan Base" name="dt[base]" value="<?= $my_approval['base'] ?>">

              </div>
            
            <div class="form-group col-md-3">

                  <label for="form-prepared_by">PREPARED BY</label>

                  <select disabled style="width:100%" type="text" class="select2" id="form-approved_by" name="dt[prepared_by]">

                  

<option value="">SELECT PREPARED BY</option>
<?php 
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.name, a.nip, b.role
FROM user a
LEFT JOIN role b
ON a.role_id = b.id
ORDER BY b.role ASC"); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$my_approval['prepared_by']){

$text = "selected";

}

// if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id']."' ".$text." >".$val['role'].' - '.$val['name']."</option>";
// }

}


?>

                  </select>

              </div>
              
              <div class="form-group col-md-3">

                  <label for="form-approved_by">APPROVED BY</label>

                  <select disabled style="width:100%"  type="text" class="select2" id="form-approved_by" name="dt[approved_by]">

                  

<option value="">SELECT APPROVED BY</option>
<?php 
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.name, a.nip, b.role
FROM user a
LEFT JOIN role b
ON a.role_id = b.id
ORDER BY b.role ASC"); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$my_approval['approved_by']){

$text = "selected";

}

// if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id']."' ".$text." >".$val['role'].' - '.$val['name']."</option>";
// }

}


?>


                  </select>

              </div>
              
              
              <!-- <div class="form-group col-md-3">

                  <label for="form-approved_by">APPROVED BY 2</label>

                  <select style="width:100%"  type="text" class="select2" id="form-approved_by" name="dt[approved_by_2]">

                  

<option value="">APPROVED BY 2</option>
<?php 
$instructor = $this->mymodel->selectWithQuery("SELECT a.id, a.name, a.nip, b.role
FROM user a
LEFT JOIN role b
ON a.role_id = b.id
ORDER BY b.role ASC"); 

foreach ($instructor as $val) {

$text="";

if($val['id']==$my_approval['approved_by_2']){

$text = "selected";

}

// if (strpos($val['type'], 'FLIGHT') !== false) {
echo "<option value='".$val['id']."' ".$text." >".$val['role'].' - '.$val['name']."</option>";
// }

}


?>

                  </select>

              </div> -->
              
     
              <div class="form-group col-md-12">

              <label for="form-approval_status">REMARK</label>

              <textarea type="text" class="form-control" id="form-approval_status" placeholder="Masukan Remark" name="dt[remark]"><?= $my_approval['remark'] ?></textarea>

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
            <button type="submit" class="btn btn-primary btn-send float-1" ><i class="fa fa-save"></i></button>


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

                       window.location.href = "<?= base_url('master/daily_approval') ?>";

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