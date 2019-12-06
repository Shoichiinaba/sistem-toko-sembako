  <!-- UNTUK BELUM ACC -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembelian Barang - Belum ACC
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Belum Acc</a></li>
      </ol>
    </section>
    <section class="content">
		<div class="box-body" style="padding-top:0px; padding-left:0px;">
            <button type="button" id="refresh-barang" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></button>
        </div>
		<div class="box box-danger no-margin hapus-radius-bawah">
            <div class="box-header with-border">
				<i class="fa fa-th-list"></i>
              <h3 class="box-title">Daftar Barang - Belum ACC</h3>
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
								<span class="label  label-danger"><?php echo $barang['acc'];?></span>
							</td>
							<td>
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
			  Datadefine['tipe-konten'] = 'belum';
			  Datadefine['index-hal'] = 1;
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			</script>
			<?php } ?>