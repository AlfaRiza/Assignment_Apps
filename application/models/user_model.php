<?php 

class user_model extends CI_Model{
    public function getData($tabel,$where){
        return $this->db->get_where($tabel, $where)->row_array();
    }

    public function updateData($tabel,$set,$where){
        $this->db->set($set);
        $this->db->where($where);
        $this->db->update($tabel);
    }
}


?>