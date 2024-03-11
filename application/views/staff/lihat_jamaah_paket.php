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


            <?php $this->load->view('staff/include/side_menu'); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Pilih Paket</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Lihat Jamaah Sesuai Paket</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 200px">Nama Paket</th>
                                                        <th>Tanggal Keberangkatan</th>
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
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url(); ?>staff/info/load_paket",
                "order": [
                    [1, "desc"]
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat Peserta</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm manifest_btn">Lihat Manifest</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm room_btn">Lihat Room List</a> \n\
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm bayar_btn">Input Pembayaran</a>\n\
                                            <a href="javascript:void(0);" class="btn btn-info btn-sm perlengkapan_btn">Pengambilan Perlengkapan Jamaah</a>'
                    },
                    {
                        targets: 1,
                        "render": function(data, type, row) {
                            var from = data.split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            return $.datepicker.formatDate('dd M yy', f);
                        }
                    }
                ]
            });

            $("#dataTable tbody").on("click", ".lihat_btn", function() {
                var trid = $(this).closest('tr').attr('id'); // table row ID 
                window.location.href = "<?php echo base_url(); ?>staff/peserta?id_paket=" + trid;
            });

            $("#dataTable tbody").on("click", ".manifest_btn", function() {
                var trid = $(this).closest('tr').attr('id'); // table row ID 
                window.location.href = "<?php echo base_url(); ?>staff/manifest?id_paket=" + trid;
            });

            $("#dataTable tbody").on("click", ".room_btn", function() {
                var trid = $(this).closest('tr').attr('id'); // table row ID 
                window.location.href = "<?php echo base_url(); ?>staff/room_list?id_paket=" + trid;
            });

            $("#dataTable tbody").on("click", ".bayar_btn", function() {
                var trid = $(this).closest('tr').attr('id'); // table row ID 
                window.location.href = "<?php echo base_url(); ?>staff/finance/bayar?id_paket=" + trid;
            });
            $("#dataTable tbody").on("click", ".perlengkapan_btn", function() {
                var trid = $(this).closest('tr').attr('id'); // table row ID 
                window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_peserta?id_paket=" + trid;
            });
        });
    </script>

</body>

</html>