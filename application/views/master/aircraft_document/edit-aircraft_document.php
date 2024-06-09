<?php

$inspection_type = $this->mymodel->selectWithQuery("SELECT * FROM inspection_type ORDER BY inspection_number ASC");



?>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        AIRCRAFT DOCUMENT

        <small>EDIT</small>

      </h1>

      <ol class="breadcrumb">

      <li><a href="#"><i class="fa fa-dashboard"></i> HOME</a></li>


      <li class="#">AIRCRAFT DOCUMENT</li>

      <li class="active">EDIT</li>

      </ol>

    </section>

    <!-- Main content -->

    <section class="content">
    <button form="upload-create" type="submit" class="btn btn-primary btn-send float-1"  data-placement="top" title="SAVE AIRCRAFT DATA"><i class="mdi mdi-content-save"></i></button>

    <form method="POST" action="<?= base_url('master/aircraft_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $aircraft_document['id'] ?>">

      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
                EDIT AIRCRAFT DOCUMENT <?=$aircraft_document['serial_number']?>
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

                      <label for="form-model">MODEL</label>

                      <input type="text" class="form-control" id="form-model" placeholder="Fill Model" name="dt[model]" value="<?= $aircraft_document['model'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-type">TYPE</label>

                     
<select style='width:100%' name="dt[type]" class="form-control select2">

<?php 

$curriculum = $this->mymodel->selectWhere('aircraft_type',null);

foreach ($curriculum as $curriculum_record) {

  $text="";

  if($curriculum_record['aircraft_type']==$aircraft_document['type']){

    $text = "selected";

  }



  echo "<option value='".$curriculum_record['aircraft_type']."' ".$text." >".$curriculum_record['aircraft_type']."</option>";

}

?>

</select>


                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-serial_number">SERIAL</label>

                      <input type="text" class="form-control" id="form-serial_number" placeholder="Fill Serial Number" name="dt[serial_number]" value="<?= $aircraft_document['serial_number'] ?>">

                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-registration">REGISTRATION</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[registration]" value="<?= $aircraft_document['registration'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">SERIAL NUMBER</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[serial]" value="<?= $aircraft_document['serial'] ?>">

                  </div>

                  <div class="form-group col-md-3">

                      <label for="form-registration">ENGINE NUMBER</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[engine]" value="<?= $aircraft_document['engine'] ?>">

                  </div>

                  <div class="form-group col-md-3">

                      <label for="form-registration">PROP NUMBER</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[prop]" value="<?= $aircraft_document['prop'] ?>">

                  </div>

                  <div class="form-group col-md-3">

                      <label for="form-registration">USG</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[usg]" value="<?= $aircraft_document['usg'] ?>">

                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-registration">WEIGHT</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[weight]" value="<?= $aircraft_document['weight'] ?>">

                  </div>
                  <div class="form-group col-md-3">

                      <label for="form-registration">FUEL</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[fuel]" value="<?= $aircraft_document['fuel'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">MIX</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[mix]" value="<?= $aircraft_document['mix'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">NF</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[nf]" value="<?= $aircraft_document['nf'] ?>">

                  </div>
                  
                  <div class="form-group col-md-3">

                      <label for="form-registration">AVIONIC</label>

                      <input type="text" class="form-control" id="form-registration" placeholder="" name="dt[avionic]" value="<?= $aircraft_document['avionic'] ?>">

                  </div>

                  <div class="form-group col-md-3">

<label for="form-type">STATUS</label>


<select style='width:100%' name="dt[status]" class="form-control select2">

<?php 

$curriculum = $this->mymodel->selectWhere('aircraft_status',null);

foreach ($curriculum as $curriculum_record) {

$text="";

if($curriculum_record['aircraft_status']==$aircraft_document['status']){

$text = "selected";

}



echo "<option value='".$curriculum_record['aircraft_status']."' ".$text." >".$curriculum_record['aircraft_status']."</option>";

}

?>

</select>


</div>

                 



                  <div class="form-group col-md-3">

                      <label for="form-file">FILE </label>  
                      
                      <?php

                  if($file['dir']!=""){ ?>
                    <a href="<?= base_url($file['dir']) ?>" target="_blank"><i class="fa fa-download"></i> <?= $file['name'] ?></a>


                <?php } ?>
                     

                      <input type="file" class="form-control" id="form-file" placeholder="Fill File" name="file">

                  </div>
                
       

                </div></div>
  
  </div>
            <div class="box-footer">
            <div class="col-md-12">
            <div class="row">
              
            

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


      

      <div class="row">
		  
		  <div class="col-md-12">

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
  <th style="width:75px;" >START
  </th>
  <th style="width:75px;" >UNTIL
  </th>
</tr>
<?php
$attachment_list = $this->mymodel->selectWithQuery("SELECT * FROM aircraft_file WHERE status = 'ENABLE' ORDER BY number ASC");
$att = json_decode($aircraft_document['attachment'],true);
// print_r($att);

$i = 0;

$price = array();
// // foreach ($attachment_list as $key => $row)
// // {
// //     $price[$key] = $row['number'];
// // }
// array_multisort($price, SORT_ASC, $attachment_list);
// print_r($attachment_list);

foreach($attachment_list as $key=>$val){
 
    // echo $val['number'];
    // $data = $this->mymodel->selectDataOne('aircraft_file',array('id'=>$val['type']));
    
?>
<tr>
<td class="text-left" style="width:25px;" >
<?=$i+1?>
</td>
<td class="text-left">
<?=$val['aircraft_file']?>
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
<a href="<?=base_url()?>webfile/aircraft_file/<?=$att[$val['id']]['file']?>" target="_blank" class="btn btn-delete btn-xs btn-info"><i class="mdi mdi-eye"></i></a>
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
               <form action="<?=base_url()?>master/aircraft_document/update_file/<?=$aircraft_document['id']?>/<?=$val['id']?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Attachment Type</label>
                <input readonly autocomplete="off" required required type="text" class="form-control" name="dtt[type]" value="<?=$val['aircraft_file']?>">
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
                <span style="font-weight:100">Are you sure you want to delete this data?</span>
               </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
                <a type="button" class="btn btn-outline" href="<?=base_url()?>master/aircraft_document/delete_file/<?=$aircraft_document['id']?>/<?=$val['id']?>">Delete Now</a>
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
  
            <!-- /.box-body -->

          </div>

          <!-- /.box -->



          <!-- /.box -->

          </div>
          </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

     
      <div class="modal modal-success fade" id="modal-upload">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UPLOAD ATTACHMENT FILE</h4>
              </div>
              <div class="modal-body" style="color:#fff!important;">
               <form action="<?=base_url()?>master/aircraft_document/upload_file/<?=$aircraft_document['id']?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Attachment Type</label>
                <select required style="width:100%;" class="select2" name="dtt[type]">
<option value="">SELECT ATTACHMENT
</option>
<?php foreach($attachment as $key2=>$val2){ ?>
<option value="<?=$val2['id']?>"><?=$val2['aircraft_file']?>
</option>
<?php } ?>
</select>    
            </div>
<div class="form-group">
                <label>Valid Date Start</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_start]">
                </div>
<div class="form-group">
                <label>Valid Date Until</label>
                <input autocomplete="off" required required type="text" class="form-control tgl" name="dtt[valid_date_until]">
                </div>
<div class="form-group">
                <label>Attachment Number</label>
                <input autocomplete="off" requiredrequired type="text" class="form-control" name="dtt[number]">
                </div>
                <div class="form-group">
                <label>Description</label>
                <input autocomplete="off" required required type="text" class="form-control" name="dtt[description]">
                </div>
<div class="form-group">
                <label>Attachment File</label>
                <input required type="file" class="form-control" name="file">
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



        <style>
.table-striped{
    display: block!important;
    width:100%;
    overflow-y: scroll!important;
    height: 500px!important;
}
table {
  /* Not required only for visualizing */
  border-collapse: collapse;
  width: 100%;
}

.th1 {
  /* Important */
  background:#066265;
  position: sticky;
  z-index: 100;
  top: 0px;
}

.th2 {
  /* Important */
  background:#066265;
  position: sticky;
  z-index: 100;
  top: 36px;
}

td {
  /* Not required only for visualizing */
  padding: 1em;
}
</style>

      
      
      
      
      <a href="" class="btn btn-danger float-2" href="#!" data-toggle="modal" data-target="#modal-delete-x"  data-placement="top" title="DELETE AIRCRAFT DATA"><i class="mdi mdi-delete"></i></a>
         
         <div class="modal modal-danger fade" id="modal-delete-x">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">DELETE DATA</h4>
               </div>
               <div class="modal-body" style="color:#fff!important;">
                <form action="<?=base_url()?>master/aircraft_document/delete/<?=$aircraft_document['id']?>">
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

                          //  window.location.href = "<?= base_url('master/aircraft_document') ?>";
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