<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_statistik_event extends CI_Model {

    public function __construct()
    {

      $this->load->database();
        
    }


    var $column_order = array(null,'nama_event','tipe_pendaftaran','jumlah_semua_pendaftaran','jumlah_pendaftaran_diterima','jumlah_team','jumlah_rider'); //field yang ada di table user
    var $column_search = array(null,'nama_event','tipe_pendaftaran','jumlah_semua_pendaftaran','jumlah_pendaftaran_diterima','jumlah_team','jumlah_rider'); //field yang ada di table user
    var $order = array('nama_event'=>'asc'); // default order 
    var $table = "(SELECT *
FROM (
SELECT a.id as idA, a.nama_event, a.tipe_pendaftaran
FROM event a 
WHERE a.status='ENABLE'
) a
LEFT OUTER JOIN
(
SELECT a.id as idB, COUNT(b.id) as jumlah_semua_pendaftaran
FROM event a
LEFT OUTER JOIN pendaftaran b
ON a.id = b.event
GROUP BY a.id
) b
ON a.idA = b.idB
LEFT OUTER JOIN
(
SELECT a.id as idC, COUNT(b.id) as jumlah_pendaftaran_diterima
FROM event a
LEFT OUTER JOIN pendaftaran b
ON a.id = b.event
WHERE b.status_pendaftaran = 'Payment'
GROUP BY a.id
) c
ON a.idA = c.idC
LEFT OUTER JOIN
(
SELECT a.id as idD, COUNT(c.id) as jumlah_team
FROM event a
LEFT OUTER JOIN pendaftaran b
ON a.id = b.event
LEFT OUTER JOIN team c
ON b.id = c.id_pendaftaran
WHERE b.status_pendaftaran = 'Payment'
GROUP BY a.id
) d
ON a.idA = d.idD
LEFT OUTER JOIN
(
SELECT a.id as idE, COUNT(c.id) as jumlah_rider
FROM event a
LEFT OUTER JOIN pendaftaran b
ON a.id = b.event
LEFT OUTER JOIN pembalap c
ON b.id = c.id_pendaftaran
WHERE b.status_pendaftaran = 'Payment'
GROUP BY a.id
) e
ON a.idA = e.idE) as tabledata";

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
