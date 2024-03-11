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


            <?php $this->load->view('staff/include/side_menu', ['pembayaran_konsultan' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Verifikasi Konsultan
                                <?php echo $refund != null ? 'Pengembalian' : 'Pembayaran' ?></h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Nama Konsultan :</strong>
                                        <?php echo $agen->nama_agen; ?><br>
                                        <strong>Program :</strong> <?php echo $peserta->agenPaket->nama_paket; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Data
                                            <?php echo $refund != null ? 'Pengembalian' : 'Pembayaran' ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>

                                        <div class="form-group">
                                            <label class="col-form-label">Tanggal
                                                <?php echo $refund != null ? 'Pengembalian' : 'Pembayaran' ?> (<span
                                                    class="text-primary font-italic font-weight-lighter">yyyy-mm-dd</span>)</label>
                                            <input class="form-control" disabled
                                                <?php echo 'value="' . $dataBayar['data']->tanggal_bayar . '"'; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Jumlah
                                                <?php echo $refund != null ? 'Pengembalian' : 'Bayar' ?></label>
                                            <input class="form-control" disabled
                                                <?php echo 'value="' . 'Rp. ' . number_format($dataBayar['data']->jumlah_bayar, null, ',', '.') . ',-' . '"'; ?>>
                                        </div>
                                        <label class="col-form-label">Scan Bukti
                                            <?php echo $refund != null ? 'Pengembalian' : 'Pembayaran' ?> (<span
                                                class="text-primary font-italic font-weight-lighter">Foto</span>)</label>

                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                                <?php if ($dataBayar['data']->scan_bayar == null) { ?>
                                                File Belum Ada
                                                <?php } else { ?>
                                                <center>
                                                    <a href="<?php echo base_url() . $dataBayar['data']->scan_bayar; ?>"
                                                        onclick="window.open('<?php echo base_url() . $dataBayar['data']->scan_bayar; ?>',
                                                                                   'newwindow', 'width=1000,height=500');return false;">
                                                        <img src="<?php echo base_url() . $dataBayar['data']->scan_bayar; ?>"
                                                            style="width:180px; height:auto">
                                                    </a>
                                                </center>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Cara
                                                <?php echo $refund != null ? 'Pengembalian' : 'Pembayaran' ?> </label>
                                            <input class="form-control" disabled
                                                <?php echo 'value="' . $dataBayar['data']->cara_pembayaran . '"'; ?>>
                                        </div>
                                        <?php if ($refund == null) : ?>
                                        <div class="form-group">
                                            <label class="col-form-label">No. Referensi (<span
                                                    class="text-primary font-italic font-weight-lighter">Untuk
                                                    transfer</span>)</label>
                                            <input class="form-control" disabled
                                                <?php echo 'value="' . $dataBayar['data']->nomor_referensi . '"'; ?>>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-group">
                                            <label class="col-form-label">Keterangan</label>
                                            <input class="form-control" disabled
                                                <?php echo 'value="' . $dataBayar['data']->keterangan . '"'; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Hasil Verifikasi Sebelumnya</label>
                                            <?php
                                                if ($dataBayar['data']->verified == 1) {
                                                    $ver = 'Valid';
                                                } elseif ($dataBayar['data']->verified == 2) {
                                                    $ver = 'Tidak Valid';
                                                } else {
                                                    $ver = 'Belum dicek';
                                                }
                                                ?>
                                            <input class="form-control" disabled <?php echo 'value="' . $ver . '"'; ?>>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Verifikasi</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/pembayaran_konsultan/proses_verifikasi<?php echo $refund != null ? '?refund=1' : '' ?>"
                                            method="post">
                                            <input type="hidden" name="id_pembayaran"
                                                value="<?php echo $dataBayar['data']->id_pembayaran; ?>">
                                            <input type="hidden" name="iap"
                                                value="<?php echo $peserta->id_agen_peserta; ?>">
                                            <div class="form-group">
                                                <label
                                                    class="col-form-label"><?php echo $refund != null ? 'Pengembalian' : 'Pembayaran' ?>
                                                    Valid? (<span
                                                        class="text-primary font-italic font-weight-lighter">Verifikasi</span>)</label>

                                                <br><input type="radio" name="verified" value="2"
                                                    <?php echo $dataBayar['data']->verified == 2 ? 'checked' : ''; ?>>
                                                Tidak
                                                <br><input type="radio" name="verified" value="1"
                                                    <?php echo $dataBayar['data']->verified == 1 ? 'checked' : ''; ?>>
                                                Ya
                                                <br><input type="radio" name="verified" value="0"
                                                    <?php echo $dataBayar['data']->verified == 0 ? 'checked' : ''; ?>>
                                                Belum Cek
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>
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