<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
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
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/surat_cuti_ban.jpg");
    }
    </style>
</head>

<body class="theme-light">
    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu');?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Surat Cuti</p>
                    <h1>Buat Surat Cuti Jamaah Anda</h1>
                    <p class="mb-3">
                        Isi data <span class="color-highlight font-600" style="font-size: 17px;">
                            <?php echo implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));?></span>
                        dengan benar
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <form role="form" action="<?php echo base_url(); ?>konsultan/req_cuti_konsultan/proses_tambah_cuti"
                        method="post" enctype="multipart/form-data" id="myForm">
                        <input type="hidden" name="id_member" value="<?php echo $_GET['idm']; ?>">
                        <div class="form-group mt-4">
                            <label class="text-danger mb-4">Notes : Jika ada tanda ( * ) diwajibkan</label><br>
                            <label class="color-highlight">Nama Lengkap <strong class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap"
                                    value="<?php echo $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name?>"
                                    required>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em>(required)</em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Jabatan <strong
                                    class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="text" name="jabatan" class="form-control" id="jabatan">
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Keterangan <strong
                                    class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select name="keterangan" id="keterangan">
                                    <option value="izin cuti">Cuti</option>
                                    <option value="izin">Izin Lainnya</option>
                                </select>
                                <!-- <input type="text" name="jabatan" class="form-control" id="jabatan"> -->
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Jenis Nomor Induk <strong
                                    class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <select name="jenis_nomor" id="jenis_nomor">
                                    <option value="">-- Pilih Jenis Nomor Induk --</option>
                                    <option value="NIP">NIP</option>
                                    <option value="NIS">NIS</option>
                                    <option value="NIDN">NIDN</option>
                                    <option value="NIK">NIK</option>
                                    <option value="Other">Nomor Induk Lainnya</option>
                                </select>
                                <input type="text" id="lainnya" name="lainnya" style="display: none;" placeholder="Masukkan Jenis Nomor Induk">
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group mb-3 mt-2">
                            <label class="color-highlight">Nomor Induk <strong
                                    class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon  mb-4">
                                <input type="number" name="nomor_induk" class="form-control" id="nomor_induk">
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Tanggal Mulai (<span
                                    class="text-primary font-italic font-weight-lighter"> dd-mm-yyyy </span>) <strong
                                    class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon">
                                <input name="tanggal_mulai" type="date" class="form-control validate-name upper"
                                    id="form7" value="<?php echo $selectedPaket->tanggal_berangkat ?>">
                                <!-- <a href="#" class="text-dark">
                                </a> -->
                                <!-- <i class="fa fa-check valid color-green-dark"></i> -->
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Tanggal Selesai (<span
                                    class="text-primary font-italic font-weight-lighter"> dd-mm-yyyy </span>) <strong
                                    class="text-danger"> *</strong></label>
                            <div class="input-style no-borders has-icon">
                                <!-- <a href="#" class="text-dark"> -->
                                    <input name="tanggal_selesai" type="date" class="form-control validate-name upper"
                                        id="form8" value="<?php echo $selectedPaket->tanggal_pulang ?>">
                                <!-- </a> -->
                                <!-- <i class="fa fa-check valid color-green-dark"></i> -->
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Kepala Surat <strong class="text-danger"> *</strong>
                                <p class="mb-0">Contoh : </p>
                                <p class="mb-0">Kepada Yth. Bapak Kepala ( Nama Instansi )</p>
                                <p class="mb-0">Bapak ( Nama Kepala Instansi )</p>
                                <p class="mb-0">NIP : ( Nomor Induk Kepala Instansi )</p>
                            </label>
                            <div class="input-style no-borders has-icon">
                                <textarea name="header_surat" id="header_surat" cols="30" rows="10" onkeypress="breakLine();"></textarea>
                                <i class="fa fa-check valid color-green-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-l font-600 font-13 gradient-highlight rounded-s mb-3">Submit</button>
                        <!-- <a href="#" id="submitBtn" data-back-button
                            class="btn btn-l font-600 font-13 gradient-highlight rounded-s mb-3">Submit</a> -->
                    </form>
                </div>
            </div>
        </div>
    </div>


    </div>
    <?php $this->load->view('konsultan/include/alert'); ?>
    <!-- Page content ends here-->

    <!-- Main Menu-->
    <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

    <!-- Share Menu-->
    <div id="menu-share" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>



    <?php $this->load->view('konsultan/include/script_view'); ?>
    <script>
    function breakLine() {
        var key = window.event.keyCode;

        // If the user has pressed enter
        if (key === 13) {
            document.getElementById("header_surat").value = document.getElementById("header_surat").value + "`";
            return false;
        } else {
            return true;
        }
    }


    $(document).ready(function() {

        $('#lainnya').hide();

        $('#jenis_nomor').change(function(){
            if($(this).val() === 'Other') {
                $('#lainnya').show();
            } else {
                $('#lainnya').hide();
            }
        });
        
        $('input').on('input', function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('input').focusout(function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('input').focusin(function() {
            this.value = this.value.toLocaleUpperCase();
        });

        $('textarea').on('textarea', function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('textarea').focusout(function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('textarea').focusin(function() {
            this.value = this.value.toLocaleUpperCase();
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
            source: "getTempatLahir"
        });
        $("#kewarganegaraan").autocomplete({
            source: "getCountries"
        });
    });
    </script>
</body>