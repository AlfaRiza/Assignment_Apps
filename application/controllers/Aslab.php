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
            $data = [
                'nama_kelas' => htmlspecialchars($this->input->post('class_name'), true),
                'image' => 'default.jpg',
                'id_user_created' => $this->session->userdata('id'),
                'deskripsi' => htmlspecialchars($this->input->post('description'),true),
                'token' => $this->input->post('token') ,
                'date_create' => time(),
                'is_active' => 1
            ];

            // cek gambar yg diupload
            $upload_image = $_FILES['image']['name'];
            if ($upload_image) {
                $config['upload_path'] = './assets/img/profile/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']     = '2048';

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    //$old_image = $data['user']['foto'];
                    //if ($old_image != 'default.jpg') {
                    //    unlink(FCPATH . 'assets/img/profile' . $old_image);
                    //}
                    $new_image = $this->upload->data('file_name');
                    if (!$new_image) {
                        $setw = ['image' => 'default.jpg'];
                    }else {
                    $setw = [
                        'image'=> $new_image
                    ];
                }
                    $this->aslab_model->updateData('user', $setw, $where);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->aslab_model->insertDB('kelas',$data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
            Kelas berhasil ditambahkan! </div>');
            redirect('aslab/kelola');
        }
    }

    public function detailKelas($id){
            $this->form_validation->set_rules('nama_kelas','Nama Kelas','required|trim');
            $this->form_validation->set_rules('deskripsi','Deskripsi Kelas','required|trim');
            if($this->form_validation->run() == false){
                $data['judul'] = 'Kelola kelas';
                $data['user'] = $this->user_model->getData('user',['nim' => $this->session->userdata('nim')]);
                $data['kelas'] = $this->aslab_model->getClassbyID('kelas',['id' => $id]);
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar');
                $this->load->view('templates/topbar');
                $this->load->view('aslab/detailKelas',$data);
                $this->load->view('templates/footer');
            }else{
                echo 'Asu';
                // $data = [
                //     'nama_kelas' => htmlspecialchars($this->input->post('nama_kelas'),true),
                //     'deskripsi' => htmlspecialchars($this->input->post('deskripsi'),true)
                // ];
                // $where = [
                //     'id' => $id
                // ];
                // $this->aslab_model->updateClass('kelas',$data,$where);
                // $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                // Kelas berhasil diupdate! </div>');
                // redirect('aslab/kelola');
            }

    }

    public function hapusKelas($id){
        $this->aslab_model->deleteClassbyID('kelas',['id' => $id]);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Kelas berhasil dihapus!</div>');
        redirect('aslab/kelola');
    }
}

?>