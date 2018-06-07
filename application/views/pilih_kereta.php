  <!--Form Booking-->
  <div class="container">
    <div class="row row-centered booking-form animated fadeInDown">
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
        <div class="col-md-10 col-pad ticket-information">
<p class="kota"><?php echo ucfirst($asal->nama);?> <i class="fa fa-arrow-right"></i> <?php echo ucfirst($tujuan->nama);?></p>
<p class="rincian"><?php echo tgl_indo($tgl);?> | <?php echo $kursi;?> Orang</p>
        </div>

        <div class="col-md-2 col-pad-2">
          <button type="button" name="button" class="btn btn-ubah" onclick="form2Toggle()">Ubah Pencarian <i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
        </div>




    <form action="<?php echo site_url('kereta/cari');?>" method="GET" id="form-cari-jadwal">
      <div class="form2 form-group">
        <br> <br> <br> <br>
        <div class="col-md-6 col-pad-2">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>

            <select id="kota-asal" name="asal" data-placeholder="Stasiun Asal" class="form-control select-stasiun" style="width: 220px">
              
            </select>
            <span class="input-group-btn">
              <button class="btn btn-reverse" type="button"><span class="fa fa-refresh" style="color: #e16738;"></span></button>
            </span>

            <select id="kota-tujuan" name="tujuan" data-placeholder="Stasiun Tujuan" class="form-control select-stasiun" style="width: 220px">
              
            </select>
            <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
          </div>
        </div>
        <div class="col-md-2 col-pad">
          <div class="input-group">
            <input id="tgl-brngkat" name="tgl" type="text" placeholder="Hari Berangkat" class="form-control" value="<?php echo set_value('tgl');?>">
            <span class="input-group-btn">
            <button id="btn-kalender"  class="btn" type="button"><span class="fa fa-calendar"></span></button>
            </span>
          </div>
        </div>
        <div class="col-md-2 col-pad">
          <div class="input-group">
            <span class="input-group-addon" type="button"><i class="fa fa-users"></i></span>
            <select class="form-control" name="kursi" id="sel1">
              <option value="1" <?php echo (set_value('kursi') == '1') ? 'selected' : '';?>>1</option>
              <option value="2" <?php echo (set_value('kursi') == '2') ? 'selected' : '';?>>2</option>
              <option value="3" <?php echo (set_value('kursi') == '3') ? 'selected' : '';?>>3</option>
              <option value="4" <?php echo (set_value('kursi') == '4') ? 'selected' : '';?>>4</option>
              <option value="5" <?php echo (set_value('kursi') == '5') ? 'selected' : '';?>>5</option>
              <option value="6" <?php echo (set_value('kursi') == '6') ? 'selected' : '';?>>6</option>
            </select>
          </div>
        </div>

        <div class="col-md-2 col-pad">
          <button type="submit" name="button" class="btn btn-book">UBAH</button>
        </div>
      </div>
    </form>
    </div>

    <div class="row row-centered row-ticket animated fadeIn table-responsive">
      <table class="table">
    <thead>
      <tr>
        <th class="awal">Kereta</th>
        <th>Pergi</th>
        <th>Tiba</th>
        <th class="akhir">Pilih</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if($jadwal) {
        foreach($jadwal as $jdwl) {
      ?>
        <tr>
          <td><?php echo $jdwl->nama_kereta;?> (<?php echo $jdwl->kode_kereta;?>)</td>
          <td><?php echo date('H:i', strtotime($jdwl->waktu_berangkat));?></td>
          <td><?php echo date('H:i', strtotime($jdwl->waktu_tiba));?></td>
          <td>
            <?php
            $tgl_pesan = DateTime::createFromFormat('d/m/Y', $tgl);
            $disabled = '';
            if(
              (date('Y-m-d') == $tgl_pesan->format('Y-m-d') && 
                (strtotime($jdwl->waktu_berangkat) <= strtotime(date('H:i'))))
              ) {
              $disabled = 'disabled';
            }
            if(isset($this->session->login)) { 
            ?>
            <a class="btn btn-sm btn-default <?php echo $disabled;?>" href="<?php echo site_url('kereta/pilih/' . $jdwl->id . '?tgl=' . $tgl . '&kursi=' . $kursi);?>"><i class="fa fa-train"></i> Pilih</a>
            <?php } else { ?>
            <a class="btn btn-sm btn-default <?php echo $disabled;?>" data-toggle="modal" href="#myModal"><i class="fa fa-train"></i> Pilih</a>
            <?php } ?>
          </td>
        </tr>
      <?php 
        }
      } else {
        echo '<tr><td colspan="5" style="text-align: center !important;font-size: large;"><b>Rute Tidak Ditemukan.</b></td></tr>';
      }
      ?>
    </tbody>
  </table>
    </div>
  </div>
<!-- Modal Login -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login / Daftar</h4>
      </div>
      <div class="modal-body">

        <form action="<?php echo site_url('auth/login');?>" method="post">
          <div class="form-group">
            <input type="text" class="form-control" id="username" placeholder="Username / Email" name="username">
          </div>

          <div class="form-group">
            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
          </div>

          <div class="form-group">
            <button type="submit" name="button" class="btn btn-login">Login</button>
          </div>
          <div class="form-group">
            <a href="<?php echo site_url('daftar');?>" class="btn btn-primary" style="min-width: 100%;">Daftar</a>
            <p class="text-center help-block"><small>Silakan daftar jika belum punya akun!<small></p>
          </div>
        </form>
      </div>

    </div>

  </div>
</div>