
<div class="container" style="max-width:900px;">
      <div class="row row-centered animated fadeIn row-login">
        <div class="col-md-2" style="padding: 10px">
          <h4><a href="<?php echo site_url('user/booking/');?>" style="color: #ffffff;"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></h4>
        </div>
        <div class="col-md-8" style="padding: 10px">
          <h4>Detail Booking <?php echo $pemesanan->kode_booking;?></h4>
        </div>

      </div>

      <div class="row row-ticket animated fadeInUp" style="text-align:left !important; background:#FFFFFF;">
        <div class="col-sm-9"><h3>BUKTI PEMBAYARAN TIKET KERETA API</h3>
<h4>www.tiketmaster.com</h4>
        </div>
        <div class="col-sm-2"><img src="<?php echo base_url('assets/img/logoKAI.png')?>" alt="LogoKAI" style="max-width:200px;"></div>



        <table class="table">
          <thead>
            <tr>
              <th colspan="5">Detail Pemesanan</th>
            </tr>
          </thead>
          <tbody class="font-normal">
            <tr>
              <td rowspan="5">
                <img src="<?php echo site_url('user/booking/qrcode/?s=' . $pemesanan->kode_booking); ?>">
                <p>Kode Booking:</p>
                <h4 style="color:red;"><?php echo $pemesanan->kode_booking;?></h4>
              </td>
              <td>Nama</td>
              <td>: <?php echo ucwords($pemesan->nama_depan . ' ' . $pemesan->nama_belakang);?></td>
            </tr>
            <tr>
              <td>Telepon</td>
              <td>: <?php echo $pemesan->no_hp;?></td>
            </tr>
            <tr>
              <td>Email</td>
              <td>: <?php echo $pemesan->email;?></td>
            </tr>
            <tr>
              <td>Tanggal Pesan</td>
              <td>: <?php echo tgl_indo3($pemesanan->tanggal);?></td>
            </tr>
          </tbody>
          <thead>
            <tr>
              <th colspan="5">Detail Perjalanan</th>
            </tr>
          </thead>
          <thead class="th2">
            <tr>
              <th>TANGGAL</th>
              <th>NO KERETA</th>
              <th>NAMA KERETEA</th>
              <th>BERANGKAT</th>
              <th>TIBA</th>
            </tr>
          </thead>
          <tbody class="font-normal">
            <tr>
              <td><?php echo tgl_indo3($pemesanan->tanggal);?></td>
              <td><?php echo $detail_kereta->kode_kereta;?></td>
              <td><?php echo $detail_kereta->nama_kereta;?></td>
              <?php 
              $tgl_berangkat = new DateTime($detail_kereta->tanggal . ' ' . $detail_kereta->waktu_berangkat);
               

              $tgl_tiba = new DateTime($detail_kereta->tanggal . ' ' . $detail_kereta->waktu_tiba);

              if($tgl_berangkat->diff($tgl_tiba)->invert != 0) {
                $tgl_tiba->add(new DateInterval('P1D'));
              }

              ?>
              <td><?php echo tgl_indo2($tgl_berangkat);?><br><?php echo $detail_kereta->stasiun_pemberangkatan;?></td>
              <td><?php echo tgl_indo2($tgl_tiba);?><br><?php echo $detail_kereta->stasiun_tujuan;?></td>
            </tr>
          </tbody>
          <thead>
            <tr>
              <th colspan="5">Detail Penumpang</th>
            </tr>
          </thead>
          <thead class="th2">
            <tr>
              <th>NO IDENTITAS</th>
              <th colspan="2">NAMA LENGKAP</th>
              <th>GERBONG</th> 
              <th>KURSI</th> 
            </tr>
          </thead>
          <tbody class="font-normal">
            <?php foreach($penumpang as $p) { ?>
            <tr>
              <td><?php echo $p->no_identitas;?></td>
              <td colspan="2"><?php echo strtoupper($p->nama_lengkap);?></td>
              <td><?php echo $p->nama_gerbong;?></td>
              <td><?php echo $p->kursi;?></td>
              <td>	</td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>

  </div>
