<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
    }
    #page {
        min-height: 100vh !important;
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu'); ?>
        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="content mb-0 pb-5">

                <p class="mb-n1 color-highlight font-600">Selamat! </p>
                <h1 class="font-26 font-800">Terimakasih</h1>
                <p>
                    Anda telah terdaftar pada paket <span
                        class="color-highlight font-800"><?php echo $paket->nama_paket; ?></span>
                    dengan keberangkatan tanggal <span
                        class="color-highlight font-800"><?php echo $this->date->convert_date_indo($paket->tanggal_berangkat); ?></span>.
                </p>
                <!-- <?php if (!isset($family)) { ?>
                <p>
                    Berikutnya, daftarkan anggota keluarga atau kerabat Anda untuk berangkat bersama Anda, klik
                    tombol dibawah! <br>
                    <a href="<?php echo base_url() . 'jamaah/daftar/start?parent=' . $id_member; ?>"
                        class="btn btn-l mb-3 mt-3 rounded-s font-700 shadow-s bg-highlight">Daftarkan Keluarga
                        Anda</span></a>
                </p> -->
                <?php } ?>
                <?php if (isset($family)) { ?>
                <p class="mb-2">
                    Berikut kerabat atau keluarga yang berhasil Anda daftarkan :
                </p>
                <?php foreach ($family as $fam) : ?>
                <div class="d-flex mb-2">
                    <div class="align-self-center rounded-sm shadow-l bg-gray-light p-2 me-2">
                        <img src="<?php echo base_url() ?>asset/appkit/images/ventour/avatar.png" width="20">
                    </div>
                    <div class="align-self-center">
                        <h2 class="font-15 line-height-s mt-1 mb-1">
                            <?php echo implode(' ', array_filter([$fam->jamaahData->first_name, $fam->jamaahData->second_name, $fam->jamaahData->last_name])) ?>
                        </h2>
                    </div>
                </div>
                <?php endforeach; ?>
                <p class="mb-2">Daftarkan lagi keluarga atau kerabat Anda yang lain!</p>

                <a href="<?php echo base_url() . 'jamaah/daftar/start?parent=' . $id_member . "&idg=" . $id_agen; ?>"
                    class="btn btn-l mb-3 mt-3 rounded-s font-700 shadow-s bg-highlight">Daftarkan Lagi</span></a>
                <?php } ?>
                <div class="divider"></div>
                <!-- <p>
                    Atau, lanjut ke tahap berikutnya.
                </p> -->
                
            </div>
            <a href="<?php echo base_url() . 'jamaah/daftar/registrasi_next'; ?>"
                class="btn btn-l mb-3 mx-3 rounded-s text-uppercase font-700 shadow-s bg-green-light btn-full fixed-bottom" style="bottom:70px;">Lanjutkan</span></a>
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
    </script>
</body>