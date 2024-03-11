<div class="page-title page-title-fixed">
    <!-- <h1>AppKit</h1> -->
    <div style="width: 70%;">
        <a href="<?php echo base_url() ?>konsultan/home" class="header-title ms-3 show-on-theme-light"><img
                src="<?php echo base_url() . 'asset/appkit/images/ventour/LOGO-VENTOUR-Hitam.png'; ?>" alt=""
                style="max-width: 170px;"></a>
        <a href="<?php echo base_url() ?>konsultan/home" class="header-title ms-3 show-on-theme-dark"><img
                src="<?php echo base_url() . 'asset/appkit/images/ventour/LOGO-VENTOUR-Putih.png'; ?>" alt=""
                style="max-width: 170px;"></a>
    </div>
    <!-- <a href="#" class="page-title-icon shadow-xl bg-theme color-theme" data-menu="menu-share"><i class="fa fa-share-alt"></i></a> -->
    <!-- <a href="#" class="page-title-icon shadow-xl bg-theme color-theme" data-toggle-theme><i class="fa fa-moon"></i></a> -->
    <!-- Icon "fa-bell" dengan badge -->
    <?php if (isset($menuBC)) { ?>
    <a href="<?php echo base_url() . 'konsultan/broadcast_list'?>" class="page-title-icon shadow-xl bg-theme color-theme">
        <i class="fa fa-bell"></i>
        <?php if ($countBc != 0 ) { ?>
        <span class="badge"><?php echo $countBc ;?></span> <!-- Badge dengan angka notifikasi -->
        <?php } ?>
    </a>
    <?php } ?>
    <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-light" data-toggle-theme>
        <i class="fa fa-moon"></i>
    </a>
    <a href="#" class="page-title-icon shadow-xl bg-theme color-theme show-on-theme-dark" data-toggle-theme>
        <i class="fa fa-sun color-yellow-dark"></i>
    </a>
    <a href="#" class="page-title-icon shadow-xl bg-theme color-theme" data-menu="menu-main" data-bs-toggle="card"
        data-bs-target="fixed">
        <i class="fa fa-bars"></i>
    </a>
</div>