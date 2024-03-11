<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default-profile.jpg");
    }

    .image-container {
        width: 190px;
        height: 190px;
        overflow: hidden;
        margin: 0px auto 0px;
        border: 5px solid #edbd5a;
        border-radius: 100%;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    </style>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body>

    <body class="theme-light">

        <div id="preloader">
            <div class="spinner-border color-highlight" role="status"></div>
        </div>

        <div id="page">
            <!-- header-bar -->
            <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>

            <!-- footer-menu -->
            <?php $this->load->view('konsultan/include/footer_menu', ['profile_nav' => true]); ?>

            <!-- header title -->
            <?php $this->load->view('konsultan/include/header_menu'); ?>
            <div class="page-title-clear"></div>

            <div class="page-content">

                <div class="content">
                    <div class="image-container">
                        <?php if (empty($agen->agen_pic)) : ?>
                        <a href="<?= base_url() . 'asset/appkit/images/pictures/default/default-profile.jpg' ?>"
                            title="Default Profile Picture" class="default-link" data-gallery="gallery-1">
                            <img src="<?php echo base_url(); ?>asset/appkit/images/pictures/default/default-profile.jpg"
                                width="40%" class="rounded-circle mx-auto shadow-xl">
                        </a>
                        <?php else : ?>
                        <a href="<?= base_url() . $agen->agen_pic ?>" title="<?php echo $agen->nama_agen ?>"
                            class="default-link" data-gallery="gallery-1">
                            <img src="<?php echo base_url() . $agen->agen_pic; ?>" width="100"
                                class="rounded-circle mx-auto shadow-xl">
                        </a>
                        <?php endif; ?>
                    </div>

                    <div class="my-3">
                        <h2 class="text-center my-0" id="text"><?php echo $agen->nama_agen ?></h2>
                        <span class="text-center my-0 d-block">No. Konsultan : <?php echo $agen->no_agen ?></span>
                        <?php if ($agen->id_agen == $_SESSION['id_agen']) : ?>
                        <div class="d-flex justify-content-center align-items-center my-2">
                            <a href="<?php echo base_url() . 'konsultan/profile/edit_profile' ?>"
                                class="btn btn-s btn-outline btn-full mb-3 rounded-l text-uppercase font-700 shadow-s bg-highlight"
                                style="width: 150px;">
                                <i class="fa-regular fa-pen-to-square me-2"></i>Edit Profile
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card card-style">
                    <div class="content mb-0">
                        <p class="color-highlight font-500 mb-n1">No. KTP</p>
                        <span><?php echo $agen->no_ktp ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Email</p>
                        <span><?php echo $agen->email ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">No. WhatsApp</p>
                        <span><?php echo $format_wa; ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Tanggal Lahir</p>
                        <span><?php echo $agen->tanggal_lahir ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">No. Rekening</p>
                        <span id="bank"><?php echo $agen->nama_bank . ' - ' . $agen->no_rekening ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Alamat</p>
                        <span
                            id="alamat"><?php echo $agen->alamat . ', ' . $agen->kecamatan . ', ' . $agen->kota . ', ' . $agen->provinsi ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Kewarganegaraan</p>
                        <span id="kwg"><?php echo $agen->kewarganegaraan ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Pekerjaan</p>
                        <span id="pkj"><?php echo $agen->pekerjaan ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Hobi</p>
                        <span id="hobi"><?php echo $agen->hobi ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Jenis Kelamin</p>
                        <span id="hobi"><?php echo $agen->jenis_kelamin == 'L' ? 'Laki - laki' :'Perempuan' ?></span>
                        <div class="divider mb-3 mt-2"></div>

                        <p class="color-highlight font-500 mb-n1">Ukuran Baju</p>
                        <span id="hobi"><?php echo $agen->ukuran_baju ?></span>
                        <div class="divider mb-3 mt-2"></div>
                    </div>
                </div>
                <?php $this->load->view('konsultan/include/footer'); ?>
                <?php $this->load->view('konsultan/include/alert'); ?>
            </div>



        </div>

        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370">
        </div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480">
        </div>

        <script type="text/javascript" src="scripts/bootstrap.min.js"></script>
        <script type="text/javascript" src="scripts/custom.js"></script>
        <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>

        <?php $this->load->view('konsultan/include/script_view'); ?>
        <script>
        $(document).ready(function() {
            var nama = $('#nama').text();
            var bank = $('#bank').text();
            var alamat = $('#alamat').text();
            var kwg = $('#kwg').text();
            var pkj = $('#pkj').text();
            var hobi = $('#hobi').text();

            var namaUpper = nama.toUpperCase();
            var bankUpper = bank.toUpperCase();
            var alamatUpper = alamat.toUpperCase();
            var kwgUpper = kwg.toUpperCase();
            var pkjUpper = pkj.toUpperCase();
            var hobiUpper = hobi.toUpperCase();

            $('#nama').text(namaUpper);
            $('#bank').text(bankUpper);
            $('#alamat').text(alamatUpper);
            $('#kwg').text(kwgUpper);
            $('#pkj').text(pkjUpper);
            $('#hobi').text(hobiUpper);
        });
        </script>
    </body>

</body>

</html>