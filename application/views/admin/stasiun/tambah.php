
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Stasiun
        <small>Tambah Stasiun</small>
        <a href="<?php echo site_url('admin/stasiun/');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i> Kembali</a>
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
      <!-- Default box -->
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Tambah Stasiun</h3>
        </div>
        <form action="<?php echo site_url('admin/stasiun/tambah');?>" method="post" class="form-horizontal">
        <div class="box-body">

          <div class="form-group <?php echo (form_error('kode')) ? 'has-error' : '';?>">
            <label for="kodest" class="col-sm-2 control-label">Kode</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="kodest" name="kode" placeholder="Kode Stasiun" value="<?php echo set_value('kode'); ?>">
              <?php echo (form_error('kode')) ? '<span class="help-block">' . form_error('kode') . '</span>' : '';?>
            </div>
          </div>

          <div class="form-group <?php echo (form_error('nama')) ? 'has-error' : '';?>">
            <label for="namast" class="col-sm-2 control-label">Nama</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="namast" name="nama" placeholder="Nama Stasiun" value="<?php echo set_value('nama'); ?>">
              <?php echo (form_error('nama')) ? '<span class="help-block">' . form_error('nama') . '</span>' : '';?>
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" class="btn btn-info pull-right">Simpan</button>
        </div>
        <!-- /.box-footer -->
        </form>
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->