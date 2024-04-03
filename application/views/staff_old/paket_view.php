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


            <?php $this->load->view('staff/include/side_menu', ['paket_umroh' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Paket Umroh</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                    <?php echo $_SESSION['alert_message']; ?>
                                </div>
                                <?php } ?>
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Paket Umroh</h6>
                                        <span class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/paket/ubah_paket?id=<?php echo $id_paket; ?>"
                                                class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Ubah Data</span>
                                            </a>
                                            <a onclick="$('#fly_up').trigger('click');" href="#"
                                                class="btn btn-success btn-icon-split btn-sm" for="fly_up">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-newspaper"></i>
                                                </span>
                                                <span class="text">Upload Paket Flyer</span>
                                            </a>
                                            <form action="<?php echo base_url(); ?>staff/paket/upload" method="post"
                                                enctype="multipart/form-data" style="display: inline">
                                                <input type="hidden" name="id" value="<?php echo $id_paket; ?>">
                                                <input name="paket_flyer" onchange='this.form.submit();' id="fly_up"
                                                    type="file" style="display: none;">
                                            </form>
                                            <a onclick="$('#it_up').trigger('click');" href="#"
                                                class="btn btn-info btn-icon-split btn-sm" for="it_up">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-route"></i>
                                                </span>
                                                <span class="text">Upload Detail Itinerary</span>
                                            </a>
                                            <form action="<?php echo base_url(); ?>staff/paket/upload" method="post"
                                                enctype="multipart/form-data" style="display: inline">
                                                <input type="hidden" name="id" value="<?php echo $id_paket; ?>">
                                                <input name="itinerary" onchange='this.form.submit();' id="it_up"
                                                    type="file" style="display: none;">
                                            </form>
                                            <a onclick="$('#pkt_up').trigger('click');" href="#"
                                                class="btn btn-warning btn-icon-split btn-sm" for="it_up">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-list"></i>
                                                </span>
                                                <span class="text">Upload Paket Info</span>
                                            </a>
                                            <form action="<?php echo base_url(); ?>staff/paket/upload" method="post"
                                                enctype="multipart/form-data" style="display: inline">
                                                <input type="hidden" name="id" value="<?php echo $id_paket; ?>">
                                                <input name="paket_info" onchange='this.form.submit();' id="pkt_up"
                                                    type="file" style="display: none;">
                                            </form>
                                        </span>

                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tr>
                                                    <th style="width:200px;">Nama Paket</th>
                                                    <td>
                                                        <div><?php echo $nama_paket; ?></div>
                                                        <table class="table table-borderless">
                                                            <?php if ($paket_flyer !== null) { ?>
                                                            <tr>
                                                                <td style="width: 250px;">
                                                                    <a class="btn btn-success btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . $paket_flyer; ?>"
                                                                        download>
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-file-download"></i>
                                                                        </span>
                                                                        <span class="text">Download Paket
                                                                            Flyer</span>
                                                                    </a>
                                                                    <a class="btn btn-danger btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . "staff/paket/delete_upload?field=paket_flyer&id=$id_paket" ?>">
                                                                        <span class="icon">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <?php if ($itinerary !== null) { ?>
                                                            <tr>
                                                                <td style="width: 250px;">
                                                                    <a class="btn btn-info btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . $itinerary; ?>"
                                                                        download>
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-file-download"></i>
                                                                        </span>
                                                                        <span class="text">Download Itinerary</span>
                                                                    </a>
                                                                    <a class="btn btn-danger btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . "staff/paket/delete_upload?field=itinerary&id=$id_paket" ?>">
                                                                        <span class="icon">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                            <?php if ($paket_info !== null) { ?>
                                                            <tr>
                                                                <td style="width: 250px;">
                                                                    <a class="btn btn-warning btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . $paket_info; ?>"
                                                                        download>
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-file-download"></i>
                                                                        </span>
                                                                        <span class="text">Download Paket
                                                                            Info</span>
                                                                    </a>
                                                                    <a class="btn btn-danger btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . "staff/paket/delete_upload?field=paket_info&id=$id_paket" ?>">
                                                                        <span class="icon">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </table>
                                                        <!-- <div class="mt-2">
                                                            <?php if ($paket_flyer !== null) { ?>
                                                            <a class="btn btn-success btn-icon-split btn-sm"
                                                                href="<?php echo base_url() . $paket_flyer; ?>"
                                                                download>
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-file-download"></i>
                                                                </span>
                                                                <span class="text">Hapus Paket Flyer</span>
                                                            </a>
                                                            <?php } ?>
                                                            <?php if ($itinerary !== null) { ?>
                                                            <a class="btn btn-info btn-icon-split btn-sm"
                                                                href="<?php echo base_url() . $itinerary; ?>" download>
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-file-download"></i>
                                                                </span>
                                                                <span class="text">Hapus Itinerary</span>
                                                            </a>
                                                            <?php } ?>
                                                            <?php if ($paket_info !== null) { ?>
                                                            <a class="btn btn-danger btn-icon-split btn-sm"
                                                                href="<?php echo base_url() . $paket_info; ?>" download>
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-file-download"></i>
                                                                </span>
                                                                <span class="text">Hapus Paket Info</span>
                                                            </a>
                                                            <?php } ?>
                                                        </div> -->
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Keberangkatan</th>
                                                    <td><?php echo $tanggal_berangkat; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jam Take-off</th>
                                                    <td><?php echo $jam_terbang; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Pulang</th>
                                                    <td><?php echo $tanggal_pulang; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Maskapai</th>
                                                    <td><?php echo $maskapai; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jumlah Seat</th>
                                                    <td><?php echo $jumlah_seat; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Isi Kamar</th>
                                                    <td><?php echo $isi_kamar; ?></td>
                                                </tr>

                                                <tr>
                                                    <th>Minimal DP</th>
                                                    <td><?php echo number_format($minimal_dp); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>DP Display</th>
                                                    <td><?php echo number_format($dp_display); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Harga Quad</th>
                                                    <td><?php echo number_format($harga); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Harga Triple</th>
                                                    <td><?php echo number_format($harga_triple); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Harga Double</th>
                                                    <td><?php echo number_format($harga_double); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Default Diskon</th>
                                                    <td><?php echo number_format($default_diskon); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Diskon</th>
                                                    <td><?php echo $deskripsi_default_diskon != null || $deskripsi_default_diskon != '' ? $deskripsi_default_diskon : ''; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Periode Diskon</th>
                                                    <td><?php echo $waktu_diskon_start != null || $waktu_diskon_start != '' || $waktu_diskon_end != null || $waktu_diskon_end != '' ? ($waktu_diskon_start != '00 0000' || $waktu_diskon_end != '00 0000' ? $waktu_diskon_start . ' - ' . $waktu_diskon_end : '') : ''; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Extra Fee</th>
                                                    <td><?php echo number_format($extra_fee); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Extra Fee</th>
                                                    <td><?php echo nl2br($deskripsi_extra_fee); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nominal Denda</th>
                                                    <td><?php echo number_format($denda_kurang_3); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Komisi Langsung (Konsultan)</th>
                                                    <td><?php echo number_format($komisi_langsung_fee); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Reward Poin (Konsultan)</th>
                                                    <td><?php echo number_format($komisi_poin); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Publish</th>
                                                    <td><?php echo $publish == 1 ? 'Ya' : 'Tidak'; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Publish</th>
                                                    <td><?php echo $published_at; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Link Pendaftaran</th>
                                                    <td>
                                                        <input id="myInput" disabled="true"
                                                            value="https://www.ventour.co.id/app/daftar?id=<?php echo $id_paket; ?>"
                                                            size="40">
                                                        <button class="btn btn-danger btn-sm" href="#"
                                                            onclick="myFunction()">Copy Link</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Star</th>
                                                    <td><?php echo $star; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gambar Banner</th>
                                                    <td><img src="<?php echo base_url() . $banner_image; ?>" alt=""
                                                            style="max-width: 200px;"></td>
                                                </tr>
                                                <tr>
                                                    <th>Detail Promo</th>
                                                    <td><?php echo $detail_promo; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Flight Schedule</th>
                                                    <td><?php echo nl2br($flight_schedule); ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Hotel</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <a href="<?php echo base_url(); ?>staff/paket/tambah_hotel?id=<?php echo $id_paket; ?>"
                                                class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                                <span class="text">Tambah Hotel</span>
                                            </a>
                                        </div>
                                        <?php if (empty($hotel)) { ?>
                                        <center><span class="text-gray-500 font-italic">Belum ada data</span></center>
                                        <?php } else { ?>
                                        <div class="row">
                                            <?php foreach ($hotel as $htl) { ?>
                                            <div class="col-xl-6 col-md-6 mb-4">
                                                <div class="card border-left-warning shadow h-100 py-2">
                                                    <div class="card-body">
                                                        <div class="row no-gutters align-items-center">
                                                            <div class="col mr-2">

                                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                                    <?php echo $htl->nama_hotel; ?>
                                                                    <a href="<?php echo base_url(); ?>staff/paket/hapus_hotel?id=<?php echo $htl->id_hotel; ?>"
                                                                        class="btn btn-sm btn-warning btn-icon-split btnHapus"
                                                                        data-toggle="modal" data-target="#hapusModal">

                                                                        <span class="text">Hapus</span>
                                                                    </a>
                                                                </div>
                                                                <div class="mb-0 text-gray-800">The Time :
                                                                    <?php echo $htl->time; ?></div>
                                                                <div class="mb-0 text-gray-800">History :
                                                                    <?php echo $htl->history; ?></div>
                                                                <div class="mb-0 text-gray-800">Mazarat :
                                                                    <?php echo $htl->mazarat; ?></div>
                                                            </div>

                                                            <div class="col mr-2">
                                                                <div class="table-responsive">
                                                                    <img src="<?php echo base_url() . $htl->foto; ?>"
                                                                        alt="" style="max-width: 400px;">

                                                                </div>
                                                            </div>
                                                            <div class="col mr-2 mt-3">
                                                                <div class="table-responsive">
                                                                    <iframe width="720" height="300" frameborder="0"
                                                                        style="border:0" src="
                                                                                    https://www.google.com/maps/embed/v1/place?q=<?php echo urlencode($htl->nama_hotel); ?>&key=AIzaSyD0mI9tAXxHhM-qtUak3XcPyeolqymIgno
                                                                                    ">
                                                                    </iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php } ?>
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
    <!-- Logout Modal-->
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yakin untuk menghapus hotel?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Ya" untuk menghapus hotel.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <a class="btn btn-primary" id="btnModal">Ya</a>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('staff/include/script_view'); ?>
    <script>
    $(".btnHapus").click(function() {
        var ref = $(this).attr("href");
        $("#btnModal").attr("href", ref);

    });

    function myFunction() {
        /* Get the text field */
        var copyText = document.getElementById("myInput");
        var text = copyText.value;

        var selection = document.getSelection();
        var range = document.createRange();
        range.selectNode(copyText);
        selection.removeAllRanges();
        selection.addRange(range);
        /* Select the text field */
        //                copyText.select();
        //                copyText.setSelectionRange(0, 99999); /*For mobile devices*/

        /* Copy the text inside the text field */
        document.execCommand("copy");
        selection.removeAllRanges();
        /* Alert the copied text */
        alert("Copied the text: " + text);
    }
    </script>
</body>

</html>