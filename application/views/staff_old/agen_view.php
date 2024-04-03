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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Konsultan</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Nama konsultan yang terdaftar di
                                            sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="<?php echo base_url() ?>staff/broadcast_agen"
                                            class="btn btn-success mb-3"><i class="fas fa-fw fa-bullhorn"></i>
                                            Broadcast</a>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="150%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>ID Konsultan</th>
                                                        <th style="width: 300px;">Tanggal Terdaftar</th>
                                                        <th>WhatsApp</th>
                                                        <th>Bank</th>
                                                        <th>No. Rekening</th>
                                                        <th>Email</th>
                                                        <th>Kota</th>
                                                        <th style="width:400px">Upline</th>
                                                        <th style="width:500px">Aksi</th>
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
            "pageLength": 50,
            "lengthMenu": [
                [1000, 100, 50, 25, 10],
                [1000, 100, 50, 25, 10]
            ],
            dom: 'lBfrtip',
            buttons: [{
                extend: 'excel',
                text: 'EXCEL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
                },
                filename: function() {
                    return "Daftar Konsultan";
                },
                customizeData: function(data) {
                    for (var i = 0; i < data.body.length; i++) {
                        data.body[i][1] = '\u200C' + data.body[i][1];
                    }
                },
            }],
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo base_url(); ?>staff/kelola_agen/load_agen",
            columns: [{
                    data: 'id_agen',
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'nama_agen',
                    "render": function(data, type, row) {
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'no_agen'
                },
                {
                    data: 'tanggal_terdaftar',
                    render: function(data, row, type) {
                        if (data != null && data != '0000-00-00') {
                            var from = String(data).split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            var data = $.datepicker.formatDate('dd-mm-yy', f);
                            data = data;
                        } else {
                            data = '-';
                        }
                        return data;
                    }
                },
                {
                    data: 'no_wa'
                },
                {
                    data: 'nama_bank'
                },
                {
                    data: 'no_rekening'
                },
                {
                    data: 'email',
                    bVisible: false
                },
                {
                    data: 'kota'
                },
                {
                    data: 'upline_name'
                },
                {
                    data: 'DT_RowId',
                    "render": function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-warning btn-sm lihat_btn mb-1">Lihat Konsultan</a><br>\n\
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm network_btn">Network</a>'
                    }
                }
            ],
            order: [10, 'desc']
        });

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/kelola_agen/profile?id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".jamaah_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/kelola_agen/jamaah?id=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".network_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/agen_network?id=" + trid, '_blank');
        });
    });
    </script>

</body>

</html>