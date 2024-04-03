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


            <?php $this->load->view('staff/include/side_menu', ['agen_paket' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Program Konsultan</h1>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Informasi Program Konsultan</h6>
                                        <span class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/agen_paket/ubah?id=<?php echo $id; ?>"
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
                                            <form action="<?php echo base_url(); ?>staff/agen_paket/upload"
                                                method="post" enctype="multipart/form-data" style="display: inline">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <input name="agen_paket_flyer" onchange='this.form.submit();'
                                                    id="fly_up" type="file" style="display: none;">
                                            </form>
                                        </span>

                                    </div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <table class="table table-bordered" width="100%" cellspacing="0">
                                                <tr>
                                                    <th style="width:200px;">Nama Program</th>
                                                    <td>
                                                        <div><?php echo $nama_paket; ?></div>
                                                        <table class="table table-borderless">
                                                            <?php if ($agen_paket_flyer !== null) { ?>
                                                            <tr>
                                                                <td style="width: 250px;">
                                                                    <a class="btn btn-success btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . $agen_paket_flyer; ?>"
                                                                        download>
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-file-download"></i>
                                                                        </span>
                                                                        <span class="text">Download Paket
                                                                            Flyer</span>
                                                                    </a>
                                                                    <a class="btn btn-danger btn-icon-split btn-sm"
                                                                        href="<?php echo base_url() . "staff/agen_paket/delete_upload?field=agen_paket_flyer&id=$id" ?>">
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
                                                    <th>Harga Program</th>
                                                    <td><?php echo number_format($harga); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Diskon Member Baru</th>
                                                    <td><?php echo number_format($diskon_member_baru); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Diskon Member Baru</th>
                                                    <td><?php echo $deskripsi_diskon_member_baru != null || $deskripsi_diskon_member_baru != '' ? $deskripsi_diskon_member_baru : ''; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Diskon Member Lama</th>
                                                    <td><?php echo number_format($diskon_member_lama); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Diskon Member Lama</th>
                                                    <td><?php echo $deskripsi_diskon_member_lama != null || $deskripsi_diskon_member_lama != '' ? $deskripsi_diskon_member_lama : ''; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Diskon Eks Jamaah</th>
                                                    <td><?php echo number_format($diskon_eks_jamaah); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Deskripsi Diskon Eks Jamaah</th>
                                                    <td><?php echo $deskripsi_diskon_eks_jamaah != null || $deskripsi_diskon_eks_jamaah != '' ? $deskripsi_diskon_eks_jamaah : ''; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Active</th>
                                                    <td><?php echo $active == 1 ? 'Ya' : 'Tidak'; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <?php if ($is_member == 2 || $is_member == null) { ?>
                                                        <td>Untuk Konsultan Baru & Konsultan Lama</td>
                                                    <?php } else if($is_member == 1) { ?>
                                                        <td>Untuk Konsultan Lama</td>
                                                    <?php } else { ?>
                                                        <td>Untuk Konsultan Baru</td>
                                                    <?php } ?>
                                                </tr>
                                                <tr>
                                                    <th>Tanggal Publish</th>
                                                    <td><?php echo $published_at; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Link Pendaftaran</th>
                                                    <td>
                                                        <input id="myInput" disabled="true"
                                                            value="https://www.ventour.co.id/app/konsultan/updown_line/tambah_downline"
                                                            size="40">
                                                        <button class="btn btn-danger btn-sm" href="#"
                                                            onclick="myFunction()">Copy Link</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Gambar Banner</th>
                                                    <td><img src="<?php echo base_url() . $agen_gambar_banner; ?>"
                                                            alt="" style="max-width: 200px;"></td>
                                                </tr>
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