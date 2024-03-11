<!-- <div class="static" data-bs-backdrop="static"> -->
<div class="card rounded-0 bg-menu" data-card-height="150"
    style="background-image: url(<?php echo base_url(); ?>asset/appkit/images/side_banner.jpg);">
    <div class="card-top">
        <a href="#" class="close-menu float-end me-2 text-center mt-3 icon-40 notch-clear">
            <i class="fa fa-times color-white"></i>
        </a>
    </div>
    <div class="card-bottom">
        <h1 class="color-white ps-3 mb-n1 font-28">Ventour Mobile</h1>
        <?php if (isset($_SESSION['id_agen'])) {
            $namaJamaah = $_SESSION['nama_agen'];
        } else {
            $namaJamaah = "Konsultan";
        } ?>
        <p class="mb-2 ps-3 font-14 color-white opacity-50">Welcome <span
                class="color-highlight font-700"><?php echo $namaJamaah; ?></span></p>
    </div>
    <div class="card-overlay bg-gradient"></div>
</div>
<!-- <?php if (!isset($_SESSION['id_agen'])) { ?>
<div class="list-group list-custom-small list-menu">
    <span>Sudah punya akun?</span>
    <a href="<?php echo base_url() . 'jamaah/masuk'; ?>" class="btn btn-sm rounded-s gradient-green me-4 color-white"
        id="nav-welcome" style="color :#FFF !important">
        Masuk
    </a>
</div>
<?php } ?> -->

<?php if (!empty($mou_doc)) { ?>
<div class="list-group list-custom-small list-menu">
    <a href="<?php echo base_url() . 'konsultan/profile/dl_mou'; ?>"
        class="btn btn-sm rounded-s gradient-green me-4 mt-2 mb-3 color-white" style="color: #FFF !important">
        Download MOU
    </a>
</div>
<?php } ?>

<div class="mt-4"></div>
<h6 class="menu-divider">Tentang Kami</h6>
<div class="list-group list-custom-small list-menu">
    <a href="<?php echo base_url(); ?>konsultan/tentang_kami/profile" id="nav-profile">
        <i class="fa fa-user gradient-yellow color-white"></i>
        <span>Profil</span>
        <i class="fa fa-angle-right"></i>
    </a>
    <a href="<?php echo base_url(); ?>konsultan/tentang_kami/layanan" id="nav-layanan">
        <i class="fa fa-square-plus gradient-red color-white"></i>
        <span>Layanan</span>
        <i class="fa fa-angle-right"></i>
    </a>
    <a href="<?php echo base_url(); ?>konsultan/tentang_kami" id="nav-galeri">
        <i class="fa-solid fa-images gradient-blue color-white"></i>
        <span>Galeri</span>
        <i class="fa fa-angle-right"></i>
    </a>
    <a href="<?php echo base_url(); ?>konsultan/tentang_kami/kontak" id="nav-kontak">
        <i class="fa-solid fa-address-book gradient-pink color-white"></i>
        <span>Kontak</span>
        <i class="fa fa-angle-right"></i>
    </a>
</div>

<?php if (isset($_SESSION['id_agen'])) { ?>
<h6 class="menu-divider mt-4">Program Anda</h6>
<div class="list-group list-custom-small list-menu">
    <a href="<?php echo base_url() . 'konsultan/ambil_perlengkapan/ambil_kolektif'; ?>" id="nav-perl">
        <i class="fa fa-cart-flatbed-suitcase gradient-orange color-white"></i>
        <span>Ambil Perlengkapan</span>
        <i class="fa fa-angle-right"></i>
    </a>
    <!-- <a href="<?php echo base_url(); ?>jamaah/req_dokumen" id="nav-request">
        <i class="fa fa-file gradient-pink color-white"></i>
        <span>Request Dokumen</span>
        <i class="fa fa-angle-right"></i>
    </a> -->
</div>
<?php } ?>

<h6 class="menu-divider mt-4">Pengaturan</h6>
<div class="list-group list-custom-small list-menu">
    <a href="#" data-menu="menu-colors">
        <i class="fa-solid fa-fill gradient-brown color-white"></i>
        <span>Customization</span>
        <i class="fa fa-angle-right"></i>
    </a>
    <a href="#" data-toggle-theme><i class="fa fa-moon gradient-gray color-white"></i><span>Dark Mode</span>
        <div class="custom-control small-switch ios-switch">
            <input data-toggle-theme type="checkbox" class="ios-input" id="toggle-dark-menu">
            <label class="custom-control-label" for="toggle-dark-menu"></label>
        </div>
    </a>
</div>
<?php if (isset($_SESSION['id_agen'])) { ?>
<div class="list-group list-custom-small list-menu">
    <a href="<?php echo base_url() . 'konsultan/logout'; ?>"
        class="btn btn-sm rounded-s gradient-red me-4 mt-2 mb-3 color-white" id="nav-welcome"
        style="color: #FFF !important">
        Keluar
    </a>
</div>
<?php } ?>
<!-- </div> -->