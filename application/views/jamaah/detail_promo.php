<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php //$this->load->view('jamaah/include/header_menu'); ?>
        <!-- <div class="page-title-clear mb-0"></div> -->

        <div class="card card-fixed" style="background-image:url(<?php echo base_url() . $promo->banner_promo; ?>)"
            data-card-height="350">
            <div class="card-top mt-3 pb-5 ps-3">
                <a href="#" data-back-button class="icon icon-s bg-theme rounded-xl float-start me-3"><i
                        class="fa color-highlight fa-arrow-left"></i></a>
            </div>
        </div>
        <div class="card card-clear" data-card-height="350"></div>

        <div class="page-content mt-n1">

            <div class="card card-full mb-n5 rounded-l pb-4">

                <div class="content p-3 mt-3">
                    <h2><?php echo $promo->nama_diskon ;?></h2>
                    <div class="divider mt-3 mb-3"></div>
                    <p><?php echo $promo->deskripsi ;?>
                    </p>
                    <h4>Expired : <?php echo $this->date->convert_date_indo($promo->tgl_berakhir) ;?></h4>
                    <a href="#"
                        class="btn btn-full btn-m mt-5 rounded-s text-uppercase font-700 shadow-s gradient-highlight">Dapatkan
                        promo</a>

                </div>

                <?php $this->load->view('jamaah/include/alert'); ?>
                <?php $this->load->view('jamaah/include/toast'); ?>
            </div>
            <!-- Page content ends here-->

            <!-- Added to Bookmarks Menu-->
            <div id="menu-heart" class="menu menu-box-modal rounded-m" data-menu-hide="1000" data-menu-width="250"
                data-menu-height="170">

                <h1 class="text-center mt-3 pt-2">
                    <i class="fa fa-heart color-red-dark fa-3x scale-icon"></i>
                </h1>
                <h3 class="text-center pt-2">Saved to Favorites</h3>
            </div>

            <div id="menu-other" class="menu menu-box-bottom rounded-m bg-theme" data-menu-height="300"
                data-menu-effect="menu-over">
                <div class="menu-title">
                    <p class="color-highlight">Menu</p>
                    <h1>Lainnya</h1>
                    <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
                </div>
                <div class="content">
                    <div class="list-group list-custom-small list-menu ms-0 me-2">
                        <a href="#">
                            <i class="fa fa-star-and-crescent gradient-highlight color-white"></i>
                            <span>Jadwal Sholat</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-location-arrow gradient-highlight color-white"></i>
                            <span>Arah Kiblat</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-mosque gradient-highlight color-white"></i>
                            <span>Tempat Ibadah</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
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
        <?php $this->load->view('jamaah/include/script_view'); ?>
        <script type="text/javascript">
        var toastID = document.getElementById('toast-2');
        toastID = new bootstrap.Toast(toastID);
        toastID.show();

        // Fungsi untuk memperbarui waktu dan mendapatkan latitude serta longitude
        function updateTimeAndLocation() {
            // Mendefinisikan URL API TimezoneDB
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                var timezoneApiUrl =
                    `https://timeapi.io/api/Time/current/coordinate?latitude=${latitude}&longitude=${longitude}`;

                // Memanggil navigator.geolocation.getCurrentPosition untuk mendapatkan lokasi pengguna

                // Mengirim permintaan ke API TimezoneDB dengan latitude dan longitude pengguna
                fetch(timezoneApiUrl)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Memeriksa apakah permintaan berhasil
                        var zoneName = data.timeZone;
                        var timeNow = data.time;


                        // Memperbarui tampilan zona waktu dan waktu terformat
                        document.getElementById("zoneName").textContent = zoneName;
                        document.getElementById("formattedTime").textContent = timeNow;
                    })
                    .catch(error => {
                        console.error('Terjadi kesalahan:', error);
                        // Menampilkan pesan kesalahan jika terjadi masalah dalam mengambil data waktu
                        document.getElementById("timeInfo").textContent =
                            "Gagal mendapatkan informasi zona waktu.";
                    });
            }, function(error) {
                // Penanganan kesalahan jika mendapatkan lokasi gagal
                console.error("Error getting location: ", error);
                document.getElementById("timeInfo").textContent = "Gagal mendapatkan lokasi pengguna.";
            });
        }

        // Memanggil fungsi updateTimeAndLocation saat halaman dimuat
        // window.onload = function() {
        // updateTimeAndLocation();
        //     // Menetapkan pembaruan waktu setiap detik (1000 milidetik)
        //     setInterval(updateTimeAndLocation, 1000);
        // };
        </script>
</body>