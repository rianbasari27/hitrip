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
            <?php $this->load->view('staff/include/side_menu', ["produk" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Detail Informasi Paket / Produk</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Paket Umroh</h6>
                                        <span class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/paket/ubah_paket?id=<?php echo $id_paket; ?>"
                                                class="btn btn-xs rounded-xs btn-warning btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Ubah Data</span>
                                            </a>
                                            <a onclick="$('#fly_up').trigger('click');" href="#"
                                                class="btn btn-success btn-icon-split btn-xs rounded-xs" for="fly_up">
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
                                                class="btn btn-info btn-icon-split  btn-xs rounded-xs" for="it_up">
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
                                            <a onclick="$('#banner_up').trigger('click');" href="#"
                                                class="btn btn-warning btn-icon-split  btn-xs rounded-xs" for="it_up">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-list"></i>
                                                </span>
                                                <span class="text">Upload Banner Image</span>
                                            </a>
                                            <form action="<?php echo base_url(); ?>staff/paket/upload" method="post"
                                                enctype="multipart/form-data" style="display: inline">
                                                <input type="hidden" name="id" value="<?php echo $id_paket; ?>">
                                                <input name="banner_image" onchange='this.form.submit();' id="banner_up"
                                                    type="file" style="display: none;">
                                            </form>
                                        </span>

                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table" width="100%" cellspacing="0">
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
                                                            <?php if ($banner_image !== null) { ?>
                                                            <tr>
                                                                <td style="width: 250px;">
                                                                    <a class="btn btn-warning btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . $banner_image; ?>"
                                                                        download>
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-file-download"></i>
                                                                        </span>
                                                                        <span class="text">Download Banner Image</span>
                                                                    </a>
                                                                    <a class="btn btn-danger btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . "staff/paket/delete_upload?field=banner_image&id=$id_paket" ?>">
                                                                        <span class="icon">
                                                                            <i class="fas fa-trash"></i>
                                                                        </span>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Keberangkatan</th>
                                                    <td><?php echo $this->date->convert_date_indo($tanggal_berangkat) ; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Pulang</th>
                                                    <td><?php echo $this->date->convert_date_indo($tanggal_pulang); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Jumlah Pax</th>
                                                    <td><?php echo $jumlah_seat; ?></td>
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
                                                    <th>Diskon</th>
                                                    <td><?php echo number_format($default_diskon); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Diskon</th>
                                                    <td><?php echo $deskripsi_default_diskon != null || $deskripsi_default_diskon != '' ? $deskripsi_default_diskon : ''; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Publish</th>
                                                    <td><?php echo $publish == 1 ? 'Ya' : 'Tidak'; ?></td>
                                                </tr>
                                                <!-- <tr>
                                                    <th>Link Pendaftaran</th>
                                                    <td>
                                                        <input id="myInput" disabled="true"
                                                            value="https://www.ventour.co.id/app/daftar?id=<?php echo $id_paket; ?>"
                                                            size="40">
                                                        <button class="btn btn-danger btn-sm" href="#"
                                                            onclick="myFunction()">Copy Link</button>
                                                    </td>
                                                </tr> -->
                                                <tr>
                                                    <th>Gambar Banner</th>
                                                    <td><img src="<?php echo base_url() . $banner_image; ?>" alt=""
                                                            style="max-width: 200px;"></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Singkat</th>
                                                    <td><?php echo $detail_promo; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
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
                        </div> -->
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
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('staff/include/script_view') ?>
</body>

</html>