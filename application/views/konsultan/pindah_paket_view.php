<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/home-banner.png");
    }

    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-19 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-17 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-18 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-20 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-21 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-29 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-33 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['daftar_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="card card-style">
                <div class="content my-2">
                    <p class="mb-2 font-600 color-highlight">Paket saat ini</p>
                    <div class="row mb-0">
                        <div class="d-flex">
                            <div class="col-3 mb-4 pe-0"><img src="<?php echo ($currentPaket->banner_image) ? base_url() . $currentPaket->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>" class="rounded-sm shadow-xl img-fluid">
                            </div>
                            <div class="col-9 ms-3 pe-2">
                                <a href="#" class="d-block">
                                    <?php for ($i = 0; $i < $currentPaket->star; $i++) { ?>

                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <?php } ?>
                                    <br>
                                </a>
                                <h3 class="mb-0"><?php echo $currentPaket->nama_paket; ?></h3>
                                <?php if ($currentPaket->sisa_seat > 20) { ?>
                                
                                <span class="opacity-100 font-11">Berangkat
                                    <?php echo $this->date->convert("j F Y", $currentPaket->tanggal_berangkat); ?></span>
                                <?php } else {  ?>
                                <!-- <h1 class="mb-n2 font-800">
                                    <?php echo $currentPaket->hargaHome; ?><sup class="font-800 font-16" style="font-weight:bold;">
                                        Jt</sup></h1> -->
                                <span class="opacity-100 font-11">Berangkat
                                    <?php echo $this->date->convert("j F Y", $currentPaket->tanggal_berangkat); ?></span>
                                <?php } ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-style" id="paket">
                <div class="content mb-0">
                    <p class="mb-n1 font-600 color-highlight">Segera bergabung, seat terbatas!</p>
                    <h2 class="mb-4">Pilih Paket
                        <?php echo $monthSelected ? $this->date->convert("F", '01-' . $monthSelected . '-1990') : ""; ?>
                    </h2>
                    <div class="card card-style bg-highlight pt-2 pb-2" data-menu="menu-bulan">
                        <h5 class="color-white text-center">
                            Pilih Bulan
                            <span class="ms-2 icon icon-xxs bg-theme color-black rounded-xl"><i
                                    class="fa fa-arrow-right"></i></span>
                        </h5>
                    </div>
                    <div class="row mb-0">
                        <?php foreach ($paket as $p) { ?>
                        <div class="d-flex" onclick="window.location='<?php echo $p->detail_link; ?>';">
                            <div class="col-6 mb-4 pe-0">
                                <a href="#"><img
                                        src="<?php echo ($p->banner_image) ? base_url() . $p->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                                        class="rounded-sm shadow-xl img-fluid"></a>
                            </div>
                            <div class="col-6 ms-3 pe-2">
                                <a href="#" class="d-block">
                                    <?php for ($i = 0; $i < $p->star; $i++) { ?>

                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <?php } ?>
                                    <br>
                                </a>
                                <a href="#">
                                    <h5 class="mb-0"><?php echo $p->nama_paket; ?></h5>
                                    <?php if ($p->sisa_seat > 20) { ?>
                                    <span class="color-green-dark font-10">Seat Tersedia</span>
                                    <?php } else { ?>
                                    <span class="color-orange-light font-10">Sisa <?php echo $p->sisa_seat; ?> Seat
                                        Lagi!</span>
                                    <?php } ?>
                                </a>
                                <?php if ($p->default_diskon > 0 ) { ?>
                                <del style="color: red;text-decoration:line-through">
                                    <p class="mt-1 mb-n2 font-600">
                                        <?php echo $p->hargaHome; ?> Jt
                                    </p>
                                </del>
                                <h1 class="mb-n2 font-800"><?php echo $p->hargaHomeDiskon; ?><sup
                                        class="font-800 font-16" style="font-weight:bold;"> Jt</sup></h1>
                                <span class="opacity-100 font-11">Berangkat
                                    <?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></span>
                                <?php } else {  ?>
                                <h1 class="mb-n2 font-800">
                                    <?php echo $p->hargaHome; ?><sup class="font-800 font-16" style="font-weight:bold;">
                                        Jt</sup></h1>
                                <span class="opacity-100 font-11">Berangkat
                                    <?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="w-100 divider divider-margins"></div>
                        <?php } ?>


                    </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="https://wa.me/6281210118028" target="_blank">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <span style="font-size: 15px;">Help & Support</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <div id="menu-bulan" class="menu menu-box-bottom rounded-m" data-menu-height="450" data-menu-effect="menu-over">
            <div class="menu-title">
                <p class="color-highlight">Selalu Tersedia</p>
                <h1 class="font-24">Pilih Bulan Keberangkatan</h1>

                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>

            </div>
            <div class="me-4 ms-3 mt-2">
                <div class="list-group list-custom-small">
                    <a href="<?php echo base_url() . 'konsultan/daftar_jamaah#paket'; ?>"><span>Semua
                            Keberangkatan</span><i class="fa fa-angle-right"></i></a>
                    <?php foreach ($availableMonths as $month) { ?>
                    <a
                        href="<?php echo base_url() . 'konsultan/daftar_jamaah?month=' . substr($month->tanggal_berangkat, 5, 2); ?>#paket"><span><?php echo $this->date->convert('F', $month->tanggal_berangkat); ?></span><i
                            class="fa fa-angle-right"></i></a>
                    <?php } ?>
                </div>
                <div class="clear"></div>
            </div>
        </div>


        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-daftar"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>