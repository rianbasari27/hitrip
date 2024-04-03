<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
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
                            <h1 class="h3 mb-0 text-gray-800">Pengambilan Perlengkapan Jamaah</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-warning text-white">
                                    <div class="card-body text-l">
                                        <strong>Nama :</strong>
                                        <?php echo $jamaah->first_name . ' ' . $jamaah->second_name . ' ' . $jamaah->last_name; ?><br>
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?>
                                        (<?php echo $paket->tanggal_berangkat; ?>) <br>
                                        <strong>No Telepon :</strong> <?php echo $noKirim; ?><br>
                                        <strong>Alamat :</strong> <?php echo $alamatKirim; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-danger">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-danger">
                                            <?php $ctr = 0; ?>
                                            <?php foreach ($pendingBooking['dateGroup'] as $tglAmbil => $ambil) { ?>
                                            <?php $ctr++; ?>
                                            <?php if ($jenisAmbil == 'pengiriman') { ?>
                                                <span>Pengiriman Tanggal : </span> <span class="text-success"> <?php echo $tglAmbil; ?>
                                            <?php } else { ?>
                                                <span>Pengambilan Tanggal : </span> <span class="text-success"> <?php echo $tglAmbil; ?>
                                            <?php } ?>
                                                <script language="javascript" type="text/javascript">
                                                /* <![CDATA[ */
                                                document.write(
                                                    '<a target="_blank" href="detail_pdf?nama=<?php echo $jamaah->first_name . '_' . $jamaah->second_name . '_' . $jamaah->last_name; ?>&url=' +
                                                    encodeURIComponent(location.href) +
                                                    '" class="btn btn-danger btn-icon-split btn-sm">');
                                                document.write('<span class="icon text-white-50">' +
                                                    '<i class="fas fa-file-pdf"></i>' +
                                                    '</span>' +
                                                    '<span class="text">Download SPP</span>');
                                                document.write('</a>');
                                                /* ]]> */
                                                </script>
                                        </h6>

                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width:200px;" class="text-center">Status
                                                        </th>
                                                        <th>Nama Barang</th>
                                                        <th>Jumlah</th>
                                                        <th>Deskripsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ambil as $am) { ?>
                                                    <tr>
                                                        <td class="text-center">Siap Diambil
                                                        </td>
                                                        <td><?php echo $am->nama_barang; ?></td>
                                                        <td><?php echo $am->jumlah_ambil . ' ' . $am->stok_unit; ?>
                                                        </td>
                                                        <td><?php echo $am->deskripsi; ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php } ?>
                                        <?php if (empty($pendingBooking['items'])) { ?>
                                        <div>
                                            Tidak ada booking perlengkapan yang masih pending.
                                        </div>
                                        <?php } ?>
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
    $(document).ready(function() {

        $(".hapus_btn").on("click", function() {
            event.preventDefault();
            if (confirm('Yakin untuk menghapus data ini?')) {
                let link = $(this).attr('href');
                window.location.href = link;
            }
        });
        if (window.innerWidth > 800) {
            $(".datepicker").attr("type", "text");
            $(function() {
                $(".datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeYear: true,
                    changeMonth: true,
                    yearRange: "1940:-nn"
                });
            });
        }
    });
    </script>
</body>

</html>