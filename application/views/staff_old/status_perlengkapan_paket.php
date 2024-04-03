<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
        th {
            color: white;
            background-color: lightseagreen;
        }

        td {
            background-color: lightyellow;
        }
    </style>
    <link href="<?php echo base_url(); ?>asset/mycss/detail_pdf.css" type="text/css" rel="stylesheet" media="mpdf" />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['perl_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Status Perlengkapan <?php echo $paket->nama_paket . ' ' . $paket->tanggal_berangkat; ?>
                                <a href="<?php echo base_url(); ?>staff/perlengkapan_paket/atur?id=<?php echo $paket->id_paket; ?>" class="btn btn-warning btn-icon-split btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                    <span class="text">Atur Perlengkapan Lagi</span>
                                </a>
                            </h1>
                        </div>
                        <!-- Content Row -->
                        <div class="row">
                            <form id="form_pilih_paket" action="<?php echo base_url(); ?>staff/perlengkapan_paket/proses_status" method="post" style="display:contents;">
                                <div class="col-lg-9">
                                    <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="card shadow mb-4 border-left-primary">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary">Pilih Perlengkapan yang Ingin diubah statusnya</h6>

                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 40px;">All <input id="checkAll" type="checkbox"></th>
                                                            <th>Nama Barang</th>
                                                            <th>Stok</th>
                                                            <th>Deskripsi</th>
                                                            <th>jml Pria</th>
                                                            <th>jml Wanita</th>
                                                            <th>jml Anak Pria</th>
                                                            <th>jml Anak Wanita</th>
                                                            <th>jml Bayi</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($perlengkapan['perlengkapan'] as $p) { ?>
                                                            <tr>
                                                                <td>
                                                                    <input class="checks" type="checkbox" name="id_perlpaket[]" value="<?php echo $p->id_perlpaket; ?>">
                                                                </td>
                                                                <td><?php echo $p->nama_barang; ?></td>
                                                                <td><?php echo $p->stok . ' ' . $p->stok_unit; ?></td>
                                                                <td><?php echo nl2br($p->deskripsi); ?></td>
                                                                <td><?php echo $p->jumlah_pria; ?></td>
                                                                <td><?php echo $p->jumlah_wanita; ?></td>
                                                                <td><?php echo $p->jumlah_anak_pria; ?></td>
                                                                <td><?php echo $p->jumlah_anak_wanita; ?></td>
                                                                <td><?php echo $p->jumlah_bayi; ?></td>
                                                                <td><?php echo $p->status; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="card shadow mb-4 border-left-info">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h6 class="m-0 font-weight-bold text-primary"> Ubah Status disini</h6>
                                        </div>
                                        <div class="card-body">

                                            <div class='form-group'>
                                                <label class="col-form-label">Pilih Status :</label><br>
                                                <input type="radio" name="status" value="Belum Ready" checked> Belum Ready<br>
                                                <input type="radio" name="status" value="Siap Diambil"> Siap Diambil<br>
                                                <input type="radio" name="status" value="Other"> Other
                                            </div>
                                            <button class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Submit</span>
                                            </button>



                                        </div>
                                    </div>

                                </div>
                            </form>
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
            $("#content").on("click", "#checkAll", function() {
                $(".checks").prop('checked', $(this).prop('checked'));
            });
        });
    </script>
</body>

</html>