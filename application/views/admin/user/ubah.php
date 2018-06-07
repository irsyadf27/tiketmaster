
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Pengguna - @<?php echo $data->username;?>
        <small>Ubah Pengguna</small>
        <a href="<?php echo site_url('admin/user/');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i> Kembali</a>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
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
    <form action="<?php echo site_url('admin/user/ubah/' . $data->id);?>" method="post" class="form-horizontal">
    <div class="row">
      <div class="col-md-6">
        <!-- Default box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Identitas Pengguna</h3>
          </div>
          <div class="box-body">

            <div class="form-group <?php echo (form_error('nama_depan')) ? 'has-error' : '';?>">
              <label for="nama_depan" class="col-sm-2 control-label">Nama Depan</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_depan" name="nama_depan" placeholder="Nama Depan" value="<?php echo set_value('nama_depan', $data->nama_depan); ?>">
                <?php echo (form_error('nama_depan')) ? '<span class="help-block">' . form_error('nama_depan') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('nama_belakang')) ? 'has-error' : '';?>">
              <label for="nama_belakang" class="col-sm-2 control-label">Nama Belakang</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="nama_belakang" name="nama_belakang" placeholder="Nama Belakang" value="<?php echo set_value('nama_belakang', $data->nama_belakang); ?>">
                <?php echo (form_error('nama_belakang')) ? '<span class="help-block">' . form_error('nama_belakang') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('no_hp')) ? 'has-error' : '';?>">
              <label for="no_hp" class="col-sm-2 control-label">No. HP</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="No. HP" value="<?php echo set_value('no_hp', $data->no_hp); ?>">
                <?php echo (form_error('no_hp')) ? '<span class="help-block">' . form_error('no_hp') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('email')) ? 'has-error' : '';?>">
              <label for="email" class="col-sm-2 control-label">Email</label>

              <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" placeholder="email" value="<?php echo set_value('email', $data->email); ?>">
                <?php echo (form_error('email')) ? '<span class="help-block">' . form_error('email') . '</span>' : '';?>
              </div>
            </div>

          </div>

        </div>
        <!-- /.box -->
      </div>

      <div class="col-md-6">
        <!-- Default box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"></h3>
          </div>
          <div class="box-body">

            <div class="form-group <?php echo (form_error('username')) ? 'has-error' : '';?>">
              <label for="username" class="col-sm-2 control-label">Username</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo set_value('username', $data->username); ?>">
                <?php echo (form_error('username')) ? '<span class="help-block">' . form_error('username') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('jenis')) ? 'has-error' : '';?>">
              <label for="jenis" class="col-sm-2 control-label">Jenis User</label>

              <div class="col-sm-10">
                <select name="jenis" class="form-control">
                  <option value="user" <?php echo (set_value('jenis', $data->jenis) == 'user') ? 'selected' : ''; ?>>User</option>
                  <option value="admin" <?php echo (set_value('jenis', $data->jenis) == 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
                <?php echo (form_error('jenis')) ? '<span class="help-block">' . form_error('no_hp') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('password')) ? 'has-error' : '';?>">
              <label for="password" class="col-sm-2 control-label">Password</label>

              <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                <span class="help-block">Kosongkan jika tidak akan diubah.</span>
                <?php echo (form_error('password')) ? '<span class="help-block">' . form_error('password') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('cpassword')) ? 'has-error' : '';?>">
              <label for="cpassword" class="col-sm-2 control-label">Konfirmasi Password</label>

              <div class="col-sm-10">
                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Konfirmasi Password">
                <?php echo (form_error('cpassword')) ? '<span class="help-block">' . form_error('cpassword') . '</span>' : '';?>
              </div>
            </div>
          </div>

        </div>
        <!-- /.box -->
      </div>
      <div class="col-md-12">

        <!-- Default box -->
        <div class="box">
          <div class="box-body">
            <button type="submit" name="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Simpan</button>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

      </div>
    </div>
    </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->