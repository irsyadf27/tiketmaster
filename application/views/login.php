  <div class="container login">
    <div class="row row-centered">
      <div class="column col-xs-8 col-md-3 animated fadeIn" style="text-align: left;padding-top:10px">
      <?php
      if($this->session->flashdata('sukses')) { 
      echo alert_sukses($this->session->flashdata('sukses'));
      }
      if($this->session->flashdata('warning')) { 
      echo alert_warning($this->session->flashdata('warning'));
      }
      if($this->session->flashdata('error')) { 
      echo alert_error($this->session->flashdata('error'));
      }
      if($this->session->flashdata('info')) { 
      echo alert_info($this->session->flashdata('info'));
      }
      if(validation_errors()) {
      echo alert_error(validation_errors());
      }
      ?>
        <form action="<?php echo site_url('auth/login');?>" method="post">
          <div class="form-group <?php echo (form_error('username')) ? 'has-error' : '';?>">
            <label class="label-form" for="username">Username / Email <span style="color:#B23850;">*</span></label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username / Email" value="<?php echo set_value('username');?>">
            <?php echo (form_error('username')) ? '<span class="help-block">' . form_error('username') . '</span>' : '';?>
          </div>
          <div class="form-group <?php echo (form_error('password')) ? 'has-error' : '';?>">
            <label class="label-form" for="password">Password <span style="color:#B23850;">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <?php echo (form_error('password')) ? '<span class="help-block">' . form_error('password') . '</span>' : '';?>
          </div>
          <div class="form-group">
            <button type="submit" name="button" class="btn btn-login">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </div>