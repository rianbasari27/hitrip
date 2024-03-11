<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <link rel="stylesheet" href="<?php echo base_url();?>asset/mycss/combobox.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['perl_office' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Input Barang Office Baru</h1>
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
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/perlengkapan_office/proses_serah"
                                            method="post">
                                            <input type="hidden" name="id_req_pinjam" value="<?php echo $requestPinjam->id_req_pinjam ;?>">
                                            <input type="hidden" name="id_barang" value="<?php echo $requestPinjam->id_barang ;?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Barang</label>
                                                <input class="form-control" type="text" name="nama" value="<?php echo $barang->nama ;?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah Request</label>
                                                <input class="form-control" type="number" name="jumlah_request" value="<?php echo $requestPinjam->jumlah_request ;?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Request</label>
                                                <input class="form-control" type="text" name="tempat" value="<?php echo $requestPinjam->tanggal_request ;?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat</label>
                                                <input class="form-control" type="text" name="tempat" value="<?php echo $requestPinjam->tempat ;?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Peminjam</label>
                                                <input class="form-control" type="text" name="nama_peminjam" value="<?php echo $staff->nama ;?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah Approve</label>
                                                <input class="form-control" type="text" name="jumlah_approve" value="">
                                            </div>
                                            <button class="btn btn-success btn-icon-split">
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
    <script src="<?php echo base_url();?>asset/myjs/combobox.js"></script>

</body>

</html>