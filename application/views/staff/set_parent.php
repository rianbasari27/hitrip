<!DOCTYPE html>
<html lang="en">

    <head>
    <link rel="stylesheet" href="<?php echo base_url();?>asset/mycss/combobox.css">
        <?php $this->load->view('staff/include/header_view'); ?>

    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


                <?php $this->load->view('staff/include/side_menu', ['data_jamaah' => true]); ?>

                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        <!-- Topbar -->
                        <?php $this->load->view('staff/include/top_menu'); ?>
                        <!-- End of Topbar -->

                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                            <!-- Page Heading -->
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <h1 class="h3 mb-0 text-gray-800">Pengaturan Link</h1>
                            </div>

                            <!-- Content Row -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow mb-4 bg-warning text-white">
                                        <div class="card-body">
                                            <strong>Nama :</strong> <?php echo $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name; ?><br>
                                            <strong>Paket :</strong> <?php echo $member->paket_info->nama_paket; ?> (<?php echo $member->paket_info->tanggal_berangkat; ?>)
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <!-- Basic Card Example -->
                                    <div class="card shadow mb-4 border-left-primary">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Pilih Akun yang Ingin Dihubungkan</h6>
                                        </div>
                                        <div class="card-body">
                                            <?php if (!empty($_SESSION['alert_type'])) { ?>
                                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                                    <?php echo $_SESSION['alert_message']; ?>
                                                </div>
                                            <?php } ?>
                                            <form role="form" action="<?php echo base_url(); ?>staff/jamaah/proses_set_parent" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="id_member" value="<?php echo $member->id_member; ?>">
                                                <input type="hidden" name="id_jamaah" value="<?php echo $jamaah->id_jamaah; ?>">

                                                <div class="form-group">
                                                    <label class="col-form-label">Peserta Umroh : </label>
                                                    <select name='parent_id' id="combobox" class="form-control">
                                                        <option value='' >&ltKosong&gt</option>
                                                        <?php foreach ($listMember as $lm) { ?>
                                                            <?php if ($lm->id_member == $member->id_member) { ?>
                                                                <?php continue; ?>
                                                            <?php } ?>
                                                        <option value='<?php echo $lm->id_member; ?>' <?php echo $lm->id_member == $parentId ? 'selected':'';?>><?php echo $lm->jamaahData->first_name . ' ' . $lm->jamaahData->second_name . ' ' . $lm->jamaahData->last_name; ?> (No. Paspor: <?php echo $lm->paspor_no; ?>)</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <button class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Submit</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <?php $this->load->view('staff/include/footer'); ?>
                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <?php $this->load->view('staff/include/script_view'); ?>
        <script src="<?php echo base_url();?>asset/myjs/combobox.js"></script>
        <script>
            $(document).ready(function () {

                $(".option_kamar").css("display", "none");
                var selected_paket = $("#select_paket").find(":selected").val();
                $(".kmr-" + selected_paket + ":first").prop("selected", true);
                $(".kmr-" + selected_paket).css("display", "block");

                $("#select_paket").change(function () {
                    $(".option_kamar").css("display", "none");
                    selected_paket = $(this).find(":selected").val();
                    $(".kmr-" + selected_paket).css("display", "block");
                    $(".kmr-" + selected_paket + ":first").prop("selected", true);
                });

                if (window.innerWidth > 800) {
                    $("#datepicker").attr("type", "text");
                    $(function () {
                        $("#datepicker").datepicker({
                            dateFormat: 'yy-mm-dd',
                            changeYear: true,
                            changeMonth: true,
                            yearRange: "1940:-nn"
                        });
                    });
                }

                $("#ktp").blur(function () {
                    $.getJSON("getJamaah", {ktp: $("#ktp").val()}, function (data) {

                    });
                });
                $("#provinsi").change(function () {
                    var provId = $(this).find(":selected").attr('rel');
                    $.getJSON("getRegencies", {provId: provId}, function (data) {
                        $('#kabupaten').find('option').remove();
                        $('#kecamatan').find('option').remove();
                        populateDistrict(data[0]['id']);
                        $(data).each(function (index, item) {
                            $('#kabupaten').append('<option value="' + item['name'] + '" rel="' + item['id'] + '">' + item['name'] + '</option>');
                        });
                    });
                });

                $("#kabupaten").change(function () {
                    var regId = $(this).find(":selected").attr('rel');
                    populateDistrict(regId);

                });

                function populateDistrict(regId) {
                    $.getJSON("getDistricts", {regId: regId}, function (data) {
                        $('#kecamatan').find('option').remove();
                        $(data).each(function (index, item) {
                            $('#kecamatan').append('<option value="' + item['name'] + '">' + item['name'] + '</option>');
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

</html>






