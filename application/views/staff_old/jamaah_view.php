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
                            <h1 class="h3 mb-0 text-gray-800">Data Jamaah</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang Terdaftar didalam
                                            Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>Nomor Telepon</th>
                                                        <th>Kota Tinggal</th>
                                                        <th>Program</th>
                                                        <th>Registrasi Via</th>
                                                        <th>Tanggal Regist</th>
                                                        <th>Referensi</th>
                                                        <th>Nama Ahli Waris</th>
                                                        <th>No Ahli Waris</th>
                                                        <th>Aksi</th>
                                                        <th>dummy</th>
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
            "ajax": "<?php echo base_url(); ?>staff/jamaah/load_jamaah",
            columns: [{
                    data: 'first_name'
                },
                {
                    data: 'no_wa'
                },
                {
                    data: 'kabupaten_kota'
                },
                {
                    data: 'all_paket',
                    searchable: false,
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);"class="btn_paket">'+data+'</a>'
                    }
                },
                {
                    data: 'register_from',
                    render: function(data, type, row) {
                        if (data === 'app') {
                            return 'APLIKASI';
                        } else {
                            return 'VENOM';
                        }
                    }
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'referensi',
                    render: function(data, type, row) {
                        if (data == 'Agen' || data == 'agen') {
                            return 'KONSULTAN';
                        } else if (data) {
                            return data.toUpperCase();
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'nama_ahli_waris',
                    render: function(data, type, row) {
                        if (data == null ) {
                            return '-'
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'no_ahli_waris',
                    render: function(data, type, row) {
                        if (data == null ) {
                            return '-'
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'id_paket',
                    "render": function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat Detail</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
                    }

                },
                {
                    data: 'nama_paket',
                    visible: false
                },
                {
                    data: 'tgl_regist',
                    visible: false
                },
                {
                    data: 'second_name',
                    visible: false
                },
                {
                    data: 'last_name',
                    visible: false
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

            ],
            columnDefs: [{
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

                        return (data + ' ' + r1 + ' ' + r2).toUpperCase();
                    }

                },
                {
                    targets: 3,
                    orderData: [5]
                }
            ],
            order: [
                [5, 'desc']
            ]
        });

        $("#dataTable tbody").on("click", ".btn_paket", function() {
            var trid = $(this).closest('tr').attr('id_paket'); // table row ID Paket
            window.open("<?php echo base_url(); ?>staff/peserta?id_paket=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/jamaah/hapus?id=" + trid;
            }
        });

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/log?tbl=ja&id=" + trid, '_blank');
        });
    });
    </script>

</body>

</html>