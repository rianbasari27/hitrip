<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
    .theme-dark label {
        background-color: #4a89dc !important;
    }

    input[type="date"]::-webkit-calendar-picker-indicator {
        opacity: 0;
        /* Sembunyikan ikon tapi tetap bisa di-klik */
        cursor: pointer;
        /* Tampilkan pointer saat hover */
    }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['profile' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">
            <div class="card card-style">
                <div class="content mb-0">
                    <div class="mt-1 mb-3">
                        <h5>Update kelengkapan program</h5>
                        <label class="text-danger mb-4">Notes : Jika ada tanda ( * ) diwajibkan</label>
                        <form action="<?php echo base_url() ?>jamaah/profile/proses_edit_data"
                            enctype="multipart/form-data" type="multipart" method="post">
                            <input type="hidden" name="id_member" value="<?php echo $id_member ?>">
                            <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                            <input type="hidden" name="id_paket" value="<?php echo $id_paket ?>">
                            <label for="paspor_name" class="color-highlight">Nama Paspor</label>
                            <div class="input-style has-borders validate-field mb-4">
                                <input type="text" name="paspor_name" class="form-control validate-name"
                                    value="<?php echo $paspor_name != null ? $paspor_name : set_value('paspor_name') ?>"
                                    id="paspor_name" placeholder="Nama Paspor">
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="mt-n2 mb-3"><?php echo form_error('paspor_name') ?></div>

                            <label for="paspor_no" class="color-highlight">No Paspor</label>
                            <div class="input-style has-borders validate-field mb-4">
                                <input type="text" name="paspor_no" class="form-control validate-name"
                                    value="<?php echo $paspor_no != null ? $paspor_no : set_value('paspor_no') ?>"
                                    id="paspor_no" placeholder="No Paspor">
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="mt-n2 mb-3"><?php echo form_error('paspor_no') ?></div>

                            <label for="paspor_issuing_city" class="color-highlight">Kota Pembuatan Paspor</label>
                            <div class="input-style has-borders validate-field mb-4">
                                <input type="text" name="paspor_issuing_city" class="form-control validate-name"
                                    value="<?php echo $paspor_issuing_city != null ? $paspor_issuing_city : set_value('paspor_issuing_city') ?>"
                                    id="paspor_issuing_city" placeholder="Kota Pembuatan Paspor">
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="mt-n2 mb-3"><?php echo form_error('paspor_issuing_city') ?></div>

                            <label for="paspor_issue_date" class="color-highlight">Tanggal berlaku paspor</label>
                            <div class="input-style has-borders validate-field mb-4">
                                <input type="date" name="paspor_issue_date" class="form-control"
                                    value="<?php echo $paspor_issue_date != null ? $paspor_issue_date : set_value('paspor_issue_date') ?>"
                                    id="paspor_issue_date" placeholder="Tanggal berlaku paspor">
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em></em>
                            </div>
                            <div class="mt-n2 mb-3"><?php echo form_error('paspor_issue_date') ?></div>

                            <label for="paspor_expiry_date" class="color-highlight">Tanggal berakhir paspor</label>
                            <div class="input-style has-borders validate-field mb-4">
                                <input type="date" name="paspor_expiry_date" class="form-control"
                                    value="<?php echo $paspor_expiry_date != null ? $paspor_expiry_date : set_value('paspor_expiry_date') ?>"
                                    id="paspor_expiry_date" placeholder="Tanggal berakhir paspor">
                                <!-- <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i> -->
                                <em></em>
                            </div>
                    </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="content">
                    <h5 class="mb-2">Upload Dokumen</h5>
                    <div class="mb-4">
                        <label for="paspor_scan" class="color-highlight">Scan Paspor</label>
                        <div class="input-style has-borders validate-field mb-3 d-flex align-items-center">
                            <input type="file" name="paspor_scan" class="form-control" id="paspor_scan">
                            <em></em>
                            <?php if (!empty($paspor_scan)) { ?>
                            <div class="image-preview ms-3">
                                <!-- Gunakan ms-3 untuk margin start -->
                                <a href="<?php echo base_url($paspor_scan); ?>" title="Scan Paspor" class="default-link"
                                    data-gallery="gallery-1">
                                    <img src="<?php echo base_url($paspor_scan); ?>" alt="Gambar Paspor"
                                        style="max-width: 150px; height: auto; cursor: pointer;">
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('paspor_scan') ?></div>
                    </div>
                    <div class="mb-4">
                        <label for="ktp_scan" class="color-highlight">Scan KTP</label>
                        <div class="input-style has-borders validate-field mb-3 d-flex align-items-center">
                            <input type="file" name="ktp_scan" class="form-control" id="ktp_scan">
                            <em></em>
                            <?php if (!empty($ktp_scan)) { ?>
                            <div class="image-preview ms-3">
                                <!-- Gunakan ms-3 untuk margin start -->
                                <a href="<?php echo base_url($ktp_scan); ?>" title="Scan Paspor" class="default-link"
                                    data-gallery="gallery-1">
                                    <img src="<?php echo base_url($ktp_scan); ?>" alt="Gambar Paspor"
                                        style="max-width: 150px; height: auto; cursor: pointer;">
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('ktp_scan') ?></div>
                    </div>
                    <div class="mb-4">
                        <label for="foto_scan" class="color-highlight">Scan Foto</label>
                        <div class="input-style has-borders validate-field mb-3 d-flex align-items-center">
                            <input type="file" name="foto_scan" class="form-control" id="foto_scan">
                            <em></em>
                            <?php if (!empty($foto_scan)) { ?>
                            <div class="image-preview ms-3">
                                <!-- Gunakan ms-3 untuk margin start -->
                                <a href="<?php echo base_url($foto_scan); ?>" title="Scan Paspor" class="default-link"
                                    data-gallery="gallery-1">
                                    <img src="<?php echo base_url($foto_scan); ?>" alt="Gambar Paspor"
                                        style="max-width: 150px; height: auto; cursor: pointer;">
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('foto_scan') ?></div>
                    </div>
                    <div class="mb-4">
                        <label for="kk_scan" class="color-highlight">Scan KK</label>
                        <div class="input-style has-borders validate-field mb-3 d-flex align-items-center">
                            <input type="file" name="kk_scan" class="form-control" id="kk_scan">
                            <em></em>
                            <?php if (!empty($kk_scan)) { ?>
                            <div class="image-preview ms-3">
                                <!-- Gunakan ms-3 untuk margin start -->
                                <a href="<?php echo base_url($kk_scan); ?>" title="Scan Paspor" class="default-link"
                                    data-gallery="gallery-1">
                                    <img src="<?php echo base_url($kk_scan); ?>" alt="Gambar Paspor"
                                        style="max-width: 150px; height: auto; cursor: pointer;">
                                </a>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('kk_scan') ?></div>
                    </div>
                    <button type="submit"
                        class="btn btn-s rounded-pill shadow-xl text-uppercase font-700 bg-highlight mb-3 mt-3">Simpan</button>
                    </form>
                </div>
            </div>

            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
            <?php $this->load->view('jamaah/include/toast'); ?>
        </div>
        <!-- Page content ends here-->

        <div id="insertimageModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content rounded-m">
                    <div class="modal-header">
                        <h4 class="modal-title">Ganti Profile Anda</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 text-center">
                                <div id="image_demo" style="width:350px; margin-top:30px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn rounded btn-success crop_image">Save</button>
                        <button type="button" class="btn rounded btn-danger btn-default close"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


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


    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
    <script>
    </script>
</body>