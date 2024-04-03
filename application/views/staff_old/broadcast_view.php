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
                            <h1 class="h3 mb-0 text-gray-800">Broadcast Pesan</h1>
                        </div>

                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Paket :</strong> <?php echo $paket->nama_paket; ?> <br>
                                        <strong>Keberangkatan : </strong>
                                        <?php echo date_format(date_create($paket->tanggal_berangkat), "d F Y"); ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                    <?php echo $_SESSION['alert_message']; ?>
                                </div>
                                <?php } ?>
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-danger">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Broadcast Pesan Baru</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo base_url(); ?>staff/broadcast/proses_tambah"
                                            method="post">
                                            <input type="hidden" name="id_paket"
                                                value="<?php echo $paket->id_paket; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Judul Pesan : </label><br>
                                                <textarea rows="1" cols="100" name="judul"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Isi Pesan : </label><br>
                                                <textarea rows="5" cols="100" class="wysiwyg" name="pesan" id="pesan" onkeydown="breakLine(event)"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Warna Background : </label>
                                                <input type="radio" name="color" value="primary" checked> <span
                                                    class="btn btn-sm btn-primary">Biru</span>
                                                <input type="radio" name="color" value="warning"> <span
                                                    class="btn btn-sm btn-warning">Kuning</span>
                                                <input type="radio" name="color" value="danger"> <span
                                                    class="btn btn-sm btn-danger">Merah</span>
                                                <input type="radio" name="color" value="success"> <span
                                                    class="btn btn-sm btn-success">Hijau</span>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Status : </label>
                                                <br><input type="radio" name="tampilkan" value="1" checked> Tampilkan
                                                <br><input type="radio" name="tampilkan" value="0"> Sembunyikan
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
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Daftar Pesan yang di Broadcast
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <?php foreach ($pesan as $p) { ?>
                                        <div class="card shadow mb-4 border-left-warning">
                                            <div
                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <a href="<?php echo base_url(); ?>staff/broadcast/hapus?id=<?php echo $p->id_broadcast; ?>"
                                                    class="btn btn-danger btn-icon-split btn-sm">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Hapus</span>
                                                </a>
                                                <h6 class="m-0 font-weight-bold text-primary">
                                                    <?php echo date_format(date_create($p->tanggal_post), "d F Y h:i:s A"); ?>
                                                </h6>

                                            </div>
                                            <div class="card-body">


                                                <form action="<?php echo base_url(); ?>staff/broadcast/status"
                                                    method="post">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Judul Pesan : </label><br>
                                                        <textarea rows="1" cols="100"
                                                            name="judul"><?php echo $p->judul; ?></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Isi Pesan : </label><br>
                                                        <textarea rows="5" cols="100"
                                                            name="pesan" class="wysiwyg" id="output_pesan"><?php echo str_replace("<br>","`",$p->pesan); ?></textarea>
                                                    </div>
                                                    <input type="hidden" name="id_broadcast"
                                                        value="<?php echo $p->id_broadcast; ?>">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Warna Background : </label>
                                                        <input type="radio" name="color" value="primary"
                                                            <?php echo $p->color == 'primary' ? 'checked' : ''; ?>>
                                                        <span class="btn btn-sm btn-primary">Biru</span>
                                                        <input type="radio" name="color" value="warning"
                                                            <?php echo $p->color == 'warning' ? 'checked' : ''; ?>>
                                                        <span class="btn btn-sm btn-warning">Kuning</span>
                                                        <input type="radio" name="color" value="danger"
                                                            <?php echo $p->color == 'danger' ? 'checked' : ''; ?>> <span
                                                            class="btn btn-sm btn-danger">Merah</span>
                                                        <input type="radio" name="color" value="success"
                                                            <?php echo $p->color == 'success' ? 'checked' : ''; ?>>
                                                        <span class="btn btn-sm btn-success">Hijau</span>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label">Status : </label>
                                                        <br><input type="radio" name="tampilkan" value="1"
                                                            <?php echo $p->tampilkan == 1 ? 'checked' : ''; ?>>
                                                        Tampilkan
                                                        <br><input type="radio" name="tampilkan" value="0"
                                                            <?php echo $p->tampilkan == 0 ? 'checked' : ''; ?>>
                                                        Sembunyikan
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
                                        <?php } ?>
                                        <?php if (empty($pesan)) { ?>
                                        <center>Belum ada pesan yang di broadcast</center>
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
        function breakLine(event) {
            var inputField = document.getElementById("pesan");
            var key = event.keyCode;
        
            if (key === 13) {
                var cursorPos = inputField.selectionStart;
                var text = inputField.value;
                var textBefore = text.substring(0, cursorPos);
                var textAfter = text.substring(cursorPos);

                var beforeCursor = textBefore.charAt(cursorPos - 1);

                if (beforeCursor === "`") {
                    inputField.value = textBefore + "\n" + textAfter;
                    inputField.selectionStart = cursorPos + 1;
                    inputField.selectionEnd = cursorPos + 1;
                } else {
                    if (cursorPos === text.length) {
                        inputField.value = textBefore + "`\n";
                    } else {
                        inputField.value = textBefore + "`\n" + textAfter;
                    }
                    inputField.selectionStart = cursorPos + 2;
                    inputField.selectionEnd = cursorPos + 2;
                }

                event.preventDefault();
            }
        }

        function breakLineEdit(event) {
            var inputField = document.getElementById("pesanEdit");
            var key = event.keyCode;
        
            if (key === 13) {
                var cursorPos = inputField.selectionStart;
                var text = inputField.value;
                var textBefore = text.substring(0, cursorPos);
                var textAfter = text.substring(cursorPos);

                var beforeCursor = textBefore.charAt(cursorPos - 1);

                if (beforeCursor === "`") {
                    inputField.value = textBefore + "\n" + textAfter;
                    inputField.selectionStart = cursorPos + 1;
                    inputField.selectionEnd = cursorPos + 1;
                } else {
                    if (cursorPos === text.length) {
                        inputField.value = textBefore + "`\n";
                    } else {
                        inputField.value = textBefore + "`\n" + textAfter;
                    }
                    inputField.selectionStart = cursorPos + 2;
                    inputField.selectionEnd = cursorPos + 2;
                }

                event.preventDefault();
            }
        }
    </script>

</body>

</html>