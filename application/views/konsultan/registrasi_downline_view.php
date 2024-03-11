<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar', ['noBackButton' => true, 'always_show' => true]); ?>

        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['updown_nav' => true]); ?>

        <!-- header title -->
        <!-- NOT USED IN THIS PAGE -->
        <div class="page-content header-clear-medium">
            <form action="<?php echo base_url(); ?>konsultan/updown_line/proses_tambah" method="post" id="myForm" enctype="multipart/form-data">
                <div class="card card-style">
                    <div class="content">
                        <p class="mb-n1 color-highlight font-600 font-12">Formulir Pendaftaran Konsultan</p>
                        <!-- <h4><?php echo $paket->nama_paket; ?></h4> -->
                        <p>
                            Lengkapi formulir dibawah ini. Pastikan data Anda di input dengan benar.
                        </p>
                        <h4>Isi data diri Anda</h4>
                        <div class="mt-1 mb-3">
                            <?php //if (isset($parent_id)) : 
                            ?>
                            <label class="text-danger mb-4">Notes : Jika ada tanda ( * ) diwajibkan</label>
                            <div class="form-group">
                                <label class="color-highlight ms-3">Pilih Program<strong class="text-danger">
                                        *</strong></label>
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <select name="id_agen_paket" class="form-control" id="slct">
                                        <option class="color-dark-dark" value="<?php echo isset($_SESSION['form']['id_agen_paket']) ? $_SESSION['form']['id_agen_paket'] : ''; ?>" disabled selected>Pilih salah satu ... </option>
                                        <?php $n = 0;
                                        foreach ($program as $prog) {
                                            $n++; ?>
                                            <option id="<?php echo 'n' . $n; ?>" value="<?php echo $prog->id; ?>">
                                                <?php echo $prog->nama_paket; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <em><strong></strong></em>
                                </div>
                            </div>
                            <div class="mb-4 card card-style mx-0 d-none" id="detailProg">
                                <div class="content mb-0">
                                    <div id="appendFlyer"></div>
                                    <div id="appendHarga"></div>
                                    <!-- <del style="color: red;text-decoration:line-through" id="diskon">
                                        <span class="mt-1 mb-0" id="harga"></span>
                                    </del> -->
                                    <h3 id="hargaDiskon"></h3>
                                    <div id="appendDesc"></div><br>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <input type="hidden" id="id_upline" name="upline_id" value="<?php echo $agen->id_agen; ?>">
                                    <input type="text" class="form-control validate-name" placeholder="" value="<?php echo $agen->nama_agen; ?>" readonly>
                                    <label for="inputAgen" class="color-highlight">Nama Upline <strong class="text-danger">
                                            *</strong></label>
                                    <em></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <input name="nama_agen" type="name" class="form-control validate-name upper" id="form1" placeholder="" value="<?php echo isset($_SESSION['form']['nama_agen']) ? $_SESSION['form']['nama_agen'] : ''; ?>">
                                    <label for="form1" class="color-highlight">Nama Lengkap <strong class="text-danger">
                                            *</strong></label>
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <em><strong>(wajib diisi)</strong></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <a href="#" data-menu="datepicker2" class="text-dark">
                                        <input name="tanggal_lahir" type="date" class="form-control validate-name upper" id="form2" readonly value="<?php echo isset($_SESSION['form']['tanggal_lahir']) ? $_SESSION['form']['tanggal_lahir'] : ''; ?>">
                                        <label for="form2" class="color-highlight">Tanggal Lahir <strong class="text-danger">*</strong></label>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <input name="email" type="text" class="form-control validate-name upper" id="form3" placeholder="" value="<?php echo isset($_SESSION['form']['email']) ? $_SESSION['form']['email'] : ''; ?>">
                                    <label for="form3" class="color-highlight">Email <strong class="text-danger">
                                            *</strong></label>
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <em><strong>(wajib diisi)</strong></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <input name="no_wa" type="number" class="form-control validate-name upper" id="form4" placeholder="" value="<?php echo isset($_SESSION['form']['no_wa']) ? $_SESSION['form']['no_wa'] : ''; ?>">
                                    <label for="form4" class="color-highlight">No WhatsApp <strong class="text-danger">
                                            *</strong></label>
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <em><strong>(wajib diisi)</strong></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <textarea name="alamat" type="number" class="form-control validate-name upper" id="form5" placeholder="" value="<?php echo isset($_SESSION['form']['alamat']) ? $_SESSION['form']['alamat'] : ''; ?>"></textarea>
                                    <label for="form5" class="color-highlight">Alamat Lengkap <strong class="text-danger">
                                            *</strong></label>
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <em><strong>(wajib diisi)</strong></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="color-highlight ms-3">Ukuran Baju<strong class="text-danger">
                                        *</strong></label>


                                <a href="<?php echo base_url() . 'asset/images/ukuran_baju.jpeg' ?>" title="Size Chart" class="d-flex justify-content-center my-3" data-gallery="gallery-1">
                                    <img src="<?php echo base_url() . 'asset/images/ukuran_baju.jpeg' ?>" width="50%" class="rounded-sm shadow-m img-fluid">
                                </a>
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <select name="ukuran_baju" class="form-control" id="slct">
                                        <option class="color-dark-dark" value="<?php echo isset($_SESSION['form']['ukuran_baju']) ? $_SESSION['form']['ukuran_baju'] : ''; ?>" disabled selected>Pilih salah satu ... </option>
                                        <option value="XXL" <?php echo (isset($_SESSION['form']['ukuran_baju']) && $_SESSION['form']['ukuran_baju']) == 'XXL' ? 'checked' : ''; ?>>
                                            XXL</option>
                                        <option value="XL" <?php echo (isset($_SESSION['form']['ukuran_baju']) && $_SESSION['form']['ukuran_baju']) == 'XL' ? 'checked' : ''; ?>>
                                            XL</option>
                                        <option value="L" <?php echo (isset($_SESSION['form']['ukuran_baju']) && $_SESSION['form']['ukuran_baju']) == 'L' ? 'checked' : ''; ?>>
                                            L</option>
                                        <option value="M" <?php echo (isset($_SESSION['form']['ukuran_baju']) && $_SESSION['form']['ukuran_baju']) == 'M' ? 'checked' : ''; ?>>
                                            M</option>
                                        <option value="S" <?php echo (isset($_SESSION['form']['ukuran_baju']) && $_SESSION['form']['ukuran_baju']) == 'S' ? 'checked' : ''; ?>>
                                            S</option>
                                    </select>
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <em><strong></strong></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="color-highlight ms-3">Foto Diri<strong class="text-danger">
                                        *</strong></label><br>

                                <!-- <img src="<?php echo base_url() . 'asset/images/ukuran_baju.jpeg' ?>" class=""> -->
                                <!-- <div class="row"> -->
                                <a href="<?php echo base_url() . 'asset/images/foto_diri.jpeg' ?>" title="Foto Diri" class="d-flex justify-content-center my-3" data-gallery="gallery-1">
                                    <img src="<?php echo base_url() . 'asset/images/foto_diri.jpeg' ?>" width="50%" class="rounded-sm shadow-m img-fluid">
                                </a>
                                <!-- </div> -->
                                <div class="card card-style mx-0 shadow-none p-2">
                                    <input class="form-control border-none rounded-xs mb-3" type="file" name="foto_diri">
                                    <input class="form-control border-none rounded-xs" type="file" name="foto_diri2">
                                </div>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                    <input name="no_ktp" type="text" class="form-control validate-name upper" id="form6" placeholder="" value="<?php echo isset($_SESSION['form']['no_ktp']) ? $_SESSION['form']['no_ktp'] : ''; ?>">
                                    <label for="form6" class="color-highlight">No KTP <strong class="text-danger">
                                            *</strong></label>
                                    <i class="fa fa-times disabled invalid color-red-dark"></i>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <em><strong>(wajib diisi)</strong></em>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-style has-borders input-style-always-active validate-field mb-4">
                                    <label for="select" class="color-highlight">Jenis Kelamin <strong class="text-danger">
                                            *</strong></label>
                                    <select name="jenis_kelamin" id="form-9">
                                        <option class="color-dark-dark" value="" disabled selected>-- Pilih Jenis
                                            Kelamin --
                                        </option>
                                        <option class="color-dark-dark" value="L" <?php echo (isset($_SESSION['form']['jenis_kelamin']) && $_SESSION['form']['jenis_kelamin']) == 'L' ? 'checked' : ''; ?>>
                                            LAKI-LAKI</option>
                                        <option class="color-dark-dark" value="P" <?php echo (isset($_SESSION['form']['jenis_kelamin']) && $_SESSION['form']['jenis_kelamin']) == 'P' ? 'checked' : ''; ?>>
                                            PEREMPUAN</option>
                                    </select>
                                    <span><i class="fa fa-chevron-down"></i></span>
                                    <i class="fa fa-check disabled valid color-green-dark"></i>
                                    <i class="fa fa-check disabled invalid color-red-dark"></i>
                                    <em></em>
                                </div>
                            </div>
                        </div>
                        <a href="#" id="submit" class="btn btn-full btn-m bg-highlight rounded-s font-13 font-600 mt-4">Berikutnya</a>
                    </div>
                </div>
            </form>
        </div>
        <!-- Page content ends here-->
        <?php $this->load->view('konsultan/include/alert-bottom'); ?>
        <?php $this->load->view('konsultan/include/script_view'); ?>
        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0" data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280" data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m" data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <!-- Modal new datepicker -->
    <div id="datepicker2" class="date-picker menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="date_header mb-3">
                <span class="title">Tanggal lahir : </span>
                <div class="fw-bold fs-5" id="tanggalLahir"><span id="tahun">0000</span>-<span id="bulan">00</span>-<span id="tanggal">00</span></div>
            </div>
            <div class="row">
                <div class="col-3">
                    Tanggal
                    <input name="tanggal" type="number" class="form-control rounded fs-5 shadow" id="tanggalInput">
                </div>
                <div class="col-5">
                    Bulan
                    <select name="bulan" class="form-control rounded fs-5 shadow" id="bulanInput">
                        <option value="00" selected></option>
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col">
                    Tahun
                    <input type="number" class="form-control rounded fs-5 shadow" id="tahunInput">
                </div>
            </div>
            <button type="button" id="set" class="close-menu btn btn-sm gradient-highlight font-13 btn-sm font-600 rounded-s" style="float: right;">Pilih</button>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
    <script src="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            // $('#n1').on('click', function() {
            //     console.log('a');
            // });

            $('#slct').change(function() {
                var selected = $(this).val();
                if (selected != null) {
                    $("#detailProg").removeClass('d-none');
                }
                var paket = [];
                $.getJSON("<?php echo base_url() . 'konsultan/updown_line/get_paket' ?>", {
                        term: selected,
                    })
                    .done(function(data) {
                        var namaPaket = data['nama_paket'];
                        var harga = data['hargaPretty'];
                        var diskon = data['diskon_member_baru'];
                        var hargaDiskon = data['hargaPrettyDiskon'];
                        var pax = data['pax'];
                        var tanggal = data['tanggalFormat'];
                        var exJamaah = data['diskon_eks_jamaah'];
                        var discExJamaah = data['hargaEksJamaahPretty'];
                        var descExJamaah = data['deskripsi_diskon_eks_jamaah'];
                        var flyer = data['agen_paket_flyer'];

                        if (flyer != null) {
                            $('#flyer').remove()
                            var base_url = "<?php echo base_url(); ?>"
                            var html = "<a href='" + base_url + flyer + "' title='Flyer Image' class='d-flex justify-content-center my-3' data-gallery='gallery-1' id='flyer'>\n";
                            html += "<img src='" + base_url + flyer + "' width='50%' class='rounded-sm shadow-m img-fluid'>\n";
                            html += "</a>";

                            $('#appendFlyer').append(html)
                        } else {
                            $('#flyer').remove()
                        }

                        if (diskon == 0) {
                            document.getElementById('hargaDiskon').innerText = harga;
                            $('#diskon').remove()
                        } else {
                            $('#appendHarga').append('<del style="color:red;text-decoration:line-through" id="diskon"><span class="mt-1 mb-0" id="harga"></span></del>')
                            document.getElementById('harga').innerText = harga;
                            document.getElementById('hargaDiskon').innerText = hargaDiskon;
                        }

                        if (exJamaah != 0) {
                            $('#desc').remove();
                            $('#appendDesc').append('<span id="desc">' + descExJamaah + ' ' + discExJamaah + '</span>')
                        } else {
                            $('#desc').remove();
                        }

                        // $.each(data, function(idx, d) {
                        // let label = d.nama_paket;
                        // let name = {
                        //     "namaPaket": namaPaket,
                        //     "harga": harga,
                        //     "tanggal": tanggal,
                        // };
                        // paket.push(name);
                        // });
                    });
                // console.log(paket[1]);
            })

            // async function getPaket(request) {
            //     var paket = [];
            //     await $.getJSON("<?php echo base_url() . 'konsultan/daftar_konsultan/get_paket' ?>",
            //             request)
            //         .done(function(data) {
            //             console.log(data);
            //             $.each(data, function(idx, d) {
            //                 let label = d.nama_agen + " (" + d.no_agen + ")";
            //                 let name = {
            //                     "label": label,
            //                     "value": d.id_agen
            //                 };
            //                 agenNames.push(name);
            //             });
            //         });
            //     return agenNames;
            // }


            $("#submit").on("click", function(event) {
                event.preventDefault();
                //check apakah id_upline kosong
                const agenData = $("#id_upline").val();
                if (agenData === "") {
                    alert("Pilih Konsultan dari Pop Up Menu!");
                    $("#inputAgen").val("");
                } else {
                    $("#myForm").submit();
                }
            });
            $("#inputAgen").on("keyup paste", function(event) {
                const selectionKeys = [38, 39, 40, 13];
                if (selectionKeys.includes(event.which) === false) {
                    $("#id_upline").val('');
                }
            });
            $("#inputAgen").autocomplete({
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
                await $.getJSON("<?php echo base_url() . 'konsultan/daftar_konsultan/agen_autocomplete' ?>",
                        request)
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

            // Limit input tanggal hanya 2 digit
            $("#tanggalInput").on("input", function() {
                var inputValue = $(this).val();
                if (inputValue.length > 2) {
                    $(this).val(inputValue.slice(0, 2));
                }
            });
            // Limit input tahun hanya 2 digit
            $("#tahunInput").on("input", function() {
                var inputValue = $(this).val();
                if (inputValue.length > 4) {
                    $(this).val(inputValue.slice(0, 4));
                }
            });

            function updateTanggal() {
                var tanggalInput = $('#tanggalInput').val();
                if (tanggalInput > 31) {
                    $('#tanggalInput').val(31);
                    tanggalInput = 31;
                }
                var formattedTanggal = (tanggalInput < 10) ? '0' + tanggalInput : tanggalInput;
                if (tanggalInput < 10) {
                    formattedTanggal = '0' + tanggalInput
                } else {
                    formattedTanggal = tanggalInput
                }
                if (tanggalInput.substr(0, 1) == '0') {
                    formattedTanggal = tanggalInput
                }
                if (tanggalInput == '' || tanggalInput == '00') {
                    formattedTanggal = '00'
                }
                $('#tanggal').text(formattedTanggal);
            }

            function updateBulan() {
                var bulanInput = $('#bulanInput').val();
                $('#bulan').text(bulanInput);
            }

            function updateTahun() {
                var tahunInput = $('#tahunInput').val();
                const date = new Date();
                let yearNow = date.getFullYear();
                if (tahunInput > yearNow) {
                    $('#tahunInput').val(yearNow);
                    tahunInput = yearNow.toString();
                }
                if (tahunInput < 10) {
                    formattedTahun = '000' + tahunInput
                } else if (tahunInput < 100) {
                    formattedTahun = '00' + tahunInput
                } else if (tahunInput < 1000) {
                    formattedTahun = '0' + tahunInput
                } else if (tahunInput.substr(0, 1) == 0) {
                    formattedTahun = tahunInput
                } else {
                    formattedTahun = tahunInput
                }

                if (tahunInput == '' ||
                    tahunInput == '00' ||
                    tahunInput == '000' ||
                    tahunInput == '0000') {
                    formattedTahun = '0000'
                }

                $('#tahun').text(formattedTahun);
            }

            $('#tanggalInput').on('input', updateTanggal);
            $('#bulanInput').on('input', updateBulan);
            $('#tahunInput').on('input', updateTahun);

            updateTanggal();
            updateBulan();
            updateTahun();

            // set tanggal
            $("#set").click(function() {
                var tanggal = $('#tanggal').text();
                var bulan = $('#bulan').text();
                var tahun = $('#tahun').text();
                // Bulan yang cuma punya 30 hari
                if (bulan == '02' ||
                    bulan == '04' ||
                    bulan == '06' ||
                    bulan == '09' ||
                    bulan == '11'
                ) {
                    if (tanggal == '31') {
                        alert('Tanggal tidak valid!')
                        return;
                    }
                }
                //Khusus bulan Februari
                if (bulan == '02') {
                    if (tanggal > 29) {
                        alert('Tanggal tidak valid!')
                        return;
                    }
                    // Pengaturan hari pada tahun kabisat
                    if (tahun % 4 != 0) {
                        if (tanggal > 28) {
                            alert('Tanggal tidak valid!')
                            return;
                        }
                    }
                }
                if (tahun == '0000') {
                    alert('Tahun tidak valid!')
                    return;
                }
                if (bulan == '00') {
                    alert('Bulan tidak valid!')
                    return;
                }
                if (tanggal == '00') {
                    alert('Tanggal tidak valid!')
                    return;
                }
                if (tahun < '1850') {
                    alert('Tahun sudah terlalu lama!')
                    return;
                }
                var sourceText = $("#tanggalLahir").text();
                $("#form2").val(sourceText);
            });
        });
    </script>
</body>