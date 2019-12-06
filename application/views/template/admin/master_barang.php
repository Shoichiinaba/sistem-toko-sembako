  <!-- UNTUK DATA MASTER BARANG -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-th-list"></i> Master Barang
        <small>Mengelola data master barang</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-th-list"></i>Master Barang</a></li>
      </ol>
    </section>
	
    <section class="content">
     <div class="box-body">
            <button type="button" id="refresh-barang" class="btn btn-sm btn-default" style="display:none;"><i class="fa fa-refresh"></i></button>
            <button type="button" data-toggle="modal" data-target="#modal-primary" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Item</button>
			<a href="<?php echo base_url();?>index.php/c_master_barang/cetak_barang">
			<button type="button" class="btn btn-sm btn-primary pull-right"><i class="fa fa-print"></i> Cetak</button></a>
      </div>
	  
	  <div class="box box-success no-margin hapus-radius-bawah">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Barang</h3>
            </div>
            <div class="box-body no-padding" style="margin:12px 6px 0px 0px;">
			  <div class="pull-right">
				<div class="input-group input-group-sm" style="width: 200px;">
                  <input type="text" name="table_search" class="fil-cari form-control pull-left" placeholder="Cari barang">
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
                <thead>
                  <tr>
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
                  if($countData){
                    foreach($data as $key){
                      ?>
                      <tr>
                        <td><?php echo $key['id_barang']; ?></td>
                        <td><?php echo $key['nama_barang']; ?></td>
						<td><?php echo $key['satuan'];?></td>
                        <td><?php echo $key['harga_jual']; ?></td>
                        <td><?php echo $key['harga_beli']; ?></td>
                        <td><?php echo $key['jumlah_stok']; ?></td>
                        <td>
						  <button type="button" data-toggle="modal" data-target="#modal-info" data-cstarget="resultGet" class="btn btn-info fa fa-eye"></button>
                          <button type="button" data-toggle="modal" data-target="#modal-warning" data-cstarget="editReck" class="btn btn-warning fa fa-pencil-square-o"></button>
                          <button type="button" data-toggle="modal" data-target="#modal-danger" data-cstarget="delPick" class="btn btn-danger fa fa-trash"></button>
                        </td>
                      </tr>
                      <?php
                    }
                  }
                ?>
              </tbody>
            </table>
            
            </div>
            <!-- /.box-body -->
			<div class="box-body" style="padding-top:0px;">
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
                <thead><tr>
                  <th style="width: 10%;">#</th>
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

      <div class="modal modal-warning fade" id="modal-warning">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pembaharuan Barang</h4>
              </div>
              <div class="modal-body">
                <form id="form-edit-barang">
                  
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

        <div class="modal modal-primary fade" id="modal-primary">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Entri Master Barang</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <form id="form-input-barang">
                  <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Masukan nama barang anda" required/>
                  </div>
				  <div class="form-group">
                    <label>Satuan</label>
                    <select class="form-control" name="satuan">
                      <option value="Pc">Pouch(Pc)</option>
					  <option value="Pcs">Peaces(Pcs)</option>
					  <option value="Sch">Sachet(Sch)</option>
					  <option value="Btl">Botol(Btl)</option>
					  <option value="Krtn">Karton(Krtn)</option>
					  <option value="Gln">Galon(Gln)</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="text" name="harga_jual" class="form-control" placeholder="Berapakah harga jualnya..." required/>
                  </div>
                  <div class="form-group">
                    <label>Harga Beli</label>
                    <input type="text" class="form-control" name="harga_beli" placeholder="Berapakah harga belinya..." required/>
                  </div>
                  <div class="form-group">
                    <label>Jumlah Stok</label>
                    <input type="text" class="form-control" name="jumlah_stok" placeholder="Tentukan jumlah stoknya..." required/>
                  </div>
                  <div class="form-group" id="penempatan">
                    <label>Penempatan barang</label>
                    <select class="form-control" name="id_penempatan" id="form-penempatan">
                      <?php echo $form_penempatan_barang; ?>
                    </select>
                  </div>
				  <div class="form-group">
                    <label>Supplier</label>
                    <select class="form-control" name="supplier">
                      <?php echo $form_supplier_barang; ?>
                    </select>
                  </div>
                </form>
                <div id="loading"></div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" id="tutup" data-dismiss="modal">Tutup</button>
                
                <button type="button" class="btn btn-outline" id="kirim-barang"><i class="fa fa-send"></i> Kirim</button>
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
                <form id="form-hapus-barang">
                <div class="form-group">
                    <label>ID Barang</label>
                    <input type="text" name="id_barang" class="form-control" placeholder="Masukan nama barang anda" value="" readonly>
                  </div>
                </form>
                  <div class="form-group">
                    <label>Nama Barang : </label>
                    <span class="label label-warning"></span>
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
		<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  var Datadefine = [];
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['index-hal'] = 1;
			  Datadefine['url'] = '<?php echo base_url();?>';
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			  Datadefine['atribut'];
			  Datadefine['cari'];
			</script>
			<?php } ?>
