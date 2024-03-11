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
                                        <?php echo $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name; ?><br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($sudahAmbil['items'])) { ?>
                        <div class="mb-4">
                            <a href="<?php echo base_url() . 'staff/perlengkapan_peserta/download_full?idm=' . $member->id_member ;?>"
                                class="btn btn-primary">Download Detail</a>
                        </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Perlengkapan Yang Sudah Diambil
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (empty($sudahAmbil['items'])) { ?>
                                        <div>
                                            Belum ada perlengkapan yang sudah diambil.
                                        </div>
                                        <?php } ?>
                                        <?php $ctr = 0; ?>
                                        <?php foreach ($sudahAmbil['dateGroup'] as $tglAmbil => $ambil) { ?>
                                        <?php $ctr++; ?>
                                        <div class="card shadow mb-4 border-left-primary">
                                            <a href="#sudahAmbil<?php echo $ctr; ?>" class="d-block card-header py-3"
                                                data-toggle="collapse" role="button" aria-expanded="false"
                                                aria-controls="sudahAmbil<?php echo $ctr; ?>">
                                                <h6 class="m-0 font-weight-bold text-primary"><span>Pengambilan Tanggal
                                                        : </span> <span class="text-success">
                                                        <?php echo $tglAmbil; ?></span> <span
                                                        class="text-gray-500">(click expand to download) </span></h6>
                                            </a>

                                            <div class="collapse" id="sudahAmbil<?php echo $ctr; ?>">

                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered" width="100%"
                                                            cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Nama Barang</th>
                                                                    <th style="width:10%;">Jumlah Ambil</th>
                                                                    <th>Menyerahkan</th>
                                                                    <th>Menerima</th>
                                                                    <th style="width:40%">Deskripsi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($ambil as $am) { ?>
                                                                <tr>
                                                                    <td><?php echo $am->nama_barang; ?></td>
                                                                    <td><?php echo $am->jumlah_ambil . ' ' . $am->stok_unit; ?>
                                                                    </td>
                                                                    <td><?php echo $am->staff; ?></td>
                                                                    <td><?php echo $am->penerima; ?></td>
                                                                    <td><?php echo $am->deskripsi; ?></td>
                                                                </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                        <a href="<?php echo base_url() . "staff/perlengkapan_peserta/download?idj=" . $member->id_jamaah . "&idm=" . $member->id_member . "&id=" . $tglAmbil; ?>"
                                                            class="btn btn-primary">Download Tanda Terima</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        //this page only for
                        if (($_SESSION['bagian'] == 'Logistik' || $_SESSION['bagian'] == 'Master Admin' || $_SESSION['bagian'] == 'Admin' || $_SESSION['nama'] == 'Yashinta CS' || $_SESSION['nama'] == 'Shafira CS' || $_SESSION['nama'] == 'Syaiful CS' || $_SESSION['nama'] == 'Kania CS' || $_SESSION['nama'] == 'Dhira CS') ) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Perlengkapan yang Akan
                                            Diambil</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <?php if (empty($logistikPaket['perlengkapan'])) { ?>
                                        <div class="mb-4">
                                            <span class="text">
                                                Perlengkapan belum diatur, atur perlengkapan paket terlebih dahulu
                                                disini
                                                <a href="<?php echo base_url() . 'staff/perlengkapan_paket/atur?id=' . $member->id_paket; ?>"
                                                    class="btn btn-warning lihat_btn">Atur Perlengkapan Paket</a>
                                            </span>
                                        </div>
                                        <?php } ?>
                                        <?php if (!empty($logistikPaket['perlengkapan']) && ($logistikPaket['siapDiambilPria'] == 0 && $logistikPaket['siapDiambilWanita'] == 0)) { ?>
                                        <div class="mb-4">
                                            <span class="text">
                                                Perlengkapan belum ada yang siap diambil, untuk merubah status
                                                perlengkapan klik disini
                                                <a href="<?php echo base_url() . 'staff/perlengkapan_paket/atur_status?id=' . $member->id_paket; ?>"
                                                    class="btn btn-warning lihat_btn">Atur Status Perlengkapan</a>
                                            </span>
                                        </div>
                                        <?php } ?>
                                        <?php if (!empty($ambilList)) { ?>
                                        <?php $jk = $jamaah->jenis_kelamin; ?>
                                        <span class="text">Jenis Kelamin :
                                            <?php echo $jk == 'L' ? 'Laki-laki' : 'Perempuan'; ?></span>
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/perlengkapan_peserta/proses_ambil"
                                            method="post">
                                            <input type="hidden" name="id_member"
                                                value="<?php echo $member->id_member; ?>">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:50px;">Ambil</th>
                                                            <th>Nama Barang</th>
                                                            <th>Jumlah Yang Harus Diambil</th>
                                                            <th>Stok Kantor</th>
                                                            <th style="width:40%">Deskripsi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($ambilList as $lv) { ?>
                                                        <?php if (!isset($lv->jumlah_harus_ambil) || $lv->jumlah_harus_ambil == 0 || $lv->status != 'Siap Diambil') continue; ?>
                                                        <tr>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="items[]"
                                                                    value="<?php echo $lv->id_logistik; ?>"
                                                                    style="scale: 2;">
                                                            </td>
                                                            <td><?php echo $lv->nama_barang; ?></td>
                                                            <td><?php echo $lv->jumlah_harus_ambil . " " . $lv->stok_unit; ?>
                                                            </td>
                                                            <td><?php echo $lv->stok_kantor . " " . $lv->stok_unit; ?>
                                                            </td>
                                                            <td><?php echo nl2br($lv->deskripsi); ?></td>
                                                        </tr>
                                                        <?php } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Ambil (<span
                                                        class="text-primary font-italic font-weight-lighter">yyyy-mm-dd</span>)</label>
                                                <input class="form-control" type="datetime-local" name="tanggal_ambil"
                                                    value="<?php echo date('Y-m-d H:i'); ?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Penerima (<span
                                                        class="text-primary font-italic font-weight-lighter">Nama yang
                                                        akan muncul di invoice</span>)</label>
                                                <input class="form-control" type="text" name="penerima" value="">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pengambilan</label>
                                                <select class="form-control" name="tempat_ambil">
                                                    <option value="ho">Head Office</option>
                                                    <option value="bandung">Bandung</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Status Pengambilan :</label><br>
                                                <input type="radio" id="rd1" name="status" value="Pending" checked>
                                                <label for="rd1">Pending (<span
                                                        class="text-primary font-weight-lighter">Belum diambil
                                                        (dijadwalkan)</span>)</label><br>
                                                <input type="radio" id="rd2" name="status" value="Selesai">
                                                <label for="rd2">Selesai (<span
                                                        class="text-primary font-weight-lighter">Sudah diambil (Langsung
                                                        Ambil)</span>)</label><br>
                                            </div>

                                            <button class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Submit</span>
                                            </button>
                                        </form>
                                        <?php } else { ?>
                                        Tidak ada perlengkapan yang dapat diambil.
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
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