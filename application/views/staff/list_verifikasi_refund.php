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


            <?php $this->load->view('staff/include/side_menu', ['refund_pembayaran' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Verifikasi Refund</h1>
                        </div>
                        <div class='row'>
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get"
                                            action="<?php echo base_url(); ?>staff/finance/verifikasi_refund">
                                            <div class="form-group">
                                                <label class="col-form-label">Pilih Paket Umroh dibawah, atau
                                                    <a href="<?php echo base_url(); ?>staff/info/lihat_jamaah"
                                                        class="btn btn-warning btn-icon-split btn-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                        <span class="text">Lihat Semua Paket</span>
                                                    </a>
                                                </label>

                                                <select name="id_paket" class="form-control">
                                                    <option value="all">SEMUA PAKET</option>
                                                    <?php
                                                    $flagNextSchedule = 1;
                                                    $flagFuture = 1;
                                                    $flagLast = 1;
                                                    ?>
                                                    <?php foreach ($paket as $pkt) { ?>
                                                    <?php
                                                        $futureTrue = strtotime($pkt->tanggal_berangkat) > strtotime('now');
                                                        if ($flagNextSchedule == 1) {
                                                            echo "<optgroup label='Next Trip'>";
                                                            $prepareClose = 1;
                                                            $flagNextSchedule = 0;
                                                        } elseif ($flagFuture == 1 && $futureTrue == true) {
                                                            echo "</optgroup>";
                                                            echo "<optgroup label='Future Trips'>";
                                                            $flagFuture = 0;
                                                        } elseif ($flagLast == 1 && $futureTrue == false) {
                                                            $flagLast = 0;
                                                            echo "</optgroup>";
                                                            echo "<optgroup label='Last Trips'>";
                                                        }
                                                        ?>
                                                    <option value="<?php echo $pkt->id_paket; ?>"
                                                        <?php echo $pkt->id_paket == $id_paket ? 'selected' : ''; ?>>
                                                        <?php echo $pkt->nama_paket; ?>
                                                        (<?php echo date_format(date_create($pkt->tanggal_berangkat), "d F Y"); ?>)
                                                    </option>
                                                    <?php } ?>
                                                    <?php echo "</optgroup>"; ?>
                                                </select>
                                            </div>
                                            <button class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Submit</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang Mengikuti Program
                                            <strong id="nama_paket"><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <form
                                                action="<?php echo base_url().'staff/finance/verifikasi_refund?id_paket=all'?>"
                                                method="get">
                                                <input type="hidden" name="id_paket" id="id_paket"
                                                    value="<?php echo $id_paket ?>">
                                                <div>
                                                    <label for="date_start">Pilih tanggal</label>
                                                    <input type="date" name="date_start" id="date_start"
                                                        class="border border-secondary rounded p-1"> -
                                                    <input type="date" name="date_end" id="date_end"
                                                        class="border border-secondary rounded p-1">
                                                </div>
                                                <div class="mt-2">
                                                    <label for="payments_method">Pilih metode Pembayaran</label>
                                                    <select name="payments_method" id="payments_method"
                                                        class="border border-secondary rounded p-1"
                                                        style="width: 250px;">
                                                        <option value="" selected>-- Pilih Metode Pembayaran --</option>
                                                        <option value="Transfer BSI">Transfer BSI</option>
                                                        <option value="Transfer Mandiri">Transfer Mandiri</option>
                                                        <option value="Transfer BCA">Transfer BCA</option>
                                                        <option value="Tunai">Tunai</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>NO</th>
                                                        <th>NAMA</th>
                                                        <th>PROGRAM</th>
                                                        <th>TOTAL TAGIHAN</th>
                                                        <th>TOTAL PEMBAYARAN</th>
                                                        <th>TOTAL PENGEMBALIAN</th>
                                                        <th>STATUS</th>
                                                        <th>TANGGAL PENGEMBALIAN</th>
                                                        <th>JENIS REFUND</th>
                                                        <th>CARA PENGEMBALIAN</th>
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
        $("#date_start, #date_end, #payments_method").change(function() {
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
            var dateStart = !$("#date_start").val() ? '' : $("#date_start").val();
            var dateEnd = !$("#date_end").val() ? '' : $("#date_end").val();
            var paymentsMethod = !$("#payments_method").val() ? '' : $("#payments_method").val();

            var dataTable = $('#dataTable').DataTable({
                pageLength: 100,
                lengthMenu: [
                    [1000, 500, 250, 100],
                    [1000, 500, 250, 100]
                ],
                "processing": true,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 7, 8, 9]
                    },
                    filename: function() {
                        var nama = document.getElementById("nama_paket").innerHTML
                        return nama;
                    }
                }],
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/finance/load_verifikasi_refund",
                    "data": {
                        id_paket: <?php echo $id_paket; ?>,
                        date_start: dateStart,
                        date_end: dateEnd,
                        payments_method: paymentsMethod
                    }
                },
                columns: [{
                        data: 'id_member',
                        "render": function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
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

                            return data + ' ' + r1 + ' ' + r2;
                        }
                    },
                    {
                        data: 'nama_paket',
                        render: function(data, type, row) {
                            var date = row['tanggal_berangkat'];
                            var from = date.split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            var date = $.datepicker.formatDate('dd M yy', f);
                            return data + '<br> ( ' + date + ' )';
                        }
                    },
                    {
                        data: 'total_tagihan',
                    },
                    {
                        data: 'jumlah_pembayaran',
                    },
                    {
                        data: 'jumlah_bayar',
                        render: function(data, type, row) {
                            if (row['scan_bayar'] !== null) {
                                link =
                                    "<a class='btn btn-sm btn-primary' href='<?php echo base_url(); ?>" +
                                    row['scan_bayar'] +
                                    "' target='_blank'><span class='icon text-white'><i class='fas fa-file-alt'></i></span></a>";
                            } else {
                                link = '';
                            }
                            return data + ' ' + link;
                        }
                    },
                    {
                        data: 'verified',
                        render: function(data, type, row) {
                            if (data == 1) {
                                v = 'SUDAH DIKEMBALIKAN';
                            } else if (data == 2) {
                                v = 'BELUM DIKEMBALIKAN';
                            } else {
                                v = 'BELUM DIVERIFIKASI';
                            }
                            return v;
                        }
                    },
                    {
                        data: 'tanggal_bayar',
                        render: function(data, type, row) {
                            if (data != "") {
                                var dt = new Date(data);
                                var tahun = dt.getFullYear();
                                var hari = dt.getDay();
                                var bulan = dt.getMonth();
                                var tanggal = dt.getDate();
                                var hariarray = new Array("Sun,", "Mon,", "Tue,", "Wed,", "Thu,",
                                    "Fri,", "Sat,");
                                var bulanarray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                                var z = hariarray[hari] + " " + ((tanggal < 10) ? "0" : "") + tanggal +
                                    " " + bulanarray[bulan] + " " + tahun + "<br>" + "( " + ((dt
                                        .getHours() < 10) ? "0" : "") + dt.getHours() + ":" + ((dt
                                        .getMinutes() < 10) ? "0" : "") + dt.getMinutes() + ":" + ((dt
                                        .getSeconds() < 10) ? "0" : "") + dt.getSeconds() + " )";
                                data = z
                            } else {
                                data = ' ';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'keterangan',
                        render: function(data, type, row) {
                            if (!data) {
                                return "";
                            }
                            return data.toUpperCase();
                        }
                    },
                    {
                        data: 'cara_pembayaran',
                        render: function(data, type, row) {
                            if (!data) {
                                return "";
                            }
                            return data.toUpperCase();
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
                columnDefs: [{
                    targets: 3,
                    orderData: [5]
                }],
                order: [
                    [7, 'desc'],
                    [8, 'asc']
                ]
            });
        }
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + id_jamaah +
                "&id_member=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".verifikasi_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/finance/verifikasi_data?idj=" +
                id_jamaah + "&idm=" + trid + "&idb=" + id_pembayaran + "&refund=1";
        });
        $("#dataTable tbody").on("click", ".kuitansi_btn", function() {
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            var verified = $(this).closest('tr').attr('verified'); // table row ID 
            var id_member = $(this).closest('tr').attr('id'); // table row ID 
            if (verified !== '1') {
                confirm('Pembayaran Belum diverifikasi');
            } else {
                window.location.href = "<?php echo base_url(); ?>kuitansi_dl/download?id=" +
                    id_pembayaran + "&idm=" + id_member;
                // window.open("<?php echo base_url(); ?>staff/finance/kuitansi?id=" + id_pembayaran);
            }
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=by&id=" + id_pembayaran;
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            var trid = $(this).closest('tr').attr('id');
            window.location.href = "<?php echo base_url(); ?>staff/finance/hapusRefund?id=" +
                id_pembayaran + "&idm=" + trid;
        });
    });
    </script>
</body>

</html>