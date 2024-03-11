<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
    }
    .bg-24 {
        background-image: url("<?php echo base_url() .  $program->agen_gambar_banner; ?>");
    }
    .bg-default {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/bg_kuning.jpg");
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
            <div class="card mb-0 rounded-0 <?php echo $program->agen_gambar_banner != null ? 'bg-24' : 'bg-default' ?>" data-card-height="300">
                <div class="card-bottom">
                    <?php if ($program->event[0]->link_lokasi != null) { ?>
                        <a href="<?php echo $program->event[0]->link_lokasi ?>" class="float-end btn btn-m font-700 bg-white rounded-s color-black mb-2 me-2">Temukan lokasi</a>
                    <?php } ?>
                </div>
            </div>
            <div class="content">
                <p class="font-600 color-highlight mb-n1"><?php echo $this->date->convert('l, j F Y',$program->event[0]->tanggal) ?></p>
                <h1 class="font-20 font-800"><?php echo $program->nama_paket ?></h1>
                <!-- <p class="font-14 mb-3">
                    The most prestigious summer festival in the world bringing the hotest DJ's and the best music.
                </p> -->
                <p class="opacity-80">
                    <!-- <i class="fa icon-30 text-center fa-star pe-2"></i>Rated 4.9 <span class="badge bg-transparent border border-red-dark color-red-dark ms-2">PREMIUM</span><br> -->
                    <i class="fa icon-30 text-center fa-map-marker pe-2"></i><?php echo $program->event[0]->lokasi != null ? $program->event[0]->lokasi : 'Info lokasi menyusul' ?><br>
                    <i class="fa icon-30 text-center fa-clock pe-2"></i><?php echo $program->event[0]->tanggal != null ? $this->date->convert('H:i',$program->event[0]->tanggal) . ' - ' . $this->date->convert('H:i',$program->event[0]->tanggal_selesai) . ' WIB' : 'Info jam menyusul' ?>
                </p>

                <i class="fa icon-30 text-center fa-users pe-2"></i><span class="pt-3 font-700"><?php echo $total_peserta ?> telah mendaftar</span>
            </div>
        </div>

        <?php if ($pembayaran != null) { ?>
            <a href="<?php echo base_url() ?>konsultan/kuitansi_dl/download_agen?id=<?php echo $pembayaran['data'][0]->id_pembayaran;?>" class="btn btn-full btn-margins rounded-sm gradient-highlight font-14 font-600 btn-xl">Download Invoice</a>
        <?php } else { ?>
            <a href="<?php echo base_url() . 'konsultan/home/start_program?id=' . $program->id; ?>" class="btn btn-full btn-margins rounded-sm gradient-highlight font-14 font-600 btn-xl">Daftar Sekarang</a>
        <?php }?>


        <?php $this->load->view('konsultan/include/alert'); ?>

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
</body>