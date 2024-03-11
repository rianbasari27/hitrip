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
                            <h1 class="h3 mb-0 text-gray-800">Data Store</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Pembayaran Store yang Terdaftar Pada
                                            Sistem</strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>NAMA</th>
                                                        <th>TANGGAL PEMBAYARAN</th>
                                                        <th>TANGGAL INVOICE KELUAR</th>
                                                        <th>METODE PEMBAYARAN</th>
                                                        <th>KETERANGAN</th>
                                                        <th>Verified</th>
                                                        <th>Aksi</th>
                                                        <!-- <th>dummy</th> -->
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
        loadDatatables();

        function loadDatatables() {
            var dataTable = $('#dataTable').DataTable({
                pageLength: 100,
                lengthMenu: [
                    [1000, 500, 250, 100],
                    [1000, 500, 250, 100]
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/bayar_store/load_verifikasi"
                },
                columns: [{
                        data: 'id_member',
                        "render": function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'tanggal_bayar',
                        render: function(data, type, row) {
                            if (row['scan_bayar'] !== null) {
                                link =
                                    "<a class='btn btn-sm btn-primary' href='<?php echo base_url(); ?>" +
                                    row['scan_bayar'] +
                                    "' target='_blank'><span class='icon text-white'><i class='fas fa-file-alt'></i></span></a>";
                            } else {
                                link = '';
                            }
                            var dt = new Date(data);
                            var tahun = dt.getFullYear();
                            var hari = dt.getDay();
                            var bulan = dt.getMonth();
                            var tanggal = dt.getDate();
                            var hariarray = new Array("Sun,", "Mon,", "Tue,", "Wed,", "Thu,",
                                "Fri,", "Sat,");
                            var bulanarray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                            var z = hariarray[hari] + " " + ((tanggal < 10) ? "0" : "") +
                                tanggal +
                                " " + bulanarray[bulan] + " " + tahun + "<br>" + "( " + ((dt
                                    .getHours() < 10) ? "0" : "") + dt.getHours() + ":" + ((dt
                                    .getMinutes() < 10) ? "0" : "") + dt.getMinutes() + ":" + ((
                                    dt
                                    .getSeconds() < 10) ? "0" : "") + dt.getSeconds() + " )";
                            return z;
                        }
                    },
                    {
                        data: 'tanggal_bayar',
                        render: function(data, type, row) {
                            if (row['scan_bayar'] !== null) {
                                link =
                                    "<a class='btn btn-sm btn-primary' href='<?php echo base_url(); ?>" +
                                    row['scan_bayar'] +
                                    "' target='_blank'><span class='icon text-white'><i class='fas fa-file-alt'></i></span></a>";
                            } else {
                                link = '';
                            }
                            var dt = new Date(data);
                            var tahun = dt.getFullYear();
                            var hari = dt.getDay();
                            var bulan = dt.getMonth();
                            var tanggal = dt.getDate();
                            var hariarray = new Array("Sun,", "Mon,", "Tue,", "Wed,", "Thu,",
                                "Fri,", "Sat,");
                            var bulanarray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                            var z = hariarray[hari] + " " + ((tanggal < 10) ? "0" : "") +
                                tanggal +
                                " " + bulanarray[bulan] + " " + tahun + "<br>" + "( " + ((dt
                                    .getHours() < 10) ? "0" : "") + dt.getHours() + ":" + ((dt
                                    .getMinutes() < 10) ? "0" : "") + dt.getMinutes() + ":" + ((
                                    dt
                                    .getSeconds() < 10) ? "0" : "") + dt.getSeconds() + " )";
                            return z;
                        }
                    },
                    {
                        data: 'cara_pembayaran'
                    },
                    {
                        data: 'keterangan'
                    },
                    {
                        data: 'verified',
                        render: function(data, type, row) {
                            if (data == 1) {
                                v = 'Ya';
                            } else if (data == 2) {
                                v = 'Tidak';
                            } else {
                                v = 'Belum';
                            }
                            return v;
                        }
                    },
                    {
                        data: 'id_member',
                        render: function(data, type, row) {
                            var verifButton = '';
                            if (row['cara_pembayaran'] != 'BSI-VA' && !row['cara_pembayaran']
                                .startsWith("Duitku")) {
                                verifButton =
                                    '<a href="javascript:void(0);" class="btn btn-info btn-sm verifikasi_btn">Verifikasi</a>';
                            }
                            return verifButton +
                                '\n\
                                            <a href="javascript:void(0);" class="btn btn-warning btn-sm kuitansi_btn">Kuitansi</a> \n\
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Profile</a>\n\
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a>\n\
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
                        },
                        // defaultContent: 
                    },
                    // {
                    //     data: 'nama_paket',
                    //     visible: false
                    // },
                    // {
                    //     data: 'second_name',
                    //     visible: false
                    // },
                    // {
                    //     data: 'last_name',
                    //     visible: false
                    // },
                    // {
                    //     data: 'whole_name',
                    //     bVisible: false,
                    //     bSearchable: true
                    // },
                    // {
                    //     data: 'two_name',
                    //     bVisible: false,
                    //     bSearchable: true
                    // },

                ],
                // columnDefs: [{
                //     targets: 3,
                //     orderData: [5]
                // }],
                // order: [
                //     [6, 'desc'],
                //     [8, 'asc']
                // ]
            });
        }
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('lihat'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open(trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".verifikasi_btn", function() {
            var id_user = $(this).closest('tr').attr('id_user'); // table row ID 
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            var jenis = $(this).closest('tr').attr('jenis'); // table row ID 
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url();?>staff/bayar_store/verifikasi_data?idu=" + id_user + "&idb=" + id_pembayaran + "&jenis=" + jenis + "&io=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            var trid = $(this).closest('tr').attr('id');
            window.location.href = "<?php echo base_url(); ?>staff/bayar_store/hapusPembayaran?id=" +
                id_pembayaran + "&idm=" + trid;
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=by&id=" + id_pembayaran;
        });
    });
    </script>
</body>

</html>