
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Slideshow
        <small>Tambah Slideshow</small>
        <a href="<?php echo site_url('admin/slideshow/');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i> Kembali</a>
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
    <form action="<?php echo site_url('admin/slideshow/tambah');?>" method="post" class="form-horizontal" enctype="multipart/form-data">
    <div class="row">
      <div class="col-md-12">
        <!-- Default box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Slideshow</h3>
          </div>
          <div class="box-body">

            <div class="form-group <?php echo (form_error('judul')) ? 'has-error' : '';?>">
              <label for="judul" class="col-sm-2 control-label">Judul</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" value="<?php echo set_value('judul'); ?>">
                <?php echo (form_error('judul')) ? '<span class="help-block">' . form_error('judul') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('deskripsi')) ? 'has-error' : '';?>">
              <label for="deskripsi" class="col-sm-2 control-label">Deskripsi <small>(optional)</small></label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" value="<?php echo set_value('deskripsi'); ?>">
                <?php echo (form_error('deskripsi')) ? '<span class="help-block">' . form_error('deskripsi') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('gambar')) ? 'has-error' : '';?>">
              <label for="gambar" class="col-sm-2 control-label">Gambar</label>

              <div class="col-sm-10">
                <input type="file" id="gambar" name="gambar">
                <?php echo (form_error('gambar')) ? '<span class="help-block">' . form_error('gambar') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('tampil')) ? 'has-error' : '';?>">
              <label for="tampil" class="col-sm-2 control-label">Tampil</label>

              <div class="col-sm-10">
                  <div class="radio">
                    <label>
                      <input type="radio" name="tampil" id="tampil" value="Y" <?php echo (set_value('tampil', 'Y') == 'Y') ? 'checked' : ''; ?>>
                      Ya
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="tampil" id="tampil" value="T" <?php echo (set_value('tampil') == 'T') ? 'checked' : ''; ?>>
                      Tidak
                    </label>
                  </div>
              </div>
            </div>

          </div>
          <div class="box-footer">
            <button type="submit" name="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Simpan</button>
          </div>
        </div>
        <!-- /.box -->
      </div>
    </div>
    </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->