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
            <a href="javascript:" class="sidenav-link sidenav-toggle <?php echo isset($produk) ? 'active' : '' ;?>">
                <i class="sidenav-icon feather icon-box"></i>
                <div>Data</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item <?php echo isset($tambah_produk) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket/tambah' ;?>" class="sidenav-link">
                        <div>Data User</div>
                    </a>
                </li>
                <li class="sidenav-item <?php echo isset($list_produk) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket' ;?>" class="sidenav-link">
                        <div>Registrasi User</div>
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
            <a href="javascript:" class="sidenav-link sidenav-toggle <?php echo isset($produk) ? 'active' : '' ;?>">
                <i class="sidenav-icon feather icon-box"></i>
                <div>Pembayaran</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item <?php echo isset($tambah_produk) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket/tambah' ;?>" class="sidenav-link">
                        <div>Input Pembayaran</div>
                    </a>
                </li>
                <li class="sidenav-item <?php echo isset($list_produk) ? 'active' : '' ;?>">
                    <a href="<?php echo base_url() . 'staff/paket' ;?>" class="sidenav-link">
                        <div>Verifikasi Pembayaran</div>
                    </a>
                </li>
            </ul>
        </li>
        <?php } ?>

        <!-- Forms & Tables -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Forms & Tables</li>
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon feather icon-clipboard"></i>
                <div>Forms</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="forms_layouts.html" class="sidenav-link">
                        <div>Layouts and elements</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="forms_input-groups.html" class="sidenav-link">
                        <div>Input groups</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidenav-item">
            <a href="tables_bootstrap.html" class="sidenav-link">
                <i class="sidenav-icon feather icon-grid"></i>
                <div>Tables</div>
            </a>
        </li>

        <!--  Icons -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Icons</li>
        <li class="sidenav-item">
            <a href="javascript:" class="sidenav-link sidenav-toggle">
                <i class="sidenav-icon feather icon-feather"></i>
                <div>Icons</div>
            </a>
            <ul class="sidenav-menu">
                <li class="sidenav-item">
                    <a href="icons_feather.html" class="sidenav-link">
                        <div>Feather</div>
                    </a>
                </li>
                <li class="sidenav-item">
                    <a href="icons_linearicons.html" class="sidenav-link">
                        <div>Linearicons</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Pages -->
        <li class="sidenav-divider mb-1"></li>
        <li class="sidenav-header small font-weight-semibold">Pages</li>
        <li class="sidenav-item">
            <a href="pages_authentication_login-v1.html" class="sidenav-link">
                <i class="sidenav-icon feather icon-lock"></i>
                <div>Login</div>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="pages_authentication_register-v1.html" class="sidenav-link">
                <i class="sidenav-icon feather icon-user"></i>
                <div>Signup</div>
            </a>
        </li>
        <li class="sidenav-item">
            <a href="pages_faq.html" class="sidenav-link">
                <i class="sidenav-icon feather icon-anchor"></i>
                <div>FAQ</div>
            </a>
        </li>
    </ul>
</div>
<!-- [ Layout sidenav ] End -->