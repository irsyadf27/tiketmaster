
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Kereta
        <small>Tambah Kereta</small>
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
  <form action="<?php echo site_url('admin/kereta/tambah');?>" method="post" class="form-horizontal" id="form-tambah-kereta" onsubmit="return validasi_form_kereta();">
    <div class="row">

      <div class="col-md-6">
        <!-- Default box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Detail Kereta</h3>
          </div>
          <div class="box-body">

            <div class="form-group <?php echo (form_error('kode')) ? 'has-error' : '';?>">
              <label for="kodekt" class="col-sm-2 control-label">Kode</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="kodekt" name="kode" placeholder="Kode Kereta" value="<?php echo set_value('kode'); ?>">
                <?php echo (form_error('kode')) ? '<span class="help-block">' . form_error('kode') . '</span>' : '';?>
              </div>
            </div>

            <div class="form-group <?php echo (form_error('nama')) ? 'has-error' : '';?>">
              <label for="namakt" class="col-sm-2 control-label">Nama</label>

              <div class="col-sm-10">
                <input type="text" class="form-control" id="namakt" name="nama" placeholder="Nama Kereta" value="<?php echo set_value('nama'); ?>">
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
            <div class="form-group <?php echo (form_error('kelas[0]')) ? 'has-error' : ''?>">
              <label for="kelas" class="col-sm-2 control-label">Kelas</label>


              <div class="col-sm-9">
                <select name="kelas[]" class="form-control">
                  <option value="Ekonomi" <?php echo (set_value('kelas[0]') == 'Ekonomi') ? 'selected' : ''; ?>>Ekonomi</option>
                  <option value="Bisnis" <?php echo (set_value('kelas[0]') == 'Bisnis') ? 'selected' : ''; ?>>Bisnis</option>
                  <option value="Eksekutif" <?php echo (set_value('kelas[0]') == 'Eksekutif') ? 'selected' : ''; ?>>Eksekutif</option>
                </select>
              </div>

            </div>
          <?php
          for($i=1; $i < $kelas; $i++) {
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
          <div class="box-header">
            <h3 class="box-title">Gerbong</h3>
          </div>
          <div class="box-body">

            <table class="table">
              <thead>
                <th>Nama Gerbong</th>
                <th>Kelas</th>
                <th>No. Gerbong</th>
                <th><button type="button" id="tambah-gerbong" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i></button></th>
              </thead>

              <tbody id="tabel-gerbong">
                <tr id="">
                  <td>
                    <div class="form-group <?php echo (form_error('nama_gerbong[0]')) ? 'has-error' : ''?>" id="fg-nama-gerbong-1">
                      <input type="text" class="form-control nama-gerbong" name="nama_gerbong[]" placeholder="Nama Gerbong" data-id="1" value="<?php echo set_value('nama_gerbong[0]');?>">
                      <?php echo (form_error('nama_gerbong[0]')) ? '<span class="help-block">' . form_error('nama_gerbong[0]') . '</span>' : '';?>
                    </div>
                  </td>
                  <td>
                    <select name="kelas_gerbong[]" class="form-control">
                      <option value="EKO" <?php echo (set_value('kelas_gerbong[0]') == 'EKO') ? 'selected' : ''; ?>>Ekonomi</option>
                      <option value="EKO_AC" <?php echo (set_value('kelas_gerbong[0]') == 'EKO_AC') ? 'selected' : ''; ?>>Ekonomi AC</option>
                      <option value="BIS" <?php echo (set_value('kelas_gerbong[0]') == 'BIS') ? 'selected' : ''; ?>>Bisnis</option>
                      <option value="EKS" <?php echo (set_value('kelas_gerbong[0]') == 'EKS') ? 'selected' : ''; ?>>Eksekutif</option>
                    </select>
                  </td>
                  <td>
                    <div class="form-group <?php echo (form_error('no_gerbong[0]')) ? 'has-error' : ''?>" id="fg-no-gerbong-1">
                      <input type="number" class="form-control no-gerbong" name="no_gerbong[]" value="<?php echo set_value('no_gerbong[0]');?>">
                      <?php echo (form_error('no_gerbong[0]')) ? '<span class="help-block">' . form_error('no_gerbong[0]') . '</span>' : '';?>
                    </div>
                  </td>
                  <td></td>
                </tr>


                <?php
                for($i=1; $i < $gerbong; $i++) {
                ?>
                <tr id="tr-gerbong-<?php echo $i;?>">
                  <td>
                      <div class="form-group" id="fg-nama-gerbong-<?php echo $i;?>">
                        <input type="text" class="form-control nama-gerbong" name="nama_gerbong[]" placeholder="Nama Gerbong" data-id="<?php echo $i;?>" value="<?php echo set_value('nama_gerbong[' . $i . ']');?>">
                        <?php echo (form_error('nama_gerbong[' . $i . ']')) ? '<span class="help-block">' . form_error('nama_gerbong[' . $i . ']') . '</span>' : '';?>
                      </div>
                  </td>
                  <td>
                    <select name="kelas_gerbong[]" class="form-control">
                      <option value="EKO" <?php echo (set_value('kelas_gerbong[' . $i . ']') == 'EKO') ? 'selected' : ''; ?>>Ekonomi</option>
                      <option value="EKO_AC" <?php echo (set_value('kelas_gerbong[' . $i . ']') == 'EKO_AC') ? 'selected' : ''; ?>>Ekonomi AC</option>
                      <option value="BIS" <?php echo (set_value('kelas_gerbong[' . $i . ']') == 'BIS') ? 'selected' : ''; ?>>Bisnis</option>
                      <option value="EKS" <?php echo (set_value('kelas_gerbong[' . $i . ']') == 'EKS') ? 'selected' : ''; ?>>Eksekutif</option>
                    </select>
                  </td>
                  <td>
                      <div class="form-group" id="fg-no-gerbong-<?php echo $i;?>">
                        <input type="number" class="form-control no-gerbong" name="no_gerbong[]" data-id="<?php echo $i;?>" value="<?php echo set_value('no_gerbong[' . $i . ']');?>">
                        <?php echo (form_error('no_gerbong[' . $i . ']')) ? '<span class="help-block">' . form_error('no_gerbong[' . $i . ']') . '</span>' : '';?>
                      </div>
                  </td>
                  <td>
                    <button type="button" id="hapus-gerbong" class="btn btn-sm btn-danger pull-right" data-id="<?php echo $i;?>"><i class="fa fa-close"></i></button>
                  </td>
                </tr>
                <?
                }
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
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