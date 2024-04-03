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


            <?php $this->load->view('staff/include/side_menu', ['perl_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Pending Booking</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang Pending Booking
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="mt-2">
                                                <label for="jenis_ambil">Pilih Jenis Pengambilan : </label>
                                                <select name="jenis_ambil" id="jenis_ambil"
                                                    class="border border-secondary rounded p-1" style="width: 175px;">
                                                    <option value="" selected>-- Pilih salah satu --</option>
                                                    <option value="langsung">WALK IN</option>
                                                    <option value="pengiriman">PENGIRIMAN</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:155px">Nama</th>
                                                        <th style="width:275px">Nama Program</th>
                                                        <th>Referensi</th>
                                                        <th>Nomor WhatsApp</th>
                                                        <th>Status Bayar</th>
                                                        <th style="width:137px;">Rencana Ambil</th>
                                                        <th style="width:137px;">Jenis</th>
                                                        <th style="width:200px">Aksi</th>
                                                        <th>Second Name</th>
                                                        <th>Last Name</th>
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
        $("#jenis_ambil").change(function() {
            reinitializeDataTable();
        });

        function reinitializeDataTable() {
            $('#dataTable tbody').off('mouseenter', 'tr');
            $('#dataTable tbody').off('mouseleave', 'tr');
            $('#dataTable tbody').off('click', 'tr');
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }
            loadDatatables();
        }

        loadDatatables();

        function loadDatatables() {
            var jenisAmbil = !$("#jenis_ambil").val() ? '' : $("#jenis_ambil").val();

            var dataTable = $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/perlengkapan_pending/load_pending",
                    "data": {
                        jenis_ambil: jenisAmbil
                    }
                },
                columns: [{
                        data: 'first_name'
                    },
                    {
                        data: 'nama_paket'
                    },
                    {
                        data: 'referensi',
                        render: function(data, type, row) {
                            if (data != null) {
                                return data.toUpperCase();
                            } else {
                                return data;
                            }
                        }
                    },
                    {
                        data: 'no_wa',
                        render: function(data, type, row) {
                            return '<a href="javascript:void(0);" class="blast_wa">' +
                                data + '</a>'
                        }
                    },
                    {
                        data: 'lunas',
                        render: function(data, type, row) {
                            var ket = '';
                            if (data === '0') {
                                ket = 'Belum Bayar';
                            } else if (data === '1') {
                                ket = 'Lunas';
                            } else if (data === '2') {
                                ket = 'Sudah Cicil';
                            } else if (data === '3') {
                                ket = 'Kelebihan Bayar';
                            }
                            return ket.toUpperCase();
                        }
                    },
                    {
                        data: 'tanggal_ambil',
                        render: function(data, type, row) {
                            var dt = new Date(data);
                            var tahun = dt.getFullYear();
                            var hari = dt.getDay();
                            var bulan = dt.getMonth();
                            var tanggal = dt.getDate();
                            var hariarray = new Array("Minggu,", "Senin,", "Selasa,", "Rabu,",
                                "Kamis,",
                                "Jum`at,", "Sabtu,");
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
                        data: 'jenis_ambil',
                        render: function(data, type, row) {
                            if (data != null) {
                                return data.toUpperCase()
                            } else {
                                return data
                            }
                        }
                    },
                    {
                        data: 'parent_id',
                        orderable: false,
                        render: function(data, type, row) {
                            return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a> \n\
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm ambil_btn">Kelola Booking</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a>'
                        }
                    },
                    {
                        data: 'whole_name',
                        bVisible: false,
                    },
                    {
                        data: 'two_name',
                        bVisible: false,
                    }
                ],
                columnDefs: [{
                        "targets": 0,
                        "render": function(data, type, row) {
                            if (data === null) {
                                r = '';
                            } else {
                                r = data.toUpperCase();
                            }
                            if (row['second_name'] === null) {
                                r1 = '';
                            } else {
                                r1 = row['second_name'].toUpperCase();
                            }
                            if (row['last_name'] === null) {
                                r2 = '';
                            } else {
                                r2 = row['last_name'].toUpperCase();
                            }

                            return (r + ' ' + r1 + ' ' + r2);
                        }

                    },
                    {
                        "targets": 4,
                        "render": function(data, type, row) {
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
                    }
                ],
                order: [
                    [5, 'asc']
                ],
            });
        }
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + id_jamaah +
                "&id_member=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".ambil_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href =
                "<?php echo base_url(); ?>staff/perlengkapan_pending/kelola?id_member=" + trid;
        });
        $("#dataTable tbody").on("click", ".blast_wa", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href =
                "<?php echo base_url(); ?>staff/finance/send_message?id=" + trid;
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href =
                    "<?php echo base_url(); ?>staff/perlengkapan_pending/hapus?id_member=" + trid;
            }
        });
    });
    </script>
</body>

</html>