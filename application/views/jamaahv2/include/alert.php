<div id="notification" data-dismiss="notification" data-bs-delay="3000" data-bs-autohide="true" data-isalert="<?php echo isset($_SESSION['alert']) ? 'true' : 'false'; ?>" class="notification bg-<?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['color'] : ''; ?>-dark shadow-xl opacity-95">
    <!-- <div class="toast-body color-white p-4">
        <h1 class="ms-0 ps-0 pb-2 mt-0 color-white"><?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['title'] : ''; ?></h1>
        <?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['message'] : ''; ?>
    </div> -->
    <div class="alert me-3 ms-3 rounded-s bg-green-dark" role="alert" data-isalert="<?php echo isset($_SESSION['alert']) ? 'true' : 'false'; ?>">
            <span class="alert-icon color-white"><i class="fa fa-check font-18"></i></span>
            <h4 class="color-white">Success</h4>
            <strong class="alert-icon-text color-white">Everything's okay here.</strong>
            <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
    </div>
<!-- </div> -->