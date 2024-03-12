<?php if (!isset($home) && !isset($pesanan) && !isset($feature) && !isset($favorite) && !isset($profile)) {
    $home = true;
} ?>
<div id="footer-bar" class="footer-bar-3" style="font-size:5px;">
    <a href="#" class="<?php echo isset($feature) ? 'active-nav' :'' ;?>"><i class="fa fa-star"></i><span>Features</span></a>
    <a href="#" class="<?php echo isset($pesanan) ? 'active-nav' :'' ;?>"><i class="fa fa-heart"></i><span>Pesanan</span></a>
    <a href="#" class="<?php echo isset($home) ? 'active-nav' :'' ;?>"><i class="fa fa-home"></i><span>Home</span><strong></strong></a>
    <a href="#" class="<?php echo isset($favorite) ? 'active-nav' :'' ;?>"><i class="fa fa-heart"></i><span>Favorite</span></a>
    <a href="#" class="<?php echo isset($profile) ? 'active-nav' :'' ;?>"><i class="fa fa-cog"></i><span>Profile</span><em class="badge bg-highlight">3</em></a>
</div>