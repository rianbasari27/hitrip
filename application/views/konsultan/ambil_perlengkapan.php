<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
        .bg-6 {
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/perlengkapan.jpg");
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
    <link href="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
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

        <div class="page-content ">

            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Perlengkapan</p>
                    <h1>Jadwalkan Pengambilan</h1>

                    <p class="mb-3">
                        <?php if (!$tanggalAmbil) { ?>
                            Tentukan tanggal pengambilan perlengkapan Anda agar kami dapat mempersiapkannya.
                        <?php } ?>
                        <?php if ($tanggalAmbil) { ?>
                            Anda telah merencanakan pengambilan perlengkapan untuk Jamaah Anda pada <br>
                            <span class="fw-bold color-highlight" style="font-size: 17px;">Tanggal : <?php echo $tanggalAmbil; ?></span><br>
                            <?php if ($jenisAmbil == 'Pengiriman') { ?>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Jenis : <?php echo $jenisAmbil; ?></span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">No Telepon : <?php echo $noKirim; ?></span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Alamat Kirim :<?php echo $alamatKirim; ?></span>
                            <?php } else { ?>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Jenis : <?php echo $jenisAmbil; ?></span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">No Telepon : - </span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Alamat Pengambilan : Jln. KH.M Yusuf Raya No.18A-B Mekar Jaya, Depok, Jawa Barat</span>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($tanggalSiap) { ?>
                            Anda telah merencanakan pengambilan perlengkapan untuk Jamaah Anda pada <br>
                            <span class="fw-bold color-highlight" style="font-size: 17px;">Tanggal : <?php echo $tanggalSiap; ?></span><br>
                            <?php if ($jenisAmbilSiap == 'Pengiriman') { ?>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Jenis : <?php echo $jenisAmbilSiap; ?></span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">No Telepon : <?php echo $noKirimSiap; ?></span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Alamat Kirim :<?php echo $alamatKirimSiap; ?></span>
                            <?php } else { ?>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Jenis : <?php echo $jenisAmbilSiap; ?></span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">No Telepon : - </span><br>
                                <span class="fw-bold color-highlight" style="font-size: 17px;">Alamat Pengambilan : Jln. KH.M Yusuf Raya No.18A-B Mekar Jaya, Depok, Jawa Barat</span>
                            <?php } ?>
                        <?php } ?>
                    </p>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-video">
                            <i class="color-icon-gray font-20 icon-40 text-center fab fa-youtube color-red-dark"></i>
                            <span>Tutorial Booking Perlengkapan</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <p class="color-highlight font-500 mb-n1">Perlengkapan Sudah Siap</p>
                    <h2>Perlengkapan yang Dapat Diambil</h2>
                    <p>
                        Berikut perlengkapan yang sudah dapat diambil.
                    </p>
                    <img src="<?php echo base_url(); ?>asset/appkit/images/perlengkapan2.png" class="img-fluid rounded-sm mb-3" style="width:auto;height:300px;display: block;margin-left: auto;margin-right: auto;">
                    <?php foreach ($dataAmbil as $key => $dt) { ?>
                        <div class="list-group list-custom-small list-icon-0">
                            <a data-bs-toggle="collapse" class="no-effect" href="#collapse-<?php echo $key; ?>">
                                <span class="font-14 color-dark-dark"><?php echo implode(" ", array_filter([$dt['infoJamaah']->first_name, $dt['infoJamaah']->second_name, $dt['infoJamaah']->last_name])); ?></span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                        </div>
                        <div class="collapse" id="collapse-<?php echo $key; ?>">
                            <div class="list-group list-custom-small ps-3">
                                <?php if (empty($dt['items'])) { ?>
                                    Tidak ada perlengkapan yang dapat diambil.
                                <?php } ?>
                                <ul>
                                    <?php foreach ($dt['items'] as $item) { ?>
                                        <li>
                                            <?php echo $item->nama_barang; ?>
                                            <span class="color-highlight">
                                                <?php echo $item->jumlah_harus_ambil; ?>
                                                <?php echo $item->stok_unit; ?>
                                            </span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>

                </div>

            </div>
            <?php if (!$tanggalAmbil && !$tanggalSiap) { ?>
                <div class="card card-style">
                    <div class="content">
                        <p class="color-highlight font-500 mb-n1">Jadwal Pengambilan Perlengkapan</p>
                        <h2 class="mb-3">Tentukan Tanggal</h2>
                        <p>
                            Masukkan tanggal rencana Anda mengambil perlengkapan:
                        <form action="<?php echo base_url(); ?>konsultan/ambil_perlengkapan/proses_ambil?id=<?php echo $_GET['id'] ?>" method="post">
                            <div class="form-group">
                                <label class="color-highlight">Jenis Pengambilan</label><strong class="text-danger"> *</strong>
                                <div class="input-style has-borders no-icon mb-4">
                                    <select name="jenis_ambil" class="form-control" id="slct" onchange="showOnChange(event)">
                                        <option value="" disabled selected>-- Pilih salah satu --</option>
                                        <option value="langsung">WALK IN</option>
                                        <option value="pengiriman">PENGIRIMAN</option>
                                    </select>
                                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                                    <em></em>
                                </div>
                            </div>
                            <div class="form-group" style="display: none;" id="selectAlamat">
                                <label for="form6" class="color-highlight">Alamat Lengkap</label>
                                <div class="input-style has-borders no-icon mb-4">
                                    <textarea class="form-control" name="alamat_pengiriman"></textarea>
                                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                                </div>
                            </div>
                            <div class="form-group" style="display: none;" id="selectNomor">
                                <label class="color-highlight">No Telepon ( <span class="text-primary">Nomor Telepon Aktif</span> )</label>
                                <div class="input-style has-borders no-icon mb-4">
                                    <input name="no_pengiriman" type="text" value="<?php echo $jamaah->no_wa; ?>" class="form-control validate-text">
                                    <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                                    <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                                </div>
                            </div>
                            <label class="color-highlight">Pilih Tanggal</label><strong class="text-danger">
                                *</strong>
                            <div class="input-style has-borders no-icon mb-4">
                                <input name="date" type="date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" class="form-control validate-text" id="form6" placeholder="Atur jadwal pengambilan">
                                <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                                <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                            </div>
                            <button href="#" class="btn btn-s mb-3 rounded-s text-uppercase font-700 shadow-s bg-green-light">Submit</button>
                        </form>
                        </p>


                    </div>
                </div>
            <?php } ?>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>

    </div>

    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="320" data-menu-width="350">
        <div class='responsive-iframe max-iframe'>
            <iframe width="560" height="315" id="youtube-video" src="https://www.youtube.com/embed/qfd03QcquF8?si=6PfIyt_GcINRbwHi" frameborder="0" allowfullscreen></iframe>
            <!-- <iframe src='https://www.youtube.com/embed/c9MnSeYYtYY' frameborder='0' allowfullscreen></iframe> -->
        </div>
        <div class="menu-title">
            <p class="color-highlight">Video Tutorial</p>
            <h1>Tutorial Booking Perlengkapan</h1>
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
    <script>
        function showOnChange(e) {
            var elem = document.getElementById("slct");
            var value = elem.options[elem.selectedIndex].value;
            if (value == "pengiriman") {
                document.getElementById('selectAlamat').style.display = "block";
                document.getElementById('selectNomor').style.display = "block";
            }
            if (value == "langsung") {
                document.getElementById('selectAlamat').style.display = "none";
                document.getElementById('selectNomor').style.display = "none";
            }
        }
    </script>
</body>