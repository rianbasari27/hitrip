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


            <?php $this->load->view('staff/include/side_menu', ['store_bayar' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">List Order</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Order yang terdaftar pada sistem
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="120%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 20px;">No</th>
                                                        <th style="width:300px">Nama</th>
                                                        <th style="width:300px">Tanggal Order</th>
                                                        <th>Total Tagihan</th>
                                                        <th>Notes</th>
                                                        <th>Keterangan</th>
                                                        <th style="width:300px">Status Pesanan</th>
                                                        <th>Alamat Pengiriman</th>
                                                        <th style="width:250px">Aksi</th>
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
    function formatTanggalWaktuIndonesia(tanggal) {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            timeZoneName: 'short'
        };
        return tanggal.toLocaleDateString('id-ID', options);
    }
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/bayar_store/load_order",
            },
            columns: [{
                    data: 'DT_RowId',
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'nama'
                },
                {
                    data: 'order_date',
                    render: function(data, type, row) {
                        // Contoh penggunaan
                        const tgl = new Date(data);
                        const tglIndo = formatTanggalWaktuIndonesia(tgl);
                        return tglIndo;
                    }
                },
                {
                    data: 'total_amount'
                },
                {
                    data: 'notes'
                },
                {
                    data: 'lunas',
                    render: function(data, type, row) {
                        if (data == 1) {
                            result = "Lunas";
                        } else if (data == 2) {
                            result = "Sudah Cicil";
                        } else if (data == 3) {
                            result = "Kelebihan Bayar";
                        } else {
                            result = "Belum Bayar";
                        }

                        return result;
                    }
                },
                {
                    data: 'status'
                },
                {
                    data: 'alamat'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-success btn-sm va_btn mb-2">Virtual Account</a> \n\
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm bayar_btn mb-2">Bayar</a><br> \n\
                            <a href="javascript:void(0);" class="btn btn-warning btn-sm status_btn mb-2">Set Status</a><br> \n\
                                            <a href="javascript:void(0);" class="btn btn-info btn-sm log_btn">Log</a>'
                    }
                }
            ],
            // "columnDefs": [{
            //     "targets": 0,
            //     "render": function(data, type, row) {
            //         if (row['second_name'] === null) {
            //             r1 = '';
            //         } else {
            //             r1 = row['second_name'];
            //         }
            //         if (row['last_name'] === null) {
            //             r2 = '';
            //         } else {
            //             r2 = row['last_name'];
            //         }
            //         if (row['wg']) {
            //             r3 = '<a href="#" class="btn btn-warning btn-sm">WG</a>';
            //         } else {
            //             r3 = ''
            //         }

            //         return (data + ' ' + r1 + ' ' + r2 + ' ' + r3).toUpperCase() +
            //             '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a>';
            //     }

            // }],
            order: [
                [2, 'asc']
            ]
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pm&id=" + trid;
        });
        $("#dataTable tbody").on("click", ".bayar_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var customer_id = $(this).closest('tr').attr('customer_id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/bayar_store/bayar_manual?ido=" +
                trid + "&idc=" + customer_id;
        });
        $("#dataTable tbody").on("click", ".status_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url();?>staff/bayar_store/set_status?io=" + trid, '_blank');
        });

    });
    </script>

</body>

</html>