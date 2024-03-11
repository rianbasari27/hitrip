<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/pictures/default/default-profile.jpg");
    }

    .image-container {
        width: 190px;
        height: 190px;
        overflow: hidden;
        margin: 0px auto 0px;
        border: 5px solid #edbd5a;
        border-radius: 100%;
        box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.2);
    }

    .image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .theme-dark .ignore {
        background-color: #F6BB42 !important;
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"> -->
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.css" />
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true]); ?>

        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['profile_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">

            <div class="content">
                <div class="image-container">
                    <?php if (empty($agen->agen_pic)) : ?>
                    <a href="<?=base_url().'asset/appkit/images/pictures/default/default-profile.jpg'?>"
                        title="Default Profile Picture" class="default-link" data-gallery="gallery-1">
                        <img src="<?php echo base_url(); ?>asset/appkit/images/pictures/default/default-profile.jpg"
                            width="40%" class="rounded-circle mx-auto shadow-xl">
                    </a>
                    <?php else : ?>
                    <a href="<?=base_url(). $agen->agen_pic?>" class="default-link" data-gallery="gallery-1">
                        <img src="<?php echo base_url() . $agen->agen_pic; ?>" width="100"
                            class="rounded-circle mx-auto shadow-xl">
                    </a>
                    <?php endif; ?>
                </div>
                <div class="container">
                    <div class="panel panel-default">
                        <div class="panel-body" align="center">
                            <br />
                            <div id="store_image"></div>
                            <div class="my-3">
                                <div class="d-flex justify-content-center align-items-center my-2">
                                    <label
                                        class="btn btn-s btn-full ignore mb-3 btn-full rounded-xl text-uppercase font-700 me-2 shadow-s bg-highlight border-highlight">
                                        <i class="fa-solid fa-pen-to-square me-2"></i>
                                        <input type="file" style="display: none;" name="insert_image" id="insert_image"
                                            accept="image/*" />
                                        <span class="text">Upload Foto</span>
                                    </label>
                                    <a rel="agen_pic" href="#"
                                        class="btn btn-s btn-border btn-full mb-3 rounded-xl text-uppercase font-700 border-highlight color-highlight bg-theme hapusImg">
                                        <i class="fa-solid fa-trash-can me-2"></i>
                                        <span class="text">Hapus Foto</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content mb-0">
                    <form action="<?php echo base_url(). 'konsultan/profile/proses_edit_profile' ;?>" method="post">
                        <input type="hidden" name="id_agen" value="<?php echo $agen->id_agen ;?>">
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="nama_agen" type="name" class="form-control validate-name"
                                value="<?php echo $agen->nama_agen ?>" id="nama" placeholder="Masukkan nama">
                            <label for="nama_agen" class="color-highlight">Nama</label>
                            <i
                                class="fa fa-check <?php echo $agen->nama_agen == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="no_ktp" type="text" class="form-control validate-name"
                                value="<?php echo $agen->no_ktp ?>" id="no_ktp" placeholder="Masukkan nomor KTP">
                            <label for="no_ktp" class="color-highlight">Nomor KTP</label>
                            <i
                                class="fa fa-check <?php echo $agen->no_ktp == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="email" type="email" class="form-control validate-name"
                                value="<?php echo $agen->email ?>" id="email" placeholder="Masukkan email">
                            <label for="email" class="color-highlight">Email</label>
                            <i
                                class="fa fa-check <?php echo $agen->email == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="no_wa" type="text" class="form-control validate-name"
                                value="<?php echo $agen->no_wa!=NULL ? $agen->no_wa : '+62' ?>" id="no_wa"
                                placeholder="Masukkan nomor WhatsApp">
                            <label for="no_wa" class="color-highlight">Nomor WhatsApp</label>
                            <i
                                class="fa fa-check <?php echo $agen->no_wa == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>

                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="tanggal_lahir" type="date" class="form-control validate-name"
                                value="<?php echo $agen->tanggal_lahir ?>" id="tanggal_lahir"
                                placeholder="Masukkan tanggal lahir">
                            <label for="tanggal_lahir" class="color-highlight">Tanggal Lahir</label>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <select id="nama_bank" name="nama_bank" class="form-control">
                                <option value="" <?php echo $agen->nama_bank == null ? 'selected' : '' ; ?>> --
                                    Pilih
                                    Nama Bank --</option>
                                <option value="BSI" <?php echo $agen->nama_bank == "BSI" ? 'selected' : '' ; ?>>
                                    BSI
                                </option>
                                <option value="BCA" <?php echo $agen->nama_bank == "BCA" ? 'selected' : '' ; ?>>
                                    BCA
                                </option>
                                <option value="MANDIRI" <?php echo $agen->nama_bank == "MANDIRI" ? 'selected' : '' ; ?>>
                                    MANDIRI</option>
                            </select>
                            <label for="nama_bank" class="color-highlight">Nama Bank</label>
                            <i
                                class="fa fa-check <?php echo $agen->nama_bank == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="no_rekening" type="number" class="form-control validate-name"
                                value="<?php echo $agen->no_rekening ?>" id="no_rekening"
                                placeholder="Masukkan nomor rekening">
                            <label for="no_rekening" class="color-highlight">Nomor Rekening</label>
                            <i
                                class="fa fa-check <?php echo $agen->no_rekening == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <select id="provinsi" name="provinsi" class="form-control">
                                <?php foreach ($provinceList as $p) { ?>
                                <option <?php echo $agen->provinsi == $p->name ? 'selected' : ''; ?>
                                    value="<?php echo $p->name; ?>" rel="<?php echo $p->id; ?>">
                                    <?php echo $p->name; ?>
                                </option>
                                <?php } ?>
                            </select>
                            <label for="provinsi" class="color-highlight">Provinsi</label>
                            <i
                                class="fa fa-check <?php echo $agen->provinsi == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <select class="form-control" name="kota" id="kota">
                                <option value="<?php echo $agen->kota; ?>" rel="">
                                    <?php echo $agen->kota; ?>
                                </option>
                            </select>
                            <label for="kota" class="color-highlight">Kabupaten / Kota</label>
                            <i
                                class="fa fa-check <?php echo $agen->kota == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <select class="form-control" name="kecamatan" id="kecamatan">
                                <option value="<?php echo $agen->kecamatan; ?>" rel="">
                                    <?php echo $agen->kecamatan; ?></option>
                            </select>
                            <label for="kecamatan" class="color-highlight">Kecamatan</label>
                            <i
                                class="fa fa-check <?php echo $agen->kecamatan == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <textarea name="alamat" id="alamat" cols="30"
                                rows="10"><?php echo $agen->alamat ;?></textarea>
                            <label for="alamat" class="color-highlight">Alamat</label>
                            <i
                                class="fa fa-check <?php echo $agen->alamat == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input class="form-control" type="text" name="kewarganegaraan" id="kewarganegaraan"
                                value="<?php echo $agen->kewarganegaraan; ?>">
                            <label for="kewarganegaraan" class="color-highlight">Kewarganegaraan</label>
                            <i
                                class="fa fa-check <?php echo $agen->kewarganegaraan == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="pekerjaan" type="text" class="form-control validate-name"
                                value="<?php echo $agen->pekerjaan ?>" id="pekerjaan" placeholder="Masukkan pekerjaan">
                            <label for="pekerjaan" class="color-highlight">Pekerjaan</label>
                            <i
                                class="fa fa-check <?php echo $agen->pekerjaan == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <input name="hobi" type="text" class="form-control validate-name"
                                value="<?php echo $agen->hobi ?>" id="hobi" placeholder="Masukkan hobi">
                            <label for="hobi" class="color-highlight">Hobi</label>
                            <i
                                class="fa fa-check <?php echo $agen->hobi == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                <option value="" <?php echo $agen->jenis_kelamin == null ? 'selected' : '' ; ?>
                                    disabled> --
                                    Pilih
                                    Jenis Kelamin --</option>
                                <option value="L" <?php echo $agen->jenis_kelamin == "L" ? 'selected' : '' ; ?>>
                                    Laki - laki
                                </option>
                                <option value="P" <?php echo $agen->jenis_kelamin == "P" ? 'selected' : '' ; ?>>
                                    Perempuan
                                </option>
                            </select>
                            <label for="jenis_kelamin" class="color-highlight">Jenis Kelamin</label>
                            <i
                                class="fa fa-check <?php echo $agen->jenis_kelamin == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                            <select id="ukuran_baju" name="ukuran_baju" class="form-control">
                                <option value="" <?php echo $agen->ukuran_baju == null ? 'selected' : '' ; ?> disabled>
                                    -- Pilih Jenis Kelamin --</option>
                                <option value="XXL" <?php echo $agen->ukuran_baju == "XXL" ? 'selected' : '' ; ?>>
                                    XXL
                                </option>
                                <option value="XL" <?php echo $agen->ukuran_baju == "XL" ? 'selected' : '' ; ?>>
                                    XL
                                </option>
                                <option value="L" <?php echo $agen->ukuran_baju == "L" ? 'selected' : '' ; ?>>
                                    L
                                </option>
                                <option value="M" <?php echo $agen->ukuran_baju == "M" ? 'selected' : '' ; ?>>
                                    M
                                </option>
                                <option value="S" <?php echo $agen->ukuran_baju == "S" ? 'selected' : '' ; ?>>
                                    S
                                </option>
                            </select>
                            <label for="ukuran_baju" class="color-highlight">Ukuran Pakaian</label>
                            <i
                                class="fa fa-check <?php echo $agen->ukuran_baju == NULL ? 'disabled ' : ''; ?>valid color-green-dark"></i>
                            <em></em>
                        </div>
                        <button type="submit"
                            class="btn btn-s btn-full mb-3 btn-full rounded-xl text-uppercase font-700 me-2 shadow-s bg-highlight">
                            <i class="fa-solid fa-check me-2"></i>Simpan
                        </button>
                    </form>
                </div>
            </div>

            <?php $this->load->view('konsultan/include/footer'); ?>
            <?php $this->load->view('konsultan/include/alert'); ?>
        </div>

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

    <?php $this->load->view('konsultan/include/script_view'); ?>
    <script>
    $('#agen_pic').change(function() {
        $('#target').submit();
    });

    $('.close').click(function() {
        $('#insertimageModal').modal('hide');
        location.reload();
    });

    $(document).ready(function() {
        var nama = $("#nama");
        var alamat = $("#alamat");
        var kwg = $("#kewarganegaraan");
        var pkj = $("#pekerjaan");
        var hobi = $("#hobi");

        nama.val(nama.val().toUpperCase());
        alamat.val(alamat.val().toUpperCase());
        kwg.val(kwg.val().toUpperCase());
        pkj.val(pkj.val().toUpperCase());
        hobi.val(hobi.val().toUpperCase());

        nama.on("input", function() {
            this.value = this.value.toUpperCase();
        });
        alamat.on("input", function() {
            this.value = this.value.toUpperCase();
        });
        kwg.on("input", function() {
            this.value = this.value.toUpperCase();
        });
        pkj.on("input", function() {
            this.value = this.value.toUpperCase();
        });
        hobi.on("input", function() {
            this.value = this.value.toUpperCase();
        });
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
                    url: "<?php echo base_url(). 'konsultan/profile/pic_ganti' ;?>",
                    type: 'POST',
                    data: {
                        "image": response
                    },
                    success: function(data) {
                        $('#insertimageModal').modal('hide');
                        alert(data);
                        window.location.href =
                            "<?php echo base_url(); ?>konsultan/profile/edit_profile";
                    }
                })
            });
        });
    });

    $("#provinsi").change(function() {
        var provId = $(this).find(":selected").attr('rel');
        $.getJSON("<?php echo base_url() . 'konsultan/profile/getRegencies' ;?>", {
            provId: provId
        }, function(data) {
            $('#kota').find('option').remove();
            $('#kecamatan').find('option').remove();
            populateDistrict(data[0]['id']);
            $(data).each(function(index, item) {
                $('#kota').append('<option value="' + item['name'] +
                    '" rel="' + item['id'] + '">' + item['name'] + '</option>');
            });
        });
    });

    $("#kota").change(function() {
        var regId = $(this).find(":selected").attr('rel');
        populateDistrict(regId);

    });

    function populateDistrict(regId) {
        $.getJSON("<?php echo base_url() . 'konsultan/profile/getDistricts' ;?>", {
            regId: regId
        }, function(data) {
            $('#kecamatan').find('option').remove();
            $(data).each(function(index, item) {
                $('#kecamatan').append('<option value="' + item['name'] + '">' + item[
                    'name'] + '</option>');
            });
        });
    }

    $(".hapusImg").click(function() {
        if (confirm('Hapus foto profile?')) {
            var id = $(this).attr('rel');
            $.getJSON("<?php echo base_url() . 'konsultan/profile/hapus_pic'; ?>", {
                    id_agen: "<?php echo $_SESSION['id_agen']; ?>",
                    field: id
                })
                .done(function(json) {
                    alert('File berhasil dihapus');
                    $("#" + id).remove();
                    location.reload("<?php echo base_url().'konsultan/profile/edit_profile'?>")
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
    // End upload preview image
    </script>
</body>

</html>