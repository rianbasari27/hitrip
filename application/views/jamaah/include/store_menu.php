<?php
if (!isset($product) && !isset($orders) && !isset($home) && !isset($cart) && !isset($jamaah)) {
    $home = true;
}
?>
<div id="footer-bar" class="footer-bar-6" style="font-size:5px;">
    <a href="<?php echo base_url(); ?>jamaah/online_store/products"
        class="<?php echo isset($product) ? 'active-nav' : ''; ?>"><i class="fa-solid fa-box"></i>
        <span>Produk</span></a>
    <a href="<?php echo base_url(); ?>jamaah/online_store/orders"
        class="<?php echo isset($orders) ? 'active-nav' : ''; ?>"><i
            class="fa-solid fa-receipt"></i><span>Pesanan</span></a>
    <a href="<?php echo base_url(); ?>jamaah/online_store"
        class="circle-nav <?php echo isset($home) ? 'active-nav' : ''; ?>"><i
            class="fa-solid fa-store"></i><span>Store</span></a>
    <a href="<?php echo base_url(); ?>jamaah/online_store/checkout" class="<?php echo isset($cart) ? 'active-nav' : ''; ?>" id="cartMenu">
        <i class="fa-solid fa-cart-shopping"></i>
        <?php if ($countCart > 0 ) { ?>
        <div class="badge font-10 font-300 ms-n2" id="totalItems"><?php echo $countCart ;?></div> <!-- Badge dengan angka notifikasi -->
        <?php } ?>
        <span>Keranjang</span>
    </a>
    <a href="<?php echo base_url(); ?>jamaah/home_user"
        class="<?php echo isset($jamaah) ? 'active-nav' : ''; ?>"><i
            class="fa-solid fa-home"></i><span>Home</span></a>
</div>