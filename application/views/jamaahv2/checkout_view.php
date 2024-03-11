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
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/store_menu', ['cart' => true, 'countCart' => $countCart]); ?>

        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <?php if ($cart != null) { ?>
            <form action="<?php echo base_url() . 'jamaah/online_store/proses_checkout' ?>" id="myForm" method="post">
                <div class="card card-style">
                    <div class="content">
                        <p class="font-600 color-highlight mb-n1">Keranjang</p>
                        <h3>Keranjang Anda</h3>
                        <p>
                            Daftar produk yang akan Anda checkout.
                        </p>
                        <input type="hidden" name="customer_id" value="<?php echo $cart[0]->id_customer ?>">
                        <input type="hidden" name="discount_amount" id="discount_amount" value="">

                        <?php foreach ($cart as $key => $c) { ?>
                            <p class="d-none" id="totalDiscount<?php echo $key ?>">
                                <?php echo $c->product[0]->discount_amount ?></p>
                            <div class="d-flex mb-3">
                                <div>
                                    <img src="<?php echo base_url() . $c->product[0]->images[0]->location ?>" width="110" class="rounded-s shadow-xl">
                                </div>
                                <div class="ps-3 w-100">
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i><br>
                                    <!-- <p class="mb-0 color-highlight">1x Item</p> -->
                                    <p id="hargaHome<?php echo $key; ?>" class="d-none">
                                        <?php echo $c->product[0]->priceTotal ?></p>
                                    <p id="hargaDiscountHome<?php echo $key; ?>" class="d-none">
                                        <?php echo $c->product[0]->priceTotal * $c->qty ?></p>
                                    <h2><?php echo $c->product[0]->product_name ?></h2>
                                    <h1 id="harga<?php echo $key; ?>"><?php echo $c->product[0]->hargaDiscountHome ?></h1>
                                    <!-- <h5 class="font-500">Your awesome product or service name here</h5> -->
                                </div>
                            </div>
                            <div class="mt-2 mb-4">
                                <div class="stepper rounded-s float-start">
                                    <a href="#" id="stepper_sub<?php echo $key; ?>" data-stock="<?php echo $c->product[0]->stock_quantity ?>" class="stepper-sub" onclick="decrementValue('<?php echo $key ?>')"><i class="fa fa-minus color-theme opacity-40"></i></a>
                                    <input type="number" onchange="inputStepper('<?php echo $key ?>')" data-qty="<?php echo $c->qty ?>" data-stok="<?php echo $c->product[0]->stock_quantity ?>" name="qty[]" id="stepperValue<?php echo $key ?>" value="<?php echo $c->qty ?>" min="1" max="10">
                                    <a href="#" id="stepper_add<?php echo $key; ?>" data-stock="<?php echo $c->product[0]->stock_quantity ?>" class="stepper-add" onclick="incrementValue(<?php echo $key ?>)"><i class="fa fa-plus color-theme opacity-40"></i></a>
                                </div>
                                <input type="hidden" name="id_product[]" value="<?php echo $c->id_product; ?>">
                                <a href="#" data-product="<?php echo $c->id_product; ?>" data-customer="<?php echo $c->id_customer; ?>" class="float-start mt-1 ms-4 font-11 color-theme font-12 hapusBtn"><i class="fa fa-trash color-red-dark me-1"></i> Hapus</a>
                                <div class="clearfix"></div>
                            </div>

                            <div class="divider"></div>
                        <?php } ?>


                    </div>
                </div>

                <div class="card card-style">
                    <div class="content mb-2 mt-3">
                        <div class="d-flex">
                            <div class="pe-4 w-60">
                                <p class="font-600 color-highlight mb-0 font-13">Your Total</p>
                                <h1 id="total"><?php echo $totalHarga ?></h1>
                                <input type="hidden" name="total_amount" id="total_amount" value="">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="card card-style">
                    <div class="content">
                        <p class="font-600 color-highlight mb-n1">Please select</p>
                        <h3>Payment Type</h3>
                        <p>
                            Enter some information here for your payment gateway messages. This is just a demo page.
                        </p>
                        <div class="fac fac-radio fac-highlight"><span></span>
                            <input id="box1-fac-radio" type="radio" name="rad" value="1">
                            <label for="box1-fac-radio">PayPal</label>
                        </div>
                        <div class="fac fac-radio fac-highlight"><span></span>
                            <input id="box2-fac-radio" type="radio" name="rad" value="1" checked>
                            <label for="box2-fac-radio">Credit Card</label>
                        </div>
                        <div class="fac fac-radio fac-highlight"><span></span>
                            <input id="box3-fac-radio" type="radio" name="rad" value="1">
                            <label for="box3-fac-radio">Bank Transfer</label>
                        </div>
                    </div>
                </div> -->

                <div class="card card-style">
                    <div class="content">
                        <p class="font-600 color-highlight mb-n1">Shipping</p>
                        <h3>Pengiriman</h3>
                        <p>
                            Isi alamat Anda dengan lengkap untuk proses pengiriman.
                        </p>
                        <div class="input-style has-borders no-icon validate-field input-style-always-active mb-4">
                            <input type="text" name="shipping_provinsi" class="form-control validate-text" id="provinsi">
                            <label for="form1" class="color-highlight font-500">Provinsi</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders no-icon validate-field input-style-always-active mb-4">
                            <input type="text" name="shipping_kabupaten_kota" class="form-control validate-text" id="kota">
                            <label for="form1" class="color-highlight font-500">Kabupaten / Kota</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders no-icon validate-field input-style-always-active mb-4">
                            <input type="text" name="shipping_kecamatan" class="form-control validate-text" id="kecamatan">
                            <label for="form1" class="color-highlight font-500">Kecamatan</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders no-icon validate-field input-style-always-active mb-4">
                            <input type="text" name="shipping_address" class="form-control validate-text" id="alamat">
                            <label for="form1" class="color-highlight font-500">Alamat ( nama jalan dan nomor rumah
                                )</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders no-icon validate-field input-style-always-active mb-4">
                            <input type="number" name="shipping_zip_code" class="form-control validate-number" id="kode_pos">
                            <label for="form1" class="color-highlight font-500">Kode Pos</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                    </div>
                </div>

                <div class="card card-style">
                    <div class="content">
                        <p class="font-600 color-highlight mb-n1">Informasi Tambahan</p>
                        <h3>Tambahkan Catatan</h3>
                        <p>
                            Beritahu kami jika ada tambahan informasi.
                        </p>
                        <div class="input-style has-borders input-style-always-active no-icon mb-4">
                            <textarea id="form7" name="notes" placeholder="" style="height:150px;"></textarea>
                            <label for="form7" class="color-highlight">Catatan</label>
                            <em class="mt-n3">(required)</em>
                        </div>
                    </div>
                </div>

                <a href="#" class="btn-submit btn btn-margins btn-full gradient-highlight font-13 btn-l font-600 mt-3 rounded-sm" onclick="submit()">Pesan Sekarang</a>

            </form>
            <?php } else { ?>
                <!-- <div class="content"> -->
                    <div class="card card-style">
                        <div class="content text-center">
                            <h4 class="mb-4"><i class="fa fa-4x fa-exclamation-circle color-yellow-dark scale-box shadow-xl rounded-circle"></i></h4>
                            <h3>Belum ada barang di keranjang</h1>
                            <div class="font-16 font-300">Silahkan pilih barang di menu <br><a href="<?php echo base_url() . 'jamaah/online_store/products' ?>" class="ms-1 color-yellow-dark"><i class="fa-solid fa-box me-1"></i>Produk</a></div>
                        </div>
                    </div>
                <!-- </div> -->
            <?php } ?>
        </div>


        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('konsultan/include/alert-bottom'); ?>
    <?php $this->load->view('jamaahv2/include/script_view'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        updateTotalPrice()

        function incrementValue(key) {
            var stepperValue = document.getElementById('stepperValue' + key);
            var harga = document.getElementById('hargaHome' + key).innerHTML;
            var stokValue = document.getElementById('stepper_add' + key);
            var qty = parseInt(stepperValue.value) + 1;
            var stok = stokValue.getAttribute('data-stock');
            if (qty >= stok) {
                $("#stepperValue" + key).val(stok - 1);
                qty = stok
            }

            var subtotal = harga * qty;
            document.getElementById('hargaDiscountHome' + key).innerHTML = '';
            document.getElementById('hargaDiscountHome' + key).innerHTML = subtotal;
            setTimeout(updateTotalPrice, 100);
        }

        function decrementValue(key) {
            var stepperValue = document.getElementById('stepperValue' + key);
            var harga = document.getElementById('hargaHome' + key).innerHTML;
            var qty = parseInt(stepperValue.value) - 1;
            var stokValue = document.getElementById('stepper_sub' + key);
            var stok = parseInt(stokValue.getAttribute('data-stock'));
            if (qty < 1) {
                $("#stepperValue" + key).val(1 + 1);
                qty = 1
            }

            var subtotal = harga * qty;
            document.getElementById('hargaDiscountHome' + key).innerHTML = '';
            document.getElementById('hargaDiscountHome' + key).innerHTML = subtotal;
            setTimeout(updateTotalPrice, 100);
        }

        function inputStepper(key) {
            var stepperElement = document.getElementById('stepperValue' + key);
            var stokValue = stepperElement.getAttribute('data-stok');
            var currentValue = parseInt($("#stepperValue" + key).val(), 10);
            if (currentValue > stokValue) {
                $("#stepperValue" + key).val(stokValue);
            } else if (currentValue < 1) {
                $("#stepperValue" + key).val('1');
            }
            updateTotalPrice()
        }

        function updateTotalPrice() {
            var total = 0;
            var disc = 0;
            <?php foreach ($cart as $key => $c) { ?>
                var qty = document.getElementById('stepperValue<?php echo $key ?>').value;
                var discount = document.getElementById('totalDiscount<?php echo $key ?>').innerHTML;
                var harga = document.getElementById('hargaHome<?php echo $key ?>').innerHTML;
                total += qty * harga;
                disc += qty * discount;
            <?php } ?>
            // console.log(total);
            var numberFormat = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
            document.getElementById('total').innerHTML = numberFormat.format(total);
            document.getElementById('total_amount').value = total;
            document.getElementById('discount_amount').value = disc;
        }

        function submit() {
            document.getElementById('myForm').submit();
        }

        // $("#kota").autocomplete({
        //     source: "<?php echo base_url() . 'jamaah/online_store/getKota'; ?>"
        // });
        // $("#provinsi").autocomplete({
        //     source: "<?php echo base_url() . 'jamaah/online_store/getRegencies'; ?>"
        // });
        // $("#kecamatan").autocomplete({
        //     source: "<?php echo base_url() . 'jamaah/online_store/getDistricts'; ?>"
        // });

        $(document).ready(function() {
            $('.hapusBtn').click(function(event) {
                event.preventDefault()

                var id_product = $(this).data('product');
                var id_customer = $(this).data('customer');

                // Data produk yang akan dikirimkan
                var Data = {
                    id_product: id_product,
                    id_customer: id_customer
                };
                Swal.fire({
                    // title: 'Are you sure?',
                    text: "Anda yakin ini menghapus produk?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim data produk ke server
                        $.ajax({
                            url: "<?php echo base_url() . 'jamaah/online_store/hapus_cart'; ?>", // URL endpoint API
                            type: 'POST', // Metode HTTP POST
                            contentType: 'application/json', // Tipe konten yang dikirimkan
                            data: JSON.stringify(Data), // Konversi data ke JSON string
                            success: function(response) {
                                Swal.fire(
                                    'Dihapus!',
                                    'Produk telah dihapus dari keranjang Anda.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error(
                                    error); // Log pesan error jika permintaan gagal
                            }
                        });
                    }
                })
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