<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
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

    .menu-ads {
        position: fixed;
        -webkit-backdrop-filter: saturate(180%) blur(20px);
        backdrop-filter: unset !important;
        background-color: unset !important;
        z-index: 101;
        overflow: scroll;
        transition: all 300ms ease;
        -webkit-overflow-scrolling: touch;
    }

    .theme-dark .menu-ads {
        background-color: unset !important;
    }

    .redStrikeHover {
        color: red;
        text-decoration: line-through;
    }

    @media screen and (min-width: 300px) {
        .jam {
            font-size: clamp(20px, 9vw, 40px);
        }
    }

    @media screen and (max-width: 300px) {

        .sign-icon,
        .video-icon {
            display: none;
        }

        .slider-item {
            font-size: 14px;
        }

        .btn-sm {
            padding: 7px 14px !important;
        }

        .harga-paket {
            font-size: 20px;
        }
    }
    </style>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
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

        <div class="page-content">
            <?php if (!empty($bannerPromo)) { ?>
            <div class="splide single-slider slider-no-arrows slider-no-dots " id="single-slider-1">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div data-card-height="230" class="card card-style"
                                style="background-image: url('<?php echo base_url(); ?>asset/appkit/images/ventour/banner-image.jpg');">
                                <div class="card-center text-start ps-3 pt-4">
                                    <h1 class="color-white font-18 mb-0 opacity-70">Assalamu'alaikum</h1>
                                    <h1 class="color-white font-32 mb-5">Jamaah</h1>
                                </div>
                                <div class="card-bottom text-end pe-3">
                                    <p class="color-white mb-3 opacity-70 line-height-s font-15">
                                        Wujudkan Impian Umroh Anda<br>
                                        Bersama Ventour
                                    </p>
                                </div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <?php foreach ($bannerPromo as $bp) { ?>
                        <div class="splide__slide">
                            <div data-card-height="230" class="card card-style"
                                style="background-image: url('<?php echo base_url() . 'uploads/promo_banner/' . $bp['view']; ?>');">
                                <div class="card-overlay"></div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } else {  ?>
            <div data-card-height="230" class="card card-style"
                style="background-image: url('<?php echo base_url(); ?>asset/appkit/images/ventour/home-banner.png');">
                <div class="card-center text-start ps-3 pt-4">
                    <h1 class="color-white font-22 mb-0 opacity-70">Assalamu'alaikum</h1>
                    <h1 class="color-white font-36 mb-5">Jamaah</h1>
                </div>
                <div class="card-bottom text-end pe-3">
                    <p class="color-white mb-3 opacity-70 line-height-s font-15">
                        Wujudkan Impian Umroh Anda<br>
                        Bersama Ventour
                    </p>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>
            <?php } ?>



            <div class="content mx-0 mt-0 mb-2">
                <div class="row mb-0">
                    <div class="col-6 pe-0">
                        <div class="card mr-0 mb-3 card-style rounded-sm">
                            <div class="d-flex p-2">
                                <div class="align-self-center">
                                    <h1 class="mb-0 font-26 jam">
                                        <div id="jakarta"></div>
                                    </h1>
                                </div>
                                <div class="text-end ms-auto align-self-center">
                                    <p class="fw-bold mb-n2 font-12 color-highlight">Jakarta</p>
                                    <p class="my-0" id="jkt_date" style="font-size: clamp(6px, 10vw, 12px);"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 ps-0">
                        <div class="card ml-0 mb-3 card-style rounded-sm">
                            <div class="d-flex p-2">
                                <div class="align-self-center">
                                    <h1 class="mb-0 font-26 jam">
                                        <div id="riyadh"></div>
                                    </h1>
                                </div>
                                <div class="text-end ms-auto align-self-center">
                                    <p class="fw-bold mb-n2 font-12 color-highlight">Mekkah</p>
                                    <p class="my-0" id="riyadh_date" style="font-size: clamp(6px, 10vw, 12px);"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="d-flex pt-3 mt-1 mb-2 pb-2">
                    <div class="align-self-center">
                        <i
                            class="sign-icon color-icon-gray color-gray-dark font-30 icon-40 text-center fas fa-sign-in-alt ms-3"></i>
                    </div>

                    <div class="align-self-center">
                        <p class="ps-2 ms-1 color-highlight font-500 mb-n1 mt-n2">Sudah punya akun?</p>
                        <h4 class="ps-2 ms-1 mb-0" style="font-size: clamp(14px, 5vw, 22px);">Masuk disini</h4>
                    </div>
                    <div class="ms-auto align-self-center mt-n2">
                        <a href="<?php echo base_url() . 'jamaah/masuk'; ?>"
                            class="btn btn-sm rounded-s font-13 font-600 gradient-green me-4">
                            Masuk
                        </a>
                    </div>
                </div>
            </div>

            <div class="content mt-0">
                <!-- <h1 class="font-14 my-0">Tentang Kami</h1>
                <div class="divider mb-3"></div> -->
                <div class="row text-center mb-0">
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/surat_doa' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-book-quran color-green-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Al-Qur'an</h5>
                            <span class="font-8 color-dark-light">Baca Al-Qur'an</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2">
                        <a href="<?php echo base_url() . 'jamaah/surat_doa/doa' ?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-person-praying color-magenta-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Doa</h5>
                            <span class="font-8 color-dark-light">Doa Harian & Umroh</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/surat_doa/tasbih' ?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <img src="<?php echo base_url() . 'asset/appkit/images/beads.svg' ?>" width="25px"
                                class="mx-auto pb-2 mb-2 d-block" alt="">
                            <h5 class="mb-0 font-14">Dzikir</h5>
                            <span class="font-8 color-dark-light">Penghitung Dzikir</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/paket_layanan' ?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-grip color-red-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Layanan</h5>
                            <span class="font-8 color-dark-light">Layanan Kami</span>
                        </a>
                    </div>
                    <div class="col-4 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/kontak' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-location-dot color-red-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Kontak</h5>
                            <span class="font-8 color-dark-light">Kontak Kami</span>
                        </a>
                    </div>
                    <div class="col-4 pe-2">
                        <a href="https://wa.me/6281295155670" data-menu="menu-call"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-whatsapp color-whatsapp fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Hubungi Kami</h5>
                            <span class="font-8 color-dark-light">Hubungi Kami</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-style" id="paket">
                <div class="content mb-0">
                    <p class="mb-n1 font-600 color-highlight">Segera bergabung, seat terbatas!</p>
                    <h2 class="mb-4">Jadwal Keberangkatan
                        <?php echo $monthSelected ? $this->date->convert("F", '01-' . $monthSelected . '-1990') : ""; ?>
                    </h2>

                    <div class="row">
                        <div class="col-6">
                            <div class="card card-style bg-highlight mx-0 pt-2 pb-2" data-menu="menu-musim">
                                <h5 class="color-white d-flex justify-content-between align-items-center">
                                    <span class="ms-3">Pilih Musim</span>
                                    <span class="icon icon-xxs bg-theme color-black rounded-xl me-3"><i
                                            class="fa fa-arrow-right"></i></span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-style bg-highlight mx-0 pt-2 pb-2" data-menu="menu-bulan">
                                <h5 class="color-white d-flex justify-content-between align-items-center">
                                    <span class="ms-3">Pilih Bulan</span>
                                    <span class="icon icon-xxs bg-theme color-black rounded-xl me-3"><i
                                            class="fa fa-arrow-right"></i></span>
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div id="season" class="d-none"></div>
                        <?php foreach ($paket as $p) { ?>
                        <div class="paket_musim" id="paket<?php echo $p->id_paket?>">
                            <div class="d-flex" onclick="window.location='<?php echo $p->detailLink; ?>';">
                                <div class="col-6 mb-4 pe-0">
                                    <a href="#"><img
                                            src="<?php echo ($p->banner_image) ? base_url() . $p->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                                            class="rounded-sm shadow-xl img-fluid"></a>
                                </div>
                                <div class="col-6 ms-3 pe-2">
                                    <a href="#" class="d-block">
                                        <?php for ($i = 0; $i < $p->star; $i++) { ?>

                                        <i class="fa fa-star color-yellow-dark"></i>
                                        <?php } ?>
                                        <br>
                                    </a>
                                    <a href="#">
                                        <h5 class="mb-0"><?php echo $p->nama_paket; ?></h5>
                                        <?php if ($p->sisa_seat > 20) { ?>
                                        <span class="color-green-dark font-11">Seat Tersedia</span>
                                        <?php } else { ?>
                                        <span class="color-orange-light font-11">Sisa <?php echo $p->sisa_seat; ?> Seat
                                            Lagi!</span>
                                        <?php } ?>
                                    </a>
                                    <?php if ($p->default_diskon > 0 ) { ?>
                                    <del style="color: red;text-decoration:line-through">
                                        <p class="mt-1 mb-n2 font-600">
                                            <?php echo $p->hargaHome; ?> Jt
                                        </p>
                                    </del>
                                    <h1 class="mb-n2 font-800 harga-paket"><?php echo $p->hargaHomeDiskon; ?><sup
                                            class="font-800 font-16" style="font-weight:bold;"> Jt</sup></h1>
                                    <span class="opacity-100 font-11">Berangkat
                                        <?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></span>
                                    <?php } else {  ?>
                                    <h1 class="mb-n2 font-800 harga-paket">
                                        <?php echo $p->hargaHome; ?><sup class="font-800 font-16"
                                            style="font-weight:bold;">
                                            Jt</sup></h1>
                                    <span class="opacity-100 font-11">Berangkat
                                        <?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="w-100 divider divider-margins"></div>

                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <div id="menu-bulan" class="menu menu-box-bottom rounded-m" data-menu-height="450" data-menu-effect="menu-over">
            <div class="menu-title">
                <p class="color-highlight">Selalu Tersedia</p>
                <h1 class="font-24">Pilih Bulan Keberangkatan</h1>

                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>

            </div>
            <div class="me-4 ms-3 mt-2">
                <div class="list-group list-custom-small">
                    <a href="#" data-month="00" data-musim="0000" class="month-option"><span>Semua
                            Keberangkatan</span><i class="fa fa-angle-right"></i></a>
                    <?php foreach ($availableMonths as $month) { ?>
                    <a href="#" class="month-option" data-musim="0000"
                        data-month="<?php echo date('m', strtotime($month->tanggal_berangkat)); ?>"><span><?php echo $this->date->convert('F', $month->tanggal_berangkat); ?></span><i
                            class="fa fa-angle-right"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div id="menu-musim" class="menu menu-box-bottom rounded-m" data-menu-height="450" data-menu-effect="menu-over">
            <div class="menu-title">
                <p class="color-highlight">Musim</p>
                <h1 class="font-24">Pilih Musim</h1>

                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>

            </div>
            <div class="me-4 ms-3 mt-2">
                <div class="list-group list-custom-small">
                    <a href="#" class="season-option" data-month="00" data-musim="0000"><span>Semua
                            Keberangkatan</span><i class="fa fa-angle-right"></i></a>
                    <?php $no = 0;
                    foreach ($seasonArr as $s) { 
                        $no++;
                        ?>
                    <a href="#" id="btnSeason<?php echo $no;?>" class="season-option" data-month="00"
                        data-musim="<?php echo $s[0]; ?>"><span><?php echo $s[0] . ' H'; ?></span><i
                            class="fa fa-angle-right"></i></a>
                    <?php } ?>
                </div>
            </div>
        </div>


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

    <a href="#" data-menu="ad-timed-1" data-timed-ad="0" data-auto-show-ad="5"
        class="btn btn-m btn-full shadow-xl font-600 bg-highlight mb-2 d-none">Auto Show Adds</a>

    <!-------------->
    <!-------------->
    <!--Menu Video-->
    <!-------------->
    <!-------------->
    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
        <div class='responsive-iframe max-iframe'><iframe width="560" height="315"
                src="https://www.youtube.com/embed/cozPdcPZKnc?si=Q8Nop1g4gZtndsCb" title="YouTube video player"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe></div>
        <div class="menu-title">
            <p class="color-highlight">Tutorial</p>
            <h1>Pendaftaran</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
    </div>


    <?php if ($view != null) : ?>
    <div id="ad-timed-1" class="menu-ads menu-box-modal menu-box-detached" data-menu-width="330" data-menu-height="420"
        data-menu-effect="menu-over">
        <div class="card-top">
            <a href="#" id="close-ads" class="close-menu ad-time-close shadow-l bg-red-light"><i
                    class="fa fa-times disabled"></i><span></span></a>
        </div>
        <img src="<?php echo base_url() . "uploads/ads/" . $view; ?>" alt="" width="100%" class="shadow-m">
    </div>
    <script>
    setTimeout(function() {
        $('.menu-hider').addClass('menu-active');
    }, 5000);
    </script>
    <?php endif; ?>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('jamaahv2/include/script_view'); ?>
    <script>
    $(document).ready(function() {

        $('.season-option').click(function(event) {
            event.preventDefault()

            var musim = $(this).data('musim');
            var month = $(this).data('month');

            var seasonApi = "<?php echo base_url() . 'jamaah/home/getSeasonPackage?musim=';?>" + musim +
                "&month=" + month;
            var monthApi = "<?php echo base_url() . 'jamaah/home/getMonthSeasonPackage?musim=';?>" +
                musim + "&month=" + month;
            fetch(seasonApi)
                .then(response => response.json())
                .then(data => {
                    $('#menu-musim').removeClass('menu-active');
                    $('.menu-hider').removeClass('menu-active');
                    $('.paket_musim').addClass('d-none');

                    data.forEach(function(pkt) {
                        $('#paket' + pkt.id_paket).removeClass('d-none');
                        $('#paket' + pkt.id_paket).addClass('d-block')
                    });
                    fetch(monthApi)
                        .then(response => response.json())
                        .then(month => {
                            // Append to menu-bulan
                            var menuBulan = $('#menu-bulan .list-custom-small');
                            menuBulan.empty(); // Clear existing content
                            // Append new month options
                            menuBulan.append(
                                '<a href="#" data-month="00" data-musim="0000" class="month-option"><span>Semua Keberangkatan</span><i class="fa fa-angle-right"></i></a>'
                            );
                            month.forEach(function(bulan) {
                                // console.log(month);
                                var splitMonth = bulan['tanggal_berangkat'].split('-');
                                var f = new Date(splitMonth[0], splitMonth[1] - 1,
                                    splitMonth[2]);
                                var month_name = $.datepicker.formatDate('M', f);
                                var monthOption = $(
                                    '<a href="#" class="month-option" data-musim="' +
                                    musim + '" data-month="' + splitMonth[1] +
                                    '"><span>' + month_name +
                                    '</span><i class="fa fa-angle-right"></i></a>');
                                // console.log(monthOption);
                                menuBulan.append(monthOption);
                            });
                            $('.month-option').attr('data-musim', musim)
                        })
                        .catch(error => {
                            // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                            console.error("Error getting city and country: ", error);
                        });
                })
                .catch(error => {
                    // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                    console.error("Error getting city and country: ", error);
                });
        });
        $(document).on('click', '.month-option', function(event) {
            event.preventDefault()

            var month = $(this).data('month');
            var musim = $(this).data('musim');


            var seasonApi = "<?php echo base_url() . 'jamaah/home/getMonthPackage?musim=';?>" + musim +
                "&month=" + month;
            fetch(seasonApi)
                .then(response => response.json())
                .then(data => {
                    $('#menu-bulan').removeClass('menu-active');
                    $('.menu-hider').removeClass('menu-active');
                    $('.paket_musim').addClass('d-none');

                    data.forEach(function(pkt) {
                        $('#paket' + pkt.id_paket).removeClass('d-none');
                        $('#paket' + pkt.id_paket).addClass('d-block')
                    });
                    $('.season-option').attr('data-month', month)
                })
                .catch(error => {
                    // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                    console.error("Error getting city and country: ", error);
                });
        });

        // document.querySelector('.menu-hider').classList.add('menu-active');


        function updateTimes() {
            moment.tz.add([
                "Asia/Jakarta|LMT BMT +0720 +0730 +09 +08 WIB|-77.c -77.c -7k -7u -90 -80 -70|012343536|-49jH7.c 2hiLL.c luM0 mPzO 8vWu 6kpu 4PXu xhcu|31e6",
                "Asia/Riyadh|LMT +03|-36.Q -30|01|-TvD6.Q|57e5",
            ]);
            const jakartaTime = moment().tz("Asia/Jakarta").format("HH:mm");
            const riyadhTime = moment().tz("Asia/Riyadh").format("HH:mm");
            const jakartaDate = moment().tz("Asia/Jakarta").locale('id').format("ll");
            const riyadhDate = moment().tz("Asia/Riyadh").locale('id').format("ll");

            $("#jakarta").text(jakartaTime);
            $("#riyadh").text(riyadhTime);
            $("#jkt_date").text(jakartaDate);
            $("#riyadh_date").text(riyadhDate);
        }

        setInterval(updateTimes, 1000);

        updateTimes();
    });
    </script>
    <script>
    var firebaseConfig = {
        apiKey: "AIzaSyB-6_F42LEc7yhYxrtwIbVM3YSGMpCO8cU",
        authDomain: "my-app-bd747.firebaseapp.com",
        projectId: "my-app-bd747",
        storageBucket: "my-app-bd747.appspot.com",
        messagingSenderId: "1049171222616",
        appId: "1:1049171222616:web:c39c8d86bb9dba8a04ea2d",
        measurementId: "G-LTP6XBLHHH"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function() {
            console.log("Notification permission granted.");
            // get the token in the form of promise
            return messaging.getToken()
        })
        .then(function(token) {
            $.getJSON("<?php echo base_url() . 'call_notification/getToken'; ?>", {
                    token: token,
                    id: null,
                    user: null
                }).done(function(json) {
                    console.log('Berhasil tambah token');
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.log('Token Sudah ada');
                });
            console.log("Device token is : " + token)
        })
        .catch(function(err) {
            // ErrElem.innerHTML = ErrElem.innerHTML + "; " + err
            console.log("Unable to get permission to notify.", err);
        });
    </script>
</body>