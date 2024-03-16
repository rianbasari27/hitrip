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
        <?php $this->load->view('jamaah/include/footer_menu', ['profile' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

        <div class="content">
            <div class="d-flex">
                <div class="p-1 border border-4 border-blue-dark d-inline-block rounded-pill">
                    <img src="<?php echo base_url() . 'asset/appkit/images/pictures/default/default-profile.jpg' ?>"
                    class="rounded-xl" width="60">
                </div>
                <div class="my-auto ms-3">
                    <h2 class="mb-n1">John Doe</h2>
                    <span class="d-block">johndoe007</span>
                    <!-- <a href="#" class="btn btn-xs gradient-highlight p-0">Edit profile</a> -->
                </div>
            </div>
        </div>

        <div class="card card-style mb-3">
            <div class="content">
                <div class="row mb-0">
                    <div class="col-6 border-end text-center">
                        <span class="color-blue-dark">Your Points</span>
                        <h1>12</h1>
                    </div>
                    <div class="col-6 text-center">
                        <span class="color-blue-dark">Your Vouchers</span>
                        <h1>3</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-style mb-3">
            <div class="content">
                <div class="list-group list-custom-small list-icon-0">
                    <a href=""><i class="fa fa-envelope rounded-sm bg-blue-dark color-white"></i><span>johndoe007@gmail.com</span></a>
                    <a href=""><i class="fa fa-cake-candles font-14 rounded-sm bg-blue-dark color-white"></i><span>18 Jan 1990</span></a>
                    <a href=""><i class="fa fa-mobile font-14 rounded-sm bg-blue-dark color-white"></i><span>+62 812-1299-0992</span></a>
                    <a href=""><i class="fa fa-location-dot font-14 rounded-sm bg-blue-dark color-white"></i><span>Jakarta, Indonesia</span></a>
                </div>
            </div>
        </div>
        <div class="card card-style mb-3">
            <div class="content">
                <div class="list-group list-custom-small list-icon-0">
                <a href="#"><i class="fa fa-headset font-14 rounded-sm bg-blue-dark color-white"></i><span>Help & Support</span><i class="fa fa-angle-right"></i></a>
                    <a href="#"><i class="fa fa-thumbs-up font-12 rounded-sm bg-blue-dark color-white"></i><span>Rate Our Apps</span><i class="fa fa-angle-right"></i></a>
                    <a href="#"><i class="fa fa-circle-question font-12 rounded-sm bg-blue-dark color-white"></i><span>FAQ</span><i class="fa fa-angle-right"></i></a>
                    <a href="<?php echo base_url() ?>jamaah/logout" class="color-red-dark"><i class="fa fa-right-from-bracket font-12 rounded-sm bg-red-dark color-white"></i><span>Sign Out</span><i class="fa fa-angle-right"></i></a>
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