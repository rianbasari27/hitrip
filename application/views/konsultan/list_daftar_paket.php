<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
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

    .inline {
        display: inline-block;
    }

    .form-control-sm {
        border-radius: 7px;
        width: 70vw !important;
    }

    .page-link {
        border-radius: 10px;
        border: none;
        color: black;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
        background-color: transparent;
        /* font-size: 12px; */

    }

    .active .page-link {
        color: white;
        background-color: #edbd5a !important;
    }

    /* div.dataTables_wrapper div.dataTables_paginate ul.pagination {
        justify-content: center !important;
    } */


    .hover {
        background-color: #f0f0f0 !important;
    }

    .custom-row-style {
        overflow: hidden;
        border-radius: 20px !important;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
        /* background-color: white; */
        display: table-row;
        width: 100%;
        margin-bottom: 15px;
        padding: 0px 20px 0px 20px;
    }

    .table-content {
        margin: 20px 0;
    }

    .dataTable {
        /* border-collapse: separate; */
        /* width: 100% !important; */
        border-spacing: 0 1em !important;
    }

    .table> :not(caption)>*>* {
        padding: 0.7rem 1rem 0rem !important;
    }

    .text-xxs {
        font-size: 12px;
    }

    .text-xxxs {
        font-size: 10px;
    }

    @media screen and (min-width: 300px) {
        .jam {
            font-size: clamp(20px, 9vw, 40px);
        }
    }

    @media screen and (max-width: 300px) {
        .total {
            font-size: 3rem;
        }

        .subtotal {
            font-size: 2rem !important;
        }
    }
    </style>
    <link href="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <div class="page-content">

            <div class="card card-style mt-3">
                <div class="card mb-0 bg-home" data-card-height="250"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">List Paket</p>
                    <h1>Daftarkan jamaah Anda</h1>
                </div>
            </div>

            <!-- Menu slider -->
            <!-- <?php $this->load->view('konsultan/include/slide_menu'); ?> -->
            <!--  -->

            <div class="card card-style" id="paket">
                <div class="content mb-0">
                    <p class="mb-n1 font-600 color-highlight">Segera bergabung, seat terbatas!</p>
                    <h2 class="mb-4">Jadwal Keberangkatan
                        <?php echo $monthSelected ? $this->date->convert("F", '01-' . $monthSelected . '-1990') : ""; ?>
                    </h2>
                    <div class="row">
                        <div class="col-6">
                            <div class="card card-style bg-highlight mx-0 pt-2 pb-2" data-menu="menu-musim">
                                <h5 class="color-white d-flex justify-content-between align-items-center">
                                    <span class="ms-3">Pilih Musim</span>
                                    <span class="icon icon-xxs bg-theme color-black rounded-xl me-3"><i
                                            class="fa fa-arrow-right"></i></span>
                                </h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card card-style bg-highlight mx-0 pt-2 pb-2" data-menu="menu-bulan">
                                <h5 class="color-white d-flex justify-content-between align-items-center">
                                    <span class="ms-3">Pilih Bulan</span>
                                    <span class="icon icon-xxs bg-theme color-black rounded-xl me-3"><i
                                            class="fa fa-arrow-right"></i></span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-0">
                        <?php foreach ($paket as $p) { ?>
                        <div class="paket_musim" id="paket<?php echo $p->id_paket?>">
                            <div class="d-flex" onclick="window.location='<?php echo $p->detailLink; ?>';">
                                <div class="col-6 mb-4 pe-0">
                                    <a href="#"><img
                                            src="<?php echo ($p->banner_image) ? base_url() . $p->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                                            class="rounded-sm shadow-xl img-fluid"></a>
                                </div>
                                <div class="col-6 ms-3 pe-2">
                                    <a href="#" class="d-block">
                                        <?php for ($i = 0; $i < $p->star; $i++) { ?>

                                        <i class="fa fa-star color-yellow-dark"></i>
                                        <?php } ?>
                                        <br>
                                    </a>
                                    <a href="#">
                                        <h5 class="mb-0"><?php echo $p->nama_paket; ?></h5>
                                        <?php if ($p->sisa_seat > 20) { ?>
                                        <span class="color-green-dark font-11">Seat Tersedia</span>
                                        <?php } else { ?>
                                        <span class="color-orange-light font-11">Sisa <?php echo $p->sisa_seat; ?> Seat
                                            Lagi!</span>
                                        <?php } ?>
                                    </a>
                                    <?php if ($p->default_diskon > 0 ) { ?>
                                    <del style="color: red;text-decoration:line-through">
                                        <p class="mt-1 mb-n2 font-600">
                                            <?php echo $p->hargaHome; ?> Jt
                                        </p>
                                    </del>
                                    <h1 class="mb-n2 font-800 harga-paket"><?php echo $p->hargaHomeDiskon; ?><sup
                                            class="font-800 font-16" style="font-weight:bold;"> Jt</sup></h1>
                                    <span class="opacity-100 font-11">Berangkat
                                        <?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></span>
                                    <?php } else {  ?>
                                    <h1 class="mb-n2 font-800 harga-paket">
                                        <?php echo $p->hargaHome; ?><sup class="font-800 font-16"
                                            style="font-weight:bold;">
                                            Jt</sup></h1>
                                    <span class="opacity-100 font-11">Berangkat
                                        <?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></span>
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="w-100 divider divider-margins"></div>
                        </div>
                        <?php } ?>


                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="https://wa.me/6282110150045" target="_blank">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <span style="font-size: 15px;">Help & Support</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370">
        </div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480">
        </div>
    </div>
    <div id="menu-bulan" class="menu menu-box-bottom rounded-m" data-menu-height="450" data-menu-effect="menu-over">
        <div class="menu-title">
            <p class="color-highlight">Selalu Tersedia</p>
            <h1 class="font-24">Pilih Bulan Keberangkatan</h1>

            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>

        </div>
        <div class="me-4 ms-3 mt-2">
            <div class="list-group list-custom-small">
                <a href="#" data-month="00" data-musim="0000" class="month-option"><span>Semua Keberangkatan</span><i
                        class="fa fa-angle-right"></i></a>
                <?php foreach ($availableMonths as $month) { ?>
                <a href="#" class="month-option" data-musim="0000"
                    data-month="<?php echo date('m', strtotime($month->tanggal_berangkat)); ?>"><span><?php echo $this->date->convert('F', $month->tanggal_berangkat); ?></span><i
                        class="fa fa-angle-right"></i></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div id="menu-musim" class="menu menu-box-bottom rounded-m" data-menu-height="450" data-menu-effect="menu-over">
        <div class="menu-title">
            <p class="color-highlight">Musim</p>
            <h1 class="font-24">Pilih Musim</h1>

            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>

        </div>
        <div class="me-4 ms-3 mt-2">
            <div class="list-group list-custom-small">
                <a href="#" class="season-option" data-month="00" data-musim="0000"><span>Semua Keberangkatan</span><i
                        class="fa fa-angle-right"></i></a>
                <?php $no = 0;
                    foreach ($seasonArr as $s) { 
                        $no++;
                        ?>
                <a href="#" id="btnSeason<?php echo $no;?>" class="season-option" data-month="00"
                    data-musim="<?php echo $s[0]; ?>"><span><?php echo $s[0] . ' H'; ?></span><i
                        class="fa fa-angle-right"></i></a>
                <?php } ?>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('konsultan/include/script_view'); ?>
    <script>
    $(document).ready(function() {

        $('.season-option').click(function(event) {
            event.preventDefault()

            var musim = $(this).data('musim');
            var month = $(this).data('month');

            var seasonApi =
                "<?php echo base_url() . 'konsultan/daftar_jamaah/getSeasonPackage?musim=';?>" + musim +
                "&month=" + month;
            var monthApi =
                "<?php echo base_url() . 'konsultan/daftar_jamaah/getMonthSeasonPackage?musim=';?>" +
                musim + "&month=" + month;
            fetch(seasonApi)
                .then(response => response.json())
                .then(data => {
                    $('#menu-musim').removeClass('menu-active');
                    $('.menu-hider').removeClass('menu-active');
                    $('.paket_musim').addClass('d-none');

                    data.forEach(function(pkt) {
                        $('#paket' + pkt.id_paket).removeClass('d-none');
                        $('#paket' + pkt.id_paket).addClass('d-block')
                    });
                    fetch(monthApi)
                        .then(response => response.json())
                        .then(month => {
                            // Append to menu-bulan
                            var menuBulan = $('#menu-bulan .list-custom-small');
                            menuBulan.empty(); // Clear existing content
                            // Append new month options
                            menuBulan.append(
                                '<a href="#" data-month="00" data-musim="0000" class="month-option"><span>Semua Keberangkatan</span><i class="fa fa-angle-right"></i></a>'
                            );
                            month.forEach(function(bulan) {
                                // console.log(month);
                                var splitMonth = bulan['tanggal_berangkat'].split('-');
                                var f = new Date(splitMonth[0], splitMonth[1] - 1,
                                    splitMonth[2]);
                                var month_name = $.datepicker.formatDate('M', f);
                                var monthOption = $(
                                    '<a href="#" class="month-option" data-musim="' +
                                    musim + '" data-month="' + splitMonth[1] +
                                    '"><span>' + month_name +
                                    '</span><i class="fa fa-angle-right"></i></a>');
                                // console.log(monthOption);
                                menuBulan.append(monthOption);
                            });
                            $('.month-option').attr('data-musim', musim)
                        })
                        .catch(error => {
                            // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                            console.error("Error getting city and country: ", error);
                        });
                })
                .catch(error => {
                    // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                    console.error("Error getting city and country: ", error);
                });
        });
        $(document).on('click', '.month-option', function(event) {
            event.preventDefault()

            var month = $(this).data('month');
            var musim = $(this).data('musim');


            var seasonApi =
                "<?php echo base_url() . 'konsultan/daftar_jamaah/getMonthPackage?musim=';?>" + musim +
                "&month=" + month;
            fetch(seasonApi)
                .then(response => response.json())
                .then(data => {
                    $('#menu-bulan').removeClass('menu-active');
                    $('.menu-hider').removeClass('menu-active');
                    $('.paket_musim').addClass('d-none');

                    data.forEach(function(pkt) {
                        $('#paket' + pkt.id_paket).removeClass('d-none');
                        $('#paket' + pkt.id_paket).addClass('d-block')
                    });
                    $('.season-option').attr('data-month', month)
                })
                .catch(error => {
                    // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                    console.error("Error getting city and country: ", error);
                });
        });

        // document.querySelector('.menu-hider').classList.add('menu-active');


        function updateTimes() {
            moment.tz.add([
                "Asia/Jakarta|LMT BMT +0720 +0730 +09 +08 WIB|-77.c -77.c -7k -7u -90 -80 -70|012343536|-49jH7.c 2hiLL.c luM0 mPzO 8vWu 6kpu 4PXu xhcu|31e6",
                "Asia/Riyadh|LMT +03|-36.Q -30|01|-TvD6.Q|57e5",
            ]);
            const jakartaTime = moment().tz("Asia/Jakarta").format("HH:mm");
            const riyadhTime = moment().tz("Asia/Riyadh").format("HH:mm");
            const jakartaDate = moment().tz("Asia/Jakarta").locale('id').format("ll");
            const riyadhDate = moment().tz("Asia/Riyadh").locale('id').format("ll");

            $("#jakarta").text(jakartaTime);
            $("#riyadh").text(riyadhTime);
            $("#jkt_date").text(jakartaDate);
            $("#riyadh_date").text(riyadhDate);
        }

        setInterval(updateTimes, 1000);

        updateTimes();
    });
    </script>
</body>