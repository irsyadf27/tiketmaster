<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?php echo (isset($title)) ? $title : 'Tiketmaster.com';?></title>
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/img/icon.png'); ?>">

  <!-- CSS -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/footer-basic-centered.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pnotify/dist/pnotify.custom.min.css'); ?>">
  <?php
  if(isset($css)) {
    foreach($css as $c) {
      echo '<link rel="stylesheet" href="' . base_url($c) . '">';
    }
  }
  ?>

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <script>var BASE_URL = '<?php echo site_url();?>';</script>
</head>

<body>
  <!-- Navbar -->
  <navbar>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
          <a href="<?php echo site_url();?>" class="navbar-brand"><img src="<?php echo base_url('assets/img/logo.png'); ?>"></a>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">

          <ul class="nav navbar-nav">
            <li class=""><a href="<?php echo site_url();?>">Tiket Kereta Api</a></li>
            <?php if($this->session->userdata('login')) { ?>
            <!-- <li class="s"><a href="<?php echo site_url('user/dashboard');?>">Dashboard User</a></li> -->
            <?php } ?>

            <?php if($this->session->userdata('jenis') == 'admin') { ?>
            <li class="s"><a href="<?php echo site_url('admin/dashboard');?>">Halaman Admin</a></li>
            <?php } ?>

          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if($this->session->userdata('login')) { ?>
            <li class="m-user"><a href="<?php echo site_url('user/dashboard');?>"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $this->model_user->get_username_login($this->session->userdata('id_user'));?></a></li>
            <li><a href="<?php echo site_url('auth/logout');?>" style="color: #B23850;">Logout</a></li>
            <?php } else { ?>
            <li><a href="<?php echo site_url('daftar');?>">Daftar</a></li>
            <li><a href="<?php echo site_url('auth/login');?>" style="color: #B23850;">Masuk</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
  </navbar>