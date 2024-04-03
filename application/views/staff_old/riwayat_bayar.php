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
                font-weight: bold;
            }
            .button {
                display: inline;
                width: 45px;
                height: 15px;
                background: red;
                padding: 5px;
                text-align: center;
                border-radius: 5px;
                color: white;
                font-weight: bold;
            }
            .green_row{
                background-color: lightgreen;
            }
            .red_row{
                background-color: coral;
            }
            

        </style>
    </head>
    <body>
    <center>
        <table border="1">
            <tr>
                <th>Tanggal</th>
                <th>Jumlah Bayar</th>
                <th>Valid</th>
                <th>Cara Pembayaran</th>
                <th>Nomor Referensi</th>
                <th>Keterangan</th>
                <th>Bukti Pembayaran</th>
            </tr>
            <?php if (!empty($data)) { ?>
                <?php foreach ($data as $dt) { ?>
                    <?php
                    switch ($dt->verified) {
                        case 1:

                            $class = 'green_row';
                            break;
                        case 2:
                            $class = 'red_row';
                            break;

                        default:
                            $class = 'white_row';
                            break;
                    }
                    ?>
                    <tr class="<?php echo $class;?>">
                        <td>
                            <?php echo $dt->tanggal_bayar; ?>
                            <?php if (in_array($_SESSION['bagian'], array('Finance', 'Master Admin'))) { ?>
                                <a class="button" href="<?php echo base_url() ?>staff/bayar/hapus_pembayaran?idp=<?php echo $dt->id_pembayaran ?>&idm=<?php echo $id_member; ?>">Hapus</a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php echo 'Rp. ' . number_format($dt->jumlah_bayar, null, ',', '.') . ',-'; ?> 

                        </td>
                        <td>
                            <?php
                            if ($dt->verified == 0)
                                echo 'Belum Cek';
                            if ($dt->verified == 1)
                                echo 'Ya';
                            if ($dt->verified == 2)
                                echo 'Tidak';
                            ?>
                        </td>
                        <td><?php echo $dt->cara_pembayaran; ?></td>
                        <td><?php echo $dt->nomor_referensi; ?></td>
                        <td><?php echo $dt->keterangan; ?></td>
                        <td>
                            <?php if ($dt->scan_bayar) { ?>
                                <a href="<?php echo base_url() . $dt->scan_bayar; ?>" download>Download</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr id="total" class="green_row">
                <td>Total</td>
                <td><?php echo 'Rp. ' . number_format($totalBayar, null, ',', '.') . ',-'; ?></td>
            </tr>
        </table>
    </center>
</body>
</html>



