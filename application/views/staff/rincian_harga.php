<html>
    <head>
        <style>
            table {
                border-collapse: collapse;
            }
            table, th, td {
                border: 1px solid black;
            }
            tr:hover {background-color: #f5f5f5;}
            th {
                background-color: violet;
                color: white;
                text-align: center;
            }
            th, td {
                padding: 10px;
            }
            #total{
                background-color: #f2f2f2;
                font-weight: bold;
            }

        </style>
    </head>
    <body>
    <center>
        <table border="1">
            <tr>
                <th>Item</th>
                <th>Keterangan</th>
                <th>Harga</th>
            </tr>
            <tr>
                <td>Jenis Kamar</td>
                <td><?php echo $baseFee['pilihanKamar']; ?></td>
                <td><?php echo 'Rp. ' . number_format($baseFee['harga'], null, ',', '.') . ',-'; ?></td>
            </tr>
            <?php if (!empty($dendaProgresif)) { ?>
                <tr>
                    <td>Denda Progresif</td>
                    <td></td>
                    <td><?php echo 'Rp. ' . number_format($dendaProgresif, null, ',', '.') . ',-'; ?></td>
                </tr>
            <?php } ?>
            <?php if (!empty($extraFeeProgram)) { ?>
                <td>Extra Fee Program</td>
                    <td><?php echo $deskripsiExtraFeeProgram;?></td>
                    <td><?php echo 'Rp. ' . number_format($extraFeeProgram, null, ',', '.') . ',-'; ?></td>
            <?php } ?>
            <?php if (!empty($extraFee)) { ?>
                <?php foreach ($extraFee as $ef) { ?>
                    <tr>
                        <td>Extra Fee</td>
                        <td><?php echo $ef->keterangan; ?></td>
                        <td><?php echo 'Rp. ' . number_format($ef->nominal, null, ',', '.') . ',-'; ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr  id="total">
                <td colspan="2">Total</td>
                <td><?php echo 'Rp. ' . number_format($totalHarga, null, ',', '.') . ',-'; ?></td>
            </tr>
        </table>
    </center>
</body>
</html>

