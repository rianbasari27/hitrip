<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .box {
        padding: 10px 10px 70px 10px;
        margin-bottom: 10px;
    }

    .left-side {
        padding-top: 15px;
        margin-right: 15px;
        text-align: center;
        float: left;
        width: 45%;
    }

    .right-side {
        padding-top: 15px;
        text-align: center;
        float: right;
        width: 45%;
    }

    .card-header {
        background-color: white;
    }

    .card-footer {
        background-color: white;
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar', ['always_show' => true]); ?>

        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu'); ?>

        <!-- header title -->
        <!-- NOT USED IN THIS PAGE -->
        <div class="page-content header-clear-medium">
            <div class="content">
                <div class="card card-style">
                    <div class="card-header">
                        <p class="font-600 color-highlight mb-n1">Bismillah</p>
                        <h1 class="font-30">Masuk</h1>
                        <p>
                            Masukkan nomor KTP Anda yang sudah didaftarkan sebelumnya.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="left-side">
                            Notes :
                            <div class="box">
                                <a href="<?php echo base_url() . 'jamaah/home'; ?>"><i
                                        class="fa-regular fa-user fa-2xl"></i></a>
                            </div>
                        </div>
                        <div class="right-side">
                            Penerima
                            <div class="box">
                                <a href="<?php echo base_url() . 'jamaah/masuk'; ?>"><i
                                        class="fa-regular fa-user"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>

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
    <script>
    function submit() {
        document.getElementById("myForm").submit();
    }
    </script>
</body>