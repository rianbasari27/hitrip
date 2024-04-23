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
            <?php $this->load->view('staff/include/side_menu', ["manifest" => true, "data_user" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Detail Informasi User</h4>
                        <!-- <div class='row'>
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get" action="<?php echo base_url(); ?>staff/paket">
                                            <div class="form-group">
                                                <select name="month" class="form-control">
                                                    <option value="0">Lihat Semua</option>
                                                    <?php foreach ($monthPackage as $m) { ?>
                                                    <option
                                                        value="<?php echo date('m', strtotime($m->tanggal_berangkat))?>"
                                                        <?php echo date('m', strtotime($m->tanggal_berangkat)) == $month ? 'selected' : ''; ?>>
                                                        <?php echo $this->date->convert('F', $m->tanggal_berangkat); ?>
                                                    </option>
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

                        </div> -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Profil User</h6>
                                        <span id="btnUpdateProfile" class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/jamaah/update_data?id=<?php echo $id_user; ?>"
                                                class="btn btn-primary btn-icon-split btn-xs rounded-xs">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Update Data</span>
                                            </a>
                                            <?php if (!$member) { ?>
                                            <a href="<?php echo base_url(); ?>staff/jamaah/add_member?id=<?php echo $id_user; ?>"
                                                class="btn btn-warning btn-icon-split btn-xs rounded-xs">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Input Program</span>
                                            </a>
                                            <?php } else if ($member[0]->paket_info->tanggal_berangkat < date('Y-m-d'))  { ?>
                                            <a href="<?php echo base_url(); ?>staff/jamaah/add_member?id=<?php echo $id_user; ?>"
                                                class="btn btn-warning btn-icon-split btn-xs rounded-xs">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Input Program</span>
                                            </a>
                                            <?php } ?>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Nama</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $name; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor KTP</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $no_ktp; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Email</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $email; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">No WhatsApp</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $no_wa; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tempat Lahir</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $tempat_lahir; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tanggal Lahir (<span
                                                    class="text-primary font-italic font-weight-lighter">yyyy-mm-dd</span>)</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $tanggal_lahir; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Jenis Kelamin</label>
                                            <input disabled class="form-control" type="text" value="<?php
                                                                                                    echo $jenis_kelamin == 'L' ? 'Laki-laki' : '';
                                                                                                    echo $jenis_kelamin == 'P' ? 'Perempuan' : ''
                                                                                                    ?>">
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
</body>

</html>