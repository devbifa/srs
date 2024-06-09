<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Fitur extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	function wa(){
		$data = $this->mymodel->selectWithQuery("SELECT * FROM wa");
	}
	public function export($table)
	{
		
		$base = $_SESSION['origin_base'];
		$date = $_SESSION['start_date'];

		// if(empty($base) || empty($date)){
		// 	echo '<h1>Please Fill Date & Base!</h1>';
		// 	die;
		// }

		
		$excel = new PHPExcel();
		$excel->getProperties()
		->setCreator('Smartsoft Studio')
		->setLastModifiedBy('Smartsoft Studio')
		->setTitle("Master ".$table)
		->setSubject("".$table)
		->setDescription("Master ".$table)
		->setKeywords("Master ".$table);
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
				'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_SOLID,
            	'color' => array('rgb' => 'DDDDDD')
        	),
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style_row2 = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		
		// $structure_query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table."'";
		if($table=='daily_flight_schedule'){
			if($base){
				$qry_base = " AND origin_base = '$base' ";
			}
			$table_2 = "DFS $base $date";
			$structure = array("id","date_of_flight","origin_base","aircraft_reg","pic","2nd","course","batch","tpm","mission","rute","etd","eta","eet","dep","arr","remark","duty_instructor","visibility");
			$table_name = 'daily_flight_schedule';
			$rec = $this->mymodel->selectWithQuery("SELECT * FROM $table_name WHERE DATE(date_of_flight) = '$date' ".$qry_base." AND status = 'ENABLE' AND visibility = '0'");
		}else if($table=='daily_movement_report'){
			if($base){
				$qry_base = " AND origin_base = '$base' ";
			}
			$table_2 = "DMR $base $date";
			$structure = array("id","date_of_flight","origin_base","aircraft_reg","pic","2nd","course","batch","tpm","mission","rute","etd","eta","eet","dep","arr","block_time_start","block_time_stop","block_time_total",
			"flight_time_take_off","flight_time_landing","flight_time_total","ldg","remark","irreg_code","duty_instructor","visibility","visibility_report");
			$table_name = 'daily_flight_schedule';
			$rec = $this->mymodel->selectWithQuery("SELECT * FROM $table_name WHERE DATE(date_of_flight) = '$date' ".$qry_base." AND status = 'ENABLE' AND visibility = '1' AND visibility_report = '0'");
		}else if($table=='daily_ftd_schedule'){
			if($base){
				$qry_base = " AND origin_base = '$base' ";
			}
			$table_2 = "DSS $base $date";
			$structure = array("id","date","origin_base","ftd_model","pic","2nd","course","batch","tpm","mission","etd","eta","eet","remark","visibility");
			$table_name = 'daily_ftd_schedule';
			$rec = $this->mymodel->selectWithQuery("SELECT * FROM $table_name WHERE DATE(date) = '$date' ".$qry_base." AND status = 'ENABLE' AND visibility = '0'");
		
		}else if($table=='daily_ftd_report'){
			if($base){
				$qry_base = " AND origin_base = '$base' ";
			}
			$table_2 = "DSR $base $date";
			$structure = array("id","date","origin_base","ftd_model","pic","2nd","course","batch","tpm","mission","etd","eta","eet","block_time_atd","block_time_ata","block_time_total","remark","irreg_code","visibility","visibility_report");
			$table_name = 'daily_ftd_schedule';
			$rec = $this->mymodel->selectWithQuery("SELECT * FROM $table_name WHERE DATE(date) = '$date' ".$qry_base." AND status = 'ENABLE' AND visibility = '1' AND visibility_report = '0'");
		}else if($table=='daily_ground_schedule'){
			if($base){
				$qry_base = " AND b.station = '$base' ";
			}
			$table_2 = "DGS $base $date";
			$structure = array("id","date","batch","classroom","instructor","course","batch","tpm","subject","duration","start","stop","duration","remark","visibility");
			$table_name = 'daily_ground_schedule';
			
			$rec = $this->mymodel->selectWithQuery("SELECT a.* FROM $table_name a
			LEFT JOIN classroom b
			ON a.classroom = b.code
			WHERE  DATE(a.date) = '$date' ".$qry_base." AND a.status = 'ENABLE' AND a.visibility = '0'");
		
		}else if($table=='daily_attendance_report'){
			if($base){
				$qry_base = " AND b.station = '$base' ";
			}
			$table_2 = "DGR $base $date";
			$structure = array("id","date","batch","classroom","instructor","course","batch","tpm","subject","duration","start","stop","duration","start_act","stop_act","duration_act","remark","irreg_code","visibility","visibility_report");
			$table_name = 'daily_ground_schedule';
			
			$rec = $this->mymodel->selectWithQuery("SELECT a.* FROM $table_name a
			LEFT JOIN classroom b
			ON a.classroom = b.code
			WHERE DATE(a.date) = '$date' ".$qry_base."  AND a.status = 'ENABLE' AND a.visibility = '1' AND a.visibility_report = '0'");
			// print_R($rec);die;
		}
		// $structure = $this->mymodel->selectWithQuery($structure_query);
        $urut = 0;
        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$excel->setActiveSheetIndex(0)->setCellValue($abjad.'1', $stt); 
		$urut++;
		}
	 	$urut = 0;
        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$excel->getActiveSheet()->getStyle($abjad.'1')->applyFromArray($style_col);
    	$urut++;
		}
			
			
			$no = 1; 
			$numrow = 2; 
			foreach($rec as $dt){
				$urut = 0;
		        foreach ($structure as $stt) {
					$abjad = $this->template->getNameFromNumber($urut);
					if(in_array($table,array('daily_flight_schedule','daily_movement_report'))){
						
						if($stt=='eta'){
							$stt = 'eta_utc';
						}

						if($stt=='etd'){
							$stt = 'etd_utc';
						}
						if($stt=='irreg_code'){
							$stt = 'remark_dmr';
						}
					}else if(in_array($table,array('daily_ftd_schedule','daily_ftd_report'))){
						if($stt=='etd'){
							$stt = 'etd_utc';
						}

						if($stt=='eet'){
							$stt = 'eet_utc';
						}
						if($stt=='irreg_code'){
							$stt = 'remark_report';
						}
					}else if(in_array($table,array('daily_ground_schedule','daily_attendance_report'))){
						if($stt=='start'){
							$stt = 'start_lt';
						}

						if($stt=='stop'){
							$stt = 'stop_lt';
						}
						if($stt=='irreg_code'){
							$stt = 'remark_report';
						}
					}
				
					
					$excel->setActiveSheetIndex(0)->setCellValueExplicit($abjad.$numrow,  $dt[$stt],PHPExcel_Cell_DataType::TYPE_STRING);
		    	$urut++;
				}

				// die;
				
				$urut = 0;
		        foreach ($structure as $stt) {
		        	$abjad = $this->template->getNameFromNumber($urut);
					$excel->getActiveSheet()->getStyle($abjad.$numrow)->applyFromArray($style_row);
		        	$urut++;
				}
				$no++; 
				$numrow++; 
			}
			$urut = 0;
	        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$excel->getActiveSheet()->getColumnDimension($abjad)->setAutoSize(TRUE); 
        	$urut++;
        	}
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle($table_2);
			$excel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$table_2.'.xlsx"');
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
	}

	public function ekspor($table)
	{
		$excel = new PHPExcel();
		$excel->getProperties()
		->setCreator('Smartsoft Studio')
		->setLastModifiedBy('Smartsoft Studio')
		->setTitle("Master ".$table)
		->setSubject("".$table)
		->setDescription("Master ".$table)
		->setKeywords("Master ".$table);
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			),
				'fill' => array(
            	'type' => PHPExcel_Style_Fill::FILL_SOLID,
            	'color' => array('rgb' => 'DDDDDD')
        	),
		);
		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$style_row2 = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);
		$structure_query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table."'";
        $structure = $this->mymodel->selectWithQuery($structure_query);
        $urut = 0;
        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$excel->setActiveSheetIndex(0)->setCellValue($abjad.'1', $stt['COLUMN_NAME']); 
		$urut++;
		}
	 	$urut = 0;
        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$excel->getActiveSheet()->getStyle($abjad.'1')->applyFromArray($style_col);
    	$urut++;
		}
			$rec = $this->mymodel->selectData($table);
			$no = 1; 
			$numrow = 2; 
			foreach($rec as $dt){
				$urut = 0;
		        foreach ($structure as $stt) {
		        	$abjad = $this->template->getNameFromNumber($urut);
					$excel->setActiveSheetIndex(0)->setCellValueExplicit($abjad.$numrow,  $dt[$stt['COLUMN_NAME']],PHPExcel_Cell_DataType::TYPE_STRING);
		    	$urut++;
				}
				$urut = 0;
		        foreach ($structure as $stt) {
		        	$abjad = $this->template->getNameFromNumber($urut);
					$excel->getActiveSheet()->getStyle($abjad.$numrow)->applyFromArray($style_row);
		        	$urut++;
				}
				$no++; 
				$numrow++; 
			}
			$urut = 0;
	        foreach ($structure as $stt) {
        	$abjad = $this->template->getNameFromNumber($urut);
			$excel->getActiveSheet()->getColumnDimension($abjad)->setAutoSize(TRUE); 
        	$urut++;
        	}
			$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
			$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
			$excel->getActiveSheet(0)->setTitle("Master ".$table);
			$excel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment; filename="'.$table.'.xlsx"');
			header('Cache-Control: max-age=0');
			$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
			$write->save('php://output');
	}
	public function impor($table)
	{
		# code...
       	ini_set('max_execution_time', 30000);
		$config['upload_path']          = 'webfile/';
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['file_name']            = md5($table).'.xlsx';
		$config['overwrite']            =  TRUE;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}
		else
		{
			$data = array('file' => $this->upload->data());
			$this->importdata($table);
		}
	}

	public function import($table)
	{
		# code...
       	ini_set('max_execution_time', 30000);
		$config['upload_path']          = 'webfile/';
		$config['allowed_types'] = 'xlsx|csv|xls';
		$config['file_name']            = md5($table).'.xlsx';
		$config['overwrite']            =  TRUE;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}
		else
		{
			$data = array('file' => $this->upload->data());
			$this->importdata($table);
		}
	}

	public function importdata($table)
	{

		$base = $_SESSION['origin_base'];
		$date = $_SESSION['start_date'];

		// if(empty($base)){
			// echo '<h1>Please Fill Date & Base!</h1>';
			// die;
		// }


		if(in_array($table,array('daily_flight_schedule','daily_movement_report'))){
			$table_name = 'daily_flight_schedule';   
		
		}else if(in_array($table,array('daily_ftd_schedule','daily_ftd_report'))){
			$table_name = 'daily_ftd_schedule';   
		}
		else if(in_array($table,array('daily_ground_schedule','daily_attendance_report'))){
			$table_name = 'daily_ground_schedule';   
		}


		# code...
       $this->load->library('excel');
		try 
		{
			$objPHPExcel = PHPExcel_IOFactory::load('webfile/'.md5($table).'.xlsx');
		}
		catch(Exception $e)
		{
			$this->resp->success = FALSE;
			$this->resp->msg = 'Error Uploading file';
			echo json_encode($this->resp);
			exit;
		}
		$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        $query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table_name."' AND COLUMN_KEY = 'PRI'";
        $pri = $this->mymodel->selectWithQuery($query);
        $primary = $pri[0]['COLUMN_NAME'];
        $header = $allDataInSheet[1];
			$i=1;
			$record=0;
			// print_r($allDataInSheet);
			// die;
			foreach($allDataInSheet as $aa=>$import){
                if($i>1){
					$j = 0; 
					// echo $import['L'].' _ '.$import['M'].' _ '.$import['N'];
					// echo '</br>';
					foreach ($import as $key => $value) {
		        	$abjad = $this->template->getNameFromNumber($j);
		        		$kolom = $header[$abjad]; 
		        		if($kolom==$primary){
		        			$update[$record][$kolom] = $value;  
		        		}else{
							$value = strval($value);
							// var_dump(($value));
							if(in_array($table,array('daily_flight_schedule','daily_movement_report'))){
								if($kolom=='date_of_flight'){
									$value = DATE('Y-m-d',strtotime($value));
								}else if($kolom=='eta'){
									$kolom = 'eta_utc';
								}else if($kolom=='etd'){
									$kolom = 'etd_utc';
								}else if($kolom=='irreg_code'){
									$kolom = 'remark_dmr';
								}else if($kolom=='mission'){
									$update[$record]['data']['description'] = $this->mymodel->selectDataOne('tpm_syllabus_all_course',array('code'=>$value));
									$update[$record]['data']['description'] = strval($update[$record]['data']['description']['description']);
								}else if($kolom=='visibility'){
									if(!in_array($value, array('0','1'))){
										$value = '0';
									}
								}else if($kolom=='visibility_report'){
									if(!in_array($value, array('0','1'))){
										$value = '0';
									}
								
								}
							
								
								
								if(in_array($kolom, array('eta_utc','etd_utc','eet','block_time_start','block_time_stop','block_time_total','flight_time_take_off','flight_time_landing','flight_time_total'))){
									
									if(strpos($value, ':') !== false){
										$value_pecah = explode(":",$value);
									}else if(strpos($value, '.') !== false){
										$value_pecah = explode(".",$value);
									}else if($value >= 0 && $value <= 24){
										$value_pecah[0] = $value;
										$value_pecah[1] = '00';
									}else{
										$value_pecah[0] = '00';
										$value_pecah[1] = '00';
									}
									if(strlen($value_pecah[0])=='1'){
										$value_pecah[0] = str_pad(intval($value_pecah[0]), 2, '0', STR_PAD_LEFT);
									}
									if(strlen($value_pecah[1])=='1'){
										$value_pecah[1] = str_pad(intval($value_pecah[1]), 2, '0', STR_PAD_RIGHT);
									}
									if($value_pecah[0] > 24){
										$value_pecah[0] = '00';
									}
									if($value_pecah[1] > 60){
										$value_pecah[1] = '00';
									}
						
									$value =  $value_pecah[0].':'.$value_pecah[1];
									
									
								}

								
							}else if(in_array($table,array('daily_ftd_schedule','daily_ftd_report'))){
								if($kolom=='date'){
									$value = DATE('Y-m-d',strtotime($value));
								}else if($kolom=='etd'){
									$kolom = 'etd_utc';
								}else if($kolom=='eet'){
									$kolom = 'eet_utc';
								}else if($kolom=='irreg_code'){
									$kolom = 'remark_report';
								}else if($kolom=='visibility'){
									if(!in_array($value, array('0','1'))){
										$value = '0';
									}
								}else if($kolom=='visibility_report'){
									if(!in_array($value, array('0','1'))){
										$value = '0';
									}
								
								}

								if(in_array($kolom, array('etd_utc','eta','eet_utc','block_time_atd','block_time_stop','block_time_total','flight_time_take_off','flight_time_landing','flight_time_total'))){
									if(strpos($value, ':') !== false){
										$value_pecah = explode(":",$value);
									}else if(strpos($value, '.') !== false){
										$value_pecah = explode(".",$value);
									}else if($value >= 0 && $value <= 24){
										$value_pecah[0] = $value;
										$value_pecah[1] = '00';
									}else{
										$value_pecah[0] = '00';
										$value_pecah[1] = '00';
									}
									if(strlen($value_pecah[0])=='1'){
										$value_pecah[0] = str_pad(intval($value_pecah[0]), 2, '0', STR_PAD_LEFT);
									}
									if(strlen($value_pecah[1])=='1'){
										$value_pecah[1] = str_pad(intval($value_pecah[1]), 2, '0', STR_PAD_RIGHT);
									}
									if($value_pecah[0] > 24){
										$value_pecah[0] = '00';
									}
									if($value_pecah[1] > 60){
										$value_pecah[1] = '00';
									}
						
									$value =  $value_pecah[0].':'.$value_pecah[1];
							
								}
			
							}else if(in_array($table,array('daily_ground_schedule','daily_attendance_report'))){
								if($kolom=='date'){
									$value = DATE('Y-m-d',strtotime($value));
								}else if($kolom=='start'){
									$kolom = 'start_lt';
								}else if($kolom=='stop'){
									$kolom = 'stop_lt';
								}else if($kolom=='irreg_code'){
									$kolom = 'remark_report';
									$value =  strval($value); 
								}else if($kolom=='visibility'){
									if(!in_array($value, array('0','1'))){
										$value = '0';
									}
								}else if($kolom=='visibility_report'){
									if(!in_array($value, array('0','1'))){
										$value = '0';
									}
								
								}

								if(in_array($kolom, array('start_lt','stop_lt','duration','start_act','stop_act','duration_act'))){
									if(strpos($value, ':') !== false){
										$value_pecah = explode(":",$value);
									}else if(strpos($value, '.') !== false){
										$value_pecah = explode(".",$value);
									}else if($value >= 0 && $value <= 24){
										$value_pecah[0] = $value;
										$value_pecah[1] = '00';
									}else{
										$value_pecah[0] = '00';
										$value_pecah[1] = '00';
									}
									if(strlen($value_pecah[0])=='1'){
										$value_pecah[0] = str_pad(intval($value_pecah[0]), 2, '0', STR_PAD_LEFT);
									}
									if(strlen($value_pecah[1])=='1'){
										$value_pecah[1] = str_pad(intval($value_pecah[1]), 2, '0', STR_PAD_RIGHT);
									}
									if($value_pecah[0] > 24){
										$value_pecah[0] = '00';
									}
									if($value_pecah[1] > 60){
										$value_pecah[1] = '00';
									}
						
									$value =  $value_pecah[0].':'.$value_pecah[1];	
								}
			
							}
							

							$update[$record]['data'][$kolom] = strval($value);  
							
							
					
								$update[$record]['data']['status'] = 'ENABLE';  
								$update[$record]['data']['created_at'] = DATE('Y-m-d H:i:s');
								$update[$record]['data']['created_by'] = $_SESSION['id'];    
							
						}
						
	       			$j++;
	       			}  
	       			$record++;         			
                }
           	$i++;
			}
//aang
// die;
			$this->db->trans_start();

            foreach ($update as $k => $to_table) {
            	// $cekdata = $this->mymodel->selectDataone($table_name,array($primary=>$to_table[$primary]));
            	// if(count($cekdata)==0){
				if(empty($to_table['id'])){
            		$this->mymodel2->insertData($table_name,$to_table['data']);
            	}else{
            		$this->mymodel2->updateData($table_name,$to_table['data'],array($primary=>$to_table[$primary]));
            	}
			}

			$this->db->trans_complete();

			if($table=='daily_flight_schedule'){
				redirect ('master/daily_flight_schedule/create');
			}else if($table=='daily_movement_report'){
				redirect ('master/daily_movement_report');
			}else if($table=='daily_ftd_schedule'){
				redirect ('master/daily_ftd_schedule/create');
			}else if($table=='daily_ftd_report'){
				redirect ('master/daily_ftd_report');
			}else if($table=='daily_ground_schedule'){
				redirect ('master/daily_ground_schedule/create');
			}else if($table=='daily_attendance_report'){
				redirect ('master/daily_attendance_report');
			}
            
	}
	public function access()
	{
		# code...
		$this->db->truncate('access_control');
		// print_r($ci);
		$file = $this->get_uri();
		foreach ($file['file'] as $controller) {
			$con[] = $controller;
			$fol[] = '';
		}
		foreach ($file['folder'] as $folder) {
			$files = $this->get_uri('/'.$folder);
			foreach ($files['file'] as $controller) {
				$con[] = $controller;
				$fol[] = $folder.'/';
			}
		}
		$i=0;
		foreach ($con as $ctrl) {
			if($fol[$i]!="api/"){
	    		include_once APPPATH . 'controllers/' . $fol[$i] .$ctrl;
	    		$methods = get_class_methods( str_replace( '.php', '', $ctrl ) );
	    		foreach ($methods as $mt) {
	    			$data = array(
	    						'folder'=>str_replace("/","",$fol[$i]),
	    						'class'=>str_replace( '.php', '', $ctrl ),
	    						'method'=>$mt,
	    						'val'=>strtolower($fol[$i].str_replace( '.php', '', $ctrl )."/".$mt),
	    					);
	    			$cek = $this->mymodel->selectDataone('access_control',$data);
	    			if(count($cek)==0){
						$this->db->insert('access_control', $data);
	    			}else{
	    				$this->mymodel->updateData('access_control',$data,array('id'=>$cek['id']));
	    			}
	    		}
	    	}
		$i++;
		}
		$json = $this->mymodel->selectData('access_control');
		echo json_encode($json);
	}
	function exportreport()
	{
		$data = $this->session->flashdata('report');
		// print_r($data);
		$this->excel->to_file($data['judul'],$data['head'],$data['data']);
	}
	public function toPdf()
	{
		$this->load->library('pdf');
		$dir ='./webfile/documents/';
		$filename = "Berita Resmi";
		$this->pdf->folder($dir); //Set folder to save PDF to
		$this->pdf->filename($filename.'.pdf');
		$this->pdf->paper('A4', 'portrait');
		$data = $this->load->view('report/bmn-doc/tes.php', @$this->data, true); //view
		$this->pdf->html($data);
		// $this->pdf->create('save'); //Save to path
		$this->pdf->create(); //To open with browser or save to pc
	}
	public function mpdf(){
	$data = [];
    //load the view and saved it into $html variable
    $html=$this->load->view('mpdf/index', $data, true);
    //this the the PDF filename that user will get to download
    $pdfFilePath = "output_pdf_name.pdf";
    //load mPDF library
    $this->load->library('m_pdf');
   //generate the PDF from the given html
    $this->m_pdf->pdf->WriteHTML($html);
    //download it.
    $this->m_pdf->pdf->Output($pdfFilePath, "D");     
	}
	

}
/* End of file Fitur.php */
/* Location: ./application/controllers/Fitur.php */