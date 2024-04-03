<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <link rel="stylesheet" href="<?php echo base_url();?>asset/mycss/combobox.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['perl_office' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Ubah Informasi Barang Office</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/perlengkapan_office/proses_ubah"
                                            method="post">
                                            <input type="hidden" name="id_barang" value="<?php echo $id_barang;?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Barang</label>
                                                <input class="form-control" type="text" name="nama"
                                                    value="<?php echo $nama;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jenis Barang</label>
                                                <input class="form-control" type="text" name="jenis"
                                                    value="<?php echo $jenis ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah</label>
                                                <input class="form-control" type="number" name="stock"
                                                    value="<?php echo $stock ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Satuan Barang ( <span
                                                        class="text-primary font-italic font-weight-lighter">pcs/buah/unit/kodi/set/dll</span>
                                                    )</label>
                                                <input class="form-control" type="text" name="satuan"
                                                    value="<?php echo $satuan ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Lokasi Barang ( <span
                                                        class="text-primary font-italic font-weight-lighter">Tempat
                                                        Barang disimpan saat ini</span> )</label>
                                                <input class="form-control" type="text" name="lokasi"
                                                    value="<?php echo $lokasi ;?>">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Status</label>
                                                <select name="status" id="" class="form-control">
                                                    <option value="" selected disabled> -- Pilih Salah Satu --</option>
                                                    <option value="Bekas"
                                                        <?php echo $status == "Bekas" ? 'selected' : '' ;?>>Bekas
                                                    </option>
                                                    <option value="Baru"
                                                        <?php echo $status == "Baru" ? 'selected' : '' ;?>>Baru
                                                    </option>
                                                    <option value="Hibah"
                                                        <?php echo $status == "Hibah" ? 'selected' : '' ;?>>Hibah
                                                    </option>
                                                    <option value="Rusak"
                                                        <?php echo $status == "Rusah" ? 'selected' : '' ;?>>Rusak
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Beli</label>
                                                <input class="form-control" type="date" name="tanggal_beli"
                                                    value="<?php echo $tanggal_beli ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga</label>
                                                <input class="form-control format_harga" type="text" name="harga"
                                                    value="<?php echo $harga ;?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi</label>
                                                <textarea class='form-control' name='keterangan'
                                                    rows="3"><?php echo $keterangan ;?></textarea>
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
    <script src="<?php echo base_url();?>asset/myjs/combobox.js"></script>
    <script>
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
    </script>

</body>

</html>