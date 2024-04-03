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


            <?php $this->load->view('staff/include/side_menu', ['refund_pembayaran' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Form Kelebihan Pemabayaran</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card shadow bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Nama :</strong>
                                        <?php echo $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name; ?><br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>)
                                    </div>
                                </div>
                            </div>

                            <?php if ($groupMembers) { ?>
                            <div class="col-lg-12 mb-5">
                                <div class="card shadow bg-info text-white">
                                    <div class="card-body">
                                        <strong>Group Members :</strong>
                                        <div class="mt-2">
                                            <ol>
                                                <?php foreach ($groupMembers as $gm) { ?>
                                                <li>
                                                    <?php echo implode(" ", [$gm->jamaahData->first_name, $gm->jamaahData->second_name, $gm->jamaahData->last_name]); ?>
                                                    (<?php echo $gm->jamaahData->ktp_no; ?>)
                                                </li>
                                                <?php } ?>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

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
                                        <form role="form" action="<?php echo base_url(); ?>staff/bayar/proses_refund"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <input type="hidden" name="id_jamaah"
                                                value="<?php echo $jamaah->id_jamaah; ?>">

                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Pengembalian (<span
                                                        class="text-primary font-italic font-weight-lighter">yyyy-mm-dd hh:ii</span>)</label>
                                                <input class="form-control" type="datetime-local"
                                                    name="tanggal_bayar">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah Pengembalian (<span
                                                        class="text-primary font-italic font-weight-lighter">input hanya
                                                        angka, tanpa titik/koma</span>)</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="jumlah_bayar">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Cara Pembayaran </label>
                                                <br><input type="radio" name="cara_pembayaran" value="Transfer BSI"
                                                    checked>
                                                Transfer BSI
                                                <br><input type="radio" name="cara_pembayaran" value="Transfer BCA"
                                                    checked>
                                                Transfer BCA
                                                <br><input type="radio" name="cara_pembayaran" value="Transfer Mandiri"
                                                    checked> Transfer Mandiri
                                                <br><input type="radio" name="cara_pembayaran" value="Tunai" checked>
                                                Tunai
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Upload Bukti Transfer (<span
                                                        class="text-primary font-italic font-weight-lighter">Foto</span>)</label>
                                                <input class="form-control" type="file" name="scan_bayar">
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-form-label">Keterangan : </label><br>
                                                <textarea rows="5" cols="100" name="keterangan"></textarea>
                                            </div> -->
                                            <div class="form-group">
                                                <label class="color-highlight">Jenis Pengembalian</label>
                                                <select class="form-control" name="keterangan">
                                                    <option value=" " selected> -- Pilih -- </option>
                                                    <option value="Batal Upgrade"> BATAL UPGRADE </option>
                                                    <option value="Mundur"> MUNDUR </option>
                                                    <option value="Lebih Bayar"> LEBIH BAYAR </option>
                                                </select>
                                            </div>
                                            <?php if (in_array($_SESSION['bagian'], array('Finance', 'Master Admin'))) { ?>
                                            <input type="hidden" name="verified" value="0">
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