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
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang Mengikuti Program
                                            <strong><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="140%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th></th>
                                                        <!-- <th>Kota Tinggal</th> -->
                                                        <th>Tanggal Berangkat</th>
                                                        <th>Program</th>
                                                        <!-- <th>Referensi</th> -->
                                                        <th>Status Pembayaran</th>
                                                        <th>Nilai Outstanding</th>
                                                        <th>Referensi</th>
                                                        <th>Nomor WhatsApp</th>
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
            'dom': 'lBfrtrip',
            "buttons": [{
                extend: 'excel',
                text: 'EXCEL',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5, 6, 7]
                },
            }],
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/input_dokumen/load_jamaah",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [
                {
                    data: 'first_name'
                },
                {
                    data: 'whole_name',
                    bVisible: false
                },
                // {
                //     data: 'no_wa_jamaah',
                // },
                {
                    data: 'tanggal_berangkat',
                    render: function(data, row, type) {
                        return moment(data).locale('id').format('ll')
                    }
                },
                // {
                //     data: 'kabupaten_kota'
                // },
                {
                    data: 'nama_paket',
                    searchable: false
                },
                // {
                //     data: 'referensi'
                // },
                {
                    data: 'lunas',
                },
                {
                    data: 'nilai_outstanding'
                },
                {
                    data: 'referensi'
                },
                {
                    data: 'no_wa_agen',
                    render: function(data, type, row) {
                        if (row['reference'] == 'Agen') {
                            return data
                        } else {
                            return row['no_wa']
                        }
                    }
                },
                {
                    data: 'lunas',
                    render: function(data, type, row) {
                        if (data == 0 || data == 2 ) {
                            return '<a href="<?php echo base_url() . "staff/finance/send_message?id="?>' + row['id_member'] + '" class="btn btn-success btn-icon-split btn-sm btn-whatsapp"><span class="icon text-white-50"><i class="fab fa-whatsapp"></i></span><span class="text">Kirim Pesan</span></a>'
                        }
                        return ''
                    } 
                },
                {
                    data: 'nama_paket',
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

                        return data + ' ' + r1 + ' ' + r2;
                    }

                },
                {
                    "targets": 4,
                    "render": function(data, type, row) {
                        var add = "";
                        if (data == 0) {
                            hasil = 'Belum DP';
                            color = 'crimson';
                            add = '';
                        } else {
                            if (data == 2) {
                                hasil = 'Sudah Cicil'
                                color = 'orange';
                                add =' <a href="javascript:void(0);" class="btn btn-success btn-sm invoice_btn"><i class="fa-solid fa-file-lines"></i> Invoice</a>';
                            } else if (data == 3) {
                                hasil = 'Kelebihan Bayar'
                                color = 'mediumturquoise';
                                add =' <a href="javascript:void(0);" class="btn btn-success btn-sm invoice_btn"><i class="fa-solid fa-file-lines"></i> Invoice</a>';
                            } 
                            else {
                                hasil = 'Sudah Lunas'
                                color = 'mediumaquamarine';
                                add =' <a href="javascript:void(0);" class="btn btn-success btn-sm invoice_btn"><i class="fa-solid fa-file-lines"></i> Invoice</a>';
                            }
                        }
                        return '<div class=""><span class="p-2 text-white rounded" style="background-color: ' +
                            color + ';">' + hasil + '</span>' + '<div class="mt-2">' + add + '</div>' + '</div>';
                        // return hasil;
                    }
                },
                {
                    targets: 3,
                    orderData: [4]
                }
            ],
            order: [
                [4, 'asc']
            ]
        });

        $("#dataTable tbody").on("click", ".invoice_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_member = $(this).closest('tr').attr('id_member'); // table row ID 
            window.open('<?php echo base_url(); ?>staff/info/riwayat_bayar?id=' + id_member, 'newwindow',
                'width=1000,height=800');
        });
    });
    </script>
</body>

</html>