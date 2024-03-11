<?php
if (!isset($jamaah_nav) && !isset($daftar_nav) && !isset($home_nav) && !isset($updown_nav) && !isset($profile_nav)) {
    $home_nav = true;
}
?>
<div id="footer-bar" class="footer-bar-6" style="font-size:5px;">
    <a href="<?php echo base_url(); ?>konsultan/jamaah_list" class="<?php echo isset($jamaah_nav) ? 'active-nav' : ''; ?>"><i class="fa-solid fa-users"></i><span>Jamaah</span></a>
    <a href="<?php echo base_url(); ?>konsultan/daftar_jamaah" class="<?php echo isset($daftar_nav) ? 'active-nav' : ''; ?>"><i class="fa-solid fa-file-pen"></i>
        <span>Daftarkan</span></a>
    <a href="<?php echo base_url(); ?>konsultan/home" class="circle-nav <?php echo isset($home_nav) ? 'active-nav' : ''; ?>"><i class="fa-solid fa-home"></i><span>Home</span></a>
    <a href="<?php echo base_url(); ?>konsultan/updown_line" class="<?php echo isset($updown_nav) ? 'active-nav' : ''; ?>"><i class="fa-solid fa-sitemap"></i><span>Up/Downline</span></a>
    <a href="<?php echo base_url(); ?>konsultan/profile" class="<?php echo isset($profile_nav) ? 'active-nav' : ''; ?>"><i class="fa-solid fa-user"></i><span>Profile</span></a>
</div>