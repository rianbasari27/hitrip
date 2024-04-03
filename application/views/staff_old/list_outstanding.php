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
                                        <h6 class="m-0 font-weight-bold text-primary">Detail Nilai Outstanding Jamaah
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
                                                        <th>Total Pembayaran</th>
                                                        <th>Nilai Outstanding</th>
                                                        <th>Tanggal Regist</th>
                                                        <th>Jatuh Tempo</th>
                                                        <th>Referensi</th>
                                                        <th>Nomor HP</th>
                                                        <th>Aksi</th>
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
            dom: 'lBfrtip',
            buttons: [{
                extend: 'excel',
                text: 'DOWNLOAD',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                },
            }],
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/finance/load_outstanding",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [{
                    data: 'id_paket',
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'first_name'
                },
                {
                    data: 'total_pembayaran'
                },
                {
                    data: 'nilai_outstanding',
                    render: function(data, type, row) {
                        add =
                            ' <a href="javascript:void(0);" class="btn btn-primary btn-sm riwayat_btn">Detail</a>';
                        return data + add;
                    }
                },
                {
                    data: "tgl_regist",
                    render: function(data, type, row) {
                        const tanggalSekarang = new Date(data);
                        const tanggalWaktuIndonesia = formatTanggalWaktuIndonesia(
                            tanggalSekarang);

                        return tanggalWaktuIndonesia
                    }
                },
                {
                    data: "jatuh_tempo"
                },
                {
                    data: 'referensi',
                },
                {
                    data: 'no_wa',
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="<?php echo base_url() . "staff/finance/send_message?id="?>' +
                            row['id_member'] +
                            '" class="btn btn-success btn-icon-split btn-sm btn-whatsapp"><span class="icon text-white-50"><i class="fab fa-whatsapp"></i></span><span class="text">Kirim Pesan</span></a>'
                    }

                }

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

        $("#dataTable tbody").on("click", ".riwayat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open('<?php echo base_url(); ?>staff/info/riwayat_bayar?id=' + trid, 'newwindow',
                'width=1000,height=800');
        });
    });
    </script>
</body>

</html>