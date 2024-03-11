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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Produk</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi Informasi Produk Dengan Benar!
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                                <?php echo $_SESSION['alert_message']; ?>
                                            </div>
                                        <?php } ?>
                                        <form role="form" action="<?php echo base_url(); ?>staff/online_store/proses_tambah" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Produk</label>
                                                <input class="form-control" type="text" name="product_name">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Singkat (<span
                                                        class="text-primary font-italic font-weight-lighter">Deskripsi yang muncul di single product</span>)</label>
                                                <input class="form-control" type="text" name="short_description">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Produk (<span
                                                        class="text-primary font-italic font-weight-lighter">Full Description</span>)</label>
                                                <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kategori</label>
                                                <select name="category_id" class="form-control">
                                                    <option value=""> -- Pilih Kategori -- </option>
                                                    <?php foreach ($category as $c) { ?>
                                                        <option value="<?php echo $c->category_id ;?>"><?php echo $c->category_name ;?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga</label>
                                                <input class="form-control format_harga" type="text" name="price">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Gambar Produk - rekomendasi ukuran 700x700 px</label>
                                                <input class="form-control" type="file" name="product_image[]" multiple>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Diskon</label>
                                                <input class="form-control format_harga" type="text" name="discount_amount">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Total Stok</label>
                                                <input class="form-control" type="number" name="stock_quantity">
                                            </div>

                                            <!-- <div class="form-group">
                                                <label class="col-form-label">Waktu Berlaku Diskon </label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="date" class="form-control"
                                                            name="waktu_diskon_start">
                                                    </div>
                                                    <div class="col">
                                                        <input type="date" class="form-control" name="waktu_diskon_end">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <!-- <input class="form-control" type="date" name="waktu_diskon_start"> - 
                                                <input class="form-control" type="date" name="waktu_diskon_end"> -->

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
    </script>
</body>

</html>