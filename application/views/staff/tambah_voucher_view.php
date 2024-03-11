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


            <?php $this->load->view('staff/include/side_menu', ['voucher' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Voucher Paket</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi Informasi Paket Dengan Benar!
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form" action="<?php echo base_url(); ?>staff/voucher/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">Kode Voucher</label>
                                                <input class="form-control" type="text" name="kode_voucher">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nominal</label>
                                                <input class="form-control" type="numeric" name="nominal">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kuota Voucher</label>
                                                <input class="form-control" type="numeric" name="kuota">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Mulai</label>
                                                <input class="form-control" type="date" name="tgl_mulai">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Berakhir</label>
                                                <input class="form-control" type="date" name="tgl_berakhir">
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 40px;">All <input id="checkAll"
                                                                        type="checkbox"></th>
                                                                <th>Nama Paket</th>
                                                                <th>Jumlah Seat</th>
                                                                <th>Harga Paket</th>
                                                                <th>Tanggal Berangkat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($paket as $p) { ?>
                                                            <tr>
                                                                <td>
                                                                    <input class="checks" type="checkbox"
                                                                        name="id_paket[]"
                                                                        value="<?php echo $p->id_paket; ?>">
                                                                </td>
                                                                <td><?php echo $p->nama_paket; ?></td>
                                                                <td><?php echo $p->jumlah_seat?></td>
                                                                <td><?php echo $p->harga; ?></td>
                                                                <td><?php echo date('d M Y', strtotime($p->tanggal_berangkat)); ?>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="aktif" value="1" checked> Aktifkan
                                                    </label>
                                                </div>
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
    if (window.innerWidth > 800) {
        $(".datepicker").attr("type", "text");
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "mm/dd/yy"
            });
        });
    }
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#content").on("click", "#checkAll", function() {
            $(".checks").prop('checked', $(this).prop('checked'));
        });
    });
    </script>
</body>

</html>