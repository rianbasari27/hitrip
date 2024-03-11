<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
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
            <div class="card card-style">
                <div class="content">
                    <p class="font-600 color-highlight mb-n1">Bismillah</p>
                    <h1 class="font-30 mb-3">Backdoor Login Konsultan</h1>
                    <form action="<?php echo base_url() . 'konsultan/backdoor/login_proses' ?>" method="post">
                        <div class="d-flex">
                            <input type="text" class="form-control rounded" name="id_agen">
                            <button type="submit" class="btn btn-xs bg-highlight rounded ms-2 font-18">Submit</button>
                        </div>
                    </form>

                    <?php if (isset($_SESSION['alert'])) { ?>
                        <div class="mt-3 font-800 color-<?php echo $_SESSION['alert']['color'] ?>-dark"><?php echo $_SESSION['alert']['message']; ?></div>
                    <?php } ?>

                </div>
            </div>

        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/home/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/home/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/home/colors'; ?>" data-menu-height="480"></div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script>
        function submit() {
            document.getElementById("myForm").submit();
        }
    </script>
    <script src="https://accounts.google.com/gsi/client" async></script>
</body>