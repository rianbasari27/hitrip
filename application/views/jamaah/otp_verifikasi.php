<!DOCTYPE HTML>
<html lang="en">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
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
                        <p class="font-600 color-highlight mb-1 font-16">Verifikasi identitas Anda</p>
                        <h1 class="font-26 color-white">Masukkan kode OTP</h1>
                        <p class="px-4 color-white">Silahkan periksa pesan WhatsApp Anda untuk melihat kode OTP yang telah kami kirim.</p>
                    </div>

                    <div class="content px-4">
                        <div class="text-center mx-n3">
                            <form action="<?php echo base_url() . "jamaah/login/proses_sign_up" ;?>" method="post"
                                id="myForm">
                                <input type="hidden" name="username" value="<?php echo $username;?>">
                                <input type="hidden" name="name" value="<?php echo $name;?>">
                                <input type="hidden" id="noWa" name="no_wa" value="<?php echo $no_wa;?>">
                                <input type="hidden" name="email" value="<?php echo $email;?>">
                                <input type="hidden" name="password" value="<?php echo $password;?>">
                                <input class="otp mx-1 rounded-sm text-center font-20 font-900" name="otp1" type="tel"
                                    value="●">
                                <input class="otp mx-1 rounded-sm text-center font-20 font-900" name="otp2" type="tel"
                                    value="●">
                                <input class="otp mx-1 rounded-sm text-center font-20 font-900" name="otp3" type="tel"
                                    value="●">
                                <input class="otp mx-1 rounded-sm text-center font-20 font-900" name="otp4" type="tel"
                                    value="●">
                                <input class="otp mx-1 rounded-sm text-center font-20 font-900" name="otp5" type="tel"
                                    value="●">
                                <input class="otp mx-1 rounded-sm text-center font-20 font-900" name="otp6" type="tel"
                                    value="●">
                            </form>
                        </div>

                        <p class="text-center my-4 font-11 color-white">Tidak mendapatkan kode? <a href="#"
                                id="resendBtn">Kirim ulang</a></p>

                        <a href="#" id="submitBtn" data-back-button
                            class="btn btn-full btn-l font-600 font-13 gradient-highlight mt-4 rounded-s">Verifikasi Akun</a>

                    </div>

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

        $('#resendBtn').on('click', function(e) {
            e.preventDefault();

            // Mendapatkan nomor telepon dari atribut data
            var phoneNumber = $("#noWa").val();
            // Kirim permintaan AJAX untuk resend code
            $.ajax({
                url: '<?php echo base_url() . 'jamaah/login/resendCode'; ?>',
                type: 'GET',
                data: {
                    no: phoneNumber
                },
                success: function(response) {
                    // Tanggapan sukses, lakukan apa yang diperlukan (misalnya, tampilkan pesan)
                    alert('Resend code successful!');
                },
                error: function(xhr, status, error) {
                    // Terjadi kesalahan, tangani di sini (misalnya, tampilkan pesan kesalahan)
                    alert('An error occurred while resending code.');
                }
            });
        });
    });
    </script>
</body>