<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
        p {
            color: red !important;
        }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>
        <div class="page-content pb-0">

            <div data-card-height="cover-full" class="card mb-0" style="background-image:url(<?php echo base_url() . 'asset/appkit/images/background-1.jpg' ?>)">
                <div class="card-center">

                    <div class="text-center">
                        <p class="font-600 color-highlight mb-1 font-16">Let's Get Started</p>
                        <h1 class="font-40 color-white">Sign In</h1>
                    </div>

                    <form action="<?php echo base_url() . 'jamaah/login' ;?>" id="myForm" method="post">
                        <div class="content px-4">

                            <div class="input-style input-transparent no-borders has-icon validate-field mb-4">
                                <i class="fa fa-user"></i>
                                <input type="name" name="username" class="form-control validate-name" id="form1a"
                                    placeholder="Username">
                                <label for="form1a" class="color-highlight">Username</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                            <div class="mt-n3 mb-3"><?php echo form_error('username') ?></div>
                            
                            <div class="input-style input-transparent no-borders has-icon validate-field mb-4 mt-4">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" class="form-control validate-password"
                                    id="form1b" placeholder="Password">
                                <label for="form1b" class="color-highlight">Password</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                            <div class="mt-n3 mb-5"><?php echo form_error('password') ?></div>

                            <a href="#" id="submitBtn" data-back-button
                                class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Sign
                                In</a>

                            <div class="row pt-3 mb-3">
                                <div class="col-6 text-start font-11">
                                    <a class="color-white opacity-50"
                                        href="<?php echo base_url() . 'jamaah/login/forgot' ;?>">Forgot Password?</a>
                                </div>
                                <div class="col-6 text-end font-11">
                                    <a class="color-white opacity-50"
                                        href="<?php echo base_url() . 'jamaah/login/sign_up' ;?>">Create Account</a>
                                </div>
                            </div>
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