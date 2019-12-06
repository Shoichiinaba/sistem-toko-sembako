  <!-- UNTUK TAMPILAN ADMIN PENJUALAN -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		<i class="fa fa-book"></i>
        Laporan Penjualan - <?php echo $tanggal; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i>Laporan Penjualan</a></li>
      </ol>
    </section>
    <section class="content">
		<div class="box-body" style="padding-top:0px; padding-left:0px;display:none;">
			<a href="<?php echo base_url(); ?>index.php/c_penjualan/cetak?tanggal=<?php echo $tanggal; ?>">
			<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Cetak</button></a>
        </div>
		<div class="box box-success no-margin hapus-radius-bawah">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Laporan Penjualan - <?php echo $tanggal; ?></h3>
            </div>
            <!-- /.box-body -->
          </div>
		<div class="box no-border hapus-radius-atas">
		<div id="refresh-box">
          <div class="do-refresh">
            <span><strong>Loading...</strong></span>
          </div>
        </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
				<table class="table table-striped table-bordered tampil-barang">
				<thead>
				<tr>
				  <th style="">ID Penjualan</th>
				  <th>Customer</th>
                  <th style="">Nama Barang</th>
                  <th style="">Satuan</th>
                  <th style="">Jumlah</th>
				  <th style="">Harga Satuan(Rp)</th>
				  <th>Total Harga(Rp)</th>
				  <th>Tanggal</th>
                </tr>
				</thead>
				<tbody>
				 <?php
                foreach ($data as $key) {
                  ?>
                  <tr>
                    <td style=""><?php echo $key['id'];?></td>
					<td><?php echo $key['customer'];?></td>
                    <td><?php echo $key['nama_barang'];?></td>
                    <td><?php echo $key['satuan'];?></td>
					<td><?php echo $key['jumlah'];?></td>
					<td><?php echo $key['harga_jual'];?></td>
					<td><?php echo $key['harga'];?></td>
					<td><?php echo $key['tanggal'];?></td>
                  </tr>
                  <?php } ?>
				</tbody></table>
			</div>
			<div class="box-body" style="padding-top:5px;">
				<div id="ket-index-data">
                <p>Menampilkan <strong>0</strong> dari <strong> <?php echo $countData; ?> </strong> data. </p>
              </div>
            <div id="page-more">
              <?php if($next == "ada") { ?>
                <button type="button" class="btn btn-default btn-block btn-more" data-cstarget="pageMore">Tampilkan Lagi</button>
              <?php } ?>
            </div>
			</div>
          </div>
		  
    </section>

    </div>
	<div class="modal modal-info fade" id="modal-info" style="display: none;">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Penjualan Barang</h4>
              </div>
              <div class="modal-body">
              <table class="table table-bordered tabel-penjualan-ket" style="">
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
                  <td>Harga(Rp)</td>
                  <td><div class="modal-harga"></div></td>
                </tr>
                <tr>
                  <td>Pembayaran(Rp)</td>
                  <td><div class="modal-pembayaran"></div></td>
                </tr>
                <tr>
                  <td>Kembalian(Rp)</td>
                  <td><div class="modal-kembalian"></div></td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td><div class="modal-tanggal"></div></td>
                </tr>
              </tbody>
            </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Tutup</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
  <!-- /.content-wrapper -->
			<script type="text/javascript">
			  var Datadefine = [];
			  Datadefine['url'] = '<?php echo base_url();?>';
			  Datadefine['tanggal'] = '<?php echo $tanggal; ?>';
			</script>
			<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['penjualan'] = 'detail';
			  Datadefine['index-hal'] = 1;
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>
			<?php } ?>