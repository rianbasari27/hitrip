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
        z-index: 20;
        position: relative;
        left: 550px;
        top: 600px;
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
                    Jl. M. Yusuf Raya No. 18A-B<br>
                    DEPOK - 021-7717785
                </div>
            </td>
            <td class="bold header">
                Invoice<br>
                Tanggal : <?php echo $tanggal_pembayaran; ?>
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
            <td class="bold body-right" colspan="2"><?php echo $nama_paket; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">Pilihan Kamar</td>
            <td>:</td>
            <td class="body-right" colspan="2" style="padding-top: 10px; padding-bottom: 10px;">
                <ol>
                    <?php foreach ($riwayat['tarif']['dataMember'] as $dm) { ?>
                    <li>
                        <?php echo implode(" ", [$dm['detailJamaah']->first_name, $dm['detailJamaah']->second_name, $dm['detailJamaah']->last_name]); ?>
                        (<?php echo $dm['detailJamaah']->member[0]->pilihan_kamar; ?>)
                    </li>
                    <?php } ?>
                </ol>


        </tr>
        <tr>
            <td class="bold body-left">Cara Pembayaran</td>
            <td>:</td>
            <td class="body-right" colspan="2"><?php echo $cara_pembayaran; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">Tanggal Pembayaran</td>
            <td>:</td>
            <td class="body-right" colspan="2"><?php echo $tanggal_pembayaran; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">Atas Nama</td>
            <td>:</td>
            <td class="body-right" colspan="2" style="padding-top: 15px; padding-bottom: 15px;">
                <div>
                    <ol>
                        <?php foreach ($riwayat['tarif']['dataMember'] as $dm) { ?>
                        <li>
                            <?php echo implode(" ", [$dm['detailJamaah']->first_name, $dm['detailJamaah']->second_name, $dm['detailJamaah']->last_name]); ?>
                            (<?php echo $dm['detailJamaah']->ktp_no; ?>)&nbsp;(No WA :
                            <?php echo $dm['detailJamaah']->no_wa; ?>)
                        </li>
                        <?php } ?>
                    </ol>
                </div>
            </td>
        </tr>
        <tr>
            <td class="bold body-left">Konsultan</td>
            <td>:</td>
            <td class="body-right" colspan="2"><?php echo $agen; ?>
                <?php echo ($agenTelp != '') ? "(telp : $agenTelp)" : ''; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">Pembayaran (IDR)</td>
            <td>:</td>
            <td class="body-right money bold" colspan="2"><?php echo $jumlah_bayar; ?></td>
        </tr>
        <tr>
            <td class="bold body-left">SISA TAGIHAN (IDR)</td>
            <td>:</td>
            <td class="body-right money bold" colspan="2">Rp.
                <?php echo number_format($riwayat['sisaTagihan'], 0, ',', '.'); ?>,-</td>
        </tr>
        <tr>
            <td colspan="4" class="body-bottom"></td>
        </tr>
    </table>
    <div class="left-notes">
        Notes :
        <div class="box">
            <?php echo $keterangan; ?>
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

    <div class="stamps">
        <img src="<?php echo base_url() . 'asset/images/' . ($riwayat['sisaTagihan'] > 0 ? 'belum-lunas-stamps.png' : 'lunas-stamps.png') ?>" alt="Lunas" width="200px">
    </div>

    <div class="box-rincian">
        <h3>Rincian Pembayaran</h3>
        <table cellspacing="0">
            <?php $total_tagihan = 0 ?>;
            <?php foreach ($riwayat['tarif']['dataMember'] as $dm) { ?>
            <tr>
                <td style="text-align: left;">
                    <?php echo implode(" ", [$dm['detailJamaah']->first_name, $dm['detailJamaah']->second_name, $dm['detailJamaah']->last_name]); ?>
                </td>
                <td>:</td>
                <td><?php echo 'Rp. ' . number_format($dm['baseFee']['harga'], 0, ',', '.') . ',-'; ?></td>
                <?php echo $total_tagihan = $total_tagihan + $dm['baseFee']['harga']; ?>
            </tr>
            <?php } ?>
            <tr>
                <td style="text-align: left; padding-bottom: 10px;">Total Tagihan</td>
                <td style="padding-bottom: 10px;">:</td>
                <td style="padding-bottom: 10px;">
                    <?php echo 'Rp. ' . number_format($total_tagihan, 0, ',', '.') . ',-'; ?>
                </td>
            </tr>
            <tr>
                <th colspan="3" style="text-align: left;">Potongan/Extra Fee</th>
            </tr>
            <?php 
            $extraFee = 0;
            $dendaProgres = 0;
            foreach ($riwayat['tarif']['dataMember'] as $dm) { 
                // $dendaProgres = $dendaProgres + $dm['dendaProgresif']; 
                ?>
            <?php
                if (!empty($dm['dendaProgresif'])) {                    
                
                ?>
            <tr>
                <td>Denda Progresif</td>
                <td>:</td>
                <td><?php echo 'Rp. ' . number_format($dm['dendaProgresif'], 0, ',', '.') . ',-'; ?></td>
            </tr>
            <?php } ?>
            <?php foreach ($dm['extraFee'] as $ef) { 
                    // $extraFee = $extraFee + $ef->nominal;
                    ?>
            <tr>
                <td><?php echo $ef->keterangan; ?></td>
                <td>:</td>
                <td><?php echo 'Rp. ' . number_format($ef->nominal, 0, ',', '.') . ',-'; ?></td>
            </tr>
            <?php } ?>
            <?php } ?>
            <tr class="bg-warning text-white">
                <td style="padding-bottom: 10px;">Total Biaya</td>
                <td style="padding-bottom: 10px;">:</td>
                <td style="padding-bottom: 10px;">
                    <?php echo 'Rp. ' . number_format($riwayat['tarif']['totalHargaFamily']+$extraFee+$dendaProgres, 0, ',', '.') . ',-'; ?>
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
    </div>


    <div class="keterangan" style="font-size: 14px;">

        <p><strong>PERHATIAN KHUSUS:</strong></p>
        <ol>
            <li style="color: red;">Full payment paling lambat H-45 atau tanggal (<?php echo $this->date->convert('j F Y', $h_45) ?>)</li>
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
                Pembayaran Deposit dan Full payment dapat dilakukan pada hari kerja dari Senin s/d Jumat, pada jam 09.00 s/d 16.00 WIB dan Sabtu jam 09.00 s/d 13.00 WIB.
            </li>
            <li>
                Transaksi pembayaran setelah jam kerja akan dikonfirmasi dan diterbitkan tanda terimanya pada hari kerja berikutnya.
            </li>
            <li>
                Transaksi pembayaran dapat dilakukan dengan cara sebagai berikut:
                <ul>
                    <li>Transfer - Bukti tanda terima/ invoice akan diterbitkan setelah dana efektif masuk ke rekening PT. Ventura Semesta Wisata.</li>
                </ul>
            </li>
            <li>
                Pembayaran yang sudah diterima tidak dapat dikembalikan dan tidak dapat dirubah peruntukannya ke yang lain.
            </li>
        </ol>
        <p><strong>B. KEBIJAKAN PEMBATALAN</strong></p>
        <p><strong><span style="margin-left: 15px; border-bottom: 1px solid red;">Setelah konfirmasi diterima, jika ada pembatalan atau perubahan pemesanan, harap memberitahu kami melalui email, fax, alamat surat kepada bagian Manifest dan diberlakukan sesuai ketentuan diatas. Nama-nama calon Jama’ah sudah harus di berikan ke bagian Manifest pada saat pendaftaran.</span></strong></p>
    </div>
</body>

</html>