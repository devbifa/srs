

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class Daily_aircraft_status extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "daily_aircraft_status";

			$this->template->load('template/template','master/daily_aircraft_status/all-daily_aircraft_status',$data);

		}

		public function create()

		{

			$data['page_name'] = "daily_aircraft_status";

			$this->template->load('template/template','master/daily_aircraft_status/add-daily_aircraft_status',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[date]', '<strong>Date</strong>', 'required');
$this->form_validation->set_rules('dt[acft_reg]', '<strong>Acft Reg</strong>', 'required');
$this->form_validation->set_rules('dt[type]', '<strong>Type</strong>', 'required');
$this->form_validation->set_rules('dt[origin_base]', '<strong>Origin Base</strong>', 'required');
$this->form_validation->set_rules('dt[engine_hoobs_start]', '<strong>Engine Hoobs Start</strong>', 'required');
$this->form_validation->set_rules('dt[engine_hoobs_stop]', '<strong>Engine Hoobs Stop</strong>', 'required');
$this->form_validation->set_rules('dt[total_hobbs]', '<strong>Total Hobbs</strong>', 'required');
$this->form_validation->set_rules('dt[c_of_a_valid]', '<strong>C Of A Valid</strong>', 'required');
$this->form_validation->set_rules('dt[c_of_r_valid]', '<strong>C Of R Valid</strong>', 'required');
$this->form_validation->set_rules('dt[radio_station_dgca]', '<strong>Radio Station Dgca</strong>', 'required');
$this->form_validation->set_rules('dt[radio_station_kominfo]', '<strong>Radio Station Kominfo</strong>', 'required');
$this->form_validation->set_rules('dt[swing_compass]', '<strong>Swing Compass</strong>', 'required');
$this->form_validation->set_rules('dt[weight_and_balance]', '<strong>Weight And Balance</strong>', 'required');
$this->form_validation->set_rules('dt[basarnas]', '<strong>Basarnas</strong>', 'required');
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

				$str = $this->mymodel->insertData('daily_aircraft_status', $dt);

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

					   				'table'=> 'daily_aircraft_status',

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

				   				'table'=> 'daily_aircraft_status',

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

	        $this->datatables->select('id,date,acft_reg,type,origin_base,engine_hoobs_start,engine_hoobs_stop,total_hobbs,c_of_a_valid,c_of_r_valid,radio_station_dgca,radio_station_kominfo,swing_compass,weight_and_balance,basarnas,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('daily_aircraft_status');

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

			$data['daily_aircraft_status'] = $this->mymodel->selectDataone('daily_aircraft_status',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_aircraft_status'));$data['page_name'] = "daily_aircraft_status";

			$this->template->load('template/template','master/daily_aircraft_status/edit-daily_aircraft_status',$data);

		}
		
		public function preview($id)

		{

			$data['daily_aircraft_status'] = $this->mymodel->selectDataone('daily_aircraft_status',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_aircraft_status'));$data['page_name'] = "daily_aircraft_status";

			$this->template->load('template/template','master/daily_aircraft_status/preview-daily_aircraft_status',$data);

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

					   				'table'=> 'daily_aircraft_status',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_aircraft_status'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('daily_aircraft_status', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('daily_aircraft_status', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete()

		{

				$id = $this->input->post('id', TRUE);$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'daily_aircraft_status'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'daily_aircraft_status'));



				$str = $this->mymodel->deleteData('daily_aircraft_status',  array('id'=>$id));
				return $str;
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('daily_aircraft_status',array('status'=>$status),array('id'=>$id));


			redirect('master/Daily_aircraft_status');

		}





	}

?>