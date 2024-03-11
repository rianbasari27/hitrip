<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/surat_cuti_ban.jpg");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu'); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Daftar Jamaah</p>
                    <h1>Buatkan Surat Cuti</h1>
                    <p class="mb-0">
                        <?php if (!empty($child)) {
                            echo 'Buat Surat Cuti untuk Jamaah Anda dan Kerabat Jamaah Anda' ;
                        } else {
                            echo 'Buat Surat Cuti untuk Jamaah Anda' ;
                        } ?>
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <div class="list-group list-custom-large">
                        <?php if (!empty($child)) { ?>
                        <?php 
                            $no = 0 ;
                            foreach ($child as $c) { 
                                $no = $no + 1;
                                if ($no > 4) {
                                    $no = 1 ;
                                }
                                ?>
                        <a
                            href="<?php echo base_url(); ?>konsultan/req_cuti_konsultan/list_surat_cuti?idm=<?php echo $c->jamaahData->member[0]->idSecretMember; ?>">
                            <?php if ($no == 1) { ?>
                            <i class="fa-regular fa-file-pdf fa-2xl" style="color:orange;"></i>
                            <?php } if ($no == 2) { ?>
                            <i class="fa-regular fa-file-pdf fa-2xl" style="color:red;"></i>
                            <?php } if ($no == 3) { ?>
                            <i class="fa-regular fa-file-pdf fa-2xl" style="color:blue;"></i>
                            <?php } if ($no == 4) { ?>
                            <i class="fa-regular fa-file-pdf fa-2xl" style="color:green;"></i>
                            <?php } ?>
                            <span><?php echo $c->jamaahData->first_name . ' ' . $c->jamaahData->second_name . ' ' . $c->jamaahData->last_name; ?></span>
                            <strong>Buatkan surat cuti untuk
                                <?php echo $c->jamaahData->first_name . ' ' . $c->jamaahData->second_name . ' ' . $c->jamaahData->last_name; ?></strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                        <?php } ?>
                        <?php }
                        if (empty($child)) { ?>
                        <a href="<?php echo base_url(); ?>konsultan/req_cuti_konsultan/list_surat_cuti?idm=<?php echo $member[0]->idSecretMember; ?>">
                            <i class="fa-regular fa-file-pdf fa-2xl color-highlight"></i>
                            <span><?php echo $first_name . ' ' . $second_name . ' ' . $last_name; ?></span>
                            <strong>Buatkan surat cuti untuk
                                <?php echo $first_name . ' ' . $second_name . ' ' . $last_name; ?></strong>
                            <i class="fa fa-angle-right "></i>
                        </a>

                        <?php } ?>
                    </div>
                </div>
            </div>



            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>