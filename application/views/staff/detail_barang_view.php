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
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                    <?php echo $_SESSION['alert_message']; ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php foreach ($logistik as $l) { ?>
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Detail <?php echo $l->nama_barang;?></h1>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary"><?php echo $l->nama_barang;?>
                                            Picture
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <?php if (empty($l->pic)) { ?>
                                            <i class="fas fa-laugh-wink" style="font-size: 11rem;"></i>
                                            <?php } else { ?>
                                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 11rem;"
                                                src="<?php echo base_url() . $l->pic; ?>" alt="">
                                            <?php } ?>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card shadow mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Barang</h6>

                                        <span class="m-0">
                                            <a href="<?php echo base_url() . 'staff/barang/lihat?id=' . $l->id_logistik; ?>"
                                                class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Lihat</span>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Nama Barang</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $l->nama_barang; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Stok Saat Ini</label>
                                            <input class="form-control" type="text" value='<?php echo $l->stok; ?>'
                                                disabled="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Unit Satuan (<span
                                                    class="text-primary font-italic font-weight-lighter">untuk stok,
                                                    contoh : pcs,lembar,buah</span>)</label>
                                            <input class="form-control" type="text" value='<?php echo $l->stok_unit; ?>'
                                                disabled="">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nama Vendor</label>
                                            <input class="form-control" type="text"
                                                value='<?php echo $l->nama_vendor; ?>' disabled="">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Deskripsi</label>
                                            <textarea class='form-control' rows="3"
                                                disabled=""><?php echo $l->deskripsi; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

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
    <script>
    $('#file').change(function() {
        $('#target').submit();
    });
    </script>
</body>

</html>