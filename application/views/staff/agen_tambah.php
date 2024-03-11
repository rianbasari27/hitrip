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


            <?php $this->load->view('staff/include/side_menu', ['data_konsultan' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Konsultan Baru</h1>
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
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/kelola_agen/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">ID Konsultan (Nomor Induk
                                                    Konsultan)</label>
                                                <input class="form-control" type="text" name="no_agen">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Upload MOU</label>
                                                <input class="form-control" type="file" name="mou_doc">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Terdaftar</label>
                                                <input class="form-control" type="date" name="tanggal_terdaftar">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama</label>
                                                <input class="form-control" type="text" name="nama_agen">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir (<span
                                                        class="text-primary font-italic font-weight-lighter">yyyy-mm-dd</span>)</label>
                                                <input id="datepicker" class="form-control" type="date"
                                                    name="tanggal_lahir" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor WhatsApp</label>
                                                <input class="form-control" type="number" name="no_wa">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor KTP</label>
                                                <input class="form-control" type="text" name="no_ktp">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="text" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Rekening</label>
                                                <input class="form-control" type="number" name="no_rekening">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Bank</label>
                                                <select class="form-control" name="nama_bank" id="nama_bank">
                                                    <option disabled selected>-- Pilih Bank --</option>
                                                    <option value="BSI">Bank BSI</option>
                                                    <option value="BCA">Bank BCA</option>
                                                    <option value="Mandiri">Bank Mandiri</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat</label>
                                                <textarea class="form-control" rows="6" name="alamat"></textarea>
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
                                                <select class="form-control" name="kota" id="kabupaten">
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
                                            <!-- <div class="form-group">
                                                <label class="col-form-label">Kabupaten/Kota</label>
                                                <input class="form-control" type="text" name="kota" id="kabupaten">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan</label>
                                                <input class="form-control" type="text" name="kecamatan" id="kecamatan">
                                            </div> -->
                                            <div class="form-group">
                                                <label class="col-form-label">Status Perkawinan</label>
                                                <select name="status_perkawinan" class="form-control">
                                                    <option value="BELUM KAWIN" selected="">Belum Kawin</option>
                                                    <option value="KAWIN">Kawin</option>
                                                    <option value="CERAI">Cerai</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan</label>
                                                <input class="form-control" type="text" name="pekerjaan">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan</label>
                                                <input class="form-control" type="text" name="kewarganegaraan">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Hobi</label>
                                                <input class="form-control" type="text" name="hobi">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control">
                                                    <option value="" selected disabled>-- Pilih salah satu --</option>
                                                    <option value="L">Laki - laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Ukuran Baju</label>
                                                <select name="ukuran_baju" class="form-control">
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
                                                <label class="col-form-label">Pecah Telor</label> <br>
                                                <input type="radio" name="pecah_telor" value="1"> Sudah <br>
                                                <input type="radio" name="pecah_telor" value="0"> Belum
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label text-warning font-weight-bolder">Password
                                                    (Default) : ventouragen</label>
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
    $(document).ready(function() {
        $("#kota").autocomplete({
            source: "getKota"
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