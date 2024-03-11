<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get User Location</title>
</head>

<body>

    <div id="result-container">
        <!-- Hasil jadwal sholat dan informasi lokasi akan ditambahkan di sini -->
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    function getCityAndCountry(latitude, longitude) {
        var apiUrl =
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&accept-language=id`;
        // Menggunakan Fetch API untuk mengambil data dari Nominatim
        
        const d = new Date();
        var tanggal = d.getDate() + '-' + (d.getMonth()+1) + '-' + d.getFullYear();
        var solatApi = `https://api.aladhan.com/v1/timings/${tanggal}?latitude=${latitude}&longitude=${longitude}&method=20&tune=4,4,4,4,5,5,4,5`
        fetch(solatApi)
            .then(response => response.json())
            .then(data => {
                fetch(apiUrl)
                    .then(response => response.json())
                    .then(location => {
                        var jadwal = data.data.timings;
                        var city = location.address.city || location.address.city_district;
                        displayPrayerTimes(jadwal, city, d);
                    })
                    .catch(error => {
                        // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                        console.error("Error getting city and country: ", error);
                    });
            })
            .catch(error => {
                // Penanganan kesalahan jika gagal mendapatkan informasi kota dan negara
                console.error("Error getting city and country: ", error);
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

    function displayPrayerTimes(pray, city, date) {
        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        var tgl = date.toLocaleDateString("id-ID", options)
        // Menambahkan hasil jadwal sholat ke dalam elemen dengan id 'result-container'
        var resultContainer = $('#result-container');
        var html = '<h2>Jadwal Sholat</h2>';
        html += '<p>Tanggal: ' + tgl + '</p>';
        html += '<p>Kota: ' + city + '</p>';
        html += '<ul>';
        delete pray.Midnight;
        delete pray.Firstthird;
        delete pray.Lastthird;
        delete pray.Sunrise;
        delete pray.Sunset;
        $.each(pray, function(key, value) {
            html += '<li>' + key + ': ' + value + '</li>';
        });

        html += '</ul>';

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
            // Penanganan kesalahan jika mendapatkan lokasi gagal
            console.error("Error getting location: ", error);
        });
    } else {
        // Browser tidak mendukung Geolocation
        console.log("Geolocation is not supported by your browser");
    }
    </script>

</body>

</html>