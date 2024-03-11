<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
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

    .btn.accordion-btn {
        padding: 0px 0px !important;
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-menu -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>

        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu'); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>

        <div class="card card-fixed mb-n5" data-card-height="350">
            <div class="map-full">
                <iframe style="border: 0;"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.06433365715!2d106.83693231483436!3d-6.3856989953793795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ebf482b94f85%3A0x295f753f095919f4!2sPT.+Ventura+Semesta+Wisata!5e0!3m2!1sid!2sid!4v1541995192065"
                    width="1130" height="350" frameborder="0"></iframe>
            </div>
        </div>
        <div class="card card-clear" data-card-height="500"></div>


        <div class="page-content pb-3">
            <div class="card card-full rounded-m pb-3">
                <div class="drag-line"></div>
                <div class="content mt-0">
                    <h1 class="font-700 mt-4 mb-1">Ventour Travel Umrah | Wisata Muslim Turki, Aqsa, Dubai
                    </h1>
                    <p class="color-highlight fw-bold fs-5">PT Ventura Semesta Wisata</p>
                    <!-- <div class="divider border-1"></div> -->
                    <hr>
                    <div class="row text-center mb-0">
                        <div class="col-3 text-center">
                            <a href="https://maps.app.goo.gl/YJDAmU6vWoc6LNDK8"
                                class="mx-auto d-flex justify-content-center align-items-center bg-highlight text-white rounded-circle fs-4"
                                style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-diamond-turn-right"></i>
                            </a>
                            <span class="text-dark">Direction</span>
                        </div>
                        <div class="col-3 text-center">
                            <a href="https://www.ventour.co.id"
                                class="mx-auto d-flex justify-content-center align-items-center bg-highlight text-white rounded-circle fs-4"
                                style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-globe"></i>
                            </a>
                            <span class="text-dark">Website</span>
                        </div>
                        <div class="col-3 text-center">
                            <a href="#"
                                class="mx-auto d-flex justify-content-center align-items-center bg-highlight text-white rounded-circle fs-4"
                                style="width: 50px; height: 50px;" data-menu="menu-call">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <span class="text-dark">WhatsApp</span>
                        </div>
                        <div class="col-3 text-center">
                            <a href="#"
                                class="mx-auto d-flex justify-content-center align-items-center bg-highlight text-white rounded-circle fs-4"
                                style="width: 50px; height: 50px;"
                                onclick="CopyMe('https://maps.app.goo.gl/48nV5YmqmnSShnAs5')">
                                <i class="fa-solid fa-link"></i>
                            </a>
                            <span class="text-dark">Copy Link</span>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <ul class="fa-ul">
                            <li><i class="fa-li fa-solid fa-location-dot font-20 text-danger"></i>
                                <span class="text-dark font-16"> Jl. K.H.M. Yusuf Raya No.18 A-B, Mekar Jaya, Kec.
                                    Sukmajaya, Kota Depok, Jawa Barat 16411</span>
                            </li>
                            <!-- <i class="fa-regular fa-clock"></i> -->
                            <li class="mt-2"><i class="fa-li fa-regular fa-clock font-20 text-primary"></i>
                                <!-- <span class="text-dark font-14">  -->
                                <?php if (date('l') != 'Sun') : ?>
                                <?php if (date('H:i') > "16:59" || date('H:i') < "08:30") : ?>
                                <p><span class="text-danger fw-bold font-16"> Tutup </span><span
                                        class="text-dark font-16">(
                                        <?php echo (date('l') != 'Sat') ? '08.30 - 17:00' : '08.30 - 14:00' ?>
                                        )</span></p>
                                <?php else : ?>
                                <p><span class="text-success fw-bold font-16"> Buka </span><span
                                        class="text-dark font-16">(
                                        <?php echo (date('l') != 'Sat') ? '08.30 - 17:00' : '08.30 - 14:00' ?>
                                        )</span></p>
                                <?php endif; ?>
                                <?php else : ?>
                                <p><span class="text-danger fw-bold font-16"> Tutup</span><span
                                        class="text-dark font-16">( Senin - Sabtu )</span></p>
                                <?php endif; ?>
                                <!-- </span> -->
                            </li>
                        </ul>
                    </div>
                    <div class="row ms-2">
                        <button class="btn accordion-btn no-effect color-theme" data-bs-toggle="collapse"
                            data-bs-target="#collapse3">
                            &emsp;&emsp;Offline Services Hours
                            <i class="fa fa-arrow-down font-10 accordion-icon"></i>
                        </button>
                    </div>
                    <div id="collapse3" class="collapse mt-n4 mb-2" data-bs-parent="#accordion-1">
                        <div class="pt-1 pb-2 ps-3 pe-3">
                            <?php foreach ($arr as $a) { ?>
                            <div class="row ms-4 mb-n1 <?php echo $a['days'] == date('l') ? 'fw-bold' : '';?>">
                                <div class="col-4">
                                    <span><?php echo $a['days'];?></span>
                                </div>
                                <div class="col-8">
                                    <?php if ( $a['days'] != "Sunday") { ?>
                                    <span
                                        class="text-dark"><?php echo $a['days'] == 'Saturday' ? '( 08.30 - 14.00 )' :'( 08.30 - 17.00 )';?></span>
                                    <?php } else { ?>
                                    <span class="text-dark">Closed</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row ms-2">
                        <button class="btn accordion-btn no-effect color-theme" data-bs-toggle="collapse"
                            data-bs-target="#collapse2">
                            &emsp;&emsp;Online Services Hours
                            <i class="fa fa-arrow-down font-10 accordion-icon"></i>
                        </button>
                    </div>
                    <div id="collapse2" class="collapse mt-n4 mb-2" data-bs-parent="#accordion-1">
                        <div class="pt-1 pb-2 ps-3 pe-3">
                            <?php foreach ($arr as $a) { ?>
                            <div class="row ms-4 mb-n1 <?php echo $a['days'] == date('l') ? 'fw-bold' : '';?>">
                                <div class="col-4">
                                    <span><?php echo $a['days'];?></span>
                                </div>
                                <div class="col-8">
                                    <?php if ( $a['days'] != "Sunday") { ?>
                                    <span class="text-dark">( 08.00 - 21.00 )</span>
                                    <?php } else { ?>
                                    <span class="text-dark">( 08.00 - 16.00 )</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php $this->load->view('konsultan/include/footer'); ?>
            </div>
        </div>


    </div>
    <!-- Page content ends here-->

    <!------------->
    <!------------->
    <!--Menu Call-->
    <!------------->
    <!------------->
    <div id="menu-call" class="menu menu-box-modal rounded-m" data-menu-width="350">
        <div class="menu-title">
            <p class="color-highlight">Untuk beralih ke WhatsApp</p>
            <h1>Silahkan Klik</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content">
            <a href="https://wa.me/62811167565"
                class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-green-dark text-start mb-2"><span
                    class="ms-n2">Finance</span></a>
            <a href="https://wa.me/628111456485"
                class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-blue-dark text-start mb-2"><span
                    class="ms-n2">Manifest</span></a>
            <a href="https://wa.me/6285804610529"
                class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-red-dark text-start mb-2"><span
                    class="ms-n2">Public Relation</span></a>
            <a href="https://wa.me/6285182565540"
                class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-orange-dark text-start mb-2"><span
                    class="ms-n2">Perlengkapan</span></a>
            <a href="https://wa.me/6281295155670"
                class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-yellow-dark text-start mb-4"><span
                    class="ms-n2">Help & Support</span></a>
        </div>
    </div>

    <!-- Main Menu-->
    <div id="menu-main" class="menu menu-box-left rounded-0"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
        data-menu-active="nav-kontak"></div>

    <!-- Share Menu-->
    <div id="menu-share" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
    function CopyMe(TextToCopy) {
        var TempText = document.createElement("input");
        TempText.value = TextToCopy;
        document.body.appendChild(TempText);
        TempText.select();

        document.execCommand("copy");
        document.body.removeChild(TempText);
        Swal.fire({ //displays a pop up with sweetalert
            icon: 'success',
            title: 'Text copied to clipboard',
            showConfirmButton: false,
            timer: 1000
        });
    }
    </script>
</body>