<!-- <div id="notification" data-dismiss="notification" data-bs-delay="3000" data-bs-autohide="true" data-isalert="<?php echo isset($_SESSION['alert']) ? 'true' : 'false'; ?>" class="notification bg-<?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['color'] : ''; ?>-dark shadow-xl opacity-95"> -->
    <div id="notification" data-dismiss="notification" data-bs-delay="3000" data-bs-autohide="true" data-isalert="<?php echo isset($_SESSION['alert']) ? 'true' : 'false'; ?>" class="notification alert rounded-s bg-<?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['color'] : ''; ?>-dark" role="alert" data-isalert="<?php echo isset($_SESSION['alert']) ? 'true' : 'false'; ?>">
            <span class="alert-icon color-white"><?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['icon'] : ''; ?></span>
            <h4 class="color-white"><?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['title'] : ''; ?></h4>
            <strong class="alert-icon-text color-white"><?php echo isset($_SESSION['alert']) ? $_SESSION['alert']['message'] : ''; ?></strong>
    </div>
<!-- </div> -->