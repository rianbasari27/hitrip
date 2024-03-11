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


            <?php $this->load->view('staff/include/side_menu', ['galeri' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Pembuatan Folder Galeri</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div style="color:red">
                                    <?php echo validation_errors(); ?>
                                    <?php if(isset($error)){print $error;}?>
                                </div>

                                <form action="<?php base_url() ; ?>../tambahv2_folder/" method="POST"
                                    enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Nama Directory</label>
                                        <input type="text" class="form-control" name="folder_kategori"
                                            placeholder="Contoh : Keberangkatan 03 Januari 2021" required>
                                    </div>
                                    <input type="hidden" name="directory" value="<?php echo $folder ?>">
                                    <!-- <div class="form-group">
                                        <label for="exampleInputUsername1">Gambar 1</label>
                                        <input type="file" name="image1" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Gambar 2</label>
                                        <input type="file" name="image2" class=" form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Gambar 3</label>
                                        <input type="file" name="image3" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Gambar 4</label>
                                        <input type="file" name="image4" class="form-control" required />
                                    </div> -->
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success text-right">Simpan</button>
                                        <a href="#"class="btn btn-danger text-right" onclick="history.back(-1)">Cancel</a>
                                    </div>
                                </form>
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
</body>

</html>