<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/mecca.jpg");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['pembayaran_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <!-- <div class="page-content"> -->

        <div id="tab-group-1">

            <!-- <div class="card card-style bg-theme pb-0"> -->
                <div class="content mb-4 mt-0">
                    <div class="tab-controls tabs-small" data-highlight="bg-highlight">
                        <a href="#" id="info" data-active data-bs-toggle="collapse" data-bs-target="#tab-1" class="me-1 shadow rounded-s">Informasi
                            Tagihan</a>
                        <a href="#" id="history" data-bs-toggle="collapse" data-bs-target="#tab-2" class="ms-1 shadow rounded-s">Riwayat Bayar</a>
                    </div>
                </div>
            <!-- </div> -->

            <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1">
                <div class="card card-style">
                    <div class="content">

                        <div class="d-flex mb-3">
                            <div class="mt-1">
                                <p class="color-highlight font-600 mb-n1">Riwayat Bayar</p>
                                <h3>Informasi Tagihan</h3>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div>
                                <img src="<?php echo ($tarif['dataMember'][$id_member]['detailJamaah']->member[0]->paket_info->banner_image) ? base_url() . $tarif['dataMember'][$id_member]['detailJamaah']->member[0]->paket_info->banner_image : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                                    width="120" class="rounded-s shadow-xl">
                            </div>
                            <div class="ps-3 w-100">
                                <div>
                                    <?php for ($i = 0; $i < $tarif['dataMember'][$id_member]['detailJamaah']->member[0]->paket_info->star; $i++) { ?>
                                    <i class="fa fa-star color-yellow-dark"></i>
                                    <?php } ?>
                                </div>
                                <h2 class="mb-0">
                                    <?php echo $tarif['dataMember'][$id_member]['detailJamaah']->member[0]->paket_info->nama_paket ?>
                                </h2>
                                <span>
                                    <?php echo $this->date->convert("j F Y", $tarif['dataMember'][$id_member]['detailJamaah']->member[0]->paket_info->tanggal_berangkat); ?></span>
                                <h5>x<?php echo count($tarif['dataMember']) ?></h5>
                            </div>
                        </div>

                        <div class="row mb-0 mt-4">
                            <?php foreach ($tarif['dataMember'] as $j) : ?>
                            <h5 class="col-7 mt-1 mb-0 text-start font-15">
                                <?php echo implode(' ', array_filter([$j['detailJamaah']->first_name, $j['detailJamaah']->second_name, $j['detailJamaah']->last_name])); ?>
                            </h5>
                            <h5 class="col-5 mt-1 mb-0 text-end font-15 opacity-80 font-700">
                                <?php echo 'Rp. ' . number_format($j['baseFee']['harga'], 0, ',', '.') . ',-'; ?></h5>
                            <?php if ($j['dendaProgresif'] != 0) : ?>
                            <span class="ps-4 mt-0 d-block col-7 text-start font-11">Denda Progresif</span>
                            <span
                                class="col-5 text-end d-block font-14 opacity-80 font-300"><?php echo 'Rp. ' . number_format($j['dendaProgresif'], 0, ',', '.') . ',-'; ?></span>
                            <?php endif; ?>
                            <?php foreach ($j['extraFee'] as $ef) : ?>
                            <span
                                class="ps-4 mt-0 d-block col-7 text-start font-11"><?php echo $ef->keterangan ?></span>
                            <span
                                class="col-5 text-end d-block font-14 opacity-80 font-300"><?php echo 'Rp. ' . number_format($ef->nominal, 0, ',', '.') . ',-'; ?></span>
                            <?php endforeach; ?>
                            <?php endforeach; ?>

                        </div>

                        <div class="divider mb-2 mt-4"></div>

                        <div class="d-flex mb-2">
                            <div>
                                <h5 class="font-700 color-green-dark">Total Sudah Bayar</h5>
                            </div>
                            <div class="ms-auto">
                                <h5 class="color-green-dark">Rp.
                                    <?php echo number_format($totalBayar, 0, ',', '.'); ?>,-</h5>
                            </div>
                        </div>

                        <div class="d-flex mb-2">
                            <div>
                                <h3 class="font-700 ">Sisa Tagihan</h3>
                            </div>
                            <div class="ms-auto">
                                <h3>Rp. <?php echo number_format($sisaTagihan, 0, ',', '.'); ?>,-</h3>
                            </div>
                        </div>

                        <!-- <a href="#" id="riwayat" data-bs-toggle="collapse" data-bs-target="#tab-2" class="btn btn-full btn-s d-block rounded-s font-600 gradient-highlight mb-2">Riwayat Bayar</a> -->
                        <!-- <a href="<?php echo base_url() . "jamaah/kuitansi_dl/download?id=" . $byr->id_secret; ?>" class="btn btn-full btn-s d-block rounded-s font-600 gradient-highlight mb-2"><i class="fa-solid fa-file-arrow-down"></i> Download Invoice</a> -->

                    </div>
                </div>
            </div>

            <div>
                <?php foreach ($data as $item) : ?>
                <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">
                    <div class="card card-style p-3 mb-3">
                        <a href="#" data-menu="inv<?php echo $item->id_pembayaran?>" class="d-flex">
                            <!-- <div class="align-self-center">
                    <span class="icon icon-s gradient-green color-white rounded-sm shadow-xxl"><i class="fab fa-spotify font-20"></i></span>
                </div> -->
                            <div class="align-self-center">
                                <h5 class="mb-n1 font-15"><?php echo $item->keterangan ?></h5>
                                <span class="font-11 color-theme opacity-70"">Kode Pembayaran #<?php echo $item->id_pembayaran . '-' . $item->id_member . '-' . date('y', strtotime($item->tanggal_bayar)) . date('m', strtotime($item->tanggal_bayar)) . date('d', strtotime($item->tanggal_bayar)) ?></span>
                </div>
                <div class=" ms-auto text-end align-self-center">
                                    <h5 class="color-theme font-15 font-700 d-block mb-n1">
                                        <?php echo number_format($item->jumlah_bayar, 0, ',', '.') ?></h5>
                                    <span
                                        class="color-green-dark font-11"><?php echo $this->date->convert("j F Y", $item->tanggal_bayar) ?>
                                        <i class="fa fa-check-circle"></i></span>
                            </div>
                        </a>

                        <!-- Invoice Menu-->
                    </div>
                </div>

                <div id="inv<?php echo $item->id_pembayaran; ?>" class="menu menu-box-bottom rounded-m bg-white"
                    data-menu-height="420">
                    <div class="menu-title">
                        <p class="color-highlight font-600">Riwayat</p>
                        <h1 class="font-24">Invoice</h1>
                        <a href="#" id="close" class="close-menu"><i class="fa fa-times-circle"></i></a>
                    </div>
                    <div class="content mb-0">
                        <div class="row mb-0">
                            <div class="col-6">
                                <p class="color-theme">Kode Pembayaran</p>
                            </div>
                            <div class="col-6">
                                <p class="text-end opacity-80">
                                    #<?php echo $item->id_pembayaran . '-' . $item->id_member . '-' . date('y', strtotime($item->tanggal_bayar)) . date('m', strtotime($item->tanggal_bayar)) . date('d', strtotime($item->tanggal_bayar)) ?>
                            </div>

                            <div class="col-12 pt-2">
                                <div class="divider mb-2"></div>
                            </div>

                            <div class="col-6">
                                <p class="color-theme">Nominal</p>
                            </div>
                            <div class="col-6">
                                <p class="text-end opacity-80">Rp.
                                    <?php echo number_format($item->jumlah_bayar, 0, ',', '.'); ?>,-</p>
                            </div>

                            <div class="col-12 pt-2">
                                <div class="divider mb-2"></div>
                            </div>

                            <div class="col-6">
                                <p class="color-theme">Status</p>
                            </div>
                            <?php if ($item->verified == 1) : ?>
                            <div class="col-6">
                                <p class="text-end color-green-dark">Valid</p>
                            </div>
                            <?php elseif ($item->verified == 2) : ?>
                            <div class="col-6">
                                <p class="text-end color-red-dark">Tidak Valid</p>
                            </div>
                            <?php else : ?>
                            <div class="col-6">
                                <p class="text-end color-dark-dark">Pending</p>
                            </div>
                            <?php endif; ?>

                            <div class="col-12 pt-2">
                                <div class="divider mb-2"></div>
                            </div>

                            <div class="col-6">
                                <p class="color-theme">Tanggal Bayar</p>
                            </div>
                            <div class="col-6">
                                <p class="text-end opacity-80">
                                    <?php echo $this->date->convert("j F Y", $item->tanggal_bayar) ?> </p>
                            </div>

                            <div class="col-12 pt-2">
                                <div class="divider mb-2"></div>
                            </div>

                            <div class="col-6">
                                <p class="color-theme">Metode Pembayaran</p>
                            </div>
                            <div class="col-6">
                                <p class="text-end opacity-80"><?php echo $item->cara_pembayaran ?></p>
                            </div>

                            <div class="col-12 pt-2">
                                <div class="divider mb-2"></div>
                            </div>
                        </div>
                        <a href="<?php echo base_url() . "konsultan/kuitansi_dl/download?id=" . $item->id_secret . '&idm=' . $tarif['dataMember'][$tarif['idMember']]['detailJamaah']->member[0]->idSecretMember; ?>"
                            class="btn btn-l font-13 font-600 text-uppercase gradient-highlight btn-full rounded-s border-0 mt-2"><i
                                class="fa-solid fa-file-invoice"></i> Download Invoice</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- </div> -->
        <!-- Page content ends here-->

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

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>