<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
        .bg-6 {
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/bg_kuning.jpg");
        }
        .badge {
            background-color: red;
            color: white;
            padding: 4px 6px;
            border-radius: 50%;
            margin-left: 400px;
        }
    </style>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/store_menu', ['orders' => true, 'countCart' => $countCart]); ?>

        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <!-- <form action="<?php echo base_url() . 'jamaah/online_store/proses_checkout' ?>" id="myForm" method="post"> -->
                <div class="content mt-0">
                    <p class="font-600 color-highlight mb-n1">Pesanan Anda</p>
                    <h2>Pesanan yang diproses</h2>
                </div>
                <?php if ($ordersProcess != null) { ?>
                    <?php foreach ($ordersProcess as $key => $op) { ?>
                        <div class="card card-style">
                            <div class="content">
                                <?php foreach ($op->product as $p) { ?>
                                    <div class="d-flex mb-3">
                                        <div class="me-3">
                                            <img src="<?php echo base_url() . $p->items[0]->images[0]->location ?>" width="80" class="rounded-s shadow-xl">
                                        </div>
                                        <div style="width: 100%;">
                                            <h4><?php echo $p->items[0]->product_name ?></h4>
                                            <span>Qty : <?php echo $p->quantity ?></span><br>
                                            <span class="d-block float-end color-dark-dark"><?php echo $p->amountFormat ?></span>
                                        </div>
                                    </div>
                                    <div class="divider mb-2"></div>
                                <?php } ?>

                                <?php if ($op->lunas == 0) { ?>
                                    <a href="<?php echo base_url() . 'jamaah/online_store/payment_method?id=' . $op->order_id ?>" class="color-yellow-dark my-3 d-block d-flex">
                                <?php } else { ?>
                                    <a href="<?php echo base_url() . 'jamaah/online_store/orders_tracking?ido=' . $op->order_id ?>" class="color-yellow-dark my-3 d-block d-flex">
                                <?php } ?>
                                    <div style="width: 80%;">
                                    <?php if ($op->lunas == 0) { ?>
                                        <div class="color-red-dark">
                                            <i class="fa-solid fa-credit-card me-2 my-auto"></i>
                                            Pesanan Anda belum dibayarkan
                                        </div>
                                    <?php } else { ?>
                                        <?php if ($op->status_pesanan == 0) { ?>
                                            <i class="fa-solid fa-hourglass-half me-2 my-auto"></i>
                                        <?php } else if ($op->status_pesanan == 1) { ?>
                                            <i class="fa-solid fa-boxes-packing me-2 my-auto"></i>
                                        <?php } else if ($op->status_pesanan == 2) { ?>
                                            <i class="fa-solid fa-truck-fast me-2 my-auto"></i>
                                        <?php } else { ?>
                                            <i class="fa-solid fa-circle-check me-2 my-auto"></i>
                                        <?php } ?>
                                        <?php echo $op->status ?>
                                    <?php } ?>
                                    </div>
                                    <div style="width: 20%;">
                                        <i class="fa-solid <?php echo $op->lunas == 0 ? 'color-red-dark' : '' ?> fa-angle-right float-end mt-2"></i>
                                    </div>
                                    
                                </a>
                                
                                <div class="divider mb-2"></div>

                                <div class="d-flex">
                                    <!-- <div> -->
                                        <h4>Total</h4>
                                        <div style="width: 100%;">
                                            <h3 class="float-end color-highlight"><?php echo $op->totalAmountFormat ?></h3>
                                        </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                        
                    <?php } ?>
                <?php } else { ?>
                    <div class="card card-style">
                        <div class="content">
                            <h4 class="text-center font-14 font-500">Tidak ada pesanan yang sedang diproses.</h4>
                        </div>
                    </div>
                <?php } ?>

                <div class="divider"></div>

                <div class="content mt-0">
                    <h2>Pesanan selesai</h2>
                </div>
                <?php if ($ordersComplete != null) { ?>
                    <?php foreach ($ordersComplete as $key => $oc) { ?>
                        <div class="card card-style">
                            <div class="content">
                                <?php foreach ($oc->product as $p) { ?>
                                    <div class="d-flex mb-3">
                                        <div class="me-3">
                                            <img src="<?php echo base_url() . $p->items[0]->images[0]->location ?>" width="80" class="rounded-s shadow-xl">
                                        </div>
                                        <div style="width: 100%;">
                                            <h4><?php echo $p->items[0]->product_name ?></h4>
                                            <span>Qty : <?php echo $p->quantity ?></span><br>
                                            <span class="d-block float-end color-dark-dark"><?php echo $p->amountFormat ?></span>
                                        </div>
                                    </div>
                                    <div class="divider mb-2"></div>
                                <?php } ?>

                                <a href="<?php echo base_url() . 'jamaah/online_store/orders_tracking?ido=' . $oc->order_id ?>" class="color-green-dark my-3 d-block d-flex">
                                    <div style="width: 80%;">
                                    <?php if ($oc->status_pesanan == 0) { ?>
                                        <i class="fa-solid fa-hourglass-half me-2 my-auto"></i>
                                    <?php } else if ($oc->status_pesanan == 1) { ?>
                                        <i class="fa-solid fa-boxes-packing me-2 my-auto"></i>
                                    <?php } else if ($oc->status_pesanan == 2) { ?>
                                        <i class="fa-solid fa-truck-fast me-2 my-auto"></i>
                                    <?php } else { ?>
                                        <i class="fa-solid fa-circle-check me-2 my-auto"></i>
                                    <?php } ?>
                                    <?php echo $oc->status ?>
                                    </div>
                                    
                                    <div style="width: 20%;">
                                        <i class="fa-solid fa-angle-right float-end mt-2"></i>
                                    </div>
                                </a>
                                
                                <div class="divider mb-2"></div>

                                <div class="d-flex">
                                    <!-- <div> -->
                                        <h4>Total</h4>
                                        <div style="width: 100%;">
                                            <h3 class="float-end color-highlight"><?php echo $oc->totalAmountFormat ?></h3>
                                        </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                        
                    <?php } ?>
                <?php } else { ?>
                    <div class="card card-style">
                        <div class="content">
                            <h4 class="text-center font-14 font-500">Tidak ada pesanan yang sudah diterima.</h4>
                        </div>
                    </div>
                <?php } ?>


                
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