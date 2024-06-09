<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class News extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

      redirect(base_url());
    }
    function detail($slug){
        $data['detail'] = $this->mymodel->selectDataOne('news',array('slug'=>$slug));
        
        if($data['detail']){

            $id_news = $data['detail']['id'];
            $data['other'] = $this->mymodel->selectWithQuery("SELECT * FROM news WHERE id!='$id_news' ORDER BY date DESC LIMIT 6");
            $this->template->load('template/template','template/news_detail',$data);
        }else{
            redirect(base_url());
        }
        
    }

}
