<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-head {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/profile-utama.jpg");
    }

    .bg-1 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/layanan.jpg");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-menu -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu'); ?>
        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>


        <div class="page-content">

            <div class="card rounded-0 bg-head" data-card-height="450">
                <div class="card-bottom text-end pe-3 pb-4 mb-4">
                    <h1 class="color-white font-21 mb-n1">
                        PT Ventura Semesta Wisata
                    </h1>
                    <p class="color-white font-12">

                    </p>
                </div>
                <div class="card-top mt-3 pb-5 ps-3">
                    <a href="#" data-back-button class="icon icon-s bg-theme rounded-xl float-start me-3"><i
                            class="fa color-theme fa-arrow-left"></i></a>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <!-- margin top and margin bottom negative values repesent how much you want the article to go over the above and below image-->
            <div class="card card-style card-full-right" style="margin-top:-100px; margin-bottom:-80px; z-index:1">
                <div class="content">
                    <p class="mb-n1 color-highlight font-600">Paket Layanan Kami</p>

                    <div class="list-group list-custom-large mb-4">
                        <span class="text-dark fw-bold">Ventour menyediakan berbagai macam paket Umroh dan juga Muslim
                            Tour dengan
                            harga beragam dan juga terjangkau.</span>
                    </div>
                    <h1>
                        Paket Umrah Ventour
                    </h1>
                    <p>
                        Ventour memberikan pelayanan umroh bintang 5, Dengan destinasi utamanya yakni Mekah di
                        Masjidil Haram dan Madinah di Masjid Nabawi Raudah.
                        Bekerjasama dengan maskapai dan hotel-hotel di makkah dan madinah, VENTOUR berharap
                        dapat memberikan pelayanan terbaik agar jamaah lebih fokus dalam beribadah dengan aman
                        dan nyaman.
                    </p>

                    <h1>Paket Muslim Tour Ventour</h1>
                    <p>
                        Muslim tour ventour memberikan pengalaman berwisata islam dengan mengunjungi/berziarah
                        ke tempat-tempat bersejarah islam agar lebih memperdalam ilmu tentang islam
                        Bekerjasama dengan maskapai dan hotel-hotel di makkah dan madinah, VENTOUR berharap
                        dapat memberikan pelayanan terbaik agar jamaah lebih fokus dalam beribadah dengan aman
                        dan nyaman.
                    </p>

                    <div class="divider"></div>


                </div>
            </div>

            <div class="card rounded-0 bg-1" data-card-height="400">
                <div class="card-center">
                    <h3 class="color-white font-italic text-center font-800 font-30">UMROH|MOSLEM TOUR</h3>
                    <p class="color-white text-center mb-0">"Terpercaya, Terbukti, Recomended"</p>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <!-- margin top  negative value repesent how much you want the article to go over the above image-->
            <div class="card card-style card-full-left" style="margin-top:-100px; z-index:1">
                <div class="content">
                    <p class="mb-n1 color-highlight font-600">Dukungan Kerjasama</p>
                    <h1>
                        Kerjasama Penerbangan
                    </h1>
                    <p>
                        Ventour menjalin kerjasama dengan maskapai penerbangan yang terpercaya, dalam melayani
                        keberangkatan dan kepulangan jamaah umrohnya. Maskapai penerbangan yang mayoritas digunakan
                        diantaranya Saudia Airlines, Garuda Indonesia Emirates, Etihad dan Qatar. Namun demikian,
                        Ventour tetap terbuka dalam bekerja sama dengan maskapai penerbangan lain yang memiliki
                        kesamaan visi serta reputasi yang baik.
                    </p>

                    <div class="row text-center row-cols-3 mb-0">
                        <a class="col mb-4" data-gallery="gallery-1"
                            href="<?php echo base_url(); ?>asset/appkit/images/qatar-airways.png">
                            <img src="images/empty.png"
                                data-src="<?php echo base_url(); ?>asset/appkit/images/qatar-airways.png"
                                class="preload-img img-fluid rounded-xs" alt="img">
                        </a>
                        <a class="col mb-4" data-gallery="gallery-1"
                            href="<?php echo base_url(); ?>asset/appkit/images/saudia-airlines.png">
                            <img src="images/empty.png"
                                data-src="<?php echo base_url(); ?>asset/appkit/images/saudia-airlines.png"
                                class="preload-img img-fluid rounded-xs" alt="img">
                        </a>
                        <a class="col mb-4" data-gallery="gallery-1"
                            href="<?php echo base_url(); ?>asset/appkit/images/etihad.png">
                            <img src="images/empty.png"
                                data-src="<?php echo base_url(); ?>asset/appkit/images/etihad.png"
                                class="preload-img img-fluid rounded-xs" alt="img">
                        </a>
                    </div>


                    <h4>Kerjasama Penginapan</h4>
                    <p>
                        Sementara untuk penginapan selama di tanah suci, Ventour menggandeng 5 hotel ternama di
                        Mekah dan Madinah yaitu Hotel Ajyad Makkarim (Mekah), Hotel Olayan Ajyad (Mekkah) ,Hotel
                        Dallah Taibah (Madinah), Hotel Movenpick (Mekah), Hotel Hilton Madinah dan Royal Makarem
                        (Madinah). Kualitas layanan kepada pelanggan serta kedekatan jarak dengan lokasi-lokasi
                        tujuan umroh, menjadi pertimbangan utama Ventour dalam penentuan hotel sebagai mitra
                        kerjasama dalam penginapan.
                    </p>

                    <div class="row text-center row-cols-3 mb-0">
                        <a class="col mb-4" data-gallery="gallery-1"
                            href="<?php echo base_url(); ?>asset/appkit/images/pullman.png">
                            <img src="images/empty.png"
                                data-src="<?php echo base_url(); ?>asset/appkit/images/pullman.png"
                                class="preload-img img-fluid rounded-xs" alt="img">
                        </a>
                        <a class="col mb-4" data-gallery="gallery-1"
                            href="<?php echo base_url(); ?>asset/appkit/images/lemeridan.png">
                            <img src="images/empty.png"
                                data-src="<?php echo base_url(); ?>asset/appkit/images/lemeridan.png"
                                class="preload-img img-fluid rounded-xs" alt="img">
                        </a>
                        <a class="col mb-4" data-gallery="gallery-1"
                            href="<?php echo base_url(); ?>asset/appkit/images/diar-al-manasik.png">
                            <img src="images/empty.png"
                                data-src="<?php echo base_url(); ?>asset/appkit/images/etihad.png"
                                class="preload-img img-fluid rounded-xs" alt="img">
                        </a>
                    </div>
                </div>
            </div>

            <?php $this->load->view('jamaahv2/include/footer'); ?>
        </div>
        <!-- Page content ends here-->



        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-layanan"></div>

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