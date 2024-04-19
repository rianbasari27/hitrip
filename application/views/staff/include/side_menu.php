<!-- [ Layout sidenav ] Start -->
<div id="layout-sidenav" class="layout-sidenav sidenav sidenav-vertical bg-dark">
    <div class="app-brand demo">
        <span class="app-brand-logo demo">
            <img src="<?php echo base_url() ?>asset/appkit/images/hitrip/hitrip-logogram-white.png" alt="Brand Logo"
                class="img-fluid" width="50px">
        </span>
        <a href="<?php echo base_url() ?>staff/dashboard" class="app-brand-text demo ml-2 mt-3"><img
                src="<?php echo base_url() ?>asset/appkit/images/hitrip/hitrip-logotype-white.png" width="80px"></a>
        <a href="javascript:" class="layout-sidenav-toggle sidenav-link text-large ml-auto">
            <i class="ion ion-md-menu align-middle"></i>
        </a>
    </div>
    <div class="sidenav-divider mt-0"></div>

    <!-- Links -->
    <ul class="sidenav-inner py-1">

        <!-- Dashboards -->
        <li class="sidenav-item">
            <a href="<?php echo base_url() . 'staff/dashboard' ;?>"
                class="sidenav-link <?php echo isset($dash) ? 'active' : '' ;?>">
                <i class="sidenav-icon feather icon-home"></i>
                <div>Dashboards</div>
                <div class="pl-1 ml-auto">
                    <div class="badge badge-danger">New</div>
                </div>
            </a>
        </li>

        <?php if ($_SESSION['bagian'] == "Master Admin") { ?>
        <!-- Layouts -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Product</li>
        <!-- Product elements -->
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle <?php echo isset($produk) ? 'active' : '' ;?>">
                <i class="sidenav-icon feather icon-box"></i>
                <div>Paket</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item <?php echo isset($tambah_produk) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket/tambah' ;?>" class="sidenav-link">
                        <div>Tambah Paket / Produk</div>
                    </a>
                </li>
                <li class="sidenav-item <?php echo isset($list_produk) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket' ;?>" class="sidenav-link">
                        <div>List Paket / Produk</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>

        <?php if ($_SESSION['bagian'] == "Master Admin") { ?>
        <!-- Layouts -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Manifest</li>
        <!-- Product elements -->
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle <?php echo isset($manifest) ? 'active' : '' ;?>">
                <i class="sidenav-icon feather icon-layers"></i>
                <div>Data</div>
            </a>
            <ul class="sidenav-menu">
                <!-- <li class="sidenav-item <?php echo isset($regist_user) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket' ;?>" class="sidenav-link">
                        <div>Registrasi User</div>
                    </a>
                </li> -->
                <li class="sidenav-item <?php echo isset($data_user) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/jamaah' ;?>" class="sidenav-link">
                        <div>Data User</div>
                    </a>
                </li>
                <li class="sidenav-item <?php echo isset($data_peserta) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/jamaah/data_peserta' ;?>" class="sidenav-link">
                        <div>Data Peserta</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>
        <?php if ($_SESSION['bagian'] == "Master Admin") { ?>
        <!-- Layouts -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Finance</li>
        <!-- Product elements -->
        <li class="sidenav-item">
            <a href="tables_bootstrap.html" class="sidenav-link">
                <i class="sidenav-icon feather icon-tag"></i>
                <div>Voucher / Promo</div>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle <?php echo isset($finance) ? 'active' : '' ;?>">
                <i class="sidenav-icon feather icon-credit-card"></i>
                <div>Pembayaran</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item <?php echo isset($input_bayar) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket/tambah' ;?>" class="sidenav-link">
                        <div>Input Pembayaran</div>
                    </a>
                </li>
                <li class="sidenav-item <?php echo isset($verif_bayar) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket' ;?>" class="sidenav-link">
                        <div>Verifikasi Pembayaran</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>
    </ul>
</div>
<!-- [ Layout sidenav ] End -->