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
                            <h1 class="h3 mb-0 text-gray-800">List Barang Office</h1>
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
                                            <strong>List barang yang terdaftar di sistem</strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                <form action="<?php echo base_url().'staff/perlengkapan_office'?>"
                                                    method="get">
                                                    <div class="mt-2">
                                                        <label for="jenis">Pilih Jenis Barang</label>
                                                        <select name="jenis" id="jenis"
                                                            class="border border-secondary rounded p-1"
                                                            style="width: 250px;">
                                                            <option value="" selected> -- Pilih Jenis Barang --
                                                            </option>
                                                            <?php foreach ($listJenis as $key => $j) { ?>
                                                            <option value="<?php echo $j->jenis ;?>">
                                                                <?php echo $j->jenis ;?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <a href="<?php echo base_url() . 'staff/perlengkapan_office/tambah'; ?>"
                                                    class="btn btn-primary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-plus"></i>
                                                    </span>
                                                    <span class="text">Tambah Barang Baru</span>
                                                </a>
                                                <a href="<?php echo base_url() . 'staff/perlengkapan_office/request'; ?>"
                                                    class="btn btn-secondary btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-plus"></i>
                                                    </span>
                                                    <span class="text">Request Barang Baru</span>
                                                </a>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="150%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th style="width:155px">Nama Barang</th>
                                                            <th>Jenis</th>
                                                            <th>Jumlah / Stok</th>
                                                            <th>Satuan</th>
                                                            <th>Lokasi</th>
                                                            <th>Pemegang</th>
                                                            <th style="width:155px">Status</th>
                                                            <th>Deskripsi</th>
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

                <!-- Footer -->
                <?php $this->load->view('staff/include/footer'); ?>
                <!-- End of Footer -->
            </div>
            <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <?php $this->load->view('staff/include/script_view'); ?>
    <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#jenis").change(function() {
            reinitializeDataTable();
        });

        function reinitializeDataTable() {
            $('#dataTable tbody').off('mouseenter', 'tr');
            $('#dataTable tbody').off('mouseleave', 'tr');
            $('#dataTable tbody').off('click', 'tr');
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }
            loadDatatables();
        }

        loadDatatables();

        function loadDatatables() {
            var jenis = !$("#jenis").val() ? '' : $("#jenis").val();

            var dataTable = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/perlengkapan_office/load_barang",
                    "data": {
                        jenis: jenis
                    }
                },
                columns: [{
                        data: 'id_barang',
                        "render": function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'jenis'
                    },
                    {
                        data: 'stock'
                    },
                    {
                        data: 'satuan'
                    },
                    {
                        data: 'lokasi'
                    },
                    {
                        data: 'pemegang'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            var base_url = "<?php echo base_url() ;?>"
                            if (row['foto_status'] != null) {
                                add = '<br><a href="' + base_url + row['foto_status'] +
                                    '" target="_blank" class="btn btn-outline-primary btn-sm riwayat_btn mt-1">Lihat Gambar</a>'
                            } else {
                                add = ''
                            }

                            if (data == null) {
                                data = ''
                            }

                            return data + add
                        }
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'id_barang',
                        "render": function(data, type, row) {
                            return '<a href="javascript:void(0);" class="btn btn-outline-primary btn-sm lihat_btn mt-1">Lihat</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-outline-secondary btn-sm request_btn mt-1">Request</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-outline-warning btn-sm pinjam_btn mt-1">Pinjam</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-outline-success btn-sm minta_btn mt-1">Minta</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-outline-dark btn-sm in_btn mt-1">IN</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-outline-info btn-sm out_btn mt-1">OUT</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm hapus_btn mt-1">Hapus</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-outline-dark btn-sm mutasi_btn mt-1">Mutasi</a>\n\
                                    <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn mt-1">Log</a>'
                        }

                    }

                ],
                // "order": [
                //     [1, 'asc']
                // ]
            });
        }

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/lihat?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".request_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/request?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".in_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/in_barang?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".out_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/out_barang?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".pinjam_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/pinjam?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".mutasi_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/mutasi?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href =
                    "<?php echo base_url(); ?>staff/perlengkapan_office/hapus?id=" +
                    trid;
            }
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href =
                "<?php echo base_url(); ?>staff/log?tbl=bpo&id=" + trid;
        });
    });
    </script>


</body>

</html>