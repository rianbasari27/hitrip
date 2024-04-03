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


            <?php $this->load->view('staff/include/side_menu', ['input_pembayaran' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Verifikasi Pembayaran</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Nama :</strong>
                                        <?php echo $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name; ?><br>
                                        <strong>Paket :</strong> <?php echo $member->paket_info->nama_paket; ?>
                                        (<?php echo $member->paket_info->tanggal_berangkat; ?>)
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Data Extra Fee</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <?php $ctr = 0; ?>
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nominal</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($extraFee as $ef) { ?>
                                                <tr>
                                                    <?php $ctr = $ctr + 1; ?>
                                                    <td><a onclick="return confirm('Yakin Untuk Menghapus?')" href="<?php
                                                                echo base_url() . "staff/finance/hapus_extrafee?" .
                                                                "idef=" . $ef->id_fee .
                                                                "&idm=" . $member->id_member .
                                                                "&idj=" . $jamaah->id_jamaah .
                                                                "&idpkt=" . $member->id_paket;
                                                                ?>" class="btn btn-danger btn-sm hapus_btn">Hapus</a>
                                                        <?php echo $ctr; ?>
                                                    </td>
                                                    <td><?php echo "Rp " . number_format($ef->nominal); ?></td>
                                                    <td><?php echo nl2br($ef->keterangan); ?></td>

                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>


                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Tambah Extra Fee</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/finance/extrafee?idm=<?php echo $member->id_member; ?>&idj=<?php echo $jamaah->id_jamaah; ?>&idpkt=<?php echo $member->id_paket; ?>"
                                            method="post">

                                            <div class="form-group">
                                                <label class="col-form-label">Nominal :</label>
                                                <input class="form-control format_harga" type="text" name="nominal">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Keterangan :</label>
                                                <textarea class="form-control" name="keterangan"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>
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

</body>
<script>
$(document).ready(function() {

    $(".format_harga").on("input", function() {
        var inputValue = $(this).val();
        var minus = inputValue.substr(0, 1);

        inputValue = inputValue.replace(/[^\d.]/g, '');
        if (inputValue !== '') {
            inputValue = parseFloat(inputValue).toLocaleString('en-US');
            $(this).val(inputValue);
        } else {
            $(this).val('');
        }
        if (minus == '-') {
            $(this).val(minus + inputValue);
        }
    });
});
</script>

</html>