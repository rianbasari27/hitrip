<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>
        <div class="page-content pb-0">

            <div data-card-height="cover-full" class="card mb-0"
                style="background-image:url(<?php echo base_url() . 'asset/appkit/images/background-3.jpg' ?>)">
                <div class="card-center">

                    <div class="text-center">
                        <p class="font-600 color-highlight mb-1 font-16">Let's Get Started</p>
                        <h1 class="font-40 color-white">Reset Password</h1>
                    </div>

                    <form action="<?php echo base_url() . 'jamaah/login/proses_reset_pass' ;?>" id="myForm"
                        method="post">
                        <div class="content px-4">
                            <input type="hidden" name="email"
                                value="<?php echo isset($_SESSION['form']['email']) ? $_SESSION['form']['email'] : $email ;?>">
                            <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                                <i class="fa fa-user"></i>
                                <input type="password" name="password" class="form-control validate-name" id="form1a"
                                    placeholder="New Password">
                                <label for="form1a" class="color-highlight">New Password</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                            <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="confirmPassword" class="form-control validate-password"
                                    id="form1b" placeholder="Confirm Password">
                                <label for="form1b" class="color-highlight">Confirm Password</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>

                            <a href="#" aria-label="For submit the form" id="submitBtn" data-back-button
                                class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Continue</a>
                        </div>
                    </form>

                </div>
                <div class="card-overlay bg-black opacity-85"></div>
                <?php $this->load->view('jamaah/include/alert'); ?>
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


    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
    <script>
    $(document).ready(function() {
        $('#submitBtn').on('click', function() {
            $('#myForm').submit();
        });
    });
    </script>
</body>