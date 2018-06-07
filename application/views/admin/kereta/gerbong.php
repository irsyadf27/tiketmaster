
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Kereta
        <small>Kelola Gerbong Kereta</small>
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

      <div class="col-md-12">
        <!-- Default box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Gerbong</h3>
            <button type="button" class="btn btn-sm btn-default pull-right" id="tambah-kelola-gerbong" data-toggle="modal" data-target="#modal-gerbong-kereta"><i class="fa fa-plus"></i> Tambah</button>
          </div>
          <div class="box-body">

            <table class="table" id="tabel-kelola-gerbong">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Nama Gerbong</th>
                      <th>Kelas</th>
                      <th>No. Gerbong</th>
                      <th style="width: 80px;"></th>
                  </tr>
              </thead>
              <tbody>
                <?php
                foreach($gerbong as $g) {
                ?>
                <tr>
                    <td><?php echo $g->id;?></td>
                    <td>
                      <a href="#" id="kelola-gerbong-nama-<?php echo $g->id;?>" data-type="text" data-pk="<?php echo $g->id;?>" data-url="<?php echo site_url('admin/gerbong/ubah_nama');?>" data-title="Nama Gerbong"><?php echo $g->nama;?></a> 
                      <button type="button" id="btn-kelola-gerbong-nama-<?php echo $g->id;?>" class="btn btn-sm btn-toggle-xedit" data-id="kelola-gerbong-nama-<?php echo $g->id;?>"><i class="fa fa-pencil"></i></button>
                    </td>
                    <?php
                    switch ($g->kelas) {
                      case 'EKO':
                        $kelas = 'Ekonomi';
                      break;
                      case 'EKO_AC':
                        $kelas = 'Ekonomi AC';
                      break;
                      case 'BIS':
                        $kelas = 'Bisnis';
                      break;
                      case 'EKS':
                        $kelas = 'Ekseskutif';
                      break;
                    }
                    ?>
                    <td>
                      <a href="#" id="kelola-gerbong-kelas-<?php echo $g->id;?>" data-type="select" data-pk="<?php echo $g->id;?>" data-url="<?php echo site_url('admin/gerbong/ubah_kelas');?>" data-title="Kelas Gerbong" data-value="<?php echo $g->kelas;?>" data-name="kelas"><?php echo $kelas;?></a> 
                      <button type="button" id="btn-kelola-gerbong-kelas-<?php echo $g->id;?>" class="btn btn-sm btn-toggle-xedit" data-id="kelola-gerbong-kelas-<?php echo $g->id;?>"><i class="fa fa-pencil"></i></button>
                    </td>
                    <td>
                      <a href="#" id="kelola-gerbong-no-<?php echo $g->id;?>" data-type="text" data-pk="<?php echo $g->id;?>" data-url="<?php echo site_url('admin/gerbong/ubah_nomor');?>" data-title="No. Gerbong"><?php echo $g->no_gerbong;?></a> 
                      <button type="button" id="btn-kelola-gerbong-kelas-<?php echo $g->id;?>" class="btn btn-sm btn-toggle-xedit" data-id="kelola-gerbong-no-<?php echo $g->id;?>"><i class="fa fa-pencil"></i></button>
                        
                    </td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="javascript: hapus_gerbong('<?php echo $g->id;?>');"><i class="fa fa-trash"></i> Hapus</button>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>

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

<div class="modal fade" id="modal-gerbong-kereta">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Gerbong</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('admin/gerbong/tambah/' . $kereta->kode);?>" method="post" class="form-horizontal" id="form-tambah-gerbong" onsubmit="return validasi_tambah_gerbong();">

          <div class="form-group" id="fg-nama">
            <label for="namagerbong" class="col-sm-2 control-label">Nama Gerbong</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="namagerbong" name="nama" placeholder="Nama Gerbong" maxlength="50">
            </div>
          </div>

          <div class="form-group" id="fg-kelas">
            <label for="kelasgerbong" class="col-sm-2 control-label">Kelas Gerbong</label>

            <div class="col-sm-10">
              <select name="kelas" class="form-control" id="kelasgerbong">
                <option value="EKO">Ekonomi</option>
                <option value="EKO_AC">Ekonomi AC</option>
                <option value="BIS">Bisnis</option>
                <option value="EKS">Eksekutif</option>
              </select>
            </div>
          </div>

          <div class="form-group" id="fg-no">
            <label for="nogerbong" class="col-sm-2 control-label">No. Gerbong</label>

            <div class="col-sm-10">
              <input type="number" class="form-control" id="nogerbong" name="no_gerbong" placeholder="No. Gerbong" maxlength="3">
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info pull-right"><i class="fa fa-save"></i> Simpan</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->