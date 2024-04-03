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


            <?php $this->load->view('staff/include/side_menu', ['status_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800"><strong
                                    id="nama_paket"><?php echo $nama_paket; ?></strong></h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang sudah mengambil
                                            <strong><?php echo $barang[0]->nama_barang; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 150px;">Nama</th>
                                                                <th>Status Ambil</th>
                                                                <th>Tanggal Ambil</th>
                                                                <th>Nama Penginput</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
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
    $(document).ready(function() {
        $('#dataTable').DataTable({
            pageLength: 100,
            lengthMenu: [
                [100, 50, 25, 10],
                [100, 50, 25, 10]
            ],
            "processing": true,
            dom: 'lBfrtip',
            buttons: [{
                extend: 'excel',
                text: 'EXCEL',
                filename: function() {
                    var nama = document.getElementById("nama_paket").innerHTML
                    return "Detail Perlengkapan " + nama;
                },
                customizeData: function(data) {
                    for (var i = 0; i < data.body.length; i++) {
                        data.body[i][1] = '\u200C' + data.body[i][1];
                    }
                },
            }],
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/perlengkapan_peserta/load_detail",
                "data": {
                    id_paket: "<?php echo $id_paket; ?>",
                    id_logistik: "<?php echo $id_log;?>",
                    status: "<?php echo $status;?>",
                }
            },
            columns: [{
                    data: 'first_name',
                    render: function(data, type, row) {
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

                        return (data + ' ' + r1 + ' ' + r2 + ' ' + r3).toUpperCase();
                    }
                },
                {
                    data: 'status_ambil',
                    render: function(data, type, row) {
                        if (data == 1) {
                            return "Sudah Ambil"
                        } else {
                            return "Belum Ambil"
                        }
                    }
                },
                {
                    data: 'tanggal_ambil',
                    render: function(data, type, row) {
                        if (data != null) {
                            return data
                        } else {
                            return '-'
                        }
                    }
                },
                {
                    data: 'nama_penginput',
                    render: function(data, type, row) {
                        if (data != null) {
                            return data
                        } else {
                            return '-'
                        }
                    }
                }
            ],
            // "columnDefs": [{
            //             "targets": 0,
            //             "data": "nama_paket",

            //         },
            //         {
            //             "targets": 1,
            //             "data": "tanggal_berangkat",
            //             "render": function(data, type, row) {
            //                 return data;
            //             }
            //         },
            //         {
            //             "targets": 2,
            //             "data": "jumlah_seat",
            //         },
            //         {
            //             "targets": -1,
            //             render: function(data, type, row) {
            //                 return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a>'
            //             }
            //         },
            //         {
            //             "targets": perlDefs,
            //             render: function(data, type, row) {
            //                 return "Sudah : " + data + "<br>" +
            //                        "Belum : " + (row['jumlah_seat'] - data) 
            //             }
            //         }
            //     ],
            // "order": [
            //     [1, "desc"]
            // ],
        });

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/paket/lihat?id=" + trid, '_blank');
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

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pu&id=" + trid;
        });
    });
    </script>

</body>

</html>