<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
        th {
            color: white;
            background-color: lightseagreen;
        }

        td {
            background-color: lightyellow;
        }
    </style>
    <link href="<?php echo base_url(); ?>asset/mycss/detail_pdf.css" type="text/css" rel="stylesheet" media="mpdf" />

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
                            <h1 class="h3 mb-0 text-gray-800">Pengaturan Perlengkapan Paket</h1>
                        </div>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-5">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                    <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                        <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                        <?php echo $_SESSION['alert_message']; ?>
                                    </div>
                                <?php } ?>
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                                        <span class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/barang/tambah" target='_blank' class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Tambah Barang Baru</span>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Aksi</th>
                                                        <th>Nama Barang</th>
                                                        <th>Stok</th>
                                                        <th>Unit Satuan</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card shadow mb-4 border-left-info">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Perlengkapan <strong><?php echo $paketInfo->nama_paket; ?> (<?php echo $paketInfo->tanggal_berangkat; ?>)</strong></h6>

                                    </div>
                                    <div class="card-body">
                                        <form id="form_pilih_paket" action="<?php echo base_url(); ?>staff/perlengkapan_paket/proses_atur" method="post">
                                            <input type='hidden' name='idPaket' value='<?php echo $paketInfo->id_paket; ?>'>
                                            <div class='table-responsive'>
                                                <table class='table table-bordered' id='table-form'>
                                                    <thead>
                                                        <tr>
                                                            <th>Barang</th>
                                                            <th style='width: 70px;'>Jml Pria</th>
                                                            <th style='width: 70px;'>Jml Wanita</th>
                                                            <th style='width: 70px;'>Jml Anak Pria</th>
                                                            <th style='width: 70px;'>Jml Anak Wanita</th>
                                                            <th style='width: 70px;'>Jml Bayi</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($perlengkapanPaket['perlengkapan'] as $pp) { ?>
                                                            <tr>
                                                                <td>
                                                                    <input type='hidden' name='id_paket[]' value='<?php echo $paketInfo->id_paket; ?>'>
                                                                    <input type='hidden' name='id_logistik[]' value='<?php echo $pp->id_logistik; ?>'>
                                                                    <?php echo $pp->nama_barang; ?>
                                                                </td>
                                                                <td>
                                                                    <input class='form-control' name='jumlah_pria[]' value='<?php echo $pp->jumlah_pria; ?>'>
                                                                </td>
                                                                <td>
                                                                    <input class='form-control' name='jumlah_wanita[]' value='<?php echo $pp->jumlah_wanita; ?>'>
                                                                </td>
                                                                <td>
                                                                    <input class='form-control' name='jumlah_anak_pria[]' value='<?php echo $pp->jumlah_anak_pria; ?>'>
                                                                </td>
                                                                <td>
                                                                    <input class='form-control' name='jumlah_anak_wanita[]' value='<?php echo $pp->jumlah_anak_wanita; ?>'>
                                                                </td>
                                                                <td>
                                                                    <input class='form-control' name='jumlah_bayi[]' value='<?php echo $pp->jumlah_bayi; ?>'>
                                                                </td>
                                                                <td>
                                                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm delete">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <?php if (empty($perlengkapanPaket)) { ?>
                                                <span id='noDataMsg'>
                                                    <center>Belum ada barang yang dipilih</center>
                                                </span>
                                            <?php } ?>
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
                "ajax": "<?php echo base_url(); ?>staff/barang/load_barang",
                columns: [{
                        data: 'id_logistik',
                        "render": function(data, type, row) {

                            return '<a href="javascript:void(0);" nm="' + row['nama_barang'] + '" class="btn btn-primary btn-sm pilih_btn">Pilih</a>'
                        }

                    },
                    {
                        data: 'nama_barang'
                    },
                    {
                        data: 'stok'
                    },
                    {
                        data: 'stok_unit'
                    },
                ],
                "order": [
                    [1, "asc"]
                ]
            });
            $("#dataTable tbody").on("click", ".pilih_btn", function() {
                $("#noDataMsg").remove();
                var id_logistik = $(this).closest('tr').attr('id'); // table row ID 
                var nama_barang = $(this).attr('nm');
                var html = "<tr>";
                html = html + "<td>\n";
                html = html + "<input type='hidden' name='id_paket[]' value='<?php echo $paketInfo->id_paket; ?>'>\n";
                html = html + "<input type='hidden' name='id_logistik[]' value='" + id_logistik + "'>\n";
                html = html + nama_barang + '\n </td>';
                html = html + "<td><input class='form-control' name='jumlah_pria[]' value='1'></td>\n";
                html = html + "<td><input class='form-control' name='jumlah_wanita[]' value='1'></td>\n";
                html = html + "<td><input class='form-control' name='jumlah_anak_pria[]' value='1'></td>\n";
                html = html + "<td><input class='form-control' name='jumlah_anak_wanita[]' value='1'></td>\n";
                html = html + "<td><input class='form-control' name='jumlah_bayi[]' value='1'></td>\n";
                html = html + "<td><a href='javascript:void(0);' class='btn btn-danger btn-sm delete'>\n";
                html = html + "<span class='icon text-white-50'>\n";
                html = html + "<i class='fas fa-trash'></i></span></a></td>\n";
                $("#table-form tbody").append(html);
            });

            $("#table-form").on("click", ".delete", function() {
                $(this).parent().parent().remove();
            });
        });
    </script>
</body>

</html>