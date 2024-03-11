<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/mecca.jpg");
    }

    .shadow-accor * {
        box-shadow: 0;
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['pembayaran_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">

            <div class="card card-style">
                <div class="content">

                    <div class="d-flex mb-3">
                        <div class="mt-1">
                            <p class="color-highlight font-600 mb-n1">Pembayaran</p>
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

                    <div class="divider mb-2 mt-4"></div>

                    <div class="d-flex mb-2">
                        <div>
                            <h3 class="font-700 ">Sisa Tagihan</h3>
                        </div>
                        <div class="ms-auto">
                            <h3>Rp. <?php echo number_format($sisaTagihan, 0, ',', '.'); ?>,-</h3>
                        </div>
                    </div>

                    <a href="#" data-menu="menu-receipts"
                        class="btn btn-full btn-s d-block rounded-s font-600 gradient-highlight mt-4 mb-2">Pembayaran</a>

                </div>
            </div>

            <?php if (!empty($transPending)) : ?>
            <div class="card card-style">
                <div class="content">
                    <i class="fa fa-circle-exclamation float-start me-3 scale-box fa-4x color-yellow-dark"></i>
                    <h4 class="font-16">Ada transaksi yang belum diselesaikan</h4>
                    <!-- <div class="align-self-center">
                        <h4 class="font-16 mb-0">Ada transaksi yang belum diselesaikan</h4>
                    </div> -->
                    <a href="<?php echo base_url() . 'jamaah/pembayaran/bayar_duitku'?>" class="btn btn-xs bg-green-light rounded shadow-l">Cek Transaksi</a>
                </div>
            </div>
            <?php endif; ?>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-video">
                            <i class="color-icon-gray font-20 icon-40 text-center fab fa-youtube color-red-dark"></i>
                            <span>Tutorial Pembayaran</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- <div class="card card-style">
                <div class="content mb-0">
                    <h4 class="color-highlight">Pilih Metode Pembayaran </h4>
                    <div class="list-group list-custom-large">
                        <a href="<?php echo base_url(); ?>jamaah/pembayaran/bayar">
                            <img src="<?php echo base_url(); ?>asset/images/icons/bsi-logo.png" alt="BSI Logo" />
                            <span>BSI</span>
                            <strong>Bank Syariah Indonesia</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="<?php echo base_url(); ?>jamaah/pembayaran/bayar_duitku">
                            <img src="<?php echo base_url(); ?>asset/images/icons/Duitku.svg" alt="Duitku Logo" />
                            <span>Bank Lain</span>
                            <strong>Mandiri, BNI, BRI, dll.</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div> -->

            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

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

    <!-- Modal Metode Bayar -->
    <div id="menu-receipts" class="menu menu-box-bottom rounded-m bg-white" data-menu-height="650">
        <div class="menu-title">
            <p class="color-highlight font-600">Pembayaran</p>
            <h1>Pilih Cara Pembayaran</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>

        <div class="ms-4 me-4 mb-4">
            <div class="search-box  rounded-m bottom-0">
                <i class="fa fa-search ms-2"></i>
                <input id="search" type="text" oninput="performSearch()" class="border-0"
                    placeholder="Cari metode pembayaran" value="">
            </div>
        </div>

        <div id="list-agen"></div>

    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript">
    function CopyMe(TextToCopy) {
        var TempText = document.createElement("input");
        TempText.value = TextToCopy;
        document.body.appendChild(TempText);
        TempText.select();

        document.execCommand("copy");
        document.body.removeChild(TempText);
        Swal.fire({ //displays a pop up with sweetalert
            icon: 'success',
            title: 'Text copied to clipboard',
            showConfirmButton: false,
            timer: 1000
        });
    }

    performSearch()

    function performSearch() {
        var searchValue = document.getElementById('search').value.toLowerCase();
        var resultsContainer = document.getElementById('list-agen');
        var containerWallet = document.getElementById('results-container-wallet');
        resultsContainer.innerHTML = ''; // Clear previous results
        // containerWallet.innerHTML = ''; // Clear previous results

        // List of items to be searched
        var items = [{
                name: 'BSI',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/bayar',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bsi.jpg'
            },
            {
                name: 'BCA',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/BC',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bca.jpg'
            },
            {
                name: 'Mandiri',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/M2',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-mandiri.jpg'
            },
            {
                name: 'BNI',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/I1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bni.jpg'
            },
            {
                name: 'BRI',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/BR',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bri.jpg'
            },
            {
                name: 'Permata',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/BT',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-permata.jpg'
            },
            {
                name: 'CIMB Niaga',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/B1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-cimb.jpg'
            },
            {
                name: 'Maybank',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/VA',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-maybank.jpg'
            },
            {
                name: 'BNC',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/NC',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-neobank.jpg'
            },
            {
                name: 'Artha Graha',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/AG',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-ag.jpg'
            },
            {
                name: 'ATM Bersama',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/A1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-atm-bersama.jpg'
            },
            // Add other data as needed
            // ...
        ];

        var itemsWallet = [{
                name: 'Dana',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/DA',
                image: '<?php echo base_url(); ?>asset/images/icons/dana.jpg'
            },
            {
                name: 'OVO',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/OV',
                image: '<?php echo base_url(); ?>asset/images/icons/ovo.jpg'
            },
            {
                name: 'Shopee Pay',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/SA',
                image: '<?php echo base_url(); ?>asset/images/icons/shopee-pay.jpg'
            },
            {
                name: 'LinkAja',
                link: '<?php echo base_url(); ?>jamaah/pembayaran/duitku_bayar_baru/LA',
                image: '<?php echo base_url(); ?>asset/images/icons/linkaja.jpg'
            },
        ];

        // var allItems = items.concat(itemsWallet);

        // Perform the search
        var results = items.filter(function(item) {
            return item.name.toLowerCase().includes(searchValue);
        });

        // console.log(results);

        var resultsWallet = itemsWallet.filter(function(item) {
            return item.name.toLowerCase().includes(searchValue);
            // console.log(item);
        });

        // Display the search results
        displayResults(results, resultsWallet);
        // displayResultsWallet(resultsWallet);
    }

    function displayResults(results, resultsWallet) {
        var resultsContainer = document.getElementById('results-container');
        // var resultsContainerWallet = document.getElementById('results-container-wallet');


        if (results.length === 0 && resultsWallet.length === 0) {
            var listAgen = document.getElementById("list-agen");
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

            // Dapatkan elemen induk dengan ID "results-container"
            var listAgen = document.getElementById("list-agen");

            // Tambahkan elemen baru sebagai anak ke elemen "results-container"
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

            // Dapatkan elemen induk dengan ID "results-container"
            var listAgen = document.getElementById("list-agen");

            // Tambahkan elemen baru sebagai anak ke elemen "results-container"
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

    function displayResultsWallet(results) {
        var resultsContainer = document.getElementById('results-container-wallet');
        // var resultsContainerWallet = document.getElementById('results-container-wallet');

        if (results.length === 0) {
            var resultLink = document.createElement('a');
            resultLink.href = results.link;
            resultLink.className = 'col-3 col-md-4 mb-3';
            resultLink.dataset.filterItem = true;
            resultLink.dataset.filterName = results.name.toLowerCase();

            var resultImage = document.createElement('div');
            resultImage.innerHTML = '<img src="' + results.image + '" alt="' + results.name +
                ' Logo" class="img-fluid rounded shadow-xl">';

            var resultText = document.createElement('span');
            resultText.className = 'color-dark-dark';
            resultText.textContent = result.name;

            resultLink.appendChild(resultImage);
            resultLink.appendChild(resultText);

            resultsContainer.appendChild(resultLink);
        } else {
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

                resultsContainer.appendChild(resultLink);
            });
        }
    }
    </script>
</body>