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
                            <h1 class="h3 mb-0 text-gray-800">Rename Nama Directory</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div style="color:red">
                                    <?php echo validation_errors(); ?>
                                    <?php if(isset($error)){print $error;}?>
                                </div>

                                <form action="<?php base_url() ; ?>../../form_rename_kg" method="POST"
                                    enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Nama Directory Baru</label>
                                        <input type="text" class="form-control" name="folder_baru"
                                            value="<?php echo $nama ?>" required>
                                    </div>
                                    <input type="hidden" name="folder_lama" value="<?php echo $folder ?>">
                                    <input type="hidden" name="file" value="<?php echo $file ?>">
                                    <input type="hidden" name="nama" value="<?php echo $nama ?>">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-success text-right"
                                            name="ubah_folder">Simpan</button>
                                            <a href="#"class="btn btn-danger text-right" onclick="history.back(-1)">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <!-- /.container-fluid -->
                    <?php
                                                        //  echo '<pre>' ;
                                                        //  print_r($data);
                                                        //  exit();
                    ?>
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