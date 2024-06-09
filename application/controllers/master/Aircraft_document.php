

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Aircraft_document extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "aircraft_document";

			$this->template->load('template/template','master/aircraft_document/all-aircraft_document',$data);

		}

		public function create()

		{

			$data['page_name'] = "aircraft_document";

			$this->template->load('template/template','master/aircraft_document/add-aircraft_document',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[model]', '<strong>Model</strong>', 'required');
$this->form_validation->set_rules('dt[type]', '<strong>Type</strong>', 'required');
$this->form_validation->set_rules('dt[serial_number]', '<strong>Serial Number</strong>', 'required');
$this->form_validation->set_rules('dt[registration]', '<strong>Registration</strong>', 'required');
// $this->form_validation->set_rules('dt[last_input_date]', '<strong>Last Input Date</strong>', 'required');
	}

	public function validate_history()

	{

		$this->form_validation->set_error_delimiters('<li>', '</li>');

$this->form_validation->set_rules('id', '<strong>ID</strong>', 'required');

// $this->form_validation->set_rules('dt[last_input_date]', '<strong>Last Input Date</strong>', 'required');
}



		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
				

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('aircraft_document', $dt);

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

					   				'table'=> 'aircraft_document',

					   				'table_id'=> $last_id,

					   				'status'=>'ENABLE',

					   				'created_at'=>date('Y-m-d H:i:s')

					   	 		);

					   	$str = $this->mymodel->insertData('file', $data);

						$this->alert->alertsuccess('Success Send Data');    

					} 

				}else{

					$data = array(

				   				'id' => '',

				   				'name'=> '',

				   				'mime'=> '',

				   				'dir'=> '',

				   				'table'=> 'aircraft_document',

				   				'table_id'=> $last_id,

				   				'status'=>'ENABLE',

				   				'created_at'=>date('Y-m-d H:i:s')

				   	 		);



				   	$str = $this->mymodel->insertData('file', $data);

					$this->alert->alertsuccess('Success Send Data');



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

	        $this->datatables->select('id,model,type,serial_number,registration,last_input_date,status');

	        // $this->datatables->where('status',$status);

	        $this->datatables->from('aircraft_document');

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

			$data['aircraft_document'] = $this->mymodel->selectDataone('aircraft_document',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'aircraft_document'));$data['page_name'] = "aircraft_document";

			$this->template->load('template/template','master/aircraft_document/edit-aircraft_document',$data);

		}
		
		public function preview($id)

		{

			$data['aircraft_document'] = $this->mymodel->selectDataone('aircraft_document',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'aircraft_document'));$data['page_name'] = "aircraft_document";

			$this->template->load('template/template','master/aircraft_document/preview-aircraft_document',$data);

		}





		public function update()

		{	

			$this->validate();

			



	    	if ($this->form_validation->run() == FALSE){

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

					   				'table'=> 'aircraft_document',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'aircraft_document'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('aircraft_document', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('aircraft_document', $dt , array('id'=>$id));

					return $str;  

				}}

		}
		



		public function delete($id)

		{

				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'aircraft_document'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'aircraft_document'));



				$str = $this->mymodel->deleteData('aircraft_document',  array('id'=>$id));
				redirect(base_url().'report/aircraft_status');

		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('aircraft_document',array('status'=>$status),array('id'=>$id));


			redirect('master/Aircraft_document');

		}


		public function update_history()

		{	


	    	if (1==0){

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

					   				'table'=> 'daily_flight_schedule',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

					

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('daily_flight_schedule', $dt , array('id'=>$id));

						// return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('daily_flight_schedule', $dt , array('id'=>$id));

					// return $str;  

				}


			}

			// echo 1;
				redirect(base_url().'master/aircraft_document/edit/'.$_POST['id_aircraft']);

		}

		
		public function store_history()

{

    

    if (1==0){

        $this->alert->alertdanger(validation_errors());     

    }else{

        $dt = $_POST['dt'];
		
		$aircraft = $this->mymodel->selectDataOne('aircraft_document',array('id'=>$_POST['id_aircraft']));


		$insp = $this->mymodel->selectDataOne('inspection_type',array('id'=>$aircraft['inspection_type']));
		$insp = json_decode($insp['konfigurasi'],true);
		$hours = '';
		foreach($insp as $k=>$v){
			if($v['option']==$dt['type']){
				$hours = $v['hours'];
			}
			
		}

		$dt['type_hours'] = $hours;
		$dt['type_json'] = json_encode($insp,true);
		
        $dt['created_by'] = $_SESSION['id'];

        $dt['aircraft_reg'] = $aircraft['serial_number'];

        $dt['visibility_report'] = 1;

        $dt['created_at'] = date('Y-m-d H:i:s');

        $dt['status'] = "ENABLE";

        $str = $this->mymodel->insertData('daily_flight_schedule', $dt);

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

                               'table'=> 'daily_flight_schedule',

                               'table_id'=> $last_id,

                               'status'=>'ENABLE',

                               'created_at'=>date('Y-m-d H:i:s')

                            );

                   $str = $this->mymodel->insertData('file', $data);

                $this->alert->alertsuccess('Success Send Data');    

            } 

        }else{

            $data = array(

                           'id' => '',

                           'name'=> '',

                           'mime'=> '',

                           'dir'=> '',

                           'table'=> 'daily_flight_schedule',

                           'table_id'=> $last_id,

                           'status'=>'ENABLE',

                           'created_at'=>date('Y-m-d H:i:s')

                        );



               $str = $this->mymodel->insertData('file', $data);

            $this->alert->alertsuccess('Success Send Data');



            }

                
			redirect(base_url().'master/aircraft_document/edit/'.$_POST['id_aircraft']);

            

    }

}


public function delete_history($id)

{

	$data = $this->mymodel->selectDataOne('daily_flight_schedule',array('id'=>$id));
	$aircraft = $this->mymodel->selectDataOne('aircraft_document',array('serial_number'=>$data['aircraft_reg']));


		$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_flight_schedule'));

		@unlink($file['dir']);

		$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_flight_schedule'));



		$str = $this->mymodel->deleteData('daily_flight_schedule',  array('id'=>$id));

		redirect(base_url().'master/aircraft_document/edit/'.$aircraft['id']);

		


}


function delete_file($id,$index){
	// header('Content-Type: application/json');

	$data = $this->mymodel->selectDataOne('aircraft_document',array('id'=>$id));
	$data = json_decode($data['attachment'],true);
	unset($data[$index]);
	// print_r($data);
	// die;
	$dt_input['attachment'] = json_encode($data);
	$this->mymodel->updateData('aircraft_document', $dt_input , array('id'=>$id));
	// print_r($data);
	if($_GET['type']=='student'){
		redirect(base_url().'master/student_document/edit/'.$id);
	}else{
		redirect(base_url().'master/aircraft_document/edit/'.$id);
	}

}

function upload_file($id){
	// header('Content-Type: application/json');

	$data = $this->mymodel->selectDataOne('aircraft_document',array('id'=>$id));
	
	$data = json_decode($data['attachment'],true);
	// print_r($data);
	
	$id_now = (end(array_keys($data))+1);

	$dt = $_POST['dtt'];

	if (!empty($_FILES['file']['name'])){
		// echo 123;

		$dir  = "webfile/aircraft_file/";

		$config['upload_path']          = $dir;

		$config['allowed_types']        = '*';

		$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file')){

			$error = $this->upload->display_errors();

			$this->alert->alertdanger($error);		

		}else{

			   $file = $this->upload->data();

			   $dt['file'] = $file['file_name'];

		} 

	}

	$dt['id'] = $id_now;
	$dt['created_at'] = DATE('Y-m-d H:i:s');

	$dt['updated_at'] = DATE('Y-m-d H:i:s');
if($data){
// array_push($data,$dt);
$data[$id_now] = $dt;
}else{
$data = array();
$data[$id_now] = $dt;
// array_push($data,$dt);
}

// print_r($data);
	
// die;


// die;

	$dt_input['attachment'] = json_encode($data);
	$this->mymodel->updateData('aircraft_document', $dt_input , array('id'=>$id));
	 
	if($_POST['type']=='student'){

		redirect(base_url().'master/student_document/edit/'.$id);
	}else{
		redirect(base_url().'master/aircraft_document/edit/'.$id);
	}
	

}

function update_file($id,$index){
	header('Content-Type: application/json');

	$data = $this->mymodel->selectDataOne('aircraft_document',array('id'=>$id));
	
	$data = json_decode($data['attachment'],true);
	
	$data_index = $data[$index];

	$data_edit = $_POST['dtt'];
	$data_edit['updated_at'] = DATE('Y-m-d H:i:s');
	
	$dt = $data_edit;
	

	if (!empty($_FILES['file']['name'])){
	
		$dir  = "webfile/aircraft_file/";

		$config['upload_path']          = $dir;

		$config['allowed_types']        = '*';

		$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);



		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('file')){

			$error = $this->upload->display_errors();

			$this->alert->alertdanger($error);		

		}else{

			   $file = $this->upload->data();

			   $dt['file'] = $file['file_name'];

		} 

	}else{
		$dt['file'] = $data_index['file'];
	}

if($data){
$data[$index] = $dt;
}else{
$data[$index] = $dt;
}

	$dt_input['attachment'] = json_encode($data);
	$this->mymodel->updateData('aircraft_document', $dt_input , array('id'=>$id));
	
	if($_POST['type']=='student'){

		redirect(base_url().'master/student_document/edit/'.$id);
	}else{
		redirect(base_url().'master/aircraft_document/edit/'.$id);
	}

}

	}

?>