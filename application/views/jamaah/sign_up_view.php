<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
        .error-message p {
            color: red !important;
        }
        .back-button {
            position: fixed;
            top: 30px;
            left: 30px;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 10;
        }

        .back-button a {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            font-size: 20px;
            text-decoration: none;
        }

        @media only screen and (min-width:600px) {
            .back-button {
                left: calc((100% - 600px) / 2 + 30px);
            }
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

            <!-- back button -->
            <div class="back-button bg-white">
                <a href="#" data-back-button class="color-highlight">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
            </div>

            <div data-card-height="cover-full" class="card mb-0" style="background-image:url(<?php echo base_url() . 'asset/appkit/images/background-3.jpg' ?>)">
                <div class="card-center">
                    <div class="text-center">
                        <p class="font-600 color-highlight mb-1 font-16">Buat akun</p>
                        <h1 class="font-40 color-white">Sign Up</h1>
                        <p class="boxed-text-xl color-white opacity-50 pt-3 font-15">

                        </p>

                    </div>

                    <form action="<?php echo base_url() . 'jamaah/login/sign_up' ;?>" id="myForm" method="post">
                        <div class="content px-4">
                            <div class="input-style input-transparent no-borders has-icon validate-field">
                                <i class="fa fa-user"></i>
                                <input type="name" class="form-control validate-text" name="username" id="form1ab"
                                    placeholder="Username" value="<?php echo set_value('username') ?>">
                                <label for="form1ab" class="color-highlight">Username</label>
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i> -->
                                <!-- <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em>(required)</em>
                            </div>
                            <div class="error-message mt-n2 mb-3"><?php echo form_error('username') ?></div>

                            <div class="input-style input-transparent no-borders has-icon validate-field">
                                <i class="fa fa-user"></i>
                                <input type="name" class="form-control validate-text" name="name" id="form1ac"
                                    placeholder="Full Name"
                                    value="<?php echo set_value('name') ?>">
                                <label for="form1ac" class="color-highlight">Full Name</label>
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i> -->
                                <!-- <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em>(required)</em>
                            </div>
                            <div class="error-message mt-n2 mb-3"><?php echo form_error('name') ?></div>

                            <div class="input-style input-transparent no-borders has-icon validate-field">
                                <i class="fa fa-at"></i>
                                <input type="email" name="email" class="form-control validate-email" id="form1ad"
                                    placeholder="Email Address"
                                    value="<?php echo set_value('email') ?>">
                                <label for="form1ad" class="color-highlight">Email Address</label>
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i> -->
                                <!-- <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em>(required)</em>
                            </div>
                            <div class="error-message mt-n2 mb-3"><?php echo form_error('email') ?></div>

                            <div class="input-style input-transparent no-borders has-icon validate-field">
                                <i class="fa fa-phone"></i>
                                <input type="number" name="no_wa" class="form-control validate-email" id="form1ae"
                                    placeholder="No. Telp"
                                    value="<?php echo set_value('no_wa') ?>">
                                <label for="form1ae" class="color-highlight">No. Telp</label>
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i> -->
                                <!-- <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em>(required)</em>
                            </div>
                            <div class="error-message mt-n2 mb-3"><?php echo form_error('no_wa') ?></div>

                            <div class="input-style input-transparent no-borders has-icon validate-field">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="password" class="form-control validate-password"
                                    id="form1af" placeholder="Password"
                                    value="<?php echo set_value('password') ?>">
                                <label for="form1af" class="color-highlight">Password</label>
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i> -->
                                <!-- <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em>(required)</em>
                            </div>
                            <div class="error-message mt-n2 mb-3"><?php echo form_error('password') ?></div>

                            <div class="input-style input-transparent no-borders has-icon validate-field">
                                <i class="fa fa-lock"></i>
                                <input type="password" name="confirmPassword" class="form-control validate-password"
                                    id="form1ag" placeholder="Confirm Password"
                                    value="<?php echo set_value('confirmPassword') ?>">
                                <label for="form1ag" class="color-highlight">Confirm Password</label>
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i> -->
                                <!-- <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em>(required)</em>
                            </div>
                            <div class="error-message mt-n2 mb-3"><?php echo form_error('confirmPassword') ?></div>

                            <a href="#" id="submitBtn" data-back-button
                                class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Sign
                                Up</a>

                            <div class="row pt-3 mb-3">
                                <div class="col-6 text-start font-11">
                                    <a class="color-white opacity-50"
                                        href="<?php echo base_url() . 'jamaah/login/forgot' ;?>">Lupa
                                        Password?</a>
                                </div>
                                <div class="col-6 text-end font-11">
                                    <a class="color-white opacity-50"
                                        href="<?php echo base_url() . 'jamaah/login' ;?>">Sign In</a>
                                </div>
                            </div>

                        </div>
                    </form>


                </div>
                <div class="card-overlay bg-black opacity-85"></div>
                <?php $this->load->view('jamaah/include/alert'); ?>
                <?php $this->load->view('jamaah/include/toast'); ?>
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