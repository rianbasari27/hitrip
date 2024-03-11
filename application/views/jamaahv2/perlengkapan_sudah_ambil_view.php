<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/perlengkapan.jpg");
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
        <?php $this->load->view('jamaahv2/include/footer_menu', ['perlengkapan_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Perlengkapan</p>
                    <h1>Sudah Diambil</h1>

                    <p class="mb-3">
                        Berikut ini perlengkapan yang sudah diambil oleh jamaah.
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content">
                    <?php foreach ($data as $key => $dt) { ?>
                    <div class="list-group list-custom-small list-icon-0">
                        <a data-bs-toggle="collapse" class="no-effect" href="#collapse-<?php echo $key; ?>">
                            <span
                                class="font-14 color-dark-dark"><?php echo implode(" ", array_filter([$dt['infoJamaah']->first_name, $dt['infoJamaah']->second_name, $dt['infoJamaah']->last_name])); ?></span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                    </div>
                    <div class="collapse" id="collapse-<?php echo $key; ?>">
                        <div class="list-group list-custom-small ps-3">
                            <?php if (empty($dt['items']['items'])) { ?>
                            Tidak ada perlengkapan yang sudah diambil.
                            <?php } ?>
                            <ul>
                                <?php foreach ($dt['items']['items'] as $item) { ?>
                                <li>
                                    <?php echo $item->nama_barang; ?>
                                    <span class="color-highlight">
                                        <?php echo $item->jumlah_ambil; ?>
                                        <?php echo $item->stok_unit; ?>
                                    </span>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <?php } ?>

                </div>

            </div>



            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
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