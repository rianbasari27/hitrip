<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/image-popup.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/default/easyui.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/icon.css"> -->
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>asset/easyui-custom/jquery.easyui.min.js"></script> -->
    <style>
        .bg-6 {
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/voucher.png");
        }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['pembayaran_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1"></p>
                    <h1>Kode Voucher</h1>

                    <p class="mb-3">
                        Masukkan kode voucher untuk mendapatkan potongan harga
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <?php if (isset($status)) { ?>
                        <h5 class="pt-3 ps-3 color-<?php echo $status == 0 ? 'red' : 'green' ?>-dark">
                            <?php echo $status == 0 ? 'Kode tidak dapat digunakan. ' : 'Selamat, '; ?>
                            <?php echo $msg; ?></h5>
                    <?php } ?>
                    <form role="form" action="<?php echo base_url(); ?>jamaah/voucher/proses" method="post" enctype="multipart/form-data" id="myForm">
                        <div class="input-style no-borders has-icon validate-field my-4">
                            <input type="text" name="kode_voucher" class="form-control" id="form1a" placeholder="Kode Voucher">
                            <label for="form1a" class="color-highlight">Kode Voucher</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>

                        <a href="#" id="submitBtn" data-back-button class="btn btn-l font-600 font-13 gradient-highlight rounded-s mb-3">Klaim Voucher</a>
                    </form>
                </div>
            </div>

            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script>
        $(document).ready(function() {
            $('#submitBtn').on("click", function(event) {
            $("#myForm").submit();
        });
        });
    </script>
</body>