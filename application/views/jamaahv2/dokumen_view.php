<!DOCTYPE HTML>
<html lang="en" translate="no">

<head>
    <?php $this->load->view('jamaahv2/include/header'); ?>
    <style>
    .bg-6 {
        background-image: url("<?php echo base_url(); ?>asset/appkit/images/banner_dokumen.jpg");
    }
    </style>
</head>

<body class="theme-light">

    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        <!-- header-bar -->
        <?php $this->load->view('jamaahv2/include/header_bar'); ?>


        <!-- footer-menu -->
        <?php $this->load->view('jamaahv2/include/footer_menu', ['dokumen_nav' => true]); ?>

        <!-- header title -->
        <?php $this->load->view('jamaahv2/include/header_menu'); ?>
        <div class="page-title-clear"></div>
        <!-- Page content starts here-->
        <div class="page-content">
            <div class="card card-style">
                <div class="card mb-0 bg-6" data-card-height="150"></div>
                <div class="content mt-3">
                    <p class="color-highlight font-500 mb-n1">Data Jamaah</p>
                    <h1>Update Identitas Jamaah</h1>

                    <p class="mb-0">
                        Lengkapi identitas diri Anda Segera.
                    </p>
                </div>
            </div>
            <div class="card card-style">
                <div class="content mt-0 mb-0">
                    <div class="list-group list-custom-large">
                        <?php if (!empty($child)) { ?>
                        <?php
                            $no = 0;
                            foreach ($child as $c) {
                                $no = $no + 1;
                                if ($no > 4) {
                                    $no = 1;
                                }
                            ?>
                        <a
                            href="<?php echo base_url(); ?>jamaah/dokumen/update_data?idm=<?php echo $c->memberData->idSecretMember; ?>">
                            <?php if ($no == 1) { ?>
                            <i class="fa fa-address-card fa-2xl" style="color:orange"></i>
                            <?php } else if ($no == 2) { ?>
                            <i class="fa fa-address-card fa-2xl" style="color:red"></i>
                            <?php } else if ($no == 3) { ?>
                            <i class="fa fa-address-card fa-2xl" style="color:blue"></i>
                            <?php } else if ($no == 4) { ?>
                            <i class="fa fa-address-card fa-2xl" style="color:green"></i>
                            <?php } ?>
                            <span><?php echo $c->jamaahData->first_name . ' ' . $c->jamaahData->second_name . ' ' . $c->jamaahData->last_name; ?>

                            </span>
                            <strong>Update data diri
                                <?php echo $c->jamaahData->first_name . ' ' . $c->jamaahData->second_name . ' ' . $c->jamaahData->last_name; ?></strong>
                            <?php if ($verified == 1 && $member[0]->verified == 1) {
                                                echo '<i class="fa-regular fa-circle-check fs-5 text-success"></i>';
                                            } else {
                                                echo '<i class="fa-regular fa-circle-xmark fs-5 text-danger"></i>';
                                            }
                                        ?>

                        </a>
                        <?php } ?>
                        <?php }
                        if (empty($child)) { ?>
                        <a
                            href="<?php echo base_url(); ?>jamaah/dokumen/update_data?idm=<?php echo $member[0]->idSecretMember; ?>">
                            <i class="fa-solid fa-address-card fa-2xl color-highlight"></i>
                            <span><?php echo $first_name . ' ' . $second_name . ' ' . $last_name; ?>

                            </span>
                            <strong>Update data diri
                                <?php echo $first_name . ' ' . $second_name . ' ' . $last_name; ?></strong>
                            <?php if ($verified == 1 && $member[0]->verified == 1) {
                                        echo '<i class="fa-regular fa-circle-check fs-5 text-success"></i>';
                                    } else {
                                        echo '<i class="fa-regular fa-circle-xmark fs-5 text-danger"></i>';
                                    }
                                    ?>
                        </a>

                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="card card-style">
                <div class="content">
                    <div class="list-group list-custom-small">
                        <a href="#" data-menu="menu-video">
                            <i class="color-icon-gray fa-2xl icon-40 text-center fab fa-youtube color-red-dark"></i>
                            <span>Tutorial Update Data & Dokumen</span>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>



            <?php $this->load->view('jamaahv2/include/footer'); ?>
            <?php $this->load->view('jamaahv2/include/alert'); ?>
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
    <!-------------->
    <!-------------->
    <!--Menu Video-->
    <!-------------->
    <!-------------->
    <div id="menu-video" class="menu menu-box-modal rounded-m" data-menu-height="300" data-menu-width="350">
        <div class='responsive-iframe max-iframe'><iframe width="560" height="315"
                src="https://www.youtube-nocookie.com/embed/yr4YO1mdGnc?si=z5z0G6VNWU1eIoqR"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen></iframe></div>
        <div class="menu-title">
            <p class="color-highlight">Tutorial</p>
            <h1>Data & Dokumen</h1>
            <a href="#" class="close-menu"><i class="fa fa-times-circle"></i></a>
        </div>
    </div>

    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>asset/appkit/scripts/custom.js"></script>
</body>