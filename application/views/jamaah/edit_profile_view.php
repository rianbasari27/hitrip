<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
    <style>
        .theme-dark label {
            background-color: #4a89dc !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaah/include/header_bar', ['noBackButton' => true]); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaah/include/footer_menu', ['profile' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaah/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content mt-n1">

            <div class="content text-center">
                <div class="p-1 border border-4 border-blue-dark d-inline-block rounded-pill">
                    <img src="<?php echo base_url() . ($profile_picture != null ? $profile_picture : 'asset/appkit/images/pictures/default/default-profile.jpg') ?>"
                    class="rounded-xl" width="100">
                </div>
                <div class="d-flex mt-3 justify-content-center">
                    <label
                        class="btn btn-s btn-full ignore btn-full rounded-xl text-uppercase font-700 me-2 shadow-s bg-highlight">
                        <input type="file" style="display: none;" name="insert_image" id="insert_image"
                            accept="image/*" />
                        <span class="text">Upload Foto</span>
                    </label>
                    <a rel="profile_picture" href="#"
                        class="btn btn-s btn-border btn-full rounded-xl text-uppercase font-700 border-red-dark color-red-dark hapusImg">
                        <span class="text">Hapus Foto</span>
                    </a>
                    <!-- <a href="#" class="btn btn-xs me-1 d-inline-block rounded-pill shadow-xl bg-highlight">Upload foto</a> -->
                    <!-- <a href="#" class="btn btn-s btn-full ignore btn-full rounded-xl text-uppercase font-700 me-2 color-red-dark shadow-s border-red-dark">Hapus foto</a> -->
                </div>
            </div>

            <div class="card card-style">
                <div class="content mb-0">
                    <form action="<?php echo base_url() ?>jamaah/profile/edit_profile" method="post">
                        <input type="hidden" name="id_user" value="<?php echo $id_user ?>">
                        <div class="input-style has-borders validate-field mb-4">
                            <input type="text" name="name" class="form-control validate-name" value="<?php echo $name != null ? $name : set_value('name') ?>" id="name" placeholder="Nama Lengkap">
                            <label for="name" class="color-highlight">Nama Lengkap</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('name') ?></div>

                        <div class="input-style has-borders validate-field mb-4">
                            <input type="text" name="username" class="form-control validate-name" value="<?php echo $username != null ? $username : set_value('username') ?>" id="username" placeholder="Username">
                            <label for="username" class="color-highlight">Username</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('username') ?></div>

                        <div class="input-style has-borders validate-field mb-4">
                            <input type="email" name="email" class="form-control validate-name" value="<?php echo $email != null ? $email : set_value('email') ?>" id="email" placeholder="Email">
                            <label for="email" class="color-highlight">Email</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('email') ?></div>

                        <div class="input-style has-borders validate-field mb-4">
                            <input type="text" name="no_wa" class="form-control validate-name" value="<?php echo $no_wa != null ? $no_wa : set_value('no_wa') ?>" id="no_wa" placeholder="Nomor Telepon (WhatsApp)">
                            <label for="no_wa" class="color-highlight">Nomor Telepon (Whatsapp)</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="mt-n2 mb-3"><?php echo form_error('no_wa') ?></div>

                        <div class="input-style has-borders validate-field mb-4">
                            <input type="text" name="no_ktp" class="form-control validate-name" value="<?php echo $no_ktp != null ? $no_ktp : set_value('no_ktp') ?>" id="no_ktp" placeholder="Nomor Identitas / KTP">
                            <label for="no_ktp" class="color-highlight">Nomor Identitas / KTP</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>

                        <div class="input-style has-borders validate-field mb-4">
                            <input type="text" name="tempat_lahir" class="form-control validate-name" value="<?php echo $tempat_lahir != null ? $tempat_lahir : set_value('tempat_lahir') ?>" id="tempat_lahir" placeholder="Tempat Lahir">
                            <label for="tempat_lahir" class="color-highlight">Tempat Lahir</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders validate-field mb-4">
                            <input type="date" name="tanggal_lahir" class="form-control validate-name" value="<?php echo $tanggal_lahir != null ? $tanggal_lahir : set_value('tanggal_lahir') ?>" id="tanggal_lahir" placeholder="Tanggal Lahir">
                            <label for="tanggal_lahir" class="color-highlight">Tanggal Lahir</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                        </div>
                        <div class="input-style has-borders no-icon mb-4">
                            <label for="jenis_kelamin" class="color-highlight">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin">
                                <option value="default" disabled selected>
                                Pilih jenis kelamin
                                </option>
                                <option value="L" <?php echo $jenis_kelamin == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?php echo $jenis_kelamin == 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                            <span><i class="fa fa-chevron-down"></i></span>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <i class="fa fa-check disabled invalid color-red-dark"></i>
                        </div>
                        <button type="submit" class="btn btn-s rounded-pill shadow-xl text-uppercase font-700 bg-highlight mb-3 mt-3">Simpan</button>
                    </form>

                
                </div>
            </div>

            <?php $this->load->view('jamaah/include/footer'); ?>
            <?php $this->load->view('jamaah/include/alert'); ?>
            <?php $this->load->view('jamaah/include/toast'); ?>
        </div>
        <!-- Page content ends here-->

        <div id="insertimageModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content rounded-m">
                    <div class="modal-header">
                        <h4 class="modal-title">Ganti Profile Anda</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 text-center">
                                <div id="image_demo" style="width:350px; margin-top:30px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn rounded btn-success crop_image">Save</button>
                        <button type="button" class="btn rounded btn-danger btn-default close"
                            data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'jamaah/menu/colors'; ?>" data-menu-height="480"></div>
    </div>


    <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquery.min.js"></script>
    <?php $this->load->view('jamaah/include/script_view'); ?>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
    <script>
        $('#agen_pic').change(function() {
            $('#target').submit();
        });
        $('.close').click(function() {
            $('#insertimageModal').modal('hide');
            location.reload();
        });
        
        $(document).ready(function() {

            $image_crop = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width: 200,
                    height: 200,
                    type: 'circle' //circle
                },
                boundary: {
                    width: 300,
                    height: 300
                }
            });

            $('#insert_image').on('change', function() {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $image_crop.croppie('bind', {
                        url: event.target.result
                    }).then(function() {
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(this.files[0]);
                $('#insertimageModal').modal('show');
            });

            $('.crop_image').click(function(event) {
                $image_crop.croppie('result', {
                    type: 'canvas',
                    size: 'viewport'
                }).then(function(response) {
                    $.ajax({
                        url: "<?php echo base_url(). 'jamaah/profile/pic_ganti' ;?>",
                        type: 'POST',
                        data: {
                            "image": response
                        },
                        success: function(data) {
                            console.log(response);
                            $('#insertimageModal').modal('hide');
                            alert(data);
                            window.location.href =
                                "<?php echo base_url(); ?>jamaah/profile/edit_profile";
                        }
                    })
                });
            });
            
        });

        $(".hapusImg").click(function() {
        if (confirm('Hapus foto profile?')) {
            var id = $(this).attr('rel');
            console.log(id);
            $.getJSON("<?php echo base_url() . 'jamaah/profile/hapus_pic'; ?>", {
                    id_user: "<?php echo $_SESSION['id_user']; ?>",
                    field: id
                })
                .done(function(json) {
                    alert('File berhasil dihapus');
                    $("#" + id).remove();
                    location.reload("<?php echo base_url().'jamaah/profile/edit_profile'?>")
                })
                .fail(function(jqxhr, textStatus, error) {
                    alert('File gagal dihapus');
                });
        }
    });

    $("#kewarganegaraan").autocomplete({
        source: "getCountries"
    });

    // Start upload preview image
    $(document).on('click', '#upload-aphoto', function() {
        document.getElementById('selectedFile').click();
    });

    $('#selectedFile').change(function() {
        if (this.files[0] == undefined)
            return;
        $('#imageModalContainer').modal('show');
        let reader = new FileReader();
        reader.addEventListener("load", function() {
            window.src = reader.result;
            $('#selectedFile').val('');
        }, false);
        if (this.files[0]) {
            reader.readAsDataURL(this.files[0]);
        }
    });

    let croppi;
    $('#imageModalContainer').on('shown.bs.modal', function() {
        let width = document.getElementById('crop-image-container').offsetWidth - 20;
        $('#crop-image-container').height((width - 80) + 'px');
        croppi = $('#crop-image-container').croppie({
            viewport: {
                width: width,
                height: width,
                type: 'circle'
            },
        });
        $('.modal-body1').height(document.getElementById('crop-image-container').offsetHeight + 50 +
            'px');
        croppi.croppie('bind', {
            url: window.src,
        }).then(function() {
            croppi.croppie('setZoom', 0);
        });
    });
    $('#imageModalContainer').on('hidden.bs.modal', function() {
        croppi.croppie('destroy');
    });

    $(document).on('click', '.save-modal', function(ev) {
        croppi.croppie('result', {
            type: 'base64',
            format: 'jpeg',
            size: 'original'
        }).then(function(resp) {
            $('#confirm-img').attr('src', resp);
            $('.modal').modal('hide');
        });
        $('#modalForm').submit();
    });
        
    </script>
</body>