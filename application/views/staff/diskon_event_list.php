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


            <?php $this->load->view('staff/include/side_menu', ['diskon_event' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Discount Event Paket</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Discount Event Paket yang ada
                                            didalam Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <a href="<?php echo base_url() . 'staff/diskon_event/tambah'; ?>"
                                                class="btn btn-primary btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                                <span class="text">Tambah Discount Baru</span>
                                            </a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 300px">Nominal</th>
                                                        <th>Tanggal Berlaku</th>
                                                        <th>Tanggal Berakhir</th>
                                                        <th>Status</th>
                                                        <th style="width: 250px">Aksi</th>
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
            "ajax": "<?php echo base_url(); ?>staff/diskon_event/load_diskon",
            "order": [
                [1, "asc"]
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": '<a href="javascript:void(0);" class="btn btn-primary btn-sm edit_btn mb-1">Edit</a> \n\
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mb-1">Hapus</a> \n\
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn mb-1">Log</a>'
                },
                {
                    targets: [1, 2],
                    "render": function(data, type, row) {
                        var from = data.split("-");
                        var f = new Date(from[0], from[1] - 1, from[2]);
                        return $.datepicker.formatDate('dd M yy', f);
                    }
                }
            ]
        });

        $("#dataTable tbody").on("click", ".edit_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/diskon_event/edit?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/diskon_event/hapus?id=" + trid;
            }
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=d&id=" + trid;
        });
    });
    </script>

</body>

</html>