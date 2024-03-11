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
                            <h1 class="h3 mb-0 text-gray-800">Identitas Diri Jamaah
                                <a href="<?php echo base_url() . 'staff/info/pdf?id=' . $id_jamaah . '&paket=' . $member_select; ?>" class="btn btn-danger btn-icon-split btn-sm">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-file-pdf"></i>
                                    </span>
                                    <span class="text">pdf</span>
                                </a>
                            </h1>

                        </div>
                        <!-- Content Row -->
                        <?php if ($member) { ?>
                            <div class="row hidePdf">
                                <div class="col-lg-12">
                                    <label class="switch">
                                        <input type="checkbox" id="togBtn" value="false" name="disableYXLogo" <?php echo $member[0]->valid == 1 ? 'checked' : '' ?>>
                                        <div class="slider round"></div>
                                    </label>
                                    <span class="text-primary font-italic fs-1">Jika data sudah divalidasi, jamaah tidak dapat melakukan update data.</span>

                                </div>
                            </div>
                        <?php } ?>

                        <div class="row">
                            <div class="col-lg-6">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                    <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                        <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                        <?php echo $_SESSION['alert_message']; ?>
                                    </div>
                                <?php } ?>


                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Profil Diri</h6>
                                        <span id="btnUpdateProfile" class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/jamaah/update_data?id=<?php echo $id_jamaah; ?>" class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="text">Update Data</span>
                                            </a>
                                        </span>
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
                                            <label class="col-form-label">Nomor HP (<span class="text-primary font-italic font-weight-lighter"><a href="https://wa.me/<?php echo $no_wa; ?>">Chat
                                                        WhatsApp</a></span>)</label>
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
                                        <label class="col-form-label">Surat Dokter</label>
                                        <div class="card shadow mb-4">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <?php if ($upload_penyakit == null) { ?>
                                                            File Belum Ada
                                                        <?php } else { ?>

                                                            <center>
                                                                <div id="paspor_scan2">
                                                                    <a href="<?php echo base_url() . $upload_penyakit; ?>" onclick="window.open('<?php echo base_url() . $upload_penyakit; ?>',
                                                                                               'newwindow',
                                                                                               'width=1000,height=500');
                                                                                       return false;">
                                                                        <img src="<?php echo base_url() . $upload_penyakit; ?>" style="width:auto; height:150px">
                                                                    </a>
                                                                </div>
                                                            </center>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Referensi</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $referensi == 'Agen' ? 'Konsultan' : $referensi; ?>">
                                        </div>
                                        <div class="py-2 d-flex flex-row align-items-center justify-content-between">
                                        <h5 class="m-0 font-weight-bold text-primary">Profil Ahli Waris</h6>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-form-label">Nama Ahli Waris</label>
                                            <input disabled class="form-control" type="text" value="<?php echo $nama_ahli_waris ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Nomor Telp</label>
                                            <input disabled class="form-control" type="number" value="<?php echo $no_ahli_waris; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Alamat</label>
                                            <textarea disabled class="form-control" rows="3"><?php echo $alamat_ahli_waris; ?></textarea>
                                        </div>              
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card shadow mb-4 border-left-info">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Program Umroh yang Diikuti</h6>
                                        <span id="btnTambahProgram" class="m-0">
                                            <a href="<?php echo base_url(); ?>staff/jamaah/add_member?id=<?php echo $id_jamaah; ?>" class="btn btn-warning btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-plus"></i>
                                                </span>
                                                <span class="text">Ikut Program Baru</span>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($member)) { ?>
                                            <form id="form_pilih_paket" action="<?php echo base_url(); ?>staff/info/detail_jamaah">
                                                <div class="form-group">
                                                    <input type="hidden" name="id" value="<?php echo $id_jamaah; ?>">
                                                    <label class="col-form-label">Pilih Program :</label>
                                                    <select name="id_member" class="form-control" id="select_paket">
                                                        <?php foreach ($member as $key => $mbr) { ?>
                                                            <option <?php echo $key == $member_select ? 'selected' : ''; ?> value="<?php echo $mbr->id_member; ?>">
                                                                <?php if (!empty($mbr->paket_info)) { ?>
                                                                    <?php echo $mbr->paket_info->nama_paket . ' (' . date_format(date_create($mbr->paket_info->tanggal_berangkat), "d F Y") . ')'; ?>
                                                                <?php } else { ?>
                                                                    &lt;Detail Paket Sudah Dihapus&gt;
                                                                <?php } ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </form>

                                            <center>
                                                <div id="btnProgram" class="form-group">
                                                    <a href="<?php echo base_url(); ?>staff/bayar?idm=<?php echo $member[$member_select]->id_member; ?>" class="btn btn-primary btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-hand-holding-usd"></i>
                                                        </span>
                                                        <span class="text">Proses Bayar</span>
                                                    </a>
                                                    <a href="<?php echo base_url(); ?>staff/jamaah/update_member?idm=<?php echo $member[$member_select]->id_member; ?>" class="btn btn-warning btn-icon-split">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Update Data</span>
                                                    </a>

                                                </div>
                                            </center>
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <tr>
                                                        <th>
                                                            <a href="<?php echo base_url(); ?>staff/member/pindah_paket/<?php echo $member[$member_select]->id_jamaah; ?>/<?php echo $member[$member_select]->id_member; ?>" class="btn btn-danger btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fa-solid fa-right-left"></i>
                                                                </span>
                                                                <span class="text">Pindah Paket</span>
                                                            </a>
                                                        </th>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:200px;">
                                                            Group Leader
                                                            <a id="btnSetLeader" href="<?php echo base_url(); ?>staff/jamaah/set_parent?idm=<?php echo $member[$member_select]->id_member; ?>" class="btn btn-sm btn-warning btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-user-edit"></i>
                                                                </span>
                                                                <span class="text">Set Leader</span>
                                                            </a>
                                                        </th>

                                                        <td>
                                                            <?php if (!empty($child)) { ?>
                                                                <?php foreach ($child as $key => $c) { ?>
                                                                    <?php if ($member[$member_select]->parent_id == $key) { ?>
                                                                        <?php echo $c->jamaahData->first_name . ' ' . $c->jamaahData->second_name . ' ' . $c->jamaahData->last_name; ?>
                                                                        <a target='_blank' href="<?php echo base_url(); ?>staff/info/detail_jamaah?id=<?php echo $c->jamaahData->id_jamaah ?>&id_member=<?php echo $c->memberData->id_member; ?>" class="btn btn-sm btn-primary btn-icon-split">
                                                                            <span class="icon text-white-50">
                                                                                <i class="fas fa-user"></i>
                                                                            </span>
                                                                            <span class="text">Lihat Detail</span>
                                                                            <?php break; ?>
                                                                        <?php } ?>
                                                                        </a>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:200px;">Group Members</th>

                                                        <td>
                                                            <?php if (!empty($child)) { ?>
                                                                <?php foreach ($child as $c) { ?>
                                                                    <?php // if ($c->memberData->id_member == $parent->memberData->id_member) continue; 
                                                                    ?>
                                                                    <?php echo $c->jamaahData->first_name . ' ' . $c->jamaahData->second_name . ' ' . $c->jamaahData->last_name; ?>
                                                                    <a target='_blank' href="<?php echo base_url(); ?>staff/info/detail_jamaah?id=<?php echo $c->jamaahData->id_jamaah ?>&id_member=<?php echo $c->memberData->id_member; ?>" class="btn btn-sm btn-primary btn-icon-split">
                                                                        <span class="icon text-white-50">
                                                                            <i class="fas fa-user"></i>
                                                                        </span>
                                                                    </a>
                                                                    <br>
                                                                <?php } ?>
                                                            <?php } ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:200px;">Nama Konsultan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->agen->id_agen)) { ?>
                                                                <a href="<?php echo base_url() . 'staff/kelola_agen/profile?id=' . $member[$member_select]->agen->id_agen; ?>" target="_blank">
                                                                    <?php echo $member[$member_select]->agen->nama_agen . ' (' . $member[$member_select]->agen->no_agen . ')'; ?>
                                                                </a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:200px;">Nomor Paspor</th>
                                                        <td><?php echo $member[$member_select]->paspor_no; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pilihan Kamar</th>
                                                        <td><?php echo $member[$member_select]->pilihan_kamar; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Harga</th>
                                                        <td>
                                                            <?php echo 'Rp. ' . number_format($member[$member_select]->total_harga, null, ',', '.') . ',-'; ?>
                                                            <!-- <a id="btnRincian" href="<?php echo base_url(); ?>staff/info/rincian_harga?id=<?php echo $member[$member_select]->id_member; ?>" class="btn btn-sm btn-primary btn-icon-split" onclick="window.open('<?php echo base_url(); ?>staff/info/rincian_harga?id=<?php echo $member[$member_select]->id_member; ?>',
                                                                                   'newwindow',
                                                                                   'width=400,height=400');
                                                                           return false;">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-eye"></i>
                                                                </span>
                                                                <span class="text">Rincian</span>
                                                            </a> -->
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status Pembayaran</th>
                                                        <?php
                                                        if ($member[$member_select]->lunas == 1) {
                                                            $lns = 'Lunas';
                                                        } else if ($member[$member_select]->lunas == 2) {
                                                            $lns = 'Sudah Cicil';
                                                        } else if ($member[$member_select]->lunas == 3) {
                                                            $lns = 'Kelebihan Bayar';
                                                        } else {
                                                            $lns = 'Belum Bayar';
                                                        }
                                                        ?>
                                                        <td>
                                                            <?php echo $lns; ?>

                                                            <a id="btnRiwayatBayar" href="<?php echo base_url() ?>staff/info/riwayat_bayar?id=<?php echo $member[$member_select]->id_member; ?>" class="btn btn-sm btn-primary btn-icon-split" onclick="window.open('<?php echo base_url() ?>staff/info/riwayat_bayar?id=<?php echo $member[$member_select]->id_member; ?>',
                                                                                   'newwindow',
                                                                                   'width=800,height=800');
                                                                           return false;">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-eye"></i>
                                                                </span>
                                                                <span class="text">Rincian dan Riwayat Bayar</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Pernah Umroh</th>
                                                        <td><?php echo $member[$member_select]->pernah_umroh == '1' ? 'Pernah' : 'Tidak'; ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Urutan Manifest</th>
                                                        <td><?php echo $member[$member_select]->manifest_order; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nomor Kamar</th>
                                                        <td><?php echo $member[$member_select]->room_number; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Nama Paspor</th>
                                                        <td><?php echo $member[$member_select]->paspor_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paspor Issue Date</th>
                                                        <td><?php echo $member[$member_select]->paspor_issue_date; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paspor Expiry Date</th>
                                                        <td><?php echo $member[$member_select]->paspor_expiry_date; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paspor Issuing City</th>
                                                        <td><?php echo $member[$member_select]->paspor_issuing_city; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paspor Scan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->paspor_scan)) { ?>
                                                                <a href="<?php echo base_url() . $member[$member_select]->paspor_scan; ?>" onclick="window.open('<?php echo base_url() . $member[$member_select]->paspor_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                                    <img src="<?php echo base_url() . $member[$member_select]->paspor_scan; ?>" style="width:auto; height:120px">

                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paspor 2 Scan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->paspor_scan2)) { ?>
                                                                <a href="<?php echo base_url() . $member[$member_select]->paspor_scan2; ?>" onclick="window.open('<?php echo base_url() . $member[$member_select]->paspor_scan2; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                                    <img src="<?php echo base_url() . $member[$member_select]->paspor_scan2; ?>" style="width:auto; height:120px">

                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>KTP Scan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->ktp_scan)) { ?>
                                                                <a href="<?php echo base_url() . $member[$member_select]->ktp_scan; ?>" onclick="window.open('<?php echo base_url() . $member[$member_select]->ktp_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                                    <img src="<?php echo base_url() . $member[$member_select]->ktp_scan; ?>" style="width:auto; height:120px">
                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Foto Scan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->foto_scan)) { ?>
                                                                <a href="<?php echo base_url() . $member[$member_select]->foto_scan; ?>" onclick="window.open('<?php echo base_url() . $member[$member_select]->foto_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                                    <img src="<?php echo base_url() . $member[$member_select]->foto_scan; ?>" style="width:auto; height:120px">
                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>VISA Scan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->visa_scan)) { ?>
                                                                <a href="<?php echo base_url() . $member[$member_select]->visa_scan; ?>" onclick="window.open('<?php echo base_url() . $member[$member_select]->visa_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                                    <img src="<?php echo base_url() . $member[$member_select]->visa_scan; ?>" style="width:auto; height:120px">
                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>KK Scan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->kk_scan)) { ?>
                                                                <a href="<?php echo base_url() . $member[$member_select]->kk_scan; ?>" onclick="window.open('<?php echo base_url() . $member[$member_select]->kk_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                                    <img src="<?php echo base_url() . $member[$member_select]->kk_scan; ?>" style="width:auto; height:120px" alt="Download here">
                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vaksin Scan</th>
                                                        <td>
                                                            <?php if (!empty($member[$member_select]->vaksin_scan)) { ?>
                                                                <a href="<?php echo base_url() . $member[$member_select]->vaksin_scan; ?>" onclick="window.open('<?php echo base_url() . $member[$member_select]->vaksin_scan; ?>',
                                                                                       'newwindow',
                                                                                       'width=1000,height=500');
                                                                               return false;">
                                                                    <img src="<?php echo base_url() . $member[$member_select]->vaksin_scan; ?>" style="width:auto; height:120px" alt="Download here">
                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Paspor Check</th>
                                                        <td>
                                                            <?php if ($member[$member_select]->paspor_check == 1) { ?>
                                                                <span class="btn btn-sm btn-success btn-circle">
                                                                    <i class="fas fa-check"></i>
                                                                </span> Sudah
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span> Belum
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Buku Kuning Check</th>
                                                        <td>
                                                            <?php if ($member[$member_select]->buku_kuning_check == 1) { ?>
                                                                <span class="btn btn-sm btn-success btn-circle">
                                                                    <i class="fas fa-check"></i>
                                                                </span> Sudah
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span> Belum
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Foto Check</th>
                                                        <td>
                                                            <?php if ($member[$member_select]->foto_check == 1) { ?>
                                                                <span class="btn btn-sm btn-success btn-circle">
                                                                    <i class="fas fa-check"></i>
                                                                </span> Sudah
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-danger btn-circle">
                                                                    <i class="fas fa-times"></i>
                                                                </span> Belum
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        <?php } else { ?>
                                            <center>Tidak ada program yang diikuti</center>
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
    <div class="modal fade" id="hapusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $("#togBtn").on('change', function() {
            if ($(this).is(':checked')) {
                $.getJSON("<?php echo base_url() . 'staff/info/validasi'; ?>", {
                        id_member: "<?php echo $member[0]->id_member; ?>",
                        valid: 1
                    })
                    .done(function(json) {
                        alert('Data berhasil di-lock');
                        $("#" + id).remove();
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        alert('Data gagal di-lock');
                    });
            } else {
                $.getJSON("<?php echo base_url() . 'staff/info/validasi'; ?>", {
                        id_member: "<?php echo $member[0]->id_member; ?>",
                        valid: 0
                    })
                    .done(function(json) {
                        alert('Data berhasil di-unlock');
                        $("#" + id).remove();
                    })
                    .fail(function(jqxhr, textStatus, error) {
                        alert('Data gagal di-unlock');
                    });
            }
        });
    </script>

</body>

</html>