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
                            <h1 class="h3 mb-0 text-gray-800">List Permintaan Barang Office</h1>
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
                                            <strong>List barang yang diminta</strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3">
                                                <form action="<?php echo base_url().'staff/perlengkapan_office'?>"
                                                    method="get">
                                                    <div class="mt-2">
                                                        <label for="status_request">Pilih Status </label>
                                                        <select name="status_request" id="status_request"
                                                            class="border border-secondary rounded p-1"
                                                            style="width: 250px;">
                                                            <option value="" selected> -- Pilih Status --
                                                            </option>
                                                            <?php foreach ($statusRequest as $key => $s) { ?>
                                                            <option value="<?php echo $s->status_request ;?>">
                                                                <?php if ( $s->status_request == 0) { ?>
                                                                    <?php echo "Belum Di Order" ;?>
                                                                <?php } else if ($s->status_request == 1) { ?>
                                                                    <?php echo "Sudah Di Order" ;?>
                                                                <?php } else if ($s->status_request == 2) { ?>
                                                                    <?php echo "Belum Di Terima" ;?>
                                                                <?php } else { ?>
                                                                    <?php echo "Belum Di Terima" ;?>
                                                                <?php } ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="120%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th style="width:155px">Nama Barang</th>
                                                            <th>Jenis</th>
                                                            <th>Jumlah Request/Permintaan</th>
                                                            <th>Tanggal</th>
                                                            <th>Yang Merequest/Meminta</th>
                                                            <th>Divisi</th>
                                                            <th>Keterangan</th>
                                                            <th>Status Request/Permintaan</th>
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
    function formatTanggalWaktuIndonesia(tanggal) {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            timeZoneName: 'short'
        };
        return tanggal.toLocaleDateString('id-ID', options);
    }
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#status_request").change(function() {
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
            var status_request = !$("#status_request").val() ? '' : $("#status_request").val();

            var dataTable = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/perlengkapan_office/load_request",
                    "data": {
                        status_request: status_request
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
                        data: 'info'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'tanggal',
                        render: function(data, type, row) {
                            const tanggalSekarang = new Date(data);
                            const tanggalWaktuIndonesia = formatTanggalWaktuIndonesia(tanggalSekarang);

                            return tanggalWaktuIndonesia
                        }
                    },
                    {
                        data: 'nama_staff'
                    },
                    {
                        data: 'divisi'
                    },
                    {
                        data: 'keterangan_tambahan'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'id_barang',
                        render: function(data, type, row) {
                            var orderButton = '';
                            if (row['status_request'] == "0" && row['status_request'] == "Request") {
                                orderButton =
                                    '<a href="javascript:void(0);" class="btn btn-outline-primary btn-sm order_btn mt-1">Order</a>';
                            } else {
                                orderButton =
                                    '<a href="javascript:void(0);" class="btn btn-outline-success btn-sm terima_btn mt-1">Terima Permintaan</a>';
                            }
                            return orderButton
                            // '\n\
                            //             <a href="javascript:void(0);" class="btn btn-warning btn-sm kuitansi_btn mt-1">Kuitansi</a> \n\
                            //             <a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn mt-1">Profile</a>\n\
                            //             <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mt-1">Hapus</a>\n\
                            //             <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn mt-1">Log</a>'
                        },

                    }

                ],
                // "order": [
                //     [1, 'asc']
                // ]
            });
        }

        $("#dataTable tbody").on("click", ".order_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/order?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".terima_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/terima?id=" +
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