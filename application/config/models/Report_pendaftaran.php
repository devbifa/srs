<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_pendaftaran extends CI_Model {

    public function __construct()
    {

      $this->load->database();
        
    }


    var $column_order = array(null,'nama_event','kode_pendaftaran','tipe_pendaftaran','status_pendaftaran','tanggal_daftar','tanggal_aprroval'); //field yang ada di table user
    var $column_search = array(null,'nama_event','kode_pendaftaran','tipe_pendaftaran','status_pendaftaran','tanggal_daftar','tanggal_aprroval'); //field yang ada di table user
    var $order = array('nama_event'=>'asc'); // default order 
    var $table = "(SELECT b.nama_event, a.kode_pendaftaran, a.tipe_pendaftaran, a.status_pendaftaran, a.created_at as tanggal_daftar, a.updated_at as tanggal_aprroval
FROM pendaftaran a
LEFT JOIN event b
ON a.event = b.id
ORDER BY b.id DESC) as tabledata";

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
                    $this->db->like($item, $_POST['search']['value']);
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
