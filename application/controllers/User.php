

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class User extends MY_Controller {



    public function __construct()

    {

        parent::__construct();

    }



    public function index()

    {

        // $data['page_name'] = "user";

        // $this->template->load('template/template','master/user/all-user',$data);

    }


    public function validate()

    {

        $this->form_validation->set_error_delimiters('<li>', '</li>');

		$this->form_validation->set_rules('dt[full_name]', '<strong>Full Name</strong>', 'required');
		$this->form_validation->set_rules('dt[nick_name]', '<strong>Nick Name</strong>', 'required');
		$this->form_validation->set_rules('dt[email]', '<strong>Email</strong>', 'required');
	// $this->form_validation->set_rules('dt[role]', '<strong>Role</strong>', 'required');
// $this->form_validation->set_rules('dt[role_id]', '<strong>Role Id</strong>', 'required');
// $this->form_validation->set_rules('dt[base]', '<strong>Base</strong>', 'required');
}



    public function edit()

    {

		$id = $_SESSION['id'];
        $data['user'] = $this->mymodel->selectDataone('user',array('id'=>$id));
        $data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));
        $data['file_signature'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'file_signature'));
        
        $data['page_name'] = "user";
		if($_SESSION['role']!='4'){
			$this->template->load('template/template','master/user/edit',$data);
		}else{
			$this->template->load('template/template','master/user/edit-student',$data);
		}
      

    }



	public function update()

		{	

			$this->validate();

			$dt = $_POST['dt'];
			$id = $_SESSION['id'];
			$nick_name =  $dt['nick_name'];
			$id_number =  $dt['id_number'];
		   $user = $this->mymodel->selectDataOne('user',"nick_name = '$nick_name' AND id != '$id'");
   
		   $user2 = $this->mymodel->selectDataOne('user',"id_number = '$id_number' AND id != '$id'");

		   if($user){
			   $this->alert->alertdanger('nick name already in use. please use another nickname!');     
			   die;
		   }else if($user2){
				$this->alert->alertdanger('id number already in use. please use another id number!');     
				die;
			}else if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());  
			}else{

				$id = $this->input->post('id', TRUE);

	        	if (!empty($_FILES['file']['name'])){

	        		$dir  = "webfile/";

					$config['upload_path']          = $dir;

					$config['allowed_types']        = '*';

					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

	        		$this->load->library('upload', $config);

				if ( ! $this->upload->do_upload('file')){

						$error = $this->upload->display_errors();

						$this->alert->alertdanger($error);		

					}else{

						$file = $this->upload->data();

						$data = array(

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				// 'size'=> $file['file_size'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'user',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}



					}

				}

				if (!empty($_FILES['file_signature']['name'])){

					$dir  = "webfile/";
					
					$config['upload_path']          = $dir;
					
					$config['allowed_types']        = '*';
					
					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);
					
					$this->load->library('upload', $config);
					
					if ( ! $this->upload->do_upload('file_signature')){
					
						$error = $this->upload->display_errors();
					
						$this->alert->alertdanger($error);		
					
					}else{
					
						$file = $this->upload->data();
					
						$data = array(
					
									   'name'=> $file['file_name'],
					
									   'mime'=> $file['file_type'],
					
									   // 'size'=> $file['file_size'],
					
									   'dir'=> $dir.$file['file_name'],
					
									   'table'=> 'file_signature',
					
									   'table_id'=> $id,
					
									   'updated_at'=>date('Y-m-d H:i:s')
					
									);
					
						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'file_signature'));
					
						@unlink($file['dir']);
					
						if($file==""){
					
							$this->mymodel->insertData('file', $data);
					
						}else{
					
							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
					
						}
					
					
					
					}
					
					}
				


				$dt = $_POST['dt'];

				if($_POST['password']){
					$dt['password'] = md5($_POST['password']);
				}
				$dt['updated_at'] = date("Y-m-d H:i:s");

				$str =  $this->mymodel->updateData('user', $dt , array('id'=>$id));

				return $str;  

			}

		}






}

?>