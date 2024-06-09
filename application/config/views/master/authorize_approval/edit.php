

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        BASE AIRPORT DOCUMENT

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">BASE AIRPORT DOCUMENT</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/authorize_approval/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $authorize_approval['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT AUTHORIZE APPROVAL
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
                <div class="form-group col-md-12">

                      <label for="form-base">APPROVAL FOR</label>

                      <input readonly type="text" class="form-control" id="form-base" placeholder="Masukan Type" value="<?= $authorize_approval['val'] ?>">

                  </div>
                  
                  <div class="form-group col-md-12">

                      <label for="form-role_id">POSITION</label>

                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <tr class="bg-success">
                            <th class=" text-left" style="width:150px;">
                              BASE
                            </th>
                            <th class=" text-left">
                              USER
                            </th>
                          </tr>
                      <?php
                  $json_setting = json_decode($authorize_approval['json_setting'],true);
                  
                  $base = $this->mymodel->selectWithQuery("SELECT * FROM base_airport_document ORDER BY base ASC");
                  foreach($base as $key=>$val){
                  ?>
                    <tr>
                      <td class="text-left">
                        <input type="text" class="form-control" readonly name="json_setting[<?=$val['base']?>][base]" value="<?=$val['base']?>">
                      </td>
                      <td class="text-left">
                      <select style='width:100%' name="json_setting[<?=$val['base']?>][user]" class="form-control select2">
                      <option value="">SELECT USER</option>

<?php 



// $this->db->order_by('role ASC');
$this->db->order_by('full_name ASC');
$base = $val['base'];
$role = $this->mymodel->selectWhere('user',"status='ACTIVE' AND role IN ('1','2','3') AND (base='$base' OR role IN ('1','2'))");

foreach ($role as $role_record) {

  $role = $this->mymodel->selectDataOne('role',array('id'=>$role_record['role']));
  $text="";

  if($role_record['id']==$json_setting[$val['base']]['user']){

    $text = "selected";

  }

  echo "<option value='".$role_record['id']."' ".$text." >".$role_record['full_name']." (".$role_record['id_number'].") ".$role['role']."</option>";

}

?>

</select>
                      </td>
                    </tr>
                  <?php } ?>
                  </table>
                  </div>
                  </div>
                  

                 
        
                  
              </div></div>
  
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
                <button type="submit" class="btn btn-primary btn-send float-1" data-placement="top" title="SAVE"  ><i class="mdi mdi-content-save"></i></button>


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

                           window.location.href = "<?= base_url('master/authorize_approval') ?>";

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