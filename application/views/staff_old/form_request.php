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


            <?php $this->load->view('staff/include/side_menu'); ?>

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <?php $this->load->view('staff/include/top_menu', ['request_dokumen' => true]); ?>
                    <!-- End of Topbar -->

                    <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Request Dokumen</h1>
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
                                            action="<?php echo base_url(); ?>staff/input_dokumen/proses_input_req"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_request" value=" <?php echo null ?>">
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member[0]->id_member; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Lengkap</label>
                                                <input class="form-control" type="text" name="nama_lengkap"
                                                    value="<?php echo implode(" ", array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tambah Nama (<span
                                                        class="text-primary font-italic font-weight-lighter">Tidak Boleh
                                                        Kosong</span>)</label>
                                                <br><input type="radio" name="tambah_nama" value="1"> Iya &nbsp;
                                                &nbsp;<input type="radio" name="tambah_nama" value="0" checked> Tidak
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Paket</label>
                                                <input class="form-control" type="text" name="nama_paket"
                                                    value="<?php echo $member[0]->paket_info->nama_paket?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir</label>
                                                <input class="form-control" type="text" name="tempat_lahir"
                                                    id="tempat_lahir" placeholder="Contoh : Kota Jakarta"
                                                    value="<?php echo $jamaah->tempat_lahir ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir </label>
                                                <input class="form-control" type="date" name="tanggal_lahir"
                                                    id="tanggal_lahir" value="<?php echo $jamaah->tanggal_lahir ?>"
                                                    autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">NIK</label>
                                                <input class="form-control" type="text" name="no_ktp" id="no_ktp"
                                                    placeholder="Contoh : 3210123456789"
                                                    value="<?php echo $jamaah->ktp_no; ?>" autocomplete="off">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Request </label>
                                                <input class="form-control" type="text" name="tgl_request"
                                                    value="<?php echo date('Y-m-d H:i:s');?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kantor Imigrasi</label>
                                                <input class="form-control" type="text" name="imigrasi_tujuan"
                                                    id="imigrasi_tujuan" placeholder="Contoh : Jakarta" value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kantor Kementrian Agama</label>
                                                <input class="form-control" type="text" name="kemenag_tujuan"
                                                    id="kemenag_tujuan" placeholder="Contoh : Jakarta" value="">
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="nama_2_suku" id="nama_2_suku" value="">
                                                <input type="hidden" name="status" value="0">
                                            </div>
                                            <button class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Submit</span>
                                            </button>
                                            <!-- </form> -->
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
            $.getJSON("<?php echo base_url(); ?>staff/jamaah/hapus_imigrasi", {
                    id_request: "<?php echo $member->id_request; ?>",
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

</html>