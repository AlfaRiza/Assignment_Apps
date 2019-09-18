<?php 

class Admin extends CI_Controller{
    public function index(){
        $data['judul'] = 'Dashboard';
        //$data['user'] = $this->model->getdata();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('admin/index');
        $this->load->view('templates/footer');
    }
}

?>