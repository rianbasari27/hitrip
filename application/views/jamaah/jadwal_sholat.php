<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
    #page {
        min-height: 100vh !important;
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar'); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['home' => true]); ?>

        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n2">
            <div class="content">
                <h1 class="mb-0 mt-n2">Jadwal Sholat</h1>
                <span class="color-theme" id="location"></span>
                <h1 class="font-48 mt-5" id="time"></h1>
                <p id="tgl-container" class="mb-n2"></p>
            </div>
            <div id="result-container"></div>

            <?php $this->load->view('jamaah/include/footer'); ?>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
    <script>
    function getCityAndCountry(latitude, longitude) {
        var apiUrl =
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&accept-language=id`;
        // Menggunakan Fetch API untuk mengambil data dari Nominatim

        const d = new Date();
        var tanggal = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
        var solatApi =
            `https://api.aladhan.com/v1/timings/${tanggal}?latitude=${latitude}&longitude=${longitude}&method=20&tune=1,1,1,1,1,1,1,1`
        fetch(solatApi)
            .then(response => response.json())
            .then(data => {
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(location => {
                        console.log(data.data);
                        var jadwal = data.data.timings;
                        var timezone = data.data.meta.timezone;
                        var city = location.address.city || location.address.city_district;
                        var country = location.address.country;
                        displayPrayerTimes(jadwal, timezone, city, country, d);
                    })
                    .catch(error => {
                        console.error("Error getting city and country: ", error);
                        var jakartaLatitude = -6.186486;
                        var jakartaLongitude = 106.834091;
                        var solatApiErr =
                            `https://api.aladhan.com/v1/timings/${tanggal}?latitude=${jakartaLatitude}&longitude=${jakartaLongitude}&method=20&tune=1,1,1,1,1,1,1,1`;
                        var apiUrlErr =
                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${jakartaLatitude}&lon=${jakartaLongitude}&accept-language=id`;
                        fetch(solatApiErr)
                            .then(response => response.json())
                            .then(data => {
                                fetch(apiUrlErr)
                                    .then(response => response.json())
                                    .then(location => {
                                        console.log(data.data);
                                        var jadwal = data.data.timings;
                                        var timezone = data.data.meta.timezone;
                                        var city = location.address.city || location.address
                                            .city_district;
                                        var country = location.address.country;
                                        displayPrayerTimes(jadwal, timezone, city, country, d);
                                    })
                                    .catch(error => {
                                        console.error("Error getting city and country: ", error);
                                        const jakartaLatitude = -6.186486;
                                        const jakartaLongitude = 106.834091;
                                        getCityAndCountry(jakartaLatitude, jakartaLongitude);
                                        // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                                    });
                            })
                            .catch(error => {
                                console.error("Error getting city and country: ", error);
                            });
                        // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                    });
            })
            .catch(error => {
                console.error("Error getting city and country: ", error);
                var jakartaLatitude = -6.186486;
                var jakartaLongitude = 106.834091;
                var solatApiErr =
                    `https://api.aladhan.com/v1/timings/${tanggal}?latitude=${jakartaLatitude}&longitude=${jakartaLongitude}&method=20&tune=1,1,1,1,1,1,1,1`;
                var apiUrlErr =
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${jakartaLatitude}&lon=${jakartaLongitude}&accept-language=id`;
                fetch(solatApiErr)
                    .then(response => response.json())
                    .then(data => {
                        fetch(apiUrlErr)
                            .then(response => response.json())
                            .then(location => {
                                console.log(data.data);
                                var jadwal = data.data.timings;
                                var timezone = data.data.meta.timezone;
                                var city = location.address.city || location.address.city_district;
                                var country = location.address.country;
                                displayPrayerTimes(jadwal, timezone, city, country, d);
                            })
                            .catch(error => {
                                console.error("Error getting city and country: ", error);
                                const jakartaLatitude = -6.186486;
                                const jakartaLongitude = 106.834091;
                                getCityAndCountry(jakartaLatitude, jakartaLongitude);
                                // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                            });
                    })
                    .catch(error => {
                        console.error("Error getting city and country: ", error);
                    });

                // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
            });
    }

    function displayLocationInfo(city, district, country, fullAddress) {
        // Menambahkan informasi lokasi ke dalam elemen dengan id 'result-container'
        var resultContainer = $('#result-container');
        var html = '<h2>Informasi Lokasi</h2>';
        html += '<p>City: ' + city + '</p>';
        html += '<p>District/County: ' + district + '</p>';
        html += '<p>Country: ' + country + '</p>';
        html += '<p>Full Address: ' + fullAddress + '</p>';
        resultContainer.append(html);
    }

    function displayPrayerTimes(pray, timezone, city, country, date) {
        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        // tampilkan lokasi
        var locationContainer = $('#location');
        var location = city + ', ' + country;
        locationContainer.append('<i class="fa-solid fa-location-dot color-highlight font-14 me-2"></i>' + location);

        function displayTime() {
            const currentTime = new Date();
            const timeOptions = {
                timeZone: timezone,
                hour12: false,
                hour: 'numeric',
                minute: 'numeric'
            };
            var timeString = new Intl.DateTimeFormat('id-ID', timeOptions).format(currentTime);
            timeString = timeString.replace(/\./g, ':');
            document.getElementById('time').textContent = timeString;
        }
        displayTime();
        setInterval(displayTime, 1000);


        var tgl = date.toLocaleDateString("id-ID", options)
        var tglContainer = $('#tgl-container');
        tglContainer.append(tgl);

        var resultContainer = $('#result-container');
        var html = '<div class="card card-style mt-3">';
        html += '<div class="content row">';
        delete pray.Midnight;
        delete pray.Firstthird;
        delete pray.Lastthird;
        delete pray.Sunrise;
        delete pray.Sunset;
        $.each(pray, function(key, value) {
            html += '<div class="col-6 mb-3"><p class="font-14 color-theme">' + key + '</p></div>';
            html += '<div class="col-6 mb-3"><p class="font-16 color-theme text-end font-700">' + value +
                '</p></div>';
        });
        html += '</div>';
        html += '</div>';

        resultContainer.append(html);
    }

    // Periksa apakah browser mendukung Geolocation
    if ("geolocation" in navigator) {
        // Menggunakan Geolocation API untuk mendapatkan lokasi pengguna
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Mendapatkan informasi kota dan negara
            getCityAndCountry(latitude, longitude);
        }, function(error) {
            const d = new Date();
            var tanggal = d.getDate() + '-' + (d.getMonth() + 1) + '-' + d.getFullYear();
            var jakartaLatitude = -6.186486;
            var jakartaLongitude = 106.834091;
            var solatApiErr =
                `https://api.aladhan.com/v1/timings/${tanggal}?latitude=${jakartaLatitude}&longitude=${jakartaLongitude}&method=20&tune=1,1,1,1,1,1,1,1`;
            var apiUrlErr =
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${jakartaLatitude}&lon=${jakartaLongitude}&accept-language=id`;
            fetch(solatApiErr)
                .then(response => response.json())
                .then(data => {
                    fetch(apiUrlErr)
                        .then(response => response.json())
                        .then(location => {
                            console.log(data.data);
                            var jadwal = data.data.timings;
                            var timezone = data.data.meta.timezone;
                            var city = location.address.city || location.address.city_district;
                            var country = location.address.country;
                            displayPrayerTimes(jadwal, timezone, city, country, d);
                        })
                        .catch(error => {
                            console.error("Error getting city and country: ", error);
                            const jakartaLatitude = -6.186486;
                            const jakartaLongitude = 106.834091;
                            getCityAndCountry(jakartaLatitude, jakartaLongitude);
                            // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                        });
                })
                .catch(error => {
                    console.error("Error getting city and country: ", error);
                });
            console.error("Error getting location: ", error);
        });
    } else {
        // Browser tidak mendukung Geolocation
        console.log("Geolocation is not supported by your browser");
    }
    </script>

</body>

</html>