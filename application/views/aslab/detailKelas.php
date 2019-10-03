
            <!-- Begin Page Content -->
            <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $judul; ?></h1>
            </div>
            <div class="row">
                <div class="col-md">
                    <a href="<?= base_url('aslab/kelola') ?>" class="btn btn-primary mb-4">Kembali</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    <div class="card" style="width: 100%;">
                        <img src="<?= base_url('assets/img/class/').$kelas['image']; ?>" class="card-img-top" alt="...">
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nama_kelas" class="col-sm-4 col-form-label">Nama Kelas</label>
                            <div class="col-sm-8">
                            <input type="text" name="nama_kelas" class="form-control" id="nama_kelas" value="<?= $kelas['nama_kelas']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deskripsi" class="col-sm-4 col-form-label">Deskripsi</label>
                            <div class="col-sm-8">
                            <input type="text" name="nama_kelas" class="form-control" id="deskripsi" value="<?= $kelas['deskripsi']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deskripsi" class="col-sm-4 col-form-label">Token</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="deskripsi" value="<?= $kelas['token']; ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deskripsi" class="col-sm-4 col-form-label">Dibuat</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" id="deskripsi" value="<?= date('d-M-Y',$kelas['date_create']) ?>" readonly>
                            </div>
                        </div>
                </div>
                <div class="col-md-1">
                        <a href="" class="btn btn-success btn-lg mb-3" data-toggle="modal" data-target="#editModal"><i class="far fa-fw fa-edit"></i></a>
                        <a  href="<?= base_url('aslab/hapusKelas/').$kelas['id']; ?>" class="btn btn-danger btn-lg mt-3" data-toggle="modal" data-target="#hapusModal"><i class="fas fa-fw fa-trash"></i></a>
                </div>
            </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <?php form_open_multipart('aslab/editKelas/').$kelas['id']; ?>
                <div class="form-group">
                            <label for="class_name">Nama Kelas</label>
                            <input type="text" class="form-control" id="class_name" name="class_name" value="<?= $kelas['nama_kelas']; ?>">
                            <?= form_error('class_name', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <input type="text" class="form-control" id="description" name="description" value="<?= $kelas['deskripsi']; ?>">
                            <?= form_error('description', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <?php 
                        $str = "";
                        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
                        $max = count($characters) - 1;
                        for ($i = 0; $i < 4; $i++) {
                            $rand = mt_rand(0, $max);
                            $str  .= $characters[$rand];
                        }
                        ?>
                        <div class="form-group">
                            <label for="token">Token</label>
                            <input type="text" class="form-control" id="token" name="token" value="<?= $kelas['token'] ?>" readonly>
                            <?= form_error('token', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="modal-footer">
                        <a href="<?= base_url('aslab/editKelas/').$kelas['id']; ?>" class="btn btn-primary">Edit</a>
                    </div>
                </form>
                </div>
                
                </div>
            </div>
        </div>
        <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah Anda Yakin?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Hapus <?= $kelas['nama_kelas'];?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <a href="<?= base_url('aslab/hapusKelas/').$kelas['id']; ?>" class="btn btn-primary">Hapus</a>
                </div>
                </div>
            </div>
        </div>