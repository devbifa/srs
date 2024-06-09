<?php 
$event = $this->mymodel->selectWithQuery("SELECT * FROM event WHERE event_utama='IYA' ORDER BY id DESC LIMIT 1");
$id = $event[0]['id'];
 $tanggals= $event[0]['tanggal_penutupan'];
$file = $this->mymodel->selectDataone('file',  array('table_id' => $id, 'table' => 'event'));
?>
<div class="content">
  <div class="">
    <div class="row">
      <div class="col-md-12" align="center">
        <!--<h1><b>Event Terbaru</b></h1>-->
      </div>
      <div class="col-md-9">
        <div class="row" align="center">
          <div class="col-md-12">
            <a href="<?= base_url("event-detail/") .$this->template->sonEncode(($event[0]['id']))?>" class="a_black">
              <div class="box">
                <?php
                // if ($event['0']['statusEvent'] == 'BERJALAN') {
                //   echo '<span class="label_status bg-yellow round right" style="margin-left:5px">BERJALAN</span>';
                // } else if ($event['0']['statusEvent'] == 'SELESAI') {
                //   echo '<span class="label_status bg-green round right" style="margin-left:5px">SELESAI</span>';
                // } else if ($event['0']['statusEvent'] == 'BATAL') {
                //   echo '<span class="label_status bg-red round right" style="margin-left:5px">DIBATALKAN</span>';
                // } else {
                //   echo '<span class="label_status bg-blue round right" style="margin-left:5px">DIBUKA</span>';
                // }
                ?>
                <img src="<?=base_url()?>admin-side/webfile/<?= $file['name'] ?>" class="main-event" style="height:527px;border-radius:15px;">
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
              <a class="a_black">
                <div class="box"  style="background-color:#13375C;color:#FFCC00;height:190px;">
                  <div class="row">
                    <div class="col-md-12" style="padding:15px;">
                        <h4>2020 REGISTRATIONS ARE OPEN</h4>
                        <br>
                        <h4>Countdown Closed Until The On <br><?= date('d M Y', strtotime($event[0]['tanggal_penutupan'])) ?></h4>
<br>                    

                        <div style="text-align:center;">
                            <div class="row text-center;" id="clockdiv">
                            <div class="col-md-3">
                                <h5 class="days">00</h5>
                                <p style="font-size:11px;text-align:center;">DAYS</p>
                            </div>
                            <div class="col-md-3">
                                <h5 class="hours">00</h5>
                                <p style="font-size:11px;text-align:center;">HOURS</p>
                            </div>
                            <div class="col-md-3">
                               <h5 class="minutes">00</h5>
                                <p style="font-size:11px;text-align:center;">MINUTES</p>
                            </div>
                            <div class="col-md-3">
                                <h5 class="seconds">00</h5>
                                <p style="font-size:11px;text-align:center;">SECONDS</p>
                            </div>
                             </div>
                        </div>

                    </div>
                  </div>
                </div>
              </a>
            </div>
            
            
            <div class="col-md-12">
              <a class="a_black">
                <div class="box"  style="background-color:#FFCC00;color:#13375C;height:130px;">
                  <div class="row">
                    <div class="col-md-12" style="padding:15px;">
                        <h4>
                            <b><a href="<?= base_url("event-detail/") . $this->template->sonEncode(($event[0]['id'])) ?>">REGISTER NOW!</a></b>
                          <br><br>
                             </h4>
                              <h4>
                            ON
                            <br>
                            <b><?=$event['0']['nama_event']?></b>
                        </h4>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            
             <div class="col-md-12">
              <a class="a_black">
                <div class="box"  style="background-color:#fff;color:#13375C;">
                  <div class="row">
                    <div class="col-md-12" style="padding:15px;">
                        <h4>
                           <b>EVENT START ON</b>
                        </h4>
                        <?= date('d M Y', strtotime($event[0]['tanggal_mulai'])) ?> Until <?= date('d M Y', strtotime($event[0]['tanggal_selesai'])) ?>
                        <br>
                        <?= $event[0]['lokasi_event'] ?>
                         <h4>
                        <br>
                           <b><a href="<?= base_url("event/champions/") . $this->template->sonEncode(strtolower($event[0]['id'])) ?>" style="color:#13375C;">WHO ARE THE CHAMPIONS</a></b>
                           <br><br>
                           <b><a target="_blank" href="<?=$event[0]['live_event']?>" style="color:#13375C;">CHECK LIVE EVENT NOW!</a></b>
                        </h4>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            
            
        </div>
      </div>
      
      <div class="col-md-12" style="margin-top:5px;">
        <div class="row">
		  	<?php
$events = $this->mymodel->selectWithQuery("SELECT * FROM event WHERE id!='$id' ORDER BY event_utama ASC, tanggal_mulai DESC LIMIT 6");
foreach ($events as $row) {
	$photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'event'));
	
	if(empty($photo)){
		$photo['dir'] = base_url().'webfile/no_image.png';
	}else{
		$photo['dir'] = base_url().'admin-side/'.$photo['dir'];
	}
	$pendaftar = $this->mymodel->selectWithQuery("SELECT count(id) as pendaftar from pendaftaran WHERE event = '" . $row['id'] . "' AND status_pendaftaran = 'Payment' AND id NOT LIKE '0'");

	$tanggal_penutupan = date('d M Y', strtotime($row['tanggal_penutupan']));


	if ($row['status_event'] == 'Cooming Soon') {
		$tanggal_penutupan = '-';
		$status =  '<span class="label bg-yellow round right" style="border-radius:15px;">Cooming Soon</span>';
	} else if ($row['status_event'] == 'Masih Dibuka') {
		$status =  '<span class="label bg-green round right" style="border-radius:15px;">Masih Dibuka</span>';
	} else if ($row['status_event'] == 'Sudah Ditutup') {
		$status =  '<span class="label bg-red round right" style="border-radius:15px;">Sudah Ditutup</span>';
	} else {
		$status =  '<span class="label bg-blue round right" style="border-radius:15px;">Sedang Berjalan</span>';
	}
	
	$nama_event = substr($row["nama_event"], 0, 16);
	
	$tanggal = "";
	if ($row['status_event']=='Cooming Soon') { 
		$tanggal = '-';
	} else {
		$tanggal = date('d M Y', strtotime($row['tanggal_mulai'])) . "<b> s/d </b>" . date('d M Y', strtotime($row['tanggal_selesai']));
	}

	
	$output = '

	<div class="col-md-4">
	<a href="' . base_url("event-detail/") . $this->template->sonEncode(strtolower($row['id'])). '" class="a_black">
		<div class="box">
				<div class="row">
				<div class="col-md-12" align="center">
					<span class="label_status bg-green round right" style="margin-left:5px">MASIH DIBUKA</span>                      
					<img style="width:100%;height:270px;" src="'.$photo['dir'].'" class="mech-img">
				</div>
				<div class="col-md-12" align="center" style="margin:15px;">
				<p class="small">
				' . $row['tipe_pendaftaran']. '
				</p>
				<h4 class="medium">' . $nama_event . '</h4>
					<p class="medium">
					' . $status . '
					</p>
					<p class="small" style="margin-top:5px;">'.$tanggal.'</p>
					<p class="medium" style="margin-top:5px;">'.intval($pendaftar[0]['pendaftar']).' Verified Register</p>
					<p class="small" style="margin-top:5px;">Penutupan : '.$tanggal_penutupan.'</p>
				</div>
				</div>
			</div>
			</a>
		</div>
			

	';

echo $output;
}
			?>
        </div>
      </div>
      
      
      <div class="col-lg-12" align="center">
        <a href="<?= base_url('event') ?>">
          <button class="btn btn-primary btn-lg btn-blog round" style="background-color: #72c02c;">Lihat Semua Event</button>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="cover2">
  </div>
</div>
<div class="content">
  <div class="">
    <div class="row">
      <div class="col-lg-6" align="center">
        <h1 style="margin:25px 0px; " ><b>News</b></h1>
        <?php foreach ($news as $row) {
          $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'news')); ?>
          <div class="col-lg-12">
            <a href="<?= base_url("news-detail/") . $this->template->sonEncode(strtolower($row['id'])) ?>" class="a_black">
              <div class="box">
                <div class="row">
                  <div class="col-lg-4">
                    <img class="index-event" src="<?= 'https://nsoproject.com/admin-side/webfile/'.$photo['name'] ?>">
                  </div>
                  <div class="col-lg-8" style="padding:10px;">
                    <h4><b><?= substr($row["nama_news"], 0, 35) ?></b></h4>
                    <p><?= substr($row["deskripsi_news"], 0, 100) . "..." ?></p>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php } ?>
        <div class="row" align="center">
          <div class="col-lg-12">
            <a href="<?= base_url('news') ?>">
              <button class="btn btn-primary btn-lg btn-blog" style="background-color: #72c02c;">Lihat Semua News</button>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-6" align="center">
        <h1 style="margin:25px 0px;"><b>Merchandise</b></h1>
        <div class="row">
          <?php foreach ($merchandise as $row) {
            $photo = $this->mymodel->selectDataone('file', array('table_id' => $row['id'], 'table' => 'merchandise')); ?>
            <div class="col-lg-6">
              <a href="<?= base_url("merchandise-detail/") . $this->template->sonEncode(($row['id']))?>" class="a_black">
                <div class="box">
                  <div class="row">
                    <div class="col-lg-12" align="center">
                      <?php
                        if ($row['status'] == 'ENABLE') {
                          echo '<span class="label_status bg-green round right" style="margin-left:5px">Stok Tersedia</span>';
                        } else {
                          echo '<span class="label_status bg-red round right" style="margin-left:5px">Stok Habis</span>';
                        }
                        ?>
                      <img style="width:100%;height:170px;" src="<?= 'https://nsoproject.com/admin-side/webfile/'.$photo['name'] ?>" class="mech-img">
                    </div>
                    <div class="col-lg-12"  style="padding:15px;">
                      
                        <h4><b><?= substr($row["nama_merchandise"], 0, 30) ?></b></h4>
                        
                        <p>
                        <b>Rp. <?= number_format($row['harga_merchandise'], 0, ',', '.') ?>,- </b>
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          <?php } ?>
        </div>
        <div class="row" align="center">
          <div class="col-lg-12">
            <a href="<?= base_url('merchandise') ?>">
              <button class="btn btn-primary btn-lg btn-blog" style="background-color: #72c02c;">Lihat Semua Merchandise</button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
    function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  if(seconds < 0 || minutes < 0 || hours < 0 || days < 0){
    var seconds = 0;
    var minutes = 0;
    var hours = 0;
    var days = 0;
  }
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}
<?php

$start = strtotime(date('Y-m-d'));
$end = strtotime('2019-11-19');

$days_between = ceil(abs($end - $start) / 86400);

$tanggal = $tanggals;

?>
var deadline = '<?=DATE('M' ,strtotime($tanggal))?> <?=DATE('d' ,strtotime($tanggal))?> <?=DATE('Y' ,strtotime($tanggal))?> 23:59:59 GMT+0200';
initializeClock('clockdiv', deadline);

</script>
