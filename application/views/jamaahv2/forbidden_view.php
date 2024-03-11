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
        <?php $this->load->view('jamaahv2/include/header_bar', ['noBackButton' => true]); ?>

        <div class="page-title page-title-fixed">
            <!-- <h1>AppKit</h1> -->
            <div style="width: 70%;">
                <a href="<?php echo base_url() ?>jamaah/home" class="header-title ms-3 show-on-theme-light"><img
                        src="<?php echo base_url() . 'asset/appkit/images/ventour/LOGO-VENTOUR-Hitam.png'; ?>" alt=""
                        style="max-width: 170px;"></a>
                <a href="<?php echo base_url() ?>jamaah/home" class="header-title ms-3 show-on-theme-dark"><img
                        src="<?php echo base_url() . 'asset/appkit/images/ventour/LOGO-VENTOUR-Putih.png'; ?>" alt=""
                        style="max-width: 170px;"></a>
            </div>
        </div>
        <!-- header title -->
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="card card-style p-4 text-center py-5">
                <p class="font-600 color-highlight mb-0">Oopss..</p>
                <h1>FORBIDDEN ACCESS</h1>
                <p>
                    Mohon maaf, halaman tidak dapat diakses
                </p>
            </div>
            <!--  -->
            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
        </div>
        <!-- Page content ends here-->
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>