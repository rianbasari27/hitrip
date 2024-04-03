<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <style>
    #dataTable td {
        text-align: center;
    }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu',['jadwal_handling' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Daftar Jadwal Keberangkatan</h1>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Jadwal Keberangkatan didalam
                                            Sistem</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="300%"
                                                cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5px;">No</th>
                                                        <th style="width: 200px;">Nama Group</th>
                                                        <th>Manifest</th>
                                                        <th>Keuangan</th>
                                                        <th>Perlengkapan</th>
                                                        <th style="width: 350px;">Detail Flight</th>
                                                        <th>Program Hari</th>
                                                        <th>Tanggal Berangkat</th>
                                                        <th>Tanggal Pulang</th>
                                                        <th>Jumlah Pax</th>
                                                        <th>Tour Leader</th>
                                                        <th>Muthowif</th>
                                                        <th>Tanggal Kumpul</th>
                                                        <th>Jam Kumpul</th>
                                                        <th>Tempat Kumpul</th>
                                                        <th>Lounge</th>
                                                        <th>Handling</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
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


    <?php $this->load->view('staff/include/script_view'); ?>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
    // Call the dataTables jQuery plugin
    // function setModalWidth() {
    //     // Ambil lebar teks pada judul modal
    //     var modalTitleWidth = $("#exampleModalLabel").width();
    //     // Atur lebar modal sesuai dengan lebar teks judul modal
    //     $("#myModal .modal-dialog").css("max-width", modalTitleWidth + 300); // Tambahkan 100px sebagai tambahan lebar
    // }

    // // Panggil fungsi setModalWidth saat modal ditampilkan
    // $("#myModal").on("shown.bs.modal", function() {
    //     setModalWidth();
    // });
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            dom: 'lBfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: 'Export to Excel',
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c[r^="F"]', sheet).attr('s',
                        '2'); // Mengatur gaya untuk kolom "Detail Flight"
                }
            }],
            "ajax": {
                "url": "<?php echo base_url(); ?>staff/handling/load_data"
            },
            "columns": [{
                    data: 'DT_RowId',
                    "render": function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    data: "nama_paket"
                },
                {
                    data: "manifest"
                },
                {
                    data: "finance"
                },
                {
                    data: "perlengkapan"
                },
                {
                    data: "flight_schedule"
                },
                {
                    data: "program_hari"
                },
                {
                    data: "tanggal_berangkat"
                },
                {
                    data: "tanggal_pulang"
                },
                {
                    data: "jumlah_seat"
                },
                {
                    data: "tl",
                    render: function(data, type, row) {
                        if (data == '') {
                            return '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        } else {
                            return data +
                                '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        }
                    }
                },
                {
                    data: "muthowif",
                    render: function(data, type, row) {
                        if (data == '') {
                            return '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        } else {
                            return data +
                                '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        }
                    }
                },
                {
                    data: "tanggal_kumpul"
                },
                {
                    data: "jam_kumpul"
                },
                {
                    data: "tempat_kumpul"
                },
                {
                    data: "lounge",
                    render: function(data, type, row) {
                        if (data == '') {
                            return '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        } else {
                            return data +
                                '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        }
                    }
                },
                {
                    data: "handling",
                    render: function(data, type, row) {
                        if (data == '') {
                            return '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        } else {
                            return data +
                                '<a href="javascript:void(0)" class="btn btn-primary btn-sm tl_btn">+</a>';
                        }
                    }
                },
                {
                    data: 'status'
                },
            ],
            "order": [
                [7, "asc"]
            ],
            "columnDefs": [{
                    "targets": 5,
                    "className": "detail-flight"
                } // Menambahkan kelas CSS pada kolom "Detail Flight"
            ],
            "initComplete": function(settings, json) {
                var api = this.api();
                // Customize ekspor ke Excel
                api.buttons().container().appendTo($('#export-buttons'));
            }
        });

        $("#dataTable tbody").on("click", ".tl_btn", function() {
            var id = $(this).closest('tr').attr('id'); // table row ID 
            window.open("<?php echo base_url(); ?>staff/handling/tambah_tl?id=" + id, '_blank');
        });


        $("#dataTable tbody").on("click", ".hapus_btn", function() {
            var trid = $(this).closest('tr').attr('id'); // table row ID 
            var r = confirm("Yakin untuk menghapus?");
            if (r == true) {
                window.location.href = "<?php echo base_url(); ?>staff/reminder/hapus?id=" + trid;
            }
        });
    });

    // Fungsi untuk menyesuaikan format teks sebelum diekspor ke Excel
    function formatDetailFlightForExcel(data, type, row) {
        if (type === 'export') {
            return row['detail_flight'].replace(/\n/g, "\r\n");
        }
        return data;
    }
    </script>

</body>

</html>