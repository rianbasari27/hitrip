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


            <?php $this->load->view('staff/include/side_menu',['agen_paket' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Program Konsultan</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi Informasi Program Dengan
                                            Benar!
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/agen_paket/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Program</label>
                                                <input class="form-control" type="text" name="nama_paket">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga Program</label>
                                                <input class="form-control format_harga" type="text" name="harga">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Diskon Member Baru</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="diskon_member_baru">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Diskon Member Baru</label>
                                                <input class="form-control" type="text"
                                                    name="deskripsi_diskon_member_baru">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Diskon Member Lama</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="diskon_member_lama">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Diskon Member Lama</label>
                                                <input class="form-control" type="text"
                                                    name="deskripsi_diskon_member_lama">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Diskon Eks Jamaah</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="diskon_eks_jamaah">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Diskon Eks Jamaah</label>
                                                <input class="form-control" type="text"
                                                    name="deskripsi_diskon_eks_jamaah">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Status (<span
                                                        class="text-primary font-italic font-weight-lighter"> yang akan dimunculkan di aplikasi konsultan / pendaftaran </span>)</label>
                                                <select name="is_member" id="" class="form-control">
                                                    <option value="2">Konsultan Lama & Konsultan Baru</option>
                                                    <option value="1">Konsultan Lama</option>
                                                    <option value="0">Konsultan Baru</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Gambar Banner - rekomendasi ukuran 700x700
                                                    px (<span
                                                        class="text-primary font-italic font-weight-lighter">Gambar yang
                                                        muncul di aplikasi jamaah</span>)</label>
                                                <input class="form-control" type="file" name="agen_gambar_banner">
                                            </div>

                                            <div class="form-group mb-0">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="active" value="1" checked> Publish
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label class="col-form-label">Tanggal Publish</label>
                                                <input class="form-control" type="date" name="published_at">
                                            </div> -->


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
    $(document).ready(function() {
        $(".format_harga").on("input", function() {
            var inputValue = $(this).val();

            inputValue = inputValue.replace(/[^\d.]/g, '');
            if (inputValue !== '') {
                inputValue = parseFloat(inputValue).toLocaleString('en-US');
                $(this).val(inputValue);
            } else {
                $(this).val('');
            }
        });
    });
    if (window.innerWidth > 800) {
        $(".datepicker").attr("type", "text");
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "mm/dd/yy"
            });
        });
    }
    </script>
</body>

</html>