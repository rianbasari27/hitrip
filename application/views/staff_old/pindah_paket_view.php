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


            <?php $this->load->view('staff/include/side_menu', ['data_jamaah' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Pindah Paket Umroh</h1>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">



                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Profil Diri</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label class="col-form-label">Nama</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $first_name . ' ' . $second_name . ' ' . $last_name; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor KTP</label>
                                            <input disabled class="form-control" type="number" value="<?php echo $ktp_no; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="col-form-label">Nama Ayah</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $nama_ayah; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tempat Lahir</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $tempat_lahir; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Tanggal Lahir (<span class="text-primary font-italic font-weight-lighter">yyyy-mm-dd</span>)</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $tanggal_lahir; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Jenis Kelamin</label>
                                            <input disabled class="form-control" type="text" value="<?php
                                                                                                    echo $jenis_kelamin == 'L' ? 'Laki-laki' : '';
                                                                                                    echo $jenis_kelamin == 'P' ? 'Perempuan' : ''
                                                                                                    ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Status Perkawinan</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $status_perkawinan; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor HP (<span class="text-primary font-italic font-weight-lighter">aktif Whatsapp</span>)</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $no_wa; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor Telepon Rumah</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $no_rumah; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Email</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $email; ?>">
                                        </div>
                                        <?php
                                        $alamat = $alamat_tinggal . '&#13;&#10;&#13;&#10;Kecamatan ' . $kecamatan . '&#13;&#10;Kabupaten/Kota ' . $kabupaten_kota . '&#13;&#10;Propinsi ' . $provinsi;
                                        ?>
                                        <div class="form-group">
                                            <label class="col-form-label">Alamat Tinggal</label>
                                            <textarea disabled class="form-control" rows="6"><?php echo $alamat; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Kewarganegaraan</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $kewarganegaraan; ?>" id="kewarganegaraan">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Pekerjaan</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $pekerjaan; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Pendidikan Terakhir</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $pendidikan_terakhir; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Riwayat Penyakit</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $penyakit; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Referensi</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $referensi; ?>">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card shadow mb-4 border-left-info">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h3 class="m-0 font-weight-bold text-primary">Program Umroh yang Diikuti</h3>

                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                                <?php echo $_SESSION['alert_message']; ?>
                                            </div>
                                        <?php } ?>
                                        <div>
                                            <h4 class="text-success"><?php echo $member[0]->paket_info->nama_paket; ?></h4>
                                            <h5 class="text-primary"> Keberangkatan <?php echo date_format(date_create($member[0]->paket_info->tanggal_berangkat), "d M Y"); ?></h4>
                                        </div>
                                        <div class="card bg-primary text-white shadow mt-5">
                                            <div class="card-body">
                                                <h4>Pindahkan ke Program :</h4>
                                                <form id="form_pilih_paket" action="<?php echo base_url(); ?>staff/member/proses_pindah_paket" method="post">
                                                    <div class="form-group">
                                                        <input type="hidden" name="idMember" value="<?php echo $member[0]->id_member; ?>">
                                                        <input type="hidden" name="idPaketLama" value="<?php echo $member[0]->id_paket; ?>">
                                                        <select name="idPaketBaru" id="select_paket" class="form-control">
                                                            <?php
                                                            $flagNextSchedule = 1;
                                                            $flagFuture = 1;
                                                            $flagLast = 1;
                                                            ?>
                                                            <?php foreach ($paketTersedia as $pkt) { ?>
                                                                <?php
                                                                $futureTrue = strtotime($pkt->tanggal_berangkat) > strtotime('now');
                                                                if ($flagNextSchedule == 1) {
                                                                    echo "<optgroup label='Next Trip'>";
                                                                    $prepareClose = 1;
                                                                    $flagNextSchedule = 0;
                                                                } elseif ($flagFuture == 1 && $futureTrue == true) {
                                                                    echo "</optgroup>";
                                                                    echo "<optgroup label='Future Trips'>";
                                                                    $flagFuture = 0;
                                                                } elseif ($flagLast == 1 && $futureTrue == false) {
                                                                    $flagLast = 0;
                                                                    echo "</optgroup>";
                                                                    echo "<optgroup label='Last Trips'>";
                                                                }
                                                                ?>
                                                                <option value="<?php echo $pkt->id_paket; ?>"><?php echo $pkt->nama_paket; ?> (<?php echo date_format(date_create($pkt->tanggal_berangkat), "d F Y"); ?>)</option>


                                                            <?php } ?>
                                                            <?php echo "</optgroup>"; ?>
                                                        </select>
                                                    </div>
                                                    <button class="btn btn-success btn-icon-split mt-4">
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
    </script>
</body>

</html>