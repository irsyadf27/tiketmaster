  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li><a href="<?php echo site_url();?>"><i class="fa fa-home"></i> Halaman Utama</a></li>
        <li <?php echo ($active == 'dashboard') ? 'class="active"' : ''?>>
          <a href="<?php echo site_url('admin/dashboard');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li <?php echo ($active == 'user') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/user');?>"><i class="fa fa-user"></i> Pengguna</a></li>
        <li <?php echo ($active == 'stasiun') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/stasiun');?>"><i class="fa fa-map-marker"></i> Stasiun</a></li>
        <li <?php echo ($active == 'kereta') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/kereta');?>"><i class="fa fa-train"></i> Kereta</a></li>
        <li <?php echo ($active == 'jadwal') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/jadwal');?>"><i class="fa fa-calendar"></i> Jadwal</a></li>
        <li <?php echo ($active == 'pemesanan') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/pemesanan');?>"><i class="fa fa-group"></i> Pemesanan</a></li>
        <li <?php echo ($active == 'slideshow') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/slideshow');?>"><i class="fa fa-image"></i> Slideshow</a></li>
        <li <?php echo ($active == 'laporan_pemesanan') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/laporan/pemesanan');?>"><i class="fa fa-pie-chart"></i> Laporan Pemesanan</a></li>
        <!-- <li class="treeview <?php echo (in_array($active, array('laporan_pemesanan', 'laporan_perjalanan'))) ? 'active' : ''?>">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php echo ($active == 'laporan_pemesanan') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/laporan/pemesanan');?>"><i class="fa fa-circle-o"></i> Pemesanan</a></li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Perjalanan</a></li>
          </ul>
        </li>-->
        <li <?php echo ($active == 'backup') ? 'class="active"' : ''?>><a href="<?php echo site_url('admin/backup');?>"><i class="fa fa-cog"></i> Backup Database</a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->