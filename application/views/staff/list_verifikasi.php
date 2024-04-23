<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>

</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <?php $this->load->view('staff/include/side_menu', ["finance" => true, "verif_bayar" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Verifikasi Pembayaran</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-2 border-left-primary rounded">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Program</h6>
                                    </div>
                                    <div class="card-body">
                                        <select name="id_paket" id="id_paket" class="form-select">
                                            <option value="0">SEMUA PAKET</option>
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
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary rounded">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang Mengikuti Program
                                            <strong id="nama_paket"><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table id="dataTable" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>NAMA</th>
                                                    <th>PROGRAM</th>
                                                    <th>HARGA PAKET</th>
                                                    <th>NILAI PEMBAYARAN</th>
                                                    <th>JUMLAH PAX</th>
                                                    <th>TANGGAL PEMBAYARAN</th>
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
                    <!-- [ content ] End -->

                    <?php $this->load->view('staff/include/footer_view') ?>
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->
    <?php $this->load->view('staff/include/script_view') ?>
    <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#id_paket").change(function() {
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
            var idPaket = !$("#id_paket").val() ? '' : $("#id_paket").val();
            var dataTable = new DataTable('#dataTable', {
                scrollX: true,
                layout: {
                    bottomEnd: {
                        paging: {
                            boundaryNumbers: false
                        }
                    }
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo base_url(); ?>staff/finance/load_verifikasi",
                    data: {
                        id_paket: idPaket
                    }
                },
                order: [
                    [6, "desc"]
                ],
                columnDefs: [{
                        targets: 0,
                        data: 'DT_RowId',
                        render: function(data, type, full, meta) {
                            var page = meta.settings._iDisplayStart / meta.settings
                                ._iDisplayLength;
                            return page * meta.settings._iDisplayLength + meta.row + 1
                        }
                    },
                    {
                        targets: 1,
                        data: 'name',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 2,
                        data: 'nama_paket',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 3,
                        data: 'harga',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 4,
                        data: 'jumlah_bayar',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 5,
                        data: 'jumlah_pax',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 6,
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
                        targets: 7,
                        data: 'cara_pembayaran',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 8,
                        data: 'notes',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 9,
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
                        targets: -1,
                        data: null,
                        defaultContent: '<a href="javascript:void(0);" class="btn btn-primary btn-xs rounded-xs lihat_btn mt-1">Detail</a> \n\
                                <a href="javascript:void(0);" class="btn btn-warning btn-xs rounded-xs verifikasi_btn mt-1">Verifikasi</a> \n\
                                <a href="javascript:void(0);" class="btn btn-info btn-xs rounded-xs kuitansi_btn mt-1">kuitansi</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-xs rounded-xs hapus_btn mt-1">Hapus</a> \n\
                                <a href="javascript:void(0);" class="btn btn-success btn-xs rounded-xs log_btn mt-1">Log</a>'
                    }
                ]
            });
        }

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_user = $(this).closest('tr').attr('id_user'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_user?id=" + id_user, '_blank');
        });
        $("#dataTable tbody").on("click", ".verifikasi_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_user = $(this).closest('tr').attr('id_user'); // table row ID 
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/finance/verifikasi_data?idj=" +
                id_user + "&idm=" + trid + "&idb=" + id_pembayaran;
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
            window.location.href = "<?php echo base_url(); ?>staff/finance/hapusPembayaran?id=" +
                id_pembayaran + "&idm=" + trid;
        });
    });
    </script>
</body>

</html>