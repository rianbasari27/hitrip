<?php if (!isset($home) && !isset($order) && !isset($trip) && !isset($discover) && !isset($profile)) {
    $home = true;
} ?>

<div id="footer-bar" class="footer-bar-1" style="font-size: 7px;">
    <a href="<?php echo base_url() . 'jamaah/trip' ?>" class="<?php echo isset($trip) ? 'active-nav' :'' ;?>"><i
            class="fa-solid fa-umbrella-beach"></i><span>Trip</span></a>
    <a href="<?php echo base_url() . 'jamaah/discover' ?>" class="<?php echo isset($discover) ? 'active-nav' :'' ;?>"><i
            class="fa-solid fa-compass"></i><span>Discover</span></a>
    <a href="<?php echo base_url() . 'jamaah/home' ?>" class="<?php echo isset($home) ? 'active-nav' :'' ;?>"><i
            class="fa-solid fa-home"></i><span>Home</span></a>
    <a href="<?php echo base_url() . 'jamaah/order' ?>" class="<?php echo isset($order) ? 'active-nav' :'' ;?>"><i
            class="fa-solid fa-clipboard-list"></i><span>Order</span>
        <!--<em class="badge bg-highlight">3</em></a>-->
        <a href="<?php echo !isset($_SESSION['no_ktp']) ? base_url() . 'jamaah/login' : base_url() . 'jamaah/profile' ?>"
            class="<?php echo isset($profile) ? 'active-nav' :'' ;?>"><i
                class="fa-solid <?php echo !isset($_SESSION['no_ktp']) ? 'fa-right-to-bracket' : 'fa-circle-user' ?>"></i><span>
                <?php echo !isset($_SESSION['no_ktp']) ? 'Login' : 'Profile' ?></span></a>
</div>