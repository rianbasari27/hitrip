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
                        <div class="d-sm-flex align-items-center mb-5">
                            <h1 class="h3 mb-0 text-gray-800">Konsultan Network</h1><br>

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <h4 class="h4 mb-0 mr-2 mb-2"><?php echo $agen->nama_agen; ?></h4>
                                <?php if ($agen->suspend == 1) { ?>
                                    <h4 class="h4 mb-0 font-weight-bold mr-4" style="color: red;">(SUSPENDED)</h4>
                                <?php } ?>
                                <span style="color: #4ec738;">ID Konsultan <?php echo $agen->no_agen; ?></span>,
                                <span style="color: #d85b5b;">Telp. <?php echo $agen->no_wa; ?></span>
                            </div>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Upline</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="<?php echo base_url() . "staff/agen_network/atur_network/upline/" . $agen->id_agen; ?>" class="btn btn-warning btn-icon-split mb-5">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-edit" aria-hidden="true"></i>
                                            </span>
                                            <span class="text">Atur Upline</span>
                                        </a>
                                        <br>
                                        <?php if (!empty($upline)) { ?>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <tr>
                                                        <th style="width: 150px;">Nama</th>
                                                        <th style="width : 5px;">:</th>
                                                        <td><a href="<?php echo base_url() . 'staff/kelola_agen/profile?id=' . $upline->id_agen; ?>" target="_blank"><?php echo $upline->nama_agen; ?></a></td>
                                                    </tr>
                                                    <tr>
                                                        <th>ID Konsultan</th>
                                                        <th>:</th>
                                                        <td><?php echo $upline->no_agen; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Telepon</th>
                                                        <th>:</th>
                                                        <td>
                                                            <a href="https://wa.me/<?php echo $this->wa_number->convert($upline->no_wa); ?>" target="_blank">
                                                                <?php echo $this->wa_number->convert($upline->no_wa); ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <a href="<?php echo base_url() . 'staff/agen_network/hapus_upline/' . $agen->id_agen; ?>" class="btn btn-danger btn-sm hapusUpline_btn mb-1">Hapus Upline</a><br>
                                        <?php } else { ?>
                                            Belum ada upline
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Downline</h6>
                                    </div>
                                    <div class="card-body">
                                        <a href="<?php echo base_url() . "staff/agen_network/atur_network/downline/" . $agen->id_agen; ?>" class="btn btn-warning btn-icon-split mb-5">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-plus" aria-hidden="true"></i>
                                            </span>
                                            <span class="text">Tambah Downline</span>
                                        </a>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>ID Konsultan</th>
                                                        <th>WhatsApp</th>
                                                        <th>Provinsi</th>
                                                        <th>Kota</th>
                                                        <th>Kecamatan</th>
                                                        <th>Alamat</th>
                                                        <th>Poin<br>(cl)</th>
                                                        <th>Poin<br>(un)</th>
                                                        <th style="width:200px">Aksi</th>
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
                "pageLength": 100,
                "lengthMenu": [
                    [100, 50, 25, 10],
                    [100, 50, 25, 10]
                ],
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'EXCEL',
                    exportOptions: {
                        columns: [0, 1, 4, 6]
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
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/agen_network/load_downline",
                    "data": {
                        id_agen: '<?php echo $agen->id_agen; ?>'
                    }
                },
                columns: [{
                        data: 'nama_agen'
                    },
                    {
                        data: 'no_agen'
                    },
                    {
                        data: 'no_wa'
                    },
                    {
                        data: 'provinsi'
                    },
                    {
                        data: 'kota'
                    },
                    {
                        data: 'kecamatan'
                    },
                    {
                        data: 'alamat',
                        bVisible: false
                    },
                    {
                        data: 'claimed_point'
                    },
                    {
                        data: 'unclaimed_point'
                    },
                    {
                        data: 'DT_RowId',
                        "render": function(data, type, row) {
                            return '<a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mb-1">Hapus</a><br>\n\
                            <a href="javascript:void(0);" class="btn btn-warning btn-sm lihat_btn mb-1">Profile</a>\n\
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm jamaah_btn mb-1">Jamaah</a>\n\
                                        <a href="javascript:void(0);" class="btn btn-success btn-sm network_btn mb-1">Network</a>'
                        }
                    }
                ]
            });

            $("#dataTable tbody").on("click", ".lihat_btn", function() {
                var trid = $(this).closest('tr').attr('id'); // table row ID
                window.open("<?php echo base_url(); ?>staff/kelola_agen/profile?id=" + trid, '_blank');
            });
            $("#dataTable tbody").on("click", ".hapus_btn", function() {
                // table row ID
                if (confirm("Yakin untuk hapus?")) {
                    var idDownline = $(this).closest('tr').attr('id');
                    var idAgen = <?php echo $agen->id_agen; ?>;
                    window.location.href = "<?php echo base_url(); ?>staff/agen_network/hapus_downline/" + idAgen + "/" + idDownline;
                };
            });
            $(document).on("click", ".hapusUpline_btn", function() {
                event.preventDefault();
                // table row ID
                if (confirm("Yakin untuk hapus?")) {
                    var href = $(this).attr('href');
                    window.location.href = href;
                };
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