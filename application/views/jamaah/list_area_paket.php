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
        <?php $this->load->view('jamaah/include/footer_menu', ['discover' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

            <div class="content mt-0">
                <h1>Trip</h1>
            </div>
            <?php if ($paket != null) { ?>
                <?php foreach ($paket as $p) { ?>
                    <a href="<?php echo base_url() . 'jamaah/detail_paket?id=' . $p->id_paket ?>" class="card card-style my-3" aria-label="<?php echo $p->nama_paket ?>"
                            data-filter-item
                            data-filter-name="<?php echo strtolower($p->nama_paket . ' ' . $p->negara) ?>">
                            <div class="d-flex content m-3">
                                <div class="align-self-center">
                                    <img src="<?php echo base_url() . ($p->banner_image != null ? $p->banner_image : 'asset/appkit/images/default-banner-image.jpg') ?>"
                                        alt="" class="rounded-s me-3" width="120">
                                </div>
                                <div class="align-self-center">
                                    <div class="mb-n1">
                                        <?php for ($i = 1; $i <= $p->star; $i++) { ?>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <?php } ?>
                                        <?php for ($i = 1; $i <= (5 - $p->star); $i++) { ?>
                                        <i class="fa-solid fa-star color-gray-dark"></i>
                                        <?php } ?>
                                    </div>
                                    <h2 class="font-16 font-700 mb-1 line-height-s mt-1 mb-n1"><?php echo $p->nama_paket ?>
                                    </h2>
                                    <span class="font-12 opacity-60 color-dark-dark"><?php echo $p->nama_paket . ', ' . $p->negara ?></span>
                                    <?php if ($p->default_diskon != 0) { ?>
                                    <del style="text-decoration:line-through; color: grey;">
                                        <span class="d-block mt-1"><?php echo $p->hargaPretty ?></span>
                                    </del>
                                    <h6 class="font-14 color-highlight"><?php echo $p->hargaPrettyDiskon ?></h6>
                                    <?php } else { ?>
                                    <h6 class="font-14 color-highlight mt-2"><?php echo $p->hargaPretty ?></h6>
                                    <?php } ?>
                                </div>
                                <div class="ms-auto ps-3 align-self-center text-center">
                                </div>
                            </div>
                        </a>
                <?php } ?>
            <?php } else { ?>
                <div class="card card-style">
                    <div class="content">
                        <h1>Oops!</h1>
                        <p>
                            Tidak dapat menampilkan area trip. Paket belum tersedia.
                        </p>
                    </div>
                </div>
            <?php } ?>

            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
            <?php $this->load->view('jamaah/include/toast'); ?>
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