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


            <?php $this->load->view('staff/include/side_menu', ['refund_pembayaran' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Refund Pembayaran</h1>
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
                                            action="<?php echo base_url(); ?>staff/finance/refund">
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
                                                    <option value="0">Lihat Semua</option>
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
                                        <!-- <div class="form-group">
                                            <a href="<?php echo base_url() . 'staff/finance/list_bayar_excel?id=' . $id_paket; ?>"
                                                class="btn btn-info btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-file-excel"></i>
                                                </span>
                                                <span class="text">Download Laporan Pembayaran</span>
                                            </a>
                                            <a href="<?php echo base_url() . 'staff/finance/send_jamaah?id_paket=' . $id_paket . "&input=1"; ?>"
                                                class="btn btn-success btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-paper-plane"></i>
                                                </span>
                                                <span class="text">Kirim Pesan Tagihan</span>
                                            </a>
                                        </div> -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:300px">Nama</th>
                                                        <th>Program</th>
                                                        <th>Total Tagihan</th>
                                                        <th>Total Pembayaran</th>
                                                        <th>Lebih Bayar</th>
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
                "url": "<?php echo base_url(); ?>staff/finance/load_refund",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [{
                    data: 'first_name'
                },
                {
                    data: 'nama_paket'
                },
                {
                    data: 'total_tagihan'
                },
                {
                    data: 'jumlah_pembayaran',
                    render: function(data, type, row) {
                        add =
                            ' <a href="javascript:void(0);" class="btn btn-primary btn-sm riwayat_btn">Rincian & Invoice</a>';
                        return data + add;
                    }
                },
                {
                    data: 'lebih_bayar'
                },
                // {
                //     data: 'status',
                //     render: function(data, type, row) {
                //         if (data == 1) {
                //             data = "SUDAH DIKEMBALIKAN"
                //         }
                //         if (data == 0) {
                //             data = "BELUM DIKEMBALIKAN"
                //         }
                //         if (data == null) {
                //             data = ""
                //         }
                //         return data


                //     }
                // },
                // {
                //     data: 'tanggal_pengembalian',
                //     render: function(data, type, row) {
                //         if (data != "") {
                //             var from = String(data).split("-");
                //             var f = new Date(from[0], from[1] - 1, from[2]);
                //             var data = $.datepicker.formatDate('d M yy', f);
                //             data = data;
                //         } else {
                //             data = ' ';
                //         }
                //         return data;
                //     }
                // },
                // {
                //     data: 'jenis_refund',
                //     render: function(data, type, row) {
                //         if (!data) {
                //             return "";
                //         }
                //         return data.toUpperCase();
                //     }
                // },
                {
                    data: 'parent_id',
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm bayar_lebih_btn mb-2">Bayar Lebih</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn mb-2">Hapus</a>\n\
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

                    return (data + ' ' + r1 + ' ' + r2 + " ( " + row['jumlah_keluarga'] +
                        " Orang )").toUpperCase();
                }

            }],
            order: [
                [5, 'desc']
            ]
        });
        $("#dataTable tbody").on("click", ".bayar_lebih_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/bayar/refund?idj=" + id_jamaah +
                "&idm=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var id_pembayaran = $(this).closest('tr').attr('id_pembayaran'); // table row ID 
            var trid = $(this).closest('tr').attr('id');
            window.location.href = "<?php echo base_url(); ?>staff/finance/hapusPembayaran?id=" +
                id_pembayaran + "&idm=" + trid;
        });
        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pm&id=" + trid;
        });

        $("#dataTable tbody").on("click", ".riwayat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open('<?php echo base_url(); ?>staff/info/riwayat_bayar?id=' + trid, 'newwindow',
                'width=1000,height=800');
        });

    });
    </script>

</body>

</html>