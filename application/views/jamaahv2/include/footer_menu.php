<?php
if (!isset($perlengkapan_nav) && !isset($pembayaran_nav) && !isset($home_nav) && !isset($dokumen_nav) && !isset($jamaah_nav)) {
    $home_nav = true;
}
?>
<div id="footer-bar" class="footer-bar-6" style="font-size:5px;">
    <a href="<?php echo base_url(); ?>jamaah/perlengkapan"
        class="<?php echo isset($perlengkapan_nav) ? 'active-nav' : ''; ?>"><i class="fa-solid fa-suitcase"></i>
        <span>Perlengkapan</span></a>
    <a href="<?php echo base_url(); ?>jamaah/pembayaran"
        class="<?php echo isset($pembayaran_nav) ? 'active-nav' : ''; ?>"><i
            class="fa-solid fa-credit-card"></i><span>Bayar</span></a>
    <a href="<?php echo base_url(); ?>jamaah/home"
        class="circle-nav <?php echo isset($home_nav) ? 'active-nav' : ''; ?>"><i
            class="fa-solid fa-home"></i><span>Home</span></a>
    <a href="<?php echo base_url(); ?>jamaah/dokumen"
        class="<?php echo isset($dokumen_nav) ? 'active-nav' : ''; ?>"><i
            class="fa-solid fa-file"></i><span>Dokumen</span></a>
    <a href="<?php echo base_url(); ?>jamaah/jamaah"
        class="<?php echo isset($jamaah_nav) ? 'active-nav' : ''; ?>"><i
            class="fa-solid fa-user"></i><span>Jamaah</span></a>
</div>