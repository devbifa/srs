
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>USER</title>
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



<body>
  
      <h1>

      USER

  
      </h1>


           

            <div class="box-header" style="display:block!important;">

              <div class="<?=$header?>">

                


                </div>  

              </div>

              

            </div>

            <?php $curriculum_id = $curriculum['code']; ?>

            <?php
            // echo $type;
              if($type=='ground'){
                $bg = 'bg-success';
              }else if($type=='sim'){
                $bg = 'bg-warning';
              }else if($type=='flight'){
                $bg = 'bg-danger';
              }else if($type=='others'){
                $bg = 'bg-default';
              }
             
            ?>
            <div class="box-body">
<table>
  <tr>
  <th style="width:20px">NUM</th><th>ROLE</th><th>USERNAME</th><th>FULL NAME</th><th>NICK NAME</th><th>EMAIL</th><th>CAPABILITY</th><th>SUBJECT</th><th>POSITION</th><th>BASE</th><th>STATUS</th>
                   
  </tr>
  <?php foreach($data as $key=>$val){
     $val['type'] = json_decode($val['type'],true);
    //  print_r($val['type']);
     $t = '';
     foreach($val['type'] as $k=>$v){
       if($v['GROUND']){
        $t .='GROUND, ';
       }
       if($v['FTD']){
        $t .='FTD, ';
       }
       if($v['FLIGHT']){
        $t .='FLIGHT, ';
       }
       
     }
     $val['type'] = substr($t,0,-2); 
    ?>
    <tr>
    <td><?=$key+1?><td><?=$val['role']?></td><td><?=$val['id_number']?></td><td><?=$val['full_name']?></td><td><?=$val['nick_name']?></td><td><?=$val['email']?></td>
                    <td><?=$val['type']?></td>
                    <td><?=$val['remark_instructor']?></td>
                    <td><?=$val['position']?></td>
                    <td><?=$val['base']?></td>
                    <td><?=$val['status']?></td>
    </tr>
    <?php } ?>
</table>
            
 

              
              
             

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



  </body>
