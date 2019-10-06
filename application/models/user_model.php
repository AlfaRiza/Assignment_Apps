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

    public function getElementClassbyid($table,$where){
        $result = $this->db->get_where($table, $where)->result_array();
        return $result;
    }

    public function getAllClass($table){
        $result = $this->db->get($table)->result_array();
        return $result;
    }

    public function addClass($table,$data){
        $this->db->insert($table,$data);
    }

    public function getAllAslab($table,$where){
        $result = $this->db->get_where($table,$where)->result_array();
        return $result;
    }
}


?>