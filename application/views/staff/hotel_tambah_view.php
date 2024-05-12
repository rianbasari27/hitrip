<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
    /* Style untuk input form */
    .form-control {
        border: none;
        border-radius: 0;
        border-bottom: 1px solid #ced4da;
        /* warna garis bawah */
    }

    /* Style untuk input form yang aktif/fokus */
    .form-control:focus {
        box-shadow: none;
        border-color: #80bdff;
        /* warna garis bawah saat aktif */
    }
    </style>

</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <?php $this->load->view('staff/include/side_menu', ["produk" => true, "tambah_produk" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Tambah Hotel Paket <?php echo $nama_paket ?></h4>
                        <div class="row">
                            <!-- 1st row Start -->
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-header with-elements">
                                        <h6 class="card-header-title mb-0 text primary">Isi data dengan benar</h6>
                                        <div class="card-header-elements">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo base_url() . 'staff/paket/proses_tambah_hotel' ;?>"
                                            method="post" enctype="multipart/form-data">
                                            <input class="form-control" type="hidden" name="id_paket" value="<?php echo $id_paket ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Hotel</label>
                                                <input class="form-control" type="text" name="nama_hotel" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kota</label>
                                                <input class="form-control" type="text" name="kota">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Star</label>
                                                <input class="form-control" type="number" name="star">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Foto Hotel</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01" name="foto">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Link</label>
                                                <input class="form-control" type="text" name="maps_link"
                                                    required>
                                            </div>
                                            <button class="btn btn-xs btn-primary btn-icon-split rounded-xs mt-4">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Submit</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ content ] End -->

                    <?php $this->load->view('staff/include/footer_view') ?>
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->
    <?php $this->load->view('staff/include/script_view') ?>
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
</body>

</html>