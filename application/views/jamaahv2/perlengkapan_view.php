<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/perlengkapan.jpg");
    }

    @media screen and (max-width: 300px) {
        .video-icon {
            display: none;
        }
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
        <?php $this->load->view('jamaahv2/include/footer_menu', ['perlengkapan_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Kelola Perlengkapan</p>
                    <h1>Perlengkapan</h1>

                    <p class="mb-3">
                        Buat jadwal pengambilan perlengkapan, atau lihat perlengkapan yang sudah Anda ambil.
                    </p>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-video">
                            <i
                                class="video-icon color-icon-gray font-20 icon-40 text-center fab fa-youtube color-red-dark"></i>
                            <span>Tutorial Booking Perlengkapan</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="https://wa.me/6285182565540">
                            <i
                                class="video-icon color-icon-gray font-20 icon-40 text-center fa-solid fa-suitcase color-yellow-dark"></i>
                            <span>Admin Perlengkapan</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <div class="list-group list-custom-large">
                        <a href="<?php echo base_url() . 'jamaah/perlengkapan/jadwal_ambil'; ?>">
                            <i class="fa fa-calendar-day font-14 bg-green-dark color-white rounded-sm shadow-xl"></i>
                            <span>Jadwalkan Pengambilan</span>
                            <strong>Rencana tanggal pengambilan perlengkapan.</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>

                        <a href="<?php echo base_url() . 'jamaah/perlengkapan/lihat_ambil'; ?>">
                            <i class="fa fa-dolly font-14 bg-blue-dark color-white rounded-sm shadow-xl"></i>
                            <span>Perlengkapan Sudah Diambil</span>
                            <strong>Lihat perlengkapan yang sudah Anda ambil.</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>



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
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="320" data-menu-width="350">
        <div class='responsive-iframe max-iframe'>
            <iframe width="560" height="315" id="youtube-video"
                src="https://www.youtube.com/embed/qfd03QcquF8?si=6PfIyt_GcINRbwHi" frameborder="0"
                allowfullscreen></iframe>
            <!-- <iframe src='https://www.youtube.com/embed/c9MnSeYYtYY' frameborder='0' allowfullscreen></iframe> -->
        </div>
        <div class="menu-title">
            <p class="color-highlight">Video Tutorial</p>
            <h1>Tutorial Booking Perlengkapan</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-n2">
            <!-- <p>
                It's super easy to embed videos. Just copy the embed!
            </p> -->
            <!-- <a href="#" class="close-menu btn btn-full btn-m shadow-l rounded-s text-uppercase font-600 gradient-green mt-n2">Awesome</a> -->
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>