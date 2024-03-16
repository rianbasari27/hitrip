<?php if (!isset($home) && !isset($order) && !isset($trip) && !isset($favorite) && !isset($profile)) {
    $home = true;
} ?>

<div id="footer-bar" class="footer-bar-1" style="font-size: 7px;">
    <a href="<?php echo base_url() . 'jamaah/trip' ?>" class="<?php echo isset($trip) ? 'active-nav' :'' ;?>"><i class="fa fa-suitcase-rolling"></i><span>Trip</span></a>
    <a href="<?php echo base_url() . 'jamaah/order' ?>" class="<?php echo isset($order) ? 'active-nav' :'' ;?>"><i class="fa fa-clipboard-list"></i><span>Order</span><!--<em class="badge bg-highlight">3</em></a>-->
    <a href="<?php echo base_url() . 'jamaah/home' ?>" class="<?php echo isset($home) ? 'active-nav' :'' ;?>"><i class="fa fa-home"></i><span>Home</span></a>
    <a href="<?php echo base_url() . 'jamaah/favorite' ?>" class="<?php echo isset($favorite) ? 'active-nav' :'' ;?>"><i class="fa fa-heart"></i><span>Favorite</span></a>
    <a href="<?php echo !isset($_SESSION['username']) ? base_url() . 'jamaah/login' : base_url() . 'jamaah/profile' ?>" class="<?php echo isset($profile) ? 'active-nav' :'' ;?>"><i class="fa <?php echo !isset($_SESSION['username']) ? 'fa-right-to-bracket' : 'fa-user' ?>"></i><span> <?php echo !isset($_SESSION['username']) ? 'Login' : 'Profile' ?></span></a>
</div>