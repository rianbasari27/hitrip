<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
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

        <div class="page-content">

            <div class="content mt-0 mb-2">

                <div class="mt-1">
                    <p class="color-highlight font-600 mb-n1">Pilih metode pembayaran</p>
                    <h1>Pembayaran</h1>
                </div>
            </div>    

            <div class="card card-style mb-3">
                <div class="content">
                    <h5>Virtual Account</h5>
                    <div class="row mb-n2">
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=bca">
                                <img src="<?php echo base_url(); ?>asset/images/icons/bank-bca.jpg" alt="BCA" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=mandiri">
                                <img src="<?php echo base_url(); ?>asset/images/icons/bank-mandiri.jpg" alt="Mandiri" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=bri">
                                <img src="<?php echo base_url(); ?>asset/images/icons/bank-bri.jpg" alt="bri" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=bni">
                                <img src="<?php echo base_url(); ?>asset/images/icons/bank-bni.jpg" alt="bni" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=permata">
                                <img src="<?php echo base_url(); ?>asset/images/icons/bank-permata.jpg" alt="permata" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=cimb">
                                <img src="<?php echo base_url(); ?>asset/images/icons/bank-cimb.jpg" alt="cimb" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-style mb-3">
                <div class="content">
                    <h5>E-wallet</h5>
                    <div class="row mb-n2">
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=gopay">
                                <img src="<?php echo base_url(); ?>asset/images/icons/gopay.jpg" alt="gopay" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=dana">
                                <img src="<?php echo base_url(); ?>asset/images/icons/dana.jpg" alt="dana" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=ovo">
                                <img src="<?php echo base_url(); ?>asset/images/icons/ovo.jpg" alt="ovo" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=spay">
                                <img src="<?php echo base_url(); ?>asset/images/icons/shopee-pay.jpg" alt="spay" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=linkaja">
                                <img src="<?php echo base_url(); ?>asset/images/icons/linkaja.jpg" alt="linkaja" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-style mb-3">
                <div class="content">
                    <h5>Retail</h5>
                    <div class="row mb-n2">
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=alfamart">
                                <img src="<?php echo base_url(); ?>asset/images/icons/alfamart.jpg" alt="alfamart" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=alfamidi">
                                <img src="<?php echo base_url(); ?>asset/images/icons/alfamidi.jpg" alt="alfamidi" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                        <div class="col-3">
                            <a href="<?php echo base_url() ?>jamaah/daftar/dp_notice?method=indomaret">
                                <img src="<?php echo base_url(); ?>asset/images/icons/indomaret.jpg" alt="indomaret" class="img-fluid rounded-sm shadow mb-3">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        
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

    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
        <div class='responsive-iframe max-iframe'>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/9quq1e6UiUE?si=G8dAU0DJv1qiDIl8"
                frameborder="0" allowfullscreen></iframe>
            <!-- <iframe src='https://www.youtube.com/embed/c9MnSeYYtYY' frameborder='0' allowfullscreen></iframe> -->
        </div>
        <div class="menu-title">
            <p class="color-highlight">Video Tutorial</p>
            <h1>Tutorial Pembayaran</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-n2">
            <!-- <p>
                It's super easy to embed videos. Just copy the embed!
            </p> -->
            <!-- <a href="#" class="close-menu btn btn-full btn-m shadow-l rounded-s text-uppercase font-600 gradient-green mt-n2">Awesome</a> -->
        </div>
    </div>

    <!-- Modal Metode Bayar -->
    <div id="menu-receipts" class="menu menu-box-bottom rounded-m bg-white" data-menu-height="650">
        <div class="menu-title">
            <p class="color-highlight font-600">Pembayaran</p>
            <h1>Pilih Cara Pembayaran</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>

        <div class="ms-4 me-4 mb-4">
            <div class="search-box rounded-m bottom-0">
                <i class="fa fa-search ms-2"></i>
                <input id="search" type="text" oninput="performSearch()" class="border-0"
                    placeholder="Cari metode pembayaran" value="">
            </div>
        </div>
        <div id="cara-pembayaran"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    
</body>