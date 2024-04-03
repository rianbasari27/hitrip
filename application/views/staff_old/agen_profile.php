<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>

</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['data_konsultan' => true]); ?>

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
                        <div class="d-sm-flex align-items-center mb-3">
                            <h1 class="h3 mb-0 text-gray-800 mr-2"><?php echo $nama_agen; ?></h1>
                            <?php if ($suspend == 1) { ?>
                            <h1 class="h3 mb-0 font-weight-bold mr-3" style="color: red;">(SUSPENDED)</h1>
                            <?php } ?>
                        </div>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                    <?php echo $_SESSION['alert_message']; ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">

                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Profile Picture</h6>
                                        <form id="target" action="<?php echo base_url(); ?>staff/kelola_agen/ganti_pic"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_agen" value="<?php echo $id_agen; ?>">
                                            <label class="btn btn-primary btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <input id="file" name="file" style="display: none;" type="file" />
                                                <span class="text">Ganti</span>
                                            </label>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <?php if (empty($agen_pic)) { ?>
                                            <i class="fas fa-laugh-wink" style="font-size: 10rem;"></i>
                                            <?php } else { ?>
                                            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 15rem;"
                                                src="<?php echo base_url() . $agen_pic; ?>" alt="">
                                            <a rel="agen_pic" href="javascript:void(0);"
                                                class="btn btn-danger btn-icon-split btn-sm hapusPic">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Hapus</span>
                                            </a>
                                            <?php } ?>
                                        </center>
                                    </div>
                                </div>

                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">MOU</h6>
                                        <form id="return" action="<?php echo base_url(); ?>staff/kelola_agen/upload_mou"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_agen" value="<?php echo $id_agen; ?>">
                                            <label class="btn btn-secondary btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <input id="upload" name="file" style="display: none;" type="file" />
                                                <span class="text">Upload MOU</span>
                                            </label>
                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($mou_doc == null) { ?>
                                        File Belum Ada
                                        <?php } else { ?>

                                        <center>
                                            <div id="mou_doc">
                                                <a href="<?php echo base_url() . "staff/kelola_agen/dl_mou?id_agen=" . $id_agen; ?>"
                                                    class="m-1">
                                                    Download File
                                                </a>
                                                <a rel="mou_doc" href="javascript:void(0);"
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
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Komisi Langsung</h6>
                                        <a href="<?php echo base_url() . 'staff/komisi?id=' . $id_agen; ?>"
                                            class="btn btn-success btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                            <span class="text">Button</span>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                    </div>
                                </div>
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Poin Pribadi</h6>
                                        <a href="<?php echo base_url() . 'staff/komisi/poin_pribadi?id=' . $id_agen; ?>"
                                            class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                            <span class="text">Tambah</span>
                                        </a>
                                    </div>
                                    <div class="card-body text-center">
                                        <h1><?php echo $poin ;?></h1>
                                        <a href="<?php echo base_url() . 'staff/kelola_agen/lihat_poin?id='.$id_agen;?>"
                                            class="btn btn-primary btn-sm">Detail</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="card shadow mb-4">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Detail Konsultan</h6>

                                        <span class="m-0">
                                            <a href="<?php echo base_url() . 'staff/kelola_agen/ubah_profile?id=' . $id_agen; ?>"
                                                class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Ubah</span>
                                            </a>
                                            <span style="margin-left:30px;"></span>
                                            <a href="<?php echo base_url() . 'staff/kelola_agen/suspend?id=' . $id_agen; ?>"
                                                class="btn btn-<?php echo $suspend == 1 ? 'success' : 'danger'; ?> btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-ban"></i>
                                                </span>
                                                <span
                                                    class="text"><?php echo $suspend == 1 ? 'Cabut Suspend' : 'Suspend'; ?></span>
                                            </a>
                                            <a href="#" id="hapus" class="btn btn-danger btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-trash"></i>
                                                </span>
                                                <span class="text">Hapus Konsultan</span>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="col-form-label">ID Konsultan (Nomor Induk Konsultan)</label>
                                            <input disabled class="form-control" type="text"
                                                value="<?php echo $no_agen; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tanggal Terdaftar</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $tanggal_terdaftar; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor WhatsApp</label>
                                            <input class="form-control" type="number" disabled
                                                value="<?php echo $no_wa; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor KTP</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $no_ktp; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tanggal Lahir</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo date_format(date_create($tanggal_lahir), "d M Y"); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Email</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $email; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor Rekening</label>
                                            <input class="form-control" type="number" disabled
                                                value="<?php echo $no_rekening; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nama Bank</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $nama_bank; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Alamat</label>
                                            <textarea class="form-control" rows="6"
                                                disabled><?php echo $alamat; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Provinsi</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $provinsi; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Kabupaten/Kota</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $kota; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Kecamatan</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $kecamatan; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Status Perkawinan</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $status_perkawinan; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Pekerjaan</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $pekerjaan; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Kewarganegaraan</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $kewarganegaraan; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Hobi</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $hobi; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Jenis Kelamin</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $jenis_kelamin; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Ukuran Baju</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $ukuran_baju; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Pecah Telor</label>
                                            <input class="form-control" type="text" disabled
                                                value="<?php echo $pecah_telor == 1 ? 'Sudah' : 'Belum' ?>">
                                        </div>
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
    <script>
    $('#file').change(function() {
        $('#target').submit();
    });
    $('#upload').change(function() {
        $('#return').submit();
    });
    $('#hapus').click(function() {
        var r = confirm("Yakin untuk menghapus?");
        if (r == true) {
            window.location.href = "<?php echo base_url() . 'staff/kelola_agen/hapus?id=' . $id_agen; ?>";
        }
    });

    $(".hapusImg").click(function() {
        var id = $(this).attr('rel');
        $.getJSON("<?php echo base_url(); ?>staff/kelola_agen/hapus_mou", {
                id_agen: "<?php echo $id_agen; ?>",
                field: id
            })
            .done(function(json) {
                alert('File berhasil dihapus');
                $("#" + id).remove();
                location.reload();
            })
            .fail(function(jqxhr, textStatus, error) {
                alert('File gagal dihapus');
            });

    });

    $(".hapusPic").click(function() {
        var id = $(this).attr('rel');
        $.getJSON("<?php echo base_url(); ?>staff/kelola_agen/hapus_pic", {
                id_agen: "<?php echo $id_agen; ?>",
                field: id
            })
            .done(function(json) {
                alert('File berhasil dihapus');
                $("#" + id).remove();
                location.reload();
            })
            .fail(function(jqxhr, textStatus, error) {
                alert('File gagal dihapus');
            });

    });
    </script>
</body>

</html>