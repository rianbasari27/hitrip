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


            <?php $this->load->view('staff/include/side_menu',['paket_umroh' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Tambah Paket Umroh</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi Informasi Paket Dengan Benar!
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form" action="<?php echo base_url(); ?>staff/paket/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Paket (<span
                                                        class="text-primary font-italic font-weight-lighter">Advertising
                                                        Name</span>)</label>
                                                <input class="form-control" type="text" name="nama_paket">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Keberangkatan (<span
                                                        class="text-primary font-italic font-weight-lighter">mm/dd/yyyy</span>)</label>
                                                <input class="form-control datepicker" type="date"
                                                    name="tanggal_berangkat">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Pulang (<span
                                                class="text-primary font-italic font-weight-lighter">mm/dd/yyyy</span>)</label>
                                                <input class="form-control datepicker" type="date"
                                                name="tanggal_pulang">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jam Take-off</label>
                                                <input class="form-control" type="time"
                                                    name="jam_terbang">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah Seat</label>
                                                <input class="form-control" type="number" name="jumlah_seat">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Isi Kamar (<span
                                                        class="text-primary font-italic font-weight-lighter">Berapa
                                                        orang dalam satu kamar</span>)</label>
                                                <input class="form-control" type="text" name="isi_kamar">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Minimal DP (<span
                                                        class="text-primary font-italic font-weight-lighter">Harga yang
                                                        akan dijadikan untuk minimal pembayaran DP pada sistem aplikasi
                                                    </span>)</label>
                                                <input class="form-control format_harga" type="text" name="minimal_dp"
                                                    value="5,000,000">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">DP Display (<span
                                                        class="text-primary font-italic font-weight-lighter">Harga yang
                                                        akan dijadikan tampilan display pada sistem aplikasi
                                                    </span>)</label>
                                                <input class="form-control format_harga" type="text" name="dp_display"
                                                    value="5,000,000">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga Quad</label>
                                                <input class="form-control format_harga" type="text" name="harga">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga Triple</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="harga_triple">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Harga Double</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="harga_double">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Default Diskon (<span
                                                        class="text-primary font-italic font-weight-lighter">Diskon yang
                                                        langsung diberikan pada jamaah yang baru mendaftar, jamaah yang
                                                        sudah mendaftar sebelumnya tidak
                                                        mendapat diskon
                                                    </span>)</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="default_diskon">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Waktu Berlaku Diskon </label>
                                                <div class="row">
                                                    <div class="col">
                                                        <input type="date" class="form-control"
                                                            name="waktu_diskon_start">
                                                    </div>
                                                    <div class="col">
                                                        <input type="date" class="form-control" name="waktu_diskon_end">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <input class="form-control" type="date" name="waktu_diskon_start"> - 
                                                <input class="form-control" type="date" name="waktu_diskon_end"> -->
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Diskon </label>
                                                <input class="form-control" type="text" name="deskripsi_default_diskon">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Komisi Langsung (Konsultan)</label>
                                                <input class="form-control format_harga" type="text"
                                                    name="komisi_langsung_fee">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Reward Poin (Konsultan)</label>
                                                <input class="form-control" type="number" name="komisi_poin" value="1">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nominal Denda (<span
                                                        class="text-primary font-italic font-weight-lighter">Apabila
                                                        jamaah pernah umroh kurang dari 3 tahun yang
                                                        lalu</span>)</label>
                                                <input class="form-control format_harga" type="text" name="denda"
                                                    value="0">
                                            </div>
                                            <div class="form-group mb-0">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="publish" value="1" checked> Publish
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Publish</label>
                                                <input class="form-control" type="date" name="published_at">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Extra Fee</label>
                                                <input class="form-control" type="number" name="extra_fee">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Deskripsi Extra Fee</label>
                                                <textarea class="form-control wysiwyg" rows="6"
                                                    name="deskripsi_extra_fee"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Star (<span
                                                        class="text-primary font-italic font-weight-lighter">Jumlah
                                                        bintang yang muncul di aplikasi jamaah</span>)</label>
                                                <input class="form-control" type="number" name="star" value="5">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Gambar Banner - rekomendasi ukuran 700x700
                                                    px (<span
                                                        class="text-primary font-italic font-weight-lighter">Gambar yang
                                                        muncul di aplikasi jamaah</span>)</label>
                                                <input class="form-control" type="file" name="banner_image">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Detail Promo</label>
                                                <textarea class="form-control wysiwyg" rows="6"
                                                    name="detail_promo"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Maskapai</label>
                                                <select name="maskapai" class="form-control">
                                                    <option value="BELUM TERSEDIA">Belum Tersedia</option>
                                                    <option value="SAUDIA">SAUDIA</option>
                                                    <option value="QATAR">QATAR</option>
                                                    <option value="OMAN">OMAN</option>
                                                    <option value="EMIRATES">EMIRATES</option>
                                                    <option value="LION AIR">LION AIR</option>
                                                    <option value="SRILANKAN">SRILANKAN</option>
                                                    <option value="GARUDA INDONESIA">GARUDA INDONESIA</option>
                                                    <option value="ETIHAD">ETIHAD</option>
                                                    <option value="TURKISH AIRLINE">TURKISH AIRLINE</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Flight Schedule</label>
                                                <textarea class="form-control wysiwyg" rows="6"
                                                    name="flight_schedule"></textarea>
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
    if (window.innerWidth > 800) {
        $(".datepicker").attr("type", "text");
        $(function() {
            $(".datepicker").datepicker({
                dateFormat: "mm/dd/yy"
            });
        });
    }
    </script>
</body>

</html>