<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/konten.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/css/skins/_all-skins.min.css">
 
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>T</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Sem.</b>Toko</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

        
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Alexander Pierce</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
                
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        
         
        </ul>
      </div>
        
    </nav>
  </header>
    
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url(); ?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
            <a href="https://adminlte.io/docs">
                <i class="fa fa-calendar-plus-o"></i>
                <span>Documentation</span>
            </a>
        </li>
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li>
            <a href="https://adminlte.io/docs">
                <i class="fa fa-book"></i>
                <span>Documentation</span>
            </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Barang
        <small>Menampilkan seluruh data barang</small>
      </h1>
    </section>

    <div class="konten-utama">

      <div class="konten-widget-tanggal">
        <div class="box box-primary" style="margin-bottom: 0px;">
            <div class="box-header">
              <h3 class="box-title">Filter penjualan</h3>
            </div>
            <div class="box-body">
              <div class="kotak-tanggal">
              <div class="form-group">
              <label>Penjualan Berdasarkan Tanggal :</label>
              <div id="form-tanggal-container">
                <div id="form-kotak-tanggal">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <div class="form-kotak-tanggal">
                      <div id="form-tanggal">
                        <input type="text" class="form-control tanggal" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="form-kotak-tombol">
                  <button type="button" class="btn btn-block btn-primary" id="tanggal" data-cstarget="searchTanggal">Tampilkan</button>
                </div>
              </div>
            </div>
            </div>

            <div class="kotak-bulan">
              <div class="form-group">
                  <label>Penjualan Berdasarkan Bulan :</label>
                  <div id="form-bulan-container">
                    <div id="form-kotak-bulan">
                      <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <div class="form-kotak-tanggal">
                      <div id="form-tanggal">
                        <input type="text" class="form-control bulan" data-inputmask="'alias': 'mm/yyyy'" data-mask>
                      </div>
                    </div>
                  </div>
                    </div>
                    <div id="form-kotak-bulan-tombol">
                      <button type="button" class="btn btn-block btn-primary" id="bulan"data-cstarget="searchTanggal">Tampilkan</button>
                    </div>
                  </div>
                  
                </div>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
      </div>

      <div class="konten-utama-barang">
        <div class="box box-success">
           <div class="box-header">
              <h3 class="box-title">Tabel daftar penjualan barang</h3>
            </div>
            <div id="ket-pencarian">
              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover tampil-barang">
                <thead><tr>
                  <th>ID</th>
                  <th>Barang Jual</th>
                  <th>Harga</th>
                  <th>Pembayaran</th>
                  <th>kembalian</th>
                  <th>Tanggal</th>
                  <th>Info</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($data as $key) {
                      echo '<tr>';
                        echo '<td>'.$key['id'].'</td>';
                        echo '<td>'.$key['deskripsi_barang'].'</td>';
                        echo '<td>'.$key['total_harga'].'</td>';
                        echo '<td>'.$key['pembayaran'].'</td>';
                        echo '<td>'.$key['kembalian'].'</td>';
                        echo '<td>'.$key['tanggal'].'</td>';
                        echo '<td> <button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button></td>';
                      echo '</tr>';
                    }
                  ?>
                </tbody>
              </table>
              <div id="ket-index-data">
                <p>Menampilkan <strong>2</strong> dari <strong> <?php echo $countData; ?> </strong> data. </p>
              </div>
              <div id="page-more">
                <button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>
              </div>
            </div>
              
            
            <!-- /.box-body -->
          </div>
      </div>
    </div>
    </div>
  <!-- /.content-wrapper -->
  <div class="modal modal-info fade" id="modal-info" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Detail Barang</h4>
              </div>
              <div class="modal-body">
              <table class="table table-bordered tabel-penjualan-ket">
                <thead><tr>
                  <th style="width: 5%;">#</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>ID</td>
                  <td><div class="modal-id"></div></td>
                </tr>
                <tr>
                  <td>Barang</td>
                  <td><div class="modal-barang"></div></td>
                </tr>
                <tr>
                  <td>Harga</td>
                  <td><div class="modal-harga"></div></td>
                </tr>
                <tr>
                  <td>Pembayaran</td>
                  <td><div class="modal-pembayaran"></div></td>
                </tr>
                <tr>
                  <td>Kembalian</td>
                  <td><div class="modal-kembalian"></div></td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td><div class="modal-tanggal"></div></td>
                </tr>
                <tr>
                  <td>Kasir</td>
                  <td><div class="modal-kasir"></div></td>
                </tr>
              </tbody>
            </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.1
    </div>
    <strong>Copyright &copy; 2019-2020 <a href="https://adminlte.io">Andi studio</a>.</strong> All rights
    reserved.
  </footer>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script type="text/javascript">
  var Datadefine = [];
  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
  Datadefine['index-hal'] = 1;
  Datadefine['url'] = '<?php echo base_url();?>';
  Datadefine['count-data'] = '<?php echo $countData; ?>';
</script>
<script src="<?php echo base_url(); ?>bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>dist\js\plugin-btn2.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- FastClick -->
<script src="<?php echo base_url(); ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
</body>
</html>
