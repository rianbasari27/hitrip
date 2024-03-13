<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body class="theme-light">

    <div id="preloader">
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


        <div class="page-content pb-0">


            <div class="splide single-slider slider-no-arrows slider-no-dots" id="single-slider-1"
                data-splide='{"autoplay":false}'>
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div class="card rounded-0" data-card-height="cover-full">
                                <div class="card-top text-center mt-5">
                                    <h1 class="font-18 font-700 color-highlight mb-n1">Say Hello to</h1>
                                    <h1 class="font-40 font-800 pb-4">AppKit</h1>
                                    <h4 class="opacity-60 mb-4 pb-4">Explore endless possibilties <br> like never seen
                                        before on Mobile.</h4>
                                    <h1 class="text-center"><img src="images/undraw/a.svg" class="mx-auto" width="240">
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card rounded-0" data-card-height="cover-full">
                                <div class="card-top text-center  mt-5">
                                    <h1 class="font-18 font-700 color-highlight mb-n1">Appkit Is</h1>
                                    <h1 class="font-34 font-800 pb-4">PWA Ready</h1>
                                    <h4 class="opacity-60 mb-4 pb-4">Add it to your Home Screen <br> Use it like a
                                        Native Application.</h4>
                                    <h1 class="text-center"><img src="images/undraw/b.svg" class="mx-auto" width="180">
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card rounded-0" data-card-height="cover-full">
                                <div class="card-top text-center  mt-5">
                                    <h1 class="font-18 font-700 color-highlight mb-n1">Lights off with</h1>
                                    <h1 class="font-34 font-800 pb-4">Dark Mode</h1>
                                    <h4 class="opacity-60 mb-4 pb-4">Add it to your Home Screen <br> Use it like a
                                        Native Application.</h4>
                                    <h1 class="text-center"><img src="images/undraw/c.svg" class="mx-auto" width="250">
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card rounded-0" data-card-height="cover-full">
                                <div class="card-top text-center  mt-5">
                                    <h1 class="font-18 font-700 color-highlight mb-n1">Familiar Code</h1>
                                    <h1 class="font-34 font-800 pb-4">Bootstrap</h1>
                                    <h4 class="opacity-60 mb-4 pb-4">Code you understand <br> made easy to customise.
                                    </h4>
                                    <h1 class="text-center"><img src="images/undraw/d.svg" class="mx-auto" width="250">
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card rounded-0" data-card-height="cover-full">
                                <div class="card-top text-center  mt-5">
                                    <h1 class="font-18 font-700 color-highlight mb-n1">Go Mobile Today</h1>
                                    <h1 class="font-34 font-800 pb-4">With Appkit</h1>
                                    <h4 class="opacity-60 mb-4 pb-4">It's the Best Mobile <br> Website on Envato Market.
                                    </h4>
                                    <h1 class="text-center"><img src="images/undraw/e.svg" class="mx-auto" width="300">
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="slider-bottom-button mb-4">
                <a href="<?php echo base_url() . 'jamaah/splash/end/home' ;?>" aria-label="For go to page Home"
                    data-back-button
                    class="btn btn-m btn-full ms-5 me-5 rounded-sm border-0 gradient-highlight font-600 font-13 mt-5 scale-box">Get
                    Started</a>
                <a href="<?php echo base_url() . 'jamaah/splash/end/login' ;?>" aria-label="For go to page Login"
                    data-back-button
                    class="btn btn-m btn-full ms-5 me-5 rounded-sm border-highlight color-highlight font-600 font-13 mt-3">Login</a>
            </div>



        </div>
        <!-- Page content ends here-->


    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
</body>