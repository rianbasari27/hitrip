<div id="toast-2" 
    class="toast toast-tiny toast-top 
    <?php if (isset($_SESSION['toast'])) { ?> 
        <?php if ($_SESSION['toast']['color'] == 'green') { ?> 
            bg-green-dark
        <?php } else { ?>
            bg-red-dark
        <?php } ?>
    <?php } ?>
    font-700" 
    style="width: max-content !important; padding: 0px 15px !important;" 
    data-bs-delay="3000" 
    data-bs-autohide="true">
    <?php echo isset($_SESSION['toast']) ? $_SESSION['toast']['icon'] : ''; ?><?php echo isset($_SESSION['toast']) ? $_SESSION['toast']['message'] : ''; ?>
</div>