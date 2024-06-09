<?php
$uri = $this->uri->segment(3);
$student['id'] = $this->uri->segment(4);
$btn_1 = 'btn-default';
$btn_2 = 'btn-default';
$btn_3 = 'btn-default';
$btn_4 = 'btn-default';
if($uri=='student_rev'){
  $btn_1 = 'btn-primary';
}else if($uri=='student'){
  $btn_2 = 'btn-primary';
}else if($uri=='student_detail'){
  $btn_3 = 'btn-primary';
}else if($uri=='student_course'){
  $btn_4 = 'btn-primary';
}
?>
<a class="btn <?=$btn_1?>" href="<?=base_url()?>record/student_hours/student_rev/<?=$student['id']?>">GENERAL</a>
<a class="btn <?=$btn_2?>" href="<?=base_url()?>record/student_hours/student/<?=$student['id']?>">PROGRESS</a>
<a class="btn <?=$btn_3?>" href="<?=base_url()?>record/student_hours/student_detail/<?=$student['id']?>">DETAIL</a>
<a class="btn <?=$btn_4?>" href="<?=base_url()?>record/student_hours/student_course/<?=$student['id']?>">TRAINING REQUIREMENT COURSE</a>
