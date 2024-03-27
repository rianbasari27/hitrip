<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Exchange Rates</title>
</head>

<body>

    <h1>Nilai Tukar Mata Uang</h1>

    <!-- Form input untuk mata uang awal, tujuan, dan jumlah -->
    <form id="exchangeForm">
        <label for="fromCurrency">Mata Uang Awal:</label>
        <input type="text" id="fromCurrency" name="fromCurrency" placeholder="Contoh: USD" required>
        <label for="toCurrency">Mata Uang Tujuan:</label>
        <input type="text" id="toCurrency" name="toCurrency" placeholder="Contoh: IDR" required>
        <label for="amount">Jumlah:</label>
        <input type="number" id="amount" name="amount" placeholder="Masukkan jumlah" required>
        <button type="submit">Periksa Nilai Tukar</button>
    </form>

    <div id="exchangeResult"></div>

    <!-- Script JavaScript untuk mengambil dan menampilkan data nilai tukar mata uang -->
    <script type="text/javascript">
    // Mendefinisikan URL API Open Exchange Rates
    var apiUrl = "https://openexchangerates.org/api/latest.json?app_id=1ee4fd1dc1fe4233bdb787a25d5e2bfe";

    // Mendapatkan elemen form dan hasil pertukaran
    var exchangeForm = document.getElementById("exchangeForm");
    var exchangeResult = document.getElementById("exchangeResult");

    // Menangani pengiriman form
    exchangeForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Menghentikan pengiriman form

        // Mendapatkan nilai dari input mata uang awal, tujuan, dan jumlah
        var fromCurrency = document.getElementById("fromCurrency").value.toUpperCase();
        var toCurrency = document.getElementById("toCurrency").value.toUpperCase();
        var amount = parseFloat(document.getElementById("amount").value);

        // Mengambil data nilai tukar mata uang dari API
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Memeriksa apakah permintaan berhasil
                if (data && data.rates) {
                    var exchangeRates = data.rates;

                    // Memeriksa apakah mata uang yang diminta tersedia dalam data nilai tukar
                    if (fromCurrency in exchangeRates && toCurrency in exchangeRates) {
                        var exchangeRate = exchangeRates[toCurrency] / exchangeRates[fromCurrency];
                        var convertedAmount = amount * exchangeRate;
                        var resultMessage = "Nilai tukar dari " + fromCurrency + " ke " + toCurrency +
                            " adalah " + convertedAmount.toFixed(4) + " " + toCurrency;
                        exchangeResult.textContent = resultMessage;
                    } else {
                        exchangeResult.textContent = "Mata uang tidak valid. Silakan coba lagi.";
                    }
                } else {
                    exchangeResult.textContent = "Gagal memperoleh data nilai tukar mata uang.";
                }
            })
            .catch(error => {
                console.error('Terjadi kesalahan:', error);
                // Menampilkan pesan kesalahan jika terjadi masalah dalam mengambil data nilai tukar mata uang
                exchangeResult.textContent =
                    "Terjadi kesalahan dalam mengambil data nilai tukar mata uang.";
            });
    });
    </script>

</body>

</html>