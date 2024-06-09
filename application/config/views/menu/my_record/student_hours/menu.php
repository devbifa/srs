<?php
$uri = $this->uri->segment(3);
$btn_1 = 'btn-default';
$btn_2 = 'btn-default';
$btn_3 = 'btn-default';
if($uri==''){
  $btn_1 = 'btn-primary';
}else if($uri=='progress'){
  $btn_2 = 'btn-primary';
}else if($uri=='detail'){
  $btn_3 = 'btn-primary';
}
?>
<a class="btn <?=$btn_1?>" href="<?=base_url()?>menu/my_record">GENERAL</a>
<a class="btn <?=$btn_2?>" href="<?=base_url()?>menu/my_record/progress">PROGRESS</a>
<a class="btn <?=$btn_3?>" href="<?=base_url()?>menu/my_record/detail">DETAIL</a>
