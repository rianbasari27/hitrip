<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-head {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/banner.jpg");
    }

    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/transit kecil.jpg");
    }

    .bg-7 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/pembekalan kecil.jpg");
    }

    .bg-8 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/katering kecil.jpg");
    }

    .bg-9 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/pendampingan kecil.jpg");
    }

    .bg-10 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/manasik.jpeg");
    }

    .bg-11 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/manasik_2.jpeg");
    }

    .bg-12 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/katering_2.jpeg");
    }

    .bg-13 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/katering_3.jpeg");
    }

    .bg-14 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/bandara.jpg");
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
        <div class="card card-fixed mb-n5" data-card-height="420">
            <div class="card rounded-0 bg-head" data-card-height="450">
                <div class="card-bottom px-3 pb-2">
                    <h1 class="color-white font-28 mb-0">
                        PT. Ventura Semesta Wisata
                    </h1>
                    <p class="color-white font-12 opacity-80">
                    </p>
                </div>
                <div class="card-top mt-3 pb-5 ps-3">
                    <a href="#" data-back-button class="icon icon-s bg-theme rounded-xl float-start me-3"><i
                            class="fa color-theme fa-arrow-left"></i></a>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>
        </div>
        <div class="card card-clear" data-card-height="400"></div>


        <div class="page-content pb-3">

            <div class="card card-full rounded-m pb-4">
                <div class="drag-line"></div>

                <div class="content pb-5">

                    <p class="color-highlight font-600 mb-n1">PT. Ventura Semesta Wisata</p>
                    <h1>Apa itu Ventour?</h1>
                    <p>
                        adalah badan perjalanan wisata yang mengedepankan pelayanan yang terbaik,
                        fasilitas yang sangat baik dan program-program yang berkualitas sehingga perjalanan Anda lebih
                        bermakna. <br>
                        Sesuai dengan Tagline kami “ Pergi Umrah Tanpa menunggu Lama”, Ventour menjaga amanah untuk
                        membantu umat muslim seluruh indonesia agar dapat menjalankan ibadah dengan baik dan lancar.
                    </p>

                    <div class="divider"></div>

                    <h1>Layanan Unggulan</h1>
                    <p>
                        Berbeda dengan kebanyakan layanan agen perjalanan dan umroh sekelasnya, Ventour begitu
                        memperhatikan detil kebutuhan calon jamaah umroh dan peserta tur wisatanya. Customer service
                        Ventour juga siap sedia membantu kliennya dalam memenuhi persyaratan perjalanan ibadah umroh
                        atau tur wisatanya. Kelengkapan administratif dan ketepatan waktu pengurusan sangat diperhatikan
                        untuk meminimalisir kesalahan, keterlambatan dan kegagalan pemberangkatan.
                    </p>
                    <h3 class="color-highlight font-600 mb-1">Layanan Integratif Menyeluruh</h3>

                    <div class="d-flex">
                        <div class="me-3">
                            <a class="col mb-4" data-gallery="gallery-1"
                                href="<?php echo base_url(); ?>asset/appkit/images/ventour/dokumen kecil.jpg">
                                <img width="120" class="fluid-img rounded-m shadow-xl"
                                    src="<?php echo base_url(); ?>asset/appkit/images/ventour/dokumen kecil.jpg">
                            </a>
                        </div>
                        <div>
                            <h2>Dokumen</h2>
                            <p class="mt-2">
                                Calon jamaah Umroh akan senantiasa
                                diingatkan terkait keperluan administratif, baik pengadaan paspor, pengurusan visa dan
                                kelengkapan lainnya
                            </p>
                        </div>
                    </div>
                    <div class="divider mt-4"></div>
                    <div class="d-flex mb-4">
                        <div>
                            <h2>Keberangkatan</h2>
                            <p class="mt-2">
                                Tersedianya pilihan waktu keberangkatan yang
                                fleksibel dengan tingkat keberangkatan yang pasti.
                            </p>
                        </div>
                        <div class="ms-3">
                            <a class="col mb-4" data-gallery="gallery-1"
                                href="<?php echo base_url(); ?>asset/appkit/images/ventour/keberangkatan kecil.jpg">
                                <img width="120" class="fluid-img rounded-m shadow-xl"
                                    src="<?php echo base_url(); ?>asset/appkit/images/ventour/keberangkatan kecil.jpg">
                            </a>
                        </div>
                    </div>

                    <div class="divider"></div>
                    <h1>Transit</h1>
                    <p>
                        Fasilitas transit di Lounge bandara khususnya bagi peserta paket umroh ini, juga
                        merupakan keistimewaan yang diberikan Ventour. Selain pembekalan, di lounge ini jamaah
                        juga dijamu dengan ‘makan berat’ sebelum pesawat tinggal landas menuju tanah suci, agar
                        jamaah lebih siap secara fisik selama perjalanan.
                    </p>
                    <div class="card card-style mx-n3 rounded-0 bg-6" data-card-height="250">
                        <div class="card-center text-end me-3">
                            <h1 class="color-white font-900 font-34 mb-n2">Transit</h1>
                        </div>
                    </div>
                    <div class="divider"></div>

                    <p class="color-highlight font-600 mb-n1">Interact with your Users</p>
                    <h1>Pembekalan</h1>
                    <p>
                        Pembekalan, yang tidak hanya diberikan secara menyeluruh saat manasik umroh maupun
                        pendaftaran tur wisata, namun hingga di lounge Bandara Soekarno-Hatta, untuk memastikan
                        jamaah mengerti dan memahami perjalanan ibadahnya.
                    </p>
                    <div class="divider"></div>
                    <h1>Katering</h1>
                    <p>
                        Katering citarasa nusantara bagi peserta umroh reguler. Keistimewaannya, masakan yang
                        dihidangkan merupakan makanan olahan chef Indonesia, dengan citarasa lidah negeri asal
                        dan kenikmatan yang teruji, sehingga jamaah tidak merasa asing dalam menikmati hidangan
                        selama menunaikan ibadah umroh.
                    </p>
                    <div class="divider"></div>
                    <h1>Pendampingan</h1>
                    <p>
                        Pendampingan yang dilakukan secara kontinyu, untuk memastikan peserta tur dan calon
                        jamaah umroh mendapatkan layanan terbaik, sekaligus memastikan kebutuhan perjalanan
                        klien telah lengkap.
                    </p>
                    <div class="divider"></div>

                    <p class="color-highlight font-600 mb-n1">Show off Media</p>
                    <h1>Ventour Galleri</h1>
                    <div class="row mb-0">
                        <div class="col-6 pe-0">
                            <a class="card mx-0 mb-3 card-style default-link bg-7" data-card-height="410"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/ventour/pembekalan kecil.jpg">
                                <div class="card-bottom">
                                    <h3 class="color-white text-center mb-n1">Pembekalan</h3>
                                    <p class="color-white text-center opacity-50 pb-3 font-14">
                                    </p>
                                </div>
                                <div class="card-overlay bg-gradient"></div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a class="card mx-0 mb-2 card-style default-link bg-10" data-card-height="130"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/pictures/default/manasik.jpeg"></a>
                            <a class="card mx-0 mb-2 card-style default-link bg-11" data-card-height="130"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/pictures/default/manasik_2.jpeg"></a>
                            <a class="card mx-0 mb-2 card-style default-link bg-12" data-card-height="130"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/pictures/default/katering_2.jpeg"></a>
                        </div>
                        <div class="col-12">
                            <a class="card mx-0 mb-2 card-style default-link bg-8" data-card-height="250"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/ventour/katering kecil.jpg">
                                <h1 class="card-bottom color-white text-center mb-0 font-italic">Katering</h1>
                                <div class="card-overlay bg-gradient"></div>
                            </a>
                        </div>
                        <div class="col-5">
                            <a class="card mx-0 mb-2 card-style default-link bg-13" data-card-height="130"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/pictures/default/katering_3.jpeg"></a>
                            <a class="card mx-0 mb-2 card-style default-link bg-14" data-card-height="130"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/pictures/default/bandara.jpg"></a>
                        </div>
                        <div class=" col-7 ps-0">
                            <a class="card mx-0 card-style default-link bg-9" data-card-height="270"
                                data-gallery="gallery-b"
                                href="<?php echo base_url(); ?>asset/appkit/images/ventour/pendampingan kecil.jpg">
                                <div class="card-bottom">
                                    <h2 class="color-white text-center mb-n1">Pendampingan</h2>
                                    <p class="color-white text-center opacity-50 pb-3">
                                    </p>
                                </div>
                                <div class="card-overlay bg-gradient"></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('jamaah/include/footer'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-profile"></div>

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