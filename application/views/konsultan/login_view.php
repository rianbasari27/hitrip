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
        <?php $this->load->view('jamaahv2/include/header_bar', ['always_show' => true]); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu'); ?>

        <!-- header title -->
        <!-- NOT USED IN THIS PAGE -->
        <div class="page-content header-clear-medium">
            <div class="card card-style mb-3">
                <div class="content">
                    <p class="font-600 color-highlight mb-n1">Bismillah</p>
                    <h1 class="font-30">Login Konsultan</h1>
                    <p class="font-600 color-dark-dark mb-n1 mt-5">Konsultan masuk menggunakan email google yang telah terdaftar di Ventour.</p>
                    <p class="font-600 color-dark-dark mb-3 mt-2">Apabila email Anda belum terdaftar, silakan hubungi Customer Service.</p>

                    <?php if (isset($_SESSION['alert'])) { ?>
                        <!-- <div class="mt-3 font-800 color-<?php echo $_SESSION['alert']['color'] ?>-dark"><?php echo $_SESSION['alert']['message']; ?></div> -->
                    <?php } ?>

                    <div id="g_id_onload" data-client_id="747034251442-2pui9t7sml074vdrc9at3iatet2trii9.apps.googleusercontent.com" data-context="signin" data-ux_mode="redirect" data-login_uri="<?php echo base_url(); ?>konsultan/login/proses" data-itp_support="true">
                    </div>

                    <div class="g_id_signin mb-5" data-type="standard" data-shape="rectangular" data-theme="outline" data-text="signin_with" data-size="large" data-logo_alignment="left">
                    </div>
                </div>
            </div>

            <!-- <div class="content mt-0">
                <div class="text-center">Belum punya akun?</div>
                <div class="divider mb-4"></div>
                <a href="<?php echo base_url() . 'konsultan/daftar_konsultan'; ?>"
                    class="btn btn-sm btn-full rounded-sm font-13 font-600 gradient-green">
                    Daftar disini
                </a>
            </div> -->

        </div>
        <!-- Page content ends here-->
        <?php $this->load->view('konsultan/include/alert-bottom');?>
        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/home/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/home/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/home/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script>
        function submit() {
            document.getElementById("myForm").submit();
        }
    </script>
    <script src="https://accounts.google.com/gsi/client" async></script>
</body>