<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
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

    .no-border {
        border: 0;
    }

    .icon-alert {
        width: 80px;
        height: 80px;
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
        <?php $this->load->view('jamaah/include/footer_menu', ['trip' => true]); ?>

        <!-- header title -->
        <!-- NOT USED IN THIS PAGE -->

        <div class="card card-fixed mb-n5" data-card-height="300">
            <div class="card rounded-0 bg-20" data-card-height="300"
                style="background-image:url('<?php echo ($banner_image) ? base_url() . $banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>');">
                <!-- <div class="card-bottom px-3 pb-2 mb-4">
                    <h1 class="color-white font-28 mb-0">
                        <?php echo $nama_paket; ?>
                    </h1>
                    <p class="color-white font-12 opacity-80 mb-1">
                        <?php echo $detail_promo; ?>
                    </p>
                </div> -->
                <div class="card-top mt-3 pb-5 ps-3">
                    <a href="#" data-back-button class="icon icon-s bg-theme rounded-xl float-start me-3"><i
                            class="fa color-highlight fa-arrow-left"></i></a>
                </div>
                <!-- <div class="card-overlay bg-gradient"></div> -->
            </div>
        </div>
        <div class="card card-clear" data-card-height="280"></div>
        <div class="page-content pb-3">

            <div class="card card-full rounded-m pb-4 mb-3">
                <div class="drag-line"></div>

                <div class="content">
                    <!-- <div class="card card-style mx-0 mt-3" data-card-height="100"
                        style="background-image:url('<?php echo ($banner_image) ? base_url() . $banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>');">
                        <div class="card-center px-3 no-click">
                            <h1 class="color-white mb-n2 font-24">Daftar Sekarang</h1>
                            <h5 class="color-white mt-n1 opacity-80 font-14">Harga mulai
                                <?php echo $hargaPrettyDiskon; ?>
                        </div>
                        <div class="card-center">
                            <a href="<?php echo isset($_SESSION['id_user']) ? base_url() . 'jamaah/daftar/start?id=' . $id_paket : '#' ?>" 
                                data-menu="<?php echo isset($_SESSION['id_user']) ? '' : 'menu-option-2' ?>"
                                class="float-end mx-3 gradient-highlight btn-s rounded-sm shadow-xl text-uppercase font-800">Daftar</a>
                        </div>
                        <div class="card-overlay bg-black opacity-60"></div>
                    </div> -->

                    <!-- <div class="divider"></div> -->




                    <!-- <p class="color-highlight font-600 mb-n1">Terpercaya, Terbukti, Recommended</p> -->
                    <div class="d-flex mb-5">
                        <div>
                            <div class="mb-2">
                                <?php for ($i = 1; $i <= $star; $i++) { ?>
                                    <i class="fa-solid fa-star color-yellow-dark"></i>
                                <?php } ?>
                                <?php for ($i = 1; $i <= (5 - $star); $i++) { ?>
                                    <i class="fa-solid fa-star color-gray-dark"></i>
                                <?php } ?>
                            </div>
                                
                            <h1 class="mb-n1"><?php echo $nama_paket; ?></h1>
                            <p class="color-highlight font-500"><i class="fa-solid fa-location-dot me-1"></i><?php echo $nama_paket . ', ' . $negara ?></p>
                        </div>
                        <div class="ms-auto mt-auto">
                            <!-- <div> -->
                            <?php if ($default_diskon != 0) { ?>
                                <del style="text-decoration:line-through; color: grey;">
                                    <span class="font-16 d-block text-end"><?php echo $hargaPretty ?></span>
                                </del>
                                <h6 class="font-18 color-highlight text-end"><?php echo $hargaPrettyDiskon ?></h6>
                            <?php } else { ?>
                                <h6 class="font-18 color-highlight text-end"><?php echo $hargaPretty ?></h6>
                            <?php } ?>
                            <!-- </div> -->
                            <!-- <a href="<?php echo isset($_SESSION['id_user']) ? base_url() . 'jamaah/daftar/start?id=' . $id_paket : '#' ?>" 
                                data-menu="<?php echo isset($_SESSION['id_user']) ? '' : 'menu-option-2' ?>"
                                class="btn ms-auto mx-3 gradient-highlight btn-s rounded-sm shadow-xl text-uppercase font-800">Daftar</a> -->
                        </div>
                    </div>

                    <div class="row">
                        <?php if ($gallery != null) { ?>
                            <?php foreach ($gallery as $g) { ?>
                                <div class="col-4 mb-3">
                                    <a href="<?php echo base_url() . $g->gallery_image ?>" title="Preview <?php echo $nama_paket ?>" class="default-link" data-gallery="gallery-1">
                                        <img src="<?php echo base_url() . $g->gallery_image ?>" class="img-fluid shadow-xl rounded-sm">
                                    </a>
                                    <!-- <img src="<?php echo base_url() . $g->gallery_image ?>" class="img-fluid rounded shadow"> -->
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <?php if ($detail_promo != null) { ?>
                    <div class="detail-article mb-3">
                        <?php echo $detail_promo; ?>
                    </div>
                    <?php } ?>
                </div>
                
                <div class="card card-style card-full-left"
                    style="background-image:url(<?php echo base_url() . $banner_image; ?>)"
                    data-card-height="170">
                    <div class="card rounded-0 shadow-xl" data-card-height="cover" style="width:100px; z-index:99;">
                        <div class="card-center text-center">
                            <?php if ($lamaHari) { ?>
                            <h1 class="font-28 text-uppercase font-900 opacity-30"><?php echo $lamaHari; ?></h1>
                            <h1 class="font-24 font-900">Hari</h1>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-top ps-5 ms-5 pt-3">
                        <div class="ps-4">
                            <h1 class="color-white pt-3 pb-3">Trip Schedule </h1>
                            <p class="color-white mb-0"><i
                                    class="fa fa-plane-departure color-white pe-2 icon-30"></i>
                                <?php echo date_format(date_create($tanggal_berangkat), 'l, j F Y'); ?></p>
                            <p class="color-white mb-2"><i class="fa fa-plane-arrival color-white pe-2 icon-30"></i>
                                <?php echo date_format(date_create($tanggal_pulang), 'l, j F Y'); ?></p>
                        </div>
                    </div>
                    <div class="card-overlay bg-black opacity-70"></div>
                </div>

                <div class="content">
                    <div class="row mb-0">
                        <?php if ($itinerary != null) { ?>
                        <div class="col-3">
                            <a href="<?php echo base_url() . $itinerary; ?>" download
                                class="font-12 mb-3 py-3 text-center d-block rounded-sm shadow font-700 color-highlight bg-theme"><i
                                    class="fa-solid fa-file-lines font-24 mb-2"></i><br>Itinerary</a>
                        </div>
                        <?php } ?>
                        <?php if ( $paket_flyer != null ) { ?>
                        <div class="col-3">
                            <a href="<?php echo base_url() . $paket_flyer?>" download
                                class="font-12 mb-3 py-3 text-center d-block rounded-sm shadow font-700 color-highlight bg-theme"><i
                                    class="fa-solid fa-file-image font-24 mb-2"></i><br> Flyer</a>
                        </div>
                        <?php } ?>
                        <div class="col-3">
                            <a href="#" download
                                class="font-12 mb-3 py-3 text-center d-block rounded-sm shadow font-700 color-highlight bg-theme"><i
                                    class="fa-solid fa-hotel font-24 mb-2"></i><br> Hotel</a>
                        </div>
                        <div class="col-3">
                            <a href="#" download
                                class="font-12 mb-3 py-3 text-center d-block rounded-sm shadow font-700 color-highlight bg-theme"><i
                                    class="fa-solid fa-plane-up font-24 mb-2"></i><br> Maskapai</a>
                        </div>
                    </div>
                    <div class="divider"></div>
    

                    <?php if ($flight_schedule != null) { ?>
                    <h1 class="color-highlight font-600 mb-n1">Flight Schedule</h1>
                    <div class="detail-article mb-3">
                        <?php echo $flight_schedule; ?>
                    </div>
                    <?php } ?>


                    <a href="<?php echo isset($_SESSION['id_user']) ? base_url() . 'jamaah/daftar/start?id=' . $id_paket : '#' ?>" 
                        data-menu="<?php echo isset($_SESSION['id_user']) ? '' : 'menu-option-2' ?>"
                        class="btn mb-4 mt-3 gradient-highlight btn-l rounded-sm btn-full font-700 text-uppercase border-0">Daftar
                        Sekarang</a>

                    <!-- <p class="color-highlight font-600 mb-n1">Prioritas Kenyamanan</p>
                    <h1>Hotel</h1>
                    <p>
                        Dengan mengutamakan kenyamanan istirahat Anda, jalannya ibadah pun insya Allah akan menjadi
                        maksimal.
                    </p>
                    <div class="row mb-3">
                        <div class="col-12">
                            <?php foreach ($hotel as $htl) { ?>
                            <a class="card mx-0 mb-2 card-style default-link" data-card-height="130"
                                <?php echo ($htl->foto) ? "data-gallery='gallery-b'" : ""; ?>
                                title="<?php echo $htl->nama_hotel ?>"
                                href="<?php echo ($htl->foto) ? base_url() . $htl->foto : '#'; ?>"
                                style="background-image:url(<?php echo base_url() . $htl->foto; ?>)">
                                <div class="card-bottom mb-1">
                                    <span class="color-white text-center ms-3"><?php echo $htl->nama_hotel; ?></span>
                                </div>
                                <div class="card-bottom text-end mb-1">
                                    <div class="mt-3 me-3 color-white">
                                        <i class="fa fa-map-location-dot font-25"
                                            onclick="openMaps('<?php echo urlencode($htl->nama_hotel); ?>')"></i>
                                    </div>
                                </div>
                                <div class="card-overlay bg-gradient"></div>
                            </a>
                            <?php } ?>
                        </div>

                    </div> -->
                </div>
            </div>
        </div>
        <!-- Page content ends here-->

        <div id="menu-option-2" class="menu menu-box-modal rounded-m" 
            data-menu-height="330" 
            data-menu-width="350">
            <h1 class="text-center mt-4"><i class="fa fa-3x fa-info-circle scale-box color-blue-dark shadow-xl rounded-circle"></i></h1>
            <h3 class="text-center mt-3 font-700">Perlu login</h3>
            <p class="boxed-text-xl opacity-70">
                Untuk booking paket diperlukan login ke akun Hi-Trip Anda. Jika belum memiliki akun, silahkan <a href="<?php echo base_url() ?>jamaah/login/sign_up" class="color-highlight">daftar disini.</a>
            </p>
            <div class="row mb-0 me-3 ms-3">
                <div class="col-6">
                    <a href="#" class="btn close-menu btn-full btn-m bg-red-dark font-600 rounded-s">Batal</a>
                </div>
                <div class="col-6">
                    <a href="<?php echo base_url() ?>/jamaah/login" class="btn close-menu btn-full btn-m bg-highlight font-600 rounded-s">Login</a>
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

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <script>
    function openMaps(loc) {
        event.preventDefault();
        window.location.href = 'https://maps.google.com/?q=' + loc;
        event.stopPropagation();
    }

    function showAlert() {
      // Basic alert
      Swal.fire({
        title: "Satu langkah lagi",
        text: "Untuk mendaftar, silahkan hubungi konsultan kepercayaan Anda.",
        // icon: "<?php echo base_url() ?>asset/appkit/images/hand-holding-heart.svg",
        iconHtml: '<img src="<?php echo base_url() ?>asset/appkit/images/hand-holding-heart.png" class="icon-alert">',
        customClass: {
            icon: 'no-border icon-alert'
        },
        button: "Ok",
      });
      // Mengambil semua elemen dengan kelas "swal-button"
        var elements = document.getElementsByClassName("swal-button");

        // Iterasi melalui setiap elemen dan menambahkan kelas "bg-highlight"
        for (var i = 0; i < elements.length; i++) {
            elements[i].classList.add("bg-highlight");
        }
    }

    var imgElement = document.querySelector('img[src="<?php echo base_url() ?>/asset/appkit/images/hand-holding-heart.svg"]');
    imgElement.setAttribute('width', '40'); 
  </script>
</body>