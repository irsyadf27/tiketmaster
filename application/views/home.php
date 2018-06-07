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
      <form action="<?php echo site_url('kereta/cari');?>" method="GET" id="form-cari-jadwal">
      <div class="form-group">
        <div class="col-md-6 col-pad">
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
            <input id="tgl-brngkat" name="tgl" type="text" placeholder="Hari Berangkat" class="form-control" value="<?php echo date('d/m/Y');?>">
            <span class="input-group-btn">
            <button id="btn-kalender" class="btn" type="button"><span class="fa fa-calendar"></span></button>
            </span>
          </div>
        </div>
        <div class="col-md-2 col-pad">
          <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-users"></i></span>
            <select class="form-control" name="kursi" id="sel1">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </div>
        </div>

        <div class="col-md-2 col-pad">
          <button type="submit" name="button" class="btn btn-book">BOOK NOW</button>
        </div>



      </div>
    </form>


    </div>

    <div class="row row-centered row-carousel">
      <div id="mycarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <?php for($i=0; $i < count($slideshow); $i++) { ?>
          <li data-target="#mycarousel" data-slide-to="<?php echo $i;?>" <?php echo ($i == 0) ? 'class="active"' : '';?>></li>
          <?php } ?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
          <?php
          for($i=0; $i < count($slideshow); $i++) {
            $s = $slideshow[$i];
          ?>
          <div class="item <?php echo ($i == 0) ? 'active' : '';?>">
            <img src="<?php echo base_url('assets/slideshow/' . $s->gambar);?>" alt="<?php echo $s->judul;?>">
            <div class="carousel-caption">
              <h3><?php echo $s->judul;?></h3>
              <?php echo ($s->deskripsi != '') ? '<p>' . $s->deskripsi . '</p>' : '';?>
            </div>
          </div>
          <?php } ?>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#mycarousel" role="button" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
              <a class="right carousel-control" href="#mycarousel" role="button" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>