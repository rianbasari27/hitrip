<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
    .floating-button {
        position: fixed;
        bottom: 80px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        text-align: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }

    .floating-button a {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        color: #fff;
        font-size: 24px;
        text-decoration: none;
    }

    .squircle-icon {
        width: 50px;
        height: 50px;
        border-radius: 35%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .page-content {
        transform: none !important;
    }

    @media only screen and (min-width:600px) {
        .floating-button {
            right: calc((100% - 600px) / 2 + 20px);
        }
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

            <!-- Timezone Section -->
            <!-- <div class="content my-0 mx-4">
            <div id="timeInfo" class="text-center d-flex justify-content-between mb-2">
                <p class="mb-0">Zona waktu Anda: </p>
                <div class="font-700">
                    <i class="fa-solid fa-clock me-1 color-highlight"></i><span id="formattedTime"
                    class="color-highlight"></span> | <span id="zoneName" class="font-500"></span>
                </div>
            </div>
        </div> -->
            <!-- End Timezone Section -->

            <!-- Promo Section -->
            <?php if ($promo) { ?>
            <?php if (count($promo) > 1) { ?>
            <div class="splide single-slider slider-no-arrows visible-slider slider-no-dots" id="single-slider-1">
                <div class="splide__track">
                    <div class="splide__list">
                        <?php foreach ($promo as $prm) { ?>
                        <div class="splide__slide">
                            <div class="card card-style ms-3"
                                style="background-image:url(<?php echo base_url() . $prm->banner_promo ?>);"
                                data-card-height="200">
                                <div class="card-bottom px-3 py-3">
                                    <a href="<?php echo base_url() . 'jamaah/home/promo?id=' . $prm->id_diskon; ?>"
                                        aria-label="Click for Explore"
                                        class="bg-white color-black rounded-sm btn btn-xs float-start font-700 font-12">Ambil
                                        Promo</a>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } else { ?>
            <?php foreach ($promo as $prm) { ?>
            <div class="card card-style ms-3"
                style="background-image:url('<?php echo base_url() . $prm->banner_promo ?>');" data-card-height="170">
                <div class="card-bottom px-3 py-3">
                    <a href="<?php echo base_url() . 'jamaah/home/promo?id=' . $prm->id_diskon; ?>"
                        aria-label="Click for Explore"
                        class="bg-white color-black rounded-sm btn btn-xs float-start font-700 font-12">Ambil Promo</a>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <!-- End Promo Section -->

            <!-- Search Section -->
            <div class="content mt-0 mb-4">
                <div class="search-box search-dark bg-theme rounded-sm bottom-0">
                    <i class="fa fa-search ms-1"></i>
                    <input type="text" class="border-0" placeholder="Searching for something? Try 'dubai'" data-search>
                </div>
                <div class="search-results disabled-search-list">
                    <div>
                        <?php if ($paket != null) { ?>
                        <?php foreach ($paket as $pkt) { ?>
                        <a href="<?php echo base_url() . 'jamaah/detail_paket?id=' . $pkt->id_paket ?>"
                            class="card card-style my-3" aria-label="<?php echo $pkt->nama_paket ?>" data-filter-item
                            data-filter-name="<?php echo strtolower($pkt->nama_paket . ' ' . $pkt->negara) ?>">
                            <div class="d-flex content">
                                <div class="align-self-center">
                                    <img src="<?php echo base_url() . ($pkt->banner_image != null ? $pkt->banner_image : 'asset/appkit/images/default-banner-image.jpg') ?>"
                                        alt="" class="rounded-s me-3" width="80">
                                </div>
                                <div class="align-self-center">
                                    <h2 class="font-16 font-700 mb-1 line-height-s mt-1"><?php echo $pkt->nama_paket ?>
                                    </h2>
                                    <?php if ($pkt->default_diskon != 0) { ?>
                                    <del style="text-decoration:line-through; color: grey;">
                                        <span class="d-block mt-1"><?php echo $pkt->hargaPretty ?></span>
                                    </del>
                                    <h6 class="font-14 color-highlight"><?php echo $pkt->hargaPrettyDiskon ?></h6>
                                    <?php } else { ?>
                                    <h6 class="font-14 color-highlight mt-2"><?php echo $pkt->hargaPretty ?></h6>
                                    <?php } ?>
                                </div>
                                <div class="ms-auto ps-3 align-self-center text-center">
                                </div>
                            </div>
                        </a>
                        <?php } ?>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="search-no-results disabled mt-4">
                <div class="card card-style">
                    <div class="content">
                        <h1>Oops!</h1>
                        <p>
                            Paket yang Anda cari tidak ditemukan. Coba untuk menggunakan keyword lain.
                        </p>
                    </div>
                </div>
            </div>
            <!-- End Search Section -->

            <!-- Menu Section -->
            <div class="content">
                <div class="row mb-0">
                    <a href="<?php echo base_url() ?>jamaah/trip" class="col-3 py-2 mb-2 text-center">
                        <div class="squircle-icon gradient-highlight shadow mx-auto">
                            <i class="fa-solid fa-umbrella-beach icon font-20 color-white"></i>
                        </div>
                        <div class="lh-sm mt-2 font-11 color-theme">Trip</div>
                    </a>
                    <a href="<?php echo base_url() ?>jamaah/voucher" class="col-3 py-2 mb-2 text-center">
                        <div class="squircle-icon gradient-highlight shadow mx-auto">
                            <i class="fa-solid fa-ticket icon font-20 color-white"></i>
                        </div>
                        <div class="lh-sm mt-2 font-11 color-theme">Voucher</div>
                    </a>
                    <a href="<?php echo base_url() . 'features' ;?>" class="col-3 py-2 mb-2 text-center">
                        <div class="squircle-icon gradient-highlight shadow mx-auto">
                            <i class="fa-solid fa-bell icon font-20 color-white"></i>
                        </div>
                        <div class="lh-sm mt-2 font-11 color-theme">Notifikasi</div>
                    </a>
                    <a href="#" class="col-3 py-2 mb-2 text-center" data-menu="menu-other">
                        <div class="squircle-icon gradient-highlight shadow mx-auto">
                            <i class="fa-solid fa-ellipsis icon font-20 color-white"></i>
                        </div>
                        <div class="lh-sm mt-2 font-11 color-theme">Lainnya</div>
                    </a>
                </div>
            </div>
            <!-- End Menu Section -->

            <div class="content mt-0 mb-n1">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-16">Paket Terbaru</h1>
                    </div>
                    <div class="ms-auto align-self-center">
                        <a href="<?php echo base_url() ?>jamaah/trip" aria-label="Click for See All Products"
                            class="float-end font-12 font-400">Lihat semua</a>
                    </div>
                </div>
            </div>

            <?php if (!empty($paket_terbaru)) { ?>
            <?php if (count($paket_terbaru) >= 3) { ?>
            <div class="splide double-slider visible-slider slider-no-arrows slider-no-dots ps-2" id="double-slider-1">
                <div class="splide__track">
                    <div class="splide__list">
                        <?php foreach ($paket_terbaru as $p) { ?>
                        <div class="splide__slide">
                            <a href="<?php echo base_url() . 'jamaah/detail_paket?id=' . $p->id_paket ?>"
                                class="card m-2 mb-1 card-style">
                                <img src="<?php echo base_url() . ($p->banner_image != null ? $p->banner_image : 'asset/appkit/images/default-banner-image.jpg') ?>"
                                    class="img-fluid" alt="">
                                <div class="p-2 bg-theme rounded-sm">
                                    <!-- <div class="mb-n1">
                                        <?php for ($i = 1; $i <= $p->star; $i++) { ?>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <?php } ?>
                                        <?php for ($i = 1; $i <= (5 - $p->star); $i++) { ?>
                                        <i class="fa-solid fa-star color-gray-dark"></i>
                                        <?php } ?>
                                    </div> -->
                                    <h4 class="font-15 pt-1 line-height-s pb-0 mb-0"><?php echo $p->nama_paket ?></h4>
                                    <!-- <span class="font-10 mb-0">7 Nights - All Inclusive</span> -->
                                    <?php if ($p->default_diskon != 0) { ?>
                                    <del style="text-decoration:line-through; color: grey;">
                                        <span class="d-block mt-1 font-12"><?php echo $p->hargaPretty ?></span>
                                    </del>
                                    <h6 class="font-13 color-highlight"><?php echo $p->hargaPrettyDiskon ?></h6>
                                    <?php } else { ?>
                                    <h6 class="font-13 color-highlight mt-2"><?php echo $p->hargaPretty ?></h6>
                                    <?php } ?>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } else { ?>
            <div class="row">
                <?php foreach ($paket_terbaru as $p) { ?>
                <div class="col-md-6">
                    <a href="<?php echo base_url() . 'jamaah/detail_paket?id=' . $p->id_paket ?>"
                        class="card m-2 mb-1 card-style">
                        <img src="<?php echo base_url() . ($p->banner_image != null ? $p->banner_image : 'asset/appkit/images/default-banner-image.jpg') ?>"
                            class="card-img-top" alt="">
                        <div class="card-body bg-theme rounded-sm">
                            <!-- <div class="mb-n1">
                                <?php for ($i = 1; $i <= $p->star; $i++) { ?>
                                <i class="fa-solid fa-star color-yellow-dark"></i>
                                <?php } ?>
                                <?php for ($i = 1; $i <= (5 - $p->star); $i++) { ?>
                                <i class="fa-solid fa-star color-gray-dark"></i>
                                <?php } ?>
                            </div> -->
                            <h4 class="card-title font-16 pt-1 line-height-s pb-0 mb-n1"><?php echo $p->nama_paket ?>
                            </h4>
                            <!-- <span class="font-10 mb-0">7 Nights - All Inclusive</span> -->
                            <?php if ($p->default_diskon != 0) { ?>
                            <del style="text-decoration:line-through; color: grey;">
                                <span class="d-block mt-1"><?php echo $p->hargaPretty ?></span>
                            </del>
                            <h6 class="card-subtitle font-14 color-highlight"><?php echo $p->hargaPrettyDiskon ?></h6>
                            <?php } else { ?>
                            <h6 class="card-subtitle font-14 color-highlight mt-2"><?php echo $p->hargaPretty ?></h6>
                            <?php } ?>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
            <?php } else { ?>
            <div class="card card-style">
                <div class="content text-center">
                    <h5 class="font-14">Paket belum tersedia.</h5>
                </div>
            </div>
            <?php } ?>

            <?php if ($category != null) { ?>
            <div class="content mb-n1">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-16">Discover</h1>
                    </div>
                    <div class="ms-auto align-self-center">
                        <a href="<?php echo base_url() ?>jamaah/discover" aria-label="Click for See All Products"
                            class="float-end font-12 font-400">Lihat
                            semua</a>
                    </div>
                </div>
                <div class="row mb-n4">
                    <?php $no = 0; foreach ($category as $a) { $no++ ?>
                    <a href="<?php echo base_url() . 'jamaah/discover/list_area?area=' . $a->kategori ?>"
                        class="col-6 mb-2 pe-1">
                        <div class="card card-style mx-0 mb-2"
                            style="background-image: url(<?php echo base_url() . ($no != 1 ? 'asset/appkit/images/banner-hajj.jpg' : 'asset/appkit/images/banner-umroh.jpg') ?>);"
                            data-card-height="150">
                            <div class="card-bottom p-3">
                                <h2 class="color-white"><?php echo $a->kategori ?></h2>
                            </div>
                            <div class="card-overlay bg-gradient opacity-10"></div>
                            <div class="card-overlay bg-gradient"></div>
                        </div>
                    </a>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>

            <!-- <div class="content mb-n1">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-16">Kunjungi lagi</h1>
                    </div>
                    <div class="ms-auto align-self-center">
                        <a href="#" aria-label="Click for See All Products" class="float-end font-12 font-400">Lihat semua</a>
                    </div>
                </div>
            </div> -->

            <!-- <div class="splide double-slider visible-slider slider-no-arrows slider-no-dots ps-2" id="double-slider-3">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l"
                                style="background-image:url(<?php echo base_url() ?>asset/images/city/istanbul-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Istanbul</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l"
                                style="background-image:url(<?php echo base_url() ?>asset/images/city/tokyo-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Tokyo</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l"
                                style="background-image:url(<?php echo base_url() ?>asset/images/city/london-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">London</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l"
                                style="background-image:url(<?php echo base_url() ?>asset/images/city/bali-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Bali</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l"
                                style="background-image:url(<?php echo base_url() ?>asset/images/city/dubai-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Dubai</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="floating-button gradient-highlight">
                <a href="https://wa.me/628881224549?text=Halo,%20Hi-Trip!" target="_blank">
                    <i class="fa-solid fa-headset"></i>
                </a>
            </div>

            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
            <?php $this->load->view('jamaah/include/toast'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Added to Bookmarks Menu-->
        <div id="menu-heart" class="menu menu-box-modal rounded-m" data-menu-hide="1000" data-menu-width="250"
            data-menu-height="170">

            <h1 class="text-center mt-3 pt-2">
                <i class="fa fa-heart color-red-dark fa-3x scale-icon"></i>
            </h1>
            <h3 class="text-center pt-2">Saved to Favorites</h3>
        </div>

        <div id="menu-other" class="menu menu-box-bottom rounded-m bg-theme" data-menu-height="400"
            data-menu-effect="menu-over">
            <div class="menu-title">
                <p class="color-highlight">Menu</p>
                <h1>Lainnya</h1>
                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            </div>
            <div class="content">
                <div class="list-group list-custom-small list-menu ms-0 me-2 mb-4">
                    <a href="<?php echo base_url() ?>jamaah/trip">
                        <i class="fa-solid fa-umbrella-beach gradient-highlight color-white"></i>
                        <span>Trip</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <!-- <a href="#">
                        <i class="fa-solid fa-percent gradient-highlight color-white"></i>
                        <span>Promo</span>
                        <i class="fa fa-angle-right"></i>
                    </a> -->
                    <a href="<?php echo base_url() ?>jamaah/voucher">
                        <i class="fa-solid fa-ticket gradient-highlight color-white"></i>
                        <span>Voucher</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="#">
                        <i class="fa-solid fa-bell gradient-highlight color-white"></i>
                        <span>Notifikasi</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <!-- <a href="#">
                        <i class="fa-solid fa-money-bill-wave gradient-highlight color-white"></i>
                        <span>Currency</span>
                        <i class="fa fa-angle-right"></i>
                    </a> -->
                    <!-- <a href="#">
                        <i class="fa-solid fa-utensils gradient-highlight color-white"></i>
                        <span>Restoran Terdekat</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="#">
                        <i class="fa-solid fa-hotel gradient-highlight color-white"></i>
                        <span>Hotel Terdekat</span>
                        <i class="fa fa-angle-right"></i>
                    </a> -->
                    <a href="<?php echo base_url() . 'jamaah/discover'?>">
                        <i class="fa-solid fa-compass gradient-highlight color-white"></i>
                        <span>Discover</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="<?php echo base_url() . 'features/jadwal_solat' ?>">
                        <i class="fa-solid fa-star-and-crescent gradient-highlight color-white"></i>
                        <span>Jadwal Sholat</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <a href="<?php echo base_url() . "features/list_surat" ;?>">
                        <i class="fa-solid fa-star-and-crescent gradient-highlight color-white"></i>
                        <span>Al Quran</span>
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <!-- <a href="#">
                        <i class="fa-solid fa-location-arrow gradient-highlight color-white"></i>
                        <span>Arah Kiblat</span>
                        <i class="fa fa-angle-right"></i>
                    </a> -->
                    <!-- <a href="#">
                        <i class="fa-solid fa-mosque gradient-highlight color-white"></i>
                        <span>Tempat Ibadah</span>
                        <i class="fa fa-angle-right"></i>
                    </a> -->
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

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
    <script type="text/javascript">
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
            $.getJSON("<?php echo base_url() . 'features/getToken'; ?>", {
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

    // Fungsi untuk memperbarui waktu dan mendapatkan latitude serta longitude
    function updateTimeAndLocation() {
        // Mendefinisikan URL API TimezoneDB
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var timezoneApiUrl =
                `https://timeapi.io/api/Time/current/coordinate?latitude=${latitude}&longitude=${longitude}`;

            // Memanggil navigator.geolocation.getCurrentPosition untuk mendapatkan lokasi pengguna

            // Mengirim permintaan ke API TimezoneDB dengan latitude dan longitude pengguna
            fetch(timezoneApiUrl)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    // Memeriksa apakah permintaan berhasil
                    var zoneName = data.timeZone;
                    var timeNow = data.time;


                    // Memperbarui tampilan zona waktu dan waktu terformat
                    document.getElementById("zoneName").textContent = zoneName;
                    document.getElementById("formattedTime").textContent = timeNow;
                })
                .catch(error => {
                    console.error('Terjadi kesalahan:', error);
                    // Menampilkan pesan kesalahan jika terjadi masalah dalam mengambil data waktu
                    document.getElementById("timeInfo").textContent =
                        "Gagal mendapatkan informasi zona waktu.";
                });
        }, function(error) {
            // Penanganan kesalahan jika mendapatkan lokasi gagal
            console.error("Error getting location: ", error);
            document.getElementById("timeInfo").textContent = "Gagal mendapatkan lokasi pengguna.";
        });
    }

    // Memanggil fungsi updateTimeAndLocation saat halaman dimuat
    // window.onload = function() {
    // updateTimeAndLocation();
    //     // Menetapkan pembaruan waktu setiap detik (1000 milidetik)
    //     setInterval(updateTimeAndLocation, 1000);
    // };
    </script>
</body>