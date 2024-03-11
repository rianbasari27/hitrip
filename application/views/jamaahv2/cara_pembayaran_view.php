<div class="card card-style">
    <div class="content mb-0">
        <h4 class="color-highlight">Cara Pembayaran </h4>
        <div class="list-group list-custom-small list-icon-0">
            <a data-bs-toggle="collapse" class="no-effect" href="#collapse-7">
                <span class="font-14">Melalui Aplikasi BSI Mobile (m-Banking BSI)</span>
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
        <div class="collapse" id="collapse-7">
            <div class="list-group list-custom-small ps-3">
                <ol>
                    <li>Buka Aplikasi BSI Mobile</li>
                    <li>Pilih menu <strong>Bayar</strong></li>
                    <li>Pilih menu <strong>Institusi</strong></li>
                    <li>Masukkan Nama Institusi dengan kode <strong>5720</strong> atau <strong>PT Ventura Semesta Wisata</strong></li>
                    <li>Masukan ID Pelanggan/Kode Bayar dengan nomor VA : <strong><?php echo $nomorVAOpen; ?> <button onclick="CopyMe('<?php echo $nomorVAOpen;?>')"><i class="fa-solid fa-clipboard"></i></button></strong></li>
                    <li>Masukkan Nominal sesuai tagihan yang akan dibayarkan</li>
                    <li>Masukkan PIN BSI Anda</li>
                    <li>Transaksi selesai</li>
                </ol>
            </div>
        </div>
        <div class="list-group list-custom-small list-icon-0">
            <a data-bs-toggle="collapse" class="no-effect" href="#collapse-1">
                <span class="font-14">Dari Virtual Account BSI</span>
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
        <div class="collapse" id="collapse-1">        
            <div class="list-group list-custom-medium ps-3">
                <ol>
                    <li>Login ke BSI Mobile</li>
                    <li>Pilih menu <strong>Bayar &rarr; Institusi</strong></li>
                    <img src="<?php echo base_url() . 'asset/appkit/images/ventour/bayar.jpg'; ?>" class="mx-10"  width="100px"> 
                    <img src="<?php echo base_url() . 'asset/appkit/images/ventour/institusi.jpg'; ?>" class="mx-10" width="100px">
                    <li>Masukan nama <strong>Institusi</strong>, cari atau ketik <strong>5720 - PT. Ventura Semesta
                            Wisata</strong></li>
                    <img src="<?php echo base_url() . 'asset/appkit/images/ventour/cari.jpg'; ?>" class="mx-10" width="100px">
                    <li>Pilih <strong>5720 - PT. Ventura Semesta Wisata</strong></li>
                    <img src="<?php echo base_url() . 'asset/appkit/images/ventour/pilih_ventour.jpg'; ?>" class="mx-10" width="100px">
                    <li>Masukan <strong>Nomor VA : <?php echo $nomorVAOpen ;?> <button onclick="CopyMe('<?php echo $nomorVAOpen;?>')"><i class="fa-solid fa-clipboard"></i></button></strong></li>
                    <img src="<?php echo base_url() . 'asset/appkit/images/ventour/input_va.jpg'; ?>" class="mx-10" width="100px">
                    <li>Masukkan jumlah uang sesuai tagihan yang akan dibayarkan </li>
                    <img src="<?php echo base_url() . 'asset/appkit/images/ventour/input_nominal.jpg'; ?>" class="mx-10" width="100px">
                    <li>Ikuti petunjuk selanjutnya untuk menyelesaikan proses pembayaran</li>
                </ol>
            </div>
        </div>

        <div class="list-group list-custom-small list-icon-0">
            <a data-bs-toggle="collapse" class="no-effect" href="#collapse-2">
                <span class="font-14">Melalui ATM Bank BSI</span>
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
        <div class="collapse" id="collapse-2">
            <div class="list-group list-custom-small ps-3">
                <ol>
                    <li>Masukan kartu ATM dan pin anda</li>
                    <li>Pilih <strong>Menu Utama/Lainnya</strong></li>
                    <li>Pilih <strong>Menu Transfer</strong></li>
                    <li>Pilih <strong>jenis Rekening &rarr; Virtual Account Billing</strong></li>
                    <li>Masukan nomor <strong>VA : <?php echo $nomorVAOpenLuarBSI; ?> <button onclick="CopyMe('<?php echo $nomorVAOpenLuarBSI;?>')"><i class="fa-solid fa-clipboard"></i></button></strong></li>
                    <li>Masukkan jumlah uang sesuai tagihan yang akan dibayarkan</li>
                    <li>Transaksi selesai</li>
                </ol>
            </div>
        </div>

        <div class="list-group list-custom-small list-icon-0">
            <a data-bs-toggle="collapse" class="no-effect" href="#collapse-3">
                <span class="font-14">Dari Bank Selain Bank BSI</span>
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
        <div class="collapse" id="collapse-3">
            <div class="list-group list-custom-small ps-3">
                <ol>
                    <li>Buka aplikasi Mobile Banking pilihan anda</li>
                    <li>Masukan kata sandi anda</li>
                    <li>Pilih <strong>Menu Transfer/Bayar &rarr; Bank lain atau masukan kode Bank</strong></li>
                    <li>Pilih Bank <strong>BSI</strong></li>
                    <li>Masukan <strong>Nomor Rekening : <?php echo $nomorVAOpenLuarBSI; ?> <button onclick="CopyMe('<?php echo $nomorVAOpenLuarBSI;?>')"><i class="fa-solid fa-clipboard"></i></button></strong></li>
                    <li>Masukkan jumlah uang sesuai tagihan yang akan dibayarkan</li>
                    <li>Ikuti petunjuk selanjutnya untuk menyelesaikan proses pembayaran</li>
                </ol>
            </div>
        </div>

        <div class="list-group list-custom-small list-icon-0">
            <a data-bs-toggle="collapse" class="no-effect" href="#collapse-4">
                <span class="font-14">Melalui ATM Bank Selain Bank BSI</span>
                <i class="fa fa-angle-down"></i>
            </a>
        </div>
        <div class="collapse" id="collapse-4">
            <div class="list-group list-custom-small ps-3">
                <ol>
                    <li>Masukan kartu ATM dan pin anda</li>
                    <li>Pilih <strong>Menu Transfer/Bayar &rarr; Bank lain atau masukan kode Bank</strong></li>
                    <li>Pilih Bank <strong>BSI</strong></li>
                    <li>Masukan <strong>Nomor Rekening : <?php echo $nomorVAOpenLuarBSI; ?> <button onclick="CopyMe('<?php echo $nomorVAOpenLuarBSI;?>')"><i class="fa-solid fa-clipboard"></i></button></strong></li>
                    <li>Masukkan jumlah uang sesuai tagihan yang akan dibayarkan</li>
                    <li>Transaksi selesai</li>
                </ol>
            </div>
        </div>


    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
    function CopyMe(TextToCopy) {
        var TempText = document.createElement("input");
        TempText.value = TextToCopy;
        document.body.appendChild(TempText);
        TempText.select();

        document.execCommand("copy");
        document.body.removeChild(TempText);
        Swal.fire({ //displays a pop up with sweetalert
            icon: 'success',
            title: 'Text copied to clipboard',
            showConfirmButton: false,
            timer: 1000
        });
    }
</script>