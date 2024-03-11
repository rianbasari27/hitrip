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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Foto</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div style="color:red">
                                    <?php echo validation_errors(); ?>
                                    <?php if(isset($error)){print $error;}?>
                                </div>

                                <form action="<?php echo base_url().'staff/upload_promo/proses_tambah'?>" method="POST"
                                    enctype="multipart/form-data">
                                    <?php echo form_open_multipart() ?>
                                    <div class="form-group">
                                        <label for="file">Silahkan Upload Gambar Banner</label>
                                        <input type="file" name="foto[]" class="form-control" multiple>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success text-right" name="upload"
                                            value="Upload">Simpan</button>
                                        <a href="#" class="btn btn-danger text-right"
                                            onclick="history.back(-1)">Cancel</a>
                                    </div>
                                    <?php echo form_close() ?>
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