

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Curriculum extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}

		function print_mission(){
			$key = $_GET['key'];
			$id = $this->uri->segment(4);
			$data = array();
			$data['data'] = $this->mymodel->selectDataOne('syllabus_curriculum',"id = '$id'");
			if($key){
				$data['type_of_training'] = $this->mymodel->selectDataOne('syllabus_type_of_training',"code = '$key'");
				$this->load->view('syllabus/curriculum/print_mission',$data);
			}else{
				$this->load->view('syllabus/curriculum/print_bifa_course',$data);
			}
		}


		public function index()

		{

			$data['page_name'] = "curriculum";

			$this->template->load('template/template','syllabus/curriculum/all',$data);

		}

		public function create()

		{

			$data['page_name'] = "curriculum";

			$this->template->load('template/template','syllabus/curriculum/add',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
$this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
	}



		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt_2 = $_POST['dt'];

				$code = $dt_2['code'];
				$dat = $this->mymodel->selectDataOne('syllabus_curriculum',"code = '$code'");
				if($dat){
					$this->alert->alertdanger('Curriculum code already used!');     
					die;
				}
				
				$dt = $_POST['dt'];
				
				$arr = $_POST['type_of_training'];
				foreach($arr as $k=>$v){
					if($v=='ON'){
						$type[$k]['status'] = "ON";
					}
				}
				$dt['type_of_training'] = json_encode($type,true);

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('syllabus_curriculum', $dt);

				$last_id = $this->db->insert_id();	    if (!empty($_FILES['file']['name'])){

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

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'syllabus_curriculum',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Insert Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'syllabus_curriculum',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Insert Data');



					}

					    

					

			}

		}

		public function clone_process()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt_2 = $_POST['dt'];

				$code = $dt_2['code'];
				$dat = $this->mymodel->selectDataOne('syllabus_curriculum',"code = '$code'");
				if($dat){
					$this->alert->alertdanger('Curriculum code already used!');     
					die;
				}

				
				$id = $_POST['id'];

				$data['data'] = $this->mymodel->selectDataone('syllabus_curriculum',array('id'=>$id));
				if(empty($data['data'])){
					$this->alert->alertdanger("Curriculum data not found!");
					die;
				}
				
				$dt = $data['data'];
				unset($dt['id']);
				
				$dt['code'] = $dt_2['code'];
				$dt['name'] = $dt_2['name'];
				$dt['description'] = $dt_2['description'];

				$arr = $_POST['type_of_training'];
				foreach($arr as $k=>$v){
					if($v=='ON'){
						$type[$k]['status'] = "ON";
					}
				}
				$dt['type_of_training'] = json_encode($type,true);
				

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('syllabus_curriculum', $dt);

				$last_id = $this->db->insert_id();	    if (!empty($_FILES['file']['name'])){

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

					   				'id' => '',

					   				'name'=> $file['file_name'],

					   				'mime'=> $file['file_type'],

					   				'dir'=> $dir.$file['file_name'],

					   				'table'=> 'syllabus_curriculum',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Insert Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'syllabus_curriculum',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Insert Data');



					}

					    

					

			}

		}


		public function json()

		{

			$status = $_GET['status'];

			if($status==''){

				$status = 'ENABLE';

			}

			header('Content-Type: application/json');

	        $this->datatables->select('a.id,a.effective_date,a.description,a.code,a.code_name,a.name,a.status,a.position');

	        $this->datatables->where('a.status',$status);

	        $this->datatables->from('syllabus_curriculum a');


	        if($status=="ENABLE"){

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm btn-primary btn-block" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			', 'id');



	    	}else{

			$this->datatables->add_column('view', '
			<button type="button" class="btn btn-sm mb-5 btn-primary btn-block" onclick="preview($1)"><i class="fa fa-pencil"></i> PREVIEW</button>
			<button type="button" class="btn btn-sm mb-5 btn-primary" onclick="edit($1)"><i class="fa fa-pencil"></i> EDIT</button>
			<button type="button" onclick="hapus($1)" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> HAPUS</button>', 'id');



	    	}

	        echo $this->datatables->generate();

		}

		public function configuration($id)

		{

			$data['data'] = $this->mymodel->selectDataone('syllabus_curriculum',array('id'=>$id));
			if(empty($data['data'])){
				redirect(base_url().'syllabus/curriculum');
			}
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_curriculum'));
			$data['page_name'] = "curriculum";

			$this->template->load('template/template','syllabus/curriculum/configuration',$data);

		}

		public function edit($id)

		{

			$data['data'] = $this->mymodel->selectDataone('syllabus_curriculum',array('id'=>$id));
			if(empty($data['data'])){
				redirect(base_url().'syllabus/curriculum');
			}
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_curriculum'));
			$data['page_name'] = "curriculum";

			$this->template->load('template/template','syllabus/curriculum/edit',$data);

		}

		public function clone($id)

		{

			$data['data'] = $this->mymodel->selectDataone('syllabus_curriculum',array('id'=>$id));
			if(empty($data['data'])){
				redirect(base_url().'syllabus/curriculum');
			}
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_curriculum'));
			$data['page_name'] = "curriculum";

			$this->template->load('template/template','syllabus/curriculum/clone',$data);

		}

		function update_1(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['type_of_training'],true);
			if($_POST['val']=='ON'){
				$arr[$_POST['id']]['status'] = 'ON';
			}else{
				unset($arr[$_POST['id']]['status']);
			}
			$dt['type_of_training'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		function update_2(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['course'],true);
			if($_POST['val']=='ON'){
				$arr[$_POST['id_parent']][$_POST['id']]['status'] = 'ON';
			}else{
				unset($arr[$_POST['id_parent']][$_POST['id']]['status']);
			}
			$dt['course'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		function update_3(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			if($_POST['val']=='ON'){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['status'] = 'ON';
			}else{
				unset($arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]);
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}
		function update_4(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			$_POST['val'] = $this->template->to_utc($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration'] = $_POST['val'];
			}else{
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration'] = '-';
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}
		function update_5(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			$_POST['val'] = $this->template->to_number_pure($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['price'] = $_POST['val'];
			}else{
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['price'] = '0';
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		
		function update_6(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			// $_POST['val'] = $this->template->to_number_pure($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_dual'] = $_POST['val'];
			}else{
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_dual'] = '-';
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		function update_7(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			// $_POST['val'] = $this->template->to_number_pure($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_solo'] = $_POST['val'];
			}else{
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_solo'] = '-';
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		function update_8(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			// $_POST['val'] = $this->template->to_number_pure($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_pic'] = $_POST['val'];
			}else{
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_pic'] = '-';
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		function update_9(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			// $_POST['val'] = $this->template->to_number_pure($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_pic_solo'] = $_POST['val'];
			}else{
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_pic_solo'] = '-';
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		function update_10(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['mission'],true);
			// $_POST['val'] = $this->template->to_number_pure($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_non_rev'] = $_POST['val'];
			}else{
				$arr[$_POST['id_type']][$_POST['id_parent']][$_POST['id']]['duration_non_rev'] = '-';
			}
			
			$dt['mission'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		
		function update_11(){
			$data = $this->mymodel->selectDataOne('syllabus_curriculum',array('id'=>$_POST['id_curriculum']));
			$arr = json_decode($data['course'],true);
			$_POST['val'] = $this->template->to_number_pure($_POST['val']);
			if($_POST['val']){
				$arr[$_POST['id_parent']][$_POST['id']]['price'] = $_POST['val'];
			}else{
				$arr[$_POST['id_parent']][$_POST['id']]['price'] = '0';
			}
			$dt['course'] = json_encode($arr,true); 
			$this->db->update('syllabus_curriculum',$dt,array('id'=>$_POST['id_curriculum']));
		}

		public function preview($id)

		{

			$data['data'] = $this->mymodel->selectDataone('syllabus_curriculum',array('id'=>$id));
			if(empty($data['data'])){
				redirect(base_url().'syllabus/curriculum');
			}
			$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_curriculum'));
			$data['page_name'] = "curriculum";

			$this->template->load('template/template','syllabus/curriculum/preview',$data);

		}





		public function update()

		{	

			$this->validate();

			



	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$id = $this->input->post('id', TRUE);
				$dt = $_POST['dt'];
				$code = $dt['code'];
				
				$dat = $this->mymodel->selectDataOne('syllabus_curriculum',"code = '$code' AND id != '$id'");
   
				if($dat){
					$this->alert->alertdanger('Curriculum code already used!');    
					die;
				}

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

					   				'table'=> 'syllabus_curriculum',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_curriculum'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						$arr = $_POST['type_of_training'];
						foreach($arr as $k=>$v){
							if($v=='ON'){
								$type[$k]['status'] = "ON";
							}
						}
						$dt['type_of_training'] = json_encode($type,true);

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('syllabus_curriculum', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					$arr = $_POST['type_of_training'];
					foreach($arr as $k=>$v){
						if($v=='ON'){
							$type[$k]['status'] = "ON";
						}
					}
					$dt['type_of_training'] = json_encode($type,true);

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('syllabus_curriculum', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete($id)

		{

				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_curriculum'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'syllabus_curriculum'));



				$str = $this->mymodel->deleteData('syllabus_curriculum',  array('id'=>$id));
				redirect(base_url().'syllabus/curriculum');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('syllabus_curriculum',array('status'=>$status),array('id'=>$id));


			redirect('syllabus/Classroom');

		}





	}

?>