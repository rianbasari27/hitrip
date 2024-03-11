<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar', ["always_show" => true]); ?>
        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu'); ?>

        <div class="page-content header-clear-medium">

            <div class="card card-style">
                <div class="content">
                    <h1 class="mb-n1 color-highlight"><?php echo $file; ?></h1>
                    <p class="mb-3">
                        Kumpulan Foto Jamaah <?php echo $file; ?> Bersama Ventour
                    </p>
                    <div class="row row-cols-3 px-1 mb-0">
                        <?php
                        if ($data  != NULL) {
                            foreach ($data as $dt) { ?>
                        <a class="col p-2" href="<?php echo $dt['view']; ?>" data-gallery="gallery-b">
                            <img src="<?php echo $dt['view']; ?>" alt="img" class="img-fluid rounded-s shadow-xl">
                        </a>
                        <?php }
                        } else {
                            ?> <div class="content mb-n2">
                            <div class="d-flex">
                                <div class="align-self-center">
                                    <h1 class="mb-0 font-18"></h1>
                                </div>
                            </div>
                        </div><?php
                                }
                                    ?>
                    </div>
                </div>
            </div>
            <?php $this->load->view('jamaahv2/include/footer'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-galeri"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>


    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>