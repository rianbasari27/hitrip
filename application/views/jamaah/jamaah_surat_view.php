<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
    .bg-11 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/quran-bg.jpg");
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
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style bg-11 mt-3" data-card-height="250">
                <div class="card-top ps-3 mt-3 mb-2">
                    <a href="<?php echo base_url() . 'jamaah/surat_doa/' ?>"
                        class="py-2 px-3 bg-white rounded-l color-dark-dark"><i
                            class="fa-solid fa-arrow-left me-2"></i>Semua surat</a>
                </div>
                <div class="card-center mt-n2 px-3 pb-3 mt-3">
                    <!-- <h1 class="font-14 mb-n1 fw-bold color-white text-shadow">Assalamu'alaikum</h1> -->
                    <div style="width: 75%;">
                        <h1 class="font-40 color-white text-shadow mb-0"><?php echo $nama ?></h1>
                        <h3 class="font-18 color-white text-shadow mb-0"><?php echo $namaLatin ?></h3>
                        <span class="text-white"><?php echo $arti ?></span><br>
                        <!-- <span class="text-white"><?php echo $tempatTurun == 'Mekah' ? 'Makkiyah' : 'Madaniyah' ?></span><br> -->
                        <!-- <span class="text-white">Jumlah Ayat : <?php echo $jumlahAyat ?></span> -->
                    </div>
                </div>
                <div class="card-bottom ps-3 pb-3">
                    <div>
                        <audio class="pe-3" controls style="width: 100%; height: 40px;">
                            <source src="<?php echo $audioFull['01']; ?>" type="audio/mp3">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    </div>
                </div>
                <div class="card-overlay"></div>
            </div>

            <!-- <div class="card card-style">
                <div class="content">
                    <h3><?php echo $namaLatin ?></h3>
                    <span><?php echo $tempatTurun ?></span><br>
                    <span>Jumlah Ayat : <?php echo $jumlahAyat ?></span>
                    <div>
                        <audio controls>
                            <source src="<?php echo $audioFull['01']; ?>" type="audio/mp3">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>
                    </div>
                </div>
            </div> -->

            <div class="card card-style">
                <div class="content">

                    <?php foreach ( $ayat as $a) { ?>
                    <div class="align-self-center mt-3" id="ayat<?php echo $a['nomorAyat'] ?>">
                        <div class="d-flex mb-3">
                            <div class="circle bg-highlight">
                                <span><?php echo $a['nomorAyat'] ?></span>
                            </div>
                            <a href="#" data-id="<?php echo $a['nomorAyat'] ?>" id="a<?php echo $a['nomorAyat']?>"
                                class="btnTandai btn btn-xs ms-2 py-1 px-3 btn-border border-highlight color-highlight opacity-80 rounded-l my-auto">
                                <i class="fa-solid fa-bookmark me-2"></i>Tandai
                            </a>
                        </div>
                        <span
                            class="d-block text-end font-28 color-dark-dark mb-0 lh-base"><?php echo $a['teksArab'] ?></span>
                    </div>
                    <p class="font-14"><?php echo $a['teksIndonesia'] ?></p>
                    <div class="divider"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script> -->
    <!-- <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script> -->
    <?php $this->load->view('jamaah/include/script_view'); ?>
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
        setBookmark()

        function setBookmark() {
            var token = messaging.getToken()
            token.then((result) => {
                // console.log(result);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'jamaah/surat_doa/get_bookmark'?>',
                    data: {
                        userId: result,
                    },
                    success: function(response) {
                        // console.log(response);
                        var parsedData = JSON.parse(response);
                        var riwayatAyat = parsedData.bookmark.ayat;
                        var nomorSurat = <?php echo $nomor; ?>;
                        var nomorSuratNow = parsedData.bookmark.no_surat;
                        var nomorAyatTujuan = parsedData.bookmark.ayat - 1;
                        var targetElement = $('#ayat' + nomorAyatTujuan);
                        console.log(nomorSuratNow);
                        if (nomorSurat == nomorSuratNow) {
                            if (targetElement.length) {
                                var targetPosition = targetElement.offset().top;
                                $('html, body').animate({
                                    scrollTop: targetPosition
                                }, {
                                    duration: 1500,
                                    easing: 'easeInOutCubic'
                                });
                            }
                        }
                        if (nomorSurat == nomorSuratNow) {
                            $('#a' + riwayatAyat).addClass('bg-highlight');
                        }

                        // console.log(nomorSurat + ' ' + nomorSuratNow);
                        // console.log(parsedData);
                        // bookmark(parsedData);
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

        }
        // console.log(token)

        // document.querySelector('.menu-hider').classList.add('menu-active');
        $('.btnTandai').on('click', function(e) {
            e.preventDefault();

            var nomorAyat = $(this).data('id');
            var nomorSurat = <?php echo $nomor; ?>;
            // var userId = <?php //echo $_SESSION['id_agen']; ?>;
            var token = messaging.getToken()
            token.then((result) => {
                console.log(result);
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . 'jamaah/surat_doa/tandai_ayat'?>',
                    data: {
                        userId: result,
                        nomorAyat: nomorAyat,
                        nomorSurat: <?php echo $nomor; ?>
                    },
                    success: function(response) {
                        var parsedData = JSON.parse(response);
                        // console.log(parsedData.before);
                        // $(this).attr("disabled", true);
                        Swal.fire({
                            icon: 'success',
                            title: 'Ayat berhasil ditandai',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        bookmark(parsedData);
                        // setTimeout(function() {
                        //     location.reload();
                        // }, 2000);

                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            // console.log(token);

        });



        function bookmark(data) {
            var ayatBefore = data.before.ayat;
            var ayatAfter = data.after.ayat;
            // console.log(ayatBefore);
            $('#a' + data.before['ayat']).removeClass('bg-highlight');
            $('#a' + data.after['ayat']).addClass('bg-highlight');

            // console.log(a);
        }
    });
    </script>
</body>