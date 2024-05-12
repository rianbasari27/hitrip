<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['order' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

            
        <div class="card card-style mb-3 mt-3">
            <div class="content">
                <h1 class="mb-n2 font-20"><?php echo $paket->nama_paket?></h1>
                <p class="color-highlight mb-1"><i class="fa-solid fa-location-dot me-1"></i><?php echo $paket->nama_paket . ', ' . $paket->negara ?></p>
                <div class="card card-style mx-0" 
                    style="background-image:url('<?php echo base_url() . $paket->banner_image ?>');" 
                    data-card-height="100">
                </div>

                <div class="d-flex opacity-60">
                    <div class="mx-auto">
                        <i class="fa-solid fa-plane-departure font-16 color-theme"></i>
                    </div>
                    <div class="mx-auto" style="width: 70%">
                        <div style="border-bottom: 1px dashed grey;" class="mt-2"></div>
                    </div>
                    <div class="mx-auto">
                        <i class="fa-solid fa-plane-arrival font-16 color-theme"></i>
                    </div>
                </div>
                <div class="d-flex opacity-60">
                    <h4 class="font-12 text-start"><?php echo $this->date->convert_date_indo($paket->tanggal_berangkat) ?></h4>
                    <h4 class="font-12 text-end ms-auto"><?php echo $this->date->convert_date_indo($paket->tanggal_pulang) ?></h4>
                </div>
            </div>
        </div>

        <div class="card card-style mb-3">
            <div class="content mb-0">
                <h3 class="font-16">Detail</h3>
                <div class="row">
                    <div class="col-6">Pilihan Kamar</div>
                    <div class="col-6 text-end color-theme font-700"><?php echo $member->pilihan_kamar ?></div>
                    <div class="col-6">Status Pembayaran</div>
                    <div class="col-6 text-end font-700 <?php echo $member->lunas != '1' ? 'color-red-dark' : 'color-green-dark' ?>"><?php echo $member->lunas != '1' ? 'Belum lunas' : 'Lunas' ?></div>
                    <div class="col-6">Itinerary</div>
                    <?php if ($paket->itinerary != null) { ?>
                        <a href="<?php echo base_url() . $paket->itinerary; ?>" download class="col-6 text-end font-700"><u><i class="fa-solid fa-download me-1"></i>Download</u></a>
                    <?php } else { ?>
                        <div class="col-6 text-end">Belum tersedia</div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="card card-style">
            <div class="content">
                <h3 class="font-16 mb-3">Hotel Info</h3>
                <?php if ($paket->hotel_info != null) { ?>
                    <?php foreach ($paket->hotel_info as $h) { ?>
                    <div class="card card-style mx-0 mb-3">
                        <div class="card mb-0" style="background-image: url('<?php echo base_url() . ($h->foto != null ? $h->foto : 'asset/appkit/images/hotel-default.jpg'); ?>');" 
                        data-card-height="100">
                        </div>
                        <div class="content m-3">
                            <div class="d-flex mb-n1">
                                <div>
                                    <h3 class="font-16 mb-n1"><?php echo $h->nama_hotel ?></h3>
                                    <p class="font-12 mb-0"><?php echo $h->kota . ', ' . $paket->negara ?></p>
                                </div>
                                <div class="ms-auto">
                                    <p class="color-yellow-dark font-700 mb-0 text-end"><?php echo $h->star ?><i class="fa-solid fa-star ms-1"></i></p>
                                    <a href="<?php echo $h->maps_link != null ? $h->maps_link : '#' ?>" class="color-highlight font-12"><i class="fa-solid fa-up-right-from-square me-1"></i>Temukan</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>Hotel belum tersedia</p>
                <?php } ?>
            </div>
        </div>

        <div class="content">
            <a href="<?php echo base_url() . 'jamaah/pembayaran/riwayat?id=' . $member->id_member ?>" class="btn btn-m btn-full gradient-highlight rounded-s">Riwayat Transaksi</a>
        </div>

            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
            <?php $this->load->view('jamaah/include/toast'); ?>
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


    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
</body>