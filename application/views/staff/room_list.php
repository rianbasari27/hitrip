<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <link href="<?php echo base_url(); ?>asset/mycss/detail_pdf.css" type="text/css" rel="stylesheet" media="mpdf" />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ['dokumen_admin' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Room List</h1>
                        </div>

                        <!-- Content Row -->
                        <div class='row'>
                            <?php if (!empty($_SESSION['alert_type'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                <?php echo $_SESSION['alert_message']; ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class='row hidePdf'>
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Paket Umroh</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form" method="get"
                                            action="<?php echo base_url(); ?>staff/room_list">
                                            <div class="form-group">
                                                <label class="col-form-label">Pilih Paket Umroh dibawah, atau
                                                    <a href="<?php echo base_url(); ?>staff/info/lihat_jamaah"
                                                        class="btn btn-warning btn-icon-split btn-sm">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-eye"></i>
                                                        </span>
                                                        <span class="text">Lihat Semua Paket</span>
                                                    </a>
                                                </label>

                                                <select name="id_paket" class="form-control">
                                                    <?php
                                                        $flagNextSchedule = 1;
                                                        $flagFuture = 1;
                                                        $flagLast = 1;
                                                        ?>
                                                    <?php foreach ($paket as $pkt) { ?>
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
                                                    <option value="<?php echo $pkt->id_paket; ?>"
                                                        <?php echo $pkt->id_paket == $id_paket ? 'selected' : ''; ?>>
                                                        <?php echo $pkt->nama_paket; ?>
                                                        (<?php echo date_format(date_create($pkt->tanggal_berangkat), "d F Y"); ?>)
                                                    </option>
                                                    <?php } ?>
                                                    <?php echo "</optgroup>"; ?>
                                                </select>
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
                        <div class="row hidePdf">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            <strong><?php echo $nama_paket; ?></strong><br>Jamaah yang Belum Mempunyai
                                            Kamar
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable" width="100%"
                                                        cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:100px;">Ketik Nama Kamar</th>
                                                                <th style="width:155px">Nama</th>
                                                                <th>Jenis Kelamin</th>
                                                                <th>Konsultan</th>
                                                                <th>Pilihan Kamar</th>
                                                                <th>Sharing Bed</th>
                                                                <th>Keterangan</th>
                                                                <th>Group</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            Room List
                                            <script language="javascript" type="text/javascript">
                                            /* <![CDATA[ */
                                            document.write('<a target="_blank" href="room_list/detail_pdf?url=' +
                                                encodeURIComponent(location.href) +
                                                '" class="btn btn-danger btn-icon-split btn-sm">');
                                            document.write('<span class="icon text-white-50">' +
                                                '<i class="fas fa-file-pdf"></i>' +
                                                '</span>' +
                                                '<span class="text">pdf</span>');
                                            document.write('</a>');
                                            /* ]]> */
                                            </script>
                                            <a href="<?php echo base_url() . 'staff/room_list/room_list_excel?id_paket=' . $id_paket; ?>"
                                                class="btn btn-info btn-icon-split btn-sm">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-file-excel"></i>
                                                </span>
                                                <span class="text">Download Room List</span>
                                            </a>
                                        </h6>
                                    </div>
                                    <div class="card-body" id="appendDynamicList">
                                        <div class="row" id="dynamicList">
                                            <?php foreach ($rooms as $room) { ?>
                                            <div class="col-lg-6">
                                                <div class="card shadow mb-4">
                                                    <div class="card-header py-3">
                                                        <h6 class="m-0 font-weight-bold text-primary">
                                                            <?php echo $room['room_number']; ?></h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered" width="100%"
                                                                cellspacing="0">
                                                                <thead>
                                                                    <tr>

                                                                        <th style="width:100px;">
                                                                            <div class="hidePdf">Hapus</div>
                                                                        </th>

                                                                        <th style="width:155px">Nama</th>
                                                                        <th>Gender</th>
                                                                        <th>Pilihan Kamar</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($room['member'] as $member) { ?>
                                                                    <tr>

                                                                        <th>
                                                                            <div class="hidePdf">
                                                                                <a href="#"
                                                                                    class="btn btn-danger btn-icon-split btn-sm hapus_btn"
                                                                                    idMember="<?php echo $member->id_member; ?>">
                                                                                    <span class="icon text-white-50">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </span>
                                                                                    <span class="text">Hapus</span>
                                                                                </a>
                                                                            </div>
                                                                        </th>
                                                        </div>
                                                        <td><?php echo $member->detailJamaah->first_name . " " . $member->detailJamaah->second_name . " " . $member->detailJamaah->last_name; ?>
                                                        </td>
                                                        <td><?php echo ($member->detailJamaah->jenis_kelamin != null) ? $member->detailJamaah->jenis_kelamin : ''; ?>
                                                        </td>
                                                        <td><?php echo $member->pilihan_kamar; ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
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
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/room_list/load_peserta",
                "data": {
                    id_paket: <?php echo $id_paket; ?>
                }
            },
            columns: [{
                    data: 'id_member',
                    "render": function(data, type, row) {
                        var html = "<input type='text' class='inputKamar'>";
                        return html;
                    }
                },
                {
                    data: 'nama_lengkap'
                },
                {
                    data: 'jenis_kelamin',
                    render: function(data, type, row) {
                        if (data == 'L') {
                            return "Laki - laki"
                        } else if (data == 'P') {
                            return 'Perempuan'
                        } else {
                            return data
                        }
                    }
                },
                {
                    data: 'nama_agen'
                },
                {
                    data: 'pilihan_kamar'
                },
                {
                    data: 'sharing_bed',
                    render: function(data, type, row) {
                        if (data === 1) {
                            data = "IYA"
                        } else {
                            data = "TIDAK"
                        }
                        return data
                    }
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'parent_id',
                    visible: false
                },
                {
                    data: 'whole_name',
                    bVisible: false,
                    bSearchable: true
                },
                {
                    data: 'two_name',
                    bVisible: false,
                    bSearchable: true
                },
            ],
            "order": [
                [5, 'desc']
            ],
        });

        $("#dataTable tbody").on("change", ".inputKamar", function() {
            var id_member = $(this).closest('tr').attr('id'); // table row ID 
            var room_number = $(this).val();
            $.getJSON("<?php echo base_url() . 'staff/room_list/setKamar'; ?>", {
                    id_member: id_member,
                    room_number: room_number
                })
                .done(function(data) {
                    $("#dynamicList").remove();
                    html = '<div class="row" id="dynamicList">\n' + '</div>';
                    $("#appendDynamicList").append(html);
                    $.each(data, function(key, value) {
                        html = getRoomHtml(value['room_number'], value['member']);
                        $("#dynamicList").append(html);

                    });
                    console.log(html);
                });
            table.ajax.reload();
        });

        $("#appendDynamicList").on("click", ".hapus_btn", function() {
            var idMember = $(this).attr('idMember'); // table row ID 
            var r = confirm('Yakin untuk menghapus?');
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/room_list/hapus?id=" + idMember;
            }
        });

        function getRoomHtml(roomNumber, data) {
            var html =
                '<div class="col-lg-6">\n' +
                '<div class="card shadow mb-4">\n' +
                '<div class="card-header py-3">\n' +
                '<h6 class="m-0 font-weight-bold text-primary">' + roomNumber + '</h6>\n' +
                '</div>\n' +
                '<div class="card-body">\n' +
                '<div class="table-responsive">\n' +
                '<table class="table table-bordered" width="100%" cellspacing="0">\n' +
                '<thead>\n' +
                '<tr>\n' +
                '<th style="width:100px;">Hapus</th>\n' +
                '<th style="width:155px">Nama</th>\n' +
                '<th>Gender</th>\n' +
                '<th>Pilihan Kamar</th>\n' +
                '</tr>\n' +
                '</thead>\n' +
                '<tbody>\n';
            $.each(data, function(key, value) {
                html =
                    html + '<tr>\n' +
                    '<td>\n' +
                    '<a href="#" idMember="' + value['id_member'] +
                    '" class="btn btn-danger btn-icon-split btn-sm hapus_btn">\n' +
                    '<span class="icon text-white-50">\n' +
                    '<i class="fas fa-trash"></i>\n' +
                    '</span>\n' +
                    '<span class="text">Hapus</span>\n' +
                    '</a>\n' +
                    '</td>\n' +
                    '<td>' + value['detailJamaah']['first_name'] + ' ' + value['detailJamaah'][
                        'second_name'
                    ] + ' ' + value['detailJamaah']['last_name'] + '</td>\n' +
                    '<td>' + value['detailJamaah']['jenis_kelamin'] + '</td>\n' +
                    '<td>' + value['pilihan_kamar'] + '</td>\n' +
                    '</tr>\n';
            });
            html =
                html + '</tbody>\n' +
                '</table>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>\n' +
                '</div>\n';
            return html;
        }
    });
    </script>

</body>

</html>