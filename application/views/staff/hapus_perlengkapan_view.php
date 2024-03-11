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
                            <h1 class="h3 mb-0 text-gray-800">Pengambilan Perlengkapan Jamaah</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-warning text-white">
                                    <div class="card-body text-l">
                                        <strong>Nama :</strong>
                                        <?php echo implode(' ', array_filter([$member->first_name, $member->second_name, $member->last_name])); ?><br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>) <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-danger">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-success">Perlengkapan yang sudah diambil
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($sudahAmbil['items'])) { ?>
                                        <div>
                                            Tidak ada perlengkapan yang dapat dihapus.
                                        </div>
                                        <?php } else { ?>
                                        <div class="card-body">
                                            <div class='row'>
                                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                                    <?php echo $_SESSION['alert_message']; ?>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <div class="table-responsive">
                                                <form
                                                    action="<?php echo base_url() . 'staff/perlengkapan_peserta/proses_hapus'; ?>"
                                                    method="post">
                                                    <input type="hidden" name="id_member"
                                                        value="<?php echo $member->member[0]->id_member ;?>">
                                                    <p>* Note : Centang untuk perlengkapan yang akan dihapus</p>
                                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:50px;">Check</th>
                                                                <th>Nama Barang</th>
                                                                <th style="width:10%;">Jumlah Ambil</th>
                                                                <th>Akun Staff</th>
                                                                <th style="width:40%">Deskripsi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($sudahAmbil['items'] as $am) { ?>
                                                            <tr>
                                                                <td class="text-center">
                                                                    <input type="checkbox" name="id_perl[]"
                                                                        value="<?php echo $am->id_perlmember; ?>"
                                                                        style="scale: 2;">
                                                                </td>
                                                                <td><?php echo $am->nama_barang; ?></td>
                                                                <td><?php echo $am->jumlah_ambil . ' ' . $am->stok_unit; ?>
                                                                </td>
                                                                <td><?php echo $am->staff; ?></td>
                                                                <td><?php echo $am->deskripsi; ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>

                                                    <button class="btn btn-danger btn-icon-split mt-4">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <span class="text">Hapus Perlengkapan</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <?php } ?>
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
    $(document).ready(function() {

        $(".hapus_btn").on("click", function() {
            event.preventDefault();
            if (confirm('Yakin untuk menghapus data ini?')) {
                let link = $(this).attr('href');
                window.location.href = link;
            }
        });
        if (window.innerWidth > 800) {
            $(".datepicker").attr("type", "text");
            $(function() {
                $(".datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: "1940:-nn"
                });
            });
        }
    });
    </script>
</body>

</html>