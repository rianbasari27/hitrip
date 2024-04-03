<!DOCTYPE html>
<html lang="en">

    <head>
        <?php $this->load->view('staff/include/header_view'); ?>
        <style>
            .trx-1{
                background-color: aliceblue;
                color: black;
            }
            .trx-2{
                background-color: yellowgreen;
                color: black;
            }
            .trx-3, .trx-4{
                background-color: brown;
                color: white;
            }
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


                <?php $this->load->view('staff/include/side_menu'); ?>

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
                                    <?php if (empty($profile->agen_pic)) { ?>
                                        <i class="fas fa-laugh-wink" style="font-size: 10rem;"></i>
                                    <?php } else { ?>
                                        <img class="img-fluid px-3 px-sm-4" style="width: 15rem;" src="<?php echo base_url() . 'asset/images/agen/' . $profile->agen_pic; ?>" alt="">
                                    <?php } ?>
                                </div>
                                <div class="col-lg-10 vertical-align">
                                    <!-- Page Heading -->
                                    <div>
                                        <div class="d-sm-flex">
                                            <h1 class="h3 mb-0 text-gray-800"><?php echo $profile->nama_agen; ?></h1>
                                            <?php if ($profile->suspend == 1) { ?>
                                                <h1 class="h3 mb-0 font-weight-bold" style="color: red;">(SUSPENDED)</h1>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-sm font-weight-bold text-primary">
                                                    <span style="color: #4ec738;">Unclaimed <?php echo $profile->unclaimed_point; ?> points</span>, 
                                                    <span style="color: #d85b5b;">Claimed <?php echo $profile->claimed_point; ?> points</span>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Histori Poin</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal</th>
                                                            <th>Poin</th>
                                                            <th>Transaksi</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (empty($history)) { ?>
                                                            <tr>
                                                                <td colspan="4"> Tidak ada data </td>
                                                            </tr>
                                                        <?php } else { ?>
                                                            <?php foreach ($history as $d) { ?>
                                                                <tr class="trx-<?php echo $d->jenis; ?>">
                                                                    <td><?php echo date_format(date_create($d->tanggal), "d M Y"); ?></td>
                                                                    <td><?php echo $d->poin; ?></td>
                                                                    <td><?php echo $d->jenisText; ?></td>
                                                                    <td><?php echo nl2br($d->keterangan); ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
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
    </body>

</html>


