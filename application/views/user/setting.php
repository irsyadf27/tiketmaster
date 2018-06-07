    <!--Form Booking-->
    <div class="container con-login">
      <div class="row row-centered animated fadeIn row-login">

        <h4>Pengaturan Akun</h4>

      </div>
      <div class="row row-centered default-row animated fadeIn">
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
        <form class="form-horizontal" method="POST">
        <div class="column col-md-6 col-pad akun">
            <div class="form-group">
              <label for="username" class="control-label col-xs-3">Username</label>
              <div class="col-xs-8">
                <input type="text" class="form-control" id="username" placeholder="Username" value="<?php echo $user->username;?>" readonly="true">
              </div>
            </div>
            <div class="form-group <?php echo (form_error('nama_depan')) ? 'has-error' : '';?>">
              <label for="namadepan" class="control-label col-xs-3">Nama Depan</label>
              <div class="col-xs-8">
                <input type="text" class="form-control" id="namadepan" placeholder="Nama Depan" name="nama_depan" value="<?php echo set_value('nama_depan', $user->nama_depan);?>">
                <?php echo (form_error('nama_depan')) ? '<span class="help-block">' . form_error('nama_depan') . '</span>' : '';?>
              </div>
            </div>
            <div class="form-group <?php echo (form_error('nama_belakang')) ? 'has-error' : '';?>">
              <label for="namabelakang" class="control-label col-xs-3">Nama Belakang</label>
              <div class="col-xs-8">
                <input type="text" class="form-control" id="namabelakang" placeholder="Nama Belakang" name="nama_belakang" value="<?php echo set_value('nama_belakang', $user->nama_belakang);?>">
                <?php echo (form_error('nama_belakang')) ? '<span class="help-block">' . form_error('nama_belakang') . '</span>' : '';?>
              </div>
            </div>
            <div class="form-group <?php echo (form_error('email')) ? 'has-error' : '';?>">
              <label for="email" class="control-label col-xs-3">Email</label>
              <div class="col-xs-8">
                <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo set_value('email', $user->email);?>">
                <?php echo (form_error('email')) ? '<span class="help-block">' . form_error('email') . '</span>' : '';?>
              </div>
            </div>
            <div class="form-group <?php echo (form_error('no_hp')) ? 'has-error' : '';?>">
              <label for="nohp" class="control-label col-xs-3">No. HP</label>
              <div class="col-xs-8">
                <input type="text" class="form-control" id="nohp" placeholder="No. HP" name="no_hp" value="<?php echo set_value('no_hp', $user->no_hp);?>">
                <?php echo (form_error('no_hp')) ? '<span class="help-block">' . form_error('no_hp') . '</span>' : '';?>
              </div>
            </div>
        </div>
        <div class="column col-md-4 col-pad akun">
            <div class="form-group <?php echo (form_error('pass_lama')) ? 'has-error' : '';?>">
              <label for="passlama" class="control-label col-xs-3">Password Lama</label>
              <div class="col-xs-8">
                <input type="password" class="form-control" id="passlama" placeholder="Password Lama" name="pass_lama">
                <?php echo (form_error('pass_lama')) ? '<span class="help-block">' . form_error('pass_lama') . '</span>' : '';?>
              </div>
            </div>
            <div class="form-group <?php echo (form_error('pass_baru')) ? 'has-error' : '';?>">
              <label for="passbaru" class="control-label col-xs-3">Password Baru</label>
              <div class="col-xs-8">
                <input type="password" class="form-control" id="passbaru" placeholder="Password Baru" name="pass_baru">
                <?php echo (form_error('pass_baru')) ? '<span class="help-block">' . form_error('pass_baru') . '</span>' : '';?>
              </div>
            </div>
            <div class="form-group <?php echo (form_error('konf_pass_baru')) ? 'has-error' : '';?>">
              <label for="konfpassbaru" class="control-label col-xs-3">Konfirmasi Password Baru</label>
              <div class="col-xs-8">
                <input type="password" class="form-control" id="konfpassbaru" placeholder="Konfirmasi Password Baru" name="konf_pass_baru">
                <?php echo (form_error('konf_pass_baru')) ? '<span class="help-block">' . form_error('konf_pass_baru') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group">
              <div class="control-label col-xs-offset-3 col-xs-8">
                <button type="submit" class="btn btn-login">Ubah</button>
              </div>
            </div>
        </div>
        </form>

      </div>
    </div>