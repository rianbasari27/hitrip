<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <style>
        .pulse {
            height: 150px;
            width: 150px;
            /* background: linear-gradient(
				#8a82fb,
				#407ed7
			); */
            /* position: absolute; */
            margin-top: 150px auto 0px;
            /* : ; */
            /* left: 0;
			right: 0;
			top: 500px;
			bottom: 0; */
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 50px;
            color: #ffffff;
            animation: pulseAnimation 2s infinite;
        }

        /* .pulse:before,
		.pulse:after{
			content: "";
			position: absolute;
			height: 100%;
			width: 100%;
			background-color: #8a82fb;
			border-radius: 50%;
			z-index: 0;
			opacity: 0.7;
		} */
        .pulse:before {
            animation: pulse 4s ease-out infinite;
        }

        .pulse:after {
            animation: pulse 4s 4s ease-out infinite;
        }

        @keyframes pulse {
            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        @keyframes pulseAnimation {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .reset-btn {
            position: absolute;
            top: 600px;
            left: 50%;
            transform: translateX(-50%);
        }


        /* .theme-dark, .theme-dark .page-bg, .theme-dark #page {
			z-index: -2;
		} */
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <div class="content">
            <h1 class="text-center">Penghitung Dzikir</h1>
            <h2 class="text-center" style="font-size: 72px; margin-top: 80px;" id="counter">0</h2>
            <div class="mt-5 text-center">
                <span for="maxCountInput">Set Max Count:</span><br>
                <input type="number" id="maxCountInput" class="mx-auto rounded form-control" style="width: 40%;" value="" placeholder="0" onchange="setCounterLimit()">
            </div>
            <!-- <div class="mx-auto bg-highlight d-flex justify-content-center align-items-center rounded-circle pulse" style="margin-top: 300px; width: 150px; height: 150px;">
					<p class="mx-auto text-dark mb-0">Tap Here</p>
				</div> -->
            <div class="d-flex justify-content-center align-items-center mt-5">
                <a href="#" class="pulse gradient-highlight shadow-l" onclick="incrementCounter()">
                    <i class="fas fa-hand-pointer color-white"></i>
                </a>
            </div>


            <button class="reset-btn btn btn-border border-highlight color-highlight d-block mt-0 px-4 py-2 rounded-pill mx-auto d-flex justify-content-center align-self-center" onclick="resetCounter()">Reset</button>
        </div>




        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>


    <!-------------->
    <!-------------->
    <!--Menu Video-->
    <!-------------->
    <!-------------->

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <?php $this->load->view('jamaahv2/include/script_view'); ?>

    <script>
        maxCount = 999999;

        function setCounterLimit() {
            maxCount = parseInt(document.getElementById("maxCountInput").value);
            // alert("Max Count is set to " + maxCount);
        }

        function incrementCounter() {
            var counterElement = document.getElementById("counter");
            var currentCount = parseInt(counterElement.innerText);
            var newCount = currentCount + 1;
            if (maxCount > 0) {
                if (newCount > maxCount) {
                    newCount = 1;
                }
            }
            counterElement.innerText = newCount;
        }

        function resetCounter() {
            document.getElementById("counter").innerText = "0";
        }
    </script>
</body>