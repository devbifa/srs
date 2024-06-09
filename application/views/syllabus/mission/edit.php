

<a href="#!" class="btn btn-danger float-2" href="#!" data-toggle="modal" data-target="#modal-deletes" data-placement="top" title="DELETE USER DATA"><i class="mdi mdi-delete-forever"></i></a>
<div class="modal modal-danger fade" id="modal-deletes">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">DELETE DATA</h4>
      </div>
      <div class="modal-body" style="color:#fff!important;">
        <form action="<?=base_url()?>syllabus/mission/delete/<?=$data['id']?>">
        <span style="font-weight:100">Are you sure you want to delete this data?</span>
      
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

    <form method="POST" action="<?= base_url('syllabus/mission/update') ?>" id="upload-create" enctype="multipart/form-data">



      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT SYLLABUS MISSION
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

                  <label for="form-classroom">CODE</label>

                  <input type="hidden" class="form-control" name="id" value="<?= $data['id'] ?>">
                  <input type="text" class="form-control" id="form-classroom" placeholder="Fill Code" name="dt[code]" value="<?= $data['code'] ?>">

                  </div>
                  <div class="form-group col-md-3">
                  <label for="form-classroom">CODE NAME</label>
                  <input type="text" class="form-control" id="form-classroom" placeholder="Fill Code Name" name="dt[code_name]" value="<?= $data['code_name'] ?>">
                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-classroom">NAME</label>

                      <input type="text" class="form-control" id="form-classroom" placeholder="Fill Name" name="dt[name]" value="<?= $data['name'] ?>">

                  </div><div class="form-group col-md-3">

<label for="form-remark">DESCRIPTION</label>

<input type="text" class="form-control" id="form-remark" placeholder="Fill Description" name="dt[description]" value="<?= $data['description'] ?>">

</div><div class="form-group col-md-3">

<label for="form-remark">POSITION</label>

<input type="number" class="form-control" id="form-remark" placeholder="Fill Position" name="dt[position]" value="<?= intval($data['position']) ?>">

</div>

<div class="form-group col-md-3">

<label for="form-remark">TYPE</label>

<input type="text" class="form-control" id="form-remark" placeholder="Fill Type" name="dt[type]" value="<?= ($data['type']) ?>">

</div>
<div class="form-group col-md-3">

<label for="form-remark">TYPE SUB</label>

<input type="text" class="form-control" id="form-remark" placeholder="Fill Type Sub" name="dt[type_sub]" value="<?= ($data['type_sub']) ?>">

</div>

                  <div class="form-group col-md-3">

                  <label for="form-classroom">TYPE OF TRAINING</label>
                  <select name="dt[type_of_training]" id="type_of_training" class="form-control select2">
                  <option value="">SELECT TYPE OF TRAINING</option>
                  <?php
                  $this->db->order_by('position ASC');
                  $arr = $this->mymodel->selectWhere("syllabus_type_of_training",null);
                  foreach($arr as $k=>$v){
                    $selected = '';
                    if($v['code'] == $data['type_of_training']){
                      $selected = 'selected';
                    }
                  ?>
                  <option <?=$selected?> value="<?=$v['code']?>"><?=$v['name']?></option>
                  <?php } ?>
                  </select>
                  </div>
                  <div class="form-group col-md-3">
                  <label for="form-classroom">COURSE</label>
                  <select name="dt[course]" id="course" class="form-control select2">
                  <option value="">SELECT COURSE</option>
                  <?php
                  
                  $this->db->order_by('position ASC');
                  $qry = '"'.$data['type_of_training'].'":{"status":"ON"}';
                  $arr = $this->mymodel->selectWithQuery("SELECT *
                  FROM syllabus_course
                  WHERE type_of_training LIKE '%$qry%'
                  ORDER BY position ASC");
                
                  foreach($arr as $k=>$v){
                    $selected = '';
                    if($v['code'] == $data['course']){
                      $selected = 'selected';
                    }
                  ?>
                  <option <?=$selected?> value="<?=$v['code']?>"><?=$v['code']?> - <?=$v['name']?></option>
                  <?php } ?>
                  </select>
                  </div>

                  <script>
                    $(document).ready(function(){
                        $('#type_of_training').change(function() {
                              var type = $('#type_of_training').val();
                              $("#course").html('<option>LOADING...</option>');
                              if(type){
                                  $.ajax({
                                      url:'<?=base_url()?>syllabus/mission/get_course?type='+type,
                                      success:function(html){
                                        $("#course").html(html);
                                      }
                                  }); 
                              }else{
                                $("#course").html('');
                              }
                          
                          });

                    });
                  </script>
                  <div class="form-group col-md-3">

                      <label for="form-file">FILE</label>

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

                  </div></div></div>
  
  <div class="col-md-6">
  
  <div class="row">
  
  </div>
  </div>
  </div>
                <button type="submit" class="btn btn-primary btn-send float-1"  data-placement="top" title="SAVE CLASS ROOM DATA" ><i class="mdi mdi-content-save"></i></button>


             



            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

        </div>

        <!-- /.col -->

        </div></div>

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

                           window.location.href = "<?= base_url('syllabus/mission') ?>";

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