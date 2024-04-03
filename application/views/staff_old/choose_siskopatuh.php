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


            <?php $this->load->view('staff/include/side_menu', ['dokumen_admin' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Cetak Manifest Siskopatuh</h1>
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
                                            action="<?php echo base_url(); ?>staff/manifest/siskopatuh">
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
                                        <h6 class="m-0 font-weight-bold text-primary">Manifest Program
                                            <strong id="nama_paket"><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:5px">NO</th>
                                                        <th>TITLE</th>
                                                        <th>NAMA ( SESUAI DENGAN NAMA PADA KARTU VAKSIN )</th>
                                                        <th>NAMA</th>
                                                        <th>NAMA AYAH</th>
                                                        <th>JENIS IDENTITAS</th>
                                                        <th>NO IDENTITAS</th>
                                                        <th>NAMA PASPOR</th>
                                                        <th>NO PASPOR</th>
                                                        <th>TANGGAL DIKELUARKAN PASPOR</th>
                                                        <th>KOTA PASPOR</th>
                                                        <th>TEMPAT LAHIR</th>
                                                        <th>TANGGAL LAHIR</th>
                                                        <th>ALAMAT</th>
                                                        <th>PROVINSI</th>
                                                        <th>KABUPATEN</th>
                                                        <th>KECAMATAN</th>
                                                        <th>KELURAHAN</th>
                                                        <th>NO TELP</th>
                                                        <th>NO HP</th>
                                                        <th>KEWARGANEGARAAN</th>
                                                        <th>STATUS PERNIKAHAN</th>
                                                        <th>PENDIDIKAN</th>
                                                        <th>PEKERJAAN</th>
                                                        <th>PROVIDER VISA</th>
                                                        <th>NO VISA</th>
                                                        <th>TANGGAL BERLAKU VISA</th>
                                                        <th>TANGGAL AKHIR VISA</th>
                                                        <th>ASURANSI</th>
                                                        <th>NO POLIS</th>
                                                        <th>TANGGAL INPUT POLIS</th>
                                                        <th>TANGGAL AWAL POLIS</th>
                                                        <th>TANGGAL AKHIR POLIS</th>
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
            pageLength: 100,
            lengthMenu: [
                [100, 50, 25, 10],
                [100, 50, 25, 10]
            ],
            "processing": true,
            dom: 'lBfrtip',
            buttons: [{
                extend: 'excel',
                text: "SISKOPATUH",
                exportOptions: {
                    columns: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
                        19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32
                    ]
                },
                filename: function() {
                    var nama = document.getElementById("nama_paket").innerHTML
                    return "Dokumen Siskopatuh " + nama;
                },
                customizeData: function(data) {
                    for (var i = 0; i < data.body.length; i++) {
                        data.body[i][5] = '\u200C' + data.body[i][5];
                    }
                },
            }],
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/manifest/loadData",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [{
                    data: 'id_member',
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: 'jenis_kelamin',
                    render: function(data, type, row) {
                        function calculate_age(dob) {
                            var diff_ms = Date.now() - dob.getTime();
                            var age_dt = new Date(diff_ms);

                            return Math.abs(age_dt.getUTCFullYear() - 1969);
                        }
                        var parts = 0;
                        // if tanggal lahir tidak null
                        parts = String(row['tanggal_lahir']).split("-");


                        usia = calculate_age(new Date(parts[0], parts[1] - 1, parts[2]));
                        if (isNaN(usia)) {
                            usia = 25;
                        }
                        if (row['jenis_kelamin'] == null) {
                            row['jenis_kelamin'] = 'L';
                        }
                        // console.log(row['jenis_kelamin']);

                        if (row['jenis_kelamin'] == "L" && usia <= 17) {
                            data = "MSTR";
                        } else if (row['jenis_kelamin'] == "L" && usia > 17) {
                            data = "MR";
                        } else if (row['jenis_kelamin'] == "P" && usia <= 17) {
                            data = "MISS";
                        } else if (row['jenis_kelamin'] == "P" && usia > 17) {
                            data = "MRS";
                        }
                        return data;
                    }
                },
                {
                    data: 'first_name',
                    render: function(data, type, row) {
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

                        return (data + ' ' + r1 + ' ' + r2).toUpperCase();
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'first_name',
                    render: function(data, type, row) {
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

                        return (data + ' ' + r1 + ' ' + r2).toUpperCase();
                    }
                },
                {
                    data: 'nama_ayah',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'ktp_no',
                },
                {
                    data: 'paspor_name',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'paspor_no'
                },
                {
                    data: 'paspor_issue_date'
                },
                {
                    data: 'paspor_issuing_city',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'tempat_lahir',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'tanggal_lahir',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'alamat_tinggal',
                },
                {
                    data: 'provinsi',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'kabupaten_kota',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'kecamatan',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'no_rumah',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'no_wa',
                },
                {
                    data: 'kewarganegaraan',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'status_perkawinan',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'pendidikan_terakhir',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'pekerjaan',
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: null,
                    "render": function(data, type, row) {
                        return '';
                    },
                    bVisible: false,
                    bSearchable: true
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
            "order": [
                [2, 'desc']
            ]
        });

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var id_jamaah = $(this).closest('tr').attr('id_jamaah'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/info/detail_jamaah?id=" + id_jamaah +
                "&id_member=" + trid;
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
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pm&id=" + trid;
        });
    });
    </script>

</body>

</html>