
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Pemesanan & Penumpang
        <small>TiketMaster</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-8">
          <!-- Default box -->
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Laporan Pemesanan &amp; Penumpang Tahun <?php echo $tahun;?></h3> -->
              <input type="hidden" id="hidden_tahun" name="hidden_tahun" value="<?php echo $tahun;?>">
              <div class="box-tools pull-right">
                <a href="<?php echo site_url('admin/laporan/export_pemesanan/' . $tahun);?>" class=""><i class="fa fa-file-excel-o"></i> Export Excel</a>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <div id="chartPemesanan"></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <div class="col-md-4">
          <!-- Default box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Filter Laporan</h3>
            </div>
            <form class="form-horizontal" action="<?php echo site_url('admin/laporan/pemesanan');?>" method="GET">
            <div class="box-body">
                <div class="form-group <?php echo (form_error('tahun')) ? 'has-error' : '';?>">
                  <label for="tahun" class="col-sm-2 control-label">Tahun</label>

                  <div class="col-sm-10">
                    <select id="tahun" name="tahun" class="form-control">
                      <?php for($i=date('Y'); $i > date('Y') - 10; $i--) { ?>
                      <option value="<?php echo $i;?>" <?php echo ($tahun == $i) ? 'selected' : '';?>><?php echo $i;?></option>
                      <?php } ?>
                    </select>

                    <?php echo (form_error('tahun')) ? '<span class="help-block">' . form_error('tahun') . '</span>' : '';?>
                  </div>

                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-sm btn-success pull-right"><i class="fa fa-search"></i> Filter</button>
            </div>
            <!-- /.box-footer-->
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->