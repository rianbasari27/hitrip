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
                            <h1 class="h3 mb-0 text-gray-800">Ubah Data Konsultan</h1>
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
                                            action="<?php echo base_url(); ?>staff/kelola_agen/proses_ubah"
                                            method="post">
                                            <input type="hidden" name="id_agen"
                                                value="<?php echo $dataAgen->id_agen;?>">
                                            <div class="form-group">
                                                <label class="col-form-label">NIK (Nomor Induk Konsultan)</label>
                                                <input class="form-control" type="text" name="no_agen"
                                                    value="<?php echo $dataAgen->no_agen; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Terdaftar</label>
                                                <input class="form-control" type="date" name="tanggal_terdaftar"
                                                    value="<?php echo $dataAgen->tanggal_terdaftar; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama</label>
                                                <input class="form-control" type="text" name="nama_agen"
                                                    value="<?php echo $dataAgen->nama_agen; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir (<span
                                                        class="text-primary font-italic font-weight-lighter">yyyy-mm-dd</span>)</label>
                                                <input id="datepicker" class="form-control" type="date"
                                                    name="tanggal_lahir" value="<?php echo $dataAgen->tanggal_lahir;?>"
                                                    autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor WhatsApp</label>
                                                <input class="form-control" type="number" name="no_wa"
                                                    value="<?php echo $dataAgen->no_wa; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor KTP</label>
                                                <input class="form-control" type="text" name="no_ktp"
                                                    value="<?php echo $dataAgen->no_ktp; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="text" name="email"
                                                    value="<?php echo $dataAgen->email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Rekening</label>
                                                <input class="form-control" type="number" name="no_rekening"
                                                    value="<?php echo $dataAgen->no_rekening; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Bank</label>
                                                <select class="form-control" name="nama_bank" id="nama_bank">
                                                    <option value="BSI"
                                                        <?php echo $dataAgen->nama_bank == 'BSI' ? 'selected' : '' ?>>
                                                        Bank BSI</option>
                                                    <option value="BCA"
                                                        <?php echo $dataAgen->nama_bank == 'BCA' ? 'selected' : '' ?>>
                                                        Bank BCA</option>
                                                    <option value="Mandiri"
                                                        <?php echo $dataAgen->nama_bank == 'Mandiri' ? 'selected' : '' ?>>
                                                        Bank Mandiri</option>
                                                </select>
                                                <!-- <input class="form-control" type="text" name="nama_bank"
                                                    value="<?php echo $dataAgen->nama_bank; ?>"> -->
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat</label>
                                                <textarea class="form-control" rows="6"
                                                    name="alamat"><?php echo $dataAgen->alamat; ?></textarea>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-form-label">Provinsi</label>
                                                <input class="form-control" type="text" name="kota" id="provinsi"
                                                    value="<?php echo $dataAgen->provinsi; ?>">
                                            </div> -->
                                            <div class="form-group">
                                                <label class="col-form-label">Provinsi</label>
                                                <select id="provinsi" name="provinsi" class="form-control">
                                                    <?php foreach ($provinsi as $p) { ?>
                                                    <option <?php echo $dataAgen->provinsi==$p->name?'selected':'';?>
                                                        value="<?php echo $p->name; ?>" rel="<?php echo $p->id; ?>">
                                                        <?php echo $p->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten/Kota</label>
                                                <select class="form-control" name="kota" id="kabupaten">
                                                    <option value="<?php echo $dataAgen->kota; ?>" rel="">
                                                        <?php echo $dataAgen->kota; ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan</label>
                                                <select class="form-control" name="kecamatan" id="kecamatan">
                                                    <option value="<?php echo $dataAgen->kecamatan; ?>" rel="">
                                                        <?php echo $dataAgen->kecamatan; ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Status Perkawinan</label>
                                                <select name="status_perkawinan" class="form-control">
                                                    <option value="BELUM KAWIN"
                                                        <?php echo $dataAgen->status_perkawinan == 'BELUM KAWIN' ? 'selected' : '';?>>
                                                        Belum Kawin</option>
                                                    <option value="KAWIN"
                                                        <?php echo $dataAgen->status_perkawinan == 'KAWIN' ? 'selected' : '';?>>
                                                        Kawin</option>
                                                    <option value="CERAI"
                                                        <?php echo $dataAgen->status_perkawinan == 'CERAI' ? 'selected' : '';?>>
                                                        Cerai</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan</label>
                                                <input class="form-control" type="text" name="pekerjaan"
                                                    value="<?php echo $dataAgen->pekerjaan; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan</label>
                                                <input class="form-control" type="text" name="kewarganegaraan"
                                                    value="<?php echo $dataAgen->kewarganegaraan; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Hobi</label>
                                                <input class="form-control" type="text" name="hobi"
                                                    value="<?php echo $dataAgen->hobi; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control">
                                                    <option value=""
                                                        <?php echo $dataAgen->jenis_kelamin == NULL ? 'selected' : '' ;?>
                                                        disabled>
                                                        -- Pilih salah satu --</option>
                                                    <option value="L"
                                                        <?php echo $dataAgen->jenis_kelamin == 'L' ? 'selected' : '' ;?>>
                                                        Laki -
                                                        laki</option>
                                                    <option value="P"
                                                        <?php echo $dataAgen->jenis_kelamin == 'P' ? 'selected' : '' ;?>>
                                                        Perempuan
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Ukuran Baju</label>
                                                <select name="ukuran_baju" class="form-control">
                                                    <option value=""
                                                        <?php echo $dataAgen->ukuran_baju == NULL ? 'selected' : '' ;?>
                                                        disabled>
                                                        -- Pilih salah satu --
                                                    </option>
                                                    <option value="XXL"
                                                        <?php echo $dataAgen->ukuran_baju == 'XXL' ? 'selected' : '' ;?>>
                                                        XXL
                                                    </option>
                                                    <option value="XL"
                                                        <?php echo $dataAgen->ukuran_baju == 'XL' ? 'selected' : '' ;?>>
                                                        XL
                                                    </option>
                                                    <option value="L"
                                                        <?php echo $dataAgen->ukuran_baju == 'L' ? 'selected' : '' ;?>>L
                                                    </option>
                                                    <option value="M"
                                                        <?php echo $dataAgen->ukuran_baju == 'M' ? 'selected' : '' ;?>>M
                                                    </option>
                                                    <option value="S"
                                                        <?php echo $dataAgen->ukuran_baju == 'S' ? 'selected' : '' ;?>>S
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pecah Telor</label> <br>
                                                <input type="radio" name="pecah_telor" value="1"
                                                    <?php echo $dataAgen->pecah_telor == 1 ? 'checked' : '' ?>> Sudah
                                                <br>
                                                <input type="radio" name="pecah_telor" value="0"
                                                    <?php echo $dataAgen->pecah_telor == 0 ? 'checked' : '' ?>> Belum
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