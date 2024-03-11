<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('jamaah/include/header_view'); ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">




        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">


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

                        <!-- Area Chart -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div>
                                        <div class="row align-items-center">
                                            <div class="col-md-12 text-gray-800">

                                                <div class="card shadow mb-4">
                                                    <!-- Card Header - Accordion -->
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Pembayaran
                                                        </h6>
                                                    </div>

                                                    <!-- Card Content - Collapse -->
                                                    <div class="collapse show" id="collapseCardExample">
                                                        <div class="card-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered" id="dataTable"
                                                                    width="100%" cellspacing="0">
                                                                    <?php foreach ($tarif['dataMember'] as $dm) { ?>
                                                                    <tr>
                                                                        <th colspan="3">
                                                                            <?php echo $dm['detailAgen'][0]->nama_agen; ?>
                                                                        </th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><?php echo $dm['detailMember'][0]->agenPaket->nama_paket; ?>
                                                                        </td>
                                                                        <td><?php echo 'Rp. ' . number_format($dm['baseFee']['harga'], 0, ',', '.') . ',-'; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php if ($dm['diskon'] != 0) { ?>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td><?php echo $dm['deskripsiDiskon']; ?>
                                                                        </td>
                                                                        <td><?php echo 'Rp. ' . number_format($dm['diskon'], 0, ',', '.') . ',-'; ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                    <tr class="bg-secondary text-white">
                                                                        <th></th>
                                                                        <th>Total Biaya</th>
                                                                        <th><?php echo 'Rp. ' . number_format($dm['totalHarga'], 0, ',', '.') . ',-'; ?>
                                                                        </th>
                                                                    </tr>
                                                                    <?php } ?>
                                                                    <tr class="bg-warning text-white">
                                                                        <th colspan="2">Total Biaya Keseluruhan</th>
                                                                        <th><?php echo 'Rp. ' . number_format($tarif['total_harga'], 0, ',', '.') . ',-'; ?>
                                                                        </th>
                                                                    </tr>
                                                                    <?php foreach ($data as $byr) { ?>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            <?php echo $byr->jenis == 'bayar_konsultan' ? 'Pembayaran' : 'Refund' ;?>
                                                                            Tanggal
                                                                            <?php echo date_format(date_create($byr->tanggal_bayar), "d M Y"); ?>
                                                                        </td>
                                                                        <td>
                                                                            Rp.
                                                                            <?php echo number_format($byr->jumlah_bayar, 0, ',', '.'); ?>,-
                                                                            <a href="<?php echo base_url() . "kuitansi_dl/download_agen?id=" . $byr->id_pembayaran; ?>"
                                                                                class="btn btn-sm btn-success">
                                                                                Invoice
                                                                            </a>


                                                                            <?php if ($byr->scan_bayar) { ?>
                                                                            <a href="<?php echo base_url() . $byr->scan_bayar; ?>"
                                                                                download>
                                                                                <i class="fas fa-file-alt"></i>
                                                                            </a>
                                                                            <?php } ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                    <tr class="bg-warning text-white">
                                                                        <th colspan="2">Total Sudah Bayar</th>
                                                                        <th>Rp.
                                                                            <?php echo number_format($totalBayar, 0, ',', '.'); ?>,-
                                                                        </th>
                                                                    </tr>
                                                                    <tr class="bg-primary text-white">
                                                                        <th colspan="2">SISA TAGIHAN</th>
                                                                        <th>Rp.
                                                                            <?php echo number_format($sisaTagihan, 0, ',', '.'); ?>,-
                                                                        </th>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

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
            <?php $this->load->view('jamaah/include/footer'); ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <?php $this->load->view('jamaah/include/script_view'); ?>

</body>

</html>