<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_student_hours extends CI_Model {

    public function __construct()
    {

      $this->load->database();

      $date_start = $_SESSION['date_start'];
      $date_end = $_SESSION['date_end'];

     $this->column_order = array(null,'nama_batch','nama_lengkap','hours'); //field yang ada di table user
     $this->column_search = array(null,'nama_batch','nama_lengkap','hours'); //field yang ada di table user
     $this->order = array('nama_batch'=>'asc'); // default order 
     $this->table = "(SELECT b.nama_batch, a.nama_lengkap, (FLOOR( 1 + RAND( ) *60 )) AS hours FROM siswa a
LEFT JOIN batch b
ON a.batch = b.id) as tabledata";
        
    }


   

    private function _get_datatables_query()
    {

        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                }else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) 

                    $this->db->group_end(); 
            }
            $i++;
        }

         

        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

 

    function get_datatables()
    {
        
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();

    }

 

    function count_filtered()
    {

        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();

    }

 

    public function count_all()
    {

        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


     function get_data()
    {
        
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();

    }


}

?>
