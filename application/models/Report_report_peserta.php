<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_report_peserta extends CI_Model {

    public function __construct()
    {

      $this->load->database();

      $event = $_SESSION['event'];  

      $this->column_order = array(null,'status_pendaftaran','kode_pendaftaran','nama_event','nama_team','nama_lengkap','nomor_start','ukuran_jersey','no_urut'); //field yang ada di table user
      $this->column_search = array(null,'status_pendaftaran','kode_pendaftaran','nama_event','nama_team','nama_lengkap','nomor_start','ukuran_jersey','no_urut'); //field yang ada di table user
      $this->order = array('status_pendaftaran'=>'asc'); // default order 
      $this->table = "(SELECT a.id, a.status_pendaftaran, a.kode_pendaftaran, d.nama_event, b.nama_team, c.nama_jersey as nama_lengkap, c.nomor_start, c.ukuran_jersey, a.no_urut
  FROM pendaftaran a
  LEFT JOIN team b
  ON a.id = b.id_pendaftaran
  LEFT JOIN pembalap c
  ON a.id = c.id_pendaftaran
  LEFT JOIN event d
  ON a.event = d.id
  WHERE d.id='$event' AND a.status_pendaftaran='Payment' AND d.status='ENABLE'
  ORDER BY a.id ASC, c.id ASC) as tabledata";
  
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
                    // $this->db->like($item, $_POST['search']['value']);
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
