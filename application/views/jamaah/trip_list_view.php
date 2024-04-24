<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['trip' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

            <div class="content my-0">
                <h1>Trips</h1>
            </div>
            <div class="content">
                <!-- Search Section -->
                <div class="mt-0 mb-4">
                    <div class="search-box search-dark bg-theme rounded-sm bottom-0">
                        <i class="fa fa-search ms-1"></i>
                        <input type="text" class="border-0" placeholder="Searching for something? Try 'dubai'" data-search>
                    </div>
                    <div class="search-results disabled-search-list">
                        <div>
                            <?php if ($paket != null) { ?>
                                <?php foreach ($paket as $pkt) { ?>
                                    <a href="#" class="card card-style my-3" aria-label="<?php echo $pkt->nama_paket ?>" data-filter-item data-filter-name="<?php echo strtolower($pkt->nama_paket . ' ' . $pkt->area_trip) ?>">
                                        <div class="d-flex content">
                                            <div class="align-self-center">
                                                <img src="<?php echo base_url() . ($pkt->banner_image != null ? $pkt->banner_image : 'asset/appkit/images/default-banner-image.jpg') ?>" alt=""
                                                    class="rounded-s me-3" width="80">
                                            </div>
                                            <div class="align-self-center">
                                                <h2 class="font-16 font-700 mb-1 line-height-s mt-1"><?php echo $pkt->nama_paket ?></h2>
                                                <?php if ($pkt->default_diskon != 0) { ?>
                                                    <del style="text-decoration:line-through; color: grey;">
                                                        <span class="d-block mt-1"><?php echo $pkt->hargaPretty ?></span>
                                                    </del>
                                                    <h6 class="font-14 color-highlight"><?php echo $pkt->hargaPrettyDiskon ?></h6>
                                                <?php } else { ?>
                                                    <h6 class="font-14 color-highlight mt-2"><?php echo $pkt->hargaPretty ?></h6>
                                                <?php } ?>
                                            </div>
                                            <div class="ms-auto ps-3 align-self-center text-center">
                                            </div>
                                        </div>
                                    </a>
                                <?php } ?>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="search-no-results disabled mt-4">
                    <div class="card card-style">
                        <div class="content">
                            <h1>Oops!</h1>
                            <p>
                                Paket yang Anda cari tidak ditemukan. Coba untuk menggunakan keyword lain.
                            </p>
                        </div>
                    </div>
                </div>
            <!-- End Search Section -->

                <?php if (!empty($paket)) { ?>
                <div class="row mb-0 mx-0">
                    <?php foreach ($paket as $p) { ?>
                    <a href="<?php echo base_url() . 'jamaah/detail_paket?id=' . $p->id_paket ?>" class="col-6 p-0 mb-2">
                        <div class="card m-2 mb-1 card-style">
                            <img src="<?php echo $p->banner_image != null ? base_url() . $p->banner_image : base_url() . 'asset/appkit/images/default-banner-image.jpg' ?>" class="img-fluid">
                            <div class="p-2 bg-theme rounded-sm">
                                <div class="mb-n1">
                                    <?php for ($i = 1; $i <= $p->star; $i++) { ?>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <?php } ?>
                                    <?php for ($i = 1; $i <= (5 - $p->star); $i++) { ?>
                                        <i class="fa-solid fa-star color-gray-dark"></i>
                                    <?php } ?>
                                </div>
                                <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1"><?php echo $p->nama_paket ?></h4>
                                <!-- <span class="font-10 mb-0">7 Nights - All Inclusive</span> -->
                                <?php if ($p->default_diskon != 0) { ?>
                                    <del style="text-decoration:line-through; color: grey;">
                                        <span class="d-block mt-1"><?php echo $p->hargaPretty ?></span>
                                    </del>
                                    <h6 class="color-highlight"><?php echo $p->hargaPrettyDiskon ?></h6>
                                <?php } else { ?>
                                    <h6 class="color-highlight mt-2"><?php echo $p->hargaPretty ?></h6>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
                <?php } else { ?>
                    <div class="card card-style">
                        <div class="content text-center">
                            <h5 class="font-14">Paket belum tersedia.</h5>
                        </div>
                    </div>
                <?php } ?>
            </div>


            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
        </div>
        <!-- Page content ends here-->


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


    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
</body>