<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backupdb extends My_Controller {

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$data['page_name'] = "Backupdb";
		$data['backupdb'] = $this->mymodel->selectData('log_backupdb');

		$this->template->load('template/template','backupdb/index',$data);
	}

	public function getbackupdb()
	{
		$this->load->dbutil();

		$prefs = array(     
			'format'      => 'zip',             
			'filename'    => $this->db->database.'.sql'
		);

		$backup = $this->dbutil->backup($prefs); 

		$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
		$save = 'backupDatabase/'.$db_name;

		$this->load->helper('file');
		$simpandb = write_file($save, $backup);
		$getsize = filesize($save);
		$bytes = filesize($save);

		if ($bytes >= 1073741824)
		{
			$bytes = number_format($bytes / 1073741824, 2) . ' GB';
		}
		elseif ($bytes >= 1048576)
		{
			$bytes = number_format($bytes / 1048576, 2) . ' MB';
		}
		elseif ($bytes >= 1024)
		{
			$bytes = number_format($bytes / 1024, 2) . ' KB';
		}
		elseif ($bytes > 1)
		{
			$bytes = $bytes . ' bytes';
		}
		elseif ($bytes == 1)
		{
			$bytes = $bytes . ' byte';
		}
		else
		{
			$bytes = '0 bytes';
		}

		if($simpandb){
			$datalog = array(
				'bdb_file' =>  $db_name,
				'bdb_size' =>  $getsize,
				'bdb_sizedisplay' =>  $bytes,
				'bdb_created_at' => date("Y-m-d-H-i-s"),
				'bdb_created_by' => $this->session->userdata('id')
			);
			$strlog = $this->db->insert('log_backupdb',$datalog);


			$this->session->set_flashdata('sukses', 'Success Backup DataBase');
		}

		redirect('backupdb','refresh');
	}

	function getbackupfile(){
		if($_SESSION['role'] == '1'){
			$name = 'backup_dokumen_rims_'.DATE('Y-m_d_H_i_s');
			$this->load->library('zip');
			$path='D:\\xampp73\\htdocs\\bifa\\webfile\\batch\\';
			$this->zip->read_dir($path); 
			$this->zip->download($name.'.zip'); 
		}else{
			redirect(base_url());
		}
	}
	function restore_file(){
		sleep(5);
		redirect(base_url().'backupdb');
	}

	function restore_database(){
		sleep(5);
		redirect(base_url().'backupdb');
	}
	public function json()
	{
		header('Content-Type: application/json');
		$this->datatables->select('log_backupdb.bdb_id, log_backupdb.bdb_file, log_backupdb.bdb_size, log_backupdb.bdb_created_at,log_backupdb.bdb_sizedisplay, log_backupdb.bdb_created_by,user.full_name as name');
		$this->datatables->from('log_backupdb');
		$this->datatables->join('user','user.id=log_backupdb.bdb_created_by');
		
		$this->datatables->add_column('view', '<button type="button" class="btn btn-sm btn-success" onclick="download($1)"><i class="fa fa-download"></i> Download</button></div>', 'bdb_id');
		
		echo $this->datatables->generate();
	}

	function downloaddb($id)
	{

		$getdata = $this->mymodel->selectDataone('log_backupdb',array('bdb_id'=>$id));
		$pathdata = 'backupDatabase/'.$getdata['bdb_file'];
		$this->load->helper('download');
		force_download($pathdata, NULL);
	}

	

}

/* End of file Tinymce.php */
/* Location: ./application/controllers/Tinymce.php */