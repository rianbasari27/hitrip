<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/mecca.jpg");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['pembayaran_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Invoice & Pembayaran</p>
                    <h1>Pembayaran</h1>

                    <p class="mb-3">
                        Kelola pembayaran dan download invoice Anda.
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <div class="list-group list-custom-large">
                        <a href="<?php echo base_url() . 'konsultan/riwayat_bayar/metode?id='. $idMember; ?>">
                            <i class="fa fa-dollar-sign font-14 bg-green-dark color-white rounded-sm shadow-xl"></i>
                            <span>Bayar</span>
                            <strong>Melakukan pembayaran baru</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="<?php echo base_url() . 'konsultan/voucher'; ?>">
                            <i class="fa fa-ticket font-14 bg-red-dark color-white rounded-sm shadow-xl"></i>
                            <span>Voucher Diskon</span>
                            <strong>Gunakan kode voucher</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="<?php echo base_url() . 'konsultan/riwayat_bayar/riwayat?id=' . $idMember; ?>">
                            <i class="fa fa-server font-14 bg-blue-dark color-white rounded-sm shadow-xl"></i>
                            <span>Riwayat Pembayaran</span>
                            <strong>Melihat riwayat dan download invoice</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>



                    </div>
                </div>
            </div>



            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
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

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>