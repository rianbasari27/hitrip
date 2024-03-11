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

                    <?php if (!empty($transPending)) : ?>
                    <div class="divider mt-4"></div>
                    <h4 class="color-highlight font-500 mb-3">Selesaikan Transaksi Pending </h4>
                    <div class="list-group list-custom-large">
                        <?php foreach ($transPending as $pend) : ?>
                        <a href="<?php echo $pend['paymentUrl']; ?>">
                            <img src="<?php echo base_url(); ?>asset/images/icons/Duitku.svg" alt="Duitku Logo" />
                            <span><?php echo $this->money->format($pend['paymentAmount']); ?> <span
                                    class="btn btn-xxs rounded-s font-700 bg-green-dark"
                                    style="position: initial;">Bayar</span></span>
                            <strong class="color-red-dark mt-4">
                                Waktu pembayaran <i class='fa-regular fa-clock'
                                    style="float: unset; margin: unset;"></i>
                                <span style="all: unset;" class="countdown" id="<?php echo $pend['merchantOrderId']; ?>"
                                    endTime="<?php echo $pend['dateExpired']; ?>">time</span>
                            </strong>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <h4 class="color-highlight font-500 mb-2 mt-5">Atau Buat Pembayaran Baru </h4>
                    <?php endif; ?>

                    <a href="<?php echo base_url(); ?>konsultan/riwayat_bayar/duitku_bayar_baru?id=<?php echo $tarif['dataMember'][$tarif['idMember']]['detailJamaah']->member[0]->idSecretMember; ?>&metode=null"
                        class="btn btn-m rounded-s text-uppercase font-700 bg-green-dark shadowxl mt-3">Buat Pembayaran
                        Baru</a>

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
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>

    <script>
    let countdownIntervals = {};

    $('.countdown').each(function(i, obj) {
        let id = obj.getAttribute('id');
        let endDate = obj.getAttribute('endTime');
        let endTime = new Date(endDate).getTime();
        initCountdown(id, endTime);
    });

    function initCountdown(rowId, endTime) {
        clearInterval(countdownIntervals[rowId]);

        function updateCountdown() {
            const currentTime = new Date().getTime();
            const timeLeft = endTime - currentTime;
            if (timeLeft <= 0) {
                clearInterval(countdownIntervals[rowId]);
                $('#' + rowId).html('');
            } else {
                const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                // Ganti ini dengan kode untuk menampilkan countdown dengan benar
                $('#' + rowId).html(hours + 'j ' + minutes + 'm ' + seconds + 'd');
            }
        }


        countdownIntervals[rowId] = setInterval(updateCountdown, 1000);
    }
    </script>
</body>