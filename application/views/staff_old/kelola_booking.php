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
                                        <?php echo implode(' ', array_filter([$jamaah->first_name, $jamaah->second_name, $jamaah->last_name])); ?><br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>) <br>
                                        <strong>No Telepon :</strong> <?php echo $noKirim; ?><br>
                                        <strong>Alamat :</strong> <?php echo $alamatKirim; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <div class="card shadow mb-4 border-left-danger">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-danger">Pending Booking</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($pendingBooking['items'])) { ?>
                                        <div>
                                            Tidak ada booking perlengkapan yang masih pending.
                                        </div>
                                        <?php } ?>
                                        <?php $ctr = 0; ?>
                                        <?php foreach ($pendingBooking['dateGroup'] as $tglAmbil => $ambil) { ?>
                                        <?php $ctr++; ?>
                                        <div class="card shadow mb-4 border-left-danger">
                                            <a href="#pendingBooking<?php echo $ctr; ?>"
                                                class="d-block card-header py-3" data-toggle="collapse" role="button"
                                                aria-expanded="true" aria-controls="pendingBooking<?php echo $ctr; ?>">
                                                <?php if ($ambil[0]->jenis_ambil == "pengiriman") { ?>
                                                    <h6 class="m-0 font-weight-bold text-danger"><span>Pengiriman Tanggal :
                                                    </span> <span class="text-success"> <?php echo $tglAmbil; ?></span>
                                                    <span class="text-gray-500">(click to expand)</span>
                                                </h6>
                                                <?php } else { ?>
                                                    <h6 class="m-0 font-weight-bold text-danger"><span>Pengambilan Tanggal :
                                                    </span> <span class="text-success"> <?php echo $tglAmbil; ?></span>
                                                    <span class="text-gray-500">(click to expand)</span>
                                                </h6>
                                                <?php } ?>
                                            </a>
                                            <div class="collapse show" id="pendingBooking<?php echo $ctr; ?>">

                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <form
                                                            action="<?php echo base_url() . 'staff/perlengkapan_pending/statusPending'; ?>"
                                                            method="post">
                                                            <input type="hidden" name="jenis_ambil" value="<?php echo $jenisAmbil ;?>">
                                                            <input type="hidden" name="idm" value="<?php echo $member->id_member; ?>">
                                                            <input type="hidden" name="noWa" value="<?php echo $noKirim; ?>">
                                                            <table class="table table-bordered" width="100%"
                                                                cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:50px;">Ambil</th>
                                                                        <th>Nama Barang</th>
                                                                        <th style="width:10%;">Jumlah Ambil</th>
                                                                        <th>Akun Penerima</th>
                                                                        <th style="width:40%">Deskripsi</th>
                                                                        <th>Aksi</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($ambil as $am) { ?>
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <input type="checkbox" name="items[]"
                                                                                value="<?php echo $am->id_perlmember; ?>"
                                                                                style="scale: 2;" checked>
                                                                        </td>
                                                                        <td><?php echo $am->nama_barang; ?></td>
                                                                        <td><?php echo $am->jumlah_ambil . ' ' . $am->stok_unit; ?>
                                                                        </td>
                                                                        <td><?php echo $am->staff; ?></td>
                                                                        <td><?php echo $am->deskripsi; ?></td>
                                                                        <td>
                                                                            <a href="<?php echo base_url() . 'staff/perlengkapan_pending/pending_batal?id=' . $am->id_perlmember; ?>"
                                                                                class="btn btn-danger btn-sm hapus_btn">Hapus</a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                            <div class="form-group">
                                                                <label class="col-form-label">Status Perlengkapan
                                                                </label>
                                                                <br><input type="radio" name="status" value="Siap">
                                                                Siap di ambil
                                                            </div>

                                                            <button class="btn btn-success btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-check"></i>
                                                                </span>
                                                                <span class="text">Set Status</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
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