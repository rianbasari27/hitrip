<!DOCTYPE html>
<html lang="en">

    <head>
        <?php $this->load->view('staff/include/header_view'); ?>
        <style>
            .vertical-align {
                display: flex;
                align-items: center;
            }
        </style>

    </head>


    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


                <?php $this->load->view('staff/include/side_menu', ['data_konsultan' => true]); ?>

                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        <!-- Topbar -->
                        <?php $this->load->view('staff/include/top_menu'); ?>
                        <!-- End of Topbar -->

                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                            <div class="row h-100 mb-4">
                                <div class="col-lg-2">
                                    <?php if (empty($agen_pic)) { ?>
                                        <i class="fas fa-laugh-wink" style="font-size: 10rem;"></i>
                                    <?php } else { ?>
                                        <img class="img-fluid px-3 px-sm-4" style="width: 15rem;" src="<?php echo base_url() . 'asset/images/agen/' . $agen_pic; ?>" alt="">
                                    <?php } ?>
                                </div>
                                <div class="col-lg-10 vertical-align">
                                    <!-- Page Heading -->
                                    <div>
                                        <div class="d-sm-flex">
                                            <h1 class="h3 mb-0 text-gray-800"><?php echo $nama_agen; ?></h1>
                                            <?php if ($suspend == 1) { ?>
                                                <h1 class="h3 mb-0 font-weight-bold" style="color: red;">(SUSPENDED)</h1>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-sm font-weight-bold text-primary">
                                                    <span style="color: #4ec738;">Unclaimed <?php echo $unclaimed_point; ?> points</span>, 
                                                    <span style="color: #d85b5b;">Claimed <?php echo $claimed_point; ?> points</span>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Atur Ulang Poin</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo base_url(); ?>staff/kelola_agen/proses_atur_poin" method="post">
                                                <input type="hidden" name="id_agen" value="<?php echo $id_agen; ?>">
                                                <div class="form-group">
                                                    <label class="col-form-label">Unclaimed Points</label>
                                                    <input class="form-control" type="number" name="unclaimed_point" value="<?php echo $unclaimed_point; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Claimed Points</label>
                                                    <input class="form-control" type="number" name="claimed_point" value="<?php echo $claimed_point; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Keterangan</label>
                                                    <textarea name="keterangan" class="form-control">Penyesuaian Poin</textarea>
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
    </body>

</html>


