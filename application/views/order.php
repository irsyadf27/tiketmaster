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
          <p class="kota"><?php echo ucfirst($jadwal->nama_stasiun_asal);?> <i class="fa fa-arrow-right"></i> <?php echo ucfirst($jadwal->nama_stasiun_tujuan);?> | <?php echo $jadwal->nama_kereta . ' (' . $jadwal->kode_kereta . ')';?> <sup><?php echo date('H:i', strtotime($jadwal->waktu_berangkat));?> - <?php echo date('H:i', strtotime($jadwal->waktu_tiba));?></sup></p>
          <p class="rincian"><?php echo tgl_indo($tgl);?> | <?php echo $kursi;?> Orang</p>
        </div>

        <div class="col-md-2 col-pad-2">
          <a href="<?php echo site_url('kereta/cari?asal=' . $jadwal->asal . '&tujuan=' . $jadwal->tujuan . '&tgl=' . $tgl . '&kursi=' . $kursi);?>" class="btn btn-ubah">Ubah Kereta <i class="fa fa-train" aria-hidden="true"></i></a>
          <input type="hidden" name="tgl" id="tgl" value="<?php echo $tgl;?>">
        </div>






      </div>

      <form action="" method="post">
      <div class="row row-centered row-ticket animated fadeIn">
        <table class="table">
          <?php
          for($i=1; $i <= $kursi; $i++) {
          ?>
          <thead>
            <tr>
              <th <?php echo ($i == 1) ? 'class="awal"' : '';?>></th>
              <th colspan="4">Penumpang <?php echo $i; ?></th>
              <th <?php echo ($i == 1) ? 'class="akhir"' : '';?>></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td style="vertical-align:top;"></td>
              <td style="vertical-align:top;">
                <div class="form-group <?php echo (form_error('nama_lengkap[' . $i . ']')) ? 'has-error' : '';?>">
                  <label class="control-label" for="namalengkap">Nama Lengkap <span style="color:#B23850;">*</span></label>
                  <input type="text" class="form-control" id="namalengkap" name="nama_lengkap[<?php echo $i;?>]" placeholder="Nama Lengkap" value="<?php echo set_value('nama_lengkap[' . $i . ']'); ?>">
                  <?php echo (form_error('nama_lengkap[' . $i . ']')) ? '<span class="help-block">' . form_error('nama_lengkap[' . $i . ']') . '</span>' : '';?>
                </div>
                
                <p class="help-block" style="padding-left:20px;"><small>Diisi sesuai dengan KTP/Paspor/SIM (tanpa tanda baca atau gelar)<small></p>
              </td>
              <td style="vertical-align:top;">
                <div class="form-group <?php echo (form_error('no_identitas[' . $i . ']')) ? 'has-error' : '';?>">
                  <label class="control-label" for="noidentitas">Nomor Identitas <span style="color:#B23850;">*</span></label>
                  <input type="text" class="form-control" id="noidentitas" name="no_identitas[<?php echo $i;?>]" placeholder="Nomor Identitas" value="<?php echo set_value('no_identitas[' . $i . ']'); ?>">
                  <?php echo (form_error('no_identitas[' . $i . ']')) ? '<span class="help-block">' . form_error('no_identitas[' . $i . ']') . '</span>' : '';?>
                </div>

                <p class="help-block" style="padding-left:20px;"><small>Untuk penumpang di bawah 17 tahun, wajib diisi dengan tanggal lahir, format yyyymmdd (19990717)<small></p>
              </td>
              <td style="vertical-align:top;">
                <?php if(form_error('hidden_gerbong[' . $i . ']') || form_error('hidden_row[' . $i . ']') || form_error('hidden_seat[' . $i . ']')) { ?>
                <span class="text-danger" id="kursi-<?php echo $i;?>">(No Kursi)</span>
                <?php } elseif(set_value('hidden_gerbong_nama[' . $i . ']'))  { ?>
                <span id="kursi-<?php echo $i;?>"><?php echo set_value('hidden_gerbong_nama[' . $i . ']') . '; ' . set_value('hidden_seat[' . $i . ']') . set_value('hidden_row[' . $i . ']');?></span>
                <?php } else { ?>
                <span id="kursi-<?php echo $i;?>">(No Kursi)</span>
                <?php } ?>
              </td>
              <input type="hidden" name="hidden_gerbong[<?php echo $i;?>]" id="hgerbong-<?php echo $i;?>" value="<?php echo set_value('hidden_gerbong[' . $i . ']');?>">
              <input type="hidden" name="hidden_gerbong_nama[<?php echo $i;?>]" id="hgerbongnama-<?php echo $i;?>" value="<?php echo set_value('hidden_gerbong_nama[' . $i . ']');?>">
              <input type="hidden" name="hidden_row[<?php echo $i;?>]" id="hrow-<?php echo $i;?>" value="<?php echo set_value('hidden_row[' . $i . ']');?>">
              <input type="hidden" name="hidden_seat[<?php echo $i;?>]" id="hseat-<?php echo $i;?>" value="<?php echo set_value('hidden_seat[' . $i . ']');?>">
            </tr>
            <tr>
              <td colspan="4"></td>
              <td style="text-align:center !important; padding-bottom:20px;"><button type="button" class="btn btn-primary btn-pilih-kursi" data-i="<?php echo $i;?>">Pilih Kursi</button></td>
            </tr>
            <tr class="gerbong-<?php echo $i;?>" style="display: none;">
              <td colspan="5" style="text-align; right;">
                <div class="col-md-4 form-group <?php echo (form_error('gerbong[' . $i . ']')) ? 'has-error' : '';?>">
                  <label class="control-label" for="noidentitas">Gerbong <span style="color:#B23850;">*</span></label>
                  <select class="form-control pilih-gerbong-<?php echo $i;?>">
                    <?php foreach($gerbong as $g) { ?>
                      <option value="<?php echo $g->id;?>"><?php echo $g->nama . ' (' . $g->kelas . ')';?></option>
                    <?php } ?>
                  </select>
                </div>
              </td>
            <tr class="gerbong-<?php echo $i;?> div-seat-map" style="display: none;">
              <td></td>
              <td colspan="4" class="txt-nama-gerbong-<?php echo $i;?>" style="text-align: center;background-color: #E7E2D4;color: #000000; font-weight: bold;"></td>
              <td></td>
            </tr>
            <tr class="gerbong-<?php echo $i;?>" style="display: none;">
              <td colspan="5" class="" style="vertical-align:top; text-align:center; margin: 0 auto;">
                <div class="seat-map-<?php echo $i;?>"></div>
              </td>
            </tr>
          </tbody>
        <?php } ?>
  </table>
<p style="text-align:right; padding-right:35px;">
  <button type="button" class="btn btn-default" style="min-width:100px !important;" onclick="javascript: batal_pesan();">Batal</button>&nbsp;&nbsp;
  <button type="submit" class="btn btn-ubah " style="min-width:100px !important;">Booking Sekarang</button>
</p>



  <hr>

    </div>
  </form>
  </div>