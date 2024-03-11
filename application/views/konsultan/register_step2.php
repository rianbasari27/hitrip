<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
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
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['daftar_nav' => true]); ?>
        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style">
                <div class="content mb-0 pb-5">

                    <p class="mb-n1 color-highlight font-600">Selamat! </p>
                    <h1 class="font-26 font-800">Terimakasih</h1>
                    <p>
                        Jamaah Anda telah terdaftar pada paket <span
                            class="color-highlight font-800"><?php echo $paket_info->nama_paket; ?></span>
                        dengan keberangkatan tanggal <span
                            class="color-highlight font-800"><?php echo $this->date->convert("j F Y", $paket_info->tanggal_berangkat); ?></span>.
                    </p>
                    <?php if (!$family) { ?>
                    <p>
                        Berikutnya, daftarkan Jamaah lain atau anggota keluarga dan kerabat Jamaah Anda untuk berangkat bersama, klik
                        tombol dibawah! <br>
                        <!-- <a href="" class="btn btn-l mb-3 mt-3 rounded-s font-700 shadow-s bg-highlight">
                            Daftarkan lagi
                        </a> -->
                        <a href="<?php echo base_url() . 'konsultan/daftar_jamaah/start?parent=' . $id_member; ?>"
                            class="btn btn-l mb-3 mt-3 rounded-s font-700 shadow-s bg-highlight">Daftarkan Lagi</span></a>
                    </p>
                    <?php } ?>
                    <?php if ($family) { ?>
                    <p class="mb-2">
                        Berikut jamaah yang berhasil Anda daftarkan :
                    </p>
                    <?php foreach ($family as $fam) : ?>
                        <div class="d-flex mb-2">
                            <div class="align-self-center rounded-sm shadow-l bg-gray-light p-2 me-2">
                                <img src="<?php echo base_url() ?>asset/appkit/images/ventour/avatar.png" width="20">
                            </div>
                            <div class="align-self-center">
                                <h2 class="font-15 line-height-s mt-1 mb-1"><?php echo implode(' ', array_filter([$fam->jamaahData->first_name, $fam->jamaahData->second_name, $fam->jamaahData->last_name])) ?></h2>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <p class="mb-2">Daftarkan lagi Jamaah yang lain!</p>

                    <a href="<?php echo base_url() . 'konsultan/daftar_jamaah/start?parent=' . (!($parent_id) ? $id_member : $parent_id); ?>"
                        class="btn btn-l mb-3 mt-3 rounded-s font-700 shadow-s bg-highlight">Daftarkan Lagi</span></a>
                    <?php } ?>
                    <div class="divider"></div>
                    <p>
                        Atau, lanjut ke tahap berikutnya.
                    </p>
                    <a href="<?php echo base_url() . 'konsultan/daftar_jamaah/registrasi_next?id='. $id_member; ?>"
                        class="btn btn-l mb-3 mt-3 rounded-s text-uppercase font-700 shadow-s bg-green-light btn-full">Lanjutkan</span></a>

                </div>
            </div>
        </div>
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

    <!-- Menu Modal -->
    <div id="modal" 
         class="menu menu-box-modal rounded-m bg-theme" 
         data-menu-width="350"
         data-menu-height="205">
        <div class="menu-title">
            <p class="color-highlight">Registrasi </p>
            <h1 class="font-800">Daftarkan lagi</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        
        <div class="content mt-1">

            <div>
                <span>Daftarkan Jamaah lain atau anggota keluarga dan kerabat Jamaah Anda untuk berangkat bersama.</span>
            </div>

            <div class="row">
                <div class="col-6">
                    <a href="<?php echo base_url() . 'konsultan/daftar_jamaah/start?parent=' . $id_member; ?>" class="close-menu btn btn-full gradient-green font-12 btn-m font-600 mt-3 rounded-s">Keluarga</a>
                </div>
                <div class="col-6">
                    <a href="<?php echo base_url() . 'konsultan/daftar_jamaah/start?agen_parent=' . $id_member; ?>" class="close-menu btn btn-full gradient-blue font-12 btn-m font-600 mt-3 rounded-s">Bukan Keluarga</a>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script>
    </script>
</body>