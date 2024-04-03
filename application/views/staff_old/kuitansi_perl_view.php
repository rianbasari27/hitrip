<html>

<head>
    <style>
    .logo {
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
        /* border-top: 1px solid black; */
    }

    /* @page {
        margin-top: 2.5cm;
        margin-bottom: 2.5cm;
        margin-left: 2.5cm;
        margin-right: 2.5cm;
    } */



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
        padding-top: 10px;
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
    }
    </style>


</head>

<body>
    <table>
        <tr>
            <td class="header" colspan="2">
                <div class="logo">
                    <img width="200px" src="<?php echo base_url() .  $logo ;?>"><br>
                </div>
            </td>
            <td class="header">
                <div>
                    PT.VENTURA SEMESTA WISATA<br>
                    Jl. M. Yusuf Raya No. 18A-B<br>
                    DEPOK - 021-7717785
                </div>
            </td>
            <td class="bold header">
            </td>
        </tr>
        <tr>
            <td colspan="5">
                <hr>
            </td>
        </tr>
        <tr>
            <td>Sudah Diterima Oleh</td>
            <td>:</td>
            <td colspan="2"><?php echo $nama;?></td>
        </tr>
        <tr>
            <td style="padding-bottom: 15px;">Tanggal Cetak</td>
            <td style="padding-bottom: 15px;">:</td>
            <td colspan="2" style="padding-bottom: 15px;"> <?php echo $dateNow;?></td>
        </tr>
        <tr>
            <td class="body-bottom" colspan="5"></td>
        </tr>
        <?php foreach ($members as $member) : ?>
        <tr>
            <td class="title-body" colspan="4"><strong>Informasi Perlengkapan</strong></td>
        </tr>
        <tr>
            <td>Nama Jamaah</td>
            <td>:</td>
            <td class="bold" colspan="2"><?php echo $member->jamaahData->first_name ;?></td>
        </tr>
        <tr>
            <td>Program</td>
            <td>:</td>
            <td colspan="2"><?php echo $member->jamaahData->member[0]->paket_info->nama_paket . ' - ( ' . $this->date->convert("j F Y", $member->jamaahData->member[0]->paket_info->tanggal_berangkat) . ' )';?></td>
        </tr>
        <tr>
            <td colspan="4" style="vertical-align: top; padding-top:10px; padding-bottom:10px;">Detail Perlengkapan (
                Sudah Diambil
                )</td>
        </tr>
        <?php if (!empty($member->riwayatAmbil['dateGroup'])) { ?>
        <tr style="border: 1px solid black;">
            <th>Tanggal</th>
            <th colspan="3">Barang Sudah Ambil</th>
        </tr>
        <?php foreach ($member->riwayatAmbil['dateGroup'] as $tglAmbil => $ambil) { ?>
        <tr style="border: 1px solid black;">
            <td style="vertical-align: top; border: 1px solid black;"><?php echo $tglAmbil ;?></td>
            <!-- <td style="vertical-align: top;">:</td> -->
            <td colspan="3">
                <ol>
                    <?php foreach ($ambil as $a) { ?>
                    <li><?php echo $a->nama_barang;?></li>
                    <?php } ?>
                </ol>
            </td>
        </tr>
        <?php } ?>
        <tr style="border: 1px solid black;">
            <td>Status Pengambilan</td>
            <!-- <td style="padding-top: 20px;">:</td> -->
            <td colspan="5"><?php echo $member->status;?></td>
        </tr>
        <?php } else { ?>
        <tr>
            <td>Status Pengambilan</td>
            <td>:</td>
            <td colspan="3"><?php echo $member->status ;?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="6" class="body-bottom"></td>
        </tr>
        <?php endforeach ?>
        <tr>
            <td style="padding-top: 50px; text-align: center;">Yang Menyerahkan</td>
            <td></td>
            <td></td>
            <td colspan="2" style="padding-top: 50px;text-align: center;">
                Yang Menerima
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
            <?php if ($staff != null) { ?>
                <img src="<?php echo base_url() . 'asset/images/' . ($staff == 'Qonita' ? 'ttd_qonita.png' : 'ttd_ilham.png') ?>" width="128px"><br>
                <strong><?php echo $staff ?></strong>
            <?php } ?>
            </td>
            <td></td>
            <td></td>
            <td colspan="2" style="padding-top: 120px; text-align: center;"><strong><?php echo $nama_penerima ?></strong></td>
        </tr>
    </table>

</body>

</html>