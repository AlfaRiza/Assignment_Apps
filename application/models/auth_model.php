<?php 
class auth_model extends CI_Model{
    public function insert_DB($tabel, $data){
        $this->db->insert($tabel, $data);
    }

    public function getElementbyNim($tabel, $nim){
        return $user = $this->db->get_where($tabel, $nim)->row_array();
    }
}

?>