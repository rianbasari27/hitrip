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


            <?php $this->load->view('staff/include/side_menu', ['bayar_store' => true]); ?>

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
                            <h1 class="h3 mb-0 text-gray-800">Set Status Pesanan
                        </div>
                        <!-- Content Row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card shadow mb-4 bg-warning text-white">
                                    <div class="card-body">
                                        <strong>Nama Pelanggan :</strong>
                                        <?php echo $nama; ?><br>
                                        <strong>Alamat :</strong> <?php echo $alamat;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='row'>
                            <?php if (!empty($_SESSION['alert_type'])) { ?>
                            <div class="alert alert-<?php echo $_SESSION['alert_type']; ?>">
                                <i class="<?php echo $_SESSION['alert_icon']; ?>"></i>
                                <?php echo $_SESSION['alert_message']; ?>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <!-- Basic Card Example -->
                                <div class="card shadow mb-4 border-left-primary">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Verifikasi</h6>
                                    </div>
                                    <div class="card-body">
                                        <form role="form"
                                            action="<?php echo base_url(); ?>staff/bayar_store/proses_set_status"
                                            method="post">
                                            <input type="hidden" name="order_id"
                                                value="<?php echo $order->order_id; ?>">
                                            <div class="form-group">
                                                <label class="col-form-label">Set Status Pesanan</label>
                                                <select class="form-control" name="status_pesanan" id="">
                                                    <option value="0" <?php echo $order->status_pesanan == 0 ? 'selected' : '' ?> >Pesanan Segera Di Siapkan</option>
                                                    <option value="1" <?php echo $order->status_pesanan == 1 ? 'selected' : '' ?> >Pesanan Sedang Di Siapkan</option>
                                                    <option value="2" <?php echo $order->status_pesanan == 2 ? 'selected' : '' ?> >Pesanan Sedang Di Kirim</option>
                                                    <option value="3" <?php echo $order->status_pesanan == 3 ? 'selected' : '' ?> >Pesanan Di Terima</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-success btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    <span class="text">Submit</span>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <!-- Basic Card Example -->
                                <?php 
                                $no = 0;
                                foreach ($list_items as $key => $list) { 
                                $no++;
                                ?>
                                    <div class="card shadow mb-4 border-left-primary">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Detail Pesanan <?php echo $no ;?></h6>
                                        </div>
                                        <div class="card-body">
                                            <p>Nama Produk: <span class="font-weight-bold"><?php echo $list->items[0]->product_name ;?></span></p>
                                            <p>Harga: <span class="font-weight-bold"><?php echo 'Rp. ' . number_format($list->items[0]->price , 0, ',', '.') . ',-';?></span></p>
                                            <p>Diskon: <span class="font-weight-bold"><?php echo 'Rp. ' . number_format($list->items[0]->discount_amount , 0, ',', '.') . ',-';?></span></p>
                                            <p>Jumlah: <span class="font-weight-bold"><?php echo $list->quantity ;?></span></p>
                                            <p>Total: <span class="font-weight-bold"><?php echo 'Rp. ' . number_format($list->amount , 0, ',', '.') . ',-' ;?></span></p>
                                        </div>
                                    </div>
                                <?php } ?>
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
</body>

</html>