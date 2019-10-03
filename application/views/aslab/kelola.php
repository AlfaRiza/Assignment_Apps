
            <!-- Begin Page Content -->
            <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?= $judul; ?></h1>
            </div>
            <div class="row">
                <div class="col-md">
                    <?= $this->session->flashdata('message'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md">
                    <a href="<?= base_url('aslab/tambahKelas'); ?>" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Buat Kelas Baru</a>
                </div>
            </div>
            <div class="row">
            <?php foreach($kelas as $k) : ?>
                <div class="col-md">
                    <a href="<?= base_url('aslab/detailKelas/').$k['id']; ?>" class="kelas" >
                    <div class="card" style="width: 18rem;">
                        <img src="<?= base_url('assets/img/class/').$k['image']; ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= $k['nama_kelas']; ?></h5>
                            <p class="card-text"><?= $k['deskripsi']; ?></p>
                            <p class="card-text"><?= $k['token']; ?>  </p>
                        </div>
                    </div>
                    </a>
                </div>
            <?php endforeach; ?>
            </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

