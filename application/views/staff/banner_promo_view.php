<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <?php $this->load->view('staff/include/header_view'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['promo_bayar' => true]); ?>

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php $this->load->view('staff/include/top_menu'); ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Promo Banner</h1>
                        </div>
                        <div class='row'>
                            <?php if (!empty($_SESSION['alert_type'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                <?php echo $_SESSION['alert_message']; ?>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Promo Banner ( <span
                                                class="text-secondary font-italic font-weight-lighter">Rekomendasi
                                                Ukuran 700x466 px untuk Gambar yang muncul di Aplikasi</span> )</h6>
                                    </div>
                                    <div class="col-lg-12">
                                        <a href="<?php echo base_url().'staff/upload_promo/tambah';?>"
                                            class="btn btn-sm btn-primary mt-2 mb-3">Tambah</a>
                                        <a href="<?php echo base_url().'staff/upload_promo/hapus_all';?>"
                                            class="btn btn-sm btn-primary mt-2 mb-3">Hapus Semua</a>
                                    </div>
                                    <div class="content">
                                        <div class="row px-1 mb-0">
                                            <?php 
                                                if (empty($promo)){
                                                    ?>
                                            <div class="content mb-n2">
                                                <div class="d-flex">
                                                    <div class="align-self-center">
                                                        <!-- <h2 class="mb-0 font-18"><strong>&ensp;&ensp;Belum ada
                                                                isinya!!</strong></h2> -->
                                                    </div>
                                                </div>
                                            </div><?php
                                                } else {
                                                foreach ($promo as $p) {?>
                                            <div class="col-3">
                                                <a href="<?php echo base_url() . 'staff/upload_promo/hapus?id=' . $p['view'];?>"
                                                    class="btn btn-sm btn-danger">Hapus Foto</a>
                                                <img src="<?php echo base_url() . 'uploads/promo_banner/'.$p['view'];?>"
                                                    alt="img" class="img-fluid rounded-s shadow-xl m-4">
                                            </div>
                                            <?php } 
                                                }
                                                ?>
                                        </div>
                                    </div>
                                    <div class="mb-3"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <?php $this->load->view('staff/include/footer'); ?>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <?php $this->load->view('staff/include/script_view'); ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/myjs/combobox.js"></script>
</body>

</html>