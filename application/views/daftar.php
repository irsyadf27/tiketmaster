<div class="container daftar">
  <div class="row row-centered">
    <br>
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
    <div class="column col-xs-8 col-md-8 animated fadeIn">
      <div class="row"><a href="index.html"><img src="<?php echo base_url('assets/img/logo.png');?>"></a></div>
      <form action="<?php echo site_url('daftar');?>" method="post">
        <div class="col-md-6" style="text-align: left;">
          <div class="form-group <?php echo (form_error('nama_depan')) ? 'has-error' : '';?>">
            <label class="control-label" for="namadepan">Nama Depan <span style="color:#B23850;">*</span></label>
            <input type="text" class="form-control" id="namadepan" name="nama_depan" placeholder="Nama Depan" value="<?php echo set_value('nama_depan'); ?>">
            <?php echo (form_error('nama_depan')) ? '<span class="help-block">' . form_error('nama_depan') . '</span>' : '';?>
          </div>
          <div class="form-group <?php echo (form_error('nama_belakang')) ? 'has-error' : '';?>">
            <label class="control-label" for="namabelakang">Nama Belakang <span style="color:#B23850;">*</span></label>
            <input type="text" class="form-control" id="namabelakang" name="nama_belakang" placeholder="Nama Belakang" value="<?php echo set_value('nama_belakang'); ?>">
            <?php echo (form_error('nama_belakang')) ? '<span class="help-block">' . form_error('nama_belakang') . '</span>' : '';?>
          </div>
          <div class="form-group <?php echo (form_error('email')) ? 'has-error' : '';?>">
            <label class="control-label" for="email">Email <span style="color:#B23850;">*</span></label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo set_value('email'); ?>">
            <?php echo (form_error('email')) ? '<span class="help-block">' . form_error('email') . '</span>' : '';?>
          </div>
          <div class="form-group <?php echo (form_error('nohp')) ? 'has-error' : '';?>">
            <label class="control-label" for="nohp">No. HP <span style="color:#B23850;">*</span></label>
            <input type="text" class="form-control" id="nohp" name="nohp" placeholder="No. HP" value="<?php echo set_value('nohp'); ?>">
            <?php echo (form_error('nohp')) ? '<span class="help-block">' . form_error('nohp') . '</span>' : '';?>
          </div>
        </div>
        <div class="col-md-6" style="text-align: left;">
          <div class="form-group <?php echo (form_error('username')) ? 'has-error' : '';?>">
            <label class="control-label" for="username">Username <span style="color:#B23850;">*</span></label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo set_value('username'); ?>">
            <?php echo (form_error('username')) ? '<span class="help-block">' . form_error('username') . '</span>' : '';?>
          </div>
          <div class="form-group <?php echo (form_error('password')) ? 'has-error' : '';?>">
            <label class="control-label" for="password">Password <span style="color:#B23850;">*</span></label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" value="<?php echo set_value('password'); ?>">
            <?php echo (form_error('password')) ? '<span class="help-block">' . form_error('password') . '</span>' : '';?>
          </div>
          <div class="form-group <?php echo (form_error('cpassword')) ? 'has-error' : '';?>">
            <label class="control-label" for="konfirmasipassword">Konfirmasi Password <span style="color:#B23850;">*</span></label>
            <input type="password" class="form-control" id="konfirmasipassword" name="cpassword" placeholder="Konfirmasi Password" value="<?php echo set_value('cpassword'); ?>">
            <?php echo (form_error('cpassword')) ? '<span class="help-block">' . form_error('cpassword') . '</span>' : '';?>
          </div>
          <div class="form-group">
            <label class="control-label"></label>
            <button type="submit" name="button" class="btn btn-login">Daftar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>