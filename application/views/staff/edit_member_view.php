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


                <?php $this->load->view('staff/include/side_menu', ['staff_member' => true]); ?>

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
                                <h1 class="h3 mb-0 text-gray-800">Ubah Data Member</h1>
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

                                <div class="col-lg-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                        </div>
                                        <div class="card-body">
                                            <form role="form" action="<?php echo base_url(); ?>staff/member/proses_edit" method="post">
                                                <div class="form-group">
                                                    <label class="col-form-label">Nama</label>
                                                    <input class="form-control" type="text" name="nama" value="<?php echo $nama; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Email</label>
                                                    <input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Bagian</label>
                                                    <select name="bagian" class="form-control">
                                                        <option value="Manifest" <?php echo ($bagian == 'Manifest') ? 'selected' : ''; ?>>Manifest</option>
                                                        <option value="Finance" <?php echo ($bagian == 'Finance') ? 'selected' : ''; ?>>Finance</option>
                                                        <option value="Logistik" <?php echo ($bagian == 'Logistik') ? 'selected' : ''; ?>>Logistik</option>
                                                        <option value="Admin" <?php echo ($bagian == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                                        <option value="PR" <?php echo ($bagian == 'PR') ? 'selected' : ''; ?>>Public Relation</option>
                                                        <option value="Store" <?php echo ($bagian == 'Store') ? 'selected' : ''; ?>>Store</option>
                                                    </select>
                                                </div>
                                                <input type='hidden' name='id_staff' value='<?php echo $id_staff;?>'>
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
    </body>

</html>




