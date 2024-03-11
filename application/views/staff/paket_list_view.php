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


            <?php $this->load->view('staff/include/side_menu',['paket_umroh' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Paket Umroh</h1>
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
                                        <form role="form" method="get" action="<?php echo base_url(); ?>staff/paket">
                                            <div class="form-group">
                                            <select name="month" class="form-control">
                                                    <option value="0">Lihat Semua</option>
                                                    <?php foreach ($monthPackage as $m) { ?>
                                                    <option value="<?php echo date('m', strtotime($m->tanggal_berangkat))?>"
                                                        <?php echo date('m', strtotime($m->tanggal_berangkat)) == $month ? 'selected' : ''; ?>>
                                                        <?php echo $this->date->convert('F', $m->tanggal_berangkat); ?>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Paket Umroh yang Terdaftar
                                            didalam Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div style="width: 20px; height: 20px; background-color: lightgreen; margin-right: 5px;" class="rounded border border-dark"></div>
                                            <p class="text-dark">Broadcast Aktif</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 200px">Nama Paket</th>
                                                        <th>Tanggal Keberangkatan</th>
                                                        <th>Jumlah Pax</th>
                                                        <th>Harga Quad</th>
                                                        <th>Harga Triple</th>
                                                        <th>Harga Double</th>
                                                        <th>Publish</th>
                                                        <th style="width: 100px;">Tanggal Publish</th>
                                                        <th style="width: 300px">Aksi</th>
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
            'rowCallback': function(row, data, index) {
                    if (data['status_bcast'] == '1') {
                        $(row).css('background-color', 'lightgreen');
                        $(row).css('color', 'black');
                    }
                },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/paket/load_paket",
                "data": {
                    month: "<?php echo $month; ?>"
                }
            },
            "order": [
                [1, "desc"]
            ],
            "columnDefs": [{
                    "targets": -1,
                    "data": null,
                    "defaultContent": '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Lihat</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm bc_btn">Broadcast</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-warning btn-sm manasik_btn">BC Manasik</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mt-1">Hapus</a> \n\
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn mt-1">Log</a>'
                },
                {
                    "targets": [ 1, 7 ],
                    "render": function(data, type, row) {
                        if (data != null) {
                            var from = data.split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            return $.datepicker.formatDate('dd M yy', f);
                        } else {
                            return '-'
                        }
                    }
                }
            ]
        });

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

        $("#dataTable tbody").on("click", ".manasik_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast/manasik?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pu&id=" + trid;
        });
    });
    </script>

</body>

</html>