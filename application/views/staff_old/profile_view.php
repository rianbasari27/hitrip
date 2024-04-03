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


            <?php $this->load->view('staff/include/side_menu', ['dashboard' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Profile</h1>
                        </div>

                        <!-- Content Row -->
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
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
                                        <form id="target" action="<?php echo base_url(); ?>staff/profile/ganti_pic"
                                            method="post" enctype="multipart/form-data">
                                            <label class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <input id="file" name="file" style="display: none;" type="file" />
                                                <span class="text">Ganti</span>
                                            </label>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <?php if (empty($_SESSION['image'])) { ?>
                                            <i class="fas fa-laugh-wink" style="font-size: 10rem;"></i>
                                            <?php } else { ?>
                                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;"
                                                src="<?php echo base_url() . 'asset/images/staff/' . $_SESSION['image']; ?>"
                                                alt="">
                                            <?php } ?>
                                        </center>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card shadow mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Detail Profile</h6>

                                        <span class="m-0">
                                            <a href="<?php echo base_url();?>staff/profile/ubah_profile"
                                                class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Ubah</span>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class=" text-lg font-weight-bold text-success">
                                            <?php echo $_SESSION['nama']; ?>
                                        </div>
                                        <div class="text-gray-900">
                                            <?php echo $_SESSION['bagian']; ?>
                                        </div>
                                        <div class="text-gray-900 text-monospace">
                                            <?php echo $_SESSION['email']; ?>
                                        </div>
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
    <script>
    $('#file').change(function() {
        $('#target').submit();
    });
    </script>
</body>

</html>