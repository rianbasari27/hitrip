<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
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
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['pembayaran_nav' => true]); ?>
        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="content mt-0">

                <div class="mt-1">
                    <p class="color-highlight font-600 mb-n1">Anda Telah Terdaftar</p>
                    <h1>Pembayaran</h1>
                </div>

                <div class="card card-style mx-0">
                    <div class="content">
                        <h5>Details</h5>
                        <div class="row mb-0 mt-2">
                            <h5 class="col-6 text-start font-14 opacity-60 font-500">Paket</h5>
                            <h5 class="col-6 text-end font-14 font-700"><?php echo $currentPaket->nama_paket . ', ' . $currentPaket->area_trip ?></h5>
                            <h5 class="col-6 text-start font-14 opacity-60 font-500">Tanggal</h5>
                            <h5 class="col-6 text-end font-14 font-700"><?php echo $this->date->convert("j F Y", $tgl_regist); ?></h5>
                            <h5 class="col-6 text-start font-14 opacity-60 font-500">Waktu</h5>
                            <h5 class="col-6 text-end font-14 font-700"><?php echo date('H:i', strtotime($tgl_regist)); ?> WIB</h5>
                            <h5 class="col-6 text-start font-14 opacity-60 font-500">Jumlah</h5>
                            <h5 class="col-6 text-end font-14 font-700"><?php echo count($dataMember); ?> Orang</h5>
                            <h5 class="col-6 text-start font-14 opacity-60 font-500">Keberangkatan</h5>
                            <h5 class="col-6 text-end font-14 font-700"><?php echo $this->date->convert("j F Y", $currentPaket->tanggal_berangkat); ?></h5>
                        </div>
                        
                        <div class="divider my-3"></div>

                        <h5>Rincian</h5>
                        <div class="row mb-0 mt-2">
                            <h5 class="col-6 text-start font-14 opacity-60 font-500">Harga</h5>
                            <h5 class="col-6 text-end font-14 font-700"><?php echo $currentPaket->hargaPretty . ' (x' . count($dataMember) . ')' ?></h5>
                            <h5 class="col-6 text-start font-14 opacity-60 font-500">Potongan</h5>
                            <h5 class="col-6 text-end font-14 font-700"><?php echo $this->money->format($currentPaket->default_diskon) ?></h5>
                        </div>
                        
                        <div class="divider my-3"></div>

                        <div class="row mb-0 mt-2">
                            <h5 class="col-6 text-start">Total</h5>
                            <h5 class="col-6 text-end font-18 font-700"><?php echo $currentPaket->hargaPrettyDiskon ?></h5>
                        </div>
                    </div>
                
                </div>

                <div class="card card-style mx-0">
                    <div class="content">
                        <div class="d-flex">
                            <img src="<?php echo base_url(); ?>asset/images/icons/bank-bca.jpg" alt="BCA" width="80" class="shadow rounded-sm">
                            <div class="ms-3">
                                <h5 class="font-12 font-500 mb-0 opacity-60">BANK CENTRAL ASIA</h5>
                                <h3 class="font-18 mb-0">7261829103 (DEMO)</h3>
                                <h5>Hi Trip</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-6">
                        <a href="#" data-menu="batal_bayar"
                            class="btn btn-full btn-m d-block rounded-s font-600 bg-red-light">Batalkan</a>
                    </div>
                    <div class="col-6">
                        <a href="#" data-menu="menu-receipts"
                            class="btn btn-full btn-m d-block rounded-s font-600 gradient-highlight mb-2">Cek Status</a>
                    </div>
                </div> -->

            </div>

            <!-- <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-video">
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
            </div> -->

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
                        <a href="<?php echo base_url() . 'jamaah/daftar/batal_bayar?id=' . ($parentId == null ? $idMember : $parentId) ?>"
                            class="btn close-menu btn-full btn-s bg-green-dark font-600 rounded-s">Ya</a>
                    </div>
                </div>
            </div>
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
    // Mengatur waktu akhir perhitungan mundur
    var countDownDate = new Date("<?php echo $countDown; ?>").getTime();

    // Memperbarui hitungan mundur setiap 1 detik
    var x = setInterval(function() {

        // Untuk mendapatkan tanggal dan waktu hari ini
        var now = new Date().getTime();

        // Temukan jarak antara sekarang dan tanggal hitung mundur
        var distance = countDownDate - now;

        // Perhitungan waktu untuk hari, jam, menit dan detik
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Keluarkan hasil dalam elemen dengan id = "demo"
        document.getElementById("countDownTime").innerHTML =
            "Waktu booking seat Anda <i class='fa-regular fa-clock'></i> " + hours + "h " +
            minutes + "m " + seconds + "s";

        // Jika hitungan mundur selesai, tulis beberapa teks 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countDownTime").innerHTML = "";
        }
    }, 1000);

    performSearch();

    function performSearch() {
        var searchValue = document.getElementById('search').value.toLowerCase();
        var resultsContainer = document.getElementById('cara-pembayaran');
        var containerWallet = document.getElementById('results-container-wallet');
        resultsContainer.innerHTML = ''; // Hapus hasil sebelumnya

        // List of items to be searched
        var items = [{
                name: 'BSI',
                link: '<?php echo base_url(); ?>jamaah/daftar/bsi_dp',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bsi.jpg'
            },
            {
                name: 'BCA',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/BC',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bca.jpg'
            },
            {
                name: 'Mandiri',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/M2',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-mandiri.jpg'
            },
            {
                name: 'BNI',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/I1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bni.jpg'
            },
            {
                name: 'BRI',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/BR',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bri.jpg'
            },
            {
                name: 'Permata',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/BT',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-permata.jpg'
            },
            {
                name: 'CIMB Niaga',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/B1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-cimb.jpg'
            },
            {
                name: 'Maybank',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/VA',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-maybank.jpg'
            },
            {
                name: 'BNC',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/NC',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-neobank.jpg'
            },
            {
                name: 'Artha Graha',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/AG',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-ag.jpg'
            },
            {
                name: 'ATM Bersama',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/A1',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-atm-bersama.jpg'
            },
        ];

        var itemsWallet = [{
                name: 'Dana',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/DA',
                image: '<?php echo base_url(); ?>asset/images/icons/dana.jpg'
            },
            {
                name: 'OVO',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/OV',
                image: '<?php echo base_url(); ?>asset/images/icons/ovo.jpg'
            },
            {
                name: 'Shopee Pay',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/SA',
                image: '<?php echo base_url(); ?>asset/images/icons/shopee-pay.jpg'
            },
            {
                name: 'LinkAja',
                link: '<?php echo base_url(); ?>jamaah/daftar/duitku_dp/LA',
                image: '<?php echo base_url(); ?>asset/images/icons/linkaja.jpg'
            },
        ];

        // Perform the search VA
        var results = items.filter(function(item) {
            return item.name.toLowerCase().includes(searchValue);
        });

        var resultsWallet = itemsWallet.filter(function(item) {
            return item.name.toLowerCase().includes(searchValue);
        });

        // Tampilkan hasil pencarian
        displayResults(results, resultsWallet);
    }

    function displayResults(results, resultsWallet) {
        var resultsContainer = document.getElementById('results-container');


        if (results.length === 0 && resultsWallet.length === 0) {
            var listAgen = document.getElementById("cara-pembayaran");
            var font = document.createElement("h5");
            font.className = "font-14"; // Sesuaikan dengan kelas yang diinginkan
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