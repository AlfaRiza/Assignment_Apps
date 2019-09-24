<?php 

class Mahasiswa extends CI_Controller{
    public function __construct(){
        parent::__construct();
        cek_login();
    }
    public function index(){
        $data['judul'] = 'My Profile';
        $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('mahasiswa/index',$data);
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
            $this->load->view('mahasiswa/edit',$data);
            $this->load->view('templates/footer');
        }else{
            $nama   = $this->input->post('nama');
            $nim    = $this->input->post('nim');
            $no_telp    = $this->input->post('no_telp');
            $alamat = $this->input->post('alamat');
            $where = [
                'nim' => $nim
            ];
            $set = [
                'nama' => $nama,
                'no_telp' => $no_telp,
                'alamat' => $alamat
            ];

            // cek gambar yg diupload
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['foto'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $setw = [
                        'foto'=> $new_image
                    ];
                    $this->user_model->updateData('user', $setw, $where);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->user_model->updateData('user',$set,$where);
            
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Profile anda telah di update</div>');
            redirect('mahasiswa');
        }

    }
}

?>