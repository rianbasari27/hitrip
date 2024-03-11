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
    }
    </style>


</head>

<body>
    <table>
        <tr>
            <td class="header" colspan="2">
                <div class="logo">
                    <img width="200px" src="<?php echo base_url() . $logo ?>"><br>
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
                Invoice<br>
                Tanggal : <?php echo isset($tanggal_pembayaran) ? $tanggal_pembayaran : '-'; ?>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <hr>
            </td>
        </tr>
        <tr>
            <td>Sudah Diterima Dari</td>
            <td>:</td>
            <td colspan="2"><?php echo $nama; ?></td>
        </tr>
        <tr>
            <td style="padding-bottom: 15px;">Tanggal Cetak Kwitansi</td>
            <td style="padding-bottom: 15px;">:</td>
            <td colspan="2" style="padding-bottom: 15px;"><?php echo $tanggal_cetak; ?></td>
        </tr>

        <tr>
            <td class="title-body" colspan="4"><strong>Untuk Pembayaran :</strong></td>
        </tr>
        <tr>
            <td class="bold body-left">Program</td>
            <td>:</td>
            <td class="bold body-right" colspan="2">
                <?php echo $nama_paket; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">Cara Pembayaran</td>
            <td>:</td>
            <td class="body-right" colspan="2"><?php echo isset($cara_pembayaran) ? $cara_pembayaran : '-'; ?></td>
        </tr>
        <tr>
            <?php if (isset($jenis)) : ?>
            <td class="bold body-left">Tanggal <?php echo $jenis == 'bayar_konsultan' ? 'Pembayaran' : 'Refund' ;?></td>
            <td>:</td>
            <td class="body-right" colspan="2"><?php echo $tanggal_pembayaran; ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <td class="bold body-left">Atas Nama</td>
            <td>:</td>
            <td class="body-right" colspan="2" style="padding-top: 15px; padding-bottom: 15px;">
                <div>
                    <ol>
                        <?php foreach ($riwayat['tarif']['dataMember'] as $dm) { ?>
                        <li>
                            <?php echo $dm['detailAgen'][0]->nama_agen; ?>
                            (<?php echo $dm['detailAgen'][0]->no_ktp; ?>)&nbsp;(No WA :
                            <?php echo $dm['detailAgen'][0]->no_wa; ?>)
                        </li>
                        <?php } ?>
                    </ol>
                </div>
            </td>
        </tr>
        <tr>
            <?php if (isset($jenis)) : ?>
            <td class="bold body-left"><?php echo $jenis == 'bayar_konsultan' ? 'Pembayaran' : 'Refund' ;?> (IDR)</td>
            <td>:</td>
            <td class="body-right money bold" colspan="2"><?php echo $jumlah_bayar; ?></td>
            <?php endif; ?>
        </tr>
        <tr>
            <?php if (isset($jenis)) : ?>
            <td class="bold body-left">SISA TAGIHAN (IDR)</td>
            <td>:</td>
            <td class="body-right money bold" colspan="2">Rp.
                <?php echo number_format($riwayat['sisaTagihan'], 0, ',', '.'); ?>,-</td>
            <?php endif; ?>
        </tr>
        <tr>
            <td colspan="4" class="body-bottom"></td>
        </tr>
    </table>
    <div class="left-notes">
        Notes :
        <div class="box">
            <?php echo isset($keterangan) ? $keterangan : ''; ?>
        </div>
    </div>
    <div class="right-sign">
        Penerima
        <!-- <div class="penerima">
        </div> -->
        <div class="bold">
            Ventour Finance

        </div>
    </div>
    <br>

    <div class="box-rincian">
        <?php if (isset($jenis)) : ?>
        <h3>Rincian Pembayaran</h3>
        <table cellspacing="0">
            <?php $total_tagihan = 0 ?>
            <?php foreach ($riwayat['tarif']['dataMember'] as $dm) { ?>
            <tr>
                <td style="text-align: left;">
                    <?php echo $dm['detailAgen'][0]->nama_agen; ?>
                </td>
                <td>:</td>
                <td><?php echo 'Rp. ' . number_format($dm['baseFee']['harga'], 0, ',', '.') . ',-'; ?></td>
            </tr>
            <tr>
                <th colspan="3" style="text-align: left;">Potongan</th>
            </tr>
            <tr>
                <td style="text-align: left; padding-bottom: 10px;"><?php echo $dm['deskripsiDiskon'] ;?></td>
                <td style="padding-bottom: 10px;">:</td>
                <td style="padding-bottom: 10px;">
                    <?php echo 'Rp. ' . number_format($dm['diskon'], 0, ',', '.') . ',-'; ?>
                </td>
            </tr>
            <?php } ?>
            <tr class="bg-warning text-white">
                <td style="padding-bottom: 10px;">Total Biaya</td>
                <td style="padding-bottom: 10px;">:</td>
                <td style="padding-bottom: 10px;">
                    <?php echo 'Rp. ' . number_format($riwayat['tarif']['total_harga'], 0, ',', '.') . ',-'; ?>
                </td>
            </tr>

            <tr>
                <th colspan="3" style="text-align: left;">Untuk Pembayaran</th>
            </tr>
            <?php foreach ($riwayat['data'] as $byr) { ?>
            <tr>
                <td>Tanggal
                    <?php echo $this->date->convert("d M Y", $byr->tanggal_bayar) . " ( " . $byr->id_pembayaran . " )"; ?>
                </td>
                <td>:</td>
                <td>
                    Rp. <?php echo number_format($byr->jumlah_bayar, 0, ',', '.'); ?>,-
                </td>
            </tr>
            <?php } ?>
            <tr class="bg-warning text-white">
                <th style="padding: 10px 0px 10px 0px;">Total Sudah Bayar</th>
                <td style="padding: 10px 0px 10px 0px;">:</td>
                <th style="padding: 10px 0px 10px 0px;">Rp.
                    <?php echo number_format($riwayat['totalBayar'], 0, ',', '.'); ?>,-</th>
            </tr>
            <tr class="bg-primary text-white">
                <th>SISA TAGIHAN</th>
                <td>:</td>
                <th>Rp. <?php echo number_format($riwayat['sisaTagihan'], 0, ',', '.'); ?>,-</th>
            </tr>
        </table>
        <?php else : ?>
        <table>
            <tr>
                <th>
                    <h3>Total DP</h3>
                </th>
                <td>
                    <h3>:</h3>
                </td>
                <th>
                    <h3>Rp. <?php echo number_format($totalDp, 0, ',', '.'); ?></h3>
                </th>
            </tr>
        </table>
        <?php endif; ?>
    </div>


    <div class="stamps">
        <img src="<?php echo base_url() . 'asset/images/' . $logoLunas ?>" alt="Lunas" width="200px">
    </div>

    <!-- 
    <div class="keterangan" style="font-size: 14px;">

        <p><strong>PERHATIAN KHUSUS:</strong></p>
        <ol>
            <li style="color: red;">Full payment paling lambat H-45 atau tanggal
                (<?php echo $this->date->convert('j F Y', $h_45) ?>)</li>
            <li>Harga sewaktu-waktu dapat berubah tanpa pemberitahuan sebelumnya.</li>
            <li>Transaksi Pembayaran dilakukan dengan (IDR) Rupiah Indonesia.</li>
            <li>Membayar berarti setuju dengan semua syarat dan ketentuan yang berlaku ( Terlampir )</li>
            <li>Harga mengacu kurs Rp.16.000</li>
        </ol>

        <p><strong><span style="border-bottom: 2px solid red;">SYARAT & KETENTUAN</span></strong></p>
        <p><strong>A. PROSEDUR PEMBAYARAN</strong></p>
        <ol type="I">
            <li>
                Pemesanan program &gt; 60 hari sebelum keberangkatan;
                <ul>
                    <li><strong>Deposit IDR 15,000,000 Per Orang/ Pax</strong></li>
                </ul>
            </li>
            <li>
                Pemesanan program antara 45-14 hari sebelum keberangkatan;
                <ul>
                    <li><strong>Diharuskan FULL PAYMENT</strong></li>
                </ul>
            </li>
            <li>
                Pembayaran Deposit dan Full payment dapat dilakukan pada hari kerja dari Senin s/d Jumat, pada jam 09.00
                s/d 16.00 WIB dan Sabtu jam 09.00 s/d 13.00 WIB.
            </li>
            <li>
                Transaksi pembayaran setelah jam kerja akan dikonfirmasi dan diterbitkan tanda terimanya pada hari kerja
                berikutnya.
            </li>
            <li>
                Transaksi pembayaran dapat dilakukan dengan cara sebagai berikut:
                <ul>
                    <li>Transfer - Bukti tanda terima/ invoice akan diterbitkan setelah dana efektif masuk ke rekening
                        PT. Ventura Semesta Wisata.</li>
                </ul>
            </li>
            <li>
                Pembayaran yang sudah diterima tidak dapat dikembalikan dan tidak dapat dirubah peruntukannya ke yang
                lain.
            </li>
        </ol>
        <p><strong>B. KEBIJAKAN PEMBATALAN</strong></p>
        <p><strong><span style="margin-left: 15px; border-bottom: 1px solid red;">Setelah konfirmasi diterima, jika ada
                    pembatalan atau perubahan pemesanan, harap memberitahu kami melalui email, fax, alamat surat kepada
                    bagian Manifest dan diberlakukan sesuai ketentuan diatas. Nama-nama calon Jama’ah sudah harus di
                    berikan ke bagian Manifest pada saat pendaftaran.</span></strong></p>
    </div> -->
</body>

</html>