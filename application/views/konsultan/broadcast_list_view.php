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
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <div class="page-content">
            <div class="content mt-0">
                <p class="mb-n1 color-highlight font-600">Informasi</p>
                <h1>Pengumuman</h1>
            </div>
            <?php foreach ($broadcast as $bc) : ?>
            <a href="<?php echo base_url() . 'konsultan/broadcast_list/single_broadcast?id=' . $bc->id_broadcast ?>" class="card card-style bg-opacity-10 mb-3"
                style="position:relative; height:fit-content;">
                <div class="content mb-3">
                    <span class="p-2 rounded-circle bg-<?php echo $bc->color; ?> bg-opacity-25">
                        <i class="fa-solid fa-bullhorn text-<?php echo $bc->color; ?>"></i>
                    </span>
                    <span class="fw-bold ms-2 font-16 text-<?php echo $bc->color;?>"><?php echo substr($bc->judul, 0, 35); ?><?php if (strlen($bc->judul) > 35) echo '...'; ?></span>

                    <div class="mb-2 mt-1">
                        <span class="color-dark-dark"><?php echo substr($bc->pesan, 0, 100); ?><?php if (strlen($bc->pesan) > 100) echo '...'; ?></span>
                    </div>
                    <div class="d-flex">
                        <span class="mb-0 fw-bold font-12 text-<?php echo $bc->color ?>"><?php echo $bc->tanggal_post ?></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
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