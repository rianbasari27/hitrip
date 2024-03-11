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


            <?php $this->load->view('staff/include/side_menu', ['input_pembayaran' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Input Pembayaran Store</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card shadow bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Nama :</strong>
                                        <?php echo $nama;?><br>
                                        <strong>Order Date :</strong> <?php echo $order->order_date; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb-5">
                                <div class="card shadow bg-primary text-white">
                                    <div class="card-body">
                                        <h3>Sisa Tagihan :
                                            <?php echo 'Rp. ' . number_format($order->total_amount, 0, ',', '.') . ',-'; ?>
                                        </h3>
                                    </div>
                                </div>
                            </div>

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
                                            action="<?php echo base_url(); ?>staff/bayar_store/proses_bayar"
                                            method="post" enctype="multipart/form-data">
                                            <!-- <input type="hidden" name="customer_id"
                                                value="<?php echo $order->customer_id; ?>"> -->
                                            <input type="hidden" name="order_id"
                                                value="<?php echo $order->order_id; ?>">
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
                                                <label class="col-form-label">Scan Bukti Pembayaran (<span
                                                        class="text-primary font-italic font-weight-lighter">Foto</span>)</label>
                                                <input class="form-control" type="file" name="scan_bayar">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Cara Pembayaran </label>
                                                <br><input type="radio" name="cara_pembayaran" value="Transfer BSI"
                                                    checked> Transfer BSI
                                                <br><input type="radio" name="cara_pembayaran" value="Transfer BCA"
                                                    checked> Transfer BCA
                                                <br><input type="radio" name="cara_pembayaran" value="Transfer Mandiri"
                                                    checked> Transfer Mandiri
                                                <br><input type="radio" name="cara_pembayaran" value="Tunai" checked>
                                                Tunai
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
                                                <select class="form-control" name="keterangan">
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
                                                <br><input type="radio" name="verified" value="0" checked> Belum Cek
                                                <br><input type="radio" name="verified" value="2"> Tidak
                                                <br><input type="radio" name="verified" value="1"> Ya
                                            </div>
                                            <?php } else { ?>
                                            <input type="hidden" name="verified" value="0">
                                            <?php } ?>
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

        if (window.innerWidth > 800) {
            $("#datepicker").attr("type", "text");
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: "1940:-nn"
                });
            });
        }
    });
    </script>
</body>

</html>