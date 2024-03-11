<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url(); ?>home">

    <div class="sidebar-brand-icon">
        Umroh System
    </div>
    <!--<div class="sidebar-brand-text mx-3">Ventour Management App</div>-->
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="<?php echo base_url(); ?>home">
        <i class="fas fa-fw fa-home"></i>
        <span>Home</span></a>
    <a class="nav-link" href="<?php echo base_url(); ?>detail_program">
        <i class="fas fa-fw fa-archive"></i>
        <span>Lihat Detail Program</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Anggota Keluarga
</div>

<?php $this->load->model('registrasi'); ?>
<?php $family = $this->registrasi->getGroupMembers($_SESSION['id_member']); ?>
<?php if (!empty($family)) { ?>
    <?php foreach ($family as $f) { ?>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url().'home?id='.$f->memberData->id_member; ?>">
                <i class="fas fa-fw fa-arrow-right"></i>
                <span style='text-align: justify'><?php echo $f->jamaahData->first_name . ' ' . $f->jamaahData->second_name . ' ' . $f->jamaahData->last_name; ?></span></a>
        </li>
    <?php } ?>

<?php } ?>
<li class="nav-item active">
    <a class="nav-link" href="<?php echo base_url()."daftar?parent=".$_SESSION['id_member']; ?>">
        <i class="fas fa-fw fa-plus"></i>
        <span style='text-align: justify'>Daftarkan Keluarga Anda (klik disini!)</span></a>
</li>
<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->

