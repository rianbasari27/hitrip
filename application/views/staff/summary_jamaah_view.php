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
                            <h1 class="h3 mb-0 text-gray-800">Data Summary Jamaah</h1>
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
                        <div class='row'>
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get"
                                            action="<?php echo base_url(); ?>staff/finance/summary_jamaah">
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
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Summary Pembayaran Jamaah
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <!-- <a href="<?php echo base_url() . 'staff/finance/list_summary_jamaah'; ?>"
                                                class="btn btn-success btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-file-excel"></i>
                                                </span>
                                                <span class="text">Download Summary Pembayaran</span>
                                            </a> -->
                                            <button class="btn btn-success btn-icon-split btn-sm" id="btn-whatsapp">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-paper-plane"></i>
                                                </span>
                                                <span class="text">Kirim Pesan Tagihan</span>
                                            </button>
                                        </div>

                                        <div class="mb-3">
                                            <form
                                                action="<?php echo base_url().'staff/finance/summary_jamaah?id_paket=all'?>"
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
                                                    <label for="status_bayar">Pilih Status Pembayaran</label>
                                                    <select name="status_bayar" id="status_bayar"
                                                        class="border border-secondary rounded p-1"
                                                        style="width: 250px;">
                                                        <option value="" selected>-- Pilih Status Pembayaran --</option>
                                                        <option value="1">Lunas</option>
                                                        <option value="2">Sudah Cicil</option>
                                                        <option value="3">Kelebihan Bayar</option>
                                                        <option value="0">Belum DP</option>
                                                    </select>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="status_berangkat">Pilih Status Keberangkatan</label>
                                                    <select name="status_berangkat" id="status_berangkat"
                                                        class="border border-secondary rounded p-1"
                                                        style="width: 250px;">
                                                        <option value="" selected>-- Pilih Status Keberangkatan --
                                                        </option>
                                                        <option value="1">Sudah Berangkat</option>
                                                        <option value="0">Belum Berangkat</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="140%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>ID Member</th>
                                                        <th style="width:150px">Nama</th>
                                                        <th>Program</th>
                                                        <th>Tanggal Berangkat</th>
                                                        <th>Harga Program</th>
                                                        <th>Jumlah Pembayaran</th>
                                                        <th>Nilai Outstanding</th>
                                                        <th>Lebih Bayar</th>
                                                        <th>Status Pembayaran</th>
                                                        <th>Jatuh Tempo</th>
                                                        <th>Tanggal Pelunasan</th>
                                                        <th>Nama Konsultan</th>
                                                        <th>No. WhatsApp</th>
                                                        <th>Blast Terakhir</th>
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
        $("#date_start, #date_end, #status_bayar, #status_berangkat").change(function() {
            reinitializeDataTable();
        });

        $('#btn-whatsapp').on("click", function(event) {
            var dateStart = !$("#date_start").val() ? '' : $("#date_start").val();
            var dateEnd = !$("#date_end").val() ? '' : $("#date_end").val();
            var statusBayar = !$("#status_bayar").val() ? '' : $("#status_bayar").val();
            var statusBerangkat = !$("#status_berangkat").val() ? '' : $("#status_berangkat").val();
            $.getJSON("<?php echo base_url() . 'staff/finance/send_jamaah';?>", {
                    id_paket: "<?php echo $id_paket;?>",
                    statusBayar: statusBayar,
                    statusBerangkat: statusBerangkat,
                    dateStart: dateStart,
                    dateEnd: dateEnd
                }).done(function(json) {
                    alert('Pesan berhasil dikirim!');
                })
                .fail(function(jqxhr, textStatus, error) {
                    alert('Beberapa pesan terkirim');
                });
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
            var statusBayar = !$("#status_bayar").val() ? '' : $("#status_bayar").val();
            var statusBerangkat = !$("#status_berangkat").val() ? '' : $("#status_berangkat").val();

            var dataTable = $('#dataTable').DataTable({
                'rowCallback': function(row, data, index) {
                    if (data['status_pembayaran'] == 'Sudah Lunas') {
                        $(row).css('background-color', 'lightgreen');
                        $(row).css('color', 'black');
                    } else if (data['status_pembayaran'] == 'Sudah Cicil') {
                        $(row).css('background-color', 'orange');
                        $(row).css('color', 'black');
                    } else if (data['status_pembayaran'] == 'Belum DP') {
                        $(row).css('background-color', 'red');
                        $(row).css('color', 'black');
                    } else if (data['status_pembayaran'] == 'Kelebihan Bayar') {
                        $(row).css('background-color', 'lightsteelblue');
                        $(row).css('color', 'black');
                    }

                    // if (data['publish'] == 0) {
                    //     $(row).css('background-color', '#63d5ff');
                    //     $(row).css('color', 'black');
                    // }

                },
                "processing": true,
                "serverSide": true,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'EXCEL',
                }],
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/finance/load_jamaah",
                    "data": {
                        id_paket: "<?php echo $id_paket; ?>",
                        date_start: dateStart,
                        date_end: dateEnd,
                        status_bayar: statusBayar,
                        status_berangkat: statusBerangkat,
                    }
                },
                "columns": [{
                        "data": 'DT_RowId',
                        "bVisible": false
                    },
                    {
                        "data": 'first_name'
                    },
                    {
                        "data": 'nama_paket',
                        "render": function(data, type, row) {
                            return data + ' (' + row['tanggal_berangkat'] + ')'
                        }
                    },
                    {
                        "data": 'tanggal_berangkat',
                        "bVisible": false
                    },
                    {
                        "data": 'harga'
                    },
                    {
                        "data": 'jumlah_pembayaran',
                        "render": function(data, type, row) {
                            if (row['jumlah_keluarga'] > 1) {
                                jumlahKeluarga = data + '<br>(' + row['jumlah_keluarga'] +
                                    ' orang)'
                            } else {
                                jumlahKeluarga = data
                            }
                            return jumlahKeluarga
                        }
                    },
                    {
                        "data": 'nilai_outstanding'
                    },
                    {
                        "data": 'lebih_bayar'
                    },
                    {
                        "data": 'status_pembayaran'
                    },
                    {
                        "data": 'jatuh_tempo'
                    },
                    {
                        "data": 'tanggal_pelunasan'
                    },
                    {
                        "data": 'nama_agen'
                    },
                    {
                        "data": 'no_wa'
                    },
                    {
                        "data": 'last_blast',
                        render: function(data, type, row) {
                            if (data == '') {
                                return data
                            } else {
                                var dt = new Date(data);
                                var tahun = dt.getFullYear();
                                var hari = dt.getDay();
                                var bulan = dt.getMonth();
                                var tanggal = dt.getDate();
                                var hariarray = new Array("Minggu,", "Senin,", "Selasa,",
                                    "Rabu,",
                                    "Kamis,",
                                    "Jum`at,", "Sabtu,");
                                var bulanarray = new Array("Jan", "Feb", "Mar", "Apr", "May",
                                    "Jun",
                                    "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                                var z = hariarray[hari] + " " + ((tanggal < 10) ? "0" : "") +
                                    tanggal +
                                    " " + bulanarray[bulan] + " " + tahun + "<br>" + "( " + ((dt
                                        .getHours() < 10) ? "0" : "") + dt.getHours() + ":" + ((
                                        dt
                                        .getMinutes() < 10) ? "0" : "") + dt.getMinutes() +
                                    ":" + ((
                                        dt
                                        .getSeconds() < 10) ? "0" : "") + dt.getSeconds() +
                                    " )";
                                var btn = '<a href="javascript:void(0);" class="btn btn-primary btn-sm log_btn">Log</a>';
                                return z + btn;
                            }

                        }
                    },
                ],
                "columnDefs": [{
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
                    //     "targets": -1,
                    //     "data": null,
                    //     "defaultContent": '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat</a> \n\
                    //                                 <a href="javascript:void(0);" class="btn btn-warning btn-sm bc_btn">Broadcast</a> \n\
                    //                                 <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
                    //                             <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
                    // },
                    // {
                    //     targets: 3,
                    //     "render": function(data, type, row) {
                    //         var from = row['tanggal_berangkat'].split("-");
                    //         var f = new Date(from[0], from[1] - 1, from[2]);
                    //         return data + $.datepicker.formatDate('dd M yy', f);
                    //     }
                    // },
                    // {
                    //     targets: 11,
                    //     "render": function(data, type, row) {
                    //         return data;
                    //     }
                    // }
                ]
            });
        }
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/log_wa?id=" + trid);
        });
        // $("#dataTable tbody").on("click", ".harga_paket", function() {
        //     var trid = $(this).closest('tr').attr('id'); // table row ID 
        //     window.open("<?php echo base_url(); ?>staff/paket/lihat?id=" + trid, '_blank');
        // });
        // $("#dataTable tbody").on("click", ".discount_paket", function() {
        //     var trid = $(this).closest('tr').attr('id'); // table row ID 
        //     window.open("<?php echo base_url(); ?>staff/finance/diskon_log?id=" + trid, '_blank');
        // });
        // $("#dataTable tbody").on("click", ".total_exclude", function() {
        //     var trid = $(this).closest('tr').attr('id'); // table row ID 
        //     window.open("<?php echo base_url(); ?>staff/finance/detail_exclude?id=" + trid, '_blank');
        // });
        // $("#dataTable tbody").on("click", ".total_lebih_bayar", function() {
        //     var trid = $(this).closest('tr').attr('id'); // table row ID 
        //     window.open("<?php echo base_url(); ?>staff/finance/total_lebih_bayar?id_paket=" + trid, '_blank');
        // });
        // $("#dataTable tbody").on("click", ".belum_dp", function() {
        //     var trid = $(this).closest('tr').attr('id'); // table row ID 
        //     window.open("<?php echo base_url(); ?>staff/finance/belum_dp?id_paket=" + trid, '_blank');
        // });
        // $("#dataTable tbody").on("click", ".outstanding", function() {
        //     var trid = $(this).closest('tr').attr('id'); // table row ID 
        //     window.open("<?php echo base_url(); ?>staff/finance/detail_outstanding?id_paket=" + trid, '_blank');
        // });
    });
    </script>

</body>

</html>