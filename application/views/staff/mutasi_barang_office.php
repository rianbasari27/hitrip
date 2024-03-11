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


            <?php $this->load->view('staff/include/side_menu', ['mutasi_office' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">List Peminjaman Barang Office</h1>
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
                                            <strong>List Barang yang dipinjam</strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="150%"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>No File</th>
                                                            <th style="width:155px">Nama Barang</th>
                                                            <th>Jenis</th>
                                                            <th>Stok Sebelumnya</th>
                                                            <th>IN</th>
                                                            <th>OUT</th>
                                                            <th>Stok Sesudah</th>
                                                            <th>Divisi</th>
                                                            <th>Status</th>
                                                            <th>PIC</th>
                                                            <th>Tanggal Mutasi</th>
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
        // $("#status_request").change(function() {
        //     reinitializeDataTable();
        // });

        // function reinitializeDataTable() {
        //     $('#dataTable tbody').off('mouseenter', 'tr');
        //     $('#dataTable tbody').off('mouseleave', 'tr');
        //     $('#dataTable tbody').off('click', 'tr');
        //     if ($.fn.DataTable.isDataTable('#dataTable')) {
        //         $('#dataTable').DataTable().destroy();
        //     }
        //     loadDatatables();
        // }

        loadDatatables();

        function loadDatatables() {
            // var status_request = !$("#status_request").val() ? '' : $("#status_request").val();

            var dataTable = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/perlengkapan_office/load_mutasi_all",
                    "data" : {
                        id_barang : "<?php echo $id_barang ;?>"
                    }
                },
                columns: [{
                        data: "no_file",
                        orderable: false
                    },
                    {
                        data: 'nama_barang',
                        orderable: false
                    },
                    {
                        data: 'jenis',
                        orderable: false
                    },
                    {
                        data: 'stock_before',
                        orderable: false
                    },
                    {
                        data: 'in',
                        orderable: false
                    },
                    {
                        data: 'out',
                        orderable: false
                    },
                    {
                        data: 'stock_after',
                        orderable: false
                    },
                    {
                        data: 'divisi',
                        orderable: false
                    },
                    {
                        data: 'status',
                        orderable: false
                    },
                    {
                        data: 'pic',
                        orderable: false
                    },
                    {
                        data: 'tanggal_mutasi',
                        render: function(data, type, row) {
                            const tanggalSekarang = new Date(data);
                            const tanggalWaktuIndonesia = formatTanggalWaktuIndonesia(tanggalSekarang);

                            return tanggalWaktuIndonesia
                        }
                    },
                ],
                "order": [
                    [10, 'asc'],
                ]
            });
        }

        $("#dataTable tbody").on("click", ".serah_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/serahkan_barang?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".tolak_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/proses_tolak?id=" +
                trid;
        });
        $("#dataTable tbody").on("click", ".kembali_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_office/kembali_barang?id=" +
                trid;
        });
    });
    </script>


</body>

</html>