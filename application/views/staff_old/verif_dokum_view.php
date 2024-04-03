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


            <?php $this->load->view('staff/include/side_menu', ['request_dokumen' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Request Dokumen</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Nama :</strong>
                                        <?php echo $member->nama_2_suku ;?><br>
                                        <br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>)
                                    </div>
                                </div>
                            </div>
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
                                            action="<?php echo base_url(); ?>staff/request_dokumen/proses_update_req"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_request"
                                                value="<?php echo $member->id_request; ?>">
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Lengkap (<span
                                                        class="text-primary font-italic font-weight-lighter">Minimal 2
                                                        Suku Kata</span>)</label>
                                                <input class="form-control" type="text" name="nama_lengkap"
                                                    value="<?php echo implode(" ", array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name]));?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tambah Nama&nbsp;(<span
                                                        class="text-primary font-italic font-weight-lighter">Tidak Boleh
                                                        Kosong</span>)</label>
                                                <br><input type="radio" name="tambah_nama" value="1"
                                                    <?php echo $member->tambah_nama == 1 ? 'checked' : ''; ?>> Iya
                                                &nbsp;
                                                &nbsp;<input type="radio" name="tambah_nama" value="0"
                                                    <?php echo $member->tambah_nama == 0 ? 'checked' : ''; ?>> Tidak
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tempat Lahir</label>
                                                <input class="form-control" type="text" name="tempat_lahir"
                                                    value="<?php echo $member->tempat_lahir ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Lahir</label>
                                                <input class="form-control" type="date" name="tanggal_lahir"
                                                    value="<?php echo $member->tanggal_lahir ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Request</label>
                                                <input class="form-control" type="text" name="tgl_request"
                                                    value="<?php echo date('d F Y H:i:s', strtotime($member->tgl_request)) ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">NIK</label>
                                                <input class="form-control" type="text" name="no_ktp"
                                                    value="<?php echo $member->no_ktp ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kantor Imigrasi</label>
                                                <input class="form-control" type="text" name="imigrasi_tujuan"
                                                    value="<?php echo $member->imigrasi_tujuan ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kantor Kemenag</label>
                                                <input class="form-control" type="text" name="kemenag_tujuan"
                                                    value="<?php echo $member->kemenag_tujuan ?>">
                                            </div>
                                            <div class="form-group">
                                                <input type="hidden" name="nama_2_suku" id="nama_2_suku" value="">
                                            </div>
                                            <label class="col-form-label">Surat Rekom Imigrasi</label>
                                            <div class="col-lg-6">
                                                <a href="<?php echo base_url() . "dokum_dl/download?idr=" . $id_request . "&idm=". $dataReq->id_member; ?>"
                                                    class="btn btn-sm btn-primary mb-2">
                                                    Download Dokumen
                                                </a>
                                            </div>
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="imigrasi">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if ($member->imigrasi == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="imigrasi">
                                                                    <a href="<?php echo base_url() . "staff/request_dokumen/dl_imigrasi?idr=" . $id_request . "&idm=". $dataReq->id_member; ?>"
                                                                        class="m-1">
                                                                        Download File
                                                                    </a>
                                                                    <a rel="imigrasi" href="javascript:void(0);"
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
                                                    </div>
                                                </div>
                                            </div>
                                            <label class="col-form-label">Surat Rekom Kemenag</label>
                                            <div class="col-lg-6">
                                                <a href="<?php echo base_url() . "dokum_dl/download_kemenag?idr=" . $id_request . "&idm=". $dataReq->id_member; ?>"
                                                    class="btn btn-sm btn-primary mb-2">
                                                    Download Dokumen
                                                </a>
                                            </div>
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <div class="card shadow mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <input class="form-control" type="file" name="kemenag">
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <?php if ($member->kemenag == null) { ?>
                                                            File Belum Ada
                                                            <?php } else { ?>

                                                            <center>
                                                                <div id="kemenag">
                                                                    <a href="<?php echo base_url() . "staff/request_dokumen/dl_kemenag?idr=" . $id_request . "&idm=". $dataReq->id_member; ?>"
                                                                        class="m-1">
                                                                        Download File
                                                                    </a>
                                                                    <a rel="kemenag" href="javascript:void(0);"
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
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Status Verifikasi </label>
                                                <br><input type="radio" name="status" value="2"
                                                    <?php echo $member->status == 2 ? 'checked' : ''; ?>> Selesai
                                                <br><input type="radio" name="status" value="1"
                                                    <?php echo $member->status == 1 ? 'checked' : ''; ?>> Sedang Proses
                                                <br><input type="radio" name="status" value="0"
                                                    <?php echo $member->status == 0 ? 'checked' : ''; ?>> Belum
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