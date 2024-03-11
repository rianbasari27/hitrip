<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <?php $this->load->view('staff/include/header_view'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/image-popup.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/default/easyui.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/icon.css"> -->
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>asset/easyui-custom/jquery.easyui.min.js"></script> -->

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['data_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Registrasi Jamaah Baru</h1>
                        </div>

                        <!-- Content Row -->
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
                                        <form role="form" action="<?php echo base_url(); ?>staff/jamaah/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Pilih Paket Umroh</label>
                                                        <select name="id_paket" id="select_paket" class="form-control">
                                                            <?php
                                                            $flagNextSchedule = 1;
                                                            $flagFuture = 1;
                                                            $flagLast = 1;
                                                            ?>
                                                            <?php foreach ($paket as $pkt) { ?>
                                                            <?php
                                                                $futureTrue = strtotime($pkt->tanggal_berangkat) > strtotime('now');
                                                                if ($flagNextSchedule == 1) {
                                                                    echo "<optgroup label='Next Trip'>";
                                                                    $prepareClose = 1;
                                                                    $flagNextSchedule = 0;
                                                                } elseif ($flagFuture == 1 && $futureTrue == true) {
                                                                    echo "</optgroup>";
                                                                    echo "<optgroup label='Future Trips'>";
                                                                    $flagFuture = 0;
                                                                } elseif ($flagLast == 1 && $futureTrue == false) {
                                                                    $flagLast = 0;
                                                                    echo "</optgroup>";
                                                                    echo "<optgroup label='Last Trips'>";
                                                                }
                                                                ?>
                                                            <option value="<?php echo $pkt->id_paket; ?>">
                                                                <?php echo $pkt->nama_paket; ?>
                                                                (<?php echo date_format(date_create($pkt->tanggal_berangkat), "d F Y"); ?>)
                                                            </option>


                                                            <?php } ?>
                                                            <?php echo "</optgroup>"; ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tipe Kamar</label>
                                                        <select name="pilihan_kamar" id="select_kamar"
                                                            class="form-control">
                                                            <?php foreach ($paket as $pkt) { ?>
                                                            <?php if (!empty($pkt->harga)) { ?>
                                                            <option
                                                                class="option_kamar kmr-<?php echo $pkt->id_paket; ?>"
                                                                value="Quad">Quad
                                                                (<?php echo 'Rp. ' . number_format($pkt->harga, null, ',', '.') . ',-'; ?>)
                                                            </option>
                                                            <?php } ?>
                                                            <?php if (!empty($pkt->harga_triple)) { ?>
                                                            <option
                                                                class="option_kamar kmr-<?php echo $pkt->id_paket; ?>"
                                                                value="Triple">Triple
                                                                (<?php echo 'Rp. ' . number_format($pkt->harga_triple, null, ',', '.') . ',-'; ?>)
                                                            </option>
                                                            <?php } ?>
                                                            <?php if (!empty($pkt->harga_double)) { ?>
                                                            <option
                                                                class="option_kamar kmr-<?php echo $pkt->id_paket; ?>"
                                                                value="Double">Double
                                                                (<?php echo 'Rp. ' . number_format($pkt->harga_double, null, ',', '.') . ',-'; ?>)
                                                            </option>
                                                            <?php } ?>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor KTP</label>
                                                <input class="form-control" type="number" name="ktp_no" id="ktp">
                                            </div>
                                            <div class="form-group">
                                                <input type="checkbox" name="pernah_umroh" value="1">
                                                <label class="col-form-label">Pernah Umroh dalam 3 Tahun Terakhir
                                                </label>

                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Depan</label>
                                                <input class="form-control" type="text" name="first_name">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Tengah</label>
                                                <input class="form-control" type="text" name="second_name">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Akhir</label>
                                                <input class="form-control" type="text" name="last_name">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Nama Ayah</label>
                                                <input class="form-control" type="text" name="nama_ayah">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir</label>
                                                <input class="form-control" type="text" name="tempat_lahir"
                                                    id="tempatLahir">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir (<span
                                                        class="text-primary font-italic font-weight-lighter">dd/mm/yyyy</span>)</label>
                                                <input class="form-control" type="date" name="tanggal_lahir"
                                                    autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control">
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Status Perkawinan</label>
                                                <select name="status_perkawinan" class="form-control">
                                                    <option value="Belum Kawin">Belum Kawin</option>
                                                    <option value="Kawin">Kawin</option>
                                                    <option value="Cerai">Cerai</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor HP (<span
                                                        class="text-primary font-italic font-weight-lighter">aktif
                                                        Whatsapp</span>)</label>
                                                <input class="form-control" type="text" name="no_wa">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Telepon Rumah</label>
                                                <input class="form-control" type="number" name="no_rumah">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="text" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat Tinggal</label>
                                                <textarea class="form-control" rows="6"
                                                    name="alamat_tinggal"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Provinsi</label>
                                                <select id="provinsi" name="provinsi" class="form-control">
                                                    <?php foreach ($provinsi as $p) { ?>
                                                    <option value="<?php echo $p->name; ?>" rel="<?php echo $p->id; ?>">
                                                        <?php echo $p->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten/Kota</label>
                                                <select class="form-control" name="kabupaten_kota" id="kabupaten">
                                                    <?php foreach ($kabupaten as $p) { ?>
                                                    <option value="<?php echo $p->name; ?>" rel="<?php echo $p->id; ?>">
                                                        <?php echo $p->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan</label>
                                                <select class="form-control" name="kecamatan" id="kecamatan">
                                                    <?php foreach ($kecamatan as $p) { ?>
                                                    <option value="<?php echo $p->name; ?>" rel="<?php echo $p->id; ?>">
                                                        <?php echo $p->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan</label>
                                                <input class="form-control" type="text" name="kewarganegaraan"
                                                    id="kewarganegaraan">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan</label>
                                                <input class="form-control" type="text" name="pekerjaan">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pendidikan Terakhir</label>
                                                <select name="pendidikan_terakhir" class="form-control">
                                                    <option value="SD">SD</option>
                                                    <option value="SMP">SMP</option>
                                                    <option value="SMA">SMA</option>
                                                    <option value="D3">D3</option>
                                                    <option value="S1" selected>S1</option>
                                                    <option value="S2">S2</option>
                                                    <option value="S3">S3</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Riwayat Penyakit (<span
                                                        class="text-primary font-italic font-weight-lighter"> " - "
                                                        bila tidak ada </span>)</label>
                                                <input class="form-control" type="text" name="penyakit">
                                            </div>
                                            <label class="col-form-label">Surat Dokter (<span
                                                        class="text-primary font-italic font-weight-lighter"> Jika ada </span>)</label>
                                            <div class="card shadow mb-4">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <input class="form-control" type="file" name="upload_penyakit">
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="color-highlight" id="form5">Referensi (<span
                                                        class="text-primary font-italic font-weight-lighter"> Darimana
                                                        Anda mendaftar </span>)</label>
                                                <div
                                                    class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                                    <select name="referensi" class="form-control" id="slct"
                                                        onchange="showOnChange(event)">
                                                        <option value="">
                                                            Pilih salah satu ... </option>
                                                        <option value="Agen">KONSULTAN</option>
                                                        <option value="Walk_in">WALK IN</option>
                                                        <option value="Socmed">SOCIAL MEDIA</option>
                                                        <option value="Iklan">IKLAN</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" id="selectOffice" style="display:none;">
                                                <div class="ui-widget">
                                                    <label>Pilih Kantor</label><br>
                                                    <!--<input class="form-control" type="text" id="agenComplete" name="nama_agen" value="<?php echo $member->nama_agen; ?>">-->
                                                    <select name="office" class="form-control">
                                                        <option value="">Pilih salah satu ... </option>
                                                        <option value="Head">Head Office</option>
                                                        <option value="Cabang">Cabang Bandung</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" id="Agen" style="display:none;">
                                                <div class="ui-widget">
                                                    <label>Nama Konsultan</label><br>
                                                    <!--<input class="form-control" type="text" id="agenComplete" name="nama_agen" value="<?php echo $member->nama_agen; ?>">-->
                                                    <select id="combobox" name="id_agen">
                                                        <option value="">Pilih Salah Satu...</option>
                                                        <?php foreach ($agenList as $ag) { ?>
                                                        <option value="<?php echo $ag->id_agen; ?>"><?php echo $ag->nama_agen; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <h6 class="m-0 font-weight-bold text-primary">Data Ahli Waris / Keluarga terdekat</h6>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Lengkap</label>
                                                <input class="form-control" type="text" name="nama_ahli_waris">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Telp (<span
                                                        class="text-primary font-italic font-weight-lighter">aktif
                                                        Whatsapp</span>)</label>
                                                <input class="form-control" type="text" name="no_ahli_waris">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat</label>
                                                <textarea class="form-control" rows="3"
                                                    name="alamat_ahli_waris"></textarea>
                                            </div>
                                            <button class="btn btn-success btn-icon-split mt-4">
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
    <script src="<?php echo base_url(); ?>asset/myjs/combobox.js"></script>
    <script>
    function showOnChange(e) {
        var elem = document.getElementById("slct");
        var value = elem.options[elem.selectedIndex].value;
        if (value == "Agen") {
            document.getElementById('Agen').style.display = "block";
        } else {
            document.getElementById('Agen').style.display = "none";
        }

        if (value == "Socmed" || value == "Iklan" || value == "Walk_in") {
            document.getElementById('selectOffice').style.display = "block";
        } else {
            document.getElementById('selectOffice').style.display = "none";
        }
    }
    $(document).ready(function() {

        $(".option_kamar").css("display", "none");
        var selected_paket = $("#select_paket").find(":selected").val();
        $(".kmr-" + selected_paket + ":first").prop("selected", true);
        $(".kmr-" + selected_paket).css("display", "block");

        $("#select_paket").change(function() {
            $(".option_kamar").css("display", "none");
            selected_paket = $(this).find(":selected").val();
            $(".kmr-" + selected_paket).css("display", "block");
            $(".kmr-" + selected_paket + ":first").prop("selected", true);
        });

        // if (window.innerWidth > 800) {
        //     $("#datepicker").attr("type", "date");
        //     $(function () {
        //         $("#datepicker").datepicker({
        //             dateFormat: 'dd/mm/yy',
        //             changeYear: true,
        //             changeMonth: true,
        //             yearRange: "1940:-nn"
        //         });
        //     });
        // }

        $("#ktp").blur(function() {
            $.getJSON("getJamaah", {
                ktp: $("#ktp").val()
            }, function(data) {

            });
        });
        $("#provinsi").change(function() {
            var provId = $(this).find(":selected").attr('rel');
            $.getJSON("getRegencies", {
                provId: provId
            }, function(data) {
                $('#kabupaten').find('option').remove();
                $('#kecamatan').find('option').remove();
                populateDistrict(data[0]['id']);
                $(data).each(function(index, item) {
                    $('#kabupaten').append('<option value="' + item['name'] +
                        '" rel="' + item['id'] + '">' + item['name'] + '</option>');
                });
            });
        });

        $("#kabupaten").change(function() {
            var regId = $(this).find(":selected").attr('rel');
            populateDistrict(regId);

        });

        function populateDistrict(regId) {
            $.getJSON("getDistricts", {
                regId: regId
            }, function(data) {
                $('#kecamatan').find('option').remove();
                $(data).each(function(index, item) {
                    $('#kecamatan').append('<option value="' + item['name'] + '">' + item[
                        'name'] + '</option>');
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