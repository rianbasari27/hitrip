<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/image-popup.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/default/easyui.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/icon.css"> -->
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <!-- add for datepicker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>asset/easyui-custom/jquery.easyui.min.js"></script> -->
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.fakemultitouch.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/datepicker/lib/drum.css">
    <script src="<?php echo base_url(); ?>asset/datepicker/lib/drum.js"></script>
    <style>
        .bg-6 {
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/banner_dokumen.jpg");
        }

        .files-form {
            border-radius: 8px;
        }

        .custom-combobox-input {
            border-radius: 8px;
        }

        /* CSS for datepicker */
        .date-picker {
            background-color: white !important;
        }

        div.date_wrapper {
            width: 265px;
        }

        div.date_wrapper .date_header {
            height: 25px;
            font-weight: 400;
            border-bottom: 1px solid #CCC;
            margin-bottom: 10px;
        }

        div.date_wrapper .date_header span.title {
            float: left;
            text-align: left;
        }

        div.date_wrapper .date_header span.selection {
            float: right;
            text-align: right;
            color: #CE0000;
        }

        div.date_wrapper form {
            position: relative;
        }

        div.date_wrapper .lines {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            border-top: solid 1px #CCC;
            border-bottom: solid 1px #CCC;
            position: absolute;
            top: 58px;
            left: 0px;
            width: 100%;
            height: 24px;
        }

        div.date_wrapper .lines div {
            margin-left: 220px;
            line-height: 21px;
        }

        div.drum-wrapper {
            float: left;
        }

        div.drum figure {
            text-align: left;
        }

        #drum_hours figure,
        #drum_date figure {
            text-align: right;
        }

        #drum_date,
        #drum_to_date {
            margin-left: 10px;
            margin-right: 5px;
        }

        #drum_date,
        #drum_hours,
        #drum_minutes {
            width: 40px;
            font-size: 18px;
        }

        #drum_hours {
            margin-left: 10px;
        }

        #drum_minutes {
            margin-left: 4px;
        }

        #drum_month {
            width: 110px;
            font-size: 18px;
        }

        #drum_fullYear {
            width: 60px;
            font-size: 18px;
        }

        #drum_hours .dial div {
            margin: 0 7px;
        }

        #drum_minutes .dial div {
            margin: 0 2px;
        }
    </style>
    <script>
        // script for datepicker
        Hammer.plugins.fakeMultitouch();

        function getIndexForValue(elem, value) {
            for (var i = 0; i < elem.options.length; i++)
                if (elem.options[i].value == value)
                    return i;
        }

        function pad(number) {
            if (number < 10) {
                return '0' + number;
            }
            return number;
        }

        function update(datetime) {
            $("#date").drum('setIndex', datetime.getDate() - 1);
            $("#month").drum('setIndex', datetime.getMonth());
            $("#fullYear").drum('setIndex', getIndexForValue($("#fullYear")[0], datetime.getFullYear()));
        }

        $(document).ready(function() {
            $("select.date").drum({
                onChange: function(elem) {
                    var selectedYear = parseInt($("#fullYear").val());
                    var selectedMonth = parseInt($("#month").val()) + 1; // Tambahkan 1 karena indeks bulan dimulai dari 0
                    var selectedDate = parseInt($("#date").val());

                    // Periksa apakah tanggal yang dipilih valid untuk bulan yang dipilih
                    var maxDate = new Date(selectedYear, selectedMonth, 0).getDate();
                    if (selectedDate > maxDate) {
                        // Jika tanggal yang dipilih melebihi jumlah hari dalam bulan, atur tanggal ke tanggal terakhir bulan
                        selectedDate = maxDate;
                        $("#date").drum('setIndex', selectedDate - 1);
                    }

                    var date = new Date(selectedYear, selectedMonth - 1, selectedDate); // Kurangi 1 dari bulan karena indeks dimulai dari 0
                    date.setSeconds(0);
                    update(date);

                    var format = date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date.getDate());

                    $('.date_header .selection').html(format);
                }
            });
            // update(new Date());
            <?php if ($jamaah->tanggal_lahir != null) { ?>
                <?php if ($jamaah->tanggal_lahir != 0000 - 00 - 00) { ?>
                    update(new Date("<?php echo $jamaah->tanggal_lahir; ?>"));
                <?php } else { ?>
                    update(new Date());
                <?php } ?>
            <?php } else { ?>
                update(new Date());
            <?php } ?>
        });
    </script>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['jamaah_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Data Jamaah</p>
                    <h1>Update Identitas Jamaah</h1>

                    <p class="mb-3">
                        Lengkapi data untuk <br><span class="color-highlight font-600" style="font-size: 17px;"><?php echo implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name])); ?></span>
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <form role="form" action="<?php echo base_url(); ?>konsultan/update_data_jamaah/proses_update_data" method="post" enctype="multipart/form-data" id="myForm">
                        <input type="hidden" name="id_member" value="<?php echo $_GET['id']; ?>">
                        <input type="hidden" name="id_jamaah" value="<?php echo $jamaah->id_jamaah; ?>">
                        <input type="hidden" name="id_paket" value="<?php echo $member->id_paket; ?>">
                        <div class="form-group mt-4">
                            <label class="text-danger mb-4">Notes : Jika ada tanda ( * ) diwajibkan</label><br>
                            <label class="color-highlight">Nomor KTP <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="ktp_no" class="form-control" id="ktp" value="<?php echo $jamaah->ktp_no; ?>" required>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nama Depan <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="first_name" class="form-control" value="<?php echo $jamaah->first_name; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nama Tengah</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="second_name" class="form-control" value="<?php echo $jamaah->second_name; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nama Akhir</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="last_name" class="form-control" value="<?php echo $jamaah->last_name; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nama Ayah <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="nama_ayah" class="form-control" value="<?php echo $jamaah->nama_ayah; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Tempat Lahir <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="tempat_lahir" id="tempat_Lahir" class="form-control" value="<?php echo $jamaah->tempat_lahir; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Tanggal Lahir (<span class="text-primary font-italic font-weight-lighter"> yyyy-mm-dd </span>) <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon">
                                <a href="#" data-menu="datepicker2" class="text-dark">
                                    <input name="tanggal_lahir" type="date" class="form-control validate-name upper" id="form7" readonly value="<?php echo $jamaah->tanggal_lahir; ?>">
                                </a>
                                <i class="fa fa-check <?php echo $jamaah->tanggal_lahir == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-4 ms-2" id="sharingBed" style="<?php echo ($age >= 2 & $age <= 6) ? 'display:block;' : 'display:none;'; ?>">
                            <label class="color-highlight" for="form10">Sharing Bed</label>
                            <div class="form-check icon-check">
                                <input class="form-check-input" type="radio" name="sharing_bed" value="1" id="radio4" <?php echo $jamaah->member[0]->sharing_bed == 1 ? 'checked' : ''; ?>>
                                <label class="form-check-label font-600" for="radio4" style="font-size: 16px;">Iya
                                </label>
                                </label>
                                <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                            </div>
                            <div class="form-check icon-check">
                                <input class="form-check-input" type="radio" name="sharing_bed" value="0" id="radio5" <?php echo $jamaah->member[0]->sharing_bed != 1 ? 'checked' : ''; ?>>
                                <label class="form-check-label font-600" for="radio5" style="font-size: 16px;">Tidak
                                </label>
                                </label>
                                <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Jenis Kelamin <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon mb-4">
                                <select name="jenis_kelamin" class="form-control">
                                    <option class="text-dark" value="L" <?php echo $jamaah->jenis_kelamin == 'L' ? 'selected' : ''; ?>>
                                        LAKI-LAKI
                                    </option>
                                    <option class="text-dark" value="P" <?php echo $jamaah->jenis_kelamin == 'P' ? 'selected' : ''; ?>>
                                        PEREMPUAN
                                    </option>
                                </select>
                                <i class="fa fa-check <?php echo $jamaah->jenis_kelamin == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Status Perkawinan</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select name="status_perkawinan" class="form-control">
                                    <option class="text-dark" value="Belum Kawin" <?php echo $jamaah->status_perkawinan == 'Belum Kawin' ? 'selected' : ''; ?>>
                                        BELUM KAWIN
                                    </option>
                                    <option class="text-dark" value="Kawin" <?php echo $jamaah->status_perkawinan == 'Kawin' ? 'selected' : ''; ?>>
                                        KAWIN
                                    </option>
                                    <option class="text-dark" value="Cerai" <?php echo $jamaah->status_perkawinan == 'Cerai' ? 'selected' : ''; ?>>
                                        CERAI
                                    </option>
                                </select>
                                <i class="fa fa-check <?php echo $jamaah->status_perkawinan == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nomor HP (Aktif WhatsApp)</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="tel" name="no_wa" class="form-control validate-name" value="<?php echo $jamaah->no_wa; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nomor Telepon Rumah</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="number" name="no_rumah" class="form-control" value="<?php echo $jamaah->no_rumah; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Email</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" id="email" name="email" class="form-control" value="<?php echo $jamaah->email; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Alamat Tinggal</label>
                            <div class="input-style no-borders has-icon ">
                                <textarea class="form-control" name="alamat_tinggal"><?php echo $jamaah->alamat_tinggal; ?></textarea>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Provinsi</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select id="provinsi" name="provinsi" class="form-control">
                                    <?php foreach ($provinceList as $p) { ?>
                                        <option <?php echo $jamaah->provinsi == $p->name ? 'selected' : ''; ?> value="<?php echo $p->name; ?>" rel="<?php echo $p->id; ?>">
                                            <?php echo $p->name; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <i class="fa fa-check <?php echo $provinceList == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Kabupaten/Kota</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select class="form-control" name="kabupaten_kota" id="kabupaten">
                                    <option value="<?php echo $jamaah->kabupaten_kota; ?>" rel="">
                                        <?php echo $jamaah->kabupaten_kota; ?>
                                    </option>
                                </select>
                                <i class="fa fa-check <?php echo $jamaah->kabupaten_kota == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Kecamatan</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select class="form-control" name="kecamatan" id="kecamatan">
                                    <option value="<?php echo $jamaah->kecamatan; ?>" rel="">
                                        <?php echo $jamaah->kecamatan; ?></option>
                                </select>
                                <i class="fa fa-check <?php echo $jamaah->kecamatan == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Kewarganegaraan <strong class="text-danger">
                                    *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control" type="text" name="kewarganegaraan" id="kewarganegaraan" value="<?php echo $jamaah->kewarganegaraan; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Pekerjaan</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control" type="text" name="pekerjaan" value="<?php echo $jamaah->pekerjaan; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Pendidikan Terakhir</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select name="pendidikan_terakhir" class="form-control">
                                    <option value="SD" <?php echo $jamaah->pendidikan_terakhir == 'SD' ? 'selected' : ''; ?>>SD
                                    </option>
                                    <option value="SMP" <?php echo $jamaah->pendidikan_terakhir == 'SMP' ? 'selected' : ''; ?>>
                                        SMP
                                    </option>
                                    <option value="SMA" <?php echo $jamaah->pendidikan_terakhir == 'SMA' ? 'selected' : ''; ?>>
                                        SMA
                                    </option>
                                    <option value="S1" <?php echo $jamaah->pendidikan_terakhir == 'S1' ? 'selected' : ''; ?>>S1
                                    </option>
                                    <option value="S2" <?php echo $jamaah->pendidikan_terakhir == 'S2' ? 'selected' : ''; ?>>S2
                                    </option>
                                    <option value="S3" <?php echo $jamaah->pendidikan_terakhir == 'S3' ? 'selected' : ''; ?>>S3
                                    </option>
                                </select>
                                <i class="fa fa-check <?php echo $jamaah->pendidikan_terakhir == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Penyakit (<span class="text-primary font-italic font-weight-lighter"> " - " bila tidak ada
                                </span>)<strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control" type="text" name="penyakit" value="<?php echo $jamaah->penyakit; ?>">
                                <em></em>
                            </div>
                        </div>
                        <label class="color-highlight">Surat Dokter (<span class="text-primary font-italic font-weight-lighter"> Opsional
                            </span>)</label>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($jamaah->upload_penyakit == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>
                                            <center>
                                                <div id="upload_penyakit">
                                                    <a href="<?php echo base_url() . $jamaah->upload_penyakit; ?>" onclick="window.open('<?php echo base_url() . $jamaah->upload_penyakit; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img src="<?php echo base_url() . $jamaah->upload_penyakit; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="upload_penyakit" href="#" class="btn btn-danger btn-icon-split btn-sm hapusDokter rounded-xs my-2">
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
                                        <input class="form-control files-form files-form" type="file" name="upload_penyakit">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nama Ahli Waris</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="nama_ahli_waris" class="form-control capital" value="<?php echo $jamaah->nama_ahli_waris; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nomor Telepon Ahli Waris</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="no_ahli_waris" class="form-control" value="<?php echo $jamaah->no_ahli_waris; ?>">
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Alamat Ahli Waris</label>
                            <div class="input-style no-borders has-icon ">
                                <textarea class="form-control" name="alamat_ahli_waris"><?php echo $jamaah->alamat_ahli_waris; ?></textarea>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Referensi (<span class="text-primary font-italic font-weight-lighter"> Darimana Anda mendaftar
                                </span>)</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select name="referensi" class="form-control" id="slct" onchange="showOnChange(event)">
                                    <option value="">Pilih salah satu ... </option>
                                    <option class="text-dark" value="Agen" <?php echo $jamaah->referensi == 'Agen' ? 'selected' : ''; ?>>
                                        KONSULTAN
                                    </option>
                                    <option class="text-dark" value="Walk_in" <?php echo $jamaah->referensi == 'Walk_in' ? 'selected' : ''; ?>>
                                        WALK IN
                                    </option>
                                    <option class="text-dark" value="Socmed" <?php echo $jamaah->referensi == 'Socmed' ? 'selected' : ''; ?>>SOCIAL MEDIA
                                    </option>
                                    <option class="text-dark" value="Iklan" <?php echo $jamaah->referensi == 'Iklan' ? 'selected' : ''; ?>>
                                        IKLAN
                                    </option>
                                    <!-- <option class="text-dark" value="Twitter"
                                        <?php echo $jamaah->referensi == 'Twitter' ? 'selected' : ''; ?>>
                                        TWITTER
                                    </option>
                                    <option class="text-dark" value="Website"
                                        <?php echo $jamaah->referensi == 'Website' ? 'selected' : ''; ?>>
                                        WEBSITE
                                    </option>
                                    <option class="text-dark" value="Iklan"
                                        <?php echo $jamaah->referensi == 'Iklan' ? 'selected' : ''; ?>>IKLAN
                                    </option> -->
                                </select>
                                <i class="fa fa-check <?php echo $jamaah->referensi == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <input type="hidden" name="verified" value="<?php echo $jamaah->verified; ?>">
                        </div>
                        <div class="form-group" id="selectOffice" style="display:<?php echo ($jamaah->referensi == 'Iklan' || $jamaah->referensi == 'Socmed' || $jamaah->referensi == 'Walk_in') ? 'block' : 'none'; ?>">
                            <label class="color-highlight" id="form5">Pilih Kantor</label>
                            <div class="input-style no-borders has-icon input-style-always-active validate-field mb-4">
                                <select name="office" class="form-control">
                                    <option value="<?php echo isset($_SESSION['form']['referensi']) ? $_SESSION['form']['referensi'] : ''; ?>">
                                        Pilih salah satu ... </option>
                                    <option value="Head" <?php echo $jamaah->office == 'Head' ? 'selected' : ''; ?>>HEAD
                                        OFFICE</option>
                                    <option value="Cabang" <?php echo $jamaah->office == 'Cabang' ? 'selected' : ''; ?>>
                                        CABANG BANDUNG</option>
                                </select>
                                <em><strong>(wajib diisi)</strong></em>
                            </div>
                        </div>
                        <div class="form-group mb-4" style="display:<?php echo ($jamaah->referensi == 'Agen') ? 'block' : 'none'; ?>;" id="Agen">
                            <div class="ui-widget">
                                <label class="color-highlight">Nama Konsultan</label><br>
                                <select id="combobox" name="id_agen">
                                    <option value="">Pilih Salah Satu...</option>
                                    <?php foreach ($agenList as $ag) { ?>
                                        <option value="<?php echo $ag->id_agen; ?>" <?php echo $member->id_agen == $ag->id_agen ? 'selected' : ''; ?>><?php echo $ag->nama_agen . " - " . $ag->no_agen; ?></option>
                                    <?php } ?>

                                </select>
                            </div>
                            <div class="divider mt-4"></div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Pilihan Kamar</label>
                            <div class="input-style no-borders has-icon mb-4">
                                <select class="form-control" name="pilihan_kamar" <?php echo $countdown <=30 ? 'disabled' : '' ;?>>
                                    <?php foreach ($kamarOption as $ko) { ?>
                                        <option value="<?php echo $ko; ?>" <?php echo $member->pilihan_kamar == $ko ? 'selected' : ''; ?>>
                                            <?php echo $ko; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <i class="fa fa-check <?php echo $kamarOption == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Pernah Umroh dalam 3 tahun terakhir</label>
                            <div class="form-check icon-check">
                                <input class="form-check-input" type="radio" id="radio1" name="pernah_umroh" value="1" <?php echo $jamaah->member[0]->pernah_umroh == 1 ? 'checked' : ''; ?>>
                                <label class="form-check-label font-600" for="radio1" style="font-size: 12px;">Pernah</label>
                                <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                                <em></em>
                            </div>
                            <div class="form-check icon-check">
                                <input class="form-check-input" type="radio" name="pernah_umroh" id='radio2' value="0" <?php echo $jamaah->member[0]->pernah_umroh != 1 ? 'checked' : ''; ?>>
                                <label class="form-check-label font-600" for="radio2" style="font-size: 12px;">Belum
                                    Pernah</label>
                                <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                                <em></em>
                            </div>
                            <div class="divider mt-4"></div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nomor Paspor</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control" type="text" name="paspor_no" value="<?php echo $member->paspor_no; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Nama Paspor</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control" type="text" name="paspor_name" value="<?php echo $member->paspor_name; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Paspor Issue Date</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control datepicker" type="date" name="paspor_issue_date" value="<?php echo $member->paspor_issue_date; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Paspor Expiry Date</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control datepicker" type="date" name="paspor_expiry_date" value="<?php echo $member->paspor_expiry_date; ?>">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Paspor Issuing City</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input class="form-control" type="text" name="paspor_issuing_city" value="<?php echo $member->paspor_issuing_city; ?>">
                                <em></em>
                            </div>
                        </div>

                        <div>Contoh scan paspor yang benar</div>
                        <div class="mb-2">
                            <a href="<?= base_url() . 'asset/images/jamaah/contoh_scan_paspor.jpg' ?>" title="Contoh Scan Paspor" class="default-link" data-gallery="gallery-1">
                                <img src="<?= base_url() . 'asset/images/jamaah/contoh_scan_paspor.jpg' ?>" class="img-fluid shadow-xl rounded-sm" width="128px">
                            </a>
                        </div>
                        <label class="color-highlight">Scan Paspor<strong class="text-danger"> *</strong></label>

                        <div class="card card-style mx-0 shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($member->paspor_scan == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>

                                            <center>
                                                <div id="paspor_scan">
                                                    <a href="<?php echo base_url() . $member->paspor_scan; ?>" onclick="window.open('<?php echo base_url() . $member->paspor_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img class="rounded-sm" src="<?php echo base_url() . $member->paspor_scan; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="paspor_scan" href="#" class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
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
                                        <input class="form-control files-form" type="file" name="paspor_scan">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>

                        <div>Contoh scan paspor yang benar</div>
                        <div class="mb-2">
                            <a href="<?= base_url() . 'asset/images/jamaah/contoh_scan_paspor2.jpg' ?>" title="Contoh Scan Paspor" class="default-link" data-gallery="gallery-1">
                                <img src="<?= base_url() . 'asset/images/jamaah/contoh_scan_paspor2.jpg' ?>" class="img-fluid shadow-xl rounded-sm" width="170px">
                            </a>
                        </div>

                        <label class="color-highlight">Scan Paspor 2</label>
                        <div class="card card-style mx-0 shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($member->paspor_scan2 == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>

                                            <center>
                                                <div id="paspor_scan2">
                                                    <a href="<?php echo base_url() . $member->paspor_scan2; ?>" onclick="window.open('<?php echo base_url() . $member->paspor_scan2; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img class="rounded-sm" src="<?php echo base_url() . $member->paspor_scan2; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="paspor_scan2" href="#" class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
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
                                        <input class="form-control files-form" type="file" name="paspor_scan2">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>
                        <label class="color-highlight">Scan KTP<strong class="text-danger"> *</strong></label>
                        <div class="card card-style mx-0 shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($member->ktp_scan == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>

                                            <center>
                                                <div id="ktp_scan">
                                                    <a href="<?php echo base_url() . $member->ktp_scan; ?>" onclick="window.open('<?php echo base_url() . $member->ktp_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img class="rounded-sm" src="<?php echo base_url() . $member->ktp_scan; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="ktp_scan" href="#" class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
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
                                        <input class="form-control files-form" type="file" name="ktp_scan">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>
                        <label class="color-highlight">Scan Foto (<span class="text-primary font-italic font-weight-lighter"> Bagi yang wanita
                                menggunakan hijab </span> )</label>
                        <div class="card card-style mx-0 shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($member->foto_scan == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>

                                            <center>
                                                <div id="foto_scan">
                                                    <a href="<?php echo base_url() . $member->foto_scan; ?>" onclick="window.open('<?php echo base_url() . $member->foto_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img class="rounded-sm" src="<?php echo base_url() . $member->foto_scan; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="foto_scan" href="#" class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
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
                                        <input class="form-control files-form" type="file" name="foto_scan">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>
                        <label class="color-highlight">Scan KK <strong class="text-danger"> *</strong></label>
                        <div class="card card-style mx-0 shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($member->kk_scan == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>

                                            <center>
                                                <div id="kk_scan">
                                                    <a href="<?php echo base_url() . $member->kk_scan; ?>" onclick="window.open('<?php echo base_url() . $member->kk_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img class="rounded-sm" src="<?php echo base_url() . $member->kk_scan; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="kk_scan" href="#" class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
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
                                        <input class="form-control files-form" type="file" name="kk_scan">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>
                        <label class="color-highlight">Scan VISA (<span class="text-primary font-italic font-weight-lighter"> Jika Ada </span> )</label>
                        <div class="card card-style mx-0 shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($member->visa_scan == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>

                                            <center>
                                                <div id="visa_scan">
                                                    <a href="<?php echo base_url() . $member->visa_scan; ?>" onclick="window.open('<?php echo base_url() . $member->visa_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img class="rounded-sm" src="<?php echo base_url() . $member->visa_scan; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="visa_scan" href="#" class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
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
                                        <input class="form-control files-form" type="file" name="visa_scan">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>
                        <label class="color-highlight">Scan Vaksin (<span class="text-primary font-italic font-weight-lighter"> Jika tidak ada bisa hubungi admin
                                atau konsultan</span> )</label>
                        <div class="card card-style mx-0 shadow mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <?php if ($member->vaksin_scan == null) { ?>
                                            File Belum Ada
                                        <?php } else { ?>

                                            <center>
                                                <div id="vaksin_scan">
                                                    <a href="<?php echo base_url() . $member->vaksin_scan; ?>" onclick="window.open('<?php echo base_url() . $member->vaksin_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                        <img class="rounded-sm" src="<?php echo base_url() . $member->vaksin_scan; ?>" style="width:auto; height:150px">
                                                    </a>
                                                    <a rel="vaksin_scan" href="#" class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
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
                                        <input class="form-control files-form" type="file" name="vaksin_scan">
                                    </div>
                                </div>
                                <em></em>
                            </div>
                        </div>
                        <?php if ($member->paspor_check == 1) { ?>
                            <input type="hidden" name="paspor_check" value="1">
                        <?php } else { ?>
                            <input type="hidden" name="paspor_check" value="0">
                        <?php } ?>

                        <?php if ($member->buku_kuning_check == 1) { ?>
                            <input type="hidden" name="buku_kuning_check" value="1">
                        <?php } else { ?>
                            <input type="hidden" name="buku_kuning_check" value="0">
                        <?php } ?>

                        <?php if ($member->foto_check == 1) { ?>
                            <input type="hidden" name="foto_check" value="1">
                        <?php } else { ?>
                            <input type="hidden" name="foto_check" value="0">
                        <?php } ?>
                        <a href="#"
                            class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s mb-3"
                            id="submitBtn">Submit</a>
                        <!-- <button type="submit" class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s mb-3" style="width: 100%;">Submit</button> -->
                    </form>
                </div>
            </div>


        </div>
        <?php $this->load->view('konsultan/include/alert'); ?>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <!-- Modal new datepicker -->
    <div id="datepicker2" class="date-picker menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="date_header mb-3">
                <span class="title">Tanggal lahir : </span>
                <div class="fw-bold fs-5" id="tanggalLahir"><span id="tahun">0000</span>-<span id="bulan">00</span>-<span id="tanggal">00</span></div>
            </div>
            <div class="row">
                <div class="col-3">
                    Tanggal
                    <input name="tanggal" type="number" class="form-control rounded fs-5 shadow" id="tanggalInput">
                </div>
                <div class="col-5">
                    Bulan
                    <select name="bulan" class="form-control rounded fs-5 shadow" id="bulanInput">
                        <option value="00" selected></option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col">
                    Tahun
                    <input type="number" class="form-control rounded fs-5 shadow" id="tahunInput">
                </div>
            </div>
            <button type="button" id="set" class="close-menu btn btn-sm gradient-highlight font-13 btn-sm font-600 rounded-s" style="float: right;">Pilih</button>
        </div>
    </div>

    <!-- datepicker modal -->
    <div id="datepicker" class="date-picker menu menu-box-modal rounded-m" data-menu-height="280" data-menu-width="350">
        <div class="menu-title mb-0">
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <!-- Date picker here -->
            <div class="date_header">
                <span class="title">Tanggal lahir : </span><span class="selection fw-bold"></span>
            </div>

            <div class="d-block w-full">
                <form name="date">
                    <div class="lines mb-2"></div>
                    <div class="width:100px;">
                        <select class="date" id="date" name="date">
                            <?php for ($i = 1; $i <= 31; $i++) : ?>
                                <option value="<?php echo $i ?>" <?php echo (date('d', strtotime($jamaah->tanggal_lahir)) == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i ?>.</option>
                            <?php endfor; ?>
                        </select>
                        <select class="date" id="month" name="month">
                            <option value="0">Januari</option>
                            <option value="1">Februari</option>
                            <option value="2">Maret</option>
                            <option value="3">April</option>
                            <option value="4">Mei</option>
                            <option value="5">Juni</option>
                            <option value="6">Juli</option>
                            <option value="7">Agustus</option>
                            <option value="8">September</option>
                            <option value="9">Oktober</option>
                            <option value="10">November</option>
                            <option value="11">Desember</option>
                        </select>
                        <select class="date" id="fullYear" name="fullYear">
                            <?php for ($i = date('Y'); $i >= date('Y', strtotime('-100 years')); $i--) : ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="button" id="setTanggal" class="close-menu btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s">Pilih</button>
                </form>
            </div>
        </div>
    </div>


    <div id="imagePopup" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
        <div id="caption"></div>
    </div>


    <?php $this->load->view('konsultan/include/script_view'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // add for datepicker
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-36251023-1']);
        _gaq.push(['_setDomainName', 'jqueryscript.net']);
        _gaq.push(['_trackPageview']);

        (function() {
            var ga = document.createElement('script');
            ga.type = 'text/javascript';
            ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
                '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(ga, s);
        })();
        // end for datepicker

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
            // Limit input tanggal hanya 2 digit
            $("#tanggalInput").on("input", function() {
                var inputValue = $(this).val();
                if (inputValue.length > 2) {
                    $(this).val(inputValue.slice(0, 2));
                }
            });
            // Limit input tahun hanya 2 digit
            $("#tahunInput").on("input", function() {
                var inputValue = $(this).val();
                if (inputValue.length > 4) {
                    $(this).val(inputValue.slice(0, 4));
                }
            });

            function updateTanggal() {
                var tanggalInput = $('#tanggalInput').val();
                if (tanggalInput > 31) {
                    $('#tanggalInput').val(31);
                    tanggalInput = 31;
                }
                var formattedTanggal = (tanggalInput < 10) ? '0' + tanggalInput : tanggalInput;
                if (tanggalInput < 10) {
                    formattedTanggal = '0' + tanggalInput
                } else {
                    formattedTanggal = tanggalInput
                }
                if (tanggalInput.substr(0, 1) == '0') {
                    formattedTanggal = tanggalInput
                }
                if (tanggalInput == '' || tanggalInput == '00') {
                    formattedTanggal = '00'
                }
                $('#tanggal').text(formattedTanggal);
            }

            function updateBulan() {
                var bulanInput = $('#bulanInput').val();
                $('#bulan').text(bulanInput);
            }

            function updateTahun() {
                var tahunInput = $('#tahunInput').val();
                const date = new Date();
                let yearNow = date.getFullYear();
                if (tahunInput > yearNow) {
                    $('#tahunInput').val(yearNow);
                    tahunInput = yearNow.toString();
                }
                if (tahunInput < 10) {
                    formattedTahun = '000' + tahunInput
                } else if (tahunInput < 100) {
                    formattedTahun = '00' + tahunInput
                } else if (tahunInput < 1000) {
                    formattedTahun = '0' + tahunInput
                } else if (tahunInput.substr(0, 1) == 0) {
                    formattedTahun = tahunInput
                } else {
                    formattedTahun = tahunInput
                }

                if (tahunInput == '' ||
                    tahunInput == '00' ||
                    tahunInput == '000' ||
                    tahunInput == '0000') {
                    formattedTahun = '0000'
                }

                $('#tahun').text(formattedTahun);
            }

            function hitungUmur(tanggalLahir, tanggalPaket) {
                var tanggalHariIni = new Date(tanggalPaket);
                var tanggalLahirObj = new Date(tanggalLahir);

                var selisihTahun = tanggalHariIni.getFullYear() - tanggalLahirObj.getFullYear();
                var bulanHariIni = tanggalHariIni.getMonth();
                var bulanLahir = tanggalLahirObj.getMonth();

                // Check apakah belum ulang tahun
                if (bulanHariIni < bulanLahir || (bulanHariIni === bulanLahir && tanggalHariIni.getDate() < tanggalLahirObj.getDate())) {
                    selisihTahun--;
                }

                return selisihTahun;
            }

            $('#tanggalInput').on('input', updateTanggal);
            $('#bulanInput').on('input', updateBulan);
            $('#tahunInput').on('input', updateTahun);

            updateTanggal();
            updateBulan();
            updateTahun();

            // set tanggal
            $("#set").click(function() {
                var tanggal = $('#tanggal').text();
                var bulan = $('#bulan').text();
                var tahun = $('#tahun').text();
                // Bulan yang cuma punya 30 hari
                if (bulan == '02' ||
                    bulan == '04' ||
                    bulan == '06' ||
                    bulan == '09' ||
                    bulan == '11'
                ) {
                    if (tanggal == '31') {
                        alert('Tanggal tidak valid!')
                        return;
                    }
                }
                //Khusus bulan Februari
                if (bulan == '02') {
                    if (tanggal > 29) {
                        alert('Tanggal tidak valid!')
                        return;
                    }
                    // Pengaturan hari pada tahun kabisat
                    if (tahun % 4 != 0) {
                        if (tanggal > 28) {
                            alert('Tanggal tidak valid!')
                            return;
                        }
                    }
                }
                if (tahun == '0000') {
                    alert('Tahun tidak valid!')
                    return;
                }
                if (bulan == '00') {
                    alert('Bulan tidak valid!')
                    return;
                }
                if (tanggal == '00') {
                    alert('Tanggal tidak valid!')
                    return;
                }
                if (tahun < '1850') {
                    alert('Tahun sudah terlalu lama!')
                    return;
                }
                var sourceText = $("#tanggalLahir").text();
                var tanggalPaket = '<?php echo $member->paket_info->tanggal_berangkat; ?>'
                var umur = hitungUmur(sourceText, tanggalPaket);
                if (umur >= 2 && umur <= 6) {
                    document.getElementById('sharingBed').style.display = "block";
                } else {
                    document.getElementById('sharingBed').style.display = "none";
                }
                $("#form7").val(sourceText);
            });

            //set tanggal
            $("#setTanggal").click(function() {
                var sourceText = $(".selection").text();
                $("#form7").val(sourceText);
            });

            // membuat input capital 
            $('input').on('input', function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('input').focusout(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('input').focusin(function() {
                this.value = this.value.toLocaleUpperCase();
            });

            $('#email').on('input', function() {
                this.value = this.value.toLocaleLowerCase();
            });
            $('#email').focusout(function() {
                this.value = this.value.toLocaleLowerCase();
            });

            $('textarea').on('textarea', function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').focusout(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            $('textarea').focusin(function() {
                this.value = this.value.toLocaleUpperCase();
            });
            // end

            $('#submitBtn').on("click", function(event) {
                Swal.fire({
                    title: 'Apa anda sudah yakin?',
                    text: "Jika ada kesalahan data bukan tanggung jawab kami",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#F7C255',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#myForm").submit();
                    }
                })
                $(".swal2-confirm").addClass('bg-highlight')
            });
            $("#ui-button").on("click", function(event) {
                event.preventDefault();
                alert('clicked');
            });

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
            //     $("#datepicker").attr("type", "text");
            //     $(function() {
            //         $("#datepicker").datepicker({
            //             dateFormat: 'yy-mm-dd',
            //             changeYear: true,
            //             changeMonth: true,
            //             yearRange: "1940:-nn"
            //         });
            //     });
            // }

            // $("#ktp").blur(function() {
            //     $.getJSON("getJamaah", {
            //         ktp: $("#ktp").val()
            //     }, function(data) {

            //     });
            // });
            $("#provinsi").change(function() {
                var provId = $(this).find(":selected").attr('rel');
                $.getJSON("<?php echo base_url() . 'konsultan/update_data_jamaah/getRegencies'; ?>", {
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
                $.getJSON("<?php echo base_url() . 'konsultan/update_data_jamaah/getDistricts'; ?>", {
                    regId: regId
                }, function(data) {
                    $('#kecamatan').find('option').remove();
                    $(data).each(function(index, item) {
                        $('#kecamatan').append('<option value="' + item['name'] + '">' + item[
                            'name'] + '</option>');
                    });
                });
            }

            $("#tempat_Lahir").autocomplete({
                source: "<?php echo base_url() . 'konsultan/update_data_jamaah/getTempatLahir'; ?>"
            });
            $("#kewarganegaraan").autocomplete({
                source: "<?php echo base_url() . 'konsultan/update_data_jamaah/getCountries'; ?>"
            });

            $(".hapusImg").click(function() {
                var id = $(this).attr('rel');
                $.getJSON("<?php echo base_url() . 'konsultan/update_data_jamaah/hapus_upload'; ?>", {
                        id_member: "<?php echo $member->id_member; ?>",
                        field: id
                    })
                    .done(function(json) {
                        alert('File berhasil dihapus');
                        $("#" + id).remove();
                        location.reload();
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        alert('File gagal dihapus');
                        location.reload();
                    });

            });

            $(".hapusDokter").click(function() {
                var id = $(this).attr('rel');
                $.getJSON("<?php echo base_url() . 'konsultan/update_data_jamaah/hapus_surat_dokter'; ?>", {
                        id_jamaah: "<?php echo $member->id_jamaah; ?>",
                        field: id
                    })
                    .done(function(json) {
                        alert('File berhasil dihapus');
                        $("#" + id).remove();
                        location.reload();
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        alert('File gagal dihapus');
                        location.reload();
                    });

            });



        });
    </script>
</body>