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


                <?php $this->load->view('staff/include/side_menu', ['perl_jamaah' => true]); ?>

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
                                <h1 class="h3 mb-0 text-gray-800">Daftar Paket</h1>
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
                                            <h6 class="m-0 font-weight-bold text-primary">Lakukan Pengaturan Sesuai dengan Paketnya</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th style='width: 250px'>Nama Paket</th>
                                                            <th>Tanggal Keberangkatan</th>
                                                            <th>Perlengkapan Pria</th>
                                                            <th>Perlengkapan Wanita</th>
                                                            <th>Perlengkapan Anak Pria</th>
                                                            <th>Perlengkapan Anak Wanita</th>
                                                            <th>Perlengkapan Bayi</th>
                                                            <th style='width: 210px'>Aksi</th>
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
            $(document).ready(function () {
                $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "<?php echo base_url(); ?>staff/perlengkapan_paket/load_perlengkapan",
                    columns: [
                        {data: 'nama_paket'},
                        {data: 'tanggal_berangkat'},
                        {
                            data: 'sumpria',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'sumwanita',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'sumanakpria',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'sumanakwanita',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'sumbayi',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'id_paket',
                            "render": function (data, type, row) {
                                return '<a href="javascript:void(0);" class="btn btn-primary btn-sm atur_btn">Atur Perlengkapan</a>\n\
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm status_btn">Set Status</a>'
                            }

                        },
                        {
                            data: 'nama_paket',
                            visible: false
                        }

                    ],
                    order: [[1, 'desc']]
                });

                $("#dataTable tbody").on("click", ".atur_btn", function () {
                    var trid = $(this).closest('tr').attr('id'); // table row ID 
                    window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_paket/atur?id=" + trid;
                });
                
                $("#dataTable tbody").on("click", ".status_btn", function () {
                    var trid = $(this).closest('tr').attr('id'); // table row ID 
                    window.location.href = "<?php echo base_url(); ?>staff/perlengkapan_paket/atur_status?id=" + trid;
                });
            });
        </script>

    </body>

</html>




