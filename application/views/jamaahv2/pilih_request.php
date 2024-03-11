<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/request_ban.jpg");
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
        <?php $this->load->view('jamaahv2/include/footer_menu'); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Daftar Jamaah</p>
                    <h1>Rekomendasi Dokumen</h1>
                    <p class="mb-0">
                        Buat surat rekomendasi untuk<br> <span class="color-highlight font-600"
                            style="font-size: 17px;"><?php echo $nama_jamaah; ?></span>
                    </p>
                    <a href="<?php echo base_url() . 'asset/docs/PPIU PT. VENTURA SEMESTA WISATA.pdf';?>"
                        class="btn btn-primary btn-xs rounded-xs mt-2" download>
                        <i class="fas fa-download"></i> Download PPIU
                    </a>
                </div>
            </div>
            <div class="card card-style" style="position:relative; height:fit-content;">
                <div class="content mt-0 mb-0">
                    <a href="<?php echo base_url(); ?>jamaah/req_dokumen/input?idm=<?php echo $idSecretMember; ?>">
                        <button class="btn btn-sm bg-highlight mt-4 rounded-s mb-3 ms-3"><i
                                class="fa fa-user-plus fa-xl color-white me-3"></i> Buat Rekomendasi Baru</button>
                    </a>
                    <?php if (empty($sudahAmbil['items'][0])) { ?>
                    <div class="mb-2 ms-3">
                        <strong>Silahkan buat Rekomendasi terlebih dahulu</strong>
                    </div>
                    <?php } ?>
                    <?php if (!empty($sudahAmbil['items'][0])) { ?>
                    <div class="content mb-4" style="border: blue;">
                        <h4 class="font-700 color-dark"><strong>Daftar Rekomendasi Anda</strong></h4>
                    </div>
                    <?php $ctr = 0; ?>
                    <?php foreach ($sudahAmbil['dateGroup'] as $tglAmbil => $ambil) { ?>
                    <?php $ctr++;?>
                    <div class="card card-style bg-highlight gradient-fade-bottom"
                        style="position:relative; height:fit-content;">
                        <div class="accordion mt-1 mb-1" id="accordion-2">
                            <button class="btn accordion-btn no-effect" data-bs-toggle="collapse"
                                data-bs-target="#sudahAmbil<?php echo $ctr;?>" style="color: black;">
                                Rekomendasi Tanggal : <span class="text-success"> <?php echo $tglAmbil; ?></span> <span
                                    class="text-gray-500" style="color: gray;">(click to download)</span>
                                <i class="fa fa-chevron-down font-10 accordion-icon"></i>
                            </button>
                            <div id="sudahAmbil<?php echo $ctr;?>" class="collapse " data-bs-parent="#accordion-2">
                                <div class="row mt-4 mb-1" style="justify-content: center;">
                                    <div class="col-5 pe-1">
                                        <a href="<?php echo base_url() . "dokum_dl/download_jamaah_imigrasi?idr=" . $sudahAmbil['dateGroup'][$tglAmbil][0]->idSecretRequest. "&idm=" . $idSecretMember; ?>"
                                            class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-500 shadow-s bg-highlight">Download
                                            Imigrasi</a>
                                    </div>
                                    <div class="col-5 pe-1 ps-1">
                                        <a href="<?php echo base_url() . "dokum_dl/download_jamaah_kemenag?idr=" . $sudahAmbil['dateGroup'][$tglAmbil][0]->idSecretRequest. "&idm=" . $idSecretMember; ?>"
                                            class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-700 shadow-s bg-highlight">Download
                                            Kemenag</a>
                                    </div>
                                </div>
                                <div class="row" style="justify-content: center;">
                                    <div class="col-8 pe-1 ps-1">
                                        <a href="<?php echo base_url() . "jamaah/req_dokumen/hapus?idr=" . $sudahAmbil['dateGroup'][$tglAmbil][0]->idSecretRequest. "&idm=" . $idSecretMember; ?>"
                                            class="btn btn-s btn-full mb-3 rounded-xs text-uppercase font-500 shadow-s gradient-red">Hapus
                                            Request</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
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
            data-menu-active="nav-request"></div>

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