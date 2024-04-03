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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Logistik</h1>
                        </div>

                        <!-- Content Row -->
                        <div class='row'>
                            <?php if (!empty($_SESSION['alert_type'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                <?php echo $_SESSION['alert_message']; ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Barang yang Terdaftar didalam
                                            Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <a href="<?php echo base_url() . 'staff/barang/tambah'; ?>"
                                                class="btn btn-danger btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-cart-plus"></i>
                                                </span>
                                                <span class="text">Tambah Barang Baru</span>
                                            </a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Stok Gudang</th>
                                                        <th>Stok Kantor</th>
                                                        <th>Stok Bandung</th>
                                                        <th>Total Stok</th>
                                                        <th>Unit Satuan</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
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

    <?php $this->load->view('staff/include/script_view'); ?>
    <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            // "rowCallback": function(row, data, index) {
            //     if (data['status'] == 'Harus Order') {
            //         $(row).css('background-color', 'red');
            //         $(row).css('color', 'black');
            //     } else if (data['status'] == 'Stok Menipis') {
            //         $(row).css('background-color', 'orange');
            //         $(row).css('color', 'black');
            //     } else {
            //         $(row).css('background-color', 'white');
            //         $(row).css('color', 'black');
            //     }

            // },
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo base_url(); ?>staff/barang/load_barang",
            columns: [{
                    data: 'nama_barang'
                },
                {
                    data: 'stok'
                },
                {
                    data: 'stok_kantor'
                },
                {
                    data: 'stok_bandung'
                },
                {
                    data: 'total_stok'
                },
                {
                    data: 'stok_unit'
                },
                {
                    data: 'status'
                },
                {
                    data: 'id_logistik',
                    "render": function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm in_btn">IN</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-info btn-sm out_btn">OUT</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-secondary btn-sm mutasi_btn">Mutasi</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-dark btn-sm transfer_btn">Transfer</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
                    }

                }

            ]
        });

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/barang/lihat?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".in_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/barang/in_barang?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".mutasi_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/barang/mutasi?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".transfer_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/barang/transfer?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".out_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/barang/out_barang?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/barang/hapus?id=" + trid;
            }
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=lg&id=" + trid;
        });
    });
    </script>

</body>

</html>