<!DOCTYPE HTML>
<html lang="en">
<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <style>
        #myVideo {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%; 
            min-height: 100%;
        }

        .card-center {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Optional: Sesuaikan tinggi dengan kebutuhan Anda */
            padding-top: 60vh; /* Sesuaikan padding-top agar konten tidak bertabrakan dengan video */
        }

    </style>
</head>
    
<body class="theme-light">
<video autoplay muted loop id="myVideo">
  <source src="<?php echo base_url() . 'asset/video/background_vid.mp4' ;?>" type="video/mp4">
  Your browser does not support HTML5 video.
</video>
    
<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
    
<div id="page">
    
    <div class="card-center text-center ps-3 mt-4">
        <img src="<?php echo base_url() ?>asset/appkit/images/hitrip/hitrip-white.png" alt="hitrip-logo" width="200">
        <h5 class="opacity-70 color-white">Explore the World with HiTrip</h5>
        <h4 class="boxed-text-xl pt-4 line-height-l color-white">Explore new horizons and make lasting memories with HiTrip's seamless global adventures.</h4>
        
        <a href="<?php echo base_url() ?>jamaah/splash/end/home" class="btn btn-center-l gradient-highlight rounded-sm btn-l font-13 font-600 mt-5 scale-box" style="margin-top: 100px;">Get Started</a>
    </div>
        
        
        
    </div>
    <!-- Page content ends here-->

    
</div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
</body>
