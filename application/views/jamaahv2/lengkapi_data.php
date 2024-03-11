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

    .btn-set-tanggal {
        position: absolute;
        top: 250px;
        left: 220px;
        width: 100px !important;
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

    .lines {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        border-top: solid 1px black;
        border-bottom: solid 1px black;
        position: absolute;
        top: 167px;
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
        font-size: 20px;
        width: 50px;
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
        width: 170px;
        font-size: 20px;
    }

    #drum_fullYear {
        width: 60px;
        font-size: 20px;
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
                var selectedMonth = parseInt($("#month").val()) + 1;
                var selectedDate = parseInt($("#date").val());

                var maxDate = new Date(selectedYear, selectedMonth, 0).getDate();
                if (selectedDate > maxDate) {
                    selectedDate = maxDate;
                    $("#date").drum('setIndex', selectedDate - 1);
                }

                var date = new Date(selectedYear, selectedMonth - 1, selectedDate);
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
            <div class="card card-style bg-red-dark" data-card-height="160">
                <div class="content">
                    <div class="d-flex mb-3">
                        <h4><i class="fa fa-3x fa-exclamation-circle color-white scale-box shadow-xl rounded-circle"></i></h4>
                        <h1 class="my-auto ms-3 color-white">Lengkapi Data Anda</h1>
                    </div>
                    <span class="color-white font-16">Lengkapi data Anda untuk keperluan <strong>Dokumen</strong> dan <strong>Perlengkapan</strong>.</span>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="d-flex">
                        <div class="align-self-center rounded-sm shadow-l bg-gray-light p-2 me-2">
                            <img src="<?php echo base_url() ?>asset/appkit/images/ventour/avatar.png" width="20">
                        </div>
                        <div class="align-self-center">
                            <p class="color-highlight font-600 mb-n1">Nama Jamaah</p>
                            <h3>
                                <?php echo implode(' ', array_filter([$first_name, $second_name, $last_name])) ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">

                    <div class="mt-1">
                        <p class="color-highlight font-600 mb-n1">Registrasi</p>
                        <h3>Lengkapi Data</h3>
                    </div>

                    <form action="<?php echo base_url(); ?>jamaah/daftar/proses_lengkapi_data" method="post"
                        id="myForm">
                        <div class="mt-4 mb-">
                            <input type="hidden" name="id_member" value="<?php echo $member[0]->id_member ?>">
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="no_wa" type="tel" class="form-control validate-name upper" id="form6"
                                    placeholder="contoh +6281631631"
                                    value="<?php echo $no_wa == null ? '+62' : $no_wa;?>" required>
                                <label for="form6" class="color-highlight">Nomor Telepon (Aktif WhatsApp) <strong
                                        class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <a href="#" data-menu="datepicker2" class="text-dark">
                                    <input name="tanggal_lahir" type="date" class="form-control validate-name upper"
                                        id="form7" readonly value="<?php echo $tanggal_lahir; ?>">
                                    <label for="form7" class="color-highlight">Tanggal Lahir <strong
                                            class="text-danger">*</strong></label>
                                </a>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="tempat_lahir" type="text" class="form-control validate-name upper"
                                    id="form8" value="<?php echo $tempat_lahir; ?>">
                                <label for="form8" class="color-highlight">Tempat Lahir <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders input-style-always-active validate-field mb-4">
                                <label for="select" class="color-highlight">Jenis Kelamin <strong class="text-danger">
                                        *</strong></label>
                                <select name="jenis_kelamin" id="form-9">
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="L" <?php echo $jenis_kelamin == 'L' ? 'selected' :'' ;?>>LAKI-LAKI
                                    </option>
                                    <option value="P" <?php echo $jenis_kelamin == 'P' ? 'selected' :'' ;?>>PEREMPUAN
                                    </option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
                            <a href="#" onclick="submit();"
                                class="btn btn-full btn-m gradient-highlight rounded-s font-13 font-600 mt-4">Simpan</a>
                        </div>
                    </form>
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

        </div>
        <!-- Page content ends here-->


        <?php $this->load->view('jamaahv2/include/alert-bottom'); ?>
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
    <div id="datepicker2" class="date-picker menu menu-box-modal rounded-m" data-menu-height="300"
        data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="date_header mb-3">
                <span class="title">Tanggal lahir : </span>
                <div class="fw-bold fs-5" id="tanggalLahir"><span id="tahun">0000</span>-<span
                        id="bulan">00</span>-<span id="tanggal">00</span></div>
            </div>
            <div class="row">
                <div class="col-3">
                    Tanggal
                    <input name="tanggal" type="number" class="form-control rounded fs-5 shadow" id="tanggalInput">
                </div>
                <div class="col-5">
                    Bulan
                    <select name="bulan" class="form-control rounded fs-5 shadow" id="bulanInput">
                        <option value="00" selected></option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col">
                    Tahun
                    <input type="number" class="form-control rounded fs-5 shadow" id="tahunInput">
                </div>
            </div>
            <button type="button" id="set"
                class="close-menu btn btn-sm gradient-highlight font-13 btn-sm font-600 rounded-s"
                style="float: right;">Pilih</button>
        </div>
    </div>

    <!-- datepicker modal -->
    <div id="datepicker" class="date-picker menu menu-box-modal rounded-m" data-menu-height="310" data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <!-- Date picker here -->
            <div class="date_header mb-3">
                <span class="title">Tanggal lahir : </span><span class="selection fw-bold"></span>
            </div>

            <div class="d-block w-full">
                <form name="date">
                    <div class="lines"></div>
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
                            <?php for ($i = date('Y', strtotime('-100 years')); $i <= date('Y'); $i++) : ?>
                            <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <button type="button" id="setTanggal"
                        class="close-menu btn-set-tanggal btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s">Pilih</button>
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

    // $(function () {
    //     $("#example").dateDropdowns();
    //     $('input[name="tanggal"]')
    //     .attr("type", "text")
    //     .attr("class", "selection")
    //     .attr("readonly", "readonly");
    // });

    function submit() {
        document.getElementById("myForm").submit();
    }

    $(document).ready(function() {

        // Limit input tanggal hanya 2 digit
        $("#tanggalInput").on("input", function() {
            var inputValue = $(this).val();
            if (inputValue.length > 2) {
                $(this).val(inputValue.slice(0, 2));
            }
        });
        // Limit input tahun hanya 2 digit
        $("#tahunInput").on("input", function() {
            var inputValue = $(this).val();
            if (inputValue.length > 4) {
                $(this).val(inputValue.slice(0, 4));
            }
        });

        function updateTanggal() {
            var tanggalInput = $('#tanggalInput').val();
            if (tanggalInput > 31) {
                $('#tanggalInput').val(31);
                tanggalInput = 31;
            }
            var formattedTanggal = (tanggalInput < 10) ? '0' + tanggalInput : tanggalInput;
            if (tanggalInput < 10) {
                formattedTanggal = '0' + tanggalInput
            } else {
                formattedTanggal = tanggalInput
            }
            if (tanggalInput.substr(0, 1) == '0') {
                formattedTanggal = tanggalInput
            }
            if (tanggalInput == '' || tanggalInput == '00') {
                formattedTanggal = '00'
            }
            $('#tanggal').text(formattedTanggal);
        }

        function updateBulan() {
            var bulanInput = $('#bulanInput').val();
            $('#bulan').text(bulanInput);
        }

        function updateTahun() {
            var tahunInput = $('#tahunInput').val();
            const date = new Date();
            let yearNow = date.getFullYear();
            if (tahunInput > yearNow) {
                $('#tahunInput').val(yearNow);
                tahunInput = yearNow.toString();
            }
            if (tahunInput < 10) {
                formattedTahun = '000' + tahunInput
            } else if (tahunInput < 100) {
                formattedTahun = '00' + tahunInput
            } else if (tahunInput < 1000) {
                formattedTahun = '0' + tahunInput
            } else if (tahunInput.substr(0, 1) == 0) {
                formattedTahun = tahunInput
            } else {
                formattedTahun = tahunInput
            }

            if (tahunInput == '' ||
                tahunInput == '00' ||
                tahunInput == '000' ||
                tahunInput == '0000') {
                formattedTahun = '0000'
            }

            $('#tahun').text(formattedTahun);
        }

        $('#tanggalInput').on('input', updateTanggal);
        $('#bulanInput').on('input', updateBulan);
        $('#tahunInput').on('input', updateTahun);

        updateTanggal();
        updateBulan();
        updateTahun();

        // set tanggal
        $("#set").click(function() {
            var tanggal = $('#tanggal').text();
            var bulan = $('#bulan').text();
            var tahun = $('#tahun').text();
            // Bulan yang cuma punya 30 hari
            if (bulan == '02' ||
                bulan == '04' ||
                bulan == '06' ||
                bulan == '09' ||
                bulan == '11'
            ) {
                if (tanggal == '31') {
                    alert('Tanggal tidak valid!')
                    return;
                }
            }
            //Khusus bulan Februari
            if (bulan == '02') {
                if (tanggal > 29) {
                    alert('Tanggal tidak valid!')
                    return;
                }
                // Pengaturan hari pada tahun kabisat
                if (tahun % 4 != 0) {
                    if (tanggal > 28) {
                        alert('Tanggal tidak valid!')
                        return;
                    }
                }
            }
            if (tahun == '0000') {
                alert('Tahun tidak valid!')
                return;
            }
            if (bulan == '00') {
                alert('Bulan tidak valid!')
                return;
            }
            if (tanggal == '00') {
                alert('Tanggal tidak valid!')
                return;
            }
            if (tahun < '1850') {
                alert('Tahun sudah terlalu lama!')
                return;
            }
            var sourceText = $("#tanggalLahir").text();
            $("#form7").val(sourceText);
        });

        $("#setTanggal").click(function() {
            var sourceText = $(".selection").text();
            $("#form7").val(sourceText);
        });

        $("#form8").autocomplete({
            source: "<?php echo base_url() . 'jamaah/daftar/getTempatLahir'; ?>"
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