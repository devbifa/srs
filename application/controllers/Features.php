<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Features extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	function excel($menu){
		$check = "0";
		if($menu=="aircraft_hours"){
			$check = "1";
			$file_name = "Record Aircraft Hours ".$_SESSION['start_date']." - ".$_SESSION['end_date'].".xlsx";
			$data['file_name'] = $file_name;
			$excel_file = $this->load->view("record/aircraft_hours/excel",$data);
		}else if($menu=="instructor_hours"){
			$check = "1";
			$file_name = "Record Instructor Hours ".$_SESSION['start_date']." - ".$_SESSION['end_date'].".xlsx";
			$data['file_name'] = $file_name;
			$excel_file = $this->load->view("record/instructor_hours/excel",$data);
		}else if($menu=="student_hours"){
			$check = "1";
			$file_name = "Record Student Hours ".$_SESSION['start_date']." - ".$_SESSION['end_date'].".xlsx";
			$data['file_name'] = $file_name;
			$excel_file = $this->load->view("record/student_hours/excel",$data);
		}else if($menu=="ftd_hours"){
			$check = "1";
			$file_name = "Record FTD Hours ".$_SESSION['start_date']." - ".$_SESSION['end_date'].".xlsx";
			$data['file_name'] = $file_name;
			$excel_file = $this->load->view("record/ftd_hours/excel",$data);
		}else if($menu=="irregularities"){
			$check = "1";
			$file_name = "Record Irregularities ".$_SESSION['start_date']." - ".$_SESSION['end_date'].".xlsx";
			$data['file_name'] = $file_name;
			$excel_file = $this->load->view("record/irregularities/excel,$data");
		}else if($menu=="safety_performance"){
			$check = "1";
			$file_name = "Record Safety Performance ".$_SESSION['start_date']." - ".$_SESSION['end_date'].".xlsx";
			$data['file_name'] = $file_name;
			$excel_file = $this->load->view("record/safety_performance/excel,$data");
		}
		if($check == "1"){
			
		}
	}

	function print_flight_schedule_v2(){
		$date = $_SESSION['start_date'];
		$type = 'FLIGHT';
		$base = $_SESSION['origin_base'];

		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base'
		LIMIT 1");

		$approval = $approval[0];

		$data['location'] = $location.', '.DATE('d M Y', strtotime($approval['sent_at']));
		// die;

		$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['prepared_by']));
        $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));

        $data['prepared_by'] = '<p><u>'.$dat['name'].'</u><p> <p>'.$role['role'].'</p>';

        $dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by']));
        $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));

		$data['approved_by'] = '<p><u>'.$dat['name'].'</u><p> <p>'.$role['role'].'</p>';
		$img = $this->mymodel->selectDataOne('file',array('table'=>'file_signature','table_id'=>$dat['id']));
		
		// if($approval['approval_status']=='APPROVE'){
		// 	$data['approved_by'] = '<img style="float:left;text-align:left" src="'.base_url().'webfile/'.$img['name'].'" >';
		// }else{
		// 	$data['approved_by'] = '<br><br><br><br><br>'.$data['approved_by'];
		// }
		$data['approved_by'] = '<br><br><br><br><br>'.$data['approved_by'];
		
		if($approval['approved_by_2']){
			if($approval['approval_status'] != 'APPROVE'){
				$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by_2']));
				$data['approved_by'] = '<p><u>'.$dat['name'].'</u><p> <p>On Behalf Of '.$role['role'].'</p>';
			}
        }

		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY FLIGHT SCHEDULE - '.$base['base'];
		}else{
			$text2 = 'DAILY FLIGHT SCHEDULE - ALL BASE';
		}

		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}
		// echo $data['date'];

		$title = $text2.' '.strtoupper($data['date']);
	
		$data['title'] = $title;
		$data['base'] = $base['base'];
		$this->load->view('dashboard/flight_schedule/print_v2',$data);
	}

	function print_flight_schedule(){
		
		$date = $_SESSION['start_date'];
		$type = 'FLIGHT';
		$base = $_SESSION['origin_base'];

		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base'
		LIMIT 1");

		$approval = $approval[0];

		$data['location'] = $location.', '.DATE('d M Y', strtotime($approval['sent_at']));
		// die;

		$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['prepared_by']));
        $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));

        $data['prepared_by'] = '<p><u>'.$dat['name'].'</u><p> <p>'.$role['role'].'</p>';

        $dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by']));
        $role = $this->mymodel->selectDataOne('role', array('id'=>$dat['role_id']));

		$data['approved_by'] = '<p><u>'.$dat['name'].'</u><p> <p>'.$role['role'].'</p>';
		$img = $this->mymodel->selectDataOne('file',array('table'=>'file_signature','table_id'=>$dat['id']));
		
		// if($approval['approval_status']=='APPROVE'){
		// 	$data['approved_by'] = '<img style="float:left;text-align:left" src="'.base_url().'webfile/'.$img['name'].'" >';
		// }else{
		// 	$data['approved_by'] = '<br><br><br><br><br>'.$data['approved_by'];
		// }
		$data['approved_by'] = '<br><br><br><br><br>'.$data['approved_by'];
		
		if($approval['approved_by_2']){
			if($approval['approval_status'] != 'APPROVE'){
				$dat = $this->mymodel->selectDataOne('user', array('id'=>$approval['approved_by_2']));
				$data['approved_by'] = '<p><u>'.$dat['name'].'</u><p> <p>On Behalf Of '.$role['role'].'</p>';
			}
        }

		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY FLIGHT SCHEDULE - '.$base['base'];
		}else{
			$text2 = 'DAILY FLIGHT SCHEDULE - ALL BASE';
		}

		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}
		// echo $data['date'];

		$title = $text2.' '.strtoupper($data['date']);
	

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/flight_schedule/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "Prepared on ".$this->template->date_indo_time(($approval['prepared_time']))." | Aproved on ".$this->template->date_indo_time(($approval['approved_time']));
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];
		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(493, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 129, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		$pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		//$pdf->Output("$namafile.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	}

	function print_flight_report(){
		
		$date = $_SESSION['start_date'];
		$type = 'FLIGHT REPORT';
		$base = $_SESSION['origin_base'];

		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base'
		LIMIT 1");

		$approval = $approval[0];



		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY MOVEMENT REPORT - '.$base['base'];
		}else{
			$text2 = 'DAILY MOVEMENT REPORT - ALL BASE';
		}

		

		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}

		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/flight_report/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "Prepared on ".$this->template->date_indo_time(($approval['prepared_time']))." | Aproved on ".$this->template->date_indo_time(($approval['approved_time']));
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(493, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 129, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		$pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		//$pdf->Output("$namafile.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	}

	
	function print_ftd_schedule(){
		
		$date = $_SESSION['start_date'];
		$type = 'FTD';
		$base = $_SESSION['origin_base'];

		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base'
		LIMIT 1");

		$approval = $approval[0];

		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY FTD SCHEDULE - '.$base['base'];
		}else{
			$text2 = 'DAILY FTD SCHEDULE - ALL BASE';
		}

		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}
		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/ftd_schedule/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "Prepared on ".$this->template->date_indo_time(($approval['prepared_time']))." | Aproved on ".$this->template->date_indo_time(($approval['approved_time']));
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(493, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 129, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		$pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		//$pdf->Output("$namafile.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	}

	function revise($type,$id){
		$_SESSION['revise'] = '1';
		if($type=='ground'){
			$data = $this->mymodel->selectDataOne('daily_ground_schedule',array('id'=>$id));
			$data['id'] = null;
			$data['id_parent'] = $id;
			$data['created_at'] = DATE('Y-m-d H:i:s');
			$data['updated_at'] = DATE('Y-m-d H:i:s');
			$data['created_by'] = $_SESSION['id'];
			$this->mymodel->insertData('daily_ground_schedule',$data);
			$id = $this->db->insert_id();
			redirect(base_url().'master/daily_attendance_report/edit/'.$id);
		}else if($type=='ftd'){
			$data = $this->mymodel->selectDataOne('daily_ftd_schedule',array('id'=>$id));
			$data['id'] = null;
			$data['id_parent'] = $id;
			$data['created_at'] = DATE('Y-m-d H:i:s');
			$data['updated_at'] = DATE('Y-m-d H:i:s');
			$data['created_by'] = $_SESSION['id'];
			$this->mymodel->insertData('daily_ftd_schedule',$data);
			$id = $this->db->insert_id();
			redirect(base_url().'master/daily_ftd_report/edit/'.$id);
		}else if($type=='flight'){
			$data = $this->mymodel->selectDataOne('daily_flight_schedule',array('id'=>$id));
			$data['id'] = null;
			$data['id_parent'] = $id;
			$data['created_at'] = DATE('Y-m-d H:i:s');
			$data['updated_at'] = DATE('Y-m-d H:i:s');
			$data['created_by'] = $_SESSION['id'];
			$this->mymodel->insertData('daily_flight_schedule',$data);
			$id = $this->db->insert_id();
			redirect(base_url().'master/daily_movement_report/edit/'.$id);
		}
	}


	function delete($type,$id){
		if($type=='ground'){
			$this->mymodel->deleteData('daily_ground_schedule',array('id'=>$id));
		}else if($type=='ftd'){
			$this->mymodel->deleteData('daily_ftd_schedule',array('id'=>$id));
		}else  if($type=='flight'){
			$this->mymodel->deleteData('daily_flight_schedule',array('id'=>$id));
		}
		redirect(base_url().'master/edit_training_report');
	}

	function print_ftd_report(){
		
		$date = $_SESSION['start_date'];
		$type = 'FTD REPORT';
		$base = $_SESSION['origin_base'];

		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base'
		LIMIT 1");

		$approval = $approval[0];

		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY FTD REPORT - '.$base['base'];
		}else{
			$text2 = 'DAILY FTD REPORT - ALL BASE';
		}
	
		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}

		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/ftd_report/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "Prepared on ".$this->template->date_indo_time(($approval['prepared_time']))." | Aproved on ".$this->template->date_indo_time(($approval['approved_time']));
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(493, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 129, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		$pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		//$pdf->Output("$namafile.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	}


	
	function print_ground_schedule(){
		

		$date = $_SESSION['start_date'];
		$type = 'GROUND';
		$base = $_SESSION['origin_base'];

		// $approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$date' AND type = '$type' AND base = '$base'
		// LIMIT 1");

		// $approval = $approval[0];

		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY GROUND SCHEDULE - '.$base['base'];
		}else{
			$text2 = 'DAILY GROUND SCHEDULE - ALL BASE';
		}

		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}
		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/ground_schedule/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "Prepared on ".$this->template->date_indo_time(($approval['prepared_time']))." | Aproved on ".$this->template->date_indo_time(($approval['approved_time']));
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(493, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 129, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		$pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		//$pdf->Output("$namafile.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	}

	function print_ground_report(){
		
		$my_date = $_SESSION['start_date'];
		$type = 'GROUND REPORT';
		$origin_base = $_SESSION['origin_base'];

		if($_SESSION['origin_base']){
		$location = $_SESSION['origin_base'];
		}else{
		$location = 'ALL BASE';
		}
		$approval = $this->mymodel->selectWithQuery("SELECT * FROM approval WHERE DATE(date) = '$my_date' AND type = '$type' AND base = '$origin_base'
		LIMIT 1");

		$approval = $approval[0];

		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'DAILY GROUND REPORT - '.$base['base'];
		}else{
			$text2 = 'DAILY GROUND REPORT - ALL BASE';
		}
	
		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}

		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('dashboard/ground_report/print.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "Prepared on ".$this->template->date_indo_time(($approval['prepared_time']))." | Aproved on ".$this->template->date_indo_time(($approval['approved_time']));
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(493, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 129, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);

					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		$pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		//$pdf->Output("$namafile.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	}

	function print_ground_instructor_productivity(){
		
		$data['page_name'] = 'print';
		$this->load->library('pdf');
		$dir = 'webfile/print/';
		$filename = 'print';

		$base = $_SESSION['origin_base'];
		$base = $this->mymodel->selectDataOne('base_airport_document', array('base'=>$base));
		if($base){
			$text2 = 'GROUND INSTRUCTOR PRODUCTIVITY - '.$base['base'];
		}else{
			$text2 = 'GROUND INSTRUCTOR PRODUCTIVITY - ALL BASE';
		}
	
		if($_SESSION['start_date'] == $_SESSION['end_date']){
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date']));
		}else{
			$data['date'] = DATE('d M Y', strtotime($_SESSION['start_date'])).' - '.DATE('d M Y', strtotime($_SESSION['end_date']));
		}

		$title = $text2.' '.strtoupper($data['date']);

		$data['base'] = $base['base'];
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'landscape');
		$data = $this->load->view('report/instructor_productivity_hours/print_ground.php', @$data, true); //view
		$this->pdf->html($data);
		$this->pdf->create('save'); //Save to path
		// die;
		// $this->pdf->create(); //To open with browser or save to pc

		$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/webfile/print/print.pdf", "wb");
		fwrite($fp, $content);
		fclose($fp);
		$namafile = $file[0]['name'];
		// $text = 'PRIVATE & CONFIDENTIAL';
		$text = '';

		// require('/home/karyas/dev.karyastudio.com/e-radir/vendor/WatermarkPDF/WatermarkPDF.php');
		require('vendor/WatermarkPDF/WatermarkPDF.php');

		# ==========================
		// $pdfFile = "webfile/agenda/$namafile";
		// $pdfFile = "/home/karyas/dev.karyastudio.com/webfile/agenda/$namafile";
		$pdfFile = "webfile/print/print.pdf";


		$watermarkText = "$text";
		$name = $_SESSION['name'];
		$text1 = "Prepared on ".$this->template->date_indo_time(($approval['prepared_time']))." | Aproved on ".$this->template->date_indo_time(($approval['approved_time']));
		// $watermarkText2 = "";

		$tanggal = DATE('d/m/Y');
		$waktu = DATE('H:i:s');
		// $watermarkText3 = "Disseminated on $tanggal at $waktu WIB";
		
	



		$pdf = new FPDI();

		// $pdf->setSourceFile($pdfFile);

		// Get total of the pages
		$pages_count = $pdf->setSourceFile($pdfFile);

		$pdf->AddPage('A4');

		$w = array();
		$h = array();
		$o = array();
		for ($i = 1; $i <= $pages_count; $i++) {

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

			$size = $pdf->getTemplateSize($tplIdx);

			if ($size['w'] > $size['h']) {
				// echo 'L';
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'L';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			} else {
				$w[$i] = $size['w'];
				$h[$i] = $size['h'];
				$o[$i] = 'P';
				$w2[($i + 1)] = $size['w'];
				$h2[($i + 1)] = $size['h'];
				$o2[($i + 1)] = 'L';
			}
		}


		for ($i = 1; $i <= $pages_count; $i++) {
			// echo $i;
			// echo $h[$i].'<br>';
			$pdf->AddPage($o[$i], array($w[$i], $h[$i]));

			$tplIdx = $pdf->importPage($i);

			$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);
		}
		// Position our "cursor" to left edge and in the middle in vertical position minus 1/2 of the font size
		// $pdf->SetXY(0, 139.7-10);


		// Output our new pdf into a file
		// F = Write local file
		// I = Send to standard output (browser)
		// D = Download file
		// S = Return PDF as a string
		// print_R($pdf);

		$id = $_SESSION['id'];

		// $pdf->Output(); //If you Leave blank then it should take default "I" i.e. Browser

		// $pdf->Output("/home/karyas/dev.karyastudio.com/webfile/dokumen/$id$namafile", 'F'); //save to a local file with the name given by filename (may include a path)

		$pdf->Output("webfile/print/print2.pdf", 'F'); //save to a local file with the name given by filename (may include a path)

		// $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/webfile/new-file.pdf', 'F');

		$h2 = $h[1];
		$w2 = $w[1];
		$pdf = new WatermarkPDF($watermarkText, $watermarkText2, $watermarkText3, $h2, $w2);
		// $pdf2 = new WatermarkPDF($pdfFile, $watermarkText);

		$pdfFile = "webfile/print/print2.pdf";
	
		$pages_count = $pdf->setSourceFile($pdfFile);

	
		for ($i = 1; $i <= $pages_count; $i++) {

			// echo $i;

			if ($i > 1) {
				// echo $h[$i].'<br>';
				$or = $o[($i - 1)];
				$we = $w[($i - 1)];
				$he = $h[($i - 1)];

				$pdf->AddPage($or, array($we, $he));

				$tplIdx = $pdf->importPage($i);

				$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true);

				$size = $pdf->getTemplateSize($tplIdx);


				$pdf->SetFont('Arial', '', 7);
				// $pdf->SetAlpha(0.2);
				$pdf->SetTextColor(192, 192, 192);

				$hes = -10;
				$page = 'Page '.($i+1);
				if ($or == 'L') {
					$pdf->Cell(493, $hes,  $text1, 0, 0, 'C');
					$pdf->Ln();
					$image1 = "assets/logo.png";
					$pdf->Image($image1, 129, 10, null, 15);
					$pdf->SetTextColor(0,0,0);
					$pdf->SetFont('Arial','B',12);
					$pdf->Cell(0, 60,  $text2, 0, 0, 'C');
					$pdf->SetFont('Arial','B',9);
					
					// $pdf->WriteHTML('<p style="color:#000" >ABC</p>');
					
					// $pdf->Cell(0, 190,  $page , 0, 0, 'C');
					
				}
				// $pdf->Rotate(10,20,30);
				$pdf->SetX($this->lMargin);

				// $rotatedText = 'AANG MUAMMAR ZEIN 123'; 
				// $pdf->watermark2($watermarkText,($we/2)-30, $he/2, $rotatedText, 45);

				$pdf->SetFont('Arial', '', 25);
				$pdf->SetTextColor(192, 192, 192);
				$pdf->RotatedText(($we / 2) - 30, $he / 2, $rotatedText, 45);

				if ($pdf->fullPathToFile) {
					if (is_null($pdf->_tplIdx)) {
						// THIS IS WHERE YOU GET THE NUMBER OF PAGES
						$pdf->numPages = $pdf->setSourceFile($pdf->fullPathToFile);
						$pdf->_tplIdx = $pdf->importPage(1);
					}
					$pdf->useTemplate($pdf->_tplIdx, 0, 0, 200);
				}
			}
		}
	
		// @unlink($_SERVER['DOCUMENT_ROOT'] . "/bifa/webfile/print/print.pdf");
		// ob_end_flush();
		// ob_end_clean();
		$pdf->setTitle($title);
		$pdf->Output(); //save to a local file with the name given by filename (may include a path)
		// $pdf->Output("print_fix.pdf", 'D'); ///
		//$pdf->Output("$namafile.pdf", 'F'); //save to a local file with the name given by filename (may include a path)
		//$pdf->Output("$namafile.pdf", 'I'); //I for "inline" to send the PDF to the browser
		//$pdf->Output("$namafile.pdf", 'S'); //return the document as a string. filename is ignored.
	}

	
}