<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['pembayaran_nav' => true]); ?>
        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="card card-style">
                <div class="content mt-3">
                    <h3 class="color-highlight font-500 mb-1">Nominal yang Harus Dibayarkan</h3>
                    <h1><?php echo 'Rp. ' . number_format($dpPlusBSIAdmin, 0, ',', '.') . ',-'; ?></h1>
                    <h3 class="color-highlight font-500 mb-1">Nomor VA BSI</h3>
                    <h1 id="copyText"><?php echo $nomorVAOpen; ?></h1>

                    <h3 class="color-highlight font-500 mb-1">Transfer dari Luar BSI</h3>
                    <h1><span style="font-size: 16px;">(Norek Bank Syariah Indonesia)</span>
                        <?php echo $nomorVAOpenLuarBSI; ?></h1>
                    <?php if ($dataMember[$idMember]['detailJamaah']->member[0]->id_paket != '369') :  ?>
                    <a href="<?php echo base_url(); ?>konsultan/jamaah_info/dp_notice?id=<?php echo $dataMember[$idMember]['detailJamaah']->member[0]->idSecretMember ;?>"
                        class="btn btn-s rounded-s font-700 bg-highlight shadowxl">Ganti Metode Pembayaran</a>
                    <?php endif; ?>

                </div>
            </div>
            <?php $this->load->view('konsultan/cara_pembayaran_konsultan', ['nomorVAOpen' => $nomorVAOpen, 'nomorVAOpenLuarBSI' => $nomorVAOpenLuarBSI]); ?>

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
    <script>
    // Mengatur waktu akhir perhitungan mundur
    var countDownDate = new Date("<?php echo $countDown; ?>").getTime();

    // Memperbarui hitungan mundur setiap 1 detik
    var x = setInterval(function() {

        // Untuk mendapatkan tanggal dan waktu hari ini
        var now = new Date().getTime();

        // Temukan jarak antara sekarang dan tanggal hitung mundur
        var distance = countDownDate - now;

        // Perhitungan waktu untuk hari, jam, menit dan detik
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Keluarkan hasil dalam elemen dengan id = "demo"
        document.getElementById("countDownTime").innerHTML =
            "Waktu booking seat Anda <i class='fa-regular fa-clock'></i> " + hours + "h " +
            minutes + "m " + seconds + "s";

        // Jika hitungan mundur selesai, tulis beberapa teks 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countDownTime").innerHTML = "";
        }
    }, 1000);
    </script>
</body>