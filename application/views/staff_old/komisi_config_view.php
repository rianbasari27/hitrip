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


                <?php $this->load->view('staff/include/side_menu', ['komisi_config' => true]); ?>

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
                                <h1 class="h3 mb-0 text-gray-800">Pengaturan Komisi</h1>
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
                                            <h6 class="m-0 font-weight-bold text-primary">List pengaturan dan persyaratan komisi</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo base_url()?>staff/komisi_config/proses_update" method="post">
                                                <table class="table table-bordered">
                                                    <!-- KOMISI KELIPATAN -->
                                                    <tr>
                                                        <th colspan="2"><div class="text-primary"><strong>KOMISI KELIPATAN</strong></div></th>
                                                    </tr>
                                                    <input type="hidden" name="id_config[]" value="<?php echo $komisi[1]->id_config ?>">
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Banyaknya Kelipatan</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3">
                                                                <input type="number" name="syarat[]" class="form-control" id="syarat" value="<?php echo $komisi[1]->syarat ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Komisi Kelipatan</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-7">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[1]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <!-- KOMISI BULANAN -->
                                                    <tr>
                                                        <th colspan="2"><div class="text-primary"><strong>KOMISI BULANAN</strong></div></th>
                                                    </tr>
                                                    <input type="hidden" name="id_config[]" value="<?php echo $komisi[4]->id_config ?>">
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Target Bulan Pertama</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3">
                                                                <input type="number" name="syarat[]" class="form-control" id="syarat" value="<?php echo $komisi[4]->syarat ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Komisi Bulan Pertama</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-7">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[4]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Target Bulan Kedua</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3">
                                                                <input type="hidden" name="id_config[]" value="<?php echo $komisi[5]->id_config ?>">
                                                                <input type="number" name="syarat[]" class="form-control" id="syarat" value="<?php echo $komisi[5]->syarat ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Komisi Bulan Kedua</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-7">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[5]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- KOMISI UKHUWAH -->
                                                    <tr>
                                                        <th colspan="2"><div class="text-primary"><strong>KOMISI UKHUWAH</strong></div></th>
                                                    </tr>
                                                    <input type="hidden" name="id_config[]" value="<?php echo $komisi[2]->id_config ?>">
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Banyaknya Downline</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3">
                                                                <input type="number" name="syarat[]" class="form-control" id="syarat" value="<?php echo $komisi[2]->syarat ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Komisi Ukhuwah</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-7">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[2]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <!-- KOMISI PEMBINAAN -->
                                                    <tr>
                                                        <th colspan="2"><div class="text-primary"><strong>KOMISI PEMBINAAN</strong></div></th>
                                                    </tr>
                                                    <input type="hidden" name="id_config[]" value="<?php echo $komisi[3]->id_config ?>">
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Banyaknya Downline</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3">
                                                                <input type="number" name="syarat[]" class="form-control" id="syarat" value="<?php echo $komisi[3]->syarat ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Komisi Pembinaan</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-7">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[3]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- REWARD PEMBINAAN -->
                                                    <tr>
                                                        <th colspan="2"><div class="text-primary"><strong>REWARD PEMBINAAN</strong></div></th>
                                                    </tr>
                                                    <input type="hidden" name="id_config[]" value="<?php echo $komisi[6]->id_config ?>">
                                                    <input type="hidden" name="syarat[]" value="<?php echo $komisi[6]->syarat ?>">
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Jumlah Minimal Downline</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[6]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Persen Minimal Downline Aktif</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-3">
                                                                <input type="hidden" name="id_config[]" class="form-control" id="id_config" value="<?php echo $komisi[7]->id_config ?>">
                                                                <input type="hidden" name="syarat[]" class="form-control" id="syarat" value="<?php echo $komisi[7]->syarat ?>">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[7]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- UNCLAIMED POINT -->
                                                    <tr>
                                                        <th colspan="2"><div class="text-primary"><strong>UNCLAIMED POINTS</strong></div></th>
                                                    </tr>
                                                    <input type="hidden" name="id_config[]" value="<?php echo $komisi[0]->id_config ?>">
                                                    <input type="hidden" name="syarat[]" value="<?php echo $komisi[0]->syarat ?>">
                                                    <tr>
                                                        <td>
                                                            <div class="my-auto">
                                                                <label>Persen penambahan poin dari<br>poin yang tidak bisa diklaim<br>di musim sebelumnya dan akan<br>ditambahkan ke musim berikutnya</label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="col-md-2">
                                                                <input type="number" name="value[]" class="form-control" id="value" value="<?php echo $komisi[0]->value ?>">
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </table>
                                                <button type="submit" class="btn btn-success"><i class="fa-solid fa-download"></i> Edit</button>
                                            </form>
                                                
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
            $(document).ready(function () {
                $('#dataTable').DataTable({
                    dom: 'rt',
                    "processing": true,
                    "serverSide": true,
                    "ajax": "<?php echo base_url(); ?>staff/komisi_config/load_komisi",
                    columns: [
                        {
                            data: 'nama'
                        },
                        {
                            data: 'syarat'
                        },
                        {
                            data: 'value',
                            render: function(data, type, row) {
                                return '<input type="number" name="value" id="value" value="'+data+'">';
                            }
                        },
                        {
                            data: 'id_config',
                            visible: false
                        //     render: function(data, type, row) {
                        //         return '<a href="javascript:void(0);" data-id="'+data+'" class="btn btn-success btn-sm edit_btn">Edit</a>';
                            
                        },
                    ],
                    // columnDefs: [
                    //     {
                    //         targets: 0,
                    //         orderable: false
                    //     }
                    // ]
                });

                $("#dataTable tbody").on("click", ".edit_btn", function () {
                    var trid = $(this).data('id'); // table row ID
                    console.log(trid) 
                    window.location.href = "<?php echo base_url(); ?>staff/komisi_config/update?id=" + trid;
                });
            });
        </script>

    </body>

</html>




