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
        <?php $this->load->view('konsultan/include/header_bar', ["always_show" => true]); ?>
        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu'); ?>
        <div class="card card-fixed mb-n5 bg-6" style="background-image: url('<?php echo $thumbnail_ ?>');"
            data-card-height="450">
            <div class="card-bottom p-3 pb-0">
                <h1 class="color-white font-30 font-800"><?php echo $folder; ?></h1>
                <p class="color-white opacity-80 pb-3">
                    Kumpulan foto-foto <?php echo $folder; ?> bersama Ventour
                </p>
            </div>
            <div class="card-overlay bg-gradient"></div>
        </div>
        <div class="card card-clear" data-card-height="460"></div>


        <div class="page-content pb-3">

            <div class="card card-full rounded-m pb-4">
                <div class="drag-line"></div>

                <div class="content mb-n2">
                    <div class="d-flex">
                        <div class="align-self-center">
                            <h1 class="mb-0 font-18">Recent Photoshoots</h1>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <?php
                    if ($data != NULL) {
                        foreach ($data as $kg) { ?>
                    <div class="col-6">
                        <div class="card m-2 card-style">
                            <a
                                href="<?php echo base_url() . 'konsultan/tentang_kami/vgaleri/' . $kg['director'] . '/' . $kg['directory']; ?>">
                                <img src="<?php echo $kg['thumbnail']; ?>" class="img-fluid">
                                <div class="p-2 bg-theme rounded-sm">
                                    <h4 class="font-10 line-height-s pb-1"><?php echo $kg['title']; ?></h4>
                                    <p class="font-5 mb-0 ps-1">Galeri Jamaah </p>
                                </div>
                        </div>
                        </a>
                    </div>
                    <?php }
                    } else {
                        ?> <div class="content mb-n2">
                        <div class="d-flex">
                            <div class="align-self-center">
                                <h1 class="mb-0 font-18"></h1>
                            </div>
                        </div>
                    </div> <?php
                            }
                                ?>
                </div>

                <?php $this->load->view('konsultan/include/footer'); ?>

            </div>
        </div>

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