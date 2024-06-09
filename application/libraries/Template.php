<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {


		var $template_data = array();
		
		function check_time_pass($time_2,$time_1){
			$time_1 = (explode(":",$time_1));
			$time_2 = (explode(":",$time_2));

			if($time_1[0] == $time_2[0] && $time_1[1] >= $time_2[1] ){
				return "1";
			}else if($time_1[0] > $time_2[0]){
				return "1";
			}else{
				return "0";
			}
		}
		function set($name, $value)
		{
			$this->template_data[$name] = $value;
		}

		public function to_number($angka){
			$angka =  number_format($angka, 0, ",", ".");
			return $angka;
		}

		function to_number_pure($angka){
			$angka = str_replace('.','KS',$angka);
			$angka = str_replace(',','.',$angka);
			$angka = str_replace('KS','',$angka);
			return $angka;
		}

		function to_utc($str){
			$value = array();
			if (strpos($str, ':') !== false) {
				$value =  explode(":",$str);
			}else if (strpos($str, '.') !== false) {
				$value =  explode(".",$str);
			}else{
				$value[0] = $str;
				$value[1] = '00';
			}
			
	
			 $value = str_pad($value[0], 2, '0', STR_PAD_LEFT).':'.str_pad($value[1], 2, '0', STR_PAD_RIGHT);
			if(in_array($str,array('','-'))){
				$value = '-';
			}
			 return $value;
	
		}

		
		function curl_url($url){
			$curl = curl_init();                
			$post['test'] = 'examples daata'; // our data todo in received
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt ($curl, CURLOPT_POST, TRUE);
			curl_setopt ($curl, CURLOPT_POSTFIELDS, $post); 

			curl_setopt($curl, CURLOPT_USERAGENT, 'api');

			curl_setopt($curl, CURLOPT_TIMEOUT, 1); 
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl,  CURLOPT_RETURNTRANSFER, false);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 1);
			curl_setopt($curl, CURLOPT_DNS_CACHE_TIMEOUT, 10); 

			curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);

			curl_exec($curl);   

			curl_close($curl);  
			
			return 'success';

		}
		
		function date_with_time($val){
			if($val){
				$val = DATE('d M Y H:i', strtotime($val));
			}else{
				$val = '';
			}
			return $val;
		}
             
		function sum_time_2($data){
 

			// Total to hold the amount of seconds
			$total = 0;

			// Loop the data items
			foreach($data as $item):
				$temp = explode(":", $item); // Explode by the seperator :
				$total+= (int) $temp[0] * 3600; // Convert the hours to seconds and add to our total
				$total+= (int) $temp[1] * 60;  // Convert the minutes to seconds and add to our total
				$total+= (int) $temp[2]; // Add the seconds to our total
			endforeach;

			// Format the seconds back into HH:MM:SS
			// $formatted = sprintf('%02d:%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			// $formatted = sprintf('%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			$formatted = sprintf('%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			
			$explode = (explode(":",$formatted));
			$formatted = intval($explode[0]).':'.$explode[1];

			if($explode[0]=="00" && $explode[1]=="00"){
				$formatted = "";
			}

			return $formatted; // Outputs 35:04:28
		}

		function sum_time($data){
 

			// Total to hold the amount of seconds
			$total = 0;

			// Loop the data items
			foreach($data as $item):
				$temp = explode(":", $item); // Explode by the seperator :
				$total+= (int) $temp[0] * 3600; // Convert the hours to seconds and add to our total
				$total+= (int) $temp[1] * 60;  // Convert the minutes to seconds and add to our total
				$total+= (int) $temp[2]; // Add the seconds to our total
			endforeach;

			// Format the seconds back into HH:MM:SS
			// $formatted = sprintf('%02d:%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			// $formatted = sprintf('%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			$formatted = sprintf('%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			
			$explode = (explode(":",$formatted));
			$formatted = intval($explode[0]).':'.$explode[1];

			return $formatted; // Outputs 35:04:28
		}

		function sum_time_3($data){
 

			// Total to hold the amount of seconds
			$total = 0;

			// Loop the data items
			foreach($data as $item):
				$temp = explode(":", $item); // Explode by the seperator :
				$total+= (int) $temp[0] * 3600; // Convert the hours to seconds and add to our total
				$total+= (int) $temp[1] * 60;  // Convert the minutes to seconds and add to our total
				$total+= (int) $temp[2]; // Add the seconds to our total
			endforeach;

			// Format the seconds back into HH:MM:SS
			// $formatted = sprintf('%02d:%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			// $formatted = sprintf('%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			$formatted = sprintf('%02d:%02d', ($total / 3600),($total / 60 % 60), $total % 60);
			
			$explode = (explode(":",$formatted));
			$formatted = intval($explode[0]).':'.$explode[1];
			if($formatted=='0:00'){
				$formatted = '-';
			}
			return $formatted; // Outputs 35:04:28
		}


		function date_range( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
			$dates = [];
			$current = strtotime( $first );
			$last = strtotime( $last );
		
			while( $current <= $last ) {
		
				$dates[] = date( $format, $current );
				$current = strtotime( $step, $current );
			}
		
			return $dates;
		}

		function sub_time($data){
 
			$first = (explode(":",$data[0]));
			$second = (explode(":",$data[1]));
			
			$first[0] = $first[0] - 1;
			$first[1] = $first[1] + 60;

			$jam = $first[0] - $second[0];
			$menit = $first[1] - $second[1]; 

			if($menit >= 60){
				$jam = $jam + 1;
				$menit = $menit - 60;
			}
			
			$formatted = $jam.':'.$menit;
			
			$formatted = sprintf('%02d:%02d', $jam,$menit, 0);
			// $formatted = $data[1]
			return $formatted; // Outputs 35:04:28
		}

		function load($template = '', $view = '' , $view_data = array(), $return = FALSE)
		{
			$this->CI =& get_instance();
						$this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
			return $this->CI->load->view($template, $this->template_data, $return);
		}
	// function pagination($page){
		
			// 	$config['full_tag_open']	= "<ul  class='pagination'>";
			// 	$config['full_tag_close']	= "</ul>";
				// 	$config['num_tag_open']		= '<li class="page-item">';
			// 	$config['num_tag_close']	= '</li>';
			// 	$config['cur_tag_open'] 	= '<li class="page-item active"><a class="page-link">';
			// 	$config['cur_tag_close']	= '</a></li>';
				// 	$config['prev_link'] 		= '<span class="la la-caret-left"></span>';
			// 	$config['prev_tag_open'] 	= '<li class="page-item">';
			// 	$config['prev_tag_close'] 	= '</li>';
			// 	$config['next_tag_open'] 	= '<li class="page-item">';
			// 	$config['next_tag_close'] 	= '</li>';
				// 	$config['next_link'] 		= '<span class="la la-caret-right"></span>';
			// 	$config['first_tag_open'] 	= '<li class="page-item">';
			// 	$config['first_tag_close']	= '</li>';
				// 	$config['first_link'] 		= '<span class="la la-backward"></span> First';
			// 	$config['last_tag_open'] 	= '<li class="page-item">';
			// 	$config['last_tag_close'] 	= '</li>';
				// 	$config['last_link'] 		= 'Last <span class="la la-forward"></span>';
		// 	$config['attributes'] = array('class' => 'page-link');
		// 	return $config;
	// }
	function pagination($page){
		
			$config['full_tag_open']	= "<ul  class='pagination'>";
			$config['full_tag_close']	= "</ul>";
				$config['num_tag_open']		= '<li class="page-item">';
			$config['num_tag_close']	= '</li>';
			$config['cur_tag_open'] 	= '<li class="page-item active"><a class="page-link">';
			$config['cur_tag_close']	= '</a></li>';
				$config['prev_link'] 		= '<span class="fa fa-caret-left"></span>';
			$config['prev_tag_open'] 	= '<li class="page-item">';
			$config['prev_tag_close'] 	= '</li>';
			$config['next_tag_open'] 	= '<li class="page-item">';
			$config['next_tag_close'] 	= '</li>';
				$config['next_link'] 		= '<span class="fa fa-caret-right"></span>';
			$config['first_tag_open'] 	= '<li class="page-item">';
			$config['first_tag_close']	= '</li>';
				$config['first_link'] 		= '<span class="fa fa-backward"></span> First';
			$config['last_tag_open'] 	= '<li class="page-item">';
			$config['last_tag_close'] 	= '</li>';
				$config['last_link'] 		= 'Last <span class="fa fa-forward"></span>';
		$config['attributes'] = array('class' => 'page-link');
		return $config;
	}
	function getNameFromNumber($num) {
	$numeric = $num % 26;
	$letter = chr(65 + $numeric);
	$num2 = intval($num / 26);
	if ($num2 > 0) {
	return $this->getNameFromNumber($num2 - 1) . $letter;
	} else {
	return $letter;
	}
	}
	function createFile($string, $path)
	{
	$create = fopen($path, "w") or die("Change your permision folder for application and harviacode folder to 777");
	fwrite($create, $string);
	fclose($create);
	
	return $path;
	}
	function label($str)
	{
	$label = str_replace('_', ' ', $str);
	$label = ucwords($label);
	return $label;
	}
	
	function chart($id,$type,$label,$data)
	{
		if ($type == 'bar' || $type == 'line') {
			$html = '<div id="container">
					<canvas id="'.$id.'" width="600" height="300"></canvas>
				</div>
				<br><br>
				<div style="overflow: auto;">
						<div class="box-group" id="accordion'.$id.'">
		<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
		<div class="panel box box-default">
			<div class="box-header with-border bg-info">
				<h4 class="box-title">
				<a data-toggle="collapse" data-parent="#accordion'.$id.'" href="#collapseOne'.$id.'" style="font-family:Montserrat;">
					Lihat Detail Grafik <i class="fa fa-arrow-down"></i>
				</a>
				</h4>
			</div>
			<div id="collapseOne'.$id.'" class="panel-collapse collapse">
				<div class="box-body">
					
					
					<table class="table table-condensed table-hover table-bordered table-responsive mytable">
						<thead>
							<tr class="bg-info">
								<th>Label</th>
								';
								foreach ($label as $labeltable) {
								$html.='<th>'.$labeltable.'</th>';
								}
							$html.='		</tr>
						</thead>
						<tbody>
							';
							foreach ($data as $datatable) {
							$datatableku[] = json_decode($datatable['data']);
							$labelku[] = $datatable['labeldata'];
							$warnaku[] = $datatable['background'];
							
							}
							for ($i=0; $i < count($datatableku) ; $i++) {
							$html.=' <tr >';
								$html.=' 	<td style="background:'.$warnaku[$i].'">'.$labelku[$i].'</td>';
								for ($a=0; $a < count($datatableku[0]) ; $a++) {
								$html.='<td>'.$datatableku[$i][$a].'</td>';
								}
							$html.='</tr>';
							}
						$html.='	</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var canvas = document.getElementById("'.$id.'");
var ctx = canvas.getContext("2d");
var '.$id.'Data = {
labels : '.json_encode($label).',
datasets : [';
foreach ($data as $record) {
$html.= '{
			label: "'.$record['labeldata'].'",
			backgroundColor: "'.$record['background'].'",
			borderColor: "'.$record['border'].'",
			borderWidth: 1,
			fillColor: "rgba(220,103,20,0.9)",
			strokeColor: "rgba(220,103,20,0.8)",
			pointColor: "#73b45a",
			pointStrokeColor: "#fff",
			pointHighlightFill: "#fff",
			pointHighlightStroke: "rgba(220,103,20,1)",
			data : '.$record['data'].'
},';
}
$html.='        ]

}
var myNewChart = new Chart(ctx , {
type: "'.$type.'",
data: '.$id.'Data,
});

</script>';
return $html;
}elseif($type == 'pie' || $type == 'doughnut'){
$html = '<div id="container">
	<canvas id="'.$id.'"></canvas>
</div>
<script>
var canvas = document.getElementById("'.$id.'");
var ctx = canvas.getContext("2d");
var '.$id.'Data = {
labels : '.$label.',
datasets : [';
foreach ($data as $record) {
$html.= '{
			label: "'.$record['labeldata'].'",
			backgroundColor: '.$record['background'].',
			borderColor: '.$record['border'].',
			borderWidth: 1,
			fillColor: "rgba(220,103,20,0.9)",
			strokeColor: "rgba(220,103,20,0.8)",
			pointColor: "#73b45a",
			pointStrokeColor: "#fff",
			pointHighlightFill: "#fff",
			pointHighlightStroke: "rgba(220,103,20,1)",
			data : '.$record['data'].'
},';
}
$html.='        ]

}
var myNewChart = new Chart(ctx , {
type: "'.$type.'",
data: '.$id.'Data,

});

</script>';
return $html;
}
}


public function sonKey()
    {
        return "sonsonz";
    }
	   // public function sonEncode($str)
    // {
    //     $key = $this->sonKey();
    //     return strtr(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $str, MCRYPT_MODE_CBC, md5(md5($key)))), '+/=', '-_~');
        
    // }
    // public function sonDecode($encoded)
    // {
	   //  $this->CI =& get_instance();

    //     $key = $this->sonKey();
    //     $random = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode(strtr($encoded, '-_~', '+/=')), MCRYPT_MODE_CBC, md5(md5($key))), "");
    // 	$result = str_replace("\\", "/", $this->CI->db->escape($random));
    // 	$result = str_replace("/0", "", $result);
    // 	$result = str_replace("'", "", $result);


   	// 	return $result;
    // }


    # jika mcrypt_encrypt tidak support di server

    function sonEncode( $string) {
	    $secret_key = '#sismik123';
    	$secret_iv = '#sismik123';
	 
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = hash( 'sha256', $secret_key );
	    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
    	$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
	    
	    return $output;
	}

	function sonDecode( $string) {
	    // you may change these values to your own
	    $secret_key = '#sismik123';
    	$secret_iv = '#sismik123';
	 
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = hash( 'sha256', $secret_key );
	    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
	       $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	    
	 
	    return $output;
	}

    public function rupiah($angka){
		if ($angka=='') {
			$hasil_rupiah = '0';
		} else {
			$hasil_rupiah = "" . @number_format($angka,0,'','.');
		}
		return $hasil_rupiah;
	 
	}

	public function date_indo2($date){
			
$dayList = array(
	'Sun' => 'Minggu',
	'Mon' => 'Senin',
	'Tue' => 'Selasa',
	'Wed' => 'Rabu',
	'Thu' => 'Kamis',
	'Fri' => 'Jumat',
	'Sat' => 'Sabtu'
  );
  $monthList = array(
	'01' => 'Jan',
	'02' =>  'Feb',
	'03' =>  'Mar',
	'04' =>  'Apr',
	'05' =>  'Mei',
	'06' =>  'Jun',
	'07' =>  'Jul',
	'08' =>  'Agt',
	'09' =>  'Sep',
	'10' =>  'Okt',
	'11' =>  'Nov',
	'12' =>  'Des'
  );
  		$date = DATE('Y-m-d', strtotime($date));
		$start_date = $date;
		$day = DATE('d', strtotime($start_date));
		$day_name = DATE('D', strtotime($start_date));
		$day_name = $dayList[$day_name];
		$month_name = DATE('m', strtotime($start_date));
		$month_name = $monthList[$month_name];
		$year = DATE('Y', strtotime($start_date));

		$start_date = intval($day).' '.$month_name.' '.$year;
		return $start_date;
	}


	public function date_indo3($date){
			
		$dayList = array(
			'Sun' => 'Sunday',
			'Mon' => 'Monday',
			'Tue' => 'Tuesday',
			'Wed' => 'Wednesday',
			'Thu' => 'Thursday',
			'Fri' => 'Friday',
			'Sat' => 'Saturday'
		  );
		  $monthList = array(
			'01' => 'Jan',
			'02' =>  'Feb',
			'03' =>  'Mar',
			'04' =>  'Apr',
			'05' =>  'Mei',
			'06' =>  'Jun',
			'07' =>  'Jul',
			'08' =>  'Agt',
			'09' =>  'Sep',
			'10' =>  'Okt',
			'11' =>  'Nov',
			'12' =>  'Des'
		  );
				$date = DATE('Y-m-d', strtotime($date));
				$start_date = $date;
				$day = DATE('d', strtotime($start_date));
				$day_name = DATE('D', strtotime($start_date));
				$day_name = $dayList[$day_name];
				$month_name = DATE('M', strtotime($start_date));
				// $month_name = $monthList[$month_name];
				$year = DATE('Y', strtotime($start_date));
		
				$start_date = $day_name.', '.intval($day).' '.$month_name.' '.$year;
				return $start_date;
			}
		
			function utc($str){
				$value = array();
				if (strpos($str, ':') !== false) {
					$value =  explode(":",$str);
				}else if (strpos($str, '.') !== false) {
					$value =  explode(".",$str);
				}else{
					$value[0] = $str;
					$value[1] = '00';
				}
				
		
				 $value = str_pad($value[0], 2, '0', STR_PAD_LEFT).':'.str_pad($value[1], 2, '0', STR_PAD_RIGHT);
				if(in_array($str,array('','-'))){
					$value = '0:00';
				}
				 return $value;
		
			}

	public function date_indo($date){
		if($date){
			$date = DATE('d M Y', strtotime($date));
			return $date;
		}else{
			return '-';
		}
  		
	}
	public function date_indo_time($date){
		if($date){
			$date = DATE('d-m-Y H:i:s', strtotime($date));
			return $date;
		}else{
			return '-';
		}
  		
	}

	public function deleteRupiah($angka)
	{
		$hasil = str_replace('.', '', $angka);
		return $hasil;
	}

}