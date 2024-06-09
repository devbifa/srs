  <div class="content-wrapper">


    <!-- Main content -->

    <section class="content">

    <form method="POST" action="<?= base_url('master/Student_document/update') ?>" id="upload-create" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $student_document['id'] ?>">





      <div class="row">

        <div class="col-md-12">

          <div class="box">

          <div class="box-header-material box-header-material-text">
                <div class="row">
                <div class="col-xs-10">
               DAILY NEWS DETAIL
                </div>
                <div class="col-xs-2">
                    <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                </div>
            </div>

            <div class="box-body" style="min-height:500px;">
            <div class="row">
                <div class="col-md-8">
                <h3><?=$detail['title']?></h3>
              
                <?php 
                $user = $this->mymodel->selectDataOne('user',array('id'=>$detail['created_by']));
                $image = $this->mymodel->selectDataOne('file',array('table'=>'news','table_id'=>$detail['id']));
                if($image['name']){
                    $image = $image['name'];
                  
                }else{
                    $image = 'no_image.png';
                }
                ?>
                
                <image src="<?=base_url('webfile/').$image?>" style="width:100%;">
                
                <br><br>
                <i class="mdi mdi-calendar-clock"></i> <?=DATE('d M Y',strtotime($detail['date']))?>
                <i class="mdi mdi-pencil"></i> <?=$user['full_name']?>
                <br><br>
                <?=$detail['content']?>
                </div>
                <div class="col-md-4">
                <h3>RECENT NEWS</h3>
                <div class="row">
                    <?php
                    foreach($other as $key=>$val){

                        
				if(strlen($val['title']) > 37 ){ 
					$val['title'] = substr($val['title'],0,37).'...'; 
				}else{ 
					$val['title'] = $val['title']; 
				}


                        $image = $this->mymodel->selectDataOne('file',array('table'=>'news','table_id'=>$val['id']));
                        if($image['name']){
                            $image = $image['name'];
                          
                        }else{
                            $image = 'no_image.png';
                        }
                    ?>
<a href="<?=base_url()?>news/detail/<?=$val['date']?>/<?=$val['id']?>" >
				<div class="col-md-12" style="margin-bottom:15px;">
				<div class="box">
					<img class="img-even" src="<?=base_url('webfile/').$image?>" style="height: 250px; width: 100%; object-fit: cover; display: inline;">
					<div class="box-body">
						<div class="row">
							<div class="col-md-12" align="center">
							<p style="font-size:17px;color:#066265"><?=$val['title']?></p>
							<p style="color:#066265"><i class="mdi mdi-calendar-clock"></i> <?=DATE('d M Y',strtotime($val['date']))?></p>
							<p style="color:#066265"><i class="mdi mdi-pencil"></i><?=($user['full_name'])?></p>
							</div>
						</div>
					</div>
				</div>
				</div>
				</a>
                    <?php } ?>
                </div>
				</div>
            </div>
            </div>
           
           
    </section>

    <!-- /.content -->

  </div>
