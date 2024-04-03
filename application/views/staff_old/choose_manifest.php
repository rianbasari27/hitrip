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
                            <h1 class="h3 mb-0 text-gray-800">Cetak Manifest</h1>
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
                                        <form role="form" method="get" action="<?php echo base_url(); ?>staff/manifest">
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
                                                        <th>NO KTP</th>
                                                        <th>FULL NAME</th>
                                                        <th>PASSPORT NAME</th>
                                                        <th>SEX</th>
                                                        <th>DATE OF BIRTH</th>
                                                        <th>PLACE OF BIRTH</th>
                                                        <th>NO PASSPORT</th>
                                                        <th>DATE OF ISSUE</th>
                                                        <th>DATE OF EXPIRY</th>
                                                        <th>ISSUING OF</th>
                                                        <th>KET</th>
                                                        <th>GROUP</th>
                                                        <th>NAMA KONSULTAN</th>
                                                        <th>NAMA AYAH</th>
                                                        <th>ALAMAT</th>
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
                text: 'EXCEL',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15]
                },
                filename: function() {
                    var nama = document.getElementById("nama_paket").innerHTML
                    return "Dokumen Manifest " + nama;
                },
                customizeData: function(data) {
                    for (var i = 0; i < data.body.length; i++) {
                        data.body[i][1] = '\u200C' + data.body[i][1];
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
                    data: 'ktp_no',
                    bVisible: false
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
                    data: 'paspor_name',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
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
                    data: 'tanggal_lahir',
                    render: function(data, type, row) {
                        if (data != null) {
                            var from = String(data).split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            var data = $.datepicker.formatDate('dd/mm/yy', f);
                            data = data;
                        } else {
                            data = ' ';
                        }
                        return data;
                    }
                },
                {
                    data: 'tempat_lahir',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'paspor_no',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'paspor_issue_date',
                    render: function(data, type, row) {
                        if (data != null) {
                            var from = String(data).split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            var data = $.datepicker.formatDate('dd/mm/yy', f);
                            data = data;
                        } else {
                            data = ' ';
                        }
                        return data;
                    }
                },
                {
                    data: 'paspor_expiry_date',
                    render: function(data, type, row) {
                        if (data != null) {
                            var from = String(data).split("-");
                            var f = new Date(from[0], from[1] - 1, from[2]);
                            var data = $.datepicker.formatDate('dd/mm/yy', f);
                            data = data;
                        } else {
                            data = ' ';
                        }
                        return data;
                    }
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
                    data: null,
                    "render": function(data, type, row) {
                        if (row['wg']) {
                            return 'WG';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'parent_id'
                },
                {
                    data: 'nama_agen',
                    render: function(data, type, row) {
                        if (!data) {
                            return "";
                        }
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'nama_ayah',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'alamat_tinggal',
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
                [11, 'desc']
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