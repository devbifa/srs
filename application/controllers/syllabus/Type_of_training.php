

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Type_of_training extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

	}

	function get_course(){
		$type = $_GET['type'];
		$this->db->order_by('position ASC');
		$qry = '"'.$type.'":{"status":"ON"}';
		$arr = $this->mymodel->selectWithQuery("SELECT *
		FROM syllabus_course
		WHERE type_of_training LIKE '%$qry%'
		ORDER BY position ASC");
		foreach($arr as $k=>$v){
			$text .= '<option value="'.$v['code'].'">'.$v['code'].' - '.$v['name'].'</option>';
		}
		echo $text;
	}


	public function index()

	{

		$data['page_name'] = "type_of_training";

		$this->template->load('template/template','syllabus/type_of_training/all',$data);

	}

	public function create()

	{

		$data['page_name'] = "type_of_training";

		$this->template->load('template/template','syllabus/type_of_training/add',$data);

	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

$this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
// $this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
// $this->form_validation->set_rules('dt[type_of_training]', '<strong>Type of Training</strong>', 'required');
// $this->form_validation->set_rules('dt[course]', '<strong>Course</strong>', 'required');
}




	public function store()

	{

		$this->validate();

		if ($this->form_validation->run() == FALSE){

			$this->alert->alertdanger(validation_errors());     

		}else{

			$dt_2 = $_POST['dt'];

			$code = $dt_2['code'];
			$dat = $this->mymodel->selectDataOne('syllabus_type_of_training',"code = '$code'");
			if($dat){
				$this->alert->alertdanger('Type of training code already used!');     
				die;
			}
			

			$dt = $_POST['dt'];
			
			$dt['created_by'] = $_SESSION['id'];

			$dt['created_at'] = date('Y-m-d H:i:s');

			$dt['status'] = "ENABLE";

			$str = $this->mymodel->insertData('syllabus_type_of_training', $dt);

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

								   'table'=> 'syllabus_type_of_training',

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

							   'table'=> 'syllabus_type_of_training',

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

		$this->datatables->select('a.id,a.code,a.name,a.status,a.position');


		$this->datatables->from('syllabus_type_of_training a');

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

	public function edit($id)

	{

		$data['data'] = $this->mymodel->selectDataone('syllabus_type_of_training',array('id'=>$id));
		if(empty($data['data'])){
			redirect(base_url().'syllabus/type_of_training');
		}
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_type_of_training'));
		$data['page_name'] = "type_of_training";


		$this->template->load('template/template','syllabus/type_of_training/edit',$data);

	}
	
	public function preview($id)

	{

		$data['syllabus_type_of_training'] = $this->mymodel->selectDataone('syllabus_type_of_training',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_type_of_training'));$data['page_name'] = "type_of_training";

		$this->template->load('template/template','syllabus/type_of_training/preview',$data);

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
			
			$dat = $this->mymodel->selectDataOne('syllabus_type_of_training',"code = '$code' AND id != '$id'");

			if($dat){
				$this->alert->alertdanger('Type of training code already used!');    
				die;
			}

			$dat = $this->mymodel->selectDataOne('syllabus_type_of_training',"id = '$id'");
			if($dat['code']=='FLIGHT' AND $dt['code']!='FLIGHT'){
				$this->alert->alertdanger('This data cannot be changed!');    
				die;
			}else if($dat['code']=='SIM' AND $dt['code']!='SIM'){
				$this->alert->alertdanger('This data cannot be changed!');    
				die;
			}else if($dat['code']=='GROUND' AND $dt['code']!='GROUND'){
				$this->alert->alertdanger('This data cannot be changed!');    
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

								   'table'=> 'syllabus_type_of_training',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);

					$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_type_of_training'));

					@unlink($file['dir']);

					if($file==""){

						$this->mymodel->insertData('file', $data);

					}else{

						$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

					}

					



					$dt = $_POST['dt'];

					
					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str =  $this->mymodel->updateData('syllabus_type_of_training', $dt , array('id'=>$id));

					return $str;  


				}

			}else{

				$dt = $_POST['dt'];

			
				$dt['updated_at'] = date("Y-m-d H:i:s");

				$str = $this->mymodel->updateData('syllabus_type_of_training', $dt , array('id'=>$id));

				return $str;  

			}}

	}



	public function delete($id)

	{

			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_type_of_training'));

			@unlink($file['dir']);

			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'syllabus_type_of_training'));


			// $str = $this->mymodel->deleteData('syllabus_type_of_training',  "id = $id AND code NOT IN (FLIGHT','SIM','GROUND') ");
			$str = $this->mymodel->deleteData('syllabus_type_of_training',  "id = $id AND code NOT IN ('FLIGHT','SIM','GROUND') ");
			
			redirect(base_url().'syllabus/type_of_training');
			


	}



	public function status($id,$status)

	{

		$this->mymodel->updateData('syllabus_type_of_training',array('status'=>$status),array('id'=>$id));


		redirect('syllabus/type_of_training');

	}





}

?>