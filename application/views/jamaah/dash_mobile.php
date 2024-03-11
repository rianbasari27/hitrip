<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
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

            <div class="content mt-n4 mb-4">
                <div class="search-box search-dark shadow-sm border-0 mt-4 bg-theme rounded-sm bottom-0">
                    <i class="fa fa-search ms-1"></i>
                    <input type="text" class="border-0" placeholder="Searching for something? Try 'dubai'" data-search>
                </div>
                <div class="search-results disabled-search-list">
                    <div>
                        <a href="#" data-filter-item data-filter-name="all city night life dubai party neon ">
                            <div class="d-flex mt-4">
                                <div class="align-self-center">
                                    <img src="images/travel/1s.jpg" class="rounded-m me-3" width="60">
                                </div>
                                <div class="align-self-center">
                                    <h2 class="font-15 font-600 mb-0 line-height-s mt-1">City Nights <br> Dubai Parties </h2>
                                </div>
                                <div class="ms-auto ps-3 align-self-center text-center">
                                    <span class="btn btn-xs gradient-blue text-uppercase font-600 rounded-s border-0">Book Now</span>
                                </div>
                            </div>
                        </a>
                        <a href="#" data-filter-item data-filter-name="all yoesemite park natural nature waterfall">
                            <div class="d-flex mt-4">
                                <div class="align-self-center">
                                    <img src="images/travel/6s.jpg" class="rounded-m me-3" width="60">
                                </div>
                                <div class="align-self-center">
                                    <h2 class="font-15 font-600 mb-0 line-height-s mt-1">Yosemite Natural <br>Park Expedition </h2>
                                </div>
                                <div class="ms-auto ps-3 align-self-center text-center">
                                    <span class="btn btn-xs gradient-blue text-uppercase font-600 rounded-s border-0">Book Now</span>
                                </div>
                            </div>
                        </a>
                        <a href="#" data-filter-item data-filter-name="all bali nature beauty earth wonder hike">
                            <div class="d-flex mt-4">
                                <div class="align-self-center">
                                    <img src="images/travel/7s.jpg" class="rounded-m me-3" width="60">
                                </div>
                                <div class="align-self-center">
                                    <h2 class="font-15 font-600 mb-0 line-height-s mt-1">Bali's Natural<br>Wonders Hike </h2>
                                </div>
                                <div class="ms-auto ps-3 align-self-center text-center">
                                    <span class="btn btn-xs gradient-blue text-uppercase font-600 rounded-s border-0">Book Now</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="search-no-results disabled mt-4">
                <div class="card card-style">
                    <div class="content">
                        <h1>No Results</h1>
                        <p>
                            Your search brought up no results. Try using a different keyword. Or try typying all
                            to see all items in the demo. These can be linked to anything you want.
                        </p>
                    </div>
                </div>
            </div>

            <div class="splide single-slider slider-no-arrows visible-slider slider-no-dots" id="single-slider-1">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div class="card card-style ms-3" style="background-image:url(<?php echo base_url() ?>asset/images/city/dubai-1280x720.jpg);" data-card-height="300">
                                <div class="card-top px-3 py-3">
                                    <a href="#" data-menu="menu-heart" class="bg-white rounded-sm icon icon-xs float-end"><i class="fa fa-heart color-red-dark"></i></a>
                                    <a href="#" class="bg-white color-black rounded-sm btn btn-xs float-start font-700 font-12">Explore</a>
                                </div>
                                <div class="card-bottom px-3 py-3">
                                    <h1 class="color-white" style="width: 250px;">City Nights Dubai Parties</h1>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card card-style ms-3" style="background-image:url(<?php echo base_url() ?>asset/images/city/seoul-1280x720.jpg);" data-card-height="300">
                                <div class="card-top px-3 py-3">
                                    <a href="#" data-menu="menu-heart" class="bg-white rounded-sm icon icon-xs float-end"><i class="fa fa-heart color-red-dark"></i></a>
                                    <a href="#" class="bg-white color-black rounded-sm btn btn-xs float-start font-700 font-12">Explore</a>
                                </div>
                                <div class="card-bottom px-3 py-3">
                                    <h1 class="color-white" style="width: 250px;">Seoul's Vibrant Cultural Tapestry</h1>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card card-style ms-3" style="background-image:url(<?php echo base_url() ?>asset/images/city/istanbul-1280x720.jpg);" data-card-height="300">
                                <div class="card-top px-3 py-3">
                                    <a href="#" data-menu="menu-heart" class="bg-white rounded-sm icon icon-xs float-end"><i class="fa fa-heart color-red-dark"></i></a>
                                    <a href="#" class="bg-white color-black rounded-sm btn btn-xs float-start font-700 font-12">Explore</a>
                                </div>
                                <div class="card-bottom px-3 py-3">
                                    <h1 class="color-white" style="width: 250px;">Istanbul's Historic East Meets</h1>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content mt-0 mb-n1">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-16">Suggested Travel Sposts</h1>
                    </div>
                    <div class="ms-auto align-self-center">
                        <a href="#" class="float-end font-12 font-400">See All</a>
                    </div>
                </div>
            </div>

            <div class="splide double-slider visible-slider slider-no-arrows slider-no-dots ps-2" id="double-slider-1">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div class="card m-2 mb-1 card-style">
                                <img src="<?php echo base_url() ?>asset/images/city/dubai-720x720.jpg" class="img-fluid">
                                <div class="p-2 bg-theme rounded-sm">
                                    <div class="mb-n1">
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                    </div>
                                    <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Dubai</h4>
                                    <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                </div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card m-2 mb-1 card-style">
                                <img src="<?php echo base_url() ?>asset/images/city/tokyo-720x720.jpg" class="img-fluid">
                                <div class="p-2 bg-theme rounded-sm">
                                    <div class="mb-n1">
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                    </div>
                                    <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Tokyo</h4>
                                    <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                </div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div class="card m-2 mb-1 card-style">
                                <img src="<?php echo base_url() ?>asset/images/city/bali-720x720.jpg" class="img-fluid">
                                <div class="p-2 bg-theme rounded-sm">
                                    <div class="mb-n1">
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                        <i class="fa-solid fa-star color-yellow-dark"></i>
                                    </div>
                                    <h4 class="font-17 pt-1 line-height-s pb-0 mb-n1">Bali</h4>
                                    <span class="font-10 mb-0">7 Nights - All Inclusive</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content mb-n1">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-16">Where we're going</h1>
                    </div>
                    <div class="ms-auto align-self-center">
                        <a href="#" class="float-end font-12 font-400">See All</a>
                    </div>
                </div>
                <div class="row mb-n4">
                    <div class="col-6 pe-1">
                        <div class="card card-style mx-0" style="background-image: url(<?php echo base_url() ?>asset/images/city/london-720x720.jpg);" data-card-height="350">
                            <div class="card-bottom p-3">
                                <h2 class="color-white">London</h2>
                                <p class="color-white opacity-60 line-height-s">
                                    Experience a Night Life like never before.
                                </p>
                            </div>
                            <div class="card-overlay bg-gradient opacity-10"></div>
                            <div class="card-overlay bg-gradient"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-style mx-0 mb-2" style="background-image: url(<?php echo base_url() ?>asset/images/city/bali-720x720.jpg);;" data-card-height="170">
                            <div class="card-bottom p-3">
                                <h2 class="color-white">Bali</h2>
                                <p class="color-white opacity-60 line-height-s font-12">
                                    Nature's beauty explored. Pure beauty.
                                </p>
                            </div>
                            <div class="card-overlay bg-gradient opacity-10"></div>
                            <div class="card-overlay bg-gradient"></div>
                        </div>
                        <div class="card card-style mx-0 mb-0" style="background-image: url(<?php echo base_url() ?>asset/images/city/istanbul-720x720.jpg);" data-card-height="170">
                            <div class="card-bottom p-3">
                                <h2 class="color-white">Istanbul</h2>
                                <p class="color-white opacity-60 line-height-s font-12">
                                    A natura park and wonder of the world
                                </p>
                            </div>
                            <div class="card-overlay bg-gradient opacity-10"></div>
                            <div class="card-overlay bg-gradient"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content mb-n1">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-16">Visit it Again</h1>
                    </div>
                    <div class="ms-auto align-self-center">
                        <a href="#" class="float-end font-12 font-400">See All</a>
                    </div>
                </div>
            </div>

            <div class="splide double-slider visible-slider slider-no-arrows slider-no-dots ps-2" id="double-slider-3">
                <div class="splide__track">
                    <div class="splide__list">
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l" style="background-image:url(<?php echo base_url() ?>asset/images/city/istanbul-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Istanbul</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l" style="background-image:url(<?php echo base_url() ?>asset/images/city/tokyo-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Tokyo</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l" style="background-image:url(<?php echo base_url() ?>asset/images/city/london-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">London</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l" style="background-image:url(<?php echo base_url() ?>asset/images/city/bali-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Bali</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                        <div class="splide__slide">
                            <div data-card-height="160" class="card rounded-m m-2 shadow-l" style="background-image:url(<?php echo base_url() ?>asset/images/city/dubai-720x720.jpg)">
                                <div class="card-bottom mb-2">
                                    <h5 class="color-white font-15 text-center pb-1">Dubai</h5>
                                </div>
                                <div class="card-overlay bg-gradient opacity-10"></div>
                                <div class="card-overlay bg-gradient"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Added to Bookmarks Menu-->
        <div id="menu-heart"
            class="menu menu-box-modal rounded-m"
            data-menu-hide="1000"
            data-menu-width="250"
            data-menu-height="170">

            <h1 class="text-center mt-3 pt-2">
                <i class="fa fa-heart color-red-dark fa-3x scale-icon"></i>
            </h1>
            <h3 class="text-center pt-2">Saved to Favorites</h3>
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
</body>