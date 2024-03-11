<html>

<head>

</head>

<body>
    <div class="container">
        <div class="card text-center" style="width: 100%">
            <div class="card-body">
                <table>
                    <tr>
                        <th></th>
                    </tr>
                </table>
                <div class="row" style="margin-top: 10rem; margin-left:5rem; text-align: justify; margin-right: 5rem;">
                    <p>Kepada Yth.</p>
                    <p> Bapak/Ibu Kepala Kantor Imigrasi <?php echo $imigrasi ?><br> Di <br>&emsp;&emsp;&emsp;Tempat</p>
                    <p><strong>Assalamualaikum wr.wb</strong></p>
                    <p>Dengan Hormat,</p>
                    <p>Bersama ini kami <strong>PT. VENTURA SEMESTA WISATA</strong> selaku penyelenggara
                        program umroh menerangkan bahwa :</p>
                    <table border="1" style="border-collapse:collapse; width:100%; text-align:center;">
                        <tr>
                            <th class="thead-dark">&nbsp;No&nbsp;</th>
                            <th class="thead-dark">&nbsp;Nama Lengkap&nbsp;</th>
                            <th class="thead-dark">&nbsp;Tempat, Tanggal Lahir&nbsp;</th>
                            <th class="thead-dark">&nbsp;NIK&nbsp;</th>
                        </tr>
                        <?php 
           $no = 0;
           {
            $no=$no+1;

         ?>
                        <tr>
                            <td>&nbsp;<?php echo $no ;?>&nbsp;</td>
                            <td>&nbsp;<?php echo $nama ;?>&nbsp;</td>
                            <td>&nbsp;<?php echo $tgl_lahir ;?>&nbsp;</td>
                            <td>&nbsp;<?php echo $ktp_no ;?>&nbsp;</td>
                        </tr>
                        <?php } ?>
                    </table>
                    <p>Bahwa nama tersebut adalah Calon Peserta Umroh, yang akan melaksanakan
                        perjalanan umrah berdasarkan surat keterangan</p>
                    <p>No :
                        <?php echo $id_request ?>/S.Rekomendasi/VSW/<?php echo $bulan ;?>/<?php echo date('Y');?>
                        pada tanggal <?php echo $tanggal_berangkat.'.' ?> s/d
                        <?php echo $tanggal_pulang. '.'; ?>
                    </p>
                    <p>Surat rekomendasi ini diberikan sebagai jaminan persyaratan untuk
                        <?php echo ($tambah_nama != 1) ?  "pembuatan" : "penambahan nama" ; ?> paspor terkait dengan
                        rencana
                        keberangkatan yang bersangkutan.
                    </p>

                    <p>Wassalamualaikum. Wr. Wb.</p>
                    <p style="margin-bottom:0;">Hormat Saya,<br>
                        Depok, <?php echo $tanggal_now?></p>
                    <p style="margin-top:0;"><strong><u>PT. VENTURA SEMESTA WISATA</u></strong></p>
                    <img src="<?php echo base_url() . 'asset/images/staff/ttd/ttd.png' ;?>"
                        style="width: 200px; height:100px;">
                    <p style="margin-bottom:0;"><strong><u>ANNISA Z. UMASUGI</u></strong></p>
                    <P style="margin-top:0;"><strong> DIREKTUR UTAMA</strong></P>
                </div>
            </div>
        </div>
    </div>

</body>

</html>