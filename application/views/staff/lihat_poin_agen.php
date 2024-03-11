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


            <?php $this->load->view('staff/include/side_menu', ['data_konsultan' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Konsultan</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Nama konsultan yang terdaftar di
                                            sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <form
                                                action="<?php echo base_url().'staff/kelola_agen/lihat_poin?id=' . $id_agen?>"
                                                method="get">
                                                <input type="hidden" name="id_agen" id="id_agen"
                                                    value="<?php echo $id_agen ?>">
                                                <div>
                                                    <label for="date_start">Pilih Musim</label>
                                                    <select name="musim" id="musim"
                                                        class="border border-secondary rounded p-1"
                                                        style="width: 250px;">
                                                        <option value="" selected>-- Pilih Musim --</option>
                                                        <?php foreach ($musimGroup as $group) { ?>
                                                        <option value="<?php echo $group->musim ;?>">
                                                            <?php echo $group->musim ;?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="150%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th style="width: 300px;">Nama Jamaah</th>
                                                        <th style="width: 300px;">Program</th>
                                                        <th style="width: 300px;">Tanggal Keberangkatan</th>
                                                        <th>No Jamaah</th>
                                                        <th style="width: 300px;">Tanggal Insert</th>
                                                        <th>Musim</th>
                                                        <th>Poin</th>
                                                        <th style="width: 300px;">Keterangan</th>
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
    function formatTanggalWaktuIndonesia(tanggal) {
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            timeZoneName: 'short'
        };
        return tanggal.toLocaleDateString('id-ID', options);
    }
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#musim").change(function() {
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
            var musim = !$("#musim").val() ? '' : $("#musim").val();

            var dataTable = $('#dataTable').DataTable({
                "pageLength": 50,
                "lengthMenu": [
                    [1000, 100, 50, 25, 10],
                    [1000, 100, 50, 25, 10]
                ],
                dom: 'lBfrtip',
                buttons: [{
                    extend: 'excel',
                    text: 'EXCEL',
                    filename: function() {
                        return "Daftar Poin Konsultan";
                    },
                    // customizeData: function(data) {
                    //     for (var i = 0; i < data.body.length; i++) {
                    //         data.body[i][1] = '\u200C' + data.body[i][1];
                    //     }
                    // },
                }],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>staff/kelola_agen/load_poin",
                    "data": {
                        id_agen: "<?php echo $id_agen; ?>",
                        musim: musim
                    }
                },
                columns: [{
                        data: 'DT_RowId',
                        "render": function(data, type, full, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'whole_name'
                    },
                    {
                        data: 'nama_paket'
                    },
                    {
                        data: 'tanggal_berangkat'
                    },
                    {
                        data: 'no_wa'
                    },
                    {
                        data: 'tanggal_insert',
                        render: function(data, type, row) {
                            const tanggalSekarang = new Date(data);
                            const tanggalWaktuIndonesia = formatTanggalWaktuIndonesia(
                                tanggalSekarang);

                            return tanggalWaktuIndonesia
                        }
                    },
                    {
                        data: 'musim'
                    },
                    {
                        data: 'poin'
                    },
                    {
                        data: 'keterangan'
                    }
                ],
                order: [2, 'desc']
            });
        }

        $("#dataTable tbody").on("click", ".lihat_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/kelola_agen/profile?id=" + trid, '_blank');
        });

        $("#dataTable tbody").on("click", ".jamaah_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/kelola_agen/jamaah?id=" + trid, '_blank');
        });
        $("#dataTable tbody").on("click", ".network_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID
            window.open("<?php echo base_url(); ?>staff/agen_network?id=" + trid, '_blank');
        });
    });
    </script>

</body>

</html>