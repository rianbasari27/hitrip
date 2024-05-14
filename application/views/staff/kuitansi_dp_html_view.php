<html>

<head>
    <style>
    * {
        line-height: 20px;
    }
    body {
        margin: 0;
        padding: 0;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        /* margin-top: -100px; */
    }
    .table-active {
        background-color: rgba(0, 0, 0, .075);
    }
    h1, h2, h3, h4, h5 {
        line-height: 10px;
    }
    p {
        line-height: 10px;
        color: #808080;
    }

    .unpaid-tag {
        position: absolute;
        float: right;
        z-index: 10;
    }

    .float-end {
        float: end;
    }
    </style>


</head>

<body>
    
    <img src="<?php echo base_url() ?>asset/appkit/images/unpaid.png" width="130px" class="unpaid-tag">
    <div class="float-end"></div>
    <table class="table">
        <tr>
            <td style="vertical-align: top; width: 350px;" colspan="3">
                <img width="140px" src="<?php echo base_url() . $logo ?>"><br>
            </td>
            <td colspan="3">
                <h3>INVOICE</h3><br>
                <h4>Nomor Invoice</h4>
                <p><?php echo '#' . $id . $riwayat['id_member'] . date('Ymd'); ?></p><br>
                <h4>Tanggal</h4>
                <p><?php echo isset($tanggal) ? $tanggal : '-' ?></p><br>
            </td>
        </tr>
        <tr>
            <td colspan="6">
                <hr  style="height: 3px;">
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <h4>Ditagih kepada</h4>
                <p><?php echo $name ?></p>
                <p><?php echo $email ?></p>
                <p><?php echo $no_wa ?></p><br>
            </td>
            <td colspan="3">
                <h4>Ditagih oleh</h4>
                <p>HiTrip</p>
                <p>info@hi-trip.com</p>
                <p>(021) 726 287812</p><br>
            </td>
        </tr>
        <tr>
            <td colspan="6"><hr></td>
        </tr>
        <tr>
            <td colspan="3">
                <h4>Paket</h4>
            </td>
            <td>
                <h4>Tipe/Jenis</h4>
            </td>
            <td style="text-align: center;">
                <h4>Jumlah</h4>
            </td>
            <td style="text-align: right;">
                <h4>Harga</h4>
            </td>
        </tr>
        <tr>
            <td colspan="6"><hr></td>
        </tr>
        <tr>
            <td colspan="3">
                <h4><?php echo $nama_paket ?></h4><br>
            </td>
            <td>
                <p><?php echo $riwayat['tarif']['dataMember'][$riwayat['id_member']]['baseFee']['pilihanKamar'] ?></p><br>
            </td>
            <td style="text-align: center;">
                <p><?php echo count($riwayat['tarif']['dataMember']) ?></p><br>
            </td>
            <td style="text-align: right;">
                <p><?php echo $this->money->format($riwayat['tarif']['dataMember'][$riwayat['id_member']]['baseFee']['harga']) ?></p><br>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <!-- <td colspan="3"><hr></td> -->
        </tr>
        <?php $extraFee = 0 ?>
        <?php foreach ($riwayat['tarif']['dataMember'] as $dm) { ?>
            <?php foreach ($dm['potongan'] as $ef) { ?>
            <tr>
                <td colspan="3"></td><br>
                <td colspan="2"><p><?php echo $ef->keterangan ?></p></td><br>
                <td style="text-align: right;"><p><?php echo $this->money->format($ef->nominal); ?></p></td><br>
            </tr>
            <?php $extraFee += $ef->nominal ?>
            <?php } ?>
        <?php } ?>
        <tr>
            <td colspan="3"></td>
            <td colspan="3"><hr></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                <h4>Total tagihan</h4><br>
            </td>
            <td style="text-align: right;">
                <h4><?php echo $this->money->format($riwayat['sisaTagihan']) ?></h4><br>
            </td>
        </tr>
        <tr>
            <td colspan="6"><hr style="height: 3px;"></td>
        </tr>
        <tr>
            <td colspan="3">
                <h4>Payment Via:</h4>
                <div style="display: flex;">
                    <img src="<?php echo $payment_method['icon'] ?>" width="50px">
                    <p style="margin-bottom: auto; margin-top: auto; margin-left: 5px;"><?php echo $payment_method['bankName'] ?></p>
                    <p>7261829103 (DEMO) a/n HiTrip</p>

                </div><br>
                <h4>Tanggal Cetak:</h4>
                <p><?php echo $tanggal_cetak ?></p><br>
            </td>
        </tr>
    </table>
</body>

</html>