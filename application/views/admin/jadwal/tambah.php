
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Jadwal - <?php echo $kereta->nama . ' (' . $kereta->kode . ')';?>
        <small>Tambah Jadwal</small>
        <a href="<?php echo site_url('admin/jadwal/kelola/' . $kode_kereta);?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i> Kembali</a>
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
    <form action="<?php echo site_url('admin/jadwal/tambah/' . $kode_kereta);?>" method="post" class="form-horizontal">
      <div class="row">
        <div class="col-md-6">
          <!-- Default box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pemberangkatan</h3>
            </div>
            <div class="box-body">

              <div class="form-group <?php echo (form_error('asal')) ? 'has-error' : '';?>">
                <label for="kota-asal" class="col-sm-2 control-label">Stasiun</label>

                <div class="col-sm-10">
                  <select id="kota-asal" name="asal" data-placeholder="Stasiun Asal" class="form-control select-stasiun" style="width: 220px">
                    
                  </select>

                  <?php echo (form_error('asal')) ? '<span class="help-block">' . form_error('asal') . '</span>' : '';?>
                </div>
              </div>

              <div class="form-group <?php echo (form_error('berangkat')) ? 'has-error' : '';?>">
                <label for="waktu-berangkat" class="col-sm-2 control-label">Waktu Berangkat</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="waktu-berangkat" name="berangkat" placeholder="Waktu Berangkat" value="<?php echo set_value('berangkat'); ?>">
                  <?php echo (form_error('berangkat')) ? '<span class="help-block">' . form_error('berangkat') . '</span>' : '';?>
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
              <h3 class="box-title">Tujuan</h3>
            </div>
            <div class="box-body">

              <div class="form-group <?php echo (form_error('tujuan')) ? 'has-error' : '';?>">
                <label for="kota-tujuan" class="col-sm-2 control-label">Stasiun</label>

                <div class="col-sm-10">
                  <select id="kota-tujuan" name="tujuan" data-placeholder="Stasiun Tujuan" class="form-control select-stasiun" style="width: 220px">
                    
                  </select>
                  <?php echo (form_error('tujuan')) ? '<span class="help-block">' . form_error('tujuan') . '</span>' : '';?>
                </div>
              </div>

              <div class="form-group <?php echo (form_error('tiba')) ? 'has-error' : '';?>">
                <label for="waktu-tiba" class="col-sm-2 control-label">Waktu Tiba</label>

                <div class="col-sm-10">
                  <input type="text" class="form-control" id="waktu-tiba" name="tiba" placeholder="Nama Stasiun" value="<?php echo set_value('tiba'); ?>">
                  <?php echo (form_error('tiba')) ? '<span class="help-block">' . form_error('tiba') . '</span>' : '';?>
                </div>
              </div>

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
              <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Simpan</button>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->      </div>
    </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->