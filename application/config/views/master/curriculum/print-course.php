<?php
$uri = $this->uri->segment(4);
$curriculum = $this->mymodel->selectDataOne('curriculum',array('code'=>$uri));
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=($curriculum['curriculum'])?> </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

</head>
<style>

body,html, *{
  padding:0px;
  margin:0px;
  font-family: Tahoma, Geneva, sans-serif;
}
table{
  border-collapse: collapse !important;
  margin-bottom:15px;
  width:100%;
}
.no-border{
  border:#fff solid 1px;
}
p,th,td,tr{
    font-family: Tahoma, Geneva, sans-serif;
   }
   h1{
     font-weight:700;
     font-size:25px;
     font-family: "Times New Roman", Times, serif;
   }
   
		table tr td {
			vertical-align: top;
      
		}
	
    .text-center{
      text-align:center;
    }
    .border-full{
      border:1px #000 solid;
      padding:5px;
    }
    .border-full2{
      /* border:1px #000 solid; */
      padding:5px;
      /* padding-top:5px; */
      /* padding-bottom:5px; */
    }
    
    td,th{
      padding:15px;
    }
    .text-right{
      text-align:right;
    }.text-left{
      text-align:left;
    }
    p,tr,td,th,div{
      font-size:14px;
    }
    .bg-primary{
      background:#333a54;
      color:#fff;
    }
    th{
      text-align:center;
      padding:5px;
    }
    td{
      padding:5px;
    }

    #left {
    width: 1%;
    /* background: lightblue; */
    display: inline-block;
    float:left;
}
#right {
    width: 60%;
    /* background: orange; */
    display: inline-block;
    float:left;
}
#right2 {
    width: 33%;
    /* background: orange; */
    display: inline-block;
    float:left;
}
td,th{
  border:1px #000 solid;
}

@media print and (color) {
   * {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
   }
}
    
    body{
      margin:15px;
    }
    td{
      text-align:center;
    }
</style>

 <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">

    <!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

      CURRICULUM : <?=$curriculum['curriculum']?>


      </h1>

    

    </section>

    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          <div class="box">

            <!-- /.box-header -->

           
            <div class="box-body">

          

              <div class="row">

                
         


            
            <div class="box-body">

                <div class="show_error"></div>



              <div class="table-responsive">

              <table class="table table-bordered" id="mytable">
                <tr class="bg-orange">
                  <th>NUM</th>
                  <!-- <th>CURRICULUM</th> -->
                  <th>CODE</th>
                  <th>COURSE CODE</th>
                  <th>COURSE</th>
                  <th>TYPE OF TRAINING</th>
                </tr>

                <?php 
                foreach($course as $key=>$val){
                  $configuration = "";
                  $text = json_decode($val['configuration'],true);
                  foreach($text as $key2=>$val2){
                    if($val2['val']>0){
                      $data = $this->mymodel->selectDataOne('training_type', array('id'=>$val2['val']));
                      if($data){
                        $configuration .= $data['training_type'].', ';
                      }
                    }else{
                      $configuration .= $val2['val'].', ';
                    }
                   
                  }
                  $configuration = substr($configuration,0,-2);
                  ?>
                  <tr class="bg-blue">
                  <td><?=$key+1?></td>
                  <td><?=$val['code']?></td>
                  <td><?=$val['course_code']?></td>
                  <td><?=$val['course_name']?></td>
                  <td class="text-left"><?=$configuration?></td>
                </tr>
                <?php } ?>
              </table>

              </div>

            </div>

            <!-- /.box-body -->

          </div>

          <!-- /.box -->

        </div>

        <!-- /.col -->

      </div>

      <!-- /.row -->

    </section>

    <!-- /.content -->

  </div>

  <!-- /.content-wrapper -->




      </div>

    </div>

  </div>


