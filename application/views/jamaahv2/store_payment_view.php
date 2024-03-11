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
        <?php $this->load->view('jamaahv2/include/store_menu', ['orders' => true, 'countCart' => $countCart]); ?>

        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="card card-style">
                <div class="content">
                    <h1>Pembayaran</h1>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <i class="fa-solid fa-magnifying-glass me-2"></i>
                    <input id="search" type="text" oninput="performSearch()" class="border-0"
                        placeholder="Cari metode pembayaran" value="">
                </div>
            </div>

            <div id="cara-pembayaran"></div>
        </div>


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

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('konsultan/include/alert-bottom'); ?>
    <?php $this->load->view('jamaahv2/include/script_view'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
    performSearch()

    function performSearch() {
        var searchValue = document.getElementById('search').value.toLowerCase();
        var resultsContainer = document.getElementById('cara-pembayaran');
        var containerWallet = document.getElementById('results-container-wallet');
        resultsContainer.innerHTML = ''; // hapus results sebelumnya

        var items = [{
                name: 'BSI',
                link: '<?php echo base_url(); ?>jamaah/online_store/bayar_bsi?id=<?php echo $id_order  ?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bsi.jpg'
            },
            {
                name: 'BCA',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=BC&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bca.jpg'
            },
            {
                name: 'Mandiri',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=M2&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-mandiri.jpg'
            },
            {
                name: 'BNI',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=I1&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bni.jpg'
            },
            {
                name: 'BRI',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=BR&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-bri.jpg'
            },
            {
                name: 'Permata',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=BT&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-permata.jpg'
            },
            {
                name: 'CIMB Niaga',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=B1&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-cimb.jpg'
            },
            {
                name: 'Maybank',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=VA&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-maybank.jpg'
            },
            {
                name: 'BNC',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=NC&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-neobank.jpg'
            },
            {
                name: 'Artha Graha',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=AG&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-ag.jpg'
            },
            {
                name: 'ATM Bersama',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=A1&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/bank-atm-bersama.jpg'
            },
        ];

        var itemsWallet = [{
                name: 'Dana',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=DA&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/dana.jpg'
            },
            {
                name: 'OVO',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=OV&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/ovo.jpg'
            },
            {
                name: 'Shopee Pay',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=SA&ido=<?php echo $id_order;?>',
                image: '<?php echo base_url(); ?>asset/images/icons/shopee-pay.jpg'
            },
            {
                name: 'LinkAja',
                link: '<?php echo base_url(); ?>jamaah/online_store/proses_duitku?metode=LA&ido=<?php echo $id_order;?>',
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