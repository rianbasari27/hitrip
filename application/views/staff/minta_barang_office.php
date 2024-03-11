<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('staff/include/header_view'); ?>
    <link rel="stylesheet" href="<?php echo base_url();?>asset/mycss/combobox.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


            <?php $this->load->view('staff/include/side_menu', ["perl_office" => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Permintaan Barang Office</h1>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Isi data dengan benar</h6>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($_SESSION['alert_type'])) { ?>
                                        <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                            <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                            <?php echo $_SESSION['alert_message']; ?>
                                        </div>
                                        <?php } ?>
                                        <form role="form" action="<?php echo $action; ?>" method="post" id="form">
                                            <?php if ($barang != NULL) { ?>
                                            <input class="form-control" type="hidden" name="id_barang"
                                                value="<?php echo $barang[0]->id_barang;?>">
                                            <?php } ?>
                                            <div class="form-group">
                                                <label class="col-form-label">Nama Barang</label>
                                                <input class="form-control" type="text" name="nama"
                                                    value="<?php echo $barang != null ? $barang[0]->nama : '';?>"
                                                    <?php echo $barang != null ? "readonly" : '';?>>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Jumlah</label>
                                                <input class="form-control" type="number" name="stock">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Divisi</label>
                                                <input class="form-control" type="text" name="divisi">
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Keterangan Tambahan</label>
                                                <textarea class='form-control' name='keterangan_tambahan'
                                                    rows="3"></textarea>
                                            </div>
                                            <?php if ($_SESSION['bagian'] == "Logistik") { ?>
                                            <div class="form-group">
                                                <label for="inputStaff">Nama Staff</label>
                                                <input type="hidden" id="id_staff_request" name="id_staff_request" value="">
                                                <input value="" type="text" class="form-control" id="inputStaff" aria-describedby="staffHelp" placeholder="masukkan nama staff">
                                                <small id="staffHelp" class="form-text text-muted">Ketik minimal 3 huruf untuk memunculkan auto complete</small>
                                            </div>
                                            <?php } ?>
                                            <a href="" class="btn btn-success btn-icon-split" id="submit">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Submit</span>
                                            </a>
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
        $(document).ready(function() {
            if ("<?php echo $_SESSION['bagian'] ;?>" == "Logistik") {
                $("#submit").on("click", function(event) {
                    event.preventDefault();
                    //check apakah id_staff_requst kosong
                    const staffData = $("#id_staff_request").val();
                    if (staffData === "") {
                        alert("Pilih Staff dari Pop Up Menu!");
                        $("#inputStaff").val("");
                    } else {
                        $("#form").submit();
                    }
                });
            } else {
                $("#submit").on("click", function(event) {
                    event.preventDefault();
                    $("#form").submit();
                });
            }
            $("#inputStaff").on("keyup paste", function(event) {
                const selectionKeys = [38, 39, 40, 13];
                if (selectionKeys.includes(event.which) === false) {
                    $("#id_staff_request").val('');
                }
            });
            $("#inputStaff").autocomplete({
                minLength: 3,
                source: function(request, response) {
                    data = getDataStaff(request).then(data => {
                        response(data);
                    }).catch(err => {
                        console.log(err)
                    });
                },
                select: function(event, ui) {
                    event.preventDefault();
                    populateField(ui);
                },
                focus: function(event, ui) {
                    event.preventDefault();
                    populateField(ui);
                }
            });

            function populateField(ui) {
                $("#id_staff_request").val(ui.item.value);
                $("#inputStaff").val(ui.item.label);
            }

            async function getDataStaff(request) {
                var staffNames = [];
                await $.getJSON("<?php echo base_url() . 'staff/perlengkapan_office/staff_autocomplete' ?>", request)
                    .done(function(data) {
                        $.each(data, function(idx, d) {
                            let label = d.nama + " (" + d.bagian + ")";
                            let name = {
                                "label": label,
                                "value": d.id_staff
                            };
                            staffNames.push(name);
                        });
                    });
                return staffNames;
            }
        });
    </script>

</body>

</html>