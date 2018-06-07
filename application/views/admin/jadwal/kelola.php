
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Jadwal - <?php echo $kereta->nama . ' (' . $kereta->kode . ')';?>
        <small>Daftar Jadwal</small>
        <a href="<?php echo site_url('admin/jadwal/');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i> Kembali</a>
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
          <h3 class="box-title">Jadwal</h3>
          <a href="<?php echo site_url('admin/jadwal/tambah/' . $kode_kereta);?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <div class="box-body">
          <input type="hidden" id="kode_kereta" value="<?php echo $kode_kereta;?>">
          <table class="table table-bordered" id="tabel-kelola-jadwal">
              <thead>
                <th width="320px">Stasiun Asal</th>
                <th width="120px">Waktu Berangkat</th>
                <th width="320px">Stasiun Tujuan</th>
                <th width="120px">Waktu Tiba</th>
                <th class="text-center" style="width: 120px;"></th>
              </thead>        
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->