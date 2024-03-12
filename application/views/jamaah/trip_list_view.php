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
        <div class="card card-style">
            <div class="content">
                <div class="card card-style m-0 mb-3">
                    <div class="content">
                        <div class="d-flex">
                            <i class="fa-solid fa-magnifying-glass me-2 my-auto"></i>
                            <input id="search" type="text" class="border-0" style="width: 100%;" placeholder="Find your dream trips" value="">
                        </div>
                    </div>
                </div>

                <div class="row mb-0 mx-0">
                    <div class="col-6 p-0 mb-2">
                        <div class="card m-2 mb-1 card-style">
                            <img src="<?php echo base_url() ?>asset/images/city/dubai-720x720.jpg" class="img-fluid">
                            <div class="p-2 bg-theme rounded-sm">
                                <div class="mb-n1">
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                </div>
                                <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Dubai</h4>
                                <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                <del style="text-decoration:line-through">
                                    <span class="d-block mt-n1">Rp 9,299,000</span>
                                </del>
                                <h6 class="color-highlight">Rp 8,299,000</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-0 mb-2">
                        <div class="card m-2 mb-1 card-style">
                            <img src="<?php echo base_url() ?>asset/images/city/tokyo-720x720.jpg" class="img-fluid">
                            <div class="p-2 bg-theme rounded-sm">
                                <div class="mb-n1">
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                </div>
                                <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Tokyo</h4>
                                <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                <del style="text-decoration:line-through">
                                    <span class="d-block mt-n1">Rp 7,599,000</span>
                                </del>
                                <h6 class="color-highlight">Rp 6,999,000</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-0 mb-2">
                        <div class="card m-2 mb-1 card-style">
                            <img src="<?php echo base_url() ?>asset/images/city/bali-720x720.jpg" class="img-fluid">
                            <div class="p-2 bg-theme rounded-sm">
                                <div class="mb-n1">
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                </div>
                                <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Bali</h4>
                                <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                <del style="text-decoration:line-through">
                                    <span class="d-block mt-n1">Rp 5,999,000</span>
                                </del>
                                <h6 class="color-highlight">Rp 4,999,000</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-0 mb-2">
                        <div class="card m-2 mb-1 card-style">
                            <img src="<?php echo base_url() ?>asset/images/city/seoul-720x720.jpg" class="img-fluid">
                            <div class="p-2 bg-theme rounded-sm">
                                <div class="mb-n1">
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                </div>
                                <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Seoul</h4>
                                <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                <del style="text-decoration:line-through">
                                    <span class="d-block mt-n1">Rp 7,999,000</span>
                                </del>
                                <h6 class="color-highlight">Rp 6,999,000</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-0 mb-2">
                        <div class="card m-2 mb-1 card-style">
                            <img src="<?php echo base_url() ?>asset/images/city/london-720x720.jpg" class="img-fluid">
                            <div class="p-2 bg-theme rounded-sm">
                                <div class="mb-n1">
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                </div>
                                <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">London</h4>
                                <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                <del style="text-decoration:line-through">
                                    <span class="d-block mt-n1">Rp 7,499,000</span>
                                </del>
                                <h6 class="color-highlight">Rp 6,499,000</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-0 mb-2">
                        <div class="card m-2 mb-1 card-style">
                            <img src="<?php echo base_url() ?>asset/images/city/istanbul-720x720.jpg" class="img-fluid">
                            <div class="p-2 bg-theme rounded-sm">
                                <div class="mb-n1">
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                </div>
                                <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Istanbul</h4>
                                <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                <del style="text-decoration:line-through">
                                    <span class="d-block mt-n1">Rp 7,499,000</span>
                                </del>
                                <h6 class="color-highlight">Rp 6,499,000</h6>
                            </div>
                        </div>
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