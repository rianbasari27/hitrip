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


            <?php $this->load->view('staff/include/side_menu'); ?>

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
                        <div class="d-sm-flex align-items-center mb-5">
                            <h1 class="h3 mb-0 text-gray-800">Atur <?php echo $pageTitle; ?></h1><br>

                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <h4 class="h4 mb-0 mr-2 mb-2"><?php echo $nama_agen; ?></h4>
                                <?php if ($suspend == 1) { ?>
                                <h4 class="h4 mb-0 font-weight-bold mr-4" style="color: red;">(SUSPENDED)</h4>
                                <?php } ?>
                                <span style="color: #4ec738;">ID Konsultan <?php echo $no_agen; ?></span>,
                                <span style="color: #d85b5b;">Telp. <?php echo $no_wa; ?></span>
                            </div>
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
                                        <h6 class="m-0 font-weight-bold text-primary">Pilih Konsultan Sebagai
                                            <?php echo $pageTitle; ?></h6>
                                    </div>
                                    <div class="card-body">
                                        <form id="form" action="<?php echo $submitForm; ?>" method="post">
                                            <input type="hidden" name="id_agen" value="<?php echo $id_agen; ?>">
                                            <div class="form-group">
                                                <label for="inputAgen">Nama Konsultan</label>
                                                <input type="hidden" id="id_upline" name="id_upline"
                                                    value="<?php echo ($pageTitle == 'Upline' && !empty($uplineData->id_agen)) ? $uplineData->id_agen : ""; ?>">
                                                <input
                                                    value="<?php echo ($pageTitle == 'Upline' && !empty($uplineData->nama_agen)) ? $uplineData->nama_agen . " (" . $uplineData->no_agen . ")" : ""; ?>"
                                                    type="text" class="form-control" id="inputAgen"
                                                    aria-describedby="agenHelp" placeholder="masukkan nama konsultan">
                                                <small id="agenHelp" class="form-text text-muted">Ketik minimal 3 huruf
                                                    untuk memunculkan auto complete</small>
                                            </div>
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
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $("#submit").on("click", function(event) {
            event.preventDefault();
            //check apakah id_upline kosong
            const agenData = $("#id_upline").val();
            if (agenData === "") {
                alert("Pilih Konsultan dari Pop Up Menu!");
                $("#inputAgen").val("");
            } else {
                $("#form").submit();
            }
        });
        $("#inputAgen").on("keyup paste", function(event) {
            const selectionKeys = [38, 39, 40, 13];
            if (selectionKeys.includes(event.which) === false) {
                $("#id_upline").val('');
            }
        });
        $("#inputAgen").autocomplete({
            minLength: 3,
            source: function(request, response) {
                data = getDataAgen(request).then(data => {
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
            $("#id_upline").val(ui.item.value);
            $("#inputAgen").val(ui.item.label);
        }

        async function getDataAgen(request) {
            var agenNames = [];
            await $.getJSON("<?php echo base_url() . 'staff/kelola_agen/agen_autocomplete' ?>", request)
                .done(function(data) {
                    $.each(data, function(idx, d) {
                        let label = d.nama_agen + " (" + d.no_agen + ")";
                        let name = {
                            "label": label,
                            "value": d.id_agen
                        };
                        agenNames.push(name);
                    });
                });
            return agenNames;
        }
    });
    </script>

</body>

</html>