<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model {

		public function __construct()
		{
			$this->load->database(); 
		}

		public function selectData($table)
		{
			$query = $this->db->get($table);
			return $query->result_array();
		}

		public function selectWithQuery($str)
    	{
    		$query = $this->db->query($str);
    		return $query->result_array();
    	}


		public function selectWhere($table,$where)
		{
				$query = $this->db->get_where($table,$where);
				return $query->result_array();
		 }

		public function selectDataone($table,$where)
		{
				$query = $this->db->get_where($table,$where);
				return $query->row_array();
		}

		public function deleteData($table,$id)
		{


			$this->db->where($id);
			$cekdata = $this->db->get($table)->result_array();

			$datajson ='';
			foreach ($cekdata as $key => $value) {
				$datajson = $datajson.json_encode($value);
			}

			if(count($cekdata) > 0){
			$datalog = array(
				'log_created_at' => date('Y-m-d H:i:s'),
				'log_created_by' => $this->session->userdata('id'),
				'log_action' => 'deleteData',
				'log_tablename' => $table,
				'log_jsondata' => $datajson,
			);

			$resultlog = $this->db->insert('log_aktivitas',$datalog);

			$this->db->where($id);
			$result = $this->db->delete($table);
			// return $this->alert->alertdanger('Success Delete Data');

			}else{

			// return  $this->alert->alertdanger("ID data tidak ditemukan");
			
			}
			
		}

		public function insertData($table,$data)
		{

			$datalog = array(
				'log_created_at' => date('Y-m-d H:i:s'),
				'log_created_by' => $this->session->userdata('id'),
				'log_action' => 'insertData',
				'log_tablename' => $table,
				'log_jsondata' => json_encode($data),
			);

			$resultlog = $this->db->insert('log_aktivitas',$datalog);

			$result = $this->db->insert($table,$data);

			return $result;
		}


		public function updateData($table,$data,$where)
		{
			$this->db->where($where);
			$cekdata = $this->db->get($table)->result_array();

			$datajson ='';
			foreach ($cekdata as $key => $value) {
				$datajson = $datajson.json_encode($value);
			}

			if(count($cekdata) > 0){
			$datalog = array(
				'log_created_at' => date('Y-m-d H:i:s'),
				'log_created_by' => $this->session->userdata('id'),
				'log_action' => 'updateData',
				'log_tablename' => $table,
				'log_jsondata' => $datajson,
			);

			$resultlog = $this->db->insert('log_aktivitas',$datalog);

			$result = $this->db->update($table,$data,$where);
			return $this->alert->alertsuccess('Success Update Data');

			}else{

				return  $this->alert->alertdanger("ID data tidak ditemukan");
			}


		}


		function body_email($val){
			
			$text = '<!doctype html>
			<html>
			  <head>
				<meta name="viewport" content="width=device-width">
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<title>Daily Flight Schedule</title>
				<link rel="preconnect" href="https://fonts.gstatic.com">
				<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
				<style>
				body,*{
					font-family: "Poppins", sans-serif;
					text-align: center;
					font-size:15px;
				}
				tr,th,td{
				padding:5px;
				border:1px #000 solid;
				}
				.bg-success{
					background:#066265!important;
					color:#fff;
				}
				.text-left{
					text-align:left!important;
				}
				.text-center{
					text-align:center;
				}
				table{
					width: 100%;
  					border-collapse: collapse;
				}
				.no-border{
					border:1px #fff solid!important;
				}
				p{
					text-align:left;
					padding:0px;
					margin:0px;
				}
				</style>
			  </head>
			  <body class="" style="">
			  '.$val['body_email'].'
			  BIFA,Bali International Flight Academy. PT.Bali Widya Dirgantara
			  <br>
			  Sovereign Plaza 11th Floor Jl. T.B. Simatupang kav.36 Jakarta 12430, Indonesia
			  <br>
			  info@baliflightacademy.com | 021 29400123 	
			  <br>
			  Build with <a href="https://karyastudio.com">Karya Studio Teknologi Digital</a> on '.DATE('d M Y H:i:s').'
			  </body>
			</html>';
			return $text;
		}

}