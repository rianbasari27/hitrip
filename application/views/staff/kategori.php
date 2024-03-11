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
                        <div class='row'>
                            <?php if (!empty($_SESSION['alert_type'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                <?php echo $_SESSION['alert_message']; ?>
                            </div>
                            <?php } ?>
                        </div>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Directory <?php echo $nama_folder;?></strong></h6>
                                    </div>
                                    <div class="col-lg-3">
                                        <a href="<?php echo base_url().'staff/galeri'?>"
                                                class="btn btn-sm btn-primary mt-2 mb-3">Kembali</a>
                                        <a href="<?php echo base_url().'staff/galeri/tambahv2_view/'. $folder?>"
                                            class="btn btn-sm btn-primary mt-2 mb-3">Tambah Directory</a>
                                    </div>
                                    <div class="row">
                                        <table class="table">
                                            <tbody>
                                                <?php 
                                        if ($data== NULL) {
                                            ?> <div class="content mb-n2">
                                                    <div class="d-flex">
                                                        <div class="align-self-center">
                                                            <h2 class="mb-0 font-18"><strong>&ensp;&ensp;Belum ada
                                                                    isinya!!</strong></h2>
                                                        </div>
                                                    </div>
                                                </div><?php
                                        } else {
                                            foreach($data['isi'] as $kg) {?>
                                                <tr>
                                                    <td>
                                                        <a
                                                            href="<?php echo base_url().'staff/galeri/vgaleri/'.$kg['director'] . '/' . $kg['directory'];?>">
                                                            <div class="p-2 bg-theme rounded-sm">
                                                                <h5 class="font-10 line-height-s pb-1">
                                                                    <?php echo $kg['title'];?></h5>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td><a href="<?php echo base_url(). "staff/galeri/hapus_direct/". $kg['director']. "/". $kg['directory'];?>"
                                                            class="btn btn-sm btn-danger m-1" style="float: right;"
                                                            onclick="konfirmasi()">Delete</a>
                                                        <a href="<?php echo base_url().'staff/galeri/rename_kg/'.$kg['director'] . '/' . $kg['directory'];?>"
                                                            class="btn btn-sm btn-success m-1"
                                                            style="float: right;">Rename
                                                        </a>
                                                        <input type="hidden" name="nama_dir"
                                                            value="<?php echo $kg['director']; ?>">
                                                        <input type="hidden" name="nama_direct"
                                                            value="<?php echo $kg['directory']; ?>">

                                                    </td>
                                                </tr>
                                                <?php } 
                                        }?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mb-3"></div>

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
</body>

</html>