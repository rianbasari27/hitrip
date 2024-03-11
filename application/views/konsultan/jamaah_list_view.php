<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/banner.jpg");
    }

    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-19 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-17 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-18 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures//default/default_700x466.png");
    }

    .bg-20 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-21 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-29 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .bg-33 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default_700x466.png");
    }

    .table> :not(caption)>*>* {
        padding: 0.7rem 1rem 0rem !important;
    }

    .page-link {
        border-radius: 10px;
        border: none;
        color: black;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);

    }

    .active .page-link {
        color: white;
        background-color: #edbd5a !important;
    }

    .hidden-row {
        display: none !important;
    }
    </style>
    <link href="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <style>
    .table-container {
        overflow-x: scroll;
    }

    .fixed-column {
        position: sticky;
        left: 0;
        z-index: 1;
        background-color: white;
    }

    .hover {
        background-color: #f0f0f0;
    }

    .disabled-form {
        background-color: #f0f0f0;
    }

    .custom-select-sm {
        border-radius: 8px;
    }

    .form-control-sm {
        border-radius: 7px;
        width: 70vw !important;
    }

    .page-link {
        border-radius: 10px;
        border: none;
        color: black;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);

    }

    .active .page-link {
        color: white;
        background-color: #edbd5a !important;
    }


    .hover {
        background-color: #f0f0f0 !important;
    }

    .custom-row-style {
        overflow: hidden;
        border-radius: 20px !important;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
        /* background-color: white; */
        display: table-row;
        width: 100%;
        margin-bottom: 15px;
        padding: 0px 20px 0px 20px;
    }

    .table-content {
        margin: 20px 0;
    }



    .dataTable {
        /* border-collapse: separate; */
        /* width: 100% !important; */
        border-spacing: 0 1em !important;

    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['jamaah_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">


            <div class="card card-style">
                <div class="card mb-0 bg-home" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Informasi Jamaah</p>
                    <h1>List Jamaah</h1>
                </div>
            </div>

            <?php if ($jamaah != null) : ?>
            <div class="card card-style">
                <div class="content">
                    <p class="color-highlight font-500 mb-2">Filter Jamaah</p>

                    <form action="<?php echo base_url().'konsultan/jamaah_list?id_agen='.$_SESSION['id_agen']?>"
                        method="get">

                        <input type="hidden" name="id_agen" value="<?php echo $_SESSION['id_agen']?>">

                        <div class="input-style has-borders no-icon mb-4">
                            <label for="select" class="color-highlight">Pilih Musim</label>
                            <select name="musim" id="musim">
                                <option value="" selected>
                                    -- Pilih Musim --
                                </option>
                                <?php foreach ($groupBySeason as $group) {?>
                                <option value="<?php echo $group->musim ;?>"><?php echo $group->musim ;?> H</option>
                                <?php } ?>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <!-- <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i> -->
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon mb-4">
                            <label for="select" class="color-highlight">Pilih bulan</label>
                            <select name="bulan" id="month">
                                <option value="" selected>
                                    -- Pilih Bulan --
                                </option>
                                <?php for ($i = 1; $i <= 12; $i++) : ?>
                                <option value="<?php echo $i ?>" rel="<?php echo $i ?>"
                                    <?php echo isset($_GET['bulan']) ? ($_GET['bulan'] == $i ? 'selected' : '') : '' ?>>
                                    <?php echo $month[$i] ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <!-- <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i> -->
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon mb-4">
                            <label for="select" class="color-highlight">Nama Paket</label>
                            <select name="id_paket" id="id_paket">
                                <option value="" selected>
                                    -- Pilih Nama Paket --
                                </option>
                                <?php foreach ($paket as $pkt) : ?>
                                <option rel=""
                                    <?php echo isset($_GET['id_paket']) ? ($_GET['id_paket'] == $pkt->id_paket ? 'selected' : '') : '' ?>
                                    value="<?php echo $pkt->id_paket?>"><?php echo $pkt->nama_paket ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <!-- <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i> -->
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon mb-4">
                            <label for="select" class="color-highlight">Status Pembayaran</label>
                            <select name="status_bayar" id="status_bayar">
                                <option value="" selected>
                                    -- Pilih Status Pembayaran --
                                </option>
                                <option value="1"
                                    <?php echo isset($_GET['status_bayar']) ? ($_GET['status_bayar'] == '1' ? 'selected' : '') : '' ?>>
                                    Lunas</option>
                                <option value="2">
                                    <?php echo isset($_GET['status_bayar']) ? ($_GET['status_bayar'] == '2' ? 'selected' : '') : '' ?>Sudah
                                    cicil</option>
                                <option value="0"
                                    <?php echo isset($_GET['status_bayar']) ? ($_GET['status_bayar'] == '0' ? 'selected' : '') : '' ?>>
                                    Belum lunas</option>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <!-- <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i> -->
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon mb-4">
                            <label for="select" class="color-highlight">Kelengkapan Data & Administrasi</label>
                            <select name="data" id="data">
                                <option value="" selected>
                                    -- Kelengkapan Data & Administrasi --
                                </option>
                                <option value="1"
                                    <?php echo isset($_GET['data']) ? ($_GET['data'] == '1' ? 'selected' : '') : '' ?>>
                                    Lengkap</option>
                                <option value="0"
                                    <?php echo isset($_GET['data']) ? ($_GET['data'] == '0' ? 'selected' : '') : '' ?>>
                                    Belum lengkap</option>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <!-- <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i> -->
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon mb-4">
                            <label for="select" class="color-highlight">Status Perlengkapan</label>
                            <select name="perlengkapan" id="perlengkapan">
                                <option value="" selected>
                                    -- Status Perlengkapan --
                                </option>
                                <option value="Sudah diambil"
                                    <?php echo isset($_GET['perlengkapan']) ? ($_GET['perlengkapan'] == 'Sudah diambil' ? 'selected' : '') : '' ?>>
                                    Sudah diambil</option>
                                <option value="Sudah sebagian"
                                    <?php echo isset($_GET['perlengkapan']) ? ($_GET['perlengkapan'] == 'Sudah sebagian' ? 'selected' : '') : '' ?>>
                                    Sudah sebagian</option>
                                <option value="Belum diambil"
                                    <?php echo isset($_GET['perlengkapan']) ? ($_GET['perlengkapan'] == 'Belum diambil' ? 'selected' : '') : '' ?>>
                                    Belum diambil</option>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <!-- <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i> -->
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon mb-4">
                            <label for="select" class="color-highlight">Status Keberangkatan</label>
                            <select name="berangkat" id="berangkat">
                                <option value="" selected>
                                    -- Status Keberangkatan --
                                </option>
                                <option value="Sudah berangkat">Sudah berangkat</option>
                                <option value="Belum berangkat">Belum berangkat</option>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <!-- <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i> -->
                            <em></em>
                        </div>

                        <!-- <button type="submit" id="search" class="btn btn-xs btn-full mb-3 rounded-xs text-uppercase font-700 shadow-s bg-highlight" value="search"><i class="fa-solid fa-magnifying-glass me-2"></i>Search</button> -->
                    </form>
                </div>

            </div>

            <div class="card card-style">
                <div class="content mb-0">
                    <p class="color-highlight font-500 mb-2">Informasi Status Jamaah</p>
                </div>
                <div class="table-content">
                    <table class="table table-borderless" style="width: 100%; padding: 0px 10px 0px 10px;"
                        id="dataTable" style="overflow: hidden;">
                        <thead class="text-center text-dark">
                            <tr class="">
                                <th></th>
                                <th class="text-start border-bottom border-1 border-highlight" style="width: 80%;">
                                    Nama Jamaah</th>
                                <th class="text-start border-bottom border-1 border-highlight">
                                    Tanggal Berangkat</th>
                                <th class="border-bottom border-1 border-highlight">Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <?php else : ?>
            <div class="card card-style">
                <div class="content">
                    <p>Tidak ada jamaah yang terdaftar pada sistem.</p>
                </div>
            </div>
            <?php endif; ?>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>

    </div>
    <!-- Page content ends here-->

    <!-- Main Menu-->
    <div id="menu-main" class="menu menu-box-left rounded-0"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
        data-menu-active="nav-welcome"></div>

    <!-- Share Menu-->
    <div id="menu-share" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370">
    </div>

    <!-- Colors Menu-->
    <div id="menu-colors" class="menu menu-box-bottom rounded-m"
        data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480">
    </div>
    </div>
    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <?php $this->load->view('konsultan/include/script_view'); ?>

    <script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#month").change(function() {
            var monthVal = $(this).find(":selected").attr('rel');

            $.getJSON(`jamaah_list/getPackageByMonth`, {
                bulan: monthVal
            }, function(data) {
                $('#id_paket').find('option').remove();

                if (!data) {
                    $('#id_paket').prop("disabled", true);
                    $('#id_paket').addClass("disabled-form");
                    $('#id_paket').append(
                        `<option value="" selected>Tidak ada paket yang tersedia.</option>`);

                } else {
                    $('#id_paket').prop("disabled", false);
                    $('#id_paket').removeClass("disabled-form");

                    $('#id_paket').append(
                        '<option value="" selected>-- Pilih Nama Paket --</option>')
                    $(data).each(function(index, item) {
                        $('#id_paket').append('<option value="' + item['id_paket'] +
                            '" rel="' + item['id_paket'] + '">' + item[
                                'nama_paket'] + '</option>');
                    });
                }
            });

            reinitializeDataTable();
        });


        $("#id_paket, #status_bayar, #data, #perlengkapan, #berangkat, #musim").change(function() {
            reinitializeDataTable();
        });

        // $("#status_bayar").change(function() {
        //     reinitializeDataTable();
        // });

        // $("#data").change(function() {
        //     reinitializeDataTable();
        // });

        // $("#perlengkapan").change(function() {
        //     reinitializeDataTable();
        // });

        // $("#berangkat").change(function() {
        //     reinitializeDataTable();
        // });


        function reinitializeDataTable() {

            $('#dataTable tbody').off('mouseenter', 'tr');
            $('#dataTable tbody').off('mouseleave', 'tr');
            $('#dataTable tbody').off('click', 'tr');

            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }

            loadDatatables();
        }

        loadDatatables();

        function loadDatatables() {
            var monthVal = !$("#month").val() ? '' : $("#month").val();
            var idPaket = !$("#id_paket").val() ? '' : $("#id_paket").val();
            var lunasVal = !$("#status_bayar").val() ? '' : $("#status_bayar").val();
            var dataVal = !$("#data").val() ? '' : $("#data").val();
            var perlengkapanVal = !$("#perlengkapan").val() ? '' : $("#perlengkapan").val();
            var berangkatVal = !$("#berangkat").val() ? '' : $("#berangkat").val();
            var musimVal = !$("#musim").val() ? '' : $("#musim").val();

            var dataTable = $('#dataTable').DataTable({
                pageLength: 10,
                dom: 'fBrtp',
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>konsultan/jamaah_list/load_jamaah",
                    "data": {
                        id_agen: "<?php echo $_SESSION['id_agen']; ?>",
                        month: monthVal,
                        status_bayar: lunasVal,
                        data: dataVal,
                        id_paket: idPaket,
                        perlengkapan: perlengkapanVal,
                        berangkat: berangkatVal,
                        musim: musimVal,
                    }
                },

                columns: [{
                        data: 'first_name',
                        visible: false
                    },
                    {
                        data: 'first_name',
                        render: function(data, type, row) {
                            if (row['second_name'] == null) {
                                secondName = ''
                            } else {
                                secondName = row['second_name']
                            }

                            if (row['last_name'] == null) {
                                lastName = ''
                            } else {
                                lastName = row['last_name']
                            }
                            return '<h6>' + data + ' ' + secondName + ' ' + lastName + '</h6>' +
                                '<span>' + row['nama_paket'] +
                                '<br><i class="fa-solid fa-plane-up me-2 mb-2 color-highlight"></i>' +
                                moment(row['tanggal_berangkat']).locale('id').format('ll') +
                                ' </span>'
                        }
                    },
                    {
                        data: 'tanggal_berangkat',
                        visible: false
                    },
                    // {
                    //     data: 'nama_paket',
                    //     render: function(data, type, row) {
                    //         return data + '<br> (' + moment(row['tanggal_berangkat']).locale('id').format('D MMMM YYYY') + ')'
                    //     }
                    // },
                    {
                        data: 'lunas',
                        render: function(data, type, row) {
                            if (data == 1 || data == 3) {
                                icon1 =
                                    '<div class="my-auto"><i class="fa fa-circle-check color-green-light fa-xl text-center"></i></div>'
                            } else {
                                icon1 =
                                    '<div class="my-auto"><i class="fa fa-circle-minus color-red-light fa-xl text-center"></i></div>'
                            }

                            if (row['dokumen'] == 1) {
                                icon2 =
                                    '<div class="my-auto"><i class="fa fa-circle-check color-green-light fa-xl text-center"></i></div>'
                            } else {
                                icon2 =
                                    '<div class="my-auto"><i class="fa fa-circle-minus color-red-light fa-xl text-center"></i></div>'
                            }

                            if (row['perlengkapan'] == 1) {
                                icon3 =
                                    '<div class="my-auto"><i class="fa fa-circle-check color-green-light fa-xl text-center"></i></div>'
                            } else {
                                icon3 =
                                    '<div class="my-auto"><i class="fa fa-circle-minus color-red-light fa-xl text-center"></i></div>'
                            }


                            return '<div class="mb-2"> <div class="d-flex"><span class="me-2">' +
                                icon1 +
                                '</span><span class="text-xxs">Pelunasan</span></div><div class="d-flex"><span class="me-2">' +
                                icon2 +
                                '</span><span class="text-xxs">Dokumen</span></div><div class="d-flex"><span class="me-2">' +
                                icon3 +
                                '</span><span class="text-xxs">Perlengkapan</span></div></div>'
                        },
                        bSearchable: false
                    },
                ],
                columnDefs: [{
                    "targets": [1, 3],
                    "orderable": false
                }],
                createdRow: function(row, data, index) {
                    $(row).addClass('custom-row-style');
                    const date = new Date();
                    let getDate = date.getDate();
                    if (data['tanggal_berangkat'] >= getDate) {
                        $(row).addClass('sudah-berangkat');
                    }
                },
                order: [
                    [0, 'asc']
                ]

            });

            $('#dataTable tbody').on('mouseenter', 'tr', function() {
                $(this).addClass('hover');
            }).on('mouseleave', 'tr', function() {
                $(this).removeClass('hover');
            });



            $('#dataTable tbody').on('click', 'tr', function() {
                var rowData = $(this).closest('tr').attr('id_secret');
                // console.log(rowData);
                window.location.href = `jamaah_info/dp_notice?id=${rowData}`
            });
        }
    });
    // function searchClick() {
    //     $('#dataTable').DataTable().ajax.reload();
    // }
    </script>

</body>