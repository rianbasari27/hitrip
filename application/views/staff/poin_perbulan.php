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


            <?php $this->load->view('staff/include/side_menu', ['data_poin' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Konsultan</h1>
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
                                <div class="content mb-0">
                    <p class="mb-n1 font-600 color-highlight">Segera bergabung, seat terbatas!</p>
                    <h2 class="mb-4">Jadwal Keberangkatan
                        <?php echo $monthSelected ? $this->date->convert("F", '01-' . $monthSelected . '-1990') : ""; ?>
                    </h2>
                    <div class="card card-style bg-highlight pt-2 pb-2" data-menu="menu-bulan">
                        <h5 class="color-white text-center">
                            Pilih Bulan
                            <span class="ms-2 icon icon-xxs bg-theme color-black rounded-xl"><i
                                    class="fa fa-arrow-right"></i></span>
                        </h5>
                    </div>
                    <div class="row mb-0">
                        <?php foreach ($paket as $p) { ?>
                        <div class="d-flex" onclick="window.location='<?php echo $p->detailLink; ?>';">                            
                            <div class="col-12">                                
                                <a href="#">
                                    <h5 class="mb-0"><?php echo $p->nama_paket; ?></h5>                                    
                                </a>                                
                                <span class="opacity-100 font-11">Berangkat
                                    <?php echo $this->date->convert("j F Y", $p->tanggal_berangkat); ?></span>
                            </div>
                        </div>

                        <div class="w-100 divider divider-margins"></div>
                        <?php } ?>


                    </div>
                </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">                                   
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>NIK</th>
                                                        <th>WhatsApp</th>
                                                        <th>Kota</th>
                                                        <th>Poin<br>(cl)</th>
                                                        <th>Poin<br>(un)</th>
                                                        <th style="width:200px">Aksi</th>
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
                <div id="menu-bulan" class="menu menu-box-bottom rounded-m" data-menu-height="450" data-menu-effect="menu-over">
                    <div class="menu-title">
                        <p class="color-highlight">Selalu Tersedia</p>
                        <h1 class="font-24">Pilih Bulan Keberangkatan</h1>

                        <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>

                    </div>
                    <div class="me-4 ms-3 mt-2">
                        <div class="list-group list-custom-small">
                            <a href="<?php echo base_url() . 'staf/poin_bulan#paket'; ?>"><span>Semua Keberangkatan</span><i class="fa fa-angle-right"></i></a>
                            <?php foreach ($availableMonths as $month) { ?>
                            <a href="<?php echo base_url() . 'staf/poin_bulan?month=' . substr($month->tanggal_berangkat, 5, 2); ?>#paket"><span><?php echo $this->date->convert('F', $month->tanggal_berangkat); ?></span><i class="fa fa-angle-right"></i></a>
                            <?php } ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

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
                "ajax": "<?php echo base_url(); ?>staff/kelola_agen/load_agen",
                columns: [{
                        data: 'nama_agen'
                    },
                    {
                        data: 'no_agen'
                    },
                    {
                        data: 'no_wa'
                    },
                    {
                        data: 'kota'
                    },
                    {
                        data: 'claimed_point'
                    },
                    {
                        data: 'unclaimed_point'
                    },
                    {
                        data: 'DT_RowId',
                        "render": function(data, type, row) {
                            return '<a href="javascript:void(0);" class="btn btn-warning btn-sm lihat_btn">Lihat Konsultan</a>\n\
                                        <a href="javascript:void(0);" class="btn btn-primary btn-sm jamaah_btn">Lihat Jamaah</a>'
                        }
                    }
                ]
            });

            $("#dataTable tbody").on("click", ".lihat_btn", function() {
                const trid = $(this).closest('tr').attr('id'); // table row ID
                window.open("<?php echo base_url(); ?>staff/kelola_agen/profile?id=" + trid, '_blank');
            });

            $("#dataTable tbody").on("click", ".jamaah_btn", function() {
                const trid = $(this).closest('tr').attr('id'); // table row ID
                window.open("<?php echo base_url(); ?>staff/kelola_agen/jamaah?id=" + trid, '_blank');
            });
        });
    </script>

</body>

</html>