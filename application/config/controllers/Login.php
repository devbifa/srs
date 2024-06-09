<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Login extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

	}



	public function index()

	{

        if(LOGIN==0){

		  $this->load->view('login/login');

        }else{

          $this->load->view('login/login-1');

        }

	}



	public function logout()

	{

		# code...

        $this->session->sess_destroy();

		redirect('login');

	}





	   public function act_login()

    {

            $username = $this->input->post('username');

            $password = $this->input->post('password');

            // $acak = "!@#$%^&*()_+SMARTSOFT+_()*&^%$#@!";

             $pass = md5($password);



            $cek     = $this->mlogin->login($username,$pass);

            $session = $this->mlogin->data($username);

            if ($cek > 0) {

                $this->session->set_userdata('session_sop', true);

                $this->session->set_userdata('id', $session['id']);

                $this->session->set_userdata('id_number', $session['id_number']);

                

                $this->session->set_userdata('role', $session['role']);

                $this->session->set_userdata('name', $session['full_name']);

                $this->session->set_userdata('json', $session);





                echo "oke";

                return TRUE;

            } else {

               echo '<div class="alert alert-danger ks-solid ks-active-border" role="alert">	<button type="button" class="close" data-dismiss="alert" aria-label="Close">		<span aria-hidden="true" class="mdi mdi-close"></span>	</button>	
            
Your username or password is wrong. Try again.</div>';
                return FALSE;



            }

    }

        function lockscreen()

    {

        $this->load->view('login/lockscreen');

    }



}



/* End of file Login.php */

/* Location: ./application/controllers/Login.php */