
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Slideshow
        <small>Daftar Slideshow</small>
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
          <a href="<?php echo site_url('admin/slideshow/tambah');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="slideshow">
                <thead>
                  <th style="width: 220px">Judul</th>
                  <th style="width: 220px">Deskripsi</th>
                  <th style="width: 180px">Tampil</th>
                  <th style="width: 180px">Gambar</th>
                  <th class="text-center" style="width: 180px;"></th>
                </thead>        
            </table>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->