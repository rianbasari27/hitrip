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


            <?php $this->load->view('staff/include/side_menu', ['data_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Peserta Program Umroh</h1>
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
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>

                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get" action="<?php echo base_url(); ?>staff/peserta">
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
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <a href="<?php echo base_url() . 'staff/peserta/scan_paspor_all?id=' . $id_paket; ?>"
                                                        class="btn btn-primary btn-icon-split btn-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-id-card"></i>
                                                        </span>
                                                        <span class="text">Download Scan Paspor</span>
                                                    </a>
                                                    <a target="_blank"
                                                        href="<?php echo base_url() . 'staff/manifest?id_paket=' . $id_paket; ?> "
                                                        class="btn btn-warning btn-sm manifest_btn">Lihat Manifest</a>
                                                    <a target="_blank"
                                                        href="<?php echo base_url() . 'staff/manifest/siskopatuh?id_paket=' . $id_paket; ?> "
                                                        class="btn btn-primary btn-sm manifest_btn">Lihat Siskopatuh</a>
                                                    <a target="_blank"
                                                        href="<?php echo base_url() . 'staff/room_list?id_paket=' . $id_paket; ?> "
                                                        class="btn btn-danger btn-sm room_btn">Lihat Room List</a>
                                                    <a target="_blank"
                                                        href="<?php echo base_url() . 'staff/finance/bayar?id_paket=' . $id_paket; ?> "
                                                        class="btn btn-success btn-sm bayar_btn">Input Pembayaran</a>
                                                    <a target="_blank"
                                                        href="<?php echo base_url() . 'staff/perlengkapan_peserta?id_paket=' . $id_paket; ?> "
                                                        class="btn btn-info btn-sm perlengkapan_btn">Pengambilan
                                                        Perlengkapan Jamaah</a>
                                                    <a href="<?php echo base_url() . 'staff/peserta/scan_foto_all?id=' . $id_paket; ?>"
                                                        class="btn btn-secondary btn-icon-split btn-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-user"></i>
                                                        </span>
                                                        <span class="text">Download Foto VISA</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:155px">Nama</th>
                                                                <th>Referensi</th>
                                                                <th>Nomor Paspor</th>
                                                                <th>Paspor Scan</th>
                                                                <th>Paspor 2 Scan</th>
                                                                <th>KTP Scan</th>
                                                                <th>Foto Scan</th>
                                                                <th>Paspor</th>
                                                                <th style="width:275px">Aksi</th>
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
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/peserta/load_peserta",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [{
                    data: 'first_name'
                },
                {
                    data: 'referensi',
                    "render": function(data, type, row) {

                        if (data && (data.toLowerCase() === 'agen')) {
                            if (row && row['nama_agen']) {
                                return row['nama_agen'].toUpperCase();
                            } else {
                                return '';
                            }
                        } else if (data) {
                            return data.toUpperCase();
                        } else {
                            return '';
                        }
                        
                    }
                },
                {
                    data: 'paspor_no'
                },

                {
                    data: 'paspor_scan'
                },
                {
                    data: 'paspor_scan2'
                },
                {
                    data: 'ktp_scan'
                },
                {
                    data: 'foto_scan'
                },
                {
                    data: 'paspor_check'
                },
                {
                    data: 'parent_id',
                    "render": function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a> \n\
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a> \n\
                                            <a href="javascript:void(0);" class="btn btn-success btn-sm log_btn">Log</a>'
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
                    "targets": 0,
                    "render": function(data, type, row) {
                        if (row['second_name'] == null) {
                            r1 = '';
                        } else {
                            r1 = row['second_name'];
                        }
                        if (row['last_name'] == null) {
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
                    "targets": [3, 4, 5, 6],
                    "render": function(data, type, row) {
                        if (data != '' && data != null) {
                            return '<a href="<?php echo base_url(); ?>' + data + '"' +
                                'onclick="window.open(\'<?php echo base_url(); ?>' + data +
                                '\'' +
                                ',\'newwindow\',\'width=1000,height=500\');return false;"' +
                                '>' +
                                '<img src="<?php echo base_url(); ?>' + data +
                                '" style="width:auto; height:60px">' +
                                '</a>';
                        } else {
                            return '<span class="btn btn-sm btn-danger btn-circle"><i class="fas fa-times"></i></span>';
                        }
                    }

                },
                // {
                //     "targets": [6, 7,],
                //     "render": function(data, type, row) {
                //         if (data !== null) {
                //             return '<span class="btn btn-sm btn-success btn-circle"><i class="fas fa-check"></i></span>';
                //         } else {
                //             return '<span class="btn btn-sm btn-danger btn-circle"><i class="fas fa-times"></i></span>';
                //         }
                //     }
                // },
                {
                    "targets": 7,
                    "render": function(data, type, row) {
                        if (data === '1') {
                            return '<span class="btn btn-sm btn-success btn-circle"><i class="fas fa-check"></i></span>';
                        } else {
                            return '<span class="btn btn-sm btn-danger btn-circle"><i class="fas fa-times"></i></span>';
                        }
                    }
                }
            ],
            "order": [
                [7, 'desc']
            ]
        });
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + id_jamaah +
                "&id_member=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/peserta/hapus?id=" + trid;
            }
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/log?tbl=pm&id=" + trid, '_blank');
        });
    });
    </script>

</body>

</html>