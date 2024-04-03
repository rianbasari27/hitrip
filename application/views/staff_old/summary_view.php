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
                            <h1 class="h3 mb-0 text-gray-800">Data Summary</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Keterangan</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get"
                                            action="<?php echo base_url(); ?>staff/finance/summary">
                                            <!-- <div class="form-group">
                                                <label for="ket">Pilih Status Keberangkatan</label>
                                                <select name="ket" id="ket" class="form-control">
                                                    <option value="0" <?php echo $ket == 0 ? 'selected' : '' ;?>>Lihat
                                                        Semua</option>
                                                    <option value="1" <?php echo $ket == 1 ? 'selected' : '' ;?>>Sudah
                                                        Berangkat</option>
                                                    <option value="2" <?php echo $ket == 2 ? 'selected' : '' ;?>>Belum
                                                        Berangkat</option>
                                                </select>
                                            </div> -->
                                            <div class="form-group">
                                                <label for="month">Pilih Bulan</label>
                                                <select name="month" id="month" class="form-control">
                                                    <option value="0 0000">Lihat Semua</option>
                                                    <?php foreach ($monthPackage as $m) { ?>
                                                    <option
                                                        value="<?php echo date('m_Y', strtotime($m['tanggal_berangkat']))?>"
                                                        <?php echo date('m_Y', strtotime($m['tanggal_berangkat'])) == $month ? 'selected' : ''; ?>>
                                                        <?php echo $this->date->convert('F Y', $m['tanggal_berangkat']); ?>
                                                    </option>
                                                    <?php } ?>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Paket yang Terdaftar didalam
                                            Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <form action="<?php echo base_url().'staff/finance/summary'?>" method="get">
                                                <!-- <input type="hidden" name="id_paket" id="id_paket" -->
                                                <!-- value="<?php echo $id_paket ?>"> -->
                                                <div>
                                                    <label for="date_start">Pilih tanggal</label>
                                                    <input type="date" name="date_start" id="date_start"
                                                        class="border border-secondary rounded p-1"> -
                                                    <input type="date" name="date_end" id="date_end"
                                                        class="border border-secondary rounded p-1">
                                                </div>
                                                <div>
                                                    <label for="status">Status Pembayaran</label>
                                                    <select name="status" id="status"
                                                        class="border border-secondary rounded p-1">
                                                        <option value="">Pilih</option>
                                                        <option value="0">Belum Lunas</option>
                                                        <option value="1">Sudah Lunas</option>
                                                        <option value="2">Lebih Bayar</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <label for="status">Status Keberangkatan</label>
                                                    <select name="ket" id="ket"
                                                        class="border border-secondary rounded p-1">
                                                        <option value="">Pilih</option>
                                                        <option value="0">Belum Berangkat</option>
                                                        <option value="1">Sudah Berangkat</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="form-group">
                                            <a href="<?php echo base_url() . 'staff/finance/list_summary'; ?>"
                                                class="btn btn-success btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-file-excel"></i>
                                                </span>
                                                <span class="text">Download Summary Pembayaran</span>
                                            </a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="170%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:150px">Nama Paket</th>
                                                        <th>Id Paket</th>
                                                        <th>Harga Paket</th>
                                                        <th>Discount Paket</th>
                                                        <th>Total Exclude</th>
                                                        <th>Tanggal Keberangkatan</th>
                                                        <th>Jumlah Pax</th>
                                                        <th style="width:100px">Terisi</th>
                                                        <th>Sisa Seat</th>
                                                        <th>Belum DP</th>
                                                        <th>Total Tagihan</th>
                                                        <th>Jumlah Pembayaran Jamaah</th>
                                                        <th>Jumlah Lebih Bayar</th>
                                                        <th>Nilai Outstanding</th>
                                                        <!-- <th>% Bayar Terisi</th> -->
                                                        <th>Jatuh Tempo</th>
                                                        <th>Sisa Hari Pelunasan</th>
                                                        <th style="width:200x">Status Group</th>
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

        $("#date_start, #date_end, #status, #ket").change(function() {
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
            var ket = !$("#ket").val() ? '' : $("#ket").val();

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
                    text: "Download",
                    exportOptions: {
                        columns: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                        orthogonal: 'export'
                    },
                    filename: function() {
                        // Definisikan array nama bulan dalam bahasa Indonesia
                        var bulanIndonesia = [
                            "Januari",
                            "Februari",
                            "Maret",
                            "April",
                            "Mei",
                            "Juni",
                            "Juli",
                            "Agustus",
                            "September",
                            "Oktober",
                            "November",
                            "Desember"
                        ];

                        var month = "<?php echo $month != '0_0000' ? $month : ''; ?>";

                        var hasil = '';

                        if (month !== '' && month !== '0 0000') {
                            var [bulan, tahun] = month.split("_");
                            var namaBulan = bulanIndonesia[parseInt(bulan) - 1];
                            hasil = namaBulan + " " + tahun;
                        }

                        return "Data Summary Group " + hasil;
                    },
                    customizeData: function(data) {
                        for (var i = 0; i < data.body.length; i++) {
                            for (var j = 0; j < data.body[i].length; j++) {
                                // Memeriksa apakah isi data adalah string sebelum memanggil replace()
                                if (typeof data.body[i][j] === 'string') {
                                    data.body[i][j] = data.body[i][j].replace(" Detail",
                                        "");
                                    data.body[i][j] = data.body[i][j].replace("Kirim Pesan",
                                        "");
                                }
                            }
                        }
                    },
                }],

                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/finance/load_paket",
                    "data": {
                        month: "<?php echo $month;?>",
                        date_start: dateStart,
                        date_end: dateEnd,
                        status: status,
                        ket: ket
                    }
                },
                "columns": [{
                        "data": 'nama_paket',
                        "render": function(data, row, type) {
                            add =
                                ' <a href="javascript:void(0);" class="btn btn-primary btn-sm detail_paket">Detail</a>';
                            return data + add;
                        }
                    },
                    {
                        "data": 'DT_RowId',
                        "bVisible": false
                    },
                    {
                        "data": 'harga',
                        "render": function(data, row, type) {
                            add =
                                ' <a href="javascript:void(0);" class="btn btn-primary btn-sm harga_paket">Detail</a>';
                            return data + add;
                        }

                    },
                    {
                        "data": 'default_diskon',
                        "render": function(data, type, row) {
                            add =
                                ' <a href="javascript:void(0);" class="btn btn-primary btn-sm discount_paket">Detail</a>';
                            return new Intl.NumberFormat().format(data) + add;
                        }
                    },
                    {
                        "data": 'total_exclude',
                        "render": function(data, type, row) {
                            add =
                                ' <a href="javascript:void(0);" class="btn btn-primary btn-sm total_exclude">Detail</a><br>';
                            return data + add;
                        }
                    },
                    {
                        "data": 'tanggal_berangkat'
                    },
                    {
                        "data": 'jumlah_seat'
                    },
                    {
                        "data": 'terisi',
                        render: function(data, type, row) {
                            if (row['lansia'] != 0) {
                                lansiaButton =
                                    ' <a href="javascript:void(0);" class="btn btn-primary btn-sm detail_terisi">Detail</a>'
                            } else {
                                lansiaButton = ''
                            }
                            return "<strong>" + data + "</strong>" + "<br>" + "Lansia : " + row[
                                    'lansia'] +
                                lansiaButton +
                                "<br>" + "Dewasa : " + row['dewasa'] +
                                "<br>" + "Anak : " + row['anak'] +
                                "<br>" + "Infant : " + row['infant']
                        }
                    },
                    {
                        "data": 'sisa_seat'
                    },
                    {
                        "data": 'belum_dp',
                        "render": function(data, type, row) {
                            add =
                                ' <a href="javascript:void(0);" class="btn btn-primary btn-sm belum_dp">Detail</a>';
                            return data + add;
                        }
                    },
                    {
                        "data": 'total_tagihan'
                    },
                    {
                        "data": 'jumlah_pembayaran',
                    },
                    {
                        "data": 'lebih_bayar',
                        "render": function(data, type, row) {
                            var add = "";
                            if (row['status_pembayaran'] == 'Kelebihan Bayar') {
                                add =
                                    ' <a href="javascript:void(0);" class="btn btn-primary btn-sm total_lebih_bayar">Detail</a>';
                            }
                            return data + add;
                        }
                    },
                    {
                        "data": 'nilai_outstanding',
                        "render": function(data, type, row) {
                            var add = "";
                            var detailBtn = '';
                            var waBtn = '';
                            if (data != 0) {
                                detailBtn =
                                    ' <a href="javascript:void(0);" class="btn btn-primary btn-sm outstanding">Detail</a>';
                                waBtn =
                                    '<a href="<?php echo base_url() ?>staff/finance/send_jamaah?id_paket=' +
                                    row['DT_RowId'] +
                                    '&input=1&lunas=2" class="btn btn-success btn-sm btn_whatsapp mt-1">Kirim Pesan</a>';
                            }
                            return data + detailBtn + waBtn;
                        }
                    },
                    // {
                    //     "data": 'persentase'
                    // },
                    {
                        "data": 'jatuh_tempo'
                    },
                    {
                        "data": 'countdown',
                        "render": function(data, row, type) {
                            var countDown = ''
                            if (data >= 0) {
                                countDown = data + ' hari lagi'
                            } else {
                                countDown = 'Over due date'
                            }
                            return countDown
                        }
                    },
                    {
                        "data": 'status_group',
                        render: function(data, type, row) {
                            if (data == 'Sudah Berangkat') {
                                color = 'magenta'
                            }
                            if (data == 'Unpublish') {
                                color = 'darkgray'
                            }
                            if (data == 'Sudah Penuh') {
                                color = 'green'
                            }
                            if (data == 'Belum Penuh') {
                                color = 'tomato'
                            }
                            return "<div class='p-2 rounded text-white' style='background-color:" +
                                color +
                                ";'>" + data + "</div>"
                        }
                    },
                ],
                "order": [
                    [5, "desc"]
                ],
                "columnDefs": [{
                        "targets": -1,
                        "data": null,
                        "defaultContent": '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat</a> \n\
                                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm bc_btn">Broadcast</a> \n\
                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
                    },
                    {
                        targets: 5,
                        "render": function(data, type, row) {
                            var from = data.split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            return $.datepicker.formatDate('dd M yy', f);
                        }
                    },
                    // {
                    //     targets: 11,
                    //     "render": function(data, type, row) {
                    //         return data;
                    //     }
                    // }
                ]
            });
        }
        $("#dataTable tbody").on("click", ".detail_paket", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/detail_paket?id_paket=" + trid);
        });
        $("#dataTable tbody").on("click", ".detail_terisi", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/detail_terisi?id_paket=" + trid +
                "&klasifikasi=Lansia");
        });
        $("#dataTable tbody").on("click", ".harga_paket", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/paket/lihat?id=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".discount_paket", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/diskon_log?id=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".total_exclude", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/detail_exclude?id=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".total_lebih_bayar", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/total_lebih_bayar?id_paket=" + trid,
                '_blank');
        });
        $("#dataTable tbody").on("click", ".belum_dp", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/belum_dp?id_paket=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".outstanding", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/detail_outstanding?id_paket=" + trid,
                '_blank');
        });
    });
    </script>

</body>

</html>