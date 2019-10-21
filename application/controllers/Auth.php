<?php 

class Auth extends CI_Controller{
    public function index(){
        if ($this->session->userdata('nim')) {
            redirect('mahasiswa');
        }
        $this->form_validation->set_rules('nim', 'NIM', 'required|trim|numeric|exact_length[9]',[
            'required' => 'NIM harus diisi',
            'numeric'   => 'Harus berupa angka',
            'exact_length' => 'Harus 9 karakter'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]',[
            'required' => 'Password harus diisi',
            'min_length' => 'Minimal 8 karakter'
        ]);

        if($this->form_validation->run() == false){
            $data['judul'] = 'Halaman Login UPN Lab';
            $this->load->view('templates/header_auth',$data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer_auth');
        }else {
            // validasi
            $this->_login();
        }
    }

    private function _login(){
        $nim = $this->input->post('nim');
        $password = $this->input->post('password');

        $user = $this->auth_model->getElementbyNim('user', ['nim' => $nim]);
        // jika user ada
        if($user){
            // jika user aktif
                if ($user['is_active'] == 1) {
                    // cek password
                    if (password_verify($password,$user['password'])) {
                        // password benar
                        $data = [
                            'nim' => $user['nim'],
                            'role_id' => $user['role_id'],
                            'id' => $user['id']
                        ];
                        $this->session->set_userdata($data);
                        if ($user['role_id'] == 1) {
                            redirect('aslab');
                        } else {
                            redirect('mahasiswa');
                        }
                    }else {
                        // password salah
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> Password salah! </div>');
                        redirect('auth');
                    }
                }else {
                    // tidak aktif
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email belum di aktivasi! </div>');
                    redirect('auth');
                }
        }else {
            // gagal
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            NIM tidak terdaftar! </div>');
            redirect('auth');
        }
    }

    public function registrasi(){
        if ($this->session->userdata('nim')) {
            redirect('mahasiswa');
        }
        
        $this->form_validation->set_rules('nama','Nama','required|trim',[
            'required' => 'Nama harus diisi'
        ]);
        $this->form_validation->set_rules('nim','NIM','required|trim|exact_length[9]|is_unique[user.nim]',[
            'required' => 'NIM harus diisi',
            'exact_length' => 'NIM harus 9 karakter',
            'is_unique' => 'NIM sudah terdaftar'
        ]);
        $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]',[
            'required' => 'Email harus diisi',
            'valid_email' => 'Harus email',
            'is_unique' => 'Email sudah terdaftar'
        ]);
        $this->form_validation->set_rules('no_telp','Nomor Telpon','required|trim|numeric',[
            'required'  => 'Nomor telpon harus diisi',
            'numeric'   => 'Harus berupa angka'
        ]);
        $this->form_validation->set_rules('alamat','Alamat','required|trim',[
            'required'  => 'Alamat harus diisi'
        ]);
        $this->form_validation->set_rules('password1','Password','required|trim|min_length[8]|matches[password2]',[
            'required' => 'Password harus diisi',
            'matches' => 'Password tidak sama',
            'min_length' => 'Password min 8 karakter',
        ]);
        $this->form_validation->set_rules('password2','Password','required|trim|min_length[8]|matches[password1]',[
            'required' => 'Password harus diisi',
            'matches' => 'Password tidak sama',
            'min_length' => 'Password min 8 karakter',
        ]);

        if($this->form_validation->run() == false){
            $data['judul'] = 'Halaman Registrasi UPN Lab';
            $this->load->view('templates/header_auth',$data);
            $this->load->view('auth/registrasi');
            $this->load->view('templates/footer_auth');
        }
        else{
            $data= [
                'nama' => htmlspecialchars($this->input->post('nama'),true),
                'nim' => htmlspecialchars($this->input->post('nim'),true),
                'email' => htmlspecialchars($this->input->post('email'),true),
                'jurusan' => 'Teknik Informatika',
                'no_telp' => htmlspecialchars($this->input->post('no_telp'),true),
                'alamat' => htmlspecialchars($this->input->post('alamat'),true),
                'foto' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_create' => time()
            ];

            $this->auth_model->insert_DB('user',$data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Registrasi berhasil! aktivasi akun anda! </div>');
            redirect('auth');
        }
        
    }

    public function logout(){
        $this->session->unset_userdata('nim');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Logout berhasil! </div>');
            redirect('auth');
    }

    public function blocked(){
        $this->load->view('auth/blocked');
    }

}

?>