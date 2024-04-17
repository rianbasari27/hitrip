<!DOCTYPE html>
<html lang="en">

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
            <?php $this->load->view('staff/include/side_menu', ["produk" => true, "list_produk" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Daftar Paket / Produk</h4>
                        <!-- <div class='row'>
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get" action="<?php echo base_url(); ?>staff/paket">
                                            <div class="form-group">
                                                <select name="month" class="form-control">
                                                    <option value="0">Lihat Semua</option>
                                                    <?php foreach ($monthPackage as $m) { ?>
                                                    <option
                                                        value="<?php echo date('m', strtotime($m->tanggal_berangkat))?>"
                                                        <?php echo date('m', strtotime($m->tanggal_berangkat)) == $month ? 'selected' : ''; ?>>
                                                        <?php echo $this->date->convert('F', $m->tanggal_berangkat); ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
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

                        </div> -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Paket Umroh yang Terdaftar
                                            didalam Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div style="width: 20px; height: 20px; background-color: lightgreen; margin-right: 5px;"
                                                class="rounded border border-dark"></div>
                                            <p class="text-dark">Broadcast Aktif</p>
                                        </div>
                                        <table id="dataTable" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 200px">Nama Paket</th>
                                                    <th>Tanggal Keberangkatan</th>
                                                    <th>Jumlah Pax</th>
                                                    <th>Harga Quad</th>
                                                    <th>Harga Triple</th>
                                                    <th>Harga Double</th>
                                                    <th>Publish</th>
                                                    <th style="width: 300px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th style="width: 200px">Nama Paket</th>
                                                    <th>Tanggal Keberangkatan</th>
                                                    <th>Jumlah Pax</th>
                                                    <th>Harga Quad</th>
                                                    <th>Harga Triple</th>
                                                    <th>Harga Double</th>
                                                    <th>Publish</th>
                                                    <th style="width: 300px">Aksi</th>
                                                </tr>
                                            </tfoot>
                                        </table>
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
    <?php $this->load->view('staff/include/script_view') ?>
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        new DataTable('#dataTable', {
            layout: {
                bottomEnd: {
                    paging: {
                        boundaryNumbers: false
                    }
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url(); ?>staff/paket/load_paket",
                data: {
                    month: "<?php echo $month; ?>"
                }
            },
            order: [
                [1, "desc"]
            ],
            columnDefs: [{
                targets: -1,
                data: null,
                defaultContent: '<a href="javascript:void(0);" class="btn btn-primary btn-xxs lihat_btn">Lihat</a> \n\
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm bc_btn">Broadcast</a> \n\
                                <a href="javascript:void(0);" class="btn btn-warning btn-sm manasik_btn">BC Manasik</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mt-1">Hapus</a> \n\
                                <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn mt-1">Log</a>'
            }]
        });



        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/paket/lihat?id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".bc_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/paket/hapus?id=" + trid;
            }
        });

        $("#dataTable tbody").on("click", ".manasik_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast/manasik?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pu&id=" + trid;
        });
    });
    </script>
</body>

</html>