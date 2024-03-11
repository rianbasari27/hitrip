<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/default/easyui.css"> -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/easyui-custom/themes/icon.css"> -->
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <!-- <script src="<?php echo base_url(); ?>asset/easyui-custom/jquery.easyui.min.js"></script> -->
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/banner_dokumen.jpg");
    }
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
        <?php $this->load->view('jamaahv2/include/footer_menu');?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Surat Request Anda</p>
                    <h1>Buat Request Surat Rekom</h1>
                    <p class="mb-3">
                        Dokumen untuk <span class="color-highlight font-600" style="font-size: 17px;">
                            <?php echo implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));?>
                        </span>
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <label class="col-form-label">Surat Rekom Imigrasi</label>
                    <div class="col-lg-6">
                        <a href="<?php echo base_url() . "dokum_dl/download?id=" . $jamaah->id_jamaah . "&id=". $dataReq->id_member; ?>"
                            class="btn btn-sm btn-primary rounded-s mb-2">
                            Download Dokumen
                        </a>
                    </div>

                    <label class="col-form-label">Surat Rekom Kemenag</label>
                    <div class="col-lg-6">
                        <a href="<?php echo base_url() . "dokum_dl/download_kemenag?id=" . $jamaah->id_jamaah . "&id=". $dataReq->id_member; ?>"
                            class="btn btn-sm rounded-s btn-primary mb-2">
                            Download Dokumen
                        </a>
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


    <?php $this->load->view('jamaahv2/include/script_view'); ?>
    <script>
    function submit() {
        document.getElementById("myForm").submit();
    }
    $(document).ready(function() {
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

        if (window.innerWidth > 800) {
            $("#datepicker").attr("type", "text");
            $(function() {
                $("#datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: "1940:-nn"
                });
            });
        }

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

        $(".hapusImg").click(function() {
            var id = $(this).attr('rel');
            $.getJSON("<?php echo base_url() . 'jamaah/dokumen/hapus_upload'; ?>", {
                    id_member: "<?php echo $member->id_member; ?>",
                    field: id
                })
                .done(function(json) {
                    alert('File berhasil dihapus');
                    $("#" + id).remove();
                })
                .fail(function(jqxhr, textStatus, error) {
                    alert('File gagal dihapus');
                });

        });

    });
    </script>
</body>