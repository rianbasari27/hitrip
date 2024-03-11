<div id="notification" data-dismiss="notification" data-bs-delay="3000" data-bs-autohide="true" data-isalert="<?php echo isset($_SESSION['alert']) ? 'true' : 'false'; ?>" class="notification bg-<?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['color'] : ''; ?>-dark shadow-xl opacity-95">
    <div class="toast-body color-white p-4">
        <h1 class="ms-0 ps-0 pb-2 mt-0 color-white"><?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['title'] : ''; ?></h1>
        <?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['message'] : ''; ?>
    </div>
</div>