<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar', ['always_show' => true]); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/store_menu', ['orders' => true]); ?>

        <?php //$this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="timeline-cover timeline-cover-center mt-5">
            <div data-card-height="250" class="card shadow-l preload-img" data-src="images/pictures/18.jpg">
                <div class="card-center text-center">
                    <h1 class="color-white font-24 mb-n2">ID Pesanan #<?php echo $id_pesanan ?></h1>
                    <p class="color-white opacity-90 font-11 mb-0">
                        Informasi pesanan Anda.
                    </p>
                    <!-- <a href="tel:+1 234 567 890" class="btn btn-s rounded-sm bg-highlight font-800 text-uppercase mt-3">Call Shipping Support</a> -->
                </div>
                <div class="card-overlay bg-black opacity-80"></div>
            </div> 
        </div>

        <div class="page-content">
            
            <div class="timeline-body">
                <div class="timeline-deco"></div>

                <div class="timeline-item mt-4">
                    <i class="fa <?php echo $tracking[0]->icon ?> <?php echo $orders[0]->status_pesanan == 0 ? 'bg-highlight' : 'bg-gray-dark' ?> color-white shadow-l timeline-icon"></i>
                    <div class="<?php echo $orders[0]->status_pesanan != 0 ? 'bg-gray-light' : '' ?> timeline-item-content rounded-s">
                        <h5 class="font-400 pt-1 pb-1">
                            <?php echo $tracking[0]->keterangan ?><br>
                            <span class="color-gray-dark"><?php echo $orders[0]->order_date ?></span>
                        </h5>
                    </div>
                </div>
                <?php if ($orders[0]->status_pesanan != 0) { ?>
                    <?php
                        unset($tracking[0]); 
                        $i = 1; ?>
                    <?php foreach ($tracking as $t) { ?>
                        <div class="timeline-item mt-4">
                            <i class="fa <?php echo $t->icon ?> <?php echo $orders[0]->status_pesanan == $i ? 'bg-highlight' : 'bg-gray-dark' ?> color-white shadow-l timeline-icon"></i>

                            <div class="<?php echo $orders[0]->status_pesanan != $i ? 'bg-gray-light' : '' ?> timeline-item-content rounded-s">
                                <h5 class="font-400 pt-1 pb-1">
                                    <?php echo $t->keterangan ?><br>
                                    <span class="color-gray-dark"><?php echo $t->updated_time ?></span>
                                </h5>
                            </div>
                        </div>
                        <?php if ($orders[0]->status_pesanan == $i) {
                            break;
                        }?>
                        <?php $i++; ?>
                    <?php } ?>
                <?php } ?>
				

            </div>			
        </div>

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('konsultan/include/alert-bottom'); ?>
    <?php $this->load->view('jamaahv2/include/script_view'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>