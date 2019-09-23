<?php 

class Admin extends CI_Controller{
    public function __construct(){
        parent::__construct();
        //cek_login();
    }
    public function index(){
        $data['judul'] = 'Dashboard';
        $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/index');
        $this->load->view('templates/footer');
    }
}

?>