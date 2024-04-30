<!DOCTYPE html>

<html lang="en" class="material-style layout-fixed">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
</head>

<body>
    <!-- [ Preloader ] Start -->
    <div class="page-loader">
        <div class="bg-primary"></div>
    </div>
    <!-- [ Preloader ] End -->

    <!-- [ Layout wrapper ] Start -->
    <div class="layout-wrapper layout-2">
        <div class="layout-inner">
            <?php $this->load->view('staff/include/side_menu', [ "dash" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Dashboard</h4>
                        <div class="text-muted small mt-0 mb-4 d-block breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#">Library</a></li>
                                <li class="breadcrumb-item active">Data</li>
                            </ol>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6">
                                <div class="row mb-0">
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-2-dark">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-briefcase display-4 text-primary"></div>
                                                    <div class="ml-3">
                                                        <div class="text-muted small">Next Trip</div>
                                                        <div class="text-large"><?php echo $nextTrip->nama_paket . ', ' . $nextTrip->negara ?></div>
                                                    </div>
                                                </div>
                                                <div id="ecom-chart-3" class="mt-3 chart-shadow-primary"
                                                    style="height:10px"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-2 bg-primary text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-calendar-full display-4"></div>
                                                    <div class="ml-3">
                                                        <div class="small">Trip Date</div>
                                                        <div class="text-large"><?php echo $nextTrip ? date_format(date_create($nextTrip->tanggal_berangkat), "d M Y") : 'Tidak ada' ?></div>
                                                    </div>
                                                </div>
                                                <div id="order-chart-1" class="mt-3 chart-shadow" style="height:10px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-2 bg-primary text-white">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-history display-4"></div>
                                                    <div class="ml-3">
                                                        <div class="small">Days Countdown</div>
                                                        <div class="text-large"><?php echo $nextTrip ? $nextTrip->countdown . ' Hari lagi' : '-' ?></div>
                                                    </div>
                                                </div>
                                                <div id="order-chart-1" class="mt-3 chart-shadow" style="height:10px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card mb-4 bg-pattern-2-dark">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="lnr lnr-users display-4 text-primary"></div>
                                                    <div class="ml-3">
                                                        <div class="text-muted small">Seat Terisi</div>
                                                        <div class="text-large"><?php echo $totalJamaah ?> Pax</div>
                                                    </div>
                                                </div>
                                                <div id="ecom-chart-3" class="mt-3 chart-shadow-primary"
                                                    style="height:10px"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card p-4" style="height: 280px">
                                    <div class="card-header with-elements pb-0">
                                        <h6 class="card-header-title mb-0" style="height: 100px;">Informasi Paket Trip</h6>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <td>Paket di-publish</td>
                                            <td><?php echo $packagePublished ?> Paket</td>
                                        </tr>
                                        <tr>
                                            <td>Paket unpublish</td>
                                            <td><?php echo $packageUnpublished ?> Paket</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                            <div class="card mb-4">
                                    <div class="card-header with-elements pb-0">
                                        <h6 class="card-header-title mb-0">Pendaftar Terbaru</h6>
                                        
                                    </div>
                                    <div class="nav-tabs-top">
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="sale-stats">
                                                <div id="tab-table-1">
                                                    <table class="table table-hover card-table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>Referensi</th>
                                                                <th>Nama Paket</th>
                                                                <th>Tanggal Regist</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1; ?>
                                                            <?php foreach ($newRegistrar as $nr) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $no ?>
                                                                    </td>
                                                                    <td>
                                                                        <h6 class="mb-0"><?php echo $nr->name ?></h6>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo $nr->referensi ?>
                                                                    </td>
                                                                    <?php if (!empty($nr->member[0])) { ?>
                                                                        <td>
                                                                            <?php echo $nr->member[0]->paket_info->nama_paket ?>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td>
                                                                            Tidak terdaftar paket
                                                                        </td>
                                                                    <?php } ?>
                                                                    <?php if (!empty($nr->member[0])) { ?>
                                                                        <td>
                                                                            <?php echo $nr->member[0]->tgl_regist ?>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td>
                                                                            Tidak terdaftar paket
                                                                        </td>
                                                                    <?php } ?>
                                                                    <?php if (!empty($nr->member[0])) { ?>
                                                                        <td>
                                                                            <?php if ($nr->member[0]->lunas == 0) { ?>
                                                                                <span class="text-danger">Belum DP</span>
                                                                            <?php } else if ($nr->member[0]->lunas == 1) { ?>
                                                                                <span class="text-success">Lunas</span>
                                                                            <?php } else if ($nr->member[0]->lunas == 2) { ?>
                                                                                <span class="text-warning">Belum Lunas</span>
                                                                            <?php } else if ($nr->member[0]->lunas == 3) { ?>
                                                                                <span class="text-info">Lebih Bayar</span>
                                                                            <?php } ?>
                                                                        </td>
                                                                    <?php } else { ?>
                                                                        <td>-</td>
                                                                    <?php } ?>
                                                                    </tr>
                                                                    <?php $no++ ?>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- <a href="javascript:"
                                                    class="card-footer d-block text-center text-dark small font-weight-semibold">SHOW
                                                    MORE</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                    <!-- [ content ] End -->

                    <?php $this->load->view('staff/include/footer_view') ?>
                </div>
                <!-- [ Layout content ] Start -->
            </div>
            <!-- [ Layout container ] End -->
        </div>
        <!-- Overlay -->
        <div class="layout-overlay layout-sidenav-toggle"></div>
    </div>
    <!-- [ Layout wrapper] End -->
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('staff/include/script_view') ?>
</body>

</html>