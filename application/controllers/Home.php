<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}


    
		public function send(){
			
    
		
		}

		
            

		function send_2(){
            $subject = 'Testing Aktivasi Akun Job Fair Active Pemerintah Kota Malang';
			$from = 'info@jobfairactive.com';
			$to = 'amuammarzein@gmail.com';
			$id = $this->template->sonEncode(1);
	
			
			$content['body_email'] = '
			<p class="text-left"><p class="text-left">Selamat Datang di Job Fair Active!</p>
			<p class="text-left" style="margin-bottom:30px;">Terima kasih telah bergabung dengan Job Fair Active. Untuk melakukan aktivasi akun anda silakan klik link di bawah ini:</p>
			<a style="background:#0f158c;border-radius:15px;padding:10px;color:#fff;text-decoration: none;
			border: 1px solid #0f158c;" href="'.WEB.'auth/activation/'.$id.'">AKTIVASI AKUN</a>
			
			<p class="text-left" style="margin-top:30px;">Salam Sukses!</p>
			<p class="text-left">Tim Job Fair Active</p>';
			$message = $this->mymodel->body_email($content);
	
			$this->load->library('email');

			$config = array(
				'protocol'  => 'smptp',
				'smtp_host' => 'ssl://jobfairactive.com',
				'smtp_port' => 465,
				'smtp_user' => 'info@jobfairactive.com',
				'smtp_pass' => 'sL)N;QBpvsx6',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE
			);
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			
			$fromname = 'Job Fair Active Pemerintah Kota Malang';
	
			$this->email->to($to);
			$this->email->from($from, $fromname);
			$this->email->subject($subject);
			$this->email->message($message);
			$send = $this->email->send();
			print_r($send);
	
	
			echo $this->email->print_debugger();

		}


	public function index()
	{
		$data['page_name'] = "home";
		$this->template->load('template/template','template/index',$data);
		
	}

    function chart($value='')
    {
        $data['page_name'] = "chart";
        $this->template->load('template/template','chartscanvasjs/index',$data);
    }



    function get_autocomplete(){
        if (isset($_GET['term'])) {
        	$this->db->like('name',$_GET['term'],'both');
            $result = $this->mymodel->selectWhere('user',null);
            if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = [
                				'id'=>$row['id'],
                				'label'=>$row['name']
                				];

                echo json_encode($arr_result);
            }
        }
    }


    public function tes()
    {
        echo "'".$this->template->sonDecode('V7-BW2sw1V5UHGX51TW3mmm1s87WfWK0-3_tBBlBpbU~')."'";
        
    }

   

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */