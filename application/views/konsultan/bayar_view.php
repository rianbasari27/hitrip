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
                    <p class="color-highlight font-500 mb-n1">Pembayaran</p>
                    <h1>Bayar Tagihan</h1>

                    <p class="mb-3">
                        Lakukan pembayaran dengan mengikuti petunjuk yang telah disediakan. Anda dapat melakukan
                        pelunasan dengan cara melakukan beberapa kali pembayaran.
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-3">
                    <img class="mb-3" src="<?php echo base_url(); ?>asset/images/icons/bsi-logo.png" alt="BSI Logo"
                        style="width: auto;height: 154px;" />
                    <h3 class="color-highlight font-500 mb-1">Sisa Tagihan</h3>
                    <h1><?php echo 'Rp. ' . number_format($sisaTagihan+$tarif['vaOpenAdminFee'], 0, ',', '.') . ',-'; ?>
                    </h1>
                    <h5 class="font-500 opacity-50 color-gray mb-3">*
                        <?php echo "Rp." . number_format($tarif['vaOpenAdminFee'], 0, ',', '.') . ",-"; ?>
                        biaya admin.</h5>

                    <h3 class="color-highlight font-500 mb-1">Nomor VA BSI</h3>
                    <h1><?php echo $tarif['nomorVAOpen']; ?> <span style="font-size: 16px;"><button
                                onclick="CopyMe('<?php echo $tarif['nomorVAOpen']; ?>')"><i
                                    class="fa-solid fa-clipboard"></i></button></span></h1>

                    <h3 class="color-highlight font-500 mb-1">Transfer dari Luar BSI</h3>
                    <h1><span style="font-size: 16px;">(Bank Syariah Indonesia)</span>
                        <?php echo $tarif['nomorVAOpenLuarBSI']; ?> <span style="font-size: 16px;"><button
                                onclick="CopyMe('<?php echo $tarif['nomorVAOpenLuarBSI']; ?>')"><i
                                    class="fa-solid fa-clipboard"></i></button></span></h1>

                </div>
            </div>
            <?php $this->load->view('konsultan/cara_pembayaran_konsultan', ['nomorVAOpen' => $tarif['nomorVAOpen'], 'nomorVAOpenLuarBSI' => $tarif['nomorVAOpenLuarBSI']]); ?>


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

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
    function CopyMe(TextToCopy) {
        var TempText = document.createElement("input");
        TempText.value = TextToCopy;
        document.body.appendChild(TempText);
        TempText.select();

        document.execCommand("copy");
        document.body.removeChild(TempText);
        Swal.fire({ //displays a pop up with sweetalert
            icon: 'success',
            title: 'Text copied to clipboard',
            showConfirmButton: false,
            timer: 1000
        });
    }
    </script>
</body>