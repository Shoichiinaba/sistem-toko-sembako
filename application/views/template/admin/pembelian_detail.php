  <!-- UNTUK DAFTAR PEMBELIAN BARANG DETAIL -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	  <i class="fa fa-th-list"></i>
        Daftar Pembelian - <?php echo $tanggal; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-th-list"></i>Daftar Pembelian</a></li>
      </ol>
    </section>
    <section class="content">
		<div class="box-body" style="padding-top:0px; padding-left:0px;">
			<a href="<?php echo base_url(); ?>index.php/c_pembelian/get_cetak_pembelian_barang?tanggal=<?php echo $tanggal; ?>">
			<button type="button" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> Cetak</button></a>
        </div>
		<div class="box box-primary">
		<div id="refresh-box">
          <div class="do-refresh">
            <span><strong>Loading...</strong></span>
          </div>
        </div>
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Pembelian Barang - <?php echo $tanggal; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
				<table class="table table-striped table-bordered tampil-barang">
				<thead>
				<tr>
                  <th style="">ID</th>
                  <th style="">Nama Barang</th>
                  <th style="">Satuan</th>
                  <th style="">Jumlah</th>
				  <th style="">Harga(Rp)</th>
				  <th style="">Nama Supplier</th>
				  <th style="">Acc</th>
				  <th style="">Aksi</th>
                </tr>
				</thead>
				<tbody>
				<?php
					foreach($data as $barang){
						?>
						<tr>
							<td><?php echo $barang['id']?></td>
							<td><?php echo $barang['nama_barang']?></td>
							<td><?php echo $barang['satuan']?></td>
							<td><?php echo $barang['jumlah']?></td>
							<td><?php echo $barang['harga']?></td>
							<td><?php echo $barang['nama_supplier']?></td>
							<td>
								<?php if($barang['acc'] == "belum"){ ?>
								<span class="label  label-danger"><?php echo $barang['acc'];?></span>
								<?php } else {?>
								<span class="label  label-success"><?php echo $barang['acc'];?></span>
								<?php } ?>
							</td>
							<td>
								<?php if($barang['status'] == "belum"){ ?>
									<button class="btn btn-primary fa fa-plus no-padding" style="height:24px;" data-cstarget="getTambah" <?php print( ($barang['acc'] == "belum") ? 'disabled':'' ); ?> > Tambahkan Stok</button>
								<?php } else { ?>
									<button class="btn btn-success fa fa-check no-padding" style="height:24px;"> Ditambahkan</button>
								<?php } ?>
								<button data-target="#modal-warning" data-cstarget="editReck" data-toggle="modal" class="btn btn-warning fa fa-pencil-square-o no-padding" style="width:30px; height:24px;" <?php print( ($barang['acc'] != "belum") ? 'disabled':'' ); ?> ></button>
								<button data-target="#modal-danger" data-toggle="modal" data-cstarget="delPick" class="btn btn-danger fa fa-trash-o no-padding" style="width:30px; height:24px;"></button>
							</td>
						</tr>
				<?php
					}
				?>
              </tbody></table>
			</div>
			<div class="box-body" style="padding-top:5px;">
				<div id="ket-index-data">
                <p>Menampilkan <strong>2</strong> dari <strong> <?php echo $countData; ?> </strong> data. </p>
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
	<div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pembaharuan Pembelian</h4>
              </div>
              <div class="modal-body">
                <form id="form-edit-pembelian">
                  
                </form>
                <div class="loader">
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-outline" id="update">Simpan Perubahan</button>
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
                <h4 class="modal-title">Hapus Barang</h4>
              </div>
              <div class="modal-body">
                <form id="form-hapus-pembelian">
                <div class="form-group">
                    <label>ID Barang</label>
                    <input type="text" name="id" class="form-control" id="id_barang" placeholder="Masukan nama barang anda" value="" readonly>
                  </div>
                </form>
                  <div class="form-group">
                    <label>Nama Barang : </label>
                    <span class="label label-warning">Beras cap kapal selam</span>
                  </div>
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
			  Datadefine['tanggal'] = '<?php echo $tanggal; ?>';
			</script>
			<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['index-hal'] = 1;
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>
			<?php } ?>