<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_aktivitas extends My_Controller {

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$data['page_name'] = "Backupdb";
		$data['backupdb'] = $this->mymodel->selectData('log_aktivitas');

		$this->template->load('template/template','log_aktivitas/index',$data);
	}


	public function json()
	{
		header('Content-Type: application/json');
		$this->datatables->select('log_aktivitas.log_id as log_id,log_aktivitas.log_created_at,log_aktivitas.log_created_by,log_aktivitas.log_action,log_aktivitas.log_tablename,log_aktivitas.log_jsondata,user.name');
		$this->datatables->join('user','user.id=log_aktivitas.log_created_by');
		$this->datatables->from('log_aktivitas');

		
		echo $this->datatables->generate();
	}

	
	

}

/* End of file Tinymce.php */
/* Location: ./application/controllers/Tinymce.php */