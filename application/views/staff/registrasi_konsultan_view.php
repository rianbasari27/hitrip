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


            <?php $this->load->view('staff/include/side_menu', ['pendaftaran_konsultan' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Registrasi Konsultan</h1>
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
                                        <form id="form" action="<?php echo base_url(); ?>staff/daftar_agen/proses_tambah"
                                            method="post">
                                            <div class="card bg-warning text-white">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Pilih Program</label>
                                                        <select name="id_agen_paket" id="select_paket" class="form-control">
                                                            <?php foreach ($program as $prog) { ?>
                                                            <option value="<?php echo $prog->id; ?>">
                                                                <?php echo $prog->nama_paket; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Status Konsultan</label>
                                                        <select name="status" id="status" class="form-control">
                                                            <option value="1">Konsultan Lama</option>
                                                            <option value="0">Konsultan Baru</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4">
                                                <label for="inputAgen">Nama Konsultan</label>
                                                <input type="hidden" id="id_agen" name="id_agen" value="<?php echo (!empty($agen->id_agen)) ? $agen->id_agen : ""; ?>">
                                                <input value="<?php echo (!empty($agen->nama_agen)) ? $agen->nama_agen . " (" . $agen->no_agen . ")" : ""; ?>" type="text" class="form-control" id="inputAgen" name="nama_agen" aria-describedby="agenHelp" placeholder="masukkan nama konsultan">
                                                <small id="agenHelp" class="form-text text-muted">Ketik minimal 3 huruf untuk memunculkan auto complete</small>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No. Konsultan</label>
                                                <input class="form-control" id="no_agen" type="text" name="no_agen">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir</label>
                                                <input class="form-control" id="tanggal_lahir" type="date" name="tanggal_lahir">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" id="email" type="text" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No WhatsApp</label>
                                                <input class="form-control" id="no_wa" type="number" name="no_wa">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No KTP</label>
                                                <input class="form-control" id="no_ktp" type="number" name="no_ktp">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No Rekening</label>
                                                <input class="form-control" id="no_rekening" type="number" name="no_rekening">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Bank</label>
                                                <select name="nama_bank" id="nama_bank" class="form-control">
                                                    <option value="BSI">BSI</option>
                                                    <option value="BCA">BCA</option>
                                                    <option value="Mandiri">Mandiri</option>
                                                </select>
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
                                                <select class="form-control" name="kota" id="kota">
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
                                                <label class="col-form-label">Status Perkawinan</label>
                                                <select name="status_perkawinan" id="status_perkawinan" class="form-control">
                                                    <option value="BELUM KAWIN" selected="">Belum Kawin</option>
                                                    <option value="KAWIN">Kawin</option>
                                                    <option value="CERAI">Cerai</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan</label>
                                                <input class="form-control" id="pekerjaan" type="text" name="pekerjaan">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan</label>
                                                <input class="form-control" type="text" name="kewarganegaraan" id="kewarganegaraan">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Hobi</label>
                                                <input class="form-control" type="text" name="hobi" id="hobi">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                    <option value="" selected disabled>-- Pilih salah satu --</option>
                                                    <option value="L">Laki - laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Ukuran Baju</label>
                                                <select name="ukuran_baju" id="ukuran_baju" class="form-control">
                                                    <option value="" selected disabled>-- Pilih salah satu --
                                                    </option>
                                                    <option value="XXL">XXL</option>
                                                    <option value="XL">XL</option>
                                                    <option value="L">L</option>
                                                    <option value="M">M</option>
                                                    <option value="S">S</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Terdaftar</label>
                                                <input class="form-control" id="tanggal_terdaftar" type="date" name="tanggal_terdaftar">
                                            </div>
                                            <a href="" class="btn btn-success btn-icon-split" id="submit">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Submit</span>
                                            </a>
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
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $("#submit").on("click", function(event) {
                event.preventDefault();
                //check apakah id_upline kosong
                const agenData = $("#status").val();
                const agenId = $("#id_agen").val();
                if (agenId == '' && agenData == 1) {
                    alert("Silahkan pilih konsultan dengan benar!");
                    $("#inputAgen").val("");
                    $("#no_agen").val("");
                    $("#no_wa").val("");
                    $("#email").val("");
                    $("#no_wa").val("");
                    $("#tanggal_lahir").val("");
                    $("#no_ktp").val("");
                    $("#no_rekening").val("");
                    $("#nama_bank").val("");
                    $("#provinsi").val("");
                    $("#kota").val("");
                    $("#kecamatan").val("");
                    $("#status_perkawinan").val("");
                    $("#pekerjaan").val("");
                    $("#hobi").val("");
                    $("#jenis_kelamin").val("");
                    $("#ukuran_baju").val("");
                    $("#tanggal_terdaftar").val("");
                } else if (agenId != '' && agenData == 0) {
                    alert("Konsultan sudah terdaftar, silahkan pilih konsultan lama!");
                    $("#inputAgen").val("");
                    $("#no_agen").val("");
                    $("#no_wa").val("");
                    $("#email").val("");
                    $("#no_wa").val("");
                    $("#tanggal_lahir").val("");
                    $("#no_ktp").val("");
                    $("#no_rekening").val("");
                    $("#nama_bank").val("");
                    $("#provinsi").val("");
                    $("#kota").val("");
                    $("#kecamatan").val("");
                    $("#status_perkawinan").val("");
                    $("#pekerjaan").val("");
                    $("#hobi").val("");
                    $("#jenis_kelamin").val("");
                    $("#ukuran_baju").val("");
                    $("#tanggal_terdaftar").val("");
                } else {
                    $("#form").submit();
                }
            });
            $("#inputAgen").on("keyup paste", function(event) {
                const selectionKeys = [38, 39, 40, 13];
                if (selectionKeys.includes(event.which) === false) {
                    $("#id_agen").val('');
                }
            });
            $("#inputAgen").autocomplete({
                minLength: 3,
                source: function(request, response) {
                    data = getDataAgen(request).then(data => {
                        response(data);
                    }).catch(err => {
                        console.log(err)
                    });
                },
                select: function(event, ui) {
                    event.preventDefault();
                    populateField(ui);
                },
                focus: function(event, ui) {
                    event.preventDefault();
                    populateField(ui);
                }
            }).keyup(function(event, ui) {
                if (ui !== 'undefined' && ui !== null) {
                    $("#no_agen").val("");
                    $("#email").val("");
                    $("#no_wa").val("");
                    $("#tanggal_lahir").val("");
                    $("#no_ktp").val("");
                    $("#no_rekening").val("");
                    $("#nama_bank").val("");
                    $("#provinsi").val("");
                    $("#kota").val("");
                    $("#kecamatan").val("");
                    $("#status_perkawinan").val("");
                    $("#pekerjaan").val("");
                    $("#hobi").val("");
                    $("#jenis_kelamin").val("");
                    $("#ukuran_baju").val("");
                    $("#tanggal_terdaftar").val("");
                }
            });

            function populateField(ui) {
                $("#id_agen").val(ui.item.value);
                $("#inputAgen").val(ui.item.label);
                $("#no_agen").val(ui.item.no_agen);
                $("#email").val(ui.item.email);
                $("#no_wa").val(ui.item.no_wa);
                $("#no_ktp").val(ui.item.no_ktp);
                $("#tanggal_lahir").val(ui.item.tanggal_lahir);
                $("#no_rekening").val(ui.item.no_rekening);
                $("#nama_bank").val(ui.item.nama_bank);
                $("#provinsi").val(ui.item.provinsi);
                $("#kota").val(ui.item.kota);
                $("#kecamatan").val(ui.item.kecamatan);
                $("#status_perkawinan").val(ui.item.status_perkawinan);
                $("#pekerjaan").val(ui.item.pekerjaan);
                $("#hobi").val(ui.item.hobi);
                $("#jenis_kelamin").val(ui.item.jenis_kelamin);
                $("#ukuran_baju").val(ui.item.ukuran_baju);
                $("#tanggal_terdaftar").val(ui.item.tanggal_terdaftar);
            }

            async function getDataAgen(request) {
                var agenNames = [];
                await $.getJSON("<?php echo base_url() . 'staff/kelola_agen/agen_autocomplete' ?>", request)
                    .done(function(data) {
                        $.each(data, function(idx, d) {
                            let label = d.nama_agen + " (" + d.no_agen + ")";
                            let name = {
                                "label": label,
                                "value": d.id_agen,
                                "no_agen": d.no_agen,
                                "email": d.email,
                                "no_wa": d.no_wa,
                                "no_ktp": d.no_ktp,
                                "tanggal_lahir": d.tanggal_lahir,
                                "no_rekening": d.no_rekening,
                                "nama_bank": d.nama_bank,
                                "provinsi": d.provinsi,
                                "kota": d.kota,
                                "kecamatan": d.kecamatan,
                                "status_perkawinan": d.status_perkawinan,
                                "pekerjaan": d.pekerjaan,
                                "hobi": d.hobi,
                                "jenis_kelamin": d.jenis_kelamin,
                                "ukuran_baju": d.ukuran_baju,
                                "tanggal_terdaftar": d.tanggal_terdaftar,
                            };
                            agenNames.push(name);
                        });
                    });
                return agenNames;
            }

            $("#provinsi").change(function() {
                var provId = $(this).find(":selected").attr('rel');
                $.getJSON("getRegencies", {
                    provId: provId
                }, function(data) {
                    $('#kota').find('option').remove();
                    $('#kecamatan').find('option').remove();
                    populateDistrict(data[0]['id']);
                    $(data).each(function(index, item) {
                        $('#kota').append('<option value="' + item['name'] +
                            '" rel="' + item['id'] + '">' + item['name'] + '</option>');
                    });
                });
            });

            $("#kota").change(function() {
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
        });
    </script>
</body>

</html>