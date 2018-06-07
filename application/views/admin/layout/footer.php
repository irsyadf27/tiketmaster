
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<!-- Datatables -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js'); ?>"></script>
<!-- Sweetalert -->
<script type="text/javascript" src="<?php echo base_url('assets/plugins/sweetalert2-6.10.3/sweetalert2.min.js'); ?>"></script>
<!-- AdminLTE App -->
<script type="text/javascript" src="<?php echo base_url('assets/admin/dist/js/adminlte.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/pnotify/dist/pnotify.custom.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/notif.js'); ?>"></script>

<?php
if(isset($js)) {
  foreach($js as $j) {
    echo '<script type="text/javascript" src="' . base_url($j) . '"></script>';
  }
}
?>
<script type="text/javascript" src="<?php echo base_url('assets/admin/main.js'); ?>"></script>
</body>
</html>