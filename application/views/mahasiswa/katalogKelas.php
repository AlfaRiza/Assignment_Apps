
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
                <?php foreach($kelas as $k) :?>
                <div class="col-md-3 pt-3">
                <div class="card" style="width: 15rem;">
                    <img height="250px" class="card-img-top" src="<?= base_url('assets/img/class/').$k['image']; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?= $k['nama_kelas']; ?></h5>
                        <p class="card-text"><?= $k['deskripsi']; ?></p>
                        <form action="<?= base_url('mahasiswa/tambahKelas/').$k['id']; ?>">
                        <a href="<?= base_url('mahasiswa/tambahKelas/').$k['id']; ?>" class="btn btn-primary">Ikuti kelas</a>
                        </form>
                    </div>
                </div>
                </div>
                <?php endforeach; ?>
            </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
