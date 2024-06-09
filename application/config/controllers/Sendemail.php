<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sendemail extends My_Controller {

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$data['page_name'] = "Send Email";

		$query = $this -> db -> get('konfig_email');
		foreach ($query->result() as $datas) {
			$option[$datas->ke_slug]=$datas->ke_content;
		}
		
		$data['konfig'] = $option;

		
		$this->template->load('template/template','sendemail/index',$data);
	}

	public function send()
	{
		$emailpenerima =$this->input->post('email');

		$query = $this -> db -> get('konfig_email');
		foreach ($query->result() as $datas) {
			$option[$datas->ke_slug]=$datas->ke_content;
		}

		$konfigmail['logo'] = $option['logo'];
		$konfigmail['namaperusahaan'] = $option['perusahaan'];
		$konfigmail['body'] = $option['body'];
		$konfigmail['footer'] = $option['footer'];
		$konfigmail['warna'] = $option['warna'];


		$template = $this->load->view('sendemail/template',$konfigmail,true);
		$sub = 'TEST MAIL';


		$this->sendmails('mailer@gatoko1.com',$emailpenerima,$sub,$template);
	}



	public function update()
	{

		$param = $this->input->post();
		$slug = array_keys($param);
		foreach ($slug as $slug) {
			$this->db->where('ke_slug', $slug);
			$result = $this->db->update('konfig_email', array('ke_content' => $param[$slug]));		
		}
		$this->alert->alertsuccess('Success Update Data');
	}



	public function template()
	{
		$data['page_name'] = "template";

		$this->load->view('sendemail/template',$data);
	}


	

	
	

}

/* End of file Tinymce.php */
/* Location: ./application/controllers/Tinymce.php */