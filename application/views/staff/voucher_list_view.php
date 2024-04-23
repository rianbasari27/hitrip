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
            <?php $this->load->view('staff/include/side_menu', ["voucher_promo" => true, "voucher_view" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">List Voucher </h4>
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
                                        <h6 class="m-0 font-weight-bold text-primary">List Voucher yang Terdaftar
                                            didalam Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <a class="btn btn-primary btn-icon-split btn-xs rounded-xs mb-2"
                                            href="<?php echo base_url() . 'staff/voucher/tambah' ;?>">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-plus me-2"></i>
                                            </span>
                                            <span class="text">Tambah Voucher</span>
                                        </a>
                                        <table id="dataTable" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th style="width: 200px">Kode Voucher</th>
                                                    <th>Nominal</th>
                                                    <th>Kuota Voucher</th>
                                                    <th>Tanggal Berlaku</th>
                                                    <th>Tanggal Berakhir</th>
                                                    <th>Status</th>
                                                    <th style="width: 400px">Aksi</th>
                                                </tr>
                                            </thead>
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
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <?php $this->load->view('staff/include/script_view') ?>
    <script>
    function formatTanggalWaktuIndonesia(tanggal) {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        };
        return tanggal.toLocaleDateString('id-ID', options);
    }
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
                url: "<?php echo base_url(); ?>staff/voucher/load_voucher"
            },
            order: [
                [4, "asc"]
            ],
            columnDefs: [{
                    targets: -1,
                    data: null,
                    defaultContent: '<a href="javascript:void(0);" class="btn btn-primary btn-xs rounded-xs edit_btn mt-1">Edit</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-xs rounded-xs hapus_btn mt-1">Delete</a> \n\
                                <a href="javascript:void(0);" class="btn btn-success btn-xs rounded-xs log_btn mt-1">Log</a>'
                },
                {
                    targets: [4, 5],
                    render: function(data, type, row) {
                        if (data != null && data != '') {
                            var tanggalSekarang = new Date(data);
                            var tanggalWaktuIndonesia = formatTanggalWaktuIndonesia(
                                tanggalSekarang);
                        } else {
                            tanggalWaktuIndonesia = ''
                        }
                        return tanggalWaktuIndonesia
                    }
                },
                {
                    targets: 0,
                    data: 'DT_RowId',
                    render: function(data, type, full, meta) {
                        var page = meta.settings._iDisplayStart / meta.settings
                            ._iDisplayLength;
                        return page * meta.settings._iDisplayLength + meta.row + 1
                    }
                },
            ]
        });



        $("#dataTable tbody").on("click", ".edit_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/voucher/edit?id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".bc_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/voucher/hapus?id=" + trid;
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