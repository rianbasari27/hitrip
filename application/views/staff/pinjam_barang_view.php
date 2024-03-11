<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <link href="<?php echo base_url(); ?>asset/chat/style.css" rel="stylesheet">
    <style>
    .iframe-container {
        height: 481px;
    }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['perl_office' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">List Barang Kantor</h1>
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
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            <strong>List barang yang di pinjam</strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <a href="<?php echo base_url() . 'staff/perlengkapan_office/tambah'; ?>"
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
                                                                <th>No</th>
                                                                <th style="width:155px">Nama Barang</th>
                                                                <th>Jumlah</th>
                                                                <th>Deskripsi</th>
                                                                <th>Tanggal Pinjam</th>
                                                                <th>Nama Peminjam</th>
                                                                <th>Status</th>
                                                                <th style="width:275px">Aksi</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>

                                            </div>
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
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo base_url(); ?>staff/perlengkapan_office/load_pinjam",
            columns: [{
                    data: 'id_barang',
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'nama_barang'
                },
                {
                    data: 'jumlah'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'nama'
                },
                {
                    data: 'status'
                },
                {
                    data: 'id_logistik',
                    "render": function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
                    }

                }

            ]
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            var id = $(this).closest('tr').attr('id_perlkantor');
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href =
                    "<?php echo base_url(); ?>staff/perlengkapan_office/hapusPinjam?id=" +
                    trid + "&idp=" + id;
            }
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href =
                "<?php echo base_url(); ?>staff/log?tbl=pof&id=" + trid;
        });
    });
    </script>


</body>

</html>