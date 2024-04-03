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


            <?php $this->load->view('staff/include/side_menu',['agen_paket' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Program Konsultan</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Program Konsultan yang Terdaftar
                                            didalam Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 200px">Nama Program</th>
                                                        <th>Harga</th>
                                                        <th>Publish</th>
                                                        <th style="width: 100px;">Tanggal Publish</th>
                                                        <th style="width: 300px">Aksi</th>
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
                "url": "<?php echo base_url(); ?>staff/agen_paket/load_paket",
            },
            "order": [
                [1, "desc"]
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn mt-1">Lihat</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mt-1">Hapus</a> \n\
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn mt-1">Log</a>'
                },
                {
                    "targets": 3,
                    "render": function(data, type, row) {
                    var dt = new Date(data);
                    var tahun = dt.getFullYear();
                    var hari = dt.getDay();
                    var bulan = dt.getMonth();
                    var tanggal = dt.getDate();
                    var hariarray = new Array("Sun,", "Mon,", "Tue,", "Wed,", "Thu,",
                        "Fri,", "Sat,");
                    var bulanarray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                    var z = hariarray[hari] + " " + ((tanggal < 10) ? "0" : "") + tanggal +
                        " " + bulanarray[bulan] + " " + tahun + "<br>" + "( " + ((dt
                            .getHours() < 10) ? "0" : "") + dt.getHours() + ":" + ((dt
                            .getMinutes() < 10) ? "0" : "") + dt.getMinutes() + ":" + ((dt
                            .getSeconds() < 10) ? "0" : "") + dt.getSeconds() + " )";
                    return z;
                }
                }
            ]
        });

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/agen_paket/lihat?id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".bc_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/paket/hapus?id=" + trid;
            }
        });

        $("#dataTable tbody").on("click", ".manasik_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast/manasik?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pu&id=" + trid;
        });
    });
    </script>

</body>

</html>