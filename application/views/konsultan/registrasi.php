<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
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
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
        }

        .capital {
            text-transform: uppercase;
        }

        /* CSS for datepicker */
        .date-picker {
            background-color: white !important;
        }

        .example {
            width: 0% !important;
            min-width: 0px !important;
        }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['daftar_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style bg-home" data-card-height="300">
                <div class="card-bottom ms-3 me-3">
                    <h1 class="font-40 line-height-xl color-white"><?php echo $paket->nama_paket; ?></h1>
                    <p class="color-white opacity-60"><i class="fa fa-plane-departure me-2"></i><?php echo date_format(date_create($paket->tanggal_berangkat), 'l, j F Y'); ?>
                    </p>
                    <p class="color-white opacity-80 font-15">
                        Daftarkan Jamaah Anda, cukup 1 menit sebagai langkah awal menuju Baitullah.
                    </p>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <form action="<?php echo base_url(); ?>konsultan/daftar_jamaah/proses" method="post" id="myForm">
                <div class="card card-style">
                    <div class="content">
                        <p class="mb-n1 color-highlight font-600 font-12">Formulir Pendaftaran</p>
                        <h4><?php echo $paket->nama_paket; ?></h4>
                        <p>
                            Lengkapi formulir dibawah ini. Pastikan data Jamaah diinput dengan benar.
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
                        <div class="mt-1 mb-3">
                            <div class="mb-3">
                                <p class="mb-n1 font-600 color-green-dark">Tipe Kamar</p>
                                <h1>Pilih Tipe Kamar</h1>
                                <p class="opacity-60">
                                    Harga yang dikenakan sesuai dengan jenis kamar yang dipilih.
                                </p>
                                <?php $n = 0;
                                foreach ($paket->availableKamar as $availableKamar) {
                                    $n++; ?>
                                    <div class="form-check icon-check">
                                        <input class="form-check-input" type="radio" name="pilihan_kamar" value="<?php echo $availableKamar; ?>" id="radio<?php echo $n; ?>" <?php echo $n == 1 && !isset($_SESSION['form']['pilihan_kamar']) ? 'checked' : ''; ?> <?php if (isset($_SESSION['form']['pilihan_kamar'])) {
                                                                                                                                                                                                                                                                        if ($_SESSION['form']['pilihan_kamar'] == $availableKamar) {
                                                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                    ?>>
                                        <label class="form-check-label font-600" for="radio<?php echo $n; ?>" style="font-size: 16px;">
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
                            <?php if (isset($_SESSION['id_agen'])) { ?>
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mt-4 mb-4">
                                    <input name="referensi" type="tel" class="form-control validate-name upper" id="form9" value="Konsultan" readonly>
                                    <label for="form9" class="color-highlight">Referensi <strong class="text-danger">
                                            *</strong></label>
                                    <i class="fa fa-check <?php isset($_SESSION['id_agen']) ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                    <em></em>
                                </div>
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <input name="agen" type="tel" class="form-control validate-name upper" id="form10" value="<?php echo $agen->nama_agen . " - " . $agen->no_agen; ?>" readonly>
                                    <label for="form10" class="color-highlight">Nama Konsultan</label>
                                    <i class="fa fa-check <?php isset($_SESSION['id_agen']) ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                    <em></em>
                                </div>

                            <?php } ?>
                        </div>
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
                                        <h2 class="font-15 line-height-s mt-1 mb-1"><?php echo implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name])) ?></h2>
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
                                                <h2 class="font-15 line-height-s mt-1 mb-1"><?php echo implode(' ', array_filter([$pm->jamaahData->first_name, $pm->jamaahData->second_name, $pm->jamaahData->last_name])) ?></h2>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- isi data jamaah -->
                <div class="card card-style">
                    <div class="content">
                        <h4 class="mb-3">Isi data Jamaah</h4>
                        <div class="mt-1 mb-3">
                            <?php //f (isset($parent_id)) : 
                            ?>
                            <label class="text-danger mb-2">Notes : Jika ada tanda ( * ) diwajibkan</label>
                            <!-- <h5 class="color-highlight mb-2">Jamaah</h5> -->
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mt-4 mb-4">
                                <input name="first_name" type="name" class="form-control validate-name upper" id="form1" placeholder="" value="<?php echo isset($_SESSION['form']['first_name']) ? $_SESSION['form']['first_name'] : ''; ?>">
                                <label for="form1" class="color-highlight">Nama Depan <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="last_name" type="name" class="form-control validate-name upper" id="form3" placeholder="" value="<?php echo isset($_SESSION['form']['last_name']) ? $_SESSION['form']['last_name'] : ''; ?>">
                                <label for="form3" class="color-highlight">Nama Belakang</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="ktp_no" type="text" class="form-control validate-name upper" id="form4" placeholder="" value="<?php echo isset($_SESSION['form']['ktp_no']) ? $_SESSION['form']['ktp_no'] : ''; ?>">
                                <label for="form4" class="color-highlight">Nomor KTP <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <a href="#" data-menu="datepicker2" class="text-dark">
                                    <input name="tanggal_lahir" type="date" class="form-control validate-name upper" id="form7" readonly value="<?php echo isset($_SESSION['form']['tanggal_lahir']) ? $_SESSION['form']['tanggal_lahir'] : ''; ?>">
                                    <label for="form7" class="color-highlight">Tanggal Lahir <strong class="text-danger">*</strong></label>
                                </a>
                            </div>
                            <div class="form-group mb-4 ms-2" id="sharingBed" style="display: none;">
                                <label class="color-highlight" for="form10">Sharing Bed</label>
                                <div class="form-check icon-check">
                                    <input class="form-check-input" type="radio" name="sharing_bed" value="1" id="radio4">
                                    <label class="form-check-label font-600" for="radio4" style="font-size: 16px;">Iya
                                    </label>
                                    </label>
                                    <i class="icon-check-1 far fa-circle color-gray-dark font-16"></i>
                                    <i class="icon-check-2 far fa-check-circle font-16 color-highlight"></i>
                                </div>
                                <div class="form-check icon-check">
                                    <input class="form-check-input" type="radio" name="sharing_bed" value="0" id="radio5" checked>
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
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="L">LAKI-LAKI</option>
                                    <option value="P">PEREMPUAN</option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>

                            <!-- <a href="#" id="add_jamaah" class="btn btn-border btn-xs btn-full mb-3 rounded-xl text-uppercase font-700 border-highlight color-highlight bg-theme mt-4"><i class="fa-solid fa-user-plus"></i> Tambah Jamaah</a> -->

                            <!-- <?php //else : 
                                    ?>
                            <label class="text-danger mb-4">Notes : Jika ada tanda ( * ) diwajibkan</label>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mt-4 mb-4">
                                <input name="first_name" type="name" class="form-control validate-name upper" id="form1"
                                    placeholder=""
                                    value="<?php echo isset($_SESSION['form']['first_name']) ? $_SESSION['form']['first_name'] : ''; ?>">
                                <label for="form1" class="color-highlight">Nama Depan <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="second_name" type="name" class="form-control validate-name upper" id="form2"
                                    placeholder=""
                                    value="<?php echo isset($_SESSION['form']['second_name']) ? $_SESSION['form']['second_name'] : ''; ?>">
                                <label for="form2" class="color-highlight">Nama Tengah</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="last_name" type="name" class="form-control validate-name upper" id="form3"
                                    placeholder=""
                                    value="<?php echo isset($_SESSION['form']['last_name']) ? $_SESSION['form']['last_name'] : ''; ?>">
                                <label for="form3" class="color-highlight">Nama Belakang</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="ktp_no" type="number" class="form-control validate-name upper" id="form4"
                                    placeholder=""
                                    value="<?php echo isset($_SESSION['form']['ktp_no']) ? $_SESSION['form']['ktp_no'] : ''; ?>">
                                <label for="form4" class="color-highlight">Nomor KTP <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="no_wa" type="tel" class="form-control validate-name upper" id="form6"
                                    placeholder="contoh +6281631631"
                                    value="+62" required>
                                <label for="form6" class="color-highlight">Nomor Telepon (Aktif WhatsApp) <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <a href="#" data-menu="datepicker" class="text-dark">
                                    <input name="tanggal_lahir" type="date" class="form-control validate-name upper" id="form7" readonly value="<?php echo isset($_SESSION['form']['tanggal_lahir']) ? $_SESSION['form']['tanggal_lahir'] : ''; ?>">
                                    <label for="form7" class="color-highlight">Tanggal Lahir <strong class="text-danger">*</strong></label>
                                </a>
                            </div> 
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="tempat_lahir" type="text" class="form-control validate-name upper" id="form8"
                                    value="<?php echo isset($_SESSION['form']['tempat_lahir']) ? $_SESSION['form']['tempat_lahir'] : ''; ?>">
                                <label for="form8" class="color-highlight">Tempat Lahir <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders input-style-always-active validate-field mb-4">
                                <label for="select" class="color-highlight">Jenis Kelamin <strong class="text-danger">
                                        *</strong></label>
                                <select name="jenis_kelamin" id="form-9">
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="L">LAKI-LAKI</option>
                                    <option value="P">PEREMPUAN</option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div> 
                            <?php //endif; 
                            ?> -->
                        </div>
                        <?php if (isset($parent_id)) : ?>
                            <div class="row">
                                <div class="col-12">
                                    <a href="#" onclick="submit();" class="btn btn-full btn-m bg-highlight rounded-s font-13 font-600 mt-4">Daftarkan</a>
                                </div>
                                <!-- <div class="col-6">
                                    <a href="#" onclick="submitNext('<?php echo base_url() . 'konsultan/daftar_jamaah/next?ktp=' . $ktp_no ?>')" class="btn btn-full btn-m bg-green-dark rounded-s font-13 font-600 mt-4">Selesai</a>
                                </div> -->
                            </div>
                        <?php else : ?>
                            <a href="#" onclick="submit();" class="btn btn-full btn-m bg-highlight rounded-s font-13 font-600 mt-4">Berikutnya</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

        </div>
        <!-- Page content ends here-->


        <?php $this->load->view('konsultan/include/alert-bottom'); ?>
        <?php $this->load->view('konsultan/include/script_view'); ?>
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
    <div id="datepicker" class="date-picker menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
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

            <form name="date">
                <div class="d-block w-full">
                    <div class="lines mb-2"></div>
                    <div class="mb-3">
                        <div class="mb-3" style="width:100%;">
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
                    </div>
                </div>
                <div class="content">
                    <button type="button" id="setTanggal" class="close-menu btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s mt-3">Pilih</button>
                </div>
            </form>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
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
                source: "<?php echo base_url() . 'konsultan/daftar_jamaah/getTempatLahir'; ?>"
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

        function submit() {
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
                        document.getElementById("myForm").submit();
                    }
                })
                $(".swal2-confirm").addClass('bg-highlight')
        }

        function submitNext(url) {
            var form = document.getElementById("myForm");
            form.action = url; // Set action attribute of the form to the provided URL
            form.submit(); // Submit the form
            // If you want to redirect after submission, you can use the following line instead
            // window.location.href = url;
        }

        // function showOnChange(e) {
        //     var elem = document.getElementById("slct");
        //     var value = elem.options[elem.selectedIndex].value;
        //     if (value == "Agen") {
        //         document.getElementById('Agen').style.display = "block";
        //     } else {
        //         document.getElementById('Agen').style.display = "none";
        //     }
        // }
    </script>
</body>