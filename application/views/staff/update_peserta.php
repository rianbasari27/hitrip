<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
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
                            <h1 class="h3 mb-0 text-gray-800">Update Kelengkapan Peserta</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/jamaah/proses_update_peserta"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <input type="hidden" name="id_jamaah"
                                                value="<?php echo $member->id_jamaah; ?>">
                                            <input type="hidden" name="id_paket"
                                                value="<?php echo $member->id_paket; ?>">
                                            <?php if ($member->id_agen != null) { ?>
                                                <div class="ui-widget">
                                                <label>Nama Konsultan</label><br>
                                                <select id="combobox" name="id_agen">
                                                    <option value="">Pilih Salah Satu...</option>
                                                    <?php foreach ($agenList as $ag) { ?>
                                                    <option value="<?php echo $ag->id_agen; ?>"
                                                        <?php echo $member->id_agen == $ag->id_agen ? 'selected' : ''; ?>><?php echo $ag->nama_agen; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="col-form-label">Pilihan Kamar</label>
                                                <select class="form-control" name="pilihan_kamar">
                                                    <?php foreach ($kamarOption as $ko) { ?>
                                                    <option value="<?php echo $ko; ?>"
                                                        <?php echo $member->pilihan_kamar == $ko ? 'selected' : ''; ?>>
                                                        <?php echo $ko; ?></option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pernah Umroh dalam 3 Tahun Terakhir
                                                </label>
                                                <br><input type="radio" name="pernah_umroh" value="1"
                                                    <?php echo $member->pernah_umroh == 1 ? 'checked' : ''; ?>> Pernah
                                                <br><input type="radio" name="pernah_umroh" value="0"
                                                    <?php echo $member->pernah_umroh != 1 ? 'checked' : ''; ?>> Belum
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
                                            <label class="col-form-label">Scan Paspor 2 ( Jika ada )</label>
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
                                            </div>
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
                                            <label class="col-form-label">Scan KK</label>
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
                                            </div>
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
                                            <label class="col-form-label">Scan Vaksin</label>
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
                                            </div>
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
    <script src="<?php echo base_url(); ?>asset/myjs/combobox.js"></script>
    <script>
    $(document).ready(function() {

        if (window.innerWidth > 800) {
            $("#datepicker").attr("type", "text");
            $(function() {
                $(".datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: "-20:+20"
                });
            });
        }
        $(".hapusImg").click(function() {
            var id = $(this).attr('rel');
            $.getJSON("<?php echo base_url(); ?>staff/jamaah/hapus_upload", {
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
        $("#agenComplete").autocomplete({
            source: function(request, response) {
                $.getJSON("<?php echo base_url(); ?>staff/jamaah/agen_autocomplete", {
                        r: request
                    })
                    .done(function(json) {
                        response(json);
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        alert('Agen gagal di load');
                    });
            }
        });
    });
    </script>
</body>

</html>