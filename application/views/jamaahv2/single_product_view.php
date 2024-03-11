<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
        .bg-6 {
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/bg_kuning.jpg");
        }
        .badge {
            background-color: red;
            color: white;
            padding: 4px 6px;
            border-radius: 50%;
            margin-left: 400px;
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
        <?php $this->load->view('jamaahv2/include/header_bar', ['always_show' => true]); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/store_menu', ['product' => true, 'countCart' => $countCart]); ?>

        <div class="page-content pb-0">
            <div class="card card-fixed" data-card-height="400">
                <div class="splide single-slider <?php echo count($product->images) > 1 ? 'slider-arrows' : 'slider-no-arrows' ?> slider-no-dots" id="single-slider-1">
                    <div class="splide__track">
                        <div class="splide__list">
                            <?php foreach ($product->images as $p) { ?>
                                <div class="splide__slide">
                                    <div class="card" style="background-image: url(<?php echo base_url() . $p->location ?>);" data-card-height="400">
                                        <div class="card-overlay"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card card-clear" data-card-height="400"></div>

            <!-- <div class="page-content"> -->

            <!-- card in this page format must have the class card-full to avoid seeing behind it-->
            <div class="card card-full pb-5 rounded-m shadow-xl">

                <div class="content">
                    <div class="d-flex">
                        <div class="me-auto align-self-center">
                            <p class="font-600 mb-n1 color-highlight">Kategori, <?php echo $product->category ?></p>
                            <h1 class="font-30 mb-0"><?php echo $product->product_name ?></h1>

                            <i class="fa fa-star color-yellow-dark"></i>
                            <i class="fa fa-star color-yellow-dark"></i>
                            <i class="fa fa-star color-yellow-dark"></i>
                            <i class="fa fa-star color-yellow-dark"></i>
                            <i class="fa fa-star color-yellow-dark"></i>
                        </div>
                        <!-- <div class="align-self-center"> -->
                            <!-- <a href="#" data-menu="menu-heart" class="icon icon-xs bg-white shadow-xl color-red-dark rounded-xl"><i class="fa fa-heart"></i></a> -->
                            <!-- <a href="#" data-menu="menu-share" class="icon icon-xs bg-white shadow-xl color-blue-dark rounded-xl ms-1"><i class="fa fa-share-alt"></i></a> -->
                            <!-- <a href="#" data-menu="menu-added" class="icon icon-xs bg-white shadow-xl color-brown-dark rounded-xl ms-1"><i class="fa fa-shopping-bag"></i></a> -->
                        <!-- </div> -->
                    </div>

                    <!-- <div class="divider mt-3 mb-3"></div> -->

                    <div class="me-auto align-self-center my-3">
                        <?php if ($product->discount_amount != 0) { ?>
                            <h2 class="pt-1 me-3 font-700"><?php echo $product->hargaDiscountHome ?></h2>
                            <del style="color: red;text-decoration:line-through">
                                <p class="font-700 font-12 mt-n1 opacity-50"><?php echo $product->hargaHome ?></p>
                            </del>
                        <?php } else { ?>
                            <h2 class="pt-1 me-3 font-700"><?php echo $product->hargaDiscountHome ?></h2>
                        <?php } ?>
                    </div>

                    <div class="row mb-0">
                        <div class="col-3">
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input type="number" class="form-control validate-number" id="qty" placeholder="1" value="1">
                                <label for="qty" class="color-highlight font-500">Qty</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                            </div>
                        </div>
                        <div class="col-9">
                            <a href="#" class="btn btn-full btn-m font-600 rounded-s shadow-l gradient-highlight cart-link" data-id="<?php echo $product->product_id; ?>">Tambah ke keranjang</a>
                        </div>
                    </div>

                    <div class="divider mt-3 mb-0"></div>
                </div>

                <div class="content mb-0">
                    <!-- <p class="mb-n1 color-highlight font-600 mb-n1">View In Detail</p> -->
                    <h2>Deskripsi Produk</h2>
                    <p class="mt-n1">
                        <?php echo $product->description ?>
                    </p>
                    <div class="row text-center row-cols-3 mb-0">
                        <?php foreach ($product->images as $p) { ?>
                            <a class="col mb-4" data-gallery="gallery-1" href="<?php echo base_url() . $p->location ?>">
                                <img src="<?php echo base_url() . $p->location ?>" data-src="<?php echo base_url() . $p->location ?>" class="img-fluid rounded preload-img shadow" alt="img">
                            </a>
                        <?php } ?>
                    </div>

                </div>

                <div class="divider my-3"></div>

                <!-- <a href="#" class="btn btn-full me-3 ms-3 btn-l font-13 font-600 rounded-s shadow-l mb-4 gradient-highlight">Beli Sekarang</a> -->

                <div class="content">
                    <h2>Produk lainnya</h2>
                </div>
                <div class="splide double-slider slider-no-dots" id="double-slider-1">
                    <div class="splide__track">
                        <div class="splide__list">
                            <?php foreach ($other as $o) { ?>
                                <div class="splide__slide">
                                    <div data-card-height="250" class="card mx-3 rounded-m shadow-l" style="background-image: url('<?php echo base_url() . $o->images[0]->location ?>');">
                                        <div class="card-bottom text-center">
                                            <h2 class="color-white font-500 font-15 mb-0"><?php echo $o->product_name ?></h2>
                                            <span class="text-center d-block color-highlight mb-2 font-500"><?php echo $o->hargaDiscountHome ?></span>
                                            <a href="<?php echo base_url() . 'jamaah/online_store/single_product?id=' . $o->product_id ?>" class="btn btn-s btn-full font-13 font-600 gradient-highlight rounded-s me-2 ms-2 mb-2">Lihat</a>
                                        </div>
                                        <div class="card-overlay bg-gradient"></div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <p id="cartItems"><?php echo $countCart ?></p>
            </div>
            <!-- </div> -->
            <?php //$this->load->view('jamaahv2/include/footer'); 
            ?>
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
            <h4 class="text-center pt-2">Ditambahkan ke keranjang</h4>
        </div>


        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('jamaahv2/include/script_view'); ?>

    <script>
        // function showAlert() {
        // // Basic alert
        //     swal({
        //         title: "Mohon Maaf",
        //         text: "Pesanan melebihi stok",
        //         icon: "info",
        //         button: "Ok",
        //     });
        // }
        $(document).ready(function() {
            $('.cart-link').click(function(event) {
                event.preventDefault()

                var id_product = $(this).data('id');
                var qty = parseInt($('#qty').val());
                if (qty == '' || qty == 0) {
                    qty == 1;
                }
                if (qty > 10) {
                    Swal.fire({
                        title: "Mohon Maaf",
                        text: "Pesanan melebihi stok",
                        icon: "error",
                        button: "Ok",
                    });
                    $('.swal2-confirm').addClass('bg-highlight');
                } else {
                    // console.log(id_product);
                    // console.log(qty);

                    // Data produk yang akan dikirimkan
                    var Data = {
                        id_product: id_product,
                        qty: qty,
                        id_customer: <?php echo $customer->id_customer; ?>,
                        jenis: "<?php echo $customer->jenis; ?>",
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

                            var countCart = parseInt($('#cartItems').text());
                            console.log(qty);
                            if (countCart > 0) {
                                $('#totalItems').text(countCart + qty);
                            } else {
                                $('#cartMenu').append('<div style="margin-left: 1.5px !important" class="badge font-10 font-300 ms-n2" id="totalItems">' + (countCart + qty) + '</div>')
                            }
                            $('#cartItems').text(countCart + qty);

                            // if (response == 'Data berhasil ditambahkan') {
                            //     modalCart()
                            // }
                            // if (response == 'Data berhasil diupdate') {
                            //     modalCart()
                            // }
                            
                        },
                        error: function(xhr, status, error) {
                            console.error(error); // Log pesan error jika permintaan gagal
                        }
                    });
                    
                }
            });

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

                    if (!selectedCategories.length && visibleProducts > 2) {
                        // Jika tidak ada kategori yang dipilih dan lebih dari 1 produk terlihat, sembunyikan produk tambahan
                        $(this).addClass('d-none');
                        $(this).removeClass('d-block');
                    }
                });
            }
        });
    </script>

</body>