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


            <?php $this->load->view('staff/include/side_menu', ['store' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Product</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Produk</h6>
                                        <span class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/online_store/ubah_product?id=<?php echo $product->product_id; ?>"
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
                                                <span class="text">Upload Gambar Produk</span>
                                            </a>
                                            <form action="<?php echo base_url(); ?>staff/online_store/upload_image"
                                                method="post" enctype="multipart/form-data" style="display: inline">
                                                <input type="hidden" name="id"
                                                    value="<?php echo $product->product_id; ?>">
                                                <input name="product_image[]" onchange='this.form.submit();' id="fly_up"
                                                    type="file" multiple style="display: none;">
                                            </form>
                                        </span>
                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tr>
                                                    <th style="width:200px;">Nama Produk</th>
                                                    <td>
                                                        <div><?php echo $product->product_name; ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Produk</th>
                                                    <td><?php echo $product->description; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Harga</th>
                                                    <td><?php echo 'Rp ' . number_format($product->price, 0, ',', '.'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Discount</th>
                                                    <td><?php echo 'Rp ' . number_format($product->discount_amount, 0, ',', '.'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Stok</th>
                                                    <td><?php echo number_format($product->stock_quantity, 0, ',', '.'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Gambar product</th>
                                                    <td>
                                                        <?php if (!empty($product->images)) { ?>
                                                        <?php foreach ($product->images as $image) { ?>
                                                        <div class="d-flex flex-column">
                                                            <div class="mb-2">
                                                                <img src="<?php echo base_url() . $image->location ?>"
                                                                    width="150px" class="shadow mb-2">
                                                                <a href="<?php echo base_url() . 'staff/online_store/delete_image?id=' . $image->image_id . '&product_id=' . $product->product_id ?>"
                                                                    class="btn btn-danger btn-sm">Hapus</a>
                                                            </div>
                                                            <!-- Tambahkan div yang sama untuk setiap gambar yang ingin ditampilkan -->
                                                        </div>
                                                        <?php } ?>
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