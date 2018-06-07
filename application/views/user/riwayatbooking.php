    <div class="container con-login">
      <div class="row row-centered animated fadeIn row-login">
        <div class="col-md-8" style="padding: 10px">
          <h4>Riwayat Booking </h4>
        </div>
        <div class="col-md-4" style="padding: 13px">
          <form action="" method="GET">
            <div class="input-group">
              <input id="pencarian" name="pencarian" type="text" placeholder="Pencarian" class="form-control" value="<?php echo $keyword;?>">
              <span class="input-group-btn">
              <button class="btn btn-search" type="submit"><span class="fa fa-search"></span></button>
              </span>
            </div>
          </form>
        </div>


      </div>

      <div class="row row-centered row-ticket animated fadeInUp">
        <table class="table">
          <thead>
            <tr>
              <th class="awal">No</th>
              <th>Kode Booking</th>
              <th>Pemberangkatan</th>
              <th>Tujuan</th>
              <th>Kereta</th>
              <th>Penumpang</th>
              <th class="akhir"></th>
            </tr>
          </thead>
          <tbody class="font-normal">
            <?php
            if($result) {
            $i = (($curr_page  - 1) * 10) + 1;
            foreach($result as $data) {
            ?>
            <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $data->kode_booking;?></td>
              <td>
              <?php 
              $tgl_berangkat = new DateTime($data->tanggal . ' ' . $data->waktu_berangkat);
              echo $data->nama_stasiun_asal . '<br/><small>' . tgl_indo2($tgl_berangkat) . '</small>';
              ?>
              </td>
              <td>
              <?php 
              $tgl_tiba = new DateTime($data->tanggal . ' ' . $data->waktu_tiba);

              if($tgl_berangkat->diff($tgl_tiba)->invert != 0) {
                $tgl_tiba->add(new DateInterval('P1D'));
              }

              echo $data->nama_stasiun_tujuan . '<br/><small>' . tgl_indo2($tgl_tiba) . '</small>';
              ?>
              </td>
              <td><?php echo $data->kereta;?></td>
              <td><?php echo $data->jumlah;?></td>
              <td><a href="<?php echo site_url('user/booking/detail/' . $data->id);?>" class="btn btn-xs btn-info"><i class="fa fa-th"></i> Detail</button>
              </td>
            </tr>
            <?php 
            $i++;
            }
            }?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="7"><?php echo $this->pagination->create_links();?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>