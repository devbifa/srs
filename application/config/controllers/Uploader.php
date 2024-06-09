<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Uploader extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['page_name'] = "Uploader";
		$this->template->load('template/template','uploader/index',$data);
		
	}

	public function prosesuploadAjax()
	{
		$directory = 'webfile/testing/';
		$filename = 'tested';
		$allowed_types = 'gif|jpg|png';
		$result = $this->uploadfile->upload('file',$filename,$directory,$allowed_types);
		if($result['alert'] == 'success'){
		$this->alert->alertsuccess('Success Upload Data');
		}else{
		$this->alert->alertdanger($result['message']);
		}


	}




}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */