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
                            <h1 class="h3 mb-0 text-gray-800">Update Identitas Jamaah</h1>
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
                                        <form role="form" action="<?php echo base_url(); ?>staff/jamaah/proses_update" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_jamaah" value="<?php echo $id_jamaah; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor KTP</label>
                                                <input class="form-control" type="number" name="ktp_no" id="ktp" value="<?php echo $ktp_no; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Depan</label>
                                                <input class="form-control" type="text" name="first_name" value="<?php echo $first_name; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Tengah</label>
                                                <input class="form-control" type="text" name="second_name" value="<?php echo $second_name; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Akhir</label>
                                                <input class="form-control" type="text" name="last_name" value="<?php echo $last_name; ?>">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Nama Ayah</label>
                                                <input class="form-control" type="text" name="nama_ayah" value="<?php echo $nama_ayah; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir</label>
                                                <input class="form-control" type="text" name="tempat_lahir" id="tempatLahir" value="<?php echo $tempat_lahir; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir (<span class="text-primary font-italic font-weight-lighter">yyyy-mm-dd</span>)</label>
                                                <input id="datepicker" class="form-control" type="date" name="tanggal_lahir" value="<?php echo $tanggal_lahir; ?>" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control">
                                                    <option value="L" <?php echo $jenis_kelamin == 'L' ? 'selected' : ''; ?>>
                                                        Laki-laki</option>
                                                    <option value="P" <?php echo $jenis_kelamin == 'P' ? 'selected' : ''; ?>>
                                                        Perempuan</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Status Perkawinan</label>
                                                <select name="status_perkawinan" class="form-control">
                                                    <option value="Belum Kawin" <?php echo $status_perkawinan == 'Belum Kawin' ? 'selected' : ''; ?>>
                                                        Belum Kawin</option>
                                                    <option value="Kawin" <?php echo $status_perkawinan == 'Kawin' ? 'selected' : ''; ?>>Kawin
                                                    </option>
                                                    <option value="Cerai" <?php echo $status_perkawinan == 'Cerai' ? 'selected' : ''; ?>>Cerai
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor HP (<span class="text-primary font-italic font-weight-lighter">aktif
                                                        Whatsapp</span>)</label>
                                                <input class="form-control" type="text" name="no_wa" value="<?php echo $no_wa; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Telepon Rumah</label>
                                                <input class="form-control" type="number" name="no_rumah" value="<?php echo $no_rumah; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat Tinggal</label>
                                                <textarea class="form-control" rows="6" name="alamat_tinggal"><?php echo $alamat_tinggal; ?></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Provinsi</label>
                                                <select id="provinsi" name="provinsi" class="form-control">
                                                    <?php foreach ($provinceList as $p) { ?>
                                                        <option <?php echo $provinsi == $p->name ? 'selected' : ''; ?> value="<?php echo $p->name; ?>" rel="<?php echo $p->id; ?>">
                                                            <?php echo $p->name; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kabupaten/Kota</label>
                                                <select class="form-control" name="kabupaten_kota" id="kabupaten">
                                                    <option value="<?php echo $kabupaten_kota; ?>" rel="">
                                                        <?php echo $kabupaten_kota; ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kecamatan</label>
                                                <select class="form-control" name="kecamatan" id="kecamatan">
                                                    <option value="<?php echo $kecamatan; ?>" rel="">
                                                        <?php echo $kecamatan; ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kewarganegaraan</label>
                                                <input class="form-control" type="text" name="kewarganegaraan" id="kewarganegaraan" value="<?php echo $kewarganegaraan; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pekerjaan</label>
                                                <input class="form-control" type="text" name="pekerjaan" value="<?php echo $pekerjaan; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pendidikan Terakhir</label>
                                                <select name="pendidikan_terakhir" class="form-control">
                                                    <option value="SD" <?php echo $pendidikan_terakhir == 'SD' ? 'selected' : ''; ?>>SD
                                                    </option>
                                                    <option value="SMP" <?php echo $pendidikan_terakhir == 'SMP' ? 'selected' : ''; ?>>SMP
                                                    </option>
                                                    <option value="SMA" <?php echo $pendidikan_terakhir == 'SMA' ? 'selected' : ''; ?>>SMA
                                                    </option>
                                                    <option value="S1" <?php echo $pendidikan_terakhir == 'S1' ? 'selected' : ''; ?>>S1
                                                    </option>
                                                    <option value="S2" <?php echo $pendidikan_terakhir == 'S2' ? 'selected' : ''; ?>>S2
                                                    </option>
                                                    <option value="S3" <?php echo $pendidikan_terakhir == 'S3' ? 'selected' : ''; ?>>S3
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Penyakit</label>
                                                <input class="form-control" type="text" name="penyakit" value="<?php echo $penyakit; ?>">
                                            </div>
                                            <label class="col-form-label">Surat Dokter (<span
                                                        class="text-primary font-italic font-weight-lighter"> Jika ada </span>)</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($upload_penyakit == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>
                                                            <center>
                                                                <div id="upload_penyakit">
                                                                    <a href="<?php echo base_url() . $upload_penyakit; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $upload_penyakit; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $upload_penyakit; ?>"
                                                                            style="width:auto; height:150px">
                                                                    </a>
                                                                    <a rel="upload_penyakit" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="upload_penyakit">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Referensi (<span class="text-primary font-italic font-weight-lighter">Dari mana
                                                        Anda mendaftar</span>)</label>
                                                    <select name="referensi" class="form-control" id="slct"
                                                    onchange="showOnChange(event)">
                                                    <option value="">Pilih salah satu ... </option>
                                                    <option value="Agen" <?php echo $referensi == 'Agen' ? 'selected' : ''; ?>>
                                                        Konsultan</option>
                                                    <option value="Walk_in" <?php echo $referensi == 'Walk_in' ? 'selected' : ''; ?>>Wakl IN</option>
                                                    <option value="Socmed" <?php echo $referensi == 'Socmed' ? 'selected' : ''; ?>>Social Media
                                                    </option>
                                                    <option value="Iklan" <?php echo $referensi == 'Iklan' ? 'selected' : ''; ?>>Iklan
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group" id="selectOffice" style="display:<?php echo ($referensi == 'Iklan' || $referensi == 'Socmed' || $referensi == 'Walk_in') ? 'block' :'none' ;?>">
                                                <div class="ui-widget">
                                                    <label>Pilih Kantor</label><br>
                                                    <!--<input class="form-control" type="text" id="agenComplete" name="nama_agen" value="<?php echo $member->nama_agen; ?>">-->
                                                    <select name="office" class="form-control">
                                                        <option value="">Pilih salah satu ... </option>
                                                        <option value="Head" <?php echo ($office == 'Head') ? 'selected' : '' ;?>>Head Office</option>
                                                        <option value="Cabang" <?php echo ($office == 'Cabang') ? 'selected' : '' ;?>>Cabang Bandung</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" id="Agen" style="display:<?php echo ($referensi == 'Agen') ? 'block' :'none' ;?>;">
                                                <div class="ui-widget">
                                                    <label>Nama Konsultan</label><br>
                                                    <!--<input class="form-control" type="text" id="agenComplete" name="nama_agen" value="<?php echo $member->nama_agen; ?>">-->
                                                    <select id="combobox" name="id_agen">
                                                        <option value="">Pilih Salah Satu...</option>
                                                        <?php foreach ($agenList as $ag) { ?>
                                                        <option value="<?php echo $ag->id_agen; ?>" <?php echo $member[0]->id_agen == $ag->id_agen ? 'selected' : ''; ?>><?php echo $ag->nama_agen; ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="py-2">
                                                <h6 class="m-0 font-weight-bold text-primary">Profil Ahli Waris</h6>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Lengkap</label>
                                                <input class="form-control" type="text" name="nama_ahli_waris" value="<?php echo $nama_ahli_waris; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Telp</label>
                                                <input class="form-control" type="number" name="no_ahli_waris" value="<?php echo $no_ahli_waris; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Alamat</label>
                                                <textarea class="form-control" rows="4" name="alamat_ahli_waris"><?php echo $alamat_ahli_waris; ?></textarea>
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

            $(".hapusImg").click(function() {
            var id = $(this).attr('rel');
            $.getJSON("<?php echo base_url(); ?>staff/jamaah/hapus_surat_dokter", {
                    id_jamaah: "<?php echo $id_jamaah; ?>",
                    field: id
                })
                .done(function(json) {
                    alert('File berhasil dihapus');
                    $("#" + id).remove();
                })
                .fail(function(jqxhr, textStatus, error) {
                    alert('File gagal dihapus');
                });

            });
        });
    </script>
</body>

</html>