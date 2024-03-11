<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
        .bg-home {
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/bg_kuning.jpg");
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

        .toast-tiny {
            width: 70%;
        }
    </style>
    <?php
    function indo($tanggal)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    };
    ?>
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
        <?php $this->load->view('jamaahv2/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu', ['menuBC' => true, 'countBc' => $countBc]); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style bg-highlight bg-home">
                <div class="content">
                    <span class="font-14 mb-n1 fw-bold" style="color: black !important;">Assalamu'alaikum</span>
                    <h1 class="font-28 mb-5 text-dark"><?php echo implode(' ', [$jamaahData->first_name, $jamaahData->second_name, $jamaahData->last_name]); ?></h1>
                    <span style="color: black !important;" class="text-dark font-15 mb-0 fw-bold"><?php echo $memberData->paket_info->nama_paket; ?></span><br>
                    <span style="color: black !important;" class="text-dark font-12"><i class="fa-solid fa-plane-up me-2"></i><?php echo date_format(date_create($memberData->paket_info->tanggal_berangkat), "d F Y") . ' ( ' . $memberData->paket_info->countdown . ' )'; ?></span>
                    <!-- <p class="opacity-70 line-height-s font-15 text-dark">
                        <?php echo $memberData->paket_info->nama_paket; ?><br>
                        <?php echo 'Keberangkatan ' . date_format(date_create($memberData->paket_info->tanggal_berangkat), "d F Y") . ' ( ' . $memberData->paket_info->countdown . ' )'; ?>
                    </p> -->
                </div>
            </div>

            <!-- <div data-card-height="240" class="card card-style bg-home">

                <div class="card-center text-start ps-3 pt-4">
                    <h1 class="color-white font-22 mb-0 opacity-70">Assalamu'alaikum</h1>
                    <h1 class="color-white font-36 mb-5">
                        <?php echo $jamaahData->first_name; ?></h1>
                </div>
                <div class="card-bottom text-end pe-3">
                    <p class="color-white mb-3 opacity-70 line-height-s font-15">
                        <?php echo $memberData->paket_info->nama_paket; ?><br>
                        <?php echo 'Keberangkatan ' . date_format(date_create($memberData->paket_info->tanggal_berangkat), "d F Y") . ' ( ' . $memberData->paket_info->countdown . ' )'; ?>
                    </p>
                </div>
                <div class="card-overlay bg-gradient opacity-60"></div>
            </div> -->

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

            <!-- Menu slider -->
            <?php //$this->load->view('jamaahv2/include/slide_menu'); 
            ?>
            <!--  -->

            <?php if ($displayBroadcast == true) { ?>
                <?php if ($DPStatus == false && (!empty($logBelumAmbil))) { ?>
                    <div class="content mt-0">
                        <div class="card card-style bg-yellow-light my-3" style="position:relative;margin:0px 1px 30px 1px;height: fit-content;">
                            <div class="content">
                                <?php if (!empty($logBelumAmbil)) { ?>
                                    <h5 class="opacity-80">
                                        <i class="opacity-100 fa fa-suitcase-rolling fa-xl icon-40 text-center"></i>
                                        Perlengkapan Yang Belum diambil
                                    </h5>
                                    <div class="divider mt-3 mb-3"></div>
                                    <h5 class="opacity-70 mb-1">
                                        <?php $ambilList = []; ?>
                                        <?php foreach ($logBelumAmbil as $blmAmbil) { ?>
                                            <?php $ambilList[] = $blmAmbil->nama_barang; ?>
                                        <?php } ?>
                                        <?php echo ucwords(strtolower(implode(", ", $ambilList))); ?>
                                    </h5>
                                <?php } ?>
                                <p>
                                    Jadwalkan pengambilan pada menu
                                    <a href="<?php echo base_url() . 'jamaah/perlengkapan'; ?>">Perlengkapan</a>
                                </p>

                                <?php if (!empty($tanggalAmbilPending)) { ?>
                                    <h5 class="opacity-80 text-danger">
                                        Ambil perlengkapan pada<span class="text-success">
                                            <?php echo $tanggalAmbilPending; ?></span>
                                    </h5>
                                    <div class="divider mt-3 mb-3"></div>
                                    <h5 class="opacity-70 mb-3 text-center">Belum ada yang bisa diambil</h5>
                                <?php } ?>
                                <?php if (!empty($tanggalAmbilSiap)) { ?>
                                    <h5 class="opacity-80 text-danger">
                                        Ambil perlengkapan pada<span class="text-success">
                                            <?php echo $tanggalAmbilSiap; ?></span>
                                    </h5>
                                    <div class="divider mt-3 mb-3"></div>
                                    <h5 class="opacity-70 mb-3 text-center">
                                        <?php $siapList = []; ?>
                                        <?php foreach ($listSiapAmbil as $lsa) { ?>
                                            <?php $siapList[] = $lsa->nama_barang; ?>
                                        <?php } ?>
                                        <?php echo ucwords(strtolower(implode(", ", $siapList))); ?>
                                    </h5>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            <?php } ?>

            <div class="content mt-0 mb-0">
                <!-- <div class="card card-style mb-3 mx-0 bg-warning">
                    <div class="content my-0">
                        </div>
                    </div> -->
                <h1 class="font-14 my-0">Kelola Umroh</h1>
                <div class="divider mb-3"></div>
                <!-- <div class="d-flex pt-2">
                    <div class="align-self-center">
                        <h1 class="mb-0 font-18">Layanan Anda</h1>
                    </div>
                </div> -->
                <div class="row text-center mb-0">
                    <div class="col-4 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/paket' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-layer-group color-orange-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Paket</h5>
                            <span class="font-8 color-dark-light">Paket Anda</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/pembayaran' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-money-bill color-green-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Pembayaran</h5>
                            <span class="font-8 color-dark-light">Lakukan Pembayaran</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2">
                        <a href="<?php echo base_url() . 'jamaah/dokumen' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-clipboard-list color-blue-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Dokumen</h5>
                            <span class="font-8 color-dark-light">Update Data & Administrasi</span>
                        </a>
                    </div>
                    <div class="col-4 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/perlengkapan' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-suitcase-rolling color-yellow-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Perlengkapan</h5>
                            <span class="font-8 color-dark-light">Ambil Perlengkapan</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/req_dokumen' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-file color-magenta-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Imigrasi</h5>
                            <span class="font-8 color-dark-light">Buat Rekomendasi Imigrasi</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2">
                        <a href="<?php echo base_url() . 'jamaah/req_cuti' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-file-pen color-teal-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Cuti</h5>
                            <span class="font-8 color-dark-light">Buat Surat Cuti</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="content mt-0">
                <h1 class="font-14 my-0">Lainnya</h1>
                <div class="divider mb-3"></div>
                <div class="row text-center mb-0">
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/surat_doa' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-book-quran color-green-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Al-Qur'an</h5>
                            <span class="font-8 color-dark-light">Baca Al-Qur'an</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2">
                        <a href="<?php echo base_url() . 'jamaah/surat_doa/doa' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-person-praying color-magenta-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Doa</h5>
                            <span class="font-8 color-dark-light">Doa Harian & Umroh</span>
                        </a>
                    </div>
                    <div class="col-4 ps-2 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/surat_doa/tasbih' ?>" class="card card-style py-4 mx-0 mb-3">
                            <img src="<?php echo base_url() . 'asset/appkit/images/beads.svg' ?>" width="25px" class="mx-auto pb-2 mb-2 d-block" alt="">
                            <h5 class="mb-0 font-14">Dzikir</h5>
                            <span class="font-8 color-dark-light">Penghitung Dzikir</span>
                        </a>
                    </div>
                    <div class="col-4 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/kontak' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-location-dot color-red-light fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Kontak</h5>
                            <span class="font-8 color-dark-light">Kontak Kami</span>
                        </a>
                    </div>
                    <div class="col-4 pe-2">
                        <a href="<?php echo base_url() . 'jamaah/jamaah' ?>" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-user color-teal-dark fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Jamaah</h5>
                            <span class="font-8 color-dark-light">Jamaah</span>
                        </a>
                    </div>
                    <div class="col-4 pe-2">
                        <a href="https://wa.me/6281295155670" data-menu="menu-call" class="card card-style py-4 mx-0 mb-3">
                            <i class="fa fa-whatsapp color-whatsapp fa-2x mb-2 pb-2"></i>
                            <h5 class="mb-0 font-14">Hubungi Kami</h5>
                            <span class="font-8 color-dark-light">Hubungi Kami</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <p class="color-highlight font-500 mb-0">Status Kesiapan Administrasi</p>
                    <h3 class="mb-0">Syarat Keberangkatan</h3>
                    <div class="row text-center">
                        <div class="col-4 pe-2">
                            <span class="py-4 mx-0 mb-3">
                                <i class="fa-solid 
                                        <?php echo $memberData->lunas == 1 || $memberData->lunas == 3 ? 'fa-circle-check' : 'fa-circle-minus' ?>
                                        fa-circle-check text-dark fs-5 d-block mb-2 
                                        <?php echo $memberData->lunas == 1 || $memberData->lunas == 3 ? 'color-green-light' : 'color-red-light' ?>" style="position: relative; top: 48px; left: 10px;">
                                </i>
                                <i class="fa-solid fa-credit-card fa-2x color-dark-dark mb-3"></i>
                                <h5 class="mb-0 font-14 color-dark-dark">Pelunasan</h5>
                            </span>
                        </div>
                        <div class="col-4 ps-2 pe-2">
                            <span href="<?php //echo base_url().'konsultan/riwayat_bayar?id='.$id_secret
                                        ?>" class="py-4 mx-0 mb-3">
                                <i class="fa-solid 
                                        <?php echo $jamaahData->verified == 1 && $memberData->verified == 1 ? 'fa-circle-check' : 'fa-circle-minus' ?>
                                        fa-circle-check text-dark fs-5 d-block mb-2 
                                        <?php echo $jamaahData->verified == 1 && $memberData->verified == 1 ? 'color-green-light' : 'color-red-light' ?>" style="position: relative; top: 48px; left: 10px;">
                                </i>
                                <i class="fa-solid fa-file-lines fa-2x color-dark-dark mb-3"></i>
                                <h5 class="mb-0 font-14 color-dark-dark">Dokumen</h5>
                            </span>
                        </div>
                        <div class="col-4 ps-2">
                            <span href="<?php //echo base_url().'konsultan/update_data_jamaah?id='.$id_secret
                                        ?>" class="py-4 mx-0 mb-3">
                                <i class="fa-solid 
                                        <?php echo $checklistData['perlengkapan'] ? 'fa-circle-check' : 'fa-circle-minus' ?>
                                        fa-circle-check text-dark fs-5 d-block mb-2 
                                        <?php echo $checklistData['perlengkapan'] ? 'color-green-light' : 'color-red-light' ?>" style="position: relative; top: 48px; left: 10px;">
                                </i>
                                <i class="fa-solid fa-suitcase fa-2x color-dark-dark mb-3"></i>
                                <h5 class="mb-0 font-14 color-dark-dark">Perlengkapan</h5>
                            </span>
                        </div>
                    </div>

                    <div class="card card-style mt-4 mb-2 bg-gray-light">
                        <div class="my-2 px-2">
                            <div class="ms-1 color-dark-dark fw-bold mb-n2">Catatan:</div>
                            <div class="ms-1 color-dark-dark icon-xs mb-n2"><i class="fa-solid fa-circle-check color-green-dark text-center"></i> Sudah Lengkap /
                                Sudah Memenuhi</div>
                            <div class="ms-1 color-dark-dark icon-xs mb-n2"><i class="fa-solid fa-circle-minus color-red-light text-center"></i> Belum Lengkap /
                                Belum Memenuhi</div>
                        </div>
                    </div>

                    <!-- <div class="row text-center">
                        <div class="col-4 pe-2">
                            <a href="https://wa.me/<?php //echo $formattedNumber 
                                                    ?>" class="py-4 mx-0 mb-3">
                                <span class="fa fa-stack fa-2x mb-2 pb-2 mx-auto">
                                    <i class="fa-solid fa-credit-card fa-stack-1x text-dark"></i>
                                    <i class="fa-regular fa-circle-check fa-stack-2x fa-2x" style="color:green"></i>
                                </span>
                                <h5 class="mb-0">Pelunasan</h5>
                                <span class="font-8"><?php echo $formattedNumber; ?></span>
                            </a>
                        </div>
                        <div class="col-4 ps-2 pe-2">
                            <a href="<?= base_url() . 'konsultan/riwayat_bayar?id=' . $id_secret ?>"
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
                            <a href="<?= base_url() . 'konsultan/update_data_jamaah?id=' . $id_secret ?>"
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

            <!-- <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-call">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <span style="font-size: 15px;">Customer Care</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div> -->


            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
        </div>

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <div id="article-1" class="menu menu-box-top menu-box-bottom-full rounded-0" data-menu-width="cover" data-menu-height="cover">
        <div class="card-top pt-4 ps-3 pe-3">
            <!-- <h3>Pengumuman</h3> -->
            <span class="font-26 my-auto fw-bold color-dark-dark">Pengumuman</span>
            <a href="#" class="close-menu float-end icon icon-s rounded-l bg-red-dark"><i class="fa fa-xmark"></i></a>
        </div>
        <div style="margin-top: 80px;">
            <?php foreach ($broadcast as $bc) : ?>
                <a href="<?php echo base_url() . 'jamaah/home_user/single_broadcast?id=' . $bc->id_broadcast ?>" class="card card-style bg-opacity-10 mb-3" style="position:relative; height:fit-content;">
                    <div class="content pb-3">
                        <span class="p-2 rounded-circle bg-<?php echo $bc->color; ?> bg-opacity-25">
                            <i class="fa-solid fa-bullhorn text-<?php echo $bc->color; ?>"></i>
                        </span>
                        <span class="fw-bold ms-2 font-16 text-<?php echo $bc->color; ?>"><?php echo substr($bc->judul, 0, 35); ?><?php if (strlen($bc->judul) > 35) echo '...'; ?></span>

                        <div class="mb-2 mt-1">
                            <span class="color-dark-dark"><?php echo substr($bc->pesan, 0, 100); ?><?php if (strlen($bc->pesan) > 100) echo '...'; ?></span>
                        </div>
                        <div class="d-flex">
                            <span class="mb-0 fw-bold font-12 text-<?php echo $bc->color ?>"><?php echo $bc->tanggal_post ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>


    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaahv2/include/script_view'); ?>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
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
                $.getJSON("<?php echo base_url() . 'call_notification/getToken'; ?>", {
                        token: token,
                        id: "<?php echo $_SESSION['id_member']; ?>",
                        user: "j"
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