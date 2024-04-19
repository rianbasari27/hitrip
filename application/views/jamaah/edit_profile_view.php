<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaah/include/header'); ?>
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
                    <img src="<?php echo base_url() . 'asset/appkit/images/pictures/default/default-profile.jpg' ?>"
                    class="rounded-xl" width="100">
                </div>
                <div class="mt-3">
                    <a href="#" class="btn btn-xs d-inline-block rounded-pill shadow-xl bg-highlight">Ubah foto profile</a>
                </div>
            </div>

            <div class="card card-style">
                <div class="content mb-0">
                    <form action="<?php echo base_url() ?>jamaah/profile/edit_profile" method="post">
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
                            <input type="text" name="tempat_lahir" class="form-control validate-name" value="<?php echo $tempat_lahir != null ? $temp : set_value('temp') ?>" id="tempat_lahir" placeholder="Tempat Lahir">
                            <label for="tempat_lahir" class="color-highlight">Tempat Lahir</label>
                            <i class="fa fa-times disabled invalid color-red-dark"></i>
                            <i class="fa fa-check disabled valid color-green-dark"></i>
                            <em>(required)</em>
                        </div>
                        <div class="input-style has-borders validate-field mb-4">
                            <input type="date" name="tanggal_lahir" class="form-control validate-name" value="<?php echo $tanggal_lahir ?>" id="tanggal_lahir" placeholder="Tanggal Lahir">
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
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
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
        </div>
        <!-- Page content ends here-->


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
</body>