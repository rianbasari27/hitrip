<!DOCTYPE html>
<html>

<head>
    <title>Dokumen</title>
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
                <div class="row" style="margin-top: 6rem; text-align:center;">
                    <h3 class="card-title title" style="margin-bottom: 0;"><strong><u>SURAT PERNYATAAN DAN
                                JAMINAN</strong></u></h3>
                    <h5 class="card-text title" style="margin-top: 0;">No :
                        <?php echo $id_request ?>/S.Rekomendasi/VSW/<?php echo $bulan?>/2023
                    </h5>
                </div>
                <div class="row" style="text-align:justify; margin-left:1rem; margin-right:1rem;">
                    <p>Assalamualaikum wr.wb</p>
                    <p>Dengan Hormat,<br>
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
                    </table>
                    <p>Bersama dengan ini menerangkan dengan sesungguhnya bahwa:</p>
                    <table>
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td><strong>Nama Lengkap</strong></td>
                            <td></td>
                            <td>&emsp;</td>
                            <td><strong> : </strong></td>
                            <td><strong><?php echo $nama ;?></strong></td>
                        </tr>
                    </table>
                    <p>Adalah calon jamaah Umrah PT. Ventura Semesta Wisata yang tercatat sebagai
                        penyelenggara perjalanan ibadah umrah pada kementrian agama. Kami
                        bertanggung jawab dan menjamin sepenuhnya terhadap calon jamaah kami dengan
                        memperhatikan hal-hal sebagai berikut:
                    </p>
                    <ol>
                        <li>Permohonan paspor yang kami urus adalah WNI (Warga Negara Indonesia)
                            yang sebenarnya akan melakukan perjalanan ke arab Saudi dalam rangka
                            menunaikan ibadah umrah.
                        </li>
                        <li>Rombongan calon jamaah umrah yang kami urus tidak akan melakukan
                            pelanggaran peraturan keimigrasian berupa penyalahgunaan izin tinggal, dan
                            tidak melebihi izin tinggalnya (over stay), memalsukan passport yang
                            diberikan kepadanya maupun bekerja secara illegal.
                        </li>
                        <li>Apabila terjadi pelanggaran sebagai mana di maksud, maka izin usaha kami
                            sebagai penyelanggara perjalanan ibadah umrah bersedia dicabut.
                        </li>
                    </ol>
                    <p>&ensp;&ensp;&ensp;Dengan demikian surat pernyataan ini dibuat agar dapat di pergunakan
                        sebagai mana mestinya, atas perhatian dan bantuannya kami ucapkan terima
                        kasih
                    </p>
                </div>
                <div class="row" style="text-align:right; margin-right:1rem;">
                    <p style="margin-bottom: 0;">Depok, <?php echo $tanggal_now?></p>
                    <p style="margin-top: 0;"><strong><u>PT. VENTURA SEMESTA WISATA</u></strong></p>
                    <img src="<?php echo base_url() . 'asset/images/staff/ttd/ttd.png' ;?>" style="width: 200px; height:100px;">
                    <p style="margin-bottom: 0;"><strong><u>ANNISA Z. UMASUGI</u></strong></p>
                    <P style="margin-top: 0;"><strong> DIREKTUR UTAMA</strong></P>
                </div>
            </div>
        </div>
    </div>
</body>

</html>