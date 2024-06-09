<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kebijakanprivasi extends MY_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$data['page'] = 'Kebijakan & Privasi';
		$this->template->load('template/template','kebijakanprivasi/index', $data); 
	}
	
}