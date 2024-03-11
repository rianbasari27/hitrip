<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
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
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <div class="page-content">
            <div class="card card-style">
                <div class="content">
                    <?php foreach ($broadcast as $bc) : ?>
                        <span class="p-2 rounded-circle bg-<?php echo $bc->color; ?> bg-opacity-25">
                            <i class="fa-solid fa-bullhorn text-<?php echo $bc->color; ?>"></i>
                        </span>
                        <span class="fw-bold ms-2 text-<?php echo $bc->color;?>"><?php echo $bc->judul ?></span>

                        <div class="mb-2 mt-3">
                            <?php if ($bc->flyer_image != null) { ?>
                            <img src="<?php echo base_url() . $bc->flyer_image?>" width="100%" class="mb-4 rounded-m shadow">
                            <?php } ?>
                            <span class="mb-2 d-block"><?php echo $bc->pesan ?></span>

                            <?php if ($bc->link1 != null || $bc->nama_link1 != null) { ?>
                                <a href="<?php echo $bc->link1 ?>" class="btn btn-xs bg-<?php echo $bc->color ?> rounded me-1 mt-2"><i class="fa-solid fa-arrow-up-right-from-square me-1"></i><?php echo $bc->nama_link1 ?></a>
                            <?php } ?>
                            <?php if ($bc->link2 != null || $bc->nama_link2 != null) { ?>
                                <a href="<?php echo $bc->link2 ?>" class="btn btn-xs bg-<?php echo $bc->color ?> rounded me-1 mt-2"><i class="fa-solid fa-arrow-up-right-from-square me-1"></i><?php echo $bc->nama_link2 ?></a>
                            <?php } ?>
                            <?php if ($bc->link3 != null || $bc->nama_link3 != null) { ?>
                                <a href="<?php echo $bc->link3 ?>" class="btn btn-xs bg-<?php echo $bc->color ?> rounded me-1 mt-2"><i class="fa-solid fa-arrow-up-right-from-square me-1"></i><?php echo $bc->nama_link3 ?></a>
                            <?php } ?>

                        </div>
                        <div class="d-flex">
                            <span class="mb-0 fw-bold font-12 text-<?php echo $bc->color ?>"><?php echo $bc->tanggal_post ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370">
        </div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480">
        </div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <!-- <script src="https://cdn.datatables.net/plug-ins/1.13.2/pagination/ellipses.js"></script> -->
    <?php $this->load->view('konsultan/include/script_view'); ?>
</body>
</html>