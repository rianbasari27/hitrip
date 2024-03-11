<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->	
        <link rel="icon" type="image/png" href="../asset/login/images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../asset/login/vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../asset/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../asset/login/fonts/iconic/css/material-design-iconic-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../asset/login/vendor/animate/animate.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="../asset/login/vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../asset/login/vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../asset/login/vendor/select2/select2.min.css">
        <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="../asset/login/vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="../asset/login/css/util.css">
        <link rel="stylesheet" type="text/css" href="../asset/login/css/main.css">
        <!--===============================================================================================-->
    </head>
    <body>

        <div class="limiter">
            <div class="container-login100" style="background-image: url('../asset/login/images/bg-01.jpg');">
                <div class="wrap-login100">
                    <form action="<?php echo base_url(); ?>staff/login/login_process" method="post" class="login100-form validate-form">

                        <center>
                            <img src="../asset/login/images/LOGO-VENTOUR.png" alt="LOGO" style="width:300px;">
                        </center>


                        <span class="login100-form-title p-b-34 p-t-27">

                        </span>
                        <span style="color:#ff9980;margin-bottom:19px;display:block;">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo $_SESSION['error'];
                            }
                            ?>
                            <?php echo validation_errors(); ?>
                        </span>
                        <div class="wrap-input100 validate-input" data-validate = "Masukkan Email">
                            <input class="input100" type="text" name="email" placeholder="Email">
                            <span class="focus-input100" data-placeholder="&#xf207;"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Masukkan Password">
                            <input class="input100" type="password" name="pass" placeholder="Password">
                            <span class="focus-input100" data-placeholder="&#xf191;"></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn" type="submit">
                                Login
                            </button>
                        </div>

                        <div class="text-center p-t-90">
                            <a class="txt1" href="#">
                                Forgot Password?
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div id="dropDownSelect1"></div>

        <!--===============================================================================================-->
        <script src="../asset/login/vendor/jquery/jquery-3.2.1.min.js"></script>
        <!--===============================================================================================-->
        <script src="../asset/login/vendor/animsition/js/animsition.min.js"></script>
        <!--===============================================================================================-->
        <script src="../asset/login/vendor/bootstrap/js/popper.js"></script>
        <script src="../asset/login/vendor/bootstrap/js/bootstrap.min.js"></script>
        <!--===============================================================================================-->
        <script src="../asset/login/vendor/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="../asset/login/vendor/daterangepicker/moment.min.js"></script>
        <script src="../asset/login/vendor/daterangepicker/daterangepicker.js"></script>
        <!--===============================================================================================-->
        <script src="../asset/login/vendor/countdowntime/countdowntime.js"></script>
        <!--===============================================================================================-->
        <script src="../asset/login/js/main.js"></script>

    </body>
</html>
