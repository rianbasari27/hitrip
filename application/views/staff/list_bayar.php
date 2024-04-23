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
            <?php $this->load->view('staff/include/side_menu', ["finance" => true, "input_bayar" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Input Pembayaran</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-2 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Program</h6>
                                    </div>
                                    <div class="card-body">
                                        <select name="id_paket" id="id_paket" class="form-select">
                                            <!-- <option value="all">SEMUA PAKET</option> -->
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
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">List Jamaah yang Mengikuti Program
                                            <strong id="nama_paket"><?php echo $nama_paket; ?></strong>
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <table id="dataTable" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="width: 200px">Nama</th>
                                                    <th>Email</th>
                                                    <th>No WA</th>
                                                    <th>Total Harga</th>
                                                    <th>Total Bayar</th>
                                                    <th>Sisa Tagihan</th>
                                                    <th style="width: 300px">Aksi</th>
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
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#id_paket").change(function() {
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
            var idPaket = !$("#id_paket").val() ? <?php echo $id_paket ;?> : $("#id_paket").val();
            console.log(idPaket);
            var dataTable = new DataTable('#dataTable', {
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
                    url: "<?php echo base_url(); ?>staff/finance/load_peserta",
                    data: {
                        id_paket: idPaket
                    }
                },
                order: [
                    [1, "desc"]
                ],
                columnDefs: [{
                        targets: 0,
                        data: 'name',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 1,
                        data: 'email',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 2,
                        data: 'no_wa',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 3,
                        data: 'total_harga',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 4,
                        data: 'total_bayar',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: 5,
                        data: 'sisa_tagihan',
                        render: function(data, type, row) {
                            return data
                        }
                    },
                    {
                        targets: -1,
                        data: null,
                        defaultContent: '<a href="javascript:void(0);" class="btn btn-primary btn-xs rounded-xs lihat_btn mt-1">Detail</a> \n\
                                <a href="javascript:void(0);" class="btn btn-warning btn-xs rounded-xs bayar_btn mt-1">Bayar</a> \n\
                                <a href="javascript:void(0);" class="btn btn-success btn-xs rounded-xs log_btn mt-1">Log</a>'
                    }
                ]
            });
        }

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/info/detail_peserta?id=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".bayar_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/bayar?idm=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".bc_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/broadcast?id=" + trid;
        });

        $("#dataTable tbody").on("click", ".log_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            window.location.href = "<?php echo base_url(); ?>staff/log?tbl=pu&id=" + trid;
        });
    });
    </script>
</body>

</html>