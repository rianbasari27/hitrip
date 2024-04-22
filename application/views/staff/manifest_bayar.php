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
            <?php $this->load->view('staff/include/side_menu', ["finance" => true, "input_bayar" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Daftar Paket / Produk</h4>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow bg-primary text-white rounded">
                                    <div class="card-body">
                                        <strong>Nama :</strong>
                                        <?php echo $user->name;?><br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>)
                                    </div>
                                </div>
                            </div>

                            <?php if ($groupMembers) { ?>
                            <div class="col-lg-12">
                                <div class="card shadow bg-info text-white rounded">
                                    <div class="card-body">
                                        <strong>Group Members :</strong>
                                        <div class="mt-2">
                                            <ol>
                                                <?php foreach ($groupMembers as $gm) { ?>
                                                <li>
                                                    <?php echo implode(" ", [$gm->userData->name]); ?>
                                                    (<?php echo $gm->userData->no_ktp; ?>)
                                                </li>
                                                <?php } ?>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-lg-12">
                                <div class="card shadow bg-primary text-white rounded">
                                    <div class="card-body">
                                        <h3>Sisa Tagihan :
                                            <?php echo 'Rp. ' . number_format($pembayaran['sisaTagihan'], 0, ',', '.') . ',-'; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary rounded">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" action="<?php echo base_url(); ?>staff/bayar/proses_bayar"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <input type="hidden" name="id_user" value="<?php echo $user->id_user; ?>">

                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Bayar (<span
                                                        class="text-primary font-italic font-weight-lighter">yyyy-mm-dd
                                                        hh:ii</span>)</label>
                                                <input class="form-control" type="datetime-local" name="tanggal_bayar">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah Bayar (<span
                                                        class="text-primary font-italic font-weight-lighter">input hanya
                                                        angka, tanpa titik/koma</span>)</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="jumlah_bayar">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Upload Bukti Pembayaran</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01" name="scan_bayar">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-form-label">Scan Bukti Pembayaran (<span
                                                        class="text-primary font-italic font-weight-lighter">Foto</span>)</label>
                                                <input class="form-control" type="file" name="scan_bayar">
                                            </div> -->
                                            <div class="form-group">
                                                <label class="col-form-label">Cara Pembayaran </label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="cara_pembayaran"
                                                            class="form-check-input" name="optradio"
                                                            value="Transfer BSI">Transfer BSI
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="cara_pembayaran"
                                                            class="form-check-input" name="optradio"
                                                            value="Transfer Mandiri">Transfer Mandiri
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="cara_pembayaran"
                                                            class="form-check-input" name="optradio"
                                                            value="Transfer BCA">Transfer BCA
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="cara_pembayaran"
                                                            class="form-check-input" name="optradio" value="Tunai"
                                                            checked>Tunai
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No. Referensi (<span
                                                        class="text-primary font-italic font-weight-lighter">Untuk
                                                        transfer</span>)</label>
                                                <input class="form-control" type="text" name="nomor_referensi">
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-form-label">Keterangan</label>
                                                <input class="form-control" type="text" name="keterangan">
                                            </div> -->
                                            <div class="form-group">
                                                <label class="color-highlight">Keterangan</label>
                                                <select class="form-select" name="keterangan">
                                                    <option value=" " selected> -- Pilih -- </option>
                                                    <option value="Bayar DP"> Bayar DP </option>
                                                    <option value="Cicilan"> Cicilan </option>
                                                    <option value="Pelunasan"> Pelunasan </option>
                                                    <option value="Mundur"> Mundur </option>
                                                </select>
                                            </div>
                                            <?php if (in_array($_SESSION['bagian'], array('Finance', 'Master Admin'))) { ?>
                                            <div class="form-group">
                                                <label class="col-form-label">Pembayaran Valid? (<span
                                                        class="text-primary font-italic font-weight-lighter">Verifikasi</span>)</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="verified" value="0"
                                                            class="form-check-input" name="optradio" checked>Belum Check
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="verified" value="2"
                                                            class="form-check-input" name="optradio">Tidak
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" name="verified" value="1"
                                                            class="form-check-input" name="optradio">Ya
                                                    </label>
                                                </div>
                                            </div>
                                            <?php } else { ?>
                                            <input type="hidden" name="verified" value="0">
                                            <?php } ?>
                                            <button class="btn btn-success btn-xs rounded-xs mt-4 btn-icon-split">
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
    <script>
    $(document).ready(function() {
        $(".format_harga").on("input", function() {
            var inputValue = $(this).val();

            inputValue = inputValue.replace(/[^\d.]/g, '');
            if (inputValue !== '') {
                inputValue = parseFloat(inputValue).toLocaleString('en-US');
                $(this).val(inputValue);
            } else {
                $(this).val('');
            }
        });
    });
    </script>
</body>

</html>