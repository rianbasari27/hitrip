<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/home-banner.png");
    }

    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-19 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-17 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-18 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-20 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-21 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-29 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-33 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }
    </style>
    <?php
    function indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    };
    ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>


        <div data-card-height="350" class="card card-style bg-home">

            <div class="card-center text-start ps-3 pt-4">
                <h1 class="color-white font-22 mb-0 opacity-70">Assalamu'alaikum</h1>
                <h1 class="color-white font-36 mb-5">
                    <?php echo $jamaahData->first_name; ?></h1>
            </div>
            <div class="card-bottom text-end pe-3">
                <p class="color-white mb-3 opacity-70 line-height-s font-15">
                    <?php echo $memberData->paket_info->nama_paket; ?><br>
                    <?php echo 'Keberangkatan ' . date_format(date_create($memberData->paket_info->tanggal_berangkat), "d F Y") . ' (' . $memberData->paket_info->countdown . ' hari lagi)'; ?>
                </p>
            </div>
            <div class="card-overlay bg-gradient opacity-60"></div>
        </div>


        <!-- Menu slider -->
        <?php $this->load->view('jamaahv2/include/slide_menu'); ?>
        <!--  -->
        <div class="row">
            <div class="col-lg-12">
                <?php if (!empty($_SESSION['alert_type'])) { ?>
                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                    <?php echo $_SESSION['alert_message']; ?>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="card card-style">
                <div class="content">
                    <div class="col-md-12 h5 text-gray-800">
                        <div class="h3 text-success mb-4 font-weight-bold">
                            Terimakasih, Pembayaran Anda Akan Segera Kami Validasi
                        </div>
                        Konfirmasi pembayaran Anda telah kami terima, silakan menunggu maksimal 2x24 jam untuk kami
                        melakukan validasi.<br>
                        Anda dapat langsung melengkapi data diri Anda.<br>
                        Terimakasih. <br>
                        <div class="h6 mt-4">
                            Untuk kembali ke halaman utama
                            <a href="<?php echo base_url() . 'jamaah/home_user?id=' . $member->id_member; ?>"
                                class="btn btn-danger">klik disini</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('jamaahv2/include/footer'); ?>
        <?php $this->load->view('jamaahv2/include/alert'); ?>
        <div class="row">
            <br><br>
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
</body>