<!DOCTYPE html>
<html>

<head>
    <title>Surat Permohonan Izin</title>
</head>

<body style="background-image: url('<?php echo base_url().'asset/images/staff/bg_dokum.jpg'?>');
            background-position:top left;
            background-repeat:no-repeat;
            background-image-resize:4;
            background-image-resolution: from-image;">

    <div class="container">
        <div class="card text-center" style="width: 100%">
            <div class="card-body">
                <table>
                    <tr>
                        <th></th>
                    </tr>
                </table>
                <div class="row" style="margin-top: 4rem; text-align:center;">
                    <h3 class="card-title title" style="margin-bottom: 0;"><strong><u>SURAT PERMOHONAN IZIN</strong></u>
                    </h3>
                    <h5 class="card-text title" style="margin-top: 0;">
                        <?php echo $id ?>/S.KETERANGAN.VSW/<?php echo $bulan ?>/<?php echo date('Y') ?>
                    </h5>
                </div>
                <div class="row" style="text-align:justify; margin-left:1rem; margin-right:1rem;">
                    <p><strong><?php echo $header_surat ?></strong></p>
                    <p><strong>Di <br>&emsp;&emsp;&emsp;Tempat</strong><br>
                        Dengan Hormat,<br>
                        Yang bertanda tangan di bawah ini
                    </p>
                    <table>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>Nama</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;&ensp;&nbsp;</td>
                            <td> : </td>
                            <td>Annissa Zulfida Umasugi</td>
                        </tr>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>Jabatan</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td> : </td>
                            <td>Direktur Utama</td>
                        </tr>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>Alamat</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td> : </td>
                            <td>Jln. KH.M Yusuf Raya No. 18 A-B Mekar Jaya - Depok</td>
                        </tr>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>Telp</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td> : </td>
                            <td>021 7717785 / 0811145648</td>
                        </tr>
                    </table>
                    <p>Menerangkan bahwa:</p>
                    <table>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td><strong>Nama</strong></td>
                            <td></td>
                            <td>&emsp;</td>
                            <td><strong> : </strong></td>
                            <td><strong><?php echo $nama; ?></strong></td>
                        </tr>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td><strong><?php echo $jenis_nomor; ?></strong></td>
                            <td></td>
                            <td>&emsp;</td>
                            <td><strong> : </strong></td>
                            <td><strong><?php echo $nomor_induk; ?></strong></td>
                        </tr>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td><strong>Jabatan</strong></td>
                            <td></td>
                            <td>&emsp;</td>
                            <td><strong> : </strong></td>
                            <td><strong><?php echo $jabatan; ?></strong></td>
                        </tr>
                    </table>
                    <p>Bahwa benar nama di atas telah terdaftar sebagai jemaah di PT Ventura
                        Semesta Wisata selaku penyelenggara ibadah Haji dan Umroh yang insyaAllah akan
                        melaksanakan kegiatan Umroh dengan keberangkatan di tanggal <u><strong><span
                                    style="font-style: italic;"><?php echo $tanggal_mulai; ?>
                                    s/d <?php echo $tanggal_selesai; ?></span></strong></u>

                    </p>
                    <p>
                        Maka dari itu, Bapak/Ibu mohon dapat memberikan <?php echo $keterangan ?> terkait dengan
                        rencana keberangkatan yang bersangkutan.
                    </p>
                    <p>
                        Demikian surat keterangan ini dibuat dengan sebenar-benarnya agar dapat digunakan
                        sebagaimana mestinya, atas perhatian dan kerjasamanya kami ucapkan terima kasih.
                    </p>
                </div>
                <div class="row" style="text-align:left; margin-left:1rem;">
                    <p style="margin-bottom: 0;">Depok, <?php echo $tanggal_now?></p>
                    <p style="margin-top: 0;"><strong><u>PT. VENTURA SEMESTA WISATA</u></strong></p>
                    <img src="<?php echo base_url() . 'asset/images/staff/ttd/ttd.png' ;?>"
                        style="width: 200px; height:100px;">
                    <p style="margin-bottom: 0;"><strong><u>ANNISA Z. UMASUGI</u></strong></p>
                    <P style="margin-top: 0;"><strong> DIREKTUR UTAMA</strong></P>
                </div>
            </div>
        </div>
    </div>
</body>

</html>