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


                <?php $this->load->view('staff/include/side_menu', ['data_jamaah' => true]); ?>

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
                                <h1 class="h3 mb-0 text-gray-800">Room List</h1>
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
                                <div class="col-lg-7">
                                    <!-- Basic Card Example -->
                                    <div class="card shadow mb-4 border-left-primary">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary"><strong><?php echo "$paket->nama_paket ($paket->tanggal_berangkat)"; ?></strong><br>Jamaah yang Belum Mempunyai Kamar</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th style="width:155px">Nama</th>
                                                                    <th>Nomor Paspor</th>
                                                                    <th>Pilihan Kamar</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi Kamar</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
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
            $(document).ready(function () {
                $('#dataTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo base_url(); ?>staff/room_list/load_peserta",
                        "data": {
                            id_paket: <?php echo $paket->id_paket; ?>
                        }
                    },
                    columns: [
                        {data: 'first_name'},
                        {data: 'paspor_no'},
                        {data: 'pilihan_kamar'}
                    ],
                    "columnDefs": [
                        {
                            "targets": 0,
                            "render": function (data, type, row) {
                                if (row['second_name'] === null) {
                                    r1 = '';
                                } else {
                                    r1 = row['second_name'];
                                }
                                if (row['last_name'] === null) {
                                    r2 = '';
                                } else {
                                    r2 = row['last_name'];
                                }
                                if (row['wg']) {
                                    r3 = '<a href="#" class="btn btn-warning btn-sm">WG</a>';
                                } else {
                                    r3 = ''
                                }

                                return data + ' ' + r1 + ' ' + r2 + ' ' + r3;
                            }

                        }
                    ]
                });
            }
            );
        </script>

    </body>

</html>





