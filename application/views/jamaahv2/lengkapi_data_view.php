<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/image-popup.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/easy_datepicker/dist/jquery.date-dropdowns.js"></script>
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/easy_datepicker/demo/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/datepicker/lib/drum.css">
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- add for datepicker -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.fakemultitouch.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/lib/drum.js"></script>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
    }

    .capital {
        text-transform: uppercase;
    }

    /* CSS for datepicker */
    .date-picker {
        background-color: white !important;
    }

    .example {
        width: 0% !important;
        min-width: 0px !important;
    }

    div.date_wrapper {
        width: 265px;
    }

    div.date_wrapper .date_header {
        height: 25px;
        font-weight: 400;
        border-bottom: 1px solid #CCC;
        margin-bottom: 10px;
    }

    div.date_wrapper .date_header span.title {
        float: left;
        text-align: left;
    }

    div.date_wrapper .date_header span.selection {
        float: right;
        text-align: right;
        color: #CE0000;
    }

    div.date_wrapper form {
        position: relative;
    }

    div.date_wrapper .lines {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        border-top: solid 1px #CCC;
        border-bottom: solid 1px #CCC;
        position: absolute;
        top: 58px;
        left: 0px;
        width: 100%;
        height: 24px;
    }

    div.date_wrapper .lines div {
        margin-left: 220px;
        line-height: 21px;
    }

    div.drum-wrapper {
        float: left;
    }

    div.drum figure {
        text-align: left;
    }

    #drum_hours figure,
    #drum_date figure {
        text-align: right;
    }

    #drum_date,
    #drum_to_date {
        margin-left: 10px;
        margin-right: 5px;
    }

    /* #drum_date,  #drum_hours,  #drum_minutes {
        width: 50px !important; 
        font-size: 18px;
    } */
    #drum_hours {
        margin-left: 10px;
    }

    #drum_minutes {
        margin-left: 4px;
    }

    #drum_month {
        width: 140px;
        font-size: 18px;
    }

    #drum_fullYear {
        width: 60px;
        font-size: 18px;
    }

    #drum_hours .dial div {
        margin: 0 7px;
    }

    #drum_minutes .dial div {
        margin: 0 2px;
    }
    </style>
    <script>
    // script for datepicker
    Hammer.plugins.fakeMultitouch();

    function getIndexForValue(elem, value) {
        for (var i = 0; i < elem.options.length; i++)
            if (elem.options[i].value == value)
                return i;
    }

    function pad(number) {
        if (number < 10) {
            return '0' + number;
        }
        return number;
    }

    function update(datetime) {
        $("#date").drum('setIndex', datetime.getDate() - 1);
        $("#month").drum('setIndex', datetime.getMonth());
        $("#fullYear").drum('setIndex', getIndexForValue($("#fullYear")[0], datetime.getFullYear()));
    }

    $(document).ready(function() {
        $("select.date").drum({
            onChange: function(elem) {
                var selectedYear = parseInt($("#fullYear").val());
                var selectedMonth = parseInt($("#month").val()) +
                    1; // Tambahkan 1 karena indeks bulan dimulai dari 0
                var selectedDate = parseInt($("#date").val());

                // Periksa apakah tanggal yang dipilih valid untuk bulan yang dipilih
                var maxDate = new Date(selectedYear, selectedMonth, 0).getDate();
                if (selectedDate > maxDate) {
                    // Jika tanggal yang dipilih melebihi jumlah hari dalam bulan, atur tanggal ke tanggal terakhir bulan
                    selectedDate = maxDate;
                    $("#date").drum('setIndex', selectedDate - 1);
                }

                var date = new Date(selectedYear, selectedMonth - 1,
                    selectedDate); // Kurangi 1 dari bulan karena indeks dimulai dari 0
                date.setSeconds(0);
                update(date);

                var format = date.getFullYear() + '-' + pad(date.getMonth() + 1) + '-' + pad(date
                    .getDate());

                $('.date_header .selection').html(format);
            }
        });
        update(new Date());
    });
    </script>
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

        <div class="page-content">

            <div class="card card-style">
                <div class="content">

                    <div class="mt-1">
                        <p class="color-highlight font-600 mb-n1">Registrasi</p>
                        <h3>Lengkapi Data</h3>
                        <span>Lengkapi data Anda dan keluarga Anda di bawah ini untuk ke proses selanjutnya.</span>
                        <div class="list-group list-custom-small">
                            <?php foreach ($parentMembers as $pm) : ?>
                            <?php if ($pm->jamaahData->tempat_lahir == null || $pm->jamaahData->tanggal_lahir == null || $pm->jamaahData->jenis_kelamin == null || $pm->jamaahData->no_wa == null) : ?>
                            <a
                                href="<?php echo base_url() . 'jamaah/daftar/lengkapi_data?id=' . $pm->jamaahData->member[0]->idSecretMember ?>">
                                <i
                                    class="fa-solid fa-user icon icon-xs rounded-sm shadow-l mr-1 bg-highlight text-white"></i>
                                <span style="font-size: 15px;">
                                    <?php echo implode(' ', array_filter([$pm->jamaahData->first_name, $pm->jamaahData->second_name, $pm->jamaahData->last_name])) ?>
                                </span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>

                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="https://wa.me/6287815131635" target="_blank">
                            <i class="fab font-15 fa-whatsapp icon icon-xs rounded-sm shadow-l mr-1 bg-whatsapp"></i>
                            <span>Help & Support</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>


            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>

        </div>
        <!-- Page content ends here-->


        <?php $this->load->view('jamaahv2/include/script_view'); ?>
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

    <!-- Modal new datepicker -->
    <div id="datepicker2" class="date-picker menu menu-box-modal rounded-m" data-menu-height="280"
        data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="wrapper">
                <div class="example">
                    <input type="hidden" id="example" name="tanggal">
                    <button type="button" id="set"
                        class="close-menu btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s mt-4"
                        style="float: right;">Pilih</button>
                </div>
            </div>
        </div>
    </div>

    <!-- datepicker modal -->
    <div id="datepicker" class="date-picker menu menu-box-modal rounded-m" data-menu-height="280" data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <!-- Date picker here -->
            <div class="date_header">
                <span class="title">Tanggal lahir : </span><span class="selection fw-bold"></span>
            </div>

            <div class="d-block w-full">
                <form name="date">
                    <div class="lines mb-2"></div>
                    <div class="width:100px;">
                        <select class="date" id="date" name="date">
                            <?php for ($i = 1; $i <= 31; $i++) : ?>
                            <option value="<?php echo $i?>"><?php echo $i?>.</option>
                            <?php endfor; ?>
                        </select>
                        <select class="date" id="month" name="month">
                            <option value="0">Januari</option>
                            <option value="1">Februari</option>
                            <option value="2">Maret</option>
                            <option value="3">April</option>
                            <option value="4">Mei</option>
                            <option value="5">Juni</option>
                            <option value="6">Juli</option>
                            <option value="7">Agustus</option>
                            <option value="8">September</option>
                            <option value="9">Oktober</option>
                            <option value="10">November</option>
                            <option value="11">Desember</option>
                        </select>
                        <select class="date" id="fullYear" name="fullYear">
                            <?php for ($i = date('Y'); $i >= date('Y', strtotime('-100 years')); $i--) : ?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="button" id="setTanggal"
                        class="close-menu btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s">Pilih</button>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>

    <script>
    // add for datepicker
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script');
        ga.type = 'text/javascript';
        ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') +
            '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(ga, s);
    })();
    // end for datepicker

    $(function() {
        $("#example").dateDropdowns();
        $('input[name="tanggal"]')
            .attr("type", "text")
            .attr("class", "selection")
            .attr("readonly", "readonly");
    });

    function submit() {
        document.getElementById("myForm").submit();
    }

    $(document).ready(function() {
        // var elementCount = 1;

        // $(document).on("click", ".delete-jamaah", function() {
        //     $(this).closest(".append-jamaah").remove();
        //     checkDeleteButton();
        // });

        // $("#add_jamaah").on("click", function(){
        //     var clonedElement = $(".append-jamaah:first").clone().attr('id', 'append_' + (++elementCount));
        //     clonedElement.find('input').val('');
        //     $(".append-container").append(clonedElement);
        //     checkDeleteButton();
        // });

        // function checkDeleteButton() {
        //     var jumlahElement = $(".append-jamaah").length;
        //     $(".delete-jamaah").prop("disabled", jumlahElement <= 1);
        // }
        // checkDeleteButton();

        // set tanggal
        $("#set").click(function() {
            var sourceText = $("#example").val();
            $("#form7").val(sourceText);
        });
        // $("#setTanggal").click(function() {
        //     var sourceText = $(".selection").text();
        //     $("#form7").val(sourceText);
        // });

        $("#form8").autocomplete({
            source: "<?php echo base_url() . 'jamaahv2/daftar/getTempatLahir'; ?>"
        });

        $('.upper').on('input', function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.upper').focusout(function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.upper').focusin(function() {
            this.value = this.value.toLocaleUpperCase();
        });

    })

    // function showOnChange(e) {
    //     var elem = document.getElementById("slct");
    //     var value = elem.options[elem.selectedIndex].value;
    //     if (value == "Agen") {
    //         document.getElementById('Agen').style.display = "block";
    //     } else {
    //         document.getElementById('Agen').style.display = "none";
    //     }
    // }
    </script>
</body>