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


            <?php $this->load->view('staff/include/side_menu', ['summary' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Data Jamaah Lebih Bayar</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Detail Jamaah Lebih Bayar 
                                            <strong><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Total Lebih Bayar</th>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.36/moment-timezone.min.js"></script>
    <?php $this->load->view('staff/include/script_view'); ?>
    <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            // 'rowCallback': function(row, data, index) {
            //     if (data['lunas'] == 1 || data['lunas'] == 3) {
            //         $(row).css('background-color', '#71cd66');
            //         $(row).css('color', 'black');
            //     } else {
            //         $(row).css('background-color', '#fc8b8b');
            //         $(row).css('color', 'black');
            //     }
            // },   
            "processing": true,
            "serverSide": true,
            'dom': 'lfrtrip',
            // "buttons": [{
            //     extend: 'excel',
            //     text: 'EXCEL',
            //     exportOptions: {
            //         columns: [0, 1, 2, 3, 4, 5, 6, 7]
            //     },
            // }],
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/finance/load_lebih_bayar",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [
                {
                    data: 'id_paket',
                    render: function (data, type, full, meta) {
                        return meta.row + 1;
                    } 
                }, 
                {
                    data: 'first_name'
                },
                {
                    data: 'lebih_bayar',
                    searchable: false
                },
                // {
                //     data: 'tanggal_berangkat',
                //     render: function(data, row, type) {
                //         return moment(data).locale('id').format('ll')
                //     }
                // },

            ],
            columnDefs: [{
                    "targets": 1,
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

                        return data + ' ' + r1 + ' ' + r2;
                    }

                },
                // {
                //     targets: 3,
                //     orderData: [5]
                // }
            ],
            order: [
                [0, 'asc']
            ]
        });
    });
    </script>
</body>

</html>