<html>

<head>
    <style>
    .logo {
        background-color: white;
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

        padding: 10px 10px 70px 10px;
        border: 1px solid;
        margin-bottom: 10px;
    }

    .box-rincian {
        padding: 10px 10px 70px 10px;
        border: 1px solid;
        margin-bottom: 10px;
        width: 385px;
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

    .left-sign {
        padding-top: 15px;
        float: left;
        width: 60%;
    }

    .right-sign {
        padding-top: 15px;
        text-align: right;
        float: right;
        width: 40%;
    }
    </style>


</head>

<body>
    <table>
        <tr>
            <td class="header" colspan="2">
                <div class="logo">
                    <img width="200px" src="<?php echo base_url(); ?>asset/login/images/LOGO-VENTOUR.png"><br>
                </div>
            </td>
            <td class="header">
                <div>
                    PT.VENTURA SEMESTA WISATA<br>
                    Jl. M. Yusuf Raya No. 23<br>
                    DEPOK - 021-7717785
                </div>
            </td>
            <td class="bold header">
                Tanda Terima Perlengkapan
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <hr>
            </td>
        </tr>
        <tr>
            <td class="title-body" colspan="4"></td>
        </tr>
        <tr>
            <td class="bold body-left">Nama</td>
            <td>:</td>
            <td class="bold body-right" colspan="2"><?php echo $nama; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">No KTP</td>
            <td>:</td>
            <td class="body-right" colspan="2"><?php echo $no_ktp; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">Nama Paket</td>
            <td>:</td>
            <td class="body-right" colspan="2">
                <?php echo $nama_paket.", ". $this->date->convert("j F Y", $tgl_berangkat);?></td>
        </tr>
        <tr>
            <td class="bold body-left">Tanggal Pengambilan</td>
            <td>:</td>
            <td class="body-right" colspan="2"><?php echo $tgl_ambil; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">Barang yang Di Ambil</td>
            <td>:</td>
            <td class="body-right" colspan="2" style="padding-top: 25px; padding-bottom: 25px;">
                <div>
                    <ol>
                        <?php foreach ($sudahAmbil as $ambil) { ?>
                        <li>
                            <?php echo implode(" ", [$ambil->nama_barang]); ?>
                            (<?php echo $ambil->jumlah_ambil . " ". $ambil->stok_unit?>)
                        </li>
                        <?php } ?>
                    </ol>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="4" class="body-bottom"></td>
        </tr>
    </table>
    <br><br>
    <div class="row">
        <div class="left-sign">
            Yang Menyerahkan
            <br><br><br><br><br>
            <div class="bold">
                <?php echo $nama_staff ;?>
            </div>
        </div>
        <div class="right-sign">
            Yang Menerima
            <br><br><br><br><br>
            <div class="bold">
            <?php echo $nama_penerima ;?>
            </div>
        </div>
    </div>

</body>

</html>