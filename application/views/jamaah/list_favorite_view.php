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
        <?php $this->load->view('jamaah/include/footer_menu', ['favorite' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

        <div class="content mt-0">
            <h2>Your Favorite Destinations</h2>
        </div>

        <div class="card card-style mb-3">
            <div class="content">
                <div class="d-flex">
                    <div>
                        <img src="<?php echo base_url() ?>asset/images/city/dubai-720x720.jpg" class="rounded-sm" width="150">
                    </div>
                    <div class="w-100 ms-3 pt-1">
                        <div class="mb-0">
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                        </div>
                        <h3>Dubai</h3>
						<p class="mb-0 font-11 mb-2 mt-n1 line-height-s">7 Nights - All inclusive</p>
                        <del style="text-decoration:line-through">
                            <span class="d-block mt-n1">Rp 9,299,000</span>
                        </del>
                        <h5 class="color-highlight">Rp 8,299,000</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-style mb-3">
            <div class="content">
                <div class="d-flex">
                    <div>
                        <img src="<?php echo base_url() ?>asset/images/city/istanbul-720x720.jpg" class="rounded-sm" width="150">
                    </div>
                    <div class="w-100 ms-3 pt-1">
                        <div class="mb-0">
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                        </div>
                        <h3>Istanbul</h3>
						<p class="mb-0 font-11 mb-2 mt-n1 line-height-s">7 Nights - All inclusive</p>
                        <del style="text-decoration:line-through">
                            <span class="d-block mt-n1">Rp 7,499,000</span>
                        </del>
                        <h5 class="color-highlight">Rp 6,499,000</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-style mb-3">
            <div class="content">
                <div class="d-flex">
                    <div>
                        <img src="<?php echo base_url() ?>asset/images/city/tokyo-720x720.jpg" class="rounded-sm" width="150">
                    </div>
                    <div class="w-100 ms-3 pt-1">
                        <div class="mb-0">
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                            <i class="fa-solid fa-star color-yellow-dark"></i>
                        </div>
                        <h3>Tokyo</h3>
						<p class="mb-0 font-11 mb-2 mt-n1 line-height-s">7 Nights - All inclusive</p>
                        <del style="text-decoration:line-through">
                            <span class="d-block mt-n1">Rp 7,599,000</span>
                        </del>
                        <h5 class="color-highlight">Rp 6,599,000</h5>
                    </div>
                </div>
            </div>
        </div>



            <!-- <?php $this->load->view('jamaah/include/footer'); ?> -->
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