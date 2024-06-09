

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



	class News extends MY_Controller {



		public function __construct()

		{

			parent::__construct();

		}



		public function index()

		{

			$data['page_name'] = "news";

			$this->template->load('template/template','master/news/all-news',$data);

		}

		public function create()

		{

			$data['page_name'] = "news";

			$this->template->load('template/template','master/news/add-news',$data);

		}

		public function validate()

		{

			$this->form_validation->set_error_delimiters('<li>', '</li>');

	$this->form_validation->set_rules('dt[title]', '<strong>Title</strong>', 'required');
$this->form_validation->set_rules('dt[date]', '<strong>Date</strong>', 'required');
$this->form_validation->set_rules('dt[content]', '<strong>Content</strong>', 'required');
	}



		public function store()

		{

			$this->validate();

	    	if ($this->form_validation->run() == FALSE){

				$this->alert->alertdanger(validation_errors());     

	        }else{

				$dt = $_POST['dt'];
				
				$slug =  preg_replace('/[^A-Za-z0-9\-]/', '-', $dt['title']);
				$slug = str_replace('--','-',$slug);
				$slug = str_replace('--','-',$slug);
				$slug = str_replace('--','-',$slug);
				$slug = strtolower($slug).'-'.$dt['date'];
				$dt['slug'] = $slug;

				$dt['created_by'] = $_SESSION['id'];

				$dt['created_at'] = date('Y-m-d H:i:s');

				$dt['status'] = "ENABLE";

				$str = $this->mymodel->insertData('news', $dt);

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

					   				'table'=> 'news',

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

				   				'table'=> 'news',

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

	        $this->datatables->select('id,title,date,content,status');

	        $this->datatables->where('status',$status);

	        $this->datatables->from('news');

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

			$data['news'] = $this->mymodel->selectDataone('news',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'news'));$data['page_name'] = "news";

			$this->template->load('template/template','master/news/edit-news',$data);

		}
		
		public function preview($id)

		{

			$data['news'] = $this->mymodel->selectDataone('news',array('id'=>$id));$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'news'));$data['page_name'] = "news";

			$this->template->load('template/template','master/news/preview-news',$data);

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

					   				'table'=> 'news',

					   				'table_id'=> $id,

					   				'updated_at'=>date('Y-m-d H:i:s')

					   	 		);

						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'news'));

						@unlink($file['dir']);

						if($file==""){

							$this->mymodel->insertData('file', $data);

						}else{

							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));

						}

						



						$dt = $_POST['dt'];

						$slug =  preg_replace('/[^A-Za-z0-9\-]/', '-', $dt['title']);
						$slug = str_replace('--','-',$slug);
						$slug = str_replace('--','-',$slug);
						$slug = str_replace('--','-',$slug);
						$slug = strtolower($slug).'-'.$dt['date'];
						$dt['slug'] = $slug;

						$dt['updated_at'] = date("Y-m-d H:i:s");

						$str =  $this->mymodel->updateData('news', $dt , array('id'=>$id));

						return $str;  
	

					}

				}else{

					$dt = $_POST['dt'];

					$slug =  preg_replace('/[^A-Za-z0-9\-]/', '-', $dt['title']);
					$slug = str_replace('--','-',$slug);
					$slug = str_replace('--','-',$slug);
					$slug = str_replace('--','-',$slug);
					$slug = strtolower($slug).'-'.$dt['date'];
					$dt['slug'] = $slug;

					$dt['updated_at'] = date("Y-m-d H:i:s");

					$str = $this->mymodel->updateData('news', $dt , array('id'=>$id));

					return $str;  

				}}

		}



		public function delete($id)

		{

				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'news'));

				@unlink($file['dir']);

				$this->mymodel->deleteData('file',  array('table_id'=>$id,'table'=>'news'));



				$str = $this->mymodel->deleteData('news',  array('id'=>$id));
				redirect(base_url().'master/news');
				


		}



		public function status($id,$status)

		{

			$this->mymodel->updateData('news',array('status'=>$status),array('id'=>$id));


			redirect('master/News');

		}





	}

?>