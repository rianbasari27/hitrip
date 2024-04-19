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
            <?php $this->load->view('staff/include/side_menu', ["produk" => true, "list_produk" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Update Peserta</h4>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/jamaah/proses_update_peserta"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <input type="hidden" name="id_user" value="<?php echo $member->id_user; ?>">
                                            <input type="hidden" name="id_paket"
                                                value="<?php echo $member->id_paket; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Pilihan Kamar</label>
                                                <select class="form-select" name="pilihan_kamar">
                                                    <?php foreach ($kamarOption as $ko) { ?>
                                                    <option value="<?php echo $ko; ?>"
                                                        <?php echo $member->pilihan_kamar == $ko ? 'selected' : ''; ?>>
                                                        <?php echo $ko; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Paspor</label>
                                                <input class="form-control" type="text" name="paspor_no"
                                                    value="<?php echo $member->paspor_no; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Paspor</label>
                                                <input class="form-control" type="text" name="paspor_name"
                                                    value="<?php echo $member->paspor_name; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Paspor Issue Date</label>
                                                <input class="form-control datepicker" type="date"
                                                    name="paspor_issue_date"
                                                    value="<?php echo $member->paspor_issue_date; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Paspor Expiry Date</label>
                                                <input class="form-control datepicker" type="date"
                                                    name="paspor_expiry_date"
                                                    value="<?php echo $member->paspor_expiry_date; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Paspor Issuing City</label>
                                                <input class="form-control" type="text" name="paspor_issuing_city"
                                                    value="<?php echo $member->paspor_issuing_city; ?>">
                                            </div>
                                            <label class="col-form-label">Scan Paspor</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->paspor_scan == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="paspor_scan">
                                                                    <a href="<?php echo base_url() . $member->paspor_scan; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->paspor_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->paspor_scan; ?>"
                                                                            style="width:auto; height:150px">
                                                                    </a>
                                                                    <a rel="paspor_scan" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="paspor_scan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <label class="col-form-label">Scan Paspor 2 ( Jika ada )</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->paspor_scan2 == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="paspor_scan2">
                                                                    <a href="<?php echo base_url() . $member->paspor_scan2; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->paspor_scan2; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->paspor_scan2; ?>"
                                                                            style="width:auto; height:150px">
                                                                    </a>
                                                                    <a rel="paspor_scan2" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="paspor_scan2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <label class="col-form-label">Scan KTP</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->ktp_scan == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="ktp_scan">
                                                                    <a href="<?php echo base_url() . $member->ktp_scan; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->ktp_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->ktp_scan; ?>"
                                                                            style="width:auto; height:150px">
                                                                    </a>
                                                                    <a rel="ktp_scan" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="ktp_scan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label">Scan Foto</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->foto_scan == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="foto_scan">
                                                                    <a href="<?php echo base_url() . $member->foto_scan; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->foto_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->foto_scan; ?>"
                                                                            style="width:auto; height:150px">
                                                                    </a>
                                                                    <a rel="foto_scan" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="foto_scan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label">Scan VISA</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->visa_scan == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="visa_scan">
                                                                    <a href="<?php echo base_url() . $member->visa_scan; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->visa_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->visa_scan; ?>"
                                                                            style="width:auto; height:150px">
                                                                    </a>
                                                                    <a rel="visa_scan" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="visa_scan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <label class="col-form-label">Scan KK</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->kk_scan == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="kk_scan">
                                                                    <a href="<?php echo base_url() . $member->kk_scan; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->kk_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->kk_scan; ?>"
                                                                            style="width:auto; height:150px"
                                                                            alt="download here">
                                                                    </a>
                                                                    <a rel="kk_scan" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="kk_scan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <label class="col-form-label">Scan Tiket</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->tiket_scan == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="tiket_scan">
                                                                    <a href="<?php echo base_url() . $member->tiket_scan; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->tiket_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->tiket_scan; ?>"
                                                                            style="width:auto; height:150px"
                                                                            alt="download here">
                                                                    </a>
                                                                    <a rel="tiket_scan" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="tiket_scan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <label class="col-form-label">Scan Vaksin</label>
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <?php if ($member->vaksin_scan == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="vaksin_scan">
                                                                    <a href="<?php echo base_url() . $member->vaksin_scan; ?>"
                                                                        onclick="window.open('<?php echo base_url() . $member->vaksin_scan; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $member->vaksin_scan; ?>"
                                                                            style="width:auto; height:150px">
                                                                    </a>
                                                                    <a rel="vaksin_scan" href="javascript:void(0);"
                                                                        class="btn btn-danger btn-icon-split btn-sm hapusImg">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                            </center>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="vaksin_scan">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <label class="col-form-label">Sudah Menyerahkan Paspor </label>
                                                <br><input type="radio" name="paspor_check" value="1"
                                                    <?php echo $member->paspor_check == 1 ? 'checked' : ''; ?>> Sudah
                                                <br><input type="radio" name="paspor_check" value="0"
                                                    <?php echo $member->paspor_check != 1 ? 'checked' : ''; ?>> Belum
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Sudah Menyerahkan Buku Kuning </label>
                                                <br><input type="radio" name="buku_kuning_check" value="1"
                                                    <?php echo $member->buku_kuning_check == 1 ? 'checked' : ''; ?>>
                                                Sudah
                                                <br><input type="radio" name="buku_kuning_check" value="0"
                                                    <?php echo $member->buku_kuning_check != 1 ? 'checked' : ''; ?>>
                                                Belum

                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Sudah Menyerahkan Pas Foto </label>
                                                <br><input type="radio" name="foto_check" value="1"
                                                    <?php echo $member->foto_check == 1 ? 'checked' : ''; ?>> Sudah
                                                <br><input type="radio" name="foto_check" value="0"
                                                    <?php echo $member->foto_check != 1 ? 'checked' : ''; ?>> Belum
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