<?php if(isset($keterangan) and $keterangan == "Kasir"){ ?>
<body class="hold-transition skin-blue sidebar-mini">
<?php } else { ?>
<body class="hold-transition skin-green sidebar-mini">
<?php } ?>
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
              <?php if( (isset($_SESSION['keterangan'])) and ($_SESSION['keterangan'] == 'Kasir') ) { ?>
					<img src="<?php echo base_url(); ?>dist/img/user.jpg" class="user-image" alt="User Image">
			  <?php } else { ?>
					<img src="<?php echo base_url(); ?>dist/img/user.jpg" class="user-image" alt="User Image">
			  <?php } ?>
              <span class="hidden-xs"><?php echo $_SESSION['nama'];?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
				  <?php if( (isset($_SESSION['keterangan'])) and ($_SESSION['keterangan'] == 'Kasir') ) { ?>
					<img src="<?php echo base_url(); ?>dist/img/user.jpg" class="img-circle" alt="User Image">
				  <?php } else { ?>
					<img src="<?php echo base_url(); ?>dist/img/user.jpg" class="img-circle" alt="User Image">
				  <?php } ?>
                <p>
                  <?php echo $_SESSION['nama'];?> - <?php echo $_SESSION['keterangan'];?>
                  <small>Berlaku sebagai <?php echo $_SESSION['keterangan'];?> Toko Anis</small>
                </p>
              </li>
                
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?php echo base_url();?>index.php/login/keluar" class="btn btn-default btn-flat">Keluar</a>
                </div>
              </li>
            </ul>
          </li>
        
         
        </ul>
      </div>
        
    </nav>
  </header>
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <?php if( (isset($_SESSION['keterangan'])) and ($_SESSION['keterangan'] == 'Kasir') ) { ?>
				<img src="<?php echo base_url(); ?>dist/img/user.jpg" class="img-circle" alt="User Image">
		  <?php } else {?>
				<img src="<?php echo base_url(); ?>dist/img/user.jpg" class="img-circle" alt="User Image">
		  <?php } ?>
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['nama'];?></p>
          <a href="#"> <?php echo $_SESSION['keterangan'];?></a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
	  <?php if(isset($keterangan) and $keterangan == "Admin") { ?>
	  <ul class="sidebar-menu" data-widget="tree">
		<li>
			<a href="<?php echo base_url();?>index.php/admin">
			<i class="fa fa-home"></i>
			<span>Home</span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url();?>index.php/admin/barang">
				<i class="fa fa-th-list"></i> 
				<span>Master Barang</span>
			</a>
		</li>
		<li>
            <a href="<?php echo base_url();?>index.php/admin/daftarpembelian">
			<i class="fa fa-th-list"></i> <span>Daftar Pembelian</span></a>
        </li>
		<li>
            <a href="<?php echo base_url();?>index.php/admin/penjualan">
                <i class="fa fa-book"></i>
                <span>Laporan Penjualan</span>
            </a>
        </li>
		<li>
            <a href="<?php echo base_url();?>index.php/admin/pembelian">
			<i class="fa fa-shopping-cart"></i> <span>Pembelian</span></a>
        </li>
		<li>
            <a href="<?php echo base_url();?>index.php/admin/penempatan">
			<i class="fa fa-inbox"></i> <span>Penempatan</span></a>
        </li>
		<li>
            <a href="<?php echo base_url();?>index.php/admin/supplier">
			<i class="fa fa-truck"></i> <span>Supplier</span></a>
        </li>
		<li>
            <a href="<?php echo base_url();?>index.php/admin/pengguna">
			<i class="fa fa-users"></i> <span>Pengguna</span></a>
        </li>
      </ul>
	  <?php } else { ?>
	  <?php
		#Menu untuk mode kasir
	  ?>
	  <ul class="sidebar-menu" data-widget="tree">
		<li>
            <a href="<?php echo base_url();?>index.php/kasirtoko">
                <i class="fa fa-shopping-cart"></i>
                <span>Penjualan</span>
            </a>
        </li>
		<li>
			<a href="<?php echo base_url();?>index.php/kasirtoko/barang">
				<i class="fa fa-th-list"></i> 
				<span>Master Barang</span>
			</a>
		</li>
		<li>
			<a href="<?php echo base_url();?>index.php/kasirtoko/penjualanlp">
				<i class="fa fa-book"></i> 
				<span>Laporan Penjualan</span>
			</a>
		</li>
        <li>
          <a href="<?php echo base_url();?>index.php/kasirtoko/barang_masuk">
            <i class="fa fa-bell"></i>
            <span>Barang Masuk</span>
            <span class="pull-right-container">
			  <small class="label pull-right bg-yellow"><?php if(isset($jumlah)){echo $jumlah;} ?></small>
            </span>
          </a>
        </li>
      </ul>
	  <?php } ?>
    </section>
    <!-- Batas Menu -->
  </aside>