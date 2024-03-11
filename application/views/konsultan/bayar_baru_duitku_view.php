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
                <div class="content mt-3">
                    <span style="color : #1f448c;">Powered by</span> <br>
                    <img class="mb-3" src="<?php echo base_url(); ?>asset/images/icons/Duitku.svg" alt="Duitku Logo"
                        style="width: 225px;height: auto;" />
                    <?php if ($totalBayar == 0) : ?>
                    <h3 class="color-highlight font-500 mb-1">Bayar DP Minimal</h3>
                    <h1><?php echo 'Rp. ' . number_format($tarif['dp'], 0, ',', '.') . ',-'; ?></h1>
                    <?php else : ?>
                    <h3 class="color-highlight font-500 mb-1">Sisa Tagihan</h3>
                    <h1><?php echo 'Rp. ' . number_format($sisaTagihan, 0, ',', '.') . ',-'; ?></h1>
                    <?php endif; ?>
                    <div class="divider mt-4"></div>
                    <h4 class="color-highlight font-500 mb-3">Masukkan nominal yang hendak dibayarkan </h4>
                    <form
                        action="<?php echo base_url(); ?>konsultan/riwayat_bayar/proses_bayar_duitku?id=<?php echo $id_member; ?>"
                        method="post" id="myForm">
                        <div class="input-style no-borders has-icon mb-4">
                            <i class="fa fa-money-bill"></i>
                            <input type="hidden" name="metode" value="<?php echo $metode ;?>">
                            <input type="text" name="nominal" class="form-control format_harga" id="form1a"
                                placeholder="Rp">
                            <em>(required)</em>
                        </div>

                        <button type="submit"
                            class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s mb-3"
                            style="width: 100%;">Bayar</button>
                        <!-- <a type="submit" onclick="submit()" data-back-button
                            class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s mb-3">Sign
                            In</a> -->
                    </form>
                </div>


            </div>
            <?php $this->load->view('konsultan/cara_pembayaran_duitku', ['nomorVAOpen' => $tarif['nomorVAOpen'], 'nomorVAOpenLuarBSI' => $tarif['nomorVAOpenLuarBSI']]); ?>



            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
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

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var formatHargaElements = document.querySelectorAll(".format_harga");

        formatHargaElements.forEach(function(element) {
            element.addEventListener("input", function() {
                var inputValue = element.value;

                inputValue = inputValue.replace(/[^\d.]/g, '');

                if (inputValue !== '') {
                    inputValue = parseFloat(inputValue).toLocaleString('en-US');
                    element.value = inputValue;
                } else {
                    element.value = '';
                }
            });
        });
    });
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>