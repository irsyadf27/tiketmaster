
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Kereta
        <small>Ubah Kereta</small>
        <a href="<?php echo site_url('admin/kereta');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i> Kembali</a>
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
  <form action="<?php echo site_url('admin/kereta/ubah/' . $kereta->kode);?>" method="post" class="form-horizontal" id="form-ubah-kereta">
    <div class="row">

      <div class="col-md-6">
        <!-- Default box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Detail Kereta</h3>
          </div>
          <div class="box-body">

            <input type="hidden" name="kode" value="<?php echo $kereta->kode;?>">

            <div class="form-group <?php echo (form_error('nama')) ? 'has-error' : '';?>">
              <label for="namakt" class="col-sm-2 control-label">Nama</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="namakt" name="nama" placeholder="Nama Kereta" value="<?php echo set_value('nama', $kereta->nama); ?>">
                <?php echo (form_error('nama')) ? '<span class="help-block">' . form_error('nama') . '</span>' : '';?>
              </div>
            </div>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

      <div class="col-md-6">
        <!-- Default box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Kelas</h3>
            <button type="button" id="tambah-kelas" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i></button>
          </div>

          <div class="box-body" id="body-kelas">
          <?php
          $i = 0;
          if($kelas) {
          foreach($kelas as $k) {
          ?>
            <div class="form-group <?php echo (form_error('kelas[' . $i . ']')) ? 'has-error' : ''?>" id="kelas-<?php echo $i;?>">
              <label for="kelas" class="col-sm-2 control-label">Kelas</label>


              <div class="col-sm-9">
                <select name="kelas[]" class="form-control">
                  <option value="Ekonomi" <?php echo ($k->kelas == 'Ekonomi') ? 'selected' : ''; ?>>Ekonomi</option>
                  <option value="Bisnis" <?php echo ($k->kelas == 'Bisnis') ? 'selected' : ''; ?>>Bisnis</option>
                  <option value="Eksekutif" <?php echo ($k->kelas == 'Eksekutif') ? 'selected' : ''; ?>>Eksekutif</option>
                </select>
              </div>
              <button type="button" id="hapus-kelas" data-id="<?php echo $i;?>" class="btn btn-sm btn-danger"><i class="fa fa-close"></i></button>
            </div>

          <?php
          $i++;
          }
          }
          ?>
          <?php
          for($i=0; $i < $kelas_tambahan; $i++) {
          ?>
            <div class="form-group <?php echo (form_error('kelas[' . $i . ']')) ? 'has-error' : ''?>" id="kelas-<?php echo $i;?>">
              <label for="kelas" class="col-sm-2 control-label">Kelas</label>


              <div class="col-sm-9">
                <select name="kelas[]" class="form-control">
                  <option value="Ekonomi" <?php echo (set_value('kelas[' . $i . ']') == 'Ekonomi') ? 'selected' : ''; ?>>Ekonomi</option>
                  <option value="Bisnis" <?php echo (set_value('kelas[' . $i . ']') == 'Bisnis') ? 'selected' : ''; ?>>Bisnis</option>
                  <option value="Eksekutif" <?php echo (set_value('kelas[' . $i . ']') == 'Eksekutif') ? 'selected' : ''; ?>>Eksekutif</option>
                </select>
              </div>
              <button type="button" id="hapus-kelas" data-id="<?php echo $i;?>" class="btn btn-sm btn-danger"><i class="fa fa-close"></i></button>
            </div>

          <?php
          }
          ?>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>


    <div class="row">
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