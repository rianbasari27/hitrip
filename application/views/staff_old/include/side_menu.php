<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>staff">

    <div class="sidebar-brand-icon">
        <img class="img-profile" width="100%" src="<?php echo base_url(); ?>asset/login/images/LOGO-VENTOUR.png">
    </div>
    <!--<div class="sidebar-brand-text mx-3">Ventour Management App</div>-->
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item <?php echo isset($dashboard)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<?php if (($_SESSION['bagian'] == 'Master Admin') || $_SESSION['bagian'] == "Legal" || $_SESSION['email'] == "wildan@ventour.co.id" || $_SESSION['email'] == "sutan@ventour.co.id") { ?>
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Ventour
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?php echo isset($reminder)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reminder" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-bell"></i>
        <span>Reminder</span>
    </a>
    <div id="reminder" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/reminder">Input Reminder</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/reminder/jadwal_reminder">Jadwal Reminder</a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
<?php } ?>

<?php if (($_SESSION['bagian'] == 'Master Admin') || $_SESSION['bagian'] == "Handling") { ?>

<!-- Heading -->
<div class="sidebar-heading">
    Handling
</div>

<li class="nav-item <?php echo isset($jadwal_handling)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/handling">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Jadwal</span></a>
</li>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item <?php echo isset($jadwal_handling)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#jadwal_handling" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-bell"></i>
        <span>List Data</span>
    </a>
    <div id="jadwal_handling" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/reminder">Tour Leader</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/reminder/jadwal_reminder">Muthowif</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/reminder/jadwal_reminder">Handling</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/reminder/jadwal_reminder">Lounge</a>
        </div>
    </div>
</li>
<hr class="sidebar-divider">
<?php } ?>

<?php if (($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance')) { ?>
<!-- Divider
<hr class="sidebar-divider"> -->

<!-- Heading -->
<div class="sidebar-heading">
    Admin
</div>

<!-- Nav Item - Pages Collapse Menu -->
<?php if (($_SESSION['bagian'] == 'Master Admin')) { ?>
<li class="nav-item <?php echo isset($staff_member)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#staff" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-user"></i>
        <span>Staff Member</span>
    </a>
    <div id="staff" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/member">Lihat Daftar Staff</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/member/tambah">Tambah Staff Baru</a>
        </div>
    </div>
</li>
<?php } ?>

<li class="nav-item <?php echo isset($paket_umroh)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#paket" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-suitcase-rolling"></i>
        <span>Paket Umroh</span>
    </a>
    <div id="paket" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/paket">Lihat Paket Umroh</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/paket/tambah">Tambah Paket Baru</a>
        </div>
    </div>
</li>

<li class="nav-item <?php echo isset($voucher)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#voucher" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-ticket"></i>
        <span>Voucher</span>
    </a>
    <div id="voucher" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/voucher">Lihat Voucher Paket</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/voucher/tambah">Tambah Voucher
                Paket</a>
        </div>
    </div>
</li>

<li class="nav-item <?php echo isset($diskon_event)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/diskon_event">
        <i class="fa-solid fa-fw fa-tag"></i>
        <span>Discount Event</span>
    </a>
</li>
<li class="nav-item <?php echo isset($promo_bayar)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/upload_promo">
        <i class="fa-solid fa-fw fa-arrow-up-from-bracket"></i>
        <span>Upload Promo Banner</span>
    </a>
</li>
<hr class="sidebar-divider">
<?php } ?>

<?php if (($_SESSION['bagian'] == 'Manifest' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Finance' || (preg_match("/bandung/i", $_SESSION['email'])))) { ?>
<!-- Heading -->
<div class="sidebar-heading">
    Manifest
</div>

<li class="nav-item <?php echo isset($data_jamaah)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#jamaah" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-id-card"></i>
        <span>Data Jamaah</span>
    </a>
    <div id="jamaah" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/jamaah/registrasi">Registrasi Jamaah</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/jamaah">Data Jamaah</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/peserta">Peserta Umroh</a>
        </div>
    </div>
</li>

<li class="nav-item <?php echo isset($dokumen_admin)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#administrasi" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-file-alt"></i>
        <span>Dokumen Administrasi</span>
    </a>
    <div id="administrasi" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/manifest">Dokumen Manifest</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/manifest/siskopatuh">Dokumen Siskopatuh</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/manifest/asuransi">Dokumen Asuransi</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/room_list">Room List</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($request_dokumen)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#request" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fa-solid fa-fw fa-file-signature"></i>
        <span>Request Dokumen</span>
    </a>
    <div id="request" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/input_dokumen">Input Request</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/request_dokumen">Kelola Request</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/paket">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span>Broadcast</span>
    </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider">
<?php } ?>
<?php if (($_SESSION['bagian'] == 'Finance' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['email'] == 'mala@ventour.co.id')) { ?>
<!-- Heading -->
<div class="sidebar-heading">
    Finance
</div>
<?php if (($_SESSION['bagian'] == 'Finance' || $_SESSION['bagian'] == 'Master Admin')) { ?>
<li class="nav-item <?php echo isset($input_pembayaran)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/finance/bayar">
        <i class="fas fa-fw fa-cash-register"></i>
        <span>Input Pembayaran</span>
    </a>
</li>
<li class="nav-item <?php echo isset($verifikasi)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/finance/verifikasi?id_paket=all">
        <i class="fas fa-fw fa-receipt"></i>
        <span>Verifikasi Pembayaran</span>
    </a>
</li>
<li class="nav-item <?php echo isset($refund_pembayaran)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Refund" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-hand-holding-dollar"></i>
        <span>Refund Pembayaran</span>
    </a>
    <div id="Refund" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/finance/refund">Refund
                Pembayaran</a>
            <a class="collapse-item"
                href="<?php echo base_url(); ?>staff/finance/verifikasi_refund?id_paket=all">Verifikasi
                Refund</a>
        </div>
    </div>
</li>
<?php } ?>
<li class="nav-item <?php echo isset($summary)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#summary" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fa-solid fa-fw fa-file-signature"></i>
        <span>Summary Pembayaran</span>
    </a>
    <div id="summary" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/finance/summary">Summary
                Pembayaran<br>Group</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/finance/summary_jamaah">Summary
                Pembayaran<br>Jamaah</a>
        </div>
    </div>
</li>
<!-- <li class="nav-item <?php echo isset($summary)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/finance/summary">
        <i class="fas fa-fw fa-file-signature"></i>
        <span>Summary Pembayaran Group</span>
    </a>
</li>
<li class="nav-item <?php echo isset($summary_jamaah)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/finance/summary_jamaah">
        <i class="fa-solid fa-clipboard-user"></i>
        <span>Summary Pembayaran Jamaah</span>
    </a>
</li> -->
<hr class="sidebar-divider">
<?php } ?>

<?php if (($_SESSION['bagian'] == 'PR' || $_SESSION['bagian'] == 'Master Admin')) { ?>
<div class="sidebar-heading">
    Public Relation
</div>
<li class="nav-item <?php echo isset($data_konsultan)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#agen" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-user-tag"></i>
        <span>Data Konsultan</span>
    </a>
    <div id="agen" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/kelola_agen/tambah">Tambah Konsultan</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/kelola_agen">Lihat Konsultan</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/kelola_agen/jamaah_agen">Lihat
                Jamaah Konsultan</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($data_poin)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#poin" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fa-solid fa-coins"></i>
        <span>Data Poin</span>
    </a>
    <div id="poin" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/poin_musim">Poin Permusim</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/poin_bulan">Poin Perbulan</a>
            <a class="collapse-item" href="#">Lihat Reward</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($agen_paket)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#agen_paket" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fa-solid fa-calendar-day"></i>
        <span>Program Konsultan</span>
    </a>
    <div id="agen_paket" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/agen_paket">Lihat Program</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/agen_paket/tambah">Tambah Program</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($agen_event)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#agen_event" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fa-solid fa-calendar-day"></i>
        <span>Event Konsultan</span>
    </a>
    <div id="agen_event" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/agen_paket/tambah_event">Tambah Event</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/agen_paket/list_event">List Event</a>
            <!-- <a class="collapse-item" href="<?php echo base_url(); ?>staff/agen_paket/list_konsultan_event">List Konsultan</a> -->
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($pendaftaran_konsultan)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/daftar_agen">
        <i class="fas fa-fw fa-address-card"></i>
        <span>Pendaftaran Konsultan</span>
    </a>
</li>
<li class="nav-item <?php echo isset($pembayaran_konsultan)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pembayaran_konsultan"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa-solid fa-cash-register"></i>
        <span>Pembayaran Konsultan</span>
    </a>
    <div id="pembayaran_konsultan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/pembayaran_konsultan">Input Pembayaran</a>
            <a class="collapse-item"
                href="<?php echo base_url(); ?>staff/pembayaran_konsultan/verifikasi?id=all">Verifikasi
                Pembayaran</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($broadcast_agen)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/broadcast_agen">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span>Broadcast</span>
    </a>
</li>
<li class="nav-item <?php echo isset($komisi_config)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/komisi_config">
        <i class="fas fa-fw fa-trophy"></i>
        <span>Pengaturan Reward</span>
    </a>
</li>
<hr class="sidebar-divider">
<?php } ?>


<?php if (($_SESSION['bagian'] == 'Logistik' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['nama'] == 'Kania CS' || $_SESSION['nama'] == 'Shafira CS' || $_SESSION['email'] == 'ulfi.bandung@ventour.co.id')) { ?>
<!-- Heading -->
<div class="sidebar-heading">
    Logistik
</div>
<li class="nav-item <?php echo isset($list_jamaah)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#listJamaah" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-list"></i>
        <span>List Barang</span>
    </a>
    <div id="listJamaah" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/barang">Stok Barang</a>
            <!-- <a class="collapse-item" href="<?php echo base_url(); ?>staff/barang/lihat_detail">Detail Barang</a> -->
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/barang/mutasi">Mutasi Barang</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($status_jamaah)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#statusJamaah" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-pen-to-square"></i>
        <span>Status Perlengkapan</span>
    </a>
    <div id="statusJamaah" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item"
                href="<?php echo base_url(); ?>staff/perlengkapan_peserta/summary_perlengkapan">Summary Perlengkapan</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/perlengkapan_peserta/log">Detail
                Pengambilan</a>
            <!-- <a class="collapse-item" href="#">Detail Perlengkapan Grup</a> -->
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($perl_jamaah)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#perlJamaah" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Perlengkapan Jamaah</span>
    </a>
    <div id="perlJamaah" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/perlengkapan_paket">Perlengkapan Paket</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/perlengkapan_pending">Pending Booking</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/perlengkapan_pending/status_siap">Siap
                Diambil</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/perlengkapan_peserta">Ambil Perlengkapan</a>
        </div>
    </div>
</li>
<hr class="sidebar-divider d-none d-md-block">

<div class="sidebar-heading">
    Logistik Office
</div>
<li class="nav-item <?php echo isset($perl_office)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#perlOffice" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-suitcase"></i>
        <span>Barang Office</span>
    </a>
    <div id="perlOffice" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/perlengkapan_office">List
                Barang Office</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/perlengkapan_office/list_request">Permintaan /
                Request</a>
            <a class="collapse-item"
                href="<?php echo base_url(); ?>staff/perlengkapan_office/list_pinjam">Peminjaman</a>
            <a class="collapse-item"
                href="<?php echo base_url(); ?>staff/perlengkapan_office/list_kembali">Pengembalian</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($mutasi_office)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/perlengkapan_office/mutasi">
        <i class="fas fa-fw fa-bullhorn"></i>
        <span>Mutasi</span>
    </a>
</li>
<hr class="sidebar-divider d-none d-md-block">
<?php } ?>

<?php if (($_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Store' || (preg_match("/logistik/i", $_SESSION['email'])))) { ?>
<div class="sidebar-heading">
    Ventour Store
</div>
<li class="nav-item <?php echo isset($kategori)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#kategori" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-layer-group"></i>
        <span>Category</span>
    </a>
    <div id="kategori" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/online_store/list_category">List Category</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/online_store/kategori">Add Category</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($store)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#venStore" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-shopping-cart"></i>
        <span>Product</span>
    </a>
    <div id="venStore" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/online_store">List Product</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/online_store/tambah">Add Product</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($store_bayar)? "active" : '' ;?>">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#storeBayar" aria-expanded="true"
        aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cash-register"></i>
        <span>Orders</span>
    </a>
    <div id="storeBayar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/bayar_store">List Order</a>
            <a class="collapse-item" href="<?php echo base_url(); ?>staff/bayar_store/verifikasi">Verifikasi
                Pembayaran</a>
        </div>
    </div>
</li>
<li class="nav-item <?php echo isset($input_foto)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/online_store/upload_banner">
        <i class="fas fa-fw fa-images"></i>
        <span>Upload Banner Store</span>
    </a>
</li>
<hr class="sidebar-divider d-none d-md-block">

<?php } ?>
<?php if (($_SESSION['bagian'] == 'Master Admin')) { ?>
<div class="sidebar-heading">
    Galeri
</div>
<li class="nav-item <?php echo isset($input_foto)? "active" : '' ;?>">
    <a class="nav-link" href="<?php echo base_url(); ?>staff/galeri">
        <i class="fas fa-fw fa-images"></i>
        <span>Input Foto</span>
    </a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">
<?php } ?>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->