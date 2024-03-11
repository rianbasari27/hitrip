<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <style>
        .circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
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
        <!-- <input id="searchInput" type="text" oninput="performSearch()" class="border-0"
        placeholder="Search by title" value=""> -->
            <div class="ms-4 me-4 mb-4">
                <div class="search-box bg-theme rounded-m bottom-0">
                    <i class="fa fa-search ms-2"></i>
                    <input id="searchInput" type="text" oninput="performSearch()" class="border-0"
                    placeholder="Cari nama surat" value="">
                </div>
            </div>

            <?php foreach ($surat as $s) : ?>
            <a href="<?php echo base_url() . 'jamaah/surat_doa/surat/' . $s['nomor']?>" class="card card-style mb-3" id="no<?php echo $s['nomor'] ?>">
                <div class="content m-3 ">
                    <div class="d-flex">
                        <div class="circle bg-highlight px-3 py-2 me-3 my-auto">
                            <span><?php echo $s['nomor'] ?></span>
                        </div>
                        <div class="align-self-center">
                            <h5 class="mb-0 font-15"><?php echo $s['namaLatin'] ?></h5>
                            <span class="font-11 color-theme opacity-70"><?php echo $s['arti'] ?></span>
                        </div>
                        <div class=" ms-auto text-end align-self-center">
                            <h5 class="color-theme font-20 font-700 d-block mb-n1"><?php echo $s['nama'] ?></h5>
                            <span class="font-11" id="bookmark<?php echo $s['nomor'] ?>"></span>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
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

        $(document).ready(function() {
            var token = messaging.getToken()
            token.then((result) => {
                // console.log(result);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'jamaah/surat_doa/get_bookmark'?>', 
                    data: { 
                        userId: result,
                    },
                    success: function (response) {
                        // console.log(response);
                        var parsedData = JSON.parse(response);
                        var index = parsedData.bookmark.no_surat - 3;
                        var targetElement = $('#no' + index);
                        // console.log(index);
                        $('#bookmark'+parsedData.bookmark.no_surat).html('<i class="fa-solid fa-book-bookmark me-1"></i>Terakhir dibaca');
                        $('#no'+parsedData.bookmark.no_surat).addClass('bg-highlight text-white');

                        if (targetElement.length) {
                            var targetPosition = targetElement.offset().top;
                            $('html, body').animate({
                                scrollTop: targetPosition
                            }, {
                                duration: 1500, 
                                easing: 'easeInOutCubic'
                            });
                        }
                        
                        // var targetPosition = targetElement.offset().top;
                        // $('html, body').animate({
                        //     scrollTop: targetPosition
                        // }, {
                        //     duration: 2000, 
                        //     easing: 'easeInOutCubic'
                        // });

                        // console.log(nomorSurat + ' ' + nomorSuratNow);
                        // console.log(parsedData);
                        // bookmark(parsedData);
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);

                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
            
        })
        
        function performSearch() {
            var input, filter, cards, card, title, i;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            cards = document.getElementsByClassName("card-style");

            for (i = 0; i < cards.length; i++) {
                card = cards[i];
                title = card.getElementsByClassName("mb-0")[0];

                if (title.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            }
        }
    </script>

</body>