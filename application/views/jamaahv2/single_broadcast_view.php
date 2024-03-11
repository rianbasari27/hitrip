<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
        p {
            margin-bottom: 0;
        }
    </style>
</head>
<body class="theme-light">
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <div class="page-content">
            <div class="card card-style">
                <div class="content">
                    <span class="p-2 rounded-circle bg-<?php echo $broadcast->color; ?> bg-opacity-25">
                        <i class="fa-solid fa-bullhorn text-<?php echo $broadcast->color; ?>"></i>
                    </span>
                    <span class="fw-bold ms-2 text-<?php echo $broadcast->color;?>">BROADCAST INFORMASI</span>

                    <div class="mb-2 mt-3">
                        <h4><?php echo $broadcast->judul ?></h4>
                        <span class="mb-2 d-block"><?php echo $broadcast->pesan ?></span>
                    </div>
                    <div class="d-flex">
                        <span class="mb-0 fw-bold font-12 text-<?php echo $broadcast->color ?>"><?php echo $broadcast->tanggal_post ?></span>
                    </div>
                </div>
            </div>
        </div>
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
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <!-- <script src="https://cdn.datatables.net/plug-ins/1.13.2/pagination/ellipses.js"></script> -->
    <?php $this->load->view('jamaahv2/include/script_view'); ?>
</body>
</html>