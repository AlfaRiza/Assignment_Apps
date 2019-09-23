<?php 

class user_model extends CI_Model{
    public function getData($tabel,$where){
        return $this->db->get_where($tabel, $where)->row_array();
    }
}


?>