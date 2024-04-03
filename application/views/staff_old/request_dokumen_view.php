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


            <?php $this->load->view('staff/include/side_menu', ['request_dokumen' => true]); ?>

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
                        <div class="d-sm-flex align-items-center justify-content-bedteen mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Request Dokumen</h1>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Request Dokumen</strong></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:100px">Nama</th>
                                                        <th style="width:155px">Program</th>
                                                        <th style="width:155px">Tanggal Request</th>
                                                        <th style="width:100px;">Telepon</th>
                                                        <th>Status</th>
                                                        <th style="width:150px">Aksi</th>
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
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/request_dokumen/load_request"
            },
            columns: [{
                    data: 'nama_2_suku'
                },
                {
                    data: 'nama_paket',
                    render: function(data, type, row) {
                        var from = row['tanggal_berangkat'].split("-");
                        var f = new Date(from[0], from[1] - 1, from[2]);
                        var tgl = $.datepicker.formatDate('dd M yy ', f);
                        return data + '<br>' + '(' + tgl + ')';
                    }
                },
                {
                    data: 'tgl_request',
                },
                {
                    data: 'no_wa'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        if (data == 0) {
                            v = 'Belum';
                        } else if (data == 1) {
                            v = 'Sedang Proses';
                        } else {
                            v = 'Selesai';
                        }
                        return v;
                    }
                },
                {
                    data: 'id_member',
                    "render": function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm verifikasi_btn">Kelola Request</a> \n\
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn m-1">Hapus</a>'
                    }

                },
                {
                    data: 'whole_name',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'two_name',
                    bVisible: false,
                    bSearchable: true
                },

            ],
            "columnDefs": [{
                "targets": 2,
                "render": function(data, type, row) {
                    var dt = new Date(data);
                    var tahun = dt.getFullYear();
                    var hari = dt.getDay();
                    var bulan = dt.getMonth();
                    var tanggal = dt.getDate();
                    var hariarray = new Array("Sun,", "Mon,", "Tue,", "Wed,", "Thu,",
                        "Fri,", "Sat,");
                    var bulanarray = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
                    var z = hariarray[hari] + " " + ((tanggal < 10) ? "0" : "") + tanggal +
                        " " + bulanarray[bulan] + " " + tahun + "<br>" + "( " + ((dt
                            .getHours() < 10) ? "0" : "") + dt.getHours() + ":" + ((dt
                            .getMinutes() < 10) ? "0" : "") + dt.getMinutes() + ":" + ((dt
                            .getSeconds() < 10) ? "0" : "") + dt.getSeconds() + " )";
                    return z;
                }
            }],
            order: [
                [4, 'asc'],
                [2, 'desc']
            ]
        });
        $("#dataTable tbody").on("click", ".verifikasi_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID
            var id_request = $(this).closest('tr').attr('id_request');
            window.location.href = "<?php echo base_url(); ?>staff/request_dokumen/req?idm=" + trid + "&idr=" + id_request, '_blank';
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id_request'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/request_dokumen/hapus?id=" +
                    trid;
            }
        });
    });
    </script>

</body>

</html>