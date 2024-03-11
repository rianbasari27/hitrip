<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 10px;
        border-radius: 20px;
        /* border: 1px solid #888; */
        width: 80%;
    }
    @media only screen and (min-width:700px) {
        .modal-content {
            width: 560px;
        }
    }

    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }

    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/perlengkapan.jpg");
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
    <link href="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.css"
        rel="stylesheet">
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
        <?php $this->load->view('konsultan/include/footer_menu'); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content ">
            <?php if($jamaahAgen != NULL) : ?>
            <div class="card card-style">
                <div class="table-content">
                    <table class="table table-borderless list-jamaah" style="width: 100%; padding: 0px 10px 0px 10px;"
                        id="dataTable" style="overflow: hidden;">
                        <thead class="text-center text-dark">
                            <tr class="">
                                <th></th>
                                <th class="text-start border-bottom border-1 border-highlight" style="width: 70%;">
                                    Nama Jamaah</th>
                                <th class="border-bottom border-1 border-highlight">Status</th>
                                <th class="border-bottom border-1 border-highlight">Aksi</th>
                                <!-- <th class="border-bottom border-1 border-highlight" style="margin:0; width: 5%;"><i
                                        class="fa-solid fa-clipboard-list fa-xl"></i></th>
                                <th class="border-bottom border-1 border-highlight" style="margin:0; width: 5%;"><i
                                        class="fa-solid fa-suitcase-rolling fa-xl"></i></th> -->
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <?php else : ?>
            <div class="card card-style mx-3">
                <div class="content">
                    <p>Tidak ada jamaah yang terdaftar</p>
                </div>
            </div>
            <?php endif; ?>

            <div class="card card-style">
                <div class="content">
                    <p class="mb-n1 color-highlight font-600">Daftar List Jamaah</p>
                    <h3 class="mb-4">Jadwal Pengambilan Perlengkapan</h3>
                    <form action="<?php echo base_url() . 'konsultan/ambil_perlengkapan/proses_ambil_kolektif' ;?>"
                        method="post">
                        <div id="list_agen">
                            <!-- list agen selected -->
                        </div>
                        <div class="form-group">
                            <label class="color-highlight">Jenis Pengambilan</label><strong class="text-danger">
                                *</strong>
                            <div class="input-style has-borders no-icon mb-4">
                                <select name="jenis_ambil" class="form-control" id="slct"
                                    onchange="showOnChange(event)">
                                    <option value="" disabled selected>-- Pilih salah satu --</option>
                                    <option value="langsung">WALK IN</option>
                                    <option value="pengiriman">PENGIRIMAN</option>
                                </select>
                                <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                                <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                                <em></em>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;" id="selectAlamat">
                            <label for="form6" class="color-highlight">Alamat Lengkap</label>
                            <div class="input-style has-borders no-icon mb-4">
                                <textarea class="form-control" name="alamat_pengiriman"></textarea>
                                <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                                <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                            </div>
                        </div>
                        <div class="form-group" style="display: none;" id="selectNomor">
                            <label class="color-highlight">No Telepon ( <span class="text-primary">Nomor Telepon
                                    Aktif</span> )</label>
                            <div class="input-style has-borders no-icon mb-4">
                                <input name="no_pengiriman" type="text" value="" class="form-control validate-text">
                                <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                                <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                            </div>
                        </div>
                        <div class="input-style has-borders no-icon mb-4">
                            <input name="date" type="date" min="<?php echo date('Y-m-d'); ?>"
                                max="<?php echo date('Y-m-d', strtotime('+3 days'));?>"
                                class="form-control validate-text" id="form6" placeholder="Atur jadwal pengambilan">
                            <label for="form6" class="color-highlight">Select Date</label>
                            <i class="fa fa-check disabled valid me-4 pe-3 font-12 color-green-dark"></i>
                            <i class="fa fa-check disabled invalid me-4 pe-3 font-12 color-red-dark"></i>
                        </div>
                        <button class="btn btn-sm gradient-highlight rounded-s">Ambil Perlengkapan</button>
                    </form>
                </div>
            </div>


            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>

        <!-- modal-->
        <div id="myModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="menu-title">
                    <p class="color-highlight">List Barang</p>
                    <h1>Sudah di ambil</h1>
                    <a href="#" onclick="myFunction()"><i class="fa fa-times-circle"></i></a>
                </div>
                <div id="modal_body">
                </div>
            </div>

        </div>

        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-perl"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>

    </div>

    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="320" data-menu-width="350">
        <div class='responsive-iframe max-iframe'>
            <iframe width="560" height="315" id="youtube-video"
                src="https://www.youtube.com/embed/qfd03QcquF8?si=6PfIyt_GcINRbwHi" frameborder="0"
                allowfullscreen></iframe>
            <!-- <iframe src='https://www.youtube.com/embed/c9MnSeYYtYY' frameborder='0' allowfullscreen></iframe> -->
        </div>
        <div class="menu-title">
            <p class="color-highlight">Video Tutorial</p>
            <h1>Tutorial Booking Perlengkapan</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-n2">
            <!-- <p>
                It's super easy to embed videos. Just copy the embed!
            </p> -->
            <!-- <a href="#" class="close-menu btn btn-full btn-m shadow-l rounded-s text-uppercase font-600 gradient-green mt-n2">Awesome</a> -->
        </div>
    </div>

    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <?php $this->load->view('konsultan/include/script_view'); ?>
    <script>
    var modal = document.getElementById("myModal");

    function myFunction() {
        modal.style.display = "none";
    }

    function showOnChange(e) {
        var elem = document.getElementById("slct");
        var value = elem.options[elem.selectedIndex].value;
        if (value == "pengiriman") {
            document.getElementById('selectAlamat').style.display = "block";
            document.getElementById('selectNomor').style.display = "block";
        }
        if (value == "langsung") {
            document.getElementById('selectAlamat').style.display = "none";
            document.getElementById('selectNomor').style.display = "none";
        }
    }
    </script>
    <script>
    $(document).ready(function() {
        // function updateTimes() {
        //     moment.tz.add([
        //         "Asia/Jakarta|LMT BMT +0720 +0730 +09 +08 WIB|-77.c -77.c -7k -7u -90 -80 -70|012343536|-49jH7.c 2hiLL.c luM0 mPzO 8vWu 6kpu 4PXu xhcu|31e6",
        //         "Asia/Riyadh|LMT +03|-36.Q -30|01|-TvD6.Q|57e5",
        //     ]);
        //     const jakartaTime = moment().tz("Asia/Jakarta").format("HH:mm");
        //     const riyadhTime = moment().tz("Asia/Riyadh").format("HH:mm");
        //     const jakartaDate = moment().tz("Asia/Jakarta").locale('id').format("ll");
        //     const riyadhDate = moment().tz("Asia/Riyadh").locale('id').format("ll");

        //     $("#jakarta").text(jakartaTime);
        //     $("#riyadh").text(riyadhTime);
        //     $("#jkt_date").text(jakartaDate);
        //     $("#riyadh_date").text(riyadhDate);
        // }

        // setInterval(updateTimes, 1000);

        // updateTimes();

        loadDatatables();

        var countdownIntervals = {};

        function loadDatatables() {
            var dataTable;

            function initCountdown(rowId, endTime) {
                clearInterval(countdownIntervals[rowId]);

                function updateCountdown() {
                    const currentTime = new Date().getTime();
                    const timeLeft = endTime - currentTime;

                    if (timeLeft <= 0) {
                        clearInterval(countdownIntervals[rowId]);
                        $('#countdown' + rowId).html('');
                    } else {
                        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                        // Ganti ini dengan kode untuk menampilkan countdown dengan benar
                        $('#countdown' + rowId).html(
                            '<div class="text-danger"><i class="fa-solid fa-clock me-1"></i> Booking seat  ' +
                            hours + 'j ' + minutes + 'm ' + seconds + 'd</div>');
                    }
                }


                countdownIntervals[rowId] = setInterval(updateCountdown, 1000);
            }

            var dataTable = $('#dataTable').DataTable({
                pageLength: 5,
                dom: 'fBrtp',
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo base_url(); ?>konsultan/home/load_perlengkapan",
                    "data": {
                        id_agen: "<?php echo $_SESSION['id_agen']; ?>",
                    }
                },
                // "oPagination": {
                //     ellipses: {
                //         iShowPages: 2
                //     }
                // },
                columns: [{
                        data: 'dp_expiry_time',
                        visible: false
                    },
                    {
                        data: 'first_name',
                        render: function(data, type, full, meta) {
                            var endTime = new Date(full['dp_expiry_time']).getTime();
                            var rowId = full['DT_RowId'];

                            // console.log('#countdown'+rowId);

                            if (full['lunas'] == 0) {
                                initCountdown(rowId, endTime);
                            }

                            if (full['second_name'] == null) {
                                r1 = ''
                            } else {
                                r1 = full['second_name']
                            }

                            if (full['last_name'] == null) {
                                r2 = ''
                            } else {
                                r2 = full['last_name']
                            }

                            return '<h6>' + data + ' ' + r1 + ' ' + r2 + '</h6>' + '<span>' +
                                full['nama_paket'] +
                                '<br><i class="fa-solid fa-plane-up me-2 color-highlight"></i>' +
                                moment(full['tanggal_berangkat']).locale('id').format('LL') +
                                ' </span>' +
                                `<div id="countdown` + rowId + `" class="mb-1 fw-bold"></div>`
                        }
                    },
                    {
                        data: 'status_perl',
                        render: function(data, type, row, meta) {
                            if (row['status_perlengkapan'] == "Belum Ambil") {
                                if (data == 1) {
                                    text = "Siap Ambil"
                                } else {
                                    text = "Belum Ready"
                                }
                            } else {
                                text = row['status_perlengkapan'];
                            }

                            //masih pending
                            if (data == 2) {
                                text = "Pending Booking"
                            }
                            return text
                        }
                    },
                    {
                        data: 'DT_RowId',
                        render: function(data, type, row, meta) {
                            var table = $('#dataTable').DataTable();
                            var info = table.data().count();
                            var dataId = meta.row; // Get the row index

                            if (row['status_perlengkapan'] == "Sudah Semua") {
                                var add = ""
                            } else {
                                if (row['status_perl'] == 1) {
                                    var add = '<a href="#" data-id="' + row['DT_RowId'] +
                                        '" data-nama="' + row['first_name'] + " " + row[
                                            'second_name'] +
                                        " " + row['last_name'] +
                                        '" data-paket="' + row['nama_paket'] +
                                        '" class="add"><i class="fa icon-50 text-center fa-plus-circle font-25 color-blue-dark"></i></a>' +
                                        '<h1 style="display:none;" id="dataPerl' + dataId +
                                        '">' +
                                        row['data_perlengkapan'] +
                                        '</h1>' +
                                        '<h1 style="display:none;" id="countPerl' + dataId +
                                        '">' +
                                        row['count'] +
                                        '</h1>'
                                } else {
                                    var add = ""
                                }
                            }

                            var info =
                                "<a data-menu='menu-call' href='#' class='info' data-id='" +
                                dataId +
                                "'><i class='fa icon-50 text-center fa-info-circle font-25 color-blue-dark'></i></a>";

                            // masih pending
                            if (row['status_perl'] == 2) {
                                add = ''
                            }
                            return info + add

                        }
                    },
                ],
                columnDefs: [{
                    "targets": [1, 2, 3],
                    "orderable": false
                }],
                // createdRow: function(row, data, index) {
                //     $(row).addClass('custom-row-style');
                // },
                order: [
                    [0, 'desc']
                ],
            });

            $('#dataTable').on('click', '.info', function() {
                var name = $("#dataPerl" + $(this).data('id')).text();
                var nama = name.split(",");
                var count = $("#countPerl" + $(this).data('id')).text();
                if (count > 0) {
                    var html = "<div class='row d-flex mb-4 fw-bold font-700 ms-3' id='list-item'>\n"
                    html += "<ul>"
                    for (let i = 0; i < count; i++) {
                        html += '<li>' + nama[i] + '</li>\n'
                    };
                    html += "</ul>"
                    html += "</div>"
                } else {
                    html =
                        "<div class='row d-flex mb-4 fw-bold font-700 ms-3' id='list-item'>Belum ada yang diambil</div>"
                }
                $("#modal_body").html(html);
                // Get the modal
                modal.style.display = "block";
                $('#myModal').fadeIn();
                // Rest of your code to display modal
            });

            $("#dataTable tbody").on("click", ".add", function() {
                if ($('#list_agen').text().trim() == "Semua Konsultan") {
                    $('#list_agen').empty();
                }
                var id_member = $(this).data('id');
                var fullName = $(this).data('nama');
                var paket = $(this).data('paket');
                var html = "";
                if ($("#list_agen").find("[data-id='" + id_member + "']").length === 0) {
                    // var html = "<div class='card card-style mb-2' data-id='" + id_member + "'>\n";
                    var html = "<div class='content' data-id='" + id_member + "'>\n";
                    html += "<div class='d-flex mb-2'>\n";
                    html += "<div class='w-100 ms-3 pt-1'>\n";
                    html +=
                        "<h6 class='font-500 font-14 pb-2'>" + fullName + " - " + paket + "</h6>\n";
                    html +=
                        "<input type='hidden' name='id_member[]' class='border border-0 bg-primary text-white rounded px-1' value='" +
                        id_member + "' readonly style='width: 50px;'>\n";
                    html +=
                        "<a href='#' class='btn gradient-red rounded-s float-start mt-1 font-11 color-theme font-12 delete'><i class='fa fa-trash color-white-white me-1'></i> Remove</a>";

                    html += "</div>\n";
                    html += "</div>\n";
                    html += "</div>\n";
                    // html += "</div>\n";
                    $("#list_agen").append(html);


                    $(this).attr("disabled", true);
                    Swal.fire({ //displays a pop up with sweetalert
                        icon: 'success',
                        title: 'Jamaah berhasil ditambahkan',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    // console.log(id_member)
                }
            });
        }

        $("#list_agen").on("click", ".delete", function() {
            $(this).parent().parent().remove();
            Swal.fire({ //displays a pop up with sweetalert
                icon: 'error',
                title: 'Jamaah berhasil dihapus',
                showConfirmButton: false,
                timer: 1000
            });
        });
    });
    </script>
</body>