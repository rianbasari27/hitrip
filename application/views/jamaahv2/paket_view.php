<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-20 {
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
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['paket_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>

        <div class="card card-fixed mb-n5" data-card-height="420">
            <div class="card rounded-0 bg-20" data-card-height="450"
                style="background-image:url('<?php echo ($banner_image) ? base_url() . $banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>');">
                <div class="card-bottom px-3 pb-2">
                    <h1 class="color-white font-28 mb-0">
                        <?php echo $nama_paket; ?>
                    </h1>
                    <p class="color-white font-12 opacity-80">
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

        <!-- Page content starts here-->
        <div class="card card-clear" data-card-height="400"></div>
        <div class="page-content pb-3">

            <div class="card card-full rounded-m pb-4 mb-3">
                <div class="drag-line"></div>

                <div class="content pb-5">


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
                    <?php if ($itinerary != null) { ?>
                    <a class="btn mb-4 btn-danger btn-l rounded-sm text-uppercase border-0"
                        href="<?php echo base_url() . $itinerary; ?>" download>
                        <i class="fas fa-file-download"></i>
                        <span class="text">Download Itinerary</span>
                    </a>
                    <?php } ?>
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
                </div>
            </div>
            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-paket"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>