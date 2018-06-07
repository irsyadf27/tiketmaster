  <!-- JS -->
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/plugins/pnotify/dist/pnotify.custom.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/notif.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/plugins/moment-2.20.1/min/moment.min.js'); ?>"></script>
  <?php
  if(isset($js)) {
    foreach($js as $j) {
      echo '<script type="text/javascript" src="' . base_url($j) . '"></script>';
    }
  }
  ?>
  <script type="text/javascript" src="<?php echo base_url('assets/js/main2.js'); ?>"></script>
</body>

</html>