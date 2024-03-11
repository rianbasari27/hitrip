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


            <?php $this->load->view('staff/include/side_menu', ['status_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Summary Perlengkapan Jamaah</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Summary Perlengkapan Group
                                            <strong><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <form
                                                action="<?php echo base_url().'staff/perlengkapan_peserta/summary_perlengkapan'?>"
                                                method="get">
                                                <!-- <input type="hidden" name="id_paket" id="id_paket" -->
                                                <!-- value="<?php echo $id_paket ?>"> -->
                                                <div>
                                                    <label for="date_start">Pilih tanggal</label>
                                                    <input type="date" name="date_start" id="date_start"
                                                        class="border border-secondary rounded p-1"> -
                                                    <input type="date" name="date_end" id="date_end"
                                                        class="border border-secondary rounded p-1">
                                                </div>
                                                <div class="mt-2">
                                                    <label for="month">Pilih Bulan</label>
                                                    <select name="month" id="month"
                                                        class="border border-secondary rounded p-1">
                                                        <option value="">-- Pilih Bulan --</option>
                                                        <?php foreach ($monthPackage as $m) { ?>
                                                        <option
                                                            value="<?php echo date('m Y', strtotime($m['tanggal_berangkat']))?>"
                                                            <?php echo date('m Y', strtotime($m['tanggal_berangkat'])) == $month ? 'selected' : ''; ?>>
                                                            <?php echo $this->date->convert('F Y', $m['tanggal_berangkat']); ?>
                                                        </option>
                                                        <?php } ?>
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
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 150px;">Nama Group</th>
                                                                <th style="width: 150px;">Tanggal Berangkat</th>
                                                                <th>Jumlah Pax</th>
                                                                <?php foreach($perlJamaah as $p ) { ?>
                                                                <th style="width: 150px;"><?php echo $p->nama_barang;?>
                                                                </th>
                                                                <?php } ?>
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
        $("#date_start, #date_end, #month, #status_berangkat").change(function() {
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
            var month = !$("#month").val() ? '' : $("#month").val();
            var status_berangkat = !$("#status_berangkat").val() ? '' : $("#status_berangkat").val();
            var jumlahPerl = <?php echo $countPerl;?>;
            const perlDefs = [];
            for (let i = 3; i <= jumlahPerl + 2; i++) {
                perlDefs.push(i);
            }
            const excel = [];
            for (let i = 0; i <= jumlahPerl + 2; i++) {
                excel.push(i);
            }
            var dataTable = $('#dataTable').DataTable({
                // 'nrowCallback': function(row, data, index) {
                //     console.log(data)
                // },
                'rowCallback': function(row, data, index) {
                    var a = 0;
                    // console.log(data['siap_ambil']);
                    for (let i = 3; i <= jumlahPerl + 2; i++) {
                        if (data[i]['hasil'] != '0') {
                            var a = 1
                            break
                        } 
                    }

                    if (a == 0 && data['siap_ambil'] == 1) {
                        $(row).css('background-color', 'lightgreen');
                        $(row).css('color', 'black');
                    } else if (a == 1 && data['siap_ambil'] == 1) {
                        $(row).css('background-color', 'tomato');
                        $(row).css('color', 'black');
                    }
                    // console.log(data);


                },
                "processing": true,
                "serverSide": true,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'EXCEL',
                    exportOptions: {
                        columns: excel
                    },
                    // filename: function() {
                    //     var nama = document.getElementById("nama_paket").innerHTML
                    //     return "Dokumen Manifest " + nama;
                    // },
                    // customizeData: function(data) {
                    //     for (var i = 0; i < data.body.length; i++) {
                    //         data.body[i][1] = '\u200C' + data.body[i][1];
                    //     }
                    // },
                }],
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/perlengkapan_peserta/load_summary",
                    "data": {
                        date_start: dateStart,
                        date_end: dateEnd,
                        month: month,
                        status_berangkat: status_berangkat
                    }
                },
                // columns: [{
                //         data: 'DT_RowId'
                //     },
                //     {
                //         data: 'nama_paket'
                //     },
                //     {
                //         data: 'jumlah_seat'
                //     }
                // ],
                "columnDefs": [{
                        "targets": 0,
                        "data": "nama_paket",

                    },
                    {
                        "targets": 1,
                        "data": "tanggal_berangkat",
                        "render": function(data, type, row) {
                            if (data != null) {
                                var from = data.split("-");
                                var f = new Date(from[0], from[1] - 1, from[2]);
                                var data = $.datepicker.formatDate('dd M yy', f);
                                data = data;
                            } else {
                                data = ' ';
                            }
                            return data;
                        }
                    },
                    {
                        "targets": 2,
                        "data": "jumlah_seat",

                    },
                    {
                        "targets": -1,
                        render: function(data, type, row) {
                            return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a>'
                        }
                    },
                    {
                        "targets": perlDefs,
                        render: function(data, type, row) {
                            // console.log(row['jumlah_laki']);
                            if (data['id_logistik'] == 1 || data['id_logistik'] == 7 || data['id_logistik'] == 13) {
                                data['hasil'] = row['jumlah_laki'] - data['jumlah']
                            } else if (data['id_logistik'] == 5 || data['id_logistik'] == 6 || data['id_logistik'] == 25) {
                                data['hasil'] = row['jumlah_wanita'] - data['jumlah']
                            } else {
                                data['hasil'] = row['jumlah_laki'] + row['jumlah_wanita'] - data['jumlah'];
                            }
                            return "Sudah : " + data[
                                    "jumlah"] + "<br>" +
                                "<a href='<?php echo base_url() ?>staff/perlengkapan_peserta/detail_sudah_ambil?id=" +
                                row['DT_RowId'] + '&idl=' + data['id_logistik'] + '&status=1' +
                                "'" + " class='btn btn-primary btn-sm'>Detail</a>" + "<br>" +
                                "Belum : " + data['hasil'] + "<br>" +
                                "<a href='<?php echo base_url() ?>staff/perlengkapan_peserta/detail_sudah_ambil?id=" +
                                row['DT_RowId'] + '&idl=' + data['id_logistik'] + '&status=0' +
                                "'" + " class='btn btn-primary btn-sm'>Detail</a>"
                        },
                        // "createdCell": function(td, cellData, rowData, row, col) {
                        //     for (let i = 3; i <= jumlahPerl + 2; i++) {
                        //         if (rowData[i] == rowData['jumlah_jamaah']) {
                        //             $(row).find('td:eq(3)').css('background-color',
                        //                 'lightgreen');
                        //         } else {
                        //             $(row).find('td:eq(3)').css('background-color',
                        //                 'red');
                        //         }
                        //     }
                        // }
                    }
                ],
                "order": [
                    [1, "desc"]
                ],
            });
        }

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/paket/lihat?id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".bc_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/paket/hapus?id=" + trid;
            }
        });

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pu&id=" + trid;
        });
    });
    </script>

</body>

</html>