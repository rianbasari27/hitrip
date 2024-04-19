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
                        <h4 class="font-weight-bold py-3 mb-0">Input New Member</h4>
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
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi informasi dengan benar !
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/jamaah/proses_update_peserta"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_user" value="<?php echo $user->id_user;?>">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Pilih Paket Umroh</label>
                                                        <select name="id_paket" id="select_paket" class="form-select">
                                                            <?php foreach ($paket as $pkt) { ?>
                                                            <option value="<?php echo $pkt->id_paket; ?>">
                                                                <?php echo $pkt->nama_paket; ?>
                                                                (<?php echo $this->date->convert_date_indo($pkt->tanggal_berangkat); ?>)
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Tipe Kamar</label>
                                                        <select name="pilihan_kamar" id="select_kamar"
                                                            class="form-select">
                                                            <?php foreach ($paket as $pkt) { ?>
                                                            <?php if (!empty($pkt->harga)) { ?>
                                                            <option
                                                                class="option_kamar kmr-<?php echo $pkt->id_paket; ?>"
                                                                value="Quad">Quad
                                                                (<?php echo 'Rp. ' . number_format($pkt->harga, null, ',', '.') . ',-'; ?>)
                                                            </option>
                                                            <?php } ?>
                                                            <?php if (!empty($pkt->harga_triple)) { ?>
                                                            <option
                                                                class="option_kamar kmr-<?php echo $pkt->id_paket; ?>"
                                                                value="Triple">Triple
                                                                (<?php echo 'Rp. ' . number_format($pkt->harga_triple, null, ',', '.') . ',-'; ?>)
                                                            </option>
                                                            <?php } ?>
                                                            <?php if (!empty($pkt->harga_double)) { ?>
                                                            <option
                                                                class="option_kamar kmr-<?php echo $pkt->id_paket; ?>"
                                                                value="Double">Double
                                                                (<?php echo 'Rp. ' . number_format($pkt->harga_double, null, ',', '.') . ',-'; ?>)
                                                            </option>
                                                            <?php } ?>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nomor Paspor</label>
                                                <input class="form-control" type="number" name="paspor_no">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Paspor</label>
                                                <input class="form-control" type="text" name="paspor_name">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Paspor Issue Date</label>
                                                <input class="form-control datepicker" type="date"
                                                    name="paspor_issue_date">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Paspor Expiry Date</label>
                                                <input class="form-control datepicker" type="date"
                                                    name="paspor_expiry_date">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Paspor Issuing City</label>
                                                <input class="form-control" type="text" name="paspor_issuing_city">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Scan Paspor</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01" name="paspor_scan">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Scan KTP</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01" name="ktp_scan">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Scan Foto</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01" name="foto_scan">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Scan VISA</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01" name="visa_scan">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Scan Vaksin</label>
                                                <div class="input-group mb-3">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input"
                                                            id="inputGroupFile01"
                                                            aria-describedby="inputGroupFileAddon01" name="vaksin_scan">
                                                        <label class="custom-file-label" for="inputGroupFile01">Choose
                                                            file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Sudah Menyerahkan Paspor </label>
                                                <br><input type="radio" name="paspor_check" value="1"> Sudah
                                                <br><input type="radio" name="paspor_check" value="0" checked> Belum
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Sudah Menyerahkan Buku Kuning </label>
                                                <br><input type="radio" name="buku_kuning_check" value="1"> Sudah
                                                <br><input type="radio" name="buku_kuning_check" value="0" checked>
                                                Belum

                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Sudah Menyerahkan Pas Foto </label>
                                                <br><input type="radio" name="foto_check" value="1"> Sudah
                                                <br><input type="radio" name="foto_check" value="0" checked> Belum
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