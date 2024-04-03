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


            <?php $this->load->view('staff/include/side_menu', ['data_konsultan' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Jamaah</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Nama Konsultan :
                                            <?php echo strtoupper($nama_agen); ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:155px">Nama</th>
                                                        <th>Nomor Paspor</th>
                                                        <th>Nomor Telepon</th>
                                                        <th>Kota Tinggal</th>
                                                        <th>Program</th>
                                                        <th>Keberangkatan</th>
                                                        <th>Last Name</th>
                                                        <th>Second Name</th>
                                                        <th>Whole Name</th>
                                                        <th>Two Name</th>
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
            "pageLength": 50,
            "lengthMenu": [
                [500, 100, 50, 25, 10],
                [500, 100, 50, 25, 10]
            ],
            dom: 'lBfrtip',
            buttons: [{
                extend: 'excel',
                text: 'EXCEL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }],
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/kelola_agen/load_peserta",
                "data": {
                    id_agen: '<?php echo $id_agen; ?>',
                    musim: '<?php echo $musim['hijri']; ?>',
                }
            },
            columns: [{
                    data: 'first_name'
                },
                {
                    data: 'paspor_no'
                },
                {
                    data: 'no_wa'
                },
                {
                    data: 'kabupaten_kota'
                },
                {
                    data: 'nama_paket'
                },
                {
                    data: 'tanggal_berangkat'
                },
                {
                    data: 'last_name',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'second_name',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'whole_name',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'two_name',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'id_member',
                    "render": function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat Detail Jamaah</a>'
                    }
                }
            ],
            "columnDefs": [{
                    "targets": 0,
                    "render": function(data, type, row) {
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

            ],
            "order": [
                [0, 'desc']
            ]
        });

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + id_jamaah +
                "&id_member=" + trid, '_blank');
        });
    });
    </script>

</body>

</html>