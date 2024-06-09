
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>STUDENT STATUS</title>
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

        STUDENT STATUS

      

      </h1>

      <table>
        <tr>
        <th style="width:20px">No</th><th>BATCH</th><th class="text-center">FULL NAME</th><th class="text-center">NICK NAME</th><th>ID NUMBER</th><th>EMAIL</th><th>SPL NUMBER</th><th>PPL NUMBER</th><th>CPL NUMBER</th><th>CURRICULUM</th><th>REMARK</th>       <th style="min-width:50px">STATUS</th>
        </tr>
        <?php
        foreach($data as $key=>$val){ ?>
<tr>
<td><?=$key+1?></td>
                    <td><?=$val['batch']?></td>
                    <td><?=$val['full_name']?></td>
                    <td><?=$val['nick_name']?></td>
                    <td><?=$val['id_number']?></td>
                    <td><?=$val['email']?></td>
                    <td><?=$val['spl_number']?></td>
                    <td><?=$val['ppl_number']?></td>
                    <td><?=$val['cpl_number']?></td>
                    <td><?=$val['curriculum']?></td>
                    <td><?=$val['remark']?></td>
                    <td><?=$val['status']?></td>
</tr>
        <?php } ?>
      </table>




  </body>


                    
                 