<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
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
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['pembayaran_nav' => true]); ?>
        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

        <div class="card card-style">
            <div class="content text-center">
                <h4 class="mb-4"><i class="fa fa-4x fa-clock color-yellow-dark scale-box shadow-xl rounded-circle"></i></h4>
                <h3>Selamat! Anda telah terdaftar</h1>
                <div class="font-16 font-300">Anda telah terdaftar dalam antrian di program</div>
                <div class="d-flex p-3 rounded-sm shadow-xl bg-highlight mt-3">
                    <i class="fa fa-3x fa-calendar-check color-white"></i>
                    <h5 class="ms-2 font-14 font-500 color-white text-start"><?php echo $program->detail_program->nama_paket ?></h5>
                </div>

                <div class="divider mt-4 mb-3"></div>

                <span>Mohon menunggu informasi selanjutnya, Terima kasih</span>
            </div>
        </div>

        <?php $this->load->view('konsultan/include/alert'); ?>

        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
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