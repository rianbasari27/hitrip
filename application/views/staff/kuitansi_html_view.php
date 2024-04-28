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

    /* .logo {
        margin: 5px;
    }

    table {
        border-collapse: collapse;
    }

    td {
        padding-left: 10px;
    }

    .header {
        width: 270px;
    }

    .title-body {
        padding-top: 15px;
        padding-bottom: 15px;
        border-top: 1px solid black;
        border-left: 1px solid black;
        border-right: 1px solid black;
    }



    .bold {
        font-weight: bold;
    }

    .body-left {
        border-left: 1px solid black;
    }

    .body-right {
        border-right: 1px solid black;
    }

    .body-bottom {
        padding-top: 15px;
        border-bottom: 1px solid black;
        border-left: 1px solid black;
        border-right: 1px solid black;
    }

    .money {
        font-style: italic;
        text-decoration: underline;
    }

    .box {

        padding: 10px 10px 20px 10px;
        border: 1px solid;
        margin-bottom: 10px;
    }

    .box-rincian {
        padding: 10px 10px 70px 10px;
        border: 1px solid;
        margin-bottom: 10px;
        width: 385px;
        float: left;
    }

    .sig {
        text-align: right;
    }

    .penerima {
        display: inline;
        padding-top: 50px;
        text-decoration: underline;
        font-weight: bold;
    }

    .left-notes {
        padding-top: 10px;
        float: left;
        width: 60%;
    }

    .right-sign {
        padding-top: 15px;
        text-align: right;
        float: right;
        width: 40%;
    }

    .stamps {
        float: right;
        padding-left: 100px;
    }

    .keterangan {
        clear: both;
    } */
    /* tr:nth-child(2) {
        border-bottom: 2px solid black;
    } */
    </style>


</head>

<body>
        
    <table class="table">
        <tr>
            <td style="vertical-align: top; width: 280px;" colspan="3">
                <img width="140px" src="<?php echo base_url() . $logo ?>"><br>
            </td>
            <td colspan="3">
                <h3>INVOICE</h3><br>
                <h4>Nomor Invoice</h4>
                <p><?php echo '#' . $id . $riwayat['id_member'] . date('Ymd', strtotime($tanggal_pembayaran)); ?></p><br>
                <h4>Tanggal</h4>
                <p><?php echo isset($tanggal_pembayaran) ? $tanggal_pembayaran : '-' ?></p><br>
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
                <p><?php echo $nama ?></p>
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
            <td colspan="6"><hr></td><br>
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
            <td colspan="3"><hr></td>
        </tr>
        <?php $extraFee = 0 ?>
        <?php foreach ($riwayat['tarif']['dataMember'] as $dm) { ?>
            <?php foreach ($dm['potongan'] as $ef) { ?>
            <tr>
                <td colspan="3"></td>
                <td colspan="2"><p><?php echo $ef->keterangan ?></p><br></td>
                <td style="text-align: right;"><p><?php echo $this->money->format($ef->nominal); ?></p><br></td>
            </tr>
            <?php $extraFee += $ef->nominal ?>
            <?php } ?>
        <?php } ?>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                <h4>Total</h4><br>
            </td>
            <td style="text-align: right;">
                <?php 
                    $total = 0; 
                    foreach ($riwayat['tarif']['dataMember'] as $dm) {
                        $total += $dm['baseFee']['harga'] + $extraFee;
                    }
                ?>
                <h4><?php echo $this->money->format($total); ?></h4><br>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                <p>Total sudah bayar</p><br>
            </td>
            <td style="text-align: right;">
                <p><?php echo $this->money->format($riwayat['totalBayar']) ?></p><br>
            </td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="3"><hr></td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="2">
                <h4>Sisa tagihan</h4><br>
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
                <p><?php echo $cara_pembayaran ?></p><br>
                <h4>Tanggal Cetak:</h4>
                <p><?php echo $tanggal_cetak ?></p><br>
            </td>
        </tr>
    </table>
</body>

</html>