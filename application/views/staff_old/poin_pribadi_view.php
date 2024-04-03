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
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/komisi/proses_tambah_poin"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_agen" value="<?php echo $id_agen ;?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Agen</label>
                                                <input class="form-control" type="text"
                                                    value="<?php echo $nama_agen ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah Poin</label>
                                                <input class="form-control" type="number" name="poin"
                                                    value="<?php echo isset($_SESSION['form']['poin']) ? $_SESSION['form']['poin'] : ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Musim</label>
                                                <input class="form-control" type="text" name="musim"
                                                    value="<?php echo isset($_SESSION['form']['musim']) ? $_SESSION['form']['musim'] : ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Keterangan</label>
                                                <textarea class="form-control" rows="4"
                                                    name="keterangan"><?php echo isset($_SESSION['form']['keterangan']) ? $_SESSION['form']['keterangan'] : ''; ?></textarea>
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