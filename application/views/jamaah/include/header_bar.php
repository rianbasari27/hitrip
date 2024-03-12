<div class="header header-fixed header-logo-center <?php echo isset($always_show) ? '' : 'header-auto-show';?>">
    <a href="<?php echo base_url().'jamaah/home'?>" class="header-title show-on-theme-light"><img
            src="<?php echo base_url() . 'asset/appkit/images/hitrip/hitrip-logo.png'; ?>" alt=""
            style="max-width: 60%;"></a>
    <a href="<?php echo base_url().'jamaah/home'?>" class="header-title show-on-theme-dark"><img
            src="<?php echo base_url() . 'asset/appkit/images/hitrip/hitrip-white.png'; ?>" alt=""
            style="max-width: 60%;"></a>
    <?php if (!isset($noBackButton)) { ?>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-chevron-left"></i></a>
    <?php } ?>
    <a href="#" data-menu="menu-main" class="header-icon header-icon-4" data-bs-toggle="card" data-bs-target="fixed"><i class="fas fa-bars"></i></a>
    <!-- <a href="#" data-menu="menu-share" class="header-icon header-icon-4" data-bs-toggle="card" data-bs-target="fixed"><i class="fas fa-share-alt"></i></a> -->
    <!-- <a href="#" data-menu="menu-share" class="header-icon header-icon-3"><i class="fas fa-share-alt"></i></a> -->
    <!-- <button id="openBtn" class="btn btn-primary">Buka Sidebar</button> -->
    <a href="#" data-toggle-theme class="header-icon header-icon-3 show-on-theme-dark"><i class="fas fa-sun color-yellow-dark"></i></a>
    <a href="#" data-toggle-theme class="header-icon header-icon-3 show-on-theme-light"><i class="fas fa-moon"></i></a>
    
</div>