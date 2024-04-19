<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
    /* Style untuk input form */
    .form-control {
        border: none;
        border-radius: 0;
        border-bottom: 1px solid #ced4da;
        /* warna garis bawah */
    }

    /* Style untuk input form yang aktif/fokus */
    .form-control:focus {
        box-shadow: none;
        border-color: #80bdff;
        /* warna garis bawah saat aktif */
    }
    </style>
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <?php $this->load->view('staff/include/side_menu', ["manifest" => true, "data_peserta" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Detail Peserta</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-2 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Detail Informasi User
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table>
                                            <tr>
                                                <th>Nama User</th>
                                                <th>: </th>
                                                <th><?php echo $user->name ;?></th>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <th>: </th>
                                                <th><?php echo $user->email ;?></th>
                                            </tr>
                                            <tr>
                                                <th>No WhatsApp</th>
                                                <th>: </th>
                                                <th><?php echo $user->no_wa ;?></th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Detail Informasi Peserta</h6>
                                        <span id="btnUpdateProfile" class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/jamaah/update_member?idm=<?php echo $member->id_member; ?>"
                                                class="btn btn-warning btn-icon-split btn-xs rounded-xs">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Update Data</span>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor Paspor</label>
                                            <input disabled class="form-control" type="number" name="paspor_no">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nama Paspor</label>
                                            <input disabled class="form-control" type="text" name="paspor_name">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Paspor Issue Date</label>
                                            <input disabled class="form-control datepicker" type="date"
                                                name="paspor_issue_date">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Paspor Expiry Date</label>
                                            <input disabled class="form-control datepicker" type="date"
                                                name="paspor_expiry_date">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Paspor Issuing City</label>
                                            <input disabled class="form-control" type="text" name="paspor_issuing_city">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Scan Paspor</label>
                                            <div class="input-group mb-3">
                                                <?php if (!empty($member->paspor_scan)) { ?>
                                                <a href="<?php echo base_url() . $member->paspor_scan; ?>" onclick="window.open('<?php echo base_url() . $member->paspor_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                    <img src="<?php echo base_url() . $member->paspor_scan; ?>"
                                                        style="width:auto; height:120px">

                                                </a>
                                                <?php } else { ?>
                                                <span class="btn btn-xs rounded-xs btn-danger btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Scan KTP</label>
                                            <div class="input-group mb-3">
                                                <?php if (!empty($member->ktp_scan)) { ?>
                                                <a href="<?php echo base_url() . $member->ktp_scan; ?>" onclick="window.open('<?php echo base_url() . $member->ktp_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                    <img src="<?php echo base_url() . $member->ktp_scan; ?>"
                                                        style="width:auto; height:120px">

                                                </a>
                                                <?php } else { ?>
                                                <span class="btn btn-xs rounded-xs btn-danger btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Scan Foto</label>
                                            <div class="input-group mb-3">
                                                <?php if (!empty($member->foto_scan)) { ?>
                                                <a href="<?php echo base_url() . $member->foto_scan; ?>" onclick="window.open('<?php echo base_url() . $member->foto_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                    <img src="<?php echo base_url() . $member->foto_scan; ?>"
                                                        style="width:auto; height:120px">

                                                </a>
                                                <?php } else { ?>
                                                <span class="btn btn-xs rounded-xs btn-danger btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Scan VISA</label>
                                            <div class="input-group mb-3">
                                                <?php if (!empty($member->visa_scan)) { ?>
                                                <a href="<?php echo base_url() . $member->visa_scan; ?>" onclick="window.open('<?php echo base_url() . $member->visa_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                    <img src="<?php echo base_url() . $member->visa_scan; ?>"
                                                        style="width:auto; height:120px">

                                                </a>
                                                <?php } else { ?>
                                                <span class="btn btn-xs rounded-xs btn-danger btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Sudah Menyerahkan Paspor </label>
                                            <div class="input-group mb-3">
                                                <?php if ($member->paspor_check == 1) { ?>
                                                <span class="btn btn-xs rounded-xs btn-success btn-circle">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <?php } else { ?>
                                                <span class="btn btn-xs rounded-xs btn-danger btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Sudah Menyerahkan Buku Kuning </label>
                                            <div class="input-group mb-3">
                                                <?php if ($member->buku_kuning_check == 1) { ?>
                                                <span class="btn btn-xs rounded-xs btn-success btn-circle">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <?php } else { ?>
                                                <span class="btn btn-xs rounded-xs btn-danger btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?php } ?>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Sudah Menyerahkan Pas Foto </label>
                                            <div class="input-group mb-3">
                                                <?php if ($member->foto_check == 1) { ?>
                                                <span class="btn btn-xs rounded-xs btn-success btn-circle">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <?php } else { ?>
                                                <span class="btn btn-xs rounded-xs btn-danger btn-circle">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ content ] End -->

                    <?php $this->load->view('staff/include/footer_view') ?>
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <?php $this->load->view('staff/include/script_view') ?>
    <script>
    $(document).ready(function() {
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
    })
    </script>
</body>

</html>