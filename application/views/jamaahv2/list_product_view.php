<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <style>
        .interest-check label {
            padding: 4px 10px 4px 34px !important;
        }
        .badge {
            background-color: red;
            color: white;
            padding: 4px 6px;
            border-radius: 50%;
            margin-left: 400px;
        }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/store_menu', ['product' => true, 'countCart' => $countCart]); ?>

        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style mb-0">
                <div class="content my-2">
                    <div class="d-flex">
                        <div class="align-self-center">
                            <p class="mb-n1 color-highlight font-600">Produk</p>
                            <h1 class="mb-0 font-18">Semua Produk</h1>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="accordion" id="accordion-1">
                <div class="card card-style shadow-0 bg-highlight my-3">
                    <button class="btn accordion-btn color-white no-effect" data-bs-toggle="collapse" data-bs-target="#collapse4">
                        <i class="fa fa-list me-2"></i>
                            Cari berdasarkan kategori
                        <i class="fa fa-plus font-10 accordion-icon"></i>
                    </button>

                    <div id="collapse4" class="collapse bg-theme pt-3" data-bs-parent="#accordion-2">
                        <div class="row">
                        <?php
                        $no = 0;
                        foreach ($listCategory as $c) {
                            $no++;
                        ?>
                            <div class="col-6 me-n3">
                                <div class="mx-2">
                                    <div class="form-check interest-check">
                                        <input class="form-check-input" type="checkbox" data-category="<?php echo $c->category_id; ?>" onclick="filterProducts()" value="" id="check<?php echo $no; ?>">
                                        <label class="form-check-label border color-dark-dark shadow-xl rounded-xl font-12" style="white-space: nowrap;" for="check<?php echo $no; ?>"><?php echo $c->category_name; ?></label>
                                        <i class="fa fa-check-circle mt-n1 color-white font-18"></i>
                                        <i class="fa fa-circle-plus mt-n1 font-17 color-highlight"></i>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content mb-0">
                    <!-- <div class="splide topic-slider slider-no-arrows slider-no-dots pb-2" id="topic-slider-1">
                        <div class="splide__track">
                            <div class="splide__list">
                        <?php
                        $no = 0;
                        foreach ($listCategory as $c) {
                            $no++;
                        ?>
                            <div class="splide__slide">
                                <div class="form-check interest-check">
                                    <input class="form-check-input" type="checkbox" data-category="<?php echo $c->category_id; ?>" onclick="filterProducts()" value="" id="check<?php echo $no; ?>">
                                    <label class="form-check-label shadow-xl rounded-xl" for="check<?php echo $no; ?>"><?php echo $c->category_name; ?></label>
                                    <i class="fa fa-check-circle color-white font-18"></i>
                                    <i class="fa fa-bowl-food font-17 color-red-dark"></i>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                        </div>
                    </div> -->
     
                    
                    <!-- Product Grid View-->
                    <div class="row text-center mb-0 product-container">
                        <?php foreach ($products as $key => $p) { ?>
                            <div class="col-6 mb-4 card-product" data-category="<?php echo $p->category_id ?>">
                                <?php if (!empty($p->images)) { ?>
                                    <a href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $p->product_id ?>"><img src="<?php echo base_url() . $p->images[0]->location; ?>" class="rounded-sm shadow-xl img-fluid"></a>
                                <?php } ?>
                                <a href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $p->product_id ?>" class="d-block mt-3">
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i><br>
                                    <!-- <span class="font-10 d-block mt-n1">130 Reviewers</span> -->
                                </a>
                                <a href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $p->product_id ?>">
                                    <h5 class="mt-1"><?php echo $p->product_name ?></h5>
                                    <span class="<?php echo ($p->stock_quantity > 0) ? 'color-green-dark' : 'color-red-dark' ?> font-10"><?php echo ($p->stock_quantity > 0) ? 'Stok Tersedia' : 'Stok Habis' ?></span>
                                </a>
                                <?php if ($p->discount_amount != 0) { ?>
                                    <h1 class="mt-1 mb-n2 font-800">Rp. <?php echo $p->hargaDiscountFormat ?></h1>
                                    <del style="color: red;text-decoration:line-through">
                                        <p class="mt-1 mb-0 font-600 font-14">
                                            <?php echo $p->hargaHome; ?>
                                        </p>
                                    </del>
                                <?php } else { ?>
                                    <h1 class="mt-1 mb-n2 font-800">Rp. <?php echo $p->hargaDiscountFormat ?></h1>
                                <?php } ?>
                            </div>
                        <?php } ?>

                    </div>

                </div>
            </div>
            <?php $this->load->view('jamaahv2/include/footer'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Added to Bookmarks Menu-->
        <div id="menu-heart" class="menu menu-box-modal rounded-m" data-menu-hide="1000" data-menu-width="250" data-menu-height="170">

            <h1 class="text-center mt-3 pt-2">
                <i class="fa fa-heart color-red-dark fa-3x scale-icon"></i>
            </h1>
            <h3 class="text-center pt-2">Saved to Favorites</h3>
        </div>
        <div id="menu-added" class="menu menu-box-modal rounded-m" data-menu-hide="800" data-menu-width="250" data-menu-height="170">

            <h1 class="text-center mt-3 pt-2">
                <i class="fa fa-shopping-bag color-brown-dark fa-3x"></i>
            </h1>
            <h3 class="text-center pt-2">Added to Cart</h3>
        </div>


        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <!-- Modal Cart -->

    <div id="menu-cart" class="menu menu-box-bottom rounded-m">
        <div class="menu-title">
            <p class="color-highlight">Keranjang</p>
            <h1>Keranjang Anda</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <form action="<?php echo base_url() . 'jamaah/online_store/cart_to_checkout' ?>" method="post" id="myForm">
            <div class="content mb-0 mt-n1">
                <div class="divider"></div>

                <div id="cartItems">
                    <!-- Tempatkan elemen-elemen HTML di sini menggunakan JavaScript -->
                    <!-- <a href="#" class="float-start mt-1 ms-4 font-11 color-theme font-12 hapusBtn"><i class="fa fa-trash color-red-dark me-1"></i> Remove</a> -->
                </div>
            </div>

            <div id="buttonOrder">
                <?php if ($cart != null) { ?>
                    <a href="#" onclick="submit()" id="btnOrder" class="close-menu btn-submit btn btn-margins btn-full gradient-blue font-13 btn-m font-600 mt-3 rounded-sm">Proses
                        Checkout</a>
                <?php } else { ?>
                    <h6 class="font-500 font-14 pb-2 text-center" id="textEmptyCart" style="margin-bottom: 100px;">Belum ada barang di
                        keranjang</h6>
                <?php } ?>
            </div>
        </form>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php $this->load->view('jamaahv2/include/script_view'); ?>

    <script>
        
        // var splide = document.getElementsByClassName('splide__slide');
        // for (var i = 0; i < splide.length; i++) {
        //     splide[i].style.cssText = "width: 0 !important;";
        // }
            
            $('.interest-check input[type="checkbox"]').change(filterProducts);

            function filterProducts() {
                var selectedCategories = $('.interest-check input[type="checkbox"]:checked').map(function() {
                    return $(this).data('category');
                }).get();

                var visibleProducts = 0; // Tambahkan variabel untuk menghitung jumlah produk yang terlihat

                var $productContainer = $('.product-container'); // Menambahkan kontainer produk di mana teks akan di-append

                $productContainer.find('.not-found').remove();

                $('.card-product').each(function() {
                    var productCategory = $(this).data('category');

                    if (selectedCategories.length === 0 || selectedCategories.includes(productCategory)) {
                        $(this).addClass('d-block');
                        $(this).removeClass('d-none');
                        visibleProducts++;
                    } else {
                        $(this).addClass('d-none');
                        $(this).removeClass('d-block');
                    }

                    if (!selectedCategories.length && visibleProducts > 6) {
                        $(this).addClass('d-none');
                        $(this).removeClass('d-block');
                    }
                });

                if (visibleProducts === 0) {
                    $productContainer.append('<h5 class="font-500 mb-3 not-found">Produk tidak ditemukan</h5>');
                }
            }
        // });

        document.addEventListener('DOMContentLoaded', function() {
            var elementsByClass = document.getElementsByClassName('splide__slide');
            for (var i = 0; i < elementsByClass.length; i++) {
                elementsByClass[i].removeAttribute('style');
            }
        });

    </script>

</body>