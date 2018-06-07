
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Kereta
        <small>Daftar Kereta</small>
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
          <a href="<?php echo site_url('admin/kereta/tambah');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <div class="box-body">
          <table class="table table-bordered" id="kereta">
              <thead>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th class="text-center" style="width: 280px;"></th>
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