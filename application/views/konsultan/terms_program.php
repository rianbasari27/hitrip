<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <div class="header header-fixed header-logo-center header-auto-show">
            <a href="index.html" class="header-title">Syarat & Ketentuan</a>
            <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-chevron-left"></i></a>
            <a href="#" data-toggle-theme class="header-icon header-icon-4 show-on-theme-dark"><i
                    class="fas fa-sun"></i></a>
            <a href="#" data-toggle-theme class="header-icon header-icon-4 show-on-theme-light"><i
                    class="fas fa-moon"></i></a>
        </div>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['daftar_nav' => true]); ?>

        <!-- header title -->
        <div class="page-title page-title-fixed">
            <h1 class="font-22">Syarat & Ketentuan</h1>
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-light" data-toggle-theme><i
                    class="fa fa-moon"></i></a>
            <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-dark" data-toggle-theme><i
                    class="fa fa-lightbulb color-yellow-dark"></i></a>
        </div>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style">
                <div class="content">
                <p class="color-highlight mb-n2" style="text-align: center;"><strong>UMROH || MOSLEM TOUR</strong></p><br>
        <h5 class="font-800 mt-n2" style="text-align: center;">SYARAT DAN KETENTUAN <br>
        <?php echo $nama_program ?>
        </h5>
        <!-- <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div> -->
        <div class="">
            <div class="divider"></div>
            <div class="d-flex mb-4">
                <div class="w-100 pt-1" style="text-align: justify;"> 
                    <ol style="line-height: 180%;">
                        <li>Terdaftar sebagai konsultan resmi Ventour Travel</li>
                        <li>Paham dan menggunakan serta memposting konten secara aktif di media sosial: Facebook dan Instagram</li>
                        <li>Memiliki dan menggunakan Whatsapp Business</li>
                        <li>Memiliki dan paham menggunakan device smartphone dan laptop yang kompatibel (minimal RAM 4GB)</li>
                        <li>Bersedia mengeluarkan budget iklan pribadi untuk kegiatan praktik (direkomendasikan budget awal Rp1.000.000)</li>
                        <li>Mendaftarkan diri dan membayar melalui Ventour Mobile (Virtual Account) dengan metode sekali pembayaran (lunas)</li>
                        <li>Masuk ke dalam group WA</li>
                        <li>Memakai T-shirt yang diberikan oleh Ventour Travel</li>
                        <li>Menggunakan ID card konsultan</li>
                        <li>Mengikuti rangkaian acara dengan tertib dan khidmat</li>
                        <li>Potensi hasil pelatihan digital marketing dapat berbeda-beda setiap konsultan berdasarkan pada:
                            <ul style="list-style-type:disc">
                                <li>Mengikuti syarat dan ketentuan poin di atas</li>
                                <li>Kemampuan memahami dan mempraktekkan materi offline dan online dari program ini</li>
                                <li>Kreativitas masing-masing konsultan dalam berkonten</li>
                                <li>Konsistensi dan persistensi dalam bersyiar melalui digital marketing</li>
                                <li>Hal-hal teknis lainnya yang telah disampaikan oleh pemateri expert tetapi tidak dipraktekkan</li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="divider mb-n2 mt-n2"></div>
            <div class="row mb-0 mt-4">
                <div class="w-100 ms-3 pt-1">
                <!-- <a href="<?php echo base_url(). 'asset/docs/invoice_terms.pdf' ;?>" class="mb-0 mt-2" download>Download Syarat & Ketentuan disini</a> -->
                <div class="form-check icon-check mt-3">
                    <input class="form-check-input" type="checkbox" value="" id="check3" onclick="checkboxfun()">
                    <label class="form-check-label fw-bold" for="check3">Saya menyetujui seluruh syarat dan
                        ketentuan yang telah ditetapkan PT. Ventura Semesta Wisata</label>
                    <i class="icon-check-1 far fa-square color-gray-dark font-16"></i>
                    <i class="icon-check-2 far fa-check-square font-16 color-highlight"></i>
                </div>

                </div>
            </div>
            <a href="#" id="btn-accept"
                class="btn mb-4 mt-3 gradient-gray btn-l rounded-sm btn-full font-700 text-uppercase border-0">Daftar
                Sekarang</a>
        </div>
                </div>
            </div>
        </div>
                </div>
            </div>
        </div>
        <!-- Page content ends here-->


        <?php $this->load->view('konsultan/include/alert-bottom'); ?>
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

    <script>
    function checkboxfun() {
        var checkBox = document.getElementById("check3");
        var buttonAccept = document.getElementById("btn-accept");
        if (checkBox.checked == true) {
            buttonAccept.classList.remove("gradient-gray");
            buttonAccept.classList.add('gradient-highlight');
            buttonAccept.href = "<?php echo base_url() . 'konsultan/home/start_program?id=' . $id; ?>";
        }
        if (checkBox.checked == false) {
            buttonAccept.classList.remove("gradient-highlight");
            buttonAccept.classList.add('gradient-gray');
            buttonAccept.href = "#";
        }
    }
    document.getElementById("btn-accept").addEventListener("click", function(event) {
        event.preventDefault();
        event.stopPropagation();
        href = this.getAttribute("href");;
        if (href == "#") {
            alert("Anda harus menyetujui syarat dan ketentuan yang berlaku.");
        } else {
            window.location = href;
        }

    });
    </script>
</body>