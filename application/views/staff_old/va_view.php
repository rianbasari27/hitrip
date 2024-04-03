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
                            <h1 class="h3 mb-0 text-gray-800">Virtual Account</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <div class="card shadow bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Nama :</strong> <?php echo $first_name . ' ' . $second_name . ' ' . $last_name; ?><br>
                                        <strong>Paket :</strong> <?php echo $member[0]->paket_info->nama_paket; ?> (<?php echo $member[0]->paket_info->tanggal_berangkat; ?>)
                                    </div>
                                </div>
                            </div>

                            <?php if ($groupMembers) { ?>
                                <div class="col-lg-12 mb-5">
                                    <div class="card shadow bg-info text-white">
                                        <div class="card-body">
                                            <strong>Group Members :</strong>
                                            <div class="mt-2">
                                                <ol>
                                                    <?php foreach ($groupMembers as $gm) { ?>
                                                        <li>
                                                            <?php echo implode(" ", [$gm->jamaahData->first_name, $gm->jamaahData->second_name, $gm->jamaahData->last_name]); ?>
                                                            (<?php echo $gm->jamaahData->ktp_no; ?>)
                                                        </li>
                                                    <?php } ?>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="col-lg-12 mb-5">
                                <div class="card shadow bg-primary text-white">
                                    <div class="card-body">
                                        <h3>Sisa Tagihan : <?php echo 'Rp. ' . number_format($pembayaran['sisaTagihan'], 0, ',', '.') . ',-'; ?></h3>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Buat Virtual Account Baru</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                                <?php echo $_SESSION['alert_message']; ?>
                                            </div>
                                        <?php } ?>
                                        <form role="form" action="<?php echo base_url(); ?>staff/va/create" method="post">
                                            <div class="form-group">
                                                <label class="col-form-label">Metode Pembayaran </label>
                                                <br><input type="radio" name="metode" value="BSI-VA" id="bsi_radio" checked> <label for="bsi_radio">BSI Virtual Account (OPEN Payment)</label> <br>
                                                <input type="radio" name="metode" value="duitku" id="duitku_radio"> <label for="duitku_radio">Duitku (CLOSE Payment)</label>
                                            </div>
                                            <div class="bsi">
                                                <p>
                                                    BSI Virtual Account menggunakan mekanisme open payment.<br>
                                                    Jamaah dapat langsung membayarkan
                                                    dengan nominal berapapun yang dikehendaki jamaah dengan ketentuan maksimalnya adalah sesuai dengan
                                                    sisa tagihan.
                                                </p>
                                                <h3>Nomor VA BSI: <span class="font-weight-bolder"><?php echo $member[0]->va_open; ?></span></h3>
                                                <h3>Nomor Rekening (Transfer dari Luar BSI): <span class="font-weight-bolder"><?php echo $pembayaran['tarif']['nomorVAOpenLuarBSI']; ?></span></h3>

                                            </div>


                                            <input type="hidden" name="id_member" value="<?php echo $member[0]->id_member; ?>">
                                            <div class="form-group notbsi">
                                                <label class="col-form-label">Nominal Pembayaran (<span class="text-primary font-italic font-weight-lighter">input hanya angka, tanpa titik/koma</span>)</label>
                                                <input class="form-control" type="number" name="nominal_tagihan">
                                            </div>

                                            <!-- <div class="form-group notbsi">
                                                <div class="col-form-label">VA Expired </div>
                                                <input type="number" name="expiryDays" value="<?php echo $this->config->item('va_expiry_days'); ?>" class="mr-2" style="width: 80px;"> Hari
                                                <input type="number" name="expiryHours" value="<?php echo $this->config->item('va_expiry_hours'); ?>" class="ml-2 mr-2" style="width: 80px;"> Jam
                                            </div>


                                            <div class="form-group notbsi">
                                                <label class="col-form-label">Informasi</label>
                                                <input class="form-control" type="text" name="informasi">
                                            </div> -->
                                            <button class="btn btn-success btn-icon-split notbsi">
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
                                    <a href="#riwayatBSI" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="riwayatBSI">
                                        <h6 class="m-0 font-weight-bold text-primary">Riwayat Virtual Account BSI</h6>
                                    </a>
                                    <div class="collapse" id="riwayatBSI" style="">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:300px">Nomor VA</th>
                                                            <th>Informasi</th>
                                                            <th>Tanggal Create <br><span style="font-style: italic;font-weight: lighter;">(yyyy-mm-dd hh-mm-ss)</span></th>
                                                            <th>Tanggal Expired <br><span style="font-style: italic;font-weight: lighter;">(yyyy-mm-dd hh-mm-ss)</span></th>
                                                            <th>Nominal</th>
                                                            <th>Metode</th>
                                                            <th>Status Pembayaran</th>
                                                            <th>Waktu Transaksi <br><span style="font-style: italic;font-weight: lighter;">(yyyy-mm-dd hh-mm-ss)</span></th>

                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow mb-4 border-left-primary">
                                    <!-- Card Header - Accordion -->
                                    <a href="#riwayatDuitku" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="riwayatDuitku">
                                        <h6 class="m-0 font-weight-bold text-primary">Riwayat DUITKU</h6>
                                    </a>
                                    <!-- Card Content - Collapse -->
                                    <div class="collapse" id="riwayatDuitku" style="">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dtDuitku" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:300px">Reference</th>
                                                            <th>Informasi</th>
                                                            <th>Tanggal Create <br><span style="font-style: italic;font-weight: lighter;">(yyyy-mm-dd hh-mm-ss)</span></th>
                                                            <th>Tanggal Expired <br><span style="font-style: italic;font-weight: lighter;">(yyyy-mm-dd hh-mm-ss)</span></th>
                                                            <th>Nominal</th>
                                                            <th>Metode</th>
                                                            <th>Status</th>
                                                            <th>Payment URL</th>
                                                            <th>Waktu Transaksi <br><span style="font-style: italic;font-weight: lighter;">(yyyy-mm-dd hh-mm-ss)</span></th>

                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
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
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/va/load_va",
                    "data": {
                        id_member: <?php echo $member[0]->id_member; ?>
                    }
                },
                columns: [{
                        data: 'nomor_va'
                    },
                    {
                        data: 'informasi'
                    },
                    {
                        data: 'tanggal_create'
                    },
                    {
                        data: 'tanggal_expired'
                    },
                    {
                        data: 'nominal_tagihan'
                    },
                    {
                        data: 'metode'
                    },
                    {
                        data: 'status_pembayaran'
                    },
                    {
                        data: 'waktu_transaksi'
                    },
                ],
                order: [
                    [2, 'desc']
                ]
            });
            $('#dtDuitku').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/va/load_duitku",
                    "data": {
                        id_member: <?php echo $member[0]->id_member; ?>
                    }
                },
                "columnDefs": [{
                    "targets": [7],
                    "render": function(data, type, row) {
                        return "<a href = " + data + " target='_blank' class='btn btn-success btn-sm'>Go</a>";
                    }
                }],
                order: [
                    [2, 'desc']
                ]
            });
            $('.notbsi').hide();
            $('.bsi').show();
            $('input[type=radio][name=metode]').change(function() {
                if (this.value == 'BSI-VA') {
                    $('.notbsi').hide();
                    $('.bsi').show();
                } else {
                    $('.notbsi').show();
                    $('.bsi').hide();
                }
            });
        });
    </script>
</body>

</html>