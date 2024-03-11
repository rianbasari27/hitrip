<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu'); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style">
                <div class="content">
                    <p class="mb-n1 color-highlight font-600"></p>
                    <h1 class="color-highlight">Galeri</h1>
                    <p>
                        Kumpulan Dokumentasi Keberangkatan Jamaah Bersama Ventour
                    </p>
                </div>
            </div>
            <?php $this->load->view('konsultan/include/slide_menu'); ?>
            <div class="divider mt-0"></div>
            <?php if ($data != NULL) {
                foreach ($data as $dt) { ?>
            <a href="<?php echo base_url() . 'konsultan/tentang_kami/kategori/' . $dt['directory']; ?>"
                style="background-image: url('<?php echo $dt['thumbnail']; ?>');" class="default-link card card-style"
                data-card-height="450" title="">
                <div class="card-bottom">
                    <div class="content text-end">
                        <h1 class="color-white font-28"><?php echo $dt['title']; ?></h1>
                        <p class="color-white opacity-70">
                            Kumpulan foto-foto perjalanan <br>
                            <?php echo $dt['title']; ?> Bersama Ventour
                        </p>
                    </div>
                </div>
                <div class="card-overlay bg-gradient opacity-70"></div>
            </a>
            <div class="divider divider-margins"></div>
            <?php }
            } else {
                ?><div class="content mb-n2">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-18"></h1>
                    </div>
                </div>
            </div> <?php
                    }
                        ?>

            <?php $this->load->view('konsultan/include/footer'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-galeri"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>