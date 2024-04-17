<!-- Core scripts -->
<script src="<?php echo base_url() ?>asset/bhumlu/js/pace.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/libs/popper/popper.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/js/bootstrap.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/js/sidenav.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/js/layout-helpers.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/js/material-ripple.js"></script>

<!-- Libs -->
<script src="<?php echo base_url() ?>asset/bhumlu/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/libs/eve/eve.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/libs/flot/flot.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/libs/flot/curvedLines.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/libs/chart-am4/core.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/libs/chart-am4/charts.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/libs/chart-am4/animated.js"></script>

<!-- Demo -->
<script src="<?php echo base_url() ?>asset/bhumlu/js/demo.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/js/analytics.js"></script>
<script src="<?php echo base_url() ?>asset/bhumlu/js/pages/dashboards_index.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.4/js/dataTables.js"></script>
<!-- <script src="<?php echo base_url(); ?>asset/sbadmin2/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script> -->
<?php if (isset($_SESSION['toast'])) { ?>
<script>
$('.toast').toast('show');
</script>
<?php } ?>