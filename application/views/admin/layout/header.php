<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo (isset($title)) ? $title : 'Tiketmaster.com - Admin';?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css'); ?>">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/sweetalert2-6.10.3/sweetalert2.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/AdminLTE.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pnotify/dist/pnotify.custom.min.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/css/skins/skin-red-light.min.css'); ?>">
  <?php
  if(isset($css)) {
    foreach($css as $c) {
      echo '<link rel="stylesheet" href="' . base_url($c) . '">';
    }
  }
  ?>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script>var BASE_URL = '<?php echo site_url('admin'); ?>';</script>
</head>
<body class="hold-transition skin-red-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo site_url(); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>TM</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>TiketMaster</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php $data_login = $this->model_user->get_id($this->session->userdata('id_user'));?>
              <span><?php echo ucwords($data_login->nama_depan . ' ' . $data_login->nama_belakang);?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <div style="margin:0 auto; width: 100px; height: 100px; border-radius: 100px; background: #333;">
                  <div style="width: 100%; text-align: center; color: white; font-size: 42px; line-height: 100px;">
                    <?php
                  echo strtoupper(substr($data_login->nama_depan, 0, 1) . substr($data_login->nama_belakang, 0, 1));
                  ?>
                  </div>
                </div>
                <p>
                  <?php
                  echo ucwords($data_login->nama_depan . ' ' . $data_login->nama_belakang);
                  ?>
                  <small>@<?php echo $data_login->username;?></small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo site_url('admin/user/ubah/' . $this->session->userdata('id_user'));?>" class="btn btn-default btn-flat">Pengaturan Akun</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('auth/logout');?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>