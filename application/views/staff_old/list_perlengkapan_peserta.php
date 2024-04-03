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


            <?php $this->load->view('staff/include/side_menu', ['perl_jamaah' => true]); ?>

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
                                            action="<?php echo base_url(); ?>staff/perlengkapan_peserta">
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
                                        <h6 class="m-0 font-weight-bold text-primary">Status Perlengkapan untuk Program
                                            <strong><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">

                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <a href="<?php echo base_url() . 'staff/perlengkapan_paket/atur_status?id=' . $id_paket; ?>"
                                                                    class="btn btn-primary lihat_btn">Lihat Detail
                                                                    Status</a>
                                                            </th>
                                                            <th>Logistik Pria (Total <?php echo $totalPria; ?>)</th>
                                                            <th>Logistik Wanita (Total <?php echo $totalWanita; ?>)</th>
                                                            <th>Logistik Anak Pria (Total <?php echo $totalAnakPria; ?>)
                                                            </th>
                                                            <th>Logistik Anak Wanita (Total
                                                                <?php echo $totalAnakWanita; ?>)</th>
                                                            <th>Logistik Bayi (Total <?php echo $totalBayi; ?>)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th class="bg-warning text-white">Belum Ready</th>
                                                            <td><?php echo $belumReadyPria == 0 ? ' - ' : implode(", ", $brgBelumReadyPria); ?>
                                                            </td>
                                                            <td><?php echo $belumReadyWanita == 0 ? ' - ' : implode(", ", $brgBelumReadyWanita); ?>
                                                            </td>
                                                            <td><?php echo $belumReadyAnakPria == 0 ? ' - ' : implode(", ", $brgBelumReadyAnakPria); ?>
                                                            </td>
                                                            <td><?php echo $belumReadyAnakWanita == 0 ? ' - ' : implode(", ", $brgBelumReadyAnakWanita); ?>
                                                            </td>
                                                            <td><?php echo $belumReadyBayi == 0 ? ' - ' : implode(", ", $brgBelumReadyBayi); ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <th class="bg-success text-white">Siap Diambil</th>
                                                            <td><?php echo $siapDiambilPria == 0 ? ' - ' : implode(", ", $brgSiapPria); ?>
                                                            </td>
                                                            <td><?php echo $siapDiambilWanita == 0 ? ' - ' : implode(", ", $brgSiapWanita); ?>
                                                            </td>
                                                            <td><?php echo $siapDiambilAnakPria == 0 ? ' - ' : implode(", ", $brgSiapAnakPria); ?>
                                                            </td>
                                                            <td><?php echo $siapDiambilAnakWanita == 0 ? ' - ' : implode(", ", $brgSiapAnakWanita); ?>
                                                            </td>
                                                            <td><?php echo $siapDiambilBayi == 0 ? ' - ' : implode(", ", $brgSiapBayi); ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
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
                                                <?php if (empty($perlengkapan)) { ?>
                                                <div class="mb-4">
                                                    <span class="text">
                                                        Perlengkapan belum diatur, atur perlengkapan paket terlebih
                                                        dahulu disini
                                                        <a href="<?php echo base_url() . 'staff/perlengkapan_paket/atur?id=' . $id_paket; ?>"
                                                            class="btn btn-warning lihat_btn">Atur Perlengkapan
                                                            Paket</a>
                                                    </span>
                                                </div>
                                                <?php } ?>
                                                <?php if (!empty($perlengkapan) && ($siapDiambilPria == 0 && $siapDiambilWanita == 0)) { ?>
                                                <div class="mb-4">
                                                    <span class="text">
                                                        Perlengkapan belum ada yang siap diambil, untuk merubah status
                                                        perlengkapan klik disini
                                                        <a href="<?php echo base_url() . 'staff/perlengkapan_paket/atur_status?id=' . $id_paket; ?>"
                                                            class="btn btn-warning lihat_btn">Atur Status
                                                            Perlengkapan</a>
                                                    </span>
                                                </div>
                                                <?php } ?>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:155px">Nama</th>
                                                                <th>Nomor Paspor</th>
                                                                <th>Nama Konsultan</th>
                                                                <th>Status Bayar</th>
                                                                <th style="width:137px;">Ambil</th>
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
                "url": "<?php echo base_url(); ?>staff/perlengkapan_peserta/load_peserta",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [{
                    data: 'first_name'
                },
                {
                    data: 'paspor_no'
                },
                {
                    data: 'nama_agen',
                    render: function(data, type, row) {
                        if (data != null) {
                            return data.toUpperCase();
                        } else {
                            return data;
                        }
                    }
                },
                {
                    data: 'lunas',
                    render: function(data, type, row) {
                        var ket = '';
                        if (data === '0') {
                            ket = 'Belum Bayar';
                        } else if (data === '1') {
                            ket = 'Lunas';
                        } else if (data === '2') {
                            ket = 'Sudah Cicil';
                        } else if (data === '3') {
                            ket = 'Kelebihan Bayar';
                        }
                        return ket.toUpperCase();
                    }
                },
                {
                    data: 'status_perlengkapan',
                    orderable: false,
                    render: function(data, type, row) {
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
                    data: 'parent_id',
                    orderable: false,
                    render: function(data, type, row) {
                        return '<a href="javascript:void(0);" class="btn btn-primary btn-sm lihat_btn">Detail</a> \n\
                                <a href="javascript:void(0);" class="btn btn-success btn-sm ambil_btn">Ambil Perlengkapan</a> \n\
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm hapus_btn">Hapus</a>'
                    }
                },
                {
                    data: 'second_name',
                    visible: false,
                },
                {
                    data: 'last_name',
                    visible: false,
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
            order: [
                [3, 'asc']
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
                    if (row['wg']) {
                        r3 = '<a href="#" class="btn btn-warning btn-sm">WG</a>';
                    } else {
                        r3 = ''
                    }

                    return (data + ' ' + r1 + ' ' + r2 + ' ' + r3).toUpperCase();
                }

            }]
        });
        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + id_jamaah +
                "&id_member=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".ambil_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/perlengkapan_peserta/ambil?id_member=" + trid,
                '_blank');
        });
        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/perlengkapan_peserta/hapus?id_member=" + trid,
                '_blank');
        });
    });
    </script>

</body>

</html>