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
                <h1 class="mb-n1 mt-n2">Invoice</h1>
                <p class="mb-0"><?php echo $this->date->convert_date_indo(date('Y-m-d')) ?></p>
            </div>

            <div class="card card-style">
                <div class="content mb-0">
                    <div class="row mb-3">
                        <div class="col-4 color-theme">Kepada</div>
                        <div class="col-8 text-end font-700 color-theme"><?php echo $user->name ?></div>
                        <div class="col-4 color-theme">No. Telp</div>
                        <div class="col-8 text-end font-700 color-theme"><?php echo $user->no_wa ?></div>
                        <div class="col-4 color-theme">Email</div>
                        <div class="col-8 text-end font-700 color-theme"><?php echo $user->email ?></div>
                    </div>

                    <div class="divider mb-3" style="background-color: rgba(0, 0, 0, 0.2);"></div>

                    <div class="row mb-3">
                        <div class="col-6 mb-2 color-theme">Paket</div>
                        <div class="col-6 mb-2 text-end font-700 color-theme"><?php echo $paket->nama_paket ?></div>
                        <div class="col-6 mb-2 color-theme">Status</div>
                        <div class="col-6 mb-2 text-end font-700 <?php echo $payment->verified == 1 ? 'color-green-dark ' : 'color-red-dark' ; ?>"><?php echo $payment->verified == 1 ? 'Valid' : 'Tidak Valid' ; ?></div>
                        <div class="col-6 mb-2 color-theme">Tanggal Bayar</div>
                        <div class="col-6 mb-2 text-end font-700 color-theme"><?php echo $this->date->convert_date_indo(date('Y-m-d', strtotime($payment->tanggal_bayar))); ?></div>
                        <div class="col-6 mb-2 color-theme">Metode Pembayaran</div>
                        <div class="col-6 mb-2 text-end font-700 color-theme"><?php echo $payment->cara_pembayaran ?></div>
                        <div class="col-6 mb-2 color-theme">Nominal</div>
                        <div class="col-6 mb-2 text-end font-700 color-theme"><?php echo $this->money->format($payment->jumlah_bayar) ?></div>
                        <div class="col-4 mb-2 color-theme">Keterangan</div>
                        <div class="col-8 mb-2 text-end font-700 color-theme"><?php echo $payment->keterangan ?></div>
                    </div>

                </div>
            </div>
            <div class="content mt-n2">
                <a href="<?php echo base_url() . 'jamaah/kuitansi_dl/download?id=' . $payment->id_pembayaran ?>" class="btn btn-m btn-full rounded-s gradient-highlight">Download Invoice</a>
            </div>

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