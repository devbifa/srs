

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Mission extends MY_Controller {



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

		$data['page_name'] = "mission";

		$this->template->load('template/template','syllabus/mission/all',$data);

	}

	public function create()

	{

		$data['page_name'] = "mission";

		$this->template->load('template/template','syllabus/mission/add',$data);

	}

	public function validate()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

$this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
$this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
$this->form_validation->set_rules('dt[type_of_training]', '<strong>Type of Training</strong>', 'required');
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
			$dat = $this->mymodel->selectDataOne('syllabus_mission',"code = '$code'");
			if($dat){
				$this->alert->alertdanger('Mission code already used!');     
				die;
			}
			

			$dt = $_POST['dt'];
			
			// $arr = $_POST['type_of_training'];
			// foreach($arr as $k=>$v){
			// 	if($v=='ON'){
			// 		$type[$k]['status'] = "ON";
			// 	}
			// }
			// $dt['type_of_training'] = json_encode($type,true);

			$dt['created_by'] = $_SESSION['id'];

			$dt['created_at'] = date('Y-m-d H:i:s');

			$dt['status'] = "ENABLE";

			$str = $this->mymodel->insertData('syllabus_mission', $dt);

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

								   'table'=> 'syllabus_mission',

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

							   'table'=> 'syllabus_mission',

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

		$this->datatables->select('a.id,a.code,CONCAT(a.code_name," - ",a.name) as code_name,a.status,CONCAT(a.type_of_training," - ",b.code_name) as type_of_training,CONCAT(a.type," ",a.type_sub) as type,a.position');

		$this->datatables->where('a.status',$status);

		$this->datatables->from('syllabus_mission a');
		$this->datatables->join('syllabus_course b','a.course = b.code');
		


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

		$data['data'] = $this->mymodel->selectDataone('syllabus_mission',array('id'=>$id));
		if(empty($data['data'])){
			redirect(base_url().'syllabus/mission');
		}
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_mission'));
		$data['page_name'] = "syllabus_mission";


		$this->template->load('template/template','syllabus/mission/edit',$data);

	}
	
	public function preview($id)

	{

		$data['syllabus_mission'] = $this->mymodel->selectDataone('syllabus_mission',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_mission'));$data['page_name'] = "mission";

		$this->template->load('template/template','syllabus/mission/preview',$data);

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
			
			$dat = $this->mymodel->selectDataOne('syllabus_mission',"code = '$code' AND id != '$id'");

			if($dat){
				$this->alert->alertdanger('Mission code already used!');    
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

								   'table'=> 'syllabus_mission',

								   'table_id'=> $id,

								   'updated_at'=>date('Y-m-d H:i:s')

								);

					$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_mission'));

					@unlink($file['dir']);

					if($file==""){

						$this->mymodel->insertData('file', $data);

					}else{

						$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

					}

					



					$dt = $_POST['dt'];

					$mission = $this->mymodel->selectDataOne('syllabus_mission',array('id'=>$id));
					if($dt['type_of_training']=="FLIGHT"){
						$dts = array();
						$dts['mission'] = $dt['code'];
						$dts['updated_at'] = DATE('Y-m-d H:i:s');
						$this->db->update('daily_flight_schedule',$dts,array('mission'=>$mission['code']));
					}else if($dt['type_of_training']=="FTD"){
						$dts = array();
						$dts['mission'] = $dt['code'];
						$dts['updated_at'] = DATE('Y-m-d H:i:s');
						$this->db->update('daily_ftd_schedule',$dts,array('mission'=>$mission['code']));
					}else if($dt['type_of_training']=="GROUND"){
						$dts = array();
						$dts['subject'] = $dt['code'];
						$dts['updated_at'] = DATE('Y-m-d H:i:s');
						$this->db->update('daily_ground_schedule',$dts,array('subject'=>$mission['code']));
					}
					

					// $arr = $_POST['type_of_training'];
					// foreach($arr as $k=>$v){
					// 	if($v=='ON'){
					// 		$type[$k]['status'] = "ON";
					// 	}
					// }
					// $dt['type_of_training'] = json_encode($type,true);

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str =  $this->mymodel->updateData('syllabus_mission', $dt , array('id'=>$id));

					return $str;  


				}

			}else{

				$dt = $_POST['dt'];
				$mission = $this->mymodel->selectDataOne('syllabus_mission',array('id'=>$id));
				if($dt['type_of_training']=="FLIGHT"){
					$dts = array();
					$dts['mission'] = $dt['code'];
					$dts['updated_at'] = DATE('Y-m-d H:i:s');
					$this->db->update('daily_flight_schedule',$dts,array('mission'=>$mission['code']));
				}else if($dt['type_of_training']=="FTD"){
					$dts = array();
					$dts['mission'] = $dt['code'];
					$dts['updated_at'] = DATE('Y-m-d H:i:s');
					$this->db->update('daily_ftd_schedule',$dts,array('mission'=>$mission['code']));
				}else if($dt['type_of_training']=="GROUND"){
					$dts = array();
					$dts['subject'] = $dt['code'];
					$dts['updated_at'] = DATE('Y-m-d H:i:s');
					$this->db->update('daily_ground_schedule',$dts,array('subject'=>$mission['code']));
				}

				// $arr = $_POST['type_of_training'];
				// foreach($arr as $k=>$v){
				// 	if($v=='ON'){
				// 		$type[$k]['status'] = "ON";
				// 	}
				// }
				// $dt['type_of_training'] = json_encode($type,true);

				$dt['updated_at'] = date("Y-m-d H:i:s");

				$str = $this->mymodel->updateData('syllabus_mission', $dt , array('id'=>$id));

				return $str;  

			}}

	}



	public function delete($id)

	{

			$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'syllabus_mission'));

			@unlink($file['dir']);

			$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'syllabus_mission'));



			$str = $this->mymodel->deleteData('syllabus_mission',  array('id'=>$id));
			redirect(base_url().'syllabus/mission');
			


	}



	public function status($id,$status)

	{

		$this->mymodel->updateData('syllabus_mission',array('status'=>$status),array('id'=>$id));


		redirect('syllabus/mission');

	}





}

?>