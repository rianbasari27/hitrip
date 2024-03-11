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


            <?php $this->load->view('staff/include/side_menu', ['list_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Barang</h1>
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
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Barang</h6>
                                        <span class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/barang/ubah?id=<?php echo $id_logistik; ?>"
                                                class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Ubah Data</span>
                                            </a>
                                            <a onclick="$('#fly_up').trigger('click');" href="#"
                                                class="btn btn-success btn-icon-split btn-sm" for="fly_up">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-image"></i>
                                                </span>
                                                <span class="text">Upload Gambar</span>
                                            </a>
                                            <form action="<?php echo base_url(); ?>staff/barang/ganti_pic" method="post"
                                                enctype="multipart/form-data" style="display: inline">
                                                <input type="hidden" name="id_logistik"
                                                    value="<?php echo $id_logistik; ?>">
                                                <input name="file" onchange='this.form.submit();' id="fly_up"
                                                    type="file" style="display: none;">
                                            </form>
                                        </span>
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tr>
                                                    <th style="width:200px;">Nama Barang</th>
                                                    <td>
                                                        <div><?php echo $nama_barang; ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Jumlah / Stok Kantor</th>
                                                    <td><?php echo $stok; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jumlah / Stok Gudang</th>
                                                    <td><?php echo $stok_kantor; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Satuan</th>
                                                    <td><?php echo $stok_unit; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama Vendor</th>
                                                    <td><?php echo $nama_vendor; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi</th>
                                                    <td><?php echo $deskripsi; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gambar Status</th>
                                                    <td>
                                                        <?php if (!empty($pic)) { ?>
                                                        <div class="d-flex flex-column">
                                                            <div class="mb-2">
                                                                <img src="<?php echo base_url() . $pic ?>" width="150px"
                                                                    class="shadow mb-2">
                                                                <a href="<?php echo base_url() . 'staff/barang/delete_pic?id=' . $id_logistik ?>"
                                                                    class="btn btn-danger btn-sm">Hapus</a>
                                                            </div>
                                                            <!-- Tambahkan div yang sama untuk setiap gambar yang ingin ditampilkan -->
                                                        </div>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            </table>
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
    <!-- Logout Modal-->

    <?php $this->load->view('staff/include/script_view'); ?>
    <script>
    $(".btnHapus").click(function() {
        var ref = $(this).attr("href");
        $("#btnModal").attr("href", ref);

    });
    </script>
</body>

</html>