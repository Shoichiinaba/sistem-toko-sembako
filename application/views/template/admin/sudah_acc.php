  <!-- UNTUK SUDAH ACC -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembelian Barang - Sudah ACC
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Sudah Acc</a></li>
      </ol>
    </section>
    <section class="content">
		
		<div class="box-body" style="padding-top:0px; padding-left:0px;">
            <button type="button" id="refresh-barang" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></button>
        </div>
		
		<div class="panel-tambahkan">
			<div class="box box-warning box-solid" style="display:none;">
            <div class="box-header with-border">
              <h3 class="box-title">Tambahkan Stok</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool hilang"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<form id="form-tambah-stok">
              <div class="box-body no-padding table-responsive">
				<table class="table table-striped">
				<thead>
				<tr>
                  <th style="width: 40px">ID Barang</th>
                  <th style="width:150px;">Nama Barang</th>
                  <th style="width:80px;">Stok</th>
                  <th style="width:90px;">Ditambahkan</th>
				  <th style="width:90px;">Stok Maksimum</th>
                </tr>
				</thead>
				<tbody>
					
				</tbody>
			  </table>
			</div>
			</form>
            </div>
            <!-- /.box-body -->
			<div class="box-footer no-border">
                <button type="submit" class="btn btn-success" id="kirim-tambah-stok">Kirim</button>
				<button type="submit" class="btn btn-danger" id="batal-tambah-stok">Batal</button>
				<div id="loader">
					Sedang Menambahkan... <img src="<?php echo base_url(); ?>dist/img/ajax_clock_small.gif"/>
				</div>
              </div>
          </div>
		</div>
		
		<div class="box box-success no-margin hapus-radius-bawah">
            <div class="box-header with-border">
				<i class="fa fa-th-list"></i>
              <h3 class="box-title">Daftar Barang - Sudah ACC</h3>
            </div>
            <div class="box-body">
			  <div class="pull-left">
				<div class="input-group input-group-sm" style="width: 288px;">
				  <select class="form-control fil-atr" style="width:120px;">
					<option value="nama_barang">nama_barang</option>
					<option value="tanggal">tanggal</option>
				   </select>
                  <input type="text" name="table_search" class="fil-cari form-control pull-left" placeholder="Search" style="width:135px;">
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
            <div class="box-body no-padding table-responsive">
				<table class="table table-striped tampil-barang">
				<thead>
				<tr>
                  <th style="width: 40px">ID Barang</th>
                  <th style="width:210px;">Nama Barang</th>
                  <th style="width:80px;">Kategori</th>
                  <th style="width:90px;">Jumlah</th>
				  <th style="width:90px;">Harga</th>
				  <th style="width:120px;">Tanggal</th>
				  <th style="width:90px;">Acc</th>
                </tr>
				</thead>
				<tbody>
				<?php
					foreach($data as $barang){
						?>
						<tr>
							<td><?php echo $barang['id_barang'];?></td>
							<td><?php echo $barang['nama_barang'];?></td>
							<td><?php echo $barang['kategori'];?></td>
							<td><?php echo $barang['jumlah'];?></td>
							<td><?php echo $barang['harga'];?></td>
							<td><?php echo $barang['tanggal'];?></td>
							<td>
								<span class="label  label-success"><?php echo $barang['acc'];?></span>
							</td>
							<td>
								
								<?php if($barang['status'] == 'sudah'){ ?>
									<button type="button" alt="<?php echo $barang['id']; ?>" class="btn btn-success fa fa-check" style="padding:5px 4px 6px 4px; height:24px; font-size:13px;">&nbsp;Ditambahkan</button>
								<?php } else { ?>
									<button type="button" alt="<?php echo $barang['id']; ?>" class="btn btn-primary fa fa-plus" data-cstarget="addStock" style="padding:5px 4px 6px 4px; height:24px; font-size:13px;">&nbsp;Tambahkan</button>
								<?php } ?>
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
	<div class="modal modal-danger fade" id="modal-danger">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Hapus Barang</h4>
              </div>
              <div class="modal-body">
                <form id="form-hapus-barang">
                <div class="form-group">
                    <label>ID Barang</label>
                    <input type="text" name="id_barang" class="form-control" id="id_barang" placeholder="Masukan nama barang anda" value="" readonly>
                  </div>
				<div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal" class="form-control" id="tanggal" placeholder="Masukan nama barang anda" value="" readonly>
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
			  // Datadefine['tanggal'] = '';
			</script>
			<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['tipe-konten'] = 'sudah';
			  Datadefine['index-hal'] = 1;
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>
			<?php } ?>