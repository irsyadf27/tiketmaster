
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelola Pemesanan
        <small>Detail Pemesanan</small>
        <a href="<?php echo site_url('admin/pemesanan/');?>" class="btn btn-sm btn-default pull-right"><i class="fa fa-chevron-left"></i> Kembali</a>
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
    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Detail Pemesan</h3>
          </div>
          <div class="box-body">
            <input type="hidden" id="id_pemesanan" value="<?php echo $pemesanan->id;?>">
            <b>Username:</b> @<?php echo $pemesan->username;?><br>
            <b>Nama Pemesan:</b> <?php echo $pemesan->nama_depan . ' ' . $pemesan->nama_belakang;?><br>
            <b>Email:</b> <?php echo $pemesan->email;?><br>
            <b>No. HP:</b> <?php echo $pemesan->no_hp;?>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Detail Kereta</h3>
          </div>
          <div class="box-body">
              <div class="col-md-9">
              <?php 
              $tgl_berangkat = new DateTime($detail_kereta->tanggal . ' ' . $detail_kereta->waktu_berangkat);
               

              $tgl_tiba = new DateTime($detail_kereta->tanggal . ' ' . $detail_kereta->waktu_tiba);

              if($tgl_berangkat->diff($tgl_tiba)->invert != 0) {
                $tgl_tiba->add(new DateInterval('P1D'));
              }

              ?>
            <b>Kereta:</b> <?php echo $detail_kereta->kereta;?><br>
            <b>Pemberangkatan:</b> <?php echo $detail_kereta->stasiun_pemberangkatan . ' <small>' . tgl_indo2($tgl_berangkat) . '</small>';?><br>
            <b>Tujuan:</b> <?php echo $detail_kereta->stasiun_tujuan . ' - ' . ' <small>' . tgl_indo2($tgl_tiba) . '</small>';?><br>
            </div>
            <div class="col-md-3">
              <img src="<?php echo site_url('admin/dashboard/qrcode/?s=' . $pemesanan->kode_booking); ?>"><br>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Detail Penumpang</h3>
          </div>
          <div class="box-body">
            <table class="table table-bordered" id="detail-pemesanan">
                <thead>
                  <th>No. Identitas</th>
                  <th>Nama Lengkap</th>
                  <th>Gerbong</th>
                  <th>No. Kursi</th>
                  <th class="text-center" style="width: 120px;"></th>
                </thead>        
            </table>
          </div>
        </div>
      </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<div class="modal fade" id="modal-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Edit Identitas</h4>
      </div>
      <div class="modal-body">
        <form action="<?php echo site_url('admin/penumpang/ubah/');?>" method="post" class="form-horizontal" id="form-ubah-penumpang">

          <div class="form-group">
            <label for="no_identitas" class="col-sm-2 control-label">No. Identitas</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="no_identitas" name="no_identitas" placeholder="No. Identitas" maxlength="30">
              <input type="hidden" name="id_penumpang" id="id_penumpang">
              <input type="hidden" name="id_pemesanan" id="id_pemesanan" value="<?php echo $pemesanan->id;?>">
            </div>
          </div>

          <div class="form-group">
            <label for="nama_lengkap" class="col-sm-2 control-label">Nama Lengkap</label>

            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" maxlength="50">
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