<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
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
        <?php $this->load->view('jamaahv2/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['pembayaran_nav' => true]); ?>
        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style">
                <div class="content mb-0 pb-5">

                    <p class="mb-n1 color-highlight font-600">Selamat! </p>
                    <h1 class="font-26 font-800">Seat Berhasil di Booking</h1>
                    <p>
                        Anda telah terdaftar pada paket <span
                            class="color-highlight font-800"><?php echo $dataMember[$idMember]['detailJamaah']->member[0]->paket_info->nama_paket; ?></span>
                        dengan keberangkatan tanggal <span
                            class="color-highlight font-800"><?php echo $this->date->convert("j F Y", $_SESSION['paket']['tanggal_berangkat']); ?></span>
                        <?php if ($dataMember[$idMember]['detailJamaah']->member[0]->paket_info->countdown <= 45 && $dataMember[$idMember]['detailJamaah']->member[0]->paket_info->countdown >= 0) { ?>
                        <br>
                        (<span class="text-danger font-800">
                            <?php echo $dataMember[$idMember]['detailJamaah']->member[0]->paket_info->countdown; ?></span>
                        )
                        <?php } elseif ($dataMember[$idMember]['detailJamaah']->member[0]->paket_info->countdown > 45 && $dataMember[$idMember]['detailJamaah']->member[0]->paket_info->countdown <= 90) { ?>
                        (<span>
                            <?php echo $dataMember[$idMember]['detailJamaah']->member[0]->paket_info->countdown; ?></span>)
                        <?php } ?>
                    </p>
                    <span>
                        Seat berhasil di booking untuk nama-nama berikut :
                    </span>
                    <ul class="color-highlight font-17">
                        <strong>
                            <?php foreach ($dataMember as $fam) { ?>
                            <li><?php echo implode(' ', array_filter([$fam['detailJamaah']->first_name, $fam['detailJamaah']->second_name, $fam['detailJamaah']->last_name])); ?>
                            </li>
                            <?php } ?>
                        </strong>
                    </ul>
                    <a href="<?php echo base_url() ?>jamaah/daftar/pindah_paket?id=<?php echo $dataMember[$idMember]['id_member'] ?>"
                        class="btn btn-xxs mb-3 rounded text-uppercase font-700 shadow-s gradient-highlight">Pindah
                        Paket</a>
                    <h4>Segera lakukan pembayaran Down Payment (DP) senilai :</h4>
                    <h1 class="font-900 color-highlight">
                        <?php echo "Rp." . number_format($dpPlusBSIAdmin, 0, ',', '.') . ",-"; ?></h1>
                    <h5 class="font-500 opacity-75 color-highlight mb-3">*
                        <?php echo "Rp." . number_format($vaOpenAdminFee, 0, ',', '.') . ",-"; ?>
                        biaya admin.</h5>
                    <p>
                        Lakukan Pembayaran untuk mengamankan seat Anda.
                        <br><span class="color-red-dark font-700">* Data dan
                            seat Anda akan terhapus apabila DP tidak dibayarkan selama lebih dari
                            <?php echo $this->config->item('dp_expiry_hours'); ?> jam dari saat waktu mendaftar</span>.
                    </p>
                    <p class="mt-n4"><span class="color-red-dark font-700" id="countDownTime"></span></p>
                    <span class="opacity-70">*Catatan: Halaman ini dapat Anda akses kembali dari menu
                        "Pembayaran".</span>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-3">
                    <h3 class="color-highlight font-500 mb-1">Nominal yang Harus Dibayarkan</h3>
                    <h1><?php echo 'Rp. ' . number_format($dpPlusBSIAdmin, 0, ',', '.') . ',-'; ?></h1>

                    <h3 class="color-highlight font-500 mb-1">Nomor VA BSI</h3>
                    <h1 id="copyText"><?php echo $nomorVAOpen; ?></h1>

                    <h3 class="color-highlight font-500 mb-1">Transfer dari Luar BSI</h3>
                    <h1><span style="font-size: 16px;">(Norek Bank Syariah Indonesia)</span>
                        <?php echo $nomorVAOpenLuarBSI; ?></h1>

                </div>
            </div>
            <?php $this->load->view('jamaahv2/cara_pembayaran_view', ['nomorVAOpen' => $nomorVAOpen, 'nomorVAOpenLuarBSI' => $nomorVAOpenLuarBSI]); ?>

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