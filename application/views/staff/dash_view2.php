<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <link href="<?php echo base_url(); ?>asset/chat/style.css" rel="stylesheet">
    <style>
    .iframe-container {
        height: 481px;
    }

    .pagination {
        text-align: center;
        margin-top: 10px;
    }

    .pagination a {
        padding: 5px 10px;
        margin: 2px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
        background-color: #f2f2f2;
        cursor: pointer;
    }

    .pagination a.active {
        background-color: #007BFF;
        color: #fff;
    }

    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['dashboard' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                    <?php echo $_SESSION['alert_message']; ?>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Earnings (Monthly) Card Example -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="mb-4">
                                            <div class="card border-left-primary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                Next Schedule</div>
                                                            <div class="mb-0 font-weight-bold text-gray-800">
                                                                <?php echo $nextTrip ? $nextTrip->nama_paket : 'Tidak ada'; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-suitcase fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Earnings (Monthly) Card Example -->
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="mb-4">
                                            <div class="card border-left-success shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                                Trip Date</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                <?php echo $nextTrip ? date_format(date_create($nextTrip->tanggal_berangkat), "d M Y") : 'Tidak ada'; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="mb-4">
                                            <div class="card border-left-info shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                                Days Countdown</div>
                                                            <div class="row no-gutters align-items-center">
                                                                <div class="col-auto">
                                                                    <div
                                                                        class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                                        <?php echo $nextTrip ? $nextTrip->countdown : 'N/A'; ?>
                                                                        hari lagi</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="mb-4">
                                            <div class="card border-left-warning shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div
                                                                class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                                Seat Terisi</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                <?php echo $totalJamaah; ?> Jamaah</div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card shadow mb-4 border-left-primary">
                                            <div
                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <h6 class="m-0 font-weight-bold text-primary">Informasi Paket Umroh</h6>
                                            </div>
                                            <div class="card-body">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                                        <tr>
                                                            <th>Paket di Publish</th>
                                                            <td><?php echo $packagePublished; ?> Paket</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Paket Tidak di Publish</th>
                                                            <td><?php echo $packageUnpublished; ?> Paket</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="iframe-container">
                                    <iframe src="<?php echo base_url(); ?>staff/dashboard/chat" height="100%"
                                        width="100%" style="border:none;"></iframe>
                                </div>
                            </div>
                        </div>
                        <?php if (in_array($_SESSION['bagian'], array('Logistik', 'Master Admin'))) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <a href="#perlengkapan" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="seatAndPay">
                                        <h6 class="m-0 font-weight-bold text-primary">Detail Pengambilan Perlengkapan
                                            <span class="text-gray-500">(click to expand)</span>
                                        </h6>
                                    </a>
                                    <div class="collapse" id="perlengkapan">
                                        <div class="card-body">

                                            <a href="<?php echo base_url() ;?>staff/perlengkapan_peserta/perlengkapan_excel"
                                                class="btn btn-success mb-2">Download Excel</a>

                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0" id="detail_perlengkapan">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2"></th>
                                                            <th rowspan="2">Nama Paket</th>
                                                            <th rowspan="2">Tanggal Berangkat</th>
                                                            <th rowspan="2">Jumlah Seat</th>
                                                            <th rowspan="2">Sisa Seat</th>
                                                            <th rowspan="2">Total Jamaah</th>
                                                            <th colspan="3">Status Perlengkapan</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Semua</th>
                                                            <th>Sebagian</th>
                                                            <th>Belum</th>
                                                        </tr>
                                                    </thead>
                                                    <!-- <tbody>
                                                        <?php //if ($perlengkapan) : ?>
                                                        <?php //foreach ($perlengkapan as $p) { ?>
                                                        <tr>
                                                            <td><a
                                                                    href="<?php //echo base_url() . "staff/perlengkapan_peserta?id_paket=$p->id_paket"; ?>"><?php echo $p->nama_paket; ?></a>
                                                            </td>
                                                            <td><?php //echo date_format(date_create($p->tanggal_berangkat), "d M Y"); ?>
                                                            </td>
                                                            <td><?php //echo $p->jumlah_seat;?> orang</td>
                                                            <td><?php //echo $p->sisa_seat; ?> orang</td>
                                                            <td><?php //echo $p->totalJamaah; ?> orang</td>
                                                            <td><strong><?php //echo $p->sudahSemua; ?></strong>
                                                                Sudah Ambil Semua</td>
                                                            <td><strong><?php //echo $p->sudahSebagian; ?></strong> Sudah
                                                                Ambil Sebagian
                                                            </td>
                                                            <td><strong><?php //echo $p->belumSemua; ?></strong> Belum
                                                                Ambil Semua
                                                            </td>
                                                        </tr>
                                                        <?php //} ?>
                                                        <?php //endif; ?>
                                                    </tbody> -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <a href="#seatAndPay" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="seatAndPay">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Seat dan Pembayaran
                                            <span class="text-gray-500">(click to expand)</span>
                                        </h6>
                                    </a>
                                    <div class="collapse" id="seatAndPay">
                                        <div class="card-body">

                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0" id="infoSeat">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2"></th>
                                                            <th rowspan="2">Nama Paket</th>
                                                            <th rowspan="2">Keberangkatan</th>
                                                            <th rowspan="2">Sisa Seat</th>
                                                            <th colspan="4">Pembayaran</th>
                                                        </tr>
                                                        <tr>
                                                            <th>Lunas</th>
                                                            <th>Cicil</th>
                                                            <th>Belum Bayar</th>
                                                            <th>Lebih</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (in_array($_SESSION['bagian'], array('Manifest', 'Master Admin', 'Finance'))) { ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="card shadow mb-4 border-left-primary">
                                    <a href="#dokumen" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="dokumen">
                                        <h6 class="m-0 font-weight-bold text-primary">Berkas Belum Lengkap</h6>
                                    </a>
                                    <div class="collapse" id="dokumen">
                                        <div class="card-body">
                                            <?php if ($nextTrip) : ?>
                                            <div class="card bg-warning text-white">
                                                <a href="<?php echo base_url() . "staff/peserta?id_paket=$nextTrip->id_paket"; ?>"
                                                    target="_blank"><?php echo $nextTrip->nama_paket . ' </a>' . ' <br>' . date_format(date_create($nextTrip->tanggal_berangkat), 'd M Y'); ?><br>
                                                    Total Seat Terisi : <?php echo $totalJamaah; ?>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <?php foreach ($berkas as $key => $b) { ?>
                                                    <tr>
                                                        <th><?php echo str_replace('_', ' ', $key); ?></th>
                                                        <td><?php echo count($b); ?></td>
                                                    <tr>
                                                        <?php } ?>
                                                </table>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-6">
                                <div class="card shadow mb-4 border-left-primary">
                                    <a href="#newRegistrar" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="newRegistrar">
                                        <h6 class="m-0 font-weight-bold text-primary">Jamaah Terbaru <span
                                                class="text-gray-500">(click to expand)</span></h6>
                                    </a>
                                    <div class="collapse" id="newRegistrar">
                                        <div class="card-body">

                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama</th>
                                                            <th>Telp</th>
                                                            <th>Paket</th>
                                                            <th>Register Via</th>
                                                            <th>Lihat</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($newRegistrar as $nr) { ?>
                                                        <tr>
                                                            <td><a href="<?php echo base_url() . "staff/info/detail_jamaah?id=$nr->id_jamaah"; ?>"
                                                                    target="_blank"><?php echo $nr->first_name . ' ' . $nr->second_name . ' ' . $nr->last_name; ?></a>
                                                            </td>
                                                            <td><a
                                                                    href="https://wa.me/<?php echo $nr->no_wa; ?>"><?php echo $nr->no_wa; ?></a>
                                                            </td>
                                                            <?php if (!empty($nr->member[0])) { ?>
                                                            <td><a href="<?php echo base_url() . "staff/paket/lihat?id=" . $nr->member[0]->paket_info->id_paket; ?>"
                                                                    target="_blank"><?php echo !isset($nr->member[0]) ? '' : $nr->member[0]->paket_info->nama_paket . ' <br>(' . date_format(date_create($nr->member[0]->paket_info->tanggal_berangkat), 'd M Y') . ')'; ?>
                                                                </a></td>
                                                            <?php } else { ?>
                                                            <td style="color:red;">Tidak terdaftar pada paket. </td>
                                                            <?php } ?>
                                                            <?php if (!empty($nr->member[0])) { ?>
                                                            <td><?php echo $nr->member[0]->register_from=='app'? 'Aplikasi' : 'Venom' ;?>
                                                            </td>
                                                            <?php } else { ?>
                                                            <td>Tidak terdaftar pada paket. </td>
                                                            <?php } ?>
                                                            <td><a href="<?php echo !isset($nr->member[0]) ? base_url() . "staff/info/detail_jamaah?id=$nr->id_jamaah" : base_url() . "staff/info/detail_jamaah?id=$nr->id_jamaah&id_member=" . $nr->member[0]->id_member; ?>"
                                                                    target="_blank"
                                                                    class="btn btn-primary btn-sm lihat_btn">Detail</a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <?php } ?>
                        <?php if (in_array($_SESSION['bagian'], array('Finance', 'Master Admin'))) { ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <a href="#unverified" class="d-block card-header py-3" data-toggle="collapse"
                                        role="button" aria-expanded="true" aria-controls="unverified">
                                        <h6 class="m-0 font-weight-bold text-primary">Pembayaran Belum di Verifikasi
                                            <span class="text-gray-500">(click to expand)</span>
                                        </h6>
                                    </a>
                                    <div class="collapse" id="unverified">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Tanggal Bayar</th>
                                                            <th>Nama</th>
                                                            <th>Paket</th>
                                                            <th>Nominal</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (empty($unverified)) { ?>
                                                        <tr>
                                                            <td colspan="5">
                                                                <center>Tidak Ada Pembayaran yang Belum di Verifikasi
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php foreach ($unverified as $un) { ?>
                                                        <tr>
                                                            <td><?php echo date_format(date_create($un['pembayaran']->tanggal_bayar), 'd M Y'); ?>
                                                            </td>

                                                            <td><a href="<?php echo base_url() . "staff/info/detail_jamaah?id=" . $un['jamaah']->id_jamaah; ?>"
                                                                    target="_blank"><?php echo $un['jamaah']->first_name . ' ' . $un['jamaah']->second_name . ' ' . $un['jamaah']->last_name; ?></a>
                                                            </td>

                                                            <?php if (!empty($un['paket'])) { ?>
                                                            <td><a href="<?php echo base_url() . "staff/paket/lihat?id=" . $un['paket']->id_paket; ?>"
                                                                    target="_blank"><?php echo $un['paket']->nama_paket . ' (' . date_format(date_create($un['paket']->tanggal_berangkat), 'd M Y') . ')'; ?></a>
                                                            </td>
                                                            <?php } else { ?>
                                                            <td style="color: red;">&lt;detail paket sudah dihapus&gt;
                                                            </td>
                                                            <?php } ?>
                                                            <td><?php echo 'Rp. ' . number_format($un['pembayaran']->jumlah_bayar, 0, ',', '.') . ',-'; ?>
                                                            </td>
                                                            <td><a href="<?php echo base_url() . "staff/finance/verifikasi_data?idj=" . $un['jamaah']->id_jamaah . "&idm=" . $un['pembayaran']->id_member . "&idb=" . $un['pembayaran']->id_pembayaran; ?>"
                                                                    target="_blank"
                                                                    class="btn btn-warning btn-sm lihat_btn">Verifikasi</a>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if (in_array($_SESSION['bagian'], array('Logistik', 'Master Admin'))) { ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card shadow mb-4 border-left-primary">
                                    <a href="#perlengkapanJamaah" class="d-block card-header py-3"
                                        data-toggle="collapse" role="button" aria-expanded="true"
                                        aria-controls="perlengkapanJamaah">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Pengambilan Perlengkapan
                                            <span class="text-gray-500">(click to expand)</span>
                                        </h6>
                                    </a>
                                    <div class="collapse" id="perlengkapanJamaah">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card shadow mb-4 border-left-primary">
                                    <a href="#statusPerlengkapan" class="d-block card-header py-3"
                                        data-toggle="collapse" role="button" aria-expanded="true"
                                        aria-controls="statusPerlengkapan">
                                        <h6 class="m-0 font-weight-bold text-primary">Status Perlengkapan <span
                                                class="text-gray-500">(click to expand)</span></h6>
                                    </a>
                                    <div class="collapse" id="statusPerlengkapan">
                                        <div class="card-body">
                                            <?php if ($nextTrip) : ?>
                                            <div class="card bg-warning text-white">
                                                <a href="<?php echo base_url() . "staff/perlengkapan_paket/atur_status?id=$nextTrip->id_paket"; ?>"
                                                    target="_blank"><?php echo $nextTrip->nama_paket . ' </a>' . ' <br>' . date_format(date_create($nextTrip->tanggal_berangkat), 'd M Y'); ?><br>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Total</th>
                                                            <th>Siap Diambil</th>
                                                            <th>Belum Ready</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>Logistik Pria</th>
                                                            <td><?php echo $statusPerlengkapan['pria']['total']; ?></td>
                                                            <td><?php echo $statusPerlengkapan['pria']['siap']; ?></td>
                                                            <td><?php echo $statusPerlengkapan['pria']['belum']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Logistik Wanita</th>
                                                            <td><?php echo $statusPerlengkapan['wanita']['total']; ?>
                                                            </td>
                                                            <td><?php echo $statusPerlengkapan['wanita']['siap']; ?>
                                                            </td>
                                                            <td><?php echo $statusPerlengkapan['wanita']['belum']; ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php endif; ?>
                                        </div>
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
        $(document).ready(function () {
            $('#infoSeat').DataTable({
                pageLength: 100,
                dom: '',
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url(); ?>staff/dashboard2/load_informasi_seat",
                "columns": [
                    {
                        "data": 'id_paket',
                        "bVisible": false
                    },
                    {
                        "data": 'nama_paket',
                        render: function(data, type, row) {
                            return '<a href="<?php echo base_url() ?>staff/paket/lihat?id='+row['id_paket']+'">'+data+'</a>'
                        }
                    },
                    {
                        "data": 'tanggal_berangkat',
                        render: function(data, type, row) {
                            // Mengubah format tanggal dari 'yyyy-mm-dd' menjadi 'dd M Y'
                            var dateParts = data.split('-');
                            var formattedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                            var options = { day: '2-digit', month: 'short', year: 'numeric' };
                            return formattedDate.toLocaleDateString('en-US', options);
                        }
                    },
                    {
                        "data": 'sisa_seat',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' orang'
                        }
                    },
                    {
                        "data": 'total_belum_bayar',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' Belum Bayar'
                        }
                    },
                    {
                        "data": 'total_lunas',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' Lunas'
                        }
                    },
                    {
                        "data": 'total_cicil',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' Cicil'
                        }
                    },
                    {
                        "data": 'total_lebih',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' Kelebihan Bayar'
                        }
                    },
                ],
                "order": [
                    [2, "asc"]
                ],
            })


            $('#detail_perlengkapan').DataTable({
                pageLength: 100,
                dom: '',
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo base_url(); ?>staff/dashboard2/load_detail_perlengkapan",
                "columns": [
                    {
                        "data": 'id_paket',
                        "bVisible": false
                    },
                    {
                        "data": 'nama_paket',
                        render: function(data, type, row) {
                            return '<a href="<?php echo base_url() ?>staff/paket/lihat?id='+row['id_paket']+'">'+data+'</a>'
                        }
                    },
                    {
                        "data": 'tanggal_berangkat',
                        render: function(data, type, row) {
                            // Mengubah format tanggal dari 'yyyy-mm-dd' menjadi 'dd M Y'
                            var dateParts = data.split('-');
                            var formattedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                            var options = { day: '2-digit', month: 'short', year: 'numeric' };
                            return formattedDate.toLocaleDateString('en-US', options);
                        }
                    },
                    {
                        "data": 'jumlah_seat',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' orang'
                        }
                    },
                    {
                        "data": 'sisa_seat',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' orang'
                        }
                    },
                    {
                        "data": 'total_jamaah',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' orang'
                        }
                    },
                    {
                        "data": 'sudah_semua',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' Sudah Ambil Semua'
                        }
                    },
                    {
                        "data": 'sudah_sebagian',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' Sudah Ambil Sebagian'
                        }
                    },
                    {
                        "data": 'belum_ambil',
                        render: function(data, type, row) {
                            return '<strong>'+data+'</strong>' + ' Belum Ambil'
                        }
                    },
                ],
                "order": [
                    [2, "asc"]
                ],
            })
        });

    </script>


</body>

</html>