<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/mecca.jpg");
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
        <?php $this->load->view('jamaah/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['order' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

            <div class="content">
                <h1 class="mb-0 mt-n2">Transaki Anda</h1>
            </div>

            <?php if ($data != null ) { ?>
                <?php foreach ($data as $item) { ?>
                    <div class="card card-style p-3 mb-3">
                        <a href="<?php echo base_url() . 'jamaah/pembayaran/detail_pembayaran?id=' . $item->id_pembayaran . '&idm=' . $id_member ?>" class="d-flex">
                            <div class="align-self-center">
                                <h5 class="mb-n1 font-15"><?php echo $item->keterangan ?></h5>
                                <span class="font-11 color-theme opacity-70"">No. Pembayaran #<?php echo $item->id_pembayaran . $item->id_member . date('Ymd', strtotime($item->tanggal_bayar)) ?></span>
                                </div>
                                <div class=" ms-auto text-end align-self-center">
                                    <h5 class="color-theme font-15 font-700 d-block mb-n1">
                                        <?php echo number_format($item->jumlah_bayar, 0, ',', '.') ?></h5>
                                    <p
                                        class="color-green-dark font-11 d-inline"><?php echo $this->date->convert_date_indo(date('Y-m-d', strtotime($item->tanggal_bayar))); ?>
                                        <i class="fa fa-check-circle"></i></p>
                            </div>
                        </a>
                    </div>
                <?php } ?>
                <div class="content">
                    <p class="text-center">Pilih salah satu untuk download invoice</p>
                </div>
            <?php } else { ?>
                <div class="content">
                    <p class="text-center">Belum ada transaksi</p>
                </div>
            <?php } ?>


            <?php $this->load->view('jamaah/include/alert'); ?>
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
    $(document).ready(function() {
        // $('#riwayat').click(function() {
        //     console.log('Tes');
        //     $('#history').attr('class', 'bg-highlight no-click')
        //     $('#info').attr('class', 'collapsed')
        // })
        $('#close').click(function() {
            location.reload();
        })
    })
    </script>
</body>