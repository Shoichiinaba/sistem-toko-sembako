  <!-- UNTUK TAMPILAN ADMIN PENJUALAN -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		<i class="fa fa-book"></i>
        Laporan Penjualan
		<small>Mengelola laporan penjualan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i>Laporan Penjualan</a></li>
      </ol>
    </section>
    <section class="content">
		<div class="box-body" style="padding-left:0px;">
			<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default"><i class="fa fa-print"></i> Cetak</button>
		</div>
		<div class="box box-success no-margin hapus-radius-bawah">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Laporan Penjualan</h3>
            </div>
            <div class="box-body no-padding" style="margin:12px 12px 0px 0px;">
			  <div class="pull-right">
				<div class="input-group input-group-sm" style="width: 200px;">
                  <input type="text" name="table_search" class="fil-cari form-control pull-left" placeholder="Cari tanggal">
                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default fa fa-search" data-cstarget="searchNpage"></button>
                  </div>
                </div>
			  </div>
              
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
                  <th style="">Total Penjualan</th>
                  <th style="">Jumlah Item</th>
                  <th style="">Total Harga(Rp)</th>
				  <th style="">Tanggal</th>
				  <th>Aksi</th>
                </tr>
				</thead>
				<tbody>
				 <?php
                foreach ($data as $key) {
                  ?>
                  <tr>
                    <td><center><?php echo $key['total_penjualan'];?></center></td>
                    <td><center><?php echo $key['total_item'];?></center></td>
					<td><?php echo $key['total_harga'];?></td>
					<td><?php echo $key['tanggal'];?></td>
                    <td>
					  <a href="<?php echo base_url(); ?>index.php/admin/penjualan_detail?tgl=<?php echo $key['tanggal']; ?>">
                      <button type="button" data-toggle="modal" class="btn btn-primary fa fa-eye"></button>
					  </a>
                      <button type="button" data-toggle="modal" data-cstarget="delPick" data-target="#modal-danger" class="btn btn-danger fa fa-trash"></button>
					 </td>
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
	<div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cetak Laporan Penjualan</h4>
              </div>
              <div class="modal-body">
                <form action="<?php echo base_url();?>index.php/c_penjualan/get_print_penjualan" method="POST">
					<div class="form-group">
						<label>Dari Tanggal:</label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" class="form-control pull-right" id="datepicker" name="tgl_1" autocomplete="off">
						</div>
                <!-- /.input group -->
					</div>
					<div class="form-group">
						<label>Sampai Tanggal:</label>
						<div class="input-group date">
						  <div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						  </div>
						  <input type="text" class="form-control pull-right" id="datepicker2" name="tgl_2" autocomplete="off">
						</div>
                <!-- /.input group -->
					</div>
					<div class="box-body" style="padding:0px 0px 0px 0px;">
						<input type="reset" class="btn btn-default" value="Batal" />
						<input type="submit" class="btn btn-primary pull-right" value="Ok"/>
					</div>
				</form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
    </div>
	<div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus Data Penjualan</h4>
              </div>
              <div class="modal-body">
                <form id="form-hapus-barang">
				<div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal" class="form-control" id="tanggal" placeholder="Masukan nama barang anda" value="" readonly>
                  </div>
                </form>
                  <p>Apakah anda yakin ingin menghapus data ini</p>
                  <div class="loader"></div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" id="tutup" data-dismiss="modal">Tidak</button>
                <button type="button" id="delete" class="btn btn-outline"><i class="fa fa-trash"></i> Hapus</button>
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
			  // Datadefine['tanggal'] = '';
			</script>
			<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['penjualan'] = 'penjualan';
			  Datadefine['index-hal'] = 1;
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>
			<?php } ?>