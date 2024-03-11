<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/bg_kuning_biru.jpg");
    }

    .bg-11 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/bg_kuning_biru.jpg");
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

    p {
        margin-bottom: 0;
    }

    .text-shadow {
        text-shadow: 2px 2px 6px black;
    }

    .page-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* padding: 10px; */
        /* background-color: #f1f1f1; */
        /* Ganti warna latar belakang sesuai kebutuhan */
    }

    .page-title a {
        /* margin-left: 10px; */
        /* Ganti margin sesuai kebutuhan */
        position: relative;
    }

    .badge {
        background-color: red;
        color: white;
        padding: 5px 8px;
        border-radius: 50%;
        position: absolute;
        top: -5px;
        right: -5px;
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
        <?php $this->load->view('konsultan/include/header_menu', ['menuBC' => true, 'countBc' => $countBc]); ?>
        <div class="page-title-clear"></div>
        <div class="page-content">

            <div class="card card-style bg-11 mt-3" data-card-height="230">
                <div class="card-top px-3 pb-3 mt-3">
                    <div class="ms-auto d-inline-block bg-white rounded-xl border border-3 border-white shadow-l me-3"
                        style="position: absolute; right: 0px;">
                        <img src="<?php echo base_url() . ($agen->agen_pic != null ? $agen->agen_pic : 'asset/appkit/images/pictures/default/default-profile.jpg') ?>"
                            class="rounded-xl" width="70">
                    </div>
                    <h1 class="font-14 mb-n1 fw-bold color-white text-shadow">Assalamu'alaikum</h1>
                    <div style="width: 75%;">
                        <h1 class="font-20 mb-5 color-white text-shadow"><?php echo $agen->nama_agen ?></h1>
                    </div>
                </div>
                <div class="card-bottom ps-3 pb-3">
                    <div class="d-flex">
                        <div class="pe-3">
                            <h5><i class="fa-solid fa-plane-circle-check mb-2 fs-6 color-green-dark"></i></h5>
                            <h3 class="font-24 color-white counter" data-count="<?php echo $sudah_berangkat ?>">0</h3>
                        </div>
                        <div class="pe-3">
                            <h5><i class="fa-solid fa-user-clock mb-2 fs-6 color-yellow-dark"></i></h5>
                            <h3 class="font-24 color-white counter" data-count="<?php echo $belum_berangkat ?>">0</h3>
                        </div>
                        <div class="ms-auto text-end pe-3">
                            <h5 class="color-white opacity-60">Total Jamaah</h5>
                            <h3 class="font-32 color-white counter" data-count="<?php echo $totalJamaah ?>">0</h3>
                        </div>
                    </div>
                </div>
                <div class="card-overlay bg-gradient opacity-80"></div>
            </div>

            <div class="content mx-0 mb-0">
                <div class="row mb-0">
                    <div class="col-6 pe-0">
                        <div class="card mr-0 mb-3 card-style rounded-sm">
                            <div class="d-flex p-2">
                                <div class="align-self-center">
                                    <h1 class="mb-0 font-26 jam">
                                        <div id="jakarta"></div>
                                    </h1>
                                </div>
                                <div class="text-end ms-auto align-self-center">
                                    <p class="fw-bold mb-n2 font-12 color-highlight">Jakarta</p>
                                    <p class="my-0" id="jkt_date" style="font-size: clamp(6px, 10vw, 12px);"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 ps-0">
                        <div class="card ml-0 mb-3 card-style rounded-sm">
                            <div class="d-flex p-2">
                                <div class="align-self-center">
                                    <h1 class="mb-0 font-26 jam">
                                        <div id="riyadh"></div>
                                    </h1>
                                </div>
                                <div class="text-end ms-auto align-self-center">
                                    <p class="fw-bold mb-n2 font-12 color-highlight">Mekkah</p>
                                    <p class="my-0" id="riyadh_date" style="font-size: clamp(6px, 10vw, 12px);"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content mb-0 mt-0">
                <p class="mb-n1 color-highlight font-600">Program</p>
                <h1>Program Konsultan</h1>
            </div>
            <?php if (empty($program)) { ?>
            <div class="card card-style">
                <div class="content">
                    <h4 class="text-center">Belum ada program yang tersedia</h4>
                </div>
            </div>
            <?php } else { ?>
            <?php if (count($program) <= 1) { ?>
            <a href="<?php echo base_url() . 'konsultan/home/daftar_program?id=' . $program[0]->id ?>"
                class="card card-style">
                <div class="content">
                    <div class="d-flex">
                        <div style="height: 105px;" class="rounded-sm shadow-xl">
                            <img src="<?php echo base_url() . ($program[0]->agen_gambar_banner != null ?  $program[0]->agen_gambar_banner : 'asset/appkit/images/pictures/default/default_150x150.png') ?>"
                                width="80" class="rounded-sm">
                            <div class="text-center color-blue-dark font-700 font-12">DAFTAR</div>
                        </div>
                        <div class="ms-3">
                            <!-- <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <i class="fa fa-star color-yellow-dark"></i><br> -->
                            <h4 class="mb-0 font-16 animated-text"><?php echo $program[0]->nama_paket ?></h4>

                            <?php if ($program[0]->diskon_eks_jamaah > 0 || $program[0]->diskon_member_lama > 0) { ?>
                            <del style="color: red;text-decoration:line-through">
                                <p class="mb-0 font-600 font-12">
                                    <?php echo $program[0]->hargaPretty; ?>
                                </p>
                            </del>
                            <h1 class="mb-n1 mt-n1 font-20 font-800 harga-paket">
                                <?php echo $program[0]->hargaEksJamaahPretty; ?></h1>
                            <?php } else {  ?>
                            <div class="d-flex">
                                <h1 class="mb-n1 font-800 harga-paket">
                                    <?php echo $program[0]->hargaPretty; ?></h1>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </a>
            <?php } else { ?>
            <div class="splide single-slider slider-no-arrows slider-no-dots" id="single-slider-1">
                <div class="splide__track">
                    <div class="splide__list">
                        <?php foreach ($program as $p) { ?>
                        <div class="splide__slide">
                            <a href="<?php echo base_url() . 'konsultan/home/daftar_program?id=' . $p->id ?>"
                                class="card card-style">
                                <div class="content">
                                    <div class="d-flex">
                                        <div style="height: 105px;" class="rounded-sm shadow-xl">
                                            <img src="<?php echo base_url() . ($p->agen_gambar_banner != null ?  $p->agen_gambar_banner : 'asset/appkit/images/pictures/default/default_150x150.png')?>"
                                                width="80" class="rounded-sm">
                                            <div class="text-center color-blue-dark font-700 font-12">DAFTAR</div>
                                        </div>
                                        <div class="ms-3">
                                            <!-- <i class="fa fa-star color-yellow-dark"></i>
                                                <i class="fa fa-star color-yellow-dark"></i>
                                                <i class="fa fa-star color-yellow-dark"></i>
                                                <i class="fa fa-star color-yellow-dark"></i>
                                                <i class="fa fa-star color-yellow-dark"></i><br> -->
                                            <h4><?php echo $p->nama_paket ?></h4>
                                            <?php if ($p->diskon_member_lama > 0  || $p->diskon_eks_jamaah > 0) { ?>
                                            <del style="color: red;text-decoration:line-through">
                                                <p class="mt-1 mb-0 font-600 font-14">
                                                    <?php echo $p->hargaPretty; ?>
                                                </p>
                                            </del>
                                            <h1 class="mb-n1 font-800 harga-paket">
                                                <?php echo $p->hargaEksJamaahPretty; ?>
                                            </h1>
                                            <?php } else {  ?>
                                            <h1 class="mb-n1 font-800 harga-paket">
                                                <?php echo $p->hargaPretty; ?></h1>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php } ?>

            <!-- <?php if (!empty($paket)) { ?>
            <div class="card card-style">
                <div class="content">
                    <div class="d-flex">
                        <div>
                            <img src="<?php echo base_url() . $paket->banner_image ?>" width="130"
                                class="rounded-sm shadow-xl">
                        </div>
                        <div class="ps-3 w-100">
                            <h4 class="mb-0 color-dark-dark"><?php echo $paket->nama_paket ;?>
                                <?php if (!empty($jamaah->member) && ($lunas == 1 || $lunas == 3)) : ?>
                                <br><span class="color-green-dark font-16">Terdaftar</span>
                                <?php elseif (!empty($jamaah->member) && ($lunas == 0 || $lunas == 2)) : ?>
                                <br><span class="color-yellow-dark font-16">Menunggu Pembayaran</span>
                                <?php endif; ?>

                                <?php if ($paket->default_diskon > 0 ) { ?>
                                <del style="color: red;text-decoration:line-through">
                                    <p class="mt-1 mb-0 font-600 font-14">
                                        <?php echo $paket->hargaHome; ?> Jt
                                    </p>
                                </del>
                                <h1 class="mb-n1 font-800 harga-paket"><?php echo $paket->hargaHomeDiskon; ?><sup
                                        class="font-800 font-16" style="font-weight:bold;"> Jt</sup></h1>
                                <?php } else {  ?>
                                <h1 class="mb-n1 font-800 harga-paket">
                                    <?php echo $paket->hargaHome; ?><sup class="font-800 font-16"
                                        style="font-weight:bold;">
                                        Jt</sup></h1>
                                <?php } ?>

                                <span><i class="fa-solid fa-calendar me-1"></i>
                                    <?php echo $this->date->convert("j F Y", "$paket->tanggal_berangkat"); ?></span><br>

                                <?php if (empty($jamaah) || empty($jamaah->member)) { ?>
                                <a href="<?php echo base_url() . "konsultan/daftar_jamaah/daftar_program?id=369" ?>"
                                    class="btn btn-xs gradient-highlight rounded mt-2">Ikuti Program</a>
                                <?php } else { ?>
                                <?php if ($id_pembayaran == null) { ?>
                                <a href="<?php echo base_url() . "konsultan/jamaah_info/bsi_dp?id=" . $jamaah->member[0]->idSecretMember ?>"
                                    class="btn btn-xs gradient-highlight rounded mt-2">Pembayaran</a>
                                <?php } else { ?>
                                <span class="color-dark-dark fw-bold">Download invoice Anda </span><a class="fw-bold"
                                    href="<?php echo base_url() . 'konsultan/kuitansi_dl/download_program?id=' . $id_pembayaran . "&idm=" . $jamaah->member[0]->idSecretMember ;?>">di
                                    sini.</a>
                                <?php } ?>
                                <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php } ?> -->



            <?php if ($broadcast != null) : ?>
            <!-- <div class="card card-style" style="position:relative; height:fit-content;">
                <span class="content">Tidak ada informasi atau pengumuman</span>
            </div> -->
            <div class="content mb-0">
                <p class="mb-n1 color-highlight font-600">Informasi</p>
                <h1>Pengumuman</h1>
            </div>
            <?php //$i = 0; ?>
            <?php //foreach ($broadcast as $key => $bc) : ?>
            <div class="card card-style bg-opacity-10 mb-3" style="position:relative; height:fit-content;">
                <div class="content mb-3">
                    <span class="p-2 rounded-circle bg-<?php echo $broadcast[0]->color; ?> bg-opacity-25">
                        <i class="fa-solid fa-bullhorn text-<?php echo $broadcast[0]->color; ?>"></i>
                    </span>
                    <span
                        class="fw-bold ms-2 font-16 text-<?php echo $broadcast[0]->color;?>"><?php echo substr($broadcast[0]->judul, 0, 35); ?><?php if (strlen($broadcast[0]->judul) > 35) echo '...'; ?></span>

                    <div class="mb-2 mt-1">
                        <span
                            class="mb-2 d-block"><?php echo substr($broadcast[0]->pesan, 0, 100); ?><?php if (strlen($broadcast[0]->pesan) > 100) echo '...'; ?></span>
                        <?php if (strlen($broadcast[0]->pesan) <= 100) : ?>
                        <?php if ($broadcast[0]->link1 != null || $broadcast[0]->nama_link1 != null) { ?>
                        <a href="<?php echo $broadcast[0]->link1 ?>"
                            class="btn btn-xs bg-<?php echo $broadcast[0]->color ?> rounded me-1 mt-2"><i
                                class="fa-solid fa-arrow-up-right-from-square me-1"></i><?php echo $broadcast[0]->nama_link1 ?></a>
                        <?php } ?>
                        <?php if ($broadcast[0]->link2 != null || $broadcast[0]->nama_link2 != null) { ?>
                        <a href="<?php echo $broadcast[0]->link2 ?>"
                            class="btn btn-xs bg-<?php echo $broadcast[0]->color ?> rounded me-1 mt-2"><i
                                class="fa-solid fa-arrow-up-right-from-square me-1"></i><?php echo $broadcast[0]->nama_link2 ?></a>
                        <?php } ?>
                        <?php if ($broadcast[0]->link3 != null || $broadcast[0]->nama_link3 != null) { ?>
                        <a href="<?php echo $broadcast[0]->link3 ?>"
                            class="btn btn-xs bg-<?php echo $broadcast[0]->color ?> rounded me-1 mt-2"><i
                                class="fa-solid fa-arrow-up-right-from-square me-1"></i><?php echo $broadcast[0]->nama_link3 ?></a>
                        <?php } ?>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex">
                        <p class="mb-0 fw-bold font-12 text-<?php echo $broadcast[0]->color ?>">
                            <?php echo $broadcast[0]->tanggal_post ?>
                        </p>
                        <?php if (strlen($broadcast[0]->pesan) > 100 || $broadcast[0]->flyer_image != null) : ?>
                        <a href="<?php echo base_url() . 'konsultan/broadcast_list/single_broadcast?id=' . $broadcast[0]->id_broadcast ?>"
                            data-menu="modal_broadcast" class="ms-auto text-<?php echo $broadcast[0]->color ?>">Lihat
                            Selengkapnya</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php //$i++; ?>
            <!-- <?php if ($i == 3) {
                    break;
                } ?> -->
            <?php //endforeach; ?>
            <?php if (count($broadcast) > 1) : ?>
            <a href="<?php echo base_url() . 'konsultan/broadcast_list/'?>" class="card card-style">
                <div class="content text-center my-2">
                    <span>Lihat Semua</span><i class="fa-solid fa-arrow-right ms-2"></i>
                </div>
            </a>
            <?php endif; ?>
            <?php endif; ?>
            <!-- </div>         -->

            <!-- </div> -->

            <div class="content mb-0 mt-0">
                <p class="mb-n1 color-highlight font-600">Informasi Jamaah</p>
                <h1>Keberangkatan Segera</h1>
            </div>
            <?php if($jamaahAgen != NULL) : ?>
            <div class="card card-style">
                <div class="table-content">
                    <table class="table table-borderless list-jamaah" style="width: 100%; padding: 0px 10px 0px 10px;"
                        id="dataTable" style="overflow: hidden;">
                        <thead class="text-center text-dark">
                            <tr class="">
                                <th></th>
                                <th class="text-start border-bottom border-1 border-highlight" style="width: 80%;">
                                    Nama Jamaah</th>
                                <th class="border-bottom border-1 border-highlight">Status</th>
                                <!-- <th class="border-bottom border-1 border-highlight" style="margin:0; width: 5%;"><i
                                        class="fa-solid fa-clipboard-list fa-xl"></i></th>
                                <th class="border-bottom border-1 border-highlight" style="margin:0; width: 5%;"><i
                                        class="fa-solid fa-suitcase-rolling fa-xl"></i></th> -->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <?php else : ?>
            <div class="card card-style mx-3">
                <div class="content">
                    <p>Tidak ada jamaah yang terdaftar</p>
                </div>
            </div>
            <?php endif; ?>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-call">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <span style="font-size: 15px;">Hubungi Kami</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- <div class="col-3 text-center">
                <a href="#"
                    class="mx-auto d-flex justify-content-center align-items-center bg-highlight text-white rounded-circle fs-4"
                    style="width: 50px; height: 50px;" data-menu="menu-call">
                    <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                    <span style="font-size: 15px;">Hubungi Kami</span>
                    <i class="fa fa-angle-right"></i>
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <span class="text-dark">WhatsApp</span>
            </div> -->

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>
        <!-- Page content ends here-->


        <a href="#" data-menu="ad-timed-1" data-timed-ad="0" data-auto-show-ad="5"
            class="btn btn-m btn-full shadow-xl font-600 bg-highlight mb-2 d-none">Auto Show Adds</a>

        <?php if ($view != null) : ?>
        <div id="ad-timed-1" class="menu-ads menu-box-modal menu-box-detached" data-menu-width="330"
            data-menu-height="420" data-menu-effect="menu-over">
            <div class="card-top">
                <a href="#" id="close-ads" class="close-menu ad-time-close shadow-l bg-red-light"><i
                        class="fa fa-times disabled"></i><span></span></a>
            </div>
            <img src="<?php echo base_url() . "uploads/ads/" . $view; ?>" alt="" width="100%" class="shadow-m">
        </div>
        <script>
        setTimeout(function() {
            $('.menu-hider').addClass('menu-active');
        }, 5000);
        </script>
        <?php endif; ?>

        <div id="menu-call" class="menu menu-box-modal rounded-m" data-menu-width="350">
            <div class="menu-title">
                <p class="color-highlight">Untuk beralih ke WhatsApp</p>
                <h1>Silahkan Klik</h1>
                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            </div>
            <div class="content">
                <a href="https://wa.me/62811167565"
                    class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-green-dark text-start mb-2"><span
                        class="ms-n2">Finance</span></a>
                <a href="https://wa.me/628111456485"
                    class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-blue-dark text-start mb-2"><span
                        class="ms-n2">Manifest</span></a>
                <a href="https://wa.me/6285804610529"
                    class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-red-dark text-start mb-2"><span
                        class="ms-n2">Public Relation</span></a>
                <a href="https://wa.me/6285182565540"
                    class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-orange-dark text-start mb-2"><span
                        class="ms-n2">Perlengkapan</span></a>
                <a href="https://wa.me/6281295155670"
                    class="external-link btn btn-l font-14 shadow-l btn-full rounded-s font-600 bg-yellow-dark text-start mb-4"><span
                        class="ms-n2">Help & Support</span></a>
            </div>
        </div>

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

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <!-- <script src="https://cdn.datatables.net/plug-ins/1.13.2/pagination/ellipses.js"></script> -->
    <?php $this->load->view('konsultan/include/script_view'); ?>

    <script>
    $(document).ready(function() {
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

        loadDatatables();

        var countdownIntervals = {};

        function loadDatatables() {
            var dataTable;

            function initCountdown(rowId, endTime) {
                clearInterval(countdownIntervals[rowId]);

                function updateCountdown() {
                    const currentTime = new Date().getTime();
                    const timeLeft = endTime - currentTime;

                    if (timeLeft <= 0) {
                        clearInterval(countdownIntervals[rowId]);
                        $('#countdown' + rowId).html('');
                    } else {
                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        // Ganti ini dengan kode untuk menampilkan countdown dengan benar
                        $('#countdown' + rowId).html(
                            '<div class="text-danger"><i class="fa-solid fa-clock me-1"></i> Booking seat  ' +
                            hours + 'j ' + minutes + 'm ' + seconds + 'd</div>');
                    }
                }


                countdownIntervals[rowId] = setInterval(updateCountdown, 1000);
            }

            var dataTable = $('#dataTable').DataTable({
                pageLength: 10,
                dom: 'fBrtp',
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>konsultan/home/load_jamaah",
                    "data": {
                        id_agen: "<?php echo $_SESSION['id_agen']; ?>",
                    }
                },
                // "oPagination": {
                //     ellipses: {
                //         iShowPages: 2
                //     }
                // },
                columns: [{
                        data: 'dp_expiry_time',
                        visible: false
                    },
                    {
                        data: 'first_name',
                        render: function(data, type, full, meta) {
                            var endTime = new Date(full['dp_expiry_time']).getTime();
                            var rowId = full['DT_RowId'];

                            // console.log('#countdown'+rowId);

                            if (full['lunas'] == 0) {
                                initCountdown(rowId, endTime);
                            }

                            if (full['second_name'] == null) {
                                r1 = ''
                            } else {
                                r1 = full['second_name']
                            }

                            if (full['last_name'] == null) {
                                r2 = ''
                            } else {
                                r2 = full['last_name']
                            }

                            return '<h6>' + data + ' ' + r1 + ' ' + r2 + '</h6>' + '<span>' +
                                full['nama_paket'] +
                                '<br><i class="fa-solid fa-plane-up me-2 color-highlight"></i>' +
                                moment(full['tanggal_berangkat']).locale('id').format('LL') +
                                ' </span>' +
                                `<div id="countdown` + rowId + `" class="mb-1 fw-bold"></div>`
                        }
                    },
                    {
                        data: 'lunas',
                        render: function(data, type, row) {
                            if (data == 1 || data == 3) {
                                icon1 =
                                    '<div class="my-auto"><i class="fa fa-circle-check color-green-light fa-xl text-center"></i></div>'
                            } else {
                                icon1 =
                                    '<div class="my-auto"><i class="fa fa-circle-minus color-red-light fa-xl text-center"></i></div>'
                            }

                            if (row['dokumen'] == 1) {
                                icon2 =
                                    '<div class="my-auto"><i class="fa fa-circle-check color-green-light fa-xl text-center"></i></div>'
                            } else {
                                icon2 =
                                    '<div class="my-auto"><i class="fa fa-circle-minus color-red-light fa-xl text-center"></i></div>'
                            }

                            if (row['perlengkapan'] == 1) {
                                icon3 =
                                    '<div class="my-auto"><i class="fa fa-circle-check color-green-light fa-xl text-center"></i></div>'
                            } else {
                                icon3 =
                                    '<div class="my-auto"><i class="fa fa-circle-minus color-red-light fa-xl text-center"></i></div>'
                            }


                            return '<div class="mb-2"> <div class="d-flex"><span class="me-2">' +
                                icon1 +
                                '</span><span class="text-xxs">Pelunasan</span></div><div class="d-flex"><span class="me-2">' +
                                icon2 +
                                '</span><span class="text-xxs">Dokumen</span></div><div class="d-flex"><span class="me-2">' +
                                icon3 +
                                '</span><span class="text-xxs">Perlengkapan</span></div></div>'
                        }
                    },
                ],
                columnDefs: [{
                    "targets": [1, 2],
                    "orderable": false
                }],
                createdRow: function(row, data, index) {
                    $(row).addClass('custom-row-style');
                },
                order: [
                    [0, 'desc']
                ],
            });
            $('#dataTable tbody').on('mouseenter', 'tr', function() {
                $(this).addClass('hover');
            }).on('mouseleave', 'tr', function() {
                $(this).removeClass('hover');
            });

            $('#dataTable tbody').on('click', 'tr', function() {
                // var rowData = dataTable.row(this).data();
                var rowData = $(this).closest('tr').attr('id_secret');
                window.location.href = `jamaah_info/dp_notice?id=${rowData}`
            });
        }

        $('.counter').each(function() {
            var $this = $(this),
                countTo = $this.attr('data-count');

            $({
                countNum: $this.text()
            }).animate({
                    countNum: countTo
                },

                {
                    duration: 1000,
                    easing: 'linear',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }

                });

        });
    });
    </script>

    <script>
    var firebaseConfig = {
        apiKey: "AIzaSyB-6_F42LEc7yhYxrtwIbVM3YSGMpCO8cU",
        authDomain: "my-app-bd747.firebaseapp.com",
        projectId: "my-app-bd747",
        storageBucket: "my-app-bd747.appspot.com",
        messagingSenderId: "1049171222616",
        appId: "1:1049171222616:web:c39c8d86bb9dba8a04ea2d",
        measurementId: "G-LTP6XBLHHH"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function() {
            console.log("Notification permission granted.");
            // get the token in the form of promise
            return messaging.getToken()
        })
        .then(function(token) {
            $.getJSON("<?php echo base_url() . 'call_notification/getToken';?>", {
                    token: token,
                    id: "<?php echo $_SESSION['id_agen'];?>",
                    user: "k"
                }).done(function(json) {
                    console.log('Berhasil tambah token');
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.log('Token Sudah ada');
                });
            console.log("Device token is : " + token)
        })
        .catch(function(err) {
            // ErrElem.innerHTML = ErrElem.innerHTML + "; " + err
            console.log("Unable to get permission to notify.", err);
        });
    </script>
</body>