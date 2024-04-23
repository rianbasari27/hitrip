<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
    /* Style untuk input form */
    .form-control {
        border: none;
        border-radius: 0;
        border-bottom: 1px solid #ced4da;
        /* warna garis bawah */
    }

    /* Style untuk input form yang aktif/fokus */
    .form-control:focus {
        box-shadow: none;
        border-color: #80bdff;
        /* warna garis bawah saat aktif */
    }
    </style>

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
            <?php $this->load->view('staff/include/side_menu', ["voucher_promo" => true, "voucher_view" => true]) ?>
            <!-- [ Layout container ] Start -->
            <div class="layout-container">
                <?php $this->load->view('staff/include/nav_menu') ?>

                <!-- [ Layout content ] Start -->
                <div class="layout-content">
                    <?php $this->load->view('staff/include/toast') ?>
                    <!-- [ content ] Start -->
                    <div class="container-fluid flex-grow-1 container-p-y">
                        <!-- Page Heading -->
                        <h4 class="font-weight-bold py-3 mb-0">Tambah Voucher</h4>
                        <!-- Content Row -->
                        <div class="row" id="content">
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
                                        <form role="form" id="myForm"
                                            action="<?php echo base_url(); ?>staff/voucher/proses_tambah" method="post"
                                            enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="col-form-label">Kode Voucher</label>
                                                <input class="form-control" type="text" name="kode_voucher">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Nominal</label>
                                                <input class="form-control format_harga" type="text" name="nominal">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Kuota Voucher</label>
                                                <input class="form-control format_harga" type="text" name="kuota">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Mulai</label>
                                                <input class="form-control" type="date" name="tgl_mulai">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Tanggal Berakhir</label>
                                                <input class="form-control" type="date" name="tgl_berakhir">
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 40px;" data-orderable="false">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="checkAll">
                                                                        <label class="form-check-label" for="checkAll">
                                                                            All
                                                                        </label>
                                                                    </div>
                                                                </th>
                                                                <th>Nama Paket</th>
                                                                <th>Jumlah Seat</th>
                                                                <th>Harga</th>
                                                                <th>Tanggal Berangkat</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($paket as $p) { ?>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input checks"
                                                                            name="id_paket[]" type="checkbox"
                                                                            value="<?php echo $p->id_paket; ?>">
                                                                    </div>
                                                                </td>
                                                                <td><?php echo $p->nama_paket; ?></td>
                                                                <td><?php echo $p->jumlah_seat; ?></td>
                                                                <td><?php echo $p->harga; ?></td>
                                                                <td><?php echo $p->tanggal_berangkat; ?></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input class="form-check-input" name="aktif" type="checkbox"
                                                        value="1" id="flexCheckChecked" checked>
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        Aktifkan
                                                    </label>
                                                </div>
                                            </div>

                                            <button id="submitBtn" type="button"
                                                class="btn btn-success btn-icon-split btn-xs rounded-xs">
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
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script> -->
    <?php $this->load->view('staff/include/script_view') ?>
    <script>
    $(document).ready(function() {
        // Event untuk tombol "Submit"
        var dataTable = $('#dataTable').DataTable({
            searchable: true,
            pageLength: 5,
            lengthMenu: [
                [5, 10, 25, 50],
                [5, 10, 25, 50]
            ],
        });
        // Event untuk tombol "Submit"
        $('#submitBtn').click(function() {
            var selectedIds = [];

            // Iterasi setiap halaman dalam DataTable
            $('#dataTable').DataTable().$('input[name="id_paket[]"]:checked').each(function() {
                selectedIds.push($(this).val());
            });

            // Hapus semua input yang ada
            $('input[name="id_paket[]"]').remove();

            // Tambahkan kembali input dengan ID yang dipilih
            selectedIds.forEach(function(id) {
                $('#myForm').append('<input type="hidden" name="id_paket[]" value="' + id +
                    '">');
            });

            // Mengirim formulir
            $('#myForm').submit();
        });

        // Event untuk checkbox "All"
        $("#checkAll").click(function() {
            // $(".checks").prop('checked', $(this).prop('checked'));

            // Iterate through all pages and select checkboxes
            for (var i = 0; i < dataTable.page.info().pages; i++) {
                dataTable.page(i).draw('page');
                $(".checks").prop('checked', $(this).prop('checked'));
            }
        });

        // Event untuk mengubah status checkbox "All" ketika salah satu checkbox diubah
        $('.checks').change(function() {
            var allChecked = true;
            $('.checks').each(function() {
                if (!$(this).prop('checked')) {
                    allChecked = false;
                    return false; // Keluar dari loop jika salah satu checkbox tidak dicentang
                }
            });
            $('#checkAll').prop('checked', allChecked);
        });

        // Format input harga
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