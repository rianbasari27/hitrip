<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['pembayaran_nav' => true]); ?>
        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="card card-style">
                <div class="content">

                    <div class="d-flex">
                        <div class="mt-1">
                            <p class="color-highlight font-600 mb-n1">Selamat!</p>
                            <h3>Anda berhasil terdaftar</h3>
                        </div>
                        <div class="ms-auto rounded-xl p-2 border border-highlight shadow-l">
                            <img src="<?php echo base_url() ?>asset/images/icons/icon-72x72.png" width="40">
                        </div>
                    </div>
                    <div class="row mt-4 mb-0">
                        <div class="col-6">
                            <h5 class="font-14 font-500">ID Konsultan</h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-14 text-end"><?php echo $agen->no_agen; ?></h5>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <h5 class="font-14 font-500">Nama Konsultan</h5>
                        </div>
                        <div class="col-6">
                            <h5 class="font-14 text-end"><?php echo $agen->nama_agen; ?></h5>
                        </div>
                    </div>

                    <div class="divider mt-0"></div>

                    <div class="d-flex mb-3">
                        <div>
                            <img src="<?php echo ($detail_program->agen_gambar_banner != null) ? base_url() . $detail_program->agen_gambar_banner : base_url() . 'asset/appkit/images/pictures/default/default_150x150.png'; ?>"
                                width="80" class="rounded-s shadow-xl">
                        </div>
                        <div class="ps-3 w-100">
                            <h4 class="mb-0"><?php echo $detail_program->nama_paket ?></h4>
                            <h4><?php echo $agen->program[0]->hargaAfterDiskonPretty; ?></h4>

                            <!-- <span> <?php echo $detail_program->tanggalFormat; ?></span> -->
                            <span>
                                <!-- <?php if ($detail_program->countdown <= 45 && $detail_program->countdown >= 0) { ?>
                                <br>
                                (<span class="text-danger font-800">
                                    <?php echo $detail_program->countdown; ?></span> )
                                <?php } elseif ($detail_program->countdown > 45 && $detail_program->countdown <= 90) { ?>
                                (<span>
                                    <?php echo $detail_program->countdown; ?></span>)
                                <?php } ?> -->
                            </span>
                        </div>

                    </div>
                    <!-- <a href="<?php echo base_url() ?>jamaah/daftar/pindah_paket?id=<?php echo $tarif['dataMember'][$tarif['idMember']]['id_member'] ?>" class="btn btn-xxs rounded text-uppercase font-700 shadow-s gradient-highlight">Pindah Paket</a> -->

                    <div class="divider mb-3 mt-4"></div>

                    <div class="d-flex mt-4">
                        <div>
                            <h3 class="font-700">Total Tagihan</h3>
                        </div>
                        <div class="ms-auto">
                            <h3><?php echo $agen->program[0]->hargaAfterDiskonPretty; ?></h3>
                        </div>
                    </div>
                    <span class="color-red-dark font-700" id="countDownTime"></span><br>

                    <a href="#" data-menu="menu-receipts"
                        class="btn btn-full btn-s d-block rounded-s font-600 gradient-highlight mb-2">Pembayaran</a>
                    <!-- <a href="<?php echo base_url() . "konsultan/kuitansi_dl/invoiceBelumDp?id=" . $tarif['idMember']; ?>" class="btn btn-full btn-s d-block rounded-s font-600 gradient-blue mb-2">Download Invoice</a>
                        <a href="#" data-menu="batal_bayar" class="btn btn-full btn-s d-block rounded-s font-600 bg-red-light">Batalkan Pembayaran</a> -->
                    <!-- <div class="d-flex mt-2">
                        <div>
                            <a href="#" class="btn btn-border btn-full btn-l rounded-s font-600 border-red-light color-red-light">Batalkan</a>
                        </div>
                        <div>
                            <a href="#" class="btn btn-full btn-l rounded-s font-600 gradient-highlight">Bayar</a>
                        </div>
                    </div> -->

                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-video">
                            <!-- <i class="color-icon-gray font-20 icon-40 text-center fab fa-youtube color-red-dark"></i> -->
                            <i
                                class="fab font-20 icon-40 fa-youtube icon icon-xs rounded-sm shadow-l mr-1 color-red-dark"></i>
                            <span>Tutorial Pembayaran</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    <div class="list-group list-custom-small">
                        <a href="https://wa.me/6287815131635" target="_blank">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <span>Help & Support</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>


        <div id="batal_bayar" class="menu menu-box-modal rounded-m" data-menu-height="190" data-menu-width="350">
            <div class="menu-title">
                <i class="fa fa-circle-exclamation scale-box float-start me-3 ms-3 fa-3x mt-1 color-yellow-dark"></i>
                <p class="color-highlight">Apakah anda yakin untuk</p>
                <h1 class="font-20">Batalkan pembayaran?</h1>
                <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
            </div>
            <div class="content mt-0">
                <p class="pe-3 mb-2">
                    Membatalkan pembayaran akan menghapus data Anda sebagai calon jamaah
                </p>
                <div class="row mb-0">
                    <div class="col-6">
                        <a href="#" class="btn close-menu btn-full btn-s bg-red-dark font-600 rounded-s">Tidak</a>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo base_url() . 'konsultan/jamaah_info/batal_bayar?id=' . ($parentId == null ? $tarif['idMember'] : $parentId) ?>"
                            class="btn close-menu btn-full btn-s bg-green-dark font-600 rounded-s">Ya</a>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->load->view('konsultan/include/alert'); ?>

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

    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
        <div class='responsive-iframe max-iframe'>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/9quq1e6UiUE?si=G8dAU0DJv1qiDIl8"
                frameborder="0" allowfullscreen></iframe>
            <!-- <iframe src='https://www.youtube.com/embed/c9MnSeYYtYY' frameborder='0' allowfullscreen></iframe> -->
        </div>
        <div class="menu-title">
            <p class="color-highlight">Video Tutorial</p>
            <h1>Tutorial Pembayaran</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-n2">
            <!-- <p>
                It's super easy to embed videos. Just copy the embed!
            </p> -->
            <!-- <a href="#" class="close-menu btn btn-full btn-m shadow-l rounded-s text-uppercase font-600 gradient-green mt-n2">Awesome</a> -->
        </div>
    </div>

    <!-- Modal Metode Bayar -->
    <div id="menu-receipts" class="menu menu-box-bottom rounded-m bg-white" data-menu-height="650">
        <div class="menu-title">
            <p class="color-highlight font-600">Pembayaran</p>
            <h1>Pilih Cara Pembayaran</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>

        <div class="ms-4 me-4 mb-4">
            <div class="search-box rounded-m bottom-0">
                <i class="fa fa-search ms-2"></i>
                <input id="search" type="text" oninput="performSearch()" class="border-0"
                    placeholder="Cari metode pembayaran" value="">
            </div>
        </div>
        <div id="cara-pembayaran"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script>
    performSearch()

    function performSearch() {
        var searchValue = document.getElementById('search').value.toLowerCase();
        var resultsContainer = document.getElementById('cara-pembayaran');
        var containerWallet = document.getElementById('results-container-wallet');
        resultsContainer.innerHTML = ''; // hapus results sebelumnya

        var items = [{
                name: 'BSI',
                link: '<?php echo base_url(); ?>konsultan/home/bsi_dp_agen',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bsi.jpg'
            },
            {
                name: 'BCA',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/BC',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bca.jpg'
            },
            {
                name: 'Mandiri',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/M2',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-mandiri.jpg'
            },
            {
                name: 'BNI',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/I1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bni.jpg'
            },
            {
                name: 'BRI',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/BR',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bri.jpg'
            },
            {
                name: 'Permata',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/BT',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-permata.jpg'
            },
            {
                name: 'CIMB Niaga',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/B1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-cimb.jpg'
            },
            {
                name: 'Maybank',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/VA',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-maybank.jpg'
            },
            {
                name: 'BNC',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/NC',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-neobank.jpg'
            },
            {
                name: 'Artha Graha',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/AG',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-ag.jpg'
            },
            {
                name: 'ATM Bersama',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/A1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-atm-bersama.jpg'
            },
        ];

        var itemsWallet = [{
                name: 'Dana',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/DA',
                image: '<?php echo base_url(); ?>asset/images/icons/dana.jpg'
            },
            {
                name: 'OVO',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/OV',
                image: '<?php echo base_url(); ?>asset/images/icons/ovo.jpg'
            },
            {
                name: 'Shopee Pay',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/SA',
                image: '<?php echo base_url(); ?>asset/images/icons/shopee-pay.jpg'
            },
            {
                name: 'LinkAja',
                link: '<?php echo base_url(); ?>konsultan/home/duitku_dp_agen/LA',
                image: '<?php echo base_url(); ?>asset/images/icons/linkaja.jpg'
            },
        ];

        // Perform the search VA
        var results = items.filter(function(item) {
            return item.name.toLowerCase().includes(searchValue);
        });

        // Perform the search eWallet
        var resultsWallet = itemsWallet.filter(function(item) {
            return item.name.toLowerCase().includes(searchValue);
        });

        // Tampilkan hasil search
        displayResults(results, resultsWallet);
    }

    function displayResults(results, resultsWallet) {
        var resultsContainer = document.getElementById('results-container');


        if (results.length === 0 && resultsWallet.length === 0) {
            var listAgen = document.getElementById("cara-pembayaran");
            var font = document.createElement("h5");
            font.className = "font-14"; // Sesuaikan dengan kelas yang diinginkan
            font.className = "content"; // Sesuaikan dengan kelas yang diinginkan
            var resultText = document.createTextNode("Cara Pembayaran tidak ditemukan");
            font.appendChild(resultText);
            listAgen.appendChild(font)

        } else if (results.length !== 0) {

            var card = document.createElement("div");
            card.className = "card card-style search-result"; // Sesuaikan dengan kelas yang diinginkan
            var content = document.createElement("div");
            content.className = "content"; // Sesuaikan dengan kelas yang diinginkan
            var font = document.createElement("h5");
            font.className = "font-14"; // Sesuaikan dengan kelas yang diinginkan
            var row = document.createElement("div");
            row.className = "row mt-4 mb-1 text-center"; // Sesuaikan dengan kelas yang diinginkan
            row.id = "result-container"; // Sesuaikan dengan kelas yang diinginkan

            // Isi elemen dengan konten
            var resultText = document.createTextNode("Virtual Account");
            font.appendChild(resultText);

            // Dapatkan elemen induk dengan ID "cara-pembayaran"
            var listAgen = document.getElementById("cara-pembayaran");

            // Tambahkan elemen baru sebagai anak ke elemen "cara-pembayaran"
            card.appendChild(content);
            content.appendChild(font);
            content.appendChild(row);
            listAgen.appendChild(card);
            // Tambahkan hasil pencarian baru
            results.forEach(function(result) {
                var resultLink = document.createElement('a');
                resultLink.href = result.link;
                resultLink.className = 'col-3 col-md-4 mb-3';
                resultLink.dataset.filterItem = true;
                resultLink.dataset.filterName = result.name.toLowerCase();

                var resultImage = document.createElement('div');
                resultImage.innerHTML = '<img src="' + result.image + '" alt="' + result.name +
                    ' Logo" class="img-fluid rounded shadow-xl">';

                var resultText = document.createElement('span');
                resultText.className = 'color-dark-dark';
                resultText.textContent = result.name;

                resultLink.appendChild(resultImage);
                resultLink.appendChild(resultText);

                row.appendChild(resultLink);
            });
        }

        if (resultsWallet.length !== 0) {
            var cardWallet = document.createElement("div");
            cardWallet.className = "card card-style search-result"; // Sesuaikan dengan kelas yang diinginkan
            var contentWallet = document.createElement("div");
            contentWallet.className = "content"; // Sesuaikan dengan kelas yang diinginkan
            var fontWallet = document.createElement("h5");
            fontWallet.className = "font-14"; // Sesuaikan dengan kelas yang diinginkan
            var rowWallet = document.createElement("div");
            rowWallet.className = "row mt-4 mb-1 text-center"; // Sesuaikan dengan kelas yang diinginkan
            rowWallet.id = "result-container-wallet"; // Sesuaikan dengan kelas yang diinginkan

            // Isi elemen dengan konten
            var resultText = document.createTextNode("E-Wallet");
            fontWallet.appendChild(resultText);

            // Dapatkan elemen induk dengan ID "cara-pembayaran"
            var listAgen = document.getElementById("cara-pembayaran");

            // Tambahkan elemen baru sebagai anak ke elemen "cara-pembayaran"
            cardWallet.appendChild(contentWallet);
            contentWallet.appendChild(fontWallet);
            contentWallet.appendChild(rowWallet);
            listAgen.appendChild(cardWallet);
            // Tambahkan hasil pencarian baru
            resultsWallet.forEach(function(resultWallet) {
                var resultLinkWalet = document.createElement('a');
                resultLinkWalet.href = resultWallet.link;
                resultLinkWalet.className = 'col-3 col-md-4 mb-3';
                resultLinkWalet.dataset.filterItem = true;
                resultLinkWalet.dataset.filterName = resultWallet.name.toLowerCase();

                var resultImageWallet = document.createElement('div');
                resultImageWallet.innerHTML = '<img src="' + resultWallet.image + '" alt="' + resultWallet
                    .name +
                    ' Logo" class="img-fluid rounded shadow-xl">';

                var resultTextWallet = document.createElement('span');
                resultTextWallet.className = 'color-dark-dark';
                resultTextWallet.textContent = resultWallet.name;

                resultLinkWalet.appendChild(resultImageWallet);
                resultLinkWalet.appendChild(resultTextWallet);

                rowWallet.appendChild(resultLinkWalet);
            });
        }
    }
    </script>
</body>