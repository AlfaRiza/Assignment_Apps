<?php 

class User extends CI_Controller{
    public function index(){
        $data['judul'] = 'Dashboard Mahasiswa';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index');
        $this->load->view('templates/footer');
    }
}

?>