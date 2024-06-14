<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['discover' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

            <div class="content mt-0">
                <h1>Area Trip</h1>
            </div>
            <?php if ($area != null) { ?>
            <?php $no = 0; foreach ($area as $a) {  $no++ ?>
            <a href="<?php echo base_url() . 'jamaah/discover/list_area?area=' . $a->kategori ?>"
                class="card card-style mb-3"
                style="background-image:url('<?php echo base_url() . ($no != 1 ? "asset/appkit/images/banner-hajj.jpg" : "asset/appkit/images/banner-umroh.jpg") ?>')"
                data-card-height="150">
                <div class="card-center ps-3">
                    <h1 class="color-white mb-n1 font-28"><?php echo $a->kategori ?></h1>
                    <!-- <p class="color-white opacity-50 mb-0">Parties and Dancing</p> -->
                </div>
                <!-- <div class="card-center">
                        <span class="icon icon-s float-end bg-theme color-black me-3 rounded-xl"><i class="fa fa-arrow-right"></i></span>
                    </div> -->
                <div class="card-overlay bg-gradient opacity-60"></div>
            </a>
            <?php } ?>
            <?php } else { ?>
            <div class="card card-style">
                <div class="content">
                    <h1>Oops!</h1>
                    <p>
                        Tidak dapat menampilkan area trip. Paket belum tersedia.
                    </p>
                </div>
            </div>
            <?php } ?>

            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
            <?php $this->load->view('jamaah/include/toast'); ?>
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


    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
</body>