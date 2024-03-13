<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <style>
    #pageContent {
        background-image: url(<?php echo base_url() . 'asset/appkit/images/background-1.jpg'?>);
        background-size: cover;
        background-repeat: no-repeat;
        position: relative;
        background-attachment: fixed;
        /* Efek parallax */
        overflow: hidden;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        /* Ubah nilai alpha untuk mengatur kecerahan overlay */
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader" aria-hidden="true">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <div class="header header-fixed header-logo-center header-auto-show">
            <a href="index.html" aria-label="For Subscribe" class="header-title">Subscriptions</a>
            <a href="#" aria-label="To go back" data-back-button class="header-icon header-icon-1"><i
                    class="fas fa-chevron-left"></i></a>
            <a href="#" aria-label="To go home" data-menu="menu-main" class="header-icon header-icon-4"><i
                    class="fas fa-bars"></i></a>
            <a href="#" aria-label="For show on theme dark" data-toggle-theme
                class="header-icon header-icon-3 show-on-theme-dark"><i class="fas fa-sun"></i></a>
            <a href="#" aria-label="For show on theme light" data-toggle-theme
                class="header-icon header-icon-3 show-on-theme-light"><i class="fas fa-moon"></i></a>
        </div>


        <div class="page-content pb-0" aria-hidden="true">
            <div class="card rounded-0" id="pageContent" data-card-height="cover-full">
                <div class="overlay"></div>
                <div class="card-center text-center ps-3">
                    <h1 class="font-40 font-800 mb-n1 color-white">Hi<span
                            class="gradient-blue p-2 mx-1 color-black scale-box d-inline-block rounded-s border-0">Trip</span>
                    </h1>
                    <div class="splide single-slider slider-no-arrows slider-no-dots" id="single-slider-1">
                        <div class="splide__track">
                            <div class="splide__list">
                                <div class="splide__slide">
                                    <h5 class="opacity-30 pt-1 color-white">Powered by Enabled.</h5>
                                    <h4 class="boxed-text-xl pt-4 line-height-l color-white"> Gorgeous Mobile PWA with
                                        the Most
                                        Powerful Features on Envato Market</h4>
                                </div>
                                <div class="splide__slide">
                                    <h5 class="opacity-30 pt-1 color-white">PWA Ready</h5>
                                    <h4 class="boxed-text-xl pt-4 line-height-l color-white"> Add it to your home screen
                                        <br> and
                                        enjoy it like native app.
                                    </h4>
                                </div>
                                <div class="splide__slide">
                                    <h5 class="opacity-30 pt-1 color-white">Dark Mode Ready</h5>
                                    <h4 class="boxed-text-xl pt-4 line-height-l color-white"> Looks absolutely gorgeous
                                        on <br> your
                                        fancy mobile screen.</h4>
                                </div>
                                <div class="splide__slide">
                                    <h5 class="opacity-30 pt-1 color-white">RTL Out of the Box</h5>
                                    <h4 class="boxed-text-xl pt-4 line-height-l color-white"> Great for multiple
                                        languages <br>
                                        without extra hassle and stress.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo base_url() . 'jamaah/splash/end' ;?>" data-back-button
                        class="btn btn-center-l gradient-blue rounded-sm btn-l font-13 font-600 mt-5 scale-box">Get
                        Started</a>
                    <p class="font-10 line-height-s mt-4 color-white">
                        You can reduce the speed of the slider. <br> This is just for demo purposes
                    </p>
                </div>
            </div>

        </div>
        <!-- Page content ends here-->

    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
</body>