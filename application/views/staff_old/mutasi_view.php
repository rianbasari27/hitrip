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


            <?php $this->load->view('staff/include/side_menu',['list_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Logistik</h1>
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
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>

                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get"
                                            action="<?php echo base_url(); ?>staff/barang/mutasi">
                                            <div class="form-group">
                                                <label class="col-form-label">Pilih Bulan</label>

                                                <select name="month" class="form-control">
                                                    <option value="0">Lihat Semua</option>
                                                    <?php foreach ($mutasiMonth as $m) { ?>
                                                    <option value="<?php echo date('m', strtotime($m->tanggal))?>"
                                                        <?php echo date('m', strtotime($m->tanggal)) == $month ? 'selected' : ''; ?>>
                                                        <?php echo $this->date->convert('F', $m->tanggal); ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php if ($id_logistik != null ) { ?>
                                            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                                            <?php } ?>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Mutasi Barang <strong
                                                id="month"><?php echo $nama_bulan;?></strong></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <form action="<?php echo base_url().'staff/barang/load_mutasi?id=all'?>"
                                                method="get">
                                                <input type="hidden" name="id_logistik" id="id_logistik"
                                                    value="<?php echo $id_logistik ?>">
                                                <div>
                                                    <label for="date_start">Pilih tanggal</label>
                                                    <input type="date" name="date_start" id="date_start"
                                                        class="border border-secondary rounded p-1"> -
                                                    <input type="date" name="date_end" id="date_end"
                                                        class="border border-secondary rounded p-1">
                                                </div>
                                                <div class="mt-2">
                                                    <label for="status">Status</label>
                                                    <select name="status" id="status"
                                                        class="border border-secondary rounded p-1"
                                                        style="width: 250px;">
                                                        <option value="" selected>-- Pilih Status --</option>
                                                        <option value="masuk">IN</option>
                                                        <option value="keluar">OUT</option>
                                                    </select>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="tempat">Pilih tempat</label>
                                                    <select name="tempat" id="tempat"
                                                        class="border border-secondary rounded p-1"
                                                        style="width: 250px;">
                                                        <option value="" selected>-- Pilih Tempat --</option>
                                                        <option value="Gudang">Gudang</option>
                                                        <option value="Kantor">Kantor</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="120%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Barang</th>
                                                        <th>Stok Sebelumnya</th>
                                                        <th>IN</th>
                                                        <th>OUT</th>
                                                        <th>Stok Sesudah</th>
                                                        <!-- <th>Stok Total</th> -->
                                                        <th>Tempat</th>
                                                        <th style="width:150px">Catatan</th>
                                                        <th style="width:100px">Nama Paket</th>
                                                        <th style="width:100px">Tanggal Berangkat</th>
                                                        <th style="width:100px">Nama Penginput</th>
                                                        <th style="width:150px">Tanggal</th>
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

    <?php $this->load->view('staff/include/script_view'); ?>
    <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#date_start, #date_end, #status, #tempat").change(function() {
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
            var status = !$("#status").val() ? '' : $("#status").val();
            var tempat = !$("#tempat").val() ? '' : $("#tempat").val();

            var dataTable = $('#dataTable').DataTable({
                "dom": 'lBfrtip',
                "buttons": [{
                    extend: 'excel',
                    text: 'EXCEL',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
                    },
                    filename: function() {
                        var nama = document.getElementById("month").innerHTML
                        return "Laporan Mutasi Barang " + nama;
                    },
                    customizeData: function(data) {
                        for (var i = 0; i < data.body.length; i++) {
                            data.body[i][1] = '\u200C' + data.body[i][1];
                        }
                    },
                }],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/barang/load_mutasi",
                    "data": {
                        month: "<?php echo $month; ?>",
                        id: "<?php echo $id_logistik;?>",
                        date_start: dateStart,
                        date_end: dateEnd,
                        status: status,
                        tempat: tempat,
                    }
                },
                columns: [{
                        data: 'id_mutasi',
                        "render": function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'nama_barang'
                    },
                    {
                        data: 'stok_before',
                        render: function(data, type, row) {
                            return data + " " + row['stok_unit'];
                        }
                    },
                    // {
                    //     data: 'jumlah',
                    //     render: function(data, type, row) {
                    //         return data + " " + row['stok_unit'];
                    //     }
                    // },
                    {
                        data: 'status_in',
                        render: function(data, type, row) {
                            return data;
                            // if (data == 'masuk') {
                            //     return data = 'IN'
                            // }
                            // if (data == 'keluar') {
                            //     return data = 'OUT'
                            // }
                        }
                    },
                    {
                        data: 'status_out'
                    },
                    // {
                    //     data: 'status',
                    //     render: function(data, type, row) {
                    //         if (data == 'masuk') {
                    //             return data = 'IN'
                    //         }
                    //         if (data == 'keluar') {
                    //             return data = 'OUT'
                    //         }
                    //     }
                    // },
                    {
                        data: 'stok_after'
                    },
                    {
                        data: 'tempat',
                    },
                    {
                        data: 'note'
                    },
                    {
                        data: 'nama_paket',
                        render: function(data, type, row) {
                            if (data != null) {
                                hasil = data
                            } else {
                                hasil = "-";
                            }

                            return hasil
                        }
                    },
                    {
                        data: 'tanggal_berangkat',
                        render: function(data, type, row) {
                            if (data != null) {
                                var from = String(data).split("-");
                                var f = new Date(from[0], from[1] - 1, from[2]);
                                var data = $.datepicker.formatDate('dd-mm-yy', f);
                                data = data;
                            } else {
                                data = ' ';
                            }
                            return data;
                        }
                    },
                    {
                        data: 'nama_penginput',
                        render: function(data, type, row) {
                            if (data != null) {
                                hasil = data
                            } else {
                                hasil = "-";
                            }

                            return hasil
                        }
                    },
                    {
                        data: 'tanggal',
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
                        data: 'id_mutasi',
                        "render": function(data, type, row) {
                            return '<a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
                                    <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
                        }

                    }

                ],
                "order": [
                    [11, 'desc']
                ]
            });
        }

        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/barang/hapus_mutasi?id=" + trid;
            }
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=m&id=" + trid;
        });
    });
    </script>

</body>

</html>