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

    .inline {
        display: inline-block;
    }

    .form-control-sm {
        border-radius: 7px;
        width: 70vw !important;
    }

    .page-link {
        border-radius: 10px;
        border: none;
        color: black;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
        background-color: transparent;
        /* font-size: 12px; */

    }

    .active .page-link {
        color: white;
        background-color: #edbd5a !important;
    }

    /* div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        justify-content: center !important;
    } */


    .hover {
        background-color: #f0f0f0 !important;
    }

    .custom-row-style {
        overflow: hidden;
        border-radius: 20px !important;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
        /* background-color: white; */
        display: table-row;
        width: 100%;
        margin-bottom: 15px;
        padding: 0px 20px 0px 20px;
    }

    .table-content {
        margin: 20px 0;
    }

    .dataTable {
        /* border-collapse: separate; */
        /* width: 100% !important; */
        border-spacing: 0 1em !important;
    }

    .table > :not(caption) > * > * {
        padding: 0.7rem 1rem 0rem !important;
    }

    .text-xxs {
        font-size: 12px;
    }

    .text-xxxs {
        font-size: 10px;
    }

    @media screen and (min-width: 300px) {
        .jam {
            font-size: clamp(20px, 9vw, 40px);
        }
    }

    @media screen and (max-width: 300px) {
        .total {
            font-size: 3rem;
        }
        .subtotal {
            font-size: 2rem !important;
        }
    }
    </style>
    <link href="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="card card-fixed mb-n5" data-card-height="420">
            <div class="card rounded-0 bg-20" data-card-height="450"
                style="background-image:url('<?php echo ($banner_image) ? base_url() . $banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>');">
                <div class="card-bottom px-3 pb-2 mb-4">
                    <h1 class="color-white font-28 mb-0">
                        <?php echo $nama_paket; ?>
                    </h1>
                    <p class="color-white font-12 opacity-80 mb-1">
                        Ventour memperhatikan detil kebutuhan calon jamaah umroh dan peserta tur wisatanya. Kami siap
                        sedia membantu Anda.
                    </p>
                </div>
                <div class="card-top mt-3 pb-5 ps-3">
                    <a href="#" data-back-button class="icon icon-s bg-theme rounded-xl float-start me-3"><i
                            class="fa color-theme fa-arrow-left"></i></a>
                    <a href="#" data-menu="menu-main" class="icon icon-s bg-theme rounded-xl float-end me-3"><i
                            class="fa color-theme fa-bars"></i></a>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>
        </div>
        <div class="card card-clear" data-card-height="400"></div>
        <div class="page-content">

        <div class="card card-full rounded-m pb-4 mb-3">
                <div class="drag-line"></div>

                <div class="content pb-5">
                    <div class="card card-style mx-0 mt-3" data-card-height="100"
                        style="background-image:url('<?php echo ($banner_image) ? base_url() . $banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>');">
                        <div class="card-center px-3 no-click">
                            <h1 class="color-white mb-n2 font-24">Daftar Sekarang</h1>
                            <h5 class="color-white mt-n1 opacity-80 font-14">Harga mulai
                                <!-- <?php echo 'Rp. ' . substr($harga_display, 0, 2); ?> jutaan</h5> -->
                                <?php echo $hargaPrettyDiskon; ?>
                        </div>
                        <div class="card-center">
                            <a href="<?php echo base_url() . "konsultan/daftar_jamaah/daftar?id=" . $id_paket; ?>"
                                class="float-end mx-3 gradient-highlight btn-s rounded-sm shadow-xl text-uppercase font-800">Daftar</a>
                        </div>
                        <div class="card-overlay bg-black opacity-60"></div>
                    </div>

                    <div class="divider"></div>



                    <p class="color-highlight font-600 mb-n1">Terpercaya, Terbukti, Recommended</p>
                    <h1 class="mb-2"><?php echo $nama_paket; ?></h1>

                    <div class="card card-style card-full-left"
                        style="background-image:url(<?php echo base_url() . 'asset/appkit/images/ventour/trip-schedule.jpg'; ?>)"
                        data-card-height="170">
                        <div class="card rounded-0 shadow-xl" data-card-height="cover" style="width:100px; z-index:99;">
                            <div class="card-center text-center">
                                <?php if ($lamaHari) { ?>
                                <h1 class="font-28 text-uppercase font-900 opacity-30"><?php echo $lamaHari; ?></h1>
                                <h1 class="font-24 font-900">Hari</h1>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-top ps-5 ms-5 pt-3">
                            <div class="ps-4">
                                <h1 class="color-white pt-3 pb-3">Trip Schedule </h1>
                                <p class="color-white mb-0"><i
                                        class="fa fa-plane-departure color-white pe-2 icon-30"></i>
                                    <?php echo date_format(date_create($tanggal_berangkat), 'l, j F Y'); ?></p>
                                <p class="color-white mb-2"><i class="fa fa-plane-arrival color-white pe-2 icon-30"></i>
                                    <?php echo date_format(date_create($tanggal_pulang), 'l, j F Y'); ?></p>
                            </div>
                        </div>
                        <div class="card-overlay bg-black opacity-70"></div>
                    </div>
                    <div class="row mb-0">
                        <?php if ($itinerary != null) { ?>
                        <div class="col-4 pe-1">
                            <a href="<?php echo base_url() . $itinerary; ?>" download class="btn btn-m btn-full mb-3 rounded-sm text-uppercase font-700 shadow-s bg-orange-light"><i class="fas fa-file-download"></i><br> Itinerary</a>
                        </div>
                        <?php } ?>
                        <?php if ( $paket_flyer != null ) { ?>
                        <div class="col-4 pe-1 ps-1">
                            <a href="<?php echo base_url() . $paket_flyer?>" download class="btn btn-m btn-full mb-3 rounded-sm text-uppercase font-700 shadow-s bg-green-light"><i class="fa-solid fa-file-image"></i><br> Flyer</a>
                        </div>
                        <?php } ?>
                        <div class="col-4 ps-1">
                            <a href="#" data-menu="menu-share" class="btn btn-m btn-full mb-3 rounded-sm text-uppercase font-700 shadow-s bg-teal-light" data-bs-toggle="card" data-bs-target="fixed"><i class="fas fa-share-alt"></i><br> Share</a>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <?php if ($detail_promo != null) { ?>
                    <h1 class="color-highlight font-600 mb-n1 mt-n2">Detail Promo</h1>
                    <div class="detail-article mb-3">
                        <?php echo $detail_promo; ?>
                    </div>
                    <?php } ?>

                    <?php if ($flight_schedule != null) { ?>
                    <h1 class="color-highlight font-600 mb-n1">Flight Schedule</h1>
                    <div class="detail-article mb-3">
                        <?php echo $flight_schedule; ?>
                    </div>
                    <?php } ?>
                    <div class="divider"></div>


                    <a href="<?php echo base_url() . "konsultan/daftar_jamaah/daftar?id=" . $id_paket; ?>"
                        class="btn mb-4 mt-3 gradient-highlight btn-l rounded-sm btn-full font-700 text-uppercase border-0">Daftar
                        Sekarang</a>
                    <span
                        class="opacity-50 font-10 d-block text-center mt-n3 mb-4"><?php echo "Harga Mulai " . $hargaPrettyDiskon?></span>
                    <div class="divider"></div>

                    <p class="color-highlight font-600 mb-n1">Prioritas Kenyamanan</p>
                    <h1>Hotel</h1>
                    <p>
                        Dengan mengutamakan kenyamanan istirahat Anda, jalannya ibadah pun insya Allah akan menjadi
                        maksimal.
                    </p>
                    <div class="row mb-3">
                        <div class="col-12">
                            <?php foreach ($hotel as $htl) { ?>
                            <a class="card mx-0 mb-2 card-style default-link" data-card-height="130"
                                <?php echo ($htl->foto) ? "data-gallery='gallery-b'" : ""; ?>
                                title="<?php echo $htl->nama_hotel ?>"
                                href="<?php echo ($htl->foto) ? base_url() . $htl->foto : '#'; ?>"
                                style="background-image:url(<?php echo base_url() . $htl->foto; ?>)">
                                <div class="card-bottom mb-1">
                                    <span class="color-white text-center ms-3"><?php echo $htl->nama_hotel; ?></span>
                                </div>
                                <div class="card-bottom text-end mb-1">
                                    <div class="mt-3 me-3 color-white">
                                        <i class="fa fa-map-location-dot font-25"
                                            onclick="openMaps('<?php echo urlencode($htl->nama_hotel); ?>')"></i>
                                    </div>
                                </div>
                                <div class="card-overlay bg-gradient"></div>
                            </a>
                            <?php } ?>
                        </div>

                    </div>
                    <a href="<?php echo base_url() . "konsultan/daftar_jamaah/daftar?id=" . $id_paket; ?>"
                        class="btn mb-4 gradient-highlight btn-l rounded-sm btn-full font-700 text-uppercase border-0">Daftar
                        Sekarang</a>
                    <span
                        class="opacity-50 font-10 d-block text-center mt-n3 mb-4"><?php echo "Harga Mulai " . $hargaPrettyDiskon;?></span>
                </div>
            </div>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370">
        </div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480">
        </div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <!-- <script src="https://cdn.datatables.net/plug-ins/1.13.2/pagination/ellipses.js"></script> -->
    <?php $this->load->view('konsultan/include/script_view'); ?>
    <script>
    function openMaps(loc) {
        event.preventDefault();
        window.location.href = 'https://maps.google.com/?q=' + loc;
        event.stopPropagation();
    }
    </script>
</body>