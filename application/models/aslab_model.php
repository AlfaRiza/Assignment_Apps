<?php 

class aslab_model extends CI_Model{
    public function getClass($table,$where){
        $result = $this->db->get_where($table,$where)->result_array();
        return $result;
    }
    public function getClassbyID($table,$where){
        $result = $this->db->get_where($table,$where)->row_array();
        return $result;
    }

    public function insertDB($table,$data){
        $this->db->insert($table,$data);
    }

    public function deleteClassbyID($table,$where){
        $this->db->delete($table,$where);
    }

    public function updateClass($table,$data,$where){
        $this->db->update($table,$data,$where);
    }

    public function getTugasbyClass($table,$where){
        $result = $this->db->get_where($table,$where)->result_array();
        return  $result;
    }
}


?>