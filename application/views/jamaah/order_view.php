<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
        #page {
            min-height: 100vh !important;
        }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['order' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

        <div class="content my-0">
            <h1>Your Orders</h1>
        </div>
        <?php if ($member != null) { ?>
        <div class="card card-style mb-2">
            <div class="content">
                <?php foreach ($member as $m) { ?>
                    <a href="<?php echo base_url() . ($m->lunas == 0 ? 'jamaah/daftar/dp_notice' : 'jamaah/order/paket_aktif') ?>" class="d-flex">
                        <div>
                            <img src="<?php echo base_url() . $m->paket_info->banner_image ?>" class="rounded-sm" width="130">
                        </div>
                        <div class="w-100 ms-3 pt-1">
                            <div class="mb-0">
                                <?php for ($i = 1; $i <= $m->paket_info->star; $i++) { ?>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                <?php } ?>
                                <?php for ($i = 1; $i <= (5 - $m->paket_info->star); $i++) { ?>
                                    <i class="fa-solid fa-star color-gray-dark"></i>
                                <?php } ?>
                            </div>
                            <h3><?php echo $m->paket_info->nama_paket ?></h3>
                            <?php if ($m->paket_info->default_diskon != 0) { ?>
                                <del style="text-decoration:line-through; color: grey;">
                                    <span class="d-block mt-1"><?php echo $m->paket_info->hargaPretty ?></span>
                                </del>
                                <h6 class="color-highlight"><?php echo $m->paket_info->hargaPrettyDiskon ?></h6>
                            <?php } else { ?>
                                <h6 class="color-highlight mt-2"><?php echo $m->paket_info->hargaPretty ?></h6>
                            <?php } ?>
                            <p class="<?php echo $m->lunas == 0 ? 'color-red-dark' : 'color-green-dark' ?> font-11"><?php echo $m->lunas == 0 ? '<i class="fa-regular fa-clock me-1"></i>Menunggu pembayaran' : '<i class="fa-regular fa-circle-check me-1"></i>Active' ?></p>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
        <?php } else { ?>
            <div class="card card-style">
                <div class="content text-center">
                    <h5 class="font-14 mb-3">Belum ada paket yang aktif</h5>
                    <span>Mari awali petualangan Anda dengan memesan paket perjalanan </span><a href="<?php echo base_url() ?>jamaah/trip">disini.</a>
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