    <!-- SideMenu -->
    <div class="navbar-default sidebar navbar-fixed-top" role="navigation">
      <div class="sidebar-nav">
        <ul class="nav" id="side-menu" style="margin-top:10px;">
          <li class="<?php echo ($active == 'dashboard') ? 'active' : '';?>">
            <a href="<?php echo site_url('user/dashboard');?>"><i class="fa fa-home" aria-hidden="true"></i> Beranda</a>
          </li>
          <li class="<?php echo ($active == 'riwayat-booking') ? 'active' : '';?>">
            <a href="<?php echo site_url('user/booking');?>"><i class="fa fa-book" aria-hidden="true"></i> Riwayat Booking</a>
          </li>
          <li class="<?php echo ($active == 'pengaturan-akun') ? 'active' : '';?>">
            <a href="<?php echo site_url('user/setting');?>"><i class="fa fa-user" aria-hidden="true"></i> Pengaturan Akun </a>
          </li>




        </ul>
      </div>

    </div>