<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/bg_kuning.jpg");
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
    .badge {
        background-color: red;
        color: white;
        padding: 4px 6px;
        border-radius: 50%;
        margin-left: 400px;
    }

    .interest-slider {
        width: 100%;
        overflow-x: auto;
        white-space: nowrap;
        background-color: #ffffff; /* Mengatur warna latar belakang menjadi putih */
    }

    .interest-container {
        display: inline-block;
        vertical-align: top;
        width: 33%; /* Jumlah item per slide (dalam contoh ini, 3 item per slide) */
        white-space: normal;
        margin-right: 10px; /* Ruang antara item */
        background-color: #ffffff; /* Mengatur warna latar belakang menjadi putih */
    }

    /* Optional: Atur lebar elemen input dan label agar tetap terlihat dengan jelas */
    .interest-check input,
    .interest-check label {
        display: inline-block;
        vertical-align: middle;
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
        <?php $this->load->view('jamaahv2/include/store_menu', ['home' => true, 'countCart' => $countCart]) ?>
        <div class="page-content">
            <div class="card rounded-0 gradient-dark bg-6 mb-n5">
                <div class="card-body mt-2">
                    <h1 class="color-dark-dark font-30 float-start">Ventour <span
                            class="px-2 py-1 bg-dark-dark color-highlight rounded">Store</span></h1>
                    <a href="#" data-menu="menu-cart"
                        class="float-end color-dark-dark font-22 font-600 rounded-s border-dark-dark"><i
                            class="fa fa-cart-shopping mt-2"></i></a>
                    <div clas="clearfix"></div>
                </div>
                <div class="card-body mx-0 px-0 mt-n3 mb-2">
                    <div class="splide single-slider slider-no-arrows slider-no-dots" id="single-slider-1">
                        <div class="splide__track">
                            <div class="splide__list">
                                <?php foreach ($bannerPromo as $bp) { ?>
                                <div class="splide__slide">
                                    <div class="card card-style shadow-l"
                                        style="background-image:url('<?php echo base_url() . 'uploads/store_banner/' . $bp['view']; ?>');"
                                        data-card-height="230">
                                        <!-- <div class="card-top px-3 py-3"> -->
                                        <!-- <a href="" class="icon icon-s bg-white color-black rounded-xl me-2 float-end cart-link" data-id="<?php echo $pb->product_id; ?>"><i class="fa fa-shopping-bag"></i></a> -->
                                        <!-- <a href="#" class="bg-white color-black rounded-sm btn btn-xs float-start font-700 font-12"><?php echo $pb->hargaHome; ?></a> -->
                                        <!-- </div> -->
                                        <!-- <div class="card-bottom px-3 py-3">
                                                <h1 class="color-white"><?php echo $pb->product_name; ?></h1>
                                            </div> -->
                                        <div class="card-overlay opacity-30"></div>
                                        <div class="card-overlay"></div>
                                    </div>
                                </div>
                                <?php } ?>
                                <!-- <div class="splide__slide">
                                    <div class="card card-style" style="background-image:url(<?php echo base_url() . 'asset/appkit/images/ventour/hotel.png'; ?>);" data-card-height="300">
                                        <div class="card-top px-3 py-3">
                                            <a href="#" data-menu="menu-heart" class="icon icon-s bg-white color-red-dark rounded-xl float-end"><i class="fa fa-heart"></i></a>
                                            <a href="" class="icon icon-s bg-white color-black rounded-xl me-2 float-end cart-link" data-id="10"><i class="fa fa-shopping-bag"></i></a>
                                            <a href="#" class="bg-white color-black rounded-sm btn btn-xs float-start font-700 font-12">$12.99</a>
                                        </div>
                                        <div class="card-bottom px-3 py-3">
                                            <h1 class="color-white">The Ham and Bacon<br>Double Cheeseburger</h1>
                                        </div>
                                        <div class="card-overlay bg-gradient opacity-30"></div>
                                        <div class="card-overlay bg-gradient"></div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-style bg-transparent shadow-0 mb-2 rounded-sm">

                <div class="search-box search-dark shadow-sm border-0 mt-4 bg-theme rounded-sm bottom-0">
                    <i class="fa fa-search ms-n3"></i>
                    <input type="text" class="border-0" placeholder="Cari produk" data-search>
                </div>
                <div class="search-results disabled-search-list">
                    <div>
                        <?php foreach ($products as $p) { ?>
                        <a href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $p->product_id ?>" data-filter-item data-filter-name="<?php echo $p->product_name . ' ' . $p->category . ' ' . $p->short_description ?>a">
                            <div class="d-flex mt-4">
                                <div class="align-self-center">
                                    <img src="<?php echo base_url() . $p->images[0]->location ?>" class="rounded-m me-3" width="80">
                                </div>
                                <div class="align-self-center">
                                    <h2 class="font-15 line-height-s mt-1 mb-n1"><?php echo $p->product_name ?></h2>
                                    <p class="mb-0 font-11 mt-2 line-height-s">
                                        <?php echo $p->category ?>
                                    </p>
                                </div>
                                <div class="ms-auto ps-3 align-self-center text-center">
                                    <?php if ($p->discount_amount != 0) { ?>
                                        <h2 class="font-20 mb-n2">Rp <?php echo $p->hargaDiscountFormat ?></h2>
                                        <del style="color: red;text-decoration:line-through">
                                            <p class="mt-1 mb-0 font-12">
                                                <?php echo $p->hargaHome; ?>
                                            </p>
                                        </del>
                                    <?php } else { ?>
                                        <h2 class="font-20 mb-n2">Rp <?php echo $p->hargaDiscountFormat ?></h2>
                                    <?php } ?>
                                </div>

                            </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="search-no-results disabled mt-4">
                <div class="card card-style">
                    <div class="content">
                        <h1>Produk tidak ditemukan</h1>
                        <p>
                            Produk yang Anda cari tidak ditemukan. Silahkan coba kata kunci lain.
                        </p>
                    </div>
                </div>
            </div>
            <div class="content mt-4 pt-2 mb-0">
                <div class="d-flex">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-18">Promo Terbaru</h1>
                    </div>
                </div>
            </div>
            <div class="splide double-slider slider-no-arrows slider-no-dots" id="double-slider-1">
                <div class="splide__track">
                    <div class="splide__list">
                        <?php foreach ($productPromo as $pp) { ?>
                        <div class="splide__slide">
                            <a href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $pp->product_id ?>"
                                class="card card-style">
                                <img src="<?php echo base_url() . $pp->images[0]->location; ?>" class="img-fluid">
                                <div class="p-3 bg-theme rounded-sm">
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i><br>
                                    <div class="d-flex mt-2">
                                        <div style="width: 50%;">
                                            <h4 class="mb-n1 font-14 line-height-xs pb-2">
                                                <?php echo $pp->product_name ?></h4>
                                        </div>
                                        <div class="ms-auto">
                                            <h3 class="mt-1 font-800"><?php echo $pp->hargaDiscountFormat ?></h3>
                                        </div>
                                    </div>
                                    <!-- <p class="font-10 mb-0"><i class="fa fa-star color-yellow-dark pe-2"></i>34
                                            Recommend It</p> -->
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content mb-0">
                    <p class="mb-n1 color-highlight font-600">Semua Produk</p>
                    <h1 class="font-20">Temukan Produk Lainnya</h1>
                    <div class="interest-slider">
                        <div class="interest-container">
                            <div class="list py-2 px-2" id="categoryList">
                                <?php
                                $no = 0;
                                foreach ($listCategory as $c) {
                                    $no++;
                                ?>
                                    <div class="slide text-center form-check interest-check">
                                        <input class="form-check-input" type="checkbox" data-category="<?php echo $c->category_id; ?>" onclick="filterProducts()" id="check<?php echo $no; ?>">
                                        <label class="form-check-label shadow-l rounded-xl" style="white-space: nowrap;" for="check<?php echo $no; ?>"><?php echo $c->category_name; ?></label>
                                        <i class="fa fa-check-circle color-white font-18"></i>
                                        <i class="fa fa-star font-17 color-yellow-dark"></i>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Grid View-->
                    <div class="row text-center mb-0">
                        <?php foreach ($products as $key => $p) { ?>
                        <div class="col-6 mb-4 card-product <?php echo $key <= 5 ? 'd-block' : 'd-none' ?>"
                            data-category="<?php echo $p->category_id ?>">
                            <?php if (!empty($p->images)) { ?>
                            <a
                                href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $p->product_id ?>"><img
                                    src="<?php echo base_url() . $p->images[0]->location; ?>"
                                    class="rounded-sm shadow-xl img-fluid"></a>
                            <?php } ?>
                            <a href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $p->product_id ?>"
                                class="d-block mt-3">
                                <i class="fa fa-star color-yellow-dark"></i>
                                <i class="fa fa-star color-yellow-dark"></i>
                                <i class="fa fa-star color-yellow-dark"></i>
                                <i class="fa fa-star color-yellow-dark"></i>
                                <i class="fa fa-star color-yellow-dark"></i><br>
                                <!-- <span class="font-10 d-block mt-n1">130 Reviewers</span> -->
                            </a>
                            <a
                                href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $p->product_id ?>">
                                <h5 class="mt-1"><?php echo $p->product_name ?></h5>
                                <span
                                    class="<?php echo ($p->stock_quantity > 0) ? 'color-green-dark' : 'color-red-dark' ?> font-10"><?php echo ($p->stock_quantity > 0) ? 'Stok Tersedia' : 'Stok Habis' ?></span>
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
                    <div class="d-flex justify-content-center">
                        <a href="<?php echo base_url() . 'jamaah/online_store/products'?>"
                            class="shadow-xl font-16 py-1 px-4 rounded-pill bg-highlight mb-3">
                            <!-- <div class="content text-center my-2"> -->
                            <i class="fa-solid fa-cubes me-2"></i><span>Lihat Semua</span>
                            <!-- </div> -->
                        </a>
                    </div>

                </div>
            </div>
            <?php $this->load->view('jamaahv2/include/footer'); ?>
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
        <div id="menu-added" class="menu menu-box-modal rounded-m" data-menu-hide="800" data-menu-width="250"
            data-menu-height="170">

            <h1 class="text-center mt-3 pt-2">
                <i class="fa fa-shopping-bag color-brown-dark fa-3x"></i>
            </h1>
            <h3 class="text-center pt-2">Added to Cart</h3>
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
                <a href="#" onclick="submit()" id="btnOrder"
                    class="close-menu btn-submit btn btn-margins btn-full gradient-blue font-13 btn-m font-600 mt-3 rounded-sm">Proses
                    Checkout</a>
                <?php } else { ?>
                <h6 class="font-500 font-14 pb-2 text-center" id="textEmptyCart" style="margin-bottom: 100px;">Belum ada
                    barang di
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
        document.addEventListener('DOMContentLoaded', function() {
            const interestSlider = document.querySelector('.interest-slider');
            const interestContainer = document.querySelector('.interest-container');
            const checkboxes = document.querySelectorAll('.form-check-input');
            const scrollAmount = 200; // Ganti angka 200 sesuai kebutuhan

            // Hitung lebar total dari semua elemen dalam slider
            let totalWidth = 0;
            checkboxes.forEach(function(checkbox) {
                totalWidth += checkbox.parentElement.offsetWidth; // Menggunakan parentElement untuk mengakses elemen induk (form-check)
            });

            // Atur lebar kontainer sesuai dengan total lebar elemen-elemen
            interestContainer.style.width = totalWidth + 'px';

            // Fungsi untuk menggulir ke kiri
            // function scrollLeft() {
            //     interestSlider.scrollLeft -= scrollAmount;
            // }

            // Fungsi untuk menggulir ke kanan
            // function scrollRight() {
            //     interestSlider.scrollLeft += scrollAmount;
            // }

            // Tambahkan event listener untuk tombol scroll ke kiri
            // document.getElementById('scrollLeftButton').addEventListener('click', function() {
            //     scrollLeft();
            // });

            // Tambahkan event listener untuk tombol scroll ke kanan
            // document.getElementById('scrollRightButton').addEventListener('click', function() {
            //     scrollRight();
            // });

            // // Tambahkan event listener untuk mendeteksi akhir scroll
            // interestSlider.addEventListener('scroll', function() {
            //     // Jika sudah mencapai ujung kanan, geser kembali ke awal
            //     if (interestSlider.scrollLeft + interestSlider.clientWidth >= interestSlider.scrollWidth) {
            //         interestSlider.scrollLeft = 0;
            //     }
            // });
        });


    modalCart()

    function modalCart() {
        var cartItems = document.getElementById("cartItems").innerHTML = '';
        // if (cartItems == null) {
        //     cartItems = document.getElementById("emptyItems");
        // }
        // cartItems.innerHTML = '';
        var Data = {
            id_user: <?php echo $id_customer; ?>,
            jenis: "j"
        };

        $.ajax({
            url: "<?php echo base_url() . 'jamaah/online_store/getCustomerCart'; ?>", // URL endpoint API
            type: 'POST', // Metode HTTP POST
            contentType: 'application/json', // Tipe konten yang dikirimkan
            data: JSON.stringify(Data), // Konversi data ke JSON string
            success: function(response) {
                var result = JSON.parse(response);
                var keyCount = Object.keys(result).length;
                var cartData = result

                // Fungsi untuk membuat dan menambahkan elemen baru ke dalam DOM
                function appendCartItem(key, cartItem) {
                    var cartItemsDiv = document.getElementById('cartItems');
                    var buttonOrderDiv = document.getElementById('buttonOrder');
                    var textEmpty = document.getElementById('textEmptyCart');
                    // if (cartItemsDiv == null) {
                    //     cartItemsDiv = document.getElementById('emptyItems');
                    // }
                    // console.log(cartItemsDiv);

                    // Membuat elemen-elemen HTML
                    var div = document.createElement('div');
                    div.className = 'd-flex mb-4';

                    var img = document.createElement('img');
                    img.src = '<?php echo base_url(); ?>' + cartItem.product[0].images[0].location;
                    img.className = 'rounded-sm';
                    img.width = '110';

                    var div2 = document.createElement('div');
                    div2.className = 'w-100 ms-3 pt-1';

                    var h4 = document.createElement('h4');
                    h4.className = 'font-700 mb-0';
                    h4.textContent = cartItem.product[0].product_name;

                    var del = document.createElement('del');
                    del.style.color = 'red';
                    del.style.textDecoration = 'line-through';
                    var span = document.createElement('span');
                    span.className = 'font-12';
                    span.textContent = cartItem.product[0].hargaHome;
                    del.appendChild(span);

                    var h5 = document.createElement('h5');
                    h5.className = 'font-500 font-16 mt-n1';
                    h5.textContent = cartItem.product[0].hargaDiscountHome;

                    var h5NoDiscount = document.createElement('h5');
                    h5NoDiscount.className = 'font-500 font-16';
                    h5NoDiscount.textContent = cartItem.product[0].hargaHome;

                    var divStepper = document.createElement('div');
                    divStepper.className = 'stepper rounded-s float-start';

                    var aSub = document.createElement('a');
                    aSub.href = '#';
                    aSub.className = 'stepper-sub';
                    aSub.onclick = function() {
                        decrementValue(key);
                    };
                    var iSub = document.createElement('i');
                    iSub.className = 'fa fa-minus color-theme opacity-40';
                    aSub.appendChild(iSub);

                    var inputQty = document.createElement('input');
                    inputQty.type = 'number';
                    inputQty.dataset.stok = cartItem.product[0].stock_quantity;
                    inputQty.name = 'qty[]';
                    inputQty.id = 'stepperValue' + key;
                    inputQty.value = cartItem.qty;
                    inputQty.min = '1';
                    inputQty.max = '10';

                    var inputProduct = document.createElement('input');
                    inputProduct.type = 'hidden';
                    inputProduct.name = 'id_product[]';
                    inputProduct.value = cartItem.id_product;

                    var inputCustomer = document.createElement('input');
                    inputCustomer.type = 'hidden';
                    inputCustomer.name = 'id_customer[]';
                    inputCustomer.value = cartItem.id_customer;

                    var aAdd = document.createElement('a');
                    aAdd.href = '#';
                    aAdd.className = 'stepper-add';
                    aAdd.onclick = function() {
                        incrementValue(key);
                    };
                    var iAdd = document.createElement('i');
                    iAdd.className = 'fa fa-plus color-theme opacity-40';
                    aAdd.appendChild(iAdd);

                    var removeBtn = document.createElement('a');
                    removeBtn.href = '#';
                    removeBtn.className = 'ms-3 mt-1 d-inline-block color-dark-dark hapusBtn';
                    removeBtn.id = 'removeBtn' + key
                    var removeIcon = document.createElement('i');
                    removeIcon.className = 'fa fa-trash color-red-dark';
                    removeBtn.onclick = function() {
                        removeItems(key)
                    }
                    removeBtn.dataset.product = cartItem.id_product;
                    removeBtn.dataset.customer = cartItem.id_customer;
                    removeBtn.appendChild(removeIcon);
                    removeBtn.appendChild(document.createTextNode(' Hapus'));
                    // removeBtn.appendChild('Remove')

                    var btnOrder = document.createElement('a')
                    btnOrder.href = "#";
                    btnOrder.onclick = function() {
                        submit();
                    };
                    btnOrder.className =
                        "close-menu btn-submit btn btn-margins btn-full gradient-blue font-13 btn-m font-600 mt-3 rounded-sm";
                    btnOrder.id = "btnOrder";
                    btnOrder.textContent = "Proses Checkout";

                    var textEmptyCart = document.createElement("h6");
                    textEmptyCart.className = "font-500 font-14 pb-2 text-center";
                    textEmptyCart.id = "textEmptyCart";
                    textEmptyCart.style.marginBottom = "100px";
                    textEmptyCart.textContent = "Belum ada barang di keranjang";

                    // Menyusun elemen-elemen HTML yang sudah dibuat
                    div.appendChild(img);
                    div2.appendChild(h4);
                    if (cartItem.product[0].discount_amount != 0) {
                        del.appendChild(span);
                        div2.appendChild(del);
                        div2.appendChild(h5);
                    } else {
                        div2.appendChild(h5NoDiscount);
                    }
                    divStepper.appendChild(aSub);
                    divStepper.appendChild(inputQty);
                    divStepper.appendChild(inputProduct);
                    divStepper.appendChild(inputCustomer);
                    divStepper.appendChild(aAdd);
                    div2.appendChild(divStepper);
                    div2.appendChild(removeBtn);
                    div.appendChild(div2);

                    // Menambahkan elemen baru ke dalam div utama
                    // if (cartItemsDiv != null) {
                    cartItemsDiv.appendChild(div);
                    // }


                    // Menambahkan elemen button order
                    if (textEmpty) {
                        buttonOrderDiv.removeChild(textEmpty);
                        buttonOrderDiv.appendChild(btnOrder);
                    }
                }

                // Memanggil fungsi appendCartItem untuk setiap item dalam cartData
                cartData.forEach(function(item, index) {
                    appendCartItem(index, item);
                });

            },
            error: function(xhr, status, error) {
                console.error(error); // Log pesan error jika permintaan gagal
            }
        });


    }

    function submit() {
        document.getElementById("myForm").submit();
    }

    function decrementValue(key) {
        var currentValue = parseInt($("#stepperValue" + key).val(), 10);
        if (currentValue > 1) {
            // Kurangi nilai saat nilai sekarang lebih besar dari 1
            $("#stepperValue" + key).val(currentValue - 1);
        }
    }

    function incrementValue(key) {
        var stepperElement = document.getElementById('stepperValue' + key);
        var stokValue = parseInt(stepperElement.dataset.stok, 10); // Ubah data-stok menjadi integer
        var currentValue = parseInt($("#stepperValue" + key).val(), 10);
        if (currentValue < stokValue) {
            // Tambah nilai saat nilai sekarang kurang dari stok
            $("#stepperValue" + key).val(currentValue + 1);
        }
    }

    function removeItems(key) {
        var btnRemove = document.getElementById('removeBtn' + key);
        var id_product = btnRemove.getAttribute('data-product');
        var id_customer = btnRemove.getAttribute('data-customer');

        // Data produk yang akan dikirimkan
        var Data = {
            id_product: id_product,
            id_customer: id_customer
        };

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim data produk ke server
                var xhr = new XMLHttpRequest();
                xhr.open('POST', "<?php echo base_url() . 'jamaah/online_store/hapus_cart'; ?>", true);
                xhr.setRequestHeader('Content-Type', 'application/json');

                xhr.onload = function() {
                    if (xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    } else {
                        console.error(xhr.statusText);
                    }
                };

                xhr.onerror = function() {
                    console.error('Network error');
                };

                xhr.send(JSON.stringify(Data));
            }
        });
    }

    $('.interest-check input[type="checkbox"]').change(filterProducts);

    function filterProducts() {
        var selectedCategories = $('.interest-check input[type="checkbox"]:checked').map(function() {
            return $(this).data('category');
        }).get();

        var visibleProducts = 0; // Tambahkan variabel untuk menghitung jumlah produk yang terlihat

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
                // Jika tidak ada kategori yang dipilih dan lebih dari 1 produk terlihat, sembunyikan produk tambahan
                $(this).addClass('d-none');
                $(this).removeClass('d-block');
            }
        });
    }


    $(document).ready(function() {
        $('.cart-link').click(function(event) {
            event.preventDefault()

            var id_product = $(this).data('id');

            // Data produk yang akan dikirimkan
            var Data = {
                id_product: id_product,
                qty: 1,
                id_customer: <?php echo $id_customer; ?>,
                jenis: "<?php echo $jenis; ?>",
            };

            // Kirim data produk ke server
            $.ajax({
                url: "<?php echo base_url() . 'jamaah/online_store/add_cart'; ?>", // URL endpoint API
                type: 'POST', // Metode HTTP POST
                contentType: 'application/json', // Tipe konten yang dikirimkan
                data: JSON.stringify(Data), // Konversi data ke JSON string
                success: function(response) {
                    $('#menu-added').addClass('menu-active');
                    $('.menu-hider').addClass('menu-active');
                    // Setelah 3 detik, hilangkan elemen #menu-added secara otomatis
                    setTimeout(function() {
                        $('#menu-added').removeClass('menu-active');
                        $('.menu-hider').removeClass('menu-active');
                    }, 800); // Waktu dalam milidetik (misalnya, 3000 untuk 3 detik)

                    if (response == 'Data berhasil ditambahkan') {
                        modalCart()
                    }
                    if (response == 'Data berhasil diupdate') {
                        modalCart()
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log pesan error jika permintaan gagal
                }
            });
        });

        
    });
    </script>

</body>