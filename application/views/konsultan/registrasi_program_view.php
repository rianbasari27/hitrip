<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('konsultan/include/header'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/combobox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/jqueryui/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>asset/mycss/image-popup.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/easy_datepicker/dist/jquery.date-dropdowns.js"></script>
    <link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/easy_datepicker/demo/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/datepicker/lib/drum.css">
    <!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/jquery/jquer/y.min.js"></script> -->
    <!-- add for datepicker -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/contrib/hammerjs/hammer.fakemultitouch.js"></script>
    <script src="<?php echo base_url(); ?>asset/datepicker/lib/drum.js"></script>
    <style>
    .bg-home {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/ventour/register.png");
    }

    .capital {
        text-transform: uppercase;
    }

    /* CSS for datepicker */
    .date-picker {
        background-color: white !important;
    }

    .example {
        width: 0% !important;
        min-width: 0px !important;
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('konsultan/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('konsultan/include/footer_menu', ['home_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('konsultan/include/header_menu'); ?>
        <div class="page-title-clear"></div>

        <div class="page-content">
            <div class="card card-style bg-home" data-card-height="300">
                <div class="card-bottom ms-3 me-3">
                    <h1 class="font-30 line-height-xl color-white"><?php echo $program->nama_paket; ?></h1>
                    <p class="color-white opacity-60"><i
                            class="fa fa-plane-departure me-2"></i><?php echo date_format(date_create($program->event[0]->tanggal), 'l, j F Y'); ?>
                    </p>
                    <p class="color-white opacity-80 font-15">
                        Daftarkan Diri Anda sebagai peserta <?php echo $program->nama_paket ?>
                    </p>
                </div>
                <div class="card-overlay bg-gradient"></div>
            </div>

            <form action="<?php echo base_url(); ?>konsultan/home/proses_daftar_program" method="post" id="myForm">
                <div class="card card-style">
                    <div class="content mb-0">
                        <p class="mb-n1 color-highlight font-600 font-12">Formulir Pendaftaran</p>
                        <h4><?php echo $program->nama_paket; ?></h4>
                        <p>
                            Lengkapi formulir dibawah ini. Pastikan data diri Anda diinput dengan benar.
                        </p>
                        <?php if (isset($_SESSION['alert'])) { ?>
                        <div class="card card-style bg-pink2-light ms-0 me-0 pt-2 pb-0 rounded-0">
                            <ul class="color-white">
                                <?php echo $_SESSION['alert']['message']; ?>
                            </ul>
                        </div>
                        <?php } ?>
                        
                        <input type="hidden" name="id_agen_paket" value="<?php echo $program->id; ?>">
                        <input type="hidden" name="id_agen" value="<?php echo $agen->id_agen; ?>">
                    </div>
                </div>
                
                <!-- isi data jamaah -->
                <div class="card card-style">
                    <div class="content">
                        <h4 class="mb-3">Isi data diri</h4>
                        <div class="mt-1 mb-3">
                            <?php //f (isset($parent_id)) : ?>
                            <label class="text-danger mb-2">Notes : Jika ada tanda ( * ) diwajibkan</label>
                            <!-- <h5 class="color-highlight mb-2">Jamaah</h5> -->
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mt-4 mb-4">
                                <input name="nama_agen" type="name" class="form-control validate-name upper" id="form1"
                                    placeholder=""
                                    value="<?php echo $agen->nama_agen; ?>">
                                <label for="form1" class="color-highlight">Nama Lengkap <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="no_ktp" type="name" class="form-control validate-name upper" id="form2"
                                    placeholder=""
                                    value="<?php echo $agen->no_ktp; ?>">
                                <label for="form2" class="color-highlight">Nomor KTP</label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                            </div>
                            <div class="input-style has-borders input-style-always-active validate-field mb-4">
                                <label for="select" class="color-highlight">Jenis Kelamin<strong class="text-danger">
                                        *</strong></label>
                                <select name="jenis_kelamin" id="form-9">
                                    <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                    <option value="L" <?php echo $agen->jenis_kelamin == "L" ? 'selected':'' ;?> >LAKI-LAKI</option>
                                    <option value="P" <?php echo $agen->jenis_kelamin == "P" ? 'selected':'' ;?> >PEREMPUAN</option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
                            <div class="input-style has-borders input-style-always-active validate-field mb-4">
                                <label for="select" class="color-highlight">Ukuran Baju<strong class="text-danger">
                                        *</strong></label>
                                <select name="ukuran_baju" id="form-9">
                                    <option value="" disabled selected>-- Pilih Ukuran Baju--</option>
                                    <option value="XXL" <?php echo $agen->ukuran_baju == "XXL" ? 'selected':'' ;?> >XXL</option>
                                    <option value="XL" <?php echo $agen->ukuran_baju == "XL" ? 'selected':'' ;?> >XL</option>
                                    <option value="L" <?php echo $agen->ukuran_baju == "L" ? 'selected':'' ;?> >L</option>
                                    <option value="M" <?php echo $agen->ukuran_baju == "M" ? 'selected':'' ;?> >M</option>
                                    <option value="S" <?php echo $agen->ukuran_baju == "S" ? 'selected':'' ;?> >S</option>
                                </select>
                                <span><i class="fa fa-chevron-down"></i></span>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <i class="fa fa-check disabled invalid color-red-dark"></i>
                                <em></em>
                            </div>
                            <!-- <div class="input-style has-borders no-icon input-style-always-active validate-field mb-4">
                                <input name="ukuran_baju" type="number" class="form-control validate-name upper" id="form5"
                                    placeholder=""
                                    value="<?php echo $agen->ukuran_baju; ?>">
                                <label for="form4" class="color-highlight">Ukuran Baju <strong class="text-danger">
                                        *</strong></label>
                                <i class="fa fa-times disabled invalid color-red-dark"></i>
                                <i class="fa fa-check disabled valid color-green-dark"></i>
                                <em></em>
                            </div> -->
                        </div>
                            <a href="#" onclick="submit();"
                                    class="btn btn-full btn-m bg-highlight rounded-s font-13 font-600 mt-4">Daftar</a>
                    </div>
                </div>
            </form>

        </div>
        <!-- Page content ends here-->


        <?php $this->load->view('konsultan/include/alert-bottom'); ?>
        <?php $this->load->view('konsultan/include/script_view'); ?>
        <!-- Main Menu-->
        <div id="menu-main" class="menu menu-box-left rounded-0"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu'; ?>" data-menu-width="280"
            data-menu-active="nav-welcome"></div>

        <!-- Share Menu-->
        <div id="menu-share" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/share'; ?>" data-menu-height="370"></div>

        <!-- Colors Menu-->
        <div id="menu-colors" class="menu menu-box-bottom rounded-m"
            data-menu-load="<?php echo base_url() . 'konsultan/main_menu/colors'; ?>" data-menu-height="480"></div>
    </div>

    <!-- Modal new datepicker -->
    <div id="datepicker2"  
         class="date-picker menu menu-box-modal rounded-m" 
         data-menu-height="280" 
         data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <div class="wrapper">
                <div class="example">
                    <input type="hidden" id="example" name="tanggal">
                    <button type="button" id="set" class="close-menu btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s mt-4" style="float: right;">Pilih</button>
                </div>
            </div>
        </div>
    </div> 

    <!-- datepicker modal -->
    <div id="datepicker"  
         class="date-picker menu menu-box-modal rounded-m" 
         data-menu-height="300" 
         data-menu-width="350">
        <div class="menu-title mb-0">
            <p class="color-highlight">Registrasi</p>
            <h1>Pilih Tanggal Lahir</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
        <div class="content mt-0">
            <!-- Date picker here -->
            <div class="date_header"> 
                <span class="title">Tanggal lahir : </span><span class="selection fw-bold"></span> 
            </div>

            <form name="date">
                <div class="d-block w-full">
                    <div class="lines mb-2"></div>
                    <div class="mb-3">
                    <div class="mb-3" style="width:100%;">
                        <select class="date" id="date" name="date">
                            <?php for ($i = 1; $i <= 31; $i++) : ?>
                            <option value="<?php echo $i?>"><?php echo $i?>.</option>
                            <?php endfor; ?>
                        </select>
                        <select class="date" id="month" name="month">
                            <option value="0">Januari</option>
                            <option value="1">Februari</option>
                            <option value="2">Maret</option>
                            <option value="3">April</option>
                            <option value="4">Mei</option>
                            <option value="5">Juni</option>
                            <option value="6">Juli</option>
                            <option value="7">Agustus</option>
                            <option value="8">September</option>
                            <option value="9">Oktober</option>
                            <option value="10">November</option>
                            <option value="11">Desember</option>
                        </select>
                        <select class="date" id="fullYear" name="fullYear">
                            <?php for ($i = date('Y'); $i >= date('Y', strtotime('-100 years')); $i--) : ?>
                                <option value="<?php echo $i?>"><?php echo $i?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    </div>
                </div>
                <div class="content">
                    <button type="button" id="setTanggal" class="close-menu btn btn-full gradient-highlight font-13 btn-sm font-600 rounded-s mt-3">Pilih</button>
                </div>
            </form>
        </div>
    </div>   

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>

    <script>
    // add for datepicker
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    // end for datepicker

    // $(function () {
    //     $("#example").dateDropdowns();
    //     $('input[name="tanggal"]')
    //     .attr("type", "text")
    //     .attr("class", "selection")
    //     .attr("readonly", "readonly");
    // });

    function submit() {
        document.getElementById("myForm").submit();
    }

    $(document).ready(function() {
        // set tanggal
        // $("#set").click(function() {
        //     var sourceText = $("#example").val();
        //     $("#form7").val(sourceText);
        // });
        $("#setTanggal").click(function() {
            var sourceText = $(".selection").text();
            $("#form7").val(sourceText);
        });

        $("#form8").autocomplete({
            source: "<?php echo base_url() . 'konsultan/daftar_jamaah/getTempatLahir'; ?>"
        });

        $('.upper').on('input', function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.upper').focusout(function() {
            this.value = this.value.toLocaleUpperCase();
        });
        $('.upper').focusin(function() {
            this.value = this.value.toLocaleUpperCase();
        });

    })

    // function showOnChange(e) {
    //     var elem = document.getElementById("slct");
    //     var value = elem.options[elem.selectedIndex].value;
    //     if (value == "Agen") {
    //         document.getElementById('Agen').style.display = "block";
    //     } else {
    //         document.getElementById('Agen').style.display = "none";
    //     }
    // }
    </script>
</body>