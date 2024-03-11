<?php if (isset($_SESSION['alert'])) { ?>

    <a href="#" id="warning-button" data-menu="menu-warning"></a>
    <?php if ($_SESSION['alert']['color'] == 'red') { ?>
        <div id="menu-warning" class="menu menu-box-bottom bg-red-dark rounded-m" data-menu-height="400" data-menu-effect="menu-over">
            <h1 class="text-center mt-4"><i class="fa fa-3x fa-times-circle scale-box color-white shadow-xl rounded-circle"></i></h1>
            <h1 class="text-center mt-3 text-uppercase color-white font-700"><?php echo $_SESSION['alert']['title']; ?></h1>
            <div class="boxed-text-l color-white mb-3">
                <?php echo $_SESSION['alert']['message']; ?>
            </div>
            <a href="#" class="close-menu btn btn-m btn-center-l button-s shadow-l rounded-s text-uppercase font-600 bg-white color-black">Hmmm, Cek Lagi?</a>
        </div>
    <?php } ?>
    <?php if ($_SESSION['alert']['color'] == 'green') { ?>
        <div id="menu-success-2" class="menu menu-box-bottom bg-green-dark rounded-m" data-menu-height="335" data-menu-effect="menu-over">
            <h1 class="text-center mt-4"><i class="fa fa-3x fa-check-circle scale-box color-white shadow-xl rounded-circle"></i></h1>
            <h1 class="text-center mt-3 font-700 color-white"><?php echo $_SESSION['alert']['title']; ?></h1>
            <div class="boxed-text-l color-white mb-3">
                <?php echo $_SESSION['alert']['message']; ?>
            </div>
            <a href="#" class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-600 bg-white color-black">Siap, Terimakasih!</a>
        </div>
    <?php } ?>
    <?php if ($_SESSION['alert']['color'] == 'merah') { ?>
        <div id="menu-warning" class="menu menu-box-bottom bg-red-dark rounded-m" data-menu-height="400" data-menu-effect="menu-over">
            <h1 class="text-center mt-4"><i class="fa fa-3x fa-times-circle scale-box color-white shadow-xl rounded-circle"></i></h1>
            <h1 class="text-center mt-3 text-uppercase color-white font-700"><?php echo $_SESSION['alert']['title']; ?></h1>
            <div class="boxed-text-l color-white mb-3">
                <?php echo $_SESSION['alert']['message']; ?>
            </div>
            <a href="#" class="close-menu btn btn-m btn-center-l button-s shadow-l rounded-s text-uppercase font-600 bg-white color-black">Oke</a>
        </div>
    <?php } ?>
<?php } ?>