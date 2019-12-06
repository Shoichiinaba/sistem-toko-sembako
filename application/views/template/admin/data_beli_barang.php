  <!-- UNTUK DATA BARANG JUAL -->
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Barang Beli
        <small>Menampilkan seluruh data barang beli</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data barang beli</a></li>
      </ol>
    </section>
    <section class="content">
          <div class="box-body">
            <button type="button" id="refresh-barang" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i></button>
            <button type="button" data-toggle="modal" data-target="#modal-primary" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Tambah Barang</button>
          </div>
		  
		  <div class="box box-success no-margin hapus-radius-bawah">
            <div class="box-header with-border">
              <h3 class="box-title">Tabel Daftar Barang</h3>
            </div>
            <div class="box-body">
			  <div class="pull-left">
				<div class="input-group input-group-sm" style="width: 288px;">
				  <select class="form-control fil-atr" style="width:120px;">
                    <?php echo $pencarian; ?>
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
            <div class="box-body table-responsive">
              <table class="table table-bordered table-striped tampil-barang">
                <thead>
                  <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Supplier</th>
					<th>Opsi</th>
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
                        <td><?php echo $key['nama_kategori']; ?></td>
                        <td><?php echo $key['harga']; ?></td>
                        <td><?php echo $key['nama_supplier']; ?></td>
                        <td> 
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
                  <th style="width: 5%;">#</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><strong>ID Barang</strong></td>
                  <td><div class="modal-idbarang">id barang</div></td>
                </tr>
                <tr>
                  <td><strong>Nama Barang</strong></td>
                  <td><div class="modal-nama-barang">Nama barang</div></td>
                </tr>
                <tr>
                  <td><strong>Kategori</strong></td>
                  <td><div class="modal-kategori">Harga</div></td>
                </tr>
                <tr>
                  <td><strong>Harga</strong></td>
                  <td><div class="modal-harga">stok</div></td>
                </tr>
                <tr>
                  <td><strong>Supplier</strong></td>
                  <td><div class="modal-supplier">nama_kategori</div></td>
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
                <form id="form-input-barang">
                  
                </form>
                <div class="loader"></div>
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
                <h4 class="modal-title">Entri Barang</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <form id="form-input-barang">
                  <div class="form-group">
                    <label>Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" placeholder="Masukan nama barang anda">
                  </div>
                  <div class="form-group">
                    <label>Kategori</label>
                    <select class="form-control" name="id_kategori">
                      <?php echo $form_kategori_barang; ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Harga</label>
					<input type="text" name="harga" class="form-control" placeholder="Masukan harga barang anda">
                  </div>
                  <div class="form-group">
                    <label>Supplier</label>
                    <select class="form-control" name="id_supplier">
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
		<?php if(isset($maxHal) && isset($countData)) { ?>
			<script type="text/javascript">
			  var Datadefine = [];
			  Datadefine['maksimal-hal'] = parseInt('<?php echo $maxHal;?>');
			  Datadefine['index-hal'] = 1;
			  Datadefine['url'] = '<?php echo base_url();?>';
			  Datadefine['count-data'] = '<?php echo $countData; ?>';
			  // untuk penanganan peda pencarian
			  Datadefine['atribut'];
			  Datadefine['cari'];
			</script>
			<?php } ?>
