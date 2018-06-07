
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Stasiun
        <small>Daftar Stasiun</small>
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
          <a href="<?php echo site_url('admin/stasiun/tambah');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        <div class="box-body">
          <table class="table table-bordered" id="stasiun">
              <thead>
                <th>Kode</th>
                <th>Nama</th>
                <th class="text-center" style="width: 180px;"></th>
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

<div class="modal fade" id="modal-ubah-stasiun">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ubah Stasiun</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('admin/stasiun/ubah');?>" method="post" class="form-horizontal" id="form-ubah-stasiun">

          <div class="form-group">
            <label for="namast" class="col-sm-2 control-label">Nama</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="namast" name="nama" placeholder="Nama Stasiun" maxlength="50">
              <input type="hidden" name="kode" id="kodest">
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info pull-right">Simpan</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->