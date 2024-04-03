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


            <?php $this->load->view('staff/include/side_menu',['reminder' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Jadwal Reminder</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Reminder yang Terdaftar
                                            didalam Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="150%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5px;">No</th>
                                                        <th style="width: 200px;">Keterangan</th>
                                                        <th>Kode Bayar</th>
                                                        <th>Nominal</th>
                                                        <th>Status Reminder</th>
                                                        <th>Tanggal Reminder</th>
                                                        <th>Jadwal</th>
                                                        <th>No Penerima</th>
                                                        <th>Action</th>
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
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/reminder/load_reminder"
            },
            "columns": [{
                    data: 'DT_RowId',
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "keterangan"
                },
                {
                    data: "kode_bayar"
                },
                {
                    data: "nominal"
                },
                {
                    data: "status",
                    render: function(data, type, row) {
                        if (data == 'bulan') {
                            return "Di ulang setiap Bulan"
                        }
                        if (data == 'tahun') {
                            return "Di ulang setiap Tahun"
                        }
                    }
                },
                {
                    data: "tgl_reminder"
                },
                {
                    data: "jadwal"
                },
                {
                    data: "wa_number"
                },
                {
                    data: 'DT_RowId',
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-success btn-sm edit_btn mb-2">Edit</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mb-2">Hapus</a><br>'
                    }
                },
            ]
            // "order": [
            //     [1, "desc"]
            // ],
            // "columnDefs": [{
            //         "targets": -1,
            //         "data": null,
            //         "defaultContent": '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat</a> \n\
            //                                     <a href="javascript:void(0);" class="btn btn-warning btn-sm bc_btn">Broadcast</a> \n\
            //                                     <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
            //                                 <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
            //     },
            //     {
            //         targets: 1,
            //         "render": function(data, type, row) {
            //             var from = data.split("-");
            //             var f = new Date(from[0], from[1] - 1, from[2]);
            //             return $.datepicker.formatDate('dd M yy', f);
            //         }
            //     }
            // ]
        });

        $("#dataTable tbody").on("click", ".edit_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/reminder/edit?id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/reminder/hapus?id=" + trid;
            }
        });
    });
    </script>

</body>

</html>