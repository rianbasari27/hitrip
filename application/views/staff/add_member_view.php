<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" href="<?php echo base_url();?>asset/mycss/combobox.css">
        <?php $this->load->view('staff/include/header_view'); ?>

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

                            <!-- Page Heading -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800">Pendaftaran Program untuk Jamaah Lama</h1>
                            </div>

                            <!-- Content Row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Basic Card Example -->
                                    <div class="card shadow mb-4 border-left-primary">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Nama Jamaah : <?php echo $jamaah->first_name.' '.$jamaah->second_name.' '.$jamaah->last_name;?></h6>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($_SESSION['alert_type'])) { ?>
                                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                                    <?php echo $_SESSION['alert_message']; ?>
                                                </div>
                                            <?php } ?>
                                            <form role="form" action="<?php echo base_url(); ?>staff/jamaah/proses_update_peserta" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id_jamaah" value="<?php echo $jamaah->id_jamaah;?>">
                                                <div class="card bg-warning text-white">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label class="col-form-label">Pilih Paket Umroh</label>
                                                            <select name="id_paket" id="select_paket" class="form-control">
                                                                <?php foreach ($paket as $pkt) { ?>
                                                                    <option value="<?php echo $pkt->id_paket; ?>"><?php echo $pkt->nama_paket; ?> (<?php echo $pkt->tanggal_berangkat; ?>)</option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-form-label">Tipe Kamar</label>
                                                            <select name="pilihan_kamar" id="select_kamar" class="form-control">
                                                                <?php foreach ($paket as $pkt) { ?>
                                                                    <?php if (!empty($pkt->harga)) { ?>
                                                                        <option class="option_kamar kmr-<?php echo $pkt->id_paket; ?>" value="Quad">Quad (<?php echo 'Rp. ' . number_format($pkt->harga, null, ',', '.') . ',-'; ?>)</option>
                                                                    <?php } ?>
                                                                    <?php if (!empty($pkt->harga_triple)) { ?>
                                                                        <option class="option_kamar kmr-<?php echo $pkt->id_paket; ?>" value="Triple">Triple (<?php echo 'Rp. ' . number_format($pkt->harga_triple, null, ',', '.') . ',-'; ?>)</option>
                                                                    <?php } ?>
                                                                    <?php if (!empty($pkt->harga_double)) { ?>
                                                                        <option class="option_kamar kmr-<?php echo $pkt->id_paket; ?>" value="Double">Double (<?php echo 'Rp. ' . number_format($pkt->harga_double, null, ',', '.') . ',-'; ?>)</option>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <input type="checkbox" name="pernah_umroh" value="1">
                                                    <label class="col-form-label">Pernah Umroh dalam 3 Tahun Terakhir </label>
                                                </div>

                                                <div class="ui-widget">
                                                    <label>Nama Konsultan</label><br>
                                                    <!--<input class="form-control" type="text" id="agenComplete" name="nama_agen" value="<?php echo $member->nama_agen; ?>">-->
                                                    <select id="combobox" name="id_agen">
                                                        <option value="">Pilih Salah Satu...</option>
                                                        <?php foreach ($agenList as $ag) { ?>
                                                            <option value="<?php echo $ag->id_agen;?>"><?php echo $ag->nama_agen;?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label">Pernah Umroh dalam 3 Tahun Terakhir </label>
                                                    <br><input type="radio" name="pernah_umroh" value="1"> Pernah
                                                    <br><input type="radio" name="pernah_umroh" value="0" checked> Belum
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Nomor Paspor</label>
                                                    <input class="form-control" type="number" name="paspor_no">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Nama Paspor</label>
                                                    <input class="form-control" type="text" name="paspor_name">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Paspor Issue Date</label>
                                                    <input class="form-control datepicker" type="date" name="paspor_issue_date">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Paspor Expiry Date</label>
                                                    <input class="form-control datepicker" type="date" name="paspor_expiry_date">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Paspor Issuing City</label>
                                                    <input class="form-control" type="text" name="paspor_issuing_city">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Scan Paspor</label>
                                                    <input class="form-control" type="file" name="paspor_scan">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Scan KTP</label>
                                                    <input class="form-control" type="file" name="ktp_scan">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Scan Foto</label>
                                                    <input class="form-control" type="file" name="foto_scan">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Scan VISA</label>
                                                    <input class="form-control" type="file" name="visa_scan">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Scan Vaksin</label>
                                                    <input class="form-control" type="file" name="vaksin_scan">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Sudah Menyerahkan Paspor </label>
                                                    <br><input type="radio" name="paspor_check" value="1"> Sudah
                                                    <br><input type="radio" name="paspor_check" value="0" checked> Belum
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Sudah Menyerahkan Buku Kuning </label>
                                                    <br><input type="radio" name="buku_kuning_check" value="1"> Sudah
                                                    <br><input type="radio" name="buku_kuning_check" value="0" checked> Belum

                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label">Sudah Menyerahkan Pas Foto </label>
                                                    <br><input type="radio" name="foto_check" value="1"> Sudah
                                                    <br><input type="radio" name="foto_check" value="0" checked> Belum
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
        <script src="<?php echo base_url();?>asset/myjs/combobox.js"></script>
        <script>
            $(document).ready(function () {

                $(".option_kamar").css("display", "none");
                var selected_paket = $("#select_paket").find(":selected").val();
                $(".kmr-" + selected_paket + ":first").prop("selected", true);
                $(".kmr-" + selected_paket).css("display", "block");

                $("#select_paket").change(function () {
                    $(".option_kamar").css("display", "none");
                    selected_paket = $(this).find(":selected").val();
                    $(".kmr-" + selected_paket).css("display", "block");
                    $(".kmr-" + selected_paket + ":first").prop("selected", true);
                });

                if (window.innerWidth > 800) {
                    $("#datepicker").attr("type", "text");
                    $(function () {
                        $("#datepicker").datepicker({
                            dateFormat: 'yy-mm-dd',
                            changeYear: true,
                            changeMonth: true,
                            yearRange: "1940:-nn"
                        });
                    });
                }

                $("#ktp").blur(function () {
                    $.getJSON("getJamaah", {ktp: $("#ktp").val()}, function (data) {

                    });
                });
                $("#provinsi").change(function () {
                    var provId = $(this).find(":selected").attr('rel');
                    $.getJSON("getRegencies", {provId: provId}, function (data) {
                        $('#kabupaten').find('option').remove();
                        $('#kecamatan').find('option').remove();
                        populateDistrict(data[0]['id']);
                        $(data).each(function (index, item) {
                            $('#kabupaten').append('<option value="' + item['name'] + '" rel="' + item['id'] + '">' + item['name'] + '</option>');
                        });
                    });
                });

                $("#kabupaten").change(function () {
                    var regId = $(this).find(":selected").attr('rel');
                    populateDistrict(regId);

                });

                function populateDistrict(regId) {
                    $.getJSON("getDistricts", {regId: regId}, function (data) {
                        $('#kecamatan').find('option').remove();
                        $(data).each(function (index, item) {
                            $('#kecamatan').append('<option value="' + item['name'] + '">' + item['name'] + '</option>');
                        });
                    });
                }

                $("#tempatLahir").autocomplete({
                    source: "getTempatLahir"
                });
                $("#kewarganegaraan").autocomplete({
                    source: "getCountries"
                });
            });

        </script>
    </body>

</html>




