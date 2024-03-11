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


            <?php $this->load->view('staff/include/side_menu', ['broadcast_agen' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Broadcast Pesan Konsultan</h1>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if (!empty($_SESSION['alert_type'])) { ?>
                                <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                    <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                    <?php echo $_SESSION['alert_message']; ?>
                                </div>
                                <?php } ?>
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-danger">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Broadcast Pesan Baru</h6>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo base_url(); ?>staff/broadcast_agen/proses_tambah"
                                            method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_broadcast">
                                            <div class="form-group">
                                                <label class="col-form-label">Judul : </label><br>
                                                <textarea class="form-control" name="judul"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Pesan : </label><br>
                                                <!-- <textarea rows="5" cols="100" name="pesan" id="pesan" onkeydown="breakLine(event);"></textarea><br> -->
                                                <textarea rows="5" cols="100" name="pesan" id="pesan" class="wysiwyg"></textarea><br>
                                                <!-- <button type="button" id="add_link">Tambahkan Link</button> -->
                                            </div>
                                            <div class="form-group">
                                                <label class="col-form-label">Link Tambahan <span class="text-primary">( Contoh untuk link pendaftaran dll. )</span></label><br>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input type="text" class="form-control" name="nama_link1" placeholder="Nama Link 1">
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control" name="link1" placeholder="Link 1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input type="text" class="form-control" name="nama_link2" placeholder="Nama Link 2">
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control" name="link2" placeholder="Link 2"> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input type="text" class="form-control" name="nama_link3" placeholder="Nama Link 3">
                                                    </div>
                                                    <div class="col-9">
                                                        <input type="text" class="form-control" name="link3" placeholder="Link 3"> 
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Tambahkan Flyer</label> <br>
                                                <input type="file" class="form-control" name="flyer_image">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Warna Background : </label>
                                                <input type="radio" name="color" value="primary" checked> <span
                                                    class="btn btn-sm btn-primary">Biru</span>
                                                <input type="radio" name="color" value="warning"> <span
                                                    class="btn btn-sm btn-warning">Kuning</span>
                                                <input type="radio" name="color" value="danger"> <span
                                                    class="btn btn-sm btn-danger">Merah</span>
                                                <input type="radio" name="color" value="success"> <span
                                                    class="btn btn-sm btn-success">Hijau</span>
                                            </div>

                                            <div class="form-group">
                                            <a href="javascript:void(0);" id="selectAll" class="btn btn-primary btn-sm selectAll">Semua Konsultan</a>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" width="100%" id="dataTable" cellspacing="0">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 40px;">
                                                                    <!-- <a href="javascript:void(0);" id="selectAll" class="btn btn-primary btn-sm selectAll"><i class="fa-solid fa-plus"></i></a> -->
                                                                </th>
                                                                <th>ID Konsultan</th>
                                                                <th>Nama Konsultan</th>
                                                                <th>Email</th>
                                                                <th>No. WhatsApp</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                <div class="shadow rounded p-3 border-left-primary my-2">
                                                    <p><strong>Kirim broadcast ke :</strong></p>
                                                    <div id="list_agen">
                                                        <!-- list agen selected -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Status : </label>
                                                <br><input type="radio" name="tampilkan" value="1" checked> Tampilkan
                                                <br><input type="radio" name="tampilkan" value="0"> Sembunyikan
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
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 border-left-primary">
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Daftar Pesan yang di Broadcast
                                        </h6>
                                    </div>
                                    <!-- foreach here -->
                                    <?php foreach ($pesan as $key => $p) : ?>
                                    <div class="card-body">
                                        <div class="card shadow mb-4 border-left-warning">
                                            <div
                                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                <a href="<?php echo base_url(); ?>staff/broadcast_agen/hapus?id_broadcast=<?php echo $pesan[$key]->id_broadcast; ?>"
                                                    class="btn btn-danger btn-icon-split btn-sm">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-edit"></i>
                                                    </span>
                                                    <span class="text">Hapus</span>
                                                </a>
                                                <h6 class="m-0 font-weight-bold text-primary">
                                                    <?php echo date_format(date_create($pesan[$key]->tanggal_post), "d F Y h:i:s A"); ?>
                                                </h6>

                                            </div>
                                            <div class="card-body">


                                                <form action="<?php echo base_url(); ?>staff/broadcast_agen/status" method="post" enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Judul : </label><br>
                                                        <textarea name="judul" class="form-control"><?php echo $pesan[$key]->judul; ?></textarea><br>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="col-form-label">Pesan : </label><br>
                                                        <textarea name="pesan" id="pesanEdit" class="wysiwyg" rows="5" cols="100"><?php echo str_replace("<br>","`",$pesan[$key]->pesan); ?></textarea><br>
                                                    </div>

                                                    
                                                    <div class="form-group">
                                                        <label class="col-form-label">Link Tambahan <span class="text-primary">( Contoh untuk link pendaftaran dll. )</span></label><br>
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="nama_link1" value="<?php echo $pesan[$key]->nama_link1 ?>" placeholder="Nama Link 1">
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" class="form-control" name="link1" value="<?php echo $pesan[$key]->link1 ?>" placeholder="Link 1">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="nama_link2" value="<?php echo $pesan[$key]->nama_link2 ?>" placeholder="Nama Link 2">
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" class="form-control" name="link2" value="<?php echo $pesan[$key]->link2 ?>" placeholder="Link 2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-3">
                                                                <input type="text" class="form-control" name="nama_link3" value="<?php echo $pesan[$key]->nama_link3 ?>" placeholder="Nama Link 3">
                                                            </div>
                                                            <div class="col-9">
                                                                <input type="text" class="form-control" name="link3" value="<?php echo $pesan[$key]->link3 ?>" placeholder="Link 3">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php if ($pesan[$key]->flyer_image != null) { ?>
                                                        <div class="my-3">
                                                            <img src="<?php echo base_url() . $pesan[$key]->flyer_image ?>" width="150px" class="rounded">
                                                            <a rel="flyer_image"
                                                                href="#"
                                                                class="btn btn-danger btn-icon-split btn-sm hapusImg rounded-xs my-2">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                <span class="text">Hapus</span>
                                                            </a>
                                                        </div>
                                                    <?php } else { ?>
                                                        <div class="form-group">
                                                            <label class="col-form-label mt-3">Tambahkan Flyer</label><br>
                                                            <input type="file" class="form-control" name="flyer_image"><br>
                                                        </div>
                                                    <?php } ?>
                                                    
                                                    <input type="hidden" name="id_broadcast" id="id_broadcast" value="<?php echo $pesan[$key]->id_broadcast; ?>">

                                                    <div class="form-group">
                                                        <label class="col-form-label">Warna Background : </label>
                                                        <input type="radio" name="color" value="primary"
                                                            <?php echo $pesan[$key]->color == 'primary' ? 'checked' : ''; ?>>
                                                        <span class="btn btn-sm btn-primary">Biru</span>
                                                        <input type="radio" name="color" value="warning"
                                                            <?php echo $pesan[$key]->color == 'warning' ? 'checked' : ''; ?>>
                                                        <span class="btn btn-sm btn-warning">Kuning</span>
                                                        <input type="radio" name="color" value="danger"
                                                            <?php echo $pesan[$key]->color == 'danger' ? 'checked' : ''; ?>> <span
                                                            class="btn btn-sm btn-danger">Merah</span>
                                                        <input type="radio" name="color" value="success"
                                                            <?php echo $pesan[$key]->color == 'success' ? 'checked' : ''; ?>>
                                                        <span class="btn btn-sm btn-success">Hijau</span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-form-label">Status : </label>
                                                        <br><input type="radio" name="tampilkan" value="1"
                                                            <?php echo $pesan[$key]->tampilkan == 1 ? 'checked' : ''; ?>>
                                                        Tampilkan
                                                        <br><input type="radio" name="tampilkan" value="0"
                                                            <?php echo $pesan[$key]->tampilkan == 0 ? 'checked' : ''; ?>>
                                                        Sembunyikan
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
                                        <?php if (empty($pesan)) { ?>
                                        <center>Belum ada pesan yang di broadcast</center>
                                        <?php } ?>
                                    </div>
                                    <?php endforeach; ?>
                                    <!-- endforeach -->
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
            // add link
            $("#add_link").on("click", function () { 
                $("#additional_link").removeClass("d-none");
            })


            $("#content").on("click", "#checkAll", function() {
                $(".checks").prop('checked', $(this).prop('checked'));
            });
            
            loadDatatables();        
            
            function loadDatatables() {

                var dataTable = $('#dataTable').DataTable({
                    pageLength: 5,
                    dom: 'frtp',
                    "processing": false,
                    "serverSide": true,
                    "ajax": {
                        "url": "<?php echo base_url(); ?>staff/broadcast_agen/load_agen"
                    },
                    
                    columns: [
                        {
                            data: 'id_agen',
                            render: function(data, type, row) {
                                return '<a href="javascript:void(0);" data-id="'+ row['id_agen'] +'" data-nama="' + row['nama_agen'] + '" data-no="' + row['no_agen'] + '" class="btn btn-primary btn-sm add"><i class="fa-solid fa-plus"></i></a>';
                            }
                        },
                        {
                            data: 'no_agen'
                        },
                        {
                            data: 'nama_agen'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'no_wa'
                        },
                    ],
                    columnDefs: [
                        {
                            "targets": [0],
                            "orderable": false
                        }
                    ],
                    order: [
                        [2, 'asc']
                    ]

                });

                $("#dataTable tbody").on("click", ".add", function() {
                    if ($('#list_agen').text().trim() == "Semua Konsultan") {
                        $('#list_agen').empty();
                    }
                    var id_agen = $(this).data('id');
                    var nama_agen = $(this).data('nama');
                    var no_agen = $(this).data('no');
                    var html = "<div class='row d-flex my-1' id='list-item'>\n";
                    if ($("#list_agen").find("[data-id='" + id_agen + "']").length === 0) {
                        var html = "<div class='row d-flex my-1' data-id='" + id_agen + "'>\n";
                        html += "<div class='col-sm-1'>\n";
                        html += "<a href='javascript:void(0);' class='btn btn-danger btn-sm delete'>\n";
                        html += "<i class='fa-solid fa-trash-can'></i></a>\n";
                        html += "</div>\n";
                        html += "<input type='hidden' name='id_agen[]' class='border border-0 bg-primary text-white rounded px-1' value='" + id_agen + "' readonly style='width: 50px;'>\n";
                        html += "<div class='col-sm-2'>\n";
                        html += "<p class='my-auto mx-2 text-primary'><strong>" + no_agen + "</strong></p>\n";
                        html += "</div>\n";
                        html += "<div class='col-sm-3'>\n";
                        html += "<p class='my-auto mx-2'>" + nama_agen + "</p>\n";
                        html += "</div>\n";
                        $("#list_agen").append(html);

                        
                        $(this).attr("disabled", true);
                        // console.log(id_agen)
                    }
                });

                // var allIds = []; 
                // var selectedIds = []; 

                // $("#dataTable").on("xhr.dt", function(e, settings, json, xhr) {
                //     json.data.forEach(function(item) {
                //         allIds.push(item.id_agen);
                //     });
                // });

                // $("#selectAll").on("click", function() {
                //     $("#list_agen").empty();
                //     $("#list_agen").text("Semua Agen");
                    
                //     if (selectedIds.length === 0) {
                //         selectedIds = allIds.slice();
                //     } else {
                //         selectedIds = [];
                //     }
                    
                //     var inputHtml = "";
                //     for (var i = 0; i < selectedIds.length; i++) {
                //         inputHtml += "<input type='hidden' name='id_agen[]' value='" + selectedIds[i] + "'>";
                //     }
                //     $("#list_agen").append(inputHtml);
                //     console.log(allIds)
                // });



                $("#selectAll").on("click", function() {
                    
                    // dataTable.ajax.reload(function(json) {
                        
                        //     var ids = [];
                        
                        //     $.each(json.data, function(index, rowData) {
                            //         console.log(rowData);
                            //         var id_agen = rowData.id_agen; 
                            //         ids.push(id_agen);
                            //     });
                            
                            //     $("#list_agen").empty(); 
                            //     $("#list_agen").append("<p class='text-primary'><strong>Semua Agen</strong></p>"); 
                            
                            //     var inputHtml = "";
                            //     for (var i = 0; i < ids.length; i++) {
                                //         inputHtml += "<input type='hidden' name='id_agen[]' value='" + ids[i] + "'>";
                    //     }

                    //     $("#list_agen").append(inputHtml);
                    // });
                    
                    const ids = [];
                    // console.log(ids);
                    // $("#dataTable tbody .add").each(function() {
                        const id_agen = <?php echo "[".$a."]" ?>;
                        // ids.push(id_agen);
                        id_agen.forEach((item) => ids.push(item))
                    // });
                    
                    $("#list_agen").empty(); 
                    $("#list_agen").append("<span class='text-primary'><strong><i class='fa-solid fa-users'></i>   Semua Konsultan</strong></span>"); 
                    
                    var inputHtml = "";
                    for (var i = 1; i <= ids.length; i++) {
                        inputHtml += "<input type='hidden' name='id_agen[]' value='" + ids[i] + "'>";
                    }
                    // console.log(ids)
                    $("#list_agen").append(inputHtml);
                });

                $("#list_agen").on("click", ".delete", function() {
                    $(this).parent().parent().remove();
                });
            }

            $(".hapusImg").click(function() {
            var id = $('#id_broadcast').val();
            $.getJSON("<?php echo base_url() . 'staff/broadcast_agen/hapus_flyer'; ?>", {
                    id: id,
                    // field: id
                })
                .done(function(json) {
                    alert('File berhasil dihapus');
                    // $("#" + id).remove();
                    location.reload();
                })
                .fail(function(jqxhr, textStatus, error) {
                    console.log("Request Failed: " + textStatus + ", " + error);
                    alert('File gagal dihapus');
                    location.reload();
                });
            });
        });
    </script>

</body>

</html>