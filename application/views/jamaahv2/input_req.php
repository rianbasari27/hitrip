<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/default/easyui.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/icon.css"> -->
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>asset/easyui-custom/jquery.easyui.min.js"></script> -->

    <!-- add for datepicker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.fakemultitouch.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/datepicker/lib/drum.css">
    <script src="<?php echo base_url(); ?>asset/datepicker/lib/drum.js"></script>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/request_ban.jpg");
    }

    /* CSS for datepicker */
    .date-picker {
        background-color: white !important;
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

    #drum_date,
    #drum_hours,
    #drum_minutes {
        width: 40px;
        font-size: 18px;
    }

    #drum_hours {
        margin-left: 10px;
    }

    #drum_minutes {
        margin-left: 4px;
    }

    #drum_month {
        width: 110px;
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
        <?php if ($jamaah->tanggal_lahir != null) { ?>
        <?php if ($jamaah->tanggal_lahir != 0000-00-00) { ?>
        update(new Date("<?php echo $jamaah->tanggal_lahir;?>"));
        <?php } else { ?>
        update(new Date());
        <?php } ?>
        <?php } else { ?>
        update(new Date());
        <?php } ?>
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
        <?php $this->load->view('jamaahv2/include/footer_menu');?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Request Dokumen</p>
                    <h1>Buat Surat Request Anda</h1>
                    <p class="mb-3">
                        Isi data <span class="color-highlight font-600" style="font-size: 17px;">
                            <?php echo implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));?></span>
                        dengan benar
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <form role="form" action="<?php echo base_url(); ?>jamaah/req_dokumen/proses_input_req"
                        method="post" enctype="multipart/form-data" id="myForm">
                        <input type="hidden" name="id_request" value="<?php echo null; ?>">
                        <input type="hidden" name="id_member" value="<?php echo $_GET['idm']; ?>">
                        <div class="form-group mt-4">
                            <label class="text-danger mb-4">Notes : Jika ada tanda ( * ) diwajibkan</label><br>
                            <label class="color-highlight">Nama Lengkap <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap"
                                    value="<?php echo implode(" ", array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));?>"
                                    required>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Tambah Nama<span
                                    class="text-primary font-italic font-weight-lighter"> ( Tidak Boleh
                                    Kosong ) </span></label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="radio1" name="tambah_nama" value="1">
                                <label class="form-check-label font-600" for="radio1"
                                    style="font-size: 12px;">Iya</label>
                                <em></em>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tambah_nama" id='radio2' value="0"
                                    checked>
                                <label class="form-check-label font-600" for="radio2"
                                    style="font-size: 12px;">Tidak</label>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Nama Paket</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="nama_paket" class="form-control" id="nama_paket"
                                    value="<?php echo $member[0]->paket_info->nama_paket?>" readonly>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Tempat Lahir <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="tempat_lahir" class="form-control" id="tempatLahir"
                                    value="<?php echo $jamaah->tempat_lahir?>">
                                <i
                                    class="fa fa-check <?php echo $jamaah->tempat_lahir == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Tanggal Lahir (<span
                                    class="text-primary font-italic font-weight-lighter"> dd-mm-yyyy </span>) <strong
                                    class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon">
                                <a href="#" data-menu="datepicker" class="text-dark">
                                    <input name="tanggal_lahir" type="date" class="form-control validate-name upper"
                                        id="form7" readonly value="<?php echo $jamaah->tanggal_lahir; ?>">
                                </a>
                                <i
                                    class="fa fa-check <?php echo $jamaah->tanggal_lahir == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <div class="input-style no-borders has-icon">
                                <input type="hidden" name="tgl_request" class="form-control" value="" readonly>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">NIK <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="number" name="no_ktp" class="form-control" id="ktp_no"
                                    value="<?php echo $jamaah->ktp_no; ?>" required>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                        </div>
                        <!-- <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Kantor Imigrasi</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="imigrasi_tujuan" id="imigrasi_tujuan" class="form-control"
                                    placeholder="Contoh : Kelas I TPI Depok" value="" id="kantorImigrasi">
                                <em></em>
                            </div>
                        </div> -->
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Kantor Imigrasi <strong class="text-danger"> *</strong> 
                                <span class="text-success d-none font-italic font-weight-lighter" id="ttd_basah">(Wajib tanda tangan basah.)</span>
                            </label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="imigrasi_tujuan" class="form-control" id="kantorImigrasi"
                                    value="">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Kantor Kemenag</label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="kemenag_tujuan" id="kemenag_tujuan" class="form-control"
                                    placeholder="Contoh : Kota Depok / Kabupaten Bogor" value="">
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <input type="hidden" name="nama_2_suku" id="nama_2_suku" value="">
                            <input type="hidden" name="status" value="0">
                        </div>
                        <button type="submit"
                            class="btn btn-sm font-600 font-13 gradient-highlight mt-4 rounded-s mb-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
    <?php $this->load->view('jamaahv2/include/alert'); ?>
    <!-- Page content ends here-->

    <!-- Main Menu-->
    <div id="menu-main" class="menu menu-box-left rounded-0"
        data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
        data-menu-active="nav-request"></div>

    <!-- Share Menu-->
    <div id="menu-share" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <!-- datepicker modal -->
    <div id="datepicker" class="date-picker menu menu-box-modal rounded-m" data-menu-height="280" data-menu-width="350">
        <div class="menu-title mb-0">
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
                            <option value="<?php echo $i?>"
                                <?php echo (date('d', strtotime($jamaah->tanggal_lahir)) == $i) ? 'selected': '' ;?>>
                                <?php echo $i?>.</option>
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


    <?php $this->load->view('jamaahv2/include/script_view'); ?>
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

    $(document).ready(function() {
        var x = $("#form7").val();
        console.log(x);
        // set tanggal
        $("#setTanggal").click(function() {
            var sourceText = $(".selection").text();
            $("#form7").val(sourceText);
        });

        $('#submitBtn').on("click", function(event) {
            $("#myForm").submit();
        });
        $("#ui-button").on("click", function(event) {
            event.preventDefault();
            alert('clicked');
        });

        $(".option_kamar").css("display", "none");
        var selected_paket = $("#select_paket").find(":selected").val();
        $(".kmr-" + selected_paket + ":first").prop("selected", true);
        $(".kmr-" + selected_paket).css("display", "block");

        $("#select_paket").change(function() {
            $(".option_kamar").css("display", "none");
            selected_paket = $(this).find(":selected").val();
            $(".kmr-" + selected_paket).css("display", "block");
            $(".kmr-" + selected_paket + ":first").prop("selected", true);
        });

        // if (window.innerWidth > 800) {
        //     $("#datepicker").attr("type", "text");
        //     $(function() {
        //         $("#datepicker").datepicker({
        //             dateFormat: 'yy-mm-dd',
        //             changeYear: true,
        //             changeMonth: true,
        //             yearRange: "1940:-nn"
        //         });
        //     });
        // }

        // $("#ktp").blur(function() {
        //     $.getJSON("getJamaah", {
        //         ktp: $("#ktp").val()
        //     }, function(data) {

        //     });
        // });
        $("#provinsi").change(function() {
            var provId = $(this).find(":selected").attr('rel');
            $.getJSON("getRegencies", {
                provId: provId
            }, function(data) {
                $('#kabupaten').find('option').remove();
                $('#kecamatan').find('option').remove();
                populateDistrict(data[0]['id']);
                $(data).each(function(index, item) {
                    $('#kabupaten').append('<option value="' + item['name'] +
                        '" rel="' + item['id'] + '">' + item['name'] + '</option>');
                });
            });
        });

        $("#kabupaten").change(function() {
            var regId = $(this).find(":selected").attr('rel');
            populateDistrict(regId);

        });

        function populateDistrict(regId) {
            $.getJSON("getDistricts", {
                regId: regId
            }, function(data) {
                $('#kecamatan').find('option').remove();
                $(data).each(function(index, item) {
                    $('#kecamatan').append('<option value="' + item['name'] + '">' + item[
                        'name'] + '</option>');
                });
            });
        }

        $("#tempatLahir").autocomplete({
            source: "<?php echo base_url() . 'jamaah/req_dokumen/getTempatLahir'; ?>"
        });
        $("#kantorImigrasi").autocomplete({
            source: "<?php echo base_url() . 'jamaah/req_dokumen/getImigrasi'; ?>",
            change: function(event, ui) {
                var kantor = $(this).val();
                $.getJSON("<?php echo base_url() . 'jamaah/req_dokumen/getImigrasiId';?>", {
                    namaKantor: kantor,
                }).done(function(json) {
                    // console.log("berhasil");
                    // $('#ttd_basah').append('(Wajib tanda tangan basah.)');
                    $('#ttd_basah').removeClass('d-none');
                    alert('Wajib tanda tangan basah. Silahkan datang ke kantor untuk meminta tanda tangan basah.')
                })
                .fail(function(jqxhr, textStatus, error) {
                    // console.log(textStatus);
                    $('#ttd_basah').addClass('d-none');

                });
            }
        });
        $("#kewarganegaraan").autocomplete({
            source: "getCountries"
        });

        // $('#combobox').keypress(function() {
        //     var dInput = this.value;
        //     console.log(dInput);
        //     // $(".dDimension:contains('" + dInput + "')").css("display","block");
        // });

    });
    </script>
</body>