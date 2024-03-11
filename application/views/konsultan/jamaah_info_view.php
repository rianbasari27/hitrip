<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/image_1.jpg");
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

    }

    .active .page-link {
        color: white;
        background-color: #edbd5a !important;
    }


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

    .image-container {

        overflow: hidden;
        margin: 0px auto 0px;
        border-radius: 100%;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
    }

    .image-container.small {
        width: 50px;
        height: 50px;
        border: 2px solid #edbd5a;
    }

    .image-container.large {
        width: 120px;
        height: 120px;
        border: 5px solid #edbd5a;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    </style>
    <link href="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">

    <?php
    $tanggalBerangkat = $paket_umroh == NULL ? '' : $paket_umroh->tanggal_berangkat;
    $tanggalPulang = $paket_umroh == NULL ? '' : $paket_umroh->tanggal_pulang;

    $dateBerangkat = strtotime($tanggalBerangkat);
    $datePulang = strtotime($tanggalPulang);

    $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );

    $formattedBerangkat = date("d", $dateBerangkat) . " " . $bulan[date("n", $dateBerangkat)] . date(" Y", $dateBerangkat);
    $formattedPulang = date("d", $datePulang) . " " . $bulan[date("n", $datePulang)] . date(" Y", $datePulang);

    ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>

        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['jamaah_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content pt-0">

            <div class="card card-style">
                <div class="content mb-0">
                    <!-- <p class="color-highlight font-500 mb-1">Informasi Jamaah</p> -->
                    <h1 class="mb-n1"><?= $jamaah->first_name.' '.$jamaah->second_name.' '.$jamaah->last_name ?></h1>
                    <span class="font-14 color-dark-light">No. Virtual Account (BSI) : <strong
                            class="color-highlight fs-5"><?php echo $noVA ;?></strong></span>

                    <div class="divider mt-4 mb-3"></div>
                    <!-- <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Informasi Jamaah</p>
                    <h1><?= $jamaah->first_name.' '.$jamaah->second_name.' '.$jamaah->last_name ?></h1>
                    <span class="fs-4 text-dark">No Virtual Account : <strong><?php echo $noVA ;?></strong></span>
                </div>
            </div> -->
                    <!-- <h4>Program yang terdaftar</h4> -->
                    <?php if ($paket_umroh != NULL) : ?>
                    <div class="d-flex mt-2 mb-4">
                        <div>
                            <img src="<?php echo ($paket_umroh->banner_image) ? base_url() . $paket_umroh->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                                width="100" class="rounded-sm shadow-xl">
                        </div>
                        <div class="ps-3 w-100">
                            <div>
                                <?php for ($i = 0; $i < $paket_umroh->star; $i++) { ?>
                                <i class="fa fa-star color-yellow-dark"></i>
                                <?php } ?>
                            </div>
                            <h4 class="mb-0 color-dark-dark"><?php echo $paket_umroh->nama_paket ?></h4>
                            <span><i class="fa-solid fa-plane-up me-1"></i>
                                <?php echo $this->date->convert("j F Y", $paket_umroh->tanggal_berangkat); ?></span>
                        </div>
                    </div>
                    <?php else : ?>
                    <p class="fs-6 mt-2 mb-4">Tidak ada paket yang sedang aktif.</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($paket_umroh != NULL) : ?>
            <div class="content">
                <!-- <div class="d-flex pt-2">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-18">Layanan Anda</h1>
                    </div>
                </div> -->
                <div class="row text-center">
                    <div class="col-4 pe-2">
                        <?php if ($jamaah->no_wa != NULL) : ?>
                        <a href="https://wa.me/<?= $formattedNumber ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-whatsapp color-green-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">WhatsApp</h5>
                            <span class="font-8 color-dark-light">Hubungi Jamaah</span>
                        </a>
                        <?php else : ?>
                        <a href="#" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-whatsapp color-gray-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14 color-gray-dark">WhatsApp</h5>
                            <span class="font-8 color-dark-light color-gray-dark">Hubungi Jamaah</span>
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?= base_url().'konsultan/riwayat_bayar?id='.$id_secret?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-money-bill color-green-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Pembayaran</h5>
                            <span class="font-8 color-dark-light">Lakukan Pembayaran</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2">
                        <a href="<?= base_url().'konsultan/update_data_jamaah?id='.$id_secret?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-clipboard-list color-blue-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Dokumen</h5>
                            <span class="font-8 color-dark-light">Update Data & Administrasi</span>
                        </a>
                    </div>
                    <div class="col-4 pe-2">
                        <a href="<?= base_url().'konsultan/ambil_perlengkapan/perl_view?id='.$id_secret?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-suitcase-rolling color-yellow-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Perlengkapan</h5>
                            <span class="font-8 color-dark-light">Ambil Perlengkapan</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?= base_url().'konsultan/request_dokumen_konsultan?id='.$id_secret?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-file color-magenta-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Imigrasi</h5>
                            <span class="font-8 color-dark-light">Buat Rekomendasi Imigrasi</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2">
                        <a href="<?= base_url().'konsultan/req_cuti_konsultan?id='.$id_secret?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-file-pen color-teal-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Cuti</h5>
                            <span class="font-8 color-dark-light">Buat Surat Cuti</span>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="card card-style">
                <div class="content">
                    <p class="color-highlight font-500 mb-0">Status Kesiapan Administrasi</p>
                    <h3 class="mb-0">Syarat Keberangkatan</h3>
                    <div class="row text-center">
                        <div class="col-4 pe-2">
                            <span href="https://wa.me/<?= $formattedNumber ?>" class="py-4 mx-0 mb-3">
                                <i class="fa-solid 
                                        <?php echo $member->lunas == 1 || $member->lunas == 3 ? 'fa-circle-check' : 'fa-circle-minus' ?>
                                        fa-circle-check text-dark fs-5 d-block mb-2 
                                        <?php echo $member->lunas == 1 || $member->lunas == 3 ? 'color-green-light' : 'color-red-light' ?>"
                                    style="position: relative; top: 48px; left: 10px;">
                                </i>
                                <i class="fa-solid fa-credit-card fa-2x color-dark-dark mb-3"></i>
                                <h5 class="mb-0 font-14 color-dark-dark">Pelunasan</h5>
                            </span>
                        </div>
                        <div class="col-4 ps-2 pe-2">
                            <span href="<?= base_url().'konsultan/riwayat_bayar?id='.$id_secret?>"
                                class="py-4 mx-0 mb-3">
                                <i class="fa-solid 
                                        <?php echo $jamaah->verified == 1 && $member->verified == 1 ? 'fa-circle-check' : 'fa-circle-minus' ?>
                                        fa-circle-check text-dark fs-5 d-block mb-2 
                                        <?php echo $jamaah->verified == 1 && $member->verified == 1 ? 'color-green-light' : 'color-red-light' ?>"
                                    style="position: relative; top: 48px; left: 10px;">
                                </i>
                                <i class="fa-solid fa-file-lines fa-2x color-dark-dark mb-3"></i>
                                <h5 class="mb-0 font-14 color-dark-dark">Dokumen</h5>
                            </span>
                        </div>
                        <div class="col-4 ps-2">
                            <span href="<?= base_url().'konsultan/update_data_jamaah?id='.$id_secret?>"
                                class="py-4 mx-0 mb-3">
                                <i class="fa-solid 
                                        <?php echo $perlengkapan == "Sudah Semua" ? 'fa-circle-check' : 'fa-circle-minus' ?>
                                        fa-circle-check text-dark fs-5 d-block mb-2 
                                        <?php echo $perlengkapan == "Sudah Semua" ? 'color-green-light' : 'color-red-light' ?>"
                                    style="position: relative; top: 48px; left: 10px;">
                                </i>
                                <i class="fa-solid fa-suitcase fa-2x color-dark-dark mb-3"></i>
                                <h5 class="mb-0 font-14 color-dark-dark">Perlengkapan</h5>
                            </span>
                        </div>
                    </div>

                    <div class="card card-style mt-4 mb-2 bg-gray-light">
                        <div class="my-2 px-2">
                            <div class="ms-1 color-dark-dark fw-bold mb-n2">Catatan:</div>
                            <div class="ms-1 color-dark-dark icon-xs mb-n2"><i
                                    class="fa-solid fa-circle-check color-green-dark text-center"></i> Sudah Lengkap /
                                Sudah Memenuhi</div>
                            <div class="ms-1 color-dark-dark icon-xs mb-n2"><i
                                    class="fa-solid fa-circle-minus color-red-light text-center"></i> Belum Lengkap /
                                Belum Memenuhi</div>
                        </div>
                    </div>

                    <!-- <div class="row text-center">
                        <div class="col-4 pe-2">
                            <a href="https://wa.me/<?= $formattedNumber ?>" class="py-4 mx-0 mb-3">
                                <span class="fa fa-stack fa-2x mb-2 pb-2 mx-auto">
                                    <i class="fa-solid fa-credit-card fa-stack-1x text-dark"></i>
                                    <i class="fa-regular fa-circle-check fa-stack-2x fa-2x" style="color:green"></i>
                                </span>
                                <h5 class="mb-0">Pelunasan</h5>
                                <span class="font-8"><?php echo $formattedNumber ;?></span>
                            </a>
                        </div>
                        <div class="col-4 ps-2 pe-2">
                            <a href="<?= base_url().'konsultan/riwayat_bayar?id='.$id_secret?>"
                                class="py-4 mx-0 mb-3">
                                <span class="fa fa-stack fa-2x mb-2 pb-2 mx-auto">
                                    <i class="fa-solid fa-file-lines fa-stack-1x text-dark"></i>
                                    <i class="fa-regular fa-circle-check fa-stack-2x fa-2x" style="color:green"></i>
                                </span>
                                <h5 class="mb-0">Dokumen</h5>
                                <span class="font-8">Lakukan Pembayaran</span>
                            </a>
                        </div>
                        <div class="col-4 ps-2">
                            <a href="<?= base_url().'konsultan/update_data_jamaah?id='.$id_secret?>"
                                class="py-4 mx-0 mb-3">
                                <span class="fa fa-stack fa-2x mb-2 pb-2 mx-auto">
                                    <i class="fa-solid fa-suitcase fa-stack-1x text-dark"></i>
                                    <i class="fa-regular fa-circle-xmark fa-stack-2x fa-2x" style="color:red"></i>
                                </span>
                                <h5 class="mb-0">Perlengkapan</h5>
                                <span class="font-8">Update Data & Administrasi</span>
                            </a>
                        </div>
                    </div> -->

                </div>
            </div>

            <!-- <?php if ($paket_umroh != NULL) : ?>
            <div class="card card-style">
                <div class="content">
                    <p class="mb-0 font-600 color-highlight">Status Kesiapan Administrasi</p>
                    <h1 class="mb-3">Syarat Keberangkatan</h1>

                    <div class="d-flex mb-4">
                        <div class="align-self-center me-0"><i
                                class="fa fa-<?= $member->lunas == 1 || $member->lunas == 3 ? 'circle-check' : 'circle-minus'; ?> color-<?= $member->lunas == 1 || $member->lunas == 3 ? 'green-dark' : 'red-light'; ?> fa-4x icon-70 text-center"></i>
                        </div>
                        <div class="me-auto ps-4">
                            <h4>Pelunasan</h4>
                            <p>Jamaah <span
                                    class="fw-bold <?= $member->lunas == 1 || $member->lunas == 3 ? 'text-success' : 'text-danger'; ?>"><?= $member->lunas == 1 || $member->lunas == 3 ? 'telah melunasi' : 'belum melunasi'; ?></span>
                                pembayaran.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="align-self-center me-0"><i
                                class="fa fa-<?= $jamaah->verified == 1 && $member->verified == 1 ? 'circle-check' : 'circle-minus'; ?> color-<?= $jamaah->verified == 1 && $member->verified == 1 ? 'green-dark' : 'red-light'; ?> fa-4x icon-70 text-center"></i>
                        </div>
                        <div class="me-auto ps-4">
                            <h4>Data & Dokumen</h4>
                            <p>Jamaah <span
                                    class="fw-bold <?= $jamaah->verified == 1 && $member->verified == 1 ? 'text-success' : 'text-danger'; ?>"><?= $jamaah->verified == 1 && $member->verified == 1 ? 'telah melengkapi' : '<a href="' . base_url().'konsultan/update_data_jamaah?id='.$id_secret . '" class="text-danger" > belum melengkapi</a>'; ?></span>
                                data dan dokumen.</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <div class="align-self-center me-0"><i
                                class="fa fa-<?= $perlengkapan == "Sudah Semua" ? 'circle-check' : 'circle-minus'; ?> color-<?= $perlengkapan == "Sudah Semua" ? 'green-dark' : 'red-light'; ?> fa-4x icon-70 text-center"></i>
                        </div>
                        <div class="me-auto ps-4">
                            <h4>Perlengkapan</h4>
                            <p>Jamaah <span
                                    class="fw-bold <?= $perlengkapan == "Sudah Semua" ? 'text-success' : 'text-danger'; ?>"><?= $perlengkapan == "Sudah Semua" ? 'telah mengambil' : 'belum mengambil'; ?></span>
                                perlengkapan.</p>
                        </div>
                    </div>
                    <div class="card card-style mt-4 bg-dark-light">
                        <div>
                            <div class="ms-4 mt-2">Catatan:</div>
                            <div class="ms-1 color-white icon-xs"><i
                                    class="fa-solid fa-circle-check color-green-dark text-center"></i> Sudah Lengkap /
                                Sudah Memenuhi</div>
                            <div class="ms-1 color-white icon-xs"><i
                                    class="fa-solid fa-circle-minus color-red-light text-center"></i> Belum Lengkap /
                                Belum Memenuhi</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?> -->
            <!-- <div class="content">
                <div class="d-flex pt-2">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-18">Syarat Keberangkatan</h1>
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col-4 pe-2">
                        <a href="https://wa.me/<?= $formattedNumber ?>" class="card card-style py-4 mx-0 mb-3">
                            <span class="fa fa-stack fa-2x mb-2 pb-2 mx-auto">
                                <i class="fa-solid fa-credit-card fa-stack-1x text-dark"></i>
                                <i class="fa-regular fa-circle-check fa-stack-2x fa-2x" style="color:green"></i>
                            </span>
                            <h5 class="mb-0">Pelunasan</h5>
                            <span class="font-8"><?php echo $formattedNumber ;?></span>
                        </a>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?= base_url().'konsultan/riwayat_bayar?id='.$id_secret?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <span class="fa fa-stack fa-2x mb-2 pb-2 mx-auto">
                                <i class="fa-solid fa-file-lines fa-stack-1x text-dark"></i>
                                <i class="fa-regular fa-circle-check fa-stack-2x fa-2x" style="color:green"></i>
                            </span>
                            <h5 class="mb-0">Dokumen</h5>
                            <span class="font-8">Lakukan Pembayaran</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2">
                        <a href="<?= base_url().'konsultan/update_data_jamaah?id='.$id_secret?>"
                            class="card card-style py-4 mx-0 mb-3">
                            <span class="fa fa-stack fa-2x mb-2 pb-2 mx-auto">
                                <i class="fa-solid fa-suitcase fa-stack-1x text-dark"></i>
                                <i class="fa-regular fa-circle-xmark fa-stack-2x fa-2x" style="color:red"></i>
                            </span>
                            <h5 class="mb-0">Perlengkapan</h5>
                            <span class="font-8">Update Data & Administrasi</span>
                        </a>
                    </div>
                </div>
            </div> -->


            <!-- <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <?php if ($jamaah->no_wa == NULL) : ?>
                        <a href="#">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <p class="fw-normal">Tidak ada nomor WhatsApp yang terdaftar</p>
                        </a>
                        <?php else : ?>
                        <a href="https://wa.me/<?= $formattedNumber ?>">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <span style="font-size: 15px;"><?= $formattedNumber.' ('.$jamaah->first_name.')'?></span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <?php endif; ?>

                        <?php if ($paket_umroh != NULL) : ?>

                        <a href="<?= base_url().'konsultan/riwayat_bayar?id='.$id_secret?>">
                            <i
                                class="fa-solid fa-server icon icon-xs rounded-sm shadow-l mr-1 bg-success text-white"></i>
                            <span style="font-size: 15px;">Pembayaran</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="<?= base_url().'konsultan/update_data_jamaah?id='.$id_secret?>">
                            <i
                                class="fa-solid fa-clipboard-list icon icon-xs rounded-sm shadow-l mr-1 bg-primary text-white"></i>
                            <span style="font-size: 15px;">Input Data Administrasi</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="<?= base_url().'konsultan/request_dokumen_konsultan?id='.$id_secret?>">
                            <i class="fa-solid fa-file icon icon-xs rounded-sm shadow-l mr-1 bg-warning text-white"></i>
                            <span style="font-size: 15px;">Rekomendasi Imigrasi</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <?php if ($statusBisaAmbil == false) : ?>
                        <a href="#" data-menu="menu-perlengkapan">
                            <i
                                class="fa-solid fa-suitcase-rolling icon icon-xs rounded-sm shadow-l mr-1 bg-gray-light text-white"></i>
                            <p class="fw-normal color-red-dark">Belum bisa mengambil perlengkapan</p>
                        </a>
                        <?php else : ?>
                        <a href="<?= base_url().'konsultan/ambil_perlengkapan?id='.$id_secret?>">
                            <i
                                class="fa-solid fa-suitcase-rolling icon icon-xs rounded-sm shadow-l mr-1 bg-danger text-white"></i>
                            <span style="font-size: 15px;">Ambil Perlengkapan</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <?php endif; ?>
                        <a href="<?= base_url().'konsultan/req_cuti_konsultan?id='.$id_secret?>">
                            <i
                                class="fa-solid fa-file-pen icon icon-xs rounded-sm shadow-l mr-1 bg-info text-white"></i>
                            <span style="font-size: 15px;">Surat Cuti</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div> -->

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-video">
                            <i class="color-icon-gray font-20 icon-40 text-center fab fa-youtube color-red-dark"></i>
                            <span>Lihat Video Tutorial</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>

    </div>

    <!-- Modal Belum Bisa Ambil Perlengkapan -->
    <div id="menu-perlengkapan" class="menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
        <div class="menu-title">
            <i class="fa fa-times-circle float-start me-3 scale-box ms-3 fa-4x color-red-dark"></i>
            <p class="color-highlight">Belum bisa mengambil perlengkapan</p>
            <h1>Isi data Jamaah</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mb-0 mt-0">
            <span>
                <strong>Data keluarga atau group Jamaah Anda belum lengkap.</strong> Silahkan untuk melengkapi data
                Jamaah berikut untuk membuka menu "Ambil Perlengkapan"
            </span>
            <div class="list-group list-custom-small">
                <?php foreach ($parentMembers as $pm) : ?>
                <a
                    href="<?= base_url().'konsultan/jamaah_info/incomplete_data?id='.$pm->jamaahData->member[0]->idSecretMember?>">
                    <i class="fa-solid fa-user icon icon-xs rounded-sm shadow-l mr-1 bg-highlight text-white"></i>
                    <span
                        style="font-size: 15px;"><?php echo implode(' ', array_filter([$pm->jamaahData->first_name, $pm->jamaahData->second_name, $pm->jamaahData->last_name])) ?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- <div id="menu-perlengkapan" 
         class="menu menu-box-modal rounded-m" 
         data-menu-height="380" 
         data-menu-width="350">
        <div class="menu-title">
            <p class="color-highlight">Belum bisa mengambil perlengkapan</p>
            <h1>Isi data Jamaah</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-n2">
            <span>
                Data keluarga atau group Jamaah Anda belum lengkap. Silahkan untuk melengkapi data Jamaah berikut untuk membuka menu "Ambil Perlengkapan"
            </span>
            <div class="list-group list-custom-small">
                <a href="<?= base_url().'konsultan/request_dokumen_konsultan?id='.$id_secret?>">
                    <i class="fa-solid fa-file icon icon-xs rounded-sm shadow-l mr-1 bg-warning text-white"></i>
                    <span style="font-size: 15px;">Rekomendasi Imigrasi</span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
    </div>    -->

    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="320" data-menu-width="350">
        <div class='responsive-iframe max-iframe'>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/cWkIYnPVM0c?si=KxXsvsrD_soFk-yl"
                frameborder="0" allowfullscreen></iframe>
            <!-- <iframe src='https://www.youtube.com/embed/c9MnSeYYtYY' frameborder='0' allowfullscreen></iframe> -->
        </div>
        <div class="menu-title">
            <p class="color-highlight">Video Tutorial</p>
            <h1>Tutorial Aplikasi<br>Ventour Mobile</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-n2">
            <!-- <p>
                It's super easy to embed videos. Just copy the embed!
            </p> -->
            <!-- <a href="#" class="close-menu btn btn-full btn-m shadow-l rounded-s text-uppercase font-600 gradient-green mt-n2">Awesome</a> -->
        </div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <?php $this->load->view('konsultan/include/script_view'); ?>
</body>