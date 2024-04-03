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
                            <h1 class="h3 mb-0 text-gray-800">Discount Paket Log</h1>
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
                        <!-- <div class='row'>
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
                                                    <option
                                                        value="<?php echo date('m', strtotime($m->tanggal_berangkat))?>"
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

                        </div> -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Log Discount Program
                                            <strong id="nama_paket"><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="120%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th style="width: 200px">Nama Paket</th>
                                                        <th>Discount</th>
                                                        <th>Deskripsi Discount</th>
                                                        <th>Tanggal Mulai</th>
                                                        <th>Tanggal Berakhir</th>
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
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/finance/load_diskon",
                "data": {
                    id_paket: "<?php echo $id_paket; ?>"
                }
            },
            "columns": [{
                    "data": "DT_RowId",
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "nama_paket"
                },
                {
                    "data": "discount"
                },
                {
                    "data": "deskripsi_diskon"
                },
                {
                    "data": "tanggal_mulai"
                },
                {
                    "data": "tanggal_berakhir"
                },
                {
                    data: null,
                    defaultContent: '<a href="javascript:void(0);" class="btn btn-info btn-sm detail_btn">Detail</a>'
                },
            ],
            "order": [
                [0, "asc"]
            ],
            "columnDefs": [{
                targets: [4, 5],
                "render": function(data, type, row) {
                    var from = data.split("-");
                    var f = new Date(from[0], from[1] - 1, from[2]);
                    return $.datepicker.formatDate('dd M yy', f);
                }
            }]
        });

        $("#dataTable tbody").on("click", ".detail_btn", function() {
            var trid = $(this).closest('tr').attr('id');
            var id_paket = $(this).closest('tr').attr('id_paket');
            var tgl_mulai = $(this).closest('tr').attr('tgl_mulai');
            var tgl_berakhir = $(this).closest('tr').attr('tgl_berakhir'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/finance/diskon_log_jamaah?id=" +
                id_paket + "&tgm=" + tgl_mulai + "&tgb=" + tgl_berakhir + "&id_log=" + trid,
                '_blank');
        });
    });
    </script>

</body>

</html>