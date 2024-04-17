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
            <?php $this->load->view('staff/include/side_menu', ["produk" => true, "tambah_produk" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <h4 class="font-weight-bold py-3 mb-0">Tambah Paket / Produk</h4>
                        <div class="row">
                            <!-- 1st row Start -->
                            <div class="col-lg-12">
                                <div class="card mb-4">
                                    <div class="card-header with-elements">
                                        <h6 class="card-header-title mb-0 text primary">Isi data dengan benar</h6>
                                        <div class="card-header-elements">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo base_url() . 'staff/paket/proses_ubah' ;?>"
                                            method="post">
                                            <input type="hidden" name="id" value="<?php echo $id_paket;?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Paket (<span
                                                        class="text-primary font-italic font-weight-lighter">Advertising
                                                        Name</span>)</label>
                                                <input class="form-control" type="text" name="nama_paket"
                                                    value="<?php echo $nama_paket ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Berangkat</label>
                                                <input class="form-control" type="date" name="tanggal_berangkat"
                                                    value="<?php echo $tanggal_berangkat ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Pulang</label>
                                                <input class="form-control" type="date" name="tanggal_pulang"
                                                    value="<?php echo $tanggal_pulang ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah Pax</label>
                                                <input class="form-control format_harga" type="text" name="jumlah_seat"
                                                    value="<?php echo $jumlah_seat ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga Quad</label>
                                                <input class="form-control format_harga" type="text" name="harga"
                                                    value="<?php echo $harga ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga Triple</label>
                                                <input class="form-control format_harga" type="text" name="harga_triple"
                                                    value="<?php echo $harga_triple ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga Double</label>
                                                <input class="form-control format_harga" type="text" name="harga_double"
                                                    value="<?php echo $harga_double ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Diskon</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="default_diskon" value="<?php echo $default_diskon ;?>"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Diskon</label>
                                                <input class="form-control" type="text" name="deskripsi_default_diskon"
                                                    value="<?php echo $deskripsi_default_diskon ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Singkat</label>
                                                <textarea class="form-control wysiwyg" rows="6"
                                                    name="detail_promo"><?php echo $detail_promo ;?></textarea>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" name="publish" type="checkbox" value="1"
                                                    id="flexCheckChecked" <?php echo $publish == 1 ? 'checked' : '' ;?>>
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Publish
                                                </label>
                                            </div>
                                            <button class="btn btn-xs btn-primary btn-icon-split rounded-xs mt-4">
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
    <?php $this->load->view('staff/include/script_view') ?>
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <script>
    $(document).ready(function() {
        $(".format_harga").on("input", function() {
            var inputValue = $(this).val();

            inputValue = inputValue.replace(/[^\d.]/g, '');
            if (inputValue !== '') {
                inputValue = parseFloat(inputValue).toLocaleString('en-US');
                $(this).val(inputValue);
            } else {
                $(this).val('');
            }
        });
    });
    </script>
</body>

</html>