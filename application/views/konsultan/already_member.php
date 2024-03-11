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
        <?php $this->load->view('konsultan/include/footer_menu', ['daftar_nav' => true]); ?>
        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="card card-style">
                <div class="content">
                    <p class="mb-n1 color-highlight font-600 mb-n1">Mohon Maaf </p>
                    <h2>Tidak Dapat Mendaftarkan Paket</h2>
                    <p class="mt-3">
                        Kami tidak dapat mendaftarkan data tersebut karena Nomor KTP yang hendak didaftarkan telah terdaftar sebelumnya.
                    </p>
                    <p>
                        Apabila Anda bermaksud untuk pindah paket umroh silakan hubungi admin Ventour untuk diproses lebih lanjut.
                    </p>
                    <p>
                        Terimakasih.<br>
                        Ventour.
                    </p>

                    <a href="<?php echo base_url() . 'konsultan/home'; ?>" class="btn btn-full btn-m rounded-sm border-0 text-uppercase font-700 gradient-highlight mt-4">Kembali ke Home</a>
                </div>
            </div>
        </div>
        <!-- Page content ends here-->

        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

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