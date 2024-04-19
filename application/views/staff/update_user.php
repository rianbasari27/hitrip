<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>

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
                        <h4 class="font-weight-bold py-3 mb-0">Update Informasi User</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi Informasi dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo base_url() . 'staff/jamaah/proses_update' ;?>"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_user" value="<?php echo $id_user ;?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama</label>
                                                <input class="form-control" type="text" name="name"
                                                    value="<?php echo $name; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor KTP</label>
                                                <input class="form-control" type="text" name="no_ktp"
                                                    value="<?php echo $no_ktp; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Email</label>
                                                <input class="form-control" type="text" name="email"
                                                    value="<?php echo $email; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">No WhatsApp</label>
                                                <input class="form-control" type="text" name="no_wa"
                                                    value="<?php echo $no_wa; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir</label>
                                                <input class="form-control" name="tempat_lahir" type="text"
                                                    value="<?php echo $tempat_lahir; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir</label>
                                                <input class="form-control" name="tanggal_lahir" type="date"
                                                    value="<?php echo $tanggal_lahir; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" class="form-control" id="">
                                                    <option value="L"
                                                        <?php echo $jenis_kelamin == "L" ? 'selected' :'' ;?>>
                                                        Laki-Laki</option>
                                                    <option value="P"
                                                        <?php echo $jenis_kelamin == "P" ? 'selected' :'' ;?>>
                                                        Perempuan</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-xs btn-primary btn-icon-split rounded-xs mt-4">
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