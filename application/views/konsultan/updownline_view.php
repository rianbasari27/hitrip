<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
        .bg-home {
            background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/agen-network.jpg");
        }

        .inline {
            display: inline-block;
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

        .image-container {

            overflow: hidden;
            margin: 0px auto 0px;
            border-radius: 100%;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
        }

        .image-container.small {
            width: 50px;
            height: 50px;
            border: 2px solid #edbd5a;
        }

        .image-container.large {
            width: 120px;
            height: 120px;
            border: 5px solid #edbd5a;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
    <link href="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['updown_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <div class="page-content">

            <div class="card card-style">
                <div class="card mb-0 bg-home" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Informasi Konsultan</p>
                    <h1>Jaringan Anda</h1>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <p class="color-highlight font-500 mb-2">Informasi Jaringan</p>
                    <h1>Upline</h1>
                    <?php if (!isset($id_agen)) { ?>
                        Tidak ada upline
                    <?php } else { ?>
                        <div class="image-container large">
                            <?php if (empty($agen_pic)) : ?>
                                <a href="<?= base_url() . 'asset/appkit/images/pictures/default/default-profile.jpg' ?>" title="<?php echo $nama_agen; ?>" class="default-link" data-gallery="gallery-1">
                                    <img src="<?php echo base_url(); ?>asset/appkit/images/pictures/default/default-profile.jpg" width="30%" class="rounded-circle mx-auto shadow-xl">
                                </a>
                            <?php else : ?>
                                <a href="<?= base_url() . $agen_pic ?>" title="<?php echo $nama_agen ?>" class="default-link" data-gallery="gallery-1">
                                    <img src="<?php echo base_url() . $agen_pic; ?>" width="100" class="rounded-circle mx-auto shadow-xl">
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="my-3">
                            <h2 class="text-center my-0">
                                <a href="<?php echo base_url() . 'konsultan/profile/index/' . $id_agen; ?>" class="color-theme"><?php echo $nama_agen ?></a>
                            </h2>
                            <span class="text-center my-0 d-block mt-2">No. Agen : <?php echo $no_agen ?></span>
                            <a href="https://wa.me/<?php echo $this->wa_number->convert($no_wa); ?>" class="text-center my-0 d-block" target="_blank">
                                <i class="fab font-25 fa-whatsapp icon color-whatsapp" aria-hidden="true" style="vertical-align: -4px;"></i>
                                <?php echo $this->wa_number->convert($no_wa); ?>
                            </a>

                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="card card-style">
                <div class="d-flex pt-3 mt-1 mb-2 pb-2">
                    <div class="align-self-center">
                        <i
                            class="sign-icon color-icon-gray color-gray-dark font-30 icon-40 text-center fas fa-sign-in-alt ms-3"></i>
                    </div>

                    <div class="align-self-center">
                        <p class="ps-2 ms-1 color-highlight font-500 mb-n1 mt-n2">Daftarkan Downline</p>
                        <h4 class="ps-2 ms-1 mb-0" style="font-size: clamp(14px, 5vw, 22px);">Daftar disini</h4>
                    </div>
                    <div class="ms-auto align-self-center mt-n2">
                        <a href="<?php echo base_url() . 'konsultan/updown_line/tambah_downline'; ?>"
                            class="btn btn-sm rounded-s font-13 font-600 gradient-green me-4">
                            Daftar
                        </a>
                    </div>
                </div>
            </div>
            <div class="card card-style">
                <div class="content">
                    <p class="color-highlight font-500 mb-2">Informasi Jaringan</p>
                    <h1>Downline</h1>
                </div>
                <div class="table-content">
                    <table class="table table-borderless" style="width: 100%; padding: 0px 10px 0px 10px;" id="dataTable" style="overflow: hidden;">
                        <thead class="text-center text-dark">
                            <tr class="">
                                <th class="border-bottom border-1 border-highlight" style="margin:0; width: 5%;"><i class="fa-solid fa-user fa-xl "></i></th>
                                <th class="text-start border-bottom border-1 border-highlight" style="width: 200px;">Nama Konsultan</th>
                                <th class="text-start border-bottom border-1 border-highlight">Jamaah</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>
        <!-- Page content ends here-->

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370">
        </div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480">
        </div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <?php $this->load->view('konsultan/include/script_view'); ?>

    <script>
        $(document).ready(function() {
            loadDatatables();

            function loadDatatables() {
                var dataTable = $('#dataTable').DataTable({
                    pageLength: 5,
                    dom: 'fBrtp',
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo base_url(); ?>konsultan/updown_line/load_downline",
                        "data": {
                            id_agen: "<?php echo $_SESSION['id_agen']; ?>",
                        }
                    },

                    columns: [{
                            data: 'agen_pic',
                            orderable: false,
                            "render": function(data, type, row) {
                                var img = "";
                                if (!data) {
                                    img = '<img src="<?php echo base_url(); ?>asset/appkit/images/pictures/default/default-profile.jpg" width="30%" class="rounded-circle mx-auto shadow-xl">';
                                } else {
                                    img = '<img src="' + '<?php echo base_url(); ?>' + data + '" width="30%" class="rounded-circle mx-auto shadow-xl">';
                                }
                                var transform = '<div class="image-container small">' + img + '<div>';
                                return transform;
                            }
                        },
                        {
                            data: 'nama_agen',
                            "render": function(data, type, row) {
                                var name = '<a href="<?php echo base_url() . 'konsultan/profile/index/'; ?>' + row.DT_RowId + '" class="font-600 font-14 color-theme">' + data + '</a>';
                                var waIcon = '<i class="fab font-25 fa-whatsapp icon color-whatsapp" aria-hidden="true" style="vertical-align: -4px;"></i> ';
                                var wa = '<span class="">' + row.no_wa + '</span>';
                                var href = '<a href="https://wa.me/' + row.no_wa + '" class="my-0 d-block" target="_blank">' + waIcon + wa + '</a>';
                                var transform = name + '<br>' + href;
                                return transform;
                            }
                        },
                        {
                            data: 'total_jamaah',
                            render: function(data, type, row) {
                                return '<h6><i class="fa-solid fa-users me-2"></i>'+data +'<h6>'
                            }
                        },
                        {
                            data: 'no_wa',
                            visible: false
                        },
                    ],
                    createdRow: function(row, data, index) {
                        $(row).addClass('custom-row-style');
                    },
                    order: [
                        [1, 'asc']
                    ],
                });
                $('#dataTable tbody').on('mouseenter', 'tr', function() {
                    $(this).addClass('hover');
                }).on('mouseleave', 'tr', function() {
                    $(this).removeClass('hover');
                });
            }
        });
    </script>
</body>