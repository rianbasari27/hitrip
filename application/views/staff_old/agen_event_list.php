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


            <?php $this->load->view('staff/include/side_menu',['agen_event' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Event Konsultan</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Event yang Terdaftar
                                            didalam Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">No</th>
                                                        <th style="width: 200px;">Nama Program</th>
                                                        <th>Harga</th>
                                                        <th style="width: 200px;">Tanggal</th>
                                                        <th style="width: 200px;">Tanggal Selesai</th>
                                                        <th>Pax</th>
                                                        <th style="width: 100px;">Lokasi</th>
                                                        <th style="width: 100px;">Publish</th>
                                                        <th style="width: 200px">Aksi</th>
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
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/agen_paket/load_event",
            },
            "columns": [{
                    data: 'DT_RowId',
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'nama_paket',
                    render: function(data, type, row) {
                        return data + ' ' + row['batch']
                    }
                },
                {
                    data: 'harga'
                },
                {
                    data: 'tanggal',
                    render: function(data, type, row) {
                        // var from = data.split("-");
                        // var f = new Date(from[0], from[1] - 1, from[2]);
                        // var f = new Date(from[0], from[1] - 1, from[2]);
                        // var data = $.datepicker.formatDate('dd M yy', f);
                        // return data;
                        const tanggal = new Date(data);
                        const bulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November',
                            'Desember'
                        ];
                        const options = {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: false,
                            timeZone: 'Asia/Jakarta'
                        };
                        const tanggalFormat = tanggal.toLocaleDateString('id-ID', options);
                        const tanggalString = tanggalFormat.replace(
                            /(\d+) (\w+) (\d+) (\d+:\d+)/,
                            function(match, day, monthIndex, year, time) {
                                return day + ' ' + bulan[bulan.indexOf(monthIndex) - 1] +
                                    ' ' + year + ' ' + time;
                            });
                        return tanggalString;
                    }
                },
                {
                    data: 'tanggal_selesai',
                    render: function(data, type, row) {
                        // var from = data.split("-");
                        // var f = new Date(from[0], from[1] - 1, from[2]);
                        // var f = new Date(from[0], from[1] - 1, from[2]);
                        // var data = $.datepicker.formatDate('dd M yy', f);
                        // return data;
                        // Mengonversi tanggal ke format lokal Indonesia
                        const tanggalSelesai = new Date(data);
                        const bulan = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November',
                            'Desember'
                        ];
                        const options = {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            hour12: false,
                            timeZone: 'Asia/Jakarta'
                        };
                        const tanggalSelesaiFormat = tanggalSelesai.toLocaleDateString('id-ID',
                            options);
                        const tanggalSelesaiString = tanggalSelesaiFormat.replace(
                            /(\d+) (\w+) (\d+) (\d+:\d+)/,
                            function(match, day, monthIndex, year, time) {
                                return day + ' ' + bulan[bulan.indexOf(monthIndex) - 1] +
                                    ' ' + year + ' ' + time;
                            });
                        return tanggalSelesaiString;
                    }
                },
                {
                    data: 'pax'
                },
                {
                    data: 'lokasi'
                },
                {
                    data: 'publish',
                    render: function(data, type, row) {
                        if (data === '1') {
                            return 'Iyaa'
                        } else {
                            return 'Tidak'
                        }
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn mt-1">Lihat</a> \n\
                                <a href="javascript:void(0);" class="btn btn-success btn-sm edit_btn mt-1">Edit</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mt-1">Hapus</a> \n\
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm insert_btn mt-1">Isi Otomatis</a>'
                    }
                },
            ],
            "order": [
                [3, "desc"]
            ],
            "columnDefs": [
                // {
                //     "targets": 3,
                //     "render": function(data, type, row) {
                //     var dt = new Date(data);
                //     var tahun = dt.getFullYear();
                //     var hari = dt.getDay();
                //     var bulan = dt.getMonth();
                //     var tanggal = dt.getDate();
                //     var hariarray = new Array("Sun,", "Mon,", "Tue,", "Wed,", "Thu,",
                //         "Fri,", "Sat,");
                //     var bulanarray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun",
                //         "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                //     var z = hariarray[hari] + " " + ((tanggal < 10) ? "0" : "") + tanggal +
                //         " " + bulanarray[bulan] + " " + tahun + "<br>" + "( " + ((dt
                //             .getHours() < 10) ? "0" : "") + dt.getHours() + ":" + ((dt
                //             .getMinutes() < 10) ? "0" : "") + dt.getMinutes() + ":" + ((dt
                //             .getSeconds() < 10) ? "0" : "") + dt.getSeconds() + " )";
                //     return z;
                // }
                // }
            ]
        });

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var nama = $(this).closest('tr').attr('nama'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/agen_paket/list_konsultan_event?nama=" + nama +
                "&id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".bc_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".edit_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/agen_paket/ubah_event?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/agen_paket/hapus?id=" + trid;
            }
        });
        $("#dataTable tbody").on("click", ".insert_btn", function() {
            var id_paket = $(this).closest('tr').attr('id_paket'); // table row ID 
            var id = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk mengisi secara otomatis?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/agen_paket/insert?id_paket=" +
                    id_paket + "&id=" + id;
            }
        });

        $("#dataTable tbody").on("click", ".manasik_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast/manasik?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=ae&id=" + trid;
        });
    });
    </script>

</body>

</html>