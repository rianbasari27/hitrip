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


            <?php $this->load->view('staff/include/side_menu', ['reminder' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Reminder</h1>
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
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi informasi dengan benar
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" action="<?php echo base_url(); ?>staff/reminder/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">Keterangan</label><br>
                                                <input type="text" value="" name="keterangan" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kode Pembayaran</label><br>
                                                <input type="text" value="" name="kode_bayar" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nominal Pembayaran (<span
                                                        class="text-primary font-italic font-weight-lighter"> Input
                                                        hanya
                                                        angka, tanpa titik/koma </span>)</label>
                                                <input class="form-control format_harga" type="text" name="nominal">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label"> Pilih Reminder </label>
                                                <select name="status" class="form-control" id="slct"
                                                    onchange="showOnChange(event)">
                                                    <option value="" disabled selected>-- Pilih salah satu --</option>
                                                    <option value="bulan">Reminder per bulan</option>
                                                    <option value="tahun">Reminder per tahun</option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="Bulan" style="display: none;">
                                                <label class="col-form-label">Tanggal Pembayaran (<span
                                                        class="text-primary font-italic font-weight-lighter"> Jadwal
                                                        tanggal pembayaran (isikan tanggalnya saja) </span>)</label>
                                                <input type="text" name="tgl_bulan" class="form-control"
                                                    placeholder="Contoh : 31">
                                            </div>
                                            <div class="form-group" id="Tahun" style="display: none;">
                                                <label class="col-form-label">Tanggal Pembayaran (<span
                                                        class="text-primary font-italic font-weight-lighter"> Jadwal
                                                        tanggal pembayaran (isikan bulan dan tanggal) </span>)<span
                                                        class="text-primary font-italic font-weight-lighter"> *format :
                                                        mm/dd</span></label>
                                                <input type="text" name="tgl_tahun" class="form-control"
                                                    placeholder="Contoh : 12-30">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jadwal Reminder (<span
                                                        class="text-primary font-italic font-weight-lighter"> Untuk
                                                        memisahkan pakai "," (koma) dan tidak pakai spasi </span>)<span
                                                        class="text-primary font-italic font-weight-lighter"> *misal 10
                                                        hari sebelum tanggal pembayaran</span></label>
                                                <input class="form-control" type="text" name="jadwal"
                                                    placeholder="Contoh : 10,15,20">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No WhatsApp 1 (<span
                                                        class="text-primary font-italic font-weight-lighter"> Nomer
                                                        untuk dikirim reminder </span>)</label>
                                                <input class="form-control" type="number" name="wa_number1"
                                                    placeholder="Contoh : 08123456789">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No WhatsApp 2 (<span
                                                        class="text-primary font-italic font-weight-lighter"> Nomer
                                                        untuk dikirim reminder </span>)</label>
                                                <input class="form-control" type="number" name="wa_number2"
                                                    placeholder="Contoh : 08123456789">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No WhatsApp 3 (<span
                                                        class="text-primary font-italic font-weight-lighter"> Nomer
                                                        untuk dikirim reminder </span>)</label>
                                                <input class="form-control" type="number" name="wa_number3"
                                                    placeholder="Contoh : 08123456789">
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
    <script>
    $('#file').change(function() {
        $('#target').submit();
    });

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

    function showOnChange(e) {
        var elem = document.getElementById("slct");
        var value = elem.options[elem.selectedIndex].value;
        if (value == "bulan") {
            document.getElementById('Bulan').style.display = "block";
        } else {
            document.getElementById('Bulan').style.display = "none";
        }

        if (value == "tahun") {
            document.getElementById('Tahun').style.display = "block";
        } else {
            document.getElementById('Tahun').style.display = "none";
        }
    }
    </script>
</body>

</html>