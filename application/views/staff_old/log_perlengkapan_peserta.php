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


            <?php $this->load->view('staff/include/side_menu', ['status_jamaah' => true]); ?>

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
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get"
                                            action="<?php echo base_url(); ?>staff/perlengkapan_peserta/log">
                                            <div class="form-group">
                                                <label class="col-form-label">Pilih Paket Umroh dibawah, atau
                                                    <a href="<?php echo base_url(); ?>staff/info/lihat_jamaah"
                                                        class="btn btn-warning btn-icon-split btn-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                        <span class="text">Lihat Semua Paket</span>
                                                    </a>
                                                </label>

                                                <select name="id_paket" class="form-control">
                                                    <?php
                                                    $flagNextSchedule = 1;
                                                    $flagFuture = 1;
                                                    $flagLast = 1;
                                                    ?>
                                                    <?php foreach ($paket as $pkt) { ?>
                                                    <?php
                                                        $futureTrue = strtotime($pkt->tanggal_berangkat) > strtotime('now');
                                                        if ($flagNextSchedule == 1) {
                                                            echo "<optgroup label='Next Trip'>";
                                                            $prepareClose = 1;
                                                            $flagNextSchedule = 0;
                                                        } elseif ($flagFuture == 1 && $futureTrue == true) {
                                                            echo "</optgroup>";
                                                            echo "<optgroup label='Future Trips'>";
                                                            $flagFuture = 0;
                                                        } elseif ($flagLast == 1 && $futureTrue == false) {
                                                            $flagLast = 0;
                                                            echo "</optgroup>";
                                                            echo "<optgroup label='Last Trips'>";
                                                        }
                                                        ?>
                                                    <option value="<?php echo $pkt->id_paket; ?>"
                                                        <?php echo $pkt->id_paket == $id_paket ? 'selected' : ''; ?>>
                                                        <?php echo $pkt->nama_paket; ?>
                                                        (<?php echo date_format(date_create($pkt->tanggal_berangkat), "d F Y"); ?>)
                                                    </option>
                                                    <?php } ?>
                                                    <?php echo "</optgroup>"; ?>
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

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang Mengikuti Program
                                            <strong><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <form
                                                action="<?php echo base_url().'staff/finance/verifikasi?id_paket=all'?>"
                                                method="get">
                                                <input type="hidden" name="id_paket" id="id_paket"
                                                    value="<?php echo $id_paket ?>">
                                                <div class="mt-2">
                                                    <label for="jenis_kelamin">Pilih Jenis Kelamin</label>
                                                    <select name="jenis_kelamin" id="jenis_kelamin"
                                                        class="border border-secondary rounded p-1"
                                                        style="width: 250px;">
                                                        <option value="" selected>-- Pilih Jenis Kelamin --</option>
                                                        <option value="L">Laki - laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th>Nama</th>
                                                                <th>Jenis Kelamin</th>
                                                                <th style="width:137px;">Ambil</th>
                                                                <?php foreach($perlengkapanPaket as $p ) { ?>
                                                                <th><?php echo $p->nama_barang;?></th>
                                                                <?php } ?>
                                                                <th>Aksi</th>
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
        $("#jenis_kelamin").change(function() {
            reinitializeDataTable();
        });

        function reinitializeDataTable() {
            $('#dataTable tbody').off('mouseenter', 'tr');
            $('#dataTable tbody').off('mouseleave', 'tr');
            $('#dataTable tbody').off('click', 'tr');
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }
            loadDatatables();
        }

        loadDatatables();

        function loadDatatables() {
            var jenis_kelamin = !$("#jenis_kelamin").val() ? '' : $("#jenis_kelamin").val();
            var jumlahPerl = <?php echo $countPerl;?>;
            const perlDefs = [];
            for (let i = 3; i <= jumlahPerl + 2; i++) {
                perlDefs.push(i);
            }
            const excel = [];
            for (let i = 0; i <= jumlahPerl + 2; i++) {
                excel.push(i);
            }
            $('#dataTable').DataTable({
                "processing": true,
                "serverSide": true,
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'EXCEL',
                    exportOptions: {
                        columns: excel
                    },
                    // filename: function() {
                    //     var nama = document.getElementById("nama_paket").innerHTML
                    //     return "Dokumen Manifest " + nama;
                    // },
                    // customizeData: function(data) {
                    //     for (var i = 0; i < data.body.length; i++) {
                    //         data.body[i][1] = '\u200C' + data.body[i][1];
                    //     }
                    // },
                }],
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/perlengkapan_peserta/load_log",
                    "data": {
                        id_paket: "<?php echo $id_paket; ?>",
                        jenisKelamin: jenis_kelamin
                    }
                },
                // columns: [{
                //         data: first_name
                //     },
                //     {
                //         data: 'parent_id',
                //         orderable: false,
                //         render: function(data, type, row) {
                //             return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a> \n\
                //                                     <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a>'
                //         }
                //     },
                //     {
                //         data: 'second_name',
                //         visible: false,
                //     },
                //     {
                //         data: 'last_name',
                //         visible: false,
                //     },
                //     {
                //         data: 'whole_name',
                //         bVisible: false,
                //         bSearchable: true
                //     },
                //     {
                //         data: 'two_name',
                //         bVisible: false,
                //         bSearchable: true
                //     },
                // ],
                "columnDefs": [{
                        "targets": 0,
                        "data": "first_name",
                        "render": function(data, type, row) {
                            if (row['second_name'] === null) {
                                r1 = '';
                            } else {
                                r1 = row['second_name'];
                            }
                            if (row['last_name'] === null) {
                                r2 = '';
                            } else {
                                r2 = row['last_name'];
                            }
                            if (row['wg']) {
                                r3 = '<a href="#" class="btn btn-warning btn-sm">WG</a>';
                            } else {
                                r3 = ''
                            }

                            return (data + ' ' + r1 + ' ' + r2 + ' ' + r3).toUpperCase();
                        }

                    },
                    {
                        "targets": 1,
                        "data": "jk",
                        "render": function(data, type, row) {
                            return row['jk'];
                        }
                    },
                    {
                        "targets": 2,
                        "data": "status_perlengkapan",
                        "render": function(data, type, row) {
                            if (data === "Belum Ambil") {
                                bgColor = '#fe000052';
                            } else if (data === "Sudah Sebagian") {
                                bgColor = '#fec00080';
                            } else {
                                bgColor = '#64fe0080';
                            }
                            return '<span style="display:inline-block;padding:9px;border-radius: 20px;color: #4f3232;background-color:' +
                                bgColor + ';"> \n\
                            ' + data + '</span>';
                        }
                    },
                    {
                        "targets": -1,
                        render: function(data, type, row) {
                            return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a>'
                        }
                    },
                    {
                        "targets": perlDefs,
                        render: function(data, type, row) {
                            if (data === 1) {
                                return '<p>Sudah<p><span class="btn btn-sm btn-success btn-circle"><i class="fas fa-check"></i></span>';
                            } else {
                                return '<p>Belum<p><span class="btn btn-sm btn-danger btn-circle"><i class="fas fa-times"></i></span>';
                            }
                        }
                    }
                ],
                order: [
                    [0, 'asc']
                ],
            });
        }
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.location.href =
                "<?php echo base_url(); ?>staff/perlengkapan_peserta/ambil?id_member=" + trid;
        });
        // $("#dataTable tbody").on("click", ".hapus_btn", function() {
        //     var trid = $(this).closest('tr').attr('id'); // table row ID 
        //     var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
        //     window.open("<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + id_jamaah +
        //         "&id_member=" + trid, '_blank');
        // });
    });
    </script>

</body>

</html>