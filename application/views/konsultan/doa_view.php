<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <style>
        h3 {
            font-weight: 100;
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
        <?php $this->load->view('konsultan/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <div id="tab-group-1">
            <div class="content mb-4 mt-0">
                <div class="tab-controls tabs-small" data-highlight="bg-highlight">
                    <a href="#" id="info" data-active data-bs-toggle="collapse" data-bs-target="#tab-1" class="me-1 shadow rounded-s">Doa Harian</a>
                    <a href="#" id="history" data-bs-toggle="collapse" data-bs-target="#tab-2" class="ms-1 shadow rounded-s">Doa Umroh</a>
                </div>
            </div>

            <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1">
                <div class="card card-style" style="margin-bottom: 100px;">
                    <div class="content">
                        <?php foreach ($doa as $d) : ?>
                            <div class="accordion" id="accordion-1">
                                <div class="mb-0">
                                    <button class="btn accordion-btn no-effect color-theme" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $d['id'] ?>">
                                        <i class="fa fa-star color-yellow-dark me-2"></i>
                                        <?php echo $d['doa'] ?>
                                        <i class="fa fa-chevron-down font-10 accordion-icon"></i>
                                    </button>
                                    <div id="collapse<?php echo $d['id'] ?>" class="collapse" data-bs-parent="#accordion-1">
                                        <div class="pt-1 pb-2 ps-3 pe-3">
                                            <h3 class="text-end lh-base"><?php echo $d['ayat'] ?></h3>
                                            <div class="fst-italic mb-2"><?php echo $d['latin'] ?></div>
                                            <span class="fw-bold"><?php echo $d['artinya'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">
                <div class="card card-style" style="margin-bottom: 100px;">
                    <div class="content">
                        <?php $this->load->view('doa-umroh') ?>
                    </div>
                </div>
            </div>
        </div>


        <!-- Page content ends here-->


        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <a href="#" data-menu="ad-timed-1" data-timed-ad="0" data-auto-show-ad="5" class="btn btn-m btn-full shadow-xl font-600 bg-highlight mb-2 d-none">Auto Show Adds</a>

    <!-------------->
    <!-------------->
    <!--Menu Video-->
    <!-------------->
    <!-------------->

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('konsultan/include/script_view'); ?>
</body>