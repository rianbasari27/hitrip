<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
    h3 {
        font-family: 'Playfair Display', serif;
    }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['pembayaran_konsultan' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Konsultan yang terdaftar pada program</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Program Konsultan</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get"
                                            action="<?php echo base_url(); ?>staff/pembayaran_konsultan">
                                            <div class="form-group">
                                                <label class="col-form-label">Pilih Program dibawah, atau
                                                    <a href="<?php echo base_url(); ?>staff/agen_paket"
                                                        class="btn btn-warning btn-icon-split btn-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                        <span class="text">Lihat Semua Program</span>
                                                    </a>
                                                </label>

                                                <select name="id" class="form-control">
                                                    <?php foreach ($program as $prog) { ?>
                                                    <option value="<?php echo $prog->id; ?>"
                                                        <?php echo $prog->id == $id ? 'selected' : ''; ?>>
                                                        <?php echo $prog->nama_paket; ?>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Konsultan yang Mengikuti
                                            Program
                                            <strong><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="card bg-primary text-white mb-4" style="max-width: 400px;">
                                            <div class="card-body">
                                                <h3 class="mb-4">Detail Paket</h3>
                                                <hr class="my-2 border-light w-25 float-left mt-n2"><br>
                                                <!-- Divider with light color and 25% width -->
                                                <div class="mt-n2">
                                                    <i class="fas fa-users fa-2x mr-2"></i>
                                                    <span class="font-weight-bold">Jumlah Terdaftar :</span>
                                                    <span
                                                        class="ml-2"><?php echo $jumlahTerdaftar; ?></span>
                                                </div><br>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:250px">Nama Konsultan</th>
                                                        <th style="width:250px">Nama Upline</th>
                                                        <th style="width:200px">Status</th>
                                                        <th style="width:250px">Total Harga</th>
                                                        <th style="width:150px">Aksi</th>
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
                "url": "<?php echo base_url(); ?>staff/pembayaran_konsultan/load_data",
                "data": {
                    id: '<?php echo $id; ?>'
                }
            },
            columns: [{
                    data: 'nama_agen'
                },
                {
                    data: 'nama_upline'
                },
                {
                    data: 'lunas',
                    render: function(data, type, row) {
                        add =
                            ' <a href="javascript:void(0);" class="btn btn-primary btn-sm riwayat_btn">Rincian & Invoice</a>';
                        return data + add;
                    }
                },
                {
                    data: 'total_harga'
                },
                {
                    data: 'parent_id',
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-success btn-sm bayar_btn mb-2">Pembayaran</a><br> \n\
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a>\n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a>\n\
                                <br><a href="javascript:void(0);" class="btn btn-info btn-sm log_btn mt-2">Log</a>'
                    }
                }
            ],
            order: [
                [1, 'desc']
            ]
        });
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var id_agen = $(this).closest('tr').attr('id_agen'); // table row ID
            window.open("<?php echo base_url(); ?>staff/kelola_agen/profile?id=" + id_agen, '_blank');
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=agp&id=" + trid;
        });
        $("#dataTable tbody").on("click", ".bayar_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_agen = $(this).closest('tr').attr('id_agen'); // table row ID
            window.location.href = "<?php echo base_url(); ?>staff/pembayaran_konsultan/bayar?iap=" +
                trid + "";
        });
        $("#dataTable tbody").on("click", ".va_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID // table row ID 
            window.open("<?php echo base_url(); ?>staff/va?idm=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href =
                    "<?php echo base_url(); ?>staff/pembayaran_konsultan/hapus_data?iap=" + trid;
            }
        });
        $("#dataTable tbody").on("click", ".rincian_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            var inv = $(this).closest('tr').attr('id_member');
            window.open('<?php echo base_url(); ?>staff/info/rincian_harga?id=' + trid + '&idm=' + inv,
                'newwindow', 'width=400,height=400');
        });
        $("#dataTable tbody").on("click", ".riwayat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_agen = $(this).closest('tr').attr('id_agen'); // table row ID 
            window.open('<?php echo base_url(); ?>staff/pembayaran_konsultan/riwayat_bayar?id=' + trid,
                'newwindow',
                'width=1000,height=800');
        });

    });
    </script>

</body>

</html>