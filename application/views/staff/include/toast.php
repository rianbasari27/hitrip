<div class="toast position-absolute start-50 mt-4" style="z-index: 99;" role="alert" aria-live="assertive"
    aria-atomic="true" data-animation="true" data-delay="3000" data-autohide="true">
    <div class="toast-header">
        <span
            class="rounded-s mr-2 bg-<?php echo (isset($_SESSION['toast']['color']))? $_SESSION['toast']['color'] : '' ;?>"
            style="width: 15px;height: 15px"></span>
        <strong
            class="mr-auto"><?php echo (isset($_SESSION['toast']['header']))? $_SESSION['toast']['header'] : '' ;?></strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        <strong
            class="mr-auto"><?php echo (isset($_SESSION['toast']['body']))? $_SESSION['toast']['body'] : '' ;?></strong>
    </div>
</div>