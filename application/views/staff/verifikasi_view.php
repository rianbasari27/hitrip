<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
    /* Style untuk input form */
    .form-control {
        border: none;
        border-radius: 0;
        border-bottom: 1px solid #ced4da;
        /* warna garis bawah */
    }

    /* Style untuk input form yang aktif/fokus */
    .form-control:focus {
        box-shadow: none;
        border-color: #80bdff;
        /* warna garis bawah saat aktif */
    }
    </style>

</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <?php $this->load->view('staff/include/side_menu', ["finance" => true, "verif_bayar" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Update Data Verifikasi</h4>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-primary text-white rounded">
                                    <div class="card-body">
                                        <strong>Nama :</strong>
                                        <?php echo $user->name; ?><br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>)
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
                                            action="<?php echo base_url(); ?>staff/finance/proses_verifikasi<?php echo $refund != null ? '?refund=1' : '' ?>"
                                            method="post">
                                            <input type="hidden" name="id_pembayaran"
                                                value="<?php echo $dataBayar['data']->id_pembayaran; ?>">
                                            <div class="form-group">
                                                <label
                                                    class="col-form-label"><?php echo $refund != null ? 'Pengembalian' : 'Pembayaran' ?>
                                                    Valid? (<span
                                                        class="text-primary font-italic font-weight-lighter">Verifikasi</span>)</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="verified" class="form-check-input"
                                                            name="optradio" value="2"
                                                            <?php echo $dataBayar['data']->verified == 2 ? 'checked' : ''; ?>>Tidak
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="verified" class="form-check-input"
                                                            name="optradio" value="1"
                                                            <?php echo $dataBayar['data']->verified == 1 ? 'checked' : ''; ?>>Ya
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="verified" class="form-check-input"
                                                            name="optradio" value="0"
                                                            <?php echo $dataBayar['data']->verified == 0 ? 'checked' : ''; ?>>Belum
                                                        Cek
                                                    </label>
                                                </div>
                                                <div class="form-group mt-4">
                                                    <button class="btn btn-success btn-xs rounded-xs btn-icon-split">
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
                    <!-- [ content ] End -->

                    <?php $this->load->view('staff/include/footer_view') ?>
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <?php $this->load->view('staff/include/script_view') ?>
</body>

</html>