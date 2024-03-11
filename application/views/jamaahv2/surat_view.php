<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-19 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-17 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-18 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-20 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-21 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-29 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-33 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .menu-ads {
        position: fixed;
        -webkit-backdrop-filter: saturate(180%) blur(20px);
        backdrop-filter: unset !important;
        background-color: unset !important;
        z-index: 101;
        overflow: scroll;
        transition: all 300ms ease;
        -webkit-overflow-scrolling: touch;
    }

    .theme-dark .menu-ads {
        background-color: unset !important;
    }

    .redStrikeHover {
        color: red;
        text-decoration: line-through;
    }

    @media screen and (min-width: 300px) {
        .jam {
            font-size: clamp(20px, 9vw, 40px);
        }
    }

    @media screen and (max-width: 300px) {

        .sign-icon,
        .video-icon {
            display: none;
        }

        .slider-item {
            font-size: 14px;
        }

        .btn-sm {
            padding: 7px 14px !important;
        }

        .harga-paket {
            font-size: 20px;
        }
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
        <?php $this->load->view('jamaahv2/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style">
                <div class="content">
                    <?php foreach ( $result as $r) { ?>
                    <p class="text-end font-28 mb-0 lh-base"><?php echo $r['arabic_text'] ?></p>
                    <p class="font-16"><?php echo $r['translation'] ?></p>
                    <?php } ?>
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

    <a href="#" data-menu="ad-timed-1" data-timed-ad="0" data-auto-show-ad="5"
        class="btn btn-m btn-full shadow-xl font-600 bg-highlight mb-2 d-none">Auto Show Adds</a>

    <!-------------->
    <!-------------->
    <!--Menu Video-->
    <!-------------->
    <!-------------->

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('jamaahv2/include/script_view'); ?>
    <script>
    $(document).ready(function() {
        // document.querySelector('.menu-hider').classList.add('menu-active');


        function updateTimes() {
            moment.tz.add([
                "Asia/Jakarta|LMT BMT +0720 +0730 +09 +08 WIB|-77.c -77.c -7k -7u -90 -80 -70|012343536|-49jH7.c 2hiLL.c luM0 mPzO 8vWu 6kpu 4PXu xhcu|31e6",
                "Asia/Riyadh|LMT +03|-36.Q -30|01|-TvD6.Q|57e5",
            ]);
            const jakartaTime = moment().tz("Asia/Jakarta").format("HH:mm");
            const riyadhTime = moment().tz("Asia/Riyadh").format("HH:mm");
            const jakartaDate = moment().tz("Asia/Jakarta").locale('id').format("ll");
            const riyadhDate = moment().tz("Asia/Riyadh").locale('id').format("ll");

            $("#jakarta").text(jakartaTime);
            $("#riyadh").text(riyadhTime);
            $("#jkt_date").text(jakartaDate);
            $("#riyadh_date").text(riyadhDate);
        }

        setInterval(updateTimes, 1000);

        updateTimes();
    });
    </script>
    <script>
    var firebaseConfig = {
        apiKey: "AIzaSyB-6_F42LEc7yhYxrtwIbVM3YSGMpCO8cU",
        authDomain: "my-app-bd747.firebaseapp.com",
        projectId: "my-app-bd747",
        storageBucket: "my-app-bd747.appspot.com",
        messagingSenderId: "1049171222616",
        appId: "1:1049171222616:web:c39c8d86bb9dba8a04ea2d",
        measurementId: "G-LTP6XBLHHH"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    messaging
        .requestPermission()
        .then(function() {
            console.log("Notification permission granted.");
            // get the token in the form of promise
            return messaging.getToken()
        })
        .then(function(token) {
            $.getJSON("<?php echo base_url() . 'call_notification/getToken';?>", {
                    token: token,
                    id: null,
                    user: null
                }).done(function(json) {
                    console.log('Berhasil tambah token');
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.log('Token Sudah ada');
                });
            console.log("Device token is : " + token)
        })
        .catch(function(err) {
            // ErrElem.innerHTML = ErrElem.innerHTML + "; " + err
            console.log("Unable to get permission to notify.", err);
        });
    </script>
</body>