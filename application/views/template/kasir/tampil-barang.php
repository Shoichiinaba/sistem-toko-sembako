  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
		<i class="fa fa-th-list"></i>
        Master Barang<small>Menampilkan seluruh data barang</small>
      </h1>
	   <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-th-list"></i>Master Barang</a></li>
      </ol>
    </section>
	<section class="content">
	  <div class="box-body" style="padding-top:0px; padding-left:0px;">
		<a href="<?php echo base_url();?>index.php/c_master_barang/cetak_barang">
		<button class="btn btn-primary btn-sm"><i class="fa fa-print"></i> Cetak</button>
		</a>
	  </div>
	
	  <div class="box box-primary no-margin hapus-radius-bawah">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Barang</h3>
            </div>
            <div class="box-body no-padding" style="margin:12px 6px 0px 0px;" >
			  <div class="pull-right">
				<div class="input-group input-group-sm" style="width: 200px;">
                  <input type="text" name="table_search" class="fil-cari form-control pull-left" placeholder="Cari Barang">
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
              <table class="table table-bordered table-striped tampil-barang">
                <thead><tr>
                  <th>ID Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Harga Jual</th>
                  <th>Harga Beli</th>
                  <th>Stok</th>
				  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($data as $key) {
                      echo '<tr>';
                        echo '<td>'.$key['id_barang'].'</td>';
                        echo '<td>'.$key['nama_barang'].'</td>';
                        echo '<td>'.$key['satuan'].'</td>';
                        echo '<td>'.$key['harga_jual'].'</td>';
						echo '<td>'.$key['harga_beli'].'</td>';
                        echo '<td>'.$key['jumlah_stok'].'</td>';
                        echo '<td> <button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button></td>';
                      echo '</tr>';
                    }
                  ?>
                </tbody>
              </table>
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
            <!-- /.box-body -->
          </div>
	</section>
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
                <table class="table table-bordered tabel-barang-ket">
                <thead>
                  <tr>
                    <th style="width:5%;">#</th>
                    <th>Deskripsi</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                  <td><strong>ID Barang</strong></td>
                  <td><div class="modal-id-barang"></div></td>
                </tr>
                <tr>
                  <td><strong>Nama Barang</strong></td>
                  <td><div class="modal-nama-barang"></div></td>
                </tr>
                <tr>
                  <td><strong>Harga Jual(Rp)</strong></td>
                  <td><div class="modal-harga-jual"></div></td>
                </tr>
				<tr>
                  <td><strong>Harga Beli(Rp)</strong></td>
                  <td><div class="modal-harga-beli"></div></td>
                </tr>
                <tr>
                  <td><strong>Stok</strong></td>
                  <td><div class="modal-jumlah-stok"></div></td>
                </tr>
                <tr>
                  <td><strong>Penempatan</strong></td>
                  <td><div class="modal-penempatan"></div></td>
                </tr>
                <tr>
                  <td><strong>Supplier</strong></td>
                  <td> <div class="modal-supplier"></div></td>
                </tr>
              </tbody></table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
	  <script type="text/javascript">
		  var Datadefine = [];
		  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal; ?>');
		  Datadefine['index-hal'] = 1;
		  Datadefine['url'] = '<?php echo base_url();?>';
		  Datadefine['count-data'] = '<?php echo $countData;?>';
	   </script>