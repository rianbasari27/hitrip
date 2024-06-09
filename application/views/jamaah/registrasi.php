<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/image-popup.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/easy_datepicker/dist/jquery.date-dropdowns.js"></script>
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/easy_datepicker/demo/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/datepicker/lib/drum.css">
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- add for datepicker -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.fakemultitouch.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/lib/drum.js"></script>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url() . $paket->banner_image; ?>");
    }

    /* CSS for datepicker */
    .date-picker {
        background-color: white !important;
    }

    select:not(:-internal-list-box) {
        overflow: visible !important;
    }

    option {
        color: black;
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
        width: 120px;
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
                var selectedMonth = parseInt($("#month").val()) + 1;
                var selectedDate = parseInt($("#date").val());

                var maxDate = new Date(selectedYear, selectedMonth, 0).getDate();
                if (selectedDate > maxDate) {
                    selectedDate = maxDate;
                    $("#date").drum('setIndex', selectedDate - 1);
                }

                var date = new Date(selectedYear, selectedMonth - 1, selectedDate);
                date.setSeconds(0);
                update(date);

                var format = date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date
                    .getDate());

                $('.date_header .selection').html(format);
            }
        });
        update(new Date());
    });
    </script>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu'); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style bg-home" data-card-height="300">
                <div class="card-bottom ms-3 me-3">
                    <h1 class="font-40 line-height-xl color-white"><?php echo $paket->nama_paket; ?></h1>
                    <p class="color-white opacity-60"><i
                            class="fa fa-plane-departure me-2"></i><?php echo date_format(date_create($paket->tanggal_berangkat), 'l, j F Y'); ?>
                    </p>
                    <p class="color-white opacity-80 font-15">
                        Siapkan dirimu untuk petualangan tak terlupakan. Mulailah menjelajahi dunia yang menakjubkan!
                    </p>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <form action="<?php echo base_url(); ?>jamaah/daftar/proses" method="post" id="myForm">
                <div class="card card-style">
                    <div class="content">
                        <p class="mb-n1 color-highlight font-600 font-12">Formulir Pendaftaran</p>
                        <h4><?php echo $paket->nama_paket; ?></h4>
                        <p>
                            Lengkapi formulir dibawah ini. Pastikan data Anda diinput dengan benar.
                        </p>
                        <?php if (isset($_SESSION['alert'])) { ?>
                        <div class="card card-style bg-pink2-light ms-0 me-0 pt-2 pb-0 rounded-0">
                            <ul class="color-white">
                                <?php echo $_SESSION['alert']['message']; ?>
                            </ul>
                        </div>
                        <?php } ?>
                        <?php if ($parent_id != null) { ?>
                        <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>">
                        <?php } ?>
                        <input type="hidden" name="id_paket" value="<?php echo $paket->id_paket; ?>">
                        <input type="hidden" name="id_user" value="<?php echo $user->id_user; ?>">
                        <div class="mt-1 mb-3">
                            <div class="mb-5">
                                <p class="mb-n1 font-600 color-green-dark">Tipe Kamar</p>
                                <h1>Pilih Tipe Kamar</h1>
                                <p class="opacity-60">
                                    Harga yang dikenakan sesuai dengan jenis kamar yang dipilih.
                                </p>
                                <?php $n = 0;
                                foreach ($paket->availableKamar as $availableKamar) {
                                    $n++; ?>
                                <div class="form-check icon-check">
                                    <input class="form-check-input" type="radio" name="pilihan_kamar"
                                        value="<?php echo $availableKamar; ?>" id="radio<?php echo $n; ?>"
                                        <?php echo $n == 1 && !isset($_SESSION['form']['pilihan_kamar']) ? 'checked' : ''; ?>
                                        <?php if (isset($_SESSION['form']['pilihan_kamar'])) {
                                                                                                                                                                                                                                                                        if ($_SESSION['form']['pilihan_kamar'] == $availableKamar) {
                                                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                    ?>>
                                    <label class="form-check-label font-600" for="radio<?php echo $n; ?>"
                                        style="font-size: 16px;">
                                        <?php echo $availableKamar; ?>
                                        (
                                        <?php if ($availableKamar == 'Quad') { ?>
                                        <?php echo "Rp." . number_format($paket->harga, 0, ',', '.') . ",-"; ?>
                                        <?php } elseif ($availableKamar == 'Triple') { ?>
                                        <?php echo "Rp." . number_format($paket->harga_triple, 0, ',', '.') . ",-"; ?>
                                        <?php } elseif ($availableKamar == 'Double') { ?>
                                        <?php echo "Rp." . number_format($paket->harga_double, 0, ',', '.') . ",-"; ?>
                                        <?php } ?>
                                        )
                                    </label>
                                    <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                    <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                                </div>
                                <?php } ?>
                            </div>


                        </div>
                        <?php if (isset($parent_id)) : ?>
                        <div class="form-group">
                            <div
                                class="input-style has-borders no-icon input-style-always-active validate-field mt-4 mb-4">
                                <input name="referensi" type="tel" class="form-control validate-name upper" id="form9"
                                    value="<?php echo $jamaah->referensi ?>" readonly>
                                <label for="form9" class="color-highlight">Referensi <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-check valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <?php if ($jamaah->referensi != 'Agen') : ?>
                            <div
                                class="input-style has-borders no-icon input-style-always-active validate-field mt-4 mb-4">
                                <input name="office" type="tel" class="form-control validate-name upper" id="form10"
                                    value="<?php echo $jamaah->office ?>" readonly>
                                <label for="form10" class="color-highlight">Office</label>
                                <i class="fa fa-check valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <?php else : ?>
                            <div
                                class="input-style has-borders no-icon input-style-always-active validate-field mt-4 mb-4">
                                <input type="hidden" name="id_agen"
                                    value="<?php echo $jamaah->member[0]->agen->id_agen ?>">
                                <input name="agen" type="tel" class="form-control validate-name upper" id="form11"
                                    value="<?php echo $jamaah->member[0]->agen->nama_agen ?>" readonly>
                                <label for="form11" class="color-highlight">Nama Konsultan</label>
                                <i class="fa fa-check valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (isset($parent_id)) : ?>
                <div class="card card-style">
                    <div class="content">
                        <h4 class="mb-3">Jamaah yang terdaftar</h4>
                        <?php if ($jamaah->member[0]->parent_id == null) : ?>
                        <div class="d-flex mb-2">
                            <div class="align-self-center rounded-sm shadow-l bg-gray-light p-2 me-2">
                                <img src="<?php echo base_url() ?>asset/appkit/images/ventour/avatar.png" width="30">
                            </div>
                            <div class="align-self-center">
                                <p class="color-highlight font-11 mb-n2">Jamaah 1</p>
                                <h2 class="font-15 line-height-s mt-1 mb-1">
                                    <?php echo implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name])) ?>
                                </h2>
                            </div>
                        </div>
                        <?php else : ?>
                        <?php if (isset($parent_id)) : ?>
                        <?php foreach ($parentMembers as $key => $pm) : ?>
                        <div class="d-flex mb-2">
                            <div class="align-self-center rounded-sm shadow-l bg-gray-light p-2 me-2">
                                <img src="<?php echo base_url() ?>asset/appkit/images/ventour/avatar.png" width="30">
                            </div>
                            <div class="align-self-center">
                                <p class="color-highlight font-11 mb-n2">Jamaah <?php echo $key + 1 ?></p>
                                <h2 class="font-15 line-height-s mt-1 mb-1">
                                    <?php echo implode(' ', array_filter([$pm->jamaahData->first_name, $pm->jamaahData->second_name, $pm->jamaahData->last_name])) ?>
                                </h2>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="card card-style">
                    <div class="content">
                        <h4>Isi data diri Anda</h4>
                        <div class="mt-1 mb-3">
                            <?php //if (isset($parent_id)) : 
                            ?>
                            <label class="text-danger mb-4">Notes : Jika ada tanda ( * ) diwajibkan</label>

                            <!-- <div class="form-group" id="selectOffice" style="display: none;">
                                    <label class="color-highlight" for="form10">Pilih Kantor</label>
                                    <div
                                        class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                        <select name="office" class="form-control" id="form10">
                                            <option
                                                value="<?php echo isset($_SESSION['form']['referensi']) ? $_SESSION['form']['referensi'] : ''; ?>">
                                                Pilih salah satu ... </option>
                                            <option value="Head">HEAD OFFICE</option>
                                            <option value="Cabang">CABANG BANDUNG</option>
                                        </select>
                                        <em><strong>(wajib diisi)</strong></em>
                                    </div>
                                </div>
                                <div class="form-group mb-4" id="Agen" style="<?php echo ($agen == null) ? 'display: none;' : 'display: block;'; ?>">
                                    <div class="ui-widget">
                                        <label class="color-highlight">Nama Konsultan</label><br>
                                        <select id="combobox" name="id_agen">
                                            <?php if ($agen == null) { ?>
                                                <option value="">Pilih Salah Satu...</option>
                                                <?php foreach ($agenList as $ag) { ?>
                                                <option value="<?php echo $ag->id_agen; ?>"><?php echo $ag->nama_agen . " - " . $ag->no_agen; ?></option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="<?php echo $agen[0]->id_agen; ?>"><?php echo $agen[0]->nama_agen . " - " . $agen[0]->no_agen; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="divider mt-4"></div>
                                </div> -->
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="name" type="name" class="form-control validate-name upper" id="form1"
                                    placeholder="" value="<?php echo $user->name ?>">
                                <label for="form1" class="color-highlight">Nama Lengkap <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em><strong>(wajib diisi)</strong></em>
                            </div>
                            <!-- <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="last_name" type="name" class="form-control validate-name upper" id="form3" placeholder="" value="<?php echo isset($_SESSION['form']['last_name']) ? $_SESSION['form']['last_name'] : ''; ?>">
                                <label for="form3" class="color-highlight">Nama Belakang</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                            </div> -->
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="no_ktp" type="text" class="form-control validate-name upper" id="form4"
                                    placeholder="" value="<?php echo $user->no_ktp != null ? $user->no_ktp : ''; ?>">
                                <label for="form4" class="color-highlight">Nomor KTP <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em><strong>(wajib diisi)</strong></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <a href="#" data-menu="datepicker2" class="text-dark">
                                    <input name="tanggal_lahir" type="date" class="form-control validate-name upper"
                                        id="form7" readonly
                                        value="<?php echo $user->tanggal_lahir != null ? $user->tanggal_lahir : ''; ?>">
                                    <label for="form7" class="color-highlight">Tanggal Lahir <strong
                                            class="text-danger">*</strong></label>
                                </a>
                            </div>
                            <div class="form-group mb-4 ms-2" id="sharingBed" style="display: none;">
                                <label class="color-highlight" for="form10">Sharing Bed</label>
                                <div class="form-check icon-check">
                                    <input class="form-check-input" type="radio" name="sharing_bed" value="1"
                                        id="radio4">
                                    <label class="form-check-label font-600" for="radio4" style="font-size: 16px;">Iya
                                    </label>
                                    </label>
                                    <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                    <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                                </div>
                                <div class="form-check icon-check">
                                    <input class="form-check-input" type="radio" name="sharing_bed" value="0"
                                        id="radio5" checked>
                                    <label class="form-check-label font-600" for="radio5" style="font-size: 16px;">Tidak
                                    </label>
                                    </label>
                                    <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                    <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                                </div>
                            </div>
                            <div class="input-style has-borders input-style-always-active validate-field mb-4">
                                <label for="select" class="color-highlight">Jenis Kelamin <strong class="text-danger">
                                        *</strong></label>
                                <select name="jenis_kelamin" id="form-9">
                                    <option class="color-dark-dark" value="" disabled selected>-- Pilih Jenis Kelamin --
                                    </option>
                                    <option class="color-dark-dark"
                                        <?php echo $user->jenis_kelamin == 'L' ? 'selected' : ''; ?> value="L">LAKI-LAKI
                                    </option>
                                    <option class="color-dark-dark"
                                        <?php echo $user->jenis_kelamin == 'P' ? 'selected' : ''; ?> value="P">PEREMPUAN
                                    </option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <label class="color-highlight">Referensi <strong class="text-danger"> *</strong></label>
                                <select name="referensi" class="form-control" id="slct" onchange="showOnChange(event)">
                                    <option class="color-dark-dark"
                                        value="<?php echo isset($_SESSION['form']['referensi']) ? $_SESSION['form']['referensi'] : ''; ?>"
                                        disabled selected>Pilih salah satu ... </option>
                                    <!-- <option value="Agen" class="color-dark-dark" <?php echo ($agen == null) ? '' : 'selected'; ?>>KONSULTAN
                                    </option> -->
                                    <option value="Walk_in"
                                        <?php echo $user->referensi == 'Walk_in' ? 'selected' : ''; ?>
                                        class="color-dark-dark">WALK IN</option>
                                    <option value="Teman" <?php echo $user->referensi == 'Teman' ? 'selected' : ''; ?>
                                        class="color-dark-dark">TEMAN/SAUDARA</option>
                                    <option value="Socmed" <?php echo $user->referensi == 'Socmed' ? 'selected' : ''; ?>
                                        class="color-dark-dark">SOCIAL MEDIA</option>
                                    <option value="Iklan" <?php echo $user->referensi == 'Iklan' ? 'selected' : ''; ?>
                                        class="color-dark-dark">IKLAN</option>
                                </select>
                                <em><strong>(wajib diisi)</strong></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="kode_voucher" type="text" class="form-control validate-name upper"
                                    id="formKode" placeholder="" value="">
                                <label for="formKode" class="color-highlight">Kode Voucher <strong
                                        class="text-secondary">(Opsional)</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em><strong>(wajib diisi)</strong></em>
                            </div>
                            <!-- <div class="form-group" id="selectOffice" style="display: none;">
                                    <label class="color-highlight" for="form10">Pilih Kantor</label>
                                    <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                        <select name="office" class="form-control" id="form10">
                                            <option value="<?php echo isset($_SESSION['form']['referensi']) ? $_SESSION['form']['referensi'] : ''; ?>" disabled selected>
                                                Pilih salah satu ... </option>
                                            <option value="Head" class="color-dark-dark">HEAD OFFICE</option>
                                            <option value="Cabang" class="color-dark-dark">CABANG BANDUNG</option>
                                        </select>
                                        <em><strong>(wajib diisi)</strong></em>
                                    </div>
                                </div> -->
                            <!-- <div class="form-group mb-4" id="Agen" style="<?php echo ($agen == null) ? 'display: none;' : 'display: block;'; ?>">
                                    <div class="ui-widget">
                                        <label class="color-highlight">Nama Konsultan</label><br>
                                        <select id="combobox" name="id_agen">
                                            <?php if ($agen == null) { ?>
                                                <option class="color-dark-dark" value="">Pilih Salah Satu...</option>
                                                <?php foreach ($agenList as $ag) { ?>
                                                    <option class="color-dark-dark" value="<?php echo $ag->id_agen; ?>"><?php echo $ag->nama_agen . " - " . $ag->no_agen; ?></option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option class="color-dark-dark" value="<?php echo $agen[0]->id_agen; ?>"><?php echo $agen[0]->nama_agen . " - " . $agen[0]->no_agen; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="divider mt-4"></div>
                                </div> -->
                        </div>

                        <?php if (isset($parent_id)) : ?>
                        <div class="row">
                            <div class="col-12">
                                <a href="#" onclick="submit();"
                                    class="btn btn-full btn-m bg-highlight rounded-s font-13 font-600 mt-4">Daftarkan</a>
                            </div>
                            <!-- <div class="col-6">
                                <?php if ($agen != null) : ?>
                                <a href="<?php echo base_url() . 'jamaah/daftar/next?idg=' . $agen[0]->id_agen ?>"
                                    class="btn btn-full btn-m bg-green-dark rounded-s font-13 font-600 mt-4">Selesai</a>
                                <?php else : ?>
                                <a href="<?php echo base_url() . 'jamaah/daftar/next' ?>"
                                    class="btn btn-full btn-m bg-green-dark rounded-s font-13 font-600 mt-4">Selesai</a>
                                <?php endif; ?>
                            </div> -->
                        </div>
                        <?php else : ?>
                        <a href="#" onclick="submit();"
                            class="btn btn-full btn-m bg-highlight rounded-s font-13 font-600 mt-4">Berikutnya</a>
                        <?php endif; ?>

                    </div>
                </div>
            </form>

        </div>
        <!-- Page content ends here-->


        <?php $this->load->view('jamaah/include/alert-bottom'); ?>
        <?php $this->load->view('jamaah/include/script_view'); ?>
        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <!-- Modal new datepicker -->
    <div id="datepicker2" class="date-picker menu menu-box-modal rounded-m" data-menu-height="300"
        data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="date_header mb-3">
                <span class="title">Tanggal lahir : </span>
                <div class="fw-bold fs-5" id="tanggalLahir"><span id="tahun">0000</span>-<span
                        id="bulan">00</span>-<span id="tanggal">00</span></div>
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
            <button type="button" id="set"
                class="close-menu btn btn-sm gradient-highlight font-13 btn-sm font-600 rounded-s"
                style="float: right;">Pilih</button>
        </div>
    </div>

    <!-- datepicker modal -->
    <div id="datepicker" class="date-picker menu menu-box-modal rounded-m" data-menu-height="280" data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
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
                            <option value="<?php echo $i ?>"><?php echo $i ?>.</option>
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
                    <button type="button" id="setTanggal"
                        class="close-menu btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s">Pilih</button>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
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

    function submit() {
        Swal.fire({
            title: 'Apa anda sudah yakin?',
            text: 'Kami tidak bertanggung jawab atas ketidakakuratan data yang mungkin terjadi',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#F7C255',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("myForm").submit();
            }
        })
        $(".swal2-confirm").addClass('bg-highlight')
    }

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

    // $(function () {
    //     $("#example").dateDropdowns();
    //     $('input[name="tanggal"]')
    //     .attr("type", "text")
    //     .attr("class", "selection")
    //     .attr("readonly", "readonly");
    // });

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
            if (bulanHariIni < bulanLahir || (bulanHariIni === bulanLahir && tanggalHariIni.getDate() <
                    tanggalLahirObj.getDate())) {
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
            var tanggalPaket = '<?php echo $paket->tanggal_berangkat; ?>'
            var umur = hitungUmur(sourceText, tanggalPaket);
            if (umur >= 2 && umur <= 6) {
                document.getElementById('sharingBed').style.display = "block";
            } else {
                document.getElementById('sharingBed').style.display = "none";
            }
            $("#form7").val(sourceText);
        });

        // set tanggal
        // $("#set").click(function() {
        //     var sourceText = $("#example").val();
        //     $("#form7").val(sourceText);
        // });

        $("#setTanggal").click(function() {
            var sourceText = $(".selection").text();
            $("#form7").val(sourceText);
        });

        $("#form8").autocomplete({
            source: "<?php echo base_url() . 'jamaah/daftar/getTempatLahir'; ?>"
        });
        $('.upper').on('input', function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.upper').focusout(function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.upper').focusin(function() {
            this.value = this.value.toLocaleUpperCase();
        });
    })
    </script>
</body>