<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/jamaah.jpg");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['jamaah_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Daftar Kerabat</p>
                    <h1>Jamaah</h1>

                    <p class="mb-0">
                        Kerabat yang Sudah Anda Daftarkan Bersama Anda.
                    </p>
                </div>
            </div>
            <?php if (!empty($_SESSION['alert_type'])) { ?>
            <div class='row'>
                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                    <?php echo $_SESSION['alert_message']; ?>
                </div>
            </div>
            <?php } ?>
            <div class="card card-style">
                <div class="content mt-0 mb-3">
                    <div class="list-group list-custom-large">
                        <?php if (!empty($child)) { ?>
                        <?php
                            $no = 0 ;
                            foreach ($child as $c) { 
                                $no = $no+1;
                                if ($no > 4 ) {
                                    $no = 1 ;
                                }
                                ?>
                        <a href="#" style="pointer-events: none;">
                            <?php if($no == 1) { ?>
                            <i class="fa fa-user fa-2xl" style="color:orange"></i>
                            <?php }else if ( $no == 2) { ?>
                            <i class="fa fa-user fa-2xl" style="color:red"></i>
                            <?php }else if ( $no == 3) { ?>
                            <i class="fa fa-user fa-2xl" style="color:blue"></i>
                            <?php }else if ( $no == 4) { ?>
                            <i class="fa fa-user fa-2xl" style="color:green"></i>
                            <?php } ?>
                            <p style="font-weight: bolder;">
                                <?php echo $c->jamaahData->first_name . ' ' . $c->jamaahData->second_name . ' ' . $c->jamaahData->last_name; ?>
                            </p>
                        </a>
                        <?php } ?>
                        <?php }
                        if (empty($child)) { ?>
                        <a href="#" style="pointer-events: none;">
                            <i class="fa-solid fa-address-card fa-2xl color-highlight"></i>
                            <span class="mt-1"><?php echo $first_name . ' ' . $second_name . ' ' . $last_name; ?></span>
                        </a>
                        <?php } ?>
                    </div>
                    <!-- <a
                        href="<?php echo base_url(); ?>jamaah/daftar/start?parent=<?php echo isset($member[0]->parent_id) ? $member[0]->parent_id : $_SESSION['id_member'];?>">
                        <button class="btn btn-sm gradient-highlight mt-4 rounded-s"><i
                                class="fa fa-user-plus fa-xl color-white"></i> Daftarkan Kerabat anda yang lain</button>
                    </a> -->
                </div>
            </div>



            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>