<?php 

class User extends CI_Controller{
    public function __construct(){
        parent::__construct();
        //cek_login();
    }
    public function index(){
        $data['judul'] = 'My Profile';
        $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index',$data);
        $this->load->view('templates/footer');
    }

    public function edit(){
        $data['judul'] = 'Edit Profile';
        $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);

        $this->form_validation->set_rules('nama','Nama','required|trim',[
            'required' => 'Nama harus diisi'
        ]);
        $this->form_validation->set_rules('no_telp','Nomor Telpon','required|trim|numeric',[
            'required'  => 'Nomor telpon harus diisi',
            'numeric'   => 'Harus berupa angka'
        ]);
        $this->form_validation->set_rules('alamat','Alamat','required|trim',[
            'required'  => 'Alamat harus diisi'
        ]);

        if($this->form_validation->run() == false){
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit',$data);
            $this->load->view('templates/footer');
        }else{
            $nama   = $this->input->post('nama');
            $nim    = $this->input->post('nim');
            $no_telp    = $this->input->post('no_telp');
            $alamat = $this->input->post('alamat');

            
            redirect('user');
        }

    }
}

?>