<?php 

class Aslab extends CI_Controller{
    public function __construct(){
        parent::__construct();
        cek_login();
    }
    public function index(){
        $data['judul'] = 'Dashboard';
        $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('aslab/index',$data);
        $this->load->view('templates/footer');
    }
    public function kelola(){
        $data['judul'] = 'Kelola kelas';
        $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
        $data['kelas'] = $this->aslab_model->getClass('kelas',['id_user_created' => $this->session->userdata('id')]);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('aslab/kelola',$data);
        $this->load->view('templates/footer');
    }
    public function tambahKelas(){
        $this->form_validation->set_rules('class_name', 'Nama Kelas', 'required|trim',[
            'required' => 'Nama Kelas harus diisi'
        ]);
        $this->form_validation->set_rules('description', 'Deskripsi Kelas', 'required|trim',[
            'required' => 'Deskripsi Kelas Harus diisi'
        ]);

        if($this->form_validation->run() == false){
            $data['judul'] = 'Kelola kelas';
            $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
            $data['kelas'] = $this->aslab_model->getClass('kelas',['id_user_created' => $this->session->userdata('id')]);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('aslab/tambahKelas',$data);
            $this->load->view('templates/footer');
        }else{
            // cek gambar yg diupload
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['upload_path'] = './assets/img/class/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $new_image = $this->upload->data('file_name');
                    if (!$new_image) {
                        $data = [
                            'nama_kelas' => htmlspecialchars($this->input->post('class_name'), true),
                            'image' => 'default.jpg',
                            'id_user_created' => $this->session->userdata('id'),
                            'deskripsi' => htmlspecialchars($this->input->post('description'),true),
                            'token' => $this->input->post('token') ,
                            'date_create' => time(),
                            'is_active' => 1
                        ];
                    }else {
                        $data = [
                            'nama_kelas' => htmlspecialchars($this->input->post('class_name'), true),
                            'image' => $new_image,
                            'id_user_created' => $this->session->userdata('id'),
                            'deskripsi' => htmlspecialchars($this->input->post('description'),true),
                            'token' => $this->input->post('token') ,
                            'date_create' => time(),
                            'is_active' => 1
                        ];
                }
                    $this->aslab_model->insertDB('kelas',$data);
                    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                    Kelas berhasil ditambahkan! </div>');
                    redirect('aslab/kelola');
                } else {
                    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                    <?= $this->upload->display_errors(); ?></div>');
                    redirect('aslab/kelola');
                }
            }else{
                $data = [
                    'nama_kelas' => htmlspecialchars($this->input->post('class_name'), true),
                    'image' => 'default.jpg',
                    'id_user_created' => $this->session->userdata('id'),
                    'deskripsi' => htmlspecialchars($this->input->post('description'),true),
                    'token' => $this->input->post('token') ,
                    'date_create' => time(),
                    'is_active' => 1
                ];
                $this->aslab_model->insertDB('kelas',$data);
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Kelas berhasil ditambahkan! </div>');
                redirect('aslab/kelola');
            }
        }
    }

    public function lihatKelas($id){
                $data['judul'] = 'Kelola kelas';
                $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
                $data['kelas'] = $this->aslab_model->getClassbyID('kelas',['id' => $id]);
                $data['tugas'] = $this->aslab_model->getTugasbyClass('tugas',['id_kelas' => $data['kelas']['id']]);
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar');
                $this->load->view('templates/topbar');
                $this->load->view('aslab/lihatKelas',$data);
                $this->load->view('templates/footer');
    }

    public function hapusKelas($id){
        $this->aslab_model->deleteClassbyID('kelas',['id' => $id]);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Kelas berhasil dihapus!</div>');
        redirect('aslab/kelola');
    }

    public function tambahTugas($id_kelas){

        $this->form_validation->set_rules('title','Judul','required|trim',[
            'required'  => 'Judul harus diisi'
        ]);
        $this->form_validation->set_rules('description','Deskripsi','required|trim',[
            'required'  => 'Deskripsi harus diisi'
        ]);
        
        if ( $this->form_validation->run() == false) {
            $data['judul'] = 'Kelola kelas';
            $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
            $data['kelas'] = $this->aslab_model->getClassbyID('kelas',['id' => $id_kelas]);
            $data['tugas'] = $this->aslab_model->getTugasbyClass('tugas',['id_kelas' => $data['kelas']['id']]);
            $data['id_kelas'] = $id_kelas;
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('aslab/tambahTugas',$data);
            $this->load->view('templates/footer');
        }else {
            $bts_waktu = $this->input->post('bts_waktu');
            $bts_waktu1 = strtotime($bts_waktu);
            $this->_uploadgambar($bts_waktu1,$id_kelas);
            
        }
        }
        

    private function _uploadgambar($bts_waktu1,$id_kelas){
        // cek gambar yg diupload
        $upload_image = $_FILES['image']['name'];
        if ($upload_image) {
            $config['upload_path'] = './assets/img/tugas/';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size']     = '2048';

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $new_image = $this->upload->data('file_name');
                if (!$new_image) {
                    $data = [
                        'Title' => htmlspecialchars( $this->input->post('title'),true),
                        'Description' => htmlspecialchars( $this->input->post('description'),true),
                        'image' => 'default.jpg',
                        'batas_waktu' => $bts_waktu1,
                        'id_kelas' => $id_kelas,
                        'is_active' => 1,
                        'date_created' => time()
                    ];
                }else {
                    $data = [
                        'Title' => htmlspecialchars( $this->input->post('title'),true),
                        'Description' => htmlspecialchars( $this->input->post('description'),true),
                        'image' => $new_image,
                        'batas_waktu' => $bts_waktu1,
                        'id_kelas' => $id_kelas,
                        'is_active' => 1,
                        'date_created' => time()
                    ];
            }
                $this->aslab_model->insertDB('tugas',$data);
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Tugas berhasil ditambahkan! </div>');
                redirect('aslab/lihatKelas/'.$id_kelas);
            } else {
                $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                <?= $this->upload->display_errors(); ?></div>');
                redirect('aslab/lihatKelas/'.$id_kelas);
            }
        }else{
            $data = [
                'Title' => htmlspecialchars( $this->input->post('title'),true),
                'Description' => htmlspecialchars( $this->input->post('description'),true),
                'image' => 'default.jpg',
                'batas_waktu' => $bts_waktu1,
                'id_kelas' => $id_kelas,
                'is_active' => 1,
                'date_created' => time()
            ];
            $this->aslab_model->insertDB('tugas',$data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
            Tugas berhasil ditambahkan! </div>');
            redirect('aslab/lihatKelas/'.$id_kelas);
        }
    }
}

?>