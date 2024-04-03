<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu',['list_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Input Barang Baru</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form" action="<?php echo base_url(); ?>staff/barang/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Barang</label>
                                                <input class="form-control" type="text" name="nama_barang">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Stok Saat Ini</label>
                                                <input class="form-control" type="number" name="stok">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Unit Satuan (<span
                                                        class="text-primary font-italic font-weight-lighter">untuk stok,
                                                        contoh : pcs,lembar,buah</span>)</label>
                                                <input class="form-control" type="text" name="stok_unit">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Vendor</label>
                                                <input class="form-control" type="text" name="nama_vendor">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi</label>
                                                <textarea class='form-control' name='deskripsi' rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Upload Foto</label>
                                                <input class="form-control" type="file" name="pic">
                                            </div>
                                            <button class="btn btn-success btn-icon-split mt-3">
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
</body>

</html>