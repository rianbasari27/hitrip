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


            <?php $this->load->view('staff/include/side_menu',['list_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Transfer Barang</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Transfer barang
                                            <?php echo $nama_barang; ?>. Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form" action="<?php echo base_url(); ?>staff/barang/proses_transfer"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_logistik" value="<?php echo $id_logistik;?>">
                                            <input type="hidden" name="stok" value="<?php echo $stok;?>">
                                            <input type="hidden" name="stok_kantor" value="<?php echo $stok_kantor;?>">
                                            <input type="hidden" name="stok_bandung"
                                                value="<?php echo $stok_bandung;?>">
                                            <input type="hidden" name="nama_barang" value="<?php echo $nama_barang;?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Dari</label>
                                                <select class="form-control" id="tempat_dari" name="tempat_dari">
                                                    <option value="Gudang">Gudang</option>
                                                    <option value="Kantor">Kantor</option>
                                                    <option value="Bandung">Bandung</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Ke</label>
                                                <select class="form-control" id="tempat_ke" name="tempat_ke">
                                                    <option value="Gudang">Gudang</option>
                                                    <option value="Kantor" selected>Kantor</option>
                                                    <option value="Bandung">Bandung</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah</label>
                                                <input class="form-control" type="number" name="jumlah">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Keterangan</label>
                                                <input class="form-control" type="text" name="note">
                                            </div>
                                            <button class="btn btn-success btn-icon-split mt-3">
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
        $("#tempat_dari").change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === "Gudang") {
                $("#tempat_ke").val("Kantor");
                $("#tempat_ke").val("Bandung");
            } else if (selectedValue === "Kantor") {
                $("#tempat_ke").val("Gudang");
                $("#tempat_ke").val("Bandung");
            } else if (selectedValue === "Bandung") {
                $("#tempat_ke").val("Gudang");
                $("#tempat_ke").val("Kantor");
            }
        });
        $("#tempat_ke").change(function() {
            var selectedValue = $(this).val();
            if (selectedValue === "Gudang") {
                $("#tempat_dari").val("Kantor");
                $("#tempat_dari").val("Bandung");
            } else if (selectedValue === "Kantor") {
                $("#tempat_dari").val("Gudang");
                $("#tempat_dari").val("Bandung");
            } else if (selectedValue === "Bandung") {
                $("#tempat_dari").val("Gudang");
                $("#tempat_dari").val("Kantor");
            }
        });
    })
    </script>
</body>

</html>